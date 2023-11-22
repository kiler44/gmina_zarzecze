<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest poprawnym numerem dowodu osobistego
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class NumerDowodu extends Walidator
{

	protected $trescBledow = array(
		'walidator_numer_dowodu_nieprawidlowy_numer' => 'Numer i seria dowodu osobistego nieprawidłowa',
	);



	function sprawdz($wartosc)
	{
		$wartosc = preg_replace('/[^0-9a-zA-Z]/', '', $wartosc);

		if (strlen($wartosc)!= 9)
		{
			$this->ustawBlad('walidator_numer_dowodu_nieprawidlowy_numer');
			return false;
		}

		$slownik = array(
			'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15, 'G' => 16,
			'H' => 17, 'I' => 18, 'J' => 19, 'K' => 20, 'L' => 21, 'M' => 22, 'N' => 23,
			'O' => 24, 'P' => 25, 'Q' => 26, 'R' => 27, 'S' => 28, 'T' => 29, 'U' => 30,
			'V' => 31, 'W' => 32, 'X' => 33, 'Y' => 34, 'Z' => 35
		);

		$nr_kontrolny = 'brak';
		$wartosc = str_split(strtoupper($wartosc));
		foreach($wartosc as $klucz => $znak)
		{
			$numery[$klucz] = (array_key_exists($znak, $slownik)) ? $slownik[$znak] : intval($znak);

			if ($nr_kontrolny == 'brak' && !array_key_exists($znak, $slownik))
			$nr_kontrolny = $klucz;
		}

		$wagi = array(7,3,1,0,7,3,1,7,3);
		$wynik = 0;

		for ($i = 0; $i < 9; $i++)
		{
			$wynik += $numery[$i] * $wagi[$i];
		}

		if ($wynik % 10 == $numery[$nr_kontrolny])
		{
			return true;
		}
		else
		{
			$this->ustawBlad('walidator_numer_dowodu_nieprawidlowy_numer');
			return false;
		}
	}
}
