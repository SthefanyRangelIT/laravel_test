<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $primaryKey = 'book_id';

    protected $fillable = [
        'name',
        'author',
        'publication_date',
        'borrowed',
        'user_who_borrowed',
        'category_id',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'category_id', 'category_id');
    }

    public function borrower()
    {
        return $this->hasOne(User::class);
    }
}
