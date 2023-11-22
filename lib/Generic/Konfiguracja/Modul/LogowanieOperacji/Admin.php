<?php
namespace Generic\Konfiguracja\Modul\LogowanieOperacji;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['formularz.niedozwolone_nazwy_plikow']
 * @property array $k['formularz.wymagane_pola']
 * @property string $k['index.domyslne_sortowanie']
 * @property int $k['index.wierszy_na_stronie']
 * @property array $k['obserwator.typy_obserwatorow']
 * @property array $k['obserwator.wymagany_obiekt_docelowy']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'formularz.niedozwolone_nazwy_plikow' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'php-error',
			'sql',
			'img404',
			),
		),

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza.',
		'typ' => 'list',
		'wartosc' => array(
			'opis',
			'typ',
			'obiekt_docelowy',
			'zdarzenia_email',
			),
		),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'id',
		'dozwolone' => array(
			'0' => 'id',
			),
		),

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy logów na stronie.',
		'typ' => 'int',
		'wartosc' => 50,
		),

	'obserwator.typy_obserwatorow' => array(
		'opis' => 'Lista dostępnych typow obserwatorów. Sposób podawania obserwatorów: kod_obserwatora => nazwa_obserwatora',
		'typ' => 'array',
		'wartosc' => array(
			'DoPliku' => 'Logowanie do pliku',
			'DoBazy' => 'Logowanie do bazy',
			'NaMail' => 'Wysyłanie na adres email',
			'Email' => 'Użycie predefiniowanej formatki z wiadomością email',
			),
		),

	'obserwator.wymagany_obiekt_docelowy' => array(
		'opis' => 'Lista kodów obserwatorów przy dla których wymagane jest podanie obiektu docelowego. (Przykładowo obserwator maMail wymaga obiektu docelowego adresy email)',
		'typ' => 'list',
		'wartosc' => array(
			'DoPliku',
			'NaMail',
			'Email',
			),
		),

	);
}
