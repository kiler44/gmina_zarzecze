<?php
namespace Generic\Konfiguracja\Modul\Galeria;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['galeria.format_daty']
 * @property array $k['galeria.pager']
 * @property string $k['galeria.prefix_miniaturki']
 * @property bool $k['galeria.uzyj_lightbox']
 * @property int $k['galeria.wierszy_na_stronie']
 * @property string $k['listaGalerii.format_daty']
 * @property array $k['listaGalerii.pager']
 * @property string $k['listaGalerii.prefix_miniaturki']
 * @property int $k['listaGalerii.wierszy_na_stronie']
 * @property string $k['szablon.pager']
 * @property string $k['zdjecie.prefix_miniaturka']
 * @property string $k['zdjecie.prefix_pelne_zdjecie']
 * @property string $k['zdjecie.prefix_zdjecie']
 * @property int $k['zdjecie.slider_ilosc_miniaturek']
 * @property string $k['zdjecie.tryb_wyswietlania']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'galeria.format_daty' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'd.m.Y @ H.i',
		),

	'galeria.pager' => array(
		'opis' => 'Kompletna konfiguracja pagera (stronicowanie)',
		'typ' => 'array',
		'wartosc' => array(
			'zakres' => 5,
			'wyborStrony' => 'linki',
			'wyborZakresu' => '',
			'skoczDo' => '',
			'pierwszaOstatnia' => 1,
			'poprzedniaNastepna' => 1,
			),
		),

	'galeria.prefix_miniaturki' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'miniaturka-podglad',
		),

	'galeria.uzyj_lightbox' => array(
		'opis' => 'Jeśli zaznaczysz to w liście miniaturek galerii po kliknięciu zdjęcie otworzy się w lightbox\'ie',
		'typ' => 'bool',
		'wartosc' => null,
		),

	'galeria.wierszy_na_stronie' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 24,
		),

	'listaGalerii.format_daty' => array(
		'opis' => 'Format wyswietlanej daty. Aby poprawnie określić sprawdź http://www.php.net/manual/pl/function.date.php',
		'typ' => 'varchar',
		'wartosc' => 'd.m.Y @ H.i',
		),

	'listaGalerii.pager' => array(
		'opis' => 'Kompletna konfiguracja pagera (stronicowanie)',
		'typ' => 'array',
		'wartosc' => array(
			'zakres' => 5,
			'wyborStrony' => 'linki',
			'wyborZakresu' => '',
			'skoczDo' => '',
			'pierwszaOstatnia' => 1,
			'poprzedniaNastepna' => 1,
			),
		),

	'listaGalerii.prefix_miniaturki' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'small',
		),

	'listaGalerii.wierszy_na_stronie' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 2,
		),

	'szablon.pager' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'pager.tpl',
		),

	'zdjecie.prefix_miniaturka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'small',
		),

	'zdjecie.prefix_pelne_zdjecie' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'zdjecie.prefix_zdjecie' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'medium',
		),

	'zdjecie.slider_ilosc_miniaturek' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 6,
		),

	'zdjecie.tryb_wyswietlania' => array(
		'opis' => '\'\' - nie robi nic, \'link\' - link do pełnego zdjęcia, \'lightbox\' - link z lightboxem',
		'typ' => 'select',
		'wartosc' => 'lightbox',
		'dozwolone' => array(
			'0' => '',
			1 => 'link',
			2 => 'lightbox',
			),
		),

	);
}
