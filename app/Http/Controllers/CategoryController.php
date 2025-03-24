<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.categories-table', compact('categories'));
    }

    public function store(Request $request)
    {
        //validación de estructura
        $data = $request->validate([
            'name' => 'required|string|max:225',
            'type' => 'required|string|max:225',
        ]);
        //crear categoria
        Category::create($data);

        //redirijir con un mensaje
        return redirect()->route('categories.index')->with('success', 'Agregado');
    }
    public function update(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255'
        ]);
        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Categoría actualizada correctamente');
    }

    public function delete($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Eliminado correctamente');
    }
}
