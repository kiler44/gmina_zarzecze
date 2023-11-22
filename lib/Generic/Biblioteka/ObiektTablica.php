<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\TablicaObiektWyjatek;
use Generic\Biblioteka\ObiektTablica;


/**
 * Obiekt zachowujacy sie jak typowy obiekt i jednoczesnie jak tablica
 *
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class ObiektTablica implements \ArrayAccess, \Countable, \Iterator
{

	/**
	 * Okresla czy pozwolic na modyfikacje
	 *
	 * @var boolean
	 */
	protected $_allowModifications;



	/**
	 * Bierzacy element
	 *
	 * @var integer
	 */
	protected $_index;



	/**
	 * Liczba elementow w wewnetrznej tablicy
	 *
	 * @var integer
	 */
	protected $_count;



	/**
	 * Tablica zawierajaca dane
	 *
	 * @var array
	 */
	protected $_array = array();



	/**
	 * Konstruktor.
	 *
	 * @param array $array tablica do zaladowania do klasy.
	 * @param boolean $allowModifications okresla czy pozwolic na modyfikacje.
	 */
	public function __construct(array $array = array(), $allowModifications = true)
	{
		$this->_allowModifications = (boolean) $allowModifications;
		$this->_index = 0;
		foreach($array as $key => $value)

		if (is_array($value))
		{
			$this->_array[$key] = new self($value);
		}
		else
		{
			$this->_array[$key] = $value;
		}
		$this->_count = count($this->_array);
	}



	/**
	 * Definiowana w interfejsie ArrayAccess
	 *
	 * @param $key klucz tablicy
	 * @return boolean
	 */
	public function offsetExists($key)
	{
		return array_key_exists($key, $this->_array);
	}



	/**
	 * Definiowana w interfejsie ArrayAccess
	 *
	 * @param $key klucz tablicy
	 *
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->_array[$key];
	}



	/**
	 * Definiowana w interfejsie ArrayAccess
	 *
	 * @param $key klucz tablicy
	 * @param $value wartosc tablicy
	 */
	public function offsetSet($key, $value)
	{
		if ($this->_allowModifications)
		{
			if (is_array($value))
			{
				$this->_array[$key] = new self($value, true);
			}
			else
			{
				$this->_array[$key] = $value;
			}

			$this->_count = count($this->_array);
		}
		else
		{
			throw new TablicaObiektWyjatek('Obiekt zostal ustawiony tylko do odczytu');
		}
	}



	/**
	 * Definiowana w interfejsie ArrayAccess
	 *
	 * @param $key klucz tablicy
	 */
	public function offsetUnset($key)
	{
		unset($this->_array[$key]);
	}



	/**
	 * Dostep obiektowy do tablicy
	 *
	 * @param $key klucz tablicy
	 *
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->_array[$key];
	}


	/**
	 * Dostep obiektowy do tablicy
	 *
	 * @param $key klucz tablicy
	 * @param $value wartosc tablicy
	 */
	public function __set($key, $value)
	{
		if ($this->_allowModifications)
		{
			if (is_array($value))
			{
				$this->_array[$key] = new self($value, true);
			}
			else
			{
				$this->_array[$key] = $value;
			}
			$this->_count = count($this->_array);
		}
		else
		{
			throw new TablicaObiektWyjatek('Obiekt zostal ustawiony tylko do odczytu');
		}
	}



	/**
	 * Dostep obiektowy do tablicy
	 *
	 * @param $key klucz tablicy
	 *
	 * @return mixed
	 */
	public function __isset($key)
	{
		return isset($this->_array[$key]);
	}



	/**
	 * Dostep obiektowy do tablicy
	 *
	 * @param $key klucz tablicy
	 *
	 * @return boolean
	 */
	public function __unset($key)
	{
		unset($this->_array[$key]);
	}


	/**
	 * Klonowanie instancji obiektu z upewnieniem sie ze wewnetrzne obiekty tez sa klonowane
	 */
	public function __clone()
	{
		$array = array();
		foreach($this->_array as $key => $value)
		{
			if ($value instanceof ObiektTablica)
			{
				$array[$key] = clone $value;
			}
			else
			{
				$array[$key] = $value;
			}
		}

		$this->_array = $array;
	}



	/**
	 * Zwtaca tablice z wartosciami zapisanymi wewnatrz obiektu.
	 *
	 * @return array
	 */
	public function toArray()
	{
		$array = array();
		foreach($this->_array as $key => $value)
		{
			if ($value instanceof ObiektTablica)
			{
				$array[$key] = $value->toArray();
			}
			else
			{
				$array[$key] = $value;
			}
		}

		return $array;
	}



	/**
	 * Blokuje mozliwosc dalszego zapisu do obiektu
	 */
	public function ustawTylkoDoOdczytu()
	{
		$this->_allowModifications = false;
	}



	/**
	 * Definiowana w interfejsie Countable
	 *
	 * @return integer
	 */
	public function count()
	{
		return $this->_count;
	}



	/**
	 * Definiowana w interfejsie Iterator
	 *
	 * @return mixed
	 */
	public function current()
	{
		return current($this->_array);
	}



	/**
	 * Definiowana w interfejsie Iterator
	 *
	 * @return mixed
	 */
	public function key()
	{
		return key($this->_array);
	}



	/**
	 * Definiowana w interfejsie Iterator
	 */
	public function next()
	{
		next($this->_array);
		$this->_index++;
	}



	/**
	 * Definiowana w interfejsie Iterator
	 */
	public function rewind()
	{
		reset($this->_array);
		$this->_index = 0;
	}



	/**
	 * Definiowana w interfejsie Iterator
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return $this->_index < $this->_count;
	}

}

class TablicaObiektWyjatek extends \Exception {}


