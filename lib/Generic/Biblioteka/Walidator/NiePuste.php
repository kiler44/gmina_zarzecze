<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest pusta
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class NiePuste extends Walidator
{

	protected $trescBledow = array(
		'walidator_nie_puste_wartosc_pusta' => 'Pole nie może być puste.',
	);



	function sprawdz($wartosc)
	{
		if (empty($wartosc) && $wartosc !== '0')
		{
			$this->ustawBlad('walidator_nie_puste_wartosc_pusta');
			return false;
		}
		else
		{
			return true;
		}
	}
}
