<?php

namespace App\Domain\Usecases;

use App\Models\Product;
use App\Models\Maker;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductCsvUsecase
{
    const CSV_HEADER = [
        'id',
        '商品名',
        '商品コード',
        'カラー',
        '入り数',
        '下代（USD）',
        '上代(円)',
        'メーカーID',
        'メーカー名',
    ];
    const input_name = [
        'id' => 'id',
        '商品名' => 'name',
        '商品コード' => 'code',
        'カラー' => 'color',
        '入り数' => 'per_case',
        '下代（USD）' => 'purchase_price',
        '上代(円)' => 'selling_price',
        'メーカーID' => 'maker_id',
        'メーカー名' => 'maker_name',
    ];

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

     /**
     * CSVエクスポートデータ取得
     *
     * @return Illuminate\Http\Response;
     */
    public function exportData(Request $request)
    {
        
        if(!isset($request->product_ids)){
            throw ValidationException::withMessages(['商品を選択してください']);
        }
        $products = Product::whereIn('id',$request->product_ids)
        ->select('id','name','code','color','per_case','purchase_price','selling_price','maker_id',)->get();
        //mapで整頓
        $exportData['products'] = $products->map(function($product){
            if(isset($product->maker_id)){
                $maker = Maker::find($product->maker_id);
                $product->maker_name =$maker->name ?? null;
                return $product ;
            }
            return $product ;
         });
        $exportData['headings'] = self::CSV_HEADER;
        return  $exportData;
    }

    /**
     * インポート処理
     */
    public function import($request)
    {
        $products = Product::get();
        $errors =[];
        // ファイルを保存
        if($request->hasFile('csvdata')) {
            if($request->csvdata->getClientOriginalExtension() !== "csv") {
                throw new Exception("拡張子が不正です。");
            }
            $request->csvdata->storeAs('public/', "products.csv");
        } else {
            throw ValidationException::withMessages(['CSVファイルの取得に失敗しました。']);

        }
        // ファイル内容取得
        $csv = Storage::disk('local')->get('public/products.csv');
        // 改行コードを統一
        $csv = str_replace(array("\r\n","\r"), "\n", $csv);
        // 行単位のコレクション作成
        $data = collect(explode("\n", $csv));
      
        
        // header作成と項目数チェック
        $header = collect(self::CSV_HEADER);
        $fileHeader = collect(explode(",", $data->shift()));
        logger('fileHeader');logger($fileHeader);
        if($header->count() !== $fileHeader->count()) {
            throw ValidationException::withMessages(['項目数エラー']);
        }
        
        // $data->pop();
        
        //ヘッダー行とデータ行をキーとバリューにして結合させる。
        $datas = $data->map(function ($oneline) use ($header) {
            logger('header');logger($header);
            logger('oneline');logger($oneline);
            if($oneline){
                return $header->combine(collect(explode(",", $oneline)));
            }
        });
        //データ最終行がNULLだったら削除する。
        if(!$datas->last()){
            $datas->pop();
        }

        // バリデーションチェック
        $datas->each(function($product) {
            if(!$this->validate($product)) {
                return false;
            }
        });


        // CSV内での重複チェック
        if($datas->duplicates("商品コード")->count() > 0) {
            $errors[] = "CSV内での商品コード重複エラー：" . $datas->duplicates("商品コード")->shift();
        }
      

        // $products = Product::get();
        $codes = array_column($products->toArray(),'code');
        //既存コードにインポートコードが存在するか
        foreach($datas as $index => $data){
            $data = $data->toArray();
            $row = $index +1;
            if(in_array($data['商品コード'] ,$codes ,true)){
                $errors[] = "$row 行目：商品コード：$data[商品コード]が重複していますので重複しないよう書き直してください。";
            }
        }
   

        $datas = $datas->map(function($data){
            return $data =[
                'name' => $data['商品名'],
                'code' => $data['商品コード'],
                'maker_id' => $data['メーカーID'],
                'color' => $data['カラー'],
                'per_case' => $data['入り数'],
                'purchase_price' => $data['下代（USD）'],
                'selling_price' => $data['上代(円)'],
            ];
          
         });

        //エラーを出力
        if(count($errors) >0){
            return $errors;
        }

        DB::table('products')->insert($datas->toArray());
        return [];

    }

   /**
     * バリデーションチェック
     */
    private function validate($user)
    {
        // 必須チェック
        // 必要に応じて他の項目にも適用
        if(empty($user['id'])) {
            $user->put('error', '必須項目エラー');
            return false;
        }

        // その他、桁数チェック・値の妥当性チェックなどを必要に応じて

        return true;
    }
}
