<?php
namespace Generic\Tlumaczenie\Pl\Modul\CacheZarzadzanie;

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
	
		'cacheBaza.etykieta_data_modyfikacji' => 'Data modyfikacji',
		'cacheBaza.etykieta_nazwa' => 'Nazwa pliku tabeli',
		'cacheBaza.tytul_strony' => 'Pliki cache tabel w bazie',
		'cacheBloki.etykieta_cache' => 'Cache',
		'cacheBloki.etykieta_cache_czas' => 'Czas cache',
		'cacheBloki.etykieta_data_modyfikacji' => 'Data modyfikacji',
		'cacheBloki.etykieta_edytuj' => 'Edytuj',
		'cacheBloki.etykieta_kod_modulu' => 'Moduł',
		'cacheBloki.etykieta_nazwa' => 'Nazwa bloku',
		'cacheBloki.etykieta_usun' => 'Usuń',
		'cacheBloki.etykieta_usun_pytanie' => 'Czy na pewno usunąć plik cache dla bloku?',
		'cacheBloki.tytul_strony' => 'Lista bloków obsługujących cache',

		'cacheStrony.etykieta_data_modyfikacji' => 'Data modyfikacji',
		'cacheStrony.etykieta_nazwa' => 'Url w cache',
		'cacheStrony.tytul_strony' => 'Statyczne strony serwisu',

		'cacheWizytowki.etykieta_data_modyfikacji' => 'Data modyfikacji',
		'cacheWizytowki.etykieta_nazwa' => 'Subdomena',
		'cacheWizytowki.tytul_strony' => 'Statyczne strony wizytowek',

		'czyscCacheBaza.blad_wyczyszczono_cache' => 'Nie można wyczyścić cache dla baziy danych',
		'czyscCacheBaza.info_wyczyszczono_cache' => 'Wyczyszczono cache dla bazy danych',

		'czyscCacheBloki.blad_wyczyszczono_cache' => 'Nie można wyczyścić cache bloków z treścią',
		'czyscCacheBloki.info_wyczyszczono_cache' => 'Wyczyszczono cache bloków z treścią',

		'czyscCachePhp.blad_wyczyszczono_cache' => 'Nie można wyczyścić cache plików PHP',
		'czyscCachePhp.info_wyczyszczono_cache' => 'Wyczyszczono cache plików PHP',

		'czyscCacheStrony.blad_wyczyszczono_cache' => 'Nie można wyczyścić statycznych stron serwisu',
		'czyscCacheStrony.info_wyczyszczono_cache' => 'Wyczyszczono statyczne strony serwisu',

		'czyscCacheTpl.blad_wyczyszczono_cache' => 'Nie można wyczyścić cache szablonów',
		'czyscCacheTpl.info_wyczyszczono_cache' => 'Wyczyszczono cache szablonów',

		'czyscCacheWizytowki.blad_wyczyszczono_cache' => 'Nie można wyczyścić statycznych stron wizytówek',
		'czyscCacheWizytowki.info_wyczyszczono_cache' => 'Wyczyszczono statyczne strony wizytówek',

		'edytujCacheBloku.blad_brak_bloku' => 'Nie można pobrać danych bloku',
		'edytujCacheBloku.blad_nie_mozna_zapisac_bloku' => 'Nie można zapisać danych bloku!',
		'edytujCacheBloku.cache.etykieta' => 'Włączyć cache dla bloku',
		'edytujCacheBloku.cache.opis' => '',
		'edytujCacheBloku.cacheCzas.etykieta' => 'Czas odświeżania cache',
		'edytujCacheBloku.cacheCzas.opis' => 'Co jaki czas wygenerowany cache ma się odświeżać',
		'edytujCacheBloku.cacheCzysc.etykieta' => 'Czyść cache',
		'edytujCacheBloku.cacheCzysc.opis' => 'Czy wyczyścić plik cache',
		'edytujCacheBloku.etykieta_select_wybierz' => ' - wybierz - ',
		'edytujCacheBloku.info_usunieto_cache_bloku' => 'Usunięto cache bloku',
		'edytujCacheBloku.info_zapisano_dane_bloku' => 'Zaktualizowano dane bloku',
		'edytujCacheBloku.nazwa.etykieta' => 'Nazwa',
		'edytujCacheBloku.nazwa.opis' => '',
		'edytujCacheBloku.tytul_strony' => 'Edycja ustawień cache bloku',
		'edytujCacheBloku.widoki.etykieta' => 'Widoki powiązane',
		'edytujCacheBloku.widoki.opis' => '',
		'edytujCacheBloku.wstecz.wartosc' => 'Wstecz',
		'edytujCacheBloku.zapisz.wartosc' => 'Zapisz',

		'formularzWyszukiwania.czysc.wartosc' => 'Czyść',
		'formularzWyszukiwania.data_modyfikacji.etykieta' => 'Data modyfikacji',
		'formularzWyszukiwania.fraza.etykieta' => 'Fraza',
		'formularzWyszukiwania.szukaj.wartosc' => 'Szukaj',

		'index.etykieta_cache_baza' => 'Cache tabel w bazie danych',
		'index.etykieta_cache_baza_ilosc' => 'Zawiera <span class="badge badge-inverse">%d</span> plików tabel',
		'index.etykieta_cache_bloki' => 'Cache bloków z treścią',
		'index.etykieta_cache_bloki_ilosc' => 'Zawiera <span class="badge badge-inverse">%d</span> plików z cache dla bloków',
		'index.etykieta_cache_php' => 'Cache plików PHP',
		'index.etykieta_cache_php_ilosc' => 'Zawiera <span class="badge badge-inverse">%d</span> plików dla podstron',
		'index.etykieta_cache_strony' => 'Statyczne strony serwisu',
		'index.etykieta_cache_strony_ilosc' => 'Zawiera <span class="badge badge-inverse">%d</span> plików',
		'index.etykieta_cache_system' => 'Cache systemu (niskopoziomowy)',
		'index.etykieta_cache_tpl' => 'Cache plików szablonów',
		'index.etykieta_cache_tpl_ilosc' => 'Zawiera <span class="badge badge-inverse">%d</span> plików dla podstron',
		'index.etykieta_cache_widok' => 'Cache widoku (wysokopoziomowy)',
		'index.etykieta_cache_wizytowki' => 'Statyczne strony wizytowek',
		'index.etykieta_cache_wizytowki_ilosc' => 'Zawiera <span class="badge badge-inverse">%d</span> wizytówek',
		'index.etykieta_cache_wlaczony' => 'Status: <span class="label label-success">Włączony</span></br>',
		'index.etykieta_cache_wylaczony' => 'Status: <span class="label">Wyłączony</span></br>',
		'index.etykieta_link_cache_baza' => 'Szczegóły',
		'index.etykieta_link_cache_bloki' => 'Szczegóły',
		'index.etykieta_link_cache_strony' => 'Szczegóły',
		'index.etykieta_link_cache_wizytowki' => 'Szczegóły',
		'index.etykieta_link_czysc_cache_baza' => 'Czyść wszystko',
		'index.etykieta_link_czysc_cache_baza_pytanie' => 'Czy wyczyścić cache dla tabel bazy danych?',
		'index.etykieta_link_czysc_cache_bloki' => 'Czyść wszystko',
		'index.etykieta_link_czysc_cache_bloki_pytanie' => 'Czy wyczyścić cache dla wszystkich bloków?',
		'index.etykieta_link_czysc_cache_php' => 'Czyść wszystko',
		'index.etykieta_link_czysc_cache_php_pytanie' => 'Czy wyczyścić cały cache dla plików php?',
		'index.etykieta_link_czysc_cache_strony' => 'Czyść wszystko',
		'index.etykieta_link_czysc_cache_strony_pytanie' => 'Czy wyczyścić statyczne strony dla serwisu?',
		'index.etykieta_link_czysc_cache_tpl' => 'Czyść wszystko',
		'index.etykieta_link_czysc_cache_tpl_pytanie' => 'Czy wyczyścić cały cache dla plików szablonów?',
		'index.etykieta_link_czysc_cache_wizytowki' => 'Czyść wszystko',
		'index.etykieta_link_czysc_cache_wizytowki_pytanie' => 'Czy wyczyścić statyczne strony dla wszystkich wizytówek?',
		'index.tytul_strony' => 'Zarządzanie Cache',

		'podglad.etykieta_data_modyfikacji' => 'Data modyfikacji',
		'podglad.etykieta_nazwa' => 'Nazwa pliku',
		'podglad.etykieta_usun' => 'Usuń',
		'podglad.etykieta_usun_pytanie' => 'Czy na pewno usunąć plik cache dla wizytowki?',
		'podglad.tytul_strony' => 'Podgląd statycznych stron wizytowki "%s"',

		'usun.blad_nie_mozna_usunac_plikow' => 'nie można usunąć plików',
		'usun.info_usunieto_pliki' => 'Usunięto pliki',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie głównego menu panelu',
			'wykonajCacheWizytowki' => 'Szczegóły cache wizytówek',
			'wykonajCacheStrony' => 'Szczegóły cache stron',
			'wykonajCacheBloki' => 'Szczegóły cache bloków',
			'wykonajCacheBaza' => 'Szczegóły cache bazy',
			'wykonajEdytujCacheBloku' => 'Edycja cache bloku',
			'wykonajPodglad' => 'Podgląd cache wizytówki',
			'wykonajUsun' => 'Usuwanie plików z cache',
			'wykonajCzyscCacheWizytowki' => 'Czyść cache wizytówki',
			'wykonajCzyscCacheStrony' => 'Czyść cache strony',
			'wykonajCzyscCacheBloki' => 'Czyść cache bloku',
			'wykonajCzyscCacheBaza' => 'Czyść cache baza',
			'wykonajCzyscCachePhp' => 'Czyść cache PHP',
			'wykonajCzyscCacheTpl' => 'Czyść cache TPL',
		),

		'cacheBloki.cache_czas_wartosci' => array(
			'0' => 'Brak limitu',
			'60' => '1 minuta',
			'300' => '5 minut',
			'900' => '15 minut',
			'1800' => '30 minut',
			'3600' => '1 godzina',
			'86400' => '24 godziny',
		),
		'cacheBloki.cache_wartosci' => array(
			'0' => '&nbsp;',
			'1' => '<strong>Włączony</strong>',
		),
	);
}
