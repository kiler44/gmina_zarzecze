<?php
namespace Generic\Tlumaczenie\En\Modul\Orders;

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
		'raport.naglowek' => 'Report B2B',
		'raport.notatki_etykieta' => 'Notes',
		'raport.produkty_zakupione_etykieta' => 'Products',
		'raport.status_etykieta' => 'STATUS : ',
		'wyslijPrzypomnienieWylogowanie.tresc_przypomnienia' => 'Hi {IMIE_LIDERA} it\'s just after {AKTUALNA_GODZINA} and your team is still logged in since {GODZINA_ZALOGOWANIA} {DATA_ZALOGOWANIA} into order: {ORDER_ID} ({ORDER_POSTCODE} {ORDER_CITY}, {ORDER_ADDRESS}). Don\'t forget to log out and finish the working day!',
		'wyslijPrzypomnienieWylogowanie.tresc_przypomnienia_nie_zamkniety_dzien' => 'Hello {IMIE_LIDERA}, you logged out of your all orders, please remember also to finish the working day.',
		'wyslijPrzypomnienieZaloguj.tresc_przypomnienia' => 'Hello {IMIE_LIDERA} it\'s just {AKTUALNA_GODZINA} and your team is still not logged in to the system. You have a orders to perform today.',
		
		'_akcje_etykiety_' => array(
			'wykonajWyslijPrzypomnienieWylogowanie' => 'Send reminder about Logout necessity',
			'wykonajRaport' => 'Raport B2B',
			'wykonajWyslijInfoTeamyNieZalogowane' => 'Send information about not logged team',
			'wykonajWyslijPrzypomnienieZalogowanie' => 'Send reminder about Login necessity'
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}