<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Genre::all();
    }

    public function show($id)
    {
        return Genre::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $genre = Genre::create($validator->validated());
        return response()->json($genre, 201);
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $genre->update($validator->validated());
        return response()->json($genre);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return response()->json(['message' => 'Genre deleted successfully']);
    }
}
