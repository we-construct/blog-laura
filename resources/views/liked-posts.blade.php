<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liked posts') }}
        </h2>
    </x-slot>
    <div>
        <div class="container">
            @foreach($posts as $post)
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-2">
                                <a href="{{ url("profile/{$post->user->id}/details") }}">
                                    @if($post->user->avatar_path !== '')
                                        <img src="{{ 'images/avatar/'.$post->user->avatar_path }}"
                                             class="img-fluid rounded-start"
                                             alt="..."
                                             width="50"
                                             height="50"
                                        >
                                    @else
                                        <img src="{{ 'images/icons/no-avatar.svg' }}"
                                             class="img-fluid rounded-start"
                                             alt="..."
                                             width="50"
                                             height="50"
                                        >
                                    @endif
                                </a>
                                <a href="{{ url("profile/{$post->user->id}/details") }}">
                                    <p class="card-text ps-2">
                                        <small class="text-muted">
                                            {{ $post->user->name }}
                                        </small>
                                    </p>
                                </a>
                            </div>
                            @if(isset($post->image[0]))
                                <div class="col-md-4">
                                    <img src="{{ asset('images/posts/' . $post->image[0]->image_path) }}" alt="">
                                </div>
                                <div class="col-md-6">
                                    @else
                                        <div class="col-md-8">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title post-item">
                                                    <a href="{{ url("posts/{$post->id}") }}">
                                                        <div class="post-title">
                                                            {{ $post->title }}
                                                        </div>
                                                    </a>
                                                </h5>
                                                <p class="card-text">{{ $post->content }}</p>
                                                @if($post->user_id === $user_id)
                                                    <a href="{{ url("posts/{$post->id}/edit") }}" class="btn btn-primary">
                                                        Edit
                                                    </a>
                                                    <form action="{{ url("/posts/{$post->id}") }}" method="POST" class="form-delete">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-secondary" type="submit">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif
                                                <div>
                                                    <p class="card-text text-end">
                                                        <small class="text-muted">
                                                            Created at {{ date_format($post->created_at,"Y/m/d") }}
                                                        </small>
                                                    </p>
                                                </div>
                                                <form action="{{ url("/like/{$post->id}") }}" method="POST">
                                                    @csrf
                                                    @if(in_array($user_id, $post->users_liked))
                                                        <button type="submit">
                                                            <img src="{{ asset('images/icons/like.svg') }}" alt="" />
                                                        </button>
                                                    @else
                                                        <button type="submit">
                                                            <img src="{{ asset('images/icons/white-like.svg') }}" alt="" />
                                                        </button>
                                                    @endif
                                                    <small>{{ count($post->liked_users) }} likes
                                                        <a href="{{ url("posts/{$post->id}") }}">
                                                            <span class="ms-2">
                                                                {{ count($post->comments) }} comments
                                                            </span>
                                                        </a>
                                                    </small>
                                                </form>
                                            </div>
                                        </div>
                                </div>
                        </div>
                    </div>
            @endforeach
            <div class="row mt-2">
                <div class="col-md-9 d-flex justify-content-center">
                    {{ $posts->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

