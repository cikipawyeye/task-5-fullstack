@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <a class="btn btn-primary my-3" href="/home/create">Create Content</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">User</th>
                    <th scope="col">Category</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $article->id }}</td>
                        <td><a href="/blog/{{ $article->id }}">{{ $article->title }}</a></td>
                        <td>{{ $article->user->name }}</td>
                        <td>{{ $article->category->name }}</td>
                        <td>
                            <a href="/home/{{ $article->id }}/edit">Edit</a> | 
                            <form action="/home/{{ $article->id }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="border-0 bg-white text-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
