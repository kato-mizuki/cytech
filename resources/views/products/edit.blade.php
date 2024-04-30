@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
               
                <div class="card">
                    <div class="card-header"><h2>商品情報編集画面</h2></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('products.update',$product, $companies) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="product_name" class="form-label">商品名
                                 <span class="required" style="color:red">*</span>
                                </label>
                                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="company_id" class="form-label">メーカー名
                                 <span class="required" style="color:red">*</span>
                                </label>
                                <select name="company_id" id="company_id" class="form-select">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">金額
                                 <span class="required" style="color:red">*</span>
                                </label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">在庫数
                                 <span class="required" style="color:red">*</span>
                                </label>
                                <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">コメント</label>
                                <textarea name="comment" id="comment" class="form-control" rows="3">{{ $product->comment }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="img_path" class="form-label">商品画像</label>
                                <input type="file" class="form-control" id="img_path" name="img_path">
                                <img src="{{ asset($product->img_path) }}" alt="商品画像" class="product-image">
                            </div>

                            <button type="submit" class="btn btn-warning">更新</button>
                        </form>
                        <a href="{{ route('products.index') }}" class="btn btn-info mt-1 mb-3">戻る</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection