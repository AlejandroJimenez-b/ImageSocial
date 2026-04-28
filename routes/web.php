<?php

// use App\Http\Controllers\HomeController;

use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\FavoritosController;
use App\Http\Controllers\GenteController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentsController;
use Illuminate\Support\Facades\Route;
// use App\Models\Image;

Route::get('/', function () {
    /*
    $images = Image::all();

    foreach ($images as $image) {
        echo $image->image_path."<br>";
        echo $image->description."<br>";
        echo $image->user->name.' '.$image->user->surname."<br>";

        if(count($image->comments) >= 1) {
            echo "<h4>Comentarios</h4>";
            foreach ($image->comments as $comment) {
                echo $comment->user->name.' '.$comment->user->surname.'<br>';
                echo $comment->content.'<br>';
            }
        }else{
            echo "<h5>Esta imagen no tiene ningun comentario</h5>";
        }

        echo "<h4>Likes: ".count($image->likes).'</h4>'.'<hr>';
    }
    die();
    */
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grupo de rutas para la seccion del perfil (dashboard)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PerfilController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');
});


// Grupo de rutas para la seccion de gente
// get: Lleva a la vista 'gente.blade.php' desde el menu desplegable 'admin'
Route::middleware('auth')->group(function () {
    Route::get('/gente', [GenteController::class, 'index'])->name('gente.view');
    Route::get('/profile/{id}', [GenteController::class, 'profile'])->name('gente.profile');
});

// Grupo de rutas para la seccion de favoritos
// get: Lleva a la vista 'favoritos.blade.php' desde el menu desplegable 'admin'
Route::middleware('auth')->group(function () {
    Route::get('/favoritos', [FavoritosController::class, 'index'])->name('favoritos.view');
});

// Grupo de rutas para la seccion de imagenes

Route::middleware('auth')->group(function () {
    Route::get('/image/create', [ImagesController::class, 'create'])->name('images.view');
    Route::post('/image/up', [ImagesController::class, 'upImage'])->name('images.save');
    Route::get('/image/details/{id}', [ImagesController::class, 'details'])->name('images.details');
    Route::get('/image/update/{id}', [ImagesController::class, 'updateImage'])->name('images.update');
    Route::post('/image/save/update/{id}', [ImagesController::class, 'saveImageUpdate'])->name('images.updatesave');
    Route::get('/image/show/{filename}', [ImagesController::class, 'showImage'])->name('images.show');
    Route::delete('/image/delete/{id}', [ImagesController::class, 'deleteImage'])->name('images.delete');
});

// Grupo de rutas para la seccion de configuracion
// get: Lleva a la vista 'configuracion.blade.php' desde el menu desplegable 'admin'

Route::middleware('auth')->group(function () {
    Route::get('/config', [ConfiguracionController::class, 'config'])->name('config.view');
    Route::post('/config', [ConfiguracionController::class, 'update'])->name('config.update');
    Route::get('/user/avatar/{filename}', [ConfiguracionController::class, 'getImage'])->name('user.avatar');
});

// Grupo de rutas para la seccion likes en una imagen

Route::middleware('auth')->group(function () {
    Route::get('/likes/{image_id}', [LikeController::class, 'like'])->name('like.save');
    Route::get('/dislikes/{image_id}', [LikeController::class, 'dislike'])->name('like.delete');
});

// Grupo de rutas para la seccion de comentarios en una imagen
Route::middleware('auth')->group(function () {
    Route::get('/comments/{image_id}', [CommentsController::class, 'comments'])->name('comments.view');
    Route::post('/comments/{image_id}', [CommentsController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment_id}', [CommentsController::class, 'destroy'])->name('comments.destroy');
    Route::get('/comments/{image_id}/json', [CommentsController::class, 'getComments'])->name('comments.json');

});


require __DIR__.'/auth.php';
