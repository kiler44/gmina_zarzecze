<?php
namespace Generic\Konfiguracja\Modul\BlokMenuCzesciowe;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['kategoria_startowa']
 * @property int $k['maksymalny_poziom']
 * @property bool $k['oznaczanie_rodzicow']
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

	'oznaczanie_rodzicow' => array(
		'opis' => 'Jeżeli zaznaczone, wszystkie kategorie będące rodzicami dla bieżącej(ścieżka) dostaną specjalną klasę',
		'typ' => 'bool',
		'wartosc' => null,
		),

	);
}
