@extends('layouts.app')
@section('content')
    <div class="container">
        @if ($article->image_type == 0)
            <img src="{{ $article->media }}" alt="Article Image" width="500" height="500" class="center-block">
        @elseif($article->image_type == 1)
            <video src="{{ $article->media }}"></video>
        @endif
        <h1 class="text-center">{{ $article->title }}</h1>
        <h6 class="text-center">{{ $article->tags }}</h6>
        <p>{{ $article->description }}</p>
    </div>
@endsection
