<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest liczbą zmiennoprzecinkową
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class LiczbaZmiennoprzecinkowa extends Walidator
{

	protected $trescBledow = array(
		'walidator_liczba_zmiennoprzecinkowa_nieprawidlowa_liczba' => 'To nie jest liczba zmiennoprzecinkowa',
	);



	function sprawdz($wartosc)
	{
		if ( ! preg_match("/^[0-9]+(.[0-9]+)?$/", $wartosc))
		{
			$this->ustawBlad('walidator_liczba_zmiennoprzecinkowa_nieprawidlowa_liczba');
			return false;
		}
		else
		{
			return true;
		}
	}
}
