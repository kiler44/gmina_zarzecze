<?php
namespace Generic\Biblioteka\Zdarzenia;
use Generic\Model\Obserwator;
use Generic\Biblioteka\Zdarzenia;


/**
 * Menedzer zdarzen odpowiedzialny za obsługę i kojarzenie zdarzenia i uchwytu
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Menedzer
{

	protected static $obserwatory = array();


	protected static $obserwatoryZaladowane = false;



	public function __construct()
	{

		if (static::$obserwatoryZaladowane === false)
		{
			$this->ladujObserwatory();
			static::$obserwatoryZaladowane = true;

		}
	}



	protected function ladujObserwatory()
	{
		$mapper = Obserwator\Mapper::wywolaj();
		foreach ($mapper->pobierzWszystko() as $obserwator)
		{
			$this->dodajObserwator($obserwator);
		}

		$obserwatorRaport = new Obserwator\Obiekt(array(
			'id' => 0,
			'opis' => 'Raport',
			'typ' => 'DoPlikuRaport',
			'obiekt_docelowy' => 'Raport',
			'zdarzenia' => array(),
			'ustawienia' => array(),
		));
		$this->dodajObserwator($obserwatorRaport);

		$obserwatorCache = new Obserwator\Obiekt(array(
			'id'=> 0,
			'opis' => 'Czyszczenie cache',
			'typ' => 'CacheWizytowki',
			'obiekt_docelowy' => 'Usuń cache',
			'zdarzenia' => array(),
			'ustawienia' => array(),
		));
		$this->dodajObserwator($obserwatorCache);
		
		$obserwatorMongo = new Obserwator\Obiekt(array(
			'id'=> 0,
			'opis' => 'Logowanie zdarzen',
			'typ' => 'DoBazyNosql',
			'obiekt_docelowy' => 'LogZdarzen',
			'zdarzenia' => array(),
			'ustawienia' => array(),
		));
		$this->dodajObserwator($obserwatorMongo);

	}



	public function dodajObserwator(Obserwator\Obiekt $obserwator)
	{
		$nazwaObserwatora = 'Generic\\Biblioteka\\Obserwator\\' . $obserwator->typ;
		static::$obserwatory[] = new $nazwaObserwatora($obserwator);
	}



	public function przechwycZdarzenie(Zdarzenia\Zdarzenie $zdarzenie)
	{
		foreach (static::$obserwatory as $obserwator)
		{
			$obserwator->przechwycZdarzenie($zdarzenie);
		}
	}

}
