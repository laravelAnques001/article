@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="justify-content-center">
            @if ($article->image_type == 0)
                <img src="{{ $article->media }}" alt="Article Image" class="wizard border-radius">
            @elseif($article->image_type == 1)
                <video src="{{ $article->media }}"></video>
            @endif
        </div>
        <h1>{{ ucfirst($article->title) }}</h1>
        <p>{{ $article->tags }} <img src="{{ asset('assets/images/trending.png') }}" width="20">
            <span class="m-20">{{ $article->day_ago }}</span>
        </p>
        <h5>Category : {{ implode(', ', $article->category->pluck('name')->toArray()) }}</h5>
        <p>{{ $article->description }}</p>
        <p>- {{ $article->user->name }}</p>
        <p><span class="m-20">Like : {{ $article->like_count }}</span> <span class="m-20"> Share :
                {{ $article->share_count }}</span></p>
    </div>
@endsection
