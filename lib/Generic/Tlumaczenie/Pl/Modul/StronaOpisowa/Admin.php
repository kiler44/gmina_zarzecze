<?php
namespace Generic\Tlumaczenie\Pl\Modul\StronaOpisowa;

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
	
		'formularz.button_wstecz' => 'Wstecz',
		'formularz.button_zapisz' => 'Zapisz',
		'formularz.etykieta_select_wybierz' => ' - wybierz - ',
		'formularz.tresc.etykieta' => 'Treść',
		'formularz.tresc.opis' => '',
		'formularz.tytul.etykieta' => 'Tytuł',
		'formularz.tytul.opis' => '',
        'formularz.pliki.zakladka' => 'Pliki',
        'formularz.glowna.zakladka' => 'Informacje',

		'index.blad_nie_mozna_zapisac_strony' => 'Nie można zapisać danych strony!',
		'index.info_zapisano_dane_strony' => 'Zapisano dane strony',
		'index.tytul_strony' => 'Edycja strony opisowej',

		'usun.blad_brak_kategorii' => 'Nie można pobrać danych kategorii',
		'usun.blad_nie_mozna_usunac_kategorii' => 'Nie można usunąć kategorii!',
		'usun.info_usunieto_kategorie' => 'Kategoria została usunięta',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Edycja treści strony',
		),
	);
}
