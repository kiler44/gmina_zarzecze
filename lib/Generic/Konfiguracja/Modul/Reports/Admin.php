<?php
namespace Generic\Konfiguracja\Modul\Reports;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['doCsvRaport.naglowek_kolor_czcionki']
 * @property string $k['doCsvRaport.naglowek_kolor_tla']
 * @property string $k['doCsvRaport.wiersz_nieparzysty_kolor_tla']
 * @property string $k['doCsvRaport.wiersz_parzysty_kolor_tla']
 * @property array $k['dopuszczalne_typy_wykresow']
 * @property string $k['downloadExcel.format_domyslny']
 * @property string $k['downloadExcel.naglowek_kolor']
 * @property string $k['downloadExcel.nazwa_pliku']
 * @property string $k['downloadExcel.nazwy_kolumn']
 * @property string $k['downloadExcel.szerokosc_kolumny']
 * @property string $k['downloadExcel.szerokosc_kolumny_default']
 * @property array $k['formularz.cache.lista']
 * @property array $k['formularz.pracownicy_role']
 * @property array $k['formularz.wymagane_pola']
 * @property string $k['googleDistanceMartix_API_key']
 * @property string $k['grid_zdjecia_przedrostek']
 * @property array $k['grupy_raportow']
 * @property string $k['index.domyslne_sortowanie']
 * @property string $k['index.format_data_dodania']
 * @property string $k['index.format_daty_do']
 * @property string $k['index.format_daty_od']
 * @property array $k['index.pager_konfiguracja']
 * @property int $k['index.wierszy_na_stronie']
 * @property string $k['indexZarzadzanie.domyslne_sortowanie']
 * @property int $k['indexZarzadzanie.wierszy_na_stronie']
 * @property array $k['kategorie_edycja']
 * @property array $k['kategorie_raportow']
 * @property array $k['kategorie_wyslij_email']
 * @property string $k['podgladKlient.domyslne_sortowanie']
 * @property int $k['podgladKlient.wierszy_na_stronie']
 * @property string $k['podswietl_najnowsze_kolor_domyslny']
 * @property array $k['podswietl_najnowsze_kolor_kategoria']
 * @property string $k['raportyExcel.domyslne_godziny']
 * @property string $k['raportyExcel.domyslne_nadgodziny']
 * @property string $k['raportyExcel.domyslne_pauza']
 * @property string $k['raportyExcel.formatDatyNaglowekDnia']
 * @property string $k['raportyExcel.plik_kolejki']
 * @property string $k['szablon.formularz_wyszukiwarka']
 * @property string $k['szablon.pager']
 * @property string $k['szablonKlient.pager']
 * @property string $k['szablonKlient.tabela_danych']
 * @property string $k['szablonKlient.tabela_danych_podglad']
 * @property string $k['zapiszDzien.godzina_startu_pracy']
 * @property string $k['zapiszDzien.idTypowZamowien']
 * @property string $k['zapiszDzien.rodzaj_estymacji_trasy']
 * @property string $k['zapiszDzien.zamowieniaStatusy']
 * @property string $k['zapiszDzien.zamowieniaWorkStatusy']
 * @property string $k['zapiszaDzien.lokalizacjaBazy']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'doCsvRaport.naglowek_kolor_czcionki' => array(
		'opis' => 'Domyślny kolor podswietlenia jeżeli nie został ustawiony dla kategorii',
		'typ' => 'varchar',
		'wartosc' => 'white',
		),

	'doCsvRaport.naglowek_kolor_tla' => array(
		'opis' => 'Domyślny kolor podswietlenia jeżeli nie został ustawiony dla kategorii',
		'typ' => 'varchar',
		'wartosc' => '61',
		),

	'doCsvRaport.wiersz_nieparzysty_kolor_tla' => array(
		'opis' => 'Domyślny kolor podswietlenia jeżeli nie został ustawiony dla kategorii',
		'typ' => 'varchar',
		'wartosc' => 'white',
		),

	'doCsvRaport.wiersz_parzysty_kolor_tla' => array(
		'opis' => 'Domyślny kolor podswietlenia jeżeli nie został ustawiony dla kategorii',
		'typ' => 'varchar',
		'wartosc' => '60',
		),

	'dopuszczalne_typy_wykresow' => array(
		'opis' => 'Lista wyboru decydująca o typie wykresu',
		'typ' => 'array',
		'wartosc' => array(
			'' => 'Brak wykresu',
			'PieChart' => 'Kołowy',
			'BarChart' => 'Słupkowy poziomy',
			'ColumnChart' => 'Słupkowy pionowy',
			'LineChart' => 'Liniowy',
			),
		),

	'raportExcel.polaExcela' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(0 => 'A', 1 => 'B',2 => 'C',3 => 'D',4 => 'E',5 => 'F',6 => 'G',7 => 'H',8 => 'I',9 => 'J',10 => 'K',11 => 'L',12 => 'M',13 => 'N',14 => 'O',15 => 'P',16 => 'Q',17 => 'R',18 => 'S',19 => 'T', 20 => 'U',21 => 'V',22 => 'W',23 => 'X',24 => 'Y' ,25 => 'Z'),
	),
	'downloadExcel.format_domyslny' => array(
		'opis' => 'Domyślny format komórki excela',
		'typ' => 'array',
		'wartosc' => array(
				'Align' => 'left',
				'Border' => 1
			),
		),
	'downloadExcel.pokazuj_pelen_adres' => array(
		'opis' => 'Czy mają być zapisywane pełne adresy w raporcie, czy tylko kod pocztowy i miejscowość',
		'typ' => 'bool',
		'wartosc' => false,
		),
	'downloadExcel.naglowek_kolor' => array(
		'opis' => 'Kolor czcionki nagłówka',
		'typ' => 'varchar',
		'wartosc' => 'Black',
		),
	'downloadExcel.nazwa_pliku' => array(
		'opis' => 'Nazwa pliku raportu',
		'typ' => 'varchar',
		'wartosc' => 'report-{DATA_OD}-{DATA_DO}',
		),
	'downloadExcel.nazwy_kolumn' => array(
		'opis' => 'Nazwy kolumn',
		'typ' => 'array',
		'wartosc' => array(
				'Montører', 'Ordinære arbeidstimer', 'Betalt spisepause', 'Overtidstimer',
			),
		),
	'downloadExcel.nazwa_kolumy_czas_jazdy' => array(
		'opis' => 'Nazwa kolumn czasu jazdy',
		'typ' => 'varchar',
		'wartosc' => 'Oppsumert kjøretid i minutter google map',
		),
	
	'downloadExcel.nazwa_kolumy_kilometry_jazdy' => array(
		'opis' => 'Nazwa kolumny kilometrów jazdy',
		'typ' => 'varchar',
		'wartosc' => 'Oppsumert KM i google map',
		),
	'downloadExcel.dni_tygodnia' => array(
		'opis' => 'Dni tygodnia po norwesku - te które pójdą do excela',
		'typ' => 'array',
		'wartosc' => array(
				0 => 'søndag',
				1 => 'mandag',
				2 => 'tirsdag',
				3 => 'onsdag',
				4 => 'torsdag',
				5 => 'fredag',
				6 => 'lørdag',
			),
		),
	
	'downloadExcel.szerokosc_kolumny' => array(
		'opis' => 'Szerokości kolumn',
		'typ' => 'array',
		'wartosc' => array(
			'22', '14,44', '13,67', '13,44', 
			),
		),
	'downloadExcel.szerokosc_kolumny_default' => array(
		'opis' => 'Domyślna szerokość kolumny',
		'typ' => 'varchar',
		'wartosc' => '16',
		),
	'formularz.cache.lista' => array(
		'opis' => 'Lista wyboru decydujaca jak długo (w godzinach) ma być przetrzymywany cache dla danego raportu',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'Nie przechowuj',
			1 => '1 godzina',
			2 => '2 godziny',
			5 => '5 godzin',
			12 => '12 godzin',
			24 => 'doba',
			48 => '2 doby',
			72 => '3 doby',
			168 => 'tydzień',
			),
		),

	'formularz.pracownicy_role' => array(
		'opis' => 'Identyfikatory ról pracowników',
		'typ' => 'list',
		'wartosc' => array(
			'admin',
			'boss',
			),
		),

	'formularz.wymagane_pola' => array(
		'opis' => 'Wymagane pola formularza dodawania i edycji raportu.',
		'typ' => 'list',
		'wartosc' => array(
			'nazwa',
			'kodSql',
			'nazwyPol',
			),
		),

	'googleDistanceMartix_API_key' => array(
		'opis' => 'Google maps API key',
		'typ' => 'varchar',
		'wartosc' => 'AIzaSyBoF3U8ZpTdqzASTQnlzwQO36NdUatzWp4',
		),

	'grid_zdjecia_przedrostek' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'xs',
		),

	'grupy_raportow' => array(
		'opis' => 'Grupy raportów',
		'typ' => 'list',
		'wartosc' => array(
			'Apartments',
			'Workers',
			),
		),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'data_dodania',
		'dozwolone' => array(
			'data_dodania' => 'data_dodania',
			'data_od' => 'data_od',
			'obiekt' => 'obiekt',
			'kategoria' => 'kategoria',
			'data_do' => 'data_do',
			),
		),

	'index.format_data_dodania' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'd-m-Y H:i',
		),

	'index.format_daty_do' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'd-m-Y',
		),

	'index.format_daty_od' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'd-m-Y',
		),

	'index.pager_konfiguracja' => array(
		'opis' => 'Konfiguracja stronnicowania',
		'typ' => 'pager',
		'wartosc' => array(
			'zakres' => 5,
			'wyborStrony' => 'linki',
			'wyborZakresu' => 'select',
			'skoczDo' => 'form',
			'pierwszaOstatnia' => 1,
			'poprzedniaNastepna' => 1,
			),
		),
	'villaRaport.pager_konfiguracja' => array(
		'opis' => 'Konfiguracja stronnicowania',
		'typ' => 'pager',
		'wartosc' => array(
			'zakres' => 100,
			'wyborStrony' => 'linki',
			'wyborZakresu' => 'select',
			'skoczDo' => 'form',
			'pierwszaOstatnia' => 1,
			'poprzedniaNastepna' => 1,
			),
		),
	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście użytkowników',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'indexZarzadzanie.domyslne_sortowanie' => array(
		'opis' => 'Domyślne sortowanie na liście.',
		'typ' => 'select',
		'wartosc' => 'nazwa',
		'dozwolone' => array(
			0 => 'nazwa',
			),
		),

	'indexZarzadzanie.wierszy_na_stronie' => array(
		'maks' => '1000',
		'opis' => 'Ilość wierszy na stronie w liście.',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'kategorie_edycja' => array(
		'opis' => 'Tablica zawiera informacje o linku edycji raportu (modul:akcja:parametry) parametry - propercje obiektu reports',
		'typ' => 'array',
		'wartosc' => array(
			'villa instalacje raport faktura' => 'Corrections:index:dataOd:dataDo:id:idType',
			'b2b instalacje raport faktura' => 'Corrections:index:dataOd:dataDo:id:idType',
			'digging report' => 'Corrections:index:dataOd:dataDo:id:idType',
			'homenet villa report' => 'Corrections:index:dataOd:dataDo:id:idType',
			'gravebefaring raport faktura' => 'Corrections:index:dataOd:dataDo:id:idType',
			),
		),

	'kategorie_raportow' => array(
		'opis' => 'Kategorie raportów',
		'typ' => 'list',
		'wartosc' => array(
			'villa instalacje raport faktura',
			'b2b instalacje raport faktura',
			'digging report',
			'apartamenty',
			'gravebefaring raport faktura',
			'b2b befaring raport faktura',
			'homenet villa report'
			),
		),

	'kategorie_wyslij_email' => array(
		'opis' => 'Tablica zawiera informacją jaka templatka ma zostać użyta do wysłania maila z raportem w zależności od kategorii',
		'typ' => 'array',
		'wartosc' => array(
			'villa instalacje raport faktura' => 15,
			'b2b instalacje raport faktura' => 15,
			'digging report' => 15,
			'homenet villa report' => 15,
			'gravebefaring raport faktura' => 15
			),
		),

	'podgladKlient.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'data_dodania',
		'dozwolone' => array(
			0 => 'data_dodania',
			),
		),

	'podgladKlient.wierszy_na_stronie' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 20,
		),

	'podswietl_najnowsze_kolor_domyslny' => array(
		'opis' => 'Domyślny kolor podswietlenia jeżeli nie został ustawiony dla kategorii',
		'typ' => 'varchar',
		'wartosc' => '#FFFF66',
		),

	'podswietl_najnowsze_kolor_kategoria' => array(
		'opis' => 'Kolor podświetlenia najnowszych raportów z danej kategorii',
		'typ' => 'array',
		'wartosc' => array(
			'villa instalacje raport faktura' => '#bce8f1',
			'b2b instalacje raport faktura' => '#FCDA74',
			'digging report' => '#E0D5B1',
			'homenet villa report' => '#bce8f1',
			'gravebefaring raport faktura'  => '#E0D5B1',
			),
		),

	'raportyExcel.domyslne_godziny' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '9',
		),

	'raportyExcel.domyslne_nadgodziny' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '0',
		),

	'raportyExcel.domyslne_pauza' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '0.5',
		),

	'raportyExcel.formatDatyNaglowekDnia' => array(
		'opis' => 'Format daty w nagłówkach dni',
		'typ' => 'varchar',
		'wartosc' => 'd.m.Y',
		),

	'raportyExcel.plik_kolejki' => array(
		'opis' => 'Plik w którym zapisuje kolejkę zadań',
		'typ' => 'varchar',
		'wartosc' => 'kolejka.txt',
		),

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),

	'szablon.pager' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'szablonKlient.pager' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'pager_nowy.tpl',
		),

	'szablonKlient.tabela_danych' => array(
		'opis' => 'Szablon tabeli danych',
		'typ' => 'varchar',
		'wartosc' => 'tabela_danych.tpl',
		),

	'szablonKlient.tabela_danych_podglad' => array(
		'opis' => 'Szablon tabeli danych w podgladzie raportu',
		'typ' => 'varchar',
		'wartosc' => 'tabela_danych_be.tpl',
		),

	'zapiszDzien.godzina_startu_pracy' => array(
		'opis' => 'Godzina o której firma startuje pracę',
		'typ' => 'varchar',
		'wartosc' => '07:30',
		),

	'zapiszDzien.idTypowZamowien' => array(
		'opis' => 'ID typów zamówień branych do raportu excel',
		'typ' => 'array',
		'wartosc' => array(
			0 => 1,
			),
		),

	'zapiszDzien.rodzaj_estymacji_trasy' => array(
		'opis' => 'Rodzaj estymacji trasy w Google Distance Matrix',
		'typ' => 'array',
		'wartosc' => 'pesimistic',
		'dozwolone' => array(
			0 => 'best_guess',
			1 => 'optimistic',
			2 => 'pesimistic',
			),
		),

	'zapiszDzien.zamowieniaStatusy' => array(
		'opis' => 'Statusy zamówień branych do Raportu excel',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'closed',
			),
		),

	'zapiszDzien.zamowieniaWorkStatusy' => array(
		'opis' => 'Statusy pracy zamówień branych do Raportu excel',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'done',
			1 => 'not done',
			),
		),

	'zapiszaDzien.lokalizacjaBazy' => array(
		'opis' => 'Adres bazy BKT',
		'typ' => 'varchar',
		'wartosc' => 'Micheletveien 37B, 1053 OSLO',
		),

	);
}
