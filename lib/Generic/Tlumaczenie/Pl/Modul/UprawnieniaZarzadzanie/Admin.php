<?php
namespace Generic\Tlumaczenie\Pl\Modul\UprawnieniaZarzadzanie;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.etykieta_odwroc_zaznaczenie']
 * @property string $t['dodaj.etykieta_odznacz_wiele']
 * @property string $t['dodaj.etykieta_zaznacz_wiele']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_nie_mozna_pobrac_roli']
 * @property string $t['edytuj.etykieta_odwroc_zaznaczenie']
 * @property string $t['edytuj.etykieta_odznacz_wiele']
 * @property string $t['edytuj.etykieta_zaznacz_wiele']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.blad_nie_mozna_zapisac_roli']
 * @property string $t['formularz.etykieta_input_kod']
 * @property string $t['formularz.etykieta_input_nazwa']
 * @property string $t['formularz.etykieta_input_opis']
 * @property string $t['formularz.etykieta_input_wstecz']
 * @property string $t['formularz.etykieta_input_zapisz']
 * @property string $t['formularz.region_bloki']
 * @property string $t['formularz.region_moduly']
 * @property string $t['formularz.zakladka_dane']
 * @property string $t['formularz.zakladka_moduly']
 * @property string $t['formularz.zapisano_dane_roli']
 * @property string $t['index.etykieta_kod']
 * @property string $t['index.etykieta_link_dodaj']
 * @property string $t['index.etykieta_nazwa']
 * @property string $t['index.etykieta_opis']
 * @property string $t['index.tytul_strony']
 * @property string $t['podglad.etykieta_edytuj']
 * @property string $t['podglad.etykieta_kod']
 * @property string $t['podglad.etykieta_link_edytuj']
 * @property string $t['podglad.etykieta_link_uprawnienia_administracyjne']
 * @property string $t['podglad.etykieta_link_uprawnienia_tresci']
 * @property string $t['podglad.etykieta_nazwa']
 * @property string $t['podglad.etykieta_opis']
 * @property string $t['podglad.etykieta_uprawnienia_administracyjne']
 * @property string $t['podglad.etykieta_uprawnienia_tresci']
 * @property string $t['podglad.tytul_strony']
 * @property string $t['uprawnieniaAdministracyjne.blad_nie_mozna_pobrac_roli']
 * @property string $t['uprawnieniaAdministracyjne.blad_nie_mozna_zapisac_uprawnien']
 * @property string $t['uprawnieniaAdministracyjne.etykieta_odwroc_zaznaczenie']
 * @property string $t['uprawnieniaAdministracyjne.etykieta_odznacz_wiele']
 * @property string $t['uprawnieniaAdministracyjne.etykieta_zaznacz_wiele']
 * @property string $t['uprawnieniaAdministracyjne.info_zapisano_uprawnienia']
 * @property string $t['uprawnieniaAdministracyjne.tytul_strony']
 * @property string $t['uprawnieniaTresci.blad_nie_mozna_pobrac_roli']
 * @property string $t['uprawnieniaTresci.blad_nie_mozna_zapisac_uprawnien']
 * @property string $t['uprawnieniaTresci.etykieta_odwroc_zaznaczenie']
 * @property string $t['uprawnieniaTresci.etykieta_odznacz_wiele']
 * @property string $t['uprawnieniaTresci.etykieta_zaznacz_wiele']
 * @property string $t['uprawnieniaTresci.info_zapisano_uprawnienia']
 * @property string $t['uprawnieniaTresci.tytul_strony']
 * @property string $t['usun.blad_brak_roli']
 * @property string $t['usun.blad_nie_mozna_usunac_roli']
 * @property string $t['usun.info_rola_usunieta']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajPodglad']
 * @property string $t['_akcje_etykiety_']['wykonajUprawnieniaTresci']
 * @property string $t['_akcje_etykiety_']['wykonajUprawnieniaAdministracyjne']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'dodaj.etykieta_odwroc_zaznaczenie' => 'Odwróć zaznaczenie',
		'dodaj.etykieta_odznacz_wiele' => 'Odznacz wszystkie',
		'dodaj.etykieta_zaznacz_wiele' => 'Zaznacz wszystkie',
		'dodaj.tytul_strony' => 'Dodawanie roli',

		'edytuj.blad_nie_mozna_pobrac_roli' => 'Nie można pobrać danych roli',
		'edytuj.etykieta_odwroc_zaznaczenie' => 'Odwróć zaznaczenie',
		'edytuj.etykieta_odznacz_wiele' => 'Odznacz wszystkie',
		'edytuj.etykieta_zaznacz_wiele' => 'Zaznacz wszystkie',
		'edytuj.tytul_strony' => 'Edycja roli',

		'formularz.blad_nie_mozna_zapisac_roli' => 'Nie można zapisać roli',
		'formularz.etykieta_input_kod' => 'Kod',
		'formularz.etykieta_input_nazwa' => 'Nazwa',
		'formularz.etykieta_input_opis' => 'Opis',
		'formularz.etykieta_input_wstecz' => 'Wstecz',
		'formularz.etykieta_input_zapisz' => 'Zapisz',
		'formularz.region_bloki' => 'Dostępne bloki',
		'formularz.region_moduly' => 'Dostępne moduły',
		'formularz.zakladka_dane' => 'Dane roli',
		'formularz.zakladka_moduly' => 'Moduły z automatycznym dostępem',
		'formularz.zapisano_dane_roli' => 'Zapisano dane roli',
		'formularz.kontekstowa.etykieta' => 'Rola kontekstowa',
		'formularz.kontekstowa.opis' => 'Jeżeli tak do przydzielenia uprawnień wymagany będzie odpowiedni kontekst.',
		'formularz.kontekstowa.lista' => array(
			1 => 'nie',
			2 => 'tak',
		),
		'formularz.kontekstObiekt.etykieta' => 'Powiązany obiekt',
		'formularz.kontekstObiekt.opis' => '',
		'formularz.kontekstPole.etykieta' => 'Pole obiektu',
		'formularz.kontekstPole.opis' => '',
		'formularz.kontekstPowiazanie.etykieta' => 'Powiązanie uzytkownika z obiektem',
		'formularz.kontekstPowiazanie.opis' => '',
		'formularz.kontekstPowiazanieKtoreId.etykieta' => 'Ktore pole identyfikatora w obiekcie powiązanym?',
		'formularz.kontekstPowiazanieKtoreId.opis' => '',
		'formularz.kontekstPowiazanieKtoreId.lista' => array(
			'' => '- Wybierz -',
			1 => 'ID1',
			2 => 'ID2'
		),
		'formularz.wybierz' => '- Wybierz -',

		'index.etykieta_kod' => 'Kod',
		'index.etykieta_link_dodaj' => 'Dodaj nową rolę',
		'index.etykieta_nazwa' => 'Nazwa',
		'index.etykieta_opis' => 'Opis',
		'index.tytul_strony' => 'Role użytkowników w systemie',

		'podglad.etykieta_edytuj' => 'Edycja danych i automatycznego tworzenia uprawnień dla roli',
		'podglad.etykieta_kod' => 'Kod',
		'podglad.etykieta_link_edytuj' => 'Edytuj rolę',
		'podglad.etykieta_link_uprawnienia_administracyjne' => 'Edytuj uprawnienia',
		'podglad.etykieta_link_uprawnienia_tresci' => 'Edytuj uprawnienia',
		'podglad.etykieta_link_uprawnienia_obiektow' => 'Edytuj uprawnienia',
		'podglad.etykieta_nazwa' => 'Nazwa',
		'podglad.etykieta_opis' => 'Opis',
		'podglad.etykieta_uprawnienia_administracyjne' => 'Edycja uprawnień administracyjnych',
		'podglad.etykieta_uprawnienia_tresci' => 'Edycja uprawnień do tresci',
		'podglad.etykieta_uprawnienia_obiektow' => 'Edycja uprawnień do obiektów',
		'podglad.tytul_strony' => 'Informacje o roli',
		'podglad.etykieta_uprawnienia_do_eventow' => 'Edytuj uprawnienia do wydarzeń kalendarza',
		'podglad.etykieta_link_uprawnienia_do_eventow' => 'Edytuj uprawnienia do wydarzeń',

		'uprawnieniaAdministracyjne.blad_nie_mozna_pobrac_roli' => 'Nie można pobrać danych roli',
		'uprawnieniaAdministracyjne.blad_nie_mozna_zapisac_uprawnien' => 'Nie można zapisać uprawnień dla roli',
		'uprawnieniaAdministracyjne.etykieta_odwroc_zaznaczenie' => 'Odwróć zaznaczenie',
		'uprawnieniaAdministracyjne.etykieta_odznacz_wiele' => 'Odznacz wszystkie',
		'uprawnieniaAdministracyjne.etykieta_zaznacz_wiele' => 'Zaznacz wszystkie',
		'uprawnieniaAdministracyjne.info_zapisano_uprawnienia' => 'Zapisano uprawnienia dla roli',
		'uprawnieniaAdministracyjne.tytul_strony' => 'Edycja uprawnień administracyjnych dla roli "%s"',
		
		'uprawnieniaEventow.tytul_strony' => 'Edit event permissions for role "%s"',
		'uprawnieniaEventow.brak_uprawnien_do_kalendarza' => 'This role does not have permission to Calendar module',

		'uprawnieniaObiektow.blad_nie_mozna_pobrac_roli' => 'Nie można pobrać danych roli',
		'uprawnieniaObiektow.blad_nie_mozna_zapisac_uprawnien' => 'Nie można zapisać uprawnień dla roli',
		'uprawnieniaObiektow.etykieta_odwroc_zaznaczenie' => 'Odwróć zaznaczenie',
		'uprawnieniaObiektow.etykieta_odznacz_wiele' => 'Odznacz wszystkie',
		'uprawnieniaObiektow.etykieta_zaznacz_wiele' => 'Zaznacz wszystkie',
		'uprawnieniaObiektow.info_zapisano_uprawnienia' => 'Zapisano uprawnienia dla roli',
		'uprawnieniaObiektow.tytul_strony' => 'Edycja uprawnień obiektów dla roli "%s"',
		'uprawnieniaObiektow.odczyt' => '<span style="color:#5BB75B;"><strong>%s</strong> odczyt</span>',
		'uprawnieniaObiektow.zapis' => '<span style="color:#DA4F49;"><strong>%s</strong> zapis</span>',

		'uprawnieniaTresci.blad_nie_mozna_pobrac_roli' => 'Nie można pobrać danych roli',
		'uprawnieniaTresci.blad_nie_mozna_zapisac_uprawnien' => 'Nie można zapisać uprawnień dla roli',
		'uprawnieniaTresci.etykieta_odwroc_zaznaczenie' => 'Odwróć zaznaczenie',
		'uprawnieniaTresci.etykieta_odznacz_wiele' => 'Odznacz wszystkie',
		'uprawnieniaTresci.etykieta_zaznacz_wiele' => 'Zaznacz wiele',
		'uprawnieniaTresci.info_zapisano_uprawnienia' => 'Zapisano uprawnienia dla roli',
		'uprawnieniaTresci.tytul_strony' => 'Edycja uprawnień do tresci dla roli "%s"',

		'usun.blad_brak_roli' => 'Nie można pobrać danych roli',
		'usun.blad_nie_mozna_usunac_roli' => 'NIe można usunąć roli',
		'usun.info_rola_usunieta' => 'Usunięto rolę',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista ról',
			'wykonajDodaj' => 'Dodawanie ról',
			'wykonajEdytuj' => 'Edycja ról',
			'wykonajPodglad' => 'Ekran główny edycji roli',
			'wykonajUprawnieniaTresci' => 'Edycja uprawnień do treści',
			'wykonajUprawnieniaAdministracyjne' => 'Edycja uprawnień administracyjnych',
			'wykonajUsun' => 'Usuwanie ról',
		),
	);
}
