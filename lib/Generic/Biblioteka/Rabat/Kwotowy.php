<?php
namespace Generic\Biblioteka\Rabat;
use Generic\Biblioteka\Rabat;
use Generic\Model\Produkt;


/**
 * Obsluga rabatów kwotowych
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */
class Kwotowy extends Rabat
{

	private $wartosc;

	function __construct($etykieta, $wartosc, $ilosc = 1)
	{
		$this->etykieta = $etykieta;

		if ( ! $wartosc < 0)
		{
			trigger_error('Nieprawidłowa wartość rabatu kwotowego ('.$procent.')', E_USER_WARNING);
		}
		$this->wartosc = $wartosc;
		$this->ilosc = $ilosc;
	}


	public function oblicz()
	{
		if (! $this->produkt instanceof Produkt\Obiekt)
			throw new \Exception('Nie ustawiono produktu do rabatowania');

		$this->kwotaRabatu = $wartoscRabatuNetto = $this->wartosc;
		$this->kwotaPoRabacie = $this->produkt->cenaNetto - $wartoscRabatuNetto;
		$this->rabatObliczony = true;
	}
}
