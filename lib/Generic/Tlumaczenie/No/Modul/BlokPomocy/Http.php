<?php
namespace Generic\Tlumaczenie\Pl\Modul\BlokPomocy;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.blad_brak_katergorii_glownej']
 * @property string $t['index.etykieta_rozwin']
 * @property string $t['index.etykieta_zwin']
 * @property string $t['index.tytul_modulu']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
			'index.blad_brak_katergorii_glownej' => 'Brak kategorii głównej',
		'index.etykieta_rozwin' => 'Rozwiń',
		'index.etykieta_zwin' => 'Zwiń',
		'index.tytul_modulu' => 'Tematy pomoc',
		);
}
