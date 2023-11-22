<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność nazwy subdomeny
 *
 * @author Adrian Sieracki
 * @package biblioteki
 */

class Subdomena extends Walidator
{

	protected $trescBledow = array(
		'walidator_niepoprawna_domena' => 'Niepoprawna nazwa subdomeny',
	);



	function __construct()
	{

	}



	function sprawdz($wartosc)
	{
		if (!preg_match('/^[a-zA-Z0-9][a-zA-Z-0-9]{3,31}$/', $wartosc) || !preg_match('/[a-zA-Z]/', $wartosc))
		{
			$this->ustawBlad('walidator_niepoprawna_domena');
			return false;
		}
		return true;
	}

}
