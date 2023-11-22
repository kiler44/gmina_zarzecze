<?php
namespace Generic\Biblioteka;


/**
 * Klasa obslugujaca stronnicowanie
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Pager
{

	/**
	 * Zmienna przechowujaca ilosc elementow
	 *
	 * @var integer
	 */
	protected $_ilosc;


	/**
	 * Zmienna przechowujaca numer strony
	 *
	 * @var integer
	 */
	protected $_nrStrony;


	/**
	 * Zmienna przechowujaca ilosc elementow na stronie
	 *
	 * @var integer
	 */
	protected $_naStronie;


	/**
	 * Zmienna przechowujaca ilosc stron
	 *
	 * @var integer
	 */
	protected $_iloscStron;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Biblioteka\MenedzerPlikow
	 */
	protected $j;
	
	
	/**
	 * Konstruktor, ustawia partemetry poczatkowe pager-a.
	 *
	 * @param integer $ilosc Ilosc wszystkich elementow.
	 * @param integer $na_stronie Ilosc elementow na stronie.
	 * @param integer $nr_strony Numer bierzacej strony.
	 */
	public function __construct($ilosc, $na_stronie = 10, $nr_strony = 1)
	{
		$ilosc = abs(intval($ilosc));
		$na_stronie = abs(intval($na_stronie));
		$nr_strony = abs(intval($nr_strony));

		if ($ilosc > 0)
		{
			$na_stronie = ($na_stronie > 0) ? $na_stronie : 10;
			$ile_stron = ($na_stronie > 0) ? ceil($ilosc / $na_stronie) : ceil($ilosc / 10);
		}
		else
		{
			$na_stronie = 10;
			$ile_stron = 1;
		}
		if ($nr_strony < 1) $nr_strony = 1;
		if ($nr_strony > $ile_stron) $nr_strony = $ile_stron;

		$this->_ilosc = $ilosc;
		$this->_naStronie = $na_stronie;
		$this->_nrStrony = $nr_strony;
		$this->_iloscStron = $ile_stron;
	}



	/**
	 * Zwraca numer strony.
	 *
	 * @return integer
	 */
	public function nrStrony()
	{
		return $this->_nrStrony;
	}



	/**
	 * Zwraca ilosc elementow na stronie.
	 *
	 * @return integer
	 */
	public function naStronie()
	{
		return $this->_naStronie;
	}



	/**
	 * Zwraca ilosc stron.
	 *
	 * @return integer
	 */
	public function iloscStron()
	{
		return $this->_iloscStron;
	}



	/**
	 * Zwraca pierwszy element z bierzacej strony.
	 *
	 * @return integer
	 */
	public function pierwszyNaStronie()
	{
		return ($this->_nrStrony > 1) ? ((($this->_nrStrony - 1) * $this->_naStronie) + 1) : 1;
	}



	/**
	 * Zwraca pierwszy element z bierzacej strony.
	 *
	 * @return integer
	 */
	public function ostatniNaStronie()
	{
		$ostatni = $this->pierwszyNaStronie() + $this->_naStronie - 1;
		return ($ostatni > $this->_ilosc) ? $this->_ilosc : $ostatni;
	}

}
