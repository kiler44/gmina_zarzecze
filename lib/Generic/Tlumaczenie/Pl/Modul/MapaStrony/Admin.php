<?php
namespace Generic\Tlumaczenie\Pl\Modul\MapaStrony;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.blad_nie_mozna_zapisac_konfiguracji_mapy']
 * @property string $t['index.etykieta_opis']
 * @property string $t['index.etykieta_zapisz']
 * @property string $t['index.info_zapisano_konfiguracje_mapy']
 * @property string $t['index.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'index.blad_nie_mozna_zapisac_konfiguracji_mapy' => 'Nie można zapisać konfiguracji mapy',
		'index.etykieta_opis' => 'Wybierz sekcje których podstrony mają pojawić się na mapie serwisu.',
		'index.etykieta_zapisz' => 'Zapisz',
		'index.info_zapisano_konfiguracje_mapy' => 'Zapisano konfigurację mapy',
		'index.tytul_strony' => 'Mapa Strony',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Karta tłumaczeń i konfiguracji modułu',
		),
	);
}
