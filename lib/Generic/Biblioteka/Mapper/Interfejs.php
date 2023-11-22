<?php
namespace Generic\Biblioteka\Mapper;
use Generic\Biblioteka\ObiektDanych;


/**
 * Interfejs dla klas odpowiedzialnych za pobieranie i zapisywanie danych do zrodla danych
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

interface Interfejs
{

	/**
	 * Ustawia typ zwracanego obiektu na tablice i zwraca instancja obiektu z hierarchii Mapper
	 *
	 * @param array $kolumny Kolumny ktore powinny byc pobierane w trybie tablicowym
	 *
	 * @return Mapper
	 */
	public function zwracaTablice($kolumny = array());



	/**
	 * Ustawia typ zwracanego obiektu na obiekt i zwraca instancja obiektu z hierarchii Mapper
	 *
	 * @return Mapper
	 */
	public function zwracaObiekt();



	/**
	 * Dodaje nowy obiekt do zrodla danych i zwraca identyfikator utworzonego rekordu
	 *
	 * @param ObiektDanych $obiekt Zapisywany obiekt
	 *
	 * @return integer
	 */
	public function wstaw(ObiektDanych $obiekt);



	/**
	 * Uaktualnia rekord w zrodle danych
	 *
	 * @param ObiektDanych $obiekt Zapisywany obiekt
	 *
	 * @return boolean
	 */
	public function aktualizuj(ObiektDanych $obiekt);



	/**
	 * Usuwa obiekt z zrodla danych
	 *
	 * @param ObiektDanych $obiekt zapisywany obiekt
	 *
	 * @return boolean
	 */
	public function usun(ObiektDanych $obiekt);

}

