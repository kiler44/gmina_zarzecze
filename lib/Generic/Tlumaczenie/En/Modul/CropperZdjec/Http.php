<?php
namespace Generic\Tlumaczenie\En\Modul\CropperZdjec;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['wykonajPrzytnij.komunikat_blad']
 * @property string $t['wykonajPrzytnij.komunikat_info']
 * @property string $t['wykonajPrzytnij.komunikat_nie_zaznaczono']
 * @property string $t['wykonajPrzytnij.komunikat_zapisano']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajFormularz']
 * @property string $t['_akcje_etykiety_']['wykonajPrzytnij']
 * @property array $t['_zdarzenia_etykiety_']
 * @property array $t['wykonajFormularz.etykietyFormularza']
 * @property string $t['wykonajFormularz.etykietyFormularza']['zastosuj_do_podobnych']
 * @property string $t['wykonajFormularz.etykietyFormularza']['zatwierdz']
 * @property string $t['wykonajFormularz.etykietyFormularza']['podglad']
 * @property string $t['wykonajFormularz.etykietyFormularza']['zbytMaleZaznaczenie']
 * @property array $t['wykonajFormularz.nazwyMiniatur']
 * @property string $t['wykonajFormularz.nazwyMiniatur']['l']
 * @property string $t['wykonajFormularz.nazwyMiniatur']['slider']
 * @property string $t['wykonajFormularz.nazwyMiniatur']['m']
 * @property string $t['wykonajFormularz.nazwyMiniatur']['xs']
 * @property string $t['wykonajFormularz.nazwyMiniatur']['sm']
 * @property string $t['wykonajFormularz.nazwyMiniatur']['list']
 * @property string $t['wykonajFormularz.nazwyMiniatur']['s']
 * @property string $t['wykonajFormularz.nazwyMiniatur']['dodatkowe']
 * @property string $t['wykonajFormularz.nazwyMiniatur']['miniaturka-podglad']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'wykonajPrzytnij.komunikat_blad' => 'Error occured. Please try again later',
		'wykonajPrzytnij.komunikat_info' => 'Select desired size, then select photo area and click "Apply"',
		'wykonajPrzytnij.komunikat_nie_zaznaczono' => 'Incorrect photo area selected',
		'wykonajPrzytnij.komunikat_zapisano' => 'Thumbnail saved',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Index',
			'wykonajFormularz' => 'Form',
			'wykonajPrzytnij' => 'Cropping',
		),

		'_zdarzenia_etykiety_' => array(
		),
		
		'wykonajFormularz.etykietyFormularza' => array(
			'tytul' => 'Image Cropper',
			'zastosuj_do_podobnych' => 'Apply for similar',
			'zatwierdz' => 'Apply',
			'podglad' => 'Thumbnail preview:',
			'zbytMaleZaznaczenie' => '<br />selected area is smaller than thumbnail',
		),
		'wykonajFormularz.nazwyMiniatur' => array(
			'l' => 'Big',
			'slider' => 'Slider',
			'm' => 'Medium',
			'xs' => 'Smallest',
			'sm' => 'normal thumbnail',
			'list' => 'List thumbnail',
			's' => 'Small',
			'dodatkowe' => 'Additional thumb',
			'miniaturka-podglad' => 'Preview',
		),
	);
}
