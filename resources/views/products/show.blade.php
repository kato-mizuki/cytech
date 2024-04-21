@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
   <div class="row w-75">
      <div class="col-5 offset-1">
         <img src="{{ asset('storage'. mb_substr($product->image_path,6)) }}" class="img-fluid">
      </div>

      <div class="col">
        <div class="d-flex flex-column">
            <h1 class="">{{$product->name}}</h1>
        </div>

        <div class="col">
            <strong>商品ID:</strong>
            {{$product->id}}
        </div>
         
        <div class="col">
            <strong>メーカー:</strong>
            {{$product->company->name}}
        </div>

        <div class="col">
          <strong>価格:</strong>
           {{$product->price}}
        </div>

        <div class="col">
          <strong>在庫数</strong>
           {{$product->stock}}
        </div>

        <div class="col">
          <strong>コメント</strong>
          {{$product->comment}}
        </div>

        <div class="col">
          <a href="{{ route('list') }}" class="btn btn-primary">商品一覧に戻る</a>
          <a href="{{ route('edit', $product->id) }}" class="btn btn-success">編集</a>
        </div>
     
    </div>
</div>
@endsection