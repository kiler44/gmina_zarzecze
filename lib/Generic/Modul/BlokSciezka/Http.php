<?php
namespace Generic\Modul\BlokSciezka;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Okruszki;
use Generic\Model\Kategoria;


/**
 * Wyswietlanie sciezki do danej kategorii.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokSciezka\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokSciezka\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_modulu' => $this->blok->nazwa));

		$mapper = $this->dane()->Kategoria();

		$okruszki = Okruszki::wywolaj()->pobierz();
		$okruszkiDodatkowe = (count($okruszki) > 0) ? true : false;

		if (Okruszki::wywolaj()->czyResetowacSciezkeSerwisu() === false)
		{
			$kategoria = $mapper->pobierzGlowna();
			$this->szablon->ustawBlok('/index/link', array(
				'url' => $this->urlHttp($kategoria, 'index'),
				'nazwa' => $kategoria->nazwa,
				'znak_rozdzielajacy' => ($kategoria->id != $this->kategoria->id) ? $this->j->t['index.znak_rozdzielajacy'] : '',
			));
		}

		$sciezka = $mapper->pobierzSciezke($this->kategoria->id);

		if (count($sciezka) > 0)
		{
			if (Okruszki::wywolaj()->czyResetowacSciezkeSerwisu() === false)
			{
				foreach ($sciezka as $kategoria)
				{
					if (in_array($kategoria->typ, array('system', 'glowna', 'menu'))) continue;

					switch ($kategoria->typ)
					{
						case 'kategoria':
							$url = $kategoria->pelnyLink;
							break;

						case 'link_wewnetrzny':
							$docelowa = $mapper->pobierzPoId($kategoria->idKategorii);
							$url = ($docelowa instanceof Kategoria\Obiekt) ? $docelowa->pelnyLink : '';
							break;

						case 'link_zewnetrzny':
							$url = $kategoria->adresZewnetrzny;
							break;

						default:
							$url = '';
							break;
					}
					if ($url != '')
					{
						if (($kategoria->id == $this->kategoria->id && !$okruszkiDodatkowe && !$this->k->k['ostatnia_linkiem']))
						{
                            $this->szablon->ustawBlok('/index/tekst', array(
                                'nazwa' => $kategoria->nazwa,
                            ));
						}
						else
						{
                            $this->szablon->ustawBlok('/index/link', array(
                                'url' => $url,
                                'nazwa' => $kategoria->nazwa,
                                'znak_rozdzielajacy' => ($okruszkiDodatkowe || (!$okruszkiDodatkowe && $kategoria->id != $this->kategoria->id)) ? $this->j->t['index.znak_rozdzielajacy'] : '',
                                'bez_linku' => $kategoria->blokada,
                            ));
						}
					}
				}
			}

			if (count($okruszki) > 0)
			{
				$i = 0;
				foreach ($okruszki as $element)
				{
					++$i;
					if (count($okruszki) > $i || $this->k->k['ostatnia_linkiem'])
					{
						$this->szablon->ustawBlok('/index/link', array(
							'url' => $element['url'],
							'nazwa' => $element['etykieta'],
							'znak_rozdzielajacy' => (count($okruszki) > $i) ? $this->j->t['index.znak_rozdzielajacy'] : '',
						));
					}
					else
					{
						$this->szablon->ustawBlok('/index/tekst', array(
							'nazwa' => $element['etykieta'],
						));
					}
				}
			}
			$this->tresc .= $this->szablon->parsujBlok('/index');
		}
		else
		{
			$this->komunikat($this->j->t['index.blad_brak_kategorii'], 'info');
		}
	}

}


