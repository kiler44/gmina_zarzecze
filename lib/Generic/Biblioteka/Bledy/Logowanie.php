<?php
namespace Generic\Biblioteka\Bledy;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa abstrakcyjna dla mechanizmow logowania
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
abstract class Logowanie
{

	/**
	 * Poziom logowania (domyslnie wszystko)
	 * @var integer
	 */
	protected $poziom = E_ALL;


	/**
	 * tablica z tlumaczeniami typow bledow
	 * @var array
	 */
	protected $typyBledow = array(
		E_ERROR              => 'Error',
		E_WARNING            => 'Warning',
		E_PARSE              => 'Parsing Error',
		E_NOTICE             => 'Notice',
		E_CORE_ERROR         => 'Core Error',
		E_CORE_WARNING       => 'Core Warning',
		E_COMPILE_ERROR      => 'Compile Error',
		E_COMPILE_WARNING    => 'Compile Warning',
		E_USER_ERROR         => 'User Error',
		E_USER_WARNING       => 'User Warning',
		E_USER_NOTICE        => 'User Notice',
		E_STRICT             => 'Runtime Notice',
		E_RECOVERABLE_ERROR  => 'Catchable Fatal Error',
		//E_DEPRECATED         => 'Deprecated',
		//E_USER_DEPRECATED    => 'User Deprecated',
	);



	/**
	 * Konstruktor, ustawia poziom przechwytywanych bledow.
	 *
	 * @param integer $poziom poziom przechwytywanych bledow.
	 */
	function __construct($poziom)
	{
		$this->poziom = $poziom;
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
        $_SERVER['USER'] = (isset($_SERVER['USER'])) ? $_SERVER['USER'] : 'cron';
		$wiersz = '['.date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
		$wiersz .= (PHP_SAPI != 'cli') ? ', '.Zadanie::wywolanyUrl().', '.Zadanie::adresIp() : ', '.$_SERVER['SCRIPT_NAME'].', User:'.$_SERVER['USER'];
		$wiersz .= ']'."\n";
		$wiersz .= '## ('.str_replace(CMS_KATALOG, '', $plikBledu).':'.$liniaBledu.') ';
		$wiersz .= (array_key_exists($poziomBledu, $this->typyBledow)) ? $this->typyBledow[$poziomBledu] : 'Unknown';
		$wiersz .= ': '.str_replace(array("\r\n","\r","\n", "  "), ' ', $trescBledu);
		return $wiersz;
	}



	/**
	 * Zwraca sformatowaną tresc sciezki bledu.
	 *
	 * @param array $sciezka tablica zawierajaca sciezke zwrotna dla bledu.
	 *
	 * @return string
	 */
	function formatujSciezke($sciezka)
	{
		$tresc = '';
		if (count($sciezka) > 0)
		{
			foreach($sciezka as $nr => $opis)
			{
				$wiersz = '';
				$wiersz .= '#'.$nr;
				$wiersz .= (isset($opis['file']) && $opis['line']) ? ' ('. str_replace(CMS_KATALOG, '', $opis['file']).':'.$opis['line'].') ' : ' (Nieznana lokalizacja) ';
				$wiersz .= (isset($opis['class'])) ? $opis['class'].$opis['type'] : '';
				$wiersz .= $opis['function'];

				$argumenty = array();
				if (isset($opis['args']))
				{
					foreach($opis['args'] as $argument)
					{
						switch (true)
						{
							case is_bool($argument):
								$argumenty[] = ($argument) ? 'TRUE' : 'FALSE';
								break;

							case is_int($argument):
							case is_float($argument):
								$argumenty[] = $argument;
								break;

							case is_null($argument):
								$argumenty[] = 'NULL';
								break;

							case is_string($argument):
								$argumenty[] = (strlen($argument) > 50) ? 'string['.strlen($argument).',"'.substr($argument, 0, 50).'..."]' : $argument;
								break;

							case is_array($argument):
								$temp = print_r($argument, true);
								$argumenty[] = (strlen($temp) > 250) ? 'array['.count($argument).']' : $temp;
								unset($temp);
								//$argumenty[] = 'array['.count($argument).']';
								break;

							case is_object($argument):
								$argumenty[] = 'object: ' . get_class($argument);
								break;

							case is_resource($argument):
								$argumenty[] = 'resource: '.get_resource_type($argument);
								break;

							default:
								$argumenty[] = 'unknown';
								break;
						}
					}
				}
				$wiersz .= '('.implode(', ', $argumenty).')';
				$wiersz = str_replace(array("\r\n","\r","\n","\t"), '', $wiersz);
				$tresc .= $wiersz."\n";
			}
			$tresc = str_replace(array('  ','   ','    '), ' ', $tresc);
		}
		return $tresc;
	}



	/**
	 * Metoda wywolywana przez klase przechwytujaca bledy.
	 *
	 * @param integer $poziomBledu Poziom.
	 * @param string $trescBledu Tresc bledu.
	 * @param string $plikBledu Plik w ktorym blad wystapil.
	 * @param integer $liniaBledu Linia w ktorej blad wystapil.
	 */
	public function przechwyc($poziomBledu, $trescBledu, $plikBledu, $liniaBledu, $dodatkoweArgumenty)
	{
		// Przekazuje blad do logowania tylko jeżeli poziom bledu jest zgodny z poziomem logowania
		if (($poziomBledu & $this->poziom) > 0)
		{
			$this->przechwycBlad($poziomBledu, $trescBledu, $plikBledu, $liniaBledu, $dodatkoweArgumenty);
		}
	}



	/**
	 * Faktycznie obsluguje bledy. Implementacje w klasach dziedziczacych
	 *
	 * @param integer $poziomBledu Poziom.
	 * @param string $trescBledu Tresc bledu.
	 * @param string $plikBledu Plik w ktorym blad wystapil.
	 * @param integer $liniaBledu Linia w ktorej blad wystapil.
	 */
	abstract protected function przechwycBlad($poziomBledu, $trescBledu, $plikBledu, $liniaBledu, $dodatkoweArgumenty);

}

