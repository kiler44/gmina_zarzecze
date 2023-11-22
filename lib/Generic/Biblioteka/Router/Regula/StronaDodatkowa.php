<?php
namespace Generic\Biblioteka\Router\Regula;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;
use Generic\Model\Kategoria;

/**
 * Sprawdza i tworzy url-e dla strony wizytowki
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class StronaDodatkowa extends Router\Regula
{

	/**
	 * Sprawdza czy url jest linkiem do strony na wizytowce
	 *
	 * @param string $url
	 * @return boolean
	 */
	public function sprawdzUrl($url)
	{
		if ( ! preg_match('/^\/([a-z\d][a-z\d-]+[a-z\d])-s([\d]+)$/', $url, $znalezono))
		{
			return false;
		}

		$url_strony = (isset($znalezono[1])) ? $znalezono[1] : null;
		$id_strony = (isset($znalezono[2])) ? $znalezono[2] : null;
		if ($url_strony == '' || $id_strony < 1)
		{
			return false;
		}

		$kategoria = Cms::inst()->dane()->Kategoria()->pobierzPoId($this->regula->idKategorii);
		$kategoria = $this->sprawdzLinkWewnetrzny($kategoria);

		if ($kategoria instanceof Kategoria\Obiekt)
		{
			$this->parametryZadania['kategoria'] = $kategoria;
			$this->parametryZadania['akcja'] = $this->regula->nazwaAkcji;
			$this->parametryZadania['url_strony'] = $url_strony;
			$this->parametryZadania['id_strony'] = $id_strony;
			return true;
		}
		return false;
	}



	/**
	 * Tworzy szablon url do strony wizytowki
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
		if (isset($parametry['url_strony']))
		{
			$sciezka .= $parametry['url_strony'];
			unset($parametry['url_strony']);
		}
		else
		{
			trigger_error('Brak parametru "url_strony" w danych przekazanych do routera', E_USER_WARNING);
		}
		if (isset($parametry['id_strony']))
		{
			$sciezka .= '-s'.$parametry['id_strony'];
			unset($parametry['id_strony']);
		}
		else
		{
			trigger_error('Brak parametru "id_strony" w danych przekazanych do routera', E_USER_WARNING);
		}

		return str_replace('{{sciezka}}', $sciezka, $szablonUrl);
	}

}
