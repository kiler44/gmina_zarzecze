<?php
namespace Generic\Formularz\Kategoria;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Zadanie;
use Generic\Model\DostepnyModul;
use Generic\Model\Widok;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	protected $szablonZewnetrzny;

	
	protected function generujFormularz()
	{
		$cms = Cms::inst();

		$projekt = new \Generic\Model\Projekt\Obiekt();
		$jezykiProjektu = array();
		
		$this->formularz = new Formularz('', 'kategoriaEdycja');

		/**
		 * Otwarcie glownej zakladki kategorii
		 */
		$this->formularz->otworzZakladke('kategoria', $this->tlumaczenia['etykieta_zakladka_kategoria']);

		$this->formularz->input(new Input\Text('nazwa', array(
			'atrybuty' => array('maxlength' => 255, 'style' => 'width: 70%'),
		)));
		$this->formularz->nazwa->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->otworzZbiorowyInput('nazwaPrzyjaznaKontener');

			foreach ($projekt->jezyki as $jezyk)
			{
				$jezykiProjektu[$jezyk->kod] = $jezyk->nazwa;
				$nazwaInputa = 'nazwaPrzyjazna_'.$jezyk->kod;
				
				$this->formularz->input(new Input\Html(ucfirst($nazwaInputa).'_prepend', array(
					'wartosc' => '<div class="input-prepend"><span class="add-on"><img class="flag-ico" width="16" height="11" border="0" alt="'.$jezyk->nazwa.'" title="'.$jezyk->nazwa.'" src="/_system/admin/flagi/'.$jezyk->kod.'.gif"></span>',
				),'' , '', 'CzystyHTML.tpl'));
				$this->formularz->input(new Input\Text($nazwaInputa, array(
					'atrybuty' => array('maxlength' => 255),
				)));
				
				$this->formularz->input(new Input\Button('NazwaPrzyjaznaPobierz_'.$jezyk->kod, array(
					'atrybuty' => array(
						'onclick' => 'kopiujTekst(\'nazwa\', \''.$nazwaInputa.'\')',
						'style' => 'width: 180px',
					),
					'wartosc' => $this->tlumaczenia['nazwaPrzyjaznaPobierz']['wartosc']
				)));
				
				$this->formularz->input(new Input\Html(ucfirst($nazwaInputa).'_after', array(
					'wartosc' => '</div>',
				), '', '', 'CzystyHTML.tpl'));
				
				$this->formularz->$nazwaInputa->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
			}
		$this->formularz->zamknijZbiorowyInput('nazwaPrzyjaznaKontener');

		$this->formularz->input(new Input\Text('ikona'));
		$this->formularz->ikona->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$kategorie = $cms->dane()->Kategoria();
		$lista = array();
		foreach ($this->obiekt->dostepneTypy as $typ)
		{
			$lista[$typ] = $this->tlumaczenia['etykieta_typ_'.$typ];
		}
		// sprawdzamy co jest kategoria nadrzedna a nastepnie dla niektorych przypadkw ustalamy typ
		if ($this->obiekt->rodzic->typ == 'system')
		{
			unset($lista['kategoria']);
			unset($lista['link_wewnetrzny']);
			unset($lista['link_zewnetrzny']);

			if ($kategorie->pobierzGlowna() instanceof Kategoria\Obiekt)
			{
				if ($this->obiekt->id < 1) $this->obiekt->typ = 'menu';
			}
			else
			{
				if ($this->obiekt->id < 1) $this->obiekt->typ = 'glowna';
			}
		}
		else
		{
			unset($lista['glowna']);
			unset($lista['menu']);
		}

		if ($this->obiekt->typ == '')
		{
			$this->formularz->input(new Input\Select('typ', array(
				'lista' => $lista,
				'wartosc' => $this->obiekt->typ,
				'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
			)));
		}

		// kod potrzebny do ustawienia url-a i widocznosc dodajemy do wszystkich
		if (in_array($this->obiekt->typ, array('kategoria', 'link_wewnetrzny', 'link_zewnetrzny')))
		{
			$lista = array();
			foreach ($kategorie->pobierzWszystko() as $kat)
			{
				if ($kat->kod != '' && $kat->id != $this->obiekt->id) $lista[] = $kat->kod;
			}
			$lista = array_merge($lista, array_keys($cms->pobierzUslugi()));

			$this->formularz->otworzZbiorowyInput('kodKontener');

				$this->formularz->input(new Input\Text('kod', '', array(
					'atrybuty' => array('maxlength' => 50, 'style' => 'width: 70%'),
				)))
					->dodajFiltr('strip_tags', 'filtr_xss', 'trim','strtolower')
					->dodajWalidator(new Walidator\NiedozwoloneWartosci($lista));

				$this->formularz->input(new Input\Button('kodGeneruj', '', array(
					'atrybuty' => array(
						'onclick' => 'uzupelnijKod1()',
						'style' => 'width: 120px; ',
					),
				'wartosc' => $this->tlumaczenia['kodGeneruj']['wartosc']
				)));

			$this->formularz->zamknijZbiorowyInput('kodKontener');

			$this->formularz->otworzZbiorowyInput('link');

			$this->formularz->input(new Input\Text('pelnyLink', array(
				'atrybuty' => array(
					'readonly' => 'readonly',
					'style' => 'width: 70%',
				),
			)));
			$this->formularz->input(new Input\Button('poprawLink', array(
				'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin('KategorieZarzadzanie','poprawUrl', array('id' => Zadanie::pobierzGet('id', 'intval','abs'))).'\''),
				'wartosc' => $this->tlumaczenia['poprawLink']['wartosc']
			)));

			$this->formularz->zamknijZbiorowyInput('link');

			$this->formularz->otworzZbiorowyInput('staryUrlZbiorowy');

				$this->formularz->input(new Input\Text('staryUrl', array(
					'atrybuty' => array(
						'style' => 'width: 70%',
					),
				)));

				$this->formularz->input(new Input\Button('czyscStaryUrl', array(
					'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin('KategorieZarzadzanie','czyscStaryUrl', array('id' => Zadanie::pobierzGet('id', 'intval','abs'))).'\''),
				)));

			$this->formularz->zamknijZbiorowyInput('staryUrlZbiorowy');

			$this->formularz->input(new Input\Checkbox('czyWidoczna'));
			$this->formularz->czyWidoczna->dodajFiltr('intval');
		}

		if (in_array($this->obiekt->typ, array('kategoria', 'glowna')))
		{
			$modulDlaZalogowanych = ($this->obiekt->modul instanceof DostepnyModul\Obiekt && $this->obiekt->modul->dlaZalogowanych) ? true : false;

			$this->formularz->input(new Input\Checkbox('dlaZalogowanych', array(
				'wartosc' => ($modulDlaZalogowanych) ? 1 : (bool)$this->obiekt->dlaZalogowanych,
				'atrybuty' => ($modulDlaZalogowanych) ? array('disabled' => 'disabled') : array(),
			)));
			$this->formularz->dlaZalogowanych->dodajFiltr('intval');

			$this->formularz->input(new Input\Checkbox('wymagaHttps'));
			$this->formularz->wymagaHttps->dodajFiltr('intval');

			if ($this->obiekt->modul == '')
			{
				$kategorieModuly = array();
				foreach ($kategorie->pobierzWszystko() as $k)
				{
					$kategorieModuly[$k->kodModulu][] = $k;
				}

				$moduly = DostepnyModul\Mapper::wywolaj();
				
				$lista = array();
				foreach ($moduly->pobierzPrzypisane(array('zwykly','jednorazowy'), null, new DostepnyModul\Sorter('nazwa', 'asc')) as $modul)
				{
					// moduly jednorazowe ktore zostaly juz dodane
					if ($modul->typ == 'jednorazowy'
						&& array_key_exists($modul->kod, $kategorieModuly)
						&& count($kategorieModuly[$modul->kod]) > 0
						) continue;
					// czy uzytkownik ma uprawnienia automatyczne do tego modulu
					if ( ! $cms->profil()->maUprawnieniaAutomatyczneDoModulu($modul->kod)) continue;
					$lista[$modul->kod] = $modul->nazwa;
				}
				
				$this->formularz->input(new Input\Select('kodModulu', array(
					'lista' => $lista,
					'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
				)));
			}
			else
			{
				$this->formularz->input(new Input\Html('kodModulu', array(
					'wartosc' => $this->obiekt->modul->nazwa,
				)));

				if ($this->obiekt->modul instanceof DostepnyModul\Obiekt && $this->obiekt->modul->cache == true)
				{
					$this->formularz->input(new Input\Checkbox('cache'))
						->dodajFiltr('intval', 'abs');

					$this->formularz->input(new Input\Select('czasCache', array(
						'lista' => $this->tlumaczenia['cache_przedzialy_czasowe'],
					)))
						->dodajFiltr('intval', 'abs')
						->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($this->tlumaczenia['cache_przedzialy_czasowe'])));
				}
			}

			$this->formularz->input(new Input\Checkbox('blokada', array()));
			$this->formularz->blokada->dodajFiltr('intval', 'abs');

			/**
			 * Zamkniecie glownej zakladki kategorii
			 */
			$this->formularz->zamknijZakladke('kategoria');


			/**
			 * Otwarcie zakładki do edycji widoków kategorii
			 */
			$this->formularz->otworzZakladke('wyglad', $this->tlumaczenia['etykieta_zakladka_wyglad']);

				$szablony = array();
				if ($this->obiekt->modul != '')
				{
					foreach (glob(SZABLON_KATALOG.'/moduly/'.$this->obiekt->kodModulu.'/Http*.tpl') as $szablon)
					{
						$szablony[basename($szablon)] = basename($szablon);
					}
				}

				$this->formularz->otworzRegion('widokKategoria', $this->tlumaczenia['etykieta_region_widok_kategoria']);

					$widoki = $cms->dane()->Widok()
						->zwracaTablice(array('id','nazwa'))
						->pobierzWszystko(null, new Widok\Sorter('nazwa', 'asc'));
					$listaWidokow = listaZTablicy($widoki, 'id', 'nazwa');
					if (count($listaWidokow) == 0)
					{          
                  $cms->temp('komunikaty', array(array(
                      'tresc' => $this->tlumaczenia['blad_nie_utworzono_widokow'],
                      'typ' => 'warning'
                  )));
					}

					$this->formularz->otworzZbiorowyInput('idWidokuZbiorowy');

					$this->formularz->input(new Input\Select('idWidoku', array(
						'lista' => $listaWidokow,
						'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
					)));

					$this->formularz->input(new Input\Button('przekieruj', array(
						'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin('WidokiZarzadzanie','edytuj', array('id' => $this->obiekt->idWidoku)).'\''),
						'wartosc' => $this->tlumaczenia['przekieruj']['wartosc']
					)));

					$this->formularz->zamknijZbiorowyInput('idWidokuZbiorowy');

					$this->formularz->idWidoku->dodajFiltr('intval');

					$kontenery = new Szablon();
					$kontenery->ladujTresc($this->szablonZewnetrzny, true);
					$listaKontenerow = array();
					foreach ($kontenery->struktura() as $kod)
					{
						$kod = explode('/', $kod);
						if (count($kod) == 3) $listaKontenerow[$kod[1]] = $kod[1];
					}
					$this->formularz->input(new Input\Select('kontener', array(
						'lista' => $listaKontenerow,
						'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
					)));

					$this->formularz->input(new Input\Text('klasa', array(
						'wartosc' => $this->obiekt->klasa,
					)));

					if (count($szablony) > 1)
					{
						$this->formularz->input(new Input\Select('szablon', array(
							'lista' => $szablony,
							'wartosc' => $this->obiekt->szablon,
						)));
					}

				$this->formularz->zamknijRegion('widokKategoria');

				/*
				if ($this->obiekt instanceof Model\Kategoria\Obiekt && $this->obiekt->modul != null)
				{
					$nazwa = 'Generic\\Modul\\' . $this->obiekt->modul->kod . '\\Http';
					$modul = new $nazwa();

					$tlumaczenia = $modul->pobierzTlumaczenia();
					$tlumaczeniaAkcje = $tlumaczenia['_akcje_etykiety_'];

					foreach($modul->pobierzAkcje() as $akcja)
					{
						$akcje[$akcja] = (isset($tlumaczeniaAkcje['wykonaj' . ucfirst($akcja)])) ? $tlumaczeniaAkcje['wykonaj' . ucfirst($akcja)] : $akcja;
					}

					$this->formularz->otworzRegion('widokiAkcje', $this->tlumaczenia['etykieta_region_widoki_akcje']);

						$this->formularz->input(new Input\TablicaSelect('akcjaUkladStrony', array(
							'lista_klucz' => $akcje,
							'wybierz_klucz' => $this->tlumaczenia['etykieta_select_wybierz'],
							'lista_wartosc' => $listaWidokow,
							'wybierz_wartosc' => $this->tlumaczenia['etykieta_select_wybierz'],
							'dodawanie_wierszy' => true,
						)));

						$this->formularz->input(new Input\TablicaSelect('akcjaKontener', array(
							'lista_klucz' => $akcje,
							'wybierz_klucz' => $this->tlumaczenia['etykieta_select_wybierz'],
							'lista_wartosc' => $listaKontenerow,
							'wybierz_wartosc' => $this->tlumaczenia['etykieta_select_wybierz'],
							'dodawanie_wierszy' => true,
						)));

						$this->formularz->input(new Input\TablicaSelect('akcjaKlasa', array(
							'lista_klucz' => $akcje,
							'wybierz_klucz' => $this->tlumaczenia['etykieta_select_wybierz'],
							'dodawanie_wierszy' => true,
						)));

						if (count($szablony) > 1)
						{
							$this->formularz->input(new Input\TablicaSelect('akcjaSzablon', array(
								'lista_klucz' => $akcje,
								'wybierz_klucz' => $this->tlumaczenia['etykieta_select_wybierz'],
								'lista_wartosc' => $szablony,
								'wybierz_wartosc' => $this->tlumaczenia['etykieta_select_wybierz'],
								'dodawanie_wierszy' => true,
							)));
						}

					$this->formularz->zamknijRegion('widokiAkcje');
				}
				*/

			/**
			 * Zamkniecie zakładki do edycji widoków kategorii
			 */
			$this->formularz->zamknijZakladke('wyglad');


			/**
			 * Otwarcie zakladki SEO kategorii
			 */
			$this->formularz->otworzZakladke('seo', $this->tlumaczenia['etykieta_zakladka_seo']);

				$this->formularz->input(new Input\Text('tytulStrony', array(
					'atrybuty' => array('maxlength' => 255, 'class' => 'dlugiePole'),
				)));
				$this->formularz->tytulStrony->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

				$this->formularz->input(new Input\Text('opis', array(
					'atrybuty' => array('maxlength' => 255, 'class' => 'dlugiePole'),
				)));
				$this->formularz->opis->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

				$this->formularz->input(new Input\Text('slowaKluczowe', array(
					'atrybuty' => array('maxlength' => 255, 'class' => 'dlugiePole'),
				)));
				$this->formularz->slowaKluczowe->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

				$this->formularz->input(new Input\TextArea('naglowekHtml', array(
					'atrybuty' => array('maxlength' => 1000, 'class' => 'dlugiePole'),
				)));
				$this->formularz->naglowekHtml->dodajFiltr('trim');

				$this->formularz->input(new Input\TextArea('skrypt', array(
					'atrybuty' => array('maxlength' => 1000, 'class' => 'dlugiePole'),
				)));
				$this->formularz->skrypt->dodajFiltr('trim');

				$this->formularz->input(new Input\TextArea('naglowekHttp', array(
					'atrybuty' => array('maxlength' => 1000, 'class' => 'dlugiePole'),
				)));
				$this->formularz->naglowekHttp->dodajFiltr('trim');

				if (in_array($this->obiekt->kodModulu, $cms->projekt->powiazaneModulyRss))
				{
					$this->formularz->input(new Input\Checkbox('rssWlaczony'));
					$this->formularz->rssWlaczony->dodajFiltr('intval');
				}

			/**
			 * Zamkniecie zakladki SEO kategorii
			 */
			$this->formularz->zamknijZakladke('seo');
		}

		if ($this->obiekt->typ == 'link_wewnetrzny')
		{
			$lista = array();
			$kategorie = $cms->dane()->Kategoria();
			foreach ($kategorie->pobierzWszystko() as $kat)
			{
				if (in_array($kat->typ, array('system', 'menu', 'link_wewnetrzny'))) continue;
				$lista[$kat->id] = str_repeat('&nbsp;&nbsp;&nbsp;', $kat->poziom).$kat->nazwa;
			}
			$this->formularz->input(new Input\Select('idKategorii', array(
				'lista' => $lista,
			)));
			$this->formularz->idKategorii->dodajWalidator(new Walidator\WiekszeOd(1));

			/**
			 * Zamkniecie glownej zakladki kategorii
			 */
			$this->formularz->zamknijZakladke('kategoria');
		}

		if ($this->obiekt->typ == 'link_zewnetrzny')
		{
			$this->formularz->input(new Input\Text('adresZewnetrzny', array(
				'atrybuty' => array('maxlength' => 255),
			)));
			//$form->adresZewnetrzny->dodajWalidator(new Walidator_Url());

			/**
			 * Zamkniecie glownej zakladki kategorii
			 */
			$this->formularz->zamknijZakladke('kategoria');
		}

		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin('KategorieZarzadzanie','index').'\''),
		)));

		foreach ($this->formularz as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->konfiguracja['wymagane_pola']))
			{
				$this->formularz->$nazwaInputa->wymagany = true;
				$this->formularz->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}
			
			if (strpos($nazwaInputa, 'nazwaPrzyjazna') !== false)
			{
				if (count($this->obiekt->nazwaPrzyjazna) > 1)
				{
					foreach ($this->obiekt->nazwaPrzyjazna as $kod => $nazwaJezyka)
					{
						$nazwaInputa = 'nazwaPrzyjazna_'.$kod;
						if(isset($this->formularz->$nazwaInputa))
						    $this->formularz->$nazwaInputa->ustawWartosc($nazwaJezyka);
					}
				}
				continue;
			}

			$wartosc = $input->pobierzWartoscPoczatkowa();
			if (!empty($wartosc)) continue;

			if ($nazwaInputa == 'akcjaKontener' || $nazwaInputa == 'akcjaUkladStrony' || $nazwaInputa == 'akcjaSzablon' || $nazwaInputa == 'akcjaKlasa')
			{
				$this->formularz->$nazwaInputa->ustawWartosc(unserialize($this->obiekt->$nazwaInputa));
				continue;
			}
			if ($nazwaInputa == 'czyscStaryUrl') continue;

			$this->formularz->$nazwaInputa->ustawWartosc($this->obiekt->$nazwaInputa);
		}



		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Kategoria\Edycja
	 */
	public function ustawSzablonZewnetrzny($szablon)
	{
		$this->szablonZewnetrzny = $szablon;

		return $this;
	}
}