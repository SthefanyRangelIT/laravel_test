<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($name, $author, $publication_date, $category_id)
    {
        $book = Book::create([
            'name' => $name,
            'author' => $author,
            'borrowed' => false,
            'publication_date' => Carbon::create($publication_date),
            'category_id' => $category_id,
        ]);

        if ($book !== null) {
            return $book->book_id;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($book_id)
    {
        return Book::where('book_id', $book_id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($book_id, $name, $author, $publication_date, $category_id)
    {
        $response = Book::where('book_id', $book_id)->update([
            'name' => $name,
            'author' => $author,
            'publication_date' => Carbon::create($publication_date),
            'category_id' => $category_id,
        ]);

        if ($response == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($book_id, $user_id, $borrowed)
    {
        $response = Book::where('book_id', $book_id)->update([
            'borrowed' => $borrowed,
            'user_who_borrowed' => $user_id,
        ]);

        if ($response == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($book_id)
    {
        $response = Book::where('book_id', $book_id)->delete();

        if ($response == 1) {
            return true;
        } else {
            return false;
        }
    }
}
