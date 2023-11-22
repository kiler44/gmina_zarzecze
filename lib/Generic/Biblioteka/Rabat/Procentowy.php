<?php
namespace Generic\Biblioteka\Rabat;
use Generic\Biblioteka\Rabat;
use Generic\Model\Produkt;


/**
 * Obsluga rabatów procentowych
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */
class Procentowy extends Rabat
{

	private $procent;

	function __construct($etykieta, $procent, $ilosc = 1)
	{
		$this->etykieta = $etykieta;

		if ( ! ($procent > 0 && $procent < 100))
		{
			trigger_error('Nieprawidłowa wartość rabatu procentowego ('.$procent.')', E_USER_WARNING);
		}
		$this->procent = $procent;
		$this->ilosc = $ilosc;
	}


	public function oblicz()
	{
		if (! $this->produkt instanceof Produkt\Obiekt)
			throw new \Exception('Nie ustawiono produktu do rabatowania');

		$this->kwotaRabatu = $wartoscRabatuNetto = floatval($this->procent / 100) * $this->produkt->cenaNetto;
		$this->kwotaPoRabacie = $this->produkt->cenaNetto - $wartoscRabatuNetto;
		$this->rabatObliczony = true;
	}
}
