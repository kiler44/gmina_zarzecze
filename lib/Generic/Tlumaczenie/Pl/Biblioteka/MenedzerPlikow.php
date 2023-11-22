<?php
namespace Generic\Tlumaczenie\Pl\Biblioteka;

use Generic\Tlumaczenie\Tlumaczenie;


/**
 * @property string $t['menedzer_plikow_nazwa']
 * @property string $t['menedzer_plikow_menu']
 * @property string $t['menedzer_plikow_brak']
 * @property string $t['menedzer_plikow_wyslij']
 * @property string $t['menedzer_plikow_glowna']
 * @property string $t['menedzer_plikow_stworz']
 * @property string $t['menedzer_plikow_usun']
 * @property string $t['menedzer_plikow_zmienNazwe']
 * @property string $t['menedzer_plikow_kom_kopiowanie']
 * @property string $t['menedzer_plikow_kom_kopiowanieBlad']
 * @property string $t['menedzer_plikow_kom_przenoszenie']
 * @property string $t['menedzer_plikow_kom_przenoszenieBlad']
 * @property string $t['menedzer_plikow_kom_nowyKatalog']
 * @property string $t['menedzer_plikow_kom_nowyKatalogBlad']
 * @property string $t['menedzer_plikow_kom_zmianaNazwy']
 * @property string $t['menedzer_plikow_kom_zmianaNazwyBlad']
 * @property string $t['menedzer_plikow_kom_upload']
 * @property string $t['menedzer_plikow_kom_uploadBlad']
 * @property string $t['menedzer_plikow_kom_usun']
 * @property string $t['menedzer_plikow_kom_usunBlad']
 * @property string $t['menedzer_plikow_kom_zleRozszerzenie']
 * @property string $t['menedzer_plikow_kom_zlaSciezka']
 * @property string $t['menedzer_plikow_kom_domyslny']
 * @property string $t['menedzer_plikow_kom_pustePole']
 * @property string $t['menedzer_plikow_kom_zlaSciezka']
 * @property string $t['menedzer_plikow_kom_zlaSciezkaMin']
 * @property string $t['menedzer_plikow_kom_zlaNazwa']
 * @property string $t['menedzer_plikow_kom_zlyRozmiar']
 * @property string $t['menedzer_plikow_kom_zmianaNazwy']
 * @property string $t['menedzer_plikow_poprawNazwe']
 * @property string $t['menedzer_plikow_kom_przenoszenieOff']
 * @property string $t['menedzer_plikow_kom_uploadOff']
 * @property string $t['menedzer_plikow_kom_zmianaNazwyOff']
 * @property string $t['menedzer_plikow_kom_usuwanieOff']
 * @property string $t['menedzer_plikow_kom_tworzenieKatalogowOff']
 * @property string $t['menedzer_plikow_brak_sciezka']
 * @property string $t['menedzer_etykieta_upload']
 */
class MenedzerPlikow extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'menedzer_plikow_nazwa' => 'Menadzer plików',
		'menedzer_plikow_menu' => 'Drzewo katalogów',
		'menedzer_plikow_brak' => '..',
		'menedzer_plikow_wyslij' => 'Upload',
		'menedzer_plikow_glowna' => 'Główny katalog',
		'menedzer_plikow_stworz' => 'Stwórz katalog',
		'menedzer_plikow_usun' => 'Czy jesteś pewien że chcesz usunć wybrany element?',
		'menedzer_plikow_zmienNazwe' => 'Wprowadź nazwę pliku:',
		'menedzer_plikow_kom_kopiowanie' => 'Wybrane pliki zostały skopiowane',
		'menedzer_plikow_kom_kopiowanieBlad' => 'Nie można było skopiować wybranych plików',
		'menedzer_plikow_kom_przenoszenie' => 'Wybrane pliki zostały przeniesione',
		'menedzer_plikow_kom_przenoszenieBlad' => 'Nie można przenosić plików tutaj',
		'menedzer_plikow_kom_nowyKatalog' => 'Katalog utworzony',
		'menedzer_plikow_kom_nowyKatalogBlad' => 'Nie udało się utworzyć katalogu',
		'menedzer_plikow_kom_zmianaNazwy' => 'Nazwa pliku zmieniona',
		'menedzer_plikow_kom_zmianaNazwyBlad' => 'Nie udało się zmienić nazwy pliku',
		'menedzer_plikow_kom_upload' => 'Plik został załadowany',
		'menedzer_plikow_kom_uploadBlad' => 'Wystpił błd podczas ładowania pliku',
		'menedzer_plikow_kom_usun' => 'Zaznaczony plik został usunięty',
		'menedzer_plikow_kom_usunBlad' => 'Wystapił błd podczas usuwania pliku',
		'menedzer_plikow_kom_zleRozszerzenie' => 'Zabronieone rozszerzenie pliku',
		'menedzer_plikow_kom_zlaSciezka' => 'Podana ścieżka jest nieprawidłowa',
		'menedzer_plikow_kom_domyslny' => 'Złap i upuść pliki aby je przenosić pomiędzy katalogami',
		'menedzer_plikow_kom_pustePole' => 'Podaj nazwę katalogu',
		'menedzer_plikow_kom_zlaSciezka' => 'Podana ścieżka jest nieprawidłowa',
		'menedzer_plikow_kom_zlaSciezkaMin' => 'Podana ścieżka dla miniaturki jest nieprawidłowa',
		'menedzer_plikow_kom_zlaNazwa' => 'Nazwa pliku jest nieprawidłowa',
		'menedzer_plikow_kom_zlyRozmiar' => 'Maksymalny rozmiar pliku przekroczony (%s)',
		'menedzer_plikow_kom_zmianaNazwy' => 'Nazwa pliku została automatycznie poprawiona to: %s',
		'menedzer_plikow_poprawNazwe' => 'Nazwa pliku jest niepoprawna, prosze podaj prawidłową',
		'menedzer_plikow_kom_przenoszenieOff' => 'Przenoszenie plików zablokowane',
		'menedzer_plikow_kom_uploadOff' => 'Upload plików został zablokowany',
		'menedzer_plikow_kom_zmianaNazwyOff' => 'Zmiana nazwy plików zablokowana',
		'menedzer_plikow_kom_usuwanieOff' => 'Usuwanie plików zablokowane',
		'menedzer_plikow_kom_tworzenieKatalogowOff' => 'Tworzenie katalogów zablokowane',
		'menedzer_plikow_brak_sciezka' => 'Błedna konfiguracja menadzera plików, skontaktuj się z administratorem',
		'menedzer_etykieta_upload' => 'Załaduj pliki',
		'menedzer_etykieta_katalogi' => 'Tworzenie katalogów',
		'menadzer_etykieta_kolumna_nazwa' => 'nazwa',
		'menadzer_etykieta_kolumna_typ' => 'Typ',
		'menadzer_etykieta_kolumna_rozmiar' => 'Rozmiar',
		'menadzer_etykieta_kolumna_data' => 'Data',
	);
}