<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create new post') }}
        </h2>
    </x-slot>
    <div class="container">
        <form action="{{ url('posts') }}" method="POST" class="form" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label for="images">Images</label>
                        <input type="file"
                               name="images[]"
                               class="form-control"
                               id="images"
                               multiple
                        />
                        <small class="text-danger">
                            @error('images.*')
                                {{$message}}
                            @enderror
                        </small>
                        <div class="images-preview-div d-flex"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="post_title">Title</label>
                        <input type="text"
                               class="blog-input"
                               name="post_title"
                               id="post_title"
                               value="{{ old('post_title') ?? '' }}"
                        />
                        <small class="text-danger">
                            @error('post_title')
                                {{$message}}
                            @enderror
                        </small>
                    </div>
                </div>
                <div class="row d-flex">
                    <div class="col-md-6">
                        <label for="post_content">Content</label>
                        <input type="text"
                               class="blog-input"
                               name="post_content"
                               id="post_content"
                               value="{{ old('post_content') ?? '' }}"
                        />
                        <small class="text-danger">
                            @error('post_content')
                                {{$message}}
                            @enderror
                        </small>
                    </div>
                </div>
                <div class="row mt-2 mb-4">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary submit-post">Create</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(function() {
            let previewImages = function(input, imgPreviewPlaceholder) {
                if (input.files) {
                    let filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        let reader = new FileReader();
                        reader.onload = function(event) {
                            $($.parseHTML('<img width="70" height="70" class="mt-1 me-1">')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#images').on('change', function() {
                previewImages(this, 'div.images-preview-div');
            });
        });
    </script>
</x-app-layout>
