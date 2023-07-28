@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <ul class="text-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form action="/home/{{ $article->id }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" value="{{ $article->title }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea class="form-control" name="content" aria-label="With textarea">{{ $article->content }}</textarea>
            </div>
            <div class="mb-3">
                <label for="inputGroupSelect01" class="form-label">Category</label>
                <select class="form-select" name="category_id" id="inputGroupSelect01">
                    <option selected>Choose...</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($article->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="inputGroupFile01">Image</label>
                <input type="file" name="image" class="form-control" id="inputGroupFile01">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
