<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość nie znajduje się na liście niedozwolonych
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class NiedozwoloneWartosci extends Walidator
{

	protected $trescBledow = array(
		'walidator_niedozwolone_wartosci_niedozwolona_wartosc' => 'Niedozwolona Wartość.',
	);

	private $niedozwoloneWartosci;



	function __construct(Array $niedozwoloneWartosci)
	{
		$this->niedozwoloneWartosci = $niedozwoloneWartosci;
	}



	function sprawdz($wartosc)
	{
		if (in_array($wartosc, $this->niedozwoloneWartosci))
		{
			$this->ustawBlad('walidator_niedozwolone_wartosci_niedozwolona_wartosc');
			return false;
		}
		return true;
	}
}
