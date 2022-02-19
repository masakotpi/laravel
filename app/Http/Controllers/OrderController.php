<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Exception;

class OrderController extends Controller
{
    /**
     * 注文一覧
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(){
       $orders =  Order::with('maker')->get();
       $products =  Product::get();
       $product_list = array_column($products->toArray(),'name','id');
       logger('maker_list');logger($product_list);
       return view('orders_list',compact('orders','product_list'));
    }

     /**
     * メーカー新規登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        try {
             $order =  New Order;
             $order->fill($request->all())->save();
         } catch (Exception $e) {
             return back()->withErrors($e->getMessage());
         }
         return back()->with('flash_message', '新規登録しました');
        
     }


    /**
     * 商品更新
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request){
        try {
            $Order =  Order::find($request->id);
            $Order->fill($request->all())->save();
            
        } catch (Exception $e) {
           
        }
        return redirect()->back()->with('flash_message', '商品を更新しました');
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
            if(!$request->Order_ids){
                throw new Exception('商品を選択してください');
            }
            Order::destroy($request->Order_ids);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return back()->with('flash_message', '商品を削除しました');
    }

    
}
