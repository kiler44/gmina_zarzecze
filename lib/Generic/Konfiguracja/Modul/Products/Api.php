<?php
namespace Generic\Konfiguracja\Modul\Products;

use Generic\Konfiguracja\Konfiguracja;

class Api extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		'pobierzProdukty.technologia_lista' => array(
			'opis' => 'Lista technologii i odpowiadajacym ich typom produktu',
			'typ' => 'lista',
			'wartosc' => array(
				'ftth' => 27,
				'hfc' => 26,
				),
		),
	);
}
