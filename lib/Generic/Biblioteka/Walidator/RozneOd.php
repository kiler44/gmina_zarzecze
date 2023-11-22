<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest różna od podanej
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class RozneOd extends Walidator
{

	protected $trescBledow = array(
		'walidator_rozne_od_nie_jest_rozne' => 'Nieprawidłowa wartość.',
	);

	private $wartoscDoPorownania;

	private $restrykcyjne;



	function __construct($wartoscDoPorownania, $restrykcyjne = false)
	{
		$this->wartoscDoPorownania = $wartoscDoPorownania;
		$this->restrykcyjne = (bool)$restrykcyjne;
	}



	function sprawdz($wartosc)
	{
		if ($this->restrykcyjne)
		{
			if ($wartosc === $this->wartoscDoPorownania)
			{
				$this->ustawBlad('walidator_rozne_od_nie_jest_rozne');
				return false;
			}
		}
		else
		{
			if ($wartosc == $this->wartoscDoPorownania)
			{
				$this->ustawBlad('walidator_rozne_od_nie_jest_rozne');
				return false;
			}
		}
		return true;
	}
}
