<?php
namespace Generic\Tlumaczenie\No\Modul\ModulyZarzadzanie;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.etykieta_input_fraza']
 * @property string $t['index.etykieta_input_szukaj']
 * @property string $t['index.etykieta_input_typ']
 * @property string $t['index.etykieta_link_konfiguracja']
 * @property string $t['index.etykieta_link_logi']
 * @property string $t['index.etykieta_link_phpinfo']
 * @property string $t['index.etykieta_link_tlumaczenia']
 * @property string $t['index.etykieta_nazwa']
 * @property string $t['index.etykieta_porownanie_konfiguracji']
 * @property string $t['index.etykieta_select_wybierz']
 * @property string $t['index.etykieta_typ']
 * @property string $t['index.tytul_strony']
 * @property string $t['podglad.blad_brak_modulu']
 * @property string $t['podglad.etykieta_cache']
 * @property string $t['podglad.etykieta_dla_zalogowanych']
 * @property string $t['podglad.etykieta_kod']
 * @property string $t['podglad.etykieta_nazwa']
 * @property string $t['podglad.etykieta_nie']
 * @property string $t['podglad.etykieta_opis']
 * @property string $t['podglad.etykieta_projekty']
 * @property string $t['podglad.etykieta_tak']
 * @property string $t['podglad.etykieta_typ']
 * @property string $t['podglad.etykieta_uslugi']
 * @property string $t['podglad.etykieta_wymagane']
 * @property string $t['podglad.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajPodglad']
 * @property array $t['index.modul_typy']
 * @property string $t['index.modul_typy']['administracyjny']
 * @property string $t['index.modul_typy']['zwykly']
 * @property string $t['index.modul_typy']['jednorazowy']
 * @property string $t['index.modul_typy']['blok']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'index.etykieta_input_fraza' => 'Search phrase',
		'index.etykieta_input_szukaj' => 'Search',
		'index.etykieta_input_typ' => 'Module type',
		'index.etykieta_link_konfiguracja' => 'Get configuration',
		'index.etykieta_link_logi' => 'CMS Logs',
		'index.etykieta_link_phpinfo' => 'PHP info',
		'index.etykieta_link_tlumaczenia' => 'Get translations',
		'index.etykieta_nazwa' => 'Module name',
		'index.etykieta_porownanie_konfiguracji' => 'Compare configuration',
		'index.etykieta_select_wybierz' => '- select -',
		'index.etykieta_typ' => 'Module type',
		'index.tytul_strony' => 'Available modules',

		'podglad.blad_brak_modulu' => 'Cannot obtain modules data',
		'podglad.etykieta_cache' => 'Cache this module',
		'podglad.etykieta_dla_zalogowanych' => 'Signed-in users only',
		'podglad.etykieta_kod' => 'Code',
		'podglad.etykieta_nazwa' => 'Name',
		'podglad.etykieta_nie' => 'No',
		'podglad.etykieta_opis' => 'Description',
		'podglad.etykieta_projekty' => 'Projects that contain this module',
		'podglad.etykieta_tak' => 'Yes',
		'podglad.etykieta_typ' => 'Module type',
		'podglad.etykieta_uslugi' => 'Services',
		'podglad.etykieta_wymagane' => 'Required modules',
		'podglad.tytul_strony' => 'Module preview',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Main screen',
			'wykonajPodglad' => 'Preview',
		),

		'index.modul_typy' => array(
			'administracyjny' => 'Administrative',
			'zwykly' => 'Regular',
			'jednorazowy' => 'Singular',
			'blok' => 'Block',
		),
	);
}
