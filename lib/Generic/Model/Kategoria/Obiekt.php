<?php
namespace Generic\Model\Kategoria;
use Generic\Biblioteka\ObiektDanych;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Cms;
use Generic\Model\DostepnyModul;


/**
 * Klasa odwzorowująca kategorię podstrony.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property int $prawy
 * @property int $lewy
 * @property int $poziom
 * @property int $czyWidoczna
 * @property int $dlaZalogowanych
 * @property int $wymagaHttps
 * @property string $typ
 * @property string $kodModulu
 * @property int $idWidoku
 * @property string $kontener
 * @property string $akcjaKontener
 * @property string $akcjaUkladStrony
 * @property string $akcjaSzablon
 * @property string $akcjaKlasa
 * @property string $nazwa
 * @property string $nazwaPrzyjazna
 * @property string $kod
 * @property string $pelnyLink
 * @property string $staryUrl
 * @property string $tytulStrony
 * @property string $opis
 * @property string $slowaKluczowe
 * @property int $idKategorii
 * @property string $adresZewnetrzny
 * @property bool $cache
 * @property int $czasCache
 * @property string $skrypt
 * @property int $rssWlaczony
 * @property string $szablon
 * @property string $klasa
 * @property string $naglowekHtml
 * @property string $naglowekHttp
 * @property string $ikona
 * @property string $szablonKatalog
 *
 * dostepne tylko z poziomu cache
 * @property int $idRodzica
 * @property Kategoria $rodzic
 * @property DostepnyModul $modul
 * @property Widok $widok
 */

class Obiekt extends ObiektDanych
{

	/**
	 * pola obslugiwane przez obiekt
	 * @var array
	 */
	protected $_pola = array(
		'id',
		'idProjektu',
	//	'kodJezyka',
		'prawy',
		'lewy',
		'poziom',
		'czyWidoczna',
		'dlaZalogowanych',
		'wymagaHttps',
		'typ',
		'kodModulu',
		'idWidoku',
		'kontener',
		'akcjaKontener',
		'akcjaUkladStrony',
		'akcjaSzablon',
		'akcjaKlasa',
		'staryUrl',
		'blokada',
		'nazwa',
		'nazwaPrzyjazna',
		'kod',
		'pelnyLink',
		'tytulStrony',
		'opis',
		'slowaKluczowe',
		'idKategorii',
		'adresZewnetrzny',
		'cache',
		'czasCache',
		'skrypt',
		'rssWlaczony',
		'szablon',
		'klasa',
		'naglowekHtml',
		'naglowekHttp',
		'ikona',
		'szablonKatalog'
	);


	// dozwolone typy kategorii
	protected $_typy = array(
	// 'system', // jest w systemie ale nie mozna jej wybrac
		'glowna',
		'menu',
		'kategoria',
		'link_wewnetrzny',
		'link_zewnetrzny',
	);



	function ustawIdRodzica($wartosc)
	{
		$this->_cache['idRodzica'] = (int)$wartosc;
	}



	function pobierzIdRodzica()
	{
		$rodzic = $this->pobierzRodzic();
		if ($rodzic instanceof Kategoria\Obiekt)
		{
			$this->_cache['idRodzica'] = $rodzic->id;
		}
		return $this->_cache['idRodzica'];
	}



	function pobierzRodzic()
	{
		$mapper = Cms::inst()->dane()->Kategoria();
		if (isset($this->_wartosci['id']) && $this->_wartosci['id'] > 0)
		{
			$this->_cache['rodzic'] = $mapper->pobierzRodzica($this->_wartosci['id']);
		}
		elseif (isset($this->_cache['idRodzica']) && $this->_cache['idRodzica'] > 0)
		{
			$this->_cache['rodzic'] = $mapper->pobierzPoId($this->_cache['idRodzica']);
		}
		else
		{
			return false;
		}
		return $this->_cache['rodzic'];
	}



	function pobierzModul()
	{
		$mapper = DostepnyModul\Mapper::wywolaj();
		if (isset($this->_wartosci['kodModulu']) && $this->_wartosci['kodModulu'] != '')
		{
			$this->_cache['modul'] = $mapper->pobierzPoKodzie($this->_wartosci['kodModulu']);
			return $this->_cache['modul'];
		}
		else
		{
			return null;
		}
	}



	function pobierzWidok()
	{
		$mapper = Cms::inst()->dane()->Widok();
		if (isset($this->_wartosci['idWidoku']) && $this->_wartosci['idWidoku'] != '')
		{
			$this->_cache['widok'] = $mapper->pobierzPoId($this->_wartosci['idWidoku']);
			return $this->_cache['widok'];
		}
		else
		{
			return null;
		}
	}



	function pobierzDostepneTypy()
	{
		return $this->_typy;
	}



	function pobierzIdWidokuDlaAkcji($akcja)
	{
		$akcjaUkladStrony = unserialize($this->akcjaUkladStrony);
		if (isset($akcjaUkladStrony) && is_array($akcjaUkladStrony) && array_key_exists($akcja, $akcjaUkladStrony))
		{
			return $akcjaUkladStrony[$akcja];
		}
		else
		{
			return $this->_wartosci['idWidoku'];
		}
	}



	function pobierzKontenerDlaAkcji($akcja)
	{
		$akcjaKontener = unserialize($this->akcjaKontener);
		if (isset($akcjaKontener) && is_array($akcjaKontener) && array_key_exists($akcja, $akcjaKontener))
		{
			return $akcjaKontener[$akcja];
		}
		else
		{
			return $this->_wartosci['kontener'];
		}
	}



