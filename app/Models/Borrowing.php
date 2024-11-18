<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'borrowable_id',
        'borrowable_type',
        'borrowed_at',
        'returned_at'
    ];
    public function borrowable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
