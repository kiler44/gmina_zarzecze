<?php
namespace Generic\Modul\LogowanieOperacji;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\Obserwator;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Excel;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\Mapper;


/**
 * Modul administracyjny odpowiedzialny za przeglądanie zalogowanych operacji wykonywanych w modulach.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\LogowanieOperacji\Admin
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\LogowanieOperacji\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajUsun',
		'wykonajPobierzRaport',
		'wykonajRaport'
	);



	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
		$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
		$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
		$kierunek = $this->pobierzParametr('kierunek', 'desc', true, array('strval'));

		$mapper = Obserwator\Mapper::wywolaj(Biblioteka\Mapper\Tablica::ZWRACA_TABLICE);
		$obserwatory = $mapper->pobierzWszystko();

		$pager = new Pager\Html(count($obserwatory), $naStronie, $nrStrony);
		$sorter = new Obserwator\Sorter($kolumna, $kierunek);

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('opis', $this->j->t['index.opis'], 0, Router::urlAdmin('LogowanieOperacji','edytuj', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('typ', $this->j->t['index.typ'], 0, Router::urlAdmin('LogowanieOperacji','edytuj', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('obiekt_docelowy', $this->j->t['index.obiekt_docelowy'], 0, Router::urlAdmin('LogowanieOperacji','edytuj', array('{KLUCZ}' => '{WARTOSC}')));

		$grid->dodajPrzyciski(
			Router::urlAdmin('LogowanieOperacji','{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array('edytuj')
		);

		$grid->dodajPrzyciski(
			Router::urlAdmin('LogowanieOperacji','{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array('usun')
		);

		$grid->ustawSortownie(array('id'), $kolumna, $kierunek,
			Router::urlAdmin('LogowanieOperacji', '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
		);
		$grid->pager($pager->html(Router::urlAdmin('LogowanieOperacji', 'index', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

		foreach ($obserwatory as $wiersz)
		{
			$grid->dodajWiersz($wiersz);
		}

		$this->tresc .= $this->szablon->parsujBlok('/index', array(
			'tabela_danych' => $grid->html(),
			'link_dodaj' => Router::urlAdmin('LogowanieOperacji', 'dodaj'),
			'link_raport' => Router::urlAdmin('LogowanieOperacji', 'raport'),
		));
	}



	public function wykonajDodaj()
	{
		$cms = Cms::inst();

		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));

		$this->tresc .= $this->formularz(new Obserwator\Obiekt());
	}



	public function wykonajEdytuj()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

		$id = Zadanie::pobierz('id','intval','abs');
		$mapper = Obserwator\Mapper::wywolaj();
		$obserwator = $mapper->pobierzPoId($id);

		$this->tresc .= $this->formularz($obserwator);
	}



	public function wykonajUsun()
	{
		$id = Zadanie::pobierz('id','intval','abs');
		$mapper = Obserwator\Mapper::wywolaj();
		$obserwator = $mapper->pobierzPoId($id);
		$obserwator->usun($mapper);

		Router::przekierujDo(Router::urlAdmin('LogowanieOperacji', 'index'));
		return;
	}



	public function wykonajRaport()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['raport.tytul_strony']));

		$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
		$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
		$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
		$kierunek = $this->pobierzParametr('kierunek', 'desc', true, array('strval'));

		$mapper = Obserwator\Mapper::wywolaj(true);
		$obserwatory = $mapper->pobierzWszystko();

		$pager = new Pager\Html(count($obserwatory), $naStronie, $nrStrony);
		$sorter = new Obserwator\Sorter($kolumna, $kierunek);

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('opis', $this->j->t['raport.opis']);
		$grid->dodajKolumne('typ', $this->j->t['raport.typ']);
		$grid->dodajKolumne('obiekt_docelowy', $this->j->t['raport.obiekt_docelowy']);
		$grid->dodajKolumne('przypisane_zdarzenia', $this->j->t['raport.zdarzenia']);

		$grid->ustawSortownie(array('id'), $kolumna, $kierunek,
			Router::urlAdmin('LogowanieOperacji', '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
		);
		$grid->pager($pager->html(Router::urlAdmin('LogowanieOperacji', 'index', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));


		foreach ($obserwatory as $wiersz)
		{
			$przypisaneZdarzenia = array();
			foreach($wiersz['zdarzenia'] as $klucz => $wartosc)
			{
				$temp = preg_split('/_[0-9]+_/', $klucz);
				if(count($temp) > 1)
					$przypisaneZdarzenia[] = $temp[0] . '_'. $temp[1];
				else
					$przypisaneZdarzenia[] = $temp[0];
			}
			$wiersz['przypisane_zdarzenia'] = implode("<br />", $przypisaneZdarzenia);
			$grid->dodajWiersz($wiersz);
		}

		$this->tresc .= $this->szablon->parsujBlok('/raport', array(
			'tabela_danych' => $grid->html(),
			'link_pobierz_raport' => Router::urlAdmin('LogowanieOperacji', 'pobierzRaport'),
		));
	}



	public function wykonajPobierzRaport()
	{
		$xls = Excel::UtworzSzablon();
		$xls->setVersion(8);

		$format_naglowek =& $xls->addFormat();
		$format_naglowek->setTextWrap();
		$format_naglowek->setBold();
		$format_naglowek->setAlign('top');

		// Headers
		$xls->send($this->j->t['raport.nazwa_raportu_xls'] . '.xls');

		$arkusz =& $xls->addWorksheet();
		$arkusz->setInputEncoding('UTF-8');

		$arkusz->setColumn(0, 0, 30);
		$arkusz->setColumn(0, 1, 30);
		$arkusz->setColumn(0, 2, 30);
		$arkusz->setColumn(0, 3, 60);

		$arkusz->write(0, 0, "Opis", $format_naglowek);
		$arkusz->write(0, 1, "Typ", $format_naglowek);
		$arkusz->write(0, 2, "Obiekt docelowy", $format_naglowek);
		$arkusz->write(0, 3, "Zdarzenie", $format_naglowek);

		$mapper = Obserwator\Mapper::wywolaj(true);
		$obserwatory = $mapper->pobierzWszystko();
		$wiersz = 1;

		foreach($obserwatory as $obserwator)
		{
			$przypisaneZdarzenia = array();
			foreach($obserwator['zdarzenia'] as $klucz => $wartosc)
			{
				$temp = preg_split('/_[0-9]+_/', $klucz);
				if(count($temp) > 1)
					$przypisaneZdarzenia[] = $temp[0] . '_'. $temp[1];
				else
					$przypisaneZdarzenia[] = $temp[0];
			}
			foreach($przypisaneZdarzenia as $zdarzenie)
			{
				$arkusz->write($wiersz, 0, $obserwator['opis']);
				$arkusz->write($wiersz, 1, $obserwator['typ']);
				$arkusz->write($wiersz, 2, $obserwator['obiekt_docelowy']);
				$arkusz->write($wiersz, 3, $zdarzenie);
				$wiersz++;
			}
		}

		$xls->close();
	}

	protected function wezZdarzeniaAdministracyjne()
	{
		$mapper = DostepnyModul\Mapper::wywolaj(Mapper::ZWRACA_TABLICE);
		$sorter = new DostepnyModul\Sorter('nazwa', 'asc');
		$moduly = $mapper->pobierzPoTypie('administracyjny', null, $sorter);
		$zdarzenia = array();

		foreach ($moduly as $modul)
		{
			$zdarzenia[$modul['kod']]['nazwa'] = $modul['nazwa'];
			$zdarzenia[$modul['kod']]['kod_modulu'] = $modul['kod'];
			$zdarzenia[$modul['kod']]['poziom'] = 1;

			$klasa = 'Generic\\Modul\\'.$modul['kod'].'\\Admin';
			$instancja = new $klasa;
			$tlumaczenia = $instancja->pobierzTlumaczenia();
			$tlumaczenia = (isset($tlumaczenia['_zdarzenia_etykiety_'])) ? $tlumaczenia['_zdarzenia_etykiety_'] : array();
			foreach ($instancja->pobierzZdarzenia() as $zdarzenie => $klasa)
			{
				if (is_numeric($zdarzenie) && $klasa != '')
				{
					$zdarzenie = $klasa;
					$klasa = '';
			}
				$zdarzenia[$modul['kod']][$zdarzenie] = array(
					'etykieta' => (isset($tlumaczenia[$zdarzenie])) ? $tlumaczenia[$zdarzenie] : $zdarzenie,
					'klasa' => $klasa,
				);
		}
		}
		return $zdarzenia;
	}



	protected function wezZdarzenia()
	{
		$mapper = $this->dane()->Kategoria();
		$kategorie = $mapper->zwracaTablice()->pobierzWszystko();
		$zdarzenia = array();

		foreach ($kategorie as $kategoria)
		{
			if (!in_array($kategoria['typ'], array('kategoria', 'glowna'))) continue;
			if ($kategoria['kod_modulu'] == '') continue;
			$zdarzenia['Http'][$kategoria['id']]['nazwa'] = $kategoria['nazwa'];
			$zdarzenia['Http'][$kategoria['id']]['kod_modulu'] = $kategoria['kod_modulu'];
			$zdarzenia['Http'][$kategoria['id']]['poziom'] = $kategoria['poziom'];
			$zdarzenia['Admin'][$kategoria['id']]['nazwa'] = $kategoria['nazwa'];
			$zdarzenia['Admin'][$kategoria['id']]['kod_modulu'] = $kategoria['kod_modulu'];
			$zdarzenia['Admin'][$kategoria['id']]['poziom'] = $kategoria['poziom'];
			$zdarzenia['Cron'][$kategoria['id']]['nazwa'] = $kategoria['nazwa'];
			$zdarzenia['Cron'][$kategoria['id']]['kod_modulu'] = $kategoria['kod_modulu'];
			$zdarzenia['Cron'][$kategoria['id']]['poziom'] = $kategoria['poziom'];

			$dostepnyModul = DostepnyModul\Mapper::wywolaj()->pobierzPoKodzie($kategoria['kod_modulu']);

			foreach ($dostepnyModul->uslugi as $usluga)
			{
				$klasa = 'Generic\\Modul\\'.$kategoria['kod_modulu'].'\\'.$usluga;
				$instancja = new $klasa;
				$tlumaczenia = $instancja->pobierzTlumaczenia();
				$tlumaczenia = (isset($tlumaczenia['_zdarzenia_etykiety_'])) ? $tlumaczenia['_zdarzenia_etykiety_'] : array();
				foreach ($instancja->pobierzZdarzenia() as $zdarzenie => $klasa)
				{
					if (is_numeric($zdarzenie) && $klasa != '')
					{
						$zdarzenie = $klasa;
						$klasa = '';
				}
					$zdarzenia[$usluga][$kategoria['id']][$zdarzenie] = array(
						'etykieta' => (isset($tlumaczenia[$zdarzenie])) ? $tlumaczenia[$zdarzenie] : $zdarzenie,
						'klasa' => $klasa,
					);
			}
		}

			}
		return $zdarzenia;
	}



	protected function formularz(Obserwator\Obiekt $obserwator)
	{
		$zdarzeniaObserwatora = $obserwator->zdarzenia;


		$this->wstawDoSzablonuBlokTlumaczen('formularz');

		$obiektFormularza = new \Generic\Formularz\Obserwator\Edycja();

		$obiektFormularza->ustawObiekt($obserwator)
			->ustawUrlPowrotny(Router::urlAdmin('LogowanieOperacji','index'))
			->ustawZdarzenia($this->wezZdarzenia())
			->ustawZdarzeniaAdministracyjne($this->wezZdarzeniaAdministracyjne())
			->ustawSzablon($this->szablon)
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawKonfiguracje($this->k->k);

		$wcisnietoZapisz = Zadanie::pobierz('zapisz', 'trim');
		if ($obiektFormularza->wypelniony() && $wcisnietoZapisz)
		{
			//poniewaz da sie submitowac formularz przy wyborze typu musimy
			//wychwycic zapis i wtedy sprawdzac formularz
			if ($obiektFormularza->danePoprawne())
			{
			$dane = $obiektFormularza->pobierzZmienioneWartosci();

			$mapper = Obserwator\Mapper::wywolaj();

				$przypisane_zdarzenia = $zdarzeniaObserwatora;

			foreach ($dane as $klucz => $wartosc)
			{
				if ($klucz == 'opis' || $klucz == 'typ' || $klucz == 'obiekt_docelowy')
					{
					$obserwator->$klucz = $wartosc;
					}
					elseif ($klucz == 'zdarzenia_email')
					{
						$przypisane_zdarzenia = array($wartosc);
					}
				else
				{
						if ($wartosc == 1)
						$przypisane_zdarzenia[$klucz] = $wartosc;
					elseif(isset($przypisane_zdarzenia[$klucz]) && $wartosc == 0)
						unset($przypisane_zdarzenia[$klucz]);
				}
			}
			$obserwator->zdarzenia = $przypisane_zdarzenia;
				$zdarzeniaObserwatora = $obserwator->zdarzenia;
				if ( ! is_array($obserwator->ustawienia)) $obserwator->ustawienia = array();

			$wynik = $obserwator->zapisz($mapper);

				if ($wynik == true)
			{
					$this->komunikat($this->j->t['formularz.info_zapisano_obserwator'], 'info', 'system');

					$edycja_formatki = isset($dane['edycja_formatki']) ? $dane['edycja_formatki'] : false;
					if ($edycja_formatki)
					{
						$zdarzenie = array_pop($zdarzeniaObserwatora);
						if ($zdarzenie != '')
						{
							Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie', 'edytuj', array('id' => $obserwator->obiekt_docelowy, 'zdarzenie' => $klasy[$zdarzenie])).'#tresc_wiadomosci');
							return;
						}
						else
						{
							$this->komunikat($this->j->t['formularz.info_formatka_brak_klasy'], 'warning', 'system');
							Router::przekierujDo(Router::urlAdmin('EmailZarzadzanie', 'edytuj', array('id' => $obserwator->obiekt_docelowy)).'#tresc_wiadomosci');
							return;
						}
					}
				Router::przekierujDo(Router::urlAdmin('LogowanieOperacji', 'index'));
				return;
			}
			else
			{
					$this->komunikat($this->j->t['formularz.info_blad_zapisu_obserwator'], 'info');
			}
			}
		}
		$this->tresc .= $this->szablon->parsujBlok('zaznacz_skrypt');
		return $obiektFormularza->html();
	}

}
