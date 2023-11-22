<?php
namespace Generic\Modul\UdostepnianiePlikow;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Pager;
use Generic\Model\UdostepnianyPlik;
use Generic\Biblioteka\Router;


/**
 * Moduł odpowiedzialny za udostępnianie plików użytkownikom.
 *
 * @author Półtorak Dariusz, Krzysztof Lesiczka
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\UdostepnianiePlikow\Http
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\UdostepnianiePlikow\Http
	 */
	protected $j;



	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->kategoria->tytul_strony,
			'tytul_modulu' => $this->j->t['index.tytul_modulu'],
		));

		$kryteria = array();
		$kryteria['publikuj'] = 1;
		$kryteria['id_kategorii'] = $this->kategoria->id;
		$kryteria['id_uzytkownika'] = $cms->profil()->id;

		$mapper = $this->dane()->UdostepnianyPlik();

		$ilosc = $mapper->policzPowiazane($kryteria);

		$tresc['tytul_modulu'] = $this->j->t['index.tytul_modulu'];

		if ($ilosc > 0)
		{
			$nrStrony = $this->pobierzParametr('url_parametr_1', 1, true, array('intval','abs'));
			$naStronie = $this->pobierzParametr('url_parametr_2', $this->k->k['index.wierszy_na_stronie'], false, array('intval','abs'));

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['index.pager']);
			$pager->ustawTlumaczenia($this->j->t['index.pager']);
			$pager->ustawSzablon($this->ladujSzablonZewnetrzny($this->k->k['szablon.pager']), false);

			$sortowanie = explode('.', $this->k->k['index.sortowanie']);

			//
			// USUWAMY PRZEDAWNIONE
			//
			$IloscPrzedawnionePliki = $mapper->iloscSzukaj(array('data_waznosci' => -1));
			if($IloscPrzedawnionePliki > 0)
			{
				$PlikiPrywatneUzytkownicyPowiazaniaMapper = $this->dane()->PlikPrywatnyUzytkownikPowiazanie();
				$PrzedawnioneUprawnienia = $mapper->szukajIdPliku(array('data_waznosci' => -1));
				foreach($PrzedawnioneUprawnienia as $PrzedawnioneUprawnienie)
				{
					$do_usuniecia = $PlikiPrywatneUzytkownicyPowiazaniaMapper->pobierzPoPliku($PrzedawnioneUprawnienie->plik);
					if(is_array($do_usuniecia) && count($do_usuniecia) > 0)
					{
						foreach($do_usuniecia as $plik)
						{
							$plik->usun($PlikiPrywatneUzytkownicyPowiazaniaMapper);
						}
					}
				}
			}

			$kryteria['data_waznosci'] = 1;

			$sorter = new UdostepnianyPlik\Sorter($sortowanie[0], $sortowanie[1]);
			$UdostepnianePliki = $mapper->szukajPowiazane($kryteria, $pager, $sorter);



			$licznik_plikow = 0;

			foreach($UdostepnianePliki as $UdostepnianyPlik)
			{
				$link = Cms::inst()->url('udostepniane_pliki', $UdostepnianyPlik->id).basename($UdostepnianyPlik->plik);
				$tresc['tytul'] = $UdostepnianyPlik->tytul;
				$tresc['link'] = $link;
				$tresc['tresc'] = $UdostepnianyPlik->tresc;
				$tresc['autor'] = $UdostepnianyPlik->autor;
				$tresc['data'] = date($this->k->k['index.format_daty'], strtotime($UdostepnianyPlik->dataDodania));
				$tresc['klasa_wiersza'] = ($licznik_plikow % 2) ? 'nieparzysty ' : 'parzysty ';
				$this->szablon->ustawBlok('/listaPlikow/lista', $tresc);

				if ($UdostepnianyPlik->plik != '')
				{
					$tresc['zdjecie'] = $link;
					$this->szablon->ustawBlok('/listaPlikow/lista/plik', $tresc);
				}
				else
				{
					$this->szablon->ustawBlok('/listaPlikow/lista/brak_pliku', $tresc);
				}

				$licznik_plikow++;
			}


			$tresc['pager'] = $pager->html(Router::urlHttp($this->kategoria, array('', '{NR_STRONY}', '{NA_STRONIE}')));

			$this->tresc .= $this->szablon->parsujBlok('listaPlikow', $tresc);
		}
		else
		{
			$this->komunikat($this->j->t['index.blad_brak_pliku'], 'info');
		}
	}
}


