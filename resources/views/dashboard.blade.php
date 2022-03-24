<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-5 pb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="/my-posts/{{$userId}}" method="GET">
                        @csrf
                        <button type="submit">
                            <h2 class="show-my-posts px-2">Show all my posts</h2>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="/posts/create" method="GET">
                        @csrf
                        <button type="submit">
                            <h2 class="show-my-posts px-2">Add new post</h2>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            @foreach($posts as $post)
                <div class="row d-flex mt-3">
                    <div class="col-md-9 post-item offset-md-1">
                        <a href="posts/{{$post->id}}">
                            <div class="post-title">{{$post->title}}</div>
                        </a>
                        <div>{{$post->content}}</div>
                    </div>
                    @if($post->user_id === $userId)
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
</x-app-layout>
