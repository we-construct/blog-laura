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
                                <a href="{{ url('/profile/' . $user->id . '/details') }}">
                                    @if($user->avatar_path !== '')
                                        <img src="{{ asset('images/avatar/'.$user->avatar_path) }}"
                                             class="img-fluid rounded-start"
                                             alt="..."
                                        />
                                    @else
                                        <img src="{{ asset('images/icons/no-avatar.svg') }}"
                                             class="img-fluid rounded-start"
                                             width="120"
                                             height="120"
                                             alt="..."
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
        </div>
    </div>
</x-app-layout>
