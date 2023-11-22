<?php
namespace Generic\Biblioteka\Bledy\Logowanie;
use Generic\Biblioteka\Bledy;


/**
 * Logowanie bledow do pliku dziennika.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Plik extends Bledy\Logowanie
{

	/**
	 * Sciezka do pliku dziennika.
	 * @var string
	 */
	private $plik;


	/**
	 * Konstruktor, ustawia poziom przechwytywanych bledow i otwiera plik dziennika.
	 *
	 * @param integer $poziom poziom przechwytywanych bledow.
	 * @param string $nazwaPliku nazwa pliku w ktorym znajduje sie log.
	 */
	function __construct($poziom, $nazwaPliku)
	{
		parent::__construct($poziom);
		$this->plik = $nazwaPliku;
	}



	/**
	 * Obsluguje przechwycony blad.
	 *
	 * @param integer $poziomBledu Poziom.
	 * @param string $trescBledu Tresc bledu.
	 * @param string $plikBledu Plik w ktorym blad wystapil.
	 * @param integer $liniaBledu Linia w ktorej blad wystapil.
	 */
	protected function przechwycBlad($poziomBledu, $trescBledu, $plikBledu, $liniaBledu, $dodatkoweArgumenty)
	{
		$trescBledu = $this->formatujTresc($poziomBledu, $trescBledu, $plikBledu, $liniaBledu, $dodatkoweArgumenty);
		$trescBledu .= "\n".$this->formatujSciezke($dodatkoweArgumenty)."\n\n";

		error_log($trescBledu, 3, $this->plik);
	}

}

