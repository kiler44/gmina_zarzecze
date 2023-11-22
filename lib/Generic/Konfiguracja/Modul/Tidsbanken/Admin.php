<?php
namespace Generic\Konfiguracja\Modul\Tidsbanken;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.domyslne_sortowanie']
 * @property string $k['index.pager_konfiguracja']
 * @property string $k['index.wierszy_na_stronie']
 * @property string $k['listaProduktow.domyslne_sortowanie']
 * @property string $k['listaProduktow.pager_konfiguracja']
 * @property string $k['listaProduktow.wierszy_na_stronie']
 * @property string $k['szablon.formularz_wyszukiwarka']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'drupoweDodawanie.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'tidsbanken_numer_pracownika',
	),
	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'produkt',
		),
	'index.wyszukiwarka_statusy' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('nieaktywny', 'aktywny', 'zablokowany'),
	),
	'index.pager_konfiguracja' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'index.wierszy_na_stronie' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => '9999',
		),

	'listaProduktow.domyslne_sortowanie' => array(
		'opis' => 'kod',
		'typ' => 'varchar',
		'wartosc' => 'kod',
		),

	'listaProduktow.pager_konfiguracja' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'listaProduktow.wierszy_na_stronie' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),
	'grupoweDodawanie.koduProduktow' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('500', '811', ),
	),
	'dodajProduktDlugoterminowy.kody_produktow' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('161', '170', '171', '160' ),
	),
	'gridUzytkownicy.kodNormalvakt' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('110', '15', '130', '30', '170', '171'),
	),
	'gridUzytkownicy.kodOvertid' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('100', '16'),
	),
	'raportWyplata.kodWyplataStala' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 30,
	),
	'raportWyplata.wyswietlajWyplataStala' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => false,
	),
	'raportWyplata.kody_godziny_podstawowe' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('10', '15'),
	),
	'raportWyplata.kody_godziny_40' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('100', '16'),
	),
	'raportWyplata.nie_wyswietlaj_stala_wyplata' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => true,
	),
	'raportWyplata.kody_godziny_100' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('130', '17', '120'),
	),
	'raportWyplata.kody_sykepenger' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('780'),
	),
	'raportWyplata.kody_helligdag' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('48'),
	),
	'raportWyplata.naglowki_tlumaczenia' => array(
		'opis' => 'Klucz produkty_wszystkie wyswietli wszystkie produkty wykożystane w danym okresie, produkty_do_wyplaty wszystkie mające mnożnik wiekszy niz 0 ',
		'typ' => 'array',
		'wartosc' => array(
			'nazwa_uzytkownika' => 'Ansattnr og navn',
			'suma_godzin' => 'Sum hours',
			'produkty_wszystkie' => 'produkty_wszystkie',
			'stawka_podstawowa' => 'Timelonn',
			'komentarz' => 'Komm.',
			'produkty_do_wyplaty' => 'produkty_do_wyplaty',
			'stawka_godziny_podstawowe' => 'Time sats ord. timer',
			'stawka_godziny_40' => 'Timesats overtid 40%',
			'stawka_godziny_100' => 'Timesats overtid 100%',
			'kwota_godziny_podstawowe' => 'Ord.lønn',
			'kwota_godziny_40' => 'Overtids-lønn 40 %',
			'kwota_godziny_100' => 'Nattarbeid 100%',
			'sykepenger' => 'Sykepenger',
			'helligdag' => 'Helligdag med lønn',
			'suma' => 'Sum'
			),
	),
	'raportWyplata.lista_miesiecy' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'select', 1 => 'January' , 2 => 'February' ,3 => 'March' ,4 => 'April' ,5 => 'May' ,6 => 'June' ,7 => 'July' ,8 => 'August' ,9 => 'September' ,10 => 'October' ,11 => 'November' ,12 => 'December'
			),
	),
	'raportWyplata.produkty_do_wyplaty_pomin' => array(
		'opis' => 'Te produkty nie zostaną wyświetlone w sekcji produkty_do_wyplaty ',
		'typ' => 'list',
		'wartosc' => array('48', '780'),
	),
	'raportWyplata.stawki' => array(
		'opis' => 'pola ze stawkami wyplat',
		'typ' => 'list',
		'wartosc' => array('kwota_godziny_podstawowe', 'kwota_godziny_40', 'kwota_godziny_100'),
	),
	'raportWyplata.produkty_do_wyplaty_przedrostek' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'ant. ',
	),
		'raportExcel.naglowek_kolor_czcionki' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'Black',
		),
	'raportExcel.naglowek_kolor_tla' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'Gray',
		),
	'raportExcel.wiersz_nieparzysty_kolor_tla' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'White',
		),
	'raportExcel.wiersz_parzysty_kolor_tla' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'White',
		),
	'raportExcel.polaExcela' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(0 => 'A', 1 => 'B',2 => 'C',3 => 'D',4 => 'E',5 => 'F',6 => 'G',7 => 'H',8 => 'I',9 => 'J',10 => 'K',11 => 'L',12 => 
			'M',13 => 'N',14 => 'O',15 => 'P',16 => 'Q',17 => 'R',18 => 'S',19 => 'T', 20 => 'U',21 => 'V',22 => 'W',23 => 'X',24 => 'Y' ,25 => 'Z'
			, 26 => 'AA', 27 => 'AB', 28 => 'AC', 29 => 'AD', 30 => 'AE', 31 => 'AF'
			),
		),
	'zamknijTydzien.kodNormalvakt' => array(
			'opis' => '',
			'typ' => 'int',
			'wartosc' => 110,
		),
	'zamknijTydzien.kodOvertid' => array(
			'opis' => '',
			'typ' => 'int',
			'wartosc' => 100,
		),
	'zamknijTydzien.max_minut_normalvakt_tydzien' => array(
			'opis' => '',
			'typ' => 'int',
			'wartosc' => 2700,
		),
	'raportPrzerwy.kodyPrzerw' => array(
			'opis' => ' ',
			'typ' => 'list',
			'wartosc' => array('15', '16', '17', '18'),
		),
	);
}
