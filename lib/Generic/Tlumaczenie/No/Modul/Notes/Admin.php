<?php
namespace Generic\Tlumaczenie\No\Modul\Notes;

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
 * @property string $t['_akcje_etykiety_']['wykonajEditNoteAjax']
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
		'addNote.brak_id_objektu' => 'Ikke gitt objekt id',
		'addNote.brak_objektu_w_konfiguracji' => 'Den angitte typen finnes ikke i konfigurasjonen',
		'addNote.etykieta_dodaj' => 'legge til et notat',
		'ajax_edytuj_cancel' => 'Avbryt',
		'ajax_edytuj_tooltip' => 'Klikk for å redigere',
		'ajax_edytuj_zapisz' => 'Spare',
		'brak_nazwy_mapera' => 'No name mapper konfigurasjon',
		'delete.blad_nie_mozna_pobrac_notatki' => 'Kan ikke hente notater',
		'delete.notatka_usunieta' => 'Note har blitt fjernet',
		'editnotes.blad_nie_mozna_pobrac_notatki' => 'Kan ikke hente notater',
		'formularz.blad' => 'Ikke alle obligatoriske felt er fylt ut riktig',
		'formularz.blad_zapisu' => 'Ikke alle obligatoriske felt er fylt ut riktig',
		'formularz.poprawne' => 'Lagt til et nytt notat',
		'formularz.ustaw_jako_sygnal' => 'Sett som signal',
		'formularz.wstecz.wartosc' => 'Avbryt',
		'formularz.zapisz.wartosc' => 'Spare ',
		'formularzSzukaj.czysc.wartosc' => 'Klart',
		'formularzSzukaj.etykieta_select_wybierz' => '- velg -',
		'formularzSzukaj.fraza.etykieta' => 'Søkefrase : ',
		'formularzSzukaj.fraza.opis' => '',
		'formularzSzukaj.object.etykieta' => 'Type : ',
		'formularzSzukaj.object.opis' => '',
		'formularzSzukaj.szukaj.wartosc' => 'Søk',
		'index.etykieta_author' => 'Forfatter',
		'index.etykieta_data_added' => 'Data lagt',
		'index.etykieta_data_dodania' => 'Dato',
		'index.etykieta_description' => 'Note',
		'index.etykieta_id_object' => 'Objekt id',
		'index.etykieta_object' => 'Typen',
		'index.etykieta_potwierdz_usun' => 'Er du sikker på at du vil slette dette notatet?',
		'index.tabela_etykieta_edytuj' => 'Rediger',
		'index.tabela_etykieta_revert' => 'Tilbakestille',
		'index.tabela_etykieta_usun' => 'Fjern',
		'index.tytul_modulu' => 'Notater',
		'index.tytul_strony' => 'Notater',
		'notes_addNote.etykietaMenu' => 'Legge til et notat',
		'notes_index.etykietaMenu' => 'Liste over notater',
		'notes_trash.etykietaMenu' => 'Søppel',
		'preview.error_notatka_nie_istnieje' => 'Merk at det ikke er noen',
		'previewObject.tytul_modulu' => 'Forhåndsvisning objekt',
		'previewObject.tytul_strony' => 'Forhåndsvisning objekt',
		'previewobject.brak_akcji_podgladu' => 'Ingen forhåndsvisning under konfigurasjon',
		'previewobject.kategoria_nie_istnieje' => 'Ingen kategorier for valgte modulen',
		'revert.blad_nie_mozna_pobrac_notatki' => 'Du kan ikke laste ned notater',
		'revert.notatka_przywrocona_z_kosza' => 'Note har blitt restaurert fra papirkurven',
		'trash.tytul_modulu' => 'Søppel',
		'trash.tytul_strony' => 'Søppel',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'liste over notater',
			'wykonajAddNote' => 'Legg til et notat',
			'wykonajTrash' => 'Slettede notater',
			'wykonajEditNoteAjax' => 'Ajax redigere et notat',
			'wykonajRevert' => 'Gjenopprett fra papirkurven',
			'wykonajDeleteNote' => 'Slett notat',
			'wykonajEditNote' => 'Redigere et notat',
			'wykonajPreviewObject' => 'Forhåndsvisning objekt',
		),
		'objekty_notatek' => array(
			'zamowienie' => 'Bestill',
			'zalacznik' => 'Vedlegg',
			'klient' => 'Kunde',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}