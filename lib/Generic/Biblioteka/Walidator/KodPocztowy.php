<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność kodu pocztowego
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class KodPocztowy extends Walidator
{

	protected $trescBledow = array(
		'walidator_kod_pocztowy_nieprawidlowy_kod' => 'Kod pocztowy jest nieprawidłowy',
	);



	function sprawdz($wartosc)
	{
		if (!preg_match('/^[0-9]{2}\-[0-9]{3}$/', $wartosc))
		{
			$this->ustawBlad('walidator_kod_pocztowy_nieprawidlowy_kod');
			return false;
		}

		return true;
	}
}
