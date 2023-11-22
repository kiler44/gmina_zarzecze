<?php
namespace Generic\Konfiguracja\Modul\BlokPomocy;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['kategoria_startowa']
 * @property int $k['maksymalny_poziom']
 * @property int $k['minimalny_poziom']
 * @property bool $k['oznaczanie_rodzicow']
 * @property bool $k['seolink']
 * @property string $k['typ_menu']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'kategoria_startowa' => array(
		'opis' => 'ID kategorii od której wyświetlamy menu. Aby wybrać przejdź do edycji treści.',
		'typ' => 'int',
		'wartosc' => null,
		),

	'maksymalny_poziom' => array(
		'opis' => 'Poziom do którego mają być pobierane kategorie',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'minimalny_poziom' => array(
		'opis' => 'Poziom od którego mają być pobierane kategorie',
		'typ' => 'int',
		'wartosc' => null,
		),

	'oznaczanie_rodzicow' => array(
		'opis' => 'Jeżeli zaznaczone, wszystkie kategorie będące rodzicami dla bieżącej(ścieżka) dostaną specjalną klasę',
		'typ' => 'bool',
		'wartosc' => null,
		),

	'seolink' => array(
		'opis' => 'Jeżeli zaznaczone, linki będzie miał postać JavaScript\'ową',
		'typ' => 'bool',
		'wartosc' => null,
		),

	'typ_menu' => array(
		'opis' => 'Określa sposób wybierania kategorii nadrzędnej w menu. Dostępne opcje:
				biezaca_rodzicem - menu wyświetla się od bieżącej podstrony

				gotowe_menu - menu przygotowane w strukturze strony lub od strony głównej

				wybrana_rodzicem - wyswietla linki do podstron wybranej strony',
		'typ' => 'select',
		'wartosc' => 'biezaca_rodzicem',
		'dozwolone' => array(
			'0' => 'biezaca_rodzicem',
			1 => 'gotowe_menu',
			2 => 'wybrana_rodzicem',
			),
		),

	);
}
