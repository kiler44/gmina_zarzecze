<?php
namespace Generic\Konfiguracja\Modul\Orders;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['generujPdf.stopka_adres']
 * @property string $k['generujPdf.stopka_email']
 * @property string $k['generujPdf.stopka_telefon']
 * @property string $k['godzina_przypomnienia_od']
 * @property string $k['stworzPdf.sciezka_do_mPDF']
 */

class Cron extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
	'raportBrakLopendeTimer.id_lopende_timer' => array(
		'opis' => 'Id produktó typy lopende Timer',
		'typ' => 'list',
		'wartosc' => array('lopende_timer_montor', 'lopende_timer_peilet_reflektert_kabel' , 'lopende_timer_trekt_kabel_i_ror_til_kunde' , 'lopende_timer_gravd_droppkabel' , 'lopende_timer_gravd_skap' , 'lopende_timer_peilet_kabel' , 'befaring_lopende_timer'),
		),
	'raportBrakLopendeTimer.nazwa_pliku' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '{$DATA_OD}-{$DATA_DO}-raport',
		),
	'raportBrakLopendeTimer.id_formatki_email' => array(
			'opis' => 'ID formatki wysłanej do osoby otwierajacej zamkniety projekt',
			'typ' => 'mail',
			'wartosc' => 34,
		),
	'generujPdf.stopka_adres' => array(
		'opis' => 'Adres w stopce',
		'typ' => 'varchar',
		'wartosc' => 'Addresse:<br/>Micheletveien 37B<br/>1053 Oslo',
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

	'godzina_przypomnienia_od' => array(
		'opis' => 'Godzina po której bedą wysyłane przypomnienia o konieczności wylogowania.',
		'typ' => 'varchar',
		'wartosc' => '16:00',
		),
	'formatka_email_raport_b2b' => array(
		'opis' => 'Email z raportem b2b',
		'typ' => 'mail',
		'wartosc' => '30',
		),
	'stworzPdf.sciezka_do_mPDF' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '../lib/Mpdf/mpdf.php',
		),
	'wyslijInfoTeamyNieZalogowane.uwzgeldnij_hours_interval' => array(
		'opis' => 'Uwzględnia tylko zamówienia które powinny zaczac sie od godziny 8 rano',
		'typ' => 'bool',
		'wartosc' => true,
		),
	'wyslijInfoTeamyNieZalogowane.id_formatki_email' => array(
		'opis' => 'ID formatki wysłanej do przydzielonego koordynatora po utworzeniu zamówienia',
		'typ' => 'mail',
		'wartosc' => 31,
		),
	'formatka_email_powiadom_projekt_niezamkniety' => array(
			'opis' => 'ID formatki wysłanej do osoby otwierajacej zamkniety projekt',
			'typ' => 'mail',
			'wartosc' => 34,
		),
	);
}
