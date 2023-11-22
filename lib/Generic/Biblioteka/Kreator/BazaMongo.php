<?php
namespace Generic\Biblioteka\Kreator;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Plik;
use Mandango\Mondator\Mondator;

/**
 * Odpowiada za utworzenie CAŁEGO modelu danych dla bazy MongoDB za pomocą Mondatora.
 * Wymaga istnienia pliku definicji strukturaNosql.php.
 *
 * @author Konrad Rudowski
 */
class BazaMongo implements Interfejs
{

	protected $katalogWyjsciowy;


	protected $plikStrukturyNosql;


	protected $nazwaBazy = '';


	public function __construct($plikStruktury)
	{
		$this->katalogWyjsciowy = CMS_KATALOG . '/lib/Generic/ModelNosql';

		$this->plikStrukturyNosql = $plikStruktury;
	}

	/**
	 * @return bool Określa czy plik został wygenerowany.
	 */
	function generuj($nazwaBazy, $nazwaUzytkownika)
	{
		$this->nazwaBazy = $nazwaBazy;

		$strukturaNoSql = $this->wczytajPlikKonfiguracji();

		if ($strukturaNoSql == null)
		{
			return false;
		}

		$listaMapperowPoczatkowa = $this->pobierzListeMapperowNosql();

		$this->uruchomMondator($strukturaNoSql);

		$listaMapperowKoncowa = $this->pobierzListeMapperowNosql();

		$noweMappery = array_diff($listaMapperowKoncowa, $listaMapperowPoczatkowa);

		if (count($noweMappery) > 0)
		{
			$this->poprawPliki($noweMappery);
		}
		else
		{
			//info ze nie utworzono zadnych mapperow nowych
		}
	}


	protected function uruchomMondator($strukturaNoSql)
	{
		$mondator = new Mondator();

		$mondator->setConfigClasses($strukturaNoSql);

		$mondator->setExtensions(array(
			new \Mandango\Extension\Core(array(
				'metadata_factory_class' => 'Generic\\ModelNosql\\Mapping\MetadataFactory',
				'metadata_factory_output' => $this->katalogWyjsciowy . '/Mapping',
				'default_output'         => $this->katalogWyjsciowy,
			)),
			new \Mandango\Extension\DocumentPropertyOverloading(),
			new \Mandango\Extension\DocumentArrayAccess(),
		));

		$mondator->process();
	}


	protected function poprawPliki(Array $noweMappery)
	{
		foreach ($noweMappery as $nazwa)
		{
			$this->poprawObiekt($nazwa);
			$this->poprawZapytanie($nazwa);
			$this->poprawRepozytorium($nazwa);
		}
	}

	protected function pobierzListeMapperowNosql()
	{
		$katalogDaneNosql = new Katalog($this->katalogWyjsciowy);

		$mapperyNosql = $katalogDaneNosql->pobierzZawartosc();
		ksort($mapperyNosql);

		$listaMapperowNosql = array();

		foreach ($mapperyNosql as $nazwaPliku => $czyKatalog)
		{
			if ($czyKatalog != null || $nazwaPliku == '.svn')
			{
				continue;
			}

			$nazwaPliku = str_replace(array('Repository.php', 'Query.php', '.php'), '', $nazwaPliku);

			$listaMapperowNosql[$nazwaPliku] = $nazwaPliku;
		}

		return $listaMapperowNosql;
	}


	protected function poprawObiekt($nazwa)
	{
		$this->poprawPlik($nazwa, 'class ' . $nazwa . ' extends \\Generic\\ModelNosql\\Base\\' . $nazwa . '
{', 'class ' . $nazwa . ' extends \\Generic\\ModelNosql\\Base\\' . $nazwa . '
{
	use \\Generic\\Biblioteka\\Mandango\\Document;');

	}


	protected function poprawZapytanie($nazwa)
	{
		// Obecnie nie potrzeba zmian w tym pliku
	}


	protected function poprawRepozytorium($nazwa)
	{
		$nazwa .= 'Repository';

		$this->poprawPlik($nazwa, 'class ' . $nazwa . ' extends \\Generic\\ModelNosql\\Base\\' . $nazwa . '
{', 'class ' . $nazwa . ' extends \\Generic\\ModelNosql\\Base\\' . $nazwa . '
{
	use \\Generic\\Biblioteka\\Mandango\\Repository;

	protected static $identyfikatorBazy = \'' . $this->nazwaBazy . '\';');
	}

	protected function poprawPlik($nazwa, $szukaj, $zamien)
	{
		$nazwaPliku = $this->katalogWyjsciowy . '/' . $nazwa . '.php';
		$plikKlasy = new Plik($nazwaPliku);

		$trescPliku = $plikKlasy->pobierzZawartosc();

		$nowaTrescPliku = str_replace($szukaj, $zamien, $trescPliku);

		$plikKlasy->ustawZawartosc($nowaTrescPliku);
	}

	protected function wczytajPlikKonfiguracji()
	{
		$plik = $this->plikStrukturyNosql == '' ? (CMS_KATALOG.'/strukturaNosql.php') : $this->plikStrukturyNosql;
		if (is_file($plik) && is_readable($plik))
		{
			$cfg = include($plik);
			if (is_array($cfg))
			{
				return $cfg;
			}
			else
			{
				return array();
			}
		}
		else
		{
			trigger_error('Nie mogę odczytać pliku definicji ' .$plik);
			return null;
		}
	}

	/**
	 * @return string - tekst podsumowania gotowy do wyświetlenia
	 */
	function pokazPodsumowanie()
	{
		return '';
	}
}
