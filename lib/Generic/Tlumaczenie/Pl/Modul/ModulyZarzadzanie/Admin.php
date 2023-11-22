<?php
namespace Generic\Tlumaczenie\Pl\Modul\ModulyZarzadzanie;

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

		'index.etykieta_input_fraza' => 'Szukana fraza',
		'index.etykieta_input_szukaj' => 'Szukaj',
		'index.etykieta_input_typ' => 'Typ modułu',
		'index.etykieta_link_konfiguracja' => 'Pobierz konfigurację',
		'index.etykieta_link_logi' => 'Logi CMS-a',
		'index.etykieta_link_phpinfo' => 'Informacje o PHP',
		'index.etykieta_link_tlumaczenia' => 'Pobierz tłumaczenia',
		'index.etykieta_nazwa' => 'Nazwa modułu',
		'index.etykieta_porownanie_konfiguracji' => 'Porównanie konfiguracji',
		'index.etykieta_select_wybierz' => '- wybierz -',
		'index.etykieta_typ' => 'Typ modułu',
		'index.tytul_strony' => 'Dostępne moduły',

		'podglad.blad_brak_modulu' => 'Nie można pobrać danych modułu',
		'podglad.etykieta_cache' => 'Obsługuje cache',
		'podglad.etykieta_dla_zalogowanych' => 'Tylko dla zalogowanych',
		'podglad.etykieta_kod' => 'Kod',
		'podglad.etykieta_nazwa' => 'Nazwa',
		'podglad.etykieta_nie' => 'Nie',
		'podglad.etykieta_opis' => 'Opis',
		'podglad.etykieta_projekty' => 'Projekty zawierające moduł',
		'podglad.etykieta_tak' => 'Tak',
		'podglad.etykieta_typ' => 'Typ modułu',
		'podglad.etykieta_uslugi' => 'Usługi',
		'podglad.etykieta_wymagane' => 'Wymagane moduły',
		'podglad.tytul_strony' => 'Podgląd modułu',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie modułu',
			'wykonajPodglad' => 'Podgląd',
		),

		'index.modul_typy' => array(
			'administracyjny' => 'Administracyjny',
			'zwykly' => 'Zwykły',
			'jednorazowy' => 'Zwykły Jednorazowy',
			'blok' => 'Blok',
		),
	);
}
