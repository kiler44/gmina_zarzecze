<?php
namespace Generic\Tlumaczenie\No\Modul\Mailing;

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
	
		'dodaj.blad_istnieja_w_tym_czasie' => 'There is sending task at tjis time, select another date',
		'dodaj.blad_nie_mozna_przeniesc_pliku' => 'Error occured. Cannot save recipient table',
		'dodaj.blad_nie_mozna_zapisac_cron' => 'Error occured. Cannot save cron task',
		'dodaj.blad_nie_mozna_zapisac_mailingu' => 'Error occured. Cannot save mailing',
		'dodaj.info_zapisano_dane_mailingu' => 'Mailing saved',
		'dodaj.tytul_strony' => 'Create mailing list',

		'edytuj.blad_brak_mailingu' => 'Selected mailing list doesn\'t exists',
		'edytuj.blad_nie_mozna_edytowac' => 'Cannot edit selected mailing list',
		'edytuj.blad_nie_mozna_zapisac_mailingu' => 'Error occured. Cannot modify mailing list',
		'edytuj.info_zapisano_dane_mailingu' => 'mailing list modified',
		'edytuj.tytul_strony' => 'Edit mailing list',

		'emailTestowy.blad.nie_mozna_wyslac_emaila' => 'Error occured while sending test e-mail',
		'emailTestowy.info_wyslano_poprawnie' => 'Test e-mail sent',

		'etykieta_dodaj' => 'Create mailing list',

		'formularz.dataWysylki.etykieta' => 'Sending date',
		'formularz.emailNadawcy.etykieta' => 'Sender e-mail',
		'formularz.emailTestowy.etykieta' => 'Test address',
		'formularz.nazwa.etykieta' => 'List name',
		'formularz.nazwaNadawcy.etykieta' => 'Sender name',
		'formularz.plikZLista.etykieta' => 'CSV file with recipients list',
		'formularz.pobierzRaport.wartosc' => 'Download raport',
		'formularz.pominSprawdzanieZgody.etykieta' => 'Send mailing to everybody (agreement not respected)',
		'formularz.tresc.etykieta' => 'Message',
		'formularz.trescHtml.etykieta' => 'HTML message',
		'formularz.tytul.etykieta' => 'Title',
		'formularz.wstecz.wartosc' => 'Back',
		'formularz.wyslijTestowo.wartosc' => 'Send test',
		'formularz.zaladujSzablon.etykieta' => 'Load template',
		'formularz.zapisz.wartosc' => 'Save',

		'index.etykieta_aktywna' => 'Active',
		'index.etykieta_button_listaOdbiorcow' => 'Show recipients list',
		'index.etykieta_dataDodania' => 'Creation date',
		'index.etykieta_dataWysylki' => 'Sending date',
		'index.etykieta_dataZakonczenia' => 'End date',
		'index.etykieta_ileAdresow' => 'E-mail count',
		'index.etykieta_ileBledow' => 'Error count',
		'index.etykieta_ileWyslano' => 'Sent count',
		'index.etykieta_nazwa' => 'Name',
		'index.etykieta_postep' => 'Progress',
		'index.nie' => 'NO',
		'index.tak' => 'YES',
		'index.tytul_strony' => 'Mass mailing',

		'podglad.tytul_strony' => 'Mailing list preview',

		'usun.blad_brak_mailingu' => 'Selected mailing list doesn\'t exist',
		'usun.blad_nie_mozna_usunac_mailingu' => 'Cannot remove selected mailing list',
		'usun.info_mailing_usuniety' => 'Selected mailing list removed',

		'wyslijTestowo.blad_niepelne_dane' => 'To send test e-mail enter at least recipient address, title and message',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Index',
			'wykonajDodaj' => 'Create mailing list',
			'wykonajEdytuj' => 'Edit mailing list',
			'wykonajPodglad' => 'Preview mailing list',
			'wykonajUsun' => 'Delete mailing list',
		),
	);
}
