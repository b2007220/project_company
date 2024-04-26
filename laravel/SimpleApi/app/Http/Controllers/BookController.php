<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(Books::all(), 200);
    }
    public function show($id)
    {
        $book = Books::find($id);
        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        } else {
            return response()->json($book, 200);
        }
    }
    public function store(Request $request)
    {
        $book = new Books();
        $book->name = $request->name;
        $book->author = $request->author;
        $book->publish_date = $request->publish_date;
        $book->save();
        return response()->json($book, 201);
    }
    public function update(Request $request, $id)
    {
        $book = Books::find($id);
        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        } else {
            $book->name = is_null($request->name) ? $book->name : $request->name;
            $book->author = is_null($request->author) ? $book->author : $request->author;
            $book->publish_date = is_null($request->publish_date) ? $book->publish_date : $request->publish_date;
            $book->save();
            return response()->json($book, 200);
        }
    }
    public function destroy($id)
    {
        return response()->json([
            'message' => 'Book deleted',
        ], 200);
        // $book = Books::find($id);
        // if (!$book) {
        //     return response()->json([
        //         'message' => 'Book not found',
        //     ], 404);
        // } else {
        //     $book->delete();
        //     return response()->json([
        //         'message' => 'Book deleted',
        //     ], 200);
        // }
    }
}
