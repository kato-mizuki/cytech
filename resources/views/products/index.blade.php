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
                <input type="text" name="search" class="form-control" placeholder="検索キーワード" value="{{ request('search') }}">
            </div>

            <!-- メーカー名の入力欄 -->
            <div class="col-sm-12 col-md-4">
                <select name="medium" data-toggle="select">
                    <input type="select" name="search" class="form-control" placeholder="メーカー名" value="{{ request('search') }}">
                </select>
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
                    <th>ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格
                    </th>
                    <th>在庫数
                    </th>
                    <th>メーカー名</th>
                    <th>
                      <a href="{{ route('products.create') }}" class="btn btn-warning mb-3">新規登録</a>
                    </th>
                </tr>
            </thead>
            <tbody>
            {{-- 繰り返し処理 --}}
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->company_id }}</td>
                    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->company->name }}</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
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