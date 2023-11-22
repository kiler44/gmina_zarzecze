<?php
namespace Generic\Biblioteka\Cache;


/**
 * Interfejs dla silnikow cache
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
interface Silnik
{

	/**
	 * Sprawdza czy cache jest dostepny
	 * @return bool
	 */
	public function dostepny();



	/**
	 * Ustawienie czasu dla generowanego cache
	 * @param integer $czas Po ilu sekundach cache traci wazność
	 */
	public function ustawCzas($czas = 0);



	/**
	 * Zwraca tresc dla podanego klucza
	 *
	 * @param string $klucz Klucz w cache
	 * @return mixed
	 */
	public function pobierz($klucz);



	/**
	 * Zapisuje w cache dane przypisane do klucza
	 *
	 * @param string $klucz Klucz w cache
	 * @param mixed $dane Dane do zapisania w cache
	 *
	 * @return boolean
	 */
	public function zapisz($klucz, $dane);



	/**
	 * Usuwa dane przypisane do klucza z cache
	 *
	 * @param string $klucz Klucz w cache
	 *
	 * @return boolean
	 */
	public function usun($klucz);



	/**
	 * Sprawdza czy istnieje cache dla konkretnego klucza
	 * @param string $klucz
	 * @return bool
	 */
	public function istnieje($klucz);



	/**
	 * Czyści cały cache
	 *
	 * @return boolean
	 */
	public function czysc();

}
