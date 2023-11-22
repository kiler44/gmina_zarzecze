<?php
namespace Generic\Tlumaczenie\No\Modul\BlokAktualnosci;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.blad_brak_kategorii']
 * @property string $t['index.etykieta_data_dodania']
 * @property string $t['index.etykieta_link_wiecej']
 * @property string $t['index.etykieta_link_wiecej_aktualnosci']
 * @property string $t['index.info_nie_znaleziono_aktualnosci']
 * @property string $t['index.info_nie_znaleziono_modulu']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
			'index.blad_brak_kategorii' => 'Kategoria aktualności dla tego bloku nie istnieje',
		'index.etykieta_data_dodania' => 'Data dodania:',
		'index.etykieta_link_wiecej' => 'Więcej',
		'index.etykieta_link_wiecej_aktualnosci' => 'Więcej aktualności',
		'index.info_nie_znaleziono_aktualnosci' => 'Nie dysponujemy żadnymi informacjami w tym momencie',
		'index.info_nie_znaleziono_modulu' => 'Nie znaleziono strony odpowiedzialnej za wyświetlanie aktualności',
		);
}
