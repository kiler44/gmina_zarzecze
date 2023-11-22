<?php
namespace Generic\Tlumaczenie\No\Modul\MenuAplikacji;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.etykieta_zarzadzanie_widokami']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'index.tytul_strony' => 'Applikasjonsmenyen',
		'ustawienia.komunikat_przed_edycja' => 'Før redigering, velger du brukeren du konfigurere menyen. Ellers er menyen konfigureres for alle brukere.',
		'ustawienia.brak_uprawnien_wybranego_uzytkownika_komunikat' => 'Valgte bruker ikke har tilgang til noen av handlingen. Velg en annen bruker eller gi ham de nødvendige tillatelsene.',
		'ustawienia.formularz_nie_wypełniony_komunikat' => 'Skjemaet ble ikke riktig utfylt',
		'ustawienia.dodano_pozycje_menu_komunikat' => 'Søknad menyvalget ble lagret',
		'ustawienia.nie_dodano_pozycji_menu_komunikat_blad' => 'Søknad menyvalget ble ikke lagret - noen feil oppstod',
		'ustawienia.tytul_strony' => 'Innstillinger programmeny',
		'ustawienia.tytul_modulu' => 'Innstillinger programmeny',
		'ustawienia.uzytkownik_etykieta' => 'Velg bruker',
		'ustawienia.etykieta_elementy' => 'Menyelementer',
		'ustawienia.uzytkownik_etykieta_wybierz' => '- alle brukere -',
		'ustawienia.etykieta_modulAkcja' => 'Modulen & handling',
		'ustawienia.etykieta_etykietaKontener' => 'Etikett',
		'ustawienia.etykieta_wybierz' => '- Velg -',
		'ustawienia.etykieta_parametry' => 'Parametere',
		'ustawienia.etykieta_anchor' => 'Anchor',
		'ustawienia.etykieta_ikona' => 'Ikon',
		'ustawienia.etykieta_edytuj' => 'Rediger',
		'ustawienia.etykieta_usun' => 'Fjerne',
		'ustawienia.etykieta_dodaj_pozycje' => 'Lagre',
		'ustawienia.etykieta_dodaj' => 'Legg menyelement',
		'ustawienia.etykieta_zapisz_kolejnosc' => 'Lagre den nye orden',
		'ustawienia.komunikat_zmieniono_kolejnosc' => 'Wybrana kolejność elementów menu została zapisana.',
		'ustawienia.error_nie_zmieniono_kolejnosci' => 'Nie udało się zapisać nowej kolejności elementów menu',
		'ustawienia.etykieta_zamknij' => 'Lukk',
		'ustawienia.etykieta_wstecz' => 'Tilbake',
		
		'edytuj.tytul_strony' => 'Edit-menyen stilling',
		'edytuj.tytul_modulu' => 'Edit-menyen stilling',
		'edytuj.brak_wiersza_dla_id' => 'Request for gitte parametere er ugyldig',
		'edytuj.sciezka_lista_elementow' => 'Liste over elementer',
		
		'usun.success_usunieto_pozycje' => 'Valgte menypunktet ble slettet',
		'usun.error_nie_usunieto_pozycji' => 'Det oppsto en feil under sletting valgte elementet.',
		'usun.error_brak_pozycji' => 'Kan ikke få valgt element data.',
		
		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Visibility of control panel menu',
			'wykonajEdytuj' => 'Elementer Rediger meny',
			'wykonajUstawienia' => 'Menyelementer administrasjon',
			'wykonajUsun' => 'Fjerne menyelementer',
		),
	);
}
