<?php
namespace Generic\Model\EmailSzablon;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących szablony emaili.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Tablica
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\EmailSzablon\Obiekt';


	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'nazwa' => 'nazwa',
		'tresc_html' => 'trescHtml',
		'tresc_txt' => 'trescTxt',
		'aktywny' => 'aktywny',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id');



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
		$plikDanych = TEMP_KATALOG.'/emaile_szablony.inc.php';
		if ( ! is_file($plikDanych)) return false;
		$dane = @include($plikDanych);
		if ( ! is_array($dane)) return false;
		$this->przetworzDane($dane);
		return true;
	}



	public function zapiszDane()
	{
		$tresc = "<?php
namespace Generic\Model\EmailSzablon;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
 return " . var_export($this->dane, true) . ";";
		$zapisanoBajtow = file_put_contents(TEMP_KATALOG.'/emaile_szablony.inc.php', $tresc);
		return ($zapisanoBajtow !== false) ? true : false;
	}



	/**
	 * Zwraca szablon o podanym Id
	 * @param int $id
	 * @return EmailSzablon
	 */
	public function pobierzPoId($id)
	{
		if (array_key_exists((string)$id, $this->dane))
		{
			return $this->przetworzWynik($this->dane[$id]);
		}
		else
		{
			return null;
		}
	}



	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$dane = $this->zapytanieWyszukiwanie($kryteria, $this->dane);

		return $this->pobierzWiele($dane, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$dane = $this->zapytanieWyszukiwanie($kryteria, $this->dane);

		return count($dane);
	}



	protected function zapytanieWyszukiwanie($kryteria, $dane)
	{

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$temp = array();
			foreach ($dane as $klucz => $wiersz)
			{
				if (stripos($wiersz['nazwa'], $kryteria['fraza']) !== false
					|| stripos($wiersz['tresc_html'], $kryteria['fraza']) !== false
					|| strpos($wiersz['aktywny'], $kryteria['fraza']) !== false
					)
				{
					$temp[$klucz] = $wiersz;
				}
			}
			$dane = $temp;
			unset($temp);
		}
		if (isset($kryteria['aktywny']))
		{
			$temp = array();
			$czyCache = (bool)$kryteria['aktywny'];
			foreach ($dane as $klucz => $wiersz)
			{
				if ($wiersz['aktywny'] == $czyCache) $temp[$klucz] = $wiersz;
			}
			$dane = $temp;
		}

		return $dane;
	}
}

