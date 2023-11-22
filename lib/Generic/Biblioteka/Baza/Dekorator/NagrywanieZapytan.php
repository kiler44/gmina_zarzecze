<?php
namespace Generic\Biblioteka\Baza\Dekorator;
use Generic\Biblioteka\Baza;


/**
 * Obsluga nagrywania do pliku zapytan do bazy danych.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class NagrywanieZapytan extends Baza\Dekorator
{

	/**
	 * Przetrzymuje nazwe pliku loga.
	 *
	 * @var string
	 */
	private $plik = '';



	/**
	 * Przetrzymuje sformatowana tresc zapytan do zapisania w pliku.
	 *
	 * @var array
	 */
	private $zapytania = array();



	/**
	 * Konstruktor, przekazuje obiekt obslugujacy baze danych do wewnetrznej zmiennej.
	 *
	 * @param Baza $baza obiekt obslugujacy baze.
	 * @param string $plik plik do ktorego beda logowane zapytania.
	 */
	function __construct(Baza\Interfejs $baza, $plik)
	{
		parent::__construct($baza);
		$this->plik = (string)$plik;
	}



	/**
	 * Zapisuje zapytanie do wewnetrznej tablicy a następnie wysyła do bazy.
	 *
	 * @param string $sql zapytanie SQL.
	 */
	function zapytanie($sql)
	{
		$this->baza->zapytanie($sql);

		$test = substr(trim($sql), 0, 10);
		if (strpos($test, 'INSERT') !== false
			|| strpos($test, 'UPDATE') !== false
			|| strpos($test, 'DELETE') !== false
			|| strpos($test, 'REPLACE') !== false)
		{
			$this->zapytania[] = $sql;
		}
	}



	/**
	 * Destruktor, zapisuje wykonane zapytania do pliku loga
	 */
	function __destruct()
	{
		if (count($this->zapytania) > 0)
		{
			$tresc = '';
			foreach ($this->zapytania as $zapytanie)
				$tresc .= preg_replace('/[\s\n\t\r ]{1,}/' , ' ' ,$zapytanie).";\n";

			error_log($tresc, 3, $this->plik);
		}
	}

}
