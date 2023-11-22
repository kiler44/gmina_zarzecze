<?php
namespace Generic\Tlumaczenie\En\Modul\BlokAktualnosci;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.blad_nie_mozna_pobrac_kategorii']
 * @property string $t['index.blad_nie_mozna_zapisac_bloku']
 * @property string $t['index.etykieta_input_kategoria']
 * @property string $t['index.etykieta_input_kateroria_wybierz']
 * @property string $t['index.etykieta_wstecz']
 * @property string $t['index.etykieta_zapisz']
 * @property string $t['index.info_zapisano_blok']
 * @property string $t['index.opis_input_kategoria']
 * @property string $t['index.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.blad_nie_mozna_pobrac_kategorii' => 'Nie dodano żadnej podstrony z aktualnościami',
		'index.blad_nie_mozna_zapisac_bloku' => 'Błąd nie można zapisać zmian w ustawieniach bloku',
		'index.etykieta_input_kategoria' => 'Kategorie aktualności',
		'index.etykieta_input_kateroria_wybierz' => '- wszystkie -',
		'index.etykieta_wstecz' => 'Wstecz',
		'index.etykieta_zapisz' => 'Zapisz',
		'index.info_zapisano_blok' => 'Zapisano zmiany w ustawieniach bloku.',
		'index.opis_input_kategoria' => 'Wybierz kategorie menu, które będą źródłem danych dla bloczku aktualności',
		'index.tytul_strony' => 'Blok aktualności',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Edycja ustawień bloku',
		),
	);
}
