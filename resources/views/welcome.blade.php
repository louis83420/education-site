@extends('layouts.app')

@section('title', 'Welcome to Joy自學中心')

@section('content')

<div class="container">
    <h1>Welcome to Joy自學中心</h1>
    <div class="d-flex justify-content-center">
        <a href="{{ url('/home') }}" class="btn btn-primary me-2">進入主頁</a>
        <a href="{{ url('/products') }}" class="btn btn-secondary ">查看產品列表</a>
    </div>

    <div class="content mt-5">
        <p>
            在 Joy 自學中心，裡面有我的自學資源，幫助您在旅程中取得進步。
        </p>
    </div>
</div>

@endsection