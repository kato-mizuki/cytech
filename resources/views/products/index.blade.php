@extends('layouts.app')

@section('content')
<div class="container">

  <!-- 検索フォーム -->
   <!-- 検索テキスト部分 -->
  <div class="row">
    <div class="col-sm">
      <!-- <form id="search-form"> -->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">商品名</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" name="keyword" id="name">
            </div>
            <div class="col-sm-auto">
                <button class="btn btn-primary" id="search-btn">検索</button>
            </div>
        </div>
        <!-- 検索セレクトボックス -->
        <div class="form-group row">
            <label class="col-sm-2">メーカー名</label>
            <div class="col-sm-3">
                <select name="companyId" class="form-control" id="company">
                    <option value="">未選択</option>
                    @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
          <input type="number" name="min_price" id="minPrice" placeholder="最低価格">
          <input type="number" name="max_price" id="maxPrice" placeholder="最高価格">
        </div>
        <div>
          <input type="number" name="min_stock" id="minStock" placeholder="最低在庫数">
          <input type="number" name="max_stock" id="maxStock" placeholder="最高在庫数">
        </div>
      <!-- </form> -->
    </div>
</div>
  
  <!-- 新規登録ボタン -->
  <a href="{{ route('create') }}"><button style="margin:20px;" class="btn btn-primary">新規登録</button></a>

  <!-- 商品テーブル一覧 -->
  <table class="table">
    <thead>
    <tr class="table-info">
        <th>@sortablelink('id', 'ID')</th>
        <th>商品画像</th>
        <th>@sortablelink('name', '商品名')</th>
        <th>@sortablelink('price', '価格')</th>
        <th>@sortablelink('stock', '在庫数')</th>
        <th>メーカー</th>
        <th>詳細表示</th>
        <th>編集</th>
        <th>削除</th>
    </tr>
    </thead>
    <tbody id="search-result">
    @foreach ($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <!--<td>{{ $product->image_path }}</td> -->
        <td><img src="{{ asset('storage'. mb_substr($product->image_path,6)) }}" class="imgsize"></td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->stock }}</td>
        <td>{{ $product->company->name }}</td>
        <td><a href="{{ route('show', $product->id) }}"><button class="btn btn-success">詳細</button></a></td>
        <td><a href="{{ route('edit', $product->id) }}"><button class="btn btn-primary">編集</button></a></td>
        <td>
           <!-- <form action="{{ route('destroy', $product->id) }}" method="POST"> -->
            <!-- <form> -->
            @csrf
            @method('DELETE')
            <button data-product_id="{{ $product->id }}" type="submit" class="btn btn-secondary">削除</button>
           <!-- </form> -->
        </td>
    </tr>
    @endforeach
    </tbody>
  </table>
</div>
@endsection