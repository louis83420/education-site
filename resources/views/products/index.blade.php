@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品列表</h1>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4">
            <div class="card mb-4">
                <!-- 點擊圖片或名稱時，連結到商品詳情頁 -->
                <a href="{{ route('products.show', $product->id) }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="width: 100%; height: 200px; object-fit: contain;">
                    <h5 class="card-title">{{ $product->name }}</h5>
                </a>

                <div class="card-body">
                    <p class="card-text">價格: ${{ $product->price }}</p>

                    <!-- 顯示庫存狀態 -->
                    @if ($product->stock > 0)
                    <p class="card-text">庫存: {{ $product->stock }} 件</p>
                    @else
                    <p class="card-text text-danger">補貨中</p>
                    @endif

                    <!-- 購物車按鈕 -->
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary" {{ $product->stock == 0 ? 'disabled' : '' }}>添加到購物車</button>
                    </form>

                    <!-- 管理員功能 -->
                    @if (auth()->user() && auth()->user()->isAdmin())
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning mt-2">編輯</a>

                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('確定要刪除這個商品嗎？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-2">刪除</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection