@extends('layout')

@section('title')
発注一覧
@endsection


@section('content')


<table class="table">
    <thead>

      <tr>
        <th scope="col"></th>
        <th scope="col">注文No.</th>
        <th scope="col">商品名</th>
        <th scope="col">メーカー</th>
        <th scope="col" width="10%">カラー</th>
        <th scope="col" width="7%">サイズ</th>
        <th scope="col">入り数</th>
        <th scope="col">下代</th>
        <th scope="col">新規</th>
        <tr>
      </tr>
    </thead>
    <tbody>
        {{Form::open(['method'=>'POST'])}}
        <td></td>
            <td>{{Form::text('order_number',null,['class'=>'form-control'])}}</td>
            <td>{{Form::select('product_name',$product_list,null,['class'=>'form-control'])}}</td>
            <td>{{Form::text('maker',null,['class'=>'form-control'])}}</td>
            <td>{{Form::text('color',null,['class'=>'form-control'])}}</td>
            <td>{{Form::text('size',null,['class'=>'form-control'])}}</td>
            <td>{{Form::text('per_case',null,['class'=>'form-control'])}}</td>
            <td>{{Form::text('purchase_price',null,['class'=>'form-control'])}}</td>
            <td>
              <button type="submit" formmethod="post" class="btn btn-primary btn-sm" 
              formaction="{{route('order_new')}}">新規</button>
            </td>
        </tr>
        {{Form::close()}}
  </tbody>
</table>



{{-- <table class="table" id="datatablesSimple"> --}}
<table class="table">
    <thead>

      <tr>
        <th scope="col"><input type="checkbox" id="bulk-check-action"></th>

        <th scope="col">ID</th>
        <th scope="col">商品名</th>
        <th scope="col" width="10%">コード</th>
        <th scope="col">メーカー</th>
        <th scope="col" width="10%">カラー</th>
        <th scope="col" width="7%">サイズ</th>
        <th scope="col">入り数</th>
        <th scope="col">下代</th>
        <th scope="col">上代</th>
        <th scope="col">更新</th>
        <tr>
      </tr>
    </thead>
    <tbody>
      
      {{Form::open(['method'=>'POST', 'id' => 'delete'])}}
        @foreach($orders as $order)
            <td>{{Form::checkbox('order_ids[]',$order->id,'',['form' => 'delete','class' => 'each_ids'])}}</td>
            <td>{{$order->id}}</td>
      {{Form::close()}}
         
            <td>
              <button type="submit" method="PUT" formaction="{{route('order_update',['id' => $order->id])}}"class="btn-sm btn-primary">
               更新</a>
            </td>
        </tr>
        {{Form::close()}}
        @endforeach
  </tbody>
</table>


  
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="{{ asset('js/products.js') }}"></script>