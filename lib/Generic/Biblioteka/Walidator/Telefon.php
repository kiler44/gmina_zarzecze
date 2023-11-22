<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest poprawnym numerem telefonu
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Telefon extends Walidator
{

	protected $trescBledow = array(
		'walidator_telefon_nieprawidlowy_numer' => 'Numer telefonu nieprawidłowy'
	);



	function sprawdz($wartosc)
	{
		$wartosc = preg_replace('/[^\d]/', '', $wartosc);

		if (!preg_match('/[1-9]\d{7,}/', $wartosc))
		{
			$this->ustawBlad('walidator_telefon_nieprawidlowy_numer');
			return false;
		}
		else
		{
			return true;
		}
	}
}
