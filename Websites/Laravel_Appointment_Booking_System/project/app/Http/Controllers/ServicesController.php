<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServicesController extends Controller
{
    /**
     * Wyświetl listę usług z możliwością filtrowania po kategorii.
     */
    public function index(Request $request)
    {
        $category = $request->get('category'); // Pobierz kategorię z zapytania
        $search = $request->get('search'); // Pobierz wartość z paska wyszukiwania

        // Bazowe zapytanie
        $query = Service::with('provider');

        // Filtruj po kategorii, jeśli została podana
        if ($category) {
            $query->where('category', $category);
        }

        // Przeszukuj po nazwie salonu (usługodawcy) lub kategorii
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('provider', function ($providerQuery) use ($search) {
                    $providerQuery->where('name', 'LIKE', "%$search%");
                })
                    ->orWhere('category', 'LIKE', "%$search%");
            });
        }

        // Pobierz wyniki
        $services = $query->with('provider')->get();

        return view('services.index', compact('services', 'category', 'search'));
    }





}
