@extends('layouts.app')

@section('content')
<div class="container">
    <h1>購物車</h1>
    @if(Session::has('cart') && count(Session::get('cart')) > 0)
    <table class="table">
        <thead>
            <tr>
                <th>商品名稱</th>
                <th>價格</th>
                <th>數量</th>
                <th>小計</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @php $hasStockIssue = false; @endphp
            @foreach(Session::get('cart') as $id => $item)
            @php
            $product = \App\Models\Product::find($id); // 查找每個商品
            $stockMessage = ''; // 庫存狀態信息
            @endphp
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>${{ $item['price'] }}</td>
                <td>
                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control quantity-input" data-id="{{ $id }}" style="width: 70px;">
                </td>
                <td class="item-total">${{ $item['price'] * $item['quantity'] }}</td>
                <td>
                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">移除</button>
                    </form>
                </td>
            </tr>
            @if($product && $product->stock < $item['quantity'])
                @php
                $hasStockIssue=true;
                $stockMessage='庫存不足' ;
                @endphp
                <tr>
                <td colspan="5">
                    <div class="alert alert-warning">
                        {{ $product->name }}: 庫存不足，僅剩 {{ $product->stock }} 件
                    </div>
                </td>
                </tr>
                @endif
                @endforeach
        </tbody>
    </table>
    <p><strong>總金額: $<span id="totalAmount">{{ $totalAmount }}</span></strong></p>

    <form action="{{ route('cart.clear') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning">清空購物車</button>
    </form>

    <!-- 如果有庫存不足，結帳按鈕將被禁用 -->
    <form action="{{ route('cart.checkout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success mt-3" @if($hasStockIssue) disabled @endif>結帳</button>
    </form>

    @else
    <p>您的購物車是空的。</p>
    @endif
    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">返回商品列表</a>

    <!-- 成功信息 -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- 錯誤信息 -->
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.quantity-input').on('change', function() {
            var id = $(this).data('id');
            var quantity = $(this).val();
            $.ajax({
                url: '{{ route("cart.update") }}',
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: id,
                    quantity: quantity
                },
                success: function(response) {
                    // 更新小計和總金額
                    $('[data-id="' + id + '"]').closest('tr').find('.item-total').text('$' + response.itemTotal);
                    $('#totalAmount').text(response.totalAmount);
                },
                error: function(xhr) {
                    alert('更新數量失敗，請重試。');
                }
            });
        });
    });
</script>
@endsection