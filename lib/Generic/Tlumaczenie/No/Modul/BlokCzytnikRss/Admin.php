<?php
namespace Generic\Tlumaczenie\No\Modul\BlokCzytnikRss;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['czysc.blad_nie_mozna_wyczyscic_cache']
 * @property string $t['czysc.info_wyczyszczono_cache']
 * @property string $t['index.etykieta_czysc']
 * @property string $t['index.etykieta_czysc_pytanie']
 * @property string $t['index.tytul_strony']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajCzysc']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'czysc.blad_nie_mozna_wyczyscic_cache' => 'Nie można wyczyścić cache Rss',
		'czysc.info_wyczyszczono_cache' => 'Wyczyszczono cache Rss dla tego bloku',

		'index.etykieta_czysc' => 'Czyść cache Rss',
		'index.etykieta_czysc_pytanie' => 'Czy na pewno usunąć cały cache Rss dla tego bloku?',
		'index.tytul_strony' => 'Blok czytnika rss',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Edycja ustawień bloku',
			'wykonajCzysc' => 'Czyszczenie Rss',
		),
	);
}
