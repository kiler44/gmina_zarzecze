<?php
namespace Generic\Modul\KategorieZarzadzanie;
use Generic\Biblioteka\Modul;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Walidator;
use Generic\Model\Uprawnienie;
use Generic\Model\WierszKonfiguracji;
use Generic\Model\WierszTlumaczen;
use Generic\Model\StronaOpisowa;


/**
 * Moduł administracyjny odpowiedzialny za zarządzanie kategoriami podstron.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\KategorieZarzadzanie\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\KategorieZarzadzanie\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajUsun',
		'wykonajSortowanie',
		'wykonajCzysc',
		'wykonajPrzebudowa',
		'wykonajPoprawUrl',
		'wykonajCzyscStaryUrl',
		'wykonajPobierzKonfiguracje',
		'wykonajWczytajKonfiguracje',
	);



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));
		$kategorie = $this->dane()->Kategoria();
		$dane = array();
		$kategorie = $kategorie->pobierzWszystko();

		if (count($kategorie) > 0)
		{
			foreach ($kategorie as $kategoria)
			{
				$dane = array(
					'nazwa_kategorii' => ((isset($kategoria->nazwaPrzyjazna[KOD_JEZYKA_ITERFEJSU]) && $kategoria->nazwaPrzyjazna[KOD_JEZYKA_ITERFEJSU] != '') ? $kategoria->nazwaPrzyjazna[KOD_JEZYKA_ITERFEJSU] : $kategoria->nazwa),
					'modul' => ($kategoria->modul instanceof DostepnyModul\Obiekt) ? $kategoria->modul->nazwa : '',
					'poziom' => $kategoria->poziom,
					'widoczna' => $kategoria->czyWidoczna,
					'link_tresc' => ($kategoria->kodModulu != '') ? Router::urlAdmin($kategoria) : Router::urlAdmin('KategorieZarzadzanie', 'edytuj', array('id' => $kategoria->id)),
					'link_dodaj' => Router::urlAdmin('KategorieZarzadzanie', 'dodaj', array('id' => $kategoria->id)),
					'link_edycja' => Router::urlAdmin('KategorieZarzadzanie', 'edytuj', array('id' => $kategoria->id)),
					'link_usun' => Router::urlAdmin('KategorieZarzadzanie', 'usun', array('id' => $kategoria->id)),
				);
				if ($kategoria->typ == 'system')
				{
					unset($dane['link_tresc']);
					unset($dane['link_usun']);
					unset($dane['link_przenies']);
					$this->szablon->ustawBlok('/index/kategoria_glowna', $dane);
				}
				else
				{
					$this->szablon->ustawBlok('/index/kategoria', $dane);
					if ($kategoria->typ == 'kategoria' || $kategoria->typ == 'glowna')
					{
						$this->szablon->ustawBlok('/index/kategoria/link_start', $dane);
						$this->szablon->ustawBlok('/index/kategoria/link_end', $dane);
					}
				}
			}
		}
		else
		{
			$this->komunikat($this->j->t['index.info_nie_dodano_kategorii'], 'info');
		}
		if ($this->k->k['wczytajKonfiguracje.pokaz_przyciski'])
		{
			$this->szablon->ustawBlok('/index/przyciski', array(
				'link_pobierz_konfiguracje' => Router::urlAdmin('KategorieZarzadzanie', 'pobierzKonfiguracje'),
				'link_wczytaj_konfiguracje' => Router::urlAdmin('KategorieZarzadzanie', 'wczytajKonfiguracje'),
			));
		}

		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'link_usun_wszystkie' => Router::urlAdmin('KategorieZarzadzanie', 'czysc'),
			'link_sortowanie' => Router::urlAdmin('KategorieZarzadzanie', 'sortowanie'),
			'link_przebudowa' => Router::urlAdmin('KategorieZarzadzanie', 'przebudowa'),
			'link_przekierowania' => Router::urlAdmin('KategorieZarzadzanie', 'przekierowania'),
		));
	}



	public function wykonajDodaj()
	{
		$mapper = $this->dane()->Kategoria();
		$rodzic = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));

		if (!($rodzic instanceof Kategoria\Obiekt))
		{
			$this->komunikat($this->j->t['dodaj.blad_brak_kategorii_nadrzednej'],'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'index'));
			return;
		}

		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));

		$kategoria = new Kategoria\Obiekt();
		$kategoria->idRodzica = $rodzic->id;
		$kategoria->idProjektu = ID_PROJEKTU;
		$kategoria->kodJezyka = KOD_JEZYKA;
		$kategoria->czyWidoczna = 1;

		$formularz = $this->budujFormularz($kategoria);
      
      $komunikaty = Cms::inst()->temp('komunikaty');
      if (is_array($komunikaty) && !empty($komunikaty))
      {
         foreach ($komunikaty as $komunikat)
         {
            $this->komunikat($komunikat['tresc'], $komunikat['typ']);
         }
      }
		$this->tresc .= $this->szablon->parsujBlok('dodaj', array(
			'formularz' => $formularz->html()
		));
	}



	public function wykonajEdytuj()
	{
		$mapper = $this->dane()->Kategoria();
		$kategoria = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));

		if (!($kategoria instanceof Kategoria\Obiekt))
		{
			$this->komunikat($this->j->t['edytuj.blad_brak_kategorii'],'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'index'));
			return;
		}
		if ($kategoria->typ == 'system')
		{
			$this->komunikat($this->j->t['edytuj.blad_nie_mozna_edytowac_kategorii'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'index'));
			return;
		}

		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

		$formularz = $this->budujFormularz($kategoria);
      
        $komunikaty = Cms::inst()->temp('komunikaty');
      
        if (is_array($komunikaty) && !empty($komunikaty))
        {
            foreach ($komunikaty as $komunikat)
            {
                $this->komunikat($komunikat['tresc'], $komunikat['typ']);
            }
        }
      
		$this->tresc .= $this->szablon->parsujBlok('edytuj', array(
			'formularz' => $formularz->html(),
			'sciezka' => str_replace('/'.$kategoria->kod.'/', '/', $kategoria->pelnyLink),
		));
	}



	public function wykonajUsun()
	{
		$mapper = $this->dane()->Kategoria();
		$id = Zadanie::pobierzGet('id', 'intval','abs');
		$kategoria = $mapper->pobierzPoId($id);

		if (!($kategoria instanceof Kategoria\Obiekt))
		{
			$this->komunikat($this->j->t['usun.blad_brak_kategorii'],'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'index'));
			return;
		}
		if ($kategoria->typ == 'system')
		{
			$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_kategorii'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'index'));
			return;
		}

		$uprawnieniaMapper = $this->dane()->Uprawnienie();
		$cms = Cms::inst();

		$cms->Baza()->transakcjaStart();
		if ($kategoria->usun($mapper) && $uprawnieniaMapper->usunDlaKategorii($id))
		{
			$this->komunikat($this->j->t['usun.info_usunieto_kategorie'], 'info', 'sesja');
			$cms->Baza()->transakcjaPotwierdz();
		}
		else
		{
			$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_kategorii'], 'error', 'sesja');
			$cms->Baza()->transakcjaPotwierdz();
		}
		Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie','index'));
	}



	/**
	 * Tworzy formularz edycji dla podanej kategorii
	 *
	 * @param Kategoria $kategoria Obiekt kategorii
	 *
	 * @return Formularz
	 */
	private function budujFormularz($kategoria = false)
	{

		$obiektFormularza = new \Generic\Formularz\Kategoria\Edycja();
		$obiektFormularza->ustawObiekt($kategoria)
			->ustawSzablonZewnetrzny($this->ladujSzablonZewnetrzny($this->k->k['szablon.kontenery']))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('kategoria'))
			->ustawKonfiguracje(array('wymagane_pola' => $this->k->k['formularz.wymagane_pola']));

		if ($obiektFormularza->wypelniony())
		{
			$dane = $obiektFormularza->pobierzWartosci();

			if (isset($dane['akcjaKontener']) && count($dane['akcjaKontener']) > 0)
				$obiektFormularza->zwrocFormularz()->akcjaKontener->dodajWalidator(new Walidator\NiePuste());
			if (isset($dane['akcjaUkladStrony']) && count($dane['akcjaUkladStrony']) > 0)
				$obiektFormularza->zwrocFormularz()->akcjaUkladStrony->dodajWalidator(new Walidator\NiePuste());
			if (isset($dane['akcjaSzablon']) && count($dane['akcjaSzablon']) > 0)
				$obiektFormularza->zwrocFormularz()->akcjaSzablon->dodajWalidator(new Walidator\NiePuste());
			if (isset($dane['akcjaKlasa']) && count($dane['akcjaKlasa']) > 0)
				$obiektFormularza->zwrocFormularz()->akcjaKlasa->dodajWalidator(new Walidator\NiePuste());

			if ($obiektFormularza->danePoprawne())
			{
				$this->zapiszKategorie($kategoria, $dane);
			}
		}
		return $obiektFormularza;
	}



	private function zapiszKategorie(Kategoria\Obiekt $kategoria, Array $dane)
	{
		$mapper = $this->dane()->Kategoria();

		// wartosci domyslne
		if ($kategoria->id < 1)
		{
			$kategoria->czyWidoczna = 1;
			$kategoria->dlaZalogowanych = 0;
			$kategoria->wymagaHttps = 0;
		}

		$nazwaPrzyjazna = array();
		foreach ($dane as $klucz => $wartosc)
		{
			if (strpos($klucz, 'nazwaPrzyjazna') !== false)
			{
				$nazwaPrzyjazna[substr($klucz, -2)] = $wartosc;
				continue;
			}
			if ($klucz == 'szablon' && $wartosc == 'Http.tpl')
			{
				$kategoria->$klucz = null;
				continue;
			}
			if ($klucz == 'pelnyLink') continue;
			if ($kategoria->id > 0 && $klucz == 'typ') continue;
			if ($kategoria->kodModulu != '' && $klucz == 'kodModulu') continue;

			if ($klucz == 'akcjaKontener' || $klucz == 'akcjaUkladStrony' || $klucz == 'akcjaSzablon' || $klucz == 'akcjaKlasa')
			{
				$kategoria->$klucz = serialize($wartosc);
				continue;
			}

			$kategoria->$klucz = $wartosc;
		}
		$kategoria->nazwaPrzyjazna = $nazwaPrzyjazna;

		switch ($kategoria->typ)
		{
			case 'glowna':
				$kategoria->czyWidoczna = 1;
				if ($kategoria->modul instanceof DostepnyModul\Obiekt && $kategoria->modul->dlaZalogowanych) $kategoria->dlaZalogowanych = 1;
			break;

			case 'menu':
				$kategoria->czyWidoczna = 1;
				$kategoria->dlaZalogowanych = 0;
				$kategoria->wymagaHttps = 0;
			break;

			case 'link_wewnetrzny':
				$kategoria->dlaZalogowanych = 0;
				$kategoria->wymagaHttps = 0;
			break;

			case 'kategoria':
				if ($kategoria->modul instanceof DostepnyModul\Obiekt && $kategoria->modul->dlaZalogowanych) $kategoria->dlaZalogowanych = 1;
			break;
		}
        $kategoria->generujPelnyLink();
		if ($kategoria->id > 0)
		{
			$info = $this->j->t['edytuj.info_zapisano_dane_kategorii'];
			$blad = $this->j->t['edytuj.blad_nie_mozna_zapisac_kategorii'];
			$akcja = 'stronaStartowa';
		}
		else
		{
			$info = $this->j->t['dodaj.info_zapisano_dane_kategorii'];
			$blad = $this->j->t['dodaj.blad_nie_mozna_zapisac_kategorii'];
			$akcja = 'stronaEdycji';
		}

		if ($kategoria->zapisz($mapper))
		{
			Kategoria\MapperCache::wywolaj()->zaladujDane();

         
			if (in_array($kategoria->typ, array('kategoria', 'glowna')) && $kategoria->kodModulu != '')
			{
				$this->tworzUprawnienia($kategoria);
			}
         

			$this->komunikat($info, 'info', 'sesja');

			if ($akcja == 'stronaEdycji')
			{
				Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'edytuj', array('id' => $kategoria->id)));
			}
			else
			{
				Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'index'));
			}
		}
		else
		{
			$this->komunikat($blad, 'error');
		}
	}



	private function tworzUprawnienia(Kategoria\Obiekt $kategoria)
	{
		// budujemy tablice z kodami uprawnien do kategorii
		$uprawnienia = array();
		$modul = 'Generic\\Modul\\'.$kategoria->kodModulu.'\\Admin';
		$modul = new $modul;
		foreach ($modul->pobierzUprawnienia() as $akcja)
		{
			$uprawnienia['Admin_'.$kategoria->id.'_'.$akcja] = $kategoria->kodModulu;
		}
		/*
		if ($kategoria->dlaZalogowanych == 1 && in_array($kategoria->typ, array('kategoria', 'glowna')))
		{
			$modul = 'Generic\\Modul\\'.$kategoria->kodModulu.'\\Http';
			$modul = new $modul;
			foreach ($modul->pobierzUprawnienia() as $akcja)
			{
				$uprawnienia['Http_'.$kategoria->id.'_'.$akcja] = $kategoria->kodModulu;
			}
		}
		*/

		// pobieramy istniejace uprawnienia z bazy i jezeli jakichs brak to tworzymy nowe
		$uprawnieniaMapper = $this->dane()->Uprawnienie();
		$dane_baza = $uprawnieniaMapper->pobierzDlaModulu($kategoria->kodModulu);
		$uprawnienia_baza = array();
		if (is_array($dane_baza) && count($dane_baza) > 0)
		{
			foreach ($dane_baza as $wiersz)
			{
				$uprawnienia_baza[$wiersz->usluga.'_'.$wiersz->idKategorii.'_'.$wiersz->akcja] = $wiersz;
			}
		}
		foreach ($uprawnienia as $kod => $modul)
		{
			if (!array_key_exists($kod, $uprawnienia_baza))
			{
				$kod = explode('_', $kod);
				$uprawnienie = new Uprawnienie\Obiekt();
				$uprawnienie->idProjektu = ID_PROJEKTU;
				$uprawnienie->kodJezyka = KOD_JEZYKA;
				$uprawnienie->usluga = $kod[0];
				$uprawnienie->idKategorii = $kod[1];
				$uprawnienie->kodModulu = $modul;
				$uprawnienie->akcja = $kod[2];
            $uprawnienie->hash = funkcjaHashujaca($kod[0].'_'.$kod[1].'_'.$kod[2]);
				$uprawnienie->zapisz($uprawnieniaMapper);
				$kod = implode('_', $kod);
				$uprawnienia_baza[$kod] = $uprawnienie;
			}
		}

		// sprawdzamy czy istnieja role z dostepem do modulu i jezeli sa to tworzymy powiazania z uprawnieniami
		$roleMapper = $this->dane()->Rola();
		$role = $roleMapper->zwracaTablice()->pobierzDlaDostepnegoModulu($kategoria->kodModulu);
		if (count($role) > 0)
		{
			foreach ($role as $rola)
			{
				foreach ($uprawnienia as $kod => $modul)
				{
					$uprawnienia_baza[$kod]->przypiszDoRoli($rola['id']);
				}
			}
		}
		// odswierzanie uprawnien uzytkownika
		Cms::inst()->profil()->odnowUprawnienia();
	}



	public function wykonajSortowanie()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['sortowanie.tytul_strony']));

		$mapper = $this->dane()->Kategoria();

		$kategorie = $mapper->pobierzWszystko();
		$niesortowalneKategorie = array();
		if (count($kategorie) > 0)
		{
			$drzewo = '<div id="sortowanieKategorii"><ul id="root">'."\n";
			$poprzednia = null;
			foreach ($kategorie as $kategoria)
			{
				if ($poprzednia instanceof Kategoria\Obiekt)
				{
					if ($poprzednia->poziom < $kategoria->poziom)
					{
						$drzewo .= ($kategoria->poziom == 1) ? '' : "\n".'<ul>';
						$pierwsza[$kategoria->poziom] = $kategoria->id;
					}
					elseif ($poprzednia->poziom == $kategoria->poziom)
					{
						$drzewo .= ($kategoria->poziom == 1) ? '' : '</li>';
					}
					elseif ($poprzednia->poziom > $kategoria->poziom)
					{
						$powtorzen = $poprzednia->poziom - $kategoria->poziom;
						$drzewo .= str_repeat('</li>'."\n".'</ul>'."\n", (int)$powtorzen);
						$drzewo .= "\n".'</li>';
					}
					if (in_array($kategoria->typ, array('glowna','menu')))
					{
						$sortowalna = 'niesortowalnaKategoria';
						$niesortowalneKategorie[] = 'kategoria_'.$kategoria->id;
					}
					else
					{
						$sortowalna =  'sortowalnaKategoria';
					}
					$drzewo .= '<li id="kategoria_'.$kategoria->id.'" rel="'.$sortowalna.'" class="poziom'.$kategoria->poziom.' '.$sortowalna.'"><a href="#">'.$kategoria->nazwa.'</a>'."\n";
				}
				$poprzednia = clone $kategoria;
			}
		}
		$drzewo .= str_repeat('</li>'."\n".'</ul>', $poprzednia->poziom);
		$drzewo .= '</div>';

		$obiektFormularza = new \Generic\Formularz\Kategoria\Sortowanie();
		$obiektFormularza->ustawDrzewo($drzewo);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$dane = $obiektFormularza->pobierzWartosci();
			$dane['przenoszona'] = intval(str_replace('kategoria_', '', $dane['przenoszona']));
			$dane['cel'] = intval(str_replace('kategoria_', '', $dane['cel']));

			if ($dane['przenoszona'] < 2 || $dane['cel'] < 2)
			{
				$this->komunikat($this->j->t['sortowanie.blad_niepelne_dane_kategorii'], 'error', 'sesja');
				Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'sortowanie'));
			}
			if (!in_array($dane['polozenie'], array('before', 'after', 'inside')))
			{
				$this->komunikat($this->j->t['sortowanie.blad_nieprawidlowe_oznaczenie_polozenia'], 'error', 'sesja');
				Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'sortowanie'));
			}

			$przenoszona = $mapper->pobierzPoId($dane['przenoszona']);
			$cel = $mapper->pobierzPoId($dane['cel']);
			if ($przenoszona instanceof Kategoria\Obiekt
				&& !in_array($przenoszona->typ, array('system', 'glowna','menu'))
				&& $cel instanceof Kategoria\Obiekt
				&& !in_array($cel->typ, array('system')))
			{
				if ($dane['polozenie'] == 'inside')
				{
					if ($przenoszona->zmienRodzica($mapper, $cel->id))
					{
						$staraSciezka = $przenoszona->pelnyLink;
						$przenoszona->generujPelnyLink();
						$przenoszona->staryUrl = ($staraSciezka != $przenoszona->pelnyLink) ? $staraSciezka : $przenoszona->staryUrl;

						$przenoszona->zapisz($mapper);
						$this->komunikat($this->j->t['sortowanie.info_zmieniono_rodzica_kategorii'], 'info', 'sesja');
						Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'sortowanie'));
					}
					else
					{
						$this->komunikat($this->j->t['sortowanie.blad_nie_mozna_zmienic_rodzica_kategorii'], 'error');
					}
				}
				else
				{
					$dane['polozenie'] = ($dane['polozenie'] == 'before') ? 'przed' : 'po';
					if ($przenoszona->idRodzica == $cel->idRodzica)
					{
						if ($przenoszona->przeniesObok($mapper, $cel->id, $dane['polozenie']))
						{
							$staraSciezka = $przenoszona->pelnyLink;
							$przenoszona->generujPelnyLink();
							$przenoszona->staryUrl = ($staraSciezka != $przenoszona->pelnyLink) ? $staraSciezka : $przenoszona->staryUrl;

							$przenoszona->zapisz($mapper);
							$this->komunikat($this->j->t['sortowanie.info_zmieniono_ustawienie_kategorii'], 'info', 'sesja');
							Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'sortowanie'));
						}
						else
						{
							$this->komunikat($this->j->t['sortowanie.blad_nie_mozna_zmienic_ustawienia_kategorii'], 'error');
						}
					}
					else
					{
						$this->komunikat($this->j->t['sortowanie.blad_nieprawidlowe_dane_sasiada'], 'warning');
					}
				}
			}
			else
			{
				$this->komunikat($this->j->t['sortowanie.blad_nieprawidlowe_dane_kategorii'], 'error');
			}
		}
		$this->tresc .= $this->szablon->parsujBlok('sortowanie',array(
			'form' => $obiektFormularza->html(),
			'rozwin' => '"'.implode('","', $niesortowalneKategorie).'"',
		));
	}



	public function wykonajCzysc()
	{
		$mapper = $this->dane()->Kategoria();
		$cms = Cms::inst();

		$cms->Baza()->transakcjaStart();
		if ($mapper->czysc())
		{
			$this->komunikat($this->j->t['czysc.info_usunieto_drzewo_kategorii'], 'info', 'sesja');
			$cms->Baza()->transakcjaPotwierdz();
		}
		else
		{
			$this->komunikat($this->j->t['czysc.blad_nie mozna_usunac_drzewa_kategorii'],'error', 'sesja');
			$cms->Baza()->transakcjaCofnij();
		}
		Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'index'));
	}



	public function wykonajCzyscStaryUrl()
	{
		$cms = Cms::inst();
		$mapper = $this->dane()->Kategoria();
		$kategoria = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));
		$kategoria->staryUrl = null;

		if ($kategoria->zapisz($mapper))
		{
			$this->komunikat($this->j->t['czyscStaryUrl.info_wyczyszczono_url'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czyscStaryUrl.blad_nie_wyczyszczono_url'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie','edytuj', array('id' => Zadanie::pobierzGet('id', 'intval','abs'))));
	}



	public function wykonajPoprawUrl()
	{
		$cms = Cms::inst();
		$mapper = $this->dane()->Kategoria();
		$kategoria = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));
		$staraSciezka = $kategoria->pelnyLink;
		$kategoria->generujPelnyLink();
		$kategoria->staryUrl = ($staraSciezka != $kategoria->pelnyLink) ? $staraSciezka : $kategoria->staryUrl;

		if ($kategoria->zapisz($mapper))
		{
			$this->komunikat($this->j->t['przebudowa.info_przebudowano_adres_url'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['przebudowa.info_nie_mozna_przebudowac_adresu_url'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie','edytuj', array('id' => Zadanie::pobierzGet('id', 'intval','abs'))));
	}



	public function wykonajPrzebudowa()
	{
		$cms = Cms::inst();
		$mapper = $this->dane()->Kategoria();
		$kategorie = $mapper->pobierzWszystko();

		$przetwarzane = 0;
		$zapisane = 0;
		if (count($kategorie) > 0)
		{
			$cms->Baza()->transakcjaStart();
			foreach ($kategorie as $kategoria)
			{
				if ($kategoria->id < 2) continue;
				$przetwarzane++;
				$staraSciezka = $kategoria->pelnyLink;
				$kategoria->generujPelnyLink();
				$kategoria->staryUrl = ($staraSciezka != $kategoria->pelnyLink) ? $staraSciezka : $kategoria->staryUrl;
				if ($kategoria->zapisz($mapper)) $zapisane++;
			}
			if ($przetwarzane == $zapisane)
			{
				$this->komunikat($this->j->t['przebudowa.info_przebudowano_adresy_url'], 'info', 'sesja');
				$cms->Baza()->transakcjaPotwierdz();
			}
			else
			{
				$this->komunikat($this->j->t['przebudowa.info_nie_mozna_przebudowac_adresow_url'],'error', 'sesja');
				$cms->Baza()->transakcjaCofnij();
			}
		}
		else
		{
			$this->komunikat($this->j->t['przebudowa.info_nie_utworzono_jeszcze_kategorii'],'info', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'index'));
	}



	public function wykonajPobierzKonfiguracje()
	{
		$kategorie = array();
		$konfiguracja = array();
		$tlumaczenia = array();
		$tresci = array();

		$kategorie = $this->dane()->Kategoria()->zwracaTablice()->pobierzWszystko();
		$konfiguracjaPelna = $this->dane()->WierszKonfiguracji()->zwracaTablice()->pobierzPelna();
		$tlumaczeniaPelne = $this->dane()->WierszTlumaczen()->zwracaTablice()->pobierzPelna();
		$opisy = $this->dane()->StronaOpisowa()->zwracaTablice()->pobierzWszystko();

		foreach ($konfiguracjaPelna as $wiersz)
		{
			if (intval($wiersz['id_kategorii']) > 0)
			{
				$konfiguracja[$wiersz['id_kategorii']][] = $wiersz;
			}
		}

		foreach ($tlumaczeniaPelne as $wiersz)
		{
			if (intval($wiersz['id_kategorii']) > 0)
			{
				$tlumaczenia[$wiersz['id_kategorii']][] = $wiersz;
			}
		}

		foreach ($opisy as $wiersz)
		{
			if (intval($wiersz['id_kategorii']) > 0)
			{
				$tresci[$wiersz['id_kategorii']] = $wiersz;
			}
		}

		$dane = array(
			'kategorie' => $kategorie,
			'konfiguracja_kategorii' => $konfiguracja,
			'tlumaczenia_kategorii' => $tlumaczenia,
			'tresci_kategorii' => $tresci,
		);

		/**
		 * Tworzenie sumy kontrolnej dla konfiguracji widokow, zabezpieczenie przed majstronwanie przy pliku z konfiguracja
		 */
		$dane['suma_kontrolna'] = md5('SuperTraders jest the best!!!' . var_export($dane, true) . 'SuperTraders jest the best!!!');

		$tresc = "<?php
namespace Generic\Modul\KategorieZarzadzanie;
use Generic\Biblioteka\Modul;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Model\Widok;
use Generic\Biblioteka\Szablon;
use Generic\Model\Uprawnienie;
use Generic\Model\WierszKonfiguracji;
use Generic\Model\WierszTlumaczen;
use Generic\Model\StronaOpisowa;
 return " . var_export($dane, true) . ";";
		zwrocTrescDoPrzegladarki($tresc, 'kategorieKonfiguracja.inc.php');
	}



	public function wykonajWczytajKonfiguracje()
	{
		$cms = Cms::inst();

		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['wczytajKonfiguracje.tytul_strony']));

		$obiektFormularza = new \Generic\Formularz\Kategoria\Import();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('wczytajKonfiguracje'))
			->ustawUrlPowrotny(Router::urlAdmin('WidokiZarzadzanie'))
			->ustawKonfiguracje(array('dozwolone_formaty_plikow' => $this->k->k['wczytajKonfiguracje.dozwolone_formaty_plikow']));

		if ($obiektFormularza->wypelniony())
		{
			if ($obiektFormularza->danePoprawne())
			{
				$plik_konfiguracja = $obiektFormularza->zwrocFormularz()->plik->pobierzWartosc();

				if (is_file($plik_konfiguracja['tmp_name']))
				{
					$dane = @include($plik_konfiguracja['tmp_name']);

					/**
					 * Sprawdzanie czy wczytany plik jest tablica i czy ustawiona jest suma kontrolna
					 */
					if (is_array($dane) && isset($dane['suma_kontrolna']))
					{
						/**
						 * Sprawdzanie czy suma kontrolna pliku z konfiguracja jest poprawna
						 */
						$sumaKontrolna = $dane['suma_kontrolna'];
						unset($dane['suma_kontrolna']);

						$dane['suma_kontrolna'] = md5('SuperTraders jest the best!!!' . var_export($dane, true). 'SuperTraders jest the best!!!');

						if ($sumaKontrolna == $dane['suma_kontrolna'])
						{
							$cms->Baza()->transakcjaStart();

							$statusy = array();
							$dostepneKategorie = array();
							$bledy = array();

							$kategorieMapper = $this->dane()->Kategoria();
							$konfiguracjaMapper = $this->dane()->WierszKonfiguracji();
							$tlumaczeniaMapper = $this->dane()->WierszTlumaczen();
							$opisyMapper = $this->dane()->StronaOpisowa();
							$modulyMapper = DostepnyModul\Mapper::wywolaj();

							if ($this->k->k['wczytajKonfiguracje.kasuj_stara_konfiguracje'])
							{
								$kategorieMapper->usunWszystko();
								$konfiguracjaMapper->czyscDlaWszystkichKategorii();
								$tlumaczeniaMapper->czyscDlaWszystkichKategorii();
							}

							$polaKategorie = $kategorieMapper->pobierzPolaTabeliObiekt();
							$polaKonfiguracja = $konfiguracjaMapper->pobierzPolaTabeliObiekt();
							$polaTlumaczenia = $tlumaczeniaMapper->pobierzPolaTabeliObiekt();
							$polaOpisy = $opisyMapper->pobierzPolaTabeliObiekt();

							$przypisaneModuly = listaZTablicy($modulyMapper->zwracaTablice()->pobierzPrzypisane(), null, 'kod');

							$stareKategorie = listaZObiektow($kategorieMapper->pobierzWszystko(), 'id');

							$polaBool = array('czy_widoczna','dla_zalogowanych','wymaga_https','blokada','rss_wlaczony','cache',);
							/**
							* Zapisanie do bazy danych zaimportowanych blokow
							*/
							foreach ($dane['kategorie'] as $wiersz)
							{
								$kategoria = new Kategoria\Obiekt();

								$wierszObiekt = array();
								foreach ($wiersz as $pole => $wartosc)
								{
									if (in_array($pole, $polaBool)) $wartosc = (int)$wartosc;
									$wierszObiekt[$polaKategorie[$pole]] = $wartosc;
								}
								$kategoria->wypelnij($wierszObiekt);

								$statusy[] = $kategorieMapper->wstawZId($kategoria, $kategoria->id);
								$idKategorii = $kategoria->id;

								/**
								 * Jesli istnieje konfiguracja dla kategorii, zapisujemy ja do bazy
								 */
								if (isset($dane['konfiguracja_kategorii'][$idKategorii]))
								{
									foreach ($dane['konfiguracja_kategorii'][$idKategorii] as $wierszKonfiguracji)
									{
										$wierszK = new WierszKonfiguracji\Obiekt();
										foreach ($wierszKonfiguracji as $pole => $wartosc)
										{
											if ($pole == 'id') continue;
											$wierszK->{$polaKonfiguracja[$pole]} = $wartosc;
										}
										$statusy[] = $wierszK->zapisz($konfiguracjaMapper);
									}
								}

								/**
								 * Jesli istnieja tlumaczenia dla kategorii, zapisujemy je do bazy
								 */
								if (isset($dane['tlumaczenia_kategorii'][$idKategorii]))
								{
									foreach ($dane['tlumaczenia_kategorii'][$idKategorii] as $wierszTlumaczen)
									{
										$wierszT = new WierszTlumaczen\Obiekt();
										foreach ($wierszTlumaczen as $pole => $wartosc)
										{
											if ($pole == 'id') continue;
											$wierszT->{$polaTlumaczenia[$pole]} = $wartosc;
										}
										$statusy[] = $wierszT->zapisz($tlumaczeniaMapper);
									}
								}

								/**
								 * Jesli strona jest opisowa, nadpisujemy tresc
								 */
								if (isset($dane['tresci_kategorii'][$idKategorii]))
								{
									$stronaOpisowa = new StronaOpisowa\Obiekt();
									foreach ($dane['tresci_kategorii'][$idKategorii] as $pole => $wartosc)
									{
										if ($pole == 'id') continue;
										$stronaOpisowa->{$polaOpisy[$pole]} = $wartosc;
									}
									$statusy[] = $stronaOpisowa->zapisz($opisyMapper);
								}
							}
//$cms->baza->transakcjaCofnij();
//return;
							/**
							 * Sprawdzanie czy import zostal przeprowadzony prawidlowo
							 */
							if (array_search(false, $statusy) === false)
							{
								$trescKomunikatu = $this->j->t['wczytajKonfiguracje.wczytano_konfiguracje'];
								$trescKomunikatu .= $this->szablon->parsujBlok('bledy');

								//$cms->baza->transakcjaCofnij();
								$cms->Baza()->transakcjaPotwierdz();
								$this->komunikat($trescKomunikatu, 'info', 'sesja');
								Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'index'));
							}
							else
							{
								$cms->Baza()->transakcjaCofnij();
								$this->komunikat($this->j->t['wczytajKonfiguracje.blad_nie_wczytano_konfiguracji'], 'error', 'sesja');
								Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'index'));
							}
						}
						else
						{
							$this->komunikat($this->j->t['wczytajKonfiguracje.niepoprawny_plik'], 'error', 'sesja');
							Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'index'));
						}
					}
					else
					{
						$this->komunikat($this->j->t['wczytajKonfiguracje.niepoprawny_plik'], 'error', 'sesja');
						Router::przekierujDo(Router::urlAdmin('KategorieZarzadzanie', 'index'));
					}
				}
			}
		}

		$this->tresc .= $obiektFormularza->html();
	}

}


