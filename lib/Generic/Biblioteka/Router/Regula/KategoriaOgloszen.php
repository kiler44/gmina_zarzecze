<?php
namespace Generic\Biblioteka\Router\Regula;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;
use Generic\Model\KategoriaOgloszenNowa;
use Generic\Model\Kategoria;

/**
 * Sprawdza i tworzy url-e dla kategorii ogloszen
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class KategoriaOgloszen extends Router\Regula
{

	/**
	 * Sprawdza czy url jest linkiem do kategorii ogloszen
	 * Jezeli znajdzie w url-u kategorie ogloszen ustawia wewnetrzna tablice i zwraca true
	 *
	 * @param string $url
	 * @return boolean
	 */
	public function sprawdzUrl($url)
	{
		if ( ! preg_match('/^\/([\/a-z0-9-]+)\/([\w\d,.-]+-f\/)?([\d]+)?$/', $url, $znalezono))
		{
			return false;
		}

		$urlKategorii = (isset($znalezono[1])) ? $znalezono[1] : null;
		$filtry = (isset($znalezono[2])) ? str_replace('-f/', '', $znalezono[2]) : null;
		$nrStrony = (isset($znalezono[3])) ? $znalezono[3] : null;

		$kategoriaOgloszen = Cms::inst()->dane()->KategoriaOgloszenNowa()->pobierzPoUrl($urlKategorii);

		$kategoria = null;
		if ($kategoriaOgloszen instanceof KategoriaOgloszenNowa\Obiekt)
		{
			$kategoria = Cms::inst()->dane()->Kategoria()->pobierzPoId($this->regula->idKategorii);
			$kategoria = $this->sprawdzLinkWewnetrzny($kategoria);
		}

		if ($kategoria instanceof Kategoria\Obiekt)
		{
			$this->parametryZadania['kategoria'] = $kategoria;
			$this->parametryZadania['akcja'] = $this->regula->nazwaAkcji;
			$this->parametryZadania['kategoria_ogloszen'] = $kategoriaOgloszen;
			$this->parametryZadania['url_kategorii'] = $urlKategorii;
			$this->parametryZadania['nr_strony'] = $nrStrony;
			if ($filtry != '')
				$this->parsujFiltry($filtry, $this->parametryZadania);
			return true;
		}
		return false;
	}



	/**
	 * Tworzy szablon url do kategorii ogloszen
	 *
	 * @param array $parametry Tablica parametrow do budowy url-a
	 * @return string
	 */
	public function tworzUrl(Array &$parametry)
	{
		if ($this->regula->kodModulu == 'WizytowkaPodglad')
			$szablonUrl = '{{protokol}}{{subdomena}}{{domena}}{{sciezka}}';
		else
			$szablonUrl = '{{protokol}}{{domena}}{{sciezka}}';

		$sciezka = '/';
		if (isset($parametry['url_kategorii']))
		{
			$sciezka .= $parametry['url_kategorii'].'/';
			unset($parametry['url_kategorii']);
		}
		else
		{
			trigger_error('Brak parametru "url_kategorii" w danych przekazanych do routera', E_USER_WARNING);
		}
		$sciezka .= $this->tlumaczFiltryNrStrony($parametry, '', '-f/');

		return str_replace('{{sciezka}}', $sciezka, $szablonUrl);
	}

}
