<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test00_HomepageCest
{
    public function test(AcceptanceTester $I): void
    {
        $I->wantTo('see main page');

        $I->amOnPage('/');

        $I->seeInTitle('BooKrak');

        //$I->see('Szukaj usługi...');
        $I->see('Szukaj');

        $I->amOnPage('/');
        $I->see('Fryzjer');
        $I->see('Paznokcie');
        $I->see('Masaż');
        $I->see('Depilacja');
        $I->see('Brwi/Rzęsy');

        $I->see('O nas');
        $I->see('Jest to serwis: system rezerwacji wizyt inspirowany na Booksy');

        $I->see('Jak korzystać ze strony');
        $I->see('Nasza strona jest zaprojektowana z myślą o łatwości użytkowania.');

        $I->see('Co gdy mój profil zostanie zablokowany?');
        $I->see('Jeśli twój profil zostanie zablokowany, skontaktuj się z naszym zespołem wsparcia.');
        $I->see('BooKrak © 2025 BooKrak Inc. Wszystkie prawa zastrzeżone.');

        $I->seeLink('Zaloguj się');
        $I->seeLink('Załóż konto');

        $I->fryzjerDashboard();
        $I->paznokcieDashboard();
        $I->masazDashboard();
        $I->depilacjaDashboard();
        $I->brwiRzesyDashboard();
    }
}
