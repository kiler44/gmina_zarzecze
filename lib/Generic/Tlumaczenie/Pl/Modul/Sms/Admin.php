<?php
namespace Generic\Tlumaczenie\Pl\Modul\Sms;

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
		'formularzSzukaj.czysc.wartosc' => 'Czyść',
		'formularzSzukaj.szukaj.wartosc' => 'Szukaj',
		'historiaWiadomosci.bledne_id_uzytkownika' => 'Strona historii kontaktów nie może być wyświetlona. Użytkownik nie został odnaleziony',
		'historiaWiadomosci.etykieta_brak_wynikow' => 'Dla wybranego zakresu dat nie ma żadnych wiadomości.',
		'historiaWiadomosci.etykieta_brak_wynikow_filtr' => 'Brak wyników',
		'historiaWiadomosci.etykieta_data_do' => 'do:',
		'historiaWiadomosci.etykieta_data_od' => 'Od:',
		'historiaWiadomosci.etykieta_historia_kontaktow' => 'Historia komunikacji z:',
		'historiaWiadomosci.etykieta_naglowek' => 'Lista wysłanych wiadomości',
		'historiaWiadomosci.etykieta_placeholder' => 'Filtruj wyniki',
		'historiaWiadomosci.etykieta_starsze' => 'Ładuj starsze...',
		'historiaWiadomosci.etykieta_zamknij_historie' => 'Zamknij widok historii',
		'historiaWiadomosci.nazwa_wyswietlania' => '{IMIE} {NAZWISKO}, tel: {TELEFON}, e-mail: {EMAIL}',
		'historiaWiadomosci.tytul_modulu' => 'Histaria komunikacji',
		'historiaWiadomosci.tytul_strony' => 'Historia komunikacji',
		'index.date_sent' => 'Data wysłania',
		'index.etykieta_potwierdz_usun' => 'Czy napewno chcesz usunąć wiadomość sms?',
		'index.message' => 'Treść wiadomości',
		'index.recipient_number' => 'Numer odbiorcy',
		'index.sender_number' => 'Numer nadawcy',
		'index.sent' => 'Wysłany',
		'index.status_info' => 'Status',
		'index.tabela_etykieta_usun' => 'Usuń',
		'index.type' => 'Kategoria',
		'index.tytul_modulu' => 'Lista sms',
		'index.tytul_strony' => 'Lista sms',
		'wyslijWiadomosci.blad_wyslania_email' => 'Email nie wysłany! Odbiorca: "{ODBIORCA}".',
		'wyslijWiadomosci.blad_wyslania_sms' => 'SMS nie wysłany! Odbiorca: "{ODBIORCA}", powód: {BLAD}.',
		'wyslijWiadomosci.niepoprawny_rodzaj_wysylki' => 'Błąd! Wybrany błędny typ wiadomości. Dozwolony (SMS lub e-mail). ',
		'wyslijWiadomosci.sukces_wiadomosci_wyslane' => 'Wiadomość(ci) zostały wysłane.',
		'wyslijWiadomosci.tytulWiadomosciEmail' => '{NADAWCA}{ID_GET}{ID_BKT} - Sent from BKT AS CRM System',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista sms',
		),
		'historiaWiadomosci.etykiety_statusow' => array(
			'sent' => 'Wysłana',
			'not_sent' => 'Nie wysłana',
		),
		'kategorie_sms' => array(
			'orders_get_done' => 'Zakończono zadanie (villa instalation get)',
		),
		'wiadomosc_wyslana' => array(
			'0' => 'Nie',
			'1' => 'Tak',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}