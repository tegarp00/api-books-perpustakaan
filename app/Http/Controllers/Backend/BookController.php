<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Categori;
use App\Models\Author;

class BookController extends Controller
{

    // jadi fungsi ini untuk menampilkan data buku berdasarkanID yang sudah di gabungkan dgn bbrpa table
    public function getShow($id)
    {
        // jadi pertama kita membuat query untuk mencari data buku berdasarkan ID
        $books = Buku::query()->where('id', $id)->first();

        // cek jika data tidak ada
        if(!$books) {
            return response()->json([
                "status" => 404,
                "message" => "id buku tidak ditemukan",
                "data" => []
            ],404);
        }

        // kita query data author dan kategori dengan menyamakan idnya dengan idBuku
        $books['author'] = Author::query()->where('id', $books->id_author)->first();
        $books['kategori'] = Categori::query()->where('id', $books->id_kategori)->first();


        // handle response jika berhasil
        return response()->json([
            "status" => 200,
            "message" => "list buku berhasil didapatkan",
            "data" => $books
        ], 200);

    }

    // jadi fungsi ini untuk menampilkan semua data buku yang sudah di gabungkan dgn bbrpa table
    public function all()
    {
        $books = Buku::query()->get();
        
        $collection = $books->map(function ($buku) {
            $author = Author::query()->where('id', $buku->id_author)->first();
            $kategori = Categori::query()->where('id', $buku->id_kategori)->first();

            $buku['kategori'] = $kategori;
            $buku['author'] = $author;
            return $buku;
        })->reject(function ($buku) {
            return empty($buku);
        });

        return response()->json([
            "status" => 200,
            "message" => "list buku berhasil didapatkan",
            "data" => $collection
        ], 200);

    }

    public function index()
    {
        // kita cari semua data Buku
        $buku = Buku::query()->get();

        // jika tidak ada handle errnya
        if(!$buku) {
            return response()->json([
                "status" => 404,
                "message" => "List buku belum tersedia",
                "data" => []
            ],404);
        }

        // jika berhasil beri response
        return response()->json([
            "status" => 200,
            "message" => "list buku berhasil didapatkan",
            "data" => $buku
        ]);
    }

    public function store(Request $request)
    {

        // kita tangkap inputan user(request body) dan disimpan ke variable payload
        $payload = [
            'kode_buku' => $request->input("kode_buku"),
            'judul_buku' => $request->input("judul_buku"),
            'jumlah_halaman' => $request->input("jumlah_halaman"),
            'tahun_terbit' => $request->input("tahun_terbit"),
            'id_kategori' => $request->input("id_kategori"),
            'id_author' => $request->input("id_author"),
        ];

        // terus kita panggil model Bukunya lalu kita pakai fungsi create yg dimana kita masukkan variabel payloadnya 
        $buku = Buku::query()->create($payload);

        // beri response jika berhasil
        return response()->json([
            "status" => 200,
            "message" => "Buku berhasil ditambahkan",
            "data" => $buku
        ]);
    }

    public function update(Request $request, $id)
    {
        // tangkap semua request user
        $payload = $request->all();

        // cari data Buku berdasarkan id
        $buku = Buku::find($id);

        // handle err jika data tidak ada
        if(!$buku) {
            return response()->json([
                "status" => 404,
                "message" => "id buku tidak ditemukan / sudah dihapus",
                "data" => []
            ],404);
        }

        // masukkan tangkapan user ke fungsi update
        $buku->update($payload);

        // handle response jika berhasil diupdate
        return response()->json([
            "status" => 201,
            "message" => "buku berhasil diperbarui",
            "data" => $buku
        ],201);
    }

    public function show($id)
    {
        $buku = Buku::query()->where('id', $id)->first();
        if(!$buku) {
            return response()->json([
                "status" => 404,
                "message" => "id tidak ditemukan",
                "data" => []
            ],404);
        }

        return response()->json([
            "status" => 200,
            "message" => "buku berhasil didapatkan",
            "data" => $buku
        ]);
    }

    public function destroy($id)
    {
        $buku = Buku::find($id);
        if(!$buku) {
            return response()->json([
                "status" => 404,
                "message" => "id tidak ditemukan",
                "data" => []
            ], 404);
        }

        $buku->delete();
        return response()->json([
            "status" => 200,
            "message" => "buku berhasil dihapus",
            "data" => []
        ], 200);
    }
}
