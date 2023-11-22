<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność dokumentu html
 *
 * @author Adrian Sieracki
 * @package biblioteki
 */

class Html extends Walidator
{

	protected $trescBledow = array(
		'walidator_niepoprawny_html' => 'Wprowadzona treść jest niezgodna z formatem HTML',
	);



	function __construct()
	{

	}



	function sprawdz($wartosc)
	{
		if(empty($wartosc)) return true;

		$previousInternalError = libxml_use_internal_errors(true);
		$dom = new \DOMDocument();
		$dom->validateOnParse = true;

		$dom->loadHTML($wartosc);
		$lastError = libxml_get_last_error();
		libxml_use_internal_errors($previousInternalError);

		if($lastError === false)
			return true;
		else
		{
			$this->ustawBlad('walidator_niepoprawny_html');
			return false;
		}
	}

}
