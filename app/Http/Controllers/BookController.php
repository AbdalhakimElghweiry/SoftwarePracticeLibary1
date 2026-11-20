<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        return BookResource::collection($query->get());
    }

    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());
        return (new BookResource($book))->response()->setStatusCode(201);
    }

    public function show(Book $book)
    {
        return new BookResource($book->load('category'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return new BookResource($book);
    }

    public function destroy(Book $book)
    {
        if ($book->borrowings()->exists()) {
            return response()->json([
                'message' => 'This book has borrowing records and cannot be deleted',
            ], 409);
        }

        $book->delete();
        return response()->noContent();
    }
}
