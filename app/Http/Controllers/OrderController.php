<?php

namespace App\Http\Controllers;

use App\Domain\Usecases\OrderUsecase;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Exception;
use App\Models\Maker;
use Carbon\Carbon;


class OrderController extends Controller
{
    /**
     * 注文一覧
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(){
       $orders =  Order::with('maker')->orderBy('expected_arraival_date','asc')->get();
       $product_list = array_column((Product::get())->toArray(),'name','id');
       $products = Product::get();  
       $maker_list = array_column((Maker::get())->toArray(),'name','id');
       $dt = New Carbon();
       $next_order_number = 'R'.$dt->year.str_pad(isset($orders->last()->id) ? $orders->pluck('id')->max() +1 : 1, 6, '0', STR_PAD_LEFT);
       
       return view('orders_list',
        compact('orders','product_list','maker_list','products','next_order_number'));
    }

     /**
     * 注文新規登録
     *
     * @param  App\Domain\Requests\OrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request){
        try {
             $order =  (New OrderUsecase())->store($request->all());
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
    public function update(int $id, Request $request)
    {
        try {
            $order =  Order::find($request->id);
            $order->fill($request->all())->save();
            
        } catch (Exception $e) {
           
        }
        return redirect()->back()->with('flash_message', '商品を更新しました');
    }

    /**
     * 注文一括削除
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try {
            if(!$request->order_ids){
                throw new Exception('注文を選択してください');
            }
            Order::destroy($request->order_ids);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return back()->with('flash_message', '注文を削除しました');
    }

    
}
