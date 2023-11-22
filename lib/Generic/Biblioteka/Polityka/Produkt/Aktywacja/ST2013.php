<?php
namespace Generic\Biblioteka\Polityka\Produkt\Aktywacja;
use Generic\Biblioteka\Polityka;

/**
 * Klasa abstrakcyjna dla wszystkich polityk aktywujacych konto
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class ST2013 extends Polityka\Produkt\Aktywacja
{
	/**
	 * @var Array
	 */
	protected $wymaganeParametry = array(
		'po_ilu_dniach_aktywacja_automatyczna' => 7,
	);


	/**
	 * Wykonuje algorytm polityki.
	 *
	 * @return mixed Wynik działania polityki
	 */
	public function wykonaj()
	{
		echo "Wykonuję aktywację konta na zasadach ST2013\n\n";
	}
}

