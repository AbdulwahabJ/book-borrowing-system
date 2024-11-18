<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'is_available',
        'description',
        'category',
        'available_copies',
        'pdf_file',
    ];
    public function borrowings(): MorphMany
    {
        return $this->morphMany(Borrowing::class, 'borrowable');
    }

    protected static function booted()
    {
        static::deleting(function ($book) {
            $book->borrowings()->delete();
        });
    }
}
