<?php
namespace Generic\Biblioteka\Kontener;
use Generic\Biblioteka\Kontener;
use Generic\Biblioteka\Baza;


/**
 * Kontener przetrzymujący i zwracający instancje połączeń do baz danych
 * oraz zarządzający nakładaniem transakcji na poszczególne połączenia.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class PolaczeniaBazDanych extends Kontener
{

	/**
	 * @var bool
	 */
	protected $transakcjaRozpoczeta = false;


	/**
	 * @var array
	 */
	protected $bazyRozpoczeteTransakcje = array();

	/**
	 * Wstawia obiekt połączenia z bazą danych do kontenera
	 *
	 * @param string $identyfikatorBazy Nazwa połaczenia z bazą danych
	 * @param Baza_Interfejs $obiekt Obiekt połaczenia z bazą danych
	 *
	 * @return object
	 */
	public function wstaw($identyfikatorBazy, Baza\Interfejs $obiekt)
	{
		if ( ! isset($this->instancje[$identyfikatorBazy]))
		{
			$this->instancje[$identyfikatorBazy] = $obiekt;
		}
		return $this->instancje[$identyfikatorBazy];
	}

	/**
	 * Wstawia obiekt połączenia z bazą NoSql danych do kontenera
	 *
	 * @param string $identyfikatorBazy Nazwa połaczenia z bazą danych
	 * @param Baza_Interfejs $obiekt Obiekt połaczenia z bazą danych
	 *
	 * @return object
	 */
	public function wstawNoSql($identyfikatorBazy, \Generic\Biblioteka\BazaMongo $obiekt)
	{
		if ( ! isset($this->instancje[$identyfikatorBazy]))
		{
			$this->instancje[$identyfikatorBazy] = $obiekt;
		}
		return $this->instancje[$identyfikatorBazy];
	}


	/**
	 * Rozpoczyna transakcje w wielu bazach
	 *
	 * @return boolean
	 */
	public function transakcjaStart()
	{
		if ( ! $this->transakcjaRozpoczeta)
		{
			$this->transakcjaRozpoczeta = true;
			$this->bazyRozpoczeteTransakcje = array();
		}
		else
		{
			trigger_error('Można rozpocząć tylko jedną transakcję sysytemową na raz.');
		}

		return true;
	}


	/**
	 * Cofa transakcje w wielu bazach
	 *
	 * @return boolean
	 */
	public function transakcjaCofnij()
	{
		if ($this->transakcjaRozpoczeta)
		{
			foreach ($this->bazyRozpoczeteTransakcje as $identyfikatorBazy)
			{
				if (isset($this->instancje[$identyfikatorBazy]))
				{
					$this->instancje[$identyfikatorBazy]->transakcjaCofnij();
				}
			}
			$this->transakcjaRozpoczeta = false;
		}
		else
		{
			trigger_error('Transakcja systemowa nie została rozpoczęta');
		}

		return true;
	}


	/**
	 * Potwierdza transakcje w wielu bazach
	 *
	 * @return boolean
	 */
	public function transakcjaPotwierdz()
	{
		if ($this->transakcjaRozpoczeta)
		{
			foreach ($this->bazyRozpoczeteTransakcje as $identyfikatorBazy)
			{
				if (isset($this->instancje[$identyfikatorBazy]))
				{
					$this->instancje[$identyfikatorBazy]->transakcjaPotwierdz();
				}
			}
			$this->transakcjaRozpoczeta = false;
		}
		else
		{
			trigger_error('Transakcja systemowa nie została rozpoczęta');
		}

		return true;
	}


	public function czyTransakcjaRozpoczeta()
	{
		return $this->transakcjaRozpoczeta;
	}

	public function transakcjaStartDlaPolaczenia($identyfikatorBazy)
	{
		if ( ! in_array($identyfikatorBazy, $this->bazyRozpoczeteTransakcje) && isset($this->instancje[$identyfikatorBazy]))
		{
			$this->instancje[$identyfikatorBazy]->transakcjaStart();
			$this->bazyRozpoczeteTransakcje[] = $identyfikatorBazy;
		}
	}

}
