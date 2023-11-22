<?php
namespace Generic\Tlumaczenie\En\Modul\Aktualnosci;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['aktualnosc.autor_zdjec_nieznany']
 * @property string $t['aktualnosc.blad_brak_aktualnosci']
 * @property string $t['aktualnosc.etykieta_autor']
 * @property string $t['aktualnosc.etykieta_autor_zdjec']
 * @property string $t['aktualnosc.etykieta_data']
 * @property string $t['aktualnosc.etykieta_tytul_galerii']
 * @property string $t['aktualnosc.etykieta_wstecz']
 * @property string $t['aktualnosc.tytul_modulu']
 * @property string $t['aktualnosc.tytul_strony']
 * @property string $t['listaAktualnosci.blad_brak_aktualnosci']
 * @property string $t['listaAktualnosci.etykieta_autor']
 * @property string $t['listaAktualnosci.etykieta_brak_zdjecia']
 * @property string $t['listaAktualnosci.etykieta_data']
 * @property string $t['listaAktualnosci.etykieta_ilosc']
 * @property string $t['listaAktualnosci.etykieta_ilosc_aktualnosci']
 * @property string $t['listaAktualnosci.etykieta_wiecej']
 * @property string $t['listaAktualnosci.tytul_modulu']
 * @property string $t['listaAktualnosci.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajListaAktualnosci']
 * @property string $t['_akcje_etykiety_']['wykonajAktualnosc']
 * @property array $t['listaAktualnosci.pager']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'aktualnosc.autor_zdjec_nieznany' => 'anonim',
		'aktualnosc.blad_brak_aktualnosci' => 'News doesn\'t exist',
		'aktualnosc.etykieta_autor' => 'Author: ',
		'aktualnosc.etykieta_autor_zdjec' => 'Photograpfy author: ',
		'aktualnosc.etykieta_data' => 'Creation date: ',
		'aktualnosc.etykieta_tytul_galerii' => 'Gallery: ',
		'aktualnosc.etykieta_wstecz' => '&laquo; back',
		'aktualnosc.tytul_modulu' => '%s',
		'aktualnosc.tytul_strony' => '%s',

		'listaAktualnosci.blad_brak_aktualnosci' => 'No news at this moment',
		'listaAktualnosci.etykieta_autor' => 'Author: ',
		'listaAktualnosci.etykieta_brak_zdjecia' => 'No proho',
		'listaAktualnosci.etykieta_data' => 'Creation date: ',
		'listaAktualnosci.etykieta_ilosc' => 'All: ',
		'listaAktualnosci.etykieta_ilosc_aktualnosci' => 'All: ',
		'listaAktualnosci.etykieta_wiecej' => 'read more &raquo;',
		'listaAktualnosci.tytul_modulu' => 'News',
		'listaAktualnosci.tytul_strony' => 'News',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Index',
			'wykonajListaAktualnosci' => 'News list',
			'wykonajAktualnosc' => 'News page',
		),
		'listaAktualnosci.pager' => array(
		),
	);
}
