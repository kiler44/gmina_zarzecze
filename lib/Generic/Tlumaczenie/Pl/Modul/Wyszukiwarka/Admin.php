<?php
namespace Generic\Tlumaczenie\Pl\Modul\Wyszukiwarka;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'index.tytul_modulu' => '[ETYKIETA:index.tytul_modulu]',	//TODO
		'index.tytul_strony' => '[ETYKIETA:index.tytul_strony]',	//TODO

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}