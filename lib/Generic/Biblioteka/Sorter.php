<?php
namespace Generic\Biblioteka;


/**
 * Klasa obslugujaca sortowanie
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Sorter
{

	/**
	 * Tablica przetrzymujaca rodzaje sortowania
	 *
	 * @var array
	 */
	protected $_rodzaje = array();


	/**
	 * Domyslny rodzaj sortowania
	 *
	 * @var string
	 */
	protected $_domyslne;


	/**
	 * Wybrany rodzaj sortowania
	 *
	 * @var string
	 */
	private $_wybrany;


	/**
	 * Porządek sortowania: "ASC", "DESC"
	 *
	 * @var string
	 */
	private $_porzadek = 'ASC';


	/**
	 * Prefix (alias) dla pól
	 *
	 * @var string
	 */
	public $prefix = '';



	/**
	 * Ustawia podstawowe parametry sortera
	 *
	 * @param string $rodzaj Wybrany rodzaj sortowania (zbiór kolumn)
	 * @param string $porzadek Wybrany porządek sortowania (rosnace lub malejace)
	 */
	function __construct($rodzaj = null, $porzadek = null)
	{
		$rodzaj = strtolower(trim($rodzaj));

		if (array_key_exists($rodzaj, $this->_rodzaje))
		{
			$this->_wybrany = $rodzaj;
		}
		elseif ($rodzaj == 'random')
		{
			$this->_wybrany = 'random';
			$this->_rodzaje['random'] = array('');
		}
		elseif ($rodzaj === null)
		{
			$this->_wybrany = $this->_domyslne;
		}
		else
		{
			$this->_wybrany = $this->_domyslne;
			trigger_error('Nieprawidlowy rodzaj sortowania. Sorter ustawiony domyslnie.', E_USER_NOTICE);
		}

		$porzadek = strtoupper(trim($porzadek));
		if ($porzadek == 'ASC' || $porzadek == 'DESC')
		{
			$this->_porzadek = $porzadek;
		}
	}



	/**
	 * Zwraca wybrany rodzaj sortowania
	 *
	 * @return string
	 */
	function wybraneSortowanie()
	{
		return $this->_wybrany;
	}



	/**
	 * Zwraca kolumny powiązane z wybranym rodzajem sortowania
	 *
	 * @return array
	 */
	function wybraneKolumny()
	{
		return $this->_rodzaje[$this->_wybrany];
	}



	/**
	 * Zwraca wszystkie rodzaje sortowania
	 *
	 * @return array
	 */
	function mozliweKolumny()
	{
		return $this->_rodzaje;
	}


	/**
	 * Zwraca wybrany porządek sortowania
	 *
	 * @return string
	 */
	function wybranyPorzadek()
	{
		return $this->_porzadek;
	}



	/**
	 * Zwraca wybrany odwrotny porządek sortowania
	 *
	 * @return string
	 */
	function porzadekOdwrotny()
	{
		return ($this->_porzadek == 'ASC') ? 'DESC' : 'ASC';
	}

}
