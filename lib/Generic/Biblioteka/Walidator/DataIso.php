<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność daty w formacie ISO
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class DataIso extends Walidator
{

	protected $trescBledow = array(
		'walidator_data_iso_nieprawidlowa_data' => 'Nieprawidłowa data',
	);



	function sprawdz($wartosc)
	{
		$data_int = strtotime($wartosc);

		if (date("Y-m-d", $data_int) != $wartosc)
		{
			$this->ustawBlad('walidator_data_iso_nieprawidlowa_data');
			return false;
		}
		else
		{
			return true;
		}
	}
}
