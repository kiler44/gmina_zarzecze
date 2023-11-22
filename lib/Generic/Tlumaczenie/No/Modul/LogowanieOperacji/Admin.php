<?php
namespace Generic\Tlumaczenie\No\Modul\LogowanieOperacji;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.dane.region']
 * @property string $t['formularz.edycja_formatki.etykieta']
 * @property string $t['formularz.edycja_formatki.opis']
 * @property string $t['formularz.etykieta_odwroc_zaznaczenie']
 * @property string $t['formularz.etykieta_odznacz_wiele']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.etykieta_zaznacz_wiele']
 * @property string $t['formularz.info_blad_zapisu_obserwator']
 * @property string $t['formularz.info_formatka_brak_klasy']
 * @property string $t['formularz.info_zapisano_obserwator']
 * @property string $t['formularz.obiekt_docelowy.etykieta']
 * @property string $t['formularz.opis.etykieta']
 * @property string $t['formularz.przypisz_zdarzenia']
 * @property string $t['formularz.typ.etykieta']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zakladka_moduly_administracyjne']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularz.zdarzenia_email.etykieta']
 * @property string $t['index.etykieta_link_dodaj']
 * @property string $t['index.etykieta_link_konfiguracja']
 * @property string $t['index.etykieta_link_obserwatory']
 * @property string $t['index.etykieta_link_raport']
 * @property string $t['index.obiekt_docelowy']
 * @property string $t['index.opis']
 * @property string $t['index.typ']
 * @property string $t['index.tytul_strony']
 * @property string $t['podglad.blad_nie_mozna_pobrac_loga']
 * @property string $t['podglad.etykieta_adres_ip']
 * @property string $t['podglad.etykieta_akcja']
 * @property string $t['podglad.etykieta_czas']
 * @property string $t['podglad.etykieta_dane_dodatkowe']
 * @property string $t['podglad.etykieta_id_kategorii']
 * @property string $t['podglad.etykieta_id_uzytkownika']
 * @property string $t['podglad.etykieta_kod_jezyka']
 * @property string $t['podglad.etykieta_kod_modulu']
 * @property string $t['podglad.etykieta_przegladarka']
 * @property string $t['podglad.etykieta_usluga']
 * @property string $t['podglad.etykieta_zadanie_http']
 * @property string $t['podglad.tytul_strony']
 * @property string $t['raport.etykieta_link_pobierz_raport']
 * @property string $t['raport.nazwa_raportu_xls']
 * @property string $t['raport.obiekt_docelowy']
 * @property string $t['raport.opis']
 * @property string $t['raport.typ']
 * @property string $t['raport.tytul_strony']
 * @property string $t['raport.zdarzenia']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajPodglad']
 * @property string $t['_akcje_etykiety_']['wykonajUstawienia']
 * @property string $t['_akcje_etykiety_']['wykonajPobierzRaport']
 * @property string $t['_akcje_etykiety_']['wykonajRaport']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'dodaj.tytul_strony' => 'Add new observer',

		'edytuj.tytul_strony' => 'Edit observer',

		'formularz.dane.region' => 'Observer data',
		'formularz.edycja_formatki.etykieta' => 'Edit template',
		'formularz.edycja_formatki.opis' => 'Do you want to edit template after adding observer?',
		'formularz.etykieta_odwroc_zaznaczenie' => 'Reverse selected',
		'formularz.etykieta_odznacz_wiele' => 'Uncheck all',
		'formularz.etykieta_select_wybierz' => '- select -',
		'formularz.etykieta_zaznacz_wiele' => 'Multiple select',
		'formularz.info_blad_zapisu_obserwator' => 'Observer not saved',
		'formularz.info_formatka_brak_klasy' => 'This event doesn\'t have hint data',
		'formularz.info_zapisano_obserwator' => 'Observer saved',
		'formularz.obiekt_docelowy.etykieta' => 'Observer destination object',
		'formularz.opis.etykieta' => 'Observer description',
		'formularz.przypisz_zdarzenia' => 'Observed events',
		'formularz.typ.etykieta' => 'Observer type',
		'formularz.wstecz.wartosc' => 'Back',
		'formularz.zakladka_moduly_administracyjne' => 'Administrative modules',
		'formularz.zapisz.wartosc' => 'Save',
		'formularz.zdarzenia_email.etykieta' => 'Selected event',

		'index.etykieta_link_dodaj' => 'Add observer',
		'index.etykieta_link_konfiguracja' => 'Configuration',
		'index.etykieta_link_obserwatory' => 'Observers',
		'index.etykieta_link_raport' => 'Observers raport',
		'index.obiekt_docelowy' => 'Destination object',
		'index.opis' => 'Description',
		'index.typ' => 'Type',
		'index.tytul_strony' => 'Lista of observers',

		'podglad.blad_nie_mozna_pobrac_loga' => 'Cannot obtain log data',
		'podglad.etykieta_adres_ip' => 'Ip address',
		'podglad.etykieta_akcja' => 'Action',
		'podglad.etykieta_czas' => 'Request time',
		'podglad.etykieta_dane_dodatkowe' => 'Additional data',
		'podglad.etykieta_id_kategorii' => 'Category',
		'podglad.etykieta_id_uzytkownika' => 'user ID',
		'podglad.etykieta_kod_jezyka' => 'Language code',
		'podglad.etykieta_kod_modulu' => 'Module code',
		'podglad.etykieta_przegladarka' => 'Preview',
		'podglad.etykieta_usluga' => 'Service',
		'podglad.etykieta_zadanie_http' => 'Http request',
		'podglad.tytul_strony' => 'log row preview',

		'raport.etykieta_link_pobierz_raport' => 'Donload raport',
		'raport.nazwa_raportu_xls' => 'Observers raport',
		'raport.obiekt_docelowy' => 'Destination object',
		'raport.opis' => 'Description',
		'raport.typ' => 'Type',
		'raport.tytul_strony' => 'Observers raport',
		'raport.zdarzenia' => 'Assigned events',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Logs list',
			'wykonajPodglad' => 'Selected log preview',
			'wykonajUstawienia' => 'Logs settings',
			'wykonajPobierzRaport' => 'Download raport',
			'wykonajRaport' => 'Generate raport',
		),
	);
}
