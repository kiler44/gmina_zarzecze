<?php
namespace Generic\Modul\Aktualnosci;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Pager;
use Generic\Model\Aktualnosc;


/**
 * Modul odpowiedzialny za wyswietlanie kanalu rss dla aktualnosci.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Rss extends Modul\Rss
{

	/**
	 * @var \Generic\Konfiguracja\Modul\Aktualnosci\Rss
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Aktualnosci\Rss
	 */
	protected $j;


	public function wykonajIndex()
	{
		$daneKanalu = array(
			'tytul_kanalu' => ($this->j->t['index.tytul_kanalu'] != '') ? $this->j->t['index.tytul_kanalu'] : $this->kategoria->tytul,
			'opis_kanalu' => ($this->j->t['index.opis_kanalu'] != '') ? $this->j->t['index.opis_kanalu'] : $this->kategoria->opis,
			'url_kanalu' => Router::urlHttp($this->kategoria),
			'czas_odswierzania' => $this->k->k['index.odswierzanie_minut'],
			'jezyk_kanalu' => KOD_JEZYKA,
		);

		$mapper = $this->dane()->Aktualnosc();

		$kryteria['publikuj'] = 1;
		$kryteria['id_kategorii'] = $this->kategoria->id;
		if ($this->k->k['index.respektuj_date_waznosci'])
		{
			$kryteria['data_waznosci'] = 1;
		}

		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$pager = new Pager($ilosc, $this->k->k['index.ilosc_na_liscie'], 1);
			$sorter = explode('.', $this->k->k['index.sortuj_po_kolumnie']);
			$sorter = new Aktualnosc\Sorter($sorter[0], $sorter[1]);

			foreach ($mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter) as $aktualnosc)
			{
				$wiersz = array();

				$wiersz['tytul'] = $aktualnosc['tytul'];
				$wiersz['url'] = Router::urlHttp($this->kategoria, array('aktualnosc', $aktualnosc['id']));
				$wiersz['opis'] = str_cut($aktualnosc['zajawka'], $this->k->k['index.dlugosc_opisu']);

				if ($this->k->k['index.pokazuj_date_dodania'])
				{
					$wiersz['data_dodania'] = $aktualnosc['data_dodania'];
				}
				if ($this->k->k['index.pokazuj_autora'])
				{
					$wiersz['autor'] = $aktualnosc['autor'];
				}

				$this->dodajWierszKanalu($wiersz);
			}
		}
		else
		{
			$daneKanalu['opis_kanalu'] .= " \n".$this->j->t['index.info_brak_tresci'];
		}

		$this->daneKanalu($daneKanalu);
	}

}