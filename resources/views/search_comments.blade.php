<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search for '. '"' . $search_text . '"') }}
        </h2>
        <div class="d-flex mt-3">
            <form action="{{ url('/search/users') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $search_text }}" name="search">
                <button type="submit" class="btn btn-outline-secondary">Users</button>
            </form>
            <form action="{{ url('/search/posts') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $search_text }}" name="search">
                <button type="submit" class="ms-3 btn btn-outline-secondary">Posts</button>
            </form>
            <form action="{{ url('/search/comments') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $search_text }}" name="search">
                <button type="submit" class="ms-3 btn btn-secondary">Comments</button>
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
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-11 my-md-2">
                                    <div class="comment-container ms-3">
                                        <div class="comment">{{ $comment->comment }}</div>
                                        <form action="{{ url('/comments/' . $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="Delete" class="text-muted">
                                        </form>
                                    </div>
                                </div>
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
