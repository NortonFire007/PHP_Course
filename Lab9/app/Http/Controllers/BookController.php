<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Book::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'publication_year' => 'required|integer|digits:4',
            'price' => 'required|numeric|min:0',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $book = Book::create($validator->validated());
        return response()->json($book, 201);
    }

    public function show(string $id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }

    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'publication_year' => 'sometimes|integer|digits:4',
            'price' => 'sometimes|numeric|min:0',
            'author_id' => 'sometimes|exists:authors,id',
            'genre_id' => 'sometimes|exists:genres,id',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $book->update($validator->validated());
        return response()->json($book);
    }

    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
