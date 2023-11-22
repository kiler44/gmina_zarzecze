<?php
namespace Generic\Tlumaczenie\Pl\Modul\CropperZdjec;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.info_brak_mozliwosci_zarzadzania_modulem']
 * @property string $t['index.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property array $t['_zdarzenia_etykiety_']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.info_brak_mozliwosci_zarzadzania_modulem' => 'Ten moduł nie obsługuje zarządzania treścią. Sprawdź konfigurację i tłumaczenia dla niego aby dokonać zmian.',
		'index.tytul_strony' => 'Cropper zdjęć',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Edycja ustawień modułu',
		),

		'_zdarzenia_etykiety_' => array(
		),
	);
}
