<form class="space-y-6" action="{{ route('borrow.update', $borrowedBook->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf


    <div class ="px-3 ">
        <label class="mb-2" for="borrower_name">Borrower name</label>
        <p>{{ $borrowedBook->user->name }}</p>

    </div>

    <div class="px-3">
        <label for="book">Book</label>
        <select name="book_id" id="book_id" class="w-full px-3 py-2 border border-gray-300 rounded-md text-black"
            required>
            @foreach ($books as $book)
                <option value="{{ $book->id }}" {{ $book->id == $borrowedBook->borrowable->id ? 'selected' : '' }}>
                    {{ $book->title }}
                </option>
            @endforeach
        </select>
    </div>


    <div class ="px-3">
        <label class="mb-2" for="borrowed_at">borrowed_at</label>
        <input type="datetime-local" name="borrowed_at" id="borrowed_at"
            class=" w-full px-3 py-2 border border-gray-300 rounded-md text-black"
            value="{{ $borrowedBook->borrowed_at }}" required>
    </div>

    <div class ="px-3">
        <label class="mb-2" for="returned_at">returned at</label>
        <input type="datetime-local" name="returned_at" id="returned_at"
            class="w-full px-3 py-2 border border-gray-300 rounded-md text-black"
            value="{{ $borrowedBook->returned_at }}" required>

    </div>


    <div class="flex justify-center mb-4 ">
        <button type="submit" class="btn btn-primary w-50 py-2 px-4 hover:bg-blue-600">update</button>
    </div>
</form>
