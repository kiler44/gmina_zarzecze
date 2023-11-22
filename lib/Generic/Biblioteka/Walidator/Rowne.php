<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest równa podanej
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Rowne extends Walidator
{

	protected $trescBledow = array(
		'walidator_rowne_nie_jest_rowne' => 'Nieprawidłowa wartość.',
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
				return true;
			}
		}
		else
		{
			if ($wartosc == $this->wartoscDoPorownania)
			{
				return true;
			}
		}
		$this->ustawBlad('walidator_rowne_nie_jest_rowne');
		return false;
	}
}
