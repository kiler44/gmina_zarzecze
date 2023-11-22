<?php
namespace Generic\Biblioteka\Polityka;
use Generic\Model;
use Generic\Biblioteka\Polityka;

/**
 * Interfejs dla wszystkich polityk
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

abstract class Produkt extends Polityka
{
	/**
	 * @var Generic\Model\Produkt\Obiekt
	 */
	protected $produktGlowny = null;


	/**
	 * @var Generic\Model\Klient\Obiekt
	 */
	protected $klient = null;


	/**
	 * Ustawia główny produkt polityki
	 * @param Generic\Model\Produkt\Obiekt $produkt
	 *
	 * @return Generic\Biblioteka\Polityka\Produkt
	 */
	public function ustawProduktGlowny(Model\Produkt\Obiekt $produkt)
	{
		$this->produktGlowny = $produkt;

		return $this;
	}


	/**
	 * Ustawia klienta, dla ktorego będzie wykonan polityka
	 * @param Generic\Model\Klient\Obiekt $produkt
	 *
	 * @return Generic\Biblioteka\Polityka\Produkt
	 */
	public function ustawKlienta(Generic\Model\Klient\Obiekt $klient)
	{
		$this->klient = $klient;

		return $this;
	}
}
