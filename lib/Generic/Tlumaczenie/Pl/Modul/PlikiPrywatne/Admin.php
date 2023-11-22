<?php
namespace Generic\Tlumaczenie\Pl\Modul\PlikiPrywatne;

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
	
		'index.komunikat_domyslny' => 'Wybierz plik by nadać mu uprawnienia',
		'index.tytul_strony' => 'Pliki prywatne',
		'index.utworzono_katalog' => 'Katalog został pomyślnie utworzony',

		'uprawnienia.blad_nie_znaleziono_pliku' => 'Nie znaleziono pliku',
		'uprawnienia.blad_nie_znaleziono_rol_uzytkownikow' => 'Nie moznan pobrać danych ról i uzytkowników',
		'uprawnienia.blad_nieprawidlowa_sciezka' => 'Nieprawidłowa ścieżka pliku',
		'uprawnienia.etykieta_input_plik' => 'Wybrany plik',
		'uprawnienia.etykieta_input_role' => 'Role do powiązania',
		'uprawnienia.etykieta_input_uzytkownicy' => 'Użytkownicy do powiązania',
		'uprawnienia.etykieta_wstecz' => 'Wstecz',
		'uprawnienia.etykieta_zapisz' => 'Zapisz uprawnienia',
		'uprawnienia.info_zapisano_uprawnienia' => 'Przypisano uprawnienia do pliku',
		'uprawnienia.opis_input_plik' => '',
		'uprawnienia.opis_input_role' => 'Wybrane tutaj grupy użytkowników będą miały dostęp do pliku',
		'uprawnienia.opis_input_uzytkownicy' => 'Wybrani tutaj użytkownicy będą mieli dostęp do pliku',
		'uprawnienia.tytul_strony' => 'Uprawnienia do pliku',
		'uprawnienia.zakladka_role' => 'Role',
		'uprawnienia.zakladka_uzytkownicy' => 'Użytkownicy',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Główny ekran menadżera plików',
			'wykonajNowy' => 'Tworzenie katalogów',
			'wykonajUpload' => 'Upload plików',
			'wykonajUsun' => 'Usuwanie plików i folderów',
			'wykonajZmien' => 'Zmiana nazwy plików i folderów',
			'wykonajPrzenies' => 'Przenoszenie plików i folderów',
			'wykonajUprawnienia' => 'Zmiana uprawnień do plików',
		),
	);
}
