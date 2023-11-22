<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Plik;


class RozmiarPliku extends Walidator
{

	protected $trescBledow = array(
		'walidator_rozmiar_pliku_nieprawidlowy' => 'Plik ma niedozwoloną wielkość.'
	);

	private $dozwolonaWielkoscPliku;



	function __construct()
	{
		$this->dozwolonaWielkoscPliku = 100000;
	}



	function sprawdz($wartosc)
	{
		$plik = new Plik($wartosc);
		$info = $plik->info();
		if($info['size'] < $this->dozwolonaWielkoscPliku)
		{
			return true;
		}
		else
		{
			$this->ustawBlad('walidator_rozszerzenie_pliku_nieprawidlowe');
			return false;
		}
	}
}
