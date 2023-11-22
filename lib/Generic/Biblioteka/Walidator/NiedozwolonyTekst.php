<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość zwaiera niedozwolony tekst
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class NiedozwolonyTekst extends Walidator
{

	protected $trescBledow = array(
		'walidator_niedozwolony_tekst_zawiera_tekst' => 'Wartość zawiera niedozwolony tekst',
	);

	private $wartoscSzukana;



	function __construct($wartoscSzukana)
	{
		$this->wartoscSzukana = $wartoscSzukana;
	}



	function sprawdz($wartosc)
	{
		if (strpos($wartosc, $this->wartoscSzukana) !== false)
		{
			$this->ustawBlad('walidator_niedozwolony_tekst_zawiera_tekst');
			return false;
		}
		else
		{
			return true;
		}
	}
}
