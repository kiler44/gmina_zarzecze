<?php
namespace Generic\Tlumaczenie\No\Modul\WidokPoczatkowy;

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
		'blokRaportyGetApartamenty.naglowek' => 'Latest projects with apartments',
		'blokRaportyGetApartamenty.podglad' => 'Preview',
		'blokRaportyGetApartamenty.wiecej' => 'View more',
		'details.etykieta_netto' => ' netto',
		'details.etykieta_waluta' => ' nok',
		'index.blad_zapisu_telefonu' => 'Feil ved lagring av et telefonnummer.',
		'index.ekipa_etykieta' => 'Du er lederen av teamet :',
		'index.ekipa_naglowek' => 'Teamet',
		'index.etykieta_sms_wyslij_pozniej' => 'SMS å sende ({ILOSC_WYSLIJ_SMS})',
		'index.etykieta_twoje_zamowienia' => 'Dine ordre (<b>{WYMAGANE}</b>/{OTWARTE})',
		'index.etykieta_zamowienia_projekty' => 'Prosjekter ({ILOSC_PROJEKTOW})',
		'index.etykieta_zamowienia_zamkniete' => 'Bestill stengt ({ILOSC_ZAMKNIETE})',
		'index.komunikatBrakNumeruTelefonu' => 'The system could not recognize your phone number. Missing or incorrect phone number will lack the ability to send SMS messages by the system during closing orders. <strong> Change phone number </ strong> (the number will be assigned to your profile in the system) or enter <strong> temporary number </ strong> (a temporary number is valid for one day). <br/> <strong> Phone: </ strong> <input type="text" name="telefon" placeholder="+4712345678" id="telefon" /> <br/> <a id="profilowy" class="btn btn-success" href="#">Change your phone number</a>  <a id="tymczasowy" class="btn btn-info" href="#"> Set a temporary number </a>',
		'index.link_zmien_ekipe_etykieta' => 'Endring teamet',
		'index.pole_wymagana' => 'Feil eller tom telefonnummer.',
		'index.pracownicy_ekipy_etykieta' => 'Arbeidere teamet : ',
		'index.start_pracy_etykieta' => 'Logget inn fra: ',
		'index.tytul_modulu' => 'Splash screen',
		'index.tytul_strony' => 'Splash screen',
		'index.url_dodaj_pracownika_etykieta' => 'Juster ansatt',
		'index.url_podglad_zamowienia_etykieta' => 'Bestill forhåndsvisning',
		'index.url_usun_pracownika_etykieta' => 'Fjern ansatt',
		'index.url_zakoncz_prace_etykieta' => 'Ferdig arbeid',
		'index.zamowienie_tytul_etykieta' => 'Tiden du er logget på :',
		'widokTidsbanken.autologoutInfo' => 'On that day, the system automatically logged you out',
		'widokTidsbanken.data' => 'Date',
		'widokTidsbanken.godziny' => 'Hours',
		'widokTidsbanken.godziny_do' => 'Start',
		'widokTidsbanken.godziny_od' => 'Stop',
		'widokTidsbanken.produkt' => 'Hours type',
		'widokTidsbanken.suma' => 'Sum',
		'widokTidsbanken.sumaGodzinNaglowek' => 'Sum of hours',
		'widokTidsbanken.szczegulyGodzinNaglowek' => 'Hours details',
		'widokTidsbanken.tytul_modulu' => 'Your timelist',
		'widokTidsbanken.tytul_strony' => 'Your timelist',
		'widokTidsbanken.wybierzDateNaglowek' => 'Select date range',
		'widokTidsbanken.wybierzMiesiac' => 'month',
		'widokTidsbanken.wybierzRok' => 'Year',
		'wyswietldlapracownika.brutto_naglowek' => 'Inntjeningen',
		'wyswietldlapracownika.godziny_naglowek' => 'Timer',
		'wyswietldlapracownika.naglowek_przepracowane_godziny' => 'Oppsummering timer',
		'wyswietldlapracownika.suma_etykieta' => 'Sum',
		'wyswietldlapracownika.typ_naglowek' => 'Type',
		'wyswietldlapracownika.url_przepracowanych_godzin_etykieta' => 'Se detaljer',

		'widokTidsbanken.listaMiesiecy' => array(
			'1' => 'January',
			'2' => 'Febraury',
			'3' => 'March',
			'4' => 'April',
			'5' => 'May',
			'6' => 'June',
			'7' => 'July',
			'8' => 'August',
			'9' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}