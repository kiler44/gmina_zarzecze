<?php
namespace Generic\Konfiguracja\Modul\BlokWyszukiwarki;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property bool $k['ostatnia_linkiem']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
        'id_kategorii_select_gdzie_szukaj' => [
            'opis' => 'Id kategorii gdzie szukac',
            'typ' => 'int',
            'wartosc' => 3,
        ],
        'wyszukiwarka_schowana' => [
            'opis' => 'Przycisk do chowania wyszukiwarki',
            'typ' => 'bool',
            'wartosc' => false,
        ]
	);
}
