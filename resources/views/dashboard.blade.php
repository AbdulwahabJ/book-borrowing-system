<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-800 leading-tight">

            {{ __('Books') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-800 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-center mt-4"> @can('managing-books')
                        <a href="{{ route('books.create') }}"type="button" class="btn btn-outline-primary btn-lg">add book</a>
                    @endcan
                </div>

                @include('components.books.books-table')


            </div>
        </div>

    </div>


    @if (session('downloadLink'))
        <script>
            window.onload = function() {
                window.open("{{ session('downloadLink') }}", '_blank');
            };
        </script>
    @endif

</x-app-layout>
