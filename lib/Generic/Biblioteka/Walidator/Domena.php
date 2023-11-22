<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający czy wartość jest domeną
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Domena extends Walidator
{

	protected $trescBledow = array(
		'walidator_domena_nieprawidlowa_domena' => 'Domena nieprawidłowa',
		'walidator_domena_serwer_nie_odpowiada' => 'Serwer nie odpowiada',
	);


	private $sprawdzSerwer;



	function __construct($sprawdzSerwer = false)
	{
		$this->sprawdzSerwer = (bool)$sprawdzSerwer;
	}



	function sprawdz($wartosc)
	{
		if (!preg_match("/^([a-z0-9]([-a-z0-9]*[a-z0-9])?\\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net)|(om|org)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])$/i", $wartosc))
		{
			$this->ustawBlad('walidator_domena_nieprawidlowa_domena');
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
				$this->ustawBlad('walidator_domena_serwer_nie_odpowiada');
				return false;
			}
		}
		return true;
	}

}
