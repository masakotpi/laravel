@extends('layout')

@section('title')
発注・入荷予定
@endsection


@section('content')



<!-- 入荷予定更新 -->
{{Form::open(['method' => 'post','id' => 'update_shipping', 'class' => 'text-right'])}}
  <button type="submit" id="update_shipping" formmethod="post" class="btn-sm btn-primary" 
  formaction="{{route('order_update_shippings')}}" title="入荷予定を動かして更新をしてください">入荷予定日更新</button>
{{form::close()}}




<table class="table">
    <thead>
      <tr>
        <th scope="col"><input type="checkbox" id="bulk-check-action"></th>
        <th scope="col">注文No.</th>
        <th scope="col">商品名/メーカー</th>
        <th scope="col" width="10%">数量</th>
        <th scope="col" width="10%">カラー</th>
        <th scope="col">入り数</th>
        <th scope="col">下代(US$)</th>
        <th scope="col">更新</th>
        <tr>
      </tr>
    </thead>
    <tbody class="sortable">
      @foreach($arrival_list as $arrival_date => $value)
      <!-- 入荷予定日 -->
      <tr class="arrival_date unsortable" data-date="{{$arrival_date}}">
        <td colspan="8" class="bg-primary text-white py-1">
          {{Form::date('arrival_date',$arrival_date,['class' => 'form-control w-25 p-0 bg-primary text-white text-center'])}}</td>
      </tr>
      {{Form::open()}}

      @foreach($value as $index => $order)
      <!-- 入荷詳細 -->
        <tr class="child" data-date="{{$arrival_date}}"  data-id="{{@$order['id']}}" title="注文を動かして「入荷予定日更新」をクリックすると予定日を変更できます。">
                <td>{{Form::checkbox('order_ids[]',$order['id'],null,['class' => 'each_ids'])}}
                    {{Form::hidden("order_by[$arrival_date][]",@$order['id'],['form' => 'update_shipping', 'class' => 'order_by'])}}</td>
                <td>{{$order['order_number']}}</td>
                <td>{{$order['product_name']}}<br><small>{{$maker_list[@$order['maker_id']]}}</small></td>
                <td>{{$order['quantity']}}</td>
                <td>{{$order['color']}}</td>
                <td>{{$order['per_case']}}</td>
                <td>US${{number_format($order['purchase_price'],2)}}</td>
                <td>
                  <button type="button" class="btn-sm btn-warning text-white update" data-bs-toggle="modal" data-bs-target="#updateOrderModal"
                  data-data="{{json_encode($order)}}">
                    更新
                  </button>
                </td>
        </tr>
      @endforeach
      <tr class="arrival_date" data-date="{{$arrival_date}}">
        <td colspan="8" class=" text-white py-1"></td>
      </tr>
      @endforeach
  </tbody>
</table>



<!-- 発注書発行 -->
  <button type="submit" id="issue_po" formmethod="post" class="btn-sm btn-primary " 
  formaction="{{route('issue_po')}}">発注書発行</button>

<!-- 発注モーダルボタン -->
  <button type="button" class="btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newOrderModal">
    発注
  </button>
  
<!-- 削除 -->
    <button type="submit" id="delete" formmethod="post" class="btn-sm btn-secondary" 
    formaction="{{route('order_delete')}}">一括削除</button>
  {{form::close()}}



<!-- 発注新規モーダル -->
<div class="modal fade" id="newOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">新規登録</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            {{Form::open(['method'=>'POST'])}}
              <tr>
                <th scope="col" width="10%">注文No.<small class="text-white badge bg-danger m-3">必須</small></th>
                <td>{{Form::text('order_number',$next_order_number,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col">入荷予定日<small class="text-white badge bg-danger m-2">必須</small></th>
                <td>{{Form::date('expected_arrival_date',null,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col" width="25%" >商品名<small class="text-white badge bg-danger m-3">必須</small></th>           
                  <td>{{Form::select('product_id',$product_list,null,['class'=>'form-control','placeholder'=>'商品名を選択すると商品情報が入力されます。'])}}</td>
              </tr>
              <tr>
                <th scope="col">メーカー<small class="text-white badge bg-danger m-3">必須</small></th>
                <td>{{Form::text('maker_name', '',['class'=>'form-control maker_name'])}}
                    {{Form::hidden('maker_id', '',['class'=>'form-control'])}}
                    {{Form::hidden('order_by', 1,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col">数量<small class="text-white badge bg-danger m-3">必須</small></th>
                <td>{{Form::number('quantity',1,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col" width="10%">カラー<small class="text-white badge bg-danger m-3">必須</small></th>
                <td>{{Form::text('color',null,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col">入り数<small class="text-white badge bg-danger m-2">必須</small></th>
                <td>{{Form::text('per_case',null,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col">下代<small class="text-white badge bg-danger m-2">必須</small></th>
                <td>{{Form::text('purchase_price',null,['class'=>'form-control'])}}</td>
              </tr>
          </thead>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" formmethod="post" class="btn btn-primary btn" formaction="{{route('order_new')}}">発注</button>
      </div>
    </div>
  </div>
</div>
{{Form::close()}}


<!-- 更新モーダル -->
<div class="modal fade" id="updateOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">更新</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            {{Form::open(['method'=>'PUT'])}}
              <tr>
                <th scope="col" width="10%">注文No.<small class="text-white badge bg-danger m-3">必須</small></th>
                <td>{{Form::text('order_number',$next_order_number,['class'=>'form-control'])}}</td>
                {{Form::hidden('product_id','')}}
              </tr>
              <tr>
                <th scope="col">入荷予定日<small class="text-white badge bg-danger m-2">必須</small></th>
                <td>{{Form::date('expected_arrival_date',null,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col" width="25%" >商品名<small class="text-white badge bg-danger m-3">必須</small></th>
                <td>{{Form::text('product_name','',['class'=>'form-control'])}}</td>           
              </tr>
              <tr>
                <th scope="col">メーカー<small class="text-white badge bg-danger m-3">必須</small></th>
                <td>{{Form::text('maker_name', '',['class'=>'form-control maker_name'])}}
                    {{Form::hidden('maker_id', '',['class'=>'form-control'])}}
                    {{Form::hidden('order_by', 1,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col">数量<small class="text-white badge bg-danger m-3">必須</small></th>
                <td>{{Form::number('quantity',1,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col" width="10%">カラー<small class="text-white badge bg-danger m-3">必須</small></th>
                <td>{{Form::text('color',null,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col">入り数<small class="text-white badge bg-danger m-2">必須</small></th>
                <td>{{Form::text('per_case',null,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col">下代<small class="text-white badge bg-danger m-2">必須</small></th>
                <td>{{Form::text('purchase_price',null,['class'=>'form-control'])}}</td>
              </tr>
          </thead>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" formaction=""class="btn btn-primary order_update">
                  更新</a>
      </div>
    </div>
  </div>
</div>
{{Form::close()}}


<br><br><br><br>
<small class="text-muted">
  ・発注書発行ボタンを押すとPDFで発注書が発行されます。<br>
  ・注文内容を動かして、入荷予定日更新を押すと入荷予定日が変更できます。
                          
                           
                           


</small>


<script>
products = {};
products = @json($products);

maker_list = {};
maker_list = @json($maker_list);


</script>  
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="{{ asset('js/order.js') }}"></script>