<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($category)
    {
        // Pobierz usługi z wybranej kategorii
        $services = Service::where('category', $category)->get();

        // Zwróć widok z usługami i nazwą kategorii
        return view('categories.show', compact('services', 'category'));
    }
}
