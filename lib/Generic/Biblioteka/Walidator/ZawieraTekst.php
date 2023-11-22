<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość zawiera tekst
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class ZawieraTekst extends Walidator
{

	protected $trescBledow = array(
		'walidator_zawiera_tekst_brak_tekstu' => 'Brak wymaganego tekstu',
	);

	private $wartoscSzukana;



	function __construct($wartoscSzukana)
	{
		$this->wartoscSzukana = $wartoscSzukana;
	}



	function sprawdz($wartosc)
	{
		if (strpos($wartosc, $this->wartoscSzukana) === false)
		{
			$this->ustawBlad('walidator_zawiera_tekst_brak_tekstu');
			return false;
		}
		else
		{
			return true;
		}
	}

}
