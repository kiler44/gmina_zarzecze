<?php
namespace Generic\Tlumaczenie\Pl\Modul\CropperZdjec;

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
	
		'wykonajPrzytnij.komunikat_blad' => 'Wystapił błąd. Prosimy spróbować ponownie.',
		'wykonajPrzytnij.komunikat_info' => 'Wybierz żądany rozmiar miniaturki, następnie zaznacz obszar obrazu. Kiedy zakończysz - kliknij Zatwierdź.',
		'wykonajPrzytnij.komunikat_nie_zaznaczono' => 'Nie zaznaczono odpowiedniego obszaru zdjęcia.',
		'wykonajPrzytnij.komunikat_zapisano' => 'Miniaturka została zapisana.',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie modułu',
			'wykonajFormularz' => 'Formularz przycinania miniaturki',
			'wykonajPrzytnij' => 'Przycinanie miniaturki',
		),

		'_zdarzenia_etykiety_' => array(
		),


		'wykonajFormularz.etykietyFormularza' => array(
			'tytul' => 'Poprawa miniaturki zdjęcia',
			'zastosuj_do_podobnych' => 'Zastosuj do podobnych',
			'zatwierdz' => 'Zatwierdź',
			'podglad' => 'Podgląd miniaturki:',
			'zbytMaleZaznaczenie' => '<br />Wybrany obszar jest mniejszy niż rozmiar miniatury.',
		),
		'wykonajFormularz.nazwyMiniatur' => array(
			'l' => 'Duża miniatura',
			'slider' => 'Obrazek w slajderze',
			'm' => 'Średnia miniatura',
			'xs' => 'Najmniejsza Miniatura',
			'sm' => 'Zwykła miniatura',
			'list' => 'Obrazek na liście',
			's' => 'Mały obrazek',
			'dodatkowe' => 'Dodatkowa miniatura',
			'miniaturka-podglad' => 'Miniatura podglądu',
		),
	);
}
