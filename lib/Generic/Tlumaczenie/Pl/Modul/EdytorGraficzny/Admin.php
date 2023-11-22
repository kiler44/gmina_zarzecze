<?php
namespace Generic\Tlumaczenie\Pl\Modul\EdytorGraficzny;

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

		'index.etykieta_link_korzen' => 'Wszystkie',
		'index.etykieta_link_wznow_sesje' => 'Wznów edycję obrazka',
		'index.etykieta_naglowek_filtry' => 'Filtr',
		'index.etykieta_naglowek_rozpocznij_sesje' => 'Rozpocznij nową sesję',
		'index.etykieta_naglowek_wznow_sesje' => 'Kontynuuj aktywną sesję',
		'index.komunikat_brak_miniatur' => 'W wybranym katalogu nie ma miniatur',
		'index.pytanie_nowa_sesja' => 'Czy na pewno rozpocząć nową sesje ? Możesz utracić historię bieżącej sesji.',
		'index.tytul_strony' => 'Edytor grafiki',
		'index.wyjasnienie_brak_edytora' => 'W wypadku gdyby edytor graficzny się nie pojawiał, sprawdź czy Twoja przeglądarka nie blokuje okien pop-up.',
		'index.wyjasnienie_filtr' => 'Wyświetla wszystkie obrazy znajdujące się w danym katalogu i katalogach poniżej',
		'index.wyjasnienie_miniatury' => 'Lista miniatur które możesz edytować. Wybierz zdjęcie by rozpocząć pracę.',
		'etykieta_przekierowanie_klik' => 'Klik / Click',
		'index.wyjasnienie_wznow' => 'Możesz wznowić pracę nad ostatnio edytowanym obrazem. Pamiętaj że wybranie innego obrazu wyczyści całą historię zmian',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista dostępnych zdjęć',
			'wykonajEdytor' => 'Wyświetlanie edytora',
		),
	);
}
