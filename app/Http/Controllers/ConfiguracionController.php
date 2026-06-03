<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; // Tengo que hacer el use de auth para que me de el usuario identificado
use Illuminate\Support\Facades\Storage; // Para manejo de imagenes
use Illuminate\Support\Facades\File; // Para manejo de archivos (imagenes en este caso)
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConfiguracionController extends Controller
{
    // Retorna a la vista de la configuracion del user
    public function config() {
        return view('configuration.configuracion');
    }

    // Metodos para la configuracion(actualizacion)
    public function update(Request $request) {

        // Conseguir el usuario identificado para poder actualizarlo
        $user = Auth::user();
        
        // Obtengo el id del usuario identificado
        $id = $user->id;

        // Validacion del formulario
        $validate = $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', Rule::unique('users', 'nick')->ignore($user->id)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            ]);

        // Actualizacion del usuario (recogiendo los datos del formulario)
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        // Y le asigno esos nuevos valores al objeto user
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        // Para setear la imagen del avatar (en la config (configuracion.blade.php y ruta config.update))
        // Para subir imagenes y manejarlas en un controler primero tengo que configurar un disco virtual en el archivo filesystem.php de la carpeta config (de laravel, no la mia) <- ir a ver
        // Cuando tenga hecha esa configuracion hago este proceso:

        // Subir imagen (con file en lugar de input, porque es un archivo lo que recibo del formulario)
        $image_path = $request->file('image_path');

        if ($image_path) {
            // Si image_path es true (le asigno un nombre UNICO asi)
            $image_path_name = time() . str_replace(' ', '', $image_path->getClientOriginalName());

            // Guardo la imagen (lo creado arriba) en la carpeta storage (storage/app/users)
            // ->put(nombre del archivo, y el archivo en si)
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            // Despues de todo este proceso ya puedo setear la imagen(su nombre) y guardarla en la db
            $user->image = $image_path_name;
        }

            // Los inserto en la db
            $user->update(
                ['name' => $request->name,
                'surname' => $request->surname,
                'nick' => $request->nick,
                'email' => $request->email,
                ]);
            
            return redirect()->route('config.view')->with(['message' => 'Usuario actualizado']);
    }

    // Metodo para mostrar la imagen que he subido antes
    public function getImage($filename)
    {
        // Uso el método response() del disk 'users' porque:
        // - Gestiona automáticamente si el archivo existe o no (lanza 404 si falla)
        // - Devuelve el archivo como respuesta HTTP válida
        // - Añade automáticamente el header Content-Type (image/jpeg, image/png, etc.)
        // - Usa streaming interno (más eficiente en archivos grandes)
        // - Evita tener que manejar manualmente get(), mimeType() y Response()

        return Storage::disk('users')->response($filename);
    }

    public function deleteUser($id) {
        $user = Auth::user();

        // Verificar que el usuario solo puede eliminarse a sí mismo
        if ($user->id != $id) {
            return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción.');
        }

        // Cerrar sesión antes de eliminar
        Auth::logout();

        // Eliminar usuario (comments, likes, images, etc. se borran en cascada)
        $user->delete();

        return redirect()->route('login')->with('success', 'Tu cuenta ha sido eliminada correctamente.');
        }
}