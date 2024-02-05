<?php
namespace Generic\Modul\Aktualnosci;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Pager;
use Generic\Model\Aktualnosc;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Okruszki;


/**
 * Moduł odpowiedzialny za wyswietlanie aktualności.
 *
 * @author Łukasz Wrucha
 * @package moduly
 */

class Http extends Modul\Http
{

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajListaAktualnosci',
		'wykonajAktualnosc',
	);


	/**
	 * @var \Generic\Konfiguracja\Modul\Aktualnosci\Http
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Aktualnosci\Http
	 */
	protected $j;



	public function wykonajIndex()
	{
		$akcja = Zadanie::pobierz('url_parametr_0', 'strval');

		switch($akcja)
		{
			case 'aktualnosc':
				$this->wykonajAkcje('aktualnosc');
				break;

			default:
				$this->wykonajAkcje('listaAktualnosci');
				break;
		}
	}


	public function wykonajListaAktualnosci()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->kategoria->nazwa,
            'podtytul_strony' => $this->kategoria->nazwaPrzyjazna[KOD_JEZYKA],
			'tytul_modulu' => $this->j->t['listaAktualnosci.tytul_modulu'],
		));

		$kryteria = array();
		$kryteria['publikuj'] = true;
		$kryteria['id_kategorii'] = $this->kategoria->id;
		if ($this->k->k['listaAktualnosci.respektuj_date_waznosci'])
		{
			$kryteria['data_waznosci'] = true;
		}

		$mapper = $this->dane()->Aktualnosc();
		$ilosc = $mapper->iloscSzukaj($kryteria);

		$tresc['tytul_modulu'] = $this->j->t['listaAktualnosci.tytul_modulu'];

		if ($ilosc > 0)
		{
			$nrStrony = $this->pobierzParametr('url_parametr_1', 1, true, array('intval','abs'));
			$naStronie = $this->pobierzParametr('url_parametr_2', $this->k->k['listaAktualnosci.wierszy_na_stronie'], false, array('intval','abs'));

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['listaAktualnosci.pager']);
			$pager->ustawTlumaczenia($this->j->t['listaAktualnosci.pager']);
			$pager->ustawSzablon($this->ladujSzablonZewnetrzny($this->k->k['szablon.pager']), false);

			$sortowanie = explode('.', $this->k->k['listaAktualnosci.sortowanie']);

			$sorter = new Aktualnosc\Sorter($sortowanie[0], $sortowanie[1]);
			$aktualnosci = $mapper->szukaj($kryteria, $pager, $sorter);

			$prefix = ($this->k->k['listaAktualnosci.prefix_miniaturki'] != '') ? $this->k->k['listaAktualnosci.prefix_miniaturki'].'-' : '';

			$licznik_aktualnosci = 0;

			foreach($aktualnosci as $aktualnosc)
			{
				$tresc['tytul'] = $aktualnosc->tytul;
				$tresc['link'] = Router::urlHttp($this->kategoria, array('aktualnosc', $aktualnosc->id));
				$tresc['zajawka'] = $aktualnosc->zajawka;
				$tresc['autor'] = $aktualnosc->autor;
                $tresc['data'] = $this->k->k['listaAktualnosci.format_daty_po_polsku'] ? dataGramatyczniePL(strtotime($aktualnosc->dataDodania)) : date($this->k->k['listaAktualnosci.format_daty'], strtotime($aktualnosc->dataDodania));
                $tresc['datetime'] = date($this->k->k['listaAktualnosci.format_daty_datetime'], strtotime($aktualnosc->dataDodania));
				$tresc['klasa_wiersza'] = ($licznik_aktualnosci % 2) ? 'nieparzysty ' : 'parzysty ';
				$tresc['priorytetowa'] = $aktualnosc->priorytetowa;

				$this->szablon->ustawBlok('/listaAktualnosci/lista', $tresc);

				if ($aktualnosc->zdjecieGlowne != '')
				{
					$tresc['zdjecie'] = Cms::inst()->url('aktualnosci', $aktualnosc->id).'/'.$prefix.$aktualnosc->zdjecieGlowne;
					$this->szablon->ustawBlok('/listaAktualnosci/lista/zdjecie_glowne', $tresc);
				}
				else
				{
					$this->szablon->ustawBlok('/listaAktualnosci/lista/brak_zdjecia', $tresc);
				}

				$licznik_aktualnosci++;
			}

			$tresc['pager'] = $pager->html(Router::urlHttp($this->kategoria, array('', '{NR_STRONY}', '{NA_STRONIE}')));

			$this->tresc .= $this->szablon->parsujBlok('listaAktualnosci', $tresc);
		}
		else
		{
			$this->komunikat($this->j->t['listaAktualnosci.blad_brak_aktualnosci'], 'info');
		}

	}


	public function wykonajAktualnosc()
	{
		$id = Zadanie::pobierz('url_parametr_1', 'intval','abs');

		$mapper = $this->dane()->Aktualnosc();
		$aktualnosc = $mapper->pobierzPoId($id);

		if ($aktualnosc instanceof Aktualnosc\Obiekt)
		{
            /*******************************************
             * *****************************************
             * tutaj masz metody do pobrania załączników
             *******************************************
             *******************************************/
            //$urlPlikow = Cms::inst()->url('aktualnosci', $this->obiekt->id);
            //$zalaczniki = $strona->pobierzZalaczniki();
            /**
             * @var Zalacznik\Obiekt $zalacznik
             */
            /*
            foreach($zalaczniki as $zalacznik)
            {
                dump($urlPlikow.$zalacznik->file);
            }
            */

            $this->ustawGlobalne(array(
                
				'tytul_strony' => sprintf($this->j->t['aktualnosc.tytul_strony'], $aktualnosc->tytul),
				'tytul_modulu' => sprintf($this->j->t['aktualnosc.tytul_modulu'], $aktualnosc->tytul),
			));

			Okruszki::wywolaj()->czysc()->dodaj(
				Router::urlHttp($this->kategoria, array('aktualnosc', $aktualnosc->id)),
				sprintf($this->j->t['aktualnosc.tytul_modulu'], $aktualnosc->tytul)
			);

			$tresc['tytul'] = $aktualnosc->tytul;
			$tresc['tresc_krotka'] = $aktualnosc->zajawka;
			$tresc['tresc_pelna'] = $aktualnosc->tresc;
			$tresc['autor'] = $aktualnosc->autor;
            $tresc['etykieta_autor_zdjec'] = $this->j->t['aktualnosc.etykieta_autor_zdjec'];
            $tresc['autor_zdjec'] = $aktualnosc->autorZdjec;
            $tresc['data'] = $this->k->k['listaAktualnosci.format_daty_po_polsku'] ? dataGramatyczniePL(strtotime($aktualnosc->dataDodania)) : date($this->k->k['listaAktualnosci.format_daty'], strtotime($aktualnosc->dataDodania));
            $tresc['datetime'] = date($this->k->k['listaAktualnosci.format_daty_datetime'], strtotime($aktualnosc->dataDodania));
			$tresc['link_wstecz'] = Router::urlHttp($this->kategoria);

			if ($aktualnosc->idGalerii > 0)
			{
				$mapper_zdjecia = $this->dane()->GaleriaZdjecie();
				$zdjecia = $mapper_zdjecia->pobierzOpublikowane($aktualnosc->idGalerii);

				if (count($zdjecia) > 0)
				{
					$mapper_galeria = $this->dane()->Galeria();
					$galeria = $mapper_galeria->pobierzPoId($aktualnosc->idGalerii);

					$galeria_dane = array(
						'tytul_galerii' => $galeria->nazwa,
						'autor_zdjec' => ($galeria->autor != '') ? $galeria->autor : $this->j->t['aktualnosc.autor_zdjec_nieznany'],
					);


					$katalogZdjec = Cms::inst()->url('galeria', $aktualnosc->idGalerii);
					$prefix = (empty($this->k->k['dolaczonaGaleria.prefix_miniaturki']))? null : $this->k->k['dolaczonaGaleria.prefix_miniaturki'].'-';

					foreach($zdjecia as $zdjecie)
					{
						$foto['tytul'] = $zdjecie->tytul;
						$foto['opis'] = $zdjecie->opis;
						$foto['miniaturka'] = $katalogZdjec.$prefix.$zdjecie->nazwaPliku;
						$foto['zdjecie_link'] = $katalogZdjec.$zdjecie->nazwaPliku;
						$foto['lightbox'] = (int)(bool)$this->k->k['dolaczonaGaleria.uzyj_lightbox'];

						$this->szablon->ustawBlok('galeria/miniaturka', $foto);
					}
					$tresc['galeria'] = $this->szablon->parsujBlok('galeria', $galeria_dane);
				}
			}

			$this->szablon->ustawBlok('aktualnosc', $tresc);

			if ($aktualnosc->zdjecieGlowne != '')
			{
				$prefix = (empty($this->k->k['aktualnosc.prefix_miniaturki'])) ? null : $this->k->k['aktualnosc.prefix_miniaturki'].'-';
				$prefix_pelne_zdjecie = (empty($this->k->k['aktualnosc.prefix_pelne_zdjecie'])) ? null : $this->k->k['aktualnosc.prefix_pelne_zdjecie'].'-';

				$tresc_zdjecie['zdjecie'] = Cms::inst()->url('aktualnosci', $aktualnosc->id).'/'.$prefix.$aktualnosc->zdjecieGlowne;
				$tresc_zdjecie['link'] = Cms::inst()->url('aktualnosci', $aktualnosc->id).'/'.$prefix_pelne_zdjecie.$aktualnosc->zdjecieGlowne;
				$tresc_zdjecie['uzyj_lightbox'] = (int)$this->k->k['aktualnosc.uzyj_lightbox'];
				$tresc_zdjecie['tytul'] = $aktualnosc->tytul;
                $tresc_zdjecie['autor_zdjec'] = $aktualnosc->autorZdjec;
                $tresc_zdjecie['etykieta_autor_zdjec'] = $this->j->t['aktualnosc.etykieta_autor_zdjec'];

				$this->szablon->ustawBlok('/aktualnosc/zdjecie_glowne', $tresc_zdjecie);
			}

			$this->tresc .= $this->szablon->parsujBlok('aktualnosc');
		}
		else
		{
			$this->komunikat($this->j->t['aktualnosc.blad_brak_aktualnosci'], 'info');
		}
	}

}


