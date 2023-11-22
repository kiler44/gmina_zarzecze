<?php
namespace Generic\Tlumaczenie\No\Modul\ZadaniaCykliczne;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_brak_zadania']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.aktywne.etykieta']
 * @property string $t['formularz.aktywne.opis']
 * @property string $t['formularz.blad_nie_mozna_zapisac_zadania']
 * @property string $t['formularz.dataRozpoczecia.etykieta']
 * @property string $t['formularz.dataRozpoczecia.opis']
 * @property string $t['formularz.dataZakonczenia.etykieta']
 * @property string $t['formularz.dataZakonczenia.opis']
 * @property string $t['formularz.dodanoRazy']
 * @property string $t['formularz.dodawaneWielokrotnie.etykieta']
 * @property string $t['formularz.dodawaneWielokrotnie.opis']
 * @property string $t['formularz.etykieta_data_wybierz']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.etykieta_zadanie_brak_zadan']
 * @property string $t['formularz.info_zapisano_dane_zadania']
 * @property string $t['formularz.konfiguracja.etykieta']
 * @property string $t['formularz.konfiguracja.wartosc']
 * @property string $t['formularz.opisZadania.etykieta']
 * @property string $t['formularz.opisZadania.opis']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zadanie.etykieta']
 * @property string $t['formularz.zadanie.opis']
 * @property string $t['formularz.zapisCron.etykieta']
 * @property string $t['formularz.zapisCron.opis']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularzUruchom.dataDanych.etykieta']
 * @property string $t['formularzUruchom.dataDanych.opis']
 * @property string $t['formularzUruchom.dataTresci.etykieta']
 * @property string $t['formularzUruchom.dataTresci.opis']
 * @property string $t['formularzUruchom.info_uruchomiono_zadanie']
 * @property string $t['formularzUruchom.wstecz.wartosc']
 * @property string $t['formularzUruchom.zapisz.confirm']
 * @property string $t['formularzUruchom.zapisz.wartosc']
 * @property string $t['index.etykieta_akcja']
 * @property string $t['index.etykieta_aktywne']
 * @property string $t['index.etykieta_button_uruchom']
 * @property string $t['index.etykieta_data_rozpoczecia']
 * @property string $t['index.etykieta_data_zakonczenia']
 * @property string $t['index.etykieta_dodawane_wielokrotnie']
 * @property string $t['index.etykieta_id_kategorii']
 * @property string $t['index.etykieta_kod_modulu']
 * @property string $t['index.etykieta_link_doadaj']
 * @property string $t['index.etykieta_link_raport']
 * @property string $t['index.etykieta_link_sprawdz']
 * @property string $t['index.etykieta_schemat']
 * @property string $t['index.info_brak_modulow_cron']
 * @property string $t['index.tytul_strony']
 * @property string $t['raport.co']
 * @property string $t['raport.do']
 * @property string $t['raport.kazda_godz']
 * @property string $t['raport.kazda_min']
 * @property string $t['raport.kazdy_dzien']
 * @property string $t['raport.kazdy_miesiac']
 * @property string $t['raport.nazwa_raportu_xls']
 * @property string $t['raport.od']
 * @property string $t['sprawdz.szukaj.wartosc']
 * @property string $t['sprawdz.tytul_strony']
 * @property string $t['uruchom.tytul_strony']
 * @property string $t['usun.blad_brak_zadania']
 * @property string $t['usun.blad_nie_mozna_usunac_zadania']
 * @property string $t['usun.info_zadanie_usuniete']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajRaport']
 * @property string $t['_akcje_etykiety_']['wykonajSprawdz']
 * @property string $t['_akcje_etykiety_']['ustawWielokrotne']
 * @property string $t['_akcje_etykiety_']['wykonajUruchom']
 * @property array $t['raport.dni']
 * @property string $t['raport.dni']['0']
 * @property string $t['raport.dni']['1']
 * @property string $t['raport.dni']['2']
 * @property string $t['raport.dni']['3']
 * @property string $t['raport.dni']['4']
 * @property string $t['raport.dni']['5']
 * @property string $t['raport.dni']['6']
 * @property array $t['raport.miesiace']
 * @property string $t['raport.miesiace']['0']
 * @property string $t['raport.miesiace']['1']
 * @property string $t['raport.miesiace']['2']
 * @property string $t['raport.miesiace']['3']
 * @property string $t['raport.miesiace']['4']
 * @property string $t['raport.miesiace']['5']
 * @property string $t['raport.miesiace']['6']
 * @property string $t['raport.miesiace']['7']
 * @property string $t['raport.miesiace']['8']
 * @property string $t['raport.miesiace']['9']
 * @property string $t['raport.miesiace']['10']
 * @property string $t['raport.miesiace']['11']
 * @property string $t['raport.miesiace']['12']
 * @property array $t['raport.nazwy_wartosci_schematu']
 * @property string $t['raport.nazwy_wartosci_schematu']['0']
 * @property string $t['raport.nazwy_wartosci_schematu']['1']
 * @property string $t['raport.nazwy_wartosci_schematu']['2']
 * @property string $t['raport.nazwy_wartosci_schematu']['3']
 * @property string $t['raport.nazwy_wartosci_schematu']['4']
 * @property array $t['zadanie.aktywne']
 * @property string $t['zadanie.aktywne']['0']
 * @property string $t['zadanie.aktywne']['1']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'dodaj.tytul_strony' => 'Add task',

		'edytuj.blad_brak_zadania' => 'Cannot obtain task data',
		'edytuj.tytul_strony' => 'Edit task',

		'formularz.aktywne.etykieta' => 'Active tasks',
		'formularz.aktywne.opis' => '',
		'formularz.blad_nie_mozna_zapisac_zadania' => 'Cannot save task data!',
		'formularz.dataRozpoczecia.etykieta' => 'Start date',
		'formularz.dataRozpoczecia.opis' => '',
		'formularz.dataZakonczenia.etykieta' => 'End date',
		'formularz.dataZakonczenia.opis' => '',
		'formularz.dodanoRazy' => 'Addes %s-times',
		'formularz.dodawaneWielokrotnie.etykieta' => 'Allow to add next tasks',
		'formularz.dodawaneWielokrotnie.opis' => '',
		'formularz.etykieta_data_wybierz' => ' - ',
		'formularz.etykieta_select_wybierz' => '- select -',
		'formularz.etykieta_zadanie_brak_zadan' => 'No task to be done',
		'formularz.info_zapisano_dane_zadania' => 'Task saved',
		'formularz.konfiguracja.etykieta' => '&nbsp;',
		'formularz.konfiguracja.wartosc' => 'Edit task configuration',
		'formularz.opisZadania.etykieta' => 'Task description',
		'formularz.opisZadania.opis' => '',
		'formularz.wstecz.wartosc' => 'Back',
		'formularz.zadanie.etykieta' => 'Task to do',
		'formularz.zadanie.opis' => '',
		'formularz.zapisCron.etykieta' => 'Done time',
		'formularz.zapisCron.opis' => '',
		'formularz.zapisz.wartosc' => 'Save',

		'formularzUruchom.dataDanych.etykieta' => 'Date of data',
		'formularzUruchom.dataDanych.opis' => 'Simulated date of task run',
		'formularzUruchom.dataTresci.etykieta' => 'Date of content',
		'formularzUruchom.dataTresci.opis' => 'Simulated date of task run (e-mails etc.)',
		'formularzUruchom.info_uruchomiono_zadanie' => 'Task was ran. Check logs',
		'formularzUruchom.wstecz.wartosc' => 'Back',
		'formularzUruchom.zapisz.confirm' => 'Are you sure you want to run this task?',
		'formularzUruchom.zapisz.wartosc' => 'Run',

		'index.etykieta_akcja' => 'Action',
		'index.etykieta_aktywne' => 'Active',
		'index.etykieta_button_uruchom' => 'Run this task',
		'index.etykieta_data_rozpoczecia' => 'Start date',
		'index.etykieta_data_zakonczenia' => 'End date',
		'index.etykieta_dodawane_wielokrotnie' => 'Allow to add next task',
		'index.etykieta_id_kategorii' => 'Category',
		'index.etykieta_kod_modulu' => 'Module',
		'index.etykieta_link_doadaj' => 'Add task',
		'index.etykieta_link_raport' => 'Download raport of task completion',
		'index.etykieta_link_sprawdz' => 'List of next coming tasks',
		'index.etykieta_schemat' => 'Running',
		'index.info_brak_modulow_cron' => 'No modules with cron tasks.',
		'index.tytul_strony' => 'Cron tasks management',
		'index.tytul_modulu' => 'Cron tasks management',

		'raport.co' => 'what ',
		'raport.do' => ' to ',
		'raport.kazda_godz' => 'every hour, ',
		'raport.kazda_min' => 'every minute, ',
		'raport.kazdy_dzien' => 'every day, ',
		'raport.kazdy_miesiac' => 'every month, ',
		'raport.nazwa_raportu_xls' => 'Raport_of_cron_tasks',
		'raport.od' => ' from ',

		'sprawdz.szukaj.wartosc' => 'Check',
		'sprawdz.tytul_strony' => 'Check next coming tasks',

		'uruchom.tytul_strony' => 'Run tasks',

		'usun.blad_brak_zadania' => 'Cannot obtain tasks data',
		'usun.blad_nie_mozna_usunac_zadania' => 'Cannot remove task!',
		'usun.info_zadanie_usuniete' => 'Task removed',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'List of tasks',
			'wykonajDodaj' => 'Add tasks',
			'wykonajEdytuj' => 'Edit tasks',
			'wykonajUsun' => 'Delete tasks',
			'wykonajRaport' => 'raport of added tasks',
			'wykonajSprawdz' => 'Check next coming tasks',
			'ustawWielokrotne' => 'Can run task again',
			'wykonajUruchom' => 'Manual tasks run',
		),
		'raport.dni' => array(
			'0' => 'on sunday',
			'1' => 'on monday',
			'2' => 'on tuesday',
			'3' => 'on wednesday',
			'4' => 'on thursday',
			'5' => 'on friday',
			'6' => 'on saturday',
		),
		'raport.miesiace' => array(
			'0' => '',
			'1' => 'january,',
			'2' => 'february,',
			'3' => 'march,',
			'4' => 'april,',
			'5' => 'may,',
			'6' => 'june,',
			'7' => 'july,',
			'8' => 'august,',
			'9' => 'september,',
			'10' => 'october,',
			'11' => 'november,',
			'12' => 'december,',
		),
		'raport.nazwy_wartosci_schematu' => array(
			'0' => ' min.,',
			'1' => ' hour. ',
			'2' => ' day of month,',
			'3' => '',
			'4' => '',
		),

		'zadanie.aktywne' => array(
			'0' => 'No',
			'1' => 'Yes',
		),
	);
}
