<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('404') }}
        </h2>
    </x-slot>
    <div>
        <div class="container d-flex justify-content-center align-items-center not-found">
            <p class="h2">
                Not found <span class="fw-bold">404</span>
            </p>
        </div>
    </div>
</x-app-layout>

