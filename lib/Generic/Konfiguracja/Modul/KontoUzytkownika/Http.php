<?php
namespace Generic\Konfiguracja\Modul\KontoUzytkownika;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['emailAktywacyjny.id_formatki_email']
 * @property array $k['emailAktywacyjny.wymagane_pola']
 * @property string $k['formularz.walidacja_hasla']
 * @property array $k['formularz.wymagane_pola']
 * @property bool $k['glowna.link_ogloszenia']
 * @property bool $k['glowna.link_platnosci']
 * @property bool $k['glowna.link_podglad']
 * @property bool $k['glowna.link_wiadomosci']
 * @property bool $k['glowna.link_wizytowki']
 * @property int $k['przypomnij.id_formatki_email']
 * @property array $k['przypomnij.wymagane_pola']
 * @property string $k['szablon.formularz']
 * @property string $k['szablon.formularz_konto_uzytkownika']
 * @property int $k['zaloguj.czas_blokowania']
 * @property int $k['zaloguj.nieudane_proby']
 * @property bool $k['zaloguj.ponowne_przeslanie_aktywacji']
 * @property array $k['zaloguj.wymagane_pola']
 * @property array $k['zmienEmail.wymagane_pola']
 * @property array $k['zmienHaslo.wymagane_pola']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'emailAktywacyjny.id_formatki_email' => array(
		'opis' => '',
		'typ' => 'mail',
		'wartosc' => 34,
		),

	'emailAktywacyjny.wymagane_pola' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			),
		),

	'formularz.walidacja_hasla' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '/(?!^[a-z]*$)(?!^[A-Z]*$)(?!^[0-9]*$)^([^\s]{6,20})$/',
		),

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'imie',
			'nazwisko',
			'plec',
			),
		),

	'glowna.link_ogloszenia' => array(
		'opis' => 'Wyświetlać link do edycji ogłoszeń',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'glowna.link_platnosci' => array(
		'opis' => 'Wyświetlać link do płatnosci',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'glowna.link_podglad' => array(
		'opis' => 'Wyświetlać link do podglądu wizytówki',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'glowna.link_wiadomosci' => array(
		'opis' => 'Wyświetlać link do edycji wiadomości',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'glowna.link_wizytowki' => array(
		'opis' => 'Wyświetlać link do edycji wizytówki',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'przypomnij.id_formatki_email' => array(
		'opis' => '',
		'typ' => 'mail',
		'wartosc' => 52,
		),

	'przypomnij.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'login',
			'email',
			),
		),

	'szablon.formularz' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_rejestracja.tpl',
		),

	'szablon.formularz_konto_uzytkownika' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_konto_uzytkownika_nowe_mini.tpl',
		),

	'zaloguj.czas_blokowania' => array(
		'maks' => '100',
		'opis' => 'Czas (w minutach) na jaki należy zablokować formularz po nieudanym logowaniu',
		'typ' => 'int',
		'wartosc' => 2,
		),

	'zaloguj.nieudane_proby' => array(
		'maks' => '100',
		'opis' => 'Ilość nieudanych prób logowania przed blokowaniem formularza',
		'typ' => 'int',
		'wartosc' => 3,
		),

	'zaloguj.ponowne_przeslanie_aktywacji' => array(
		'opis' => 'Umożlwia ponowne przesłanie linku aktywacyjnego',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'zaloguj.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'login',
			'haslo',
			),
		),

	'zmienEmail.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'haslo',
			'hasloPowtorz',
			'email',
			'emailPowtorz',
			),
		),

	'zmienHaslo.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'haslo',
			'hasloPowtorz',
			'noweHaslo',
			'noweHasloPowtorz',
			),
		),

	);
}
