<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość adresem url
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Url extends Walidator
{

	protected $trescBledow = array(
		'walidator_url_nieprawidlowy_url' => 'Adres URL nieprawidłowy',
		'walidator_url_serwer_nie_odpowiada' => 'Serwer nie odpowiada',
	);

	private $sprawdzSerwer;



	function __construct($sprawdzSerwer = false)
	{
		$this->sprawdzSerwer = (bool)$sprawdzSerwer;
	}



	function sprawdz($wartosc)
	{
		$protokol = "(http://)?";
		$host = "([a-z\d]+[-a-z\d]*[a-z\d]*\.)+[a-z][-a-z\d]*[a-z]";
		$port = "(:\d{1,})?";
		$path = "(\/[^?<>\#\"\s@]*)?";
		$query = "(\?[^<>\#\"\s]+)?";

		if (!preg_match("#^({$protokol}{$host}{$port}{$path}{$query})$#i", $wartosc))
		{
			$this->ustawBlad('walidator_url_nieprawidlowy_url');
			return false;
		}

		if ($this->sprawdzSerwer)
		{
			$wartosc = trim(strtolower($wartosc));

			if (strpos($wartosc, "http://") !== false)
			{
				$odpowiedz = @fsockopen($wartosc, 80);
			}
			elseif (strpos($wartosc, "https://") !== false)
			{
				$odpowiedz = @fsockopen($wartosc, 443);
			}
			else
			{
				$odpowiedz = @fsockopen("http://".$wartosc, 80);
			}

			if ($odpowiedz === false)
			{
				$this->ustawBlad('walidator_url_serwer_nie_odpowiada');
				return false;
			}
		}
		return true;
	}

}
