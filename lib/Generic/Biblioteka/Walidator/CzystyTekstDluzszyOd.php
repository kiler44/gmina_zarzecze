<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy tekst ma minimalną określoną długość
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class CzystyTekstDluzszyOd extends Walidator
{

	protected $trescBledow = array(
		'walidator_dluzsze_od_wartosc_za_krotka' => 'Wartość zbyt krótka',
	);


	private $wiekszeRowne;


	private $liczba;



	function __construct($liczba, $wieksze_rowne = false)
	{
		$this->wiekszeRowne = (bool)$wieksze_rowne;
		$this->liczba = (int)$liczba;
	}



	function sprawdz($wartosc)
	{
		$wartosc = trim(str_replace('&nbsp;', ' ', strip_tags($wartosc)));

		if ($this->wiekszeRowne)
		{
			if (mb_strlen($wartosc) >= $this->liczba)
			{
				return true;
			}
			else
			{
				$this->ustawBlad('walidator_dluzsze_od_wartosc_za_krotka');
				return false;
			}
		}
		else
		{
			if (mb_strlen($wartosc) > $this->liczba)
			{
				return true;
			}
			else
			{
				$this->ustawBlad('walidator_dluzsze_od_wartosc_za_krotka');
				return false;
			}
		}
	}
}
