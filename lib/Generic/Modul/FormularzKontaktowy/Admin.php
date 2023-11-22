<?php
namespace Generic\Modul\FormularzKontaktowy;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Pager;
use Generic\Model\FormularzKontaktowyWiadomosc;
use Generic\Model\FormularzKontaktowyTemat;
use Generic\Model\WierszKonfiguracji;
use Generic\Biblioteka\Zadanie;


/**
 * Modul odpowiadajacy za zarządzanie formularzem kontaktowym z tematami.
 *
 * @author Łukasz Wrucha
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\FormularzKontaktowy\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\FormularzKontaktowy\Admin
	 */
	protected $j;



	protected $lista_pol = array(
		'tresc' => 'TextArea',
		'imie' => 'Text',
		'nazwisko' => 'Text',
		'firmaNazwa' => 'Text',
		'nadawca' => 'Text',
		'stronaWWW' => 'Text',
		'gg' => 'Text',
		'skype' => 'Text',
		'telefon' => 'Text',
		'komorka' => 'Text',
		'fax' => 'Text',
		'daneOsobowe' => 'CheckboxOpis',
	);


	// Tablica domyslnej konfiguracji 1 - pokaż; 2 - wymagane
	protected $domyslna_konfiguracja = array(
		'imie' => '1',
		'nazwisko' => '1',
		'nadawca' => '2',
		'tresc' => '2',
		'daneOsobowe' => '2',
	);

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajKonfiguruj',
		'wykonajEdytujTrescPrzed',
		'wykonajEdytujTrescPo',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajPodglad',
		'wykonajUsun',
		'wykonajUsunWiadomosc',
	);


	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$tematy = array();
		$mapper_tematy = $this->dane()->FormularzKontaktowyTemat();
		$obiektFormularza = new \Generic\Formularz\FormularzKontaktowy\Wyszukiwanie();
		$obiektFormularza->ustawTematy($mapper_tematy->pobierzDlaKategorii(ID_KATEGORII))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('index'));

		foreach($mapper_tematy->pobierzDlaKategorii(ID_KATEGORII) as $temat)
		{
			$tematy[$temat->id] = $temat->temat;
		}

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('data_wyslania', $this->j->t['index.etykieta_data_wyslania'], 180, Router::urlAdmin($this->kategoria, 'podglad', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('temat', $this->j->t['index.etykieta_temat'], 0, Router::urlAdmin($this->kategoria, 'podglad', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('email', $this->j->t['index.etykieta_email'], 200);
		$grid->dodajKolumne('tresc', $this->j->t['index.etykieta_tresc'], '', Router::urlAdmin($this->kategoria, 'podglad', array('{KLUCZ}' => '{WARTOSC}')));

		$grid->naglowek($obiektFormularza->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

		$grid->dodajPrzyciski(
			Router::urlAdmin($this->kategoria, '{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array(
				'podglad',
				array(
					'akcja' => Router::urlAdmin($this->kategoria, 'usunWiadomosc',array('{KLUCZ}' => '{WARTOSC}')),
					'etykieta' => $this->j->t['index.etykieta_usun'],
					'ikona' => 'icon-remove',
				),
			)
		);
		$grid->dodajPrzyciskiGrupowe(
			Router::urlAdmin($this->kategoria, '{AKCJA}'),
			array(
				'zaznacz',
				'odwroc',
				array(
					'akcja' => Router::urlAdmin($this->kategoria, 'usunWiadomosc'),
					'etykieta' => $this->j->t['index.etykieta_usun'],
					'ikona' => 'icon-remove',
				),
			)
		);

		$kryteria = array_merge(array(), $obiektFormularza->pobierzZmienioneWartosci());
		$mapper = $this->dane()->FormularzKontaktowyWiadomosc();

		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna_wiadomosci', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'desc', true, array('strval'));

			$pager = new Pager\Html($mapper->iloscWszystko(), $naStronie, $nrStrony);
			$sorter = new FormularzKontaktowyWiadomosc\Sorter($kolumna, $kierunek);

			$grid->pager($pager->wyborStrony(Router::urlAdmin($this->kategoria, '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));
			$grid->pagerSelektor($pager->wyborZakresu(Router::urlAdmin($this->kategoria, '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			$grid->ustawSortownie(array('data_wyslania', 'email'), $kolumna, $kierunek,
				Router::urlAdmin($this->kategoria, '', array('kolumna_wiadomosci' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			foreach($mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter) as $wiersz)
			{
				$wiersz['tresc'] = str_cut($wiersz['tresc'], 100);
				$wiersz['temat'] = $tematy[$wiersz['id_tematu']];
				$grid->dodajWiersz($wiersz);
			}
		}
		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'tabela_danych' => $grid->html(),
			'link_konfiguruj' => Router::urlAdmin($this->kategoria, 'konfiguruj'),
			'link_tresc_przed' => Router::urlAdmin($this->kategoria, 'edytujTrescPrzed'),
			'link_tresc_po' => Router::urlAdmin($this->kategoria, 'edytujTrescPo'),
		));
	}



	public function wykonajKonfiguruj()
	{
		$mapper = $this->dane()->FormularzKontaktowyTemat();
		$ilosc = $mapper->iloscDlaKategorii(ID_KATEGORII);

		if ($ilosc < 1) // Temat domyslny
		{
			$temat = new FormularzKontaktowyTemat\Obiekt();
			$temat->idProjektu = ID_PROJEKTU;
			$temat->kodJezyka = KOD_JEZYKA;
			$temat->idKategorii = ID_KATEGORII;
			$temat->temat = $this->k->k['tematDomyslny.temat'];
			$temat->email = serialize(array($this->k->k['tematDomyslny.email']));
			$temat->konfiguracja = serialize($this->domyslna_konfiguracja);

			if($temat->zapisz($mapper))
			{
				$this->komunikat($this->j->t['konfiguruj.info_temat_domyslny_dodany']);
			}
			else
			{
				$this->komunikat($this->j->t['konfiguruj.error_temat_domyslny_dodany'], 'error');
			}
		}

		$naStronie = $this->pobierzParametr('naStronie', $this->k->k['konfiguruj.wierszy_na_stronie'], true, array('intval','abs'));
		$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
		$kolumna = $this->pobierzParametr('kolumna_tematy', $this->k->k['konfiguruj.domyslne_sortowanie'], true, array('strval'));

		if(!in_array($kolumna, array('temat', 'email')))
		$kolumna = $this->k->k['konfiguruj.domyslne_sortowanie'];

		$kierunek = $this->pobierzParametr('kierunek', 'desc', true, array('strval'));

		$mapper = $this->dane()->FormularzKontaktowyTemat();
		$pager = new Pager\Html($mapper->iloscDlaKategorii(ID_KATEGORII), $naStronie, $nrStrony);
		$sorter = new FormularzKontaktowyTemat\Sorter($kolumna, $kierunek);

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('temat', $this->j->t['index.etykieta_temat'], 0, Router::urlAdmin($this->kategoria, 'edytuj', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('email', $this->j->t['index.etykieta_email'], 200);
		$grid->dodajKolumne('emailDw', $this->j->t['index.etykieta_emailDw'], 200);

		$grid->dodajPrzyciski(
			Router::urlAdmin($this->kategoria, '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
			array('edytuj','usun')
		);
		$grid->ustawSortownie(array('temat', 'email'), $kolumna, $kierunek,
			Router::urlAdmin($this->kategoria, 'konfiguruj', array('kolumna_tematy' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
		);
		$grid->dodajPrzyciskiGrupowe(
			Router::urlAdmin($this->kategoria, '{AKCJA}'),
			array('zaznacz','odwroc','usun')
		);

		$grid->pager($pager->wyborStrony(Router::urlAdmin($this->kategoria, '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));
		$grid->pagerSelektor($pager->wyborZakresu(Router::urlAdmin($this->kategoria, '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

		foreach ($mapper->zwracaTablice()->pobierzDlaKategorii(ID_KATEGORII, $pager, $sorter) as $wiersz)
		{
			$wiersz['email'] = implode('<br />', unserialize($wiersz['email']));
			$wiersz['emailDw'] = implode('<br />', unserialize($wiersz['email_dw']));
			if(empty($wiersz['email'])) $wiersz['email'] = $this->j->t['konfiguruj.brak_adresu_email'];
			$grid->dodajWiersz($wiersz);
		}

		$this->szablon->ustawBlok('/konfiguruj', array(
			'tabela_danych' => $grid->html(),
			'link_wstecz' => Router::urlAdmin($this->kategoria, 'index'),
			'etykieta_wstecz' => $this->j->t['konfiguruj.etykieta_wstecz'],
			'link_dodaj' => Router::urlAdmin($this->kategoria, 'dodaj'),
			'etykieta_dodaj' => $this->j->t['konfiguruj.etykieta_dodaj'],
		));
		$this->tresc .= $this->szablon->parsujBlok('konfiguruj');
	}



	public function wykonajEdytujTrescPrzed()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytujTrescPrzed.tytul_strony']));

		$mapper = $this->dane()->WierszKonfiguracji();
		$wiersz = $mapper->pobierzWierszDlaModulu('formularz.tekst_przed_formularzem', 'FormularzKontaktowy_Http', $this->kategoria->id, null);

		if (!($wiersz instanceof WierszKonfiguracji\Obiekt))
		{
			$wiersz = new WierszKonfiguracji\Obiekt;
			$wiersz->idProjektu = ID_PROJEKTU;
			$wiersz->kodJezyka = KOD_JEZYKA;
			$wiersz->typ = 'string';
			$wiersz->nazwa = 'formularz.tekst_przed_formularzem';
			$wiersz->idKategorii = $this->kategoria->id;
			$wiersz->kodModulu = 'FormularzKontaktowy_Http';
		}

		$obiektFormularza = new \Generic\Formularz\FormularzKontaktowy\TrescPrzed();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('edytujTrescPrzed'))
			->ustawObiekt($wiersz)
			->ustawKategorieLinkow($this->kategoria);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$dane = $obiektFormularza->pobierzWartosci();
			$wiersz->wartosc = $dane['trescPrzed'];

			if ($wiersz->zapisz($mapper))
			{
				$this->komunikat($this->j->t['edytujTrescPrzed.info_zapisano_tresc'], 'info', 'sesja');
				Router::przekierujDo(Router::urlAdmin($this->kategoria));
				return;
			}
			else
			{
				$this->komunikat($this->j->t['edytujTrescPrzed.blad_nie_mozna_zapisac_tresci'], 'error');
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('edytujTrescPrzed', array(
			'formularz' => $obiektFormularza->html(),
		));
	}



	public function wykonajEdytujTrescPo()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytujTrescPo.tytul_strony']));

		$mapper = $this->dane()->WierszKonfiguracji();
		$wiersz = $mapper->pobierzWierszDlaModulu('formularz.tekst_za_formularzem', 'FormularzKontaktowy_Http', $this->kategoria->id, null);

		if (!($wiersz instanceof WierszKonfiguracji\Obiekt))
		{
			$wiersz = new WierszKonfiguracji\Obiekt;
			$wiersz->idProjektu = ID_PROJEKTU;
			$wiersz->kodJezyka = KOD_JEZYKA;
			$wiersz->typ = 'string';
			$wiersz->nazwa = 'formularz.tekst_za_formularzem';
			$wiersz->idKategorii = $this->kategoria->id;
			$wiersz->kodModulu = 'FormularzKontaktowy_Http';
		}

		$obiektFormularza = new \Generic\Formularz\FormularzKontaktowy\TrescPrzed();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('edytujTrescPo'))
			->ustawObiekt($wiersz)
			->ustawKategorieLinkow($this->kategoria);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$dane = $obiektFormularza->pobierzWartosci();
			$wiersz->wartosc = $dane['trescPrzed'];

			if ($wiersz->zapisz($mapper))
			{
				$this->komunikat($this->j->t['edytujTrescPo.info_zapisano_tresc'], 'info', 'sesja');
				Router::przekierujDo(Router::urlAdmin($this->kategoria));
				return;
			}
			else
			{
				$this->komunikat($this->j->t['edytujTrescPo.blad_nie_mozna_zapisac_tresci'], 'error');
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('edytujTrescPo', array(
			'formularz' => $obiektFormularza->html(),
		));
	}



	public function wykonajDodaj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));

		$temat = new FormularzKontaktowyTemat\Obiekt();
		$temat->idProjektu = ID_PROJEKTU;
		$temat->kodJezyka = KOD_JEZYKA;
		$temat->idKategorii = ID_KATEGORII;

		$dane['formularz'] = $this->formularz($temat);

		$this->tresc .= $this->szablon->parsujBlok('dodaj', $dane);
	}




	public function wykonajEdytuj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

		$mapper = $this->dane()->FormularzKontaktowyTemat();

		$temat = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));

		if ($temat instanceof FormularzKontaktowyTemat\Obiekt)
		{
			$dane['formularz'] = $this->formularz($temat);
		}
		else
		{
			$this->komunikat($this->j->t['edytuj.blad_nie_mozna_pobrac_danych'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
		}
		$this->tresc .= $this->szablon->parsujBlok('edytuj', $dane);
	}



	public function wykonajPodglad()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['podglad.tytul_strony']));

		$id = Zadanie::pobierz('id','intval','abs');
		$mapper = $this->dane()->FormularzKontaktowyWiadomosc();

		$wiadomosc = $mapper->pobierzPoId($id);
		if ($wiadomosc instanceof FormularzKontaktowyWiadomosc\Obiekt)
		{
			$obiektFormularza = new \Generic\Formularz\FormularzKontaktowy\Podglad();
			$obiektFormularza->ustawObiekt($wiadomosc)
				->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
				->ustawListaPol($this->lista_pol)
				->ustawKategorieLinkow($this->kategoria);

			$this->tresc .= $obiektFormularza->html();
		}
		else
		{
			$this->komunikat($this->j->t['podglad.error_podglad_wiadomosci'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
		}
	}



	public function wykonajUsun()
	{
		$ids = Zadanie::pobierz('id','intval', 'abs');

		if (is_array($ids))
		{
			$komunikat = $this->j->t['usun.info_usunieto_wiele'];
			$komunikat_blad = $this->j->t['usun.error_usunieto_wiele'];
		}
		else
		{
			$komunikat = $this->j->t['usun.info_usunieto'];
			$komunikat_blad = $this->j->t['usun.error_usunieto'];
		}
		$ids = (array)$ids;
		$mapper = $this->dane()->FormularzKontaktowyTemat();

		$blad = 0;

		foreach ($ids as $id)
		{
			$wiersz = $mapper->pobierzPoId($id);
			if ( ! $wiersz instanceof FormularzKontaktowyTemat\Obiekt
				|| ! $wiersz->usun($mapper))
			{
				$blad++;
			}
		}

		if ($blad == 0)
		{
			$this->komunikat($komunikat, 'info', 'sesja');
		}
		else
		{
			$this->komunikat($komunikat_blad, 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin($this->kategoria, 'konfiguruj'));
	}



	public function wykonajUsunWiadomosc()
	{
		$ids = Zadanie::pobierz('id','intval','abs');
		if (is_array($ids))
		{
			$komunikat = $this->j->t['usun.info_wiadomosc_usunieto_wiele'];
			$komunikat_blad = $this->j->t['usun.error_wiadomosc_nie_usunieto_wiele'];
		}
		else
		{
			$komunikat = $this->j->t['usun.info_wiadomosc_usunieto'];
			$komunikat_blad = $this->j->t['usun.error_wiadomosc_nie_usunieto'];
		}

		$ids = (array)$ids;
		$mapper = $this->dane()->FormularzKontaktowyWiadomosc();

		$blad = 0;
		foreach($ids as $id)
		{
			$wiersz = $mapper->pobierzPoId($id);
			if ($wiersz instanceof FormularzKontaktowyWiadomosc\Obiekt)
			{
				if(!$wiersz->usun($mapper))
				{
					$blad++;
				}
			}
			else
			{
				$blad++;
			}
		}

		if ($blad == 0)
		{
			$this->komunikat($komunikat, 'info', 'sesja');
		}
		else
		{
			$this->komunikat($komunikat_blad, 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
	}



	protected function formularz(FormularzKontaktowyTemat\Obiekt $temat)
	{
		if ($temat->id > 0)
		{
			$konfiguracja = unserialize($temat->konfiguracja);
		}
		else
		{
			// Domyślne ustawienia dla nowo tworzonego tematu
			$konfiguracja = $this->domyslna_konfiguracja;
		}

		$obiektFormularza = new \Generic\Formularz\FormularzKontaktowy\TematEdycja();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawObiekt($temat)
			->ustawListaPol($this->lista_pol)
			->ustawKategorieLinkow($this->kategoria)
			->ustawKonfiguracje($konfiguracja);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$this->zapiszTemat($temat, $obiektFormularza);
		}
		return $obiektFormularza->html();
	}



	protected function zapiszTemat($temat, $formularz)
	{
		if ($temat->id > 0)
		{
			$komunikat = $this->j->t['zapiszTemat.dane_zapisane'];
			$komunikat_blad = $this->j->t['zapiszTemat.blad_zapisu_danych'];
		}
		else
		{
			$komunikat = $this->j->t['zapiszTemat.temat_dodany'];
			$komunikat_blad = $this->j->t['zapiszTemat.blad_temat_dodany'];
		}

		foreach ($formularz->pobierzWartosci() as $klucz => $wartosc)
		{
			if ($klucz == 'email' || $klucz == 'emailDw')
			{
				$temat->$klucz = serialize($wartosc);
			}
			elseif (strpos($klucz, 'pole_') === false)
			{
				$temat->$klucz = $wartosc;
			}
			elseif ($wartosc > 0)
			{
				$pola[substr($klucz, 5)] = $wartosc;
			}
		}
		$temat->konfiguracja = serialize($pola);

		$mapper = $this->dane()->FormularzKontaktowyTemat();
		if ($temat->zapisz($mapper))
		{
			$this->komunikat($komunikat, 'info', 'sesja');
		}
		else
		{
			$this->komunikat($komunikat_blad, 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin($this->kategoria, 'konfiguruj'));
	}

}


