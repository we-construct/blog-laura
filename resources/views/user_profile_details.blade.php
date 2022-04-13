<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        @if($user->avatar_path !== '')
                            <img src="{{ asset('images/avatar/'.$user->avatar_path) }}" class="img-fluid rounded-start" alt="..." width="300" height="300">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor"
                                 class="bi bi-file-person mt-2" viewBox="0 0 16 16">
                                <path
                                    d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        @endif

                        <br>
                        <h4>{{ $user->name }}</h4>
                        <p>{{ $user->email }}</p>
                        <p><a href="{{ url("/country-posts/".$user->id) }}">{{ $user->country->country?? '' }}</a></p>

                        <p class="mt-4 mb-2 text-muted">Comments</p>
                        @foreach($comments as $comment)
                                <div class="row mt-2">
                                    <div class="col-md-8 comment-container">
                                        <div class="d-flex">
                                            <a href="{{ url('/profile/' . $comment->users->id . '/details') }}">
                                                <div>
                                                    @if($comment->users->avatar_path !== '')
                                                        <img src="{{ asset('images/avatar/' . $comment->users->avatar_path) }}" class="rounded-circle mt-1" alt="..." width="30" height="30">
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-person rounded-circle mt-1" viewBox="0 0 16 16">
                                                            <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                                            <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                            </a>
                                            <a href="{{ url('/profile/' . $comment->users->id . '/details') }}">
                                                <p class="card-text ps-2"><small class="text-muted">{{ $comment->users->name }}</small></p>
                                            </a>
                                        </div>
                                        <div class="comment mt-3">{{ $comment->comment }}</div>
                                        @if($comment->users->id === $auth_userId)
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ url('comments/' . $comment->id . '/edit') }}" class="text-muted edit-a me-3"><span>Edit</span></a>
                                                <form action="{{ url('/comments/' . $comment->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="submit" value="Delete" class="text-muted">
                                                </form>
                                            </div>
                                        @endif

                                        <div class="text-muted d-flex justify-content-end created">
                                            <span>{{$comment->created_at == $comment->updated_at? 'Created at ' . date_format($comment->created_at, "Y/m/d") : 'Updated at ' . date_format($comment->updated_at, "Y/m/d")}}</span>
                                        </div>
                                    </div>

                                </div>
                        @endforeach

                        <div class="row">
                            <div class="col-md-8 px-0">
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="userId" value="{{ $user->id }}">
                                    <textarea name="comment" id="" cols="80" rows="2" class="mt-4"></textarea>
                                    <div>
                                        <small class="text-danger">@error('comment'){{$message}}@enderror</small>
                                    </div>
                                    <div class="mt-1">
                                        <button type="submit" class="btn btn-primary">Add comment</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div>
                            @foreach($posts as $post)
                                <div class="max-w-7xl mx-auto sm:px-1 lg:px-1 mt-3">
                                    <div class="card mb-3">
                                        <div class="row g-0">
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <h5 class="card-title post-item">
                                                        <a href="{{ url('/posts/'.$post->id) }}">
                                                            <div class="post-title">{{ $post->title }}</div>
                                                        </a>
                                                    </h5>
                                                    <p class="card-text">{{ $post->content }}</p>
                                                    <p class="card-text text-end"><small class="text-muted">Created at {{ date_format($post->created_at,"Y/m/d") }}</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                            <div class="row mt-2">
                                <div class="col-md-9 d-flex justify-content-center">
                                    {{ $posts->links('pagination::bootstrap-4') }}
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
