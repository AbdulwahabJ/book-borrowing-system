<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class BorrowingController extends Controller
{
   
    public function index()
    {
        return view('borrow.books.index');

    }
    public function create($id)
    {

        $book = Book::find($id);
        return view('borrow.books.create', compact('book'));
    }
    public function edit($id)
    {

        $books = Book::all();

        $borrowedBook = Borrowing::findOrFail($id);

        return view('borrow.books.edit', compact(['borrowedBook', 'books']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'borrowed_at' => 'nullable|date',
            'returned_at' => 'nullable|date',
        ]);

        try {
            $borrowedBook = Borrowing::findOrFail($id);
            $borrowedBook->borrowable_id = $request->book_id;
            $borrowedBook->borrowed_at = $request->input('borrowed_at');
            $borrowedBook->returned_at = $request->input('returned_at');
            $borrowedBook->save();

            return redirect()->route('borrow.index')->with('success', 'Book Borrowing updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors('error', 'An error occurred while updating the book.')->withInput();
        }
    }


    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $user = Auth::user();

            $book = Book::findOrFail($request->book_id);

            if (!$book->available_copies > 0) {
                return redirect()->back()->with('error', 'This book is currently unavailable.');
            }

            $borrowing = Borrowing::create([
                'user_id' => $user->id,
                'borrowable_id' => $book->id,
                'borrowable_type' => Book::class,//handle types for future like magazine..etc.
                'borrowed_at' => $request->borrowed_at,
                'returned_at' => $request->returned_at,
            ]);

            $book->available_copies -= 1;
            $book->save();

            DB::commit();
            //
            $downloadLink = $book->pdf_file ? asset('storage/' . $book->pdf_file) : null;

            return redirect()->route('dashboard')->with('success', 'The book has been borrowed successfully')
                ->with('downloadLink', $downloadLink);
            ;


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors('error', 'An error occurred during the borrowing process: ' . $e->getMessage())->withInput();
        }
    }


    public function getBorrowingData()
    {
        $borrowings = Borrowing::with(['user', 'borrowable']);

        return DataTables::of($borrowings)
            ->addColumn('user_name', function ($borrowing) {
                return $borrowing->user->name;
            })
            ->addColumn('book_title', function ($borrowing) {
                return $borrowing->borrowable->title;
            })
            ->addColumn('borrowed_at', function ($borrowing) {
                return $borrowing->borrowed_at;
            })
            ->addColumn('returned_at', function ($borrowing) {
                return $borrowing->returned_at;
            })->make(true);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $borrowing = Borrowing::findOrFail($id);

            if ($borrowing->borrowable && $borrowing->borrowable_type === Book::class) {
                $book = $borrowing->borrowable;
                $book->available_copies += 1;
                $book->save();
            }

            $borrowing->delete();

            DB::commit();

            return redirect()->route('borrow.index')->with('success', 'success.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'An error occurred while deleting: ' . $e->getMessage()]);
        }
    }


}

