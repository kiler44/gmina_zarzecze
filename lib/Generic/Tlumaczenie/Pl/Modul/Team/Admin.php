<?php
namespace Generic\Tlumaczenie\Pl\Modul\Team;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['addTeam.tytul_modulu']
 * @property string $t['addTeam.tytul_strony']
 * @property string $t['delete.blad_nie_mozna_pobrac_obiektu']
 * @property string $t['delete.blad_zapisu_obiektu']
 * @property string $t['delete.obiekt_usuniety']
 * @property string $t['editTeam.tytul_modulu']
 * @property string $t['editTeam.tytul_strony']
 * @property string $t['editteam.blad_nie_mozna_pobrac_obiektu']
 * @property string $t['formularz.blad']
 * @property string $t['formularz.blad_zapisu']
 * @property string $t['formularz.domyslny_autocompleat']
 * @property string $t['formularz.domyslny_radio']
 * @property string $t['formularz.error_pracownik_zalogowany']
 * @property string $t['formularz.poprawne']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularzSzukaj.czysc.wartosc']
 * @property string $t['formularzSzukaj.etykieta_select_wybierz']
 * @property string $t['formularzSzukaj.fraza.etykieta']
 * @property string $t['formularzSzukaj.fraza.opis']
 * @property string $t['formularzSzukaj.pracownik.etykieta']
 * @property string $t['formularzSzukaj.pracownik.opis']
 * @property string $t['formularzSzukaj.szukaj.wartosc']
 * @property string $t['formularzZmienEkipe.ekipa.etykieta']
 * @property string $t['formularzZmienEkipe.wstecz.wartosc']
 * @property string $t['formularzZmienEkipe.zapisz.wartosc']
 * @property string $t['index.etykieta_idLeader']
 * @property string $t['index.etykieta_idUsers']
 * @property string $t['index.etykieta_numberPlate']
 * @property string $t['index.etykieta_potwierdz_usun']
 * @property string $t['index.etykieta_status']
 * @property string $t['index.etykieta_teamNumber']
 * @property string $t['index.info_ekipy_bez_przydzialu']
 * @property string $t['index.info_pracownicy_bez_przydzialu']
 * @property string $t['index.tabela_etykieta_edytuj']
 * @property string $t['index.tabela_etykieta_revert']
 * @property string $t['index.tabela_etykieta_usun']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['revert.blad_nie_mozna_pobrac_obiektu']
 * @property string $t['revert.blad_zapisu_obiektu']
 * @property string $t['revert.obiekt_przywrocony_z_kosza']
 * @property string $t['team_addTeam.etykietaMenu']
 * @property string $t['team_index.etykietaMenu']
 * @property string $t['team_trash.etykietaMenu']
 * @property string $t['trash.tytul_modulu']
 * @property string $t['trash.tytul_strony']
 * @property string $t['zmienekipe.blad_zapisu']
 * @property string $t['zmienekipe.brak_uprawnien']
 * @property string $t['zmienekipe.brak_wolnych_ekip']
 * @property string $t['zmienekipe.etykieta_wstecz']
 * @property string $t['zmienekipe.formularz_blad']
 * @property string $t['zmienekipe.formularz_eybierz']
 * @property string $t['zmienekipe.formularz_poprany']
 * @property string $t['zmienekipe.formularz_wybierz']
 * @property string $t['zmienekipe.tytul_modulu']
 * @property string $t['zmienekipe.tytul_strony']
 * @property string $t['zmienekipe.wyloguj_sie_z_zadania_info']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajAddTeam']
 * @property string $t['_akcje_etykiety_']['wykonajTrash']
 * @property string $t['_akcje_etykiety_']['wykonajRevert']
 * @property string $t['_akcje_etykiety_']['wykonajZmienEkipe']
 * @property string $t['_akcje_etykiety_']['wykonajDeleteTeam']
 * @property string $t['_akcje_etykiety_']['wykonajEditTeam']
 * @property string $t[formularz_komunikat_team_zalogowany]
 * @property array $t['formularz.status']
 * @property string $t['formularz.status']['active']
 * @property string $t['formularz.status']['delete']
 * @property string $t['formularz.status']['in_repair']
 * @property string $t['formularz.status']['temporary_use']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'addTeam.tytul_modulu' => 'Dodaj ekipę',
		'addTeam.tytul_strony' => 'Dodaj ekipę',
		'delete.blad_nie_mozna_pobrac_obiektu' => 'Nie można pobrać obiektu',
		'delete.blad_zapisu_obiektu' => 'Nie można usunąć obiektu',
		'delete.obiekt_usuniety' => 'Ekipa została usunięta',
		'editTeam.tytul_modulu' => 'Edytuj ekipę',
		'editTeam.tytul_strony' => 'Edytuj ekipę',
		'editteam.blad_nie_mozna_pobrac_obiektu' => 'Nie można pobrać obiektu',
		'formularz.blad' => 'Nie wszystkie wymagane pola zostały poprawnie wypełnione ',
		'formularz.blad_zapisu' => 'Nie można zapisać ekipy',
		'formularz.domyslny_autocompleat' => 'brak pracowników',
		'formularz.domyslny_radio' => 'lista pracowników jest pusta',
		'formularz.error_pracownik_zalogowany' => 'Pracownicy : {$info} są obecnie zalogowani do zamówienia. Zmiana spowoduje wylogowanie pracowników z obecnie wykonywanego zadania. Czy chcesz zatwierdzić tą zmieną? <br/> <button id="yes" class="akceptuj_przelogowanie btn btn-primary" name="yes">Tak</button> <button id="no" class="akceptuj_przelogowanie btn" name="no">Nie</button>',
		'formularz_komunikat_team_zalogowany' => 'Ekipa jest obecnie zalogowana do zadania, zmiany w ekipe spowodują wylogowanie lub zalogowanie pracowników do wykonywanego zadania',
		'formularz.error_lider_zalogowany' => 'Lider : {$info} jest obecnie zalogowany do zamówienia. Ta zmiana spowoduje wylogowanie pracowników ekipy z obecnie wykonywanych zadań.',
		'formularz.poprawne' => 'Dane zostały zapisane',
		'formularz.wstecz.wartosc' => 'Anuluj',
		'formularz.zapisz.wartosc' => 'Zapisz',
		'formularzSzukaj.czysc.wartosc' => 'Czyść',
		'formularzSzukaj.etykieta_select_wybierz' => '-wybierz-',
		'formularzSzukaj.fraza.etykieta' => 'Fraza',
		'formularzSzukaj.fraza.opis' => '',
		'formularzSzukaj.pracownik.etykieta' => 'Pracownik',
		'formularzSzukaj.pracownik.opis' => '',
		'formularzSzukaj.szukaj.wartosc' => 'Szukaj',
		'formularzZmienEkipe.ekipa.etykieta' => 'Wbierz ekipe : ',
		'formularzZmienEkipe.wstecz.wartosc' => 'Anuluj',
		'formularzZmienEkipe.zapisz.wartosc' => 'Zapisz',
		'index.etykieta_idLeader' => 'Lider',
		'index.etykieta_idUsers' => 'Pracownicy',
		'index.etykieta_numberPlate' => 'Numer rejestracyjny',
		'index.etykieta_potwierdz_usun' => 'Czy napewno chcesz usunać ekipe?',
		'index.etykieta_status' => 'Status',
		'index.etykieta_teamNumber' => 'Nazwa ekipy',
		'index.info_ekipy_bez_przydzialu' => 'Lista ekip bez lidera : {$ekipyBezLidera} ',
		'index.info_pracownicy_bez_przydzialu' => 'Lista pracowników bez ekipy : {$listaPracownikow}',
		'index.tabela_etykieta_edytuj' => 'Edytuj',
		'index.tabela_etykieta_revert' => 'Przywróć',
		'index.tabela_etykieta_usun' => 'Usuń',
		'index.tytul_modulu' => 'Lista ekip',
		'index.tytul_strony' => 'Lista ekip',
		'revert.blad_nie_mozna_pobrac_obiektu' => 'Nie można pobrać ekipy',
		'revert.blad_zapisu_obiektu' => 'Nie można zapisać danych',
		'revert.obiekt_przywrocony_z_kosza' => 'Ekipa została przywrócona z kosza',
		'team_addTeam.etykietaMenu' => 'Dodaj ekipe',
		'team_index.etykietaMenu' => 'Lista ekip',
		'team_trash.etykietaMenu' => 'Kosz',
		'trash.tytul_modulu' => 'Kosz',
		'trash.tytul_strony' => 'Kosz',
		'zmienekipe.blad_zapisu' => 'Nie udało się zapisać zmian',
		'zmienekipe.brak_uprawnien' => 'Nie posiadasz uprawnień do zmiany ekipy',
		'zmienekipe.brak_wolnych_ekip' => 'Brak wolnych ekip',
		'zmienekipe.etykieta_wstecz' => 'Wstecz',
		'zmienekipe.formularz_blad' => 'Formularz nie został wypełniony poprawnie',
		'zmienekipe.formularz_poprany' => 'Dane zostały zapisane',
		'zmienekipe.formularz_wybierz' => 'wybierz',
		'zmienekipe.tytul_modulu' => 'Zmiana ekipy',
		'zmienekipe.tytul_strony' => 'Zmiana ekipy',
		'zmienekipe.wyloguj_sie_z_zadania_info' => 'Nie możesz zmienić ekipy ponieważ ekipa zalogowana jest do zamówienia. Wyloguj się z zamówienia żeby zmienić ekipę.',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Ekipy',
			'wykonajAddTeam' => 'Dodaj ekipę',
			'wykonajTrash' => 'Kosz',
			'wykonajRevert' => 'Przywróć z kosza',
			'wykonajZmienEkipe' => 'Zmień ekipę (uprawnienie dla lidera)',
			'wykonajDeleteTeam' => 'Usuń ekipę',
			'wykonajEditTeam' => 'Edytuj ekipę',
		),
		'formularz.baza_teamu' => 'Team homebase',
		'formularz.status' => array(
			'active' => 'Aktywny',
			'delete' => 'Usunięty',
			'in_repair' => 'Pojazd w naprawie',
			'temporary_use' => 'Ekipa tymczasowa',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}