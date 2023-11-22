<?php
namespace Generic\Tlumaczenie\Pl\Modul\Mailing;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.blad_istnieja_w_tym_czasie']
 * @property string $t['dodaj.blad_nie_mozna_przeniesc_pliku']
 * @property string $t['dodaj.blad_nie_mozna_zapisac_cron']
 * @property string $t['dodaj.blad_nie_mozna_zapisac_mailingu']
 * @property string $t['dodaj.info_zapisano_dane_mailingu']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_brak_mailingu']
 * @property string $t['edytuj.blad_nie_mozna_edytowac']
 * @property string $t['edytuj.blad_nie_mozna_zapisac_mailingu']
 * @property string $t['edytuj.info_zapisano_dane_mailingu']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['emailTestowy.blad.nie_mozna_wyslac_emaila']
 * @property string $t['emailTestowy.info_wyslano_poprawnie']
 * @property string $t['etykieta_dodaj']
 * @property string $t['formularz.dataWysylki.etykieta']
 * @property string $t['formularz.emailNadawcy.etykieta']
 * @property string $t['formularz.emailTestowy.etykieta']
 * @property string $t['formularz.nazwa.etykieta']
 * @property string $t['formularz.nazwaNadawcy.etykieta']
 * @property string $t['formularz.plikZLista.etykieta']
 * @property string $t['formularz.pobierzRaport.wartosc']
 * @property string $t['formularz.pominSprawdzanieZgody.etykieta']
 * @property string $t['formularz.tresc.etykieta']
 * @property string $t['formularz.trescHtml.etykieta']
 * @property string $t['formularz.tytul.etykieta']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.wyslijTestowo.wartosc']
 * @property string $t['formularz.zaladujSzablon.etykieta']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['index.etykieta_aktywna']
 * @property string $t['index.etykieta_button_listaOdbiorcow']
 * @property string $t['index.etykieta_dataDodania']
 * @property string $t['index.etykieta_dataWysylki']
 * @property string $t['index.etykieta_dataZakonczenia']
 * @property string $t['index.etykieta_ileAdresow']
 * @property string $t['index.etykieta_ileBledow']
 * @property string $t['index.etykieta_ileWyslano']
 * @property string $t['index.etykieta_nazwa']
 * @property string $t['index.etykieta_postep']
 * @property string $t['index.nie']
 * @property string $t['index.tak']
 * @property string $t['index.tytul_strony']
 * @property string $t['podglad.tytul_strony']
 * @property string $t['usun.blad_brak_mailingu']
 * @property string $t['usun.blad_nie_mozna_usunac_mailingu']
 * @property string $t['usun.info_mailing_usuniety']
 * @property string $t['wyslijTestowo.blad_niepelne_dane']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajPodglad']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'dodaj.blad_istnieja_w_tym_czasie' => 'W wybranym czasie istnieje już lista wysyłkowa. Wybierz inną datę.',
		'dodaj.blad_nie_mozna_przeniesc_pliku' => 'Wystapil błąd. Nie można zapisać listy odbiorców',
		'dodaj.blad_nie_mozna_zapisac_cron' => 'Wystapil błąd. Nie można zapisać zadania Cron\'a',
		'dodaj.blad_nie_mozna_zapisac_mailingu' => 'Wystąpil błąd. Nie można zapisać mailingu',
		'dodaj.info_zapisano_dane_mailingu' => 'Zapisano dane mailingu',
		'dodaj.tytul_strony' => 'Dodaj nową listę wysyłkową',

		'edytuj.blad_brak_mailingu' => 'Wybrana lista wysyłkowa nie istnieje',
		'edytuj.blad_nie_mozna_edytowac' => 'Nie można edytować tej listy wysyłkowej',
		'edytuj.blad_nie_mozna_zapisac_mailingu' => 'Wystąpil błąd. Nie możnazmodyfikować danych mailingu',
		'edytuj.info_zapisano_dane_mailingu' => 'Zmodyfikowano dane mailingu',
		'edytuj.tytul_strony' => 'Edytuj listę wysyłkową',

		'emailTestowy.blad.nie_mozna_wyslac_emaila' => 'Wystąpił bład podczas wysyłki emaila testowego',
		'emailTestowy.info_wyslano_poprawnie' => 'Wysłano email testowy',

		'etykieta_dodaj' => 'Utwórz nową listę wysyłkową',

		'formularz.dataWysylki.etykieta' => 'Data wysyłki',
		'formularz.emailNadawcy.etykieta' => 'Email nadawcy',
		'formularz.emailTestowy.etykieta' => 'Adres e-mail do testów',
		'formularz.nazwa.etykieta' => 'Nazwa listy',
		'formularz.nazwaNadawcy.etykieta' => 'Nazwa nadawcy',
		'formularz.plikZLista.etykieta' => 'Plik CSV z listą odbiorców',
		'formularz.pobierzRaport.wartosc' => 'Pobierz raport',
		'formularz.pominSprawdzanieZgody.etykieta' => 'Pomin weryfikację zgody na otrzymanie mailingu',
		'formularz.tresc.etykieta' => 'Treść',
		'formularz.trescHtml.etykieta' => 'Treść HTML',
		'formularz.tytul.etykieta' => 'Tytuł wiadomości',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.wyslijTestowo.wartosc' => 'Wyślij testowo',
		'formularz.zaladujSzablon.etykieta' => 'Załaduj szablon',
		'formularz.zapisz.wartosc' => 'Zapisz',

		'index.etykieta_aktywna' => 'Aktywna',
		'index.etykieta_button_listaOdbiorcow' => 'Pokaż listę odbiorców',
		'index.etykieta_dataDodania' => 'Data dodania',
		'index.etykieta_dataWysylki' => 'Data Wysylki',
		'index.etykieta_dataZakonczenia' => 'Data zakończenia',
		'index.etykieta_ileAdresow' => 'Ilość maili',
		'index.etykieta_ileBledow' => 'Ilość błedów',
		'index.etykieta_ileWyslano' => 'Wysłano',
		'index.etykieta_nazwa' => 'Nazwa',
		'index.etykieta_postep' => 'Postęp',
		'index.nie' => 'NIE',
		'index.tak' => 'TAK',
		'index.tytul_strony' => 'Masowe wysylanie wiadomości e-mail',

		'podglad.tytul_strony' => 'Podglad listy wysyłkowej',

		'usun.blad_brak_mailingu' => 'Wybrana lista wysyłkowa nie istnieje',
		'usun.blad_nie_mozna_usunac_mailingu' => 'Nie można usunąć wybranej listy wysyłkowej',
		'usun.info_mailing_usuniety' => 'Wybrana lista wysyłkowa zostala usunięta',

		'wyslijTestowo.blad_niepelne_dane' => 'Aby wyslać email testowy podaj przynajmniej tytuł, treść oraz adres e-mail, na jaki ma on zostać wyslany.',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie modułu',
			'wykonajDodaj' => 'Dodawanie listy wysyłkowej',
			'wykonajEdytuj' => 'Edycja listy wysyłkowej',
			'wykonajPodglad' => 'Podglad listy wysyłkowej',
			'wykonajUsun' => 'Usuwanie listy wysyłkowej',
		),
	);
}
