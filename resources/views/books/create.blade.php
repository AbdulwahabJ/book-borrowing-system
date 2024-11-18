<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-800 leading-tight">

            {{ __('Add New Book') }}
        </h2>
    </x-slot>



    <div class="py-12 ">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-6">

            <div
                class="bg-gray-800 dark:bg-gray-800 text-white dark:text-white overflow-hidden shadow-sm sm:rounded-lg ">

                @include('components.books.create-book-form')

            </div>
        </div>

    </div>



</x-app-layout>
