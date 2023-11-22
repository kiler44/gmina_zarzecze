<?php
namespace Generic\Tlumaczenie\En\Modul\Sms;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['formularzSzukaj.czysc.wartosc']
 * @property string $t['formularzSzukaj.szukaj.wartosc']
 * @property string $t['historiaWiadomosci.bledne_id_uzytkownika']
 * @property string $t['historiaWiadomosci.etykieta_brak_wynikow']
 * @property string $t['historiaWiadomosci.etykieta_brak_wynikow_filtr']
 * @property string $t['historiaWiadomosci.etykieta_data_do']
 * @property string $t['historiaWiadomosci.etykieta_data_od']
 * @property string $t['historiaWiadomosci.etykieta_historia_kontaktow']
 * @property string $t['historiaWiadomosci.etykieta_naglowek']
 * @property string $t['historiaWiadomosci.etykieta_placeholder']
 * @property string $t['historiaWiadomosci.etykieta_starsze']
 * @property string $t['historiaWiadomosci.etykieta_zamknij_historie']
 * @property string $t['historiaWiadomosci.nazwa_wyswietlania']
 * @property string $t['historiaWiadomosci.tytul_modulu']
 * @property string $t['historiaWiadomosci.tytul_strony']
 * @property string $t['index.date_sent']
 * @property string $t['index.etykieta_potwierdz_usun']
 * @property string $t['index.message']
 * @property string $t['index.recipient_number']
 * @property string $t['index.sender_number']
 * @property string $t['index.sent']
 * @property string $t['index.status_info']
 * @property string $t['index.tabela_etykieta_usun']
 * @property string $t['index.type']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['wyslijWiadomosci.blad_wyslania_email']
 * @property string $t['wyslijWiadomosci.blad_wyslania_sms']
 * @property string $t['wyslijWiadomosci.niepoprawny_rodzaj_wysylki']
 * @property string $t['wyslijWiadomosci.sukces_wiadomosci_wyslane']
 * @property string $t['wyslijWiadomosci.tytulWiadomosciEmail']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property array $t['historiaWiadomosci.etykiety_statusow']
 * @property string $t['historiaWiadomosci.etykiety_statusow']['sent']
 * @property string $t['historiaWiadomosci.etykiety_statusow']['not_sent']
 * @property array $t['kategorie_sms']
 * @property string $t['kategorie_sms']['orders_get_done']
 * @property array $t['wiadomosc_wyslana']
 * @property string $t['wiadomosc_wyslana']['0']
 * @property string $t['wiadomosc_wyslana']['1']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'formularzSzukaj.czysc.wartosc' => 'Clear',
		'formularzSzukaj.szukaj.wartosc' => 'Search',
		'historiaWiadomosci.bledne_id_uzytkownika' => 'Contact page cannot be displayed - selecter user was not found',
		'historiaWiadomosci.etykieta_brak_wynikow' => 'There are no messages to be displayed for selected dates range.',
		'historiaWiadomosci.etykieta_brak_wynikow_filtr' => 'No results',
		'historiaWiadomosci.etykieta_data_do' => 'to:',
		'historiaWiadomosci.etykieta_data_od' => 'From:',
		'historiaWiadomosci.etykieta_historia_kontaktow' => 'Messaging history for:',
		'historiaWiadomosci.etykieta_naglowek' => 'List of sent messages:',
		'historiaWiadomosci.etykieta_placeholder' => 'Type to filter results',
		'historiaWiadomosci.etykieta_starsze' => 'Read older...',
		'historiaWiadomosci.etykieta_zamknij_historie' => 'Close history page',
		'historiaWiadomosci.nazwa_wyswietlania' => '{IMIE} {NAZWISKO}, phone: {TELEFON}, e-mail: {EMAIL}',
		'historiaWiadomosci.tytul_modulu' => 'Messaging history',
		'historiaWiadomosci.tytul_strony' => 'Messaging history',
		'index.date_sent' => 'Date sent',
		'index.etykieta_potwierdz_usun' => 'Are you sure you want to delete an SMS ?',
		'index.message' => 'Message',
		'index.recipient_number' => 'Recipient number',
		'index.sender_number' => 'Sender number',
		'index.sent' => 'Sent',
		'index.status_info' => 'Status',
		'index.tabela_etykieta_usun' => 'Delete',
		'index.type' => 'Category',
		'index.tytul_modulu' => 'List sms message',
		'index.tytul_strony' => 'List sms message',
		'wyslijWiadomosci.blad_wyslania_email' => 'Email not sent! Recipient: "{ODBIORCA}".',
		'wyslijWiadomosci.blad_wyslania_sms' => 'SMS not sent! Recipient: "{ODBIORCA}", reason: {BLAD}.',
		'wyslijWiadomosci.niepoprawny_rodzaj_wysylki' => 'Error! Wrong message type selected (SMS or e-mail). ',
		'wyslijWiadomosci.sukces_wiadomosci_wyslane' => 'Message(s) sent successfully.',
		'wyslijWiadomosci.tytulWiadomosciEmail' => '{NADAWCA}{ID_GET}{ID_BKT} - Sent from BKT AS CRM System',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'List sms message',
		),
		'historiaWiadomosci.etykiety_statusow' => array(
			'sent' => 'Sent',
			'not_sent' => 'Not sent',
		),
		'kategorie_sms' => array(
			'orders_get_done' => 'Close orders (villa instalation get)',
		),
		'wiadomosc_wyslana' => array(
			'0' => 'No',
			'1' => 'Yes',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}