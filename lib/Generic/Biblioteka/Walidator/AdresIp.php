<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność adresu ip
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class AdresIp extends Walidator
{

	protected $trescBledow = array(
		'walidator_adres_ip_nieprawidlowy_adres' => 'Adres IP nieprawidłowy'
	);



	function sprawdz($wartosc)
	{
		if (!preg_match('/([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}/', $wartosc))
		{
			$this->ustawBlad('walidator_adres_ip_nieprawidlowy_adres');
			return false;
		}
		return true;
	}
}
