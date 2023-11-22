<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność daty w formacie  polskim(DD-MM-RRRR)
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class DataPl extends Walidator
{

	protected $trescBledow = array(
		'walidator_data_pl_nieprawidlowa_data' => 'Nieprawidłowa data',
	);



	function sprawdz($wartosc)
	{
		$data_iso = substr($wartosc, -4).'-'.substr($wartosc, 3, 2).'-'.substr($wartosc, 0, 2);
		$data_int = strtotime($data_iso);
		if(date("d-m-Y", $data_int) != $wartosc)
		{
			$this->ustawBlad('walidator_data_pl_nieprawidlowa_data');
			return false;
		}
		else
		{
			return true;
		}
	}
}
