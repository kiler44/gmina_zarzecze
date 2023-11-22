<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest poprawnym numerem konta w formacie NRB
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class NrKontaNrb extends Walidator
{

	protected $trescBledow = array(
		'walidator_nr_konta_nrb_nieprawidlowy_numer' => 'Nieprawidłowy numer konta w formacie NRB',
	);



	function sprawdz($wartosc)
	{
		$wartosc = preg_replace('/[^\d]/', '', $wartosc);

		if (strlen($wartosc)!=26)
		{
			$this->ustawBlad('walidator_nr_konta_nrb_nieprawidlowy_numer');
			return false;
		}

		$wartosc .= '2521'; // doklejanie kodu kraju 'PL'

		$wartosc = substr($wartosc,2).substr($wartosc,0,2); // dostosowanie do algorytmu IBAN ISO13616
		//sprawdzanie numeru w formacie IBAN
		$wagi = array(1,10,3,30,9,90,27,76,81,34,49,5,50,15,53,45,62,38,89,17,73,51,25,56,75,71,31,19,93,57);
		$wynik =0;

		for ($i=0;$i<30;$i++)
		{
			$wynik += $wartosc[29-$i] * $wagi[$i];
		}

		if ($wynik % 97 == 1)
		{
			return true;
		}
		else
		{
			$this->ustawBlad('walidator_nr_konta_nrb_nieprawidlowy_numer');
			return false;
		}
	}
}
