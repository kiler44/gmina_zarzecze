<?php
namespace Generic\Konfiguracja\Modul\KategorieZarzadzanie;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['formularz.wymagane_pola']
 * @property string $k['szablon.kontenery']
 * @property array $k['wczytajKonfiguracje.dozwolone_formaty_plikow']
 * @property bool $k['wczytajKonfiguracje.kasuj_stara_konfiguracje']
 * @property bool $k['wczytajKonfiguracje.pokaz_przyciski']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza',
		'typ' => 'list',
		'wartosc' => array(
			'nazwa',
			'nazwaPrzyjazna',
			'kod',
			'idWidoku',
			),
		),

	'szablon.kontenery' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'kontenery.tpl',
		),

	'wczytajKonfiguracje.dozwolone_formaty_plikow' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'php',
			),
		),

	'wczytajKonfiguracje.kasuj_stara_konfiguracje' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'wczytajKonfiguracje.pokaz_przyciski' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	);
}
