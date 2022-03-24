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
                            <div class="col-md-4 offset-md-4">
                                <label for="post-item-title" class="post-item-label">Title</label>
                            </div>
                            <div class="col-md-4 offset-md-4">
                                <div type="text" id="post-item-title" class="post-item-input"> {{ $postItem->title }} </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <label for="post-item-content" class="post-item-label">Content</label>
                            </div>
                            <div class="col-md-4 offset-md-4">
                                <div id="post-item-content" class="post-item-input post-item-content">{{ $postItem->content }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
