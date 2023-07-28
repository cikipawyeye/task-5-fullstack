@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Article</h3>
        <div class="row justify-content-center">
            @foreach ($articles as $article)
                <div class="col-md-4">
                    <div class="card my-2">
                        @if ($article->image != null)
                            <img src="/storage/{{ $article->image }}" class="card-img-top" alt="..."
                                style="object-fit: cover;" width="100%" height="200">
                        @else
                            <img src="https://images.unsplash.com/photo-1519682577862-22b62b24e493?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                                class="card-img-top" alt="..." style="object-fit: cover;" width="100%"
                                height="200">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text"
                                style="overflow: hidden; display: -webkit-box; text-overflow: ellipsis; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical;">
                                {{ $article->content }}</p>
                            <a href="/blog/{{ $article->id }}" class="btn btn-primary">Read</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
