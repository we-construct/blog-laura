@extends('blog')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
@endsection

@section('posts')
    <div>
        <div class="container">
            @foreach($posts as $post)
                    <div class="row d-flex justify-content-center mt-3">
                        <div class="col-md-9 post-item">
                            <div>{{$post->content}}</div>
                        </div>
                        <div class="col-md-2 d-flex flex-column">
                            <button class="btn btn-outline-primary">Edit</button>
                            <form action="/posts/{{$post->id}}" method="POST" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-secondary mt-2" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
@endsection
