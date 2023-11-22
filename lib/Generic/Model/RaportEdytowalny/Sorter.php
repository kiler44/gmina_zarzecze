<?php
namespace Generic\Model\RaportEdytowalny;
use Generic\Biblioteka;

/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących.
 */
class Sorter extends Biblioteka\Sorter
{
	/**
	* Tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny.
	* Porzadek sortowania jest dodawany tylko do pierwszej kolumny.
	* @var array
	*/
	public $_rodzaje = array(
		'id' => array(
			'id',
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'nazwa' => array(
			'nazwa',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'opis' => array(
			'opis',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'grupa' => array(
			'grupa',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'kod_sql' => array(
			'kod_sql',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'nazwy_pol' => array(
			'nazwy_pol',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'uprawnieni_uzytkownicy' => array(
			'uprawnieni_uzytkownicy',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'filtry' => array(
			'filtry',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'data_dodania' => array(
			'data_dodania',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'cache' => array(
			'cache',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'data_modyfikacji' => array(
			'data_modyfikacji',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'zezwol_zaawansowany' => array(
			'zezwol_zaawansowany',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'typ_wykresu' => array(
			'typ_wykresu',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'kolumny_wykresu' => array(
			'kolumny_wykresu',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'typy_kolumn_tabeli' => array(
			'typy_kolumn_tabeli',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'kolumna_wykresu_daty' => array(
			'kolumna_wykresu_daty',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'typ_wykresu_modyfikowalny' => array(
			'typ_wykresu_modyfikowalny',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'sub_zapytania' => 'ASC',//TODO:
		),
		
		'sub_zapytania' => array(
			'sub_zapytania',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'nazwa' => 'ASC',//TODO:
			'opis' => 'ASC',//TODO:
			'grupa' => 'ASC',//TODO:
			'kod_sql' => 'ASC',//TODO:
			'nazwy_pol' => 'ASC',//TODO:
			'uprawnieni_uzytkownicy' => 'ASC',//TODO:
			'filtry' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'cache' => 'ASC',//TODO:
			'data_modyfikacji' => 'ASC',//TODO:
			'zezwol_zaawansowany' => 'ASC',//TODO:
			'typ_wykresu' => 'ASC',//TODO:
			'kolumny_wykresu' => 'ASC',//TODO:
			'typy_kolumn_tabeli' => 'ASC',//TODO:
			'kolumna_wykresu_daty' => 'ASC',//TODO:
			'typ_wykresu_modyfikowalny' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}