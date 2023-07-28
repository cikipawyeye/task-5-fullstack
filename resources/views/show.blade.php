@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $article->title }}</h2>
        <p>By <strong>{{ $article->user->name }}</strong> - {{ $article->category->name }}<br> 
            {{ Str::limit($article->updated_at, 10, '') }}</p>
        <div class="content mb-5">
            @if ($article->image != null)
                <img src="/storage/{{ $article->image }}" alt="image banner" class="img-fluid my-3">
            @endif
            <article style="width: 80%;">
                {{ $article->content }}
            </article>
        </div>
    </div>
@endsection