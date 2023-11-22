<?php
namespace Generic\Tlumaczenie\En\Modul\Team;

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
 * @property string $t['_akcje_etykiety_']['wykonajZmienEkipe']
 * @property string $t['_akcje_etykiety_']['wykonajTrash']
 * @property string $t['_akcje_etykiety_']['wykonajRevert']
 * @property string $t['_akcje_etykiety_']['wykonajDeleteTeam']
 * @property string $t['_akcje_etykiety_']['wykonajEditTeam']
 * @property string $t['formularz_komunikat_team_zalogowany']
 * @property string $t['formularz.error_lider_zalogowany']
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
		'addTeam.tytul_modulu' => 'Add team',
		'addTeam.tytul_strony' => 'Add team',
		'delete.blad_nie_mozna_pobrac_obiektu' => 'Unable to retrieve object',
		'delete.blad_zapisu_obiektu' => 'Can not remove object',
		'delete.obiekt_usuniety' => 'The team has been removed',
		'editTeam.tytul_modulu' => 'Edit team',
		'editTeam.tytul_strony' => 'Edit team',
		'editteam.blad_nie_mozna_pobrac_obiektu' => 'Unable to retrieve object',
		'formularz.blad' => 'Not all required fields have been correctly filled',
		'formularz.blad_zapisu' => 'You can not save the team',
		'formularz.domyslny_autocompleat' => 'staff list is empty',
		'formularz.domyslny_radio' => 'staff list is empty',
		'formularz.error_pracownik_zalogowany' => 'Workers : {$info} currently logged in to orders. This change will log out workers from orders. Are you sure you want to make this change? <br/> <button id="yes" class="akceptuj_przelogowanie btn btn-primary" name="yes">Yes</button> <button id="no" class="akceptuj_przelogowanie btn" name="no">No</button>',
		'formularz_komunikat_team_zalogowany' => 'Team is currently logged in to orders, any changes in Team cuse login or loggout workers from order',
		'formularz.error_lider_zalogowany' => 'Leader : {$info} currently logged in to orders. This change will log out workers of his team from current orders',
		'formularz.poprawne' => 'Data were saved',
		'formularz.etykieta_baza_teamu' => 'Team base',
		'formularz.wstecz.wartosc' => 'Cancel',
		'formularz.zapisz.wartosc' => 'Save',
		'formularzSzukaj.czysc.wartosc' => 'Clear',
		'formularzSzukaj.etykieta_select_wybierz' => '- select -',
		'formularzSzukaj.fraza.etykieta' => 'Phrase : ',
		'formularzSzukaj.fraza.opis' => '',
		'formularzSzukaj.pracownik.etykieta' => 'Worker : ',
		'formularzSzukaj.pracownik.opis' => '',
		'formularzSzukaj.szukaj.wartosc' => 'Search',
		'formularzZmienEkipe.ekipa.etykieta' => 'Select team : ',
		'formularzZmienEkipe.wstecz.wartosc' => 'Cancel',
		'formularzZmienEkipe.zapisz.wartosc' => 'Save',
		'index.etykieta_idLeader' => 'Leader',
		'index.etykieta_idUsers' => 'Worker',
		'index.etykieta_numberPlate' => 'Number plate',
		'index.etykieta_potwierdz_usun' => 'Do you really want to delete team ?',
		'index.etykieta_status' => 'Status',
		'index.etykieta_teamNumber' => 'Team name',
		'index.info_ekipy_bez_przydzialu' => 'List of teams without a leader : {$ekipyBezLidera} ',
		'index.info_pracownicy_bez_przydzialu' => 'List of employees without a team : {$listaPracownikow}',
		'index.tabela_etykieta_edytuj' => 'Edit',
		'index.tabela_etykieta_revert' => 'Revert',
		'index.tabela_etykieta_usun' => 'Delete',
		'index.tytul_modulu' => 'List of team',
		'index.tytul_strony' => 'List of team',
		'revert.blad_nie_mozna_pobrac_obiektu' => 'Unable to retrieve object',
		'revert.blad_zapisu_obiektu' => 'You can not save the team',
		'revert.obiekt_przywrocony_z_kosza' => 'The team has been revert from trash',
		'team_addTeam.etykietaMenu' => 'Add Team',
		'team_index.etykietaMenu' => 'List of Team',
		'team_trash.etykietaMenu' => 'Trash',
		'trash.tytul_modulu' => 'Trash',
		'trash.tytul_strony' => 'Trash',
		'zmienekipe.blad_zapisu' => 'Failed to save the changes',
		'zmienekipe.brak_uprawnien' => 'You do not have permission to change the team',
		'zmienekipe.brak_wolnych_ekip' => 'There are no available teams',
		'zmienekipe.etykieta_wstecz' => 'Back',
		'zmienekipe.formularz_blad' => 'Form is not completed correctly',
		'zmienekipe.formularz_poprany' => 'Data were saved',
		'zmienekipe.formularz_wybierz' => 'select',
		'zmienekipe.tytul_modulu' => 'Changing teams',
		'zmienekipe.tytul_strony' => 'Changing teams',
		'zmienekipe.wyloguj_sie_z_zadania_info' => 'You can not change the team because the team is logged on to the orders. Log out from the order to change the team.',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Teams',
			'wykonajAddTeam' => 'Add team',
			'wykonajZmienEkipe' => 'Change Team (for lider)',
			'wykonajTrash' => 'Trash',
			'wykonajRevert' => 'Revert from trash',
			'wykonajDeleteTeam' => 'Delete team',
			'wykonajEditTeam' => 'Edit team',
		),
		'formularz.baza_teamu' => 'Team homebase',
		'formularz.status' => array(
			'active' => 'Active',
			'delete' => 'Delete',
			'in_repair' => 'Car in repair',
			'temporary_use' => 'Temporary team',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}