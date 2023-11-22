<?php
namespace Generic\Konfiguracja\Modul\Timelist;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['cron.id_formatki_email_brak_pliku']
 * @property string $k['cron.katalog_dni_wolnych']
 * @property string $k['wyklucz_dni_z_red_day']
 */

class Cron extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
	'wylogujTeamUzytkownika.idLidera' => array(
		'opis' => 'id liderow do wylogowania',
		'typ' => 'list',
		'wartosc' => array( 28 , ),
	),
	'cron.id_formatki_email_brak_pliku' => array(
		'opis' => '',
		'typ' => 'mail',
		'wartosc' => 5,
		),

	'cron.katalog_dni_wolnych' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'timelist',
		),
	
	'wyklucz_dni_z_red_day' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'Sunday', 'Saturday',
			),
		),
	'cron.wyloguj_pracownikow.idOrderType' => array(
		'opis' => 'id typów zamówień dla których ma nastąpić autowylogowanie',
		'typ' => 'list',
		'wartosc' => array(1, 2),
	),
	'cron.wyloguj_pracownikow.nie_wyloguj_dla_zadan_z_przed_godziny' => array(
		'opis' => 'lista godzin poniżej których nastąpi wylogowanie teamu z zadania (jeżeli team zalogował się powyżej podanej godziny nie zostanie wylogowany)',
		'typ' => 'array',
		'wartosc' => array(
			'1' => '23:00',
			'2' => '23:00',
			)
	),
	'cron.wyloguj_pracownikow.zakoncz_dzien' => array(
		'opis' => 'przy autowylogowaniu teamu zamyka dzien pracy',
		'typ' => 'bool',
		'wartosc' =>  true
	),

	'cron.wyloguj_pracownikow.zakoncz_dzien_resetuj_godziny' => array(
		'opis' => 'przy zamknięciu dnia resetuje godziny ostatniego zadania',
		'typ' => 'bool',
		'wartosc' =>  true
	),
	'cron.wyloguj_pracownikow.wyslij_sms_liderowi' => array(
		'opis' => 'wysyła sms liderowi z informacją o autowylogowaniu',
		'typ' => 'bool',
		'wartosc' =>  true
	),
	'cron.wyloguj_pracownikow.wyslij_email_zbiorczy' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' =>  true
	),
	'wyloguj_pracownikow.id_formatki_email_zbiorczy' => array(
		'opis' => '',
		'typ' => 'mail',
		'wartosc' =>  17,
	),
	'raportPracownicyNaVillach.id_formatki_email' => array(
		'opis' => '',
		'typ' => 'mail',
		'wartosc' =>  34,
	),
	'raportPracownicyNaVillach.id_typow_zamowien' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' =>  array(1, 2, 32, 33),
	),
	'raportPracownicyNaVillach_wyslij_sms.id_typow_zamowien' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' =>  array(1,),
	),
	'raportExcel.naglowek_kolor_czcionki' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'Black',
		),
	'raportExcel.naglowek_kolor_tla' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'Gray',
		),
	'raportExcel.wiersz_nieparzysty_kolor_tla' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'White',
		),
	'raportExcel.wiersz_parzysty_kolor_tla' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'White',
		),
	'raportExcel.nazwy_pol' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'workers_name' => 'Workers',
			),
		),
	'raportExcel.rozmiarPolaExcela' => array(
	'opis' => '',
	'typ' => 'array',
	'wartosc' => array(
		0 => '22',
	),
	),
	'raportExcel.rozmiarPolaExcelaDefault' => array(
			'opis' => '',
			'typ' => 'int',
			'wartosc' => 12,
		),
	);
}
