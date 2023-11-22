<?php
namespace Generic\Modul\BlokMenuCzesciowe;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Router;


/**
 * Wyswietlanie menu od wybranej kategorii.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokMenuCzesciowe\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokMenuCzesciowe\Http
	 */
	protected $j;


	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_modulu' => $this->blok->nazwa));

		if ($this->k->k['kategoria_startowa'] > 0)
		{
			$mapper = $this->dane()->Kategoria();
			$kategorie = $mapper->pobierzGalazDoPoziomu($this->k->k['kategoria_startowa'], $this->k->k['maksymalny_poziom']);

			if (count($kategorie) > 0)
			{
				$poprzednia = null;
				$pierwsza = array();
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

				$drzewo = '';
				$poprzednia = null;
				$licznik_wierszy = 0;
				$ilosc_kategorii = count($kategorie);

				foreach ($kategorie as $kategoria)
				{
					$klasa_wiersza = ($licznik_wierszy % 2) ? 'nieparzysty' : 'parzysty';
					$licznik_wierszy ++;
					if ($poprzednia instanceof Kategoria\Obiekt)
					{
						if ($poprzednia->poziom < $kategoria->poziom)
						{
							if ($kategoria->poziom > 1) $drzewo .= $this->szablon->parsujBlok('drzewo/listaStart');
						}
						elseif ($poprzednia->poziom == $kategoria->poziom)
						{
							if ($kategoria->poziom > 1) $drzewo .= $this->szablon->parsujBlok('drzewo/elementStop');
						}
						elseif ($poprzednia->poziom > $kategoria->poziom)
						{
							$powtorz = (int)($poprzednia->poziom - $kategoria->poziom);
							while ($powtorz > 0)
							{
								$drzewo .= $this->szablon->parsujBlok('drzewo/elementStop');
								$drzewo .= $this->szablon->parsujBlok('drzewo/listaStop');
								$powtorz--;
							}
							$drzewo .= $this->szablon->parsujBlok('drzewo/elementStop');
						}
						switch ($kategoria->typ)
						{
							case 'glowna':
								$url = '/';
								break;

							case 'kategoria':
								$url = Router::urlHttp($kategoria,[],null, false);
								break;

							case 'link_wewnetrzny':
								$url = Router::urlHttp($kategoria->idKategorii,[],null, false);
								break;

							case 'link_zewnetrzny':
								$url = $kategoria->adresZewnetrzny;
								break;

							default:
								$url = '';
								break;
						}
						$jest_rodzicem = (bool)in_array($kategoria->id, $rodzic);
						$poziom = $kategoria->poziom - 1;

						$klasa_wiersza .= ($this->kategoria->id == $kategoria->id) ? ' active' : null;
						$klasa_wiersza .= (($licznik_wierszy == $ilosc_kategorii) && $poziom == 1) ? ' last' : null;
						$klasa_wiersza .= ($jest_rodzicem) ? ' parent' : null;
						$klasa_wiersza .= ($this->k->k['oznaczanie_rodzicow'] && in_array($kategoria->id, $rodziceBierzacej)) ? ' thisParent' : null;

						$drzewo .= $this->szablon->parsujBlok('drzewo/elementStart', array(
							'poziom' => $poziom,
							'klasa' => $klasa_wiersza,
						));
						if ($kategoria->czyWidoczna)
						{
							if ($url != '')
							{
								$drzewo .= $this->szablon->parsujBlok('drzewo/elementTrescLink', array(
									'poziom' => $poziom,
									'klasa' => $klasa_wiersza,
									'url' => $url,
									'nazwa' => $kategoria->nazwa,
								));
							}
							else
							{
								$drzewo .= $this->szablon->parsujBlok('drzewo/elementTresc', array(
									'poziom' => $poziom,
									'klasa' => $klasa_wiersza,
									'nazwa' => $kategoria->nazwa,
								));
							}
						}
					}
					$poprzednia = clone $kategoria;
				}
			}
			unset($kategorie);
			$powtorz = (int)($poprzednia->poziom - 1);
			while ($powtorz > 0)
			{
				$drzewo .= $this->szablon->parsujBlok('drzewo/elementStop');
				$drzewo .= $this->szablon->parsujBlok('drzewo/listaStop');
				$powtorz--;
			}

			$this->tresc .= $this->szablon->parsujBlok('index', array('drzewo' => $drzewo));
		}
		else
		{
			$this->komunikat($this->j->t['index.blad_brak_katergorii_startowej'],'info');
		}
	}

}