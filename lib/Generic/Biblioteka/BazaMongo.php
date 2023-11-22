<?php
namespace Generic\Biblioteka;
use Mandango\Cache\ArrayCache;
use Mandango\Connection;
use Mandango\Mandango;
use Generic\ModelNosql\Mapping\MetadataFactory;


/**
 * Obsluga bazy danych MongoDb.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */
class BazaMongo
{
	/**
	 * Obiekt Mandango
	 *
	 * @var \Mandango\Mandango
	 */
	protected $mandango = null;


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
	 * Przetrzymuje liczbę rozpoczętych transakcji w bazie.
	 *
	 * @var integer
	 */
	protected $licznikTransakcji = 0;


	/**
	 * Przetrzymuje obiekt cache
	 */
	protected $obiektCache = null;



	/**
	 * Przetrzymuje funkcję logującą zapytania
	 */
	protected $loggerCallable = null;



	/**
	 * Konstruktor, nawiazuje polaczenie z baza danych.
	 *
	 * @param array $config tablica z konfiguracja bazy danych.
	 * @param $laczenieAutomatyczne czy łączyć automatycznie
	 */
	public function __construct($config = array(), $laczenieAutomatyczne = true, $cache = null, $loggerCallable = null)
	{
		$this->config = $config;

		$this->obiektCache = $cache;
		$this->loggerCallable = $loggerCallable;

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
		return ($this->mandango instanceof Mandango);
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
					empty($this->config['db_name']) || $this->config['db_driver'] != 'mongodb')
				{
					throw new \Exception('Nieprawidlowa konfiguracja bazy danych.');
				}

				if ($this->config['identyfikator_bazy'] != '')
				{
					$this->identyfikatorBazy = $this->config['identyfikator_bazy'];
				}

				$metadataFactory = new MetadataFactory();
				if ($this->obiektCache === null)
				{
					$this->obiektCache = new ArrayCache();
				}

				$this->mandango = new Mandango($metadataFactory, $this->obiektCache, $this->loggerCallable);

				$connection = new Connection($this->config['db_driver'] . '://' . $this->config['db_host'] . ':' . $this->config['db_port'], $this->config['db_name']);
				$this->mandango->setConnection($this->identyfikatorBazy, $connection);
				$this->mandango->setDefaultConnectionName($this->identyfikatorBazy);
			}
			catch (\Exception $wyjatek)
			{
				trigger_error($wyjatek->getMessage(), E_USER_WARNING);
			}
		}
		else
		{
			trigger_error('Połączenie z bazą danych zostało już nawiązane.');
		}

	}


	public function zapisz(\Mandango\Document\Document $obiekt)
	{
		try
		{
			if ($this->licznikTransakcji > 0)
			{
				$this->mandango->getUnitOfWork()->persist($obiekt);
			}
			else
			{
				$obiekt->save();
			}

			return true;
		}
		catch (\Exception $e)
		{
			return false;
		}
	}


	public function usun(\Mandango\Document\Document $obiekt)
	{
		try
		{
			if ($this->licznikTransakcji > 0)
			{
				$this->mandango->getUnitOfWork()->remove($obiekt);
			}
			else
			{
				$obiekt->delete();
			}

			return true;
		}
		catch (\Exception $e)
		{
			return false;
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
			$this->licznikTransakcji++;
			return true;
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
			return $this->mandango->getUnitOfWork()->commit();
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
			return $this->mandango->getUnitOfWork()->clear();
		}

		return true;
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



	/**
	 * Zwraca obiekt transportowy do MongoDB
	 *
	 * @return \Mandango\Mandango
	 */
	public function pobierzMongo()
	{
		return $this->mandango;
	}

}


class BazaMongoWyjatek extends \Exception {}
