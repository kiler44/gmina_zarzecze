<?php
namespace Generic\Tlumaczenie\En\Modul\Attachments;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['attachments_index.etykietaMenu']
 * @property string $t['attachments_trash.etykietaMenu']
 * @property string $t['brak_nazwy_mapera']
 * @property string $t['delete.error_zalacznik_nie_istnieje']
 * @property string $t['delete.info_usunieta_zalacznik']
 * @property string $t['formularzSzukaj.czysc.wartosc']
 * @property string $t['formularzSzukaj.fraza.etykieta']
 * @property string $t['formularzSzukaj.object.etykieta']
 * @property string $t['formularzSzukaj.szukaj.wartosc']
 * @property string $t['index.etykieta_catalog']
 * @property string $t['index.etykieta_data_added']
 * @property string $t['index.etykieta_file']
 * @property string $t['index.etykieta_id_object']
 * @property string $t['index.etykieta_object']
 * @property string $t['index.etykieta_potwierdz_usun']
 * @property string $t['index.tabela_etykieta_download']
 * @property string $t['index.tabela_etykieta_podglad']
 * @property string $t['index.tabela_etykieta_usun']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['preview.error_zalacznik_nie_istnieje']
 * @property string $t['preview.error_zalacznik_nie_istnieje_plik']
 * @property string $t['preview.tytul_modulu']
 * @property string $t['preview.tytul_strony']
 * @property string $t['previewObject.tytul_modulu']
 * @property string $t['previewObject.tytul_strony']
 * @property string $t['previewobject.brak_akcji_podgladu']
 * @property string $t['previewobject.kategoria_nie_istnieje']
 * @property string $t['revert.error_zalacznik_nie_istnieje']
 * @property string $t['revert.info_przywrocono_zalacznik']
 * @property string $t['trash.etykieta_potwierdz_przywroc']
 * @property string $t['trash.tabela_etykieta_przywroc']
 * @property string $t['trash.tytul_modulu']
 * @property string $t['trash.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajTrash']
 * @property string $t['_akcje_etykiety_']['wykonajDelete']
 * @property string $t['_akcje_etykiety_']['wykonajRevert']
 * @property string $t['_akcje_etykiety_']['wykonajPreviewAttachments']
 * @property string $t['_akcje_etykiety_']['wykonajPreviewObject']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'attachments_index.etykietaMenu' => 'List',
		'attachments_trash.etykietaMenu' => 'Trash',
		'brak_nazwy_mapera' => 'Mapper name doesnt exist',
		'delete.error_zalacznik_nie_istnieje' => 'Attachment which you trying to delete does not exist',
		'delete.info_usunieta_zalacznik' => 'Attachment has been removed',
		'formularzSzukaj.czysc.wartosc' => 'Reset',
		'formularzSzukaj.fraza.etykieta' => 'Phrase : ',
		'formularzSzukaj.object.etykieta' => 'Object : ',
		'formularzSzukaj.szukaj.wartosc' => 'Search',
		'index.etykieta_catalog' => 'Catalog',
		'index.etykieta_data_added' => 'Date added',
		'index.etykieta_file' => 'File',
		'index.etykieta_id_object' => 'Object id',
		'index.etykieta_object' => 'Object',
		'index.etykieta_potwierdz_usun' => 'Are you sure you want to delete the selected item',
		'index.tabela_etykieta_download' => 'Download',
		'index.tabela_etykieta_podglad' => 'Preview',
		'index.tabela_etykieta_usun' => 'Delete',
		'index.tytul_modulu' => 'Attachments',
		'index.tytul_strony' => 'Attachments',
		'preview.error_zalacznik_nie_istnieje' => 'The selected Attachment does not exist',
		'preview.error_zalacznik_nie_istnieje_plik' => 'File of attachment does not exist',
		'preview.tytul_modulu' => 'Attachment preview',
		'preview.tytul_strony' => 'Attachment preview',
		'previewObject.tytul_modulu' => 'Object preview',
		'previewObject.tytul_strony' => 'Object preview',
		'previewobject.brak_akcji_podgladu' => 'Not specified preview action for the selected object in the configuration',
		'previewobject.kategoria_nie_istnieje' => 'There are no module',
		'revert.error_zalacznik_nie_istnieje' => 'Attachment which you trying to revert does not exist',
		'revert.info_przywrocono_zalacznik' => 'Attachment has been reverted',
		'trash.etykieta_potwierdz_przywroc' => 'Are you sure you want to restore an attachment',
		'trash.tabela_etykieta_przywroc' => 'Revert',
		'trash.tytul_modulu' => 'Trash',
		'trash.tytul_strony' => 'Trash',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'List of attachment',
			'wykonajTrash' => 'List of trash',
			'wykonajDelete' => 'Delete attachment',
			'wykonajRevert' => 'Revert attachment',
			'wykonajPreviewAttachments' => 'Preview attachment',
			'wykonajPreviewObject' => 'Preview object',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}