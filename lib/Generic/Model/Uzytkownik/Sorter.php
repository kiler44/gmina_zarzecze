<?php
namespace Generic\Model\Uzytkownik;
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
		'produkt' => array(
			'produkt',
			'nazwisko'
		),
		'id' => array(
			'id',
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
			
		'login' => array(
			'login',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'haslo' => array(
			'haslo',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'email' => array(
			'email',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'data_dodania' => array(
			'data_dodania',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'data_aktywacji' => array(
			'data_aktywacji',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'token' => array(
			'token',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'czy_admin' => array(
			'czy_admin',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'status' => array(
			'status',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'imie' => array(
			'imie',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'nazwisko' => array(
			'nazwisko',
			'imie' => 'ASC',//TODO:
			'id' => 'ASC',//TODO:
		),
		
		'data_urodzenia' => array(
			'data_urodzenia',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'tel_komorka_firmowa' => array(
			'tel_komorka_firmowa',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'tel_komorka_prywatna' => array(
			'tel_komorka_prywatna',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'tel_domowy' => array(
			'tel_domowy',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'kontakt_adres' => array(
			'kontakt_adres',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'kontakt_kod_pocztowy' => array(
			'kontakt_kod_pocztowy',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'kontakt_miasto' => array(
			'kontakt_miasto',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'jezyk' => array(
			'jezyk',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'kraj_pochodzenia' => array(
			'kraj_pochodzenia',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'zdjecie' => array(
			'zdjecie',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'stawka_godzinowa' => array(
			'stawka_godzinowa',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'umiejetnosci' => 'ASC',//TODO:
		),
		
		'umiejetnosci' => array(
			'umiejetnosci',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'login' => 'ASC',//TODO:
			'haslo' => 'ASC',//TODO:
			'email' => 'ASC',//TODO:
			'data_dodania' => 'ASC',//TODO:
			'data_aktywacji' => 'ASC',//TODO:
			'token' => 'ASC',//TODO:
			'czy_admin' => 'ASC',//TODO:
			'status' => 'ASC',//TODO:
			'imie' => 'ASC',//TODO:
			'nazwisko' => 'ASC',//TODO:
			'data_urodzenia' => 'ASC',//TODO:
			'tel_komorka_firmowa' => 'ASC',//TODO:
			'tel_komorka_prywatna' => 'ASC',//TODO:
			'tel_domowy' => 'ASC',//TODO:
			'kontakt_adres' => 'ASC',//TODO:
			'kontakt_kod_pocztowy' => 'ASC',//TODO:
			'kontakt_miasto' => 'ASC',//TODO:
			'jezyk' => 'ASC',//TODO:
			'kraj_pochodzenia' => 'ASC',//TODO:
			'zdjecie' => 'ASC',//TODO:
			'stawka_godzinowa' => 'ASC',//TODO:
		),
		'tidsbanken_numer_pracownika' => array(
			'tidsbanken_numer_pracownika'
		),
	);



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}