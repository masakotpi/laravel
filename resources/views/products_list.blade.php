
@extends('layout')
@section('title')
商品一覧
@endsection

@section('content')


{{--削除とエクスポート--}}
{{Form::open(['method' => 'post','id' => 'delete'])}}
<button type="submit" id="delete" formmethod="post" class="btn btn-primary btn-sm delete" 
formaction="{{route('product_delete')}}">一括削除</button>

<a href="{{route('products_export')}}">
<button type="submit" formmethod="post" formaction="{{route('products_export')}}" class="btn btn-primary btn-sm">CSVエクスポート</button></a>
{{Form::close()}}

{{--インポート--}}
{{-- {{Form::open(['url'=>route('products_import'),'method'=>'post','enctype'=>'multipart/form-data','class' => 'd-inline'])}} --}}
<button type="button" class="btn-sm btn-primary d-inline" data-bs-toggle="modal" data-bs-target="#exampleModal">
CSVインポート
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">CSVインポート</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div id="result"></div>
      </div>
      <div class="modal-footer">
        {{Form::open(['url' => route('products_import'),'method' => 'post','enctype' => "multipart/form-data"])}}
        {{Form::file('csvdata',['multiple id' => 'csvdata'])}}
        <button class="btn btn-primary btn-sm">送信</button>
        <button type="submit" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">close</button>
      </div>
    </div>
  </div>
</div>

{{Form::close()}}
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
        <th scope="col" width="8%">入り数</th>
        <th scope="col" width="8%">仕入値(USD)</th>
        <th scope="col" width="8%">上代(円)</th>
        <th scope="col" width="8%">更新</th>
      </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
          <tr>
            <td>{{Form::checkbox('product_ids[]',$product->id,'',['form' => 'delete','class' => 'each_ids'])}}</td>
            <td>{{$product->id}}{{Form::hidden('id',$product->id,['form' => 'update'.$product->id,'class' => 'form-control'])}}</td>
            <td>{{Form::text('name',$product->name,['form' => 'update'.$product->id,'class' => 'form-control'])}}</td>
            <td>{{Form::text('code',$product->code,['form' => 'update'.$product->id,'class' => 'form-control'])}}</td>
            
            <td>{{Form::select('maker_id',$maker_list,@$product->maker_id,['form' => 'update'.$product->id,'class' => 'form-control','placeholder' =>'メーカーを選択する'])}}</td>
            <td>{{Form::text('color',$product->color,['form' => 'update'.$product->id,'class' => 'form-control'])}}</td>
            <td>{{Form::text('per_case',$product->per_case,['form' => 'update'.$product->id,'class' => 'form-control'])}}</td>
            <td>{{Form::text('purchase_price',$product->purchase_price,['form' => 'update'.$product->id,'class' => 'form-control'])}}</td>
            <td>{{Form::text('selling_price',$product->selling_price,['form' => 'update'.$product->id,'class' => 'form-control'])}}</td>
            <td>
              {{--更新--}}
              {{Form::open(['method' => 'put','id' => 'update'.$product->id])}}
                <button type="submit" formaction="{{route('product_update',['id' => $product->id])}}"class="btn btn-outline-primary">
                <i class="far fa-edit"></i></button></a>
              {{Form::close()}}
              </td>
          </tr>
        @endforeach
  </tbody>
</table>
 


  
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="{{ asset('js/products.js') }}"></script>