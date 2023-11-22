<?php
namespace Generic\Tlumaczenie\No\Modul\Sms;

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
		'formularzSzukaj.czysc.wartosc' => 'Klar',
		'formularzSzukaj.szukaj.wartosc' => 'Søk',
		'historiaWiadomosci.bledne_id_uzytkownika' => 'Kontakt side kan ikke vises - selecter brukeren ble ikke funnet',
		'historiaWiadomosci.etykieta_brak_wynikow' => 'Det er ingen meldinger som skal vises for den valgte datoer rekkevidde.',
		'historiaWiadomosci.etykieta_brak_wynikow_filtr' => 'Ingen resultater',
		'historiaWiadomosci.etykieta_data_do' => 'til:',
		'historiaWiadomosci.etykieta_data_od' => 'Fra:',
		'historiaWiadomosci.etykieta_historia_kontaktow' => 'Meldinger historie for:',
		'historiaWiadomosci.etykieta_naglowek' => 'Liste over sendte meldinger:',
		'historiaWiadomosci.etykieta_placeholder' => 'Skriv for å filtrere resultatene',
		'historiaWiadomosci.etykieta_starsze' => 'Les eldre ...',
		'historiaWiadomosci.etykieta_zamknij_historie' => 'Lukk historie side',
		'historiaWiadomosci.nazwa_wyswietlania' => '{IMIE} {NAZWISKO}, tlf: {TELEFON}, e-mail: {EMAIL}',
		'historiaWiadomosci.tytul_modulu' => 'Meldinger historie',
		'historiaWiadomosci.tytul_strony' => 'Meldinger historie',
		'index.date_sent' => 'Dato sendt',
		'index.etykieta_potwierdz_usun' => 'Er du sikker på at du vil slette en SMS ?',
		'index.message' => 'Melding',
		'index.recipient_number' => 'Mottaker nummer',
		'index.sender_number' => 'Avsender nummer',
		'index.sent' => 'Sendte',
		'index.status_info' => 'Status',
		'index.tabela_etykieta_usun' => 'Slett',
		'index.type' => 'Kategori',
		'index.tytul_modulu' => 'List sms-melding',
		'index.tytul_strony' => 'List sms-melding',
		'wyslijWiadomosci.blad_wyslania_email' => 'Email not sent! Recipient: "{ODBIORCA}".',
		'wyslijWiadomosci.blad_wyslania_sms' => 'SMS not sent! Recipient: "{ODBIORCA}", reason: {BLAD}.',
		'wyslijWiadomosci.niepoprawny_rodzaj_wysylki' => 'Error! Wrong message type selected (SMS or e-mail). ',
		'wyslijWiadomosci.sukces_wiadomosci_wyslane' => 'Message(s) sent successfully.',
		'wyslijWiadomosci.tytulWiadomosciEmail' => '{NADAWCA}{ID_GET}{ID_BKT} - Sent from BKT AS CRM System',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'List sms-melding',
		),
		'historiaWiadomosci.etykiety_statusow' => array(
			'sent' => 'Sendt',
			'not_sent' => 'Ikke sendt',
		),
		'kategorie_sms' => array(
			'orders_get_done' => 'Lukk bestillinger (villa instalation get)',
		),
		'wiadomosc_wyslana' => array(
			'0' => 'Nei',
			'1' => 'Ja',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}