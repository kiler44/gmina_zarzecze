<?php
namespace Generic\Tlumaczenie\Pl\Biblioteka;

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
		'etykieta_dodaj' => 'Dodaj',
		'etykieta_edytuj' => 'Edytuj',
		'etykieta_podglad' => 'Podgląd',
		'etykieta_publikuj' => 'Publikuj',
		'etykieta_usun' => 'Usuń',
		'etykieta_potwierdz_usun' => 'Czy chcesz usunąc zaznaczony wiersz?',

		'etykieta_zaznacz_wszystkie' => 'Wybierz wszystkie',
		'etykieta_odznacz_wszystkie' => 'Odznacz wszystkie',
		'blad_zaznaczenie_puste' => 'Nie wybrano żadnych wierszy!',
		'etykieta_odwroc_zaznaczenie' => 'Odwróć zaznaczenie',
		'etykieta_eksportuj_zaznaczone' => 'Eksportuj zaznaczone',
		'etykieta_usun_zaznaczone' => 'Usuń zaznaczone',
		'etykieta_potwierdz_usun_zaznaczone' => 'czy jestes pewien że chcesz usunąć wszystkie zaznaczone wiersze?',

		'etykieta_brak_wierszy' => 'Brak danych',
		'etykieta_sortuj_po' => 'Sortuj po: ',
	);
}