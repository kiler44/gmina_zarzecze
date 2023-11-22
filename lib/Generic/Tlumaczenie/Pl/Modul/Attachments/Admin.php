<?php
namespace Generic\Tlumaczenie\Pl\Modul\Attachments;

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
		'attachments_index.etykietaMenu' => 'Lista',
		'attachments_trash.etykietaMenu' => 'Kosz',
		'brak_nazwy_mapera' => 'Brak nazwy mappera',
		'delete.error_zalacznik_nie_istnieje' => 'Załącznik który próbujesz usunąć nie istnieje',
		'delete.info_usunieta_zalacznik' => 'Załącznik został usunięty',
		'formularzSzukaj.czysc.wartosc' => 'Resetuj',
		'formularzSzukaj.fraza.etykieta' => 'Fraza',
		'formularzSzukaj.object.etykieta' => 'Objekt',
		'formularzSzukaj.szukaj.wartosc' => 'Szukaj',
		'index.etykieta_catalog' => 'Katalog',
		'index.etykieta_data_added' => 'Data dodania',
		'index.etykieta_file' => 'Plik',
		'index.etykieta_id_object' => 'Id objektu',
		'index.etykieta_object' => 'Objekt',
		'index.etykieta_potwierdz_usun' => 'Czy napewno chcesz usunąć wybrany element',
		'index.tabela_etykieta_download' => 'Pobierz',
		'index.tabela_etykieta_podglad' => 'Podgląd',
		'index.tabela_etykieta_usun' => 'Usuń',
		'index.tytul_modulu' => 'Załączniki',
		'index.tytul_strony' => 'Załączniki',
		'preview.error_zalacznik_nie_istnieje' => 'Wybrany załącznik nie istnieje',
		'preview.error_zalacznik_nie_istnieje_plik' => 'Plik z załącznikiem nie istnieje',
		'preview.tytul_modulu' => 'Podgląd załącznika',
		'preview.tytul_strony' => 'Podgląd załącznika',
		'previewObject.tytul_modulu' => 'Podgląd obiektu',
		'previewObject.tytul_strony' => 'Podgląd obiektu',
		'previewobject.brak_akcji_podgladu' => 'Nie podano akcji podglądu dla wybranego obiektu w konfiguracji',
		'previewobject.kategoria_nie_istnieje' => 'Nie znaleziono modułu',
		'revert.error_zalacznik_nie_istnieje' => 'Załącznik który próbujesz przywrócić nie istnieje',
		'revert.info_przywrocono_zalacznik' => 'Załącznik został przywrócony',
		'trash.etykieta_potwierdz_przywroc' => 'Czy napewno chcesz przywrócić wybrany załącznik',
		'trash.tabela_etykieta_przywroc' => 'Przywróć',
		'trash.tytul_modulu' => 'Kosz',
		'trash.tytul_strony' => 'Kosz',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista załączników',
			'wykonajTrash' => 'Podgląd kosza',
			'wykonajDelete' => 'Usuń załącznik',
			'wykonajRevert' => 'Przywróć załącznik',
			'wykonajPreviewAttachments' => 'Podgląd załącznika',
			'wykonajPreviewObject' => 'Podgląd obiektu',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}