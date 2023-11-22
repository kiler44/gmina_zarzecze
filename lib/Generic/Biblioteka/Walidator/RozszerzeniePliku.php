<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy rozszerzenie pliku znajduje się na liście dozwolonych
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class RozszerzeniePliku extends Walidator
{

	protected $trescBledow = array(
		'walidator_rozszerzenie_pliku_nieprawidlowe' => 'Plik ma niedozwolone rozszerzenie.'
	);

	protected $dozwolone_rozszerzenia = array();



	function __construct(Array $dozwolone_rozszerzenia = array())
	{
		$this->dozwolone_rozszerzenia = (array)$dozwolone_rozszerzenia;
	}



	function sprawdz($wartosc)
	{
		if (is_array($wartosc))
		{
			$nazwa_pliku = basename($wartosc['name']);
		}
		else
		{
			$nazwa_pliku = basename($wartosc);
		}

		if ($nazwa_pliku == '' || in_array(strtolower(file_ext($nazwa_pliku)), array_map('strtolower', $this->dozwolone_rozszerzenia)))
		{
			return true;
		}
		else
		{
			$this->ustawBlad('walidator_rozszerzenie_pliku_nieprawidlowe');
			return false;
		}
	}
}
