<?php
namespace Generic\Tlumaczenie\En\Modul\Notes;

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
 * @property string $t['_akcje_etykiety_']['wykonajEditNoteAjax']
 * @property string $t['_akcje_etykiety_']['wykonajTrash']
 * @property string $t['_akcje_etykiety_']['wykonajRevert']
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
		'addNote.brak_id_objektu' => 'Not given object id',
		'addNote.brak_objektu_w_konfiguracji' => 'The specified type does not exist in the configuration',
		'addNote.etykieta_dodaj' => 'Add note',
		'ajax_edytuj_cancel' => 'Cancel',
		'ajax_edytuj_tooltip' => 'Click to edit',
		'ajax_edytuj_zapisz' => 'Save',
		'brak_nazwy_mapera' => 'Mapper not found in configuration',
		'delete.blad_nie_mozna_pobrac_notatki' => 'Note not found',
		'delete.notatka_usunieta' => 'Note has been removed',
		'editnotes.blad_nie_mozna_pobrac_notatki' => 'Unable to retrieve notes',
		'formularz.blad' => 'Not all required fields are filled out correctly',
		'formularz.blad_zapisu' => 'Not all required fields are filled out correctly',
		'formularz.poprawne' => 'Added a new note',
		'formularz.ustaw_jako_sygnal' => 'Set as signal',
		'formularz.wstecz.wartosc' => 'Cancel',
		'formularz.zapisz.wartosc' => 'Save ',
		'formularzSzukaj.czysc.wartosc' => 'Clear',
		'formularzSzukaj.etykieta_select_wybierz' => '- select -',
		'formularzSzukaj.fraza.etykieta' => 'Phrase : ',
		'formularzSzukaj.fraza.opis' => '',
		'formularzSzukaj.object.etykieta' => 'Type : ',
		'formularzSzukaj.object.opis' => '',
		'formularzSzukaj.szukaj.wartosc' => 'Search',
		'index.etykieta_author' => 'Author',
		'index.etykieta_data_added' => 'Data added',
		'index.etykieta_data_dodania' => 'Date',
		'index.etykieta_description' => 'Note',
		'index.etykieta_id_object' => 'Id object',
		'index.etykieta_object' => 'Type',
		'index.etykieta_potwierdz_usun' => 'Are you sure you want to delete this note ?',
		'index.tabela_etykieta_edytuj' => 'Edit',
		'index.tabela_etykieta_revert' => 'Revert',
		'index.tabela_etykieta_usun' => 'Delete',
		'index.tytul_modulu' => 'Notes',
		'index.tytul_strony' => 'Notes',
		'notes_addNote.etykietaMenu' => 'Add note',
		'notes_index.etykietaMenu' => 'List od note',
		'notes_trash.etykietaMenu' => 'Trash',
		'preview.error_notatka_nie_istnieje' => 'Note doesnt exist',
		'previewObject.tytul_modulu' => 'Object preview',
		'previewObject.tytul_strony' => 'Object preview',
		'previewobject.brak_akcji_podgladu' => 'No preview action in the configuration',
		'previewobject.kategoria_nie_istnieje' => 'No categories for selected module',
		'revert.blad_nie_mozna_pobrac_notatki' => 'Note not found',
		'revert.notatka_przywrocona_z_kosza' => 'Note has been revert from the trash',
		'trash.tytul_modulu' => 'Trash',
		'trash.tytul_strony' => 'Trash',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'List of notes',
			'wykonajAddNote' => 'Add a note',
			'wykonajEditNoteAjax' => 'Ajax edit note',
			'wykonajTrash' => 'Deleted notes',
			'wykonajRevert' => 'Revert from trash',
			'wykonajDeleteNote' => 'Delete note',
			'wykonajEditNote' => 'Edit note',
			'wykonajPreviewObject' => 'Preview object',
		),
		'objekty_notatek' => array(
			'zamowienie' => 'Order',
			'zalacznik' => 'Attachment',
			'klient' => 'Customer',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}