<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Usecases\ProductCsvUsecase;
use Exception;
use Illuminate\Validation\ValidationException;

class ProductCsvController extends Controller
{
 
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
            logger('request');logger($e->errors());
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
            $usecase->import($request);
            
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
        $errors = $usecase->import($request);
        if(count($errors) >0){
            return back()->withErrors($errors);
        }
        return back()->with('flash_message', 'csvをインポートしました');
        
    }
}
