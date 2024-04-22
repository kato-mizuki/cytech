@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品新規登録</h1>

    <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">戻る</a>

    {{-- enctype="multipart/form-data=画像ファイルをアップロードする場合、必ず必要 --}}
    <form method="POST" action=" {{ route('products.store') }}" enctype="multipart/form-data">
        
        @csrf

        {{-- required=必須項目 --}}
        <div class="mb-3">
            <label for="product_name" class="form-label">商品名:</label>
            <input type="text" name="product_name" id="product_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="company_id" class="form-label">メーカー:</label>
            <select class="form-select" id="company_id" name="company_id">
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">価格:</label>
            <input type="text" name="price" id="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">在庫数:</label>
            <input type="text" name="stock" id="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">コメント:</label>
            <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="img_path" class="form-lavel">商品画像:</label>
            <input type="file" name="img_path" id="img_path" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">登録</button>
    </form>
    
</div>
    
@endsection