<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search for '. '"' . $search_text . '"') }}
        </h2>
        <div class="d-flex mt-3">
            <form action="{{ url('/search/users') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $search_text }}" name="search"/>
                <button type="submit" class="btn btn-outline-secondary">
                    Users ({{ $users_count }})
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
                <button type="submit" class="ms-3 btn btn-secondary">
                    Comments ({{ count($comments) }})
                </button>
            </form>
        </div>
    </x-slot>
    <div>
        <div class="container">
            @if(!$no_any_comment)
                <div class="mx-auto sm:px-6 lg:px-8 mt-3">
                    <p class="text-muted text-center display-5">No comment is found</p>
                </div>
            @else
                @foreach($comments as $comment)
                    <div class="row mt-2">
                        <div class="col-md-8 comment-container">
                            <div class="d-flex">
                                <a href="{{ url("/profile/{$comment->users->id}/details") }}">
                                    <div>
                                        @if($comment->users->avatar_path !== '')
                                            <img src="{{ asset('images/avatar/' . $comment->users->avatar_path) }}"
                                                 class="rounded-circle mt-1"
                                                 alt="..."
                                                 width="30"
                                                 height="30"
                                            />
                                        @else
                                            <img src="{{ asset('images/icons/no-avatar.svg') }}"
                                                 class="rounded-circle mt-1"
                                                 alt="..."
                                                 width="30"
                                                 height="30"
                                            />
                                        @endif
                                    </div>
                                </a>
                                <a href="{{ url("/profile/{$comment->users->id}/details") }}">
                                    <p class="card-text ps-2">
                                        <small class="text-muted">
                                            {{ $comment->users->name }}
                                        </small>
                                    </p>
                                </a>
                            </div>
                            <div class="comment mt-3">{{ $comment->comment }}</div>

                            <div class="text-muted d-flex justify-content-end created">
                                <span>
                                    {{$comment->created_at == $comment->updated_at? 'Created at ' . date_format($comment->created_at, "Y/m/d") : 'Updated at ' . date_format($comment->updated_at, "Y/m/d")}}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="row mt-2">
                    <div class="col-md-9 d-flex justify-content-center">
                        {{ $comments->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
