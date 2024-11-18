<form class="space-y-6" action="{{ route('borrow.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

        <input type="hidden" name="book_id" id="book_id" value="{{ $book->id }}">

    <div class="row">
        <div class="col">
            <div class ="px-3">
                <label class="mb-2" for="title">Title</label>
                <br>
                <label class="mb-2" for="title">{{ $book->title }}</label>
            </div>
        </div>
        <div class="col">
            <div class ="px-3">
                <label class="mb-2" for="author">Author</label>
                <br>
                <label class="mb-2" for="author">{{ $book->author }}</label>
            </div>
        </div>
    </div>
    <div class ="px-3">
        <label class="mb-2" for="category">Category</label>
        <br>
        <label class="mb-2" for="category">{{ $book->category }}</label>
    </div>

    <div class ="px-3">
        <details>
            <summary>Description</summary>
            <p>{{ $book->description }}</p>
        </details>
    </div>

    <div class ="px-3">
        <label class="mb-2" for="borrowed_at">borrowed_at</label>
        <input type="datetime-local" name="borrowed_at" id="borrowed_at"
            class=" w-full px-3 py-2 border border-gray-300 rounded-md text-black" required>
    </div>

    <div class ="px-3">
        <label class="mb-2" for="returned_at">returned at</label>
        <input type="datetime-local" name="returned_at" id="returned_at"
            class="w-full px-3 py-2 border border-gray-300 rounded-md text-black" required>

    </div>






    <div class="flex justify-center mb-4 ">
        <button type="submit" class="btn btn-primary w-50 py-2 px-4 hover:bg-blue-600">Borrow Book</button>
    </div>
</form>
