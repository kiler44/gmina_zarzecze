<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Okruszki;


/**
 * Singleton przetrzymujący tzw. "Okruszki" (Bredcrumb)
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
final class Okruszki
{

	/**
	 * Przechowuje instancję klasy Singleton
	 *
	 * @var object
	 * @access private
	 */
	private static $_instancja = false;


	/**
	 * Przwchowuje informacje czy sciezka ma byc zresetowana
	 * domyslnie: false
	 *
	 * @var boolean
	 * @access private
	 */
	private $_resetuj = false;


	/**
	 * Tablica przetrzymująca okruszki
	 *
	 * @var array
	 * @access private
	 */
	private $_okruszki = array();



	private function __construct()
	{
		Okruszki::$_instancja = $this;
	}



	/**
	 * Zwraca instancje klasy
	 *
	 * @return Okruszki
	 */
	static public function wywolaj()
	{
		if (self::$_instancja === false)
		{
			self::$_instancja = new Okruszki();
		}
		return self::$_instancja;
	}



	/**
	 * Dodaje element do tablicy okruszków
	 *
	 * @param string $url Url dodawanego elementu
	 * @param string $etykieta Etykieta dodawanego elementu
	 *
	 * @return Okruszki
	 */
	public function dodaj($url, $etykieta)
	{
		$this->_okruszki[] = array('url' => $url, 'etykieta' => $etykieta);
		return self::$_instancja;
	}



	/**
	 * Zwraca tablice okruszków
	 *
	 * @return array
	 */
	public function pobierz()
	{
		return $this->_okruszki;
	}



	/**
	 * Czysci tablice okruszków
	 *
	 * @return Okruszki
	 */
	public function czysc()
	{
		$this->_okruszki = array();
		return self::$_instancja;
	}



	/**
	 * Resetuje sciezke
	 *
	 * @return Okruszki
	 */
	public function resetujSciezkeSerwisu()
	{
		$this->_resetuj = true;
		return self::$_instancja;
	}



	/**
	 *Spradza czy resetowac sciezke serwisu
	 *
	 * @return type
	 */
	public function czyResetowacSciezkeSerwisu()
	{
		return  $this->_resetuj;
	}

}
