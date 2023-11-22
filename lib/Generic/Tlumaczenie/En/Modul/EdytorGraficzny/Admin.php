<?php
namespace Generic\Tlumaczenie\En\Modul\EdytorGraficzny;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.etykieta_link_korzen']
 * @property string $t['index.etykieta_link_wznow_sesje']
 * @property string $t['index.etykieta_naglowek_filtry']
 * @property string $t['index.etykieta_naglowek_rozpocznij_sesje']
 * @property string $t['index.etykieta_naglowek_wznow_sesje']
 * @property string $t['index.komunikat_brak_miniatur']
 * @property string $t['index.pytanie_nowa_sesja']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.wyjasnienie_brak_edytora']
 * @property string $t['index.wyjasnienie_filtr']
 * @property string $t['index.wyjasnienie_miniatury']
 * @property string $t['index.wyjasnienie_wznow']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajEdytor']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'index.etykieta_link_korzen' => 'All',
		'index.etykieta_link_wznow_sesje' => 'Resume last edited',
		'index.etykieta_naglowek_filtry' => 'Filter',
		'index.etykieta_naglowek_rozpocznij_sesje' => 'Start new session',
		'index.etykieta_naglowek_wznow_sesje' => 'Continue active session',
		'index.komunikat_brak_miniatur' => 'No thumbnails in selected directory',
		'index.pytanie_nowa_sesja' => 'Do you really want to start a new session ? You can loose lately made changes to not saved session.',
		'index.tytul_strony' => 'Graphics editor',
		'index.wyjasnienie_brak_edytora' => 'If editor doesn\'t appear for some time check if your browser is not blocking pop-up windows',
		'index.wyjasnienie_filtr' => 'Show all pictures in this catagory and every below',
		'index.wyjasnienie_miniatury' => 'Pick a image to edit',
		'etykieta_przekierowanie_klik' => 'Click',
		'index.wyjasnienie_wznow' => 'You can resume editing previously edited image, if no backup version of this file will be lost',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'List of available images',
			'wykonajEdytor' => 'Show editor',
		),
	);
}
