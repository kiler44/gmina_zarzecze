<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność kwoty
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Kwota extends Walidator
{

	protected $trescBledow = array(
		'walidator_kwota_nieprawidlowa_kwota' => 'Nieprawidłowy zapis kwoty',
	);



	function sprawdz($wartosc)
	{
		if (!preg_match('/^-?\d+(\.\d{2})?$/', $wartosc)) // Np. 22.99
		{
			$this->ustawBlad('walidator_kwota_nieprawidlowa_kwota');
			return false;
		}
		else
		{
			return true;
		}
	}
}
