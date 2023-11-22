<?php
namespace Generic\Model\CacheLinki;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\BazaWyjatek;


class Mapper extends Biblioteka\Mapper\Baza
{

	// nazwa klasy tworzonego obiektu
	protected $zwracanyObiekt = 'Generic\Model\CacheLinki\Obiekt';



	// przetrzymuje nazwe tabeli w bazie do ktorej beda zapisywane dane
	protected $tabela = 'cms_cache_linki';



	// przetrzymuje tablice tlumaczaca kolumny tabeli na nazwy pol obiektu
	protected $polaTabeliObiekt = array(
		'url' => 'url',
		'typ' => 'typ',
		'data_dodania' => 'dataDodania',
		'lista_zawartych_url' => 'listaZawartychUrl',
	);



	// pola tabeli tworzace klucz glowny
	protected $polaTabeliKlucz = array('url');



	// przetrzymuje typy pol tabeli w bazie
	protected $polaTabeliTypy = array(
		'url' => self::STRING,
		'typ' => self::STRING,
		'data_dodania' => self::STRING,
		'lista_zawartych_url' => self::STRING,
	);



	public function pobierzPoUrl($url)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE url = \''.addslashes($url).'\'';

		return $this->pobierzJeden($sql);
	}



	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE 1 = 1';

		if (isset($kryteria['url']) && $kryteria['url'] != '')
		{
			$sql .= ' AND url = \''.addslashes($kryteria['url']).'\'';
		}
		if (isset($kryteria['url_szukaj']) && $kryteria['url_szukaj'] != '')
		{
			$sql .= ' AND url LIKE \''.$kryteria['url_szukaj'].'\'';
		}
		if (isset($kryteria['typ']) && $kryteria['typ'] != '')
		{
			$sql .= ' AND typ = \''.addslashes($kryteria['typ']).'\'';
		}
		if (isset($kryteria['link']) && $kryteria['link'] != '')
		{
			$sql .= ' AND lista_zawartych_url LIKE \'%|'.addslashes($kryteria['link']).'|%\'';
		}

		if (isset($kryteria['linki']) && is_array($kryteria['linki']))
		{
			$like = array();
			foreach ($kryteria['linki'] as $link)
			{
				$like[] = 'lista_zawartych_url LIKE \'%|'.addslashes($link).'|%\'';
			}
			if (isset($kryteria['linki_lub_url']) && $kryteria['linki_lub_url'] != '')
			{
				$like[] = 'url = \''.addslashes($kryteria['linki_lub_url']).'\'';
			}
			$sql .= ' AND ('.implode(' OR ', $like).')';
		}

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE 1 = 1';

		if (isset($kryteria['url']) && $kryteria['url'] != '')
		{
			$sql .= ' AND url = \''.addslashes($kryteria['url']).'\'';
		}
		if (isset($kryteria['url_szukaj']) && $kryteria['url_szukaj'] != '')
		{
			$sql .= ' AND url LIKE \''.$kryteria['url_szukaj'].'\'';
		}
		if (isset($kryteria['typ']) && $kryteria['typ'] != '')
		{
			$sql .= ' AND typ = \''.addslashes($kryteria['typ']).'\'';
		}
		if (isset($kryteria['link']) && $kryteria['link'] != '')
		{
			$sql .= ' AND lista_zawartych_url LIKE \'%|'.addslashes($kryteria['link']).'|%\'';
		}

		if (isset($kryteria['linki']) && is_array($kryteria['linki']))
		{
			$like = array();
			foreach ($kryteria['linki'] as $link)
			{
				$like[] = 'lista_zawartych_url LIKE \'%|'.addslashes($link).'|%\'';
			}
			if (isset($kryteria['linki_lub_url']) && $kryteria['linki_lub_url'] != '')
			{
				$like[] = 'url = \''.addslashes($kryteria['linki_lub_url']).'\'';
			}
			$sql .= ' AND ('.implode(' OR ', $like).')';
		}


		return $this->pobierzWartosc($sql);
	}



	function usunWielePoUrl($urle = array())
	{
		$sql = 'DELETE FROM ' . $this->tabela . '
			WHERE url IN (\'' . implode('\',\'', array_map('addslashes', $urle)) . '\')';

		return $this->wykonajSql($sql);
	}



	public function czyscBloki()
	{
		$sql = 'DELETE FROM ' . $this->tabela . ' WHERE typ = \'blok\'';

		return $this->wykonajSql($sql);
		//return $this->usunPrzezWyrazenie('%#blok#%');
	}



	public function czyscStrony()
	{
		$sql = 'DELETE FROM ' . $this->tabela . ' WHERE typ = \'podstrona_portalowa\'';

		return $this->wykonajSql($sql);
		//return $this->usunPrzezWyrazenie('/%');
	}



	public function czyscSubdomeny()
	{
		$sql = 'DELETE FROM ' . $this->tabela . ' WHERE typ = \'podstrona_wizytowki\'';

		return $this->wykonajSql($sql);
		//return $this->usunPrzezWyrazenie('%#/%');
	}



	public function czyscSubdomene($subdomena)
	{
		$sql = 'DELETE FROM ' . $this->tabela . ' WHERE typ = \'podstrona_wizytowki\''
			 . ' AND url LIKE \'%#'.$subdomena.'#%\'';

		return $this->wykonajSql($sql);
		//return $this->usunPrzezWyrazenie('%#'.$subdomena.'#%');
	}



	protected function usunPrzezWyrazenie($wyrazenie)
	{
		$sql = 'DELETE FROM ' . $this->tabela . ' WHERE url LIKE \''.$wyrazenie.'\'';

		return $this->wykonajSql($sql);
	}

}
