<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Blog</title>

        @section('styles')
            <link rel="stylesheet" href="{{ asset('css/main/app.css') }}">
            <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
        @show

    </head>
    <body>
    <div class="bg-image">
        <div class="bg-opacity d-flex flex-column justify-content-center">
            <div class="container">
                <div class="row d-flex justify-content-end">
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <a href="route('logout')" class="align-self-end">
                            <button class="btn btn-light">Log Out</button>
                        </a>
                    </form>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <h1 class="title">Post Your Thoughts In This Blog</h1>
                    </div>
                </div>
            </div>
            <form action="{{ url('posts') }}" method="POST" class="form">
                @csrf
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6">
                            <label for="post_title" class="input-label">Title</label>
                            <input type="text" class="blog-input" name="post_title" id="post_title" value="{{ old('post_title') ?? '' }}">
                            <small class="text-danger"> @error('post_title'){{$message}}@enderror</small>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6">
                            <label for="post_content" class="input-label">Content</label>
                            <input type="text" class="blog-input" name="post_content" id="post_content" value="{{ old('post_content') ?? '' }}">
                            <small class="text-danger">@error('post_content'){{$message}}@enderror</small>
                        </div>
                    </div>
                    <div class="row mt-2 mb-4">
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-primary submit-post">Post</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @yield('posts')

    @section('scripts')
        <script src="{{ asset('js/app.js') }}"></script>
    @show
    </body>
</html>
