<?php
namespace Generic\Model\Kategoria;
use Generic\Biblioteka;
use Generic\Biblioteka\Cms;


/**
 * Klasa obsługująca zapis i odczyt z cache dla obiektów odwzorowujących kategorie podstron.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class MapperCache extends Biblioteka\Mapper\Tablica
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


	/**
	 * Zwraca instancje obiektu
	 *
	 * @return KategorieMapperCache
	 */
	public static function wywolaj($zwracaTablice = false)
	{
		parent::$klasa = __CLASS__;
		return parent::wywolaj($zwracaTablice);
	}



	public function zaladujDane()
	{
		$mapper = Cms::inst()->dane()->Kategoria();
		if ($dane = $mapper->zwracaTablice()->pobierzDlaCache())
		{
			$this->przetworzDane($dane);
		}
		return true;
	}



	function pobierzPoId($id)
	{
		$klucz = $id.'-'.ID_PROJEKTU;

		if (isset($this->dane[$klucz]))
		{
			return $this->pobierzJeden($this->dane[$klucz]);
		}
		return false;
	}

	
	function pobierzPoWieleId($ids)
	{
		$dane = array();
		foreach ($ids as $id)
		{
			$klucz = $id.'-'.ID_PROJEKTU;
			if (isset($this->dane[$klucz]))
			{
				$dane[] = $this->pobierzJeden($this->dane[$klucz]);
			}
		}
		
		return $dane;
	}


	function pobierzPoKodzie($kod)
	{
		$dane = $this->kolumnaRowna($this->dane, 'kod', array($kod));

		if (count($dane) > 0)
		{
			return $this->pobierzJeden(array_shift($dane));
		}
		return false;
	}



	function pobierzPoTypie($typ)
	{
		$dane = $this->kolumnaRowna($this->dane, 'typ', array($typ));

		return $this->pobierzWiele($dane);
	}



	function pobierzPoLinku($link)
	{
		$dane = $this->kolumnaRowna($this->dane, 'pelny_link', array($link));

		if (count($dane) > 0)
		{
			return $this->pobierzJeden(array_shift($dane));
		}
		return false;
	}



	function pobierzDlaModulu($kodModulu)
	{
		$dane = $this->kolumnaRowna($this->dane, 'kod_modulu', array($kodModulu));

		return $this->pobierzWiele($dane);
	}



	function pobierzDlaWidoku($idWidoku)
	{
		$dane = $this->kolumnaRowna($this->dane, 'id_widoku', array($idWidoku));

		return $this->pobierzWiele($dane);
	}



	function pobierzDlaRss()
	{
		$dane = $this->kolumnaRowna($this->dane, 'rss_wlaczony', array(1));

		return $this->pobierzWiele($dane);
	}



	function pobierzSciezke($id)
	{
		$tablica = $this->dane;
		marsort($tablica, 'lewy');

		$dane = array();
		$poziom = -1;
		foreach ($tablica as $wiersz)
		{
			if ($poziom >= 0 && $wiersz['poziom'] == $poziom)
			{
				$dane[] = $wiersz;
				$poziom--;
			}
			elseif ($wiersz['id'] == $id)
			{
				$dane[] = $wiersz;
				$poziom = $wiersz['poziom'] - 1;
			}
		}
		masort($dane, 'lewy');

		return $this->pobierzWiele($dane);
	}



	function pobierzGalazDoPoziomu($id, $poziom)
	{
		$id = (int)abs($id);
		$poziom = (int)abs($poziom);
		$tablica = $this->dane;
		masort($tablica, 'lewy');

		$dane = array();
		$poziomStartowej = -1;
		$poziomPoprzedniej = -1;
		foreach ($tablica as $wiersz)
		{
			if ($poziomStartowej >= 0 && $wiersz['poziom'] <= $poziom)
			{
				if ($wiersz['poziom'] <= $poziomStartowej) break;
				$dane[] = $wiersz;
				if ($wiersz['poziom'] < $poziomPoprzedniej) $poziom--;
			}
			elseif ($wiersz['id'] == $id)
			{
				$dane[] = $wiersz;
				$poziomStartowej = $wiersz['poziom'];
			}

		}

		return $this->pobierzWiele($dane);
	}



	function pobierzDoPoziomu($poziom)
	{
		$poziom = (int)$poziom;
		$tablica = $this->dane;
		masort($tablica, 'lewy');

		$dane = array();
		foreach ($tablica as $k => $v)
		{
			if ($v['poziom'] > $poziom) continue;
			$dane[] = $v;
		}
		return $this->pobierzWiele($dane);
	}



	function pobierzWszystko()
	{
		$tablica = $this->dane;
		masort($tablica, 'lewy');

		return $this->pobierzWiele($tablica);
	}

}

