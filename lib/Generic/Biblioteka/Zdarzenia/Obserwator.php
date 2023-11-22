<?php
namespace Generic\Biblioteka\Zdarzenia;
use Generic\Model;
use Generic\Biblioteka\Zdarzenia;


/**
 * Klasa bazowa dla wszystkich dla wszystkich uchwytow zdarzen
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

abstract class Obserwator
{

	/**
	 * Lista obslugiwanych typow zdarzen, domyslna wartosc "wszystkie" (wszystkie typy zdarzen)
	 * @var array
	 */
	protected $typyObslugiwanychZdarzen = array('wszystkie');


	/**
	 * Lista obslugiwanych kodow zdarzen, domyslna wartosc "wszystkie" (wszystkie zdarzenia)
	 * @var array
	 */
	protected $kodyObslugiwanychZdarzen = array();


	/**
	 * Ustawienia dla obserwatora
	 * @var array
	 */
	private $ustawienia;



	public function __construct(Model\Obserwator\Obiekt $obserwator)
	{
		if (count($obserwator->zdarzenia) > 0)
		{
			$this->kodyObslugiwanychZdarzen = array_values($obserwator->zdarzenia);
		}
		$this->ustawienia = $obserwator->ustawienia;
		$this->ustawieniaObserwatora($obserwator);
	}



	abstract protected function ustawieniaObserwatora(Model\Obserwator\Obiekt $obserwator);



	public function przechwycZdarzenie(Zdarzenia\Zdarzenie $zdarzenie)
	{
		if ($this->czyZdarzenieObslugiwane($zdarzenie))
		{
			$this->obsluzZdarzenie($zdarzenie);
		}
	}



	public function czyZdarzenieObslugiwane(Zdarzenia\Zdarzenie $zdarzenie)
	{
		/**
		 * W pierwszej kolejnosci sprawdzamy czy zdarzenie danego typu
		 * jest obslugiwane przez oserwator
		 */
		$typJestObslugiwany = false;
		
		if (in_array('wszystkie', $this->typyObslugiwanychZdarzen))
		{
			$typJestObslugiwany = true;
		}
		else
		{
			foreach ($this->typyObslugiwanychZdarzen as $typZdarzenia)
			{
				if ($zdarzenie instanceof $typZdarzenia) $typJestObslugiwany = true;
			}
		}
		if ( ! $typJestObslugiwany) return;

		/**
		 * Nastepnie sprawdzmy czy obserwator obsluguje zdarzenie o danym kodzie
		 */
		
		return (in_array('wszystkie', $this->kodyObslugiwanychZdarzen)
				|| in_array((string)$zdarzenie->pobierzKod(), $this->kodyObslugiwanychZdarzen));
	}



	protected function pobierzUstawienie($parametr)
	{
		return (isset($this->ustawienia[$parametr])) ? $this->ustawienia[$parametr] : null;
	}



	abstract protected function obsluzZdarzenie(Zdarzenia\Zdarzenie $zdarzenie);

}



