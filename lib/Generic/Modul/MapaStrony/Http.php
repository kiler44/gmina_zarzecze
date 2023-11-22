<?php
namespace Generic\Modul\MapaStrony;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Router;


/**
 * Modul odpowiedzialny za wyświetlanie mapy strony
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\MapaStrony\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\MapaStrony\Http
	 */
	protected $j;


	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['index.tytul_strony'],
			'tytul_modulu' => $this->j->t['index.tytul_modulu'],
		));

		$wybrane = $this->k->k['wybrane_kategorie_startowe'];
		$mapper = $this->dane()->Kategoria();

		if ( ! is_array($wybrane) || count($wybrane) < 1)
		{
			$wybrane = array();
			$kategoria = $mapper->pobierzGlowna();
			$wybrane[] = ($kategoria instanceof Kategoria\Obiekt) ? $kategoria->id : null;
		}

		$drzewo = '';
		foreach ($wybrane as $id)
		{
			$kategorie = $mapper->pobierzGalaz($id);

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

				$poprzednia = null;
				$licznik_wierszy = 0;

				foreach ($kategorie as $kategoria)
				{
					$kategoria_ma_podkategorie = (bool)in_array($kategoria->id, $rodzic);

					$klasa_wiersza = ($licznik_wierszy % 2) ? 'nieparzysty' : 'parzysty';
					$licznik_wierszy ++;
					if ($poprzednia instanceof Kategoria\Obiekt)
					{
						if ($poprzednia->poziom < $kategoria->poziom)
						{
							if ($kategoria->poziom > 1) $drzewo .= $this->szablon->parsujBlok('/drzewo/listaStart');
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
							$maks = (int)($poprzednia->poziom - $kategoria->poziom);
							$i = 0;
							while ($i < $maks)
							{
								$drzewo .= $this->szablon->parsujBlok('/drzewo/elementStop');
								$drzewo .= $this->szablon->parsujBlok('/drzewo/listaStop');
								$i++;
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
						$poziom = $kategoria->poziom - 1;

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
								$drzewo .= $this->szablon->parsujBlok('/drzewo/elementTrescLink', array(
									'poziom' => $poziom,
									'klasa' => $klasa_wiersza,
									'url' => $url,
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
			}
			unset($kategorie);
			$maks = (int)($poprzednia->poziom - 1);
			$i = 0;
			while ($i < $maks)
			{
				$drzewo .= $this->szablon->parsujBlok('/drzewo/elementStop', array());
				$drzewo .= $this->szablon->parsujBlok('/drzewo/listaStop', array());
				$i++;
			}
		}
		$this->tresc .= $this->szablon->parsujBlok('index', array('drzewo' => $drzewo));
	}

}


