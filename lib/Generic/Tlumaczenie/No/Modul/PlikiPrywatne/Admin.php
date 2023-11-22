<?php
namespace Generic\Tlumaczenie\No\Modul\PlikiPrywatne;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.komunikat_domyslny']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.utworzono_katalog']
 * @property string $t['uprawnienia.blad_nie_znaleziono_pliku']
 * @property string $t['uprawnienia.blad_nie_znaleziono_rol_uzytkownikow']
 * @property string $t['uprawnienia.blad_nieprawidlowa_sciezka']
 * @property string $t['uprawnienia.etykieta_input_plik']
 * @property string $t['uprawnienia.etykieta_input_role']
 * @property string $t['uprawnienia.etykieta_input_uzytkownicy']
 * @property string $t['uprawnienia.etykieta_wstecz']
 * @property string $t['uprawnienia.etykieta_zapisz']
 * @property string $t['uprawnienia.info_zapisano_uprawnienia']
 * @property string $t['uprawnienia.opis_input_plik']
 * @property string $t['uprawnienia.opis_input_role']
 * @property string $t['uprawnienia.opis_input_uzytkownicy']
 * @property string $t['uprawnienia.tytul_strony']
 * @property string $t['uprawnienia.zakladka_role']
 * @property string $t['uprawnienia.zakladka_uzytkownicy']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajNowy']
 * @property string $t['_akcje_etykiety_']['wykonajUpload']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajZmien']
 * @property string $t['_akcje_etykiety_']['wykonajPrzenies']
 * @property string $t['_akcje_etykiety_']['wykonajUprawnienia']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.komunikat_domyslny' => 'Select a file to set an access to it',
		'index.tytul_strony' => 'Private files',
		'index.utworzono_katalog' => 'Directory created',

		'uprawnienia.blad_nie_znaleziono_pliku' => 'File was not found',
		'uprawnienia.blad_nie_znaleziono_rol_uzytkownikow' => 'Error. Cannot obtain user access list and roles',
		'uprawnienia.blad_nieprawidlowa_sciezka' => 'Invalid file path',
		'uprawnienia.etykieta_input_plik' => 'Selected file',
		'uprawnienia.etykieta_input_role' => 'Attached roles',
		'uprawnienia.etykieta_input_uzytkownicy' => 'Attached users',
		'uprawnienia.etykieta_wstecz' => 'Back',
		'uprawnienia.etykieta_zapisz' => 'Save settings',
		'uprawnienia.info_zapisano_uprawnienia' => 'Access to this file has been assigned',
		'uprawnienia.opis_input_plik' => '',
		'uprawnienia.opis_input_role' => 'Selected groups will have access to this file',
		'uprawnienia.opis_input_uzytkownicy' => 'Selected users will have access to this file',
		'uprawnienia.tytul_strony' => 'Acces to file',
		'uprawnienia.zakladka_role' => 'Roles',
		'uprawnienia.zakladka_uzytkownicy' => 'Users',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Main screen',
			'wykonajNowy' => 'Create directory',
			'wykonajUpload' => 'Upload files',
			'wykonajUsun' => 'Remove files or directories',
			'wykonajZmien' => 'Change names of files or directories',
			'wykonajPrzenies' => 'Move files or directories',
			'wykonajUprawnienia' => 'Change access to the file',
		),
	);
}
