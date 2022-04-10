<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Maker;
use App\Domain\Usecases\ProductCsvUsecase;
use Exception;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * 商品一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $products =  Product::with('maker')->get();
        $makers =  maker::get();
        $maker_list = array_column($makers->toArray(),'name','id');
        return view('products_list',compact('products','maker_list'));
    }


    /**
     * 商品更新
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request){
        DB::beginTransaction();
        try {
            $product =  Product::find($request->id);
            $product->fill($request->all())->save();
            DB::commit();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
            DB::rollback();
        }
        return redirect()->back()->with('flash_message', '商品を更新しました');
    }

    /**
     * 商品CSVエクスポート
     *
     * @return Illuminate\Http\Response;
     */
    public function export(Request $request,ProductCsvUsecase $usecase)
    {
        try {
            $exportData = $usecase->exportData($request);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
        return $exportData['products']->exportCsv('products_export.csv',$exportData['headings']);
    }

    /**
     * 商品CSVインポート
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function import(ProductCsvUsecase $usecase , Request $request){
        
        try {
            $errors =  $usecase->import($request);
            
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
        if(count($errors) >0){
            return back()->withErrors($errors);
        }
        return back()->with('flash_message', 'csvをインポートしました');
        
    }



    /**
     * 商品一括削除
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try {
            if(!$request->product_ids){
                throw new Exception('商品を選択してください');
            }
            Product::destroy($request->product_ids);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return back()->with('flash_message', '商品を削除しました');
    }

    
}
