<?php
namespace Generic\Konfiguracja\Modul\MenuAplikacji;

use Generic\Konfiguracja\Konfiguracja;

/**
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		'index.rola_dla_wszystkich_uzytkownikow' => array(
			'typ' => 'varchar',
			'wartosc' => 'worker',
			'opis' => 'Rola dla której pobierane sa pozycje menu dla każdego uzytkownika',
		),
	);
}
