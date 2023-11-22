<?php
namespace Generic\Tlumaczenie\En\Modul\CacheZarzadzanie;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['cacheBaza.etykieta_data_modyfikacji']
 * @property string $t['cacheBaza.etykieta_nazwa']
 * @property string $t['cacheBaza.tytul_strony']
 * @property string $t['cacheBloki.etykieta_cache']
 * @property string $t['cacheBloki.etykieta_cache_czas']
 * @property string $t['cacheBloki.etykieta_data_modyfikacji']
 * @property string $t['cacheBloki.etykieta_edytuj']
 * @property string $t['cacheBloki.etykieta_kod_modulu']
 * @property string $t['cacheBloki.etykieta_nazwa']
 * @property string $t['cacheBloki.etykieta_usun']
 * @property string $t['cacheBloki.etykieta_usun_pytanie']
 * @property string $t['cacheBloki.tytul_strony']
 * @property string $t['cacheStrony.etykieta_data_modyfikacji']
 * @property string $t['cacheStrony.etykieta_nazwa']
 * @property string $t['cacheStrony.tytul_strony']
 * @property string $t['cacheWizytowki.etykieta_data_modyfikacji']
 * @property string $t['cacheWizytowki.etykieta_nazwa']
 * @property string $t['cacheWizytowki.tytul_strony']
 * @property string $t['czyscCacheBaza.blad_wyczyszczono_cache']
 * @property string $t['czyscCacheBaza.info_wyczyszczono_cache']
 * @property string $t['czyscCacheBloki.blad_wyczyszczono_cache']
 * @property string $t['czyscCacheBloki.info_wyczyszczono_cache']
 * @property string $t['czyscCachePhp.blad_wyczyszczono_cache']
 * @property string $t['czyscCachePhp.info_wyczyszczono_cache']
 * @property string $t['czyscCacheStrony.blad_wyczyszczono_cache']
 * @property string $t['czyscCacheStrony.info_wyczyszczono_cache']
 * @property string $t['czyscCacheTpl.blad_wyczyszczono_cache']
 * @property string $t['czyscCacheTpl.info_wyczyszczono_cache']
 * @property string $t['czyscCacheWizytowki.blad_wyczyszczono_cache']
 * @property string $t['czyscCacheWizytowki.info_wyczyszczono_cache']
 * @property string $t['edytujCacheBloku.blad_brak_bloku']
 * @property string $t['edytujCacheBloku.blad_nie_mozna_zapisac_bloku']
 * @property string $t['edytujCacheBloku.cache.etykieta']
 * @property string $t['edytujCacheBloku.cache.opis']
 * @property string $t['edytujCacheBloku.cacheCzas.etykieta']
 * @property string $t['edytujCacheBloku.cacheCzas.opis']
 * @property string $t['edytujCacheBloku.cacheCzysc.etykieta']
 * @property string $t['edytujCacheBloku.cacheCzysc.opis']
 * @property string $t['edytujCacheBloku.etykieta_select_wybierz']
 * @property string $t['edytujCacheBloku.info_usunieto_cache_bloku']
 * @property string $t['edytujCacheBloku.info_zapisano_dane_bloku']
 * @property string $t['edytujCacheBloku.nazwa.etykieta']
 * @property string $t['edytujCacheBloku.nazwa.opis']
 * @property string $t['edytujCacheBloku.tytul_strony']
 * @property string $t['edytujCacheBloku.widoki.etykieta']
 * @property string $t['edytujCacheBloku.widoki.opis']
 * @property string $t['edytujCacheBloku.wstecz.wartosc']
 * @property string $t['edytujCacheBloku.zapisz.wartosc']
 * @property string $t['formularzWyszukiwania.czysc.wartosc']
 * @property string $t['formularzWyszukiwania.data_modyfikacji.etykieta']
 * @property string $t['formularzWyszukiwania.fraza.etykieta']
 * @property string $t['formularzWyszukiwania.szukaj.wartosc']
 * @property string $t['index.etykieta_cache_baza']
 * @property string $t['index.etykieta_cache_baza_ilosc']
 * @property string $t['index.etykieta_cache_bloki']
 * @property string $t['index.etykieta_cache_bloki_ilosc']
 * @property string $t['index.etykieta_cache_php']
 * @property string $t['index.etykieta_cache_php_ilosc']
 * @property string $t['index.etykieta_cache_strony']
 * @property string $t['index.etykieta_cache_strony_ilosc']
 * @property string $t['index.etykieta_cache_system']
 * @property string $t['index.etykieta_cache_tpl']
 * @property string $t['index.etykieta_cache_tpl_ilosc']
 * @property string $t['index.etykieta_cache_widok']
 * @property string $t['index.etykieta_cache_wizytowki']
 * @property string $t['index.etykieta_cache_wizytowki_ilosc']
 * @property string $t['index.etykieta_cache_wlaczony']
 * @property string $t['index.etykieta_cache_wylaczony']
 * @property string $t['index.etykieta_link_cache_baza']
 * @property string $t['index.etykieta_link_cache_bloki']
 * @property string $t['index.etykieta_link_cache_strony']
 * @property string $t['index.etykieta_link_cache_wizytowki']
 * @property string $t['index.etykieta_link_czysc_cache_baza']
 * @property string $t['index.etykieta_link_czysc_cache_baza_pytanie']
 * @property string $t['index.etykieta_link_czysc_cache_bloki']
 * @property string $t['index.etykieta_link_czysc_cache_bloki_pytanie']
 * @property string $t['index.etykieta_link_czysc_cache_php']
 * @property string $t['index.etykieta_link_czysc_cache_php_pytanie']
 * @property string $t['index.etykieta_link_czysc_cache_strony']
 * @property string $t['index.etykieta_link_czysc_cache_strony_pytanie']
 * @property string $t['index.etykieta_link_czysc_cache_tpl']
 * @property string $t['index.etykieta_link_czysc_cache_tpl_pytanie']
 * @property string $t['index.etykieta_link_czysc_cache_wizytowki']
 * @property string $t['index.etykieta_link_czysc_cache_wizytowki_pytanie']
 * @property string $t['index.tytul_strony']
 * @property string $t['podglad.etykieta_data_modyfikacji']
 * @property string $t['podglad.etykieta_nazwa']
 * @property string $t['podglad.etykieta_usun']
 * @property string $t['podglad.etykieta_usun_pytanie']
 * @property string $t['podglad.tytul_strony']
 * @property string $t['usun.blad_nie_mozna_usunac_plikow']
 * @property string $t['usun.info_usunieto_pliki']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajCacheWizytowki']
 * @property string $t['_akcje_etykiety_']['wykonajCacheStrony']
 * @property string $t['_akcje_etykiety_']['wykonajCacheBloki']
 * @property string $t['_akcje_etykiety_']['wykonajCacheBaza']
 * @property string $t['_akcje_etykiety_']['wykonajEdytujCacheBloku']
 * @property string $t['_akcje_etykiety_']['wykonajPodglad']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscCacheWizytowki']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscCacheStrony']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscCacheBloki']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscCacheBaza']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscCachePhp']
 * @property string $t['_akcje_etykiety_']['wykonajCzyscCacheTpl']
 * @property array $t['cacheBloki.cache_czas_wartosci']
 * @property string $t['cacheBloki.cache_czas_wartosci']['0']
 * @property string $t['cacheBloki.cache_czas_wartosci']['60']
 * @property string $t['cacheBloki.cache_czas_wartosci']['300']
 * @property string $t['cacheBloki.cache_czas_wartosci']['900']
 * @property string $t['cacheBloki.cache_czas_wartosci']['1800']
 * @property string $t['cacheBloki.cache_czas_wartosci']['3600']
 * @property string $t['cacheBloki.cache_czas_wartosci']['86400']
 * @property array $t['cacheBloki.cache_wartosci']
 * @property string $t['cacheBloki.cache_wartosci']['0']
 * @property string $t['cacheBloki.cache_wartosci']['1']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'cacheBaza.etykieta_data_modyfikacji' => 'Date of modification',
		'cacheBaza.etykieta_nazwa' => 'Table filename',
		'cacheBaza.tytul_strony' => 'Cache files in DB table',
		'cacheBloki.etykieta_cache' => 'Cache',
		'cacheBloki.etykieta_cache_czas' => 'Cache time',
		'cacheBloki.etykieta_data_modyfikacji' => 'Date of modification',
		'cacheBloki.etykieta_edytuj' => 'Edit',
		'cacheBloki.etykieta_kod_modulu' => 'Module',
		'cacheBloki.etykieta_nazwa' => 'Block name',
		'cacheBloki.etykieta_usun' => 'Delete',
		'cacheBloki.etykieta_usun_pytanie' => 'Dou you want to remove block cache file?',
		'cacheBloki.tytul_strony' => 'List of blocks thst uses cache',

		'cacheStrony.etykieta_data_modyfikacji' => 'Date of modification',
		'cacheStrony.etykieta_nazwa' => 'Cache url',
		'cacheStrony.tytul_strony' => 'Static pages cache',

		'cacheWizytowki.etykieta_data_modyfikacji' => 'Date of modification',
		'cacheWizytowki.etykieta_nazwa' => 'Subdomain',
		'cacheWizytowki.tytul_strony' => 'Static pages cache',

		'czyscCacheBaza.blad_wyczyszczono_cache' => 'Cannot clear DB cache',
		'czyscCacheBaza.info_wyczyszczono_cache' => 'DB cache cleared',

		'czyscCacheBloki.blad_wyczyszczono_cache' => 'Cannot clear blocks cache',
		'czyscCacheBloki.info_wyczyszczono_cache' => 'Block cache cleared',

		'czyscCachePhp.blad_wyczyszczono_cache' => 'Cannot clear PHP cache',
		'czyscCachePhp.info_wyczyszczono_cache' => 'PHP cache cleared',

		'czyscCacheStrony.blad_wyczyszczono_cache' => 'Cannot clear static pages cache',
		'czyscCacheStrony.info_wyczyszczono_cache' => 'Static pages cache cleared',

		'czyscCacheTpl.blad_wyczyszczono_cache' => 'Cannot clear templates cache',
		'czyscCacheTpl.info_wyczyszczono_cache' => 'Templates cache cleared',

		'czyscCacheWizytowki.blad_wyczyszczono_cache' => 'Cannot clear static pages cache',
		'czyscCacheWizytowki.info_wyczyszczono_cache' => 'Static pages cache cleared',

		'edytujCacheBloku.blad_brak_bloku' => 'Cannot obtain block data',
		'edytujCacheBloku.blad_nie_mozna_zapisac_bloku' => 'Cannot save block data!',
		'edytujCacheBloku.cache.etykieta' => 'Turn on block cache',
		'edytujCacheBloku.cache.opis' => '',
		'edytujCacheBloku.cacheCzas.etykieta' => 'cache renewal time',
		'edytujCacheBloku.cacheCzas.opis' => 'How often cache should be renewed',
		'edytujCacheBloku.cacheCzysc.etykieta' => 'Clear cache',
		'edytujCacheBloku.cacheCzysc.opis' => 'Clear cache?',
		'edytujCacheBloku.etykieta_select_wybierz' => ' - select - ',
		'edytujCacheBloku.info_usunieto_cache_bloku' => 'Block cache cleared',
		'edytujCacheBloku.info_zapisano_dane_bloku' => 'Block data updated',
		'edytujCacheBloku.nazwa.etykieta' => 'Name',
		'edytujCacheBloku.nazwa.opis' => '',
		'edytujCacheBloku.tytul_strony' => 'Block cache settings',
		'edytujCacheBloku.widoki.etykieta' => 'Layouts assignment',
		'edytujCacheBloku.widoki.opis' => '',
		'edytujCacheBloku.wstecz.wartosc' => 'Back',
		'edytujCacheBloku.zapisz.wartosc' => 'Save',

		'formularzWyszukiwania.czysc.wartosc' => 'Clear',
		'formularzWyszukiwania.data_modyfikacji.etykieta' => 'Date of modification',
		'formularzWyszukiwania.fraza.etykieta' => 'Phrase',
		'formularzWyszukiwania.szukaj.wartosc' => 'Search',

		'index.etykieta_cache_baza' => 'DB tables cache',
		'index.etykieta_cache_baza_ilosc' => 'Contains <span class="badge badge-inverse">%d</span> table cache files',
		'index.etykieta_cache_bloki' => 'Blocks cache',
		'index.etykieta_cache_bloki_ilosc' => 'Contains <span class="badge badge-inverse">%d</span> block cache files',
		'index.etykieta_cache_php' => 'PHP cache',
		'index.etykieta_cache_php_ilosc' => 'Contains <span class="badge badge-inverse">%d</span> static pages cache files',
		'index.etykieta_cache_strony' => 'Static pages',
		'index.etykieta_cache_strony_ilosc' => 'Contains <span class="badge badge-inverse">%d</span> files',
		'index.etykieta_cache_system' => 'System cache (low level)',
		'index.etykieta_cache_tpl' => 'Templates cache',
		'index.etykieta_cache_tpl_ilosc' => 'Contains <span class="badge badge-inverse">%d</span> static pages cache files',
		'index.etykieta_cache_widok' => 'View cache (high level)',
		'index.etykieta_cache_wizytowki' => 'Static presentation cache',
		'index.etykieta_cache_wizytowki_ilosc' => 'contains <span class="badge badge-inverse">%d</span> presentations cache files',
		'index.etykieta_cache_wlaczony' => 'Status: <span class="label label-success">On</span></br>',
		'index.etykieta_cache_wylaczony' => 'Status: <span class="label">Off</span></br>',
		'index.etykieta_link_cache_baza' => 'Details',
		'index.etykieta_link_cache_bloki' => 'Details',
		'index.etykieta_link_cache_strony' => 'Details',
		'index.etykieta_link_cache_wizytowki' => 'Details',
		'index.etykieta_link_czysc_cache_baza' => 'Clear all',
		'index.etykieta_link_czysc_cache_baza_pytanie' => 'Do you want to clear DB tables cache?',
		'index.etykieta_link_czysc_cache_bloki' => 'Clear all',
		'index.etykieta_link_czysc_cache_bloki_pytanie' => 'Do you wan to clear all blocks cache?',
		'index.etykieta_link_czysc_cache_php' => 'Clear all',
		'index.etykieta_link_czysc_cache_php_pytanie' => 'Do you want co clear all PHP cache?',
		'index.etykieta_link_czysc_cache_strony' => 'Clear all',
		'index.etykieta_link_czysc_cache_strony_pytanie' => 'Do you want to clear all static pages cache?',
		'index.etykieta_link_czysc_cache_tpl' => 'Clear all',
		'index.etykieta_link_czysc_cache_tpl_pytanie' => 'Do you want to clear all templates cache?',
		'index.etykieta_link_czysc_cache_wizytowki' => 'Clear all',
		'index.etykieta_link_czysc_cache_wizytowki_pytanie' => 'Dou you want to clear all static presentations cache?',
		'index.tytul_strony' => 'Cache management',

		'podglad.etykieta_data_modyfikacji' => 'Date of modification',
		'podglad.etykieta_nazwa' => 'Filename',
		'podglad.etykieta_usun' => 'Delete',
		'podglad.etykieta_usun_pytanie' => 'Dou you want to delete presentation cache file?',
		'podglad.tytul_strony' => 'Preview of presentation cache files "%s"',

		'usun.blad_nie_mozna_usunac_plikow' => 'Cannot delete files',
		'usun.info_usunieto_pliki' => 'Files removed',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Index',
			'wykonajCacheWizytowki' => 'Presentations cache',
			'wykonajCacheStrony' => 'Static pages cache',
			'wykonajCacheBloki' => 'Blocks cache',
			'wykonajCacheBaza' => 'DB cache',
			'wykonajEdytujCacheBloku' => 'Edit block cache',
			'wykonajPodglad' => 'Presentation cache preview',
			'wykonajUsun' => 'Delete cache files',
			'wykonajCzyscCacheWizytowki' => 'Clear all presentations cache',
			'wykonajCzyscCacheStrony' => 'Clear page cache',
			'wykonajCzyscCacheBloki' => 'Clear block cache',
			'wykonajCzyscCacheBaza' => 'Clear DB cache',
			'wykonajCzyscCachePhp' => 'Clear PHP cache',
			'wykonajCzyscCacheTpl' => 'Clear TPL cache',
		),

		'cacheBloki.cache_czas_wartosci' => array(
			'0' => 'Don\' clear',
			'60' => '1 minute',
			'300' => '5 minutes',
			'900' => '15 minutes',
			'1800' => '30 minutes',
			'3600' => '1 hour',
			'86400' => '24 hours',
		),
		'cacheBloki.cache_wartosci' => array(
			'0' => '&nbsp;',
			'1' => '<strong>On</strong>',
		),
	);
}
