<?php
namespace Generic\Modul\ProjektyZarzadzanie;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Pager;
use Generic\Model\Projekt;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Katalog;
use Generic\Model\JezykProjektu;


/**
 * Modul odpowiadajacy za zarządzanie projektami.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\ProjektyZarzadzanie\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\ProjektyZarzadzanie\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajUsun',
		'wykonajVhost',
	);



	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
		$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
		$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
		$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

		$mapper = $this->dane()->Projekt();
		$pager = new Pager\Html($mapper->iloscWszystko(), $naStronie, $nrStrony);
		$sorter = new Projekt\Sorter($kolumna, $kierunek);

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('kod', $this->j->t['index.etykieta_kod'], 250, Router::urlAdmin('ProjektyZarzadzanie','edytuj', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('nazwa', $this->j->t['index.etykieta_nazwa'], 0, Router::urlAdmin('ProjektyZarzadzanie','edytuj', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('domena', $this->j->t['index.etykieta_domena'], 250);

		$grid->dodajPrzyciski(
			Router::urlAdmin('ProjektyZarzadzanie','{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array(
				array(
					'akcja' => Router::urlAdmin('ProjektyZarzadzanie', 'vhost', array('{KLUCZ}' => '{WARTOSC}')),
					'ikona' => 'icon-hdd',
					'etykieta' => $this->j->t['index.etykieta_button_vhost'],
				),
				'edytuj','usun'
			)
		);

		$grid->ustawSortownie(array('kod', 'nazwa', 'domena'), $kolumna, $kierunek,
			Router::urlAdmin('ProjektyZarzadzanie', '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
		);

		$grid->pager($pager->html(Router::urlAdmin('ProjektyZarzadzanie', '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

		foreach($mapper->zwracaTablice()->pobierzWszystko($pager, $sorter) as $projekt)
		{
			$grid->dodajWiersz($projekt);
		}

		$this->szablon->ustawBlok('/index', array(
			'tabela_danych' => $grid->html(),
			'link_dodaj' => Router::urlAdmin('ProjektyZarzadzanie', 'dodaj'),
		));
		$this->tresc .= $this->szablon->parsujBlok('index');
	}



	public function wykonajDodaj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));

		$formularz = $this->budujFormularz(new Projekt\Obiekt());

		$this->tresc .= $this->szablon->parsujBlok('/dodaj', array(
			'form' => $formularz->html(),
		));
	}



	public function wykonajEdytuj()
	{
		$mapper = $this->dane()->Projekt();
		$projekt = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));
		if (!($projekt instanceof Projekt\Obiekt))
		{
			$this->komunikat($this->j->t['edytuj.blad_brak_projektu'], 'error');
			Router::przekierujDo(Router::urlAdmin('ProjektyZarzadzanie', 'index'));
			return;
		}

		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony'].$projekt->nazwa));

		$formularz = $this->budujFormularz($projekt);

		$this->tresc .= $this->szablon->parsujBlok('/edytuj', array(
			'form' => $formularz->html(),
			'skrypt' => $this->szablon->parsujBlok('/zaznacz_skrypt'),
		));
	}



	public function wykonajUsun()
	{
		$mapper = $this->dane()->Projekt();
		$projekt = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));
		if ($projekt instanceof Projekt\Obiekt)
		{
			if ($projekt->usun($mapper))
			{
				$this->komunikat($this->j->t['usun.info_projekt_usuniety'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_projektu'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['usun.blad_brak_projektu'],'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('ProjektyZarzadzanie', 'index'));
	}



	public function wykonajVhost()
	{
		$mapper = $this->dane()->Projekt();
		$projekt = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval','abs'));

		if ($projekt instanceof Projekt\Obiekt)
		{
			$this->ustawGlobalne(array('tytul_strony' => $this->j->t['vhost.tytul_strony']));

			$vhostCfg = new Szablon(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/vhost.tpl');
			$tresc = $vhostCfg->parsujBlok('vhost', array(
				'kod' => $projekt->kod,
				'nazwa' => $projekt->nazwa,
				'domena' => $projekt->domena,
				'szablon' => $projekt->szablon,
				'katalog' => CMS_KATALOG,
				's' => DIRECTORY_SEPARATOR,
			));
			$this->tresc .= $this->szablon->parsujBlok('/vhost', array(
				'tresc' => htmlspecialchars($tresc)
			));
		}
		else
		{
			$this->komunikat($this->j->t['vhost.blad_brak_projektu'],'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('ProjektyZarzadzanie','index'));
		}
	}



	protected function budujFormularz(Projekt\Obiekt $projekt)
	{
		$obiektFormularza = new \Generic\Formularz\Projekt\Edycja();
		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawSzablon($this->szablon)
			->ustawUrlPowrotny(Router::urlAdmin('ProjektyZarzadzanie','index'))
			->ustawObiekt($projekt)
			->ustawKonfiguracje($this->k->k);

		if ($obiektFormularza->wypelniony())
		{
			if ($projekt->id < 1)
			{
				$mapper = $this->dane()->Projekt();
				$istniejacyProjekt = $mapper->pobierzPoKodzie($obiektFormularza->zwrocFormularz()->kod->pobierzWartosc());
				if ($istniejacyProjekt instanceof Projekt\Obiekt)
				{
					$this->komunikat($this->j->t['dodaj.blad_kod_zajety'], 'warning');
					$obiektFormularza->zwrocFormularz()->kod->dodajWalidator(new Walidator\RozneOd($istniejacyProjekt->kod));
				}
			}
			$obiektFormularza->zwrocFormularz()->domyslnyJezyk->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($obiektFormularza->zwrocFormularz()->jezyki->pobierzWartosc())));

			if ($obiektFormularza->danePoprawne())
			{
				$this->zapiszProjekt($projekt, $obiektFormularza->pobierzWartosci());
			}
		}

		return $obiektFormularza->zwrocFormularz();
	}



	protected function zapiszProjekt(Projekt\Obiekt $projekt, Array $dane)
	{
		$moduly = array();
		$rss = array();
		$cron = array();

		foreach ($dane as $klucz => $wartosc)
		{
			if (strpos($klucz, 'modul_') !== false)
			{
				if ($wartosc == 1) $moduly[] = str_replace('modul_', '', $klucz);
			}
			elseif (strpos($klucz, 'api_') !== false)
			{
				if ($wartosc == 1) $api[] = str_replace('api_', '', $klucz);
			}
			elseif (strpos($klucz, 'rss_') !== false)
			{
				if ($wartosc == 1) $rss[] = str_replace('rss_', '', $klucz);
			}
			elseif (strpos($klucz, 'cron_') !== false)
			{
				if ($wartosc == 1) $cron[] = str_replace('cron_', '', $klucz);
			}
			elseif (strpos($klucz, 'jezyki') !== false)
			{
				$jezyki = $wartosc;
			}
			else
			{
				$projekt->$klucz = $wartosc;
			}
		}

		foreach ($rss as $klucz => $wartosc)
		{
			if (!in_array($wartosc, $moduly)) unset($rss[$klucz]);
		}
		foreach ($api as $klucz => $wartosc)
		{
			if (!in_array($wartosc, $moduly)) unset($api[$klucz]);
		}
		foreach ($cron as $klucz => $wartosc)
		{
			if (!in_array($wartosc, $moduly)) unset($cron[$klucz]);
		}
		$projekt->przypisaneModuly = (is_array($moduly) && count($moduly) > 0) ? ','.implode(',',$moduly).',' : '';
		$projekt->modulyRss = (is_array($rss) && count($rss) > 0) ? ','.implode(',',$rss).',' : '';
		$projekt->modulyApi = (is_array($api) && count($api) > 0) ? ','.implode(',',$api).',' : '';
		$projekt->modulyCron = (is_array($cron) && count($cron) > 0) ? ','.implode(',',$cron).',' : '';

		if ($projekt->id < 1)
		{
			$komunikat_sukces = $this->j->t['dodaj.info_zapisano_dane_projektu'];
			$komunikat_blad = $this->j->t['dodaj.blad_nie_mozna_zapisac_projektu'];

			$projekt->szablon = $this->k->k['dodaj.nazwa_szablonu'];
		}
		else
		{
			$komunikat_sukces = $this->j->t['edytuj.info_zapisano_dane_projektu'];
			$komunikat_blad = $this->j->t['edytuj.blad_nie_mozna_zapisac_projektu'];
		}

		if ($projekt->zapisz($this->dane()->Projekt()) && $this->zapiszJezyki($projekt, $jezyki))
		{
			$this->zapiszKatalogi($projekt);
			$cms = Cms::inst();
			if (isset($cms->sesja->projektCache)) unset($cms->sesja->projektCache);

			$this->komunikat($komunikat_sukces, 'info', 'sesja');
		}
		else
		{
			$this->komunikat($komunikat_blad, 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('ProjektyZarzadzanie', 'index'));
	}



	protected function zapiszJezyki(Projekt\Obiekt $projekt, Array $jezyki)
	{
		$jezykiMapper = $this->dane()->JezykProjektu();
		
		$przypisane = array();
		foreach ($projekt->jezyki as $jezyk)
		{
			$przypisane[$jezyk->kod] = $jezyk;
		}
		$bledy = 0;
		foreach ($jezyki as $kod => $nazwa)
		{
			if (!array_key_exists($kod, $przypisane))
			{
				$jezyk = new JezykProjektu\Obiekt();
				$jezyk->idProjektu = $projekt->id;
				$jezyk->kod = $kod;
				$jezyk->nazwa = $nazwa;
				
				
				if ( ! $jezyk->zapisz($jezykiMapper)) $bledy++;
			}
		}
		foreach ($przypisane as $jezyk)
		{
			if ( ! array_key_exists($jezyk->kod, $jezyki))
			{
				if ( ! $jezyk->usun($jezykiMapper)) $bledy++;
			}
		}
		
		return ($bledy > 0) ? false : true;
	}



	protected function zapiszKatalogi(Projekt\Obiekt $projekt)
	{
		$katalogi = array(
			//CMS_KATALOG.'/szablony/'.$projekt->kod,
			CMS_KATALOG.'/'.$projekt->szablon,
			TEMP_KATALOG.'/'.$projekt->kod,
			TEMP_KATALOG.'/'.$projekt->kod.'/temp',
		);
		foreach ($projekt->jezykiKody as $kod_jezyka)
		{
			$katalogi[] = TEMP_KATALOG.'/'.$projekt->kod.'/'.$kod_jezyka;
		}

		$bledy = 0;
		foreach ($katalogi as $sciezka)
		{
			$katalog = new Katalog($sciezka, true);
			if ( ! $katalog->istnieje())
			{
				$this->komunikat(sprintf($this->j->t['dodaj.blad_nie_mozna_utworzyc_katalogu'], $sciezka), 'error');
				$bledy++;
			}
		}
		return ($bledy > 0) ? false : true;
	}

}

