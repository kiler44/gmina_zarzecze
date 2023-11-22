<?php
namespace Generic\Tlumaczenie\No\Modul\Team;

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
 * @property string $t['_akcje_etykiety_']['wykonajZmienEkipe']
 * @property string $t['_akcje_etykiety_']['wykonajRevert']
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
		'addTeam.tytul_modulu' => 'Legge lag',
		'addTeam.tytul_strony' => 'Legge lag',
		'delete.blad_nie_mozna_pobrac_obiektu' => 'Kan ikke hente objekt',
		'delete.blad_zapisu_obiektu' => 'Du kan ikke fjerne et objekt',
		'delete.obiekt_usuniety' => 'Teamet har blitt fjernet',
		'editTeam.tytul_modulu' => 'Redigere teamet',
		'editTeam.tytul_strony' => 'Redigere teamet',
		'editteam.blad_nie_mozna_pobrac_obiektu' => 'Kan ikke hente objekt',
		'formularz.blad' => 'Ikke alle obligatoriske felt er korrekt utfylt ',
		'formularz.blad_zapisu' => 'Du kan ikke Teamet',
		'formularz.domyslny_autocompleat' => 'personalet er tom',
		'formularz.domyslny_radio' => 'personalet er tom',
		'formularz.error_pracownik_zalogowany' => 'Arbeidere: {$ info} tiden loged i ordre. Denne endringen vil logge ut arbeidere skjema bestillinger. Er du sikker på at du ønsker å gjøre denne endringen?',
		'formularz_komunikat_team_zalogowany' => 'Teamet er logget inn på ordre',
		'formularz.error_lider_zalogowany' => 'Leder: {$ info} logget på bestillinger. Denne endringen vil logge ut teamet arbeidere fra dagens ordrer',
		'formularz.poprawne' => 'Data ble registrert',
		'formularz.wstecz.wartosc' => 'Avbryt',
		'formularz.zapisz.wartosc' => 'Lagre',
		'formularzSzukaj.czysc.wartosc' => 'Klart',
		'formularzSzukaj.etykieta_select_wybierz' => '- velg -',
		'formularzSzukaj.fraza.etykieta' => 'Søkefrase : ',
		'formularzSzukaj.fraza.opis' => '',
		'formularzSzukaj.pracownik.etykieta' => 'Medarbeider : ',
		'formularzSzukaj.pracownik.opis' => '',
		'formularzSzukaj.szukaj.wartosc' => 'Søk',
		'formularzZmienEkipe.ekipa.etykieta' => 'Velg lag : ',
		'formularzZmienEkipe.wstecz.wartosc' => 'Avbryt',
		'formularzZmienEkipe.zapisz.wartosc' => 'Lagre',
		'index.etykieta_idLeader' => 'Leder',
		'index.etykieta_idUsers' => 'Medarbeidere',
		'index.etykieta_numberPlate' => 'Den bilnummer',
		'index.etykieta_potwierdz_usun' => 'Vil du virkelig vil slette team for å ?',
		'index.etykieta_status' => 'Status',
		'index.etykieta_teamNumber' => 'Navnet på teamet',
		'index.info_ekipy_bez_przydzialu' => 'Liste over lag uten leder : {$ekipyBezLidera} ',
		'index.info_pracownicy_bez_przydzialu' => 'Liste over ansatte uten mannskap : {$listaPracownikow}',
		'index.tabela_etykieta_edytuj' => 'Rediger',
		'index.tabela_etykieta_revert' => 'Gjenopprett',
		'index.tabela_etykieta_usun' => 'Fjern',
		'index.tytul_modulu' => 'Liste over lag',
		'index.tytul_strony' => 'Liste over lag',
		'revert.blad_nie_mozna_pobrac_obiektu' => 'Kan ikke hente objekt',
		'revert.blad_zapisu_obiektu' => 'Du kan ikke fjerne et objekt',
		'revert.obiekt_przywrocony_z_kosza' => 'Teamet har blitt restaurert fra papirkurven',
		'team_addTeam.etykietaMenu' => 'Legg et lag til',
		'team_index.etykietaMenu' => 'liste over lag',
		'team_trash.etykietaMenu' => 'Søppel',
		'trash.tytul_modulu' => 'Søppel',
		'trash.tytul_strony' => 'Søppel',
		'zmienekipe.blad_zapisu' => 'Klarte ikke å lagre endringene',
		'zmienekipe.brak_uprawnien' => 'Du har ikke tillatelse til å endre på laget',
		'zmienekipe.brak_wolnych_ekip' => 'Det er ingen tilgjengelige lag',
		'zmienekipe.etykieta_wstecz' => 'Tilbake',
		'zmienekipe.formularz_blad' => 'Skjemaet er ikke korrekt utfylt',
		'zmienekipe.formularz_poprany' => 'Data ble registrert',
		'zmienekipe.formularz_wybierz' => 'velg',
		'zmienekipe.tytul_modulu' => 'Endre lag',
		'zmienekipe.tytul_strony' => 'Endre lag',
		'zmienekipe.wyloguj_sie_z_zadania_info' => 'Du kan ikke endre på laget fordi laget er logget på ordren. Logge ut av den for å endre på laget.',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lag brev',
			'wykonajAddTeam' => 'Legg et lag',
			'wykonajTrash' => 'Papirkurven',
			'wykonajZmienEkipe' => 'Endre lag (for leder)',
			'wykonajRevert' => 'Gå tilbake fra papirkurven',
			'wykonajDeleteTeam' => 'Slett lag',
			'wykonajEditTeam' => 'Redigere teamet',
		),
		'formularz.baza_teamu' => 'Team homebase',
		'formularz.status' => array(
			'active' => 'Aktiv',
			'delete' => 'Fjernet',
			'in_repair' => 'Bil under reparasjon',
			'temporary_use' => 'Midlertidig teamet',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}