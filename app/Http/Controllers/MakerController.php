<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Maker;
use Exception;

class MakerController extends Controller
{
    /**
     * メーカー一覧
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $makers =  Maker::get();
       return view('makers_list',compact('makers'));
    }
    /**
     * メーカー新規登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
       try {
            $maker =  New Maker;
            $maker->fill($request->all())->save();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return back()->with('flash_message', '新規登録しました');
       
    }


    /**
     * メーカー更新
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request){
        try {
            $maker = Maker::find($request->id);
            $maker->fill($request->all())->save();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return back()->with('flash_message', '商品を削除しました');
    }

    /**
     * メーカー一括削除
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try {
            if(!$request->maker_ids){
                throw new Exception('メーカーを選択してください');
            }
            Maker::destroy($request->maker_ids);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
        return back()->with('flash_message', 'メーカーを削除しました');
    }

    
}
