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
<div>
    <div class="container">
        <div class="row my-posts mt-3">
            <div class="col-md-3 offset-1">
                <form action="/blog" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        <h2 class="show-my-posts px-2">Back to blog</h2>
                    </button>
                </form>
            </div>
        </div>
{{--        {{print_r(gettype($posts))}}--}}
        <br>
{{--        {{print_r($posts[0])}}--}}
        @if(count($posts) === 0)
            <h3>You do not have any post yet</h3>
        @else
            @foreach($posts as $post)
                <div class="row d-flex mt-3">
                    <div class="col-md-9 post-item offset-md-1">
                        <a href="posts/{{$post->id}}">
                            <div class="post-title">{{$post->title}}</div>
                        </a>
                        <div>{{$post->content}}</div>
                    </div>
                    <div class="col-md-2 d-flex flex-column">
                        <a href="posts/{{$post->id}}" class="form-edit">
                            <button class="btn btn-outline-primary">Edit</button>
                        </a>
                        <form action="/posts/{{$post->id}}" method="POST" class="form-delete">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-secondary mt-2" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
        <div class="row mt-2">
            <div class="col-md-9 d-flex justify-content-center">
                {{ $posts->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@show
</body>
</html>
