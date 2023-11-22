<?php
namespace Generic\Konfiguracja\Modul\Notes;

use Generic\Konfiguracja\Konfiguracja;

/**
 */

class Cron extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		'status_zamowien' => array(
			'opis' => 'Statusy zamówień dla który wysyłane jest przypomnienie',
			'typ' => 'list',
			'wartosc' => array(
				'active', 'open'
			),
		),
		'work_status_zamowien' => array(
			'opis' => 'Statusy prac zamówień dla który wysyłane jest przypomnienie',
			'typ' => 'list',
			'wartosc' => array(
				'in progress'
			),
		),
		'typy_zamowien' => array(
			'opis' => 'Typy zamówień dla który wysyłane jest przypomnienie',
			'typ' => 'list',
			'wartosc' => array(
				4,5,6,7,25,8,3
			),
		),
		'uwzglednij_wpisy_timelisty' => array(
			'opis' => 'Dla przypomnien wysyłanych codziennie sprawdza czy w danym dniu była zalogowana jakas ekipa',
			'typ' => 'bool',
			'wartosc' => FALSE,
		),
	);
}
