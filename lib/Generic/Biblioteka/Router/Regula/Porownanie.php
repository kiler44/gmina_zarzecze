<?php
namespace Generic\Biblioteka\Router\Regula;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;
use Generic\Model\Kategoria;

/**
 * Sprawdza i tworzy url-e dla predefiniowanej wartosci
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Porownanie extends Router\Regula
{

	/**
	 * Sprawdza url na podstawie porownania url z wartoscia zapisana w regule
	 * Jezeli znajdzie kategorie ustawia wewnetrzna tablice i zwraca true
	 *
	 * @param string $url
	 * @return boolean
	 */
	public function sprawdzUrl($url)
	{
		$kategorieMapper = Cms::inst()->dane()->Kategoria();
		$kategoria = null;

		if ($url == $this->regula->wartosc)
		{
			$kategoria = $kategorieMapper->pobierzPoId($this->regula->idKategorii);
			$kategoria = $this->sprawdzLinkWewnetrzny($kategoria);
		}

		if ($kategoria instanceof Kategoria\Obiekt)
		{
			$this->parametryZadania['kategoria'] = $kategoria;
			$this->parametryZadania['akcja'] = $this->regula->nazwaAkcji;
			return true;
		}
		return false;
	}



	/**
	 * Tworzy sztywny url na podstawie wartosci z reguly
	 *
	 * @param array $parametry Tablica parametrow do budowy url-a
	 * @return string
	 */
	public function tworzUrl(Array &$parametry)
	{
		return $this->regula->szablonUrl;
	}

}
