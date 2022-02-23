<?php

namespace App\Domain\Usecases;

use App\Models\Product;
use App\Models\maker;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class OrderUsecase
{
   
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

}
