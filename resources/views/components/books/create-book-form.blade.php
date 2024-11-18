<form class="space-y-6" action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class ="px-3">
        <label class="mb-2" for="title">Title</label>
        <br>
        <input type="text" name="title" id="title" required
            class="w-full  px-3 py-2 border border-gray-300 rounded-md text-black">
    </div>
    <div class ="px-3">
        <label class="mb-2" for="author">Author</label>
        <br>
        <input type="text" name="author" id="author" required
            class="w-full px-3 py-2 border border-gray-300 rounded-md text-black">
    </div>
    <div class ="px-3">
        <label class="mb-2" for="description">Description</label>
        <br>
        <textarea name="description" id="description" class="w-full px-3 py-2 border border-gray-300 rounded-md text-black"></textarea>
    </div>
    <div class ="px-3">
        <label class="mb-2" for="category">Category</label>
        <br>
        <input type="text" name="category" id="category"
            class="w-full px-3 py-2 border border-gray-300 rounded-md text-black">
    </div>
    <div class ="px-3">
        <label class="mb-2" for="available_copies">Available Copies</label>
        <br>
        <input type="number" name="available_copies" id="available_copies" value="1" min="1"
            class="w-full px-3 py-2 border border-gray-300 rounded-md text-black">
    </div>
    <div class ="px-3">
        <label class="mb-2" for="pdf_file">Upload PDF File</label>
        <br>
        <input type="file" name="pdf_file" id="pdf_file" accept="application/pdf"
            class="w-80 px-3 py-2 border border-gray-300 rounded-md mb-4">
    </div>

    <div class="flex justify-center mb-4 ">
        <button type="submit" class="btn btn-primary w-50 py-2 px-4 hover:bg-blue-600">Add</button>
    </div>
</form>
