<?php
namespace Generic\Tlumaczenie\En\Modul\WidokPoczatkowy;

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
		'index.blad_zapisu_telefonu' => 'Error saving a phone number.',
		'index.ekipa_etykieta' => 'You are the leader of the team :',
		'index.ekipa_naglowek' => 'Team',
		'index.etykieta_sms_wyslij_pozniej' => 'SMS to send ({ILOSC_WYSLIJ_SMS})',
		'index.etykieta_twoje_zamowienia' => 'Your orders (<b>{WYMAGANE}</b>/{OTWARTE})',
		'index.etykieta_zamowienia_projekty' => 'Project\'s ({ILOSC_PROJEKTOW})',
		'index.etykieta_zamowienia_zamkniete' => 'Orders closed ({ILOSC_ZAMKNIETE})',
		'index.komunikatBrakNumeruTelefonu' => 'The system could not recognize your phone number. Missing or incorrect phone number will lack the ability to send SMS messages by the system during closing orders. <strong> Change phone number </ strong> (the number will be assigned to your profile in the system) or enter <strong> temporary number </ strong> (a temporary number is valid for one day). <br/> <strong> Phone: </ strong> <input type="text" name="telefon" placeholder="+4712345678" id="telefon" /> <br/> <a id="profilowy" class="btn btn-success" href="#">Change your phone number</a>  <a id="tymczasowy" class="btn btn-info" href="#"> Set a temporary number </a>',
		'index.link_zmien_ekipe_etykieta' => 'Change team',
		'index.pole_wymagana' => 'Wrong or empty phone number.',
		'index.pracownicy_ekipy_etykieta' => 'Worker of team : ',
		'index.start_pracy_etykieta' => 'Started at : ',
		'index.tytul_modulu' => 'Welcome screen',
		'index.tytul_strony' => 'Welcome screen',
		'index.url_dodaj_pracownika_etykieta' => 'Add worker to team',
		'index.url_podglad_zamowienia_etykieta' => 'Preview orders',
		'index.url_usun_pracownika_etykieta' => 'Delete worker from team',
		'index.url_zakoncz_prace_etykieta' => 'Finish work',
		'index.zamowienie_tytul_etykieta' => 'Now you are logged in to :',
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
		'wyswietldlapracownika.brutto_naglowek' => 'Earnings',
		'wyswietldlapracownika.godziny_naglowek' => 'Hours',
		'wyswietldlapracownika.naglowek_przepracowane_godziny' => 'Sum hours',
		'wyswietldlapracownika.suma_etykieta' => 'Sum',
		'wyswietldlapracownika.typ_naglowek' => 'Type',
		'wyswietldlapracownika.url_przepracowanych_godzin_etykieta' => 'Preview details',

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