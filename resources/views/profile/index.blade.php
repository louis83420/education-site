@extends('layouts.app')

@section('title', '會員資料')

@section('content')
<div class="container">
    <h1 class="text-center">會員資料</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <div class="form-group">
            <label for="name">姓名</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">電子郵件</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="mbti">MBTI 測試結果</label>
            @if ($user->mbti)

            <p class="form-control-plaintext">您的 MBTI 為：<strong>{{ $user->mbti }}</strong></p>
            @else
            <p class="form-control-plaintext">尚未測試</p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">更新資料</button>
    </form>
</div>
@endsection