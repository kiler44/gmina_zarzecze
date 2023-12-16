<?php
namespace Generic\Tlumaczenie\Pl\Modul\BlokWyszukiwarki;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.info_brak_mozliwosci_zarzadzania_modulem']
 * @property string $t['index.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.info_brak_mozliwosci_zarzadzania_modulem' => 'Ten blok nie obsługuje zarządzania treścią. Sprawdź konfigurację i tłumaczenia dla niego aby dokonać zmian.',
		'index.tytul_strony' => 'Edycja bloku ścieżki',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Edycja ustawień bloku',
		),
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
        'formularz.etykieta_wyszukiwarka_schowana' => 'Wyszukiwarka schowana : ',
        'index.blad_nie_mozna_zapisac_konfiguracji' => 'Nie można zapisać konfiguracji bloku',
        'index.info_zapisano_konfiguracje' => 'Zapisano konfigurację bloku',
	);
}
