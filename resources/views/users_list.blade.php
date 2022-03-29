<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All users') }}
        </h2>
    </x-slot>

    <div>
        <div class="container">
            @foreach($users as $user)
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-2 my-md-2">
                                <a href="profile/{{ $user->id }}/details">
                                    @if($user->avatar_path !== '')
                                        <img src="{{ asset('images/avatar/'.$user->avatar_path) }}" class="img-fluid rounded-start" alt="...">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" fill="currentColor" class="bi bi-file-person mt-2" viewBox="0 0 16 16">
                                            <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                                            <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        </svg>
                                    @endif
                                </a>
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title post-item text-center">
                                        <a href="profile/{{ $user->id }}/details">
                                            <div class="post-title">
                                                    <p class="card-text ps-2"><small class="text-muted">{{ $user->name }}</small></p>
                                            </div>
                                        </a>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card-body">
                                    <form action="{{ url('/follow-unfollow/'.$user->id) }}" method="POST">
                                        @csrf
                                        @if (in_array($user->id, $following_ids->toArray()) && !in_array($auth_user_id, $user->following_ids->toArray()))
                                            <button type="submit" class="btn btn-primary">
                                                Follow Back
                                            </button>
                                        @elseif(in_array($auth_user_id, $user->following_ids->toArray()))
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
        </div>
    </div>
</x-app-layout>
