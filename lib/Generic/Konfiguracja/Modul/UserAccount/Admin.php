<?php
namespace Generic\Konfiguracja\Modul\UserAccount;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['formularz.wymagane_pola']
 * @property bool $k['formularz.wyswietlaj_dane_kontaktowe']
 * @property string $k['ogloszenia.domyslne_sortowanie']
 * @property int $k['przypomnij.id_formatki_email']
 * @property array $k['szybkie_linki.lista']
 * @property int $k['zaloguj.czas_blokowania']
 * @property int $k['zaloguj.nieudane_proby']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'imie',
			'nazwisko',
			'jezyk',
			),
		),

	'formularz.wyswietlaj_dane_kontaktowe' => array(
		'opis' => 'Wyświetlać region z danymi kontaktowymi',
		'typ' => 'bool',
		'wartosc' => 1,
		),


	'przypomnij.id_formatki_email' => array(
		'opis' => '',
		'typ' => 'mail',
		'wartosc' => 13,
		),

	'szybkie_linki.lista' => array(
		'opis' => 'Lista linków pojawiających się w boxie szybkich linków (Nazwa => URL)',
		'typ' => 'array',
		'wartosc' => array(
			),
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
	'zmienHaslo.walidacja_hasla' => array(
		'typ' => 'varchar',
		'opis' => 'Reguły walidacji hasła',
		'wartosc' => '/(?!^[a-z]*$)(?!^[A-Z]*$)(?!^[0-9]*$)^([^\s]{6,20})$/',
		),
	);
}
