<?php
namespace Generic\Modul\Platnosci;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Pager;
use Generic\Model\Platnosc;
use Generic\Biblioteka\Zadanie;
use Generic\Model\PlatnoscHistoria;
use Generic\Biblioteka\Platnosc as Platnosci;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Plik;


/**
 * Moduł obsługujący płatności online po stronie administracyjnej.
 *
 * @author Półtorak Dariusz, Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\Platnosci\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Platnosci\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajPodglad',
		'wykonajStatus',
		'wykonajPotwierdz',
		'wykonajAnuluj',
		'wykonajUsun',
		'wykonajCzysc',
	);



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id','', 30, '', true);
		$grid->dodajKolumne('opis', $this->j->t['index.etykieta_opis'], 0, Router::urlAdmin($this->kategoria, 'podglad', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('nazwisko', $this->j->t['index.etykieta_nazwisko'], 0);
		$grid->dodajKolumne('kwota', $this->j->t['index.etykieta_kwota'], 100);
		$grid->dodajKolumne('status', $this->j->t['index.etykieta_status'], 100);
		$grid->dodajKolumne('data_dodania', $this->j->t['index.etykieta_data_dodania'], 150);

		$grid->dodajPrzyciski(
			Router::urlAdmin($this->kategoria, '{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array('podglad')
		);

		$mapper = $this->dane()->Platnosc();

		$kryteria = $this->formularzWyszukiwania($grid);

		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'desc', true, array('strval'));

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$grid->pager($pager->html(Router::urlAdmin($this->kategoria, '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			$sorter = new Platnosc\Sorter($kolumna, $kierunek);
			$pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
			$grid->ustawSortownie(array('data_dodania', 'status', 'nazwisko', 'opis', 'kwota'), $kolumna, $kierunek,
				Router::urlAdmin($this->kategoria, '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			foreach ($mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter) as $platnosc)
			{
				//$platnosc['obiekt'] = $platnosc['nazwa_modulu'] = $platnosc['typ_obiektu_modulu'].' ('.$platnosc['id_obiektu_modulu'].')';
				$platnosc['status'] = $this->j->t['platnosc.status'][$platnosc['status']];
				$platnosc['kwota'] = $platnosc['kwota'].' '.$platnosc['waluta'];
				$grid->dodajWiersz($platnosc);
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('/index', array(
			'grid' => $grid->html(),
			'link_czysc' => Router::urlAdmin($this->kategoria, 'czysc'),
		));
	}



	public function wykonajPodglad()
	{
		$mapper = $this->dane()->Platnosc();
		$platnosc = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

		if ( ! ($platnosc instanceof Platnosc\Obiekt))
		{
			$this->komunikat($this->j->t['podglad.blad_nie_mozna_pobrac_platnosci'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria));
			return;
		}

		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['podglad.tytul_strony']));

		$mapperHistoria = $this->dane()->PlatnoscHistoria();
		$sorter = new PlatnoscHistoria\Sorter('data_dodania','desc');

		$historia = $mapperHistoria->pobierzDlaPlatnosci($platnosc->id, null, $sorter);

		if (is_array($historia) && count($historia) > 0)
		{
			$systemPlatnosci = new Platnosci\PlatnosciPl();
			$systemPlatnosci->ustawKonfiguracje(Cms::inst()->config['platnosci']);

			foreach ($historia as $wiersz)
			{
				$dane_wyslane = ($wiersz->daneWyslane != '') ? unserialize($wiersz->daneWyslane) : array();
				$dane_wyslane = $systemPlatnosci->tlumaczWyslane($dane_wyslane);
				$dane_odebrane = ($wiersz->daneOdebrane != '') ? unserialize($wiersz->daneOdebrane) : array();
				$dane_odebrane = $systemPlatnosci->tlumaczOdebrane($dane_odebrane);

				$this->szablon->ustawBlok('/platnosc/historia/wiersz', array(
					'data_dodania' => $wiersz->dataDodania,
					'operacja' => $this->j->t['platnosc.operacje'][$wiersz->operacja],
					'dane_wyslane' => $this->zamienNaHtml($dane_wyslane),
					'dane_odebrane' => $this->zamienNaHtml($dane_odebrane),
				));
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('/platnosc', array(
			'obiekt' => $platnosc->typObiektu.' ('.$platnosc->idObiektu.')',
			'url' => $platnosc->urlAdministracyjnyObiektu,
			'typ_platnosci' => $this->j->t['systemy_platnosci'][$platnosc->systemPlatnosci],
			'opis' => $platnosc->opis,
			'kwota' => $platnosc->kwota.' '.$platnosc->waluta,
			'status' => $this->j->t['platnosc.status'][$platnosc->status],
			'data_dodania' => $platnosc->dataDodania,
			'link_sprawdz_status' => Router::urlAdmin($this->kategoria, 'status', array('id' => $platnosc->id)),
			'link_potwierdz' => Router::urlAdmin($this->kategoria, 'potwierdz', array('id' => $platnosc->id)),
			'link_anuluj' => Router::urlAdmin($this->kategoria, 'anuluj', array('id' => $platnosc->id)),
			'link_usun' => Router::urlAdmin($this->kategoria, 'usun', array('id' => $platnosc->id)),
		));
	}



	public function wykonajStatus()
	{
		$baza = Cms::inst()->Baza();

		$mapper = $this->dane()->Platnosc();
		$platnosc = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

		if ($platnosc instanceof Platnosc\Obiekt)
		{
			$baza->transakcjaStart();

			if ($platnosc->aktualizujStatus() && $platnosc->aktualizujPowiazanyObiekt())
			{
				$baza->transakcjaPotwierdz();
				$this->komunikat($this->j->t['status.info_zaktualizowano_platnosci'], 'info', 'sesja');
			}
			else
			{
				$baza->transakcjaCofnij();
				$this->komunikat($this->j->t['status.blad_nie_mozna_zaktualizowac_platnosci'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['status.blad_nie_mozna_pobrac_platnosci'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin($this->kategoria, 'podglad', array('id' => $platnosc->id)));
	}



	public function wykonajPotwierdz()
	{
		$baza = Cms::inst()->Baza();

		$mapper = $this->dane()->Platnosc();
		$platnosc = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

		if ($platnosc instanceof Platnosc\Obiekt)
		{
			$baza->transakcjaStart();

			if ($platnosc->potwierdz())
			{
				if ($platnosc->aktualizujStatus() && $platnosc->aktualizujPowiazanyObiekt())
				{
					$baza->transakcjaPotwierdz();
					$this->komunikat($this->j->t['potwierdz.info_zaktualizowano_platnosci'], 'info', 'sesja');
				}
				else
				{
					$baza->transakcjaCofnij();
					$this->komunikat($this->j->t['potwierdz.blad_nie_mozna_zaktualizowac_platnosci'], 'error', 'sesja');
				}
			}
			else
			{
				$baza->transakcjaCofnij();
				$this->komunikat($this->j->t['potwierdz.blad_nie_mozna_wyslac_zadania'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['potwierdz.blad_nie_mozna_pobrac_platnosci'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin($this->kategoria, 'podglad', array('id' => $platnosc->id)));
	}



	public function wykonajAnuluj()
	{
		$baza = Cms::inst()->Baza();

		$mapper = $this->dane()->Platnosc();
		$platnosc = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

		if ($platnosc instanceof Platnosc\Obiekt)
		{
			$platnosc->aktualizujStatus();
			//
			if ($platnosc->status == 'nowa')
			{
				$baza->transakcjaStart();

				if ($platnosc->anuluj())
				{
					if ($platnosc->aktualizujStatus() && $platnosc->aktualizujPowiazanyObiekt())
					{
						$baza->transakcjaPotwierdz();
						$this->komunikat($this->j->t['anuluj.info_zaktualizowano_platnosci'], 'info', 'sesja');
					}
					else
					{
						$baza->transakcjaCofnij();
						$this->komunikat($this->j->t['anuluj.blad_nie_mozna_zaktualizowac_platnosci'], 'error', 'sesja');
					}
				}
				else
				{
					$baza->transakcjaCofnij();
					$this->komunikat($this->j->t['anuluj.blad_nie_mozna_wyslac_zadania'], 'error', 'sesja');
				}
			}
			else
			{
				$this->komunikat($this->j->t['anuluj.blad_status_nie_pozwala_wykonac'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['anuluj.blad_nie_mozna_pobrac_platnosci'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin($this->kategoria, 'podglad', array('id' => $platnosc->id)));
	}



	public function wykonajUsun()
	{
		$mapper = $this->dane()->Platnosc();
		$platnosc = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

		if ( ! $platnosc instanceof Platnosc\Obiekt)
		{
			$this->komunikat($this->j->t['usun.blad_nie_mozna_pobrac_platnosci'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria));
		}
		if ($platnosc->status != 'nierozpoczeta')
		{
			$this->komunikat($this->j->t['usun.blad_platnosc_w_realizacji'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria));
		}

		$cms = Cms::inst();
		$cms->Baza()->transakcjaStart();
		if ($platnosc->aktualizujPowiazanyObiekt(Platnosc\Obiekt::DO_USUNIECIA) && $platnosc->usun($mapper))
		{
			$cms->Baza()->transakcjaPotwierdz();
			$this->komunikat($this->j->t['usun.info_usunieto_platnosc'], 'info', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria));
		}
		else
		{
			$cms->Baza()->transakcjaCofnij();
			$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_platnosci'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'podglad', array('id' => $platnosc->id)));
		}
	}



	public function wykonajCzysc()
	{
		$katalogCache = new Katalog(Cms::inst()->katalog('platnosci'), true);
		$plikCache = new Plik($katalogCache.'/lista.php');

		if ( ! $plikCache->istnieje() || $plikCache->usun())
		{
			$this->komunikat($this->j->t['czysc.info_wyczyszczono_cache'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czysc.blad_nie_mozna_wyczyscic_cache'],'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin($this->kategoria));
	}



	protected function zamienNaHtml($dane)
	{
		if (is_string($dane)) return $dane;
		if (is_array($dane))
		{
			$tekst = '';
			foreach ($dane as $klucz => $wartosc)
			{
				$tekst .= $klucz.': <strong>'.$wartosc."</strong><br/>\n";
			}
			return $tekst;
		}
	}



	private function formularzWyszukiwania(TabelaDanych $grid)
	{
		$obiektFormularza = new \Generic\Formularz\Platnosc\Wyszukiwanie();
		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('index'))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('platnosc'));

		$kryteria = $obiektFormularza->pobierzWartosci();

		$grid->naglowek($obiektFormularza->html($this->ladujSzablonZewnetrzny($this->k->k['index.formularz_wyszukiwarka']), true));

		return $kryteria;
	}

}