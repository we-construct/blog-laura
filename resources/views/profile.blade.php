<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        @if($auth_user->avatar_path !== '')
                            <img src="{{ asset('images/avatar/'.$auth_user->avatar_path) }}"
                                 class="img-fluid rounded-start" alt="..." width="150" height="150">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor"
                                 class="bi bi-file-person mt-2" viewBox="0 0 16 16">
                                <path
                                    d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        @endif
                        <form method="POST" action="{{ url('update-avatar/' . $auth_user->id)}}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4 mt-2">
                                    <input type="file" name="avatar" class="form-control">
                                    <small class="text-danger">@error('avatar'){{$message}}@enderror</small>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <button type="submit" class="btn btn-primary mb-3">Update avatar</button>
                                </div>
                            </div>
                        </form>

                        <p class="mt-2">{{ $auth_user->name }}</p>
                        <p>{{ $auth_user->email }}</p>

                        <a href="profile/edit" class="form-edit">
                            <button class="btn btn-outline-primary">Edit</button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <h4>Followers - {{ $followings }}</h4>
                        <a href="profile/followers"> Show all</a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <h4>Following - {{ $followers }}</h4>
                        <a href="profile/followings"> Show all</a>
                    </div>
                </div>
            </div>

            <div class="container px-0 mt-3">
                <h4>All my posts</h4>
                @foreach($posts as $post)
                    <div class="max-w-7xl mx-auto mt-3">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <a href="profile/{{ $auth_user->id }}/details">
                                        @if($auth_user->avatar_path !== '')
                                            <img src="{{ 'images/avatar/'.$auth_user->avatar_path }}"
                                                 class="img-fluid rounded-start" alt="...">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120"
                                                 fill="currentColor" class="bi bi-file-person mt-2" viewBox="0 0 16 16">
                                                <path
                                                    d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                                <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                            </svg>
                                        @endif
                                    </a>
                                    <a href="profile/{{ $auth_user->id }}/details">
                                        <p class="card-text ps-2"><small
                                                class="text-muted">{{ $auth_user->name }}</small></p>
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title post-item">
                                            <a href="posts/{{ $post->id }}">
                                                <div class="post-title">{{ $post->title }}</div>
                                            </a>
                                        </h5>
                                        <p class="card-text">{{ $post->content }}</p>
                                        {{--                                                @if($post->user_id === $userId)--}}
                                        <a href="posts/{{ $post->id }}/edit" class="btn btn-primary">Edit</a>
                                        <form action="/posts/{{ $post->id }}" method="POST" class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-secondary" type="submit">Delete</button>
                                        </form>
                                        {{--                                                @endif--}}
                                        <p class="card-text text-end"><small class="text-muted">Created
                                                at {{ date_format($post->created_at,"Y/m/d") }}</small></p>
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
    </div>

</x-app-layout>
