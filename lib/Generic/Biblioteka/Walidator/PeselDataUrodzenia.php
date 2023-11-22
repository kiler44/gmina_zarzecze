<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy podany numer pesel zgadza się z datą urodzenia
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class PeselDataUrodzenia extends Walidator
{

	protected $trescBledow = array(
		'walidator_pesel_data_urodzenia_nie_zgadza_sie' => 'Data urodzenia niezgodna z numerem Pesel',
	);

	private $pesel;



	function __construct($pesel)
	{
		$this->pesel = $pesel;
	}



	function sprawdz($data_iso)
	{
		$rok = substr($this->pesel, 0, 2);
		$miesiac = substr($this->pesel, 2, 2);
		$dzien = substr($this->pesel, 4, 2);

		if ($miesiac < 20)
		{
			$rok += 1900;
		}
		elseif($miesiac < 40)
		{
			$rok += 2000;
		}
		elseif($miesiac < 60)
		{
			$rok += 2100;
		}
		elseif($miesiac < 80)
		{
			$rok += 2200;
		}
		else
		{
			$rok += 1800;
		}

		$miesiac %= 20;

		$data_pesel = $rok.'-'.sprintf("%02s", $miesiac).'-'.$dzien;

		if ($data_pesel == $data_iso)
		{
			return true;
		}
		else
		{
			$this->ustawBlad('walidator_pesel_data_urodzenia_nie_zgadza_sie');
			return false;
		}
	}
}
