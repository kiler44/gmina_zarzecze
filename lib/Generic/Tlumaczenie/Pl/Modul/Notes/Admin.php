<?php
namespace Generic\Tlumaczenie\Pl\Modul\Notes;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['addNote.brak_id_objektu']
 * @property string $t['addNote.brak_objektu_w_konfiguracji']
 * @property string $t['addNote.etykieta_dodaj']
 * @property string $t['ajax_edytuj_cancel']
 * @property string $t['ajax_edytuj_tooltip']
 * @property string $t['ajax_edytuj_zapisz']
 * @property string $t['brak_nazwy_mapera']
 * @property string $t['delete.blad_nie_mozna_pobrac_notatki']
 * @property string $t['delete.notatka_usunieta']
 * @property string $t['editnotes.blad_nie_mozna_pobrac_notatki']
 * @property string $t['formularz.blad']
 * @property string $t['formularz.blad_zapisu']
 * @property string $t['formularz.poprawne']
 * @property string $t['formularz.ustaw_jako_sygnal']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularzSzukaj.czysc.wartosc']
 * @property string $t['formularzSzukaj.etykieta_select_wybierz']
 * @property string $t['formularzSzukaj.fraza.etykieta']
 * @property string $t['formularzSzukaj.fraza.opis']
 * @property string $t['formularzSzukaj.object.etykieta']
 * @property string $t['formularzSzukaj.object.opis']
 * @property string $t['formularzSzukaj.szukaj.wartosc']
 * @property string $t['index.etykieta_author']
 * @property string $t['index.etykieta_data_added']
 * @property string $t['index.etykieta_data_dodania']
 * @property string $t['index.etykieta_description']
 * @property string $t['index.etykieta_id_object']
 * @property string $t['index.etykieta_object']
 * @property string $t['index.etykieta_potwierdz_usun']
 * @property string $t['index.tabela_etykieta_edytuj']
 * @property string $t['index.tabela_etykieta_revert']
 * @property string $t['index.tabela_etykieta_usun']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['notes_addNote.etykietaMenu']
 * @property string $t['notes_index.etykietaMenu']
 * @property string $t['notes_trash.etykietaMenu']
 * @property string $t['preview.error_notatka_nie_istnieje']
 * @property string $t['previewObject.tytul_modulu']
 * @property string $t['previewObject.tytul_strony']
 * @property string $t['previewobject.brak_akcji_podgladu']
 * @property string $t['previewobject.kategoria_nie_istnieje']
 * @property string $t['revert.blad_nie_mozna_pobrac_notatki']
 * @property string $t['revert.notatka_przywrocona_z_kosza']
 * @property string $t['trash.tytul_modulu']
 * @property string $t['trash.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajAddNote']
 * @property string $t['_akcje_etykiety_']['wykonajTrash']
 * @property string $t['_akcje_etykiety_']['wykonajRevert']
 * @property string $t['_akcje_etykiety_']['wykonajEditNoteAjax']
 * @property string $t['_akcje_etykiety_']['wykonajDeleteNote']
 * @property string $t['_akcje_etykiety_']['wykonajEditNote']
 * @property string $t['_akcje_etykiety_']['wykonajPreviewObject']
 * @property array $t['objekty_notatek']
 * @property string $t['objekty_notatek']['zamowienie']
 * @property string $t['objekty_notatek']['zalacznik']
 * @property string $t['objekty_notatek']['klient']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'addNote.brak_id_objektu' => 'Nie wprowadzono id objektu',
		'addNote.brak_objektu_w_konfiguracji' => 'Podany typ objektu nie istnieje w konfiguracji',
		'addNote.etykieta_dodaj' => 'Dodaj notatkę',
		'ajax_edytuj_cancel' => 'Anuluj',
		'ajax_edytuj_tooltip' => 'Kliknij aby edytować',
		'ajax_edytuj_zapisz' => 'Zapisz',
		'brak_nazwy_mapera' => 'Brak nazwy mappera w konfiguracji',
		'delete.blad_nie_mozna_pobrac_notatki' => 'Nie można pobrać notatki',
		'delete.notatka_usunieta' => 'Notatka została usunięta',
		'editnotes.blad_nie_mozna_pobrac_notatki' => 'Nie można pobrać notatki',
		'formularz.blad' => 'Nie wszystkie wymagane pola zostały wypełnione poprawnie',
		'formularz.blad_zapisu' => 'Nie wszystkie wymagane pola zostały wypełnione poprawnie',
		'formularz.poprawne' => 'Dodano nową notatkę',
		'formularz.ustaw_jako_sygnal' => 'Ustaw jako sygnał',
		'formularz.wstecz.wartosc' => 'Anuluj',
		'formularz.zapisz.wartosc' => 'Zapisz',
		'formularzSzukaj.czysc.wartosc' => 'Czyść',
		'formularzSzukaj.etykieta_select_wybierz' => '- wybierz -',
		'formularzSzukaj.fraza.etykieta' => 'Fraza',
		'formularzSzukaj.fraza.opis' => '',
		'formularzSzukaj.object.etykieta' => 'Typ',
		'formularzSzukaj.object.opis' => '',
		'formularzSzukaj.szukaj.wartosc' => 'Szukaj',
		'index.etykieta_author' => 'Autor',
		'index.etykieta_data_added' => 'Data dodania',
		'index.etykieta_data_dodania' => 'Data',
		'index.etykieta_description' => 'Notatka',
		'index.etykieta_id_object' => 'Id objektu',
		'index.etykieta_object' => 'Typ',
		'index.etykieta_potwierdz_usun' => 'Czy na pewno chcesz usunąć notatkę ?',
		'index.tabela_etykieta_edytuj' => 'Edytuj',
		'index.tabela_etykieta_revert' => 'Przywróć',
		'index.tabela_etykieta_usun' => 'Usuń',
		'index.tytul_modulu' => 'Notatki',
		'index.tytul_strony' => 'Notatki',
		'notes_addNote.etykietaMenu' => 'Dodaj notatkę',
		'notes_index.etykietaMenu' => 'Lista notatek',
		'notes_trash.etykietaMenu' => 'Kosz',
		'preview.error_notatka_nie_istnieje' => 'Notatka nie istnieje',
		'previewObject.tytul_modulu' => 'Podgląd obiektu',
		'previewObject.tytul_strony' => 'Podgląd obiektu',
		'previewobject.brak_akcji_podgladu' => 'Brak akcji podglądu w konfiguracji',
		'previewobject.kategoria_nie_istnieje' => 'Brak kategorii dla wybranego modułu',
		'revert.blad_nie_mozna_pobrac_notatki' => 'Nie można pobrać notatki',
		'revert.notatka_przywrocona_z_kosza' => 'Notatka została przywrócona z kosza',
		'trash.tytul_modulu' => 'Kosz',
		'trash.tytul_strony' => 'Kosz',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista notatek',
			'wykonajAddNote' => 'Dodaj notatkę',
			'wykonajTrash' => 'Usunięte notatki',
			'wykonajRevert' => 'Przywróć z kosza',
			'wykonajEditNoteAjax' => 'Ajax edytuj notatkę',
			'wykonajDeleteNote' => 'Usuń notatkę',
			'wykonajEditNote' => 'Edytuj notatkę',
			'wykonajPreviewObject' => 'Podgląd obiektów',
		),
		'objekty_notatek' => array(
			'zamowieniabm' => 'Zamówienie',
			'zalacznik' => 'Załącznik',
			'klient' => 'Klient',

		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}