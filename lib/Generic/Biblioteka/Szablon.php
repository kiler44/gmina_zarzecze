<?php
namespace Generic\Biblioteka;


/**
 * Adapter dla klasy Blitz template.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Szablon
{

	/**
	 * Sciezka i nazwa pliku szablonu.
	 *
	 * @var Blitz
	 */
	protected $_blitz;



	/**
	 * Konstruktor.
	 *
	 * @param string $plikSzablonu Sciezka i nazwa pliku do uzycia.
	 * @param array $dane Zmienne dla szablonu.
	 */
	function __construct($plikSzablonu = null, $dane = array())
	{
		$this->_blitz = new \Blitz($plikSzablonu);
		if (!empty($dane))
		{
			$this->_blitz->set($dane);
		}
	}



	/**
	 * Laduje tresc szablonu.
	 *
	 * @param array $tresc Tresc szablonu.
	 */
	public function ladujTresc($tresc)
	{
		$this->_blitz->load($tresc);
	}



	/**
	 * Ustawia dane w szablonie.
	 *
	 * @param array $dane Tablica z danymi do szablonu.
	 */
	public function ustaw(Array $dane)
	{
		$this->_blitz->set($dane);
	}



	/**
	 * Ustawia dane w bloku szablonu.
	 *
	 * @param string $sciezka Sciezka do bloku.
	 * @param array $dane Tablica z danymi dla bloku.
	 */
	public function ustawBlok($sciezka, Array $dane = array())
	{
		$this->_blitz->block($sciezka, $dane);
	}



	/**
	 * Ustawia dane obowiazujace dla calego szablonu.
	 *
	 * @param array $dane Tablica z danymi globalnymi.
	 */
	public function ustawGlobalne(Array $dane = [])
	{
	    if(count($dane))
		    $this->_blitz->setGlobals($dane);
	}



	/**
	 * Dolacza inny szablon do biezacego.
	 *
	 * @param string $plikSzablonu Sciezka i nazwa pliku do uzycia.
	 * @param array $dane Zmienne dla szablonu.
	 *
	 * @return string
	 */
	public function dolaczSzablon($plikSzablonu, Array $dane)
	{
		return $this->_blitz->include($plikSzablonu, $dane);
	}



	/**
	 * Zwraca strukture zaladowanego szablonu.
	 *
	 * @param boolean $pelnaStruktura Czy korzystac z algorytmu zwracającego strukturę z wszystkimi parametrami
	 *
	 * @return array
	 */
	public function struktura($pelnaStruktura = false)
	{
		if($pelnaStruktura)
		{
			$struktura = array();
			$sciezka = array();

			ob_start();
			$this->_blitz->dumpStruct();
			foreach(explode("\n", ob_get_clean()) as $element)
			{
				$prefix = strpos($element, '^=');
				$poziom = floor(((int) $prefix - 1) / 2) + 1;

				while(count($sciezka) - 1 >= $poziom)
				{
					array_pop($sciezka);
				}

				if($prefix === false)
				{
					$element = '/';
				}
				elseif(preg_match('/^ *\^=([^\[]+?)\[5\]/', $element, $znalezione))
				{
					$element = $znalezione[1];
				}
				elseif(preg_match('/^ *\^=([^\[]+?)\[[0-9]+\][^;]*?; ARGS\([0-9]+\): ((?:[^;,]*\([0-9]+\),?)*)(?:$|;)/', $element, $znalezione))
				{
					if($znalezione[1] == 'BEGIN')
					{
						$element = str_replace('(0)', '', $znalezione[2]);
					}
					else
					{
						$element = $znalezione[1].' '.$znalezione[2];
					}
				}
				$sciezka[] = ltrim(trim($element), '/');
				$struktura[] = join('/', $sciezka);
			}

			return array_filter($struktura);
		}
		else
		{
			return $this->_blitz->getStruct();
		}
	}



	/**
	 * Zwraca tablice z danymi przekazanymi do szablonu.
	 *
	 * @return array
	 */
	public function przekazaneDane()
	{
		return $this->_blitz->getIterations();
	}


	/**
	 * Sprawdza czy szablon zawiera podany blok.
	 *
	 * @param string $sciezka Sciezka do bloku.
	 *
	 * @return boolean
	 */
	public function zawieraBlok($sciezka)
	{
		return $this->_blitz->hasContext($sciezka);
	}



	/**
	 * Parsuje blok i zwraca przetworzona tresc.
	 *
	 * @param string $sciezka Sciezka do bloku.
	 * @param array $dane Tablica z danymi dla bloku.
	 *
	 * @return string
	 */
	public function parsujBlok($sciezka, Array $dane = array())
	{
		return $this->_blitz->fetch($sciezka, $dane);
	}



	/**
	 * Parsuje szablon i zwraca przetworzona tresc.
	 *
	 * @param boolean $czysc Czy nalezy oczyscic wynikowa tresc.
	 *
	 * @return string
	 */
	public function parsuj($czysc = false)
	{
		$tresc = $this->_blitz->parse();
		if ($czysc)
		{
			$tresc = str_replace(array("\n\n","\r\n\r\n"), '', $tresc);
		}
		return $tresc;
	}



	/**
	 * Czysci szablon lub podany blok.
	 *
	 * @param string $sciezka Opcjonalna sciezka do bloku.
	 *
	 * @return boolean
	 */
	public function czysc($sciezka = null)
	{
		return $this->_blitz->clean($sciezka);
	}

}

class SzablonWyjatek extends \Exception {};
