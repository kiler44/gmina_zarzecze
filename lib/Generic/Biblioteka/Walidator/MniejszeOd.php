<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest mniejsza od liczby
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class MniejszeOd extends Walidator
{

	protected $trescBledow = array(
		'walidator_mniejsze_od_liczba_za_duza' => 'Wartość zbyt duża',
	);

	private $mniejszeRowne;

	private $liczba;



	function __construct($liczba, $mniejsze_rowne = false)
	{
		$this->mniejszeRowne = $mniejsze_rowne;
		$this->liczba = $liczba;
	}



	function sprawdz($wartosc)
	{
		if ($this->mniejszeRowne)
		{
			if ($wartosc <= $this->liczba)
			{
				return true;
			}
			else
			{
				$this->ustawBlad('walidator_mniejsze_od_liczba_za_duza');
				return false;
			}
		}
		else
		{
			if ($wartosc < $this->liczba)
			{
				return true;
			}
			else
			{
				$this->ustawBlad('walidator_mniejsze_od_liczba_za_duza');
				return false;
			}
		}
	}
}
