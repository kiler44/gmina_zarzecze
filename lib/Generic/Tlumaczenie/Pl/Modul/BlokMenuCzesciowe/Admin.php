<?php
namespace Generic\Tlumaczenie\Pl\Modul\BlokMenuCzesciowe;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['formularz.etykieta_kategoria']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.etykieta_zapisz']
 * @property string $t['index.blad_nie_mozna_zapisac_bloku']
 * @property string $t['index.info_zapisano_blok']
 * @property string $t['index.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'formularz.etykieta_kategoria' => 'Wybierz element struktury',
		'formularz.etykieta_select_wybierz' => ' - wybierz - ',
		'formularz.etykieta_zapisz' => 'Zapisz',

		'index.blad_nie_mozna_zapisac_bloku' => 'Nie można zapisać danych bloku',
		'index.info_zapisano_blok' => 'Zapisano dane bloku',
		'index.tytul_strony' => 'Edycja bloku menu "%s"',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Edycja ustawień bloku',
		),
	);
}
