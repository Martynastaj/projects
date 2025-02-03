<?php

declare(strict_types=1);

namespace TestsCodeception\Support;

use Codeception\Actor;

/**
 * Inherited Methods
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     */

    public function register(): void
    {
        $this->seeCurrentUrlEquals('/register');
        $this->fillField('name', 'Asia');
        $this->fillField('email', 'asia@wp.pl');
        $this->selectOption('role', 'provider');
        $this->fillField('password', 'secret12');
        $this->fillField('password_confirmation', 'secret12');
        $this->waitForNextPage(fn () => $this->click('Zarejestruj się'));
    }

    public function logIn(): void
    {
        $this->seeCurrentUrlEquals('/login');
        $this->fillField('email', 'john.doe@gmail.com');
        $this->fillField('password', 'secret');
        $this->waitForNextPage(fn () => $this->click('Zaloguj'));
    }

    public function AdminlogIn(): void
    {
        $this->seeCurrentUrlEquals('/login');
        $this->fillField('email', 'm@wp.pl');
        $this->fillField('password', 'secret12');
        $this->waitForNextPage(fn () => $this->click('Zaloguj'));
    }

    public function findByName(): void
    {
        $this->seeElement('input[name="search"]');
        $this->fillField('input[name="search"]', 'jakub', 'string');
        $this->click('Szukaj');
        $this->see('jakub');
    }

    public function sortByName(): void
    {
        $this->seeElement('a[href*="sortBy=name"]');
        $this->click('Imię');

    }

    public function findUserStatus(): void
    {
        $this->selectOption('select[name="status"]', 'active');
        $this->click('Szukaj');
        $this->see('Aktywny');
        $this->dontSee('Zablokowany');

        $this->see('Zablokuj');
        $this->click('Aktywuj');
        $this->see('Aktywny');

        $this->click('Zablokuj');
        $this->see('Zablokowany');

        $this->click('Usuń');
        $this->acceptPopup();
        $this->dontSee('jakub');
    }

    public function statisticsAdmin(): void
    {
        $this->click('Statystyki');
        $this->see('Sprawdź statystyki użytkowników');
        $this->see('Sprawdź statystyki usług');
        $this->see('Zobacz ceny i czasy trwania usług');

        $this->click('Sprawdź statystyki użytkowników');
        $this->see('STATYSTYKI UŻYTKOWNIKÓW');
        $this->see('Liczba użytkowników');
        $this->see('Liczba usługodawców');
        $this->see('Liczba klientów');
        $this->see('Liczba aktywnych kont');
        $this->see('Liczba zawieszonych kont');

        $this->amOnPage('/statistics');
        $this->click('Sprawdź statystyki usług');
        $this->see('Fryzjer');
        $this->see('Paznokcie');
        $this->see('Mazaż');
        $this->see('Depilacja');
        $this->see('Brwi / Rzęsy');
        $this->see('Wszystkie usługi');

        $this->amOnPage('/statistics');
        $this->click('Zobacz ceny i czasy trwania usług');
        $this->see('Najniższa cena usługi');
        $this->see('Najwyższa cena usługi');
        $this->see('Średnia cena usługi');
        $this->see('Najkrótszy czas trwania usługi');
        $this->see('Najdłuższy czas trwania usługi');
        $this->see('Średni czas trwania usługi');
    }

    public function verifyProvider(): void
    {
        $this->seeCurrentUrlEquals('/admin/unverified-providers');
        $this->see('NOWE WERYFIKACJE');
        $this->see('Imię');
        $this->see('Email');
        $this->see('Akcje');
        $this->see('ola');
        $this->see('Weryfikuj użytkownika');
        $this->see('Wyświetl informacje');
        $this->click('Wyświetl informacje');
        $this->see('Informacje o Firmie');
        $this->see('Opis firmy:');
        $this->see('Dane kontaktowe:');
    }
    public function waitForNextPage(callable $action): void
    {
        if (method_exists($this, 'waitForJS')) {
            $this->waitForJS('return document.oldPage = "yes"');
        }
        $action();

        if (method_exists($this, 'waitForJS')) {
            $this->waitForJS('return document.oldPage !== "yes"');
        }
    }

    public function testProfileUpdate(): void
    {
        $newName = 'Alicja';
        $newEmail = 'ala@wp.pl';

        $this->fillField('name', $newName);
        $this->fillField('email', $newEmail);
        $this->click('Zapisz');
        $this->seeInDatabase('users', ['name' => $newName, 'email' => $newEmail]);  // Sprawdź, czy dane zostały zapisane w bazie
    }

    public function emptyProfileUpdate(): void
    {
        $this->fillField('name', '');
        $this->fillField('email', '');
        $this->click('Zapisz');
    }

    public function testPasswordUpdate(): void
    {
        $newPassword = 'noweHaslo';
        $this->fillField('current_password', 'secret12');
        $this->fillField('password', $newPassword);
        $this->fillField('password_confirmation', $newPassword);
        $this->click('Zapisz');  // Kliknij przycisk "Zapisz"

    }

    public function deleteAccount(): void
    {
        $this->click('Usuń Konto');
        $this->click('Anuluj');

        $this->seeInDatabase('users', [
            'name' => 'Alicja',
            'email' => 'ala@wp.pl',
            'role' => 'provider',
        ]);

        // Ensure the "Usuń Konto" button is visible
        $this->see('Usuń Konto');

        // Click the "Usuń Konto" button
        $this->click('Usuń Konto');
        $this->fillField('#password', 'secret12');
        $this->waitForElementClickable('.ms-3', 5); // Klasa "ms-3" odpowiada przyciskowi finalnego usunięcia
        $this->click('.ms-3');

        $this->seeInCurrentUrl('/');
        $this->reloadPage();

        $this->dontSeeInDatabase('users', [
            'name' => 'Alicja',
            'email' => 'ala@wp.pl',
            'role' => 'provider',
        ]);
    }

    public function editCompanyInfo(): void
    {
        $this->click('Edytuj informacje');
        $this->see('Informacje o Firmie');
        $this->see('Edytuj');
        $this->click('Edytuj');
        $this->see('Opis firmy:');
        $this->fillField('description', 'Moja firma zajmuje się ..');
        $this->fillField('address', 'Kraków ul. Przykładowa 123');
        $this->fillField('phone', 123123456);
        $this->fillField('email', 'ala@wp.pl');
        $this->click('Zapisz zmiany');

        $this->seeInDatabase('companies', [
            'description' => 'Moja firma zajmuje się ..',
            'address' => 'Kraków ul. Przykładowa 123',
            'phone' => '123123456',
            'email' => 'ala@wp.pl',
        ]);
    }
    public function fryzjerDashboard(): void
    {
        $this->amOnPage('/');
        $this->click('Fryzjer');
        $this->seeCurrentUrlEquals('/services?category=Fryzjer');
        $this->see('Lista salonów w kategorii: Fryzjer');
        $this->selectOption('category', 'Paznokcie');
        $this->click('Filtruj');

        $this->see('Umów wizytę', '.bg-gray-500'); // Przycisk dla niezalogowanego użytkownika
        $this->dontSee('Umów wizytę', '.bg-blue-500'); // Przycisk dla zalogowanego użytkownika

        $this->click('Umów wizytę'); // Przycisk rezerwacji
        $this->see('Nie jesteś zalogowany!', '#not-logged-in-modal');
        $this->click('Anuluj');
        $this->dontSee('#not-logged-in-modal');
    }

    public function paznokcieDashboard(): void
    {
        $this->amOnPage('/');
        $this->click('Paznokcie');
        $this->seeCurrentUrlEquals('/services?category=Paznokcie');
        $this->see('Lista salonów w kategorii: Paznokcie');
        $this->selectOption('category', 'Fryzjer');
        $this->click('Filtruj');

        $this->see('Umów wizytę', '.bg-gray-500'); // Przycisk dla niezalogowanego użytkownika
        $this->dontSee('Umów wizytę', '.bg-blue-500'); // Przycisk dla zalogowanego użytkownika

        $this->click('Umów wizytę'); // Przycisk rezerwacji
        $this->see('Nie jesteś zalogowany!', '#not-logged-in-modal');
        $this->click('Anuluj');
        $this->dontSee('#not-logged-in-modal');
    }
    public function masazDashboard(): void
    {
        $this->amOnPage('/');
        $this->click('Masaż');
        $this->seeCurrentUrlEquals('/services?category=Masa%C5%BC');
        $this->see('Lista salonów w kategorii: Masaż');
        $this->selectOption('category', 'Brwi/Rzęsy');
        $this->click('Filtruj');

        $this->see('Umów wizytę', '.bg-gray-500'); // Przycisk dla niezalogowanego użytkownika
        $this->dontSee('Umów wizytę', '.bg-blue-500'); // Przycisk dla zalogowanego użytkownika

        $this->click('Umów wizytę'); // Przycisk rezerwacji
        $this->see('Nie jesteś zalogowany!', '#not-logged-in-modal');
        $this->click('Anuluj');
        $this->dontSee('#not-logged-in-modal');
    }

    public function depilacjaDashboard(): void
    {
        $this->amOnPage('/');
        $this->click('Depilacja');
        $this->seeCurrentUrlEquals('/services?category=Depilacja');
        $this->see('Lista salonów w kategorii: Depilacja');
        $this->selectOption('category', 'Paznokcie');
        $this->click('Filtruj');

        $this->see('Umów wizytę', '.bg-gray-500'); // Przycisk dla niezalogowanego użytkownika
        $this->dontSee('Umów wizytę', '.bg-blue-500'); // Przycisk dla zalogowanego użytkownika

        $this->click('Umów wizytę'); // Przycisk rezerwacji
        $this->see('Nie jesteś zalogowany!', '#not-logged-in-modal');
        $this->click('Anuluj');
        $this->dontSee('#not-logged-in-modal');
    }

    public function brwiRzesyDashboard(): void
    {
        $this->amOnPage('/');
        $this->click('Brwi/Rzęsy');
        $this->seeCurrentUrlEquals('/services?category=Brwi%2FRz%C4%99sy');
        $this->see('Lista salonów w kategorii: Brwi/Rzęsy');
        $this->selectOption('category', 'Paznokcie');
        $this->click('Filtruj');

        $this->see('Umów wizytę', '.bg-gray-500'); // Przycisk dla niezalogowanego użytkownika
        $this->dontSee('Umów wizytę', '.bg-blue-500'); // Przycisk dla zalogowanego użytkownika

        $this->click('Umów wizytę'); // Przycisk rezerwacji
        $this->see('Nie jesteś zalogowany!', '#not-logged-in-modal');
    }
}
