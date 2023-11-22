<?php
namespace Generic\Biblioteka\Mapper\Baza\Wersjonowana;
use Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odpowiedzialna za pobieranie i zapisywanie danych do bazy danych
 * Dodatkowo obsługuje wersjonowanie danych. Wersjonowanie odbywa się do
 * repozytorium w bazie NoSql.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class Nosql extends Biblioteka\Mapper\Baza\Wersjonowana implements Biblioteka\Mapper\Interfejs
{
	/**
	 * Konstruktor ustawia typ zwracanego obiektu i ustawia bazę danych
	 *
	 * @param boolean $zwracaTablice Czy wynik ma byc zwracany w postaci tablicy czy standardowo w postaci obiektu
	 */
	public function __construct($zwracaTablice = false)
	{
		parent::__construct($zwracaTablice);
		$this->bazaWersje = Cms::inst()->Baza($this->identyfikatorBazyWersje);
		$this->obiektPolaTabeli = array_flip($this->polaTabeliObiekt);
	}


	/**
	 * Zapisuje rekord w tabeli wersji. Podczas uzywania celowo nie obsługuję
	 * zwracanych parametrów - zapis do tabeli wersji może nie nastąpic, jednak
	 * podtrzymujemy dzialanie reszty systemu.
	 *
	 * @param Array $daneWersje
	 *
	 * @return boolean
	 */
	protected function zapiszWersje(Array $daneWersje, ObiektDanych $obiekt)
	{
		try
		{
			$nazwaMappera = $this->tabelaWersje;
			$obiektWersje = $this->dane()->$nazwaMappera()->pobierzNowyObiekt();
			foreach ($daneWersje as $klucz => $wartosc)
			{
				if ($klucz == 'id')
				{
					continue;
				}

				$klucz = $this->polaTabeliObiekt[$klucz];

				$obiektWersje->$klucz = $wartosc;
			}

			if (isset($daneWersje['id']))
			{
				$obiektWersje->idObiektu = $daneWersje['id'];
			}

			if (Cms::inst()->profil() != null)
			{
				$obiektWersje->idTworzacegoWersje = Cms::inst()->profil()->id;
			}

			$obiektWersje->dataWersji = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);

			$obiektWersje->zapisz();

		}
		catch (\Exception $wyjatek)
		{
			trigger_error('Nie mozna zapisac danych obiektu wersji '.get_class ($obiekt).' w bazie '. $this->identyfikatorBazyWersje .'.');
			return false;
		}
		return true;
	}

}
