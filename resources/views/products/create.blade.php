@extends('layouts.app')

@section('content')
<div class="container">
    <h1>創建產品</h1>
    <!-- 表單開始，設置為 multipart/form-data 以處理文件上傳 -->
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- 保護表單，防止跨站請求偽造 (CSRF) 攻擊 -->

        <!-- 產品名稱字段 -->
        <div class="form-group">
            <label for="name">產品名稱</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <!-- 產品描述字段 -->
        <div class="form-group">
            <label for="description">描述</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <!-- 產品價格字段 -->
        <div class="form-group">
            <label for="price">價格</label>
            <input type="number" name="price" class="form-control" required step="0.01" min="0">
        </div>

        <!-- 產品庫存字段 -->
        <div class="form-group">
            <label for="stock">庫存</label>
            <input type="number" name="stock" class="form-control" required min="0">
        </div>

        <!-- 圖片上傳字段 -->
        <div class="form-group">
            <label for="image">圖片</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
            <!-- `accept` 屬性限制只允許上傳圖片文件 -->
        </div>

        <!-- 提交按鈕 -->
        <button type="submit" class="btn btn-primary">創建產品</button>
    </form>
</div>
@endsection