<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność kodu pocztowego
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class WspolrzedneGeograficzne extends Walidator
{

	protected $trescBledow = array(
		'walidator_wspolrzedne_geograficzne_nieprawidlowe' => 'Lokalizacja jest nieprawidłowa',
	);



	function sprawdz($wartosc)
	{
		$szerokosc = $wartosc['szerokosc'];
		$dlugosc = $wartosc['dlugosc'];
		
		if ((is_numeric($szerokosc) && $szerokosc > -90 && $szerokosc < 90) &&
			(is_numeric($dlugosc) && $dlugosc > -180 && $dlugosc < 180))
		{
			return true;
		}
		else
		{
			$this->ustawBlad('walidator_wspolrzedne_geograficzne_nieprawidlowe');
			return false;			
		}
	}
}
