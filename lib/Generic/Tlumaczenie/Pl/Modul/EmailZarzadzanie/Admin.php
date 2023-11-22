<?php
namespace Generic\Tlumaczenie\Pl\Modul\EmailZarzadzanie;

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
	
		'dodaj.blad_nie_mozna_zapisac_formatki' => 'Błąd przy zapisie formatki',
		'dodaj.info_formatka_zapisana' => 'Dodano nową formatkę',
		'dodaj.tytul_strony' => 'Nowa formatka',

		'dodajSzablon.blad_nie_mozna_zapisac_szablonu' => 'Błąd przy zapisie szablonu',
		'dodajSzablon.info_dodano_szablon' => 'Dodano nowy szablon',
		'dodajSzablon.tytul_strony' => 'Nowy szablon',

		'edytuj.blad_brak_formatki' => 'Nie można pobrać danych formatki email',
		'edytuj.blad_nie_mozna_zapisac_formatki' => 'Błąd przy zapisie formatki',
		'edytuj.info_formatka_zapisana' => 'Dane formatki zostały zapisane',
		'edytuj.tytul_strony' => 'Edycja formatki: %s',

		'edytujSzablon.blad_brak_szablonu' => 'Nie można pobrać danych szablonu email',
		'edytujSzablon.blad_nie_mozna_zapisac_szablon' => 'Błąd przy zapisie szablonu',
		'edytujSzablon.info_zmieniono_szablon' => 'Dane szablonu zostały zapisane',
		'edytujSzablon.tytul_strony' => 'Edycja szablonu: %s',

		'formularz.bledyLicznik.etykieta' => 'Ilość nieudanych prób wysłania',
		'formularz.bledyLicznik.opis' => '',
		'formularz.bledyOpis.etykieta' => 'Opis błedów',
		'formularz.bledyOpis.opis' => 'Opis błedów powstałych podczas prób wysyłania wiadomosci',
		'formularz.bledy_wiadomosci.zakladka' => 'Błędy wiadomości',
		'formularz.dane_podstawowe.zakladka' => 'Dane podstawowe',
		'formularz.emailKopie.etykieta' => 'Kopie',
		'formularz.emailKopie.opis' => 'Adresy email odbiorców kopii wiadomości. Mażna dodać własny adres lub wybrać adres z listy pracowników.',
		'formularz.emailKopieUkryte.etykieta' => 'Kopie ukryte',
		'formularz.emailKopieUkryte.opis' => 'Adresy email odbiorców kopii ukrytych wiadomości. Mażna dodać własny adres lub wybrać adres z listy pracowników.',
		'formularz.emailNadawcaEmail.etykieta' => 'Email nadawcy',
		'formularz.emailNadawcaEmail.opis' => 'Email który zostanie wstawiony w pole From:',
		'formularz.emailNadawcaNazwa.etykieta' => 'Nazwa nadawcy',
		'formularz.emailNadawcaNazwa.opis' => 'Nazwa nadawcy która zostanie wstawiony w pole From:',
		'formularz.emailOdbiorcy.etykieta' => 'Odbiorcy',
		'formularz.emailOdbiorcy.opis' => 'Adresy email odbiorców wiadomości. Mażna dodać własny adres lub wybrać adres z listy pracowników.',
		'formularz.emailOdpowiedzi.etykieta' => 'Emaile odpowiedź',
		'formularz.emailOdpowiedzi.opis' => 'Emaile które zostaną wstawione w pole Replay to:',
		'formularz.emailPotwierdzenieEmail.etykieta' => 'Email potwierdzenie',
		'formularz.emailPotwierdzenieEmail.opis' => 'Email na który zostanie wysłane potwierdzenie przeczytania wiadomości przez odbiorcę',
		'formularz.emailSzablon.etykieta' => 'Szablon nagłówka i stopki',
		'formularz.emailSzablon.opis' => 'Szablon określa treść nagłówka i stopki zarówno dla treści HTML ja i dla treści tekstowej.<br>Po przetworzeniu tresc wiadomości zostanie wstawiona do tego szablonu.',
		'formularz.emailTrescHtml.etykieta' => 'Treść HTML',
		'formularz.emailTrescHtml.opis' => 'Treść HTML wiadomości email.<br>Można używać zmiennych które zostaną sparsowanie na odpowiednie wartosci.<br>Zmienne zależne od typu wiadomości.</br>',
		'formularz.emailTrescTxt.etykieta' => 'Treść tekstowa',
		'formularz.emailTrescTxt.opis' => 'Treść tekstowa wiadomości email.<br>Można używać zmiennych które zostaną sparsowanie na odpowiednie wartosci.<br>Zmienne zależne od typu wiadomości.',
		'formularz.emailTytul.etykieta' => 'Tytuł wiadomości',
		'formularz.emailTytul.opis' => '',
		'formularz.emailZalaczniki.etykieta' => 'Plik załącznika',
		'formularz.emailZalaczniki.opis' => '',
		'formularz.etykieta_select_wybierz' => '- wybierz -',
		'formularz.idFormatki.etykieta' => 'Formatka',
		'formularz.idFormatki.opis' => 'Formatka z której została wysłana wiadomość',
		'formularz.info_brak_aktywnych_szablonow_email' => 'Nie znaleziono aktywnych szablonów wiadomości email.<br>Ustawienie szablonu dla formatki nie będzie możliwe.',
		'formularz.info_zawiera_bledy' => 'Formularz zawiera błędy',
		'formularz.kategoria.etykieta' => 'Kategoria formatki',
		'formularz.kategoria.opis' => 'Można przypisać kategorię dzięki której łatwiej będzie znaleźć powiązane ze sobą tematycznie wiadomości',
		'formularz.odbiorcy_wiadomosci.zakladka' => 'Odbiorcy wiadomości',
		'formularz.opis.etykieta' => 'Opis formatki',
		'formularz.opis.opis' => 'Dodatkowy opis dla administratora',
		'formularz.podpowiedz.wartosc' => 'Podpowiedź',
		'formularz.tresc_wiadomosci.zakladka' => 'Treść wiadomości',
		'formularz.typAlgorytmu.etykieta' => 'Algorytm wysyłający',
		'formularz.typAlgorytmu.opis' => '',
		'formularz.typWysylania.etykieta' => 'Tryb wysyłania',
		'formularz.typWysylania.opis' => 'Określa po jakim czasie wiadomość zostanie wysłana.<br/><b>Natychmiastowo</b> oznaczacza natychmiastowe wysłanie. Inne opcje powodują wysłanie emaila w pewnym odstępie czasowym.',
		'formularz.tytul.etykieta' => 'Tytuł formatki',
		'formularz.tytul.opis' => '',
		'formularz.usunWpis.wartosc' => 'Usuń',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.wyslijPonownieWpis.wartosc' => 'Wyślij ponownie',
		'formularz.zapisz.wartosc' => 'Zapisz',

		'formularzSzablon.aktywny.etykieta' => 'Szablon aktywny',
		'formularzSzablon.aktywny.opis' => '',
		'formularzSzablon.info_zawiera_bledy' => 'Formularz zawiera błędy',
		'formularzSzablon.nazwa.etykieta' => 'Nazwa szablonu',
		'formularzSzablon.nazwa.opis' => '',
		'formularzSzablon.podgladHtml.wartosc' => 'Podgląd',
		'formularzSzablon.podgladTxt.wartosc' => 'Podgląd',
		'formularzSzablon.trescHtml.etykieta' => 'Treść HTML',
		'formularzSzablon.trescHtml.opis' => 'Treść HTML szablonu email.<br>Musi zawierać tekst {TRESC}',
		'formularzSzablon.trescTxt.etykieta' => 'Treść tekstowa',
		'formularzSzablon.trescTxt.opis' => 'Treść tekstowa wiadomości email.<br>Musi zawierać tekst {TRESC}.',
		'formularzSzablon.wstecz.wartosc' => 'Wstecz',
		'formularzSzablon.zapisz.wartosc' => 'Zapisz',

		'index.czysc.wartosc' => 'Czyść',
		'index.data_dodania.etykieta' => 'Data dodania',
		'index.email.etykieta' => 'E-mail',
		'index.etykieta_data_dodania' => 'Data dodania',
		'index.etykieta_kategoria' => 'Kategoria',
		'index.etykieta_link_dodaj' => 'Dodaj nową formatkę',
		'index.etykieta_link_kolejka' => 'Kolejka wiadomości email',
		'index.etykieta_link_szablony' => 'Szablony email',
		'index.etykieta_select_wybierz' => '- wybierz -',
		'index.etykieta_typ_wysylania' => 'Tryb wysyłania',
		'index.etykieta_tytul' => 'Tytul',
		'index.fraza.etykieta' => 'Fraza',
		'index.kategoria_rowne_.etykieta' => 'Kategoria',
		'index.szukaj.wartosc' => 'Szukaj',
		'index.typ_wysylania_rowne_.etykieta' => 'Tryb wysyłania',
		'index.tytul_strony' => 'Zarzadzanie formatkami wiadomości email',

		'kolejka.bledy_wiersz' => '<strong>BŁĘDY - %d</strong>',
		'kolejka.czysc.wartosc' => 'Czyść',
		'kolejka.data_dodania.etykieta' => 'Data dodania',
		'kolejka.email.etykieta' => 'E-mail',
		'kolejka.etykieta_bledy' => 'Błedy',
		'kolejka.etykieta_data_dodania' => 'Data dodania',
		'kolejka.etykieta_email_tytul' => 'Tytuł wiadomości',
		'kolejka.etykieta_select_wybierz' => '- wybierz -',
		'kolejka.etykieta_typ_wysylania' => 'Sposób wysyłania',
		'kolejka.fraza.etykieta' => 'Fraza',
		'kolejka.szukaj.wartosc' => 'Szukaj',
		'kolejka.typ_wysylania_rowne_.etykieta' => 'Tryb wysyłania',
		'kolejka.tytul_strony' => 'Kolejka wiadomości email do wysłania',

		'podglad.blad_brak_wpisu_kolejki' => 'Wpis kolejki wiadomości email został usunięty',
		'podglad.brak_formatki' => 'Brak formatki powiązanej z wiadomością',
		'podglad.etykieta_link_formatka' => 'Podgląd formatki',
		'podglad.tytul_strony' => 'Podglad wpisu kolejki',

		'szablony.etykieta_aktywny' => 'Aktywny',
		'szablony.etykieta_edytuj' => 'Edytuj',
		'szablony.etykieta_link_dodaj' => 'Dodaj nowy szablon',
		'szablony.etykieta_nazwa' => 'Nazwa szablonu',
		'szablony.etykieta_potwierdz_usun' => 'Czy napewno usunąć wybrany szablon?',
		'szablony.etykieta_usun' => 'Usun',
		'szablony.tytul_strony' => 'Zarzadzanie szablonami wiadomości email',

		'usun.blad_brak_formatki' => 'Nie można pobrać danych formatki',
		'usun.blad_nie_mozna_usunac_formatki' => 'Nie można usunąć formatki!',
		'usun.info_formatka_usunieta' => 'Formatka wiadomości email została usunięta',

		'usunSzablon.blad_brak_szablonu' => 'Nie można pobrać danych szablonu email',
		'usunSzablon.blad_nie_mozna_usunac_szablonu' => 'Nie można usunąć danych szablonu email',
		'usunSzablon.info_istnieja_powiazane_formatki' => 'Istnieją formatki wykorzystujące ten szablon',
		'usunSzablon.info_szablon_usuniety' => 'Szablon wiadomości email został usunięty',

		'usunWpis.blad_brak_wpisu' => 'Nie można pobrać danych wpisu',
		'usunWpis.blad_nie_mozna_usunac_wpisu' => 'Nie można usunąć wpisu kolejki!',
		'usunWpis.info_wpis_usuniety' => 'Wpis kolejki wiadomości email został usunięty',

		'usunZalacznik.blad_brak_formatki' => 'Nie można pobrać danych formatki',
		'usunZalacznik.blad_brak_zalacznika' => 'Nie znaleziono załącznika formatki',
		'usunZalacznik.blad_nie_mozna_usunac_zalacznika' => 'Nie można usunąć załącznika formatki!',
		'usunZalacznik.info_zalacznik_usuniety' => 'Załącznika został usunięty z  formatki email',

		'wyslijPonownie.blad_nie_mozna_wyslac_wiadomosci' => 'Nie można wysłać wiadomości',
		'wyslijPonownie.info_wiadomosc_wyslana' => 'Wysłano wiadomość',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista formatek email',
			'wykonajDodaj' => 'Dodawanie formatek email',
			'wykonajEdytuj' => 'Edycja formatek email',
			'wykonajUsun' => 'Usuwanie formatek email',
			'wykonajUsunZalacznik' => 'Usuwanie załączników formatki email',
			'wykonajSzablony' => 'Lista szablonów email',
			'wykonajDodajSzablon' => 'Dodawanie szablonów email',
			'wykonajEdytujSzablon' => 'Edycja szablonów email',
			'wykonajUsunSzablon' => 'Usuwanie szablonów email',
			'wykonajKolejka' => 'Kolejka wiadomości email do wysłania',
			'wykonajPodglad' => 'Podgląd wiadomości z kolejki',
			'wykonajPodgladFormatki' => 'Podgląd tworzonej formatki z szablonem',
		),

		'_zdarzenia_etykiety_' => array(
		),

		'formatka.data_dodania_opcje' => array(
			'7' => 'Ostatni tydzień',
			'14' => 'Ostatnie dwa tygodnie',
			'31' => 'Ostatni miesiąc',
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
			'{KLIENT}' => 'PRYWATNY KLIENT',
			'{KLIENT_WYSLIJ_FAKTURA}' => 'KLIENT WYSLIJ FAKTURA',
			'{KLIENT_OSOBA_KONTAKTOWA}' => 'KLIENT OSOBA KONTAKTOWA',
			'{KLIENT_FAKTURA}' => 'ZAMAWIAJĄCY',
			'{KIEROWNIK_PROJEKTU_GET}' => 'LIDER PROJEKTU GET',
			'{KOORDYNATOR_BKT}' => 'KOORDYNATOR BKT',
			'{KOORDYNATOR_BKT_STARY}' => 'POPRZEDNI KOORDYNATOR BKT',
			'{NADAWCA_WIADOMOSCI}' => 'NADAWCA WIADOMOŚCI',
			'{ODBIORCA_WIADOMOSCI}' => 'ODBIORCA WIADOMOŚCI',
			'{TEAM}' => 'EKIPA',
			'{NEW_TEAM}' => 'NOWY ZESPÓŁ',
			'{PREVIOUS_TEAM}' => 'STARY ZESPÓŁ',
			'{UZYTKOWNIK}' => 'UŻYTKOWNIK',
			'{OPIEKUN_MAGAZYNU}' => 'OPIEKUN MAGAZYNU',
		),
		'formatka.typy_wysylania' => array(
			'natychmiast' => 'Natychmiastowo',
			'cron' => 'Zadania cykliczne',
		),

		'szablon.aktywny_opcje' => array(
			'0' => 'nie',
			'1' => 'tak',
		),
	);
}
