<?php
namespace Generic\Biblioteka\Router;
use Generic\Model\RegulaRoutingu;
use Generic\Biblioteka\Router;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Cms;

/**
 * Interfejs dla regul sprawdzajacych i tworzacych adresy url
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
abstract class Regula
{

	/**
	 * przetrzymuje obiekt reguły routingu
	 * @var RegulaRoutingu
	 */
	protected $regula;



	/**
	 * Filtr parametrow url
	 * @var Router_FiltrParametry
	 */
	protected $filtrParametrow;



	/**
	 * Dane znalezione w adresie url
	 *
	 * @var array
	 */
	protected $parametryZadania = array();



	/**
	 * Ustawia wewnetrzna regule routingu
	 */
	public function __construct(RegulaRoutingu\Obiekt $regula, Router\FiltrParametry $filtrParametrow = null)
	{
		$this->regula = $regula;
		$this->filtrParametrow = $filtrParametrow;
	}



	/**
	 * Sprawdza adres url
	 * Jezeli znajdzie url spelnia zalozenia ustawia wewnetrzna tablice i zwraca true
	 *
	 * @param string $parametry Tablica parametrow do budowy url-a
	 * @return boolean
	 */
	abstract public function sprawdzUrl($url);



	/**
	 * Tworzy czesc adresu url na podstawie podanych parametrow
	 *
	 * @param array $parametry Tablica parametrow do budowy url-a
	 * @return string
	 */
	abstract public function tworzUrl(Array &$parametry);



	/**
	 * Zwraca parametry zadania znalezione podczas analizy adresu url
	 *
	 * @return array
	 */
	public function pobierzParametry()
	{
		return $this->parametryZadania;
	}



	/**
	 * Sprawdza czy kategoria jest linkiem wewnetrznym a jeżeli tak zwraca kategorie docelowa
	 *
	 * @param mixed $kategoria
	 * @return Ambigous <Kategoria, multitype:, boolean, unknown>|Kategoria
	 */
	public function sprawdzLinkWewnetrzny($kategoria)
	{
		if ($kategoria instanceof Kategoria\Obiekt && $kategoria->typ == 'link_wewnetrzny')
		{
			return Cms::inst()->dane()->Kategoria()->pobierzPoId($kategoria->idKategorii);
		}
		else
		{
			return $kategoria;
		}
	}



	/**
	 * Parsuje sciezke i uzupelnia podana tablice parametrow nie starych kluczy
	 * @param string $sciezka Tresc adresu zawierajaca filtry
	 * @param array $parametry Tablica parametrow do uzupelnienia
	 */
	protected function parsujFiltry($sciezka, Array &$parametry)
	{

		if ($this->filtrParametrow instanceof Router\FiltrParametry)
		{
			$parametrySciezka = $this->filtrParametrow->analizujSciezke($sciezka, ',', '.');

			// nie chcemy nadpisac starych parametrow
			$parametrySciezka = array_replace($parametrySciezka, $parametry);
			$parametry = array_merge($parametry, $parametrySciezka);
		}
	}



	/**
	 * Tlumaczy parametry filtrow i numer strony zadania do url-a
	 * @param array $parametry Tablica parametrow do budowy url-a
	 * @param string $filtryTekstPrzed Tekst do wstawienia przed blokiem filtrow
	 * @param string $filtryTekstPo Tekst do wstawienia po bloku filtrow
	 * @return string
	 */
	protected function tlumaczFiltryNrStrony(Array &$parametry, $filtryTekstPrzed = '', $filtryTekstPo = '')
	{
		$sciezka = '';

		if ($this->filtrParametrow instanceof Router\FiltrParametry)
		{
			$filtry = $this->filtrParametrow->tworzSciezke($parametry);
			if ($filtry != '')
			{
				$sciezka .= $filtryTekstPrzed.$filtry.$filtryTekstPo;
			}
			foreach ($this->filtrParametrow->pobierzParametrySciezka() as $parametr)
			{
				if (isset($parametry[$parametr])) unset($parametry[$parametr]);
			}
		}

		if (isset($parametry['nr_strony']))
		{
			$sciezka .= $parametry['nr_strony'];
			unset($parametry['nr_strony']);
		}

		return $sciezka;
	}

}
