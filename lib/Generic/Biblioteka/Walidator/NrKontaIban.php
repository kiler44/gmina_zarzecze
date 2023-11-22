<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość poprawnym numerem konta w formacie IBAN
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class NrKontaIban extends Walidator
{

	protected $trescBledow = array(
		'walidator_nr_konta_iban_nieprawidlowy_numer' => 'Nieprawidłowy numer konta w formacie IBAN',
	);



	function sprawdz($wartosc)
	{
		//(c) Bartłomiej Zastawnik, "Rzast".
		//Uzycie funkcji dozwolone przy zachowaniu komentarzy.
		$puste = array(' ', '-', '_', '.', ',','/', '|');//znaki do usuniecia
		$temp = trim(strtoupper(str_replace($puste, '', $wartosc))); //Zostaja cyferki + duze litery
		//Jezeli na poczatku sa cyfry, to dopisujemy PL, inne kraje musza byc jawnie wprowadzone

		if ($temp == '')
		{
			$this->ustawBlad('walidator_nr_konta_iban_nieprawidlowy_numer');
			return false;
		}

		if (($temp[0] <= '9') && ($temp[1] <= '9'))
		{
			$temp = 'PL'.$temp;
		}

		$temp = substr($temp,4).substr($temp, 0, 4); //przesuwanie cyfr kontrolnych na koniec

		//Tablica zamiennikow, potrzebnych do wyliczenia sumy kontrolnej
		$znaki = array(
			'0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4',
			'5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9',
			'A'=>'10','B'=>'11','C'=>'12','D'=>'13','E'=>'14','F'=>'15',
			'G'=>'16','H'=>'17','I'=>'18','J'=>'19','K'=>'20',
			'L'=>'21','M'=>'22','N'=>'23','O'=>'24','P'=>'25',
			'Q'=>'26','R'=>'27','S'=>'28','T'=>'29','U'=>'30',
			'V'=>'31','W'=>'32','X'=>'33','Y'=>'34','Z'=>'35'
		);

		$ilosc = strlen($temp); //dlugosc numeru
		$ciag = '';

		for ($i=0; $i<$ilosc; $i++)
		{
			$ciag .= $znaki[$temp{$i}];
		}

		$mod = 0;

		$ilosc = strlen($ciag); //nowa dlugosc numeru

		for ($i=0; $i<$ilosc; $i=$i+6)
		{
			//oblicznie modulo, $ciag jest zbyt wielka liczba na format integer, wiec dziele go na czesci
			$mod = (int)($mod.substr($ciag, $i, 6)) % 97;
		}

		if ($mod == 1)
		{
			return true;
		}
		else
		{
			$this->ustawBlad('walidator_nr_konta_iban_nieprawidlowy_numer');
			return false;
		}
	}
}
