<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Company;
use App\Models\Provider;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Query\Builder;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard');
    }

    public function statistics(): View
    {
        return view('admin.stat');
    }

    public function stat1(): View
    {
        $totalUsers = User::count();
        $providersCount = User::where('role', 'provider')->count();
        $clientsCount = User::where('role', 'client')->count();
        $blockedUsers = User::where('status', 'blocked')->count();
        $activeUsers = User::where('status', 'active')->count();
        $unverifiedUsers = User::where('is_validated', 0)->where('role', 'provider')->count();

        return view('admin.stat1', compact(
            'totalUsers',
            'providersCount',
            'clientsCount',
            'blockedUsers',
            'activeUsers',
            'unverifiedUsers'
        ));
    }

    public function stat2(): View
    {
        $fryzjerCount = Service::where('category', 'Fryzjer')->count();
        $paznokcieCount = Service::where('category', 'Paznokcie')->count();
        $masazCount = Service::where('category', 'Masaż')->count();
        $depilacjaCount = Service::where('category', 'Depilacja')->count();
        $brwirzesyCount = Service::where('category', 'Brwi/Rzęsy')->count();
        $wszystkieUslugi = Service::/*all()->*/count();

        return view('admin.stat2', compact(
            'fryzjerCount',
            'paznokcieCount',
            'masazCount',
            'depilacjaCount',
            'brwirzesyCount',
            'wszystkieUslugi'
        ));
    }
    public function stat3(): View
    {
        $lowestServicePrice = Service::min('price');
        $highiesServicePrice = Service::max('price');
        $averageServicePrice = round(Service::avg('price'), 2);
        $minDuration = Service::min('duration');
        $maxDuration = Service::max('duration');
        $meanDuration = round(Service::avg('duration'), 0);

        return view('admin.stat3', compact(
            'lowestServicePrice',
            'highiesServicePrice',
            'averageServicePrice',
            'minDuration',
            'maxDuration',
            'meanDuration',
        ));
    }

    public function listProviders(): View
    {
        $providers = DB::table('users')
            ->select('id', 'name', 'email', 'status')
            ->where('role', 'provider')
            ->where('is_validated', 1)
            ->get();

        return view('admin.providers', compact('providers'));
    }

    public function blockProvider(int $id): RedirectResponse
    {
        $provider = DB::table('users')->where('id', $id)->where('role', 'provider')->first();

        if ($provider) {
            DB::table('users')->where('id', $id)->update(['status' => 'blocked']);
            return redirect()->route('admin.providers')->with('success', 'Konto usługodawcy zostało zablokowane.');
        }

        return redirect()->route('admin.providers')->with('error', 'Nie znaleziono usługodawcy.');
    }

    public function activeProvider(int $id): RedirectResponse
    {
        $provider = DB::table('users')->where('id', $id)->where('role', 'provider')->first();

        if ($provider) {
            DB::table('users')->where('id', $id)->update(['status' => 'active']);
            return redirect()->route('admin.providers')->with('success', 'Konto usługodawcy zostało odblokowane.');
        }

        return redirect()->route('admin.providers')->with('error', 'Nie znaleziono usługodawcy.');
    }

    public function deleteProvider(int $id): RedirectResponse
    {
        $provider = DB::table('users')->where('id', $id)->where('role', 'provider')->first();

        if ($provider) {
            DB::table('users')->where('id', $id)->delete();
            return redirect()->route('admin.providers')->with('success', 'Konto usługodawcy zostało usunięte.');
        }

        return redirect()->route('admin.providers')->with('error', 'Nie znaleziono usługodawcy.');
    }

    public function listClients(): View
    {
        $clients = DB::table('users')
            ->select('id', 'name', 'email', 'status')
            ->where('role', 'client')
            ->get();

        return view('admin.clients', compact('clients'));
    }

    public function blockClient(int $id): RedirectResponse
    {
        $client = DB::table('users')->where('id', $id)->where('role', 'client')->first();

        if ($client) {
            DB::table('users')->where('id', $id)->update(['status' => 'blocked']);
            return redirect()->route('admin.clients')->with('success', 'Konto klienta zostało zablokowane.');
        }

        return redirect()->route('admin.clients')->with('error', 'Nie znaleziono klienta.');
    }

    public function activeClient(int $id): RedirectResponse
    {
        $client = DB::table('users')->where('id', $id)->where('role', 'client')->first();

        if ($client) {
            DB::table('users')->where('id', $id)->update(['status' => 'active']);
            return redirect()->route('admin.clients')->with('success', 'Konto klienta zostało odblokowane.');
        }

        return redirect()->route('admin.clients')->with('error', 'Nie znaleziono klienta.');
    }

    public function deleteClient(int $id): RedirectResponse
    {
        $client = DB::table('users')->where('id', $id)->where('role', 'client')->first();

        if ($client) {
            DB::table('users')->where('id', $id)->delete();
            return redirect()->route('admin.clients')->with('success', 'Konto klienta zostało usunięte.');
        }

        return redirect()->route('admin.clients')->with('error', 'Nie znaleziono klienta.');
    }

    public function unverifiedProviders(): View
    {
        $providers = DB::table('users')
            ->select('id', 'name', 'email', 'is_validated')
            ->where('role', 'provider')
            ->where('is_validated', false)
            ->get();

        return view('admin.unverified-providers', compact('providers'));
    }

    public function verifyProvider(int $id): RedirectResponse
    {
        $provider = DB::table('users')
            ->where('id', $id)
            ->where('role', 'provider')
            ->where('is_validated', false)
            ->first();

        if (!$provider) {
            return redirect()->route('admin.unverified-providers')->with('error', 'Nie znaleziono użytkownika lub jest już zweryfikowany.');
        }

        DB::table('users')->where('id', $id)->update(['is_validated' => true]);

        return redirect()->route('admin.unverified-providers')->with('success', 'Usługodawca został zweryfikowany.');
    }

    public function searchFilter(Request $request): View
    {
        $query = DB::table('users')->where('role', 'client');

        // Filtruj po imieniu lub e-mailu
        if ($request->filled('search') && is_string($request->input('search'))) {
            $searchTerm = $request->input('search');
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filtruj po statusie
        if ($request->filled('status') && is_string($request->input('status'))) {
            $query->where('status', $request->input('status'));
        }

        // Sortuj wyniki
        if ($request->filled('sortBy') && $request->filled('sortOrder')) {
            $sortBy = $request->input('sortBy');
            $sortOrder = $request->input('sortOrder');

            if (
                is_string($sortBy) &&
                is_string($sortOrder) &&
                in_array($sortBy, ['name', 'email'], true) &&
                in_array($sortOrder, ['asc', 'desc'], true)
            ) {
                $query->orderBy($sortBy, $sortOrder);
            }
        }

        $clients = $query->get();

        return view('admin.clients', compact('clients'));
    }

    public function show($providerId)
    {
        // Pobierz dane firmy na podstawie user_id
        $company = Company::where('user_id', $providerId)->first();

        return view('admin.only_company_info', compact('company'));
    }

    public function showServices($providerId): View
    {
        $services = Service::where('providerID', $providerId)->get();
        return view('admin.service_list', compact('services'));
    }
    public function deleteService(Service $service): RedirectResponse
    {
        //$this->authorize('delete', $service);
        $service->delete();
        return redirect()->route('admin.providers')->with('success', 'Service deleted successfully');
    }

    public function searchFilterP(Request $request): View
    {
        $query = DB::table('users')->where('role', 'provider');

        // Filtruj po imieniu lub e-mailu
        if ($request->filled('search') && is_string($request->input('search'))) {
            $searchTerm = $request->input('search');
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filtruj po statusie
        if ($request->filled('status') && is_string($request->input('status'))) {
            $query->where('status', $request->input('status'));
        }

        // Sortuj wyniki
        if ($request->filled('sortBy') && $request->filled('sortOrder')) {
            $sortBy = $request->input('sortBy');
            $sortOrder = $request->input('sortOrder');

            if (
                is_string($sortBy) &&
                is_string($sortOrder) &&
                in_array($sortBy, ['name', 'email'], true) &&
                in_array($sortOrder, ['asc', 'desc'], true)
            ) {
                $query->orderBy($sortBy, $sortOrder);
            }
        }

        $providers = $query->get();

        return view('admin.providers', compact('providers'));
    }
}
