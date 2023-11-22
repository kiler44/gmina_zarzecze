<?php
namespace Generic\Model\KanalRss;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących wpisy kanałów rss.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Tablica
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = '';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'url' => 'url',
		'tytul' => 'tytul',
		'opis' => 'opis',
		'data_dodania'=> 'dataDodania',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('url');



	/**
	 * Lista adresow url kanalow rss
	 * @var array
	 */
	public $kanaly = array();



	/**
	 * Plik przetrzymujacy cache kanalow
	 * @var string
	 */
	public $plikCache = '';



	/**
	 * Zwraca instancje obiektu
	 *
	 * @return KanalyRssMapper
	 */
	public static function wywolaj($zwracaTablice = false)
	{
		parent::$klasa = __CLASS__;
		$zwracaTablice = TRUE; //zawsze zwraca tablice
		return parent::wywolaj($zwracaTablice);
	}



	public function zaladujDane()
	{
		$dane = (is_file($this->plikCache)) ? include($this->plikCache) : array();

		if (is_array($dane) && count($dane) > 0)
		{
			$this->przetworzDane($dane);
		}
		elseif (is_array($this->kanaly) && count($this->kanaly) > 0)
		{
			$dane = array();
			foreach ($this->kanaly as $urlKanalu)
			{
				$xml = simplexml_load_file($urlKanalu);
				if ($xml instanceof \SimpleXMLElement)
				{
					foreach ($xml->channel->item as $item)
					{
						$wpis = array();
						$wpis['url'] = (string)trim($item->link);
						$data = new \DateTime(trim($item->pubDate));
						$wpis['data_dodania'] = (string)$data->format('Y-m-d H:i:s');
						$wpis['tytul'] = (string)trim($item->title);
						$wpis['opis'] = (string)trim(strip_tags($item->description));
						$dane[] = $wpis;
					}
				}
			}
			if (count($dane) > 0 && is_dir(dirname($this->plikCache)))
			{
				file_put_contents($this->plikCache, "<?php
namespace Generic\Model\KanalRss;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;

\nreturn ".var_export($dane, true)."\n;\n");
			}
			$this->przetworzDane($dane);
		}
		return true;
	}



	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$dane = $this->dane;

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$temp = array();
			foreach ($dane as $klucz => $wiersz)
			{
				if (stripos($wiersz['tytul'], $kryteria['fraza']) !== false
					|| strpos($wiersz['opis'], $kryteria['fraza']) !== false
					)
				{
					$temp[$klucz] = $wiersz;
				}
			}
			$dane = $temp;
			unset($temp);
		}
		if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '')
		{
			$data = new \DateTime("now", new \DateTimeZone('Europe/Warsaw'));
			$data->modify('+'.abs((int)trim($kryteria['data_dodania'])).' days');
			$data = $data->format('Y-m-d H:i:s');

			$temp = array();
			foreach ($dane as $klucz => $wiersz)
			{
				if ($wiersz['data_dodania'] > $data)
				{
					$temp[$klucz] = $wiersz;
				}
			}
			$dane = $temp;
		}

		return $this->pobierzWiele($dane, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$dane = $this->dane;

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$temp = array();
			foreach ($dane as $klucz => $wiersz)
			{
				if (stripos($wiersz['tytul'], $kryteria['fraza']) !== false
					|| strpos($wiersz['opis'], $kryteria['fraza']) !== false
					)
				{
					$temp[$klucz] = $wiersz;
				}
			}
			$dane = $temp;
			unset($temp);
		}
		if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '')
		{
			$data = new \DateTime("now", new \DateTimeZone('Europe/Warsaw'));
			$data->modify('+'.abs((int)trim($kryteria['data_dodania'])).' days');
			$data = $data->format('Y-m-d H:i:s');

			$temp = array();
			foreach ($dane as $klucz => $wiersz)
			{
				if ($wiersz['data_dodania'] > $data)
				{
					$temp[$klucz] = $wiersz;
				}
			}
			$dane = $temp;
		}

		return count($dane);
	}

}

