<<<<<<< HEAD
=======

>>>>>>> 6e3ba7ddd4379b516ea7d9857818c14d1dd3b0b5
@extends('layout')

@section('title')
メーカ一覧
@endsection


@section('content')


<table class="table">
    <thead>

      <tr>
        <th scope="col"></th>
        <th scope="col">新規</th>
        <th scope="col">メーカー名</th>
        <th scope="col">メーカー所在国</th>
        <th scope="col">担当者</th>
        <th scope="col">住所</th>
        <tr>
      </tr>
    </thead>
    <tbody>
        {{Form::open(['method'=>'POST'])}}
        <td></td>
            <td>新規</td>
            <td>{{Form::text('name',null,['class'=>'form-control'])}}</td>
            <td>{{Form::text('country',null,['class'=>'form-control'])}}</td>
            <td>{{Form::text('person_in_charge',null,['class'=>'form-control'])}}</td>
            <td>{{Form::text('address',null,['class'=>'form-control'])}}</td>
            <td>
              <button type="submit" formmethod="post" class="btn btn-primary btn-sm" 
              formaction="{{route('maker_new')}}">新規</button>
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
        <th scope="col">メーカー名</th>
        <th scope="col">メーカー所在国</th>
        <th scope="col">担当者</th>
        <th scope="col">住所</th>
        <tr>
      </tr>
    </thead>
    <tbody>
      
      {{Form::open(['method'=>'POST', 'id' => 'delete'])}}
        @foreach($makers as $maker)
            <td>{{Form::checkbox('maker_ids[]',$maker->id,'',['form' => 'delete','class' => 'each_ids'])}}</td>
            <td>{{$maker->id}}</td>
      {{Form::close()}}
            {{Form::open(['method'=>'PUT'])}}
            {{Form::hidden('id',$maker->id)}}
            <td>{{Form::text('name',$maker->name,['class'=>'form-control'])}}</td>
            <td>{{Form::text('country',$maker->country,['class'=>'form-control'])}}</td>
            <td>{{Form::text('person_in_charge',$maker->person_in_charge,['class'=>'form-control'])}}</td>
            <td>{{Form::text('address',$maker->address,['class'=>'form-control'])}}</td>
     
            <td>
              <button type="submit" method="PUT" formaction="{{route('maker_update',['id' => $maker->id])}}"class="btn-sm btn-primary">
               更新</a>
            </td>
        </tr>
        {{Form::close()}}
        @endforeach
  </tbody>
</table>

<button type="submit" formmethod="post"  form="delete" class="btn btn-primary btn-sm delete" 
formaction="{{route('maker_delete')}}">一括削除</button>
  
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="{{ asset('js/products.js') }}"></script>