<?php
namespace Generic\Tlumaczenie\En\Modul\Imports;

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
		'czytajExcel.blad_danych_w_excelu' => 'This excel file is not proper apartments list',
		'czytajExcel.blad_parsowania_pliku_excel' => 'Error opening or parsing excel file. Please check excel file contents.',
		'czytajExcel.blad_uploadu_pliku' => 'File upload error. Try to upload it again',
		'importApartamenty.blad_id_projektu' => 'This action requires proper ID of parent project. It seems that requested URL is wrong.',
		'importApartamenty.blad_projektu' => 'Selected parent project is incorrect.',
		'importApartamenty.etykieta_plik' => 'File to import',
		'importApartamenty.etykieta_typProjektu' => 'Select project type:',
		'importApartamenty.etykieta_wyslij' => 'Upload file',
		'importApartamenty.komunikat_brak_pliku' => 'Please select proper excel file first.',
		'importApartamenty.naglowek_modulu' => 'Import apartments for project: {NAZWA_PROJEKTU}, Order # GET {NUMER_PROJEKTU}',
		'importApartamenty.tytul_modulu' => 'Import appartment list',
		'importApartamenty.tytul_strony' => 'Import appartment list',
		'index.tytul_modulu' => 'Import',
		'index.tytul_strony' => 'Import',
		'zapiszImport.bledy_zapisu_wierszy' => 'Some rows was not saved properly. Rows not saved: {WIERSZE}',

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}