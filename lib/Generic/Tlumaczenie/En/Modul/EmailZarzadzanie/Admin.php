<?php
namespace Generic\Tlumaczenie\En\Modul\EmailZarzadzanie;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.blad_nie_mozna_zapisac_formatki']
 * @property string $t['dodaj.info_formatka_zapisana']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['dodajSzablon.blad_nie_mozna_zapisac_szablonu']
 * @property string $t['dodajSzablon.info_dodano_szablon']
 * @property string $t['dodajSzablon.tytul_strony']
 * @property string $t['edytuj.blad_brak_formatki']
 * @property string $t['edytuj.blad_nie_mozna_zapisac_formatki']
 * @property string $t['edytuj.info_formatka_zapisana']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['edytujSzablon.blad_brak_szablonu']
 * @property string $t['edytujSzablon.blad_nie_mozna_zapisac_szablon']
 * @property string $t['edytujSzablon.info_zmieniono_szablon']
 * @property string $t['edytujSzablon.tytul_strony']
 * @property string $t['formularz.bledyLicznik.etykieta']
 * @property string $t['formularz.bledyLicznik.opis']
 * @property string $t['formularz.bledyOpis.etykieta']
 * @property string $t['formularz.bledyOpis.opis']
 * @property string $t['formularz.bledy_wiadomosci.zakladka']
 * @property string $t['formularz.dane_podstawowe.zakladka']
 * @property string $t['formularz.emailKopie.etykieta']
 * @property string $t['formularz.emailKopie.opis']
 * @property string $t['formularz.emailKopieUkryte.etykieta']
 * @property string $t['formularz.emailKopieUkryte.opis']
 * @property string $t['formularz.emailNadawcaEmail.etykieta']
 * @property string $t['formularz.emailNadawcaEmail.opis']
 * @property string $t['formularz.emailNadawcaNazwa.etykieta']
 * @property string $t['formularz.emailNadawcaNazwa.opis']
 * @property string $t['formularz.emailOdbiorcy.etykieta']
 * @property string $t['formularz.emailOdbiorcy.opis']
 * @property string $t['formularz.emailOdpowiedzi.etykieta']
 * @property string $t['formularz.emailOdpowiedzi.opis']
 * @property string $t['formularz.emailPotwierdzenieEmail.etykieta']
 * @property string $t['formularz.emailPotwierdzenieEmail.opis']
 * @property string $t['formularz.emailSzablon.etykieta']
 * @property string $t['formularz.emailSzablon.opis']
 * @property string $t['formularz.emailTrescHtml.etykieta']
 * @property string $t['formularz.emailTrescHtml.opis']
 * @property string $t['formularz.emailTrescTxt.etykieta']
 * @property string $t['formularz.emailTrescTxt.opis']
 * @property string $t['formularz.emailTytul.etykieta']
 * @property string $t['formularz.emailTytul.opis']
 * @property string $t['formularz.emailZalaczniki.etykieta']
 * @property string $t['formularz.emailZalaczniki.opis']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.idFormatki.etykieta']
 * @property string $t['formularz.idFormatki.opis']
 * @property string $t['formularz.info_brak_aktywnych_szablonow_email']
 * @property string $t['formularz.info_zawiera_bledy']
 * @property string $t['formularz.kategoria.etykieta']
 * @property string $t['formularz.kategoria.opis']
 * @property string $t['formularz.odbiorcy_wiadomosci.zakladka']
 * @property string $t['formularz.opis.etykieta']
 * @property string $t['formularz.opis.opis']
 * @property string $t['formularz.podpowiedz.wartosc']
 * @property string $t['formularz.tresc_wiadomosci.zakladka']
 * @property string $t['formularz.typAlgorytmu.etykieta']
 * @property string $t['formularz.typAlgorytmu.opis']
 * @property string $t['formularz.typWysylania.etykieta']
 * @property string $t['formularz.typWysylania.opis']
 * @property string $t['formularz.tytul.etykieta']
 * @property string $t['formularz.tytul.opis']
 * @property string $t['formularz.usunWpis.wartosc']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.wyslijPonownieWpis.wartosc']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularzSzablon.aktywny.etykieta']
 * @property string $t['formularzSzablon.aktywny.opis']
 * @property string $t['formularzSzablon.info_zawiera_bledy']
 * @property string $t['formularzSzablon.nazwa.etykieta']
 * @property string $t['formularzSzablon.nazwa.opis']
 * @property string $t['formularzSzablon.podgladHtml.wartosc']
 * @property string $t['formularzSzablon.podgladTxt.wartosc']
 * @property string $t['formularzSzablon.trescHtml.etykieta']
 * @property string $t['formularzSzablon.trescHtml.opis']
 * @property string $t['formularzSzablon.trescTxt.etykieta']
 * @property string $t['formularzSzablon.trescTxt.opis']
 * @property string $t['formularzSzablon.wstecz.wartosc']
 * @property string $t['formularzSzablon.zapisz.wartosc']
 * @property string $t['index.czysc.wartosc']
 * @property string $t['index.data_dodania.etykieta']
 * @property string $t['index.email.etykieta']
 * @property string $t['index.etykieta_data_dodania']
 * @property string $t['index.etykieta_kategoria']
 * @property string $t['index.etykieta_link_dodaj']
 * @property string $t['index.etykieta_link_kolejka']
 * @property string $t['index.etykieta_link_szablony']
 * @property string $t['index.etykieta_select_wybierz']
 * @property string $t['index.etykieta_typ_wysylania']
 * @property string $t['index.etykieta_tytul']
 * @property string $t['index.fraza.etykieta']
 * @property string $t['index.kategoria_rowne_.etykieta']
 * @property string $t['index.szukaj.wartosc']
 * @property string $t['index.typ_wysylania_rowne_.etykieta']
 * @property string $t['index.tytul_strony']
 * @property string $t['kolejka.bledy_wiersz']
 * @property string $t['kolejka.czysc.wartosc']
 * @property string $t['kolejka.data_dodania.etykieta']
 * @property string $t['kolejka.email.etykieta']
 * @property string $t['kolejka.etykieta_bledy']
 * @property string $t['kolejka.etykieta_data_dodania']
 * @property string $t['kolejka.etykieta_email_tytul']
 * @property string $t['kolejka.etykieta_select_wybierz']
 * @property string $t['kolejka.etykieta_typ_wysylania']
 * @property string $t['kolejka.fraza.etykieta']
 * @property string $t['kolejka.szukaj.wartosc']
 * @property string $t['kolejka.typ_wysylania_rowne_.etykieta']
 * @property string $t['kolejka.tytul_strony']
 * @property string $t['podglad.blad_brak_wpisu_kolejki']
 * @property string $t['podglad.brak_formatki']
 * @property string $t['podglad.etykieta_link_formatka']
 * @property string $t['podglad.tytul_strony']
 * @property string $t['szablony.etykieta_aktywny']
 * @property string $t['szablony.etykieta_edytuj']
 * @property string $t['szablony.etykieta_link_dodaj']
 * @property string $t['szablony.etykieta_nazwa']
 * @property string $t['szablony.etykieta_potwierdz_usun']
 * @property string $t['szablony.etykieta_usun']
 * @property string $t['szablony.tytul_strony']
 * @property string $t['usun.blad_brak_formatki']
 * @property string $t['usun.blad_nie_mozna_usunac_formatki']
 * @property string $t['usun.info_formatka_usunieta']
 * @property string $t['usunSzablon.blad_brak_szablonu']
 * @property string $t['usunSzablon.blad_nie_mozna_usunac_szablonu']
 * @property string $t['usunSzablon.info_istnieja_powiazane_formatki']
 * @property string $t['usunSzablon.info_szablon_usuniety']
 * @property string $t['usunWpis.blad_brak_wpisu']
 * @property string $t['usunWpis.blad_nie_mozna_usunac_wpisu']
 * @property string $t['usunWpis.info_wpis_usuniety']
 * @property string $t['usunZalacznik.blad_brak_formatki']
 * @property string $t['usunZalacznik.blad_brak_zalacznika']
 * @property string $t['usunZalacznik.blad_nie_mozna_usunac_zalacznika']
 * @property string $t['usunZalacznik.info_zalacznik_usuniety']
 * @property string $t['wyslijPonownie.blad_nie_mozna_wyslac_wiadomosci']
 * @property string $t['wyslijPonownie.info_wiadomosc_wyslana']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajUsunZalacznik']
 * @property string $t['_akcje_etykiety_']['wykonajSzablony']
 * @property string $t['_akcje_etykiety_']['wykonajDodajSzablon']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujSzablon']
 * @property string $t['_akcje_etykiety_']['wykonajUsunSzablon']
 * @property string $t['_akcje_etykiety_']['wykonajKolejka']
 * @property string $t['_akcje_etykiety_']['wykonajPodglad']
 * @property string $t['_akcje_etykiety_']['wykonajPodgladFormatki']
 * @property array $t['_zdarzenia_etykiety_']
 * @property array $t['formatka.data_dodania_opcje']
 * @property string $t['formatka.data_dodania_opcje']['7']
 * @property string $t['formatka.data_dodania_opcje']['14']
 * @property string $t['formatka.data_dodania_opcje']['31']
 * @property array $t['formatka.kategorie']
 * @property string $t['formatka.kategorie']['rejestracja']
 * @property string $t['formatka.kategorie']['obsluga_klienta']
 * @property string $t['formatka.kategorie']['wewnetrzne']
 * @property string $t['formatka.kategorie']['powiadomienia_uzytkownika']
 * @property string $t['formatka.kategorie']['powiadomienia_przedstawicieli']
 * @property string $t['formatka.kategorie']['powiadomienia_dok']
 * @property array $t['formatka.predefiniowani_odbiorcy']
 * @property string $t['formatka.predefiniowani_odbiorcy']['{KLIENT}']
 * @property string $t['formatka.predefiniowani_odbiorcy']['{HANDLOWIEC}']
 * @property string $t['formatka.predefiniowani_odbiorcy']['{OPIEKUN}']
 * @property string $t['formatka.predefiniowani_odbiorcy']['{NADAWCA_WIADOMOSCI}']
 * @property string $t['formatka.predefiniowani_odbiorcy']['{ODBIORCA_WIADOMOSCI}']
 * @property array $t['formatka.typy_wysylania']
 * @property string $t['formatka.typy_wysylania']['natychmiast']
 * @property string $t['formatka.typy_wysylania']['cron']
 * @property array $t['szablon.aktywny_opcje']
 * @property string $t['szablon.aktywny_opcje']['0']
 * @property string $t['szablon.aktywny_opcje']['1']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'dodaj.blad_nie_mozna_zapisac_formatki' => 'Error while saving e-mail pattern',
		'dodaj.info_formatka_zapisana' => 'New e-mail pattern saved',
		'dodaj.tytul_strony' => 'New e-mail pattern',

		'dodajSzablon.blad_nie_mozna_zapisac_szablonu' => 'Error while saving template',
		'dodajSzablon.info_dodano_szablon' => 'New template added',
		'dodajSzablon.tytul_strony' => 'New template',

		'edytuj.blad_brak_formatki' => 'Cannot obtain e-mail pattern',
		'edytuj.blad_nie_mozna_zapisac_formatki' => 'Error while saving e-mail pattern',
		'edytuj.info_formatka_zapisana' => 'E-mail pattern saved',
		'edytuj.tytul_strony' => 'Edit e-mail pattern: %s',

		'edytujSzablon.blad_brak_szablonu' => 'Cannot obtain e-mail template',
		'edytujSzablon.blad_nie_mozna_zapisac_szablon' => 'Error while saving template',
		'edytujSzablon.info_zmieniono_szablon' => 'E-mail template saved',
		'edytujSzablon.tytul_strony' => 'Edit template: %s',

		'formularz.bledyLicznik.etykieta' => 'Count of send failure',
		'formularz.bledyLicznik.opis' => '',
		'formularz.bledyOpis.etykieta' => 'Error description',
		'formularz.bledyOpis.opis' => 'Error descriptions while sending e-mail messages',
		'formularz.bledy_wiadomosci.zakladka' => 'Message errors',
		'formularz.dane_podstawowe.zakladka' => 'General data',
		'formularz.emailKopie.etykieta' => 'Copies',
		'formularz.emailKopie.opis' => 'E-mail copy recipients.',
		'formularz.emailKopieUkryte.etykieta' => 'Hidden copies',
		'formularz.emailKopieUkryte.opis' => 'E-mail hidden copy recipients',
		'formularz.emailNadawcaEmail.etykieta' => 'Sender e-mail',
		'formularz.emailNadawcaEmail.opis' => 'Address which goes to from field',
		'formularz.emailNadawcaNazwa.etykieta' => 'Sender name',
		'formularz.emailNadawcaNazwa.opis' => 'Name which goes to from name field:',
		'formularz.emailOdbiorcy.etykieta' => 'Recipients',
		'formularz.emailOdbiorcy.opis' => '',
		'formularz.emailOdpowiedzi.etykieta' => 'E-mail reply to',
		'formularz.emailOdpowiedzi.opis' => '',
		'formularz.emailPotwierdzenieEmail.etykieta' => 'Email reception confirmation address',
		'formularz.emailPotwierdzenieEmail.opis' => 'E-mail address on which confirmation will be sent',
		'formularz.emailSzablon.etykieta' => 'Header and footer template',
		'formularz.emailSzablon.opis' => '',
		'formularz.emailTrescHtml.etykieta' => 'HTML message',
		'formularz.emailTrescHtml.opis' => 'You can use variables which will be replaced witch their respective values',
		'formularz.emailTrescTxt.etykieta' => 'Txt message',
		'formularz.emailTrescTxt.opis' => 'You can use variables which will be replaced witch their respective values',
		'formularz.emailTytul.etykieta' => 'Message title',
		'formularz.emailTytul.opis' => '',
		'formularz.emailZalaczniki.etykieta' => 'Attachements',
		'formularz.emailZalaczniki.opis' => '',
		'formularz.etykieta_select_wybierz' => '- select -',
		'formularz.idFormatki.etykieta' => 'E-mail pattern',
		'formularz.idFormatki.opis' => 'E-mail pattern to use for send',
		'formularz.info_brak_aktywnych_szablonow_email' => 'No active templates. It is not possible to create pattern',
		'formularz.info_zawiera_bledy' => 'Form not filled completely',
		'formularz.kategoria.etykieta' => 'Pattern category',
		'formularz.kategoria.opis' => '',
		'formularz.odbiorcy_wiadomosci.zakladka' => 'E-mail recipients',
		'formularz.opis.etykieta' => 'Pattern description',
		'formularz.opis.opis' => 'Additional description for Admin',
		'formularz.podpowiedz.wartosc' => 'Hint',
		'formularz.tresc_wiadomosci.zakladka' => 'Message',
		'formularz.typAlgorytmu.etykieta' => 'Send algorithm',
		'formularz.typAlgorytmu.opis' => '',
		'formularz.typWysylania.etykieta' => 'send mode',
		'formularz.typWysylania.opis' => 'Send immediately or witch some time intervals',
		'formularz.tytul.etykieta' => 'Pattern name',
		'formularz.tytul.opis' => '',
		'formularz.usunWpis.wartosc' => 'Delete',
		'formularz.wstecz.wartosc' => 'Back',
		'formularz.wyslijPonownieWpis.wartosc' => 'Send again',
		'formularz.zapisz.wartosc' => 'Save',

		'formularzSzablon.aktywny.etykieta' => 'Active template',
		'formularzSzablon.aktywny.opis' => '',
		'formularzSzablon.info_zawiera_bledy' => 'Form not filled completely',
		'formularzSzablon.nazwa.etykieta' => 'Template name',
		'formularzSzablon.nazwa.opis' => '',
		'formularzSzablon.podgladHtml.wartosc' => 'HTML preview',
		'formularzSzablon.podgladTxt.wartosc' => 'Txt preview',
		'formularzSzablon.trescHtml.etykieta' => 'HTML content',
		'formularzSzablon.trescHtml.opis' => 'Must contain variable {TRESC}',
		'formularzSzablon.trescTxt.etykieta' => 'Txt content',
		'formularzSzablon.trescTxt.opis' => 'Must contain variable {TRESC}',
		'formularzSzablon.wstecz.wartosc' => 'Back',
		'formularzSzablon.zapisz.wartosc' => 'Save',

		'index.czysc.wartosc' => 'Clear',
		'index.data_dodania.etykieta' => 'Add date',
		'index.email.etykieta' => 'E-mail',
		'index.etykieta_data_dodania' => 'Add date',
		'index.etykieta_kategoria' => 'Category',
		'index.etykieta_link_dodaj' => 'Add new pattern',
		'index.etykieta_link_kolejka' => 'E-mail queue',
		'index.etykieta_link_szablony' => 'E-mail template',
		'index.etykieta_select_wybierz' => '- select -',
		'index.etykieta_typ_wysylania' => 'Send mode',
		'index.etykieta_tytul' => 'Title',
		'index.fraza.etykieta' => 'Phrase',
		'index.kategoria_rowne_.etykieta' => 'Category',
		'index.szukaj.wartosc' => 'Search',
		'index.typ_wysylania_rowne_.etykieta' => 'Send mode',
		'index.tytul_strony' => 'E-mail pattern management',

		'kolejka.bledy_wiersz' => '<strong>ERRORS - %d</strong>',
		'kolejka.czysc.wartosc' => 'Clear',
		'kolejka.data_dodania.etykieta' => 'Add date',
		'kolejka.email.etykieta' => 'E-mail',
		'kolejka.etykieta_bledy' => 'Errors',
		'kolejka.etykieta_data_dodania' => 'Add date',
		'kolejka.etykieta_email_tytul' => 'Message title',
		'kolejka.etykieta_select_wybierz' => '- select -',
		'kolejka.etykieta_typ_wysylania' => 'Send mode',
		'kolejka.fraza.etykieta' => 'Phrase',
		'kolejka.szukaj.wartosc' => 'Search',
		'kolejka.typ_wysylania_rowne_.etykieta' => 'Send mode',
		'kolejka.tytul_strony' => 'E-mail queue',

		'podglad.blad_brak_wpisu_kolejki' => 'Queue item removed',
		'podglad.brak_formatki' => 'No pattern assigned to this e-mail',
		'podglad.etykieta_link_formatka' => 'Pattern preview',
		'podglad.tytul_strony' => 'Queue item preview',

		'szablony.etykieta_aktywny' => 'Active',
		'szablony.etykieta_edytuj' => 'Edit',
		'szablony.etykieta_link_dodaj' => 'Add new template',
		'szablony.etykieta_nazwa' => 'Template name',
		'szablony.etykieta_potwierdz_usun' => 'Do you want to remove selected template?',
		'szablony.etykieta_usun' => 'Delete',
		'szablony.tytul_strony' => 'E-mail template management',

		'usun.blad_brak_formatki' => 'cannot obtain template data',
		'usun.blad_nie_mozna_usunac_formatki' => 'Cannot remove selected template!',
		'usun.info_formatka_usunieta' => 'E-mail template removed',

		'usunSzablon.blad_brak_szablonu' => 'Nie można pobrać danych szablonu email',
		'usunSzablon.blad_nie_mozna_usunac_szablonu' => 'Nie można usunąć danych szablonu email',
		'usunSzablon.info_istnieja_powiazane_formatki' => 'This template is used by some e-mail patterns',
		'usunSzablon.info_szablon_usuniety' => 'template removed',

		'usunWpis.blad_brak_wpisu' => 'Cannot obtain queue item data',
		'usunWpis.blad_nie_mozna_usunac_wpisu' => 'Cannot remove queue item!',
		'usunWpis.info_wpis_usuniety' => 'Queue item removed',

		'usunZalacznik.blad_brak_formatki' => 'Cannot obtain e-mail pattern data',
		'usunZalacznik.blad_brak_zalacznika' => 'Pattern attachement not found',
		'usunZalacznik.blad_nie_mozna_usunac_zalacznika' => 'Cannot remove pattern attachement!',
		'usunZalacznik.info_zalacznik_usuniety' => 'Pattern attachement removed',

		'wyslijPonownie.blad_nie_mozna_wyslac_wiadomosci' => 'E-mail cannot be sent',
		'wyslijPonownie.info_wiadomosc_wyslana' => 'Message sent',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Patterns list',
			'wykonajDodaj' => 'Create pattern',
			'wykonajEdytuj' => 'Edit pattern',
			'wykonajUsun' => 'Delete pattern',
			'wykonajUsunZalacznik' => 'Pattern attachement delete',
			'wykonajSzablony' => 'templates list',
			'wykonajDodajSzablon' => 'Create template',
			'wykonajEdytujSzablon' => 'Edit template',
			'wykonajUsunSzablon' => 'Delete template',
			'wykonajKolejka' => 'E-mail queue',
			'wykonajPodglad' => 'E-mail queue item preview',
			'wykonajPodgladFormatki' => 'Preview of pattern with template',
		),

		'_zdarzenia_etykiety_' => array(
		),

		'formatka.data_dodania_opcje' => array(
			'7' => 'Last week',
			'14' => 'Last two weeks',
			'31' => 'Last month',
		),
		'formatka.kategorie' => array(
			'rejestracja' => 'Rejestracja',
			'obsluga_klienta' => 'Obsługa klienta',
			'wewnetrzne' => 'Wiadomości wewnętrzne',
			'powiadomienia_uzytkownika' => 'Powiadomienia Użytkownika',
			'powiadomienia_przedstawicieli' => 'Powiadomienia Przedstawicieli',
			'powiadomienia_dok' => 'Powiadomienia DOK',
		),
		'formatka.predefiniowani_odbiorcy' => array(
			'{KLIENT}' => 'PRIVATE CUSTOMER',
			'{KLIENT_FAKTURA}' => 'BILLING CUSTOMER',
			'{KLIENT_OSOBA_KONTAKTOWA}' => 'CUSTOMER CONTACT PERSON',
			'{KLIENT_WYSLIJ_FAKTURA}' => 'CUSTOMER SEND INVOICE',
			'{KIEROWNIK_PROJEKTU_GET}' => 'PROJECT LEADER GET',
			'{KOORDYNATOR_BKT}' => 'COORDINATOR BKT',
			'{KOORDYNATOR_BKT_STARY}' => 'PREVIOUS COORDINATOR BKT',
			'{NADAWCA_WIADOMOSCI}' => 'EMAIL SENDER',
			'{ODBIORCA_WIADOMOSCI}' => 'EMAIL RECIPIENT',
			'{TEAM}' => 'TEAM',
			'{NEW_TEAM}' => 'NEW TEAM',
			'{PREVIOUS_TEAM}' => 'PREVIOUS TEAM',
			'{UZYTKOWNIK}' => 'USER',
			'{OPIEKUN_MAGAZYNU}' => 'STORE KEEPER',
		),
		'formatka.typy_wysylania' => array(
			'natychmiast' => 'Immediately',
			'cron' => 'Via cron',
		),

		'szablon.aktywny_opcje' => array(
			'0' => 'no',
			'1' => 'yes',
		),
	);
}
