<?php
namespace Generic\Modul\UstawieniaJezykowe;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\TabelaDanych;
use Generic\Model\WierszTlumaczen;
use Generic\Model\Blok;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Mapper;
use Generic\Biblioteka\Pager;


/**
 * Modul administracyjny odpowiedzialny za zarzadząnie tłumaczeniami cms-a.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\UstawieniaJezykowe\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\UstawieniaJezykowe\Admin
	 */
	protected $j;


	protected $obslugiwaneUslugi = array('Admin', 'Http', 'Rss','Cron');


	// pola tłumaczeń odczytane z bazy
	protected $tlumaczeniaBaza = array();


	// mapowanie kluczy tłumaczeń na nazwy pól w formularzu
	protected $klucze = array();


	// obiekt dla ktorego zmieniamy konfiguracje: kategoria albo blok
	protected $obiekt;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajBiblioteki',
		'wykonajAdministracyjne',
		'wykonajZwykle',
		'wykonajEdytujAdministracyjny',
		'wykonajEdytujZwykly',
		'wykonajEdytujKategorie',
		'wykonajEdytujBlok',
		'wykonajCzyscBiblioteki',
		'wykonajCzyscAdministracyjny',
		'wykonajCzyscZwykly',
		'wykonajCzyscKategorie',
		'wykonajCzyscBlok',
		'wykonajSzukajFrazy',
		'opcjeSystemowe',
	);



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$dane = array(
			'link_tlumaczenia' => Router::urlAdmin('Testy', 'tlumaczenia'),
			'link_tlumaczenia_biblioteki' => Router::urlAdmin('UstawieniaJezykowe', 'biblioteki'),
			'link_tlumaczenia_czysc_biblioteki' => Router::urlAdmin('UstawieniaJezykowe', 'czyscBiblioteki'),
			'link_tlumaczenia_moduly_administracyjne' => Router::urlAdmin('UstawieniaJezykowe', 'administracyjne'),
			'link_tlumaczenia_czysc_moduly_administracyjne' => Router::urlAdmin('UstawieniaJezykowe', 'czyscAdministracyjne'),
			'link_tlumaczenia_moduly_zwykle' => Router::urlAdmin('UstawieniaJezykowe', 'zwykle'),
			'link_tlumaczenia_czysc_moduly_zwykle' => Router::urlAdmin('UstawieniaJezykowe', 'czyscZwykle'),
			'link_wyszukiwarka' => Router::urlAdmin('UstawieniaJezykowe', 'szukajFrazy'),
		);
		$this->tresc .= $this->szablon->parsujBlok('index', $dane);
	}



	public function wykonajSzukajFrazy()
	{
		$cms = Cms::inst();

		$fraza = Zadanie::pobierz('fraza', 'strip_tags', 'filtr_xss', 'trim');

		if (strlen($fraza) < 3)
		{
			$this->komunikat($this->j->t['szukajFrazy.blad.fraza_zbyt_krotka'], 'error');
			Router::przekierujDo(Router::urlAdmin('UstawieniaJezykowe', 'index'));
		}

		$this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['szukajFrazy.tytul_strony'], $fraza)));

		$mapperModuly = DostepnyModul\Mapper::wywolaj();

		$istniejaTlumaczeniaWModulach = false;

		foreach($mapperModuly->pobierzPrzypisane() as $modul)
		{
			foreach ($modul->uslugi as $usluga)
			{
				$grid = new TabelaDanych();
				$grid->dodajKolumne('kod', '', 0, '', true);
				$grid->dodajKolumne('nazwa', $this->j->t['szukajFrazy.etykieta_nazwa'], 300);
				$grid->dodajKolumne('wartosc', $this->j->t['szukajFrazy.etykieta_wartosc'], 300);
				$grid->dodajKolumne('dotyczy', $this->j->t['szukajFrazy.etykieta_dotyczy'], 140);

				$grid->naglowek(sprintf($this->j->t['szukajFrazy.naglowek_modulu'],$modul->nazwa.' - '.$usluga));

				$grid->dodajPrzyciski(
					Router::urlAdmin('UstawieniaJezykowe','{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
					array(
						array(
							'akcja' => Router::urlAdmin('UstawieniaJezykowe', (($modul->typ=='administracyjny') ? 'edytujAdministracyjny' : 'edytujZwykly'), array('{KLUCZ}' => '{WARTOSC}')),
							'ikona' => 'icon-pencil',
							'etykieta' => $this->j->t['szukajFrazy.etykieta_button_edytuj'],
							'klucz' => 'globalne',
						),array(
							'akcja' => Router::urlAdmin('UstawieniaJezykowe', 'edytujKategorie', array('id' => '{WARTOSC}')),
							'ikona' => 'icon-pencil',
							'etykieta' => $this->j->t['szukajFrazy.etykieta_button_edytuj'],
							'klucz' => 'kategorii',
						),array(
							'akcja' => Router::urlAdmin('UstawieniaJezykowe', 'edytujBlok', array('id' => '{WARTOSC}')),
							'ikona' => 'icon-pencil',
							'etykieta' => $this->j->t['szukajFrazy.etykieta_button_edytuj'],
							'klucz' => 'bloku',
						),
					)
				);

				$nazwaKlasy = 'Generic\\Modul\\' . $modul->kod . '\\' . $usluga;
				$instancja = new $nazwaKlasy;

				$istniejaTlumaczenia = false;

				foreach ($instancja->pobierzTlumaczenia() as $klucz => $wartosc)
				{
					if (is_array($wartosc))
					{
						foreach ($wartosc as $kluczWartosci => $wartoscWartosci)
						{
							$wiersz = $this->sprawdzWierszWyszukiwania($fraza, $kluczWartosci, $wartoscWartosci, $modul->kod, $usluga, $klucz);
							if($wiersz!==false)
							{
								switch ($wiersz['typ'])
								{
									case 'kategorii': $grid->usunPrzyciski(array('globalne', 'bloku')); break;
									case 'bloku': $grid->usunPrzyciski(array('globalne', 'kategorii')); break;
									default: $grid->usunPrzyciski(array('bloku', 'kategorii')); break;
								}
								$grid->dodajWiersz($wiersz);
								$istniejaTlumaczenia = $istniejaTlumaczeniaWModulach = true;
							}
						}
					}
					else
					{
						$wiersz = $this->sprawdzWierszWyszukiwania($fraza, $klucz, $wartosc, $modul->kod, $usluga);
						if ($wiersz!==false)
						{
							switch ($wiersz['typ'])
							{
								case 'kategorii': $grid->usunPrzyciski(array('globalne', 'bloku')); break;
								case 'bloku': $grid->usunPrzyciski(array('globalne', 'kategorii')); break;
								default: $grid->usunPrzyciski(array('bloku', 'kategorii')); break;
							}
							$grid->dodajWiersz($wiersz);
							$istniejaTlumaczenia = $istniejaTlumaczeniaWModulach = true;
						}
					}
				}
				if ($istniejaTlumaczenia)
					$this->tresc .= $grid->html().'<br />';
			}
		}

		if ( ! $istniejaTlumaczeniaWModulach)
			$this->komunikat($this->j->t['szukajFrazy.nie_znaleziono'], 'info');
	}


	protected function sprawdzWierszWyszukiwania($fraza, $klucz, $wartosc, $kodModulu, $usluga, $nazwaRodzica='')
	{
		$mapperTlumaczenia = $this->dane()->WierszTlumaczen();

		$tlumaczenieZBazy = $mapperTlumaczenia->wyszukajWiersz($nazwaRodzica!=''?$nazwaRodzica:$klucz, $kodModulu.'_'.$usluga);

		if ($tlumaczenieZBazy instanceof WierszTlumaczen\Obiekt)
		{
			$wartosc = $tlumaczenieZBazy->wartosc;
			if($nazwaRodzica!='' && $tlumaczenieZBazy->typ=='array')
			{
				$daneOdserializowane = unserialize($wartosc);
				if(isset($daneOdserializowane[$klucz]))
					$wartosc=$daneOdserializowane[$klucz];

			}
		}

		if (stripos(strtolower($klucz), $fraza)!==false || stripos(strtolower($wartosc), $fraza)!==false || stripos(strtolower($nazwaRodzica), $fraza)!==false)
		{
			$dotyczy = $this->j->t['szukajFrazy.etykieta_dotyczy_globalne'];
			$kod = $kodModulu.'#'.$usluga.'|'.$usluga.'_'.($nazwaRodzica != '' ? $nazwaRodzica.'_wyswietlony':$klucz);
			$typ = 'globale';
			if ($tlumaczenieZBazy instanceof WierszTlumaczen\Obiekt)
			{
				if ($tlumaczenieZBazy->idBloku)
				{
					$blok = $this->dane()->Blok()->pobierzPoId($tlumaczenieZBazy->idBloku);
					if ($blok instanceof Blok\Obiekt)
					{
						$dotyczy = $this->j->t['szukajFrazy.etykieta_dotyczy_bloku'].$blok->nazwa;
						$kod = $tlumaczenieZBazy->idBloku.'#'.$usluga.'|'.$usluga.'_'.($nazwaRodzica != '' ? $nazwaRodzica.'_wyswietlony':$klucz);
						$typ = 'bloku';
					}
				}
				elseif (($tlumaczenieZBazy->idKategorii))
				{
					$kategoria = $this->dane()->Kategoria()->pobierzPoId($tlumaczenieZBazy->idKategorii);
					if ($kategoria instanceof Kategoria\Obiekt)
					{
						$dotyczy = $this->j->t['szukajFrazy.etykieta_dotyczy_kategorii'].$kategoria->nazwa;
						$kod = $tlumaczenieZBazy->idKategorii.'#'.$usluga.'|'.$usluga.'_'.($nazwaRodzica != '' ? $nazwaRodzica.'_wyswietlony':$klucz);
						$typ = 'kategorii';
					}
				}
			}

			return array(
				'kod' => str_replace('.', '_', $kod),
				'nazwa' => str_ireplace($fraza,'<strong>'.$fraza.'</strong>',($nazwaRodzica!=''?$nazwaRodzica.'.':'').$klucz) ,
				'wartosc'=>  str_ireplace($fraza,'<strong>'.$fraza.'</strong>',htmlspecialchars($wartosc)),
				'dotyczy' => $dotyczy,
				'typ' => $typ,
			);
		}
		else
			return false;
	}


	public function wykonajBiblioteki()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['biblioteki.tytul_strony']));

		$urlPowrotny = Router::urlAdmin('UstawieniaJezykowe', 'index');

		$tlumaczenia = array();
		$tlumaczeniaPlik = require(CMS_KATALOG.'/lang.inc.php');

		$zakladki = array();
		foreach ($tlumaczeniaPlik as $blok => $wiersze)
		{
			$tlumaczenia = array();
			foreach ($wiersze as $klucz => $wartosc)
			{
				$tlumaczenia[$klucz]['wartosc'] = $wartosc;
				$tlumaczenia[$klucz]['typ'] = 'varchar';
			}
			$zakladki[$blok] = $tlumaczenia;
		}

		if ($this->pobierzParametr('czysc') != '')
		{
			$this->czyscKlucz(null, $this->pobierzParametr('czysc', 'trim'));
		}

		$mapper = $this->dane()->WierszTlumaczen();
		
		foreach ($mapper->pobierzDlaSystemu() as $wiersz)
		{
			$klucz = explode('.', $wiersz->nazwa);
			$blok = $klucz[0];
			$klucz = $klucz[1];

			$this->tlumaczeniaBaza[str_replace(array('.', '-'), '_', $wiersz->nazwa)] = $wiersz;

			if (isset($zakladki[$blok]) && array_key_exists($klucz, $zakladki[$blok]))
			{
				if ($wiersz->typ == 'array' || $wiersz->typ == 'object')
				{
					$wartosc = unserialize($wiersz->wartosc);
				}
				else
				{
					$wartosc = $wiersz->wartosc;
					settype($wartosc, $wiersz->typ);
				}
				$zakladki[$blok][$klucz]['wartosc'] = $wartosc;
				$zakladki[$blok][$klucz]['klucz_baza'] = $wiersz->nazwa;
			}
		}
		$urlCzysc = Router::urlAdmin('UstawieniaJezykowe', 'biblioteki', array('czysc' => '{KOD}'));

		$nazwy = array();
		$formularz = $this->budujFormularz($zakladki, $nazwy, $urlPowrotny, $urlCzysc);
		if ($formularz->wypelniony() && $formularz->danePoprawne())
		{
			$this->zapiszTlumaczenia($formularz->pobierzZmienioneWartosci(), $nazwy, $urlPowrotny);
			return;
		}
		else
		{
			$this->tresc .= $this->szablon->parsujBlok('system', array(
				'form' => $formularz->html(),
			));
		}
	}



	public function wykonajAdministracyjne()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['administracyjne.tytul_strony']));
		$grid = $this->listaModulow('administracyjne');
		$dane['grid'] = $grid->html();
		$this->tresc .= $this->szablon->parsujBlok('administracyjne', $dane);
	}



	public function wykonajZwykle()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['zwykle.tytul_strony']));
		$grid = $this->listaModulow('zwykle');
		$dane['grid'] = $grid->html();
		$this->tresc .= $this->szablon->parsujBlok('zwykle', $dane);
	}



	public function wykonajEdytujAdministracyjny()
	{
		$urlPowrotny = Router::urlAdmin('UstawieniaJezykowe', 'administracyjne');

		$mapper = DostepnyModul\Mapper::wywolaj();
		$modul = $mapper->pobierzPoKodzie(Zadanie::pobierz('kod', 'strval', 'trim'));
		if (!($modul instanceof DostepnyModul\Obiekt))
		{
			$this->komunikat($this->j->t['edytujAdministracyjny.blad_nie_mozna_pobrac_modulu'], 'error', 'sesja');
			Router::przekierujDo($urlPowrotny);
			return;
		}
		if ($modul->typ != 'administracyjny')
		{
			$this->komunikat($this->j->t['edytujAdministracyjny.blad_modulu_nie_jest_administracyjny'], 'error', 'sesja');
			Router::przekierujDo($urlPowrotny);
			return;
		}
		if ( ! $this->moznaWykonacAkcje('opcjeSystemowe') && in_array($modul->kod, array('ModulyZarzadzanie', 'ProjektyZarzadzanie')))
		{
			$this->komunikat($this->j->t['edytujAdministracyjny.blad_brak_uprawnien_do_modulu'], 'error', 'sesja');
			Router::przekierujDo($urlPowrotny);
			return;
		}

		$this->obiekt = $modul;

		if ($this->pobierzParametr('czysc') != '')
		{
			$this->czyscKlucz($this->obiekt, $this->pobierzParametr('czysc'));
		}

		$zakladki = $this->przygotujDaneFormularza($modul);
		if (count($zakladki) < 1)
		{
			$this->komunikat($this->j->t['edytujAdministracyjny.info_modul_nie_posiada_tlumaczen'], 'info', 'sesja');
			Router::przekierujDo($urlPowrotny);
			return;
		}

		$this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['edytujAdministracyjny.tytul_strony'], $modul->nazwa)));

		$urlCzysc = Router::urlAdmin('UstawieniaJezykowe', 'edytujAdministracyjny', array('kod' => $modul->kod, 'czysc' => '{KOD}'));

		$nazwy = array();
		$formularz = $this->budujFormularz($zakladki, $nazwy, $urlPowrotny, $urlCzysc);
		if ($formularz->wypelniony() && $formularz->danePoprawne())
		{
			$this->zapiszTlumaczenia($formularz->pobierzZmienioneWartosci(), $nazwy, $urlPowrotny);
			return;
		}
		else
		{
			$this->tresc .= $this->szablon->parsujBlok('edytujAdministracyjny', array(
				'form' => $formularz->html(),
				'link_czysc' => Router::urlAdmin('UstawieniaJezykowe', 'czyscAdministracyjny', array('kod' => $modul->kod)),
			));
		}
	}



	public function wykonajEdytujZwykly()
	{
		$urlPowrotny = Router::urlAdmin('UstawieniaJezykowe', 'zwykle');

		$mapper = DostepnyModul\Mapper::wywolaj();
		$modul = $mapper->pobierzPoKodzie(Zadanie::pobierz('kod', 'strval', 'trim'));
		if (!($modul instanceof DostepnyModul\Obiekt))
		{
			$this->komunikat($this->j->t['edytujZwykly.blad_nie_mozna_pobrac_modulu'], 'error', 'sesja');
			Router::przekierujDo($urlPowrotny);
			return;
		}
		if (!in_array($modul->kod, Cms::inst()->projekt->powiazaneModulyHttp))
		{
			$this->komunikat($this->j->t['edytujZwykly.blad_modul_nie_przypisany_do_projektu'], 'error', 'sesja');
			Router::przekierujDo($urlPowrotny);
		}

		if ($this->pobierzParametr('czysc') != '')
		{
			$this->czyscKlucz($modul, $this->pobierzParametr('czysc'));
		}

		$zakladki = $this->przygotujDaneFormularza($modul);
		if (count($zakladki) < 1)
		{
			$this->komunikat($this->j->t['edytujZwykly.info_modul_nie_posiada_tlumaczen'], 'info', 'sesja');
			Router::przekierujDo($urlPowrotny);
		}

		$this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['edytujZwykly.tytul_strony'], $modul->nazwa)));

		$urlCzysc = Router::urlAdmin('UstawieniaJezykowe', 'edytujZwykly', array('kod' => $modul->kod, 'czysc' => '{KOD}'));

		$nazwy = array();
		$formularz = $this->budujFormularz($zakladki, $nazwy, $urlPowrotny, $urlCzysc);
		if ($formularz->wypelniony() && $formularz->danePoprawne())
		{
			$this->zapiszTlumaczenia($formularz->pobierzZmienioneWartosci(), $nazwy, $urlPowrotny);
			return;
		}
		else
		{
			$this->tresc .= $this->szablon->parsujBlok('edytujZwykly', array(
				'form' => $formularz->html(),
				'link_czysc' => Router::urlAdmin('UstawieniaJezykowe', 'czyscZwykly', array('kod' => $modul->kod)),
			));
		}
	}



	public function wykonajEdytujKategorie()
	{
		$mapper = $this->dane()->Kategoria();
		$this->obiekt = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

		if (!($this->obiekt instanceof Kategoria\Obiekt))
		{
			$this->komunikat($this->j->t['edytujKategorie.blad_nieprawidlowa_kategoria'], 'error');
			return;
		}
		if (!($this->obiekt->modul instanceof DostepnyModul\Obiekt))
		{
			$this->komunikat($this->j->t['edytujKategorie.blad_nie_mozna_pobrac_modulu'], 'error');
			return;
		}

		if ($this->pobierzParametr('czysc') != '')
		{
			$this->czyscKlucz($this->obiekt, $this->pobierzParametr('czysc'));
		}

		$zakladki = $this->przygotujDaneFormularza($this->obiekt->modul, $this->obiekt);
		if (count($zakladki) < 1)
		{
			$this->komunikat($this->j->t['edytujKategorie.info_modul_nie_posiada_tlumaczen'], 'info');
			return;
		}

		$this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['edytujKategorie.tytul_strony'], $this->obiekt->nazwa)));

		$urlCzysc = Router::urlAdmin('UstawieniaJezykowe', 'edytujKategorie', array('id' => $this->obiekt->id, 'czysc' => '{KOD}'));

		$nazwy = array();
		$formularz = $this->budujFormularz($zakladki, $nazwy, null, $urlCzysc);
		if ($formularz->wypelniony() && $formularz->danePoprawne())
		{
			$this->zapiszTlumaczenia($formularz->pobierzZmienioneWartosci(), $nazwy);
			return;
		}
		else
		{
			$this->tresc .= $this->szablon->parsujBlok('edytujKategorie', array(
				'form' => $formularz->html(),
				'link_czysc' => Router::urlAdmin('UstawieniaJezykowe', 'czyscKategorie', array('id' => $this->obiekt->id)),
			));
		}
	}



	public function wykonajEdytujBlok()
	{
		$this->obiekt = $this->dane()->Blok()->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

		if (!($this->obiekt instanceof Blok\Obiekt))
		{
			$this->komunikat($this->j->t['edytujBlok.blad_nieprawidlowy_blok'], 'error');
			return;
		}
		if (!($this->obiekt->modul instanceof DostepnyModul\Obiekt))
		{
			$this->komunikat($this->j->t['edytujBlok.blad_nie_mozna_pobrac_modulu'], 'error');
			return;
		}

		if ($this->pobierzParametr('czysc') != '')
		{
			$this->czyscKlucz($this->obiekt, $this->pobierzParametr('czysc'));
		}

		$zakladki = $this->przygotujDaneFormularza($this->obiekt->modul, $this->obiekt);
		if (count($zakladki) < 1)
		{
			$this->komunikat($this->j->t['edytujBlok.info_modul_nie_posiada_tlumaczen'], 'info');
			return;
		}

		$this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['edytujBlok.tytul_strony'], $this->obiekt->nazwa)));

		$urlCzysc = Router::urlAdmin('UstawieniaJezykowe', 'edytujBlok', array('id' => $this->obiekt->id, 'czysc' => '{KOD}'));

		$nazwy = array();
		$formularz = $this->budujFormularz($zakladki, $nazwy, null, $urlCzysc);
		if ($formularz->wypelniony() && $formularz->danePoprawne())
		{
			$this->zapiszTlumaczenia($formularz->pobierzZmienioneWartosci(), $nazwy);
			return;
		}
		else
		{
			$this->tresc .= $this->szablon->parsujBlok('edytujBlok', array(
				'form' => $formularz->html(),
				'link_czysc' => Router::urlAdmin('UstawieniaJezykowe', 'czyscBlok', array('id' => $this->obiekt->id)),
			));
		}
	}



	public function wykonajCzyscBiblioteki()
	{
		$mapper = $this->dane()->WierszTlumaczen();
		if ($mapper->czyscDlaSystemu())
		{
			$this->komunikat($this->j->t['czyscBiblioteki.info_usunieto_wiersze'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czyscBiblioteki.blad_nie_mozna_usunac_wierszy'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('UstawieniaJezykowe', 'index'));
	}



	public function wykonajCzyscAdministracyjny()
	{
		$mapper = DostepnyModul\Mapper::wywolaj();
		$modul = $mapper->pobierzPoKodzie(Zadanie::pobierz('kod', 'strval', 'trim'));
		if (!($modul instanceof DostepnyModul\Obiekt))
		{
			$this->komunikat($this->j->t['czyscAdministracyjny.blad_nie_mozna_pobrac_modulu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UstawieniaJezykowe', 'administracyjne'));
			return;
		}
		if ($modul->typ != 'administracyjny')
		{
			$this->komunikat($this->j->t['czyscAdministracyjny.blad_modulu_nie_jest_administracyjny'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UstawieniaJezykowe', 'administracyjne'));
			return;
		}

		$mapper = $this->dane()->WierszTlumaczen();
		if ($mapper->czyscDlaModulu($modul->kod))
		{
			$this->komunikat($this->j->t['czyscAdministracyjny.info_usunieto_wiersze'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czyscAdministracyjny.blad_nie_mozna_usunac_wierszy'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('UstawieniaJezykowe', 'edytujAdministracyjny', array('kod' => $modul->kod)));
	}



	public function wykonajCzyscZwykly()
	{
		$mapper = DostepnyModul\Mapper::wywolaj();
		$modul = $mapper->pobierzPoKodzie(Zadanie::pobierz('kod', 'strval', 'trim'));
		if (!($modul instanceof DostepnyModul\Obiekt))
		{
			$this->komunikat($this->j->t['czyscZwykly.blad_nie_mozna_pobrac_modulu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UstawieniaJezykowe', 'zwykle'));
			return;
		}
		if (!in_array($modul->kod, Cms::inst()->projekt->powiazaneModulyHttp))
		{
			$this->komunikat($this->j->t['czyscZwykly.blad_modul_nie_przypisany_do_projektu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('UstawieniaJezykowe', 'zwykle'));
			return;
		}

		$mapper = $this->dane()->WierszTlumaczen();
		if ($mapper->czyscDlaModulu($modul->kod))
		{
			$this->komunikat($this->j->t['czyscZwykly.info_usunieto_wiersze'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czyscZwykly.blad_nie_mozna_usunac_wierszy'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('UstawieniaJezykowe', 'edytujZwykly', array('kod' => $modul->kod)));
	}



	public function wykonajCzyscKategorie()
	{
		$mapper = $this->dane()->Kategoria();
		$kategoria = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

		if (!($kategoria instanceof Kategoria\Obiekt))
		{
			$this->komunikat($this->j->t['czyscKategorie.blad_nieprawidlowa_kategoria'], 'error');
			return;
		}
		if (!($kategoria->modul instanceof DostepnyModul\Obiekt))
		{
			$this->komunikat($this->j->t['czyscKategorie.blad_nie_mozna_pobrac_modulu'], 'error');
			return;
		}

		$mapper = $this->dane()->WierszTlumaczen();
		if ($mapper->czyscDlaModulu($kategoria->kodModulu, $kategoria->id))
		{
			$this->komunikat($this->j->t['czyscKategorie.info_usunieto_wiersze'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czyscKategorie.blad_nie_mozna_usunac_wierszy'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('UstawieniaJezykowe', 'edytujKategorie', array('id' => $kategoria->id)));
	}



	public function wykonajCzyscBlok()
	{
		$this->obiekt = $this->dane()->Blok()->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

		if (!($blok instanceof Blok\Obiekt))
		{
			$this->komunikat($this->j->t['czyscBlok.blad_nieprawidlowy_blok'], 'error');
			return;
		}
		if (!($blok->modul instanceof DostepnyModul\Obiekt))
		{
			$this->komunikat($this->j->t['czyscBlok.blad_nie_mozna_pobrac_modulu'], 'error');
			return;
		}

		if ($this->dane()->WierszTlumaczen()->czyscDlaModulu($blok->kodModulu, null, $blok->id))
		{
			$this->komunikat($this->j->t['czyscBlok.info_usunieto_wiersze'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czyscBlok.blad_nie_mozna_usunac_wierszy'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('UstawieniaJezykowe', 'edytujBlok', array('id' => $blok->id)));
	}



	protected function listaModulow($typ)
	{
		$akcja = ($typ == 'administracyjne') ? 'edytujAdministracyjny' : 'edytujZwykly';

		$grid = new TabelaDanych();
		$grid->dodajKolumne('kod', '', null, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['tabela.etykieta_nazwa'], null, Router::urlAdmin('UstawieniaJezykowe', $akcja, array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('typ', $this->j->t['tabela.etykieta_typ'], 200);

		$grid->dodajPrzyciski(Router::urlAdmin('UstawieniaJezykowe', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')), array(
			array(
				'akcja' => Router::urlAdmin('UstawieniaJezykowe', $akcja, array('{KLUCZ}' => '{WARTOSC}')),
				'etykieta' => $this->j->t['tabela.etykieta_edytuj'],
				'ikona' => 'icon-pencil',
			)
		));

		$kryteria = $this->formularzWyszukiwania($grid, $typ);

		if ( ! $this->moznaWykonacAkcje('opcjeSystemowe'))
		{
			$kryteria['pomin'] = array('ModulyZarzadzanie', 'ProjektyZarzadzanie');
		}
		$mapper = DostepnyModul\Mapper::wywolaj(Mapper::ZWRACA_TABLICE);
		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['tabela.wierszy_na_stronie'], true, array('intval', 'abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval', 'abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['tabela.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

			$sorter = new DostepnyModul\Sorter($kolumna, $kierunek);
			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);

			$grid->ustawSortownie(array('nazwa', 'typ'), $kolumna, $kierunek,
				Router::urlAdmin('UstawieniaJezykowe', $typ, array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);
			$grid->pager($pager->html(Router::urlAdmin('UstawieniaJezykowe', $typ, array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			foreach ($mapper->szukaj($kryteria, $pager, $sorter) as $modul)
			{
				$modul['typ'] = $this->j->t['tabela.modul_typy'][$modul['typ']];
				$grid->dodajWiersz($modul);
			}
		}
		return $grid;
	}



	protected function przygotujDaneFormularza(DostepnyModul\Obiekt $modul, $obiekt = null)
	{
		$uslugi = array();
		foreach ($modul->uslugi as $usluga)
		{
			$uslugi[$usluga] = array();
		}

		$mapper = $this->dane()->WierszTlumaczen();

		$zakladki = array();
		
		foreach ($uslugi as $usluga => $tlumaczenia)
		{
			$nazwaKlasy = 'Generic\\Modul\\'.$modul->kod.'\\'.$usluga;
			$nazwaTlumaczenia = 'Generic\\Tlumaczenie\\'.ucfirst(KOD_JEZYKA).'\\Modul\\'.$modul->kod.'\\'.$usluga;
			$instancja = new $nazwaKlasy;
			
			/**
			 * @var Generic\Tlumaczenie\Tlumaczenie
			 */
			$instancjaTlumaczenie = new $nazwaTlumaczenia;

			$moduly = 'powiazaneModuly'.$usluga;
			if (!in_array($modul->kod, Cms::inst()->projekt->$moduly) && !($instancja instanceof Modul\System)) continue;

			$tlumaczenia = array();
			foreach ($instancjaTlumaczenie->t as $klucz => $wartosc)
			{
				$tlumaczenia[$klucz]['wartosc'] = $wartosc;
				$tlumaczenia[$klucz]['typ'] = $instancjaTlumaczenie->pobierzTypPola($klucz);
			}

			// czyscimy tlumaczenia dla akcji do wykonania w module
			if (isset($tlumaczenia['_akcje_etykiety_'])) unset($tlumaczenia['_akcje_etykiety_']);

			if ($obiekt instanceof Kategoria\Obiekt)
			{
				$tlumaczeniaBaza = $mapper->pobierzDlaModulu($modul->kod.'_'.$usluga, $obiekt->id);
			}
			elseif ($obiekt instanceof Blok\Obiekt)
			{
				$tlumaczeniaBaza = $mapper->pobierzDlaModulu($modul->kod.'_'.$usluga, null, $obiekt->id);
			}
			else
			{
				$tlumaczeniaBaza = $mapper->pobierzDlaModulu($modul->kod.'_'.$usluga);
			}
			foreach ($tlumaczeniaBaza as $wiersz)
			{
				if (array_key_exists($wiersz->nazwa, $tlumaczenia))
				{
					if ($wiersz->typ == 'array' || $wiersz->typ == 'object')
					{
						$wartosc = unserialize($wiersz->wartosc);
					}
					else
					{
						$wartosc = $wiersz->wartosc;
						settype($wartosc, $wiersz->typ);
					}
					$tlumaczenia[$wiersz->nazwa]['wartosc'] = $wartosc;
					if (($obiekt instanceof Kategoria\Obiekt && $wiersz->idKategorii == $obiekt->id)
						|| ($obiekt instanceof Blok\Obiekt && $wiersz->idBloku == $obiekt->id)
						|| ($obiekt === null && $wiersz->idKategorii == '' && $wiersz->idBloku == ''))
					{
						$klucz = str_replace(array('.', '-'), '_', $usluga.'_'.$wiersz->nazwa);
						$this->tlumaczeniaBaza[$klucz] = $wiersz;
						$tlumaczenia[$wiersz->nazwa]['klucz_baza'] = $usluga.'_'.$wiersz->nazwa;
					}
				}
			}

			unset($tlumaczeniaBaza);

			// czy jest co tlumaczyc
			if (count($tlumaczenia) > 0)
			{
				$zakladki[$usluga] = $tlumaczenia;
			}
		}

		return $zakladki;
	}



	protected function budujFormularz($zakladki, &$nazwy = array(), $urlPowrotny = '', $urlCzysc = '')
	{
		$cms = Cms::inst();
		$nazwy = array();
		$linkCzysc = $this->szablon->parsujBlok('/linkCzyscKlucz', array(
			'etykieta' => $this->j->t['formularz.etykieta_link_czysc'],
			'url' => $urlCzysc,
		));

		// ustaw skrypt nyroModal
		$this->tresc .= $this->szablon->parsujBlok('/scriptNyroModal');

		$obiektFormularza = new \Generic\Formularz\Tlumaczenie\Edycja();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawSzablon($this->szablon)
			->ustawUrlPowrotny($urlPowrotny)
			->ustawZakladki($zakladki)
			->ustawLinkCzysc($linkCzysc)
			->ustawUrlCzysc($urlCzysc)
			->ustawNazwy($nazwy);

		return $obiektFormularza->zwrocFormularz();
	}



	protected function zapiszTlumaczenia($zmienioneWiersze, $nazwy, $urlPowrotny = '')
	{
		$licznik = 0;
		$bledy = 0;

		$mapper = $this->dane()->WierszTlumaczen();
		$kodModulu = Zadanie::pobierz('kod', 'strval');

		foreach ($zmienioneWiersze as $klucz => $wartosc)
		{
			$wiersz = null;
			if (array_key_exists($klucz, $this->tlumaczeniaBaza))
			{
				$wiersz = $this->tlumaczeniaBaza[$klucz];

				switch ($this->wykonywanaAkcja)
				{
					case 'biblioteki':
						if ($wiersz->idKategorii > 0 || $wiersz->idBloku > 0 || $wiersz->kodModulu != '') $wiersz = null;
						break;

					case 'edytujKategorie':
						if ($wiersz->idKategorii < 0) $wiersz = null;
						break;

					case 'edytujBlok':
						if ($wiersz->idBloku < 0) $wiersz = null;
						break;

					default:
						if ($wiersz->idKategorii > 0 || $wiersz->idBloku > 0) $wiersz = null;
						break;
				}
			}
			if (!($wiersz instanceof WierszTlumaczen\Obiekt))
			{
				$wiersz = new WierszTlumaczen\Obiekt;
				$wiersz->idProjektu = ID_PROJEKTU;
				$wiersz->kodJezyka = KOD_JEZYKA;
				$wiersz->typ = gettype($wartosc);
				$wiersz->nazwa = $nazwy[$klucz];

				$kluczRozbity = explode('_', $klucz);

				$usluga = array_shift($kluczRozbity);

				switch ($this->wykonywanaAkcja)
				{
					case 'edytujKategorie':
						$wiersz->idKategorii = $this->obiekt->id;
						$wiersz->kodModulu = $this->obiekt->kodModulu.'_'.$usluga;
						break;

					case 'edytujBlok':
						$wiersz->idBloku = $this->obiekt->id;
						$wiersz->kodModulu = $this->obiekt->kodModulu.'_'.$usluga;
						break;

					case 'biblioteki':
						$usluga = trim(str_replace($nazwy[$klucz], '', $klucz), '_');
						$wiersz->nazwa = $usluga.'.'.$wiersz->nazwa;
						break;

					default:
						$wiersz->kodModulu = $kodModulu.'_'.$usluga;
						break;
				}
			}

			$wiersz->wartosc = (is_array($wartosc)) ? serialize($wartosc) : (string)$wartosc;
			if ($wiersz->zapisz($mapper))
			{
				$licznik++;
			}
			else
			{
				$this->komunikat(sprintf($this->j->t['biblioteki.blad_nie_mozna_zapisac_wiersza'], $klucz), 'error', ($urlPowrotny != '') ? 'sesja' : 'modul');
				$bledy++;
			}
		}
		$this->komunikat(sprintf($this->j->t['biblioteki.info_zapisano_wiersze'], $licznik), 'info', ($urlPowrotny != '') ? 'sesja' : 'modul');

		if ($urlPowrotny != '') Router::przekierujDo($urlPowrotny);
	}


	/*
	 * UWAGA: Tutaj jest inaczej niz w konfiguracji z nazwami wiersza
	 */
	protected function czyscKlucz($obiekt, $kodWiersza)
	{
		$wiersz = explode('_', $kodWiersza);
		$usluga = $wiersz[0];
		array_shift($wiersz);
		$nazwa = implode('_', $wiersz);
		$mapper = $this->dane()->WierszTlumaczen();
		$dane = null;

		if ($obiekt instanceof Kategoria\Obiekt)
		{
			$dane = $mapper->pobierzDlaModulu($obiekt->modul->kod.'_'.$usluga, $obiekt->id, null);
		}
		elseif ($obiekt instanceof Blok\Obiekt)
		{
			$dane = $mapper->pobierzDlaModulu($obiekt->modul->kod.'_'.$usluga, null, $obiekt->id);
		}
		elseif ($obiekt instanceof DostepnyModul\Obiekt)
		{
			$dane = $mapper->pobierzDlaModulu($obiekt->kod.'_'.$usluga);
		}
		elseif ($obiekt === null)
		{
			$dane = $mapper->pobierzDlaSystemu();
		}
		if (is_array($dane))
		{
			foreach ($dane as $wiersz)
			{
				if ($wiersz instanceof WierszTlumaczen\Obiekt && (
					($obiekt instanceof Kategoria\Obiekt && $wiersz->idKategorii == $obiekt->id && $wiersz->nazwa == $nazwa)
					|| ($obiekt instanceof Blok\Obiekt && $wiersz->idBloku == $obiekt->id && $wiersz->nazwa == $nazwa)
					|| ($obiekt instanceof DostepnyModul\Obiekt && $wiersz->idKategorii == '' && $wiersz->idBloku == '' && $wiersz->nazwa == $nazwa)
					|| ($obiekt === null && $wiersz->idKategorii == '' && $wiersz->idBloku == '' && $wiersz->kodModulu == '' && $wiersz->nazwa == $kodWiersza)
					))
				{
					$wiersz->usun($mapper);
				}
			}
		}
	}



	private function formularzWyszukiwania(TabelaDanych $grid, $typ)
	{
		$obiektFormularza = new \Generic\Formularz\Tlumaczenie\Wyszukiwanie();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('tabela'))
			->ustawTypModulow($typ)
			->ustawDomyslne($this->pobierzParametr('typ', null, true), $this->pobierzParametr('fraza', null, true, array('strip_tags', 'filtr_xss', 'trim')));

		$grid->naglowek($obiektFormularza->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

		$kryteria = array_merge(array(), $obiektFormularza->pobierzWartosci());

		// wymuszenie wartosci
		if ($typ == 'administracyjne')
		{
			$kryteria['typ'] = 'administracyjny';
		}
		elseif ($typ == 'zwykle')
		{
			$kryteria['kod'] = Cms::inst()->projekt->powiazaneModulyHttp;
			if (!isset($kryteria['typ']) || !in_array($kryteria['typ'], array('zwykly', 'jednorazowy', 'blok')))
			{
				$kryteria['typ'] = array('zwykly', 'jednorazowy', 'blok');
			}
		}

		return $kryteria;
	}

}

