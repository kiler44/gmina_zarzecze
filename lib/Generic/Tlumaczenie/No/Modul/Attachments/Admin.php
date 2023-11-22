<?php
namespace Generic\Tlumaczenie\No\Modul\Attachments;

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
		'attachments_index.etykietaMenu' => 'Liste',
		'attachments_trash.etykietaMenu' => 'Papirkurven',
		'brak_nazwy_mapera' => 'No name mapper',
		'delete.error_zalacznik_nie_istnieje' => 'Vedlegg som du prøver å slette eksisterer ikke',
		'delete.info_usunieta_zalacznik' => 'Vedlegg er fjernet',
		'formularzSzukaj.czysc.wartosc' => 'Klart',
		'formularzSzukaj.fraza.etykieta' => 'Søkefrase : ',
		'formularzSzukaj.object.etykieta' => 'Objekt : ',
		'formularzSzukaj.szukaj.wartosc' => 'Søk',
		'index.etykieta_catalog' => 'Katalog',
		'index.etykieta_data_added' => 'Dato lagt',
		'index.etykieta_file' => 'Fil',
		'index.etykieta_id_object' => 'Objekt id',
		'index.etykieta_object' => 'Objekt',
		'index.etykieta_potwierdz_usun' => 'Er du sikker på at du vil slette det valgte elementet',
		'index.tabela_etykieta_download' => 'Nedlasting',
		'index.tabela_etykieta_podglad' => 'Forhåndsvisning',
		'index.tabela_etykieta_usun' => 'Fjern',
		'index.tytul_modulu' => 'Vedlegg',
		'index.tytul_strony' => 'Vedlegg',
		'preview.error_zalacznik_nie_istnieje' => 'Den valgte Vedlegg eksisterer ikke',
		'preview.error_zalacznik_nie_istnieje_plik' => 'Vedlegg bilde eksisterer ikke',
		'preview.tytul_modulu' => 'Forhåndsvisning av vedlegg',
		'preview.tytul_strony' => 'Forhåndsvisning av vedlegg',
		'previewObject.tytul_modulu' => 'Forhåndsvisning objekt',
		'previewObject.tytul_strony' => 'Forhåndsvisning objekt',
		'previewobject.brak_akcji_podgladu' => 'Ikke spesifisert forhåndsvisning handlingen for det valgte objektet i konfigurasjonen',
		'previewobject.kategoria_nie_istnieje' => 'Det er ingen modul',
		'revert.error_zalacznik_nie_istnieje' => 'Vedlegg som du prøver å gå tilbake eksisterer ikke',
		'revert.info_przywrocono_zalacznik' => 'Vedlegg har blitt tilbakestilt',
		'trash.etykieta_potwierdz_przywroc' => 'Er du sikker på at du vil gjenopprette et vedlegg',
		'trash.tabela_etykieta_przywroc' => 'Revert',
		'trash.tytul_modulu' => 'Slettet elemente',
		'trash.tytul_strony' => 'Slettet elemente',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Liste over vedlegg',
			'wykonajTrash' => 'Søppel',
			'wykonajDelete' => 'Slett vedlegg',
			'wykonajRevert' => 'Revert vedlegg',
			'wykonajPreviewAttachments' => 'Forhåndsvisning vedlegg',
			'wykonajPreviewObject' => 'Forhåndsvisning objekt',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}