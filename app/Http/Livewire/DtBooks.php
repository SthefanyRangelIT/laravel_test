<?php

namespace App\Http\Livewire;

use App\Http\Controllers\BookController;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Livewire\Component;

class DtBooks extends Component
{

    public $books = null;
    public $categories;
    public $users;
    public $query;

    public $book_id;
    public $user_id;
    public $name;
    public $author;
    public $borrowed;
    public $user_who_borrowed;
    public $category_name;
    public $publication_date;
    public $category_id;

    public $register_modal = false;
    public $edit_modal = false;
    public $borrow_modal = false;
    public $delete_modal = false;
    public $confirmation_modal = false;
    public $confirmation_message;

    public function mount()
    {
        $this->query = Category::all();

        if ($this->query !== null) {
            $this->categories = $this->query;
        } else {
            $this->categories = null;
        }
        $this->books = Book::join('categories', 'categories.category_id', '=', 'books.category_id')->get();
        $this->users = User::all();

        //dd($this->categories);
    }

    public function cleanVariables()
    {
        $this->book_id = null;
        $this->name = null;
        $this->author = null;
        $this->publication_date = null;
        $this->borrowed = null;
        $this->user_who_borrowed = null;
        $this->category_name = null;
        $this->category_id = null;
        // dd($this->register_modal);
    }

    public function openRegisterModal()
    {
        $this->register_modal = true;
        // dd($this->register_modal);
    }

    public function openEditModal($book_id)
    {
        $this->book_id = $book_id;
        $chosen_book = Book::where('book_id', $book_id)
            ->join('categories', 'categories.category_id', '=', 'books.category_id')
            ->first();
        //  dd($chosen_book);
        $this->name = $chosen_book->name;
        $this->author = $chosen_book->author;
        $this->publication_date = $chosen_book->publication_date;
        $this->category_name = $chosen_book->category_name;
        $this->category_id = $chosen_book->category_id;
        $this->edit_modal = true;
    }

    public function openBorrowModal($book_id)
    {
        $this->book_id = $book_id;
        $chosen_book = Book::where('book_id', $book_id)
            ->join('categories', 'categories.category_id', '=', 'books.category_id')
            ->first();
        //  dd($chosen_book);
        $this->name = $chosen_book->name;
        $this->author = $chosen_book->author;
        $this->publication_date = $chosen_book->publication_date;
        $this->borrowed = $chosen_book->borrowed;
        $this->category_name = $chosen_book->category_name;
        $this->category_id = $chosen_book->category_id;
        $this->borrow_modal = true;
    }

    public function openDeleteModal($book_id)
    {
        $this->book_id = $book_id;

        $this->book_id = $book_id;
        $chosen_book = Book::where('book_id', $book_id)
            ->join('categories', 'categories.category_id', '=', 'books.category_id')
            ->first();
        //  dd($chosen_book);
        $this->name = $chosen_book->name;
        $this->author = $chosen_book->author;
        $this->publication_date = $chosen_book->publication_date;
        $this->category_name = $chosen_book->category_name;
        $this->category_id = $chosen_book->category_id;
        $this->delete_modal = true;
    }

    public function registerBook()
    {
        $bookAdmin = new BookController;
        $response = $bookAdmin->create(
            $name = $this->name,
            $author = $this->author,
            $publication_date = $this->publication_date,
            $category_id = $this->category_id,
        );

        if ($response !== null) {
            $this->cleanVariables();
            $this->confirmation_message = 'Book registered succesfully';
            $this->register_modal = false;
            $this->confirmation_modal = true;
        } else {
            $this->confirmation_message = 'Book registered failed. Please try again';
            $this->confirmation_modal = true;
        }
    }

    public function editBook()
    {
        $bookAdmin = new BookController;
        $response = $bookAdmin->edit(
            $book_id = $this->book_id,
            $name = $this->name,
            $author = $this->author,
            $publication_date = $this->publication_date,
            $category_id = $this->category_id,
        );

        if ($response !== null) {
            $this->cleanVariables();
            $this->confirmation_message = 'Book edited succesfully';
            $this->edit_modal = false;
            $this->confirmation_modal = true;
        } else {

            $this->confirmation_message = 'Book edited failed. Please try again';
            $this->confirmation_modal = true;
        }
    }

    public function changeBookStatus()
    {
        $bookAdmin = new BookController;
        if ($this->borrowed == false) {
            $new_status = true;
            $user = $this->user_id;
        } else {
            $new_status = false;
            $user = null;
        }
        $response = $bookAdmin->changeStatus(
            $book_id = $this->book_id,
            $user_id = $user,
            $borrowed = $new_status,
        );

        if ($response !== null) {
            $this->cleanVariables();
            $this->confirmation_message = 'Book status changed succesfully';
            $this->borrow_modal = false;
            $this->confirmation_modal = true;
        } else {

            $this->confirmation_message = 'Book status changed failed. Please try again';
            $this->confirmation_modal = true;
        }
    }

    public function deleteBook()
    {
        $bookAdmin = new BookController;
        $response = $bookAdmin->destroy(
            $book_id = $this->book_id
        );

        if ($response !== null) {
            $this->cleanVariables();
            $this->confirmation_message = 'Book deleted succesfully';
            $this->delete_modal = false;
            $this->confirmation_modal = true;
        } else {

            $this->confirmation_message = 'Book deleted failed. Please try again';
            $this->confirmation_modal = true;
        }
    }

    public function render()
    {
        $this->query = Category::all();

        if ($this->query !== null) {
            $this->categories = $this->query;
        } else {
            $this->categories = null;
        }
        $this->books = Book::join('categories', 'categories.category_id', '=', 'books.category_id')->get();
        $this->users = User::all();
        return view('livewire.dt-books');
    }
}
