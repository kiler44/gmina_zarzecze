<?php
namespace Generic\Modul\RejestrowanieZdarzen;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Router;


/**
 * Moduł odpowiedzialny za rejestrowanie zdarzeń.
 *
 * @author Konrad Rudowski
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\RejestrowanieZdarzen\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\RejestrowanieZdarzen\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$formularz = new Formularz('', 'wyszukiwanieZdarzen', '', 'post', true, true);

		$formularz->input(new Input\DataCzasSelect('dataOd', array('datepicker' => true)))
			->dodajFiltr('addslashes', 'strip_tags');

		$formularz->input(new Input\DataCzasSelect('dataDo', array('datepicker' => true)))
			->dodajFiltr('addslashes', 'strip_tags')
			->dodajWalidator(new Walidator\WiekszeOd($formularz->dataOd->pobierzWartosc()));

		$formularz->input(new Input\Select('zdarzenie', array(
			'lista' => array ('' => $this->j->t['formularzPrzeszukiwania.dowolne']) + $this->pobierzListeZdarzen(),
		)))
			->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($this->pobierzListeZdarzen()) + array('')))
			->dodajFiltr('addslashes', 'strip_tags');

		$formularz->input(new Input\Select('typObiektuGlownego', array(
			'lista' => array ('' => $this->j->t['formularzPrzeszukiwania.dowolne']) + $this->k->k['formularzPrzeszukiwania.listaObiektowGlownych'],
		)))
			->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($this->k->k['formularzPrzeszukiwania.listaObiektowGlownych'])))
			->dodajFiltr('strip_tags');

		$formularz->input(new Input\Text('idObiektuGlownego'))
			->dodajWalidator(new Walidator\LiczbaCalkowita())
			->dodajWalidator(new Walidator\WiekszeOd(0, true))
			->dodajFiltr('addslashes', 'strip_tags');

		$formularz->input(new Input\Text('idPracownika'))
			->dodajWalidator(new Walidator\LiczbaCalkowita())
			->dodajWalidator(new Walidator\WiekszeOd(0, true));

		$formularz->input(new Input\Text('tokenProcesu'))
			->dodajFiltr('addslashes', 'strip_tags');

		$formularz->stopka(new Input\Submit('pokaz'));

		$formularz->ustawTlumaczenia($this->j->pobierzBlokTlumaczen('formularzPrzeszukiwania'));

		$tabelaRaport = '';

		if ($formularz->wypelniony() || count($formularz->pobierzWartosci()) > 0)
		{
			if ($formularz->danePoprawne())
			{
				$tabelaRaport = $this->wygenerujRaportZdarzen($formularz->pobierzWartosci());
			}
			else
			{
				$this->komunikat($this->j->t['index.formularzNiepoprawny'], 'error');
			}
		}
		else
		{
			$formularz->dataOd->ustawWartosc('2013-01-01');
			$formularz->dataDo->ustawWartosc(date('Y-m-d H:i'));
		}

		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'formularz' => $formularz->html(),
			'tabelaRaport' => $tabelaRaport,
		));
	}


	protected function pobierzListeZdarzen()
	{
		if (! (isset(Cms::inst()->sesja->listaDopuszczalnychZdarzen) && count(Cms::inst()->sesja->listaDopuszczalnychZdarzen)))
		{
			$katalog = new Katalog(CMS_KATALOG . '\lib\Generic\Zdarzenie');

			$lista = array();

			foreach ($katalog->pobierzZawartosc(1) as $klucz => $wartosc)
			{
				if ( ! is_array($wartosc))
				{
					$lista[str_replace('.php', '', $klucz)] = str_replace('.php', '', $klucz);
				}
			}

			ksort($lista);

			Cms::inst()->sesja->listaDopuszczalnychZdarzen = $lista;
		}

		return Cms::inst()->sesja->listaDopuszczalnychZdarzen;
	}


	protected function wygenerujRaportZdarzen(Array $filtry)
	{
		$tabela = new \Generic\Biblioteka\TabelaDanych();

		$tabela->dodajKolumne('licznik', '', 0, '', true);
		$tabela->dodajKolumne('timestamp', $this->j->t['raportZdarzen.data']);
		$tabela->dodajKolumne('nazwa', $this->j->t['raportZdarzen.nazwa']);
		$tabela->dodajKolumne('idPracownika', $this->j->t['raportZdarzen.uzytkownik']);
		$tabela->dodajKolumne('typObiektuGlownego', $this->j->t['raportZdarzen.typObiektuGlownego']);
		$tabela->dodajKolumne('idObiektuGlownego', $this->j->t['raportZdarzen.idObiektuGlownego']);
		$tabela->dodajKolumne('tokenProcesu', $this->j->t['raportZdarzen.tokenProcesu']);

		$start = new \MongoDate(strtotime($filtry['dataOd']));
		$koniec = new \MongoDate(strtotime($filtry['dataDo']));

		$kryteria = array(
			'timestamp' => array('wiekszerowne' => $start, 'mniejsze' => $koniec),
		);

		if (isset($filtry['zdarzenie']) && $filtry['zdarzenie'] != '')
		{
			$kryteria['nazwa'] = 'Generic\\Zdarzenie\\' . $filtry['zdarzenie'];
		}

		if (isset($filtry['typObiektuGlownego']) && $filtry['typObiektuGlownego'] != '')
		{
			$kryteria['typObiektuGlownego'] = $filtry['typObiektuGlownego'];
		}

		if (isset($filtry['idObiektuGlownego']) && $filtry['idObiektuGlownego'] > 0)
		{
			$kryteria['idObiektuGlownego'] = (int) $filtry['idObiektuGlownego'];
		}

		if (isset($filtry['idPracownika']) && $filtry['idPracownika'] > 0)
		{
			$kryteria['idPracownika'] = (int) $filtry['idPracownika'];
		}

		if (isset($filtry['tokenProcesu']) && $filtry['tokenProcesu'] != '')
		{
			$kryteria['tokenProcesu'] = $filtry['tokenProcesu'];
		}

		$ilosc = $this->dane()->LogZdarzen()->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);

			$tabela->pager($pager->html(Router::urlAdmin($this->kategoria, '', array('kolumna' => $kolumna, 'kierunek' => $kierunek, 'nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			$tabela->ustawSortownie(array('timestamp', 'nazwa', 'idPracownika', 'typObiektuGlownego', 'idObiektuGlownego', 'tokenProcesu'), $kolumna, $kierunek,
					Router::urlAdmin($this->kategoria, '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}', 'nrStrony' => $nrStrony, 'naStronie' => $naStronie))
				);

			$wiersze = array();
			$idUzytkownikow = array();

			foreach ($this->dane()->LogZdarzen()->szukaj($kryteria, $pager, array($kolumna => $kierunek)) as $log)
			{
				$wiersze[] = array(
					'licznik' => '',
					'timestamp' => $log->timestamp->format('d.m.Y H:i:s'),
					'nazwa' => $log->nazwa,
					'idPracownika' => $log->idPracownika,
					'typObiektuGlownego' => $log->typObiektuGlownego,
					'idObiektuGlownego' => $log->idObiektuGlownego,
					'tokenProcesu' => $log->tokenProcesu,
				);

				$idUzytkownikow[] = $log->idPracownika;
			}

			$nazwyUzytkownikow = $this->pobierzNazwyPracownikow($idUzytkownikow);

			foreach ($wiersze as $wiersz)
			{
				if (isset($nazwyUzytkownikow[$wiersz['idPracownika']]))
				{
					$wiersz['idPracownika'] = $nazwyUzytkownikow[$wiersz['idPracownika']];
				}
				else
				{
					$wiersz['idPracownika'] = $this->j->t['raportZdarzen.pustyWiersz'];
				}
				$tabela->dodajWiersz($wiersz);
			}
		}

		return $tabela->html();
	}


	protected function pobierzNazwyPracownikow(Array $listaId)
	{
		$listaId = array_unique($listaId);

		$lista = array();

		foreach($listaId as $klucz => $wartosc)
		{
			if ($wartosc <= 0)
			{
				unset($listaId[$klucz]);
			}
		}

		if (count($listaId) > 0)
		{
			foreach ($this->dane()->Uzytkownik()->zwracaTablice('id' , 'imie', 'nazwisko')->szukaj(array('wiele_id' => $listaId)) as $uzytkownik )
			{
				$lista[$uzytkownik['id']] = $uzytkownik['id'] . ' (' . $uzytkownik['imie'] . ' ' . $uzytkownik['nazwisko'] . ')';
			}
		}

		return $lista;
	}

}


