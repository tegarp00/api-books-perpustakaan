<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Categori;
use App\Models\Author;

class BookController extends Controller
{

    public function getShow($id)
    {
        $books = Buku::query()->where('id', $id)->first();
        if(!$books) {
            return response()->json([
                "status" => 404,
                "message" => "id buku tidak ditemukan",
                "data" => []
            ],404);
        }

        $books['author'] = Author::query()->where('id', $books->id_author)->first();
        $books['kategori'] = Categori::query()->where('id', $books->id_kategori)->first();



        return response()->json([
            "status" => 200,
            "message" => "list buku berhasil didapatkan",
            "data" => $books
        ], 200);

    }

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

        // $list1 = [];
        // $list2 = [];


        // foreach($buku as $b) {
        //     foreach($author as $a) {
        //         if($b->id_author == $a->id) {
        //             $list1[] = [
        //                 "kode_buku" => $b->kode_buku,
        //                 "judul_buku" => $b->judul_buku,
        //                 "jumlah_halaman" => $b->jumlah_halaman,
        //                 "tahun_terbit" => $b->tahun_terbit,
        //                 "id_kategori" => $b->id_kategori,
        //                 "author" => [
        //                     "id_author" => $a->id,
        //                     "nama_author" => $a->nama_author,
        //                     "profile" => $a->file,
        //                 ],
        //             ];
        //         }
        //     }
        // }

        // foreach($list1 as $l1) {
        //     foreach($kategori as $k) {
        //         if($l1['id_kategori'] == $k->id) {
        //             $list2[] = [
        //                 "kode_buku" => $l1['kode_buku'],
        //                 "judul_buku" => $l1['judul_buku'],
        //                 "jumlah_halaman" => $l1['jumlah_halaman'],
        //                 "tahun_terbit" => $l1['tahun_terbit'],
        //                 "kategori" => [
        //                     "id_kategori" => $k->id,
        //                     "nama_kategori" => $k->nama_kategori
        //                 ],
        //                 "author" => $l1['author']
        //             ];
        //         }
        //     }
        // }

        return response()->json([
            "status" => 200,
            "message" => "list buku berhasil didapatkan",
            "data" => $collection
        ], 200);

    }

    public function index()
    {
        $buku = Buku::query()->get();
        if(!$buku) {
            return response()->json([
                "status" => 404,
                "message" => "List buku belum tersedia",
                "data" => []
            ],404);
        }

        return response()->json([
            "status" => 200,
            "message" => "list buku berhasil didapatkan",
            "data" => $buku
        ]);
    }

    public function store(Request $request)
    {
        $payload = [
            'kode_buku' => $request->input("kode_buku"),
            'judul_buku' => $request->input("judul_buku"),
            'jumlah_halaman' => $request->input("jumlah_halaman"),
            'tahun_terbit' => $request->input("tahun_terbit"),
            'id_kategori' => $request->input("id_kategori"),
            'id_author' => $request->input("id_author"),
        ];

        $buku = Buku::query()->create($payload);
        return response()->json([
            "status" => 200,
            "message" => "Buku berhasil ditambahkan",
            "data" => $buku
        ]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        $buku = Buku::find($id);
        if(!$buku) {
            return response()->json([
                "status" => 404,
                "message" => "id buku tidak ditemukan / sudah dihapus",
                "data" => []
            ],404);
        }

        $buku->update($payload);
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
