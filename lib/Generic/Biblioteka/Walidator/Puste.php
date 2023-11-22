<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy tekst jest pusty
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Puste extends Walidator
{

	protected $trescBledow = array(
		'walidator_puste_nie_puste' => 'Nie jest puste',
	);



	function sprawdz($wartosc)
	{
		if (strlen($wartosc) != 0)
		{
			$this->ustawBlad('walidator_puste_nie_puste');
			return false;
		}
		else
		{
			return true;
		}
	}
}
