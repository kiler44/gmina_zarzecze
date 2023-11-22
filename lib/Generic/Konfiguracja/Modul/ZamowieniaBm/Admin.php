<?php

namespace Generic\Konfiguracja\Modul\ZamowieniaBm;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['formularz.wymagane_pola']
 * @property string $k['index.domyslne_sortowanie']
 * @property string $k['index.pager_konfiguracja']
 * @property string $k['index.wierszy_na_stronie']
 * @property array $k['zalaczniki.dozwolone_pliki']
 */
class Admin extends Konfiguracja
{
    protected $konfiguracjaDomyslna = array(

        'formularz.wymagane_pola' => array(
            'opis' => 'Wymagane pola formularza',
            'typ' => 'list',
            'wartosc' => array(
                'cena',
                'idKlienta',
                'modelTekst',
            ),
        ),

        'index.domyslne_sortowanie' => array(//TODO
            'opis' => '',
            'typ' => 'varchar',
            'wartosc' => 'id',
        ),

        'index.pager_konfiguracja' => array(//TODO
            'opis' => '',
            'typ' => 'varchar',
            'wartosc' => array(
                'poprzedniaNastepna' => 1,
                'pierwszaOstatnia' => 1,
                'wyborStrony' => 'linki',
                'wyborZakresu' => 'select',
                'zakres' => 3,
            ),
        ),
        'email_nowe_zamowienie.id_formatki' => array(
            'opis' => '',
            'typ' => 'int',
            'wartosc' => 4,
        ),
        'email_zamowienie_przypisane.id_formatki' => array(
            'opis' => '',
            'typ' => 'int',
            'wartosc' => 5,
        ),
        'email_zamowienie_do_akceptacji.id_formatki' => array(
            'opis' => '',
            'typ' => 'int',
            'wartosc' => 6,
        ),
        'email_zamowienie_do_poprawy.id_formatki' => array(
            'opis' => '',
            'typ' => 'int',
            'wartosc' => 7,
        ),
        'index.wierszy_na_stronie' => array(//TODO
            'opis' => '',
            'typ' => 'varchar',
            'wartosc' => '10',
        ),
        'szablon.formularz_wyszukiwarka' => array(
            'opis' => '',
            'typ' => 'varchar',
            'wartosc' => 'formularz_grid.tpl',
        ),
        'zalaczniki.dozwolone_pliki' => array(
            'opis' => '',
            'typ' => 'list',
            'wartosc' => array(
                'jpg',
                'gif',
                'png',
                'pdf',
                'xlsx',
                'xls',
                'doc',
                'docx',
            ),
        ),

    );
}
