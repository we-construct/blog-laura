@extends('blog')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
@endsection

@section('posts')
    <div>
        <div class="container">
            <div class="row my-posts mt-3">
                <div class="col-md-3 offset-1">
                    <form action="/my-posts/{{$user_id}}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-secondary">
                            <h2 class="show-my-posts px-2">Show all my posts</h2>
                        </button>
                    </form>
                </div>
            </div>
            @foreach($posts as $post)
                <div class="row d-flex mt-3">
                    <div class="col-md-9 post-item offset-md-1">
                        <a href="posts/{{$post->id}}">
                            <div class="post-title">{{$post->title}}</div>
                        </a>
                        <div>{{$post->content}}</div>
                    </div>
                    @if($post->user_id === $user_id)
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
                    @endif
                </div>
            @endforeach
            <div class="row mt-2">
                <div class="col-md-9 d-flex justify-content-center">
                    {{ $posts->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
