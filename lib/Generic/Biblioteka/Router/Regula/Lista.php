<?php
namespace Generic\Biblioteka\Router\Regula;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;
use Generic\Model\Kategoria;

/**
 * Sprawdza i tworzy url-e dla list
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Lista extends Router\Regula
{

	/**
	 * Sprawdza czy url jest linkiem do listy
	 * Jezeli znajdzie w url-u kategorie ogloszen ustawia wewnetrzna tablice i zwraca true
	 *
	 * @param string $url
	 * @return boolean
	 */
	public function sprawdzUrl($url)
	{
		if (trim($this->regula->wartosc) == '') return false;

		if (strpos($url, $this->regula->wartosc) !== 0)
		{
			return false;
		}
		$url = str_replace($this->regula->wartosc, '', $url);
		if ( ! preg_match('/^([\w\d,.-]+-f\/)?([\d]+)?$/', $url, $znalezono))
		{
			return false;
		}

		$filtry = (isset($znalezono[1])) ? str_replace('-f/', '', $znalezono[1]) : null;
		$nrStrony = (isset($znalezono[2])) ? $znalezono[2] : null;

		$kategoria = Cms::inst()->dane()->Kategoria()->pobierzPoId($this->regula->idKategorii);
		$kategoria = $this->sprawdzLinkWewnetrzny($kategoria);

		if ($kategoria instanceof Kategoria\Obiekt)
		{
			$this->parametryZadania['kategoria'] = $kategoria;
			$this->parametryZadania['akcja'] = $this->regula->nazwaAkcji;
			$this->parametryZadania['nr_strony'] = $nrStrony;
			if ($filtry != '')
				$this->parsujFiltry($filtry, $this->parametryZadania);
			return true;
		}
		return false;
	}



	/**
	 * Tworzy szablon url do list
	 *
	 * @param array $parametry Tablica parametrow do budowy url-a
	 * @return string
	 */
	public function tworzUrl(Array &$parametry)
	{
		$szablonUrl = strtolower($this->regula->szablonUrl);

		$sciezka = '';
		$sciezka .= $this->tlumaczFiltryNrStrony($parametry, '', '-f/');

		return str_replace('{{sciezka}}', $sciezka, $szablonUrl);
	}

}
