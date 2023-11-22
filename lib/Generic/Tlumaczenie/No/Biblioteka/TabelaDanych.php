<?php
namespace Generic\Tlumaczenie\No\Biblioteka;

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
		'etykieta_dodaj' => 'Legg',
		'etykieta_edytuj' => 'Rediger',
		'etykieta_podglad' => 'Forhåndsvisning',
		'etykieta_publikuj' => 'Publish',
		'etykieta_usun' => 'Slett',
		'etykieta_potwierdz_usun' => 'Ønsker du å fjerne valgte rad?',

		'etykieta_zaznacz_wszystkie' => 'Velg alle',
		'etykieta_odznacz_wszystkie' => 'Opphev alle',
		'blad_zaznaczenie_puste' => 'Ingen rader valgt!',
		'etykieta_odwroc_zaznaczenie' => 'Omvendt valg',
		'etykieta_eksportuj_zaznaczone' => 'Eksporter valgt',
		'etykieta_usun_zaznaczone' => 'Slett valgt',
		'etykieta_potwierdz_usun_zaznaczone' => 'Er du sikker på at du vil fjerne alle de valgte radene?',

		'etykieta_brak_wierszy' => 'Ingen data å vise',
		'etykieta_sortuj_po' => 'Sorter etter: ',
	);
}