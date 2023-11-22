<?php
namespace Generic\Konfiguracja\Modul\BlokObecnoscUzytkownika;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['logowanieObecnosci.okres']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		'logowanieObecnosci.okres' =>  array(
			'opis' => 'Odstęp w sekundach co jaki b edzie generowany request logujący obecność pracownika.',
			'typ' => 'int',
			'wartosc' => 120,
			),
	);
}
