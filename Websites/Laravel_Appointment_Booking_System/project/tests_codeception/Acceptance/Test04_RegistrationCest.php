<?php

namespace TestsCodeception\Acceptance;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use TestsCodeception\Support\AcceptanceTester;
use App\Http\Controllers\AdminController;

class Test04_RegistrationCest
{
    public function test(AcceptanceTester $I): void
    {
        $I->amOnPage('/register');

        $I->register();

        $I->seeInDatabase('users', [
            'name' => 'Asia',
            'email' => 'asia@wp.pl',
            'role' => 'provider',
        ]);

        $I->see('Twoje konto musi zostać zweryfikowane przez administratora.');
        $I->see('BooKrak');
        $I->click('BooKrak');
        $I->see('Twoje konto musi zostać zweryfikowane przez administratora.');
        $I->see('Informacje o Firmie');
        $I->editCompanyInfo();
        $I->see('Asia');
        $I->click('Asia');
        $I->see('Profil');
        $I->click('Profil');

        $I->see('Informacje o profilu');

        $I->emptyProfileUpdate();
        //  $I->see('Please fill out this field.');
        $I->dontSeeInDatabase('users', [
            'name' => '',
            'email' => '',
            'role' => 'provider',
        ]);

        $I->testProfileUpdate();
        $I->waitForText('Zapisano');

        $I->seeInDatabase('users', [
            'name' => 'Alicja',
            'email' => 'ala@wp.pl',
            'role' => 'provider',
        ]);

        $I->see('Zaktualizuj swoje hasło');
        $I->testPasswordUpdate();
        $I->waitForText('Zapisano');

        $I->seeInDatabase('users', [
            'name' => 'Alicja',
            'email' => 'ala@wp.pl',
            'role' => 'provider',
        ]);

        $I->see('Usuń Konto');
        $I->see('Po usunięciu konta wszystkie jego zasoby i dane zostaną trwale usunięte.');
        $I->deleteAccount();
    }
}
