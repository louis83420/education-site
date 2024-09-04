@extends('layouts.app')

@section('content')
<div class="container">
    <h1>編輯產品</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- 使用PUT方法來更新數據 -->

        <!-- 產品名稱字段 -->
        <div class="form-group">
            <label for="name">產品名稱</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <!-- 產品描述字段 -->
        <div class="form-group">
            <label for="description">描述</label>
            <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
        </div>

        <!-- 產品價格字段 -->
        <div class="form-group">
            <label for="price">價格</label>
            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required step="0.01" min="0">
        </div>

        <!-- 產品庫存字段 -->
        <div class="form-group">
            <label for="stock">庫存</label>
            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required min="0">
        </div>

        <!-- 圖片上傳字段 -->
        <div class="form-group">
            <label for="image">圖片</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <p>當前圖片: <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100"></p>
        </div>

        <!-- 提交按鈕 -->
        <button type="submit" class="btn btn-primary">更新產品</button>
    </form>
</div>
@endsection