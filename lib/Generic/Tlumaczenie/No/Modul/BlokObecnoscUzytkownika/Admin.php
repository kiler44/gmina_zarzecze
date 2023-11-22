<?php
namespace Generic\Tlumaczenie\No\Modul\BlokObecnoscUzytkownika;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.info_brak_mozliwosci_zarzadzania_modulem']
 * @property string $t['index.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'index.info_brak_mozliwosci_zarzadzania_modulem' => 'Ten blok nie obsługuje zarządzania treścią. Sprawdź konfigurację i tłumaczenia dla niego aby dokonać zmian.',
		'index.tytul_strony' => 'Blok obecność uzytkownika',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Edycja ustawień bloku',
		),
	);

	protected $typyPolTlumaczen = array(
	);
}
