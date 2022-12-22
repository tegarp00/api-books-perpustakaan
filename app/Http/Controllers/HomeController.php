<?php

namespace App\Http\Controllers;

use App\Helpers\HttpClient;

class HomeController extends Controller
{
    function index()
    {
        $responsePengguna = HttpClient::fetch(
            "GET",
            "http://localhost:8000/api/books"
        );
        $books = $responsePengguna["data"];
        return view('home', [
            "books" => $books
        ]);
    }

    function createBook()
    {
        $author = HttpClient::fetch(
            "GET",
            "http://localhost:8000/api/authors"
        );
        $kategori = HttpClient::fetch(
            "GET",
            "http://localhost:8000/api/categories"
        );
        $kategori = $kategori["data"];
        $authors = $author["data"];
        return view('addbook', [
            "authors" => $authors,
            "kategori" => $kategori
        ]);
    }

    function update($id)
    {
        $author = HttpClient::fetch(
            "GET",
            "http://localhost:8000/api/authors"
        );
        $kategori = HttpClient::fetch(
            "GET",
            "http://localhost:8000/api/categories"
        );
        $kategoriId = HttpClient::fetch(
            "GET",
            "http://localhost:8000/api/books/".$id
        );
        $kategori = $kategori["data"];
        $authors = $author["data"];
        return view('updatebook', [
            "authors" => $authors,
            "kategori" => $kategori,
            "kategoriById" => $kategoriId['data']
        ]);
    }

}
