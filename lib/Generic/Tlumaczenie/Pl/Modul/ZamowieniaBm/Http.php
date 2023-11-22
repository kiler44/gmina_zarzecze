<?php
namespace Generic\Tlumaczenie\Pl\Modul\ZamowieniaBm;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie Generic\Modul\ZamowieniaBm\Admin
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 */
class Http extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = [

		'index.tytul_modulu' => '[ETYKIETA:index.tytul_modulu]',
		'index.tytul_strony' => '[ETYKIETA:index.tytul_strony]',
        'dodaj.etykietaMenu' => '[ETYKIETA:index.tytul_modulu]',
        'index.etykietaMenu' => '[ETYKIETA:index.tytul_modulu]',

    ];

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}