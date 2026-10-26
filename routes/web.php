<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/scan', [FoodController::class, 'scan'])->name('scan');
Route::get('/planes', [App\Http\Controllers\PlanController::class, 'index'])->name('planes.index');


// ============ AUTH ============
// Ruta GET "login" que Laravel usa internamente para redirigir a no autenticados
Route::get('/login', function () {
    return redirect()->route('home')->with('open_login_modal', true);
})->name('login');



Route::get('/auth/google/redirect', [SocialLoginController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [SocialLoginController::class, 'callback']);

// Rutas POST de autenticación (renombradas para evitar conflicto)
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ============ AUTENTICADAS ============
Route::middleware('auth')->group(function () {

    // Análisis con IA
    Route::post('/analyze', [FoodController::class, 'analyze'])->name('analyze');

    // Mis recetas / historial
    Route::get('/mi-historial', [RecipeController::class, 'myHistory'])->name('my.history');
    Route::get('/receta/{receta}', [RecipeController::class, 'show'])->name('recipe.show');
    Route::get('/receta/{receta}/editar', [RecipeController::class, 'edit'])->name('recipe.edit');
    Route::put('/receta/{receta}', [RecipeController::class, 'update'])->name('recipe.update');
    Route::delete('/receta/{receta}', [RecipeController::class, 'destroy'])->name('recipe.destroy');
    Route::post('/receta/{receta}/publicar', [RecipeController::class, 'togglePublic'])->name('recipe.publish');
    Route::post('/receta/{receta}/favorita', [RecipeController::class, 'toggleFavorite'])->name('recipe.favorite');

    // Favoritos
    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/receta/{receta}/favorito', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Compartir
    Route::post('/receta/{receta}/compartir', [ShareController::class, 'store'])->name('shares.store');
    Route::get('/compartidos', [ShareController::class, 'index'])->name('shares.index');

    // Foro
    Route::get('/foro', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/foro/{categoria:slug}', [ForumController::class, 'category'])->name('forum.category');

    // Likes
    Route::post('/receta/{receta}/like', [LikeController::class, 'toggle'])->name('likes.toggle');
    Route::put('/perfil', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
        // Planes y Suscripciones
    Route::post('/planes/checkout', [App\Http\Controllers\PlanController::class, 'checkout'])->name('planes.checkout');
        // Comentarios
    Route::post('/receta/{receta}/comentario', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comentario/{comentario}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
    });

// ============ LINK PÚBLICO DE COMPARTIDO ============
Route::get('/compartido/{token}', [ShareController::class, 'showByToken'])->name('shares.show');