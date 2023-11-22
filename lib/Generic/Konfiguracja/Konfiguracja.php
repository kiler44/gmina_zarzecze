<?php
namespace Generic\Konfiguracja;
use Generic\Biblioteka;

abstract class Konfiguracja implements Biblioteka\Konfiguracja\Interfejs
{
	/**
	 * Tablica dostępnych ustawien
	 *
	 * @var array
	 */
	public $k = array();


	/**
	 * Tablica opisów konfiguracji
	 *
	 * @var array
	 */
	public $opis = array();


	/**
	 * domyslne ustawienia konfiguracyjne
	 * @var array
	 */
	protected $konfiguracjaDomyslna = array();


	public function __construct()
	{
		$this->przetworzKonfiguracje();
	}


	/**
	 * Generuje konfiguracje i jej opisy na podstawie ustawionych danych.
	 */
	protected function przetworzKonfiguracje()
	{
		foreach ($this->konfiguracjaDomyslna as $klucz => $wartosc)
		{
			$this->k[$klucz] = $wartosc['wartosc'];
			unset($wartosc['wartosc']);
			$this->opis[$klucz] = $wartosc;
		}
	}

	/**
	 * Implementacja interfejsu Konfiguracja_Interfejs
	 */

	/**
	 * Zwraca tablice z konfiguracja dla modulu.
	 *
	 * @return array
	 */
	public function pobierzKonfiguracje()
	{
		return $this->k;
	}



	/**
	 * Ustawia nowa konfiguracje dla modulu.
	 *
	 * @param array $konfiguracja Tablica z konfiguracja dla modulu.
	 *
	 * @return boolean
	 */
	public function ustawKonfiguracje($konfiguracja)
	{
		$this->k = array_merge($this->k, $konfiguracja);
	}



	/**
	 * Zwraca tablice z opisem konfiguracji dla modulu.
	 *
	 * @return array
	 */
	public function pobierzOpisKonfiguracji()
	{
		return $this->opis;
	}
}
