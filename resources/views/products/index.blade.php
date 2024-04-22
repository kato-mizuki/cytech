{{-- 他のビュー内容を引継ぐための指示
　layouts>app.blase.phpに使用されているHTMLや他コードをここに引き継ぎ
　そこへ追加でコード記載となる --}}
@extends('layouts.app')

{{-- 追加内容を指定する(@section～@endsection)
　layouts.app内の@yield('content')へ挿入--}}
@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧画面</h1>

    {{-- "{{}}"←PHPコードを記載できる=ProductControllerのcreateメゾットを実行
    CCSフレームワーク(btn=要素をボタンにみせる基本的なスタイル、primary=青色、mb-3=margin-bottom(下)スペース(0~5) --}}
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">新規登録</a>

    <div class="search mt-5">

        <h2>条件絞り込み検索</h2>

        {{-- 検索フォーム／GETで商品一覧ルートにデータ送信  --}}
        <form action="{{ route('products.index') }}" method="GET" class="form-inline row g-3
        ">
            
            {{-- 以下、検索項目入力欄   --}}
            <div class="form-group col-sm-12 col-md-3">
                <input type="text" name="search" class="form-control" placeholder="商品名:" value="{{ request('search') }}">
            </div>

            <div class="form-group col-sm-12 col-md-2">
                <input type="number" name="min-price" class="form-control" placeholder="最小価格:" value="{{ request('min-price') }}">
            </div>

            <div class="form-group col-sm-12 col-md-2">
                <input type="number" name="max-price" class="form-control" placeholder="最大価格:" value="{{ request('max-price') }}">
            </div>

            <div class="form-group col-sm-12 col-md-2">
                <input type="number" name="min-stock" class="form-control" placeholder="最小在庫:" value="{{ request('min-stock') }}">
            </div>

            <div class="form-group col-sm-12 col-md-2">
                <input type="number" name="max-stock" class="form-control" placeholder="最大在庫:" value="{{ request('max-stock') }}">
            </div>
            
            <div class="form-group col-sm-12 col-md-3">
                <button class="btn btn-outline-secondary" type="submit">検索</button>
            </div>

        </form>
    </div>

    {{-- 検索条件リセットボタン  --}}
    <a href="{{ route('products.index') }}" class="btn btn-success mt-3">リセット</a>

    <div class="products mt-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'asc']) }}">↑</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'desc']) }}">↓</a>
                    </th>
                    <th>在庫数
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => 'asc']) }}">↑</a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => 'desc']) }}">↓</a>
                    </th>
                    <th>メーカー名</th>
                </tr>
            </thead>
            <tbody>
            {{-- 繰り返し処理 --}}
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    
                    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    {{-- リレーション関係有の場合↓↓ --}}
                    <td>{{ $product->company->company_name }}</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細表示</a>
                        <form method="POST" action="{{ route('products.destroy', $product)}}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mb-4">
        {{-- appends()=ページを移動しても条件を忘れないようにする
            ViewかControllerどちらかに記載しておけば機能する--}}
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection