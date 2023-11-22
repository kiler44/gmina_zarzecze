<?php
namespace Generic\Tlumaczenie\Pl\Modul\Aktualnosci;

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

		'aktualnosc.autor_zdjec_nieznany' => 'nieznany',
		'aktualnosc.blad_brak_aktualnosci' => 'Nie można pobrać aktualności lub nie istnieje',
		'aktualnosc.etykieta_autor' => 'Autor: ',
		'aktualnosc.etykieta_autor_zdjec' => 'Autor zdjęć: ',
		'aktualnosc.etykieta_data' => 'Data dodania: ',
		'aktualnosc.etykieta_tytul_galerii' => 'Galeria: ',
		'aktualnosc.etykieta_wstecz' => '&laquo; wstecz',
		'aktualnosc.tytul_modulu' => '%s',
		'aktualnosc.tytul_strony' => '%s',

		'listaAktualnosci.blad_brak_aktualnosci' => 'Nie dodano jeszcze żadnych aktualności',
		'listaAktualnosci.etykieta_autor' => 'Autor: ',
		'listaAktualnosci.etykieta_brak_zdjecia' => 'Brak zdjęcia',
		'listaAktualnosci.etykieta_data' => 'Data dodania: ',
		'listaAktualnosci.etykieta_ilosc' => 'Wszystkich: ',
		'listaAktualnosci.etykieta_ilosc_aktualnosci' => 'Wszystkich: ',
		'listaAktualnosci.etykieta_wiecej' => 'więcej &raquo;',
		'listaAktualnosci.tytul_modulu' => 'Aktualności',
		'listaAktualnosci.tytul_strony' => 'Aktualności',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie modułu',
			'wykonajListaAktualnosci' => 'Wyświetlanie listy aktualności',
			'wykonajAktualnosc' => 'Wyświetlanie podglądu aktualności',
		),
		'listaAktualnosci.pager' => array(
		),
	);
}
