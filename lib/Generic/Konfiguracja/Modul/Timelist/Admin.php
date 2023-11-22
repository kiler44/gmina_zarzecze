<?php
namespace Generic\Konfiguracja\Modul\Timelist;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['formularz.multiplier']
 * @property string $k['grid_zdjecia_przedrostek']
 * @property string $k['holiday.ikona']
 * @property string $k['ikona.holiday']
 * @property string $k['ikona.seek_day']
 * @property array $k['index.dni_wolne']
 * @property string $k['index.domyslne_sortowanie']
 * @property array $k['index.nie_zliczaj_godzin_dla_typu']
 * @property array $k['index.pager_konfiguracja']
 * @property int $k['index.wierszy_na_stronie']
 * @property bool $k['index.wlacz_kryteria_domyslne_miesiac']
 * @property array $k['konfiguracja.typ.holiday']
 * @property array $k['konfiguracja.typ.night_hours']
 * @property array $k['konfiguracja.typ.orders']
 * @property array $k['konfiguracja.typ.red_day']
 * @property array $k['konfiguracja.typ.seek_day']
 * @property string $k['liczDniWolne.pomin_dni_tygodnia']
 * @property array $k['nie_zliczaj_godzin_dla_typu']
 * @property string $k['orders.data_format']
 * @property string $k['orders.data_stop']
 * @property string $k['orders.domyslne_sortowanie']
 * @property array $k['orders.pager_konfiguracja']
 * @property string $k['orders.wierszy_na_stronie']
 * @property bool $k['orders.wlacz_kryteria_domyslne_miesiac']
 * @property string $k['preview.akcjaPodlgadu']
 * @property string $k['seekDay.ilosc_dni_chorobowych_jednorazowo_max']
 * @property string $k['seekDay.ilosc_dni_wolnych_jednorazowo_max']
 * @property string $k['szablon.formularz_wyszukiwarka']
 * @property string $k['tabela_format_daty']
 * @property array $k['timelistPomocnik.typy']
 * @property array $k['timelistPomocnik.typy_przedzial_godzin']
 * @property array $k['zliczaj_dla_typu']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'formularz.multiplier' => array(
		'opis' => 'Mnożnik czasu pracy',
		'typ' => 'array',
		'wartosc' => array(
			'0' => 0,
			'0.5' => 0.5,
			'1' => 1,
			'1.5' => 1.5,
			'2' => 2,
			'2.5' => 2.5,
			'3' => 3,
			'-0.5' => -0.5,
			'-1' => -1,
			'-1.5' => -1.5,
			'-2' => -2,
			'-2.5' => -2.5,
			'-3' => -3,
			),
		),

	'grid_zdjecia_przedrostek' => array(
		'opis' => 'Mnożnik czasu pracy',
		'typ' => 'varchar',
		'wartosc' => 'xs',
		),

	'holiday.ikona' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'ikona.holiday' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'icon-picture',
		),

	'ikona.seek_day' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'icon-ellipsis-horizontal',
		),

	'index.dni_wolne' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			0 => '\'holiday\'',
			1 => '\'seek_day\'',
			),
		),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'id',
		'dozwolone' => array(
			0 => 'id',
			1 => 'zdjecie',
			),
		),
   
	'index.nie_zliczaj_godzin_dla_typu' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			0 => '\'holiday\'',
			),
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

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście użytkowników',
		'typ' => 'int',
		'wartosc' => 5,
		),

	'index.wlacz_kryteria_domyslne_miesiac' => array(
		'opis' => 'Włącza wyświetlanie na gridzie danych z bieżącego miesiąca',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'konfiguracja.typ.holiday' => array(
		'opis' => 'Konfiguracja dla typu wolne (holiday)',
		'typ' => 'array',
		'wartosc' => array(
			'przelicznik' => 0,
			'domyslna_ilosc_godzin' => 24,
			'przedzial_godzin_od' => '00:00',
			'przedzial_godzin_do' => '00:00',
			'stawka' => 0,
			'typ_nazwa' => 'holiday',
			'zabron_logowania' => 1,
			'przelicznik_godziny_logowania' => 0,
			),
		),

	'konfiguracja.typ.night_hours' => array(
		'opis' => 'Konfiguracja dla typu godziny nocne (night_hours)',
		'typ' => 'array',
		'wartosc' => array(
			'przelicznik' => 2,
			'domyslna_ilosc_godzin' => '',
			'przedzial_godzin_od' => '22:00',
			'przedzial_godzin_do' => '07:00',
			'stawka' => '',
			'typ_nazwa' => 'night_hours',
			'wymagane_umiejetnosci' => null,
			'zabron_logowania' => 0,
			'przelicznik_godziny_logowania' => 1,
			),
		),

	'konfiguracja.typ.orders' => array(
		'opis' => 'Konfiguracja dla typu zamowienia (orders)',
		'typ' => 'array',
		'wartosc' => array(
			'przelicznik' => 1,
			'domyslna_ilosc_godzin' => '',
			'przedzial_godzin_od' => '8:00',
			'przedzial_godzin_do' => '22:00',
			'stawka' => '',
			'typ_nazwa' => 'orders',
			'zabron_logowania' => 0,
			'przelicznik_godziny_logowania' => 1,
			),
		),

	'konfiguracja.typ.red_day' => array(
		'opis' => 'Konfiguracja dla typu dni wolne (red_day)',
		'typ' => 'array',
		'wartosc' => array(
			'przelicznik' => 1,
			'domyslna_ilosc_godzin' => 7.5,
			'przedzial_godzin_od' => '00:00',
			'przedzial_godzin_do' => '00:00',
			'stawka' => '',
			'typ_nazwa' => 'red_day',
			'zabron_logowania' => 1,
			'przelicznik_godziny_logowania' => 0,
			),
		),

	'konfiguracja.typ.seek_day' => array(
		'opis' => 'Konfiguracja dla typu dni chorobowe (seek_day)',
		'typ' => 'array',
		'wartosc' => array(
			'przelicznik' => 1,
			'domyslna_ilosc_godzin' => 7.5,
			'przedzial_godzin_od' => '7:00',
			'przedzial_godzin_do' => '15:30',
			'stawka' => '',
			'typ_nazwa' => 'seek_day',
			'zabron_logowania' => 1,
			'przelicznik_godziny_logowania' => 0,
			),
		),

	'liczDniWolne.pomin_dni_tygodnia' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'Sunday', 'Saturday'
			),
		),

	'nie_zliczaj_godzin_dla_typu' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'holiday',
			),
		),
		
	'orders.data_format' => array(
		'opis' => 'Format daty wyświetlany na gridzie',
		'typ' => 'varchar',
		'wartosc' => 'Y-m-d H:i',
		),

	'orders.data_stop' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'Y-m-d H:i',
		),

	'orders.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'id',
		'dozwolone' => array(
			0 => 'id',
			),
		),

	'orders.pager_konfiguracja' => array(
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

	'orders.wierszy_na_stronie' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '5',
		),

	'orders.wlacz_kryteria_domyslne_miesiac' => array(
		'opis' => 'Włącza domyślne kryteria wyświetlania danych z bierzącego miesiąc dla listy zamówień',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'preview.akcjaPodlgadu' => array(
		'opis' => 'nazwa akcji podglądu dla zamówień',
		'typ' => 'varchar',
		'wartosc' => 'editOrder',
		),

	'seekDay.ilosc_dni_chorobowych_jednorazowo_max' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '3',
		),

	'seekDay.ilosc_dni_wolnych_jednorazowo_max' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '30',
		),

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),

	'tabela_format_daty' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'Y-m-d [H:i:s]',
		),

	'timelistPomocnik.typy' => array(
		'opis' => 'Typy timelisty po których ustawiamy mnożnik zależności od przedziału godzin',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'night_hours',
			1 => 'orders',
			2 => 'holiday',
			3 => 'red_day',
			4 => 'seek_day',
			),
		),

	'timelistPomocnik.typy_przedzial_godzin' => array(
		'opis' => 'Typy timelisty po których ustawiamy mnożnik zależności od przedziału godzin',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'night_hours',
			1 => 'orders',
			),
		),

	'zliczaj_dla_typu' => array(
		'opis' => 'Typy zamówień dla jakich mają być zliczane godziny i kwota zarobku',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'seek_day',
			1 => 'orders',
			2 => 'night_hours',
			3 => 'red_day',
			),
		),

	);
}
