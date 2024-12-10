@extends('layouts.app')

@section('title', 'Welcome to Joy自學中心')

@section('content')

<div class="container">
    <h1 class="text-center">有趣的 MBTI 測驗</h1>
    <form method="POST" action="{{ route('mbti.submit') }}">
        @csrf

        {{-- 第一部分 --}}
        <h2 class="text-center">第一部分</h2>
        <p class="text-center">哪一答案最接近地描述了你通常的思考和行為方式。</p>
        @foreach ($part1 as $index => $question)
        <div class="mb-4 text-center">
            <p class="fw-bold">{{ $index + 1 }}. {{ $question->question }}</p>
            <label class="d-block">
                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $question->option_a_value }}" required>
                {{ $question->option_a }}
            </label>
            <label class="d-block">
                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $question->option_b_value }}" required>
                {{ $question->option_b }}
            </label>
        </div>
        @endforeach

        {{-- 第二部分 --}}
        <h2 class="text-center">第二部分</h2>
        <p class="text-center">在以下各對詞中，你更傾向於哪一個。</p>
        <p class="text-center">考慮以下這些詞的意思，而不是它們好不好聽或好不好看。</p>
        @foreach ($part2 as $index => $question)
        <div class="mb-4 text-center">
            <p class="fw-bold">{{ $index + count($part1) + 1 }}. {{ $question->question }}</p>
            <label class="d-block">
                <input type="radio" name="answers[{{ $question->id }}]}" value="{{ $question->option_a_value }}" required>
                {{ $question->option_a }}
            </label>
            <label class="d-block">
                <input type="radio" name="answers[{{ $question->id }}]}" value="{{ $question->option_b_value }}" required>
                {{ $question->option_b }}
            </label>
        </div>
        @endforeach

        {{-- 第三部分 --}}
        <h2 class="text-center">第三部分</h2>
        <p class="text-center">哪個答案最接近地描述了你通常的思考和行為方式。</p>
        @foreach ($part3 as $index => $question)
        <div class="mb-4 text-center">
            <p class="fw-bold">{{ $index + count($part1) + count($part2) + 1 }}. {{ $question->question }}</p>
            <label class="d-block">
                <input type="radio" name="answers[{{ $question->id }}]}" value="{{ $question->option_a_value }}" required>
                {{ $question->option_a }}
            </label>
            <label class="d-block">
                <input type="radio" name="answers[{{ $question->id }}]}" value="{{ $question->option_b_value }}" required>
                {{ $question->option_b }}
            </label>
        </div>
        @endforeach

        <div class="text-center">
            <button type="submit" class="btn btn-primary">提交</button>
        </div>
    </form>
</div>

@endsection