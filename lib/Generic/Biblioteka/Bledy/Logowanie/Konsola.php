<?php
namespace Generic\Biblioteka\Bledy\Logowanie;
use Generic\Biblioteka\Bledy;


/**
 * Logowanie bledow do pliku dziennika.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Konsola extends Bledy\Logowanie
{

	/**
	 * Przechwycone bledy.
	 * @var array
	 */
	private $bledy = array();



	/**
	 * Konstruktor, ustawia poziom przechwytywanych bledow i zmienia konfiguracje php.
	 *
	 * @param integer $poziom poziom przechwytywanych bledow.
	 */
	function __construct($poziom)
	{
		//ini_set('display_errors', false);
		//ini_set('display_startup_errors', false);
		parent::__construct($poziom);
	}



	/**
	 * Formatuje tresc bledu.
	 *
	 * @param integer $poziomBledu Poziom.
	 * @param string $trescBledu Tresc bledu.
	 * @param string $plikBledu Plik w ktorym blad wystapil.
	 * @param integer $liniaBledu Linia w ktorej blad wystapil.
	 *
	 * @return string
	 */
	function formatujTresc($poziomBledu, $trescBledu, $plikBledu, $liniaBledu)
	{
	    $user = (isset($_SERVER['USER'])) ? $_SERVER['USER'] : 'Apache';
		$wiersz = '['.date('Y-m-d H:i:s').', '.$_SERVER['SCRIPT_NAME'].', User: '.$user.']'."\n";
		$wiersz .= '## ('.str_replace(CMS_KATALOG, '', $plikBledu).':'.$liniaBledu.') ';
		$wiersz .= (array_key_exists($poziomBledu, $this->typyBledow)) ? $this->typyBledow[$poziomBledu] : 'Unknown';
		$wiersz .= ': '.str_replace(array("\r\n","\r","\n", "  "), ' ', $trescBledu);
		return $wiersz;
	}



	/**
	 * Destruktor, wyswietla komunikaty bledow na ekranie.
	 */
	function __destruct()
	{
		if (count($this->bledy) > 0)
		{
			foreach($this->bledy as $numer => $blad)
			{
				echo $blad['tresc']."\n";
				echo ($blad['sciezka'] != '') ? $blad['sciezka'] : '';
				echo "\n\n";
			}
		}
		ini_restore('display_errors');
		ini_restore('display_startup_errors');
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
		$this->bledy[] = array(
			'tresc' => $this->formatujTresc($poziomBledu, $trescBledu, $plikBledu, $liniaBledu),
			'sciezka' => $this->formatujSciezke($dodatkoweArgumenty)
		);
	}


}

