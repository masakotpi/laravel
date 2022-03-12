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
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    /**
     * 注文一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data =  (New OrderUsecase())->index();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return view('orders_list',[
            'orders'            => $data['orders'],
            'product_list'      => $data['product_list'],
            'maker_list'        => $data['maker_list'],
            'products'          => $data['products'],
            'next_order_number' => $data['next_order_number'],
            'arrival_list'      => $data['arrival_list'],
        ]);

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
             DB::rollback();
             return back()->withErrors($e->getMessage());
         }
         DB::commit();
         return back()->with('flash_message', '新規登録しました');
        
    }

    /**
     * 個別注文更新
     *
     * @param  \Illuminate\Http\OrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, OrderRequest $request)
    {
        try {
            $order = Order::find($id);
            $order->fill($request->filter())->save();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return redirect()->back()->with('flash_message', 'ご注文を更新しました');
    }

    /**
     * 入荷予定更新
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateShippings(Request $request)
    {
        try {
            (New OrderUsecase())->updateShippings($request);
            
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return redirect()->back()->with('flash_message', 'ご注文の入荷予定日を更新しました');
    }

    /**
     * PDF発注書発行
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function issuePo(OrderUsecase $usecase, Request $request)
    {
        try {
            $pdf = $usecase->issuePo($request->all());
           
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    	return $pdf->stream();
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
