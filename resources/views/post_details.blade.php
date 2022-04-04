<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">q
                                <label for="post-item-title" class="post-item-label">Title</label>
                            </div>
                            <div class="col-md-7">
                                <div type="text" id="post-item-title" class="post-item-input"> {{ $postItem->title }} </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <label for="post-item-content" class="post-item-label">Content</label>
                            </div>
                            <div class="col-md-7">
                                <div id="post-item-content" class="post-item-input post-item-content ps-2">{{ $postItem->content }}</div>
                            </div>
                        </div>

                        <p class="mt-4 mb-2 text-muted">Comments</p>
                        @foreach($comments as $comment)
                            <div class="row mt-2">
                                <div class="col-md-6 comment-container">
                                    <div class="comment">{{ $comment->comment }}</div>
                                    <form action="{{ url('/comments/' . $comment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Delete" class="text-muted">
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        <div class="row">
                            <div class="col-md-8 px-0">
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="postId" value="{{ $postItem->id }}">
                                    <textarea name="comment" id="" cols="80" rows="2" class="mt-4"></textarea>
                                    <div>
                                        <small class="text-danger">@error('comment'){{$message}}@enderror</small>
                                    </div>
                                    <div class="mt-1">
                                        <button type="submit" class="btn btn-primary">Add comment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
