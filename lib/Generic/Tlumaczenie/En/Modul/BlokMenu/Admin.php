<?php
namespace Generic\Tlumaczenie\En\Modul\BlokMenu;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['formularz.etykieta_input_kategoria_startowa']
 * @property string $t['formularz.etykieta_input_maksymalny_poziom']
 * @property string $t['formularz.etykieta_input_minimalny_poziom']
 * @property string $t['formularz.etykieta_input_typ_menu']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.etykieta_wstecz']
 * @property string $t['formularz.etykieta_zapisz']
 * @property string $t['formularz.opis_input_kategoria_startowa']
 * @property string $t['formularz.opis_input_maksymalny_poziom']
 * @property string $t['formularz.opis_input_minimalny_poziom']
 * @property string $t['formularz.opis_input_typ_menu']
 * @property string $t['index.blad_nie_mozna_zapisac_konfiguracji']
 * @property string $t['index.info_zapisano_konfiguracje']
 * @property string $t['index.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property array $t['formularz.typy_menu']
 * @property string $t['formularz.typy_menu']['biezaca_rodzicem']
 * @property string $t['formularz.typy_menu']['gotowe_menu']
 * @property string $t['formularz.typy_menu']['wybrana_rodzicem']
 * @property string $t['formularz.typy_menu']['biezaca_dzieckiem']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'formularz.etykieta_input_kategoria_startowa' => 'Wybierz element struktury',
		'formularz.etykieta_input_maksymalny_poziom' => 'Wyświetlać poziomów',
		'formularz.etykieta_input_minimalny_poziom' => 'Zacząć o poziomu',
		'formularz.etykieta_input_typ_menu' => 'Typ menu',
		'formularz.etykieta_select_wybierz' => ' - wybierz - ',
		'formularz.etykieta_wstecz' => 'Wstecz',
		'formularz.etykieta_zapisz' => 'Zapisz',
		'formularz.opis_input_kategoria_startowa' => 'Wybierz element struktury',
		'formularz.opis_input_maksymalny_poziom' => 'Określa ile poziomów poniżej wybranej podstrony może być wyświetlane menu. Jeżeli \'0\' brak ograniczeń.',
		'formularz.opis_input_minimalny_poziom' => 'Określa od którego poziomu zacząć wyświetlanie menu. Jeżeli \'0\' brak ograniczeń.',
		'formularz.opis_input_typ_menu' => '',

		'index.blad_nie_mozna_zapisac_konfiguracji' => 'Nie można zapisać konfiguracji bloku',
		'index.info_zapisano_konfiguracje' => 'Zapisano konfigurację bloku',
		'index.tytul_strony' => 'Edycja bloku menu "%s"',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Edycja ustawień bloku',
		),

		'formularz.typy_menu' => array(
			'biezaca_rodzicem' => 'Wyświetlane menu od bieżącej podstrony',
			'gotowe_menu' => 'Predefiniowane menu lub menu od strony głównej',
			'wybrana_rodzicem' => 'Wyświetlane menu od wybranej podstrony',
			'biezaca_dzieckiem' => 'Wyświetlana gałąź menu zawierającej bieżącą podstronę',
		),
	);
}
