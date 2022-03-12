<?php

namespace App\Domain\Usecases;

use App\Models\Product;
use App\Models\maker;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderUsecase
{
   
    /**
     * 注文一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $orders =  Order::with('maker')->orderBy('expected_arrival_date','asc')->orderBy('order_by','asc')->get();
        $product_list = array_column((Product::get())->toArray(),'name','id');
        $products = Product::get();  
        $maker_list = array_column((Maker::get())->toArray(),'name','id');
        $dt = New Carbon();
        $next_order_number = 'R'.$dt->year.str_pad(isset($orders->last()->id) ? $orders->pluck('id')->max() +1 : 1, 6, '0', STR_PAD_LEFT);

        ##注文を入荷順にグループ分け
        $arrival_list = $orders->groupBy('expected_arrival_date');

        return view('orders_list',
            compact('orders','product_list','maker_list','products','next_order_number','arrival_list'));
     }

     /**
     * メーカー新規登録
     *
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $product = (New Product())->find($request['product_id']);
        $request = array_merge($request,['product_name' => $product->name]);
        (New Order())->fill($request)->save();
        return;
      
        
    }
   
     /**
     * 入荷予定更新
     *
     * @return \Illuminate\Http\Response
     */
    public function updateShippings($request)
    {
        if(!$request->order_by){
            throw new Exception('更新内容がありません。');
        }
        $is_dirty = false;
        foreach($request->order_by as $arrival_date => $order_ids) {
            foreach($order_ids as $index => $order_id){
                $order = Order::find($order_id)
                ->fill([
                    'expected_arrival_date' => $arrival_date == '未定' ? null: date($arrival_date),
                    'order_by' => $index
                ]);

                if($order->isDirty('expected_arrival_date')){
                    $is_dirty = true;
                }
                logger('order');logger($order->toArray());
                $order->save();
            }
        }
        if(!$is_dirty){
            throw new Exception('入荷予定日を変更または注文をスライドさせて予定日を変更してから更新してください。');
        }
       
    }

     /**
     * PDF発注書発行
     *                  
     * @return \Illuminate\Http\Response
     */
    public function issuePo($request)
    {
        if(empty($request['order_ids'])){
            throw new Exception('ご注文を選択してください');
        }
        $orders = Order::with('maker')->find($request['order_ids']);
        $date =  New Carbon();
        $orders->issue_date =  $date->format('Y-m-d');
        return  PDF::loadView('purchase_order',compact('orders'))->setPaper('A4');
     
    }

}
