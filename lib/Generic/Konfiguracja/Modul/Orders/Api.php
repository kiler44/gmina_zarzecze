<?php
namespace Generic\Konfiguracja\Modul\Orders;

use Generic\Konfiguracja\Konfiguracja;

/**
 */

class Api extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		'pobierzProjektyPoKodziePocztowym.id_typow_projekty' => array(
			'wartosc' => array(4),
			'typ' => 'list',
			'opis' => 'IDS typów orderów dla Projektow',
		),
		'pobierzProjektyPoKodziePocztowym.id_typow_apartamenty' => array(
			'wartosc' => array(32, 33),
			'typ' => 'list',
			'opis' => 'IDS typów orderów dla zamówień apartamentów',
		),
		'dodajZamowienie.id_typow_nowe_zamowienie' => array(
			'wartosc' => array(
				'ftth' => 27, 
				'hfc' => 26
			),
			'typ' => 'array',
			'opis' => ' ',
		),
		'dodajZamowienie.id_koordynatora' =>  array(
			'wartosc' => 42,
			'typ' => 'int',
			'opis' => ' ',
		),
		'przydzielenieDoKoordynatora.id_formatki_email' => array(
			'opis' => 'ID formatki wysłanej do przydzielonego koordynatora po utworzeniu zamówienia',
			'typ' => 'mail',
			'wartosc' => 6,
			),
	);
}
