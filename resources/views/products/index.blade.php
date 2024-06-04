{{-- 他のビュー内容を引継ぐための指示
 layouts>app.blase.phpに使用されているHTMLや他コードをここに引き継ぎ
 そこへ追加でコード記載となる --}}
@extends('layouts.app')

{{-- 追加内容を指定する(@section～@endsection)
 layouts.app内の@yield('content')へ挿入--}}
@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>

    

    <div class="search mt-5">
        {{-- 検索フォーム GETで商品一覧ルートにデータ送信  --}}
        <form action="{{ route('products.index') }}" method="GET" class="form-inline row g-3">
            
            {{-- 以下、検索項目入力欄   --}}
            <div class="form-group col-sm-12 col-md-3">
                <input type="text" id="search" class="form-control" placeholder="検索キーワード" value="{{ request('search') }}">
            </div>

            <!-- メーカー名の入力欄 -->
            <div class="col-sm-12 col-md-4">
                <select name="medium" data-toggle="select">
                    <option disabled style='display:none;' @if (empty($post->company_name)) selected @endif>メーカー名</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <input type="number" name="min_price" id="minPrice" placeholder="最低価格">
                <input type="number" name="max_price" id="maxPrice" placeholder="最高価格">
            </div>
            <div>
                <input type="number" name="min_stock" id="minStock" placeholder="最低在庫数">
                <input type="number" name="max_stock" id="maxStock" placeholder="最高在庫数">
            </div>

            <div class="form-group col-sm-12 col-md-3">
                <button class="btn btn-outline-secondary" type="submit">検索</button>
            </div>

        </form>
    </div>
    

    <div class="products mt-5">
    <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">@sortablelink('id', 'ID')</th>
                    <th scope="col">@sortablelink('img_path', '商品画像')</th>
                    <th scope="col">@sortablelink('product_name', '商品名')</th>
                    <th scope="col">@sortablelink('price', '価格')</th>
                    <th scope="col">@sortablelink('stock', '在庫数')</th>
                    <th scope="col">@sortablelink('company_name', 'メーカー名')</th>
                    <th>
                        <a href="{{ route('products.create') }}" class="btn btn-warning mb-3">新規登録</a>
                    </th>
                </tr>
            </thead>
            <tbody id="productList">
                <h2>検索結果</h2>
                @foreach($products as $product)
                  <tr class="table-row" data-id="{{ $product->id }}">
                    <td class="table-data">{{ $product->id }}</td>
                    <td class="table-data"><img width="100px" src="{{ asset('storage/' . $product->img_path) }}"></td>
                    <td class="table-data">{{ $product->product_name }}</td>
                    <td class="table-data">{{ $product->price }}</td>
                    <td class="table-data">{{ $product->stock }}</td>
                    <td class="table-data">
                        @foreach ($companies as $company)
                            @if($product->company_id === $company->id)
                                {{ $company->company_name }}
                            @endif
                        @endforeach
                   <td>

                    <td class="table-data"><a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">詳細</a></td>
                    <td class="table-data">
                         <form method="POST" action="{{ route('products.destroy', $product->id) }}" class="delete-form">
                         @csrf
                         @method('DELETE')
                          <button data-id="{{ $product->id }}" type="submit" data-url="{{ route('products.destroy', $product->id) }}" class="btn btn-warning btn-sm btn-delete">削除</button>
                        </form>
                    </td>
                    <td class="table-data">
                       <a href="{{ route('cart', ['id' => $product->id]) }}" class="btn btn-success btn-sm">購入</a>
                    </td>
                  </tr>
                @endforeach
            </tbody>
        </table>
       
    </div>
</div>
@endsection