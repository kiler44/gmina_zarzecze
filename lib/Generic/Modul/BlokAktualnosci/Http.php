<?php
namespace Generic\Modul\BlokAktualnosci;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Pager;
use Generic\Model\Aktualnosc;


/**
 * Blok odpowiedzialny za zarządzanie wyświetlanie skrotów aktualności.
 *
 * @author Łukasz Wrucha
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokAktualnosci\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokAktualnosci\Http
	 */
	protected $j;



	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_modulu' => $this->blok->nazwa));

		$kategorieMapper = $this->dane()->Kategoria();
		$aktualnosciMapper = $this->dane()->Aktualnosc();

		$kryteria = array();
		if (isset($this->k->k['idKategorii']) && $this->k->k['idKategorii'] != '')
		{
			$kategoria = $kategorieMapper->pobierzPoId($this->k->k['idKategorii']);
			if($kategoria instanceof Kategoria\Obiekt)
			{
				$kryteria['id_kategorii'] = $this->k->k['idKategorii'];
				$kategorie[0] = $kategorieMapper->pobierzPoId($kryteria['id_kategorii']);
			}
			else
			{
				$this->komunikat($this->j->t['index.blad_brak_kategorii'], 'warning');
				return;
			}
		}

		//link wiecej w kontenerze moze byc generowany tylko jeżeli mamy ustalona kategorie dla aktualnsci
		$linkWiecej = (isset($kryteria['id_kategorii']) && $kryteria['id_kategorii'] > 0) ? htmlspecialchars(($kategorie[0] instanceof Kategoria\Obiekt) ? Router::urlHttp($kategorie[0]) : null) : '';
		$this->ustawGlobalne(array('link_url' => $linkWiecej));
		$this->ustawGlobalne(array('link_etykieta' => $this->j->t['index.etykieta_link_wiecej']));

		//te opcje nie powinny sie znajdowac linku, zeby ktos nie kombinowal
		$kryteria['publikuj'] = 1;
		if ($this->k->k['index.respektuj_date_waznosci'])
		{
			$kryteria['data_waznosci'] = 1;
		}

		$mapper = $this->dane()->Aktualnosc();
		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$pager = new Pager($ilosc, $this->k->k['index.ilosc_na_liscie'], 1);
			$sorter = explode('.', $this->k->k['index.sortuj_po_kolumnie']);
			$sorter = new Aktualnosc\Sorter($sorter[0], $sorter[1]);

			$prefix = ($this->k->k['index.prefix_miniaturki'] != '') ? $this->k->k['index.prefix_miniaturki'].'-' : null;

			$licznik = 0;
			foreach ($mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter) as $aktualnosc)
			{
				if (isset($kategoria))
				{
					$kategoriaUrl = $kategoria;
				}
				else
				{
					$k = $kategorieMapper->pobierzPoId($aktualnosc['id_kategorii']);
					if ($k instanceof Kategoria\Obiekt)
					{
						$kategoriaUrl = $k;
					}
					else
					{
						continue;
					}
				}

                $dane['lp'] = $licznik;
				$dane['klasa'] = ($licznik % 2) ? 'parzysty' : 'nieparzysty';
				$dane['tytul'] = str_cut($aktualnosc['tytul'], $this->k->k['index.znakow_w_tytule']);
				$dane['url'] = Router::urlHttp($kategoriaUrl, array('aktualnosc', $aktualnosc['id']));
				$dane['tytul_alt'] = $aktualnosc['tytul'];
				$dane['data_dodania'] = date($this->k->k['index.format_daty'], strtotime($aktualnosc['data_dodania']));
				$dane['url_wiecej'] = Router::urlHttp($kategoriaUrl);

				$this->szablon->ustawBlok('/index/wiersz', $dane);

				if ($this->k->k['index.pokazuj_zdjecie'] && $aktualnosc['zdjecie_glowne'] != '')
				{
					$dane['zdjecie'] = Cms::inst()->url('aktualnosci',$aktualnosc['id']).'/'.$prefix.$aktualnosc['zdjecie_glowne'];
					$this->szablon->ustawBlok('/index/wiersz/zdjecie_glowne', $dane);
				}

				if ($this->k->k['index.pokazuj_zajawke'])
				{
					$dane['zajawka_tresc'] = str_cut($aktualnosc['zajawka'], $this->k->k['index.dlugosc_zajawki']);
					$this->szablon->ustawBlok('/index/wiersz/zajawka', $dane);

					if ($this->k->k['index.pokazuj_link_wiecej_przy_aktualnosci'])
					{
						$this->szablon->ustawBlok('index/wiersz/zajawka/link_wiecej', $dane);
					}
				}

				if ($this->k->k['index.pokazuj_autora'])
				{
					$this->szablon->ustawBlok('index/wiersz/autor', $aktualnosc);
				}

				$licznik++;
			}

			if($this->k->k['index.pokazuj_link_wiecej'])
			{
				$this->szablon->ustawBlok('/index/link_wiecej', $dane);
			}
			$this->tresc .= $this->szablon->parsujBlok('index', array(
				'klasa' => $this->k->k['index.klasa_nadrzedna_listy']
			));
		}
		else
		{
			$this->komunikat($this->j->t['index.info_nie_znaleziono_aktualnosci'], 'info');
		}
	}

}