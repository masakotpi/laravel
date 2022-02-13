<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Maker;
use Exception;

class ProductController extends Controller
{
    /**
     * 商品一覧
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(){
       $products =  Product::with('maker')->get();
       $makers =  maker::get();
       $maker_list = array_column($makers->toArray(),'name','id');
       logger('maker_list');logger($maker_list);
       return view('products_list',compact('products','maker_list'));
    }


    /**
     * 商品更新
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request){
        try {
            $product =  Product::find($request->id);
            $product->fill($request->all())->save();
            
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
