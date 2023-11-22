<?php
namespace Generic\Biblioteka\Tlumaczenia;


/**
 * Interfejs dla klas obslugujacych tlumaczenia.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

interface Interfejs
{

	/**
	 * Zwraca tablice z tlumaczeniami.
	 *
	 * @return array
	 */
	public function pobierzTlumaczenia();



	/**
	 * Ustawia nowe tlumaczenia.
	 *
	 * @param array $tlumaczenia Tablica z nowymi tlumaczeniami.
	 *
	 * @return boolean
	 */
	public function ustawTlumaczenia($tlumaczenia = array());

}

