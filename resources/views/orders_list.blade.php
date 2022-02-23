@extends('layout')

@section('title')
発注一覧
@endsection


@section('content')

<!-- 発注モーダルボタン -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newOrderModal">
  新規登録
</button>
{{--削除とエクスポート--}}
{{Form::open(['method' => 'post','id' => 'delete', 'class' => 'd-inline'])}}
<button type="submit" id="delete" formmethod="post" class="btn btn-primary btn delete" 
formaction="{{route('order_delete')}}">一括削除</button>
<table class="table">
    <thead>

      <tr>
        <th scope="col"><input type="checkbox" id="bulk-check-action"></th>

        <th scope="col">入荷予定日</th>
        <th scope="col">注文No.</th>
        <th scope="col">商品名/メーカー</th>
        <th scope="col" width="10%">数量</th>
        <th scope="col" width="10%">カラー</th>
        <th scope="col" width="7%">サイズ</th>
        <th scope="col">入り数</th>
        <th scope="col">下代(US$)</th>
        <th scope="col">更新</th>
        <tr>
      </tr>
    </thead>
    <tbody id="sortable">
      @foreach($orders as $order)
      <tr>
        {{Form::open(['method'=>'POST', 'id' => 'delete'])}}
              <td>{{Form::checkbox('order_ids[]',$order->id,'',['form' => 'delete','class' => 'each_ids'])}}</td>
              <td>{{Form::date('expected_arraival_date',$order->expected_arraival_date,['class'=>'form-control p-1 w-75 text-center','form' => 'update'.$order->id])}}</td>
              <td>{{$order->order_number}}</td>
              <td>{{$order->product_name}}<br><small>{{$maker_list[$order->maker_id]}}</small></td>
              <td>{{$order->quantity}}</td>
              <td>{{$order->color}}</td>
              <td>{{$order->size}}</td>
              <td>{{$order->per_case}}</td>
              <td>{{number_format($order->purchase_price,2)}}</td>
            
        {{Form::close()}}
        {{Form::open(['method'=>'PUT', 'id' => 'update'.$order->id])}}
              <td>
                <button type="submit" formaction="{{route('order_update',['id' => $order->id])}}"class="btn-sm btn-primary">
                更新</a>
              </td>
      </tr>
        {{Form::close()}}
        @endforeach
  </tbody>
</table>


<!-- Modal -->
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
                <th scope="col" width="25%" >商品名<small class="text-white badge bg-danger m-3">必須</small></th>           
                  <td>{{Form::select('product_id',$product_list,null,['class'=>'form-control','placeholder'=>'商品名を選択すると商品情報が入力されます。'])}}</td>
              </tr>
              <tr>
                <th scope="col">メーカー<small class="text-white badge bg-danger m-3">必須</small></th>
                <td>{{Form::text('maker_name', '',['class'=>'form-control maker_name'])}}
                    {{Form::hidden('maker_id', '',['class'=>'form-control'])}}</td>
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
                <th scope="col" width="7%">サイズ<small class="text-white badge bg-danger m-3">必須</small></th>
                <td>{{Form::text('size',null,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col">入り数<small class="text-white badge bg-danger m-2">必須</small></th>
                <td>{{Form::text('per_case',null,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col">下代<small class="text-white badge bg-danger m-2">必須</small></th>
                <td>{{Form::text('purchase_price',null,['class'=>'form-control'])}}</td>
              </tr>
              <tr>
                <th scope="col">入荷予定日<small class="text-white badge bg-danger m-2">必須</small></th>
                <td>{{Form::date('expected_arraival_date',null,['class'=>'form-control'])}}</td>
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