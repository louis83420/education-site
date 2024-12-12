@extends('layouts.app')

@section('content')
<div class="container">
    <h1>我的訂單</h1>

    @if ($orders->isEmpty())
    <p>您目前沒有任何訂單。</p>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>商品名稱</th>
                <th>數量</th>
                <th>單價</th>
                <th>總價</th>
                <th>狀態</th>
                <th>下單時間</th>
                <th>課程連結</th> <!-- 新增課程連結 -->
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product ? $item->product->name : $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->quantity * $item->price }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at }}</td>
                <td>
                    @if($item->product && $item->product->youtube_link)
                    <a href="{{ $item->product->youtube_link }}" target="_blank">觀看課程</a>
                    @else
                    無課程連結
                    @endif
                </td> <!-- 新增課程連結的顯示邏輯 -->
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection