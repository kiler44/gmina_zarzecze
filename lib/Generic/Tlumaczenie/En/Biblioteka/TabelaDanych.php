<?php
namespace Generic\Tlumaczenie\En\Biblioteka;

use Generic\Tlumaczenie\Tlumaczenie;


/**
 * @property string $t['etykieta_dodaj']
 * @property string $t['etykieta_edytuj']
 * @property string $t['etykieta_podglad']
 * @property string $t['etykieta_publikuj']
 * @property string $t['etykieta_usun']
 * @property string $t['etykieta_potwierdz_usun']
 * @property string $t['etykieta_zaznacz_wszystkie']
 * @property string $t['etykieta_odznacz_wszystkie']
 * @property string $t['blad_zaznaczenie_puste']
 * @property string $t['etykieta_odwroc_zaznaczenie']
 * @property string $t['etykieta_eksportuj_zaznaczone']
 * @property string $t['etykieta_usun_zaznaczone']
 * @property string $t['etykieta_potwierdz_usun_zaznaczone']
 * @property string $t['etykieta_brak_wierszy']
 * @property string $t['etykieta_sortuj_po']
 *
 */
class TabelaDanych extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'etykieta_dodaj' => 'Add',
		'etykieta_edytuj' => 'Edit',
		'etykieta_podglad' => 'Preview',
		'etykieta_publikuj' => 'Publish',
		'etykieta_usun' => 'Delete',
		'etykieta_potwierdz_usun' => 'Do you want to remove selected row?',

		'etykieta_zaznacz_wszystkie' => 'Select all',
		'etykieta_odznacz_wszystkie' => 'Unselect all',
		'blad_zaznaczenie_puste' => 'No rows selected!',
		'etykieta_odwroc_zaznaczenie' => 'Inverse selection',
		'etykieta_eksportuj_zaznaczone' => 'Export selected',
		'etykieta_usun_zaznaczone' => 'Delete selected',
		'etykieta_potwierdz_usun_zaznaczone' => 'Are you sure you want to remove all the selected rows?',

		'etykieta_brak_wierszy' => 'No data to display',
		'etykieta_sortuj_po' => 'Sort by: ',
	);
}