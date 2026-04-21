<?php

namespace App\Http\Controllers;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Para manejo de imagenes
use Illuminate\Support\Facades\File; // Para manejo de archivos (imagenes en este caso)
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImagesController extends Controller
{
    // Retorna la vista a la seccion de imagenes
    public function create() {
        return view('imagenes.images');
    }

    public function upImage(Request $request) {
        // Igual que con el avatar, para guardar esta imagen necesito usar un disco de almacenamiento(virtual disk)
        // (puede ser el mismo disco o uno distinto si quiero separar avatares de publicaciones)
        // En este caso tengo que separar las imagenes del perfil del usuario con la imagen de avatar (por eso he creado otro disco virtual (en el archivo filesystem.php de la carpeta config))

        // Primero: valido los datos del formulario para asegurarme de que llega una descripción
        // y que el archivo subido es realmente una imagen
        // mimes: limita formatos permitidos
        // max: limita tamaño a 2MB
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);

        // Lo segundo es recoger los datos del formulario
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        // Con el user autenticado(logueado, para obtener todos sus datos)
        // Creo una nueva instancia del modelo Image, que representará el registro que se guardará en la tabla de imágenes en la db(para eso importo Models\Image)

        $user = Auth::user(); // Obtengo el usuario autenticado para asociar la imagen al usuario que la ha subido
        $image = new Image();
        $image->user_id = $user->id; // Asigno a la imagen el id del usuario autenticado para relacionar esta publicación con su propietario
        $image->description = $description; // Lo mismo que arriba pero con la descripcion

        // Subir la imagen desde el disco virtual
        if ($image_path) {
            // Si image_path es true (le asigno un nombre UNICO asi)
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->save(); // Despues de todo el proceso, guardo la imagen en la db

        return redirect()->route('dashboard')->with(['message' => 'La foto se ha subido correctamente']);
    }

    public function details($id) {
        $image = Image::findOrFail($id);
        $comments = $image->comments()->with('user')->get();
        $likesCount = $image->likes()->count();

        return view('comments.details', compact('image', 'comments', 'likesCount'));
    }

    public function showImage($filename) {
        // Mostrar(get)la imagen en el perfil
        return Storage::disk('images')->response($filename);
    }

    public function deleteImage($id) {
        // Eliminar imagen(delete) del perfil
    }

}
