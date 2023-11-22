<?php
namespace Generic\Konfiguracja\Modul\Kalendarz;

use Generic\Konfiguracja\Konfiguracja;

/**
 * Zawiera konfigurację dla Generic\Modul\Kalendarz\Admin
 *
 */
class Admin extends Konfiguracja
{
	/**
	* Domyślna konfiguracja
	* @var array
	*/
	protected $konfiguracjaDomyslna = array(
		'szukajZamowienie.id_typu_zamowienia' => array(
			'opis' => '',
			'typ' => 'list',
			'wartosc' => array(
				4,
			),
		),
		'konfiguracja.zakresDatStart' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'varchar',
			'wartosc' => '-|7|day',
		),
		'konfiguracja.zakresDatStop' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'varchar',
			'wartosc' => '+|7|day',
		),
		'konfiguracja.zakresDatSuwakStart' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'varchar',
			'wartosc' => '-|7|day',
		),
		'konfiguracja.zakresDatSuwakStop' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'varchar',
			'wartosc' => '+|3|month',
		),
		'konfiguracja.ilosc_wyswietlanych_teamow' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'int',
			'wartosc' => 10,
		),
		'konfiguracja.grupy_teamow' => array(
			'opis' => 'Nie przywracać musi byc w bazie. Nazwy grup teamow kod => nazwa',
			'typ' => 'array',
			'wartosc' => array(
				'villa' => 'Villa group',
				'digging' => 'Digging group',
			),
		),
		'konfiguracja.teamy_w_grupach' => array(
			'opis' => 'Nie przywracać musi byc w bazie. Teamy zawarte w grupach kodGrupy => lista teamow',
			'typ' => 'array',
			'wartosc' => array(
				'villa' => '|2|3|4|5|6|7|8|',
				'digging' => '|40|41|42|43|',
			),
		),
		'konfiguracja.grupy_teamow_pracownika' => array(
			'opis' => 'Nie przywracać musi byc w bazie. Grupy użytkowników. Id użytkownika => lista grup',
			'typ' => 'array',
			'wartosc' => array(
				'1' => '|villa|digging|',
				'17' => '|villa|digging|',
			),
		),
		'konfiguracja.kolejnosc_wyswietlania_teamow_uzytkownik' => array(
			'opis' => 'Nie przywracać musi byc w bazie. Teamy wyswietlane na liście dla pracownikow urzywających kalendarza. Id użytkownika => posortowana lista teamow',
			'typ' => 'array',
			'wartosc' => array(
				'1' => '|36|20|14|34|28|24|17|38|31|39|33|37|18|32|19|11|25|23|',
				'17' => '|36|20|14|34|28|24|17|38|31|39|33|37|18|32|19|11|25|23|',
			),
		),
		'konfiguracja.domyslna_grupa' => array(
			'opis' => 'Nie przywracać musi byc w bazie',
			'typ' => 'varchar',
			'wartosc' => 'all',
		),
		'index.dodajEvent_domyslny_typ_eventy' => array(
			'opis' => 'Domyślna zakładka przy dodawaniu eventu',
			'typ' => 'varchar',
			'wartosc' => 'Projekty',
		),
		'pobierzPrzydzieloneZamowienia.kryteria_zamowienia_status_work' => array(
			'opis' => 'Id typu zamówień dla apartamentu',
			'typ' => 'list',
			'wartosc' => array('new', 'in progress'),
		),
		
		
		'pobierzPrzydzieloneZamowienia.kryteria_zamowienia_status' => array(
			'opis' => 'Id typu zamówień dla apartamentu',
			'typ' => 'list',
			'wartosc' => array('open', 'active',),
		),
		'pobierzPrzydzieloneZamowienia.id_type_apartament' => array(
			'opis' => 'Id typu zamówień dla apartamentu',
			'typ' => 'list',
			'wartosc' => array(33, 32),
		),
		'pobierzPrzydzieloneZamowienia.kolor_typ_zadania' => array(
			'opis' => 'Tlo zamówienia wyświetlanego na liście do przydzielenia w zależności od jego typu',
			'typ' => 'array',
			'wartosc' => array(
				'1' => '#FFFAFA',
				'2' => '#FDF5E6',
				'23' => '#FAA732',
				'24' => '#C9C299',
				'31' => '#C9C299',
				'3' => '#f8fc9d',
				'4' => '#f8fc9d',
				'5' => '#f8fc9d',
				'6' => '#f8fc9d',
				'7' => '#f8fc9d',
				'8' => '#f8fc9d',
				'25' => '#f8fc9d',
				'34' => '#FFCC00',
				'32' => '#61B876',
				'33' => '#61B876',
				),
		),
		'pobierzPrzydzieloneZamowienia.domyslny_kolor_zamowienia' => array(
			'opis' => 'Jeśli w konfiguracji wyżej nie jest ustawiony kolor dla danego typu zamówienia, przypisany zostanie kolor z tej konfiguracji.',
			'typ' => 'varchar',
			'wartosc' => '#ccc',
		),
		'pobierzPrzydzieloneZamowienia.ville_tylko_zalogowane' => array(
			'opis' => 'Wyswietla tylko zalogowane ville',
			'typ' => 'bool',
			'wartosc' => true,
		),
		'pobierzPrzydzieloneZamowienia.kolor_grupa_zamowien' => array(
			'opis' => 'Kolor tła dla zamówień pogrupowanych',
			'typ' => 'varchar',
			'wartosc' => '#d5dfef',
		),
		'pobierzPrzydzieloneZamowienia.kolor_grupa_apartamenty' => array(
			'opis' => 'Kolor tła dla zamówień pogrupowanych',
			'typ' => 'varchar',
			'wartosc' => '#0099cc',
		),
		'pobierzPrzydzieloneZamowienia.kolor_grupa_projekty' => array(
			'opis' => 'Kolor tła dla projektów pogrupowanych',
			'typ' => 'varchar',
			'wartosc' => '#f4bf42',
		),
		'pobierzPrzydzieloneZamowienia.nazwa_dla_villa' => array(
			'opis' => 'Nazwa wyświetlana na kalendarzu dla grupy Villi',
			'typ' => 'varchar',
			'wartosc' => 'Villa and Others <strong> x {ILOSC}</strong>',
		),
		'pobierzPrzydzieloneZamowienia.ilosc_projektow_stworz_grupe' => array(
			'opis' => 'Ilość produktów od jakiej tworzona będzie grupa projektów',
			'typ' => 'int',
			'wartosc' => 2,
		),
		'pobierzPrzydzieloneZamowienia.nazwa_dla_apartamenty' => array(
			'opis' => 'Nazwa wyświetlana na kalendarzu dla grupy apartamenty',
			'typ' => 'varchar',
			'wartosc' => 'Apartaments <strong> x {ILOSC}</strong>',
		),
		'pobierzPrzydzieloneZamowienia.nazwa_dla_projekty' => array(
			'opis' => 'Nazwa wyświetlana na kalendarzu dla grupy projektów',
			'typ' => 'varchar',
			'wartosc' => 'Projects <strong> x {ILOSC}</strong>',
		),
		'index.kryterium_id_types_projekt' => array(
			'opis' => 'id typów projektów które mają wyświetlać się na liście do przydzielenia',
			'typ' => 'list',
			'wartosc' => array(
				3,
				4,
				5,
				6,
				7,
				8,
				25,
				34,
			),
		),
		'pobierzPrzydzieloneZamowienia.id_apartamentow' => array(
			'opis' => 'id typów dla apartamentow',
			'typ' => 'list',
			'wartosc' => array(
				32,33
			),
		),
		'nowywidok2.milisekundyOdswiezLogowanie' => array(
			'opis' => 'Czas określający częstotliwość odświerzania listy zalogowanych',
			'typ' => 'int',
			'wartosc' => '60000',
		),
		'nowywidok2.dataStart' => array(
			'opis' => 'Data start do testów',
			'typ' => 'varchar',
			'wartosc' => '06-11-2016',
		),
		'nowywidok2.dataStop' => array(
			'opis' => 'Data stop do testów',
			'typ' => 'varchar',
			'wartosc' => '29-12-2016',
		),
		'nowywidok2.test' => array(
			'opis' => 'włącza pobieranie dat do testów z konfiguracji nowywidok2.dataStart i nowywidok2.dataStop ',
			'typ' => 'bool',
			'wartosc' => false,
		),
		'nowywidok2.dataStartDni' => array(
			'opis' => 'Ilość dni jaka zostanie odjęta od dzisiajeszej daty - na tej podstawie zostanie wyliczona data start kalendarza',
			'typ' => 'int',
			'wartosc' => 'P1D',
		),
		'nowywidok2.dataStopDni' => array(
			'opis' => 'Ilość dni jaka zostanie dodana od dzisiajeszej daty - na tej podstawie zostanie wyliczona data stop kalendarza',
			'typ' => 'int',
			'wartosc' => 'P60D',
		),
		'parsujEvent.grupujProjekty' => array(
			'opis' => 'Włacz jeśli projekty mają być grupowane',
			'typ' => 'bool',
			'wartosc' => true,
		),
		'dodajEvent.uruchomEventAutomatycznie' => array(
			'opis' => 'Włacz jeśli eventy z datą bieżącą i wcześniejsze mają być uruchamiane automatycznie',
			'typ' => 'bool',
			'wartosc' => false,
		)
	);
}