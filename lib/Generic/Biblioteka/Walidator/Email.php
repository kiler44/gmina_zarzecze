<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność adresu email
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Email extends Walidator
{

	protected $trescBledow = array(
		'walidator_email_nieprawidlowy_email' => 'Nieprawidłowy adres e-mail',
		'walidator_email_serwer_nie_obsluguje_poczty' => 'Nieprawidłowy adres e-mail: serwer nie obsługuje poczty',
	);

	private $sprawdzSerwer;



	function __construct($sprawdzSerwer = false)
	{
		$this->sprawdzSerwer = (bool)$sprawdzSerwer;
	}



	function sprawdz($wartosc)
	{
		$adres_wyrazenie = '/^(.+?)@(([a-z0-9\.-]+?)\.[a-z]{2,5})$/i';
		$uzytkownik_wyrazenie = "/^[a-z0-9\-\_\+\,\.]+$/i";

		if (!preg_match($adres_wyrazenie, $wartosc, $zwrot) && $wartosc !== null) // Całość poprawna składniowo
		{
			$this->ustawBlad('walidator_email_nieprawidlowy_email');
			return false;
		}
		else
		{
			$uzytkownik = $zwrot[1];
			$host = $zwrot[2];
		}

		if (!preg_match($uzytkownik_wyrazenie, $uzytkownik)) // Nazwa uzytkownika poprawna
		{
			$this->ustawBlad('walidator_email_nieprawidlowy_email');
			return false;
		}

		if ($this->sprawdzSerwer)
		{
			if (strpos($_SERVER['SERVER_SOFTWARE'], 'Win') === FALSE)
			{
				$host_obsluguje_poczte = checkdnsrr($host, "MX");
			}
			else
			{
				$host_obsluguje_poczte = true;
			}

			if (!$host_obsluguje_poczte) // Host obsługuje pocztę
			{
				$this->ustawBlad('walidator_email_serwer_nie_obsluguje_poczty');
				return false;
			}
		}
		return true;
	}
}
