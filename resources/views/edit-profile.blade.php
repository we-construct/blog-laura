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
                        @if($user->avatar_path !== '')
                            <img src="{{ asset('images/avatar/'.$user->avatar_path) }}"
                                 class="img-fluid rounded-start"
                                 alt="..."
                                 width="150"
                                 height="150"
                            />
                        @else
                            <img src="{{ asset('images/icons/no-avatar.svg') }}"
                                 class="img-fluid rounded-start"
                                 alt="..."
                                 width="150"
                                 height="150"
                            />
                        @endif
                        <form method="POST" action="{{ url("profile/{$user->id}/update") }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-2 mt-2">
                                    <label for="name">Name</label>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <input type="text" name="name" id="name" value="{{ old('name')?? $user->name }}"/>
                                    <small class="text-danger">
                                        @error('name'){{$message}}@enderror
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 mt-2">
                                    <label for="email">Email</label>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <input type="text" name="email" id="email" value="{{ old('email')?? $user->email }}"/>
                                    <small class="text-danger">
                                        @error('email'){{$message}}@enderror
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 mt-2">
                                    <label for="country">Country</label>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <select name="country" id="country" class="form-select">
                                        <option>Choose your country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{in_array($user->id, $country->users_ids)? "selected" : ''}}>
                                                {{ $country->country }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">
                                        @error('country'){{$message}}@enderror
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 mt-2">
                                    <label for="password">Password</label>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <input type="password" name="password" id="password" value=""/>
                                    <br>
                                    <small class="text-danger">
                                        @error('password'){{$message}}@enderror
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 mt-2">
                                    <label for="confirm-password">
                                        Confirm password
                                    </label>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <input type="password" name="password_confirmation" id="confirm-password" value=""/>
                                    <br>
                                    <small class="text-danger">
                                        @error('password_confirmation'){{$message}}@enderror
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto mt-2">
                                    <button type="submit" class="btn btn-primary mb-3">
                                        Update profile
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
