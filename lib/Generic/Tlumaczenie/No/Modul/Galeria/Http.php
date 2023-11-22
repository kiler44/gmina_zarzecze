<?php
namespace Generic\Tlumaczenie\No\Modul\Galeria;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['galeria.blad_nie_znaleziono_galerii']
 * @property string $t['galeria.brak_autora']
 * @property string $t['galeria.etykieta_autor']
 * @property string $t['galeria.etykieta_data_dodania']
 * @property string $t['galeria.etykieta_strona']
 * @property string $t['galeria.etykieta_wstecz']
 * @property string $t['galeria.info_brak_zdjec_w_galerii']
 * @property string $t['galeria.tytul_modulu']
 * @property string $t['galeria.tytul_strony']
 * @property string $t['listaGalerii.brak_autora']
 * @property string $t['listaGalerii.etykieta_autor']
 * @property string $t['listaGalerii.etykieta_brak_zdjecia_glownego']
 * @property string $t['listaGalerii.etykieta_data_dodania']
 * @property string $t['listaGalerii.etykieta_ilosc_kategorii']
 * @property string $t['listaGalerii.etykieta_ilosc_zdjec']
 * @property string $t['listaGalerii.etykieta_link_wiecej']
 * @property string $t['listaGalerii.info_brak_galerii']
 * @property string $t['listaGalerii.parametry_separator']
 * @property string $t['listaGalerii.tytul_modulu']
 * @property string $t['zdjecie.etykieta_pozostale_zdjecia']
 * @property string $t['zdjecie.etykieta_wstecz']
 * @property string $t['zdjecie.tytul_modulu']
 * @property string $t['zdjecie.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajListaGalerii']
 * @property string $t['_akcje_etykiety_']['wykonajGaleria']
 * @property string $t['_akcje_etykiety_']['wykonajZdjecie']
 * @property array $t['galeria.pager']
 * @property array $t['listaGalerii.pager']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'galeria.blad_nie_znaleziono_galerii' => 'Nie znaleziono galerii',
		'galeria.brak_autora' => 'Anonim',
		'galeria.etykieta_autor' => 'Dodał:',
		'galeria.etykieta_data_dodania' => 'Data dodania:',
		'galeria.etykieta_strona' => 'Strona: ',
		'galeria.etykieta_wstecz' => '&laquo; powrót do listy galerii',
		'galeria.info_brak_zdjec_w_galerii' => 'Brak zdjęć w galerii',
		'galeria.tytul_modulu' => '%s',
		'galeria.tytul_strony' => '%s',

		'listaGalerii.brak_autora' => 'Anonim',
		'listaGalerii.etykieta_autor' => 'Autor',
		'listaGalerii.etykieta_brak_zdjecia_glownego' => 'Zdjęcia wkrótce',
		'listaGalerii.etykieta_data_dodania' => 'Data dodania',
		'listaGalerii.etykieta_ilosc_kategorii' => 'Kategorii: ',
		'listaGalerii.etykieta_ilosc_zdjec' => 'Ilość zdjęć',
		'listaGalerii.etykieta_link_wiecej' => 'więcej &raquo;',
		'listaGalerii.info_brak_galerii' => 'Nie opublikowano żadnych galerii.',
		'listaGalerii.parametry_separator' => ':',
		'listaGalerii.tytul_modulu' => 'Lista galerii',

		'zdjecie.etykieta_pozostale_zdjecia' => 'Inne zdjęcia w tej galerii',
		'zdjecie.etykieta_wstecz' => '&laquo; powrót do listy miniaturek',
		'zdjecie.tytul_modulu' => '%s',
		'zdjecie.tytul_strony' => '%s',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie modułu',
			'wykonajListaGalerii' => 'Wyświetlanie listy galerii',
			'wykonajGaleria' => 'Wyświetlanie wybranej galerii',
			'wykonajZdjecie' => 'Wyświetlanie zdjęcia w pełnym widoku',
		),
		'galeria.pager' => array(
		),
		'listaGalerii.pager' => array(
		),
	);
}
