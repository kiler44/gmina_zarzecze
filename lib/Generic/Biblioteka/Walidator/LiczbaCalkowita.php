<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest liczbą całkowitą
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class LiczbaCalkowita extends Walidator
{

	protected $trescBledow = array(
		'walidator_liczba_calkowita_nieprawidlowa_liczba' => 'To nie jest liczba całkowita.',
	);



	function sprawdz($wartosc)
	{
		if ($wartosc == '0' || preg_match('/^[-]*[1-9]{1}[0-9]*$/', $wartosc) > 0)
		{
			return true;
		}
		else
		{
			$this->ustawBlad('walidator_liczba_calkowita_nieprawidlowa_liczba');
			return false;
		}
	}
}
