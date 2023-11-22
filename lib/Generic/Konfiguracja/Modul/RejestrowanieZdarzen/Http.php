<?php
namespace Generic\Konfiguracja\Modul\RejestrowanieZdarzen;

use Generic\Konfiguracja\Konfiguracja;

/**
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		'logowanieObecnosci.okres' =>  array(
			'opis' => 'Odstęp w sekundach co jaki może być generowane zdarzenie obecności użytkownika.',
			'typ' => 'int',
			'wartosc' => 100,
			),
	);
}
