<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność godziny w formacie ISO
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Godzina extends Walidator
{

	protected $trescBledow = array(
		'walidator_godzina_nieprawidlowa_godzina' => 'Nieprawidłowa godzina',
	);



	function sprawdz($wartosc)
	{
		$godz_tab = explode(':', $wartosc);
		if(strlen($wartosc) == 5) $wartosc .= ':00';
		if (($godz_tab[0] > 23 || $godz_tab < 0) ||
			($godz_tab[1] > 59 || $godz_tab[1] < 0) ||
			($godz_tab[2] > 59 || $godz_tab[2] < 0) ||
			!preg_match('/^[0-9]{2}\:([0-9]{2})\:([0-9]{2})?$/', $wartosc))
		{
			$this->ustawBlad('walidator_godzina_nieprawidlowa_godzina');
			return false;
		}
		else
		{
			return true;
		}
	}
}
