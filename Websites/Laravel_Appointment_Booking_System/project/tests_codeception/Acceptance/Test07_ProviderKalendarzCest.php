<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test07_ProviderKalendarzCest
{
    public function testKalendarzAvailability(AcceptanceTester $I): void
    {
        // Logowanie jako Ewa (usługodawca)
        $I->amOnPage('/login');
        $I->fillField('email', 'ewa@wp.pl'); // Wprowadzenie emaila
        $I->fillField('password', 'secret12'); // Wprowadzenie hasła
        $I->click('Zaloguj'); // Kliknięcie przycisku logowania

        $I->see('Strona Usługodawcy');
        $I->click('Zarządzaj kalendarzem'); // Przejście do zarządzania kalendarzem

        // Kliknięcie w dzień 31 stycznia 2025
        $I->click('//td[contains(@class, "fc-daygrid-day") and @data-date="2025-01-31"]');

        // Czekanie na pojawienie się alertu (do 10 sekund)
        $I->wait(5);

        // Wprowadzenie godzin dostępności przez Selenium
        $I->executeInSelenium(function (\Facebook\WebDriver\WebDriver $webdriver) {
            $alert = $webdriver->switchTo()->alert();
            $alert->sendKeys('10:00,13:00,13:30,14:30'); // Wprowadzenie godzin
            $alert->accept(); // Zatwierdzenie
        });

        // Ponowne oczekiwanie na potwierdzenie zapisu
        $I->wait(5);

        // Potwierdzenie alertu o zapisaniu godzin
        $I->executeInSelenium(function (\Facebook\WebDriver\WebDriver $webdriver) {
            $alert = $webdriver->switchTo()->alert();
            $alert->accept(); // Kliknięcie "OK"
        });

        // Wylogowanie użytkownika
        $I->click('//*[contains(text(), "Ewa")]');
        $I->click('#logout-button');

        // Logowanie jako klient
        $I->amOnPage('/login');
        $I->fillField('email', 'john.doe@gmail.com');
        $I->fillField('password', 'secret');
        $I->click('Zaloguj');

        $I->see('Przeglądaj Oferty');
        $I->click('Przeglądaj oferty'); // Przejście do kalendarza

        $I->see('Ewa');
        $I->click("//h2[contains(text(), 'Ewa')]/../..//a[contains(text(), 'Umów wizytę')]");

        $I->see('Rezerwacja wizyty');
        $I->fillField('date', '01/31/2025'); // Wpisanie daty w formacie MM/DD/YYYY

        // Wybór godziny
        $I->click('select#time'); // Kliknięcie w listę rozwijaną godziny
        $I->waitForElementVisible('//option[@value="13:30:00"]', 5); // Poczekanie na widoczność opcji
        $I->click('//option[@value="13:30:00"]'); // Wybór godziny "13:30"

        // Wybór usługi
        $I->click('select#service_id'); // Kliknięcie w listę rozwijaną usług
        $I->waitForElementVisible('//option[contains(text(), "Manicure hybrydowy (60 minut)")]', 5); // Poczekanie na widoczność opcji
        $I->click('//option[contains(text(), "Manicure hybrydowy (60 minut)")]'); // Wybór usługi o ID "1"

        // Kliknięcie przycisku "Zarezerwuj wizytę"
        $I->click('Zarezerwuj wizytę');

        // Sprawdzenie szczegółów wizyty
        // Kliknięcie w kafelek kalendarza oznaczony datą 31.01.2025
        $I->waitForElementVisible('//td[contains(@class, "fc-daygrid-day") and @data-date="2025-01-31"]//div[contains(@class, "fc-event-title") and text()="Manicure hybrydowy"]', 10);
        $I->click('//td[contains(@class, "fc-daygrid-day") and @data-date="2025-01-31"]//div[contains(@class, "fc-event-title") and text()="Manicure hybrydowy"]');

        $I->see('Usługa: Manicure hybrydowy');
        $I->see('Data: 2025-01-31');
        $I->see('Godzina: 13:30');

    }
}
