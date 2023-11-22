<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest poprawnym numerem REGON
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class Regon extends Walidator
{

	protected $trescBledow = array(
		'walidator_regon_nieprawidlowy' => 'Numer REGON nie jest nieprawidłowy',
	);



	function sprawdz($wartosc)
	{
		$wartosc = preg_replace('/[^\d]/', '', $wartosc);

		if ((strlen($wartosc) != 9 && strlen($wartosc) != 14) || ($wartosc == '000000000' && $wartosc == '00000000000000'))
		{
			$this->ustawBlad('walidator_regon_nieprawidlowy');
			return false;
		}

		$str = str_split($wartosc);

		if (count($str) == 9)
		{
			$arrSteps = array(8, 9, 2, 3, 4, 5, 6, 7);
			$intSum = 0;
			for ($i = 0; $i < 8; $i++)
			{
				$intSum += $arrSteps[$i] * $str[$i];
			}

			$int = $intSum % 11;
			$intControlNr = ($int == 10) ? 0 : $int;

			if ($intControlNr == $str[8])
			{
				return true;
			}
		}
		else
		{
			$arrSteps = array(2, 4, 8, 5, 0, 9, 7, 3, 6, 1, 2, 4, 8);
			$intSum = 0;
			for ($i = 0; $i < 14; $i++)
			{
				$intSum += $arrSteps[$i] * $str[$i];
			}

			$int = $intSum % 11;
			$intControlNr = ($int == 10) ? 0 : $int;

			if ($intControlNr == $str[13])
			{
				return true;
			}
		}

		$this->ustawBlad('walidator_regon_nieprawidlowy');
		return false;
	}
}
