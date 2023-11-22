<?php
namespace Generic\Tlumaczenie\Pl\Modul\Platnosci;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['anuluj.blad_brak_uprawnien_do_platnosci']
 * @property string $t['anuluj.blad_nie_mozna_pobrac_platnosci']
 * @property string $t['anuluj.blad_nie_mozna_usunac_platnosci']
 * @property string $t['anuluj.blad_platnosc_w_realizacji']
 * @property string $t['anuluj.info_usunieto_platnosc']
 * @property string $t['blad.serwis_odpowiedzial']
 * @property string $t['formularzPlatnosci.email.etykieta']
 * @property string $t['formularzPlatnosci.email.opis']
 * @property string $t['formularzPlatnosci.imie.etykieta']
 * @property string $t['formularzPlatnosci.imie.opis']
 * @property string $t['formularzPlatnosci.kodPocztowy.etykieta']
 * @property string $t['formularzPlatnosci.kodPocztowy.opis']
 * @property string $t['formularzPlatnosci.komunikat_email_blad']
 * @property string $t['formularzPlatnosci.komunikat_imie_blad']
 * @property string $t['formularzPlatnosci.komunikat_kwota_blad']
 * @property string $t['formularzPlatnosci.komunikat_nazwisko_blad']
 * @property string $t['formularzPlatnosci.komunikat_nowaPlatnosc_blad']
 * @property string $t['formularzPlatnosci.komunikat_opis_blad']
 * @property string $t['formularzPlatnosci.kraj.etykieta']
 * @property string $t['formularzPlatnosci.kraj.opis']
 * @property string $t['formularzPlatnosci.kwota.etykieta']
 * @property string $t['formularzPlatnosci.kwota.opis']
 * @property string $t['formularzPlatnosci.miasto.etykieta']
 * @property string $t['formularzPlatnosci.miasto.opis']
 * @property string $t['formularzPlatnosci.nazwisko.etykieta']
 * @property string $t['formularzPlatnosci.nazwisko.opis']
 * @property string $t['formularzPlatnosci.nrDomu.etykieta']
 * @property string $t['formularzPlatnosci.nrDomu.opis']
 * @property string $t['formularzPlatnosci.nrLokalu.etykieta']
 * @property string $t['formularzPlatnosci.nrLokalu.opis']
 * @property string $t['formularzPlatnosci.opis.etykieta']
 * @property string $t['formularzPlatnosci.opis.opis']
 * @property string $t['formularzPlatnosci.telefon.etykieta']
 * @property string $t['formularzPlatnosci.telefon.opis']
 * @property string $t['formularzPlatnosci.typPlatnosci.etykieta']
 * @property string $t['formularzPlatnosci.typPlatnosci.opis']
 * @property string $t['formularzPlatnosci.ulica.etykieta']
 * @property string $t['formularzPlatnosci.ulica.opis']
 * @property string $t['formularzPlatnosci.wstecz.wartosc']
 * @property string $t['formularzPlatnosci.wyslij.wartosc']
 * @property string $t['formularzZaplata.dalej.wartosc']
 * @property string $t['formularzZaplata.informacja.etykieta']
 * @property string $t['formularzZaplata.informacja.opis']
 * @property string $t['formularzZaplata.informacja.wartosc']
 * @property string $t['formularzZaplata.typPlatnosciPl.opis']
 * @property string $t['formularzZaplata.wstecz.wartosc']
 * @property string $t['index.blad_brak_danych_dla_platnosci']
 * @property string $t['index.blad_nie_mozna_zapisac_platnosci']
 * @property string $t['index.blad_nie_wybrano_typu_platnosci']
 * @property string $t['index.blad_nieprawidlowe_dane_platnosci']
 * @property string $t['sukces.serwis_odpowiedzial']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajNowa']
 * @property string $t['_akcje_etykiety_']['wykonajSukces']
 * @property string $t['_akcje_etykiety_']['wykonajBlad']
 * @property string $t['_akcje_etykiety_']['wykonajStatus']
 * @property string $t['_akcje_etykiety_']['wykonajAnuluj']
 * @property array $t['_zdarzenia_etykiety_']
 * @property string $t['_zdarzenia_etykiety_']['wykonano_platnosc']
 * @property string $t['_zdarzenia_etykiety_']['przerwano_platnosc']
 * @property string $t['_zdarzenia_etykiety_']['anulowano_platnosc']
 * @property string $t['_zdarzenia_etykiety_']['zmieniono_status_platnosci']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'anuluj.blad_brak_uprawnien_do_platnosci' => 'Brak uprawnień do płatności',
		'anuluj.blad_nie_mozna_pobrac_platnosci' => 'Nie można pobrać płatności',
		'anuluj.blad_nie_mozna_usunac_platnosci' => 'Nie można anulować płatności',
		'anuluj.blad_platnosc_w_realizacji' => 'Płatność w trakcie realizacji',
		'anuluj.info_usunieto_platnosc' => 'Płatność została przerwana',

		'blad.serwis_odpowiedzial' => 'Płatność została przerwana lub wystąpiły problemy podczas realizowania płatności.<br/>Poczekaj na aktualizację statusu i spróbuj powtórzyć płatność.',

		'formularzPlatnosci.email.etykieta' => 'Email',
		'formularzPlatnosci.email.opis' => 'Adres poczty elektronicznej',
		'formularzPlatnosci.imie.etykieta' => 'Imię',
		'formularzPlatnosci.imie.opis' => 'Twoje imię',
		'formularzPlatnosci.kodPocztowy.etykieta' => 'Kod pocztowy',
		'formularzPlatnosci.kodPocztowy.opis' => 'Kod pocztowy przypisany do Twojego regionu',
		'formularzPlatnosci.komunikat_email_blad' => 'Brak wymaganego pola "Email"',
		'formularzPlatnosci.komunikat_imie_blad' => 'Brak wymaganego pola "Imię"',
		'formularzPlatnosci.komunikat_kwota_blad' => 'Brak podanej kwoty',
		'formularzPlatnosci.komunikat_nazwisko_blad' => 'Brak wymaganego pola "Nazwisko"',
		'formularzPlatnosci.komunikat_nowaPlatnosc_blad' => 'Nowa płatność nie może zostać utworzona',
		'formularzPlatnosci.komunikat_opis_blad' => 'Brak wymaganego pola "Opis"',
		'formularzPlatnosci.kraj.etykieta' => 'Kraj',
		'formularzPlatnosci.kraj.opis' => 'Nazwa Twojego kraju',
		'formularzPlatnosci.kwota.etykieta' => 'Kwota',
		'formularzPlatnosci.kwota.opis' => 'Do zapłaty',
		'formularzPlatnosci.miasto.etykieta' => 'Miasto',
		'formularzPlatnosci.miasto.opis' => 'Nazwa Twojej miejscowości',
		'formularzPlatnosci.nazwisko.etykieta' => 'Nazwisko',
		'formularzPlatnosci.nazwisko.opis' => 'Twoje nazwisko',
		'formularzPlatnosci.nrDomu.etykieta' => 'Numer domu',
		'formularzPlatnosci.nrDomu.opis' => 'Numer Twojego domu',
		'formularzPlatnosci.nrLokalu.etykieta' => 'Numer mieszkania',
		'formularzPlatnosci.nrLokalu.opis' => 'Numer Twojego mieszkania',
		'formularzPlatnosci.opis.etykieta' => 'Opis',
		'formularzPlatnosci.opis.opis' => 'Krótki opis płatności',
		'formularzPlatnosci.telefon.etykieta' => 'Telefon',
		'formularzPlatnosci.telefon.opis' => 'Numer Twojego telefonu',
		'formularzPlatnosci.typPlatnosci.etykieta' => 'Sposób zapłaty',
		'formularzPlatnosci.typPlatnosci.opis' => '',
		'formularzPlatnosci.ulica.etykieta' => 'Ulica',
		'formularzPlatnosci.ulica.opis' => 'Ulica na której mieszkasz',
		'formularzPlatnosci.wstecz.wartosc' => 'Anuluj',
		'formularzPlatnosci.wyslij.wartosc' => 'Zapłać',

		'formularzZaplata.dalej.wartosc' => 'Dalej',
		'formularzZaplata.informacja.etykieta' => '&nbsp;',
		'formularzZaplata.informacja.opis' => '',
		'formularzZaplata.informacja.wartosc' => 'Wybierz sposób w jaki dokonasz wpłaty z poniższej listy',
		'formularzZaplata.typPlatnosciPl.opis' => '',
		'formularzZaplata.wstecz.wartosc' => 'Anuluj',

		'index.blad_brak_danych_dla_platnosci' => 'Brak danych potrzebnych do utworzenia nowej płatności',
		'index.blad_nie_mozna_zapisac_platnosci' => 'Nie można zapisać płatności',
		'index.blad_nie_wybrano_typu_platnosci' => 'Nie wybrano sposobu zapłaty',
		'index.blad_nieprawidlowe_dane_platnosci' => 'Nieprawidłowe dane nie można utworzyć płatności',

		'sukces.serwis_odpowiedzial' => 'Wysłano odpowiedź pozytywną z serwisu obsługującego płatności.<br/>Status transakcji powinien zostać zaktualizowany w ciągu kilku minut.',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie modułu',
			'wykonajNowa' => 'Dodawanie nowej płatności',
			'wykonajSukces' => 'Sukces',
			'wykonajBlad' => 'Błąd',
			'wykonajStatus' => 'Status',
			'wykonajAnuluj' => 'Anuluj',
		),

		'_zdarzenia_etykiety_' => array(
			'wykonano_platnosc' => 'Wykonano płatność',
			'przerwano_platnosc' => 'Przerwano płatność',
			'anulowano_platnosc' => 'Anulowano płatność',
			'zmieniono_status_platnosci' => 'Zmieniono status płatności',
		),
	);
}
