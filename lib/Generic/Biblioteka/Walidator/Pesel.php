<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest poprawnym numerem PESEL
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Pesel extends Walidator
{

	protected $trescBledow = array(
		'walidator_pesel_nieprawidlowy_numer' => 'Numer PESEL nieprawidłowy',
	);



	function sprawdz($wartosc)
	{
		$wartosc = preg_replace('/[^\d]/', '', $wartosc);

		if ((strlen($wartosc) != 11) || $wartosc == '00000000000')
		{
			$this->ustawBlad('walidator_pesel_nieprawidlowy_numer');
			return false;
		}

		$suma = 0;

		$wagi = array(1, 3, 7, 9, 1, 3, 7, 9, 1, 3);

		for ($i=0; $i<10; $i++)
		{
			$suma = ($suma + $wartosc[$i] * $wagi[$i]) % 10;
		}

		if ($wartosc[10] != (10 - $suma) % 10)
		{
			$this->ustawBlad('walidator_pesel_nieprawidlowy_numer');
			return false;
		}

		return true;
	}
}
