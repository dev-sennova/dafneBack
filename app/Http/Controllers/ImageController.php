<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        // Validación de la imagen
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajusta las reglas de validación según tus necesidades
        ]);

        // Subir la imagen al servidor
        $imagePath = $request->file('image')->store('uploads', 'public');

        // Guardar la URL en la base de datos (suponiendo que tengas un modelo y una tabla para almacenar imágenes)
        $imageUrl = asset('storage/' . $imagePath);

        // Aquí debes crear un nuevo registro en tu tabla de imágenes con la URL almacenada

        // Devolver la URL de la imagen
        return response()->json(['imageUrl' => $imageUrl]);
    }
}
