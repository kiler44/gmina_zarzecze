<?php
namespace Generic\Konfiguracja\Modul\Team;

use Generic\Konfiguracja\Konfiguracja;

/**
 */

class Cron extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		
		'formatka_email_do_pracownika' => array(
			'opis' => '',
			'typ' => 'mail',
			'wartosc' => 18,
		),
		'formatka_email_do_teamu' => array(
			'opis' => '',
			'typ' => 'mail',
			'wartosc' => 19,
		),
	);
}
