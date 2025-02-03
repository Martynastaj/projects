<?php

namespace TestsCodeception\Acceptance;

use TestsCodeception\Support\AcceptanceTester;

class Test06_ProviderTwojeUslugiCest
{
    public function testServicesForOla(AcceptanceTester $I): void
    {
        // Logowanie jako 'ola'
        $I->amOnPage('/login');
        $I->fillField('email', 'o@wp.pl'); // Dane logowania Oli
        $I->fillField('password', 'secret12'); // Przykładowe hasło
        $I->click('Zaloguj');

        // Sprawdzenie komunikatu o braku weryfikacji
        $I->waitForText('Twoje konto musi zostać zweryfikowane przez administratora.', 5);
        $I->see('Twoje konto musi zostać zweryfikowane przez administratora.');

        // Wylogowanie Oli przez menu rozwijane
        $I->click('ola');
        $I->waitForText('Wyloguj się', 5); // Poczekaj, aż "Wyloguj się" będzie widoczne
        $I->click('Wyloguj się'); // Kliknij "Wyloguj się"

        // Logowanie jako administrator
        $I->amOnPage('/login');
        $I->AdminlogIn(); // Użycie metody logowania administratora
        $I->see('Strona Admina');

        // Przejście do zakładki "Nowe walidacje"
        // Przejście do zakładki "Nowe walidacje"
        $I->click('Sprawdź weryfikacje');
        $I->see('NOWE WERYFIKACJE');
        $I->see('ola'); // Sprawdzenie, czy "ola" jest w tabeli
        $I->click('//tr[td[contains(text(), "ola")]]//button[contains(text(), "Weryfikuj użytkownika")]'); // Kliknij weryfikację użytkownika "ola"
        //$I->see('Użytkownik został zweryfikowany.');

        // Wylogowanie administratora przez menu rozwijane
        $I->click('martyna');
        $I->waitForText('Wyloguj się', 5); // Poczekaj, aż "Wyloguj się" będzie widoczne
        $I->click('Wyloguj się'); // Kliknij "Wyloguj się"

        $I->see('Zaloguj się'); // Upewnij się, że przycisk "Zaloguj się" jest widoczny
        $I->click('Zaloguj się');

        // Ponowne logowanie jako Ola
        $I->amOnPage('/login');
        $I->fillField('email', 'o@wp.pl');
        $I->fillField('password', 'secret12');
        $I->click('Zaloguj');

        // Przejście do dashboardu usługodawcy
        $I->see('Strona Usługodawcy');
        $I->see('Twoje Usługi');
        $I->see('Zobacz swoje usługi');
        $I->see('Kalendarz');
        $I->see('Zarządzaj kalendarzem');
        $I->see('Informacje o Firmie');
        $I->see('Edytuj informacje');

        // Przejście do sekcji "Twoje Usługi"
        $I->click('Zobacz swoje usługi');
        $I->see('Lista Twoich Usług');

        // Sprawdzanie listy usług dla Oli
        $I->see('Lista Twoich Usług');
        $I->see('Manicure');
        $I->see('45');
        $I->see('100.00');
        $I->see('Pedicure');
        $I->see('60');
        $I->see('150.00');

        // Edycja usługi "Manicure"
        $I->click('Edytuj', '//tr[td[contains(text(), "Manicure")]]');
        $I->see('Edytuj usługę');
        $I->fillField('name', 'Manicure deluxe');
        $I->fillField('price', '120.00');
        $I->click('Zaktualizuj');
        //$I->see('Service updated successfully');
        //$I->see('Manicure deluxe');
        //$I->see('120.00');

        // Przejście do dashboardu usługodawcy
        $I->see('Strona Usługodawcy'); // Sprawdź, czy dashboard usługodawcy się załadował
        $I->see('Twoje Usługi'); // Sprawdź, czy sekcja "Twoje Usługi" istnieje
        $I->see('Zobacz swoje usługi'); // Przycisk "Zobacz swoje usługi"
        $I->see('Kalendarz'); // Sprawdź, czy sekcja "Kalendarz" istnieje
        $I->see('Zarządzaj kalendarzem'); // Przycisk "Zarządzaj kalendarzem"
        $I->see('Informacje o Firmie'); // Sprawdź, czy sekcja "Informacje o Firmie" istnieje
        $I->see('Edytuj informacje'); // Przycisk "Edytuj informacje"

        // Przejście do sekcji "Twoje Usługi"
        $I->click('Zobacz swoje usługi');
        $I->see('Lista Twoich Usług');

        // Sprawdzanie listy usług dla Oli
        $I->see('Lista Twoich Usług');
        $I->see('Manicure deluxe');
        $I->see('45');
        $I->see('120.00');
        $I->see('Pedicure');
        $I->see('60');
        $I->see('150.00');

        // Dodanie nowej usługi
        $I->click('Dodaj nową usługę');
        $I->see('Dodaj nową usługę');
        $I->fillField('name', 'Przedłużanie żelowe');
        $I->fillField('duration', '150');
        $I->fillField('price', '200.00');
        $I->click('Dodaj');
        //$I->see('Service added successfully');
        //$I->see('Nowa usługa Oli');
        //$I->see('50');

        // Przejście do dashboardu usługodawcy
        $I->see('Strona Usługodawcy'); // Sprawdź, czy dashboard usługodawcy się załadował
        $I->see('Twoje Usługi'); // Sprawdź, czy sekcja "Twoje Usługi" istnieje
        $I->see('Zobacz swoje usługi'); // Przycisk "Zobacz swoje usługi"
        $I->see('Kalendarz'); // Sprawdź, czy sekcja "Kalendarz" istnieje
        $I->see('Zarządzaj kalendarzem'); // Przycisk "Zarządzaj kalendarzem"
        $I->see('Informacje o Firmie'); // Sprawdź, czy sekcja "Informacje o Firmie" istnieje
        $I->see('Edytuj informacje'); // Przycisk "Edytuj informacje"

        // Przejście do sekcji "Twoje Usługi"
        $I->click('Zobacz swoje usługi');
        $I->see('Lista Twoich Usług');

        // Sprawdzanie listy usług dla Oli
        $I->see('Lista Twoich Usług');
        $I->see('Manicure deluxe');
        $I->see('45');
        $I->see('120.00');
        $I->see('Pedicure');
        $I->see('60');
        $I->see('150.00');
        $I->see('Przedłużanie żelowe');
        $I->see('150');
        $I->see('200.00');

        // Usunięcie usługi
        $I->click('Usuń', '//tr[td[contains(text(), "Przedłużanie żelowe")]]');
        $I->acceptPopup();
        //$I->see('Service deleted successfully');
        //$I->dontSee('Nowa usługa Oli');
        // Przejście do dashboardu usługodawcy
        $I->see('Strona Usługodawcy'); // Sprawdź, czy dashboard usługodawcy się załadował
        $I->see('Twoje Usługi'); // Sprawdź, czy sekcja "Twoje Usługi" istnieje
        $I->see('Zobacz swoje usługi'); // Przycisk "Zobacz swoje usługi"
        $I->see('Kalendarz'); // Sprawdź, czy sekcja "Kalendarz" istnieje
        $I->see('Zarządzaj kalendarzem'); // Przycisk "Zarządzaj kalendarzem"
        $I->see('Informacje o Firmie'); // Sprawdź, czy sekcja "Informacje o Firmie" istnieje
        $I->see('Edytuj informacje'); // Przycisk "Edytuj informacje"

        // Przejście do sekcji "Twoje Usługi"
        $I->click('Zobacz swoje usługi');
        $I->see('Lista Twoich Usług');

        // Sprawdzanie listy usług dla Oli
        $I->see('Lista Twoich Usług');
        $I->see('Manicure deluxe');
        $I->see('45');
        $I->see('120.00');
        $I->see('Pedicure');
        $I->see('60');
        $I->see('150.00');
        $I->dontSee('Przedłużanie żelowe');

        $I->click('Strona Usługodawcy');
    }
}
