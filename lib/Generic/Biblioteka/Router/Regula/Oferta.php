<?php
namespace Generic\Biblioteka\Router\Regula;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;
use Generic\Model\Kategoria;

/**
 * Sprawdza i tworzy url-e dla oferty
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Oferta extends Router\Regula
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
		if ( ! preg_match('/^\/([a-z\d][a-z\d-]+[a-z\d])-o([\d]+)$/', $url, $znalezono))
		{
			return false;
		}

		$url_oferty = (isset($znalezono[1])) ? $znalezono[1] : null;
		$id_oferty = (isset($znalezono[2])) ? $znalezono[2] : null;
		if ($url_oferty == '' || $id_oferty < 1)
		{
			return false;
		}

		$kategoria = Cms::inst()->dane()->Kategoria()->pobierzPoId($this->regula->idKategorii);
		$kategoria = $this->sprawdzLinkWewnetrzny($kategoria);

		if ($kategoria instanceof Kategoria\Obiekt)
		{
			$this->parametryZadania['kategoria'] = $kategoria;
			$this->parametryZadania['akcja'] = $this->regula->nazwaAkcji;
			$this->parametryZadania['url_oferty'] = $url_oferty;
			$this->parametryZadania['id_oferty'] = $id_oferty;
			return true;
		}
		return false;
	}



	/**
	 * Tworzy szablon url do oferty
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
		if (isset($parametry['url_oferty']))
		{
			$sciezka .= $parametry['url_oferty'];
			unset($parametry['url_oferty']);
		}
		else
		{
			trigger_error('Brak parametru "url_oferty" w danych przekazanych do routera', E_USER_WARNING);
		}
		if (isset($parametry['id_oferty']))
		{
			$sciezka .= '-o'.$parametry['id_oferty'];
			unset($parametry['id_oferty']);
		}
		else
		{
			trigger_error('Brak parametru "id_oferty" w danych przekazanych do routera', E_USER_WARNING);
		}

		return str_replace('{{sciezka}}', $sciezka, $szablonUrl);
	}

}
