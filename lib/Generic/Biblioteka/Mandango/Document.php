<?php
namespace Generic\Biblioteka\Mandango;
use Generic\Biblioteka\Cms;

trait Document
{
	/**
	 * Ustawia wewnetrzna tablice z danymi na podstwie wiersza pobranego z bazy
	 *
	 * @param array $dane tablica z danymi pobranymi z bazy
	 * @return \Generic\ModelNosql\LogZdarzen
	 */
	public function wypelnij($dane = array())
	{
		return $this->setDocumentData($dane, true);
	}


	/**
	 * Przekazuje obiekt do zapisania w zrodle danych
	 *
	 * @return \Generic\ModelNosql\LogZdarzen
	 */
	public function zapisz()
	{
		$nazwaKlasy = get_class($this) . 'Repository';

		return Cms::inst()->Baza($nazwaKlasy::pobierzIdentyfikatorBazy())->zapisz($this);
	}


	/**
	 * Usuwa obiekt ze zrodla danych i czyści zawartosc wewnetrznych zmiennych
	 */
	public function usun()
	{
		$nazwaKlasy = get_class($this) . 'Repository';

		return Cms::inst()->Baza($nazwaKlasy::pobierzIdentyfikatorBazy())->usun($this);
	}

	/**
	 * Zwraca tablice z nazwami pol zmieninych podczas edycji obiektu.
	 *
	 * @return array
	 */
	public function zmodyfikowanePola()
	{
		return $this->getFieldsModified();
	}



	/**
	 * Zwraca tablice z polami i wartosciami pol obiektu.
	 *
	 * @return array
	 */
	public function daneDoZapisu()
	{
		return $this->getDocumentData();
	}
}
