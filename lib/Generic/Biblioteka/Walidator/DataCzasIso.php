<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność daty i czasu w formacie ISO
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class DataCzasIso extends Walidator
{

	protected $trescBledow = array(
		'walidator_data_czas_iso_nieprawidlowa_data' => 'Nieprawidłowa data',
	);



	function sprawdz($wartosc)
	{
		$data_int = strtotime($wartosc);

		if (date("Y-m-d H:i:s", $data_int) != $wartosc && $wartosc != '')
		{
			$this->ustawBlad('walidator_data_czas_iso_nieprawidlowa_data');
			return false;
		}
		else
		{
			return true;
		}
	}
}
