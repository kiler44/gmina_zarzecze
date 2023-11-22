<?php
namespace Generic\Biblioteka;

/**
 * Interfejs dla wszystkich polityk
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

abstract class Polityka
{
	/**
	 * @var Array
	 */
	protected $wymaganeParametry = array();


	/**
	 * Wykonuje algorytm polityki.
	 *
	 * @return mixed Wynik działania polityki
	 */
	public abstract function wykonaj();


	/**
	 * Zwraca parametry wymagane przez politykę
	 *
	 * @return Array
	 */
	public function pobierzWymaganeParametry()
	{
		return $this->wymaganeParametry;
	}
}
