<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function store(Request $request)
    {
        $payload = [
            'nama_author' => $request->input("nama_author"),
            'file' => $request->file->store("buku", "public")
        ];

        $author = Author::query()->create($payload);
        return response()->json([
            "status" => 201,
            "message" => "author berhasil ditambahkan",
            "data" => $author
        ]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->except(['file']);
        $author = Author::find($id);
        if(!$author) {
            return response()->json([
                "status" => 404,
                "message" => "id author tidak ditemukan / sudah dihapus",
                "data" => []
            ]);
        }
        if(isset($request->file)) {
            Storage::disk("public")->delete($author->file);
            $payload['file'] = $request->file->store("buku", "public");
        }

        $author->update($payload);
        return response()->json([
            "status" => 201,
            "message" => "author berhasil diperbarui",
            "data" => $author
        ]);
    }

    public function index()
    {
        $author = Author::query()->get();
        if(!$author) {
            return response()->json([
                "status" => 404,
                "message" => "Data author belum ada",
                "data" => []
            ]);
        }

        return response()->json([
            "status" => 200,
            "message" => "Berhasil mendapatkan author",
            "data" => $author
        ]);
    }

    public function show($id)
    {
        $author = Author::query()->where('id', $id)->first();
        if(!$author) {
            return response()->json([
                "status" => 404,
                "message" => "id author tidak ditemukan",
                "data" => []
            ]);
        }

        return response()->json([
            "status" => 200,
            "message" => "Berhasil mendapatkan id author",
            "data" => $author
        ]);

    }

    public function destroy($id)
    {
        $author = Author::find($id);
        if(!$author) {
            return response()->json([
                "status" => 404,
                "message" => "id author tidak ditemukan",
                "data" => []
            ]);
        }

        $author->delete();
        return response()->json([
            "status" => 200,
            "message" => "author berhasil dihapus",
            "data" => []
        ]);
    }
}
