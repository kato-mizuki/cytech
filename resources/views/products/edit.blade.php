@extends('layouts.app')

@section('content')

<div class="container">
    <h2>商品情報更新</h2>

  <form action="{{ route('update', $product->id) }}" method="POST" enctype="multipart/form-data">
     @csrf
     @method('PUT')

     <div class="form-group">
        <label for="product-name">商品名</label>
        <input type="text" name="name" id="product-name" class="form-control" value="{{ $product->name }}">
        @if ($errors->has('name'))
          <p class="errors">{{ $errors->first('name') }}</p>
        @endif
     </div>

     <div class="form-group">
        <label for="product-company">メーカー</label>
        <select name="company_id" class="form-control" id="product-company">
         @foreach ($companies as $company)
           @if ($company->id == $product->company_id)
               <option value="{{ $company->id }}" selected>{{ $company->name }}</option>
           @else
               <option value="{{ $company->id }}">{{ $company->name }}</option>
           @endif
         @endforeach
        </select> 
        @if ($errors->has('company_id'))
          <p class="errors">{{ $errors->first('company_id') }}</p>
        @endif
     </div>

     <div class="form-group">
        <label for="product-price">価格</label>
        <input type="number" name="price" id="product-price" class="form-control" value="{{ $product->price }}">
        @if ($errors->has('price'))
          <p class="errors">{{ $errors->first('price') }}</p>
        @endif
     </div>

     <div class="form-group">
        <label for="product-stock">在庫数</label>
        <input type="number" name="stock" id="product-stock" class="form-control" value="{{ $product->stock }}">
        @if ($errors->has('stock'))
          <p class="errors">{{ $errors->first('stock') }}</p>
        @endif
     </div>

     <div class="form-group">
        <label for="product-comment">コメント</label>
        <textarea name="comment" id="product-comment" class="form-control">{{ $product->comment }}</textarea>
     </div>

     <div class="form-group">
        <label for="product-image_path">画像</label>
        <input type="file" name="image_path" id="image_path" class="form-contorl" value="{{ $product->image_path }}">
        @if ($errors->has('image_path'))
          <p class="errors">{{ $errors->first('image_path') }}</p>
        @endif
    </div>

     <button type="submit" class="btn btn-success">更新</button>

    </form>

  <a href="{{ route('list') }}"> 商品一覧に戻る</a>
</div>
@endsection