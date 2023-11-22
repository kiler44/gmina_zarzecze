<?php
namespace Generic\Tlumaczenie\Pl\Modul\Orders;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['raport.historia_logowania_etykieta']
 * @property string $t['raport.klient_adres_etykieta']
 * @property string $t['raport.klient_etykieta']
 * @property string $t['raport.klient_firma_etykieta']
 * @property string $t['raport.klient_nazwa_etykieta']
 * @property string $t['raport.naglowek']
 * @property string $t['raport.notatki_etykieta']
 * @property string $t['raport.produkty_zakupione_etykieta']
 * @property string $t['raport.status_etykieta']
 * @property string $t['wyslijPrzypomnienieWylogowanie.tresc_przypomnienia']
 * @property string $t['wyslijPrzypomnienieWylogowanie.tresc_przypomnienia_nie_zamkniety_dzien']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajWyslijPrzypomnienieWylogowanie']
 */
class Cron extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'adres_etykieta' => 'Postadresse : ',
		'adres_wartosc_post' => 'Micheletveien 37b',
		'bankgiro_etykieta' => 'BANKGIRO',
		'bankgiro_wartosc' => '1503 32 27407',
		'email_etykieta' => 'Epost : ',
		'email_wartosc' => 'kontakt@bktas.no',
		'znaczek_rozdziel' => '/',
		'www_etykieta' => 'www',
		'www_wartosc' => 'www.bktas.no',
		'miasto_wartosc_post' => '1053 Oslo',
		'org_numer_etykieta' => 'Org. nr.',
		'org_numer_wartosc' => 'NO 999 301 789 MVA',
		'telefon_etykieta' => 'Sentralbord : ',
		'telefon_wartosc' => '45 45 45 02',
		'www_etykieta' => 'www',
		'www_wartosc' => 'www.bktas.no',
		'makeReport.logo_alt' => 'Bredbånd og Kabel-TV Service AS',
		'makeReport.etykieta_page_number' => 'Page: ',
		
		'raport.historia_logowania_etykieta' => 'Logging in history',
		'raport.klient_adres_etykieta' => 'Address : ',
		'raport.klient_etykieta' => 'Customer',
		'raport.klient_firma_etykieta' => 'Company name : ',
		'raport.klient_nazwa_etykieta' => 'Name : ',
		'raport.naglowek' => 'Raport B2B',
		'raport.notatki_etykieta' => 'Notes',
		'raport.produkty_zakupione_etykieta' => 'Products',
		'raport.status_etykieta' => 'STATUS : ',
		'wyslijPrzypomnienieWylogowanie.tresc_przypomnienia' => 'Hej {IMIE_LIDERA}, minela {AKTUALNA_GODZINA} a Twoja druzyna jest wciaz zalogowana od godziny {GODZINA_ZALOGOWANIA} {DATA_ZALOGOWANIA} do zamowienia: {ORDER_ID} ({ORDER_POSTCODE} {ORDER_CITY}, {ORDER_ADDRESS}). Pamietaj aby wylogowac sie z wszystkich zadan i zakonczyc dzien roboczy!',
		'wyslijPrzypomnienieWylogowanie.tresc_przypomnienia_nie_zamkniety_dzien' => 'Witaj {IMIE_LIDERA}, wylogowales sie juz z wszystkich przydzielonych na dzis zadan. Pamietaj takze aby zakonczyc dzien roboczy.',
		'wyslijPrzypomnienieZaloguj.tresc_przypomnienia' => 'Czesc {IMIE_LIDERA}, jest godzina {AKTUALNA_GODZINA} a Twoja druzyna wciaz nie zalogowala sie do systemu. Posiadasz zadania do wykonania w dniu dzisiejszym.',
		
		'_akcje_etykiety_' => array(
			'wykonajWyslijPrzypomnienieWylogowanie' => 'Wyslij przypomnienie o konieczności wylogowania',
			'wykonajRaport' => 'Raport B2B',
			'wykonajWyslijInfoTeamyNieZalogowane' => 'Wyślij informacje o niezalogowanych teamach',
			'wykonajWyslijPrzypomnienieZalogowanie' => 'Wyślij przypomnienie o konieczności zalogowania się'
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}