<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// importo il model category
use App\Category;

class CategoryController extends Controller
{
    //essendo di tipo uno a molti, le categorie contengono una collection di post con tale categoria. Voglio fare una show che mi mostri tutti gli articoli con determinata categoria, e devo gestire la rotta (tramite link su index e uno show.blade)

    public function show(Category $category) {
        // 1. recuperare la Categoria con quell'id
        // $category = Category::findOrFail($id); senza injection
        
        // 2 passarla alla vista di Categoria
        return view('admin.categories.show', compact('category'));
    }
}
