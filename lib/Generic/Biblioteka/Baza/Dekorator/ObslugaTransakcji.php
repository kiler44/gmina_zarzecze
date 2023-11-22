<?php
namespace Generic\Biblioteka\Baza\Dekorator;
use Generic\Biblioteka\Baza;
use Generic\Biblioteka\Kontener;


/**
 * Obsluga rozpoczynania transakcji dla bazy danych
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */
class ObslugaTransakcji extends Baza\Dekorator
{



	/**
	 * Przetrzymuje kontener połączeń do baz danych
	 *
	 * @var Kontener_PolaczeniaBazDanych
	 */
	protected $kontenerPolaczen;



	/**
	 * Konstruktor, przekazuje obiekt obslugujacy baze danych do wewnetrznej zmiennej.
	 *
	 * @param Baza $baza obiekt obslugujacy baze.
	 * @param Kontener_PolaczeniaBazDanych $kontenerPolaczen Obiekt kontenera połączeń z bazą danych
	 */
	function __construct(Baza\Interfejs $baza, Kontener\PolaczeniaBazDanych $kontenerPolaczen)
	{
		parent::__construct($baza);
		$this->kontenerPolaczen = $kontenerPolaczen;
	}



	/**
	 * Zapisuje zapytanie do wewnetrznej tablicy a następnie wysyła do bazy.
	 *
	 * @param string $sql zapytanie SQL.
	 */
	function zapytanie($sql)
	{
		if ( ! $this->baza->czyPolaczenieAktywne())
		{
			$this->baza->polaczZBaza();
		}

		if ($this->kontenerPolaczen->czyTransakcjaRozpoczeta() && $this->czyTransakcjaPotrzebna($sql))
		{
			$this->kontenerPolaczen->transakcjaStartDlaPolaczenia($this->baza->pobierzIdentyfikator());
		}


		$this->baza->zapytanie($sql);
	}

	protected function czyTransakcjaPotrzebna($sql)
	{
		$test = substr(trim($sql), 0, 10);
		if (strpos($test, 'INSERT') !== false
			|| strpos($test, 'UPDATE') !== false
			|| strpos($test, 'DELETE') !== false
			|| strpos($test, 'REPLACE') !== false)
		{
			return true;
		}

		return false;
	}

}
