<?php
namespace Generic\Modul\UdostepnianiePlikow;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Pager;
use Generic\Model\UdostepnianyPlik;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\ObiektDanych;
use Generic\Model\PlikPrywatny;
use Generic\Biblioteka\Walidator;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Plik;
use Generic\Model\PlikPrywatnyUzytkownikPowiazanie;


/**
 * Moduł odpowiedzialny za zarządzanie plikami udostępnianymi użytkownikom.
 *
 * @author Półtorak Dariusz, Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\UdostepnianiePlikow\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\UdostepnianiePlikow\Admin
	 */
	protected $j;


	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajUsun',
		'wykonajUsunPlik',
	);



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$formularz = new Formularz('', $this->wykonywanaAkcja);
		$formularz->input(new Input\Submit('szukaj', '', array('wartosc' => $this->j->t['index.etykieta_input_szukaj'])));
		$formularz->input(new Input\Text('fraza', $this->j->t['index.etykieta_input_fraza']));
		$formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		$formularz->input(new Input\Select('data_dodania', $this->j->t['index.etykieta_input_data_dodania'], array(
			'lista' => $this->j->t['data_dodania_opcje'],
			'wybierz' => $this->j->t['index.etykieta_select_wybierz'],
		)));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('tytul', $this->j->t['index.etykieta_tytul'], 0, Router::urlAdmin($this->kategoria, 'edytuj', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('data_dodania', $this->j->t['index.etykieta_data_dodania'], 150);
		$grid->dodajKolumne('plik', $this->j->t['index.etykieta_plik'], 255);
		$grid->dodajKolumne('autor', $this->j->t['index.etykieta_dodal'], 255);

		$grid->naglowek($formularz->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

		$grid->dodajPrzyciski(
			Router::urlAdmin($this->kategoria, '{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array('edytuj','usun')
		);

		$grid->dodajPrzyciskiGrupowe(
			Router::urlAdmin($this->kategoria, '{AKCJA}'),
			array('zaznacz','odwroc','usun')
		);

		$kryteria = array();
		$kryteria['id_kategorii'] = $this->kategoria->id;
		$kryteria = array_merge($kryteria, $formularz->pobierzZmienioneWartosci());

		$mapper = $this->dane()->UdostepnianyPlik();
		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'desc', true, array('strval'));

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
			$sorter = new UdostepnianyPlik\Sorter($kolumna, $kierunek);

			$grid->ustawSortownie(array('data_dodania', 'tytul'), $kolumna, $kierunek,
				Router::urlAdmin($this->kategoria, '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			$grid->pager($pager->html(Router::urlAdmin($this->kategoria, '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			foreach($mapper
					->zwracaTablice(array('id', 'data_dodania', 'tytul', 'plik', 'autor'))
					->szukaj($kryteria, $pager, $sorter) as $UdostepnianyPlik)
			{
				$UdostepnianyPlik['plik'] = basename($UdostepnianyPlik['plik']);
				$grid->dodajWiersz($UdostepnianyPlik);
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'tabela_danych' => $grid->html(),
			'link_dodaj' => Router::urlAdmin($this->kategoria, 'dodaj'),
		));
	}



	public function wykonajDodaj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));

		$UdostepnianyPlik = new UdostepnianyPlik\Obiekt();

		$dane['form'] = $this->formularz($UdostepnianyPlik);

		$this->tresc .= $this->szablon->parsujBlok('dodaj', $dane);
	}




	public function wykonajEdytuj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

		$mapper = $this->dane()->UdostepnianyPlik();

		$UdostepnianyPlik = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));

		if ($UdostepnianyPlik instanceof UdostepnianyPlik\Obiekt)
		{
			$dane['form'] = $this->formularz($UdostepnianyPlik);
		}
		else
		{
			$this->komunikat($this->j->t['edytuj.blad_nie_mozna_pobrac_pliku'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
		}
		$this->tresc .= $this->szablon->parsujBlok('dodaj', $dane);
	}



	public function wykonajUsun()
	{
		$ids = (array)Zadanie::pobierz('id', 'intval');
		$mapper = $this->dane()->UdostepnianyPlik();

		foreach($ids as $id)
		{
			if ($id < 1) continue;

			$UdostepnianyPlik = $mapper->pobierzPoId($id);

			if ($UdostepnianyPlik instanceof UdostepnianyPlik\Obiekt)
			{
				$katalog = new Katalog(Cms::inst()->katalog('udostepniane_pliki', $UdostepnianyPlik->id));

				$PlikiPrywatneMapper = $this->dane()->PlikPrywatny();
				$plikPrywatny = $PlikiPrywatneMapper->pobierzPoId($UdostepnianyPlik->plik);

				if (( ! $katalog->istnieje() || $katalog->usun()) && $UdostepnianyPlik->usun($mapper))
				{
					if ($plikPrywatny instanceof ObiektDanych)
					{
						$plikPrywatny->usun($PlikiPrywatneMapper);
					}
					$this->komunikat($this->j->t['usun.info_usunieto_plik'], 'info', 'sesja');
				}
				else
				{
					$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_pliku'], 'error', 'sesja');
				}
			}
			else
			{
				$this->komunikat($this->j->t['usun.blad_nie_mozna_pobrac_pliku'], 'error', 'sesja');
			}
		}
		Router::przekierujDo(Router::urlAdmin($this->kategoria));
	}



	public function wykonajUsunPlik()
	{
		$mapper = $this->dane()->UdostepnianyPlik();
		$UdostepnianyPlik = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));

		if ($UdostepnianyPlik instanceof UdostepnianyPlik\Obiekt)
		{
			$katalog = new Katalog(Cms::inst()->katalog('udostepniane_pliki', $UdostepnianyPlik->id));

			if ( ! $katalog->istnieje() || $katalog->usun())
			{
				$PlikiPrywatneMapper = $this->dane()->PlikPrywatny();
				$plikPrywatny = $PlikiPrywatneMapper->pobierzPoId($UdostepnianyPlik->plik);
				if ($plikPrywatny instanceof ObiektDanych)
				{
					$plikPrywatny->usun($PlikiPrywatneMapper);
				}

				$UdostepnianyPlik->plik = null;
				$UdostepnianyPlik->zapisz($mapper);
				$this->komunikat($this->j->t['usunPlik.info_usunieto_plik'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usunPlik.blad_nie_mozna_usunac_pliku'], 'error', 'sesja');
			}
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'edytuj', array('id' => $UdostepnianyPlik->id)));
		}
		else
		{
			$this->komunikat($this->j->t['usunPlik.blad_nie_mozna_pobrac_pliku'], 'error');
		}
	}



	private function formularz($UdostepnianyPlik)
	{
		$katalog = new Katalog(Cms::inst()->katalog('udostepniane_pliki'), true);
		if ( ! $katalog->doZapisu())
		{
			$this->komunikat($this->j->t['formularz.blad_katalog_niedostepny'], 'warning');
		}

		if ($UdostepnianyPlik->id < 1) // Domyślne ustawienia dla nowo tworzonej aktualności
		{
			$UdostepnianyPlik->dataDodania = date("Y-m-d H:i:s");
		}
		else
		{
			$plikMapper = $this->dane()->PlikPrywatny();
			$plik = $plikMapper->pobierzPoId($UdostepnianyPlik->plik);
			if($plik instanceof PlikPrywatny\Obiekt)
			{
				$plik = basename($plik->url);
			}
			else
			{
				$plik = '';
			}
		}

		$formularz = new Formularz('', 'plikiFormularz');

		$formularz->input(new Input\Text('tytul', $this->j->t['formularz.etykieta_input_tytul'], array(
			'wartosc' => $UdostepnianyPlik->tytul,
			'atrybuty' => array('style' => 'width: 90%;', 'maxlength' => 255),
			'wymagany' => true,
		), $this->j->t['formularz.opis_input_tytul']));
		$formularz->tytul->dodajWalidator(new Walidator\NiePuste);
		$formularz->tytul->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		if ($katalog->doZapisu())
		{
			$formularz->input(new Input\Plik('plik', $this->j->t['formularz.etykieta_input_plik'], array(
				'wartosc' => array('name' => (($UdostepnianyPlik->plik != '') ? $plik : '')),
				'sciezka_plikow' => Cms::inst()->url('udostepniane_pliki', $UdostepnianyPlik->id),
			), $this->j->t['formularz.opis_input_plik']));
			$formularz->plik->dodajWalidator(new Walidator\PoprawnyUpload());
		}
		else
		{
			trigger_error('Katalog dla udostępnianych plików nie ma praw do zapisu danych');
		}

		$formularz->input(new Input\TextArea('tresc', $this->j->t['formularz.etykieta_input_tresc'], array(
			'wartosc' => $UdostepnianyPlik->tresc,
			'wymagany' => true,
			'ckeditor' => true,
			'ckeditor_przelacznik' => true,
		), $this->j->t['formularz.opis_input_tresc']));
		$formularz->tresc->dodajFiltr('filtr_xss', 'trim');
		$formularz->tresc->dodajWalidator(new Walidator\NiePuste);

		$formularz->input(new Input\DataCzasSelect('dataWaznosci', $this->j->t['formularz.etykieta_input_data_waznosci'], array(
			'wartosc' => $UdostepnianyPlik->dataWaznosci,
			'wybierz' => $this->j->t['formularz.etykieta_data_wybierz'],
			'datepicker' => true,
		), $this->j->t['formularz.opis_input_data_waznosci']));
		$formularz->dataWaznosci->dodajWalidator(new Walidator\DataCzasIso);

		$PlikiUzytkownikMapper = $this->dane()->PlikPrywatnyUzytkownikPowiazanie();

		$uzytkownicyMapper = $this->dane()->Uzytkownik();
		$lista_uzytkownikow = array();
		$plik_uzytkownicy = array();
		$lista_uzytkownikow = (array)$PlikiUzytkownikMapper->zwracaTablice()->pobierzPoPliku($UdostepnianyPlik->plik);
		if(count($lista_uzytkownikow) > 0)
		{
			foreach($lista_uzytkownikow as $k => $w)
			{
				$plik_uzytkownicy[] = $w['id_uzytkownika'];
			}
		}
		$wszyscyUzytkownicy = $uzytkownicyMapper->zwracaTablice()->pobierzWszystko(null, new Uzytkownik\Sorter('nazwisko','asc'));
		if (is_array($wszyscyUzytkownicy) && count($wszyscyUzytkownicy) > 0)
		{
			$tab = array();
			foreach($wszyscyUzytkownicy as $k => $w)
			{
				$tab[$w['id']] = $w['nazwisko'].' '.$w['imie'].' ('.$w['login'].')';
			}
			$wszyscyUzytkownicy = $tab;
			$formularz->input(new Input\MultiCheckbox('uprawnienia', $this->j->t['formularz.etykieta_input_uprawnienia'], array(
				'lista' => $wszyscyUzytkownicy,
				'wartosc' => $plik_uzytkownicy,
			)));
		}
		$formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->j->t['formularz.etykieta_zapisz']
		)));
		$formularz->stopka(new Input\Button('wstecz', '', array(
			'wartosc' => $this->j->t['formularz.etykieta_wstecz'],
			'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin($this->kategoria, 'index').'\'' )
		)));

		if ($formularz->wypelniony())
		{
			if($formularz->dataWaznosci->pobierzWartosc() != '' && $formularz->dataWaznosci->pobierzWartosc() != '0000-00-00 00:00:00')
			{
				$formularz->dataWaznosci->dodajWalidator(new Walidator\WiekszeOd(date("Y-m-d H:i:s"), true));
			}

			if ($formularz->danePoprawne())
			{
				$uprawnienia = array();
				foreach($formularz->pobierzWartosci() as $klucz => $wartosc)
				{
					if ($klucz == 'plik')
					{
						$plik = $wartosc;
						continue;
					}
					if ($klucz == 'uprawnienia')
					{
						$uprawnienia = $wartosc;
						continue;
					}
					$UdostepnianyPlik->$klucz = $wartosc;
				}
				$UdostepnianyPlik->dataDodania = date("Y-m-d H:i:s");

				if ($UdostepnianyPlik->dataWaznosci == '') $UdostepnianyPlik->dataWaznosci = null;

				$this->zapiszPlik($UdostepnianyPlik, $plik);
				$this->zapiszUprawnienia($UdostepnianyPlik, $uprawnienia);

				Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
			}
		}
		return $formularz->html();
	}



	protected function zapiszPlik($UdostepnianyPlik, $plik)
	{
		$cms = Cms::inst();

		if ($UdostepnianyPlik->id > 0)
		{
			$info = $this->j->t['edytuj.info_plik_zapisany'];
			$blad = $this->j->t['edytuj.blad_nie_mozna_zapisac_pliku'];
		}
		else
		{
			$info = $this->j->t['dodaj.info_plik_zapisany'];
			$blad = $this->j->t['dodaj.blad_nie_mozna_zapisac_pliku'];

			$UdostepnianyPlik->idProjektu = ID_PROJEKTU;
			$UdostepnianyPlik->kodJezyka = KOD_JEZYKA;
			$UdostepnianyPlik->idKategorii = $this->kategoria->id;
		}
		$UdostepnianyPlik->autor = $cms->profil()->pelnaNazwa;

		$mapper = $this->dane()->UdostepnianyPlik();
		if ($UdostepnianyPlik->zapisz($mapper))
		{
			$this->komunikat($info, 'info', 'sesja');
		}
		else
		{
			$this->komunikat($blad, 'error', 'sesja');
		}
		if (is_array($plik) && isset($plik['error']) && $plik['error'] === UPLOAD_ERR_OK)
		{
			$katalog = new Katalog(Cms::inst()->katalog('udostepniane_pliki', $UdostepnianyPlik->id), true);

			$nazwa_pliku = Plik::unifikujNazwe($plik['name']);
			$plik = new Plik($plik['tmp_name']);
			$plik->przeniesDo($katalog.'/'.$nazwa_pliku);

			$UdostepnianyPlik->plik = $nazwa_pliku;

			$PlikiPrywatneMapper = $this->dane()->PlikPrywatny();
			$plikPrywatny = new PlikPrywatny\Obiekt();
			$plikPrywatny->idProjektu = ID_PROJEKTU;
			$plikPrywatny->url = Cms::inst()->url('udostepniane_pliki', $UdostepnianyPlik->id).$UdostepnianyPlik->plik;
			$plikPrywatny->zapisz($PlikiPrywatneMapper);
			$UdostepnianyPlik->plik = $plikPrywatny->id;
			$UdostepnianyPlik->zapisz($mapper);
		}
	}



	protected function zapiszUprawnienia(UdostepnianyPlik\Obiekt $UdostepnianyPlik, $uzytkownicy)
	{
		$PlikiUzytkownikMapper = $this->dane()->PlikPrywatnyUzytkownikPowiazanie();
		$plikiMapper = $this->dane()->PlikPrywatny()->zwracaTablice();
		if($UdostepnianyPlik)
		{
			$id_pliku = $UdostepnianyPlik->plik;
			$PlikiUzytkownikMapper->usunDlaPliku($id_pliku);
			if(is_array($uzytkownicy) && count($uzytkownicy) > 0)
			{
				foreach($uzytkownicy as $id_uzytkownika)
				{
					$PlikiUzytkownik = new PlikPrywatnyUzytkownikPowiazanie\Obiekt();
					$PlikiUzytkownik->idProjektu = ID_PROJEKTU;
					$PlikiUzytkownik->idPliku = $id_pliku;
					$PlikiUzytkownik->idUzytkownika = $id_uzytkownika;
					$PlikiUzytkownik->zapisz($PlikiUzytkownikMapper);
				}
			}
		}
	}

}
