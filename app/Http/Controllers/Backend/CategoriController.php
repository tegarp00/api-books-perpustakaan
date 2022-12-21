<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categori;

class CategoriController extends Controller
{
    public function store(Request $request)
    {
        $payload = [
            'nama_kategori' => $request->input("nama_kategori")
        ];

        $kategori = Categori::query()->create($payload);
        return response()->json([
            "status" => 201,
            "message" => "categori berhasil ditambahkan",
            "data" => $kategori
        ]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        $kategori = Categori::find($id);
        if(!$kategori) {
            return response()->json([
                "status" => 404,
                "message" => "id categori tidak ditemukan",
                "data" => []
            ]);
        }

        $kategori->update($payload);
        return response()->json([
            "status" => 201,
            "message" => "categori berhasil diperbarui",
            "data" => $kategori
        ]);
    }

    public function destroy($id)
    {
        $kategori = Categori::find($id);
        if(!$kategori) {
            return response()->json([
                "status" => 404,
                "message" => "id categori tidak ditemukan",
                "data" => []
            ]);
        }

        $kategori->delete();
        return response()->json([
            "status" => 200,
            "message" => "categori berhasil dihapus",
            "data" => $kategori
        ]);
    }

    public function index()
    {
        $kategori = Categori::query()->get();
        if(!$kategori) {
            return response()->json([
                "status" => 404,
                "message" => "Data categori belum ada",
                "data" => []
            ]);
        }

        return response()->json([
            "status" => 200,
            "message" => "berhasil mendapatkan categori",
            "data" => $kategori
        ]);
    }

    public function show($id)
    {
        $kategori = Categori::query()->where('id', $id)->first();
        if(!$kategori) {
            return response()->json([
                "status" => 404,
                "message" => "id categori tidak ditemukan",
                "data" => []
            ]);
        }

        return response()->json([
            "status" => 200,
            "message" => "Berhasil mendapatkan categori",
            "data" => $kategori
        ]);
    }
}
