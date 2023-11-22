<?php
namespace Generic\Modul\MenuAplikacji;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\TabelaDanych;


/**
 * Blok administracyjny odpowiedzialny za wyświetlanie menu aplikacji.
 *
 * @author Łukasz Wrucha
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\MenuAplikacji\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\MenuAplikacji\Admin
	 */
	protected $j;

	
	protected $uprawnienia = array(
		'wykonajUstawienia',
		'wykonajEdytuj',
		'wykonajUsun',
	);


	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$idUzytkownika = $cms->profil()->id;
		
		$listaRol = listaZTablicy($cms->profil()->pobierzRole(true), 'kod');
		
		$pozycjeMenu = $this->dane()->PozycjaMenuAplikacji()->zwracaTablice()->pobierzDlaUzytkownika($idUzytkownika, true, new Model\PozycjaMenuAplikacji\Sorter('kolejnosc', 'ASC'));
		
		if (array_key_exists($this->k->k['index.rola_dla_wszystkich_uzytkownikow'], $listaRol))
		{
			$idUzytkownika = 0;
			$pozycjeMenu = array_merge($this->dane()->PozycjaMenuAplikacji()->zwracaTablice()->pobierzDlaUzytkownika($idUzytkownika), $pozycjeMenu);
		}
		
		$uprawnieniaDoUstawien = $this->moznaWykonacAkcje('wykonajUstawienia');
		
		if (count($pozycjeMenu) > 0)
		{
			$ids = listaZTablicy($pozycjeMenu, null, 'id_kategorii');
			
			$kategorie = $this->dane()->Kategoria()->pobierzPoWieleId($ids);
			$kategorie = listaZObiektow($kategorie, 'id');
			
			$aktualnyAdres = Zadanie::wywolanyUrl();
			
			$pozycjeNaEkran = array();
			$podobienstwo = array();
			$i = 0;
			foreach ($pozycjeMenu as $pozycja)
			{
				$parametry = unserialize($pozycja['parametry']);
				$anchor = ($pozycja['anchor'] != '') ? '#'.$pozycja['anchor'] : '';
				$etykiety = unserialize($pozycja['etykieta']);

				if( isset($kategorie[$pozycja['id_kategorii']]) )
				    $url = Router::urlAdmin($kategorie[$pozycja['id_kategorii']], $pozycja['akcja'], $parametry).$anchor;
				else
				    $url = '';
				
				$podobienstwo[$i] = levenshtein($url, $aktualnyAdres);
				
				$pozycjeNaEkran[$i]['url'] = $url;
				$pozycjeNaEkran[$i]['etykieta'] = $etykiety[KOD_JEZYKA_ITERFEJSU];
				$pozycjeNaEkran[$i]['ikona'] = $pozycja['ikona'];
				$i++;
			}
			
			$najwiekszePodobienstwo = array_keys($podobienstwo, min($podobienstwo));
			$i = 0;
			foreach ($pozycjeNaEkran as $pozycja)
			{
				$this->szablon->ustawBlok('index/elementPojedynczy', array(
					'aktywny' => ($i == $najwiekszePodobienstwo[0]) ? true : false,
					'link_url' => $pozycja['url'],
					'link_etykieta' => $pozycja['etykieta'],
					'ikona' => $pozycja['ikona'],
				));
				$i++;
			}
			
			$this->tresc .= $this->szablon->parsujBlok('index', array(
				'ustawienia' => $uprawnieniaDoUstawien,
				'url_ustawienia' => Router::urlAdmin('MenuAplikacji', 'ustawienia'),
			));
		}
		else if ($uprawnieniaDoUstawien)
		{
			$this->tresc .= $this->szablon->parsujBlok('index', array(
				'ustawienia' => $uprawnieniaDoUstawien,
				'url_ustawienia' => Router::urlAdmin('MenuAplikacji', 'ustawienia'),
			));
		}
		//<li{{IF $aktywny}} class="active"{{END}}><a href="{{$link_url}}" title="{{$link_etykieta}}"><i class="icon {{$ikona}}"></i> <span>{{$link_etykieta}}</span></a></li>
	}
	
	
	public function wykonajUstawienia()
	{
		$cms = Cms::inst();
		$mapper = $this->dane()->PozycjaMenuAplikacji();
		$kolejnosc = Zadanie::pobierzPost('kolejnosc', 'strval', 'filtr_xss');
		
		$this->ustawUrlPowrotny();
		
		if ($kolejnosc != '')
		{
			$kolejnosc = explode(',', str_replace('id-', '', $kolejnosc));
			if ($mapper->aktualizujKolejnosc($kolejnosc))
			{
				$this->komunikat($this->j->t['ustawienia.komunikat_zmieniono_kolejnosc'], 'success');
			}
			else
			{
				$this->komunikat($this->j->t['ustawienia.error_nie_zmieniono_kolejnosci'], 'warning');
			}
		}
		
		$idUzytkownika = Zadanie::pobierz('idUzytkownika', 'intval', 'abs');
		if ($idUzytkownika == '')
		{
			$idUzytkownika = 0;
			$this->komunikat($this->j->t['ustawienia.komunikat_przed_edycja'], 'info');
		}
		
		
		$elementyMenu = $mapper->zwracatablice()->pobierzDlaUzytkownika($idUzytkownika, false);
		
		$ilosc_elementow = count($elementyMenu);
		if ($ilosc_elementow > 0)
		{
			$dane = array(
				'elementy_etykieta' => $this->j->t['ustawienia.etykieta_elementy'],
			);
			$this->szablon->ustawBlok('ustawienia/elementy', $dane);
			
			foreach ($elementyMenu as $element)
			{
				//$parametry = unserialize($element['parametry']);
				//dump($parametry);
				$dane = array(
					'id' => $element['id'],
					'etykieta' => unserialize($element['etykieta'])[KOD_JEZYKA],
					'url' => Router::urlAdmin($this->dane()->Kategoria()->pobierzPoId($element['id_kategorii']), $element['akcja'], unserialize($element['parametry'])),
					'ikona' => $element['ikona'],
					'url_edytuj' => Router::urlAdmin('MenuAplikacji', 'edytuj', array('id' => $element['id'])),
					'url_usun' => Router::urlAdmin('MenuAplikacji', 'usun', array('id' => $element['id'])),
					'etykieta_edytuj' => $this->j->t['ustawienia.etykieta_edytuj'],
					'etykieta_usun' => $this->j->t['ustawienia.etykieta_usun'],
				);
				//dump($dane);
				$this->szablon->ustawBlok('ustawienia/elementy/element', $dane);
			}
		}
		else
		{
			
		}
		
		$modulAkcja = Zadanie::pobierz('modulAkcja', 'strval', 'filtr_xss');
		
		
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['ustawienia.tytul_strony'],
			'tytul_modulu' => $this->j->t['ustawienia.tytul_modulu'],
		));
		
		$uzytkownicy = $this->dane()->Uzytkownik()->zwracaTablice(array('id', 'login', 'imie', 'nazwisko'))->szukaj(array('active' => true));
		
		$uzytkownicyLista = array(0 => $this->j->t['ustawienia.uzytkownik_etykieta_wybierz']);
		foreach ($uzytkownicy as $uzytkownik)
		{
			$uzytkownicyLista[$uzytkownik['id']] = $uzytkownik['imie'].' '.$uzytkownik['nazwisko'].' ('.$uzytkownik['login'].')';
		}
		
		//dump($uzytkownicyLista);
		
		$formularzUzytkownika = new Formularz(Router::urlAdmin('MenuAplikacji', 'ustawienia', array('idUzytkownika' => '{ID_UZYTKOWNIKA}')), 'wybor-uzytkownika');
		$formularzUzytkownika->input(new Input\Select('idUzytkownika', array(
			'lista' => $uzytkownicyLista,
			'wartosc' => $idUzytkownika,
		), $this->j->t['ustawienia.uzytkownik_etykieta']));
		
		$metody = $this->listaMetod($idUzytkownika);
		
		$formularzPozycji_HTML = '';
		if (count($metody) > 1)
		{
			$modulAkcjaTab = explode('-', $modulAkcja);
			$modul = (isset($modulAkcjaTab[0]))? $modulAkcjaTab[0] : '';
			$akcja = (isset($modulAkcjaTab[1])) ? $modulAkcjaTab[1] : '';


			$anchor = Zadanie::pobierz('anchor', 'strval', 'filtr_xss');
			$parametry = Zadanie::pobierz('parametry');
			$ikona = Zadanie::pobierz('ikona', 'strval', 'filtr_xss');
			$etykieta = Zadanie::pobierz('etykieta');
			
			if (is_serialized($etykieta))
			{
				$etykieta = unserialize($etykieta);
			}

			$dane = array(
				'metody' => $metody,
				'modul' => $modul,
				'akcja' => $akcja,
				'anchor' => $anchor,
				'parametry' => $parametry,
				'ikona' => $ikona,
				'idUzytkownika' => $idUzytkownika,
				'modulAkcja' => $modulAkcja,
				'etykieta' => $etykieta,
			);
			
			$formularzPozycji = $this->formularzPozycji($dane);
			
			$this->zapiszPozycje($formularzPozycji);
			//$kategoria = $this->dane()->Kategoria()->pobierzPoId(5);
			//dump(Router::urlAdmin($kategoria, 'index'));
			$formularzPozycji_HTML = $formularzPozycji->html();
 		}
		else
		{
			$this->komunikat($this->j->t['ustawienia.brak_uprawnien_wybranego_uzytkownika_komunikat'], 'warning');
		}
		
		$this->tresc .= $this->szablon->parsujBlok('ustawienia', array(
			'formularz_uzytkownika' => $formularzUzytkownika->html(),
			//'menuGrid' => $grid->html(),
			'formularz_pozycji' => $formularzPozycji_HTML,
			'id_uzytkownika' => $idUzytkownika,
			'ilosc_elementow' => $ilosc_elementow,
			'etykieta_dodaj_element' => $this->j->t['ustawienia.etykieta_dodaj'],
			'etykieta_zapisz_kolejnosc' => $this->j->t['ustawienia.etykieta_zapisz_kolejnosc'],
			'etykieta_zamknij' => $this->j->t['ustawienia.etykieta_zamknij'],
		));
	}

	
	public function wykonajEdytuj()
	{
		$id = Zadanie::pobierz('id', 'intval', 'abs');
		
		$elementMenu = $this->dane()->PozycjaMenuAplikacji()->pobierzPoId($id);
		
		if ($elementMenu instanceof Model\PozycjaMenuAplikacji\Obiekt)
		{
			$kroki[] = array(
				'url' => Router::urlAdmin('MenuAplikacji', 'ustawienia', array('idUzytkownika' => $elementMenu->idUzytkownika)),
				'etykieta' => $this->j->t['edytuj.sciezka_lista_elementow'],
			);
				
			Cms::inst()->temp('sciezka', $kroki);
			
			$this->ustawGlobalne(array(
				'tytul_strony' => $this->j->t['edytuj.tytul_strony'],
				'tytul_modulu' => $this->j->t['edytuj.tytul_modulu'],
			));
			
			$metody = $this->listaMetod($elementMenu->idUzytkownika);
			
			$modulAkcja = $elementMenu->idKategorii.'-wykonaj'.ucfirst($elementMenu->akcja);
			
			$modulAkcjaTab = explode('-', $modulAkcja);
			$modul = (isset($modulAkcjaTab[0]))? $modulAkcjaTab[0] : '';
			$akcja = $modulAkcjaTab[1];
			
			$dane = array(
				'id' => $id,
				'metody' => $metody,
				'modul' => $modul,
				'akcja' => $akcja,
				'anchor' => $elementMenu->anchor,
				'parametry' => $elementMenu->parametry,
				'ikona' => $elementMenu->ikona,
				'idUzytkownika' => $elementMenu->idUzytkownika,
				'modulAkcja' => $modulAkcja,
				'etykieta' => $elementMenu->etykieta,
			);
			
			$formularzPozycji = $this->formularzPozycji($dane);
			$this->zapiszPozycje($formularzPozycji, $id);
			$this->tresc .= $this->szablon->parsujBlok('edytuj', array(
				'formularz_pozycji' => $formularzPozycji->html(),
			));
		}
		else
		{
			$this->komunikat($this->j->t['edytuj.brak_wiersza_dla_id'], 'warning', 'sesja');
			Router::przekierujDo(Router::urlAdmin('MenuAplikacji', 'ustawienia'));
		}
	}


	protected function formularzPozycji($dane)
	{	
		$formularzPozycji = new Formularz('', 'formularz-pozycji');
		
			$formularzPozycji->input(new Input\SelectDrzewo('modulAkcja', array(
				'lista' => $dane['metody'],
				'cfg' => array(
					'select_class' => 'vertical',
					'preselect' => ($dane['modul'] != '' && $dane['akcja'] != '') ? '{modulAkcja: ['.$dane['modul'].', '.$dane['akcja'].']}' : '',
				),
				'wybierz' => $this->j->t['ustawienia.etykieta_wybierz'],
				'wartosc' => $dane['modulAkcja'],
				'wymagany' => true,
			), $this->j->t['ustawienia.etykieta_modulAkcja']));
			$formularzPozycji->modulAkcja->dodajWalidator(new Walidator\NiePuste());

			$projekt = new \Generic\Model\Projekt\Obiekt();
			$jezykiProjektu = array();

			$formularzPozycji->otworzZbiorowyInput('etykietaKontener', $this->j->t['ustawienia.etykieta_etykietaKontener']);

				foreach ($projekt->jezyki as $jezyk)
				{
					$jezykiProjektu[$jezyk->kod] = $jezyk->nazwa;
					$nazwaInputa = 'etykieta_'.$jezyk->kod;

					$formularzPozycji->input(new Input\Html(ucfirst($nazwaInputa).'_prepend', array(
						'wartosc' => '<div class="input-prepend"><span class="add-on tip-left" title="'.$jezyk->nazwa.'"><img class="flag-ico" width="16" height="11" border="0" alt="'.$jezyk->nazwa.'" title="'.$jezyk->nazwa.'" src="/_system/admin/flagi/'.$jezyk->kod.'.gif"/></span>',
					),'' , '', 'CzystyHTML.tpl'));
					$formularzPozycji->input(new Input\Text($nazwaInputa, array(
						'atrybuty' => array('maxlength' => 255),
						'wymagany' => true,
						'wartosc' => (isset($dane['etykieta'][$jezyk->kod])) ? $dane['etykieta'][$jezyk->kod] : '',
					)));
					$formularzPozycji->$nazwaInputa->dodajWalidator(new Walidator\NiePuste());

					$formularzPozycji->input(new Input\Html(ucfirst($nazwaInputa).'_after', array(
						'wartosc' => '</div>',
					), '', '', 'CzystyHTML.tpl'));

					$formularzPozycji->$nazwaInputa->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
				}
			$formularzPozycji->zamknijZbiorowyInput('etykietaKontener');

			$formularzPozycji->input(new Input\Tablica('parametry', array(
				'dodawanie_wierszy' => true,
				'wartosc' => $dane['parametry'],
			), $this->j->t['ustawienia.etykieta_parametry']));

			$formularzPozycji->input(new Input\Text('anchor', array('wartosc' => $dane['anchor']), $this->j->t['ustawienia.etykieta_anchor']));
			$formularzPozycji->input(new Input\Text('ikona', array('wartosc' => $dane['ikona']), $this->j->t['ustawienia.etykieta_ikona']));

			$formularzPozycji->input(new Input\Hidden('idUzytkownika', $dane['idUzytkownika']));
			
			$formularzPozycji->stopka(new Input\Submit('zapisz', array('wartosc' => $this->j->t['ustawienia.etykieta_dodaj_pozycje'])));
			
			if (isset($dane['id']) && $dane['id'] > 0)
			{
				$formularzPozycji->stopka(new Input\Button('wstecz', array(
					'atrybuty' => array('onclick' => 'window.location = \'' . $this->pobierzUrlPowrotny() . '\'' ),
					'wartosc' => $this->j->t['ustawienia.etykieta_wstecz']
				)));
			}
			
			return $formularzPozycji;
	}


	protected function zapiszPozycje($formularzPozycji, $elementId = 0)
	{
		if ($formularzPozycji->wypelniony())
		{
			if ($formularzPozycji->danePoprawne())
			{
				
				if ($elementId > 0)
				{
					$pozycjaMenu = $this->dane()->PozycjaMenuAplikacji()->pobierzPoId($elementId);
				}
				
				$projekt = new \Generic\Model\Projekt\Obiekt();
				foreach ($projekt->jezyki as $jezyk)
				{
					$etykiety[] = 'etykieta_'.$jezyk->kod;
				}
				$listaInputow = array_merge(array(
					'modulAkcja',
					'idUzytkownika',
					'parametry',
					'anchor',
					'ikona',
				), $etykiety);
				
				$etykiety = array();
				$dane = array();
				foreach ($formularzPozycji->pobierzWartosci() as $klucz => $wartosc)
				{
					if (in_array($klucz, $listaInputow))
					{
						if ($klucz == 'parametry')
						{
							//$wartosc = serialize($wartosc);
						}
						if (strpos($klucz, 'etykieta') !== false)
						{
							$etykiety[substr($klucz,-2)] = $wartosc;
							continue;
						}
						$dane[$klucz] = $wartosc;
					}
					$dane['etykieta'] = serialize($etykiety);
				}

				$modulAkcjaTab = explode('-', $dane['modulAkcja']);

				$akcja = lcfirst(str_replace('wykonaj', '', $modulAkcjaTab[1]));

				if (! $pozycjaMenu instanceof Model\PozycjaMenuAplikacji\Obiekt)
				{
					$pozycjaMenu = new Model\PozycjaMenuAplikacji\Obiekt();
					$pozycjaMenu->idProjektu = ID_PROJEKTU;
					$pozycjaMenu->idUzytkownika = $dane['idUzytkownika'];
				}
				$pozycjaMenu->idKategorii = $modulAkcjaTab[0];
				$pozycjaMenu->akcja = $akcja;
				$pozycjaMenu->anchor = $dane['anchor'];
				$pozycjaMenu->ikona = $dane['ikona'];
				$pozycjaMenu->zawszeWidoczna = false;
				$pozycjaMenu->parametry = $dane['parametry'];
				$pozycjaMenu->etykieta = $etykiety;



				if ($pozycjaMenu->zapisz($this->dane()->PozycjaMenuAplikacji()))
				{
					$formularzPozycji->resetuj();
					$this->komunikat($this->j->t['ustawienia.dodano_pozycje_menu_komunikat'], 'success', 'sesja');
				}
				else
				{
					$this->komunikat($this->j->t['ustawienia.nie_dodano_pozycji_menu_komunikat_blad'], 'error', 'sesja');
				}
				Router::przekierujDo(Router::urlAdmin('MenuAplikacji', 'ustawienia', array('idUzytkownika' => $dane['idUzytkownika'])));
			}
			else
			{
				$this->komunikat($this->j->t['ustawienia.formularz_nie_wypełniony_komunikat'], 'warning');
			}
		}
	}

	
	public function wykonajUsun()
	{
		$id = Zadanie::pobierz('id', 'intval', 'abs');
		
		$mapper = $this->dane()->PozycjaMenuAplikacji();
		$pozycjaMenu = $mapper->pobierzPoId($id);
		if ($pozycjaMenu instanceof Model\PozycjaMenuAplikacji\Obiekt)
		{
			$idUzytkownika = $pozycjaMenu->idUzytkownika;
			if ($pozycjaMenu->usun($mapper))
			{
				$this->komunikat($this->j->t['usun.success_usunieto_pozycje'], 'success', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usun.error_nie_usunieto_pozycji'], 'error', 'sesja');
			}
			Router::przekierujDo(Router::urlAdmin('MenuAplikacji', 'ustawienia', array('idUzytkownika' => $idUzytkownika)));
		}
		else
		{
			$this->komunikat($this->j->t['usun.error_brak_pozycji'], 'warning', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('MenuAplikacji', 'ustawienia'));
	}


	
	protected function listaMetod($idUzytkownika = 0)
	{
		$kategorie = $this->dane()->Kategoria()->zwracaTablice()->pobierzWszystko();
		unset($kategorie[0]);
		
		$uzytkownik = null;
		if ($idUzytkownika > 0)
		{
			/**
			 * @var Generic\Model\Uzytkownik\Obiekt $uzytkownik
			 */
			$uzytkownik = $this->dane()->Uzytkownik()->pobierzPoId($idUzytkownika);
		}
		else
		{
			$rola = $this->dane()->Rola()->pobierzPoKodzie(Cms::inst()->config['bkt_crm']['kod_podstawowej_roli']);
			
		}
		
		$metody = array();
		foreach ($kategorie as $index => $kategoria)
		{
			$ileMetod = 0;
			/**
			 * @var Generic\Model\Kategoria\Obiekt $kategoria
			 */
			$klasa = 'Generic\\Modul\\'.$kategoria['kod_modulu'].'\\Admin';
			$metody[] = array(
				'id' => $kategoria['id'],
				'nazwa' => $kategoria['kod_modulu'],
				'poziom' => 1,
			);
			foreach (get_class_methods($klasa) as $metoda)
			{
				if (strpos($metoda, 'wykonaj') !== false && $metoda != 'wykonajAkcje')
				{
					if ($uzytkownik instanceof Model\Uzytkownik\Obiekt)
					{
						if ($uzytkownik->maUprawnieniaDo('Admin_'.$kategoria['id'].'_'.$metoda))
						{
							$ileMetod++;
							$metody[] = array(
								'id' => '\''.$kategoria['id'].'-'.$metoda.'\'',
								'nazwa' => $kategoria['id'].'-'.$metoda,
								'poziom' => 2,
							);
						}
					}
					else
					{
						if ($rola instanceof Model\Rola\Obiekt && $rola->maUprawnieniaDo('Admin_'.$kategoria['id'].'_'.$metoda))
						{
							$ileMetod++;
							$metody[] = array(
								'id' => '\''.$kategoria['id'].'-'.$metoda.'\'',
								'nazwa' => $kategoria['id'].'-'.$metoda,
								'poziom' => 2,
							);
						}
					}
				}
			}
			if ($ileMetod == 0)
			{
				array_pop($metody);
			}
		}
		return $metody;
	}




	/**
	 *  Przeciazona metoda z klasy Modul. Zwraca true bo zawsze chcemy wyswietlac ten blok
	 *
	 * @param string $metoda Nazwa wywolywanej akcji (tekst albo null).
	 *
	 * @return bool True.
	 */
	protected function moznaWykonacAkcje($metoda, $wlasnyKod = false, $obiektKontekstu = null)
	{
		if ($metoda == 'wykonajIndex')
			return true;
		else
		{
			return parent::moznaWykonacAkcje($metoda, $wlasnyKod, $obiektKontekstu);
		}
	}

}
