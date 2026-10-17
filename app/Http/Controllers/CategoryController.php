<?php

namespace App\Http\Controllers;

use App\Models\Categoria;

class CategoryController extends Controller
{
    public function index()
    {
        $categorias = Categoria::activas()
            ->withCount('recetasPublicas')
            ->get();

        return view('admin.categories', compact('categorias'));
    }
}