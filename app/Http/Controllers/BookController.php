<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{

    // i didn't use a Trait for now as I don't need it extensively at the moment.
    //However, it might be useful in the future if the code grows or becomes more complex.

    public function index()
    {

        return view('books.index');
    }
    public function create()
    {
        return view('books.create');
    }


    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'title' => 'required|string',
                'author' => 'required|string',
                'description' => 'nullable|string',
                'category' => 'nullable|string',
                'available_copies' => 'required|integer|min:1',
                'pdf_file' => 'nullable|mimes:pdf|max:10000',
            ]);

            $pdfFilePath = null;

            if ($request->hasFile('pdf_file')) {
                $pdfFilePath = $request->file('pdf_file')->store('pdfs', 'public');
            }

            Book::create([
                'title' => $validated['title'],
                'author' => $validated['author'],
                'description' => $validated['description'] ?? null,
                'category' => $validated['category'] ?? null,
                'available_copies' => $validated['available_copies'],
                'pdf_file' => $pdfFilePath,
            ]);
            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Book added successfully');
            //
        } catch (\Exception $e) {
            //
            DB::rollBack();
            return redirect()->route('books.create')->with('error', 'Failed to add the book. Please try again.');
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'available_copies' => 'required|integer|min:1',
            'pdf_file' => 'nullable|mimes:pdf|max:10000',
        ]);

        try {
            $book = Book::findOrFail($id);
            $pdfPath = null;

            if ($request->hasFile('pdf_file')) {

                if ($book->pdf_file) {

                    \Storage::disk('public')->delete($book->pdf_file);
                }

                $pdfPath = $request->file('pdf_file')->store('pdfs', 'public');
            }


            $book->title = $request->input('title');
            $book->author = $request->input('author');
            $book->description = $request->input('description');
            $book->category = $request->input('category');
            $book->available_copies = $request->input('available_copies');
            $book->pdf_file = $pdfPath;

            $book->save();

            return redirect()->route('dashboard')->with('success', 'Book updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while updating the book.'])->withInput();
        }
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        if ($book->pdf_file) {
            \Storage::disk('public')->delete($book->pdf_file);
        }

        $book->delete();

        return redirect()->route('dashboard')->with('success', 'Book deleted successfully.');
    }

    public function getData()
    {

        $books = Book::query();
        return DataTables::of($books)->make(true);
    }

    public function getPermissions()
    {
        $permissions = auth()->user()->inDirectPermissions();
        return response()->json($permissions);
    }

}
