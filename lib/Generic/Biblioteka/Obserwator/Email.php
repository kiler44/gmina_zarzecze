<?php
namespace Generic\Biblioteka\Obserwator;
use Generic\Biblioteka\Zdarzenia;
use Generic\Model\Obserwator;
use Generic\Biblioteka\Pomocnik;


/**
 * Klasa obserwatora wysyjaca maila na podstawie zdarzenia
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Email extends Zdarzenia\Obserwator
{

	private $idFormatki;


	protected function ustawieniaObserwatora(Obserwator\Obiekt $obserwator)
	{
		$this->idFormatki = (int)$obserwator->obiekt_docelowy;
	}



	protected function obsluzZdarzenie(Zdarzenia\Zdarzenie $zdarzenie)
	{
		if ($this->idFormatki > 0)
		{
			$poczta = new Pomocnik\Poczta($this->idFormatki, $zdarzenie->pobierzDane());
			$poczta->wyslij();
		}
	}

}