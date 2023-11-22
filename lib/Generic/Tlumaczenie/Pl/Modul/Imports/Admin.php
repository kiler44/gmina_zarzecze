<?php
namespace Generic\Tlumaczenie\Pl\Modul\Imports;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['czytajExcel.blad_danych_w_excelu']
 * @property string $t['czytajExcel.blad_parsowania_pliku_excel']
 * @property string $t['czytajExcel.blad_uploadu_pliku']
 * @property string $t['importApartamenty.blad_id_projektu']
 * @property string $t['importApartamenty.blad_projektu']
 * @property string $t['importApartamenty.etykieta_plik']
 * @property string $t['importApartamenty.etykieta_typProjektu']
 * @property string $t['importApartamenty.etykieta_wyslij']
 * @property string $t['importApartamenty.komunikat_brak_pliku']
 * @property string $t['importApartamenty.naglowek_modulu']
 * @property string $t['importApartamenty.tytul_modulu']
 * @property string $t['importApartamenty.tytul_strony']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['zapiszImport.bledy_zapisu_wierszy']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'czytajExcel.blad_danych_w_excelu' => 'Wczytany arkusz excela nie jest prawidłową listą apartamentów do importu',
		'czytajExcel.blad_parsowania_pliku_excel' => 'Bład parsowania pliku excel. Sprawdź poprawność danych w arkuszu.',
		'czytajExcel.blad_uploadu_pliku' => 'Błąd uploadu pliku. Spróbuj ponownie',
		'importApartamenty.blad_id_projektu' => 'Ta akcja wymaga podania ID projektu rodzica. Wybrany URL jest nieprawidłowy',
		'importApartamenty.blad_projektu' => 'Wybrany projekt rodzic jest nieprawidłowy.',
		'importApartamenty.etykieta_plik' => 'Plik do importu',
		'importApartamenty.etykieta_typProjektu' => 'Wybierz typ projektu',
		'importApartamenty.etykieta_wyslij' => 'Ładuj plik',
		'importApartamenty.komunikat_brak_pliku' => 'Proszę wybrać poprawny plik arkusz excel.',
		'importApartamenty.naglowek_modulu' => 'Import apartamentów dla projektu: {NAZWA_PROJEKTU}, Numer zamówienia GET {NUMER_PROJEKTU}',
		'importApartamenty.tytul_modulu' => 'Import listy apartamentów',
		'importApartamenty.tytul_strony' => 'Import listy apartamentów',
		'index.tytul_modulu' => 'Import',
		'index.tytul_strony' => 'Import',
		'zapiszImport.bledy_zapisu_wierszy' => 'Nie wszystkie wiersze zostały zapisane. Lista wierszy nie zapisanych: {WIERSZE}',

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}