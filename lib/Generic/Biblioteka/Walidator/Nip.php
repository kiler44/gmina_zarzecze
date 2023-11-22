<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest prawidłowym numerem NIP
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Nip extends Walidator
{

	protected $trescBledow = array(
		'walidator_nip_nieprawidlowy_nip' => 'Nieprawidłowy numer NIP',
	);



	function sprawdz($wartosc)
	{
		if ( ! preg_match('/^[\d]{10}$/', $wartosc))
		{
			$this->ustawBlad('walidator_nip_nieprawidlowy_nip');
			return false;
		}
		$suma = 0;
		$wagi = array(6, 5, 7, 2, 3, 4, 5, 6, 7);

		for ($i=0; $i<9; $i++)
		{
			$suma += (int)$wartosc[$i] * $wagi[$i];
		}

		$suma = $suma % 11;

	/*	if ($suma == 10)
		{
			$this->ustawBlad('walidator_nip_nieprawidlowy_nip');
			return false;
		}
	 */
		if ($wartosc[9] != $suma)
		{
			$this->ustawBlad('walidator_nip_nieprawidlowy_nip');
			return false;
		}
		return true;
	}
}
