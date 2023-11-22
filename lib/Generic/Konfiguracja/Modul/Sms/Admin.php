<?php
namespace Generic\Konfiguracja\Modul\Sms;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['historiaWiadomosci.format_daty']
 * @property string $k['historiaWiadomosci.pokazuj_wiadomosci_ile_wstecz']
 * @property string $k['historiaWiadomosci.prefix_zdjecia']
 * @property string $k['index.domyslne_sortowanie']
 * @property array $k['index.pager_konfiguracja']
 * @property int $k['index.wierszy_na_stronie']
 * @property array $k['sms_config']
 * @property array $k['sms_kategorie']
 * @property array $k['sms_typ_zamowienia_szablon']
 * @property string $k['szablon.formularz_wyszukiwarka']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'historiaWiadomosci.format_daty' => array(
		'opis' => 'Format daty',
		'typ' => 'varchar',
		'wartosc' => "d-m-Y",
		),

	'historiaWiadomosci.pokazuj_wiadomosci_ile_wstecz' => array(
		'opis' => 'Jaki okres w czasie wiadomości mają być pokazywane wstecz (+3 day, -1 month)',
		'typ' => 'varchar',
		'wartosc' => '-3 months midnight',
		),

	'historiaWiadomosci.prefix_zdjecia' => array(
		'opis' => 'Prefix miniaturki zdjecia',
		'typ' => 'varchar',
		'wartosc' => 'min',
		),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'date_sent',
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
		'wartosc' => 10,
		),

	'sms_config' => array(
		'opis' => 'Konfiguracja do SmsNorwegia',
		'typ' => 'array',
		'wartosc' => array(
			'sms_password' => 'r262XU53e2L63y6Paq5A9AMPk38Q78',
			'sms_serviceId' => 4805,
			'sms_from_domyslny' => 664774416,
			'sms_from_pattern' => '/^[0]{2}[0-9]{10}$/',
			'wlacz_test' => 0,
			'sms_test_do' => 26114123454805,
			'sms_test_from' => 664774416,
			),
		),

	'sms_kategorie' => array(
		'opis' => 'Kategorie sms',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'orders_get_done',
			1 => 'orders_get_anulowane',
			),
		),

	'sms_typ_zamowienia_szablon' => array(
		'opis' => 'Szablony sms dla wybranych kategorii',
		'typ' => 'array',
		'wartosc' => array(
			1 => 'T712 Order {$ID_ORDERS}',
			2 => 'T712 B2B Order {$ID_ORDERS}',
			24 => 'Graving  WO {$ID_ORDERS} er ferdig. Bildene er tilgendelige i BKT system.',
			36 => 'T712 Gravebefaring  WO {$ID_ORDERS} done.',
			),
		),

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),

	);
}
