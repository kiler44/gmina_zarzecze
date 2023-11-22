<?php
namespace Generic\Model\WierszKonfiguracji;
use Generic\Biblioteka;
use Generic\Biblioteka\Cms;


/**
 * Klasa obsługująca zapis i odczyt z cache dla obiektów odwzorowujących wiersze konfiguracji.
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 */
class MapperCache extends Biblioteka\Mapper\Tablica
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\WierszKonfiguracji\Obiekt';


	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_modulu' => 'kodModulu',
		'id_kategorii' => 'idKategorii',
		'id_bloku' => 'idBloku',
		'nazwa' => 'nazwa',
		'typ' => 'typ',
		'wartosc' => 'wartosc',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id', 'id_projektu');



	/**
	 * Zwraca instancje obiektu
	 *
	 * @return WierszKonfiguracjiMapperCache
	 */
	public static function wywolaj($zwracaTablice = false)
	{
		parent::$klasa = __CLASS__;
		return parent::wywolaj($zwracaTablice);
	}



	public function zaladujDane()
	{
		if ($dane = Cms::inst()->dane()->WierszKonfiguracji()->zwracaTablice()->pobierzPelna())
		{
			$this->przetworzDane($dane);
			return true;
		}
		return false;
	}



	function pobierzDlaSystemu()
	{
		$temp = array();
		foreach ($this->dane as $klucz => $wiersz)
		{
			if ($wiersz['kod_modulu'] === null && $wiersz['id_kategorii'] === null && $wiersz['id_bloku'] === null)
			{
				$temp[$klucz] = $wiersz;
			}
		}

		return $this->pobierzWiele($temp);
	}



	function pobierzDlaModulu($kodModulu, $idKategorii = null, $idBloku = null)
	{
		$dane = $this->kolumnaRowna($this->dane, 'kod_modulu', array($kodModulu));

		$temp = array();
		if (!empty($idKategorii) && empty($idBloku))
		{
			foreach ($dane as $klucz => $wiersz)
			{
				if (($wiersz['id_kategorii'] === null || (int)$wiersz['id_kategorii'] == (int)$idKategorii) && $wiersz['id_bloku'] === null)
				{
					$temp[$klucz] = $wiersz;
				}
			}
			masort($temp, 'id_kategorii');
			if (empty($temp[0])) unset($temp[0]);
		}
		else if (empty($idKategorii) && !empty($idBloku))
		{
			foreach ($dane as $klucz => $wiersz)
			{
				if (($wiersz['id_bloku'] === null || (int)$wiersz['id_bloku'] == (int)$idBloku) && $wiersz['id_kategorii'] === null)
				{
					$temp[$klucz] = $wiersz;
				}
			}
			masort($temp, 'id_bloku');
			if (empty($temp[0])) unset($temp[0]);
		}
		else
		{
			foreach ($dane as $klucz => $wiersz)
			{
				if ($wiersz['id_bloku'] === null && $wiersz['id_kategorii'] === null)
				{
					$temp[$klucz] = $wiersz;
				}
			}
		}
		$dane = $temp;
		unset($temp);

		return $this->pobierzWiele($dane);
	}

}
