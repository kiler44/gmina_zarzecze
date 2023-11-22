<?php
namespace Generic\Modul\BlokMenu;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Router;


/**
 * Blok wyświetlający menu kategorii podstron.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokMenu\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokMenu\Http
	 */
	protected $j;


	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_modulu' => ($this->j->t['index.tytul_modulu'] != '') ? $this->j->t['index.tytul_modulu'] : $this->blok->nazwa));

		$mapper = $this->dane()->Kategoria();
		switch ($this->k->k['typ_menu'])
		{
			case 'gotowe_menu':
			case 'wybrana_rodzicem':
				$kategoriaStartowa = $mapper->pobierzPoId($this->k->k['kategoria_startowa']);
			break;

			case 'biezaca_dzieckiem':
				$sciezka = $mapper->pobierzSciezke($this->kategoria->id);
				foreach ($sciezka as $kategoriaStartowa)
				{
					if ($kategoriaStartowa->poziom > $this->k->k['minimalny_poziom']) break;
				}
			break;

			default:
				$kategoriaStartowa = $mapper->pobierzPoId($this->kategoria->id);
			break;
		}

		if ($kategoriaStartowa instanceof Kategoria\Obiekt)
		{
			if ($this->k->k['maksymalny_poziom'] > 0)
			{
				$kategorie = $mapper->pobierzGalazDoPoziomu($kategoriaStartowa->id, $kategoriaStartowa->poziom + $this->k->k['maksymalny_poziom']);
			}
			else
			{
				$kategorie = $mapper->pobierzGalaz($kategoriaStartowa->id);
			}

			if (count($kategorie) > 0)
			{
				$poprzednia = null;
				$rodzic = array();
				foreach ($kategorie as $kategoria)
				{
					if ($poprzednia instanceof Kategoria\Obiekt)
					{
						if ($poprzednia->poziom < $kategoria->poziom)
						{
							$rodzic[$kategoria->id] = $poprzednia->id;
							$pierwsza[$kategoria->poziom] = $kategoria->id;
						}
						elseif ($poprzednia->poziom == $kategoria->poziom)
						{
							$rodzic[$kategoria->id] = $rodzic[$poprzednia->id];
						}
						elseif ($poprzednia->poziom > $kategoria->poziom)
						{
							$rodzic[$kategoria->id] = $rodzic[$pierwsza[$kategoria->poziom]];
						}
					}
					$poprzednia = $kategoria;
				}

				if ($this->k->k['oznaczanie_rodzicow'])
				{
					$rodziceBierzacej = array();
					foreach ($mapper->pobierzSciezke($this->kategoria->id) as $kategoria)
					{
						$rodziceBierzacej[] = $kategoria->id;
					}
				}

				$linkiSeoWlaczone = (bool)$this->k->k['linki_seo_nowe'];

				if ($linkiSeoWlaczone && ! $this->szablon->zawieraBlok('/drzewo/elementTrescLinkSeo/'))
				{
					trigger_error('Włączono linki seo jednak w szablonie brakuje bloku /drzewo/elementTrescLinkSeo', E_USER_NOTICE);
					$linkiSeoWlaczone = false;
				}

				$drzewo = '';
				$poprzednia = null;
				$licznik_wierszy = 0;
				$ilosc_kategorii = count($kategorie);

				foreach ($kategorie as $kategoria)
				{
					$kategoria_ma_podkategorie = (bool)in_array($kategoria->id, $rodzic);
					$poziom = $kategoria->poziom - 1;

					$klasa_wiersza = ($licznik_wierszy % 2) ? 'nieparzysty' : 'parzysty';
					$licznik_wierszy ++;

					if ($poprzednia instanceof Kategoria\Obiekt)
					{
						if ($poprzednia->poziom < $kategoria->poziom)
						{
							if ($kategoria->poziom > 1) $drzewo .= $this->szablon->parsujBlok('/drzewo/listaStart', array(
									'poziom_glowny' => $poziom == 2 ? 1 : 0,
                                    'poziom' => $poziom,
								));
						}
						elseif ($poprzednia->poziom == $kategoria->poziom)
						{
							if ($poprzednia->czyWidoczna || in_array($poprzednia->id, $rodzic))
							{
								if ($kategoria->poziom > 1) $drzewo .= $this->szablon->parsujBlok('/drzewo/elementStop');
							}
						}
						elseif ($poprzednia->poziom > $kategoria->poziom)
						{
							$powtorz = (int)($poprzednia->poziom - $kategoria->poziom);
							while ($powtorz > 0)
							{
								$drzewo .= $this->szablon->parsujBlok('/drzewo/elementStop');
								$drzewo .= $this->szablon->parsujBlok('/drzewo/listaStop');
								$powtorz--;
							}
							$drzewo .= $this->szablon->parsujBlok('/drzewo/elementStop');
						}

						switch ($kategoria->typ)
						{
							case 'glowna':
								$url = '/';
								break;

							case 'kategoria':
								$url = Router::urlHttp($kategoria);
								break;

							case 'link_wewnetrzny':
								$url = Router::urlHttp($kategoria->idKategorii);
								break;

							case 'link_zewnetrzny':
								$url = $kategoria->adresZewnetrzny;
								break;

							default:
								$url = '';
								break;
						}
						$rel = '';
						if ($this->k->k['seolink'])
						{
							$rel = str_replace(array('http://', 'https://', Router::urlHttp($this->kategoria, array(), '{domena}'), '/', '.html'), array('', '', '', '#', '&'), $url);
						}

						$klasa_wiersza .= ($this->kategoria->id == $kategoria->id || $this->kategoria->id == $kategoria->idKategorii) ? ' active' : null;
						$klasa_wiersza .= (($licznik_wierszy == $ilosc_kategorii) && $poziom == 1) ? ' last' : null;
						$klasa_wiersza .= ($kategoria_ma_podkategorie) ? ' parent' : null;
						$klasa_wiersza .= ($this->k->k['oznaczanie_rodzicow'] && in_array($kategoria->id, $rodziceBierzacej)) ? ' thisParent' : null;

						if ($kategoria->czyWidoczna || $kategoria_ma_podkategorie)
						{
							$drzewo .= $this->szablon->parsujBlok('/drzewo/elementStart', array(
								'poziom' => $poziom,
								'klasa' => $klasa_wiersza,
							));
						}
						if ($kategoria->czyWidoczna)
						{
							if ($url != '')
							{
								$szablonLink = ($linkiSeoWlaczone) ? '/drzewo/elementTrescLinkSeo' : '/drzewo/elementTrescLink';
								if ($linkiSeoWlaczone) $url = strToHex($url);

								$drzewo .= $this->szablon->parsujBlok($szablonLink, array(
									'poziom' => $poziom,
									'klasa' => $klasa_wiersza,
									'url' => $url,
									'rel' => $rel,
									'nazwa' => $kategoria->nazwa,
								));
							}
							else
							{
								$drzewo .= $this->szablon->parsujBlok('/drzewo/elementTresc', array(
									'poziom' => $poziom,
									'klasa' => $klasa_wiersza,
									'nazwa' => $kategoria->nazwa,
								));
							}
						}
					}
					$poprzednia = clone $kategoria;
				}
				if ($kategoria->id != $kategoriaStartowa->id)
				{
					//testowo zmieniona liczba zakonczen
					//$powtorz = (int)($poprzednia->poziom - 1);
					$powtorz = (int)($kategoria->poziom - $kategoriaStartowa->poziom);
					while ($powtorz > 0)
					{
						$drzewo .= $this->szablon->parsujBlok('/drzewo/elementStop');
						$drzewo .= $this->szablon->parsujBlok('/drzewo/listaStop');
						$powtorz--;
					}
				}
			}
			unset($kategorie);
			$drzewo = trim($drzewo);
			if ($drzewo != '')
			{
				$this->tresc .= $this->szablon->parsujBlok('/index', array('drzewo' => $drzewo));
			}
		}
		else
		{
			$this->komunikat($this->j->t['index.blad_brak_katergorii_glownej'],'info');
		}
	}

}