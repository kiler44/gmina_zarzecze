<?php
namespace Generic\Tlumaczenie\No\Modul\Orders;

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
		
		'raport.historia_logowania_etykieta' => 'Logging i historien',
		'raport.klient_adres_etykieta' => 'Adresse : ',
		'raport.klient_etykieta' => 'Kunde',
		'raport.klient_firma_etykieta' => 'Selskapsnavn : ',
		'raport.klient_nazwa_etykieta' => 'Navn : ',
		'raport.naglowek' => 'Rapporter B2B',
		'raport.notatki_etykieta' => 'Notater',
		'raport.produkty_zakupione_etykieta' => 'Produkter',
		'raport.status_etykieta' => 'STATUS : ',
		'wyslijPrzypomnienieWylogowanie.tresc_przypomnienia' => 'Hei {IMIE_LIDERA} det er bare etter {AKTUALNA_GODZINA} og laget ditt er fortsatt logget siden {GODZINA_ZALOGOWANIA} {DATA_ZALOGOWANIA} i ordre: {ORDER_ID} ({ORDER_POSTCODE} {ORDER_CITY}, {ORDER_ADDRESS}). Ikke glem å logge ut og avslutte arbeidsdagen!',
		'wyslijPrzypomnienieWylogowanie.tresc_przypomnienia_nie_zamkniety_dzien' => 'Hei {IMIE_LIDERA}, du har logget deg ut av alle bestillinger, kan du også huske å avslutte arbeidsdagen.',
		'wyslijPrzypomnienieZaloguj.tresc_przypomnienia' => 'Hei {IMIE_LIDERA} det er bare {AKTUALNA_GODZINA} og laget ditt er fortsatt ikke logget på systemet. Du har et ordre om å utføre i dag.',
		
		'_akcje_etykiety_' => array(
			'wykonajWyslijPrzypomnienieWylogowanie' => 'Send påminnelse om Logg ut nødvendighet',
			'wykonajRaport' => 'Raport B2B',
			'wykonajWyslijInfoTeamyNieZalogowane' => 'Send informasjon om ikke logget lag',
			'wykonajWyslijPrzypomnienieZalogowanie' => 'Send påminnelse om Logg nødvendighet'
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}