@extends('layouts.app')

@section('content')

<div class="container">
    <h2>新しい商品を追加</h2>


 <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="product-name">商品名</label>
        <input type="text" name="name" id="product-name" class="form-control">
        @if ($errors->has('name'))
          <p class="errors">{{ $errors->first('name') }}</p>
        @endif
    </div>

    <div class="form-group">
        <label for="product-company">メーカー</label>
        <select name="company_id">
            @foreach ($companies as $company)
            <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>
        @if ($errors->has('company_id'))
          <p class="errors">{{ $errors->first('company_id') }}</p>
        @endif  
    </div>

    <div class="form-group">
        <label for="product-price">価格</label>
        <input type="number" name="price" id="price" class="form-control">
        @if ($errors->has('price'))
          <p class="errors">{{ $errors->first('price') }}</p>
        @endif
    </div>

    <div class="form-group">
        <label for="product-stock">在庫数</label>
        <input type="number" name="stock" id="stock" class="form-control">
        @if ($errors->has('stock'))
          <p class="errors">{{ $errors->first('stock') }}</p>
        @endif
    </div>

    <div class="form-group">
        <label for="product-comment">コメント</label>
        <textarea name="comment" id="Comment" class="form-contorl"></textarea>
    </div>

    <div class="form-group">
        <label for="product-image_path">画像</label>
        <input type="file" name="image_path" id="image_path" class="form-contorl">
        @if ($errors->has('image_path'))
          <p class="errors">{{ $errors->first('image_path') }}</p>
        @endif
    </div>

    <div>
        <button type="submit" class="btn btn-success">商品登録</button>
    </div>

    <div>
        <a href="{{ route('list') }}">商品一覧に戻る</a>
    </div>
 </form>
</div>
@endsection