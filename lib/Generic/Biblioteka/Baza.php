<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\BazaWyjatek;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka;


/**
 * Obsluga bazy danych.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Baza implements Biblioteka\Baza\Interfejs
{

	/**
	 * Przetrzymuje obiekt polaczenia z baza danych.
	 *
	 * @var PDO
	 */
	private $pdo;



	/**
	 * Przetrzymuje wynik zapytania do bazy danych.
	 *
	 * @var PDOStatement
	 */
	private $pdoSt;



	/**
	 * Czas wykonywania ostatniego zapytania.
	 *
	 * @var float
	 */
	private $czas;



	/**
	 * Przetrzymuje liczbę rozpoczętych transakcji w bazie.
	 *
	 * @var integer
	 */
	protected $licznikTransakcji = 0;



	/**
	 * Przetrzymuje identyfikator bazy danych z konfiguracji
	 *
	 * @var string
	 */
	protected $identyfikatorBazy = 'domyslna';



	/**
	 * Przetrzymuje konfigurację bazy
	 *
	 * @var array
	 */
	protected $config = array();



	/**
	 * Konstruktor, nawiazuje polaczenie z baza danych.
	 *
	 * @param array $config tablica z konfiguracja bazy danych.
	 * @param $laczenieAutomatyczne czy łączyć automatycznie
	 */
	public function __construct($config = array(), $laczenieAutomatyczne = true)
	{
		$this->config = $config;

		if ($laczenieAutomatyczne)
		{
			$this->polaczZBaza();
		}
	}


	/**
	 * Sprawdza czy połaczenie jest aktywne
	 *
	 * @return bool
	 */
	public function czyPolaczenieAktywne()
	{
		return ($this->pdo instanceof \PDO);
	}


	/**
	 * Łączy z bazą danych
	 *
	 */
	public function polaczZBaza()
	{
		if ( ! $this->czyPolaczenieAktywne())
		{
			try
			{
				if (empty($this->config['db_driver']) || empty($this->config['db_host']) ||
					empty($this->config['db_name']) || empty($this->config['db_user']) ||
					empty($this->config['db_password']))
				{
					throw new \PDOException('Nieprawidlowa konfiguracja bazy danych.');
				}
				$this->pdo = new \PDO($this->config['db_driver'].':host='.$this->config['db_host'].';port='.$this->config['db_port'].';dbname='.$this->config['db_name'], $this->config['db_user'], $this->config['db_password']);
				$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
				$this->pdo->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_NATURAL);
				$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
				$this->pdo->setAttribute(\PDO::ATTR_PERSISTENT, TRUE);
				
				if ($this->config['db_driver'] == 'mysql')
				{
					$this->pdo->exec('SET NAMES utf8');
					$this->pdo->exec('SET CHARACTER SET utf8');
					$this->pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
				}
				if ($this->config['identyfikator_bazy'] != '')
				{
					$this->identyfikatorBazy = $this->config['identyfikator_bazy'];
				}
			}
			catch (\PDOException $wyjatek)
			{
				trigger_error($wyjatek->getMessage(), E_USER_WARNING);
				//throw new BazaWyjatek('Nie mozna polaczyc z baza danych.');
			}
		}
		else
		{
			trigger_error('Połączenie z bazą danych zostało już nawiązane.');
		}

	}


	/**
	 * Wysyla zapytanie SQL do bazy danych i zachowuje rezultat w postaci obiektu klasy PDOStatement.
	 *
	 * @param string $sql zapytanie SQL.
	 */
	public function zapytanie($sql)
	{
		try
		{
			$this->czas = 0;
			$start = microtime(true);
			$this->pdoSt = $this->pdo->query($sql);
			$this->czas = microtime(true) - $start;
		}
		catch (\PDOException $wyjatek)
		{
			trigger_error($wyjatek->getMessage(), E_USER_WARNING);
			throw new BazaWyjatek('Blad podczas wykonywania zapytania w bazie danych.');
		}
	}



	/**
	 * Zwraca czas wykonywania ostatniego zapytania w sekundach i mikrosekuntach po przecinku
	 *
	 * @param integer $dokladnosc ile miejsc po przecinku wyswietlic.
	 *
	 * @return float
	 */
	public function czasZapytania($dokladnosc = 0)
	{
		if ((int)$dokladnosc > 0)
		{
			return round($this->czas, $dokladnosc);
		}
		else
		{
			return $this->czas;
		}
	}



	/**
	 * Pobiera wiersz w wyniku zapytania i zwraca w postaci tablicy asocjacyjnej.
	 *
	 * @return array
	 */
	public function pobierzWynik()
	{
		try
		{
			return $this->pdoSt->fetch(\PDO::FETCH_ASSOC);
		}
		catch (\PDOException $wyjatek)
		{
			trigger_error($wyjatek->getMessage(), E_USER_WARNING);
			//throw new BazaWyjatek('Nie mozna pobrac danych z bazy.');
		}
	}



	/**
	 * Rozpoczyna transakcje w bazie
	 *
	 * @return boolean
	 */
	public function transakcjaStart()
	{
		if ($this->licznikTransakcji == 0)
		{
			$res = $this->pdo->beginTransaction();
			if ($res) $this->licznikTransakcji++;
			return $res;
		}
		else
		{
			$this->licznikTransakcji++;
			return true;
		}
	}



	/**
	 * Potwierdza zapisanie zmian dokonanych w transakcji.
	 *
	 * @return boolean
	 */
	public function transakcjaPotwierdz()
	{
		$this->licznikTransakcji--;

		if ($this->licznikTransakcji <= 0)
		{
			$this->licznikTransakcji = 0;
			return $this->pdo->commit();
		}

		return true;
	}



	/**
	 * Anuluje zapisanie zmian dokonanych w transakcji.
	 *
	 * @return boolean
	 */
	public function transakcjaCofnij()
	{
		$this->licznikTransakcji--;

		if ($this->licznikTransakcji <= 0)
		{
			$this->licznikTransakcji = 0;
			return $this->pdo->rollBack();
		}

		return true;
	}



	/**
	 * Pisze zapytanie SQL SELECT i zwraca jego tresc
	 *
	 * @param string|array $zapytanie Zapytanie sql w formie tabeli lub tekstu
	 * @param Pager $pager Obiekt pager-a
	 * @param Sorter $sorter Obiekt sorter-a
	 *
	 * @return string
	 */
	public function sqlSelect($zapytanie, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		//dump($zapytanie);
		if (is_array($zapytanie))
		{
			$sql = 'SELECT '.$zapytanie['kolumny'].' FROM '.$zapytanie['tabela'];

			if (isset($zapytanie['warunek']) && !empty($zapytanie['warunek']))
			{
				$zapytanie['warunek'] = $this->sqlWhere($zapytanie['warunek']);
				if ($zapytanie['warunek'] != '')
				{
					$sql .= ' WHERE'.$zapytanie['warunek'];
				}
			}
		}
		else
		{
			$sql = $zapytanie;
		}
		if ($sorter instanceof Biblioteka\Sorter)
		{
			$sortowania = array();
			foreach($sorter->wybraneKolumny() as $kolumna => $porzadek)
			{
				// to trzeba usunac jak beda dokonczone sortery
				if (is_numeric($kolumna))
				{
					$kolumna = $porzadek;
					$porzadek = '';
				}
				$porzadek = strtoupper($porzadek);
				$prefix = strlen($sorter->prefix) ? $sorter->prefix.'.' : '';
				$sortowania[] = $prefix.$kolumna.' '.(in_array($porzadek, array('ASC','DESC')) ? $porzadek : $sorter->wybranyPorzadek());
			}
			if ($sorter->wybraneSortowanie() == 'random') $sortowania = array('RAND()');
			$sql .= ' ORDER BY '.implode(', ', $sortowania);
		}
		if ($pager instanceof Pager)
		{
			//$sql .= ' LIMIT ' . ($pager->pierwszyNaStronie() - 1) . ', ' . $pager->naStronie();
			// zgodnosc z PostgreSQL
			$sql .= ' LIMIT ' . $pager->naStronie() . ' OFFSET ' . ($pager->pierwszyNaStronie() - 1);
		}
		return $sql;
	}



	/**
	 * Pisze zapytanie SQL INSERT i zwraca jego tresc
	 *
	 * @param string $tabela Nazwa tabeli w bazie
	 * @param array $dane Tablica zawierajaca dane w formacie array('nazwa_pola' => 'wartosc', itd.)
	 *
	 * @return string
	 */
	public function sqlInsert($tabela, $dane)
	{
		if (is_array($dane) && count($dane) > 0)
		{
			$pola = implode(', ', array_keys($dane));
			$wartosci = implode(', ', array_values($dane));
			return 'INSERT INTO ' . $tabela . ' (' . $pola . ') VALUES (' . $wartosci . ')';
		}
		return false;
	}



	/**
	 * Pisze zapytanie SQL UPDATE i zwraca jego tresc
	 *
	 * @param string $tabela Nazwa tabeli w bazie
	 * @param array $dane Tablica zawierajaca dane w formacie array('nazwa_pola' => 'wartosc', itd.)
	 * @param string $warunek Tresc warunku where
	 *
	 * @return string
	 */
	public function sqlUpdate($tabela, $dane, $warunek)
	{
		if (is_array($dane) && count($dane) > 0 && !empty($warunek))
		{
			$zmiany = '';
			foreach($dane as $pole => $wartosc)
			{
				$zmiany .= $pole . ' = ' . $wartosc .', ';
			}
			$zmiany = substr($zmiany, 0, -2);
			return 'UPDATE ' . $tabela . ' SET ' . $zmiany . ' WHERE ' . $this->sqlWhere($warunek);
		}
		return false;
	}



	/**
	 * Pisze zapytanie SQL DELETE i zwraca jego tresc
	 *
	 * @param string $tabela Nazwa tabeli w bazie
	 * @param string|array $warunek Tresc warunku where
	 *
	 * @return string
	 */
	public function sqlDelete($tabela, $warunek)
	{
		return 'DELETE FROM '.$tabela.' WHERE '.$this->sqlWhere($warunek);
	}



	/**
	 * Zamienia tablice z warunkami na zapytanie SQL WHERE i zwraca jego tresc
	 * Struktura tablicy:
	 * array('and' => array('id' => 0, 'id2 >=' => 3), 'or' => array('sekcja' => 'www', 'sekcja2 <>' => 'cos')), itd.
	 * gdzie klucz tablicy - warunek (AND, OR, itd.), wartosc - tablica z polami i wartosciami.
	 *
	 * @param array $warunek Tablica zawierajaca warunek
	 * @param string $prefix Prefix dla pol
	 *
	 * @return string
	 */
	public function sqlWhere($warunek, $prefix = '')
	{
		if (!is_array($warunek))
		{
			return $warunek;
		}
		$sql = ' ';
		$pierwszy = true;
		foreach ($warunek as $lacznik => $bloki)
		{
			$lacznik = ' ' . strtoupper($lacznik) . ' ';
			if (!$pierwszy)
			{
				$sql .= $lacznik;
			}
			$sqlWhere = array();
			foreach ($bloki as $kolumna => $wartosc)
			{
				if (is_int($kolumna))
				{
					$sqlWhere[] = $wartosc;
					continue;
				}

				$rozbita = explode(' ', $kolumna);
				$kolumna = $prefix.$rozbita[0];

				if (is_array($wartosc))
				{
					$sqlWhere[] = $kolumna . " IN ('" . implode("', '", $wartosc) . "')";
				}
				elseif (is_null($wartosc))
				{
					$sqlWhere[] = $kolumna . " IS NULL";
				}
				else
				{
					$operator = isset($rozbita[1]) ? $rozbita[1] : '=';
					$sqlWhere[] = $kolumna . ' ' . $operator . ' \'' . addslashes($wartosc) . '\'';
				}
			}
			if (count($sqlWhere) > 0)
			{
				$sql .= '(' . implode($lacznik, $sqlWhere) . ')';
			}
			unset($sqlWhere);
			$pierwszy = false;
		}
		return $sql;
	}



	/**
	 * Zamienia tablice z kryteriami wyszukiwania na tablice z ich odpowiednikami w zapisie sql
	 *
	 * @param array $kryteria Tablica zawierajaca kryteria
	 * @param array $polaTypy Tablica w formacie 'nazwa_pola' => 'typ_pola'
	 *
	 * @return array
	 */
	public function piszKryteria(Array &$kryteria, Array $polaTypy)
	{
		$obslugiwaneOperacje = array(
			'rowne', 'nierowne',
			'zawiera', 'niezawiera',
			'wyrazenie', 'niewyrazenie',
			'wieksze', 'wiekszerowne',
			'mniejsze', 'mniejszerowne',
			'null', 'nienull',
		);

		$warunki = array(' TRUE ');
		foreach ($kryteria as $nazwaWarunku => $wartosc)
		{
			$nazwa = explode('_', $nazwaWarunku);
			if (array_pop($nazwa) === '')
			{
				$operacja = strtolower(array_pop($nazwa));
				if ($operacja == 'lubpuste')
				{
					$operacja = strtolower(array_pop($nazwa));
				}
				elseif (empty($wartosc))
				{
					continue;
				}

				if ( ! in_array($operacja, $obslugiwaneOperacje))
				{
					trigger_error('Nieznany typ operacji "'.$operacja.'" dla kryteriow automatycznych', E_USER_NOTICE);
					continue;
				}
				$nazwa_pola = strtolower(implode('_', $nazwa));
				if ( ! array_key_exists($nazwa_pola, $polaTypy))
				{
					trigger_error('Nieznane pole '.$nazwa_pola.' dla kryteriow automatycznych w klasie '.  get_class($this), E_USER_NOTICE);
					continue;
				}
				if ( is_array($wartosc) && ! in_array($operacja, array('rowne','nierowne')))
				{
					trigger_error('Nieprawidlowa wartosc tablicowa dla operacji '. $operacja, E_USER_NOTICE);
					continue;
				}
				$warunki[] = $this->sqlWarunek($nazwa_pola, $operacja, $wartosc, $polaTypy[$nazwa_pola]);
				unset($kryteria[$nazwaWarunku]);
			}
		}
		return $warunki;
	}



	/**
	 * Pisze i zwraca kod sql operacji na podstawie podanych danych
	 *
	 * @param string $kolumna Kolumna ktorej dotyczy warunek
	 * @param string $operacja Operacja wykonywana na wartosci
	 * @param string $wartosc $wartosc
	 * @param mixed $typWartosci Typ pola do formatowania
	 * @return string
	 */
	public function sqlWarunek($kolumna, $operacja, $wartosc, $typWartosci)
	{
		switch ($typWartosci)
		{
			case 'string':
				if (is_array($wartosc))
					foreach ($wartosc as $k => $v) { $wartosc[$k] = $this->formatujTekst($v); }
				else
					$wartosc = $this->formatujTekst($wartosc);
			break;

			case 'enum':
				if (is_array($wartosc))
					foreach ($wartosc as $k => $v) { $wartosc[$k] = $this->formatujTekst($v); }
				else
					$wartosc = $this->formatujTekst($wartosc);
			break;

			case 'datetime':
				if (is_array($wartosc))
					foreach ($wartosc as $k => $v) { $wartosc[$k] = $this->formatujTekst($v); }
				else
					$wartosc = $this->formatujTekst($wartosc);
			break;

			case 'float':
				if (is_array($wartosc))
					foreach ($wartosc as $k => $v) { $wartosc[$k] = $this->formatujTekst(floatval($v)); }
				else
					$wartosc = $this->formatujTekst(floatval($wartosc));
			break;

			case 'double':
				if (is_array($wartosc))
					foreach ($wartosc as $k => $v) { $wartosc[$k] = $this->formatujTekst(doubleval($v)); }
				else
					$wartosc = $this->formatujTekst(doubleval($wartosc));
				break;

			case 'integer':
				if (is_array($wartosc))
					foreach ($wartosc as $k => $v) { $wartosc[$k] = intval($v); }
				else
					$wartosc = intval($wartosc);
			break;

			case 'boolean':
				$wartosc = ($wartosc) ? true : false;
			break;

			default:
				trigger_error('Nieprawidlowy typ wartosci '. $typWartosci, E_USER_WARNING);
				return;
			break;
		}

		$sql = $kolumna;

		switch ($operacja)
		{
			case 'rowne':
				$sql .= (is_array($wartosc)) ? ' IN ('.implode(',', $wartosc).')' : ' = '.$wartosc;
			break;

			case 'nierowne':
				$sql .= (is_array($wartosc)) ? ' NOT IN ('.implode(',', $wartosc).')' : ' != '.$wartosc;
			break;

			case 'zawiera':
				$sql .= ' LIKE '.$wartosc;
			break;

			case 'niezawiera':
				$sql .= ' NOT LIKE '.$wartosc;
			break;

			case 'wyrazenie':
				$sql .= ' REGEXP '.$wartosc;
			break;

			case 'niewyrazenie':
				$sql .= ' NOT REGEXP '.$wartosc;
			break;

			case 'wieksze':
				$sql .= ' > '.$wartosc;
			break;

			case 'wiekszerowne':
				$sql .= ' >= '.$wartosc;
			break;

			case 'mniejsze':
				$sql .= ' < '.$wartosc;
			break;

			case 'mniejszerowne':
				$sql .= ' <= '.$wartosc;
			break;

			case 'null':
				$sql .= ' IS NULL ';
			break;

			case 'nienull':
				$sql .= ' IS NOT NULL ';
			break;

			default:
				trigger_error('Nieprawidlowy typ operacji '. $operacja, E_USER_WARNING);
				return;
			break;
		}

		return (string)$sql;
	}



	/**
	 * Pisze zapytanie SQL pobierajace nowe ID i zwraca jego tresc
	 *
	 * @param string $tabela Nazwa tabeli w bazie
	 * @param string|array $warunek Warunek w postaci tablicy lub ciagu tekstowego
	 *
	 * @return string
	 */
	public function sqlId($tabela, $warunek = '')
	{
		$sql = 'SELECT COALESCE(MAX(id),0)+1 AS id FROM ' . $tabela;
		if (!empty($warunek))
		{
			$warunek = $this->sqlWhere($warunek);
			if ($warunek != '')
			{
				$sql .= ' WHERE '.$warunek;
			}
		}
		return $sql;
	}



	/**
	 * Formatuje tekst tak aby nie powodowal problemow w zapytaniu
	 *
	 * @param string $tekst Tekst do przefiltrowania
	 *
	 * @return string
	 */
	public function formatujTekst($tekst)
	{
		return $this->pdo->quote($tekst);
	}



	/**
	 * Zwraca identyfikator bazy danych
	 *
	 * @return string
	 */
	public function pobierzIdentyfikator()
	{
		return $this->identyfikatorBazy;
}

}


class BazaWyjatek extends \Exception {}