	function pobierzSzablonDlaAkcji($akcja)
	{
		$akcjaSzablon = unserialize($this->akcjaSzablon);
		if (isset($akcjaSzablon) && is_array($akcjaSzablon) && array_key_exists($akcja, $akcjaSzablon))
		{
			return $akcjaSzablon[$akcja];
		}
		else
		{
			return $this->_wartosci['szablon'];
		}
	}



	function pobierzKlaseDlaAkcji($akcja)
	{
		$akcjaKlasa = unserialize($this->akcjaKlasa);
		if (isset($akcjaKlasa) && is_array($akcjaKlasa) && array_key_exists($akcja, $akcjaKlasa))
		{
			return $akcjaKlasa[$akcja];
		}
		else
		{
			return $this->_wartosci['klasa'];
		}
	}



	function ustawTyp($wartosc)
	{
		$this->poleSprawdzUstawWartosc('typ', strtolower($wartosc), $this->_typy);
		}



	function generujPelnyLink()
	{
		if (isset($this->_wartosci['typ']) && ($this->_wartosci['typ'] == 'glowna' || $this->_wartosci['typ'] == 'menu'))
		{
			if (!in_array('pelnyLink', $this->_zmodyfikowane)) $this->_zmodyfikowane[] = 'pelnyLink';
			$this->_wartosci['pelnyLink'] = '';
		}
		elseif (isset($this->_wartosci['id']) && $this->_wartosci['id'] > 0)
		{
			$this->_wartosci['pelnyLink'] = '';
			$sciezka = $this->dane()->Kategoria()->zwracaObiekt()->pobierzSciezke($this->_wartosci['id']);
			foreach ($sciezka as $kategoria)
			{
				if (!in_array($kategoria->typ, array('system','glowna','menu')) && $kategoria->id != $this->_wartosci['id'])
				{
					$this->_wartosci['pelnyLink'] .= '/'.$kategoria->kod;
				}
			}
			if (!in_array('pelnyLink', $this->_zmodyfikowane)) $this->_zmodyfikowane[] = 'pelnyLink';
			$this->_wartosci['pelnyLink'] .= (isset($this->_wartosci['kod'])) ? '/'.$this->_wartosci['kod'].'/' : '/';
		}
	}



	function ustawPelnyLink($wartosc)
	{
		trigger_error('Wartosc ustawiana pola pelnyLink jest ustawiana automatycznie podczas zapisu', E_USER_NOTICE);
	}



	function ustawPrawy($wartosc)
	{
		trigger_error('Nie mozna ustwic klucza \'prawy\' obiektu '.get_class($this), E_USER_WARNING);
	}



	function ustawLewy($wartosc)
	{
		trigger_error('Nie mozna ustwic klucza \'lewy\' obiektu '.get_class($this), E_USER_WARNING);
	}



	function ustawPoziom($wartosc)
	{
		trigger_error('Nie mozna ustwic klucza \'poziom\' obiektu '.get_class($this), E_USER_WARNING);
	}



	/*
	 * Przenosi obiekt danych obok kategorii o podanym id
	 *
	 * @param KategorieMapper $mapper Mapper obslugujacy polaczenie z baza
	 * @param int $idNowegoSasiada Identyfikator nowego sasiada
	 * @param string $polozenie Polozenie obok nowego sasiada: 'przed' lub 'po'
	 * @return bool True jezeli sukces, False w przeciwnym wypadku
	 */
	function przeniesObok(Kategoria\Mapper $mapper, $idNowegoSasiada, $polozenie)
	{
		if (!array_key_exists('id', $this->_wartosci) || $this->_wartosci['id'] < 1)
		{
			trigger_error('Nie mozna przenosic obiektu klasy '.get_class($this).' poniewaz nie jest on zapisany w bazie.', E_USER_WARNING);
			return false;
		}
		if ($mapper->przeniesObok($this, $idNowegoSasiada, $polozenie))
		{
			list($lewyId, $prawyId, $poziom) = $mapper->info($this);
			$this->_wartosci['prawy'] = $prawyId;
			$this->_wartosci['lewy'] = $lewyId;
			$this->_wartosci['poziom'] = $poziom;
			return true;
		}
		return false;
	}



	/*
	 * Zmienia kategorie nadrzedna dla bierzacej kategorii
	 *
	 * @param KategorieMapper $mapper Mapper obslugujacy polaczenie z baza
	 * @param int $idNowegoRodzica Identyfikator nowego rodzica
	 *
	 * @return bool True jezeli sukces, False w przeciwnym wypadku
	 */
	function zmienRodzica(Kategoria\Mapper $mapper, $idNowegoRodzica)
	{
		if (!array_key_exists('id', $this->_wartosci) || $this->_wartosci['id'] < 1)
		{
			trigger_error('Nie mozna przenosic obiektu klasy '.get_class($this).' poniewaz nie jest on zapisany w bazie.', E_USER_WARNING);
			return false;
		}
		if ($mapper->zmienRodzica($this, $idNowegoRodzica))
		{
			list($lewyId, $prawyId, $poziom) = $mapper->info($this);
			$this->_wartosci['prawy'] = $prawyId;
			$this->_wartosci['lewy'] = $lewyId;
			$this->_wartosci['poziom'] = $poziom;
			$this->ustawIdRodzica($idNowegoRodzica);
			return true;
		}
		return false;
	}

}
