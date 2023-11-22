<?php
namespace Generic\Tlumaczenie\No\Modul\Imports;

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
		'czytajExcel.blad_danych_w_excelu' => 'Denne excel-filen er ikke riktig leiligheter liste',
		'czytajExcel.blad_parsowania_pliku_excel' => 'Feil ved åpning eller parsing Excel-fil. Vennligst sjekk excel filinnholdet.',
		'czytajExcel.blad_uploadu_pliku' => 'Filopplasting feil. Prøv å laste den opp på nytt',
		'importApartamenty.blad_id_projektu' => 'Denne handlingen krever riktig ID av foreldre prosjektet. Det virker som forespurte nettadressen er feil.',
		'importApartamenty.blad_projektu' => 'Valgt forelder prosjektet i feil.',
		'importApartamenty.etykieta_plik' => 'Fil for å importere',
		'importApartamenty.etykieta_typProjektu' => '[ETYKIETA:importApartamenty.etykieta_typProjektu]',	//TODO
		'importApartamenty.etykieta_wyslij' => 'Opplastingsfil',
		'importApartamenty.komunikat_brak_pliku' => 'Velg riktig excel-filen først.',
		'importApartamenty.naglowek_modulu' => 'Import leiligheter til prosjekt: {NAZWA_PROJEKTU}, Ordre # GET {NUMER_PROJEKTU}',
		'importApartamenty.tytul_modulu' => 'Import leilighet liste',
		'importApartamenty.tytul_strony' => 'Import leilighet liste',
		'index.tytul_modulu' => 'Import',
		'index.tytul_strony' => 'Import',
		'zapiszImport.bledy_zapisu_wierszy' => 'Noen rader ble ikke lagret på riktig måte. Rader ikke lagret: {WIERSZE}',

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}