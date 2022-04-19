<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search for '. '"' . $search_text . '"') }}
        </h2>
        <div class="d-flex mt-3">
            <form action="{{ url('/search/users') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $search_text }}" name="search"/>
                <button type="submit" class="btn btn-secondary">
                    Users ({{ count($users) }})
                </button>
            </form>
            <form action="{{ url('/search/posts') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $search_text }}" name="search"/>
                <button type="submit" class="ms-3 btn btn-outline-secondary">
                    Posts ({{ $posts_count }})
                </button>
            </form>
            <form action="{{ url('/search/comments') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $search_text }}" name="search"/>
                <button type="submit" class="ms-3 btn btn-outline-secondary">
                    Comments ({{ $comments_count }})
                </button>
            </form>
        </div>
    </x-slot>
    <div>
        <div class="container">
            @if(!$no_any_user)
                <div class="mx-auto sm:px-6 lg:px-8 mt-3">
                    <p class="text-muted text-center display-5">No one is found</p>
                </div>
            @else
                @foreach($users as $user)
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-2 my-md-2">
                                    <a href="{{ url("/profile/{$user->id}/details") }}">
                                        @if($user->avatar_path !== '')
                                            <img src="{{ asset('images/avatar/'.$user->avatar_path) }}"
                                                 class="img-fluid rounded-start"
                                                 alt="..."
                                            />
                                        @else
                                            <img src="{{ asset('images/icons/no-avatar.svg'.$user->avatar_path) }}"
                                                 class="img-fluid rounded-start"
                                                 alt="..."
                                                 width="120"
                                                 height="120"
                                            />
                                        @endif
                                    </a>
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h5 class="card-title post-item text-center">
                                            <a href="{{ url("/profile/{$user->id}/details") }}">
                                                <div class="post-title">
                                                    <p class="card-text ps-2">
                                                        <small class="text-muted">
                                                            {{ $user->name }}
                                                        </small>
                                                    </p>
                                                </div>
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card-body">
                                        <form action="{{ url("/follow-unfollow/{$user->id}") }}" method="POST">
                                            @csrf
                                            @if (in_array($user->id, $auth_user->following_ids->toArray()) && !in_array($auth_user->id, $user->following_ids->toArray()))
                                                <button type="submit" class="btn btn-primary">
                                                    Follow Back
                                                </button>
                                            @elseif(in_array($auth_user->id, $user->following_ids->toArray()))
                                                <button type="submit" class="btn btn-secondary">
                                                    Unfollow
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-primary">
                                                    Follow
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="row mt-2">
                    <div class="col-md-9 d-flex justify-content-center">
                        {{ $users->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
