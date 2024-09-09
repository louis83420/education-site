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
            </tr>
            @endforeach
            @endforeach

        </tbody>
    </table>
    @endif
</div>
@endsection