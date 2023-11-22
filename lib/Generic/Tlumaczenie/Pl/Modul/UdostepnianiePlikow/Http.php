<?php
namespace Generic\Tlumaczenie\Pl\Modul\UdostepnianiePlikow;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.blad_brak_pliku']
 * @property string $t['index.etykieta_autor']
 * @property string $t['index.etykieta_brak_zdjecia']
 * @property string $t['index.etykieta_data']
 * @property string $t['index.etykieta_ilosc']
 * @property string $t['index.etykieta_ilosc_plikow']
 * @property string $t['index.etykieta_wiecej']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property array $t['index.pager']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
			'index.blad_brak_pliku' => 'Nie dodano jeszcze żadnych plików',
		'index.etykieta_autor' => 'Autor: ',
		'index.etykieta_brak_zdjecia' => 'Brak pliku',
		'index.etykieta_data' => 'Data dodania: ',
		'index.etykieta_ilosc' => 'Wszystkich: ',
		'index.etykieta_ilosc_plikow' => 'Wszystkich: ',
		'index.etykieta_wiecej' => 'więcej &raquo;',
		'index.tytul_modulu' => 'Udostępnianie plików',
		'index.tytul_strony' => 'Udostępnianie plików',
			'index.pager' => array(
		),
	);
}
