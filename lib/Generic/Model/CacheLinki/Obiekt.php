<?php
namespace Generic\Model\CacheLinki;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\BazaWyjatek;


/**
 * show off @property, @property-read, @property-write
 *
 * @property string $url
 * @property string $typ
 * @property string $dataDodania
 * @property string $listaZawartychUrl
 */

class Obiekt extends ObiektDanych
{

	// pola obslugiwane przez obiekt
	protected $_pola = array(
		'url',
		'typ',
		'dataDodania',
		'listaZawartychUrl',
	);



	// dozwolone typy ogloszen
	protected $_typy = array(
		'blok',
		'podstrona_portalowa',
		'podstrona_wizytowki',
	);



	public function ustawTyp($wartosc)
	{
		$this->poleSprawdzUstawWartosc('typ', strtolower($wartosc), $this->_typy);
	}



	public function pobierzDostepneTypy()
	{
		return $this->_typy;
	}




	public function zapisz(Biblioteka\Mapper\Interfejs $mapper)
	{
		$sql = "REPLACE INTO cms_cache_linki SET
			url = '".addslashes($this->url)."',
			typ = '".addslashes($this->typ)."',
			data_dodania = '".addslashes($this->dataDodania)."',
			lista_zawartych_url = '".addslashes($this->listaZawartychUrl)."'";

		$cms = Cms::inst();
		try
		{
			$cms->Baza()->transakcjaStart();
			$cms->Baza()->zapytanie($sql);
			$cms->Baza()->transakcjaPotwierdz();
			return true;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$cms->Baza()->transakcjaCofnij();
			return false;
		}
	}



	public function usun(Biblioteka\Mapper\Interfejs $mapper)
	{
		$sql = "DELETE FROM cms_cache_linki WHERE url = '".addslashes($this->url)."'";

		$cms = Cms::inst();
		try
		{
			$cms->Baza()->transakcjaStart();
			$cms->Baza()->zapytanie($sql);
			$cms->Baza()->transakcjaPotwierdz();
			return true;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$cms->Baza()->transakcjaCofnij();
			return false;
		}
	}

}
