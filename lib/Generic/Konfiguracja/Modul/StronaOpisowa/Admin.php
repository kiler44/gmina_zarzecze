<?php
namespace Generic\Konfiguracja\Modul\StronaOpisowa;

use Generic\Konfiguracja\Konfiguracja;

/**
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
        'pliki.dozwoloneRozszerzenia' => array(
            'opis' => 'Dozwolone rozszerzenia w uploadnie plików',
            'typ' => 'list',
            'wartosc' => array(
                'pdf',
                'doc',
                'docx',
                'xls',
                'xslx',
                'jpg',
                'jpeg',
                'png',
            ),
        ),
	);
}
