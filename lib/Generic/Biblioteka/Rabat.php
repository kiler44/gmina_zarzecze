<?php
namespace Generic\Biblioteka;
use Generic\Model\Produkt;


/**
 * Obsluga rabatów w systemie
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

abstract class Rabat
{


	public $etykieta = '';

	/**
	 * @var Produkt
	 */
	protected $produkt;

	protected $kwotaPoRabacie;
	protected $kwotaRabatu;
	protected $ilosc;

	protected $pozycjaNaFakture;

	protected $rabatObliczony = false;



	/**
	 * @param Produkt $produkt
	 */
	function ustawProdukt(Produkt\Obiekt $produkt)
	{
		$this->produkt = $produkt;
	}



	abstract public function oblicz();


	/**
	 * @return float
	 */
	public function pobierzKwoteRabatu()
	{
		if (! $this->rabatObliczony) $this->oblicz();
		return $this->kwotaRabatu;
	}


	/**
	 * @return float
	 */
	public function pobierzKwotePoRabacie()
	{
		if (! $this->rabatObliczony) $this->oblicz();
		return $this->kwotaPoRabacie;
	}


	/**
	 * @return array
	 */
	public function pobierzWiersz()
	{
		if (! $this->rabatObliczony) $this->oblicz();
		return array(
			'nazwa' => $this->etykieta,
			'cenaNetto' => -$this->kwotaRabatu,
			'stawkaVat' => $this->produkt->stawkaVat,
			'ilosc' => $this->ilosc,
		);
	}

}