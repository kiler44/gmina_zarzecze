<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest większa od liczby
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class WiekszeOd extends Walidator
{

	protected $trescBledow = array(
		'walidator_wieksze_od_liczba_za_mala' => 'Wartość zbyt mała.',
	);

	private $wieksze_rowne;

	private $liczba;



	function __construct($liczba, $wieksze_rowne = false)
	{
		$this->wieksze_rowne = $wieksze_rowne;
		$this->liczba = $liczba;
	}



	function sprawdz($wartosc)
	{
		if ($this->wieksze_rowne)
		{
			if ($wartosc >= $this->liczba)
			{
				return true;
			}
			else
			{
				$this->ustawBlad('walidator_wieksze_od_liczba_za_mala');
				return false;
			}
		}
		else
		{
			if ($wartosc > $this->liczba)
			{
				return true;
			}
			else
			{
				$this->ustawBlad('walidator_wieksze_od_liczba_za_mala');
				return false;
			}
		}
	}
}
