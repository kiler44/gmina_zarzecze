<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość zawiera wymagane treści
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class WymaganeWartosci extends Walidator
{

	protected $trescBledow = array(
		'walidator_wymagane_wartosci_brak_wartosci' => 'Brak wymaganej wartości',
	);


	private $wymaganeWartosci;



	function __construct(Array $wymaganeWartosci)
	{
		$this->wymaganeWartosci = $wymaganeWartosci;
	}



	function sprawdz($wartosc)
	{
		foreach ($this->wymaganeWartosci as $szukana)
		{
			if ($szukana != '' && strpos($wartosc, $szukana) === false)
			{
				$this->ustawBlad('walidator_wymagane_wartosci_brak_wartosci');
				return false;
			}
		}
		return true;
	}

}