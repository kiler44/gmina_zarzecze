<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość występuje w podanej liście
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class DozwoloneWartosci extends Walidator
{

	protected $trescBledow = array(
		'walidator_dozwolone_wartosci_niedozwolona_wartosc' => 'Wartość nie znajduje się na liście wartości akceptowanych.',
	);

	private $dozwoloneWartosci;



	function __construct(Array $dozwoloneWartosci)
	{
		$this->dozwoloneWartosci = $dozwoloneWartosci;
	}



	function sprawdz($wartosc)
	{
		if ( ! in_array($wartosc, $this->dozwoloneWartosci))
		{
			$this->ustawBlad('walidator_dozwolone_wartosci_niedozwolona_wartosc');
			return false;
		}
		return true;
	}
}
