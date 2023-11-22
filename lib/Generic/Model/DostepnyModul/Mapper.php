<?php
namespace Generic\Model\DostepnyModul;
use Generic\Biblioteka;
use Generic\Biblioteka\MapperWyjatek;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Cms;


/**
 * Klasa obsługująca zapis i odczyt z pliku dla obiektów odwzorowujących moduły cms-a.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Tablica
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\DostepnyModul\Obiekt';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'kod' => 'kod',
		'nazwa' => 'nazwa',
		'opis' => 'opis',
		'typ'=> 'typ',
		'wymagane' => 'wymagane',
		'dla_zalogowanych' => 'dlaZalogowanych',
		'uslugi' => 'uslugi',
		'cache' => 'cache',
		'katalog_szablon' => 'katalogSzablon'
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('kod');



	/**
	 * Zwraca instancje obiektu
	 *
	 * @return DostepneModulyMapper
	 */
	public static function wywolaj($zwracaTablice = false)
	{
		parent::$klasa = __CLASS__;
		return parent::wywolaj($zwracaTablice);
	}



	public function zaladujDane()
	{
		if ($dane = include(CMS_KATALOG.'/moduly.inc.php'))
		{
			$this->przetworzDane($dane);
			return true;
		}
		else
		{
			throw new MapperWyjatek('Nie mozna odczytac pliku zawierajacego dane dla '.get_class($this));
		}
	}



	public function pobierzPoKodzie($kod)
	{
		if (array_key_exists((string)$kod, $this->dane))
		{
			return $this->przetworzWynik($this->dane[$kod]);
		}
		else
		{
			return null;
		}
	}



	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$dane = $this->dane;

		if (isset($kryteria['kod']) && !empty($kryteria['kod']))
		{
			$kryteria['kod'] = (is_array($kryteria['kod'])) ? $kryteria['kod'] : array((string)$kryteria['kod']);
			$temp = $this->kolumnaRowna($dane, 'kod', (array)$kryteria['kod']);
			$dane = $temp;
			unset($temp);
		}
		if (isset($kryteria['typ']) && !empty($kryteria['typ']))
		{
			$kryteria['typ'] = (is_array($kryteria['typ'])) ? $kryteria['typ'] : array((string)$kryteria['typ']);
			$temp = $this->kolumnaRowna($dane, 'typ', (array)$kryteria['typ']);
			$dane = $temp;
			unset($temp);
		}
		if (isset($kryteria['usluga']) && !empty($kryteria['usluga']))
		{
			$temp = $this->kolumnaZawiera($dane, 'uslugi', (string)$kryteria['usluga']);
			$dane = $temp;
			unset($temp);
		}
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$temp = array();
			foreach ($dane as $klucz => $wiersz)
			{
				if (stripos($wiersz['kod'], $kryteria['fraza']) !== false
					|| stripos($wiersz['nazwa'], $kryteria['fraza']) !== false
					|| strpos($wiersz['opis'], $kryteria['fraza']) !== false
					)
				{
					$temp[$klucz] = $wiersz;
				}
			}
			$dane = $temp;
			unset($temp);
		}
		if (isset($kryteria['pomin']) && !empty($kryteria['pomin']))
		{
			foreach($kryteria['pomin'] as $kod)
			{
				unset($dane[$kod]);
			}
		}
		if (isset($kryteria['cache']))
		{
			$temp = array();
			$czyCache = (bool)$kryteria['cache'];
			foreach ($dane as $klucz => $wiersz)
			{
				if ($wiersz['cache'] == $czyCache) $temp[$klucz] = $wiersz;
			}
			$dane = $temp;
		}

		return $this->pobierzWiele($dane, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$dane = $this->dane;

		if (isset($kryteria['kod']) && !empty($kryteria['kod']))
		{
			$kryteria['kod'] = (is_array($kryteria['kod'])) ? $kryteria['kod'] : array((string)$kryteria['kod']);
			$temp = $this->kolumnaRowna($dane, 'kod', (array)$kryteria['kod']);
			$dane = $temp;
			unset($temp);
		}
		if (isset($kryteria['typ']) && !empty($kryteria['typ']))
		{
			$kryteria['typ'] = (is_array($kryteria['typ'])) ? $kryteria['typ'] : array((string)$kryteria['typ']);
			$temp = $this->kolumnaRowna($dane, 'typ', (array)$kryteria['typ']);
			$dane = $temp;
			unset($temp);
		}
		if (isset($kryteria['usluga']) && !empty($kryteria['usluga']))
		{
			$temp = $this->kolumnaZawiera($dane, 'uslugi', (string)$kryteria['usluga']);
			$dane = $temp;
			unset($temp);
		}
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$temp = array();
			foreach ($dane as $klucz => $wiersz)
			{
				if (stripos($wiersz['kod'], $kryteria['fraza']) !== false
					|| stripos($wiersz['nazwa'], $kryteria['fraza']) !== false
					|| strpos($wiersz['opis'], $kryteria['fraza']) !== false
					)
				{
					$temp[$klucz] = $wiersz;
				}
			}
			$dane = $temp;
			unset($temp);
		}
		if (isset($kryteria['pomin']) && !empty($kryteria['pomin']))
		{
			foreach($kryteria['pomin'] as $kod)
			{
				unset($dane[$kod]);
			}
		}
		if (isset($kryteria['cache']))
		{
			$temp = array();
			$czyCache = (bool)$kryteria['cache'];
			foreach ($dane as $klucz => $wiersz)
			{
				if ($wiersz['cache'] == $czyCache) $temp[$klucz] = $wiersz;
			}
			$dane = $temp;
		}

		return count($dane);
	}



	public function pobierzPoTypie($typ, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$typ = (is_array($typ)) ? $typ : array((string)$typ);
		$temp = $this->kolumnaRowna($this->dane, 'typ', $typ);

		return $this->pobierzWiele($temp, $pager, $sorter);
	}



	public function iloscPoTypie($typ)
	{
		$typ = (is_array($typ)) ? $typ : array((string)$typ);
		$temp = $this->kolumnaRowna($this->dane, 'typ', $typ);

		return count($temp);
	}



	public function pobierzDoPrzypisania(Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$temp = $this->kolumnaRowna($this->dane, 'typ', array('zwykly', 'jednorazowy', 'blok'));

		return $this->pobierzWiele($temp, $pager, $sorter);
	}



	public function pobierzPrzypisane($typ = '', Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$temp = $this->dane;

		$temp = $this->kolumnaRowna($temp, 'kod', (array)Cms::inst()->projekt->powiazaneModulyHttp);
		if (!empty($typ))
		{
			$temp = $this->kolumnaRowna($temp, 'typ', (array)$typ);
		}

		return $this->pobierzWiele($temp, $pager, $sorter);
	}



	public function iloscPrzypisane($typ = '')
	{
		$temp = $this->dane;

		if (!empty($typ))
		{
			$temp = $this->kolumnaRowna($temp, 'kod', (array)Cms::inst()->projekt->powiazaneModulyHttp);
			$temp = $this->kolumnaRowna($temp, 'typ', (array)$typ);
		}

		return count($temp);
	}



	public function pobierzWszystko(Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$temp = $this->dane;

		return $this->pobierzWiele($temp, $pager, $sorter);
	}



	public function iloscWszystko()
	{
		return count($this->dane);
	}

}

