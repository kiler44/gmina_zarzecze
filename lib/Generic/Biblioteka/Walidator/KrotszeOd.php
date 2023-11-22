<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy tekst nie przekroczył określonej długości
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class KrotszeOd extends Walidator
{

	protected $trescBledow = array(
		'walidator_krotsze_od_wartosc_za_dluga' => 'Wartość zbyt długa',
	);

	private $mniejszeRowne;

	private $liczba;



	function __construct($liczba, $mniejsze_rowne = false)
	{
		$this->mniejszeRowne = (bool)$mniejsze_rowne;
		$this->liczba = (int)$liczba;
	}



	function sprawdz($wartosc)
	{
		if ($this->mniejszeRowne)
		{
			if (mb_strlen($wartosc) <= $this->liczba)
			{
				return true;
			}
			else
			{
				$this->ustawBlad('walidator_krotsze_od_wartosc_za_dluga');
				return false;
			}
		}
		else
		{
			if (mb_strlen($wartosc) < $this->liczba)
			{
				return true;
			}
			else
			{
				$this->ustawBlad('walidator_krotsze_od_wartosc_za_dluga');
				return false;
			}
		}
	}
}
