<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Post</title>

    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/main/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/post.css') }}">
    @show

</head>
<body>
<div class="post-item-main">
    <div class="post-item-opacity d-flex justify-content-center align-items-center">
        <form action="{{ $postItem->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="container">
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <label for="post-item-title" class="post-item-label">Title</label>
                    </div>
                    <div class="col-md-4 offset-md-4">
                        <input type="text" id="post-item-title" value="{{ old('post_title') ?? $postItem->title }}" class="post-item-input" name="post_title">
                        <small class="text-danger">@error('post_title'){{$message}}@enderror</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <label for="post-item-content" class="post-item-label">Content</label>
                    </div>
                    <div class="col-md-4 offset-md-4">
                        <textarea id="post-item-content" class="post-item-input post-item-content" name="post_content">{{ old('post_content') ?? $postItem->content }}</textarea>
                        <small class="text-danger">@error('post_content'){{$message}}@enderror</small>
                    </div>
                </div>
                @if($postItem->user_id === $user_id)
                    <div class="row mt-2">
                        <div class="col-md-4 offset-md-4">
                            <button type="submit" class="btn btn-primary submit-post">Update</button>
                        </div>
                    </div>
                @endif

            </div>
        </form>

    </div>

</div>



@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@show
</body>
</html>
