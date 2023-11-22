<?php
namespace Generic\Biblioteka\Konfiguracja;


/**
 * Interfejs dla klas obsługujących konfigurację.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

interface Interfejs
{

	/**
	 * Zwraca tablicę z konfiguracją dla modułu.
	 *
	 * @return array
	 */
	public function pobierzKonfiguracje();



	/**
	 * Ustawia nową konfigurację dla modułu.
	 *
	 * @param array $tlumaczenia Tablica z konfiguracja dla modulu.
	 *
	 * @return bool
	 */
	public function ustawKonfiguracje($konfiguracja);

}

