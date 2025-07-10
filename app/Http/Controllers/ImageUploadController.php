<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/editor-images');
            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => Storage::url($path),
                ],
            ]);
        }

        return response()->json(['success' => 0, 'message' => 'Image upload failed.'], 400);
    }

    public function fetch(Request $request)
    {
        // Untuk mengambil gambar dari URL eksternal (opsional)
        // Ini bisa melibatkan cURL atau Guzzle untuk mengambil gambar
        // dan menyimpannya secara lokal jika Anda ingin mem-proxy atau mengoptimalkan.
        // Untuk contoh sederhana, kita hanya akan mengembalikan URL yang diberikan.
        $request->validate([
            'url' => 'required|url',
        ]);

        return response()->json([
            'success' => 1,
            'file' => [
                'url' => $request->url,
            ],
        ]);
    }
}