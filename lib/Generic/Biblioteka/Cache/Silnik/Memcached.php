<?php
namespace Generic\Biblioteka\Cache\Silnik;
use Generic\Biblioteka\Cache;


/**
 * Obsluga cache z z memcache
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Memcached implements Cache\Silnik
{

	/**
	 * Obiekt memcached
	 * @var Memcached
	 */
	private $memcached;


	/**
	 * Czas w sekundach przez jaki ma byc przetrzymywany cache
	 * @var integer
	 */
	private $czas = 0;



	/**
	 * Czas w sekundach przez jaki ma byc przetrzymywany cache
	 * @var bool
	 */
	private $dostepny = false;



	public function __construct(Array $serwery)
	{
		$this->memcached = new \Memcached();

		foreach ($serwery as $serwer => $waga)
		{
			$serwer = explode(':', $serwer);
			$host = ($serwer[0] != '') ? (string)$serwer[1] : '127.0.0.1';
			$port = isset($serwer[1]) ? intval($serwer[1]) : 11211;

			$this->memcached->addServer($host, $port, $waga);
		}
		$statystykiSerwerow = $this->memcached->getStats();

		if (count($statystykiSerwerow) > 0) $this->dostepny = true;
	}



	public function dostepny()
	{
		return $this->dostepny;
	}



	public function ustawCzas($czas = 0)
	{
		$this->czas = (int)$czas;
	}



	public function pobierz($klucz)
	{
		return $this->memcached->get($klucz);
	}



	public function zapisz($klucz, $dane)
	{
		return $this->memcached->set($klucz, $dane, $this->czas);
	}



	public function usun($klucz)
	{
		return $this->memcached->delete($klucz);
	}



	public function istnieje($klucz)
	{
		$this->memcached->get($klucz);
		return ($this->memcached->getResultCode() == \Memcached::RES_NOTFOUND) ? false : true;
	}



	public function czysc()
	{
		return $this->memcached->flush();
	}

}
