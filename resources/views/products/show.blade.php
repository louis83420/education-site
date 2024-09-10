@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <!-- 顯示商品圖片 -->
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 400px; object-fit: contain;">
        </div>

        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->description }}</p>
            <p>價格: ${{ $product->price }}</p>

            <!-- 顯示庫存狀態 -->
            @if ($product->stock > 0)
            <p class="text-success">庫存: {{ $product->stock }} 件</p>
            @else
            <p class="text-danger">補貨中</p>
            @endif

            <!-- 購物車按鈕 -->
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary" {{ $product->stock == 0 ? 'disabled' : '' }}>添加到購物車</button>
            </form>

            <!-- 如果是 admin 用戶，顯示編輯和刪除按鈕 -->
            @if (auth()->user() && auth()->user()->isAdmin())
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning mt-3">編輯商品</a>

            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="mt-2" onsubmit="return confirm('確定要刪除這個商品嗎？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">刪除商品</button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection