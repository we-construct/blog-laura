<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit comment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <form action="{{ url("comments/{$comment->id}") }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="comment-input">
                                        Comment
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <textarea name="commentInput" id="comment-input" cols="30" rows="6">{{ old('commentInput')?? $comment->comment}}</textarea>
                                </div>
                                <div>
                                    <small class="text-danger">
                                        @error('commentInput'){{$message}}@enderror
                                    </small>
                                </div>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary">
                                        Update comment
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

