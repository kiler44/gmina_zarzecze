<?php
namespace Generic\Tlumaczenie\Pl\Modul\MenuAplikacji;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.etykieta_zarzadzanie_widokami']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'index.tytul_strony' => 'Menu aplikacji',
		'ustawienia.komunikat_przed_edycja' => 'Przed edycją należy wybrać użytkownika, któremu konfigurujemy menu. W innym przypadku menu konfigurowane jest dla wszystkich użytkowników.',
		'ustawienia.brak_uprawnien_wybranego_uzytkownika_komunikat' => 'Wybrany użytkownik nie ma dostępu do żadnej akcji. Wybierz innego użytkownika badź nadaj mu odpowiednie uprawnienia.',
		'ustawienia.formularz_nie_wypełniony_komunikat' => 'Formularz dodawania pozycji nie został poprawnie wypełniony',
		'ustawienia.dodano_pozycje_menu_komunikat' => 'Pozycja menu aplikacji została dodana',
		'ustawienia.nie_dodano_pozycji_menu_komunikat_blad' => 'Nie udało się dodać pozycji menu aplikacji',
		'ustawienia.tytul_strony' => 'Ustawienia menu aplikacji',
		'ustawienia.tytul_modulu' => 'Ustawienia menu aplikacji',
		'ustawienia.etykieta_elementy' => 'Lista elementów menu',
		'ustawienia.uzytkownik_etykieta' => 'Wybierz użytkownika',
		'ustawienia.uzytkownik_etykieta_wybierz' => '- wszyscy użytkownicy -',
		'ustawienia.etykieta_modulAkcja' => 'Moduł & akcja',
		'ustawienia.etykieta_etykietaKontener' => 'Etykieta',
		'ustawienia.etykieta_wybierz' => '- Wybierz -',
		'ustawienia.etykieta_parametry' => 'Parametry',
		'ustawienia.etykieta_anchor' => 'Anchor',
		'ustawienia.etykieta_ikona' => 'Ikona',
		'ustawienia.etykieta_edytuj' => 'Edytuj',
		'ustawienia.etykieta_usun' => 'Unuń',
		'ustawienia.etykieta_dodaj_pozycje' => 'Zapisz',
		'ustawienia.etykieta_dodaj' => 'Dodaj element',
		'ustawienia.etykieta_zapisz_kolejnosc' => 'Zapisz nową kolejność',
		'ustawienia.komunikat_zmieniono_kolejnosc' => 'Den valgte sekvens av menyelementene har blitt lagret.',
		'ustawienia.error_nie_zmieniono_kolejnosci' => 'Klarte ikke å lagre den nye rekkefølgen på menyvalg.',
		'ustawienia.etykieta_zamknij' => 'Zamknij',
		'ustawienia.etykieta_wstecz' => 'Wstecz',
		
		'edytuj.tytul_strony' => 'Edycja pozycji menu',
		'edytuj.tytul_modulu' => 'Edycja pozycji menu',
		'edytuj.brak_wiersza_dla_id' => 'Bład żądania dla podanego parametru.',
		'edytuj.sciezka_lista_elementow' => 'Lista pozycji',
		
		'usun.success_usunieto_pozycje' => 'Wybrana pozycja menu została usunięta',
		'usun.error_nie_usunieto_pozycji' => 'Wystapił bład podczas próby usunięcia pozycji menu.',
		'usun.error_brak_pozycji' => 'Nie odnaleziono wybranej pozycji menu.',
		
		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie głównego menu panelu',
			'wykonajEdytuj' => 'Edycja pozycji menu',
			'wykonajUstawienia' => 'Zarzadzanie pozycjami menu',
			'wykonajUsun' => 'Usunięcie pozycji menu',
		),
	);
}
