<?php
namespace Generic\Biblioteka\Router\Regula;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;
use Generic\Model\WizytowkaBranza;
use Generic\Model\Kategoria;

/**
 * Sprawdza i tworzy url-e dla kategorii ogloszen
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Branza extends Router\Regula
{

	/**
	 * Sprawdza czy url jest linkiem do branzy
	 * Jezeli znajdzie w url-u branze ustawia wewnetrzna tablice i zwraca true
	 *
	 * @param string $url
	 * @return boolean
	 */
	public function sprawdzUrl($url)
	{
		if ( ! preg_match('/^\/([a-z-]+)\/([\w\d,.-]+-f\/)?([\d]+)?$/', $url, $znalezono))
		{
			return false;
		}

		$urlBranzy = (isset($znalezono[1])) ? $znalezono[1] : null;
		$filtry = (isset($znalezono[2])) ? str_replace('-f/', '', $znalezono[2]) : null;
		$nrStrony = (isset($znalezono[3])) ? $znalezono[3] : null;

		$branza = Cms::inst()->dane()->WizytowkaBranza()->pobierzPoUrl($urlBranzy);

		$kategoria = null;
		if ($branza instanceof WizytowkaBranza\Obiekt)
		{
			$kategoria = Cms::inst()->dane()->Kategoria()->pobierzPoId($this->regula->idKategorii);
			$kategoria = $this->sprawdzLinkWewnetrzny($kategoria);
		}

		if ($kategoria instanceof Kategoria\Obiekt)
		{
			$this->parametryZadania['kategoria'] = $kategoria;
			$this->parametryZadania['akcja'] = $this->regula->nazwaAkcji;
			$this->parametryZadania['branza'] = $branza;
			$this->parametryZadania['url_branzy'] = $urlBranzy;
			$this->parametryZadania['nr_strony'] = $nrStrony;
			if ($filtry != '')
				$this->parsujFiltry($filtry, $this->parametryZadania);
			return true;
		}
		return false;
	}



	/**
	 * Tworzy szablon url do branzy
	 *
	 * @param array $parametry Tablica parametrow do budowy url-a
	 * @return string
	 */
	public function tworzUrl(Array &$parametry)
	{
		$szablonUrl = '{{protokol}}{{domena}}{{sciezka}}';

		$sciezka = '/';
		if (isset($parametry['url_branzy']))
		{
			$sciezka .= $parametry['url_branzy'].'/';
			unset($parametry['url_branzy']);
		}
		else
		{
			trigger_error('Brak parametru "url_branzy" w danych przekazanych do routera', E_USER_WARNING);
		}
		$sciezka .= $this->tlumaczFiltryNrStrony($parametry, '', '-f/');

		return str_replace('{{sciezka}}', $sciezka, $szablonUrl);
	}

}
