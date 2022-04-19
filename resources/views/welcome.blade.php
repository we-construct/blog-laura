<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome to this blog') }}
        </h2>
    </x-slot>
    <div class="container">
        @foreach($posts as $post)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <a href="{{ url("/profile/{$post->user->id}/details") }}">
                                @if($post->user->avatar_path !== '')
                                    <img src="{{ 'images/avatar/'.$post->user->avatar_path }}"
                                         class="img-fluid rounded-start"
                                         alt="..."
                                    />
                                @else
                                    <img src="{{ 'images/icons/no-avatar.svg'.$post->user->avatar_path }}"
                                         class="img-fluid rounded-start"
                                         width="120"
                                         height="120"
                                         alt="..."
                                    />
                                @endif
                            </a>
                            <a href="{{ url("/profile/{$post->user->id}/details") }}">
                                <p class="card-text ps-2">
                                    <small class="text-muted">
                                        {{ $post->user->name }}
                                    </small>
                                </p>
                            </a>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title post-item">
                                    <a href="{{ url("/posts/{$post->id}") }}">
                                        <div class="post-title">
                                            {{ $post->title }}
                                        </div>
                                    </a>
                                </h5>
                                <p class="card-text">{{ $post->content }}</p>
                                <a href="{{ url('/login') }}">
                                    <button>
                                        <img src="{{ asset('images/icons/white-like.svg') }}" alt="" />
                                    </button>
                                </a>
                                <p class="card-text text-end">
                                    <small class="text-muted">
                                        Created at {{ date_format($post->created_at,"Y/m/d") }}
                                    </small>
                                </p>
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
</x-app-layout>
