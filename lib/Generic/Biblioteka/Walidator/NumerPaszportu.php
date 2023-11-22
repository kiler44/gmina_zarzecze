<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest poprawnym numerem paszportu
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class NumerPaszportu extends Walidator
{

	protected $trescBledow = array(
		'walidator_numer_paszportu_nieprawidlowy_numer' => 'Numer i seria paszportu nieprawidłowa',
	);



	function sprawdz($wartosc)
	{
		$wartosc = preg_replace('/[^0-9a-zA-Z]/', '', $wartosc);

		if (strlen($wartosc) != 10)
		{
			$this->ustawBlad('walidator_numer_paszportu_nieprawidlowy_numer');
			return false;
		}

		$slownik = array(
			'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15, 'G' => 16,
			'H' => 17, 'I' => 18, 'J' => 19, 'K' => 20, 'L' => 21, 'M' => 22, 'N' => 23,
			'O' => 24, 'P' => 25, 'Q' => 26, 'R' => 27, 'S' => 28, 'T' => 29, 'U' => 30,
			'V' => 31, 'W' => 32, 'X' => 33, 'Y' => 34, 'Z' => 35
		);

		$wartosc = str_split(strtoupper($wartosc));
		foreach($wartosc as $klucz => $znak)
		{
			$numery[$klucz] = (array_key_exists($znak, $slownik)) ? $slownik[$znak] : intval($znak);
		}

		$wagi = array(7,3,1,7,3,1,7,3,1);
		$wynik = 0;

		for ($i = 0; $i < 9; $i++)
		{
			$wynik += $numery[$i] * $wagi[$i];
		}

		if ($wynik % 10 == $numery[9])
		{
			return true;
		}
		else
		{
			$this->ustawBlad('walidator_numer_paszportu_nieprawidlowy_numer');
			return false;
		}

	}
}
