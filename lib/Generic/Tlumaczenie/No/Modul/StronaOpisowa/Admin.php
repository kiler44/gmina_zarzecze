<?php
namespace Generic\Tlumaczenie\No\Modul\StronaOpisowa;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['formularz.button_wstecz']
 * @property string $t['formularz.button_zapisz']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.tresc.etykieta']
 * @property string $t['formularz.tresc.opis']
 * @property string $t['formularz.tytul.etykieta']
 * @property string $t['formularz.tytul.opis']
 * @property string $t['index.blad_nie_mozna_zapisac_strony']
 * @property string $t['index.info_zapisano_dane_strony']
 * @property string $t['index.tytul_strony']
 * @property string $t['usun.blad_brak_kategorii']
 * @property string $t['usun.blad_nie_mozna_usunac_kategorii']
 * @property string $t['usun.info_usunieto_kategorie']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'formularz.button_wstecz' => 'Back',
		'formularz.button_zapisz' => 'Save',
		'formularz.etykieta_select_wybierz' => ' - select - ',
		'formularz.tresc.etykieta' => 'Content',
		'formularz.tresc.opis' => '',
		'formularz.tytul.etykieta' => 'Title',
		'formularz.tytul.opis' => '',

		'index.blad_nie_mozna_zapisac_strony' => 'Cannot save page content',
		'index.info_zapisano_dane_strony' => 'Page content saved',
		'index.tytul_strony' => 'Edit page',

		'usun.blad_brak_kategorii' => 'Cannot obtain category data',
		'usun.blad_nie_mozna_usunac_kategorii' => 'Cannot remove selected category',
		'usun.info_usunieto_kategorie' => 'Category removed',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Edit content',
		),
	);
}
