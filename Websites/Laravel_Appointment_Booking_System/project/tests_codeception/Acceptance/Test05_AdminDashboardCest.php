<?php

namespace TestsCodeception\Acceptance;

use Illuminate\Support\Facades\DB;
use TestsCodeception\Support\AcceptanceTester;
use App\Http\Controllers\AdminController;
use App\Models\User;

class Test05_AdminDashboardCest
{
    public function test(AcceptanceTester $I): void
    {
        // Logowanie jako administrator
        $I->amOnPage('/login');
        $I->AdminlogIn();

        $I->see('Strona Admina');

        $I->amOnPage('/admin-dashboard');
        $I->see('Sprawdź listę usługodawców');
        $I->see('Zarządzaj usługodawcami w systemie.');
        $I->seeLink('Zobacz usługodawców');
        $I->click('Zobacz usługodawców');
        $I->waitForText('LISTA USŁUGODAWCÓW'); // Zakładając, że po kliknięciu przechodzimy na stronę listy usługodawców

        // Sprawdzanie wyszukiwania po imieniu
        $I->findByName();
        $I->click('Zablokuj');
        $I->seeInDatabase('users', [
            'name' => 'jakub',
           'status' => 'blocked'
        ]);
        // Sprawdzanie sortowania
        $I->sortByName();

        // Resetowanie
        $I->click('Resetuj');

        // Sprawdzanie wyszukiwania aktywnych uzytkownikow
        $I->findUserStatus();
        $I->click('Usługi');
        $I->amOnPage('/admin-dashboard');
        $I->see('Sprawdź listę klientów');
        $I->see('Zarządzaj klientami w systemie.');
        $I->seeLink('Zobacz klientów');
        $I->click('Zobacz klientów');
        $I->waitForText('LISTA KLIENTÓW'); // Zakładając, że po kliknięciu przechodzimy na stronę listy usługodawców

        $I->sortByName();

        $I->amOnPage('/admin-dashboard');
        $I->see('Nowe walidacje');
        $I->see('Zobacz i weryfikuj nowych usługodawców.');
        $I->seeLink('Sprawdź weryfikacje');
        $I->click('Sprawdź weryfikacje');

        $I->verifyProvider();
        $I->statisticsAdmin();

        $I->click('BooKrak');
        $I->click('martyna');
        $I->click('Profil');
        $I->dontSee('Usuń Konto');
    }
}
