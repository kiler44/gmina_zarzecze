<?php
namespace Generic\Tlumaczenie\No\Modul\PlikiPubliczne;

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
	
		'index.komunikat_domyslny' => 'Pick a file you want to download',
		'index.tytul_strony' => 'Public (shared) files',
		'index.utworzono_katalog' => 'Directory created',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Files manager',
			'wykonajNowy' => 'Create directory',
			'wykonajUpload' => 'Upload files',
			'wykonajUsun' => 'Delete files or directories',
			'wykonajZmien' => 'Change file or directory names',
			'wykonajPrzenies' => 'Move files or directories',
		),
	);
}
