<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość spełnia podane wyrażenie regularne
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class WyrazenieRegularne extends Walidator
{

	protected $trescBledow = array(
		'walidator_wyrazenie_regularne_niespelnione' => 'Wartość nie spełnia warunku',
	);

	private $wyrazenie;



	function __construct($wyrazenie)
	{
		$this->wyrazenie = $wyrazenie;
	}



	function sprawdz($wartosc)
	{
		if (!preg_match($this->wyrazenie, $wartosc))
		{
			$this->ustawBlad('walidator_wyrazenie_regularne_niespelnione');
			return false;
		}
		return true;
	}

}
