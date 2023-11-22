<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność kodu pocztowego
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class KodPocztowyZeStringu extends Walidator
{

	protected $trescBledow = array(
		'walidator_kod_pocztowy_nieprawidlowy_kod' => 'Kod pocztowy jest nieprawidłowy',
	);



	function sprawdz($wartosc)
	{
		$kod = substr($wartosc, 0, 4);
		if (is_numeric($kod) && $kod > 0 && $kod < 9992)
		{
			return true;
		}
		
		$this->ustawBlad('walidator_kod_pocztowy_nieprawidlowy_kod');
		return false;
	}
}
