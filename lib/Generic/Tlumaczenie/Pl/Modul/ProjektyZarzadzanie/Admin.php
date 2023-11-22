<?php
namespace Generic\Tlumaczenie\Pl\Modul\ProjektyZarzadzanie;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.blad_kod_zajety']
 * @property string $t['dodaj.blad_nie_mozna_utworzyc_katalogu']
 * @property string $t['dodaj.blad_nie_mozna_zapisac_projektu']
 * @property string $t['dodaj.info_zapisano_dane_projektu']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_brak_projektu']
 * @property string $t['edytuj.blad_nie_mozna_zapisac_projektu']
 * @property string $t['edytuj.info_zapisano_dane_projektu']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.dodatkowe_uslugi.zakladka']
 * @property string $t['formularz.domena.etykieta']
 * @property string $t['formularz.domyslnyJezyk.etykieta']
 * @property string $t['formularz.etykieta_odwroc_zaznaczenie']
 * @property string $t['formularz.etykieta_odznacz_wiele']
 * @property string $t['formularz.etykieta_zaznacz_wiele']
 * @property string $t['formularz.jezyki.etykieta']
 * @property string $t['formularz.kod.etykieta']
 * @property string $t['formularz.moduly_zakladka.zakladka']
 * @property string $t['formularz.nazwa.etykieta']
 * @property string $t['formularz.ogolne.zakladka']
 * @property string $t['formularz.opis.etykieta']
 * @property string $t['formularz.region_bloki']
 * @property string $t['formularz.region_moduly']
 * @property string $t['formularz.szablon.etykieta']
 * @property string $t['formularz.usluga_cron.region']
 * @property string $t['formularz.usluga_rss.region']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['index.etykieta_button_vhost']
 * @property string $t['index.etykieta_dodaj']
 * @property string $t['index.etykieta_domena']
 * @property string $t['index.etykieta_kod']
 * @property string $t['index.etykieta_nazwa']
 * @property string $t['index.tytul_strony']
 * @property string $t['usun.blad_brak_projektu']
 * @property string $t['usun.blad_nie_mozna_usunac_projektu']
 * @property string $t['usun.info_projekt_usuniety']
 * @property string $t['vhost.blad_brak_projektu']
 * @property string $t['vhost.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajVhost']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'dodaj.blad_kod_zajety' => 'Wybrany kod jest już zajęty',
		'dodaj.blad_nie_mozna_utworzyc_katalogu' => 'Nie można utworzyć katalogu %s',
		'dodaj.blad_nie_mozna_zapisac_projektu' => 'Nie można zapisać danych projektu!',
		'dodaj.info_zapisano_dane_projektu' => 'Dodano nowy projekt',
		'dodaj.tytul_strony' => 'Nowy projekt',

		'edytuj.blad_brak_projektu' => 'Nie można pobrać danych projektu',
		'edytuj.blad_nie_mozna_zapisac_projektu' => 'Nie można zapisać danych projektu!',
		'edytuj.info_zapisano_dane_projektu' => 'Zaktualizowano dane projektu',
		'edytuj.tytul_strony' => 'Edycja projektu: ',

		'formularz.dodatkowe_uslugi.zakladka' => 'Dodatkowe usługi',
		'formularz.domena.etykieta' => 'Domena',
		'formularz.domyslnyJezyk.etykieta' => 'Język domyślny',
		'formularz.etykieta_odwroc_zaznaczenie' => 'Odwróć zaznaczenie',
		'formularz.etykieta_odznacz_wiele' => 'Odznacz wszystkie',
		'formularz.etykieta_zaznacz_wiele' => 'Zaznacz wszystkie',
		'formularz.jezyki.etykieta' => 'Języki',
		'formularz.kod.etykieta' => 'Kod',
		'formularz.moduly_zakladka.zakladka' => 'Przypisane moduły',
		'formularz.nazwa.etykieta' => 'Nazwa',
		'formularz.ogolne.zakladka' => 'Ustawienia',
		'formularz.opis.etykieta' => 'Opis',
		'formularz.region_bloki' => 'Dostępne bloki',
		'formularz.region_moduly' => 'Dostępne moduły',
		'formularz.szablon.etykieta' => 'Szablon',
		'formularz.usluga_cron.region' => 'Dostępne moduły Cron',
		'formularz.usluga_rss.region' => 'Dostępne moduły Rss',
		'formularz.usluga_api.region' => 'Moduły udostępniające API',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.zapisz.wartosc' => 'Zapisz',

		'index.etykieta_button_vhost' => 'Podglad konfiguracji apache',
		'index.etykieta_dodaj' => 'Dodaj projekt',
		'index.etykieta_domena' => 'Domena',
		'index.etykieta_kod' => 'Kod',
		'index.etykieta_nazwa' => 'Nazwa projektu',
		'index.tytul_strony' => 'Zarzadzanie projektami',

		'usun.blad_brak_projektu' => 'Nie można pobrać danych projektu',
		'usun.blad_nie_mozna_usunac_projektu' => 'Nie można usunąć projektu!',
		'usun.info_projekt_usuniety' => 'Projekt został usunięty',

		'vhost.blad_brak_projektu' => 'Nie można pobrać danych projektu',
		'vhost.tytul_strony' => 'Konfiguracja VirtualHost-a Apache dla projektu',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie listy projektów',
			'wykonajDodaj' => 'Dodawanie projektów',
			'wykonajEdytuj' => 'Edycja projektów',
			'wykonajUsun' => 'Usuwanie projektów',
			'wykonajVhost' => 'Generowanie treści konfiguracyjnych Virtual Hostów',
		),
	);
}
