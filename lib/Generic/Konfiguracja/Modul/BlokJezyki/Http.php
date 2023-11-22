<?php
namespace Generic\Konfiguracja\Modul\BlokJezyki;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['index.kolejnosc_wyswietlania']
 * @property bool $k['index.pokaz_wybrany']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.kolejnosc_wyswietlania' => array(
		'opis' => 'Kolejność w jakiej językie będą się wyświetlać oraz etykiety dla tych języków',
		'typ' => 'array',
		'wartosc' => array(
			),
		),

	'index.pokaz_wybrany' => array(
		'opis' => 'Czy pokazywać wybrany język',
		'typ' => 'bool',
		'wartosc' => null,
		),

	);
}
