<?php
namespace Generic\Biblioteka\Mapper;


/**
 * Abstrakcyjna klasa odpowiedzialna za obsługę mechanizmu tzw. "dziedziczonego singleton-a"
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

abstract class Singleton
{

	/**
	 * Nazwa klasy dla Singleton-a. Bedzie zmieniana klasach dziedziczacych;
	 *
	 * @var string
	 */
	protected static $klasa = __CLASS__;


	/**
	 * Przechowuje instancje Singleton-a.
	 *
	 * @var Mapper_Singleton
	 */
	protected static $instancje = array();



	/**
	 * Konstruktor do użytku wewnętrznego.
	 */
	protected function __construct() {}



	/**
	 * Zwraca instancje Singleton-a
	 *
	 * @return Mapper_Singleton
	 */
	public static function wywolaj()
	{
		$klasa = self::pobierzKlase();

		if (!isset(self::$instancje[$klasa]) ||
			!(self::$instancje[$klasa] instanceof $klasa))
		{
			self::$instancje[$klasa] = new $klasa();
		}
		self::$instancje[$klasa]->inicjuj();
		return self::$instancje[$klasa];
	}



	/**
	 * Zwraca nazwe klasy.
	 *
	 * @return string
	 */
	private static function pobierzKlase()
	{
		$bierzacaKlasa = self::$klasa;
		$oryginalnaKlasa = __CLASS__;
		if ($bierzacaKlasa === $oryginalnaKlasa)
		{
			throw new \Exception('Nie dodales lini <code>self::$klasa = __CLASS__;</code> w metodzie wywolaj() w klasie ktora wywolujesz');
		}
        
		return $bierzacaKlasa;
	}

}
