<?php
namespace Generic\Biblioteka\Bledy\Logowanie;
use Generic\Biblioteka\Bledy;


/**
 * Logowanie bledow do pliku dziennika.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Email extends Bledy\Logowanie
{

	/**
	 * Przechowuje adres email na ktory zostanie wyslane powiadomienie.
	 * @var string
	 */
	private $email;



	/**
	 * Przechwycone bledy.
	 * @var array
	 */
	private $bledy = array();



	/**
	 * Konstruktor, ustawia poziom przechwytywanych bledow i ustawia adres email.
	 *
	 * @param integer $poziom poziom przechwytywanych bledow.
	 * @param string $email adres email na ktory zostanie wyslane powiadomienie.
	 */
	function __construct($poziom, $email)
	{
		parent::__construct($poziom);
		$this->email = $email;
	}



	/**
	 * Destruktor, wysyla email z raportem o bledach.
	 */
	function __destruct()
	{
		if (count($this->bledy) > 0)
		{
			$temat = "Blad na serwerze " . $_SERVER['SERVER_NAME'];

			$tresc = "";
			$tresc .= "Adres wywolujacego: " . $_SERVER['REMOTE_ADDR'] . "\n";
			$tresc .= "Url zadania: " . $_SERVER['REQUEST_URI'] . "\n";
			$tresc .= "Wykryte bledy:\n\n";

			foreach ($this->bledy as $blad) $tresc .= $blad;

			mail($this->email, $temat, $tresc);
		}
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

		$this->bledy[] = $trescBledu;
	}

}
