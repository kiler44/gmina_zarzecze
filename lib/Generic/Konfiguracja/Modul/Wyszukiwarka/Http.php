<?php
namespace Generic\Konfiguracja\Modul\Wyszukiwarka;

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
 * @property string $k[listaWynikow.wierszy_na_stronie]
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

        'listaWynikow.wierszy_na_stronie' => array(
            'opis' => '',
            'typ' => 'int',
            'wartosc' => 10,
        ),
        'listaWynikow.ileZnakowOpisu' => array(
            'opis' => '',
            'typ' => 'int',
            'wartosc' => 120,
        ),

        'szablon.pager' => array(
            'opis' => '',
            'typ' => 'varchar',
            'wartosc' => 'pager.tpl',
        ),

        'listaWynikow.sortowanie' => array(
            'opis' => 'Sortowanie listyw formacie: kolumna.kierunek',
            'typ' => 'select',
            'wartosc' => 'priorytetowa.desc',
            'dozwolone' => array(
                '0' => 'priorytetowa.desc',
                1 => 'priorytetowa.asc',
                2 => 'tytul.desc',
                3 => 'tytul.asc',
                4 => 'autor.desc',
                5 => 'autor.asc',
                6 => 'data_dodania.desc',
                7 => 'data_dodania.asc',
            ),
        ),

        'listaWynikow.pager' => array(
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
	);
}
