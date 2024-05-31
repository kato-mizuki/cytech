@extends('layouts.app')

@section('title', '購入画面')

@section('content')
<div class="cart-container">
<div class="row justify-content-center">
    <div class="col-md-12 col-md-offset-2">
            <div class="wrapper">
                <form method="post" action="{{ route('purchase')}}" enctype="multipart/form-data">  
                    @csrf              
                    <div>
                        <img class="purchase-img" width="180px" src="{{ asset('storage/' . $product->img_path) }}">
                    </div>
                    <div class="purchase-name">
                        {{ $product->id }}. {{ $product->product_name }} (¥{{ $product->price }})
                    </div>

                    <div class="purchase">
                        @if ($product->stock > 0)
                        <input class="form-control" type="number" name="quantity" min="1"> 
                        <button class="purchase-btn btn btn-warning" type="submit">購入する</button>
                        @else
                        <p>※在庫がありません</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- 戻るボタン -->
    <div class="back-page">
            <a class="btn btn-primary" href="{{ route('products.index') }}">戻る</a>
    </div>
@endsection 