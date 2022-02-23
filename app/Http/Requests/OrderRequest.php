<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_number' => ['required'],
            'product_id' => ['required','integer'],
            'maker_id' => ['required','integer'],
            'product_id' => ['required','integer'],
            'quantity' => ['required','integer'],
            'color' => ['required','string'],
            'per_case' => ['required','integer'],
            'purchase_price' => ['required','numeric','regex:/^0$|^\d{1,5}(.\d{1,2})?$/'],
        ];
    }
    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'order_number' => 'ご注文番号',
            'product_id' => '商品ID',
            'maker_id' => 'メーカーID',
            'product_id' => '商品ID',
            'quantity' => '数量',
            'color' => 'カラー',
            'per_case' => '入り数',
            'purchase_price' => '下代',
            
        ];
    }
}
