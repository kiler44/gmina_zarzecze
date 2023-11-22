<?php
namespace Generic\Tlumaczenie\Pl\Modul\PlikiPubliczne;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.komunikat_domyslny']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.utworzono_katalog']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajNowy']
 * @property string $t['_akcje_etykiety_']['wykonajUpload']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajZmien']
 * @property string $t['_akcje_etykiety_']['wykonajPrzenies']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.komunikat_domyslny' => 'Wybierz plik by go pobrać',
		'index.tytul_strony' => 'Pliki Publiczne',
		'index.utworzono_katalog' => 'Katalog został pomyślnie utworzony',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Główny ekran menadżera plików',
			'wykonajNowy' => 'Tworzenie katalogów',
			'wykonajUpload' => 'Upload plików',
			'wykonajUsun' => 'Usuwanie plików i folderów',
			'wykonajZmien' => 'Zmiana nazwy plików i folderów',
			'wykonajPrzenies' => 'Przenoszenie plików i folderów',
		),
	);
}
