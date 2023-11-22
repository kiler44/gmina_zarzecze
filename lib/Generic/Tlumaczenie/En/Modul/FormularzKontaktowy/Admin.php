<?php
namespace Generic\Tlumaczenie\Pl\Modul\FormularzKontaktowy;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_nie_mozna_pobrac_danych']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['edytujTrescPo.blad_nie_mozna_zapisac_tresci']
 * @property string $t['edytujTrescPo.etykieta_wstecz']
 * @property string $t['edytujTrescPo.etykieta_zapisz']
 * @property string $t['edytujTrescPo.info_zapisano_tresc']
 * @property string $t['edytujTrescPo.trescPrzed.etykieta']
 * @property string $t['edytujTrescPo.tytul_strony']
 * @property string $t['edytujTrescPrzed.blad_nie_mozna_zapisac_tresci']
 * @property string $t['edytujTrescPrzed.etykieta_wstecz']
 * @property string $t['edytujTrescPrzed.etykieta_zapisz']
 * @property string $t['edytujTrescPrzed.info_zapisano_tresc']
 * @property string $t['edytujTrescPrzed.trescPrzed.etykieta']
 * @property string $t['edytujTrescPrzed.tytul_strony']
 * @property string $t['formularz.email.etykieta']
 * @property string $t['formularz.email.opis']
 * @property string $t['formularz.emailDw.etykieta']
 * @property string $t['formularz.emailDw.opis']
 * @property string $t['formularz.etykieta_brak']
 * @property string $t['formularz.etykieta_pokaz']
 * @property string $t['formularz.etykieta_wstecz']
 * @property string $t['formularz.etykieta_wymagane']
 * @property string $t['formularz.etykieta_zapisz']
 * @property string $t['formularz.konfiguracja.region']
 * @property string $t['formularz.pola.region']
 * @property string $t['formularz.pole_daneOsobowe.etykieta']
 * @property string $t['formularz.pole_fax.etykieta']
 * @property string $t['formularz.pole_firmaNazwa.etykieta']
 * @property string $t['formularz.pole_gg.etykieta']
 * @property string $t['formularz.pole_imie.etykieta']
 * @property string $t['formularz.pole_komorka.etykieta']
 * @property string $t['formularz.pole_nadawca.etykieta']
 * @property string $t['formularz.pole_nazwisko.etykieta']
 * @property string $t['formularz.pole_skype.etykieta']
 * @property string $t['formularz.pole_stronaWWW.etykieta']
 * @property string $t['formularz.pole_telefon.etykieta']
 * @property string $t['formularz.pole_tresc.etykieta']
 * @property string $t['formularz.temat.etykieta']
 * @property string $t['index.etykieta_data_wyslania']
 * @property string $t['index.etykieta_email']
 * @property string $t['index.etykieta_emailDw']
 * @property string $t['index.etykieta_input_data_wyslania']
 * @property string $t['index.etykieta_input_fraza']
 * @property string $t['index.etykieta_input_szukaj']
 * @property string $t['index.etykieta_input_temat']
 * @property string $t['index.etykieta_link_konfiguruj']
 * @property string $t['index.etykieta_link_tresc_po']
 * @property string $t['index.etykieta_link_tresc_przed']
 * @property string $t['index.etykieta_select_wybierz']
 * @property string $t['index.etykieta_temat']
 * @property string $t['index.etykieta_tresc']
 * @property string $t['index.etykieta_usun']
 * @property string $t['index.tytul_strony']
 * @property string $t['konfiguruj.brak_adresu_email']
 * @property string $t['konfiguruj.error_temat_domyslny_dodany']
 * @property string $t['konfiguruj.etykieta_dodaj']
 * @property string $t['konfiguruj.etykieta_wstecz']
 * @property string $t['konfiguruj.info_temat_domyslny_dodany']
 * @property string $t['konfiguruj.tytul_strony']
 * @property string $t['podglad.error_podglad_wiadomosci']
 * @property string $t['podglad.tytul_strony']
 * @property string $t['usun.error_usunieto']
 * @property string $t['usun.error_usunieto_wiele']
 * @property string $t['usun.error_wiadomosc_nie_usunieto']
 * @property string $t['usun.error_wiadomosc_nie_usunieto_wiele']
 * @property string $t['usun.info_usunieto']
 * @property string $t['usun.info_usunieto_wiele']
 * @property string $t['usun.info_wiadomosc_usunieto']
 * @property string $t['usun.info_wiadomosc_usunieto_wiele']
 * @property string $t['zapiszTemat.blad_temat_dodany']
 * @property string $t['zapiszTemat.blad_zapisu_danych']
 * @property string $t['zapiszTemat.dane_zapisane']
 * @property string $t['zapiszTemat.temat_dodany']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajKonfiguruj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujTrescPrzed']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujTrescPo']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajPodglad']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajUsunWiadomosc']
 * @property array $t['index.data_dodania_opcje']
 * @property string $t['index.data_dodania_opcje']['7']
 * @property string $t['index.data_dodania_opcje']['14']
 * @property string $t['index.data_dodania_opcje']['31']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'dodaj.tytul_strony' => 'Formularz kontaktowy - dodaj nowy temat',

		'edytuj.blad_nie_mozna_pobrac_danych' => 'Nee można pobrać danych konfiguracyjnych tematu',
		'edytuj.tytul_strony' => 'Edycja tematu formularza kontaktowego',

		'edytujTrescPo.blad_nie_mozna_zapisac_tresci' => 'Nie można zapisać treści za formularzem',
		'edytujTrescPo.etykieta_wstecz' => 'Wstecz',
		'edytujTrescPo.etykieta_zapisz' => 'Zapisz',
		'edytujTrescPo.info_zapisano_tresc' => 'Zapisano treść za formularzem',
		'edytujTrescPo.trescPrzed.etykieta' => 'Treść za formularzem',
		'edytujTrescPo.tytul_strony' => 'Edycja treści za formularzem',

		'edytujTrescPrzed.blad_nie_mozna_zapisac_tresci' => 'Nie można zapisać treści przed formularzem',
		'edytujTrescPrzed.etykieta_wstecz' => 'Wstecz',
		'edytujTrescPrzed.etykieta_zapisz' => 'Zapisz',
		'edytujTrescPrzed.info_zapisano_tresc' => 'Zapisano treść przed formularzem',
		'edytujTrescPrzed.trescPrzed.etykieta' => 'Treść przed formularzem',
		'edytujTrescPrzed.tytul_strony' => 'Edycja treści przed formularzem',

		'formularz.email.etykieta' => 'E-mail odbiorcy',
		'formularz.email.opis' => 'Jeśli pozostanie niewypełniony wysłany formularz zostanie zapisany tylko w bazie danych i żaden e-mail nie zostanie wysłany.',
		'formularz.emailDw.etykieta' => 'E-mail DW odbiorcy',
		'formularz.emailDw.opis' => 'Jeśli są ustawieni odbiorcy emaila, można ustawić listę adresów, do wiadomości których zostanie wysłany email.',
		'formularz.etykieta_brak' => ' brak ',
		'formularz.etykieta_pokaz' => ' pokaż ',
		'formularz.etykieta_wstecz' => 'Wstecz',
		'formularz.etykieta_wymagane' => ' wymagane ',
		'formularz.etykieta_zapisz' => 'Zapisz',
		'formularz.konfiguracja.region' => 'Ustawienia',
		'formularz.pola.region' => 'Pola formularza',
		'formularz.pole_daneOsobowe.etykieta' => 'Dane osobowe',
		'formularz.pole_fax.etykieta' => 'Fax',
		'formularz.pole_firmaNazwa.etykieta' => 'Nazwa firmy',
		'formularz.pole_gg.etykieta' => 'GaduGadu',
		'formularz.pole_imie.etykieta' => 'Imię',
		'formularz.pole_komorka.etykieta' => 'Telefon komórkowy',
		'formularz.pole_nadawca.etykieta' => 'Email nadawcy',
		'formularz.pole_nazwisko.etykieta' => 'Nazwisko',
		'formularz.pole_skype.etykieta' => 'Skype',
		'formularz.pole_stronaWWW.etykieta' => 'Strona WWW',
		'formularz.pole_telefon.etykieta' => 'Telefon',
		'formularz.pole_tresc.etykieta' => 'Treść wiadomości',
		'formularz.temat.etykieta' => 'Temat',

		'index.etykieta_data_wyslania' => 'Data wysłania',
		'index.etykieta_email' => 'Email',
		'index.etykieta_emailDw' => 'Do wiadomości',
		'index.etykieta_input_data_wyslania' => 'Data wysłania',
		'index.etykieta_input_fraza' => 'Szukana fraza',
		'index.etykieta_input_szukaj' => 'Szukaj',
		'index.etykieta_input_temat' => 'Temat',
		'index.etykieta_link_konfiguruj' => 'Konfiguracja',
		'index.etykieta_link_tresc_po' => 'Treść po form.',
		'index.etykieta_link_tresc_przed' => 'Treść przed form.',
		'index.etykieta_select_wybierz' => '- wybierz -',
		'index.etykieta_temat' => 'Temat',
		'index.etykieta_tresc' => 'Treść',
		'index.etykieta_usun' => 'Usuń',
		'index.tytul_strony' => 'Formularz kontaktowy',

		'konfiguruj.brak_adresu_email' => 'Email nieprzypisany',
		'konfiguruj.error_temat_domyslny_dodany' => 'Błąd! Temat domyślny nie został dodany',
		'konfiguruj.etykieta_dodaj' => 'Dodaj temat',
		'konfiguruj.etykieta_wstecz' => 'Wstecz',
		'konfiguruj.info_temat_domyslny_dodany' => 'Temat domyślny został dodany',
		'konfiguruj.tytul_strony' => 'Formularz kontaktowy - lista tematów',

		'podglad.error_podglad_wiadomosci' => 'Błąd! Nie można pobrać danych wiadomości.',
		'podglad.tytul_strony' => 'Podgląd wiadomości',

		'usun.error_usunieto' => 'Nie udało się usunąć wybranego tematu - sprawdź czy do tematu nie ma przypisanych wiadomości.',
		'usun.error_usunieto_wiele' => 'Nie udało się usunąć wybranych tematów - sprawdź czy do wybranych tematów nie ma przypisanych wiadomości.',
		'usun.error_wiadomosc_nie_usunieto' => 'Nie udało się usunąć wybraneej wiadomości',
		'usun.error_wiadomosc_nie_usunieto_wiele' => 'Nie udało się usunąć wybranych wiadomości',
		'usun.info_usunieto' => 'Wybrany temat został usunięty',
		'usun.info_usunieto_wiele' => 'Wybrane tematy zostały usunięte',
		'usun.info_wiadomosc_usunieto' => 'Wybrana wiadomość została usunięta',
		'usun.info_wiadomosc_usunieto_wiele' => 'Wybrane wiadomości zostały usunięte',

		'zapiszTemat.blad_temat_dodany' => 'Temat nie został dodany',
		'zapiszTemat.blad_zapisu_danych' => 'Konfiguracja tematu nie została zapisana',
		'zapiszTemat.dane_zapisane' => 'Konfiguracja tematu została zapisana',
		'zapiszTemat.temat_dodany' => 'Temat został dodany',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Podgląd wiadomości',
			'wykonajKonfiguruj' => 'Podgląd listy tematów',
			'wykonajEdytujTrescPrzed' => 'Edycja treści powyżej formuarza',
			'wykonajEdytujTrescPo' => 'Edycja treści poniżej formularza',
			'wykonajDodaj' => 'Dodawanie tematu formularza',
			'wykonajEdytuj' => 'Edycja tematu formularza',
			'wykonajPodglad' => 'Podgląd wiadomości',
			'wykonajUsun' => 'Usuwanie tematów formularza',
			'wykonajUsunWiadomosc' => 'Usuwanie wiadomości',
		),

		'index.data_dodania_opcje' => array(
			'7' => 'Ostatni tydzień',
			'14' => 'Ostatnie dwa tygodnie',
			'31' => 'Ostatni miesiąc',
		),
	);
}
