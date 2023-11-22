<?php
namespace Generic\Tlumaczenie\Pl\Modul\WidokPoczatkowy;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['blokRaportyGetApartamenty.naglowek']
 * @property string $t['blokRaportyGetApartamenty.podglad']
 * @property string $t['blokRaportyGetApartamenty.wiecej']
 * @property string $t['details.etykieta_netto']
 * @property string $t['details.etykieta_waluta']
 * @property string $t['index.blad_zapisu_telefonu']
 * @property string $t['index.ekipa_etykieta']
 * @property string $t['index.ekipa_naglowek']
 * @property string $t['index.etykieta_sms_wyslij_pozniej']
 * @property string $t['index.etykieta_twoje_zamowienia']
 * @property string $t['index.etykieta_zamowienia_projekty']
 * @property string $t['index.etykieta_zamowienia_zamkniete']
 * @property string $t['index.komunikatBrakNumeruTelefonu']
 * @property string $t['index.link_zmien_ekipe_etykieta']
 * @property string $t['index.pole_wymagana']
 * @property string $t['index.pracownicy_ekipy_etykieta']
 * @property string $t['index.start_pracy_etykieta']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.url_dodaj_pracownika_etykieta']
 * @property string $t['index.url_podglad_zamowienia_etykieta']
 * @property string $t['index.url_usun_pracownika_etykieta']
 * @property string $t['index.url_zakoncz_prace_etykieta']
 * @property string $t['index.zamowienie_tytul_etykieta']
 * @property string $t['widokTidsbanken.autologoutInfo']
 * @property string $t['widokTidsbanken.data']
 * @property string $t['widokTidsbanken.godziny']
 * @property string $t['widokTidsbanken.godziny_do']
 * @property string $t['widokTidsbanken.godziny_od']
 * @property string $t['widokTidsbanken.produkt']
 * @property string $t['widokTidsbanken.suma']
 * @property string $t['widokTidsbanken.sumaGodzinNaglowek']
 * @property string $t['widokTidsbanken.szczegulyGodzinNaglowek']
 * @property string $t['widokTidsbanken.tytul_modulu']
 * @property string $t['widokTidsbanken.tytul_strony']
 * @property string $t['widokTidsbanken.wybierzDateNaglowek']
 * @property string $t['widokTidsbanken.wybierzMiesiac']
 * @property string $t['widokTidsbanken.wybierzRok']
 * @property string $t['wyswietldlapracownika.brutto_naglowek']
 * @property string $t['wyswietldlapracownika.godziny_naglowek']
 * @property string $t['wyswietldlapracownika.naglowek_przepracowane_godziny']
 * @property string $t['wyswietldlapracownika.suma_etykieta']
 * @property string $t['wyswietldlapracownika.typ_naglowek']
 * @property string $t['wyswietldlapracownika.url_przepracowanych_godzin_etykieta']
 * @property array $t['widokTidsbanken.listaMiesiecy']
 * @property string $t['widokTidsbanken.listaMiesiecy']['1']
 * @property string $t['widokTidsbanken.listaMiesiecy']['2']
 * @property string $t['widokTidsbanken.listaMiesiecy']['3']
 * @property string $t['widokTidsbanken.listaMiesiecy']['4']
 * @property string $t['widokTidsbanken.listaMiesiecy']['5']
 * @property string $t['widokTidsbanken.listaMiesiecy']['6']
 * @property string $t['widokTidsbanken.listaMiesiecy']['7']
 * @property string $t['widokTidsbanken.listaMiesiecy']['8']
 * @property string $t['widokTidsbanken.listaMiesiecy']['9']
 * @property string $t['widokTidsbanken.listaMiesiecy']['10']
 * @property string $t['widokTidsbanken.listaMiesiecy']['11']
 * @property string $t['widokTidsbanken.listaMiesiecy']['12']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'blokRaportyGetApartamenty.naglowek' => 'Najnowsze projekty z apartamentami',
		'blokRaportyGetApartamenty.podglad' => 'Podgląd',
		'blokRaportyGetApartamenty.wiecej' => 'Pokaż więcej',
		'details.etykieta_netto' => ' netto',
		'details.etykieta_waluta' => ' nok',
		'index.blad_zapisu_telefonu' => 'Wystąpiły błędy podczas zapisu numeru telefonu.',
		'index.ekipa_etykieta' => 'Jesteś liderem ekipy :',
		'index.ekipa_naglowek' => 'Dane ekipy',
		'index.etykieta_sms_wyslij_pozniej' => 'SMS do wysłania ({ILOSC_WYSLIJ_SMS})',
		'index.etykieta_twoje_zamowienia' => 'Twoje zamówienia (<b>{WYMAGANE}</b>/{OTWARTE})',
		'index.etykieta_zamowienia_projekty' => 'Projekty ({ILOSC_PROJEKTOW})',
		'index.etykieta_zamowienia_zamkniete' => 'Zamówienia zamknięte ({ILOSC_ZAMKNIETE})',
		'index.komunikatBrakNumeruTelefonu' => 'System nie mógł rozpoznać Twojego numeru telefonu. Brak lub błędny numer telefonu spowoduje brak możliwości wysyłania wiadomości SMS przez system podczas zamykania zamówień. <strong>Zmień numer telefonu</strong> (numer zostanie przypisany do Twojego profilu w systemie) lub wprowadź <strong>numer tymczasowy</strong> (numer tymczasowy jest ważny przez jeden dzień). <br/> <strong> Telefon : </strong> <input type="text" name="telefon" placeholder="+4712345678" id="telefon" /> <br/> <a id="profilowy" class="btn btn-success" href="#">Zmień numer telefonu</a> <a id="tymczasowy" class="btn btn-info" href="#">Ustaw numer tymczasowy</a>',
		'index.link_zmien_ekipe_etykieta' => 'Zmień ekipę',
		'index.pole_wymagana' => 'Błędny lub pusty numer telefonu.',
		'index.pracownicy_ekipy_etykieta' => 'Pracownicy ekipy : ',
		'index.start_pracy_etykieta' => 'Zalogowany od : ',
		'index.tytul_modulu' => 'Ekran powitalny',
		'index.tytul_strony' => 'Ekran powitalny',
		'index.url_dodaj_pracownika_etykieta' => 'Dobierz pracownika',
		'index.url_podglad_zamowienia_etykieta' => 'Podgląd zamówienia',
		'index.url_usun_pracownika_etykieta' => 'Usuń pracownika',
		'index.url_zakoncz_prace_etykieta' => 'Zakończ pracę',
		'index.zamowienie_tytul_etykieta' => 'Obecnie jesteś zalogowany do :',
		'widokTidsbanken.autologoutInfo' => 'Zostałeś wylogowany automatycznie',
		'widokTidsbanken.data' => 'Data',
		'widokTidsbanken.godziny' => 'Godziny',
		'widokTidsbanken.godziny_do' => 'Start',
		'widokTidsbanken.godziny_od' => 'Stop',
		'widokTidsbanken.produkt' => 'Rodzaj godzin',
		'widokTidsbanken.suma' => 'Suma',
		'widokTidsbanken.sumaGodzinNaglowek' => 'Podsumowanie godzin',
		'widokTidsbanken.szczegulyGodzinNaglowek' => 'Szczegóły logowań',
		'widokTidsbanken.tytul_modulu' => 'Twoja lista logowań',
		'widokTidsbanken.tytul_strony' => 'Twoja lista logowań',
		'widokTidsbanken.wybierzDateNaglowek' => 'Wybierz date',
		'widokTidsbanken.wybierzMiesiac' => 'miesiąc',
		'widokTidsbanken.wybierzRok' => 'Rok',
		'wyswietldlapracownika.brutto_naglowek' => 'Zarobił brutto',
		'wyswietldlapracownika.godziny_naglowek' => 'Godziny',
		'wyswietldlapracownika.naglowek_przepracowane_godziny' => 'Podsumowanie godzin',
		'wyswietldlapracownika.suma_etykieta' => 'Suma',
		'wyswietldlapracownika.typ_naglowek' => 'Typ',
		'wyswietldlapracownika.url_przepracowanych_godzin_etykieta' => 'Zobacz szczegóły',

		'widokTidsbanken.listaMiesiecy' => array(
			'1' => 'Styczeń',
			'2' => 'Luty',
			'3' => 'Marzec',
			'4' => 'Kwiecień',
			'5' => 'Maj',
			'6' => 'Czerwiec',
			'7' => 'Lipiec',
			'8' => 'Sierpień',
			'9' => 'Wrzesień',
			'10' => 'Październik',
			'11' => 'Listopad',
			'12' => 'Grudzień',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}