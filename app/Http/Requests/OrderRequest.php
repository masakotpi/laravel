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
       
        // $this->merge(['id'=> $this->route('id')]);
        return [
            'order_number' => ['required'],
            'product_id' => ['required','integer'],
            'maker_id' => ['required','integer'],
            'product_id' => ['required','integer'],
            'quantity' => ['required','integer'],
            'color' => ['required','string'],
            'per_case' => ['required','integer'],
            'expected_arrival_date' => ['nullable','date'],
            'order_by' => ['required','integer'],
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
    /**
     * フィルタ
     *
     * @return array
     */
    public function filter()
    {
        return [
            'order_number'          => $this->order_number,
            'expected_arrival_date' => date($this->expected_arrival_date),
            'product_name'          => $this->product_name,
            'product_id'            => (int) $this->product_id,
            'maker_id'              => (int) $this->maker_id,
            'order_by'              => (int) $this->order_by,
            'quantity'              => (int) $this->quantity,
            'color'                 => $this->color,
            'per_case'              => (int) $this->per_case,
            'purchase_price'        => $this->purchase_price,
        ];
    }
}
