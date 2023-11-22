<?php
namespace Generic\Tlumaczenie\En\Modul\MenuAplikacji;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.etykieta_zarzadzanie_widokami']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'index.tytul_strony' => 'App menu',
		'ustawienia.komunikat_przed_edycja' => 'Before editing, select the user to whom you configure the menu. Otherwise, the menu is configured for all users.',
		'ustawienia.brak_uprawnien_wybranego_uzytkownika_komunikat' => 'Selected user does not have access to any of the actions. Select another user or give him appropriate permissions.',
		'ustawienia.formularz_nie_wypełniony_komunikat' => 'The form was not properly filled',
		'ustawienia.dodano_pozycje_menu_komunikat' => 'Application menu item was successfully saved',
		'ustawienia.nie_dodano_pozycji_menu_komunikat_blad' => 'Application menu item was not saved - some error occured',
		'ustawienia.tytul_strony' => 'Application menu settings',
		'ustawienia.tytul_modulu' => 'Application menu settings',
		'ustawienia.etykieta_elementy' => 'Menu elements',
		'ustawienia.uzytkownik_etykieta' => 'Select user',
		'ustawienia.uzytkownik_etykieta_wybierz' => '- every user -',
		'ustawienia.etykieta_modulAkcja' => 'Modue & action',
		'ustawienia.etykieta_etykietaKontener' => 'Label',
		'ustawienia.etykieta_wybierz' => '- Choose -',
		'ustawienia.etykieta_parametry' => 'Parameters',
		'ustawienia.etykieta_anchor' => 'Anchor',
		'ustawienia.etykieta_ikona' => 'Icon',
		'ustawienia.etykieta_edytuj' => 'Edit',
		'ustawienia.etykieta_usun' => 'Delete',
		'ustawienia.etykieta_dodaj_pozycje' => 'Save',
		'ustawienia.etykieta_dodaj' => 'Add menu element',
		'ustawienia.etykieta_zapisz_kolejnosc' => 'Save new positions',
		'ustawienia.komunikat_zmieniono_kolejnosc' => 'Selected new order of menu elements has been successfully saved.',
		'ustawienia.error_nie_zmieniono_kolejnosci' => 'Error occured and new order of menu elements was not saved.',
		'ustawienia.etykieta_zamknij' => 'Close',
		'ustawienia.etykieta_wstecz' => 'Back',
		
		'edytuj.tytul_strony' => 'Edit menu position',
		'edytuj.tytul_modulu' => 'Edit menu position',
		'edytuj.brak_wiersza_dla_id' => 'Request for given parameters is invalid',
		'edytuj.sciezka_lista_elementow' => 'List of elements',
		
		'usun.success_usunieto_pozycje' => 'Selected menu item was successfully deleted.',
		'usun.error_nie_usunieto_pozycji' => 'Error has occurred while deleting selected menu item.',
		'usun.error_brak_pozycji' => 'Can not obtain selected item data.',
		
		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Visibility of control panel menu',
			'wykonajEdytuj' => 'Edit menu items',
			'wykonajUstawienia' => 'Menu elements management',
			'wykonajUsun' => 'Delete menu items',
		),
	);
}
