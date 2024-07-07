<?php
namespace Generic\Modul\Galeria;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;
use Generic\Model\Galeria;
use Generic\Biblioteka\Okruszki;
use Generic\Model\GaleriaZdjecie;
use Generic\Model\Kategoria;


/**
 * Modul odpowiadajacy za wyświetlanie galerii zdjęć.
 *
 * @author Lukasz Wrucha
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\Galeria\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Galeria\Http
	 */
	protected $j;



	protected $plikiDostep = 'public'; // dostepne: 'private', 'public'

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajListaGalerii',
		'wykonajGaleria',
		'wykonajZdjecie',
	);



	public function wykonajIndex()
	{
		$akcja =  Zadanie::pobierz('url_parametr_0', 'strval');

		switch($akcja)
		{
			case 'galeria':
				$this->wykonajAkcje('galeria');
				break;

			case 'zdjecie':
				$this->wykonajAkcje('zdjecie');
				break;

			default:
				$this->wykonajAkcje('listaGalerii');
				break;
		}
	}


	public function wykonajListaGalerii()
	{
		$this->ustawGlobalne(array(
			'tytul_modulu' => $this->j->t['listaGalerii.tytul_modulu'],
			'tytul_strony' => $this->j->t['listaGalerii.tytul_modulu']
		));

		$mapper = $this->dane()->Galeria();
		$maperKategoria = $this->dane()->Kategoria();
        $dzieci = $maperKategoria->zwracaTablice(['id', 'nazwa', 'czy_widoczna'])->pobierzGalaz($this->kategoria->id);

        if(count($dzieci) > 1)
        {
            $kategorieGaleri = $dzieci;
            $kategriaGlowna = $this->kategoria;
            $idKategorii = array_keys(listaZTablicy($dzieci, 'id', 'id'));
        }
        else
        {
            $idKategorii = $this->kategoria->id;
            $rodzic = $maperKategoria->zwracaObiekt()->pobierzRodzica($idKategorii);
            $kategriaGlowna = $rodzic;
            $kategorieGaleri = $maperKategoria->zwracaTablice(['id', 'nazwa', 'czy_widoczna'])->pobierzGalaz($kategriaGlowna->id);
        }

        $ilosc = $mapper->iloscWszystkoOpublikowane(['id_kategorii' => $idKategorii]);


        /**
         * @var Kategoria\Obiekt $kategoria
         */
        foreach ($kategorieGaleri as $kategoria)
        {
            if(!$kategoria['czy_widoczna']) continue;

            $this->szablon->ustawBlok('listaGalerii/kategoriaGalerii', [
                'nazwa' => $kategoria['nazwa'],
                'link' => Router::urlHttp($kategoria['id']),
                'aktywna' => ($kategoria['id'] == $this->kategoria->id)
            ]);
        }

		if ($ilosc > 0)
		{
			$nrStrony = $this->pobierzParametr('url_parametr_1', 1, true, array('intval','abs'));
			$naStronie = $this->pobierzParametr('url_parametr_2', $this->k->k['listaGalerii.wierszy_na_stronie'], true, array('intval','abs'));

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['listaGalerii.pager']);
			$pager->ustawTlumaczenia($this->j->t['listaGalerii.pager']);
			$pager->ustawSzablon($this->ladujSzablonZewnetrzny($this->k->k['szablon.pager']), false);
			$sorter = new Galeria\Sorter('data_dodania');

            /**
             * @var Galeria\Obiekt $galeria
             */
			foreach ($mapper->pobierzWszystkoOpublikowane(['id_kategorii' => $idKategorii], $pager, $sorter) as $galeria)
			{
				if ($galeria->publikuj == 0) continue;

				$zdjecia_mapper = $this->dane()->GaleriaZdjecie();
				$ilosc_zdjec = $zdjecia_mapper->iloscOpublikowane($galeria->id);

				$tresc['nazwa'] = $galeria->nazwa;
				$tresc['opis'] = $galeria->opis;
				$tresc['autor'] = ($galeria->autor == '') ? $this->j->t['listaGalerii.brak_autora'] : str_replace('$autor', $galeria->autor, $this->j->t['listaGalerii.podpis_autor']);
				$tresc['data_dodania'] = $galeria->dataDodania->format($this->k->k['listaGalerii.format_daty']);
				$tresc['ilosc_zdjec'] = $ilosc_zdjec;
				$tresc['link'] = Router::urlHttp($this->kategoria, array('galeria', $galeria->id)); //'?kategoria='.$this->kategoria->id.'&amp;akcja=galeria&amp;galeria='.$galeria->id;//
				$tresc['link_wiecej'] = $this->j->t['listaGalerii.etykieta_link_wiecej'];

                $tresc['kategoria'] = $galeria->pobierzKategorie()->nazwa;
				if ($galeria->zdjecieGlowne != '')
				{
					$prefix = (empty($this->k->k['listaGalerii.prefix_miniaturki'])) ? null : $this->k->k['listaGalerii.prefix_miniaturki'].'-';
					$tresc['zdjecie'] = Cms::inst()->url('galeria', $galeria->id).'/'.$prefix.$galeria->zdjecieGlowne;
					$tresc['zdjecie_alt'] = $galeria->nazwa;

					$this->szablon->ustawBlok('listaGalerii/galeria_wylistowanie/zdjecie_glowne', $tresc);
				}
				else
				{
                    $tresc['zdjecie_alt'] = $this->j->t['listaGalerii.etykieta_brak_zdjecia_glownego'];

					$this->szablon->ustawBlok('listaGalerii/galeria_wylistowanie/brak_zdjecia_glownego', $tresc);
				}
				unset($galeria);
				$this->szablon->ustawBlok('listaGalerii/galeria_wylistowanie', $tresc);
			}

			$podsumowanie['pager'] = $pager->html(Router::urlHttp($this->kategoria, array('', '{NR_STRONY}', '{NA_STRONIE}')));

			$this->szablon->ustawBlok('listaGalerii/podsumowanie', $podsumowanie);

		}
		else
		{
			$this->komunikat($this->j->t['listaGalerii.info_brak_galerii'],'info');
		}
        $this->tresc .= $this->szablon->parsujBlok('listaGalerii', [

        ]);
	}



	public function wykonajGaleria()
	{
		$id = Zadanie::pobierz('url_parametr_1', 'intval','abs');

		$mapper = $this->dane()->Galeria();
		$galeria = $mapper->pobierzPoId($id);

		if ($galeria instanceof Galeria\Obiekt)
		{
			$this->ustawGlobalne(array(
				'tytul_strony' => sprintf($this->j->t['galeria.tytul_strony'], $galeria->nazwa),
				'tytul_modulu' => sprintf($this->j->t['galeria.tytul_modulu'], $galeria->nazwa),
			));

			Okruszki::wywolaj()->czysc()->dodaj(
				Router::urlHttp($this->kategoria, array('galeria', $galeria->id)),
				sprintf($this->j->t['galeria.tytul_modulu'], $galeria->nazwa)
			);

			$mapper = $this->dane()->GaleriaZdjecie();
			$ilosc = $mapper->iloscOpublikowane($id);

			$nrStrony = $this->pobierzParametr('url_parametr_2', 1, true, array('intval','abs'));
			$naStronie = $this->pobierzParametr('url_parametr_3', $this->k->k['galeria.wierszy_na_stronie'], true, array('intval','abs'));

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['galeria.pager']);
			$pager->ustawTlumaczenia($this->j->t['galeria.pager']);
			$pager->ustawSzablon($this->ladujSzablonZewnetrzny($this->k->k['szablon.pager']), false);

			$tresc['opis'] = $galeria->opis;
			$tresc['wstecz_link'] = Router::urlHttp($this->kategoria);
			$tresc['wstecz_etykieta'] = $this->j->t['galeria.etykieta_wstecz'];

			$tresc['pager'] = $pager->html(Router::urlHttp($this->kategoria, array('galeria' ,$id ,'{NR_STRONY}', '{NA_STRONIE}')));

			$this->szablon->ustawBlok('galeria', $tresc);

			$zdjecia = $mapper->pobierzOpublikowane($galeria->id, $pager);

			if (count($zdjecia) > 0)
			{
				$prefix = (empty($this->k->k['galeria.prefix_miniaturki']))? null : $this->k->k['galeria.prefix_miniaturki'].'-';

				foreach ($zdjecia as $zdjecie)
				{
					$tresc['miniaturka'] = Cms::inst()->url('galeria', $id).'/'.$prefix.$zdjecie->nazwaPliku;
					$tresc['tytul'] = $zdjecie->tytul;
					$tresc['opis'] = $zdjecie->opis;
					$tresc['data_dodania'] = $zdjecie->dataDodania->format($this->k->k['galeria.format_daty']);
					$tresc['autor'] = ($zdjecie->autor != '') ? str_replace('$autor', $galeria->autor, $this->j->t['listaGalerii.podpis_autor']) : $this->j->t['galeria.brak_autora'];
                    //$tresc['zdjecie_link'] = Cms::inst()->url('galeria', $id).'/'.$zdjecie->nazwaPliku;

					if($this->k->k['galeria.uzyj_lightbox'])
					{
						$tresc['zdjecie_link'] = Cms::inst()->url('galeria', $id).'/'.$zdjecie->nazwaPliku;
						$tresc['lightbox'] = 'data-toggle="lightbox" data-gallery="galeria-'.$id.'" ';
					}
					else
					{
						$tresc['zdjecie_link'] = Router::urlHttp($this->kategoria, array('zdjecie', $zdjecie->id));
						$tresc['lightbox'] = null;
					}


					$this->szablon->ustawBlok('galeria/miniaturka', $tresc);
				}

				$this->tresc .= $this->szablon->parsujBlok('galeria', array(
					'pager' => $pager->html(Router::urlHttp($this->kategoria, array('galeria' ,$id ,'{NR_STRONY}', '{NA_STRONIE}'))),
                    'opis' => $galeria->opis,
                    'autor' => str_replace('$autor', $galeria->autor, $this->j->t['listaGalerii.podpis_autor']),
                    'data_dodania' => $galeria->dataDodania->format('Y-m-d')
				));
			}
			else
			{
				$this->komunikat($this->j->t['galeria.info_brak_zdjec_w_galerii'], 'info');
			}
		}
		else
		{
			$this->komunikat($this->j->t['galeria.blad_nie_znaleziono_galerii'], 'warning', 'sesja');
			Router::przekierujDo(Router::urlHttp($this->kategoria));
		}
	}



	public function wykonajZdjecie()
	{
		$id = Zadanie::pobierz('url_parametr_1','intval','abs');

		$mapper = $this->dane()->GaleriaZdjecia();
		$zdjecie = $mapper->pobierzPoId($id);

		if($zdjecie instanceof GaleriaZdjecie\Obiekt)
		{
			$galeria_mapper = $this->dane()->Galeria();
			$galeria = $galeria_mapper->pobierzPoId($zdjecie->idGalerii);

			$this->ustawGlobalne(array(
				'tytul_strony' => sprintf($this->j->t['zdjecie.tytul_strony'], $galeria->nazwa),
				'tytul_modulu' => sprintf($this->j->t['zdjecie.tytul_modulu'], $galeria->nazwa),
			));

			Okruszki::wywolaj()->czysc()->dodaj(
				Router::urlHttp($this->kategoria, array('galeria', $galeria->id)),
				sprintf($this->j->t['galeria.tytul_modulu'], $galeria->nazwa)
			);

			$tresc = array();
			$tresc['etykieta_pozostale_zdjecia'] = $this->j->t['zdjecie.etykieta_pozostale_zdjecia'];
			$tresc['wstecz_link'] = Router::urlHttp($this->kategoria, array('galeria', $galeria->id));
			$tresc['wstecz_etykieta'] = $this->j->t['zdjecie.etykieta_wstecz'];
			$tresc['etykieta_pozostale_zdjecia'] = $this->j->t['zdjecie.etykieta_pozostale_zdjecia'];

			$this->szablon->ustawBlok('zdjecie', $tresc);

			$miniaturki = $mapper->pobierzOpublikowane($zdjecie->idGalerii);
			$zdjecia_html = '';
			$prefix = (empty($this->k->k['zdjecie.prefix_miniaturka']))? null : $this->k->k['zdjecie.prefix_miniaturka'].'-';
			$prefix_zdjecie = (empty($this->k->k['zdjecie.prefix_zdjecie']))? null : $this->k->k['zdjecie.prefix_zdjecie'].'-';
			$prefix_pelne_zdjecie = (empty($this->k->k['zdjecie.prefix_pelne_zdjecie']))? null : $this->k->k['zdjecie.prefix_pelne_zdjecie'].'-';
			$czy_lightbox = ($this->k->k['zdjecie.tryb_wyswietlania'] == 'lightbox') ? 'rel="lightbox"' : null;

			foreach ($miniaturki as $numer => $miniaturka)
			{
				$tresc['miniaturka'] = Cms::inst()->url('galeria', $galeria->id).$prefix.$miniaturka->nazwaPliku;
				$tresc['miniaturka_link'] = Cms::inst()->url('galeria', $galeria->id).$prefix_zdjecie.$miniaturka->nazwaPliku;
				$tresc['miniaturka_tytul'] = ($miniaturka->tytul == '') ? $miniaturka->nazwaPliku : $miniaturka->tytul;
				$tresc['miniaturka_id'] = $miniaturka->id;
				$tresc['miniaturka_autor'] = $miniaturka->autor;
				$tresc['miniaturka_opis'] = $miniaturka->opis;

				$this->szablon->ustawBlok('zdjecie/miniaturki', $tresc);

				if($miniaturka->id == $zdjecie->id)
				{
					$miniaturka_index = $numer;
					$tresc = array();

					$tresc['zdjecie'] = Cms::inst()->url('galeria', $galeria->id).$prefix_zdjecie.$zdjecie->nazwaPliku;
					$tresc['zdjecie_tytul'] = ($zdjecie->tytul == '') ? $zdjecie->nazwaPliku : $zdjecie->tytul;
					$tresc['zdjecie_link'] = Cms::inst()->url('galeria', $galeria->id).$prefix_pelne_zdjecie.$zdjecie->nazwaPliku;
					$tresc['zdjecie_lightbox_id'] = $miniaturka->id;

					switch ($this->k->k['zdjecie.tryb_wyswietlania'])
					{
						case 'link':
							$tresc['uzyj_lightbox'] = null;
							$zdjecia_html .= $this->szablon->parsujBlok('zdjecie/zdjecie', $tresc);
							break;

						case 'lightbox':
							$tresc['uzyj_lightbox'] = 'rel="lightbox"';
							$tresc['zdjecie_lightbox_id'] = $zdjecie->id;
							$zdjecia_html .= $this->szablon->parsujBlok('zdjecie/zdjecie', $tresc);
							break;

						default:
							$zdjecia_html .= $this->szablon->parsujBlok('zdjecie/zdjecie_bez_linka', $tresc);
							break;
					}
				}
				else // jesli lightbox to trzeba wygenerowac linki do pozostalych zdjec zeby w lightboxie byly linki kolejne/poprzednie zdjecie
				{
					if($this->k->k['zdjecie.tryb_wyswietlania'] != '')
					{
						$tresc = array();
						$tresc['uzyj_lightbox'] = $czy_lightbox;
						$tresc['zdjecie_lightbox_id'] = $miniaturka->id;
						$tresc['zdjecie_lightbox_link'] = Cms::inst()->url('galeria', $galeria->id).$prefix_pelne_zdjecie.$miniaturka->nazwaPliku;
						$tresc['zdjecie_lightbox_tytul'] = ($miniaturka->tytul == '') ? $miniaturka->nazwaPliku : $miniaturka->tytul;

						$zdjecia_html .= $this->szablon->parsujBlok('zdjecie/zdjecie_lightbox_link', $tresc);
					}
				}

			}
			$zdjecie_tytul = ($zdjecie->tytul == '') ? $zdjecie->nazwaPliku : $zdjecie->tytul;
			$tresc = array();

			$tresc['zdjecie_tytul'] = $zdjecie_tytul;
			$tresc['zdjecie_autor'] = ($zdjecie->autor == '') ? null : $zdjecie->autor;
			$tresc['zdjecie_opis'] = $zdjecie->opis;
			$this->szablon->ustawBlok('zdjecie/zdjecie_opis', $tresc);
			$tresc = array();

			$tresc['zdjecia_html'] = $zdjecia_html;
			$this->szablon->ustawBlok('zdjecie/zdjecia_html', $tresc);

			$tresc = array();

			$tresc['ilosc_miniaturek'] = $this->k->k['zdjecie.slider_ilosc_miniaturek'];
			$tresc['slider_strona'] = floor($miniaturka_index / $tresc['ilosc_miniaturek']);
			$tresc['active_id'] = $id;

			$tresc['uzywa_linki'] = ($this->k->k['zdjecie.tryb_wyswietlania'] != '') ? 'true' : 'false';

			$this->szablon->ustawBlok('zdjecie/java_script', $tresc);

			$this->tresc .= $this->szablon->parsujBlok('zdjecie');
		}
		else
		{
			Router::przekierujDo(Router::urlHttp($this->kategoria));
		}
	}
}

