<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //user
    Route::get('/user/permissions', [BookController::class, 'getPermissions'])->name('user.permissions');

    //books
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/data', [BookController::class, 'getData'])->name('books.data');
    Route::get('export-pdf/{id}', [BookController::class, 'exportPdf'])->name('books.exportPdf');
    Route::delete('/books/delete/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/books/edit/{id}', [BookController::class, 'edit'])->name('books.edit');
    Route::post('/books/update/{id}', [BookController::class, 'update'])->name('books.update');

    //borrowing
    Route::get('/borrow/index', [BorrowingController::class, 'index'])->name('borrow.index');
    Route::post('/borrow/store', [BorrowingController::class, 'store'])->name('borrow.store');
    Route::get('/borrow/create/{book_id}', [BorrowingController::class, 'create'])->name('borrow.book.create');
    Route::get('/borrow/data', [BorrowingController::class, 'getBorrowingData'])->name('borrow.data');
    Route::delete('/borrow/delete/{id}', [BorrowingController::class, 'destroy'])->name('borrow.destroy');
    Route::get('/borrow/edit/{id}', [BorrowingController::class, 'edit'])->name('borrow.edit');
    Route::post('/borrow/update/{id}', [BorrowingController::class, 'update'])->name('borrow.update');
});

require __DIR__ . '/auth.php';
