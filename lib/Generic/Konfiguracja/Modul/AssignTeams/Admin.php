<?php
namespace Generic\Konfiguracja\Modul\AssignTeams;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['emailPrzydzieloneZadanie.id_formatki_email']
 * @property int $k['emailZmianaZadania.id_formatki_email']
 * @property string $k['index.domyslne_sortowanie']
 * @property array $k['index.dozwolone_typy_dla_roli']
 * @property int $k['index.id_typu_reklamacji']
 * @property bool $k['index.kryterium_bez_rodzica']
 * @property bool $k['index.kryterium_bez_teamu']
 * @property array $k['index.kryterium_id_types']
 * @property array $k['index.kryterium_status_zamowien']
 * @property string $k['index.kryterium_typy']
 * @property string $k['index.pager_konfiguracja']
 * @property string $k['index.status_work']
 * @property string $k['index.wierszy_na_stronie']
 * @property string $k['index.zdjecia_pracownikow_przedrostek']
 * @property array $k['kryteria_status_teamu']
 * @property string $k['szablon.formularz_wyszukiwarka']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'emailPrzydzieloneZadanie.id_formatki_email' => array(
		'opis' => '',
		'typ' => 'mail',
		'wartosc' => 3,
		),

	'emailZmianaZadania.id_formatki_email' => array(
		'opis' => '',
		'typ' => 'mail',
		'wartosc' => 3,
		),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'object',
		),

	'index.dozwolone_typy_dla_roli' => array(
		'opis' => 'rola => id ról po przecinku (dla starego typu przydzielania)',
		'typ' => 'array',
		'wartosc' => array(
			'admin' => '1,2,3,4,5,6,7,8,9,10,11,12,13,17,23',
			'boss' => '1,2,3,4,5,6,7,8,9,10,11,12,13,17,23',
			),
		),
   'index.katalog_assign_team' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'assign_team',
	),
	'index.id_typu_reklamacji' => array(
		'opis' => 'dla starego typu przydzielania',
		'typ' => 'int',
		'wartosc' => 23,
		),

	'index.kryterium_bez_rodzica' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => null,
		),
	
	'index.kryterium_bez_teamu' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),
	'index.kolor_status_work' => array(
		'opis' => 'Tlo zamówienia wyświetlanego na liście do przydzielenia w zależności od jego statusu',
		'typ' => 'array',
		'wartosc' => array(
	
			),
	),
	'index.kolor_typ_zadania' => array(
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
	'index.typy_projektow' => array(
		'opis' => 'Id typów projektów poza grupą Get Project',
		'typ' => 'list',
		'wartosc' => array(
				34,
			),
	),
	'index.kolor_status_work' => array(
		'opis' => 'Tlo zamówienia wyświetlanego na liście przydzielonych w zależności od jego work statusu',
		'typ' => 'array',
		'wartosc' => array(
			'in progress' => '#DDF0AF',
			),
	),
	'index.kolor_obecnie_zalogowany' => array(
		'opis' => 'Tlo zamówienia do którego obecnie zalogowany jest team',
		'typ' => 'varchar',
		'wartosc' => "#dfff7d",
	),
	'index.kolor_apartamenty' => array(
		'opis' => 'Tlo zamówienia do apartamentow',
		'typ' => 'varchar',
		'wartosc' => "#0099CC",
	),
	'index.kolor_wysoki_priorytet' => array(
		'opis' => 'Tlo zamówienia wyświetlanego na liście do przydzielenia w zależności wysokiego priorytetu',
		'typ' => 'varchar',
		'wartosc' => "#FF0000",
	),
	'index.kryterium_id_types_apartamenty' => array(
		'opis' => 'id typów projektów które mają wyświetlać się na liście do przydzielenia',
		'typ' => 'list',
		'wartosc' => array(
			32,
			33,
			),
	),
	'index.kryterium_id_types_homenet_ville' => array(
		'opis' => 'id typów projektów które mają wyświetlać się na liście do przydzielenia',
		'typ' => 'list',
		'wartosc' => array(
			37
			),
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
		
	'index.kryterium_id_types' => array(
		'opis' => 'id typów zamówień które mają wyświetlać się na liście do przydzielenia',
		'typ' => 'list',
		'wartosc' => array(
			1,
			2,
			23,
			24,
			17,
			26,
			27,
			28,
			29,
			31,
			),
		),

	'index.kryterium_status_zamowien' => array(
		'opis' => 'Statusy work_status zadań które mają wyświetlać się na liście',
		'typ' => 'list',
		'wartosc' => array(
			'new', 'in progress',
			),
		),
	'index.kryterium_status' => array(
		'opis' => 'Statusy zadań które mają wyświetlać się na liście',
		'typ' => 'list',
		'wartosc' => array(
			 'open', 'active',
			),
		),
	'index.kryterium_typy' => array(
		'opis' => 'dla starego sposobu przydzielania',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'index.pager_konfiguracja' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'index.status_work' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'new', 'in progress'
			),
		),

	'index.wierszy_na_stronie' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'index.zdjecia_pracownikow_przedrostek' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'xs',
		),
	
	'kryteria_status_teamu' => array(
		'opis' => 'Statusy teamów do których mogą być przydzielane zadania',
		'typ' => 'list',
		'wartosc' => array(
			'active',
			'temporary_use',
			),
		),
	'index.id_villa_type' => array(
		'opis' => 'Id typu villa',
		'typ' => 'int',
		'wartosc' => 1,
	),
	'index.id_b2b_type' => array(
		'opis' => 'Id typu b2b',
		'typ' => 'int',
		'wartosc' => 2,
	),
	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),
	'assignApartament.data_format' => array(
		'opis' => 'format daty wyświetlanej na gridzie',
		'typ' => 'varchar',
		'wartosc' => 'd.m.Y',
		),
	'assignApartament.przykladyGodzin' => array(
		'opis' => 'Przyklady konfiguracji godzin',
		'typ' => 'array',
		'wartosc' => array(
			'standard' => '8:00-9:30,8:00-9:30,9:00-11:30,9:00-11:30,12:00-13:30,12:00-13:30,13:00-15:00,13:00-15:00,14:00-17:00,14:00-17:00',
			),
		),
	'pobierzZakresDat.kolory.kolor_do' => array(
		'opis' => 'zakres losowania kolorów dat',
		'typ' => 'int',
		'wartosc' => 15,
		),
	'pobierzZakresDat.wykluczDni' => array(
		'opis' => 'Przyklady konfiguracji godzin',
		'typ' => 'list',
		'wartosc' => array(
			'Sunday',
			'Saturday',
			),
		),
	'assignApartment.status_work_apartment' => array(
		'opis' => 'Kryteria status prac dla wyświetlanych apartamentów',
		'typ' => 'list',
		'wartosc' => array(
			'new',
			'not done',
			'done',
			'in progress'
			),
		),
	'assignApartment.blokujEdycjaPdfDostarczone' => array(
		'opis' => 'Blokuje edycja apartamentów gdy kartka z numerem i datami została dostarczona',
		'typ' => 'bool',
		'wartosc' => false,
	),
	'generujPdf.status_work_apartment' => array(
		'opis' => 'Kryteria status prac dla generowanego pdf dla apartamentów',
		'typ' => 'list',
		'wartosc' => array(
			'new',
			//'not done',
			),
		),
	'pobierzZakresDat.kolory.kolor_od' => array(
		'opis' => 'format daty wyświetlanej na gridzie',
		'typ' => 'int',
		'wartosc' => 10,
		),
	'stworzPdf.sciezka_do_mPDF' => array(
		'opis' => 'Ścieżka do biblioteki zewnetrznej mPDF',
		'typ' => 'varchar',
		'wartosc' => '../lib/Mpdf/mpdf.php',
		),
	'generujPdf.stopka_adres' => array(
		'opis' => 'Adres w stopce',
		'typ' => 'varchar',
		'wartosc' => 'Addresse:<br/>Micheletveien 37B <br/>1053 OSLO ',
		),
	'generujPdf.stopka_email' => array(
		'opis' => 'Email w stopce',
		'typ' => 'varchar',
		'wartosc' => 'Epost:<br/>post@bktas.no',
		),
	'generujPdf.stopka_telefon' => array(
		'opis' => 'Telefon w stopce',
		'typ' => 'varchar',
		'wartosc' => 'Telefon:<br/>45454502',
		),
	'assignApartment.domyslnyCzas' => array(
		'opis' => 'Domyślny czas',
		'typ' => 'varchar',
		'wartosc' => '8:00-9:30',
		),
	'assignApartment.domyslnyTeam' => array(
		'opis' => 'Domyślny team',
		'typ' => 'varchar',
		'wartosc' => '- select -',
		),
	'zapiszZmiany.ilosc_powtorzen_czasu' => array(
		'opis' => 'Możliwa ilość wystąpień czasu w tej samej dacie dla danego teamu',
		'typ' => 'int',
		'wartosc' => 2,
		),
	'dodajWiersz.pomin_propercje' => array(
		'opis' => 'Proporcje obiektu zamowienia pomijane przy kopiowaniu wiersza',
		'typ' => 'list',
		'wartosc' => array('id', 'orderName', 'statusWork', 'status', 'attributes', 'idTeam', 'numberPrivatCustomer', 'hoursInterval', 'dateStart', 'additionalData', 'idPdf'),
		),
	'fullAutoAssign.max_ilosc_apartamentow_pietro' => array(
		'opis' => 'Maxymalna ilosc apartamentów na piętrze',
		'typ' => 'int',
		'wartosc' => 24,
		),
	'emailPrzydzieloneApartamenty.id_formatki_email' => array(
		'opis' => 'Formatka email przydziel apartamenty',
		'typ' => 'mail',
		'wartosc' => 27,
		),
	'wyslijEmailApartamenty.katalog_danych_apartamentow' => array(
		'opis' => 'Katalog do którego zapisywane są dane o przydzieleniu apartamentów podczas wysyłania maila',
		'typ' => 'varchar',
		'wartosc' => 'apartamenty_przydzielone',
		),
	'assignApartment.bg_color_otwarte' => array(
		'opis' => 'Kolor tła dla zamówień otwartych',
		'typ' => 'varchar',
		'wartosc' => '#C4ECFF',
		),
	'generujIdPdf' => array(
		'opis' => 'Unikalne id przypisane do każdek kartki pdf roznoszonej po apartamentach',
		'typ' => 'varchar',
		'wartosc' => '{PROJEKT_ID}-{ID_KARTKI}',
		),
	'uzytkownik_przydziel_apartamenty_role' => array(
		'opis' => 'kody ról uzytkownikow roznoszących karteczki po apartamentach',
		'typ' => 'list',
		'wartosc' => array(
			'apartments',
		),
		),
	'projektyZapartamentami.sorter_domyslny' => array(
		'opis' => 'kody ról uzytkownikow roznoszących karteczki po apartamentach',
		'typ' => 'varchar',
		'wartosc' => 'date_start',
		),
	'pobierzWynikiSzukaj.iloscZnakow' => array(
		'opis' => 'Określa po ilu znakach ma rozpocząć sie wyszukiwanie',
		'typ' => 'int',
		'wartosc' => 3,
		),
	'pobierzWynikiSzukaj.status_label_klasa' => array(
		'opis' => 'Klasa dla statusu zamówienia',
		'typ' => 'array',
		'wartosc' => array(
			'new' => 'label-default',
			'not done' => 'label-danger',
			'done' => 'label-success',
			'in progress' => 'label-info',
			'cancelled' => 'label-Inverse',
			),
		),
	'zmianaEkipy.id_formatki_email' => array(
		'opis' => 'Określa po ilu znakach ma rozpocząć sie wyszukiwanie',
		'typ' => 'mail',
		'wartosc' => 9,
	),
	'przydzielenieDoEkipy.id_formatki_email' => array(
		'opis' => 'Określa po ilu znakach ma rozpocząć sie wyszukiwanie',
		'typ' => 'mail',
		'wartosc' => 8,
	),
	'dodajZamowienieWidok.id_typy_produktow' => array(
		'opis' => 'Id typow produktów wyświetlanych podczas dodawania podzamówień do apartamentów',
		'typ' => 'list',
		'wartosc' => array(27, 26 ),
	),
	'pobierzWynikiSzukaj.id_type_zezwol_usuwanie' => array(
		'opis' => 'Id typow zamówień które mozna usuwać z poziomu wyszukiwarki',
		'typ' => 'list',
		'wartosc' => array(),
	),
	'formularzDodajZamowienia.kopiuj_pola_apartament' => array(
		'opis' => 'Lista pól kopiowanych z apartamentu do nowego zamówienia',
		'typ' => 'list',
		'wartosc' => array('idProjektu' , 'address', 'city', 'apartment', 'idPdf', 'postcode',  ),
	),
	'id_type_apartament' => array(
		'opis' => 'Id typu zamówień dla apartamentu',
		'typ' => 'list',
		'wartosc' => array(33, 32),
	),

	'search.pager_konfiguracja' => array(
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
	
	'edycjaZamowienia.rola_koordynatorow' => array(
		'opis' => 'kod roli koordynatora',
		'typ' => 'varchar',
		'wartosc' => 'coordinator',
	),
		
	'search.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście użytkowników',
		'typ' => 'int',
		'wartosc' => 20,
		),
	'search.ograniczenia_wyszukiwania_rola_typ' => array(
		'opis' => 'ogranicza wyniki wyszukiwania dla roli',
		'typ' => 'array',
		'wartosc' => array(
				'get' => '32, 33',
			),
		),
	'dodajZamowienieWidok.id_typu_reklamacji_bkt' => array(
		'opis' => 'Id typu reklamacji',
		'typ' => 'int',
		'wartosc' => 30,
		),
	'dodajZamowienieWidok.id_typu_reklamacji_get' => array(
		'opis' => 'Id typu reklamacji',
		'typ' => 'int',
		'wartosc' => 23,
		),
	'zmianaKoordynatora.id_formatki_email' => array(
		'opis' => 'ID formatki wysłanej przy zmianie kordynatora',
		'typ' => 'mail',
		'wartosc' => 7,
		),
	'przydzielenieDoKoordynatora.id_formatki_email' => array(
		'opis' => 'ID formatki wysłanej do przydzielonego koordynatora po utworzeniu zamówienia',
		'typ' => 'mail',
		'wartosc' => 6,
		),
	'dni_tygodnia_no' => array(
		'opis' => 'dni tygodnia po norwesku',
		'typ' => 'array',
		'wartosc' => array(
				'Monday' => 'Mandag' , 'Tuesday' => 'Tirsdag', 'Wednesday' => 'Onsdag',
				'Thursday' => 'Torsdag', 'Friday' => 'Fredag', 'Saturday' => 'Lørdag',
				'Sunday' => 'Søndag',
			),
		),
		'addressList.tlo' => array(
			'opis' => 'kolor tla dla listy',
			'typ' => 'array',
			'wartosc' => array(
					'niePrzypisane' => '#fffafa' , 
					'przypisane' => '#82B8B5', 
					'wTrakcie' => '#A5F58C',
				),
		),
		'pobierzWynikiSzukaj.id_type_otworz_zamknij_projekt' => array(
			'opis' => 'Id typow zamówień dla których możliwe jest otwarcie i zamkniecie projektu',
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
		'importOrdersFromGet.domyslne_id_koordynatora' => array(
			'opis' => '',
			'typ' => 'int',
			'wartosc' => 42,
		),
		'index.powiazZGETApi' => array(
			'opis' => '',
			'typ' => 'bool',
			'wartosc' => true,
		),
		'zapiszPrzydzieleniaGetApi.usuwaj_przydzielenia' => array(
			'opis' => 'Usuwa przydzielenia jesli wystąpił błąd w systemie GET',
			'typ' => 'bool',
			'wartosc' => true,
		)
	);
	
	
}
