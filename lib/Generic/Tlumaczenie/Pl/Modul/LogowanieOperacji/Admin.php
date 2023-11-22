<?php
namespace Generic\Tlumaczenie\Pl\Modul\LogowanieOperacji;

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
	
		'dodaj.tytul_strony' => 'Dodawanie nowego obserwatora',

		'edytuj.tytul_strony' => 'Edycja obserwatora',

		'formularz.dane.region' => 'Dane obserwatora',
		'formularz.edycja_formatki.etykieta' => 'Edycja formatki',
		'formularz.edycja_formatki.opis' => 'Czy przejść do edycji formatki po zakończeniu edycji zobserwatora?',
		'formularz.etykieta_odwroc_zaznaczenie' => 'Odwróć zaznaczenie',
		'formularz.etykieta_odznacz_wiele' => 'Odznacz wszystkie',
		'formularz.etykieta_select_wybierz' => '- wybierz -',
		'formularz.etykieta_zaznacz_wiele' => 'Zaznacz wiele',
		'formularz.info_blad_zapisu_obserwator' => 'Nie udał się zapisać obserwatora',
		'formularz.info_formatka_brak_klasy' => 'Zdarzenie nie posiada definicji pozwalającej na podpowiadanie danych i obiektów',
		'formularz.info_zapisano_obserwator' => 'Obserwator został zapisany',
		'formularz.obiekt_docelowy.etykieta' => 'Obiekt docelowy obserwatora',
		'formularz.opis.etykieta' => 'Opis obserwatora',
		'formularz.przypisz_zdarzenia' => 'Obserwowane zdarzenia',
		'formularz.typ.etykieta' => 'Typ obserwatora',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.zakladka_moduly_administracyjne' => 'Moduły administracyjne',
		'formularz.zapisz.wartosc' => 'Zapisz',
		'formularz.zdarzenia_email.etykieta' => 'Wybrane zdarzenie',

		'index.etykieta_link_dodaj' => 'Dodaj obserwator',
		'index.etykieta_link_konfiguracja' => 'Konfiguracja',
		'index.etykieta_link_obserwatory' => 'Obserwatory',
		'index.etykieta_link_raport' => 'Raport obserwatorów',
		'index.obiekt_docelowy' => 'Obiekt docelowy',
		'index.opis' => 'Opis',
		'index.typ' => 'Typ',
		'index.tytul_strony' => 'Lista zdefiniowanych obserwatorów',

		'podglad.blad_nie_mozna_pobrac_loga' => 'Nie można pobrać danych loga',
		'podglad.etykieta_adres_ip' => 'Adres Ip',
		'podglad.etykieta_akcja' => 'Wykonywana akcja',
		'podglad.etykieta_czas' => 'Czas żądania',
		'podglad.etykieta_dane_dodatkowe' => 'Dane dodatkowe',
		'podglad.etykieta_id_kategorii' => 'Kategoria',
		'podglad.etykieta_id_uzytkownika' => 'Id użytkownika',
		'podglad.etykieta_kod_jezyka' => 'Kod języka',
		'podglad.etykieta_kod_modulu' => 'Kod Modułu',
		'podglad.etykieta_przegladarka' => 'Przegladarka',
		'podglad.etykieta_usluga' => 'Usługa',
		'podglad.etykieta_zadanie_http' => 'Żądanie Http',
		'podglad.tytul_strony' => 'Podgląd wiersza loga',

		'raport.etykieta_link_pobierz_raport' => 'Pobierz raport',
		'raport.nazwa_raportu_xls' => 'Obserwatory raport',
		'raport.obiekt_docelowy' => 'Obiekt docelowy',
		'raport.opis' => 'Opis',
		'raport.typ' => 'Typ',
		'raport.tytul_strony' => 'Raport obserwatorów',
		'raport.zdarzenia' => 'Przypisane zdarzenia',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista logów',
			'wykonajPodglad' => 'Podgląd wybranego loga',
			'wykonajUstawienia' => 'Ustawienia logowania operacji',
			'wykonajPobierzRaport' => 'Pobieranie raportu',
			'wykonajRaport' => 'Generowanie raportu',
		),
	);
}
