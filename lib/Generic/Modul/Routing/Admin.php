<?php
namespace Generic\Modul\Routing;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Model\RegulaRoutingu;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\TabelaSortowanie;


/**
 * Modul odpowiedzialny za zarzadzanie regułami routingu.
 *
 * @author Konrad Rudowski
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\Routing\Admin
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Routing\Admin
	 */
	protected $j;


	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajUsun',
		'wykonajSortuj',
		'wykonajPrzekierowania',
		'wykonajBlokady',
		'wykonajPobierzAkcjeDlaKategorii'
	);


	protected $zdarzenia = array(
		'dodano_regule',
		'edytowano_regule',
		'usunieto_regule',
		'posortowano_reguly',
	);


	protected $plikPrzekierowania = 'przekierowania301.inc.php';


	protected $plikBlokady = 'blokady404.inc.php';



	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['index.tytul_strony']
		));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['index.etykieta_nazwa'], 200, Router::urlAdmin('Routing','edytuj',array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('kodModulu', $this->j->t['index.etykieta_kodModulu'], 200);
		$grid->dodajKolumne('nazwaAkcji', $this->j->t['index.etykieta_nazwaAkcji'], 100);
		$grid->dodajKolumne('typReguly', $this->j->t['index.etykieta_typReguly'], 50);
		$grid->dodajKolumne('wartosc', $this->j->t['index.etykieta_wartosc'], 200);

		$grid->dodajPrzyciski(
			Router::urlAdmin('Routing','{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array('edytuj', 'usun')
		);

		$mapper = RegulaRoutingu\Mapper::wywolaj(true);

		$ilosc = $mapper->iloscWszystko();

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));

			$pager = new Pager\Html($mapper->iloscWszystko(), $naStronie, $nrStrony);

			$grid->pager($pager->wyborStrony(Router::urlAdmin('Routing', 'index', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			foreach($mapper->zwracaTablice()->pobierzWszystko($pager) as $regula)
			{
				$regula['typReguly'] = $this->j->t['formularz.typyRegul'][$regula['typReguly']];
				$grid->dodajWiersz($regula);
			}

		}

		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'tabela_danych' => $grid->html(),
			'link_dodaj' => Router::urlAdmin('Routing', 'dodaj'),
			'link_sortuj' => Router::urlAdmin('Routing', 'sortuj'),
			'link_przekierowania' => Router::urlAdmin('Routing', 'przekierowania'),
			'link_blokady' => Router::urlAdmin('Routing', 'blokady'),
		));

	}



	public function wykonajDodaj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));

		$this->tresc .= $this->szablon->parsujBlok('dodaj', array(
			'formularz' => $this->budujFormularz(new RegulaRoutingu\Obiekt())
		));
		$this->tresc .= $this->szablon->parsujBlok('skryptyJs', array(
			'urlAjax' => Router::urlAdmin('Routing', 'pobierzAkcjeDlaKategorii', array ('id' => '')),
		));
	}



	public function wykonajEdytuj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

		$mapper = RegulaRoutingu\Mapper::wywolaj();
		$regula = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval'));

		if ( ! ($regula instanceof RegulaRoutingu\Obiekt))
		{
			$this->komunikat($this->j->t['edytuj.blad_nie_mozna_pobrac'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('Routing'));
			return;
		}

		$this->tresc .= $this->szablon->parsujBlok('skryptyJs', array());

		$this->tresc .= $this->szablon->parsujBlok('dodaj', array(
			'formularz' => $this->budujFormularz($regula)
		));
		$this->tresc .= $this->szablon->parsujBlok('skryptyJs', array(
			'urlAjax' => Router::urlAdmin('Routing', 'pobierzAkcjeDlaKategorii', array ('id' => '')),
		));
	}



	public function wykonajUsun()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

		$mapper = RegulaRoutingu\Mapper::wywolaj();
		$regula = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval'));

		if ( ! ($regula instanceof RegulaRoutingu\Obiekt))
		{
			$this->komunikat($this->j->t['edytuj.blad_nie_mozna_pobrac'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('Routing'));
			return;
		}

		$kopiaReguly = $regula;

		if ($regula->usun($mapper))
		{
			$this->zdarzenie('usunieto_regule', array(
				'id' => $kopiaReguly->id,
				'nazwa' => $kopiaReguly->nazwa,
				'idKategorii' => $kopiaReguly->idKategorii,
				'nazwaAkcji' => $kopiaReguly->nazwaAkcji,
				'szablonUrl' => $kopiaReguly->szablonUrl,
				'typReguly' => $kopiaReguly->typReguly,
				'wartosc' => $kopiaReguly->wartosc,
			));

			$this->komunikat($this->j->t['usun.info_usunieto'], 'info', 'sesja');
			Router::przekierujDo(Router::urlAdmin('Routing'));
		}
		else
		{
			$this->komunikat($this->j->t['usun.error_nie_mozna_usunac'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('Routing'));
		}
	}


	public function wykonajSortuj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['sortuj.tytul_strony']));

		if (Zadanie::pobierz('kolejnosc') != '')
		{
			$this->zapiszSortowanie();
		}

		$grid = new TabelaSortowanie();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['index.etykieta_nazwa'], 200);
		$grid->dodajKolumne('kodModulu', $this->j->t['index.etykieta_kodModulu'], 150);
		$grid->dodajKolumne('nazwaAkcji', $this->j->t['index.etykieta_nazwaAkcji'], 200);
		$grid->dodajKolumne('typReguly', $this->j->t['index.etykieta_typReguly'], 300);
		$grid->dodajKolumne('wartosc', $this->j->t['index.etykieta_wartosc'], 200);

		$mapper = RegulaRoutingu\Mapper::wywolaj(true);

		$ilosc = $mapper->iloscWszystko();

		if ($ilosc > 0)
		{
			foreach($mapper->ZwracaTablice()->pobierzWszystko() as $regula)
			{
				$regula['typReguly'] = $this->j->t['formularz.typyRegul'][$regula['typReguly']];
				$grid->dodajWiersz($regula);
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('sortuj', array(
				'tabela_danych' => $grid->html(),
				'link_dodaj' => Router::urlAdmin('Routing', 'dodaj'),
				'link_wstecz' => Router::urlAdmin('Routing', 'index'),
		));
	}



	public function wykonajPrzekierowania()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['przekierowania.tytul_strony']));

		$cms = Cms::inst();
		$plikDanych = TEMP_KATALOG.'/'.$this->plikPrzekierowania;
		if (is_file($plikDanych))
		{
			$przekierowania = include($plikDanych);
		}
		if ( ! isset($przekierowania) || ! is_array($przekierowania)
			|| ! isset($przekierowania['stale']) || ! isset($przekierowania['regexp']))
		{
			$przekierowania = array(
				'stale' => array('' => ''),
				'regexp' => array('' => ''),
			);
		}

		$obiektFormularza = new \Generic\Formularz\Routing\Przekierowania();
		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzPrzekierowania'))
			->ustawUrlPowrotny(Router::urlAdmin('Routing','index'))
			->ustawObiekt($przekierowania);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$tresc = "<?php
 return " . var_export($obiektFormularza->pobierzWartosci(), true) . ";";

			if (file_put_contents(TEMP_KATALOG.'/'.$this->plikPrzekierowania, $tresc))
			{
				$this->komunikat($this->j->t['przekierowania.info_zapisano'], 'info');
			}
			else
			{
				$this->komunikat($this->j->t['przekierowania.blad_nie_mozna_zapisac'], 'error');
			}
		}
		$this->tresc .= $obiektFormularza->html();
	}



	public function wykonajBlokady()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['blokady.tytul_strony']));

		$cms = Cms::inst();
		$plikDanych = TEMP_KATALOG.'/'.$this->plikBlokady;
		if (is_file($plikDanych))
		{
			$blokady = include($plikDanych);
		}
		if ( ! isset($blokady) || ! is_array($blokady)
			|| ! isset($blokady['stale']) || ! isset($blokady['regexp']))
		{
			$blokady = array(
				'stale' => array('' => ''),
				'regexp' => array('' => ''),
			);
		}
		$obiektFormularza = new \Generic\Formularz\Routing\Przekierowania();
		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzBlokady'))
			->ustawUrlPowrotny(Router::urlAdmin('Routing','index'))
			->ustawObiekt($blokady);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$tresc = "<?php
 return " . var_export($obiektFormularza->pobierzWartosci(), true) . ";";

			if (file_put_contents(TEMP_KATALOG.'/'.$this->plikBlokady, $tresc))
			{
				$this->komunikat($this->j->t['blokady.info_zapisano'], 'info');
			}
			else
			{
				$this->komunikat($this->j->t['blokady.blad_nie_mozna_zapisac'], 'error');
			}
		}
		$this->tresc .= $obiektFormularza->html();
	}



	protected function zapiszSortowanie()
	{
		if (Zadanie::pobierz('kolejnosc', 'trim', 'strip_tags', 'filtr_xss') == '')
		{
			$this->komunikat($this->j->t['zapiszSortowanie.error_nie_mozna_zapisac'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('Routing', 'sortuj'));
			return;
		}

		$kolejnosc = array();
		foreach (explode(';', Zadanie::pobierz('kolejnosc', 'strip_tags', 'filtr_xss')) as $wiersz)
		{
			$wiersz = explode(',', $wiersz);
			$kolejnosc[intval($wiersz[0])] = intval(str_replace('id:', '', $wiersz[1]));
		}

		$mapper = RegulaRoutingu\Mapper::wywolaj();

		$listaSortowana = $mapper->pobierzWszystko();
		$listaZDanymi = listaZTablicy($mapper->zwracaTablice()->pobierzWszystko(), 'id');

		foreach ($kolejnosc as $klucz => $idReguly)
		{
			$listaSortowana[$klucz -1]->nazwa = $listaZDanymi[$idReguly]['nazwa'];
			$listaSortowana[$klucz -1]->idKategorii = $listaZDanymi[$idReguly]['idKategorii'];
			$listaSortowana[$klucz -1]->kodModulu = $listaZDanymi[$idReguly]['kodModulu'];
			$listaSortowana[$klucz -1]->nazwaAkcji = $listaZDanymi[$idReguly]['nazwaAkcji'];
			$listaSortowana[$klucz -1]->typReguly = $listaZDanymi[$idReguly]['typReguly'];
			$listaSortowana[$klucz -1]->wartosc = $listaZDanymi[$idReguly]['wartosc'];
			$listaSortowana[$klucz -1]->szablonUrl = $listaZDanymi[$idReguly]['szablonUrl'];
		}

		$wystapilBlad = false;

		$mapper->rozpocznijTransakcje();

		foreach ($listaSortowana as $regula)
		{
			if (! $regula->zapisz($mapper))
			{
				$wystapilBlad = true;
				break;
			}
		}

		if ($wystapilBlad)
		{
			$mapper->cofnijTransakcje();
			$this->komunikat($this->j->t['sortuj.error_nie_mozna_zapisac'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('Routing', 'sortuj'));
		}
		else
		{
			$mapper->zatwierdzTransakcje();
			$this->zdarzenie('posortowano_reguly', array(
			));

			$this->komunikat($this->j->t['sortuj.info_zapisano'], 'info', 'sesja');
			Router::przekierujDo(Router::urlAdmin('Routing', 'sortuj'));
		}

	}


	public function wykonajPobierzAkcjeDlaKategorii()
	{
		echo'<option value="">' . $this->j->t['formularz.etykieta_select_wybierz'] . '</option>';

		foreach ($this->pobierzListeAkcjiDlaInputa(Zadanie::pobierz('id', 'intval')) as $akcja)
		{
			echo'<option value="' . $akcja . '">' . $akcja . '</option>';
		}
		exit ;
	}


	protected function budujFormularz(RegulaRoutingu\Obiekt $regula)
	{
		$obiektFormularza = new \Generic\Formularz\Routing\Edycja();

		$obiektFormularza->ustawListaKategorii($this->pobierzListeKategoriiDlaInputa())
			->ustawUrlPowrotny(Router::urlAdmin('Routing'))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawObiekt($regula)
			->ustawKonfiguracje(array('wymagane_pola' => $this->k->k['formularz.wymagane_pola']));

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$dane = $obiektFormularza->pobierzWartosci();

			$kategoria = $this->dane()->Kategoria()->zwracaTablice()->pobierzPoId($dane['routing_kategoria']);

			$regula->nazwa = 		$dane['routing_nazwa'];
			$regula->idKategorii = 	$kategoria['id'];
			$regula->kodModulu = 	$kategoria['kod_modulu'];
			$regula->nazwaAkcji =	$dane['routing_nazwaAkcji'];
			$regula->szablonUrl =	$dane['routing_szablonUrl'];
			$regula->typReguly =	$dane['routing_typReguly'];
			$regula->wartosc =		$dane['routing_wartosc'];
			$dodanieNowego = $regula->id > 0 ? true : false;

			if ($regula->zapisz(RegulaRoutingu\Mapper::wywolaj()))
			{

				if ($dodanieNowego)
				{
					$this->zdarzenie('dodano_regule', array(
						'id' => $regula->id,
						'nazwa' => $regula->nazwa,
						'idKategorii' => $regula->idKategorii,
						'nazwaAkcji' => $regula->nazwaAkcji,
						'szablonUrl' => $regula->szablonUrl,
						'typReguly' => $regula->typReguly,
						'wartosc' => $regula->wartosc,
					));
				}
				else
				{
					$this->zdarzenie('edytowano_regule', array(
						'id' => $regula->id,
						'nazwa' => $regula->nazwa,
						'idKategorii' => $regula->idKategorii,
						'nazwaAkcji' => $regula->nazwaAkcji,
						'szablonUrl' => $regula->szablonUrl,
						'typReguly' => $regula->typReguly,
						'wartosc' => $regula->wartosc,
					));
				}
				$this->komunikat($this->j->t['formularz.info_zapisano_dane'], 'info', 'sesja');
				Router::przekierujDo(Router::urlAdmin('Routing'));
				return;
			}
			else
			{
				$this->komunikat($this->j->t['formularz.blad_nie_mozna_zapisac'], 'error', 'modul');
			}

		}

		return $obiektFormularza->html();
	}


	protected function pobierzListeKategoriiDlaInputa()
	{
		$lista = array();

		foreach ($this->dane()->Kategoria()->zwracaTablice('id', 'nazwa', 'poziom', 'kod_modulu')->pobierzWszystko() as $kategoria)
		{
			if ($kategoria['kod_modulu'] != '')
			{
				$wciecie = '';
				for ($i = 1; $i < $kategoria['poziom']; ++$i) {$wciecie .= '&nbsp;&nbsp;&nbsp;&nbsp;';}
				$lista[$kategoria['id']] = $wciecie . $kategoria['nazwa'] . ' ('. $kategoria['kod_modulu'] .')';
			}
		}

		return $lista;
	}


	protected function pobierzListeAkcjiDlaInputa($idKategorii)
	{
		$lista = array();
		$kategoria = $this->dane()->Kategoria()->zwracaTablice()->pobierzPoId($idKategorii);

		$nazwaModulu = '';

		//TODO: tutaj raz mam obiekt raz tablice - chyba coś z cache
		if (is_array($kategoria))
		{
			$nazwaModulu = 'Generic\\Modul\\' . $kategoria['kod_modulu'] . '\\Http';
		}
		else
		{
			$nazwaModulu = 'Generic\\Modul\\' . $kategoria->kodModulu . '\\Http';
		}

		$modul = new $nazwaModulu;

		foreach ($modul->pobierzAkcje() as $klucz => $akcja)
		{
			$lista[$akcja] = $akcja;
		}

		return $lista;
	}
}

