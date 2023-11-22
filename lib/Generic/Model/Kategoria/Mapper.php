<?php
namespace Generic\Model\Kategoria;
use Generic\Biblioteka;
use Generic\Model\Drzewo;
use Generic\Model\Kategoria;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\MapperWyjatek;
use Generic\Biblioteka\BazaWyjatek;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących kategorie podstron.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\Kategoria\Obiekt';

	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_kategorie';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		//'kod_jezyka' => 'kodJezyka',
		'prawy' => 'prawy',
		'lewy' => 'lewy',
		'poziom' => 'poziom',
		'czy_widoczna' => 'czyWidoczna',
		'dla_zalogowanych' => 'dlaZalogowanych',
		'wymaga_https' => 'wymagaHttps',
		'typ' => 'typ',
		'kod_modulu' => 'kodModulu',
		'id_widoku' => 'idWidoku',
		'kontener' => 'kontener',
		'akcja_kontener' => 'akcjaKontener',
		'akcja_uklad_strony' => 'akcjaUkladStrony',
		'akcja_szablon' => 'akcjaSzablon',
		'akcja_klasa' => 'akcjaKlasa',
		'stary_url' => 'staryUrl',
		'blokada' => 'blokada',
		'nazwa' => 'nazwa',
		'nazwa_przyjazna' => 'nazwaPrzyjazna',
		'kod' => 'kod',
		'pelny_link' => 'pelnyLink',
		'tytul_strony' => 'tytulStrony',
		'opis' => 'opis',
		'slowa_kluczowe' => 'slowaKluczowe',
		'id_kategorii' => 'idKategorii',
		'adres_zewnetrzny' => 'adresZewnetrzny',
		'cache' => 'cache',
		'czas_cache' => 'czasCache',
		'skrypt' => 'skrypt',
		'rss_wlaczony' => 'rssWlaczony',
		'szablon' => 'szablon',
		'klasa' => 'klasa',
		'naglowek_html' => 'naglowekHtml',
		'naglowek_http' => 'naglowekHttp',
		'ikona' => 'ikona',
		'szablon_katalog' => 'szablonKatalog'
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id', 'id_projektu');


	// pola tabeli potrzebne do zapisu drzewa
	protected $polaTabeliDrzewo = array('id', 'prawy', 'lewy', 'poziom');



	public function __construct($zwracaTablice = false)
	{
		parent::__construct($zwracaTablice);
		$this->drzewo = new Drzewo\Obiekt($this->baza, $this->tabela, ID_PROJEKTU);
		$this->obiektPolaTabeli = array_flip($this->polaTabeliObiekt);
	}



	function czysc()
	{
		$dane = array(
			'id_projektu' => ID_PROJEKTU,
			//'kod_jezyka' => KOD_JEZYKA,
			'dla_zalogowanych' => 1,
			'wymaga_https' => 0,
			'typ' => 'system',
			'nazwa' => 'System',
			'kod' => '_system_',
			'pelny_link' => '_system_',
			'tytul_strony' => 'System',
		);
		return $this->drzewo->czysc($dane);
	}



	function przeniesObok(Kategoria\Obiekt $kategoria, $idSasiada, $polozenie)
	{
		return $this->drzewo->zamienPozycjeWszystkich($kategoria->id, $idSasiada, $polozenie);
	}



	function zmienRodzica(Kategoria\Obiekt $kategoria, $idRodzica)
	{
		return $this->drzewo->przeniesWszystkie($kategoria->id, $idRodzica);
	}



	function info(Kategoria\Obiekt $kategoria)
	{
		return $this->drzewo->info($kategoria->id);
	}



	/*
	 * Przeciazona metoda zapisz. Zapisuje obiekt w bazie
	 *
	 * @param ObiektDanych $kategoria Obiekt do utrwalenia w bazie
	 *
	 * @return boolean w zaleznosci od wyniku z bazy
	 */
	function wstaw(ObiektDanych $kategoria, $id = 0):int
	{
		if ( ! $this->obiektObslugiwany($kategoria))
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($kategoria).' w bazie.');
		}
		if ((int)$kategoria->idRodzica < 1)
		{
			return false;
		}
		$dane = array();
		foreach ($kategoria->daneDoZapisu() as $zmienna => $wartosc)
		{
			$poleTabeli = $this->obiektPolaTabeli[$zmienna];
			if (in_array($poleTabeli, $this->polaTabeliDrzewo)) continue;
			$dane[$poleTabeli] = $this->formatujWartosc($poleTabeli, $wartosc);
		}
		return $this->drzewo->wstawPod($kategoria->idRodzica, '', $dane);
	}



	/*
	 * Przeciazona metoda usun. Usuwa obiekt z bazy
	 *
	 * @param ObiektDanych $kategoria Obiekt do utrwalenia w bazie
	 *
	 * @return boolean w zaleznosci od wyniku z bazy
	 */
	function usun(ObiektDanych $kategoria)
	{
		if ( ! $this->obiektObslugiwany($kategoria))
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($kategoria).' w bazie.');
		}
		return $this->drzewo->usunzDziecmi($kategoria->id);
	}



	function usunWszystko()
	{
		$sql = 'DELETE FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU;
		//. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->wykonajSql($sql);
	}



	/**
	 * Zwraca obiekt kategorii o podanym id lub null
	 *
	 * @param int $id
	 * @return Kategoria
	 */
	function pobierzPoId($id)
	{
		$cache = Kategoria\MapperCache::wywolaj($this->zwracaTablice);
		if ($cache->dostepny())
		{
			if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
			return $cache->pobierzPoId($id);
		}

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;
		//	. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->pobierzJeden($sql);
	}


	function pobierzPoWieleId($ids)
	{
		$cache = Kategoria\MapperCache::wywolaj($this->zwracaTablice);
		if ($cache->dostepny())
		{
			if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
			return $cache->pobierzPoWieleId($ids);
		}

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id IN (' . implode(',', $ids) .')'
			. ' AND id_projektu = ' . ID_PROJEKTU;
		//	. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->pobierzWiele($sql);
	}

	function pobierzPoKodzie($kod)
	{
        dump($kod);
		$cache = Kategoria\MapperCache::wywolaj();
		if ($cache->dostepny())
		{
			if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
			return $cache->pobierzPoKodzie($kod);
		}

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE kod = \'' . addslashes($kod) . '\''
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

            dump($sql);
		return $this->pobierzJeden($sql);
	}

	function pobierzPoKodModulu($kod_modulu)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE kod_modulu = \'' . addslashes($kod_modulu) . '\''
			. ' AND id_projektu = ' . ID_PROJEKTU;
		//	. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->pobierzJeden($sql);
	}

	function pobierzPoTypie($typ)
	{
		$cache = Kategoria\MapperCache::wywolaj();
		if ($cache->dostepny())
		{
			if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
			return $cache->pobierzPoTypie($typ);
		}

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE typ = \'' . addslashes($typ) . '\''
			. ' AND id_projektu = ' . ID_PROJEKTU;
		//	. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->pobierzWiele($sql);
	}



	function pobierzGlowna()
	{
		$kat = $this->pobierzPoTypie('glowna');
		return isset($kat[0]) ? $kat[0] : null;
	}


	function pobierzStartowaAdmin()
	{
		$kat = $this->pobierzDlaModulu('WidokPoczatkowy');
		
		if ($kat[0] instanceof Kategoria\Obiekt)
		{
			return $kat[0];
		}
		return null;
	}

	function pobierzPoLinku($link)
	{
        //TODO: Sprawdzić o co chodzi z tym keszem
		$cache = Kategoria\MapperCache::wywolaj();


        if ($cache->dostepny())
		{

			if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
			return $cache->pobierzPoLinku($link);
		}


		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE pelny_link = \'' . addslashes($link) . '\''
			. ' AND id_projektu = ' . ID_PROJEKTU;
			//. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->pobierzJeden($sql);
	}



	function pobierzDlaModulu($kodModulu)
	{
		$cache = Kategoria\MapperCache::wywolaj();
		if ($cache->dostepny())
		{
			if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
			return $cache->pobierzDlaModulu($kodModulu);
		}

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE kod_modulu = \''.addslashes($kodModulu).'\''
			. ' AND id_projektu = ' . ID_PROJEKTU;
		
			//. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->pobierzWiele($sql);
	}



	function pobierzDlaWidoku($idWidoku)
	{
		$cache = Kategoria\MapperCache::wywolaj();
		if ($cache->dostepny())
		{
			if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
			return $cache->pobierzDlaWidoku($idWidoku);
		}

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_widoku = '.intval($idWidoku)
			. ' AND id_projektu = ' . ID_PROJEKTU;
			//. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->pobierzWiele($sql);
	}



	function pobierzDlaRss()
	{
		$cache = Kategoria\MapperCache::wywolaj();
		if ($cache->dostepny())
		{
			if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
			return $cache->pobierzDlaRss();
		}

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE rss_wlaczony = 1'
			. ' AND id_projektu = ' . ID_PROJEKTU;
		//	. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->pobierzWiele($sql);
	}



	function pobierzWspolnyRodzicOrazPoziom($id)
	{
		//info o wybranej kategorii
		$kategoria = $this->drzewo->info((int)$id);
		// pobieranie rodzica
		$rodzic = $this->drzewo->pobierzRodzica((int)$id);
		// pobieranie calej galezi lacznie z bierzacym elementem
		$dane = $this->drzewo->pobierzGalaz($rodzic['id'], null, array('and' => array('poziom = ' . $kategoria['poziom'])));

		return $this->przetworzWynikDrzewa($dane);
	}



	function pobierzSciezke($id)
	{
		$cache = Kategoria\MapperCache::wywolaj();
		if ($cache->dostepny())
		{
			if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
			return $cache->pobierzSciezke($id);
		}

		// pobieranie listy kategorii nadrzednych az do glownej
		$dane = $this->drzewo->pobierzSciezke((int)$id);

		return $this->przetworzWynikDrzewa($dane);
	}



	function pobierzRodzica($id)
	{
		return $this->przetworzWynik($this->drzewo->pobierzRodzica((int)$id));
	}



	function pobierzDzieci($id)
	{
		// pobieranie listy kategorii podleglych bezposrednio pod bierzaca
		$dane = $this->drzewo->pobierzDzieci((int)$id);

		return $this->przetworzWynikDrzewa($dane);
	}



	function pobierzNiepelneDrzewo($id)
	{
		$kategoria = $this->drzewo->info((int)$id);
		// drzewo z kategoriami posiadajacymi podkategorie
		$dane = $this->drzewo->pobierzDrzewo(null, array('or' => array('lewy <= ' . $kategoria['lewy'], 'prawy >= ' . $kategoria['prawy'])));

		return $this->przetworzWynikDrzewa($dane);
	}



	function pobierzGalaz($id)
	{
		$cache = Kategoria\MapperCache::wywolaj();
		if ($cache->dostepny())
		{
			if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
			return $cache->pobierzGalazDoPoziomu($id, 99);
		}

		$dane = $this->drzewo->pobierzGalaz((int)$id);

		return $this->przetworzWynikDrzewa($dane);
	}



	function pobierzGalazDoPoziomu($id, $poziom)
	{
		$cache = Kategoria\MapperCache::wywolaj();
		if ($cache->dostepny())
		{
			if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
			return $cache->pobierzGalazDoPoziomu($id, $poziom);
		}

		$dane = $this->drzewo->pobierzGalaz((int)$id, null, array('and' => array('poziom <=' => (int)$poziom)));

		return $this->przetworzWynikDrzewa($dane);
	}



	function pobierzGalazOdPoziomuDoPoziomu($id, $poziomOd, $poziomDo)
	{
	//	$cache = KategorieMapperCache::wywolaj();
	//	if ($cache->dostepny())
	//	{
	//		if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
	//		return $cache->pobierzGalazDoPoziomu($id, $poziom);
	//	}

		$dane = $this->drzewo->pobierzGalaz((int)$id, null, array('and' => array('poziom >=' => (int)$poziomOd, 'poziom <=' => (int)$poziomDo)));

		return $this->przetworzWynikDrzewa($dane);
	}



	function pobierzDoPoziomu($poziom)
	{
		$cache = Kategoria\MapperCache::wywolaj();
		if ($cache->dostepny())
		{
			if ($this->zwracaTablice) $cache->zwracaTablice($this->zwracaneKolumnyTablicy);
			return $cache->pobierzDoPoziomu($poziom);
		}

		$dane = $this->drzewo->pobierzDrzewo(null, array('and' => array('poziom <= ' . (int)$poziom)));

		return $this->przetworzWynikDrzewa($dane);
	}



	function pobierzWszystko()
	{
		$cache = Kategoria\MapperCache::wywolaj($this->zwracaTablice);
		if ($cache->dostepny())
		{
			return $cache->pobierzWszystko();
		}
		$dane = $this->drzewo->pobierzDrzewo();

		return $this->przetworzWynikDrzewa($dane);
	}


	function pobierzDlaCache()
	{
		$dane = $this->drzewo->pobierzDrzewo();

		return $this->przetworzWynikDrzewa($dane);
	}


	function przetworzWynikDrzewa($dane)
	{
		if (empty($dane)) return array();

		$lista = array();
		if (is_array($dane))
		{
			foreach($dane as $wiersz)
			{
				$lista[] = $this->przetworzWynik($wiersz);
			}
		}

		if ($this->zwracaTablice)
		{
			$this->zwracaObiekt();
		}

		return $lista;
	}
}
