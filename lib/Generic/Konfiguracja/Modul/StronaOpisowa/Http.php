<?php
namespace Generic\Konfiguracja\Modul\StronaOpisowa;

use Generic\Konfiguracja\Konfiguracja;

/**
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
        'dolaczonaGaleria.prefix_miniaturki' => array(
            'opis' => 'Prefix miniaturki list zdjęć dołączonej galerii',
            'typ' => 'varchar',
            'wartosc' => 'mid',
        ),
        'dolaczonaGaleria.uzyj_lightbox' => array(
            'opis' => 'Czy po kliknięciu miniaturki zdjęcia, pełne zdjęcie ma się wyświetlić w lightboxie',
            'typ' => 'bool',
            'wartosc' => true,
        ),
        's' => array(
            'opis' => 'Czy na danej stronie opisowej mają być wyświetlane załączniki?',
            'typ' => 'bool',
            'wartosc' => true,
        ),
	);
}
