<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test08_CompanyInfoCest
{
    public function testCompanyInfo(AcceptanceTester $I): void
    {
        // Logowanie jako usługodawcaaa
        $I->amOnPage('/login');
        $I->fillField('email', 'ewa@wp.pl');
        $I->fillField('password', 'secret12');
        $I->click('Zaloguj');

        $I->see('Strona Usługodawcy');
        $I->see('Informacje o Firmie');
        $I->click('Edytuj informacje');

        $I->see('Informacje o Firmie');
        $I->see('Brak opisu firmy.');
        $I->see('Brak adresu');
        $I->see('Brak telefonu');
        $I->see('Brak emaila');

        $I->click('Edytuj');
        $I->see('Opis firmy');
        // Edytuj dane
        $I->fillField('description', 'Nowy opis firmy - test akceptacyjny.');
        $I->fillField('address', 'ul. Nowa 45, 00-002 Kraków');
        $I->fillField('phone', '+48 987 654 321');
        $I->fillField('email', 'testowyemail@firma.pl');
        $I->click('Zapisz zmiany');

        //$I->see('Informacje o firmie zostały zaktualizowane.');

        $I->see('Informacje o Firmie');
        $I->see('Nowy opis firmy - test akceptacyjny.');
        $I->see('Adres: ul. Nowa 45, 00-002 Kraków');
        $I->see('Telefon: +48 987 654 321');
        $I->see('Email: testowyemail@firma.pl');
    }
}
