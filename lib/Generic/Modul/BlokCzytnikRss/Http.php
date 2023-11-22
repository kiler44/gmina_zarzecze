<?php
namespace Generic\Modul\BlokCzytnikRss;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Katalog;
use Generic\Model\KanalRss;
use Generic\Biblioteka\Mapper;
use Generic\Biblioteka\Pager;


/**
 * Blok odpowiedzialny za wyświetlanie zewnetrznych kanałów rss.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokCzytnikRss\Http
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokCzytnikRss\Http
	 */
	protected $j;



	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_modulu' => $this->blok->nazwa));

		$katalog = new Katalog(Cms::inst()->katalog('czytnik_rss', $this->blok->id), true);
		$przerwa = ($this->k->k['index.cache_rss_czas'] > 0) ? $this->k->k['index.cache_rss_czas'] : 10;
		$czas = floor(time()/($przerwa*60))*($przerwa*60);

		$mapper = KanalRss\Mapper::wywolaj(Mapper::ZWRACA_TABLICE);
		$mapper->kanaly = $this->k->k['index.obslugiwane_kanaly'];
		$mapper->plikCache = $katalog.'/'.date('Y-m-d-H-i-s',$czas).'.php';
		$mapper->zaladujDane();

		// czyscimy cache starszy niz dwa okresy wstecz
		$staryCache = $katalog.'/'.date('Y-m-d-H-i-s',$czas-(2*$przerwa*60)).'.php';
		if (is_file($staryCache)) unlink($staryCache);

		$kryteria = array();
		$ilosc = $mapper->iloscSzukaj($kryteria);
		if ($ilosc > 0)
		{
			$pager = new Pager($ilosc, $this->k->k['index.ilosc_na_liscie'], 1);
			$sorter = explode('.', $this->k->k['index.sortuj_po_kolumnie']);
			$sorter = new KanalRss\Sorter($sorter[0], $sorter[1]);

			foreach ($mapper->szukaj($kryteria, $pager, $sorter) as $wpis)
			{
				$dane['tytul'] = str_cut($wpis['tytul'], $this->k->k['index.znakow_w_tytule']);
				$dane['url'] = $wpis['url'];
				$dane['data_dodania'] = date($this->k->k['index.format_daty'], strtotime($wpis['data_dodania']));

				$this->szablon->ustawBlok('/index/wiersz', $dane);

				if ($this->k->k['index.pokazuj_opis'])
				{
					$dane['opis_tresc'] = str_cut($wpis['opis'], $this->k->k['index.dlugosc_opisu']);
					$this->szablon->ustawBlok('/index/wiersz/opis', $dane);

					if ($this->k->k['index.pokazuj_link_wiecej_przy_opisie'])
					{
						$this->szablon->ustawBlok('index/wiersz/opis/link_wiecej', $dane);
					}
				}
			}
			$this->tresc .= $this->szablon->parsujBlok('/index');
		}
		else
		{
			$this->komunikat($this->j->t['index.info_nie_znaleziono_wpisow'], 'info');
		}
	}

}
