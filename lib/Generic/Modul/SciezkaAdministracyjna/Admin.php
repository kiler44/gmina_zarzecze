<?php
namespace Generic\Modul\SciezkaAdministracyjna;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Router;
use Generic\Model\Blok;


/**
 * Blok administracyjny wyświetlający ścieżkę nawigacyjną.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\SciezkaAdministracyjna\Admin
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\SciezkaAdministracyjna\Admin
	 */
	protected $j;

	protected $kategorieMapper;

	protected $blokiMapper;

	protected $modulyMapper;

	protected $tlumaczeniaModulow;

	protected $uprawnienia = array(
		'zmianaJezykaEdycji',
		'konfiguracjaModulu'
	);

	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$u = $cms->profil();

		$this->kategorieMapper = $this->dane()->Kategoria();
		$this->blokiMapper = $this->dane()->Blok();
		$this->modulyMapper = DostepnyModul\Mapper::wywolaj();

		$zadanie = array(
			'idKategorii' => Zadanie::pobierz('cat','intval','abs'),
			'idBloku' => Zadanie::pobierz('b','intval','abs'),
			'kodModulu' => Zadanie::pobierz('m','strval'),
			'akcja' => Zadanie::pobierz('a','strval'),
		);

		$sciezka = $this->sprawdzUnikatowe($zadanie);
      
		if (is_array($sciezka) && count($sciezka) < 1)
		{
			if ($zadanie['akcja'] != 'index' && $zadanie['akcja'] != '')
			{
				$krok = $zadanie;
				$krok['akcja'] = 'index';
				$sciezka[] = $krok;
			}
      }
		
		if ($cms->temp('resetujSciezke'))
		{
			$pierwszyKrok = $sciezka[0];
			$sciezka = array($pierwszyKrok);
		}
      
      $dodatkowe_kroki = $cms->temp('sciezka');
      if (is_array($dodatkowe_kroki) && count($dodatkowe_kroki) > 0)
      {
         foreach ($dodatkowe_kroki as $krok)
         {
            if (isset($krok['akcja']) && $krok['akcja'] != '' && isset($krok['idKategorii']) && $krok['idKategorii'] > 0)
            {
               array_push($sciezka, $krok);
            }
				else if (isset ($krok['url']) && $krok['url'] !== '')
				{
					array_push($sciezka, $krok);
				}
         }
      }
      
		foreach ($sciezka as $krok)
		{
			$this->wyswietlPozycje($krok);
		}
		
		$role = listaZTablicy($cms->profil()->pobierzRole(true), 'kod');
		$this->szablon->ustawGlobalne(array(
			'localizeUrl' => Router::urlAjax('admin', 'SciezkaAdministracyjna', 'zalogujLokalizacje'),
			'sprawdzajLokalizacje' => (czyMobilnyKlient() && ! (array_key_exists('admin', $role) || array_key_exists('no-location', $role)) && (array_key_exists('worker', $role) || array_key_exists('coordinator', $role))) ? true : false,
		));

		$this->szablon->ustawBlok('/index/tekst', array(
			'nazwa' => $this->j->t['index.etykieta_bierzaca_akcja'],
		));
		
		$uzytkownik = Cms::inst()->profil();
		
		if (count($cms->projekt->jezykiKody) > 1 && $uzytkownik->maUprawnieniaDo('SciezkaAdministracyjna_zmianaJezykaEdycji'))
		{
			$this->szablon->ustawBlok('/index/jezyk', array(
				'wybrany_jezyk' => KOD_JEZYKA,
				'nazwa_wybrany_jezyk' => $cms->lang['kraje'][KOD_JEZYKA],
			));

			$url = 'http://'.WWW_PREF.$cms->projekt->domena.'/admin/';

			foreach ($cms->projekt->jezykiKody as $kodJezyka)
			{
				if ($kodJezyka == KOD_JEZYKA) continue;
				$this->szablon->ustawBlok('/index/jezyk/zmien', array(
					'url' => $url.'?cl='.$kodJezyka,
					'kod' => $kodJezyka,
					'etykieta' => $cms->lang['kraje'][$kodJezyka],
				));
			}
		}
		

		if (($zadanie['idKategorii'] > 0)
			|| ($zadanie['kodModulu'] == 'KategorieZarzadzanie' && $zadanie['akcja'] == 'edytuj')
			|| ($zadanie['kodModulu'] == 'KonfiguracjaSystemu' && $zadanie['akcja'] == 'edytujKategorie')
			|| ($zadanie['kodModulu'] == 'UstawieniaJezykowe' && $zadanie['akcja'] == 'edytujKategorie')
			)
		{
			$id = ($zadanie['idKategorii'] > 0) ? $zadanie['idKategorii'] : Zadanie::pobierz('id','intval','abs');
			$kategoria = $this->kategorieMapper->pobierzPoId($id);
			if ($kategoria instanceof Kategoria\Obiekt)
			{
				/*
				if ($u->maUprawnieniaDo('Admin_'.$kategoria->id.'_wykonajIndex'))
					$this->szablon->ustawBlok('/index/opcje_standardowe/tresc', array(
						'link_tresc' => htmlspecialchars(Router::urlAdmin($kategoria)),
					));
				*/
				if ($u->maUprawnieniaDo('KategorieZarzadzanie_wykonajEdytuj'))
					$this->szablon->ustawBlok('/index/opcje_standardowe/edycja', array(
						'link_edycja' => htmlspecialchars(Router::urlAdmin('KategorieZarzadzanie', 'edytuj', array('id' => $kategoria->id))),
					));
				if ($u->maUprawnieniaDo('KonfiguracjaSystemu_wykonajEdytujKategorie'))
					$this->szablon->ustawBlok('/index/opcje_standardowe/konfiguracja', array(
						'link_konfiguracja' => htmlspecialchars(Router::urlAdmin('KonfiguracjaSystemu', 'edytujKategorie', array('id' => $kategoria->id))),
					));
				if ($u->maUprawnieniaDo('UstawieniaJezykowe_wykonajEdytujKategorie'))
					$this->szablon->ustawBlok('/index/opcje_standardowe/tlumaczenia', array(
						'link_tlumaczenia' => htmlspecialchars(Router::urlAdmin('UstawieniaJezykowe', 'edytujKategorie', array('id' => $kategoria->id))),
					));
			}
		}
		elseif (($zadanie['idBloku'] > 0)
				|| ($zadanie['kodModulu'] == 'WidokiZarzadzanie' && $zadanie['akcja'] == 'edytujBlok')
				|| ($zadanie['kodModulu'] == 'KonfiguracjaSystemu' && $zadanie['akcja'] == 'edytujBlok')
				|| ($zadanie['kodModulu'] == 'UstawieniaJezykowe' && $zadanie['akcja'] == 'edytujBlok')
				)
		{
			$id = ($zadanie['idBloku'] > 0) ? $zadanie['idBloku'] : Zadanie::pobierz('id','intval','abs');
			$blok = $this->blokiMapper->pobierzPoId($id);
			if ($blok instanceof Blok\Obiekt)
			{
				if ($u->maUprawnieniaDo('Bloki_'.$blok->id.'_wykonajIndex'))
					$this->szablon->ustawBlok('/index/opcje_standardowe/tresc', array(
						'link_tresc' => htmlspecialchars(Router::urlAdmin($blok)),
					));
				if ($u->maUprawnieniaDo('WidokiZarzadzanie_wykonajEdytujBlok'))
					$this->szablon->ustawBlok('/index/opcje_standardowe/edycja', array(
						'link_edycja' => htmlspecialchars(Router::urlAdmin('WidokiZarzadzanie', 'edytujBlok', array('id' => $blok->id))),
					));
				if ($u->maUprawnieniaDo('KonfiguracjaSystemu_wykonajEdytujBlok'))
					$this->szablon->ustawBlok('/index/opcje_standardowe/konfiguracja', array(
						'link_konfiguracja' => htmlspecialchars(Router::urlAdmin('KonfiguracjaSystemu', 'edytujBlok', array('id' => $blok->id))),
					));
				if ($u->maUprawnieniaDo('UstawieniaJezykowe_wykonajEdytujBlok'))
					$this->szablon->ustawBlok('/index/opcje_standardowe/tlumaczenia', array(
						'link_tlumaczenia' => htmlspecialchars(Router::urlAdmin('UstawieniaJezykowe', 'edytujBlok', array('id' => $blok->id))),
					));
			}
		}
		
		// Obsługa menu kontekstowego ustawianego w modułach administracyjnych
		$menuKontekstowe = $cms->temp('menuKontekstowe');
		if (is_array($menuKontekstowe) && count($menuKontekstowe) > 0)
		{
			foreach ($menuKontekstowe as $nazwa => $dane)
			{
				if ($u->maUprawnieniaDo(Router::pobierzKluczUprawnieniaUrl($dane['url'])))
				{
					$this->szablon->ustawBlok('/index/opcje_kontekstowe/opcja', array(
						'url' => $dane['url'],
						'etykieta' => $dane['etykieta'],
						'ikona' => $dane['ikona'],
					));
				}
			}
		}
		
		$this->tresc .= $this->szablon->parsujBlok('index', array_merge(array(
			'wylogujUrl' => Router::urlAdmin('UserAccount', 'signOut', array('noLocation' => true)),
		), $this->sterownik->pobierzGlobalne()));
	}



	private function sprawdzUnikatowe(Array $zadanie)
	{
		$sciezka = array();
		if ($zadanie['kodModulu'] == 'UstawieniaJezykowe' && $zadanie['akcja'] == 'edytujAdministracyjny')
		{
			$sciezka[] = array(
				'kodModulu' => 'UstawieniaJezykowe',
				'akcja' => 'index',
			);
			$sciezka[] = array(
				'kodModulu' => 'UstawieniaJezykowe',
				'akcja' => 'administracyjne',
			);
		}
		else if ($zadanie['kodModulu'] == 'UstawieniaJezykowe' && $zadanie['akcja'] == 'edytujZwykly')
		{
			$sciezka[] = array(
				'kodModulu' => 'UstawieniaJezykowe',
				'akcja' => 'index',
			);
			$sciezka[] = array(
				'kodModulu' => 'UstawieniaJezykowe',
				'akcja' => 'zwykle',
			);
		}
		else if ($zadanie['kodModulu'] == 'UstawieniaJezykowe' && $zadanie['akcja'] == 'edytujKategorie')
		{
			$sciezka[] = array(
				'kodModulu' => 'KategorieZarzadzanie',
				'akcja' => 'index',
			);
			$sciezka[] = array(
				'kodModulu' => 'KategorieZarzadzanie',
				'akcja' => 'edytuj',
				'parametry' => array('id' => Zadanie::pobierz('id','intval','abs')),
			);
		}
		else if ($zadanie['kodModulu'] == 'UstawieniaJezykowe' && $zadanie['akcja'] == 'edytujBlok')
		{
			$sciezka[] = array(
				'kodModulu' => 'WidokiZarzadzanie',
				'akcja' => 'index',
			);
			$sciezka[] = array(
				'kodModulu' => 'WidokiZarzadzanie',
				'akcja' => 'bloki',
			);
			$sciezka[] = array(
				'kodModulu' => 'WidokiZarzadzanie',
				'akcja' => 'edytujBlok',
				'parametry' => array('id' => Zadanie::pobierz('id','intval','abs')),
			);
		}
		else if ($zadanie['kodModulu'] == 'KonfiguracjaSystemu' && $zadanie['akcja'] == 'edytujAdministracyjny')
		{
			$sciezka[] = array(
				'kodModulu' => 'KonfiguracjaSystemu',
				'akcja' => 'index',
			);
			$sciezka[] = array(
				'kodModulu' => 'KonfiguracjaSystemu',
				'akcja' => 'administracyjne',
			);
		}
		else if ($zadanie['kodModulu'] == 'KonfiguracjaSystemu' && $zadanie['akcja'] == 'edytujZwykly')
		{
			$sciezka[] = array(
				'kodModulu' => 'KonfiguracjaSystemu',
				'akcja' => 'index',
			);
			$sciezka[] = array(
				'kodModulu' => 'KonfiguracjaSystemu',
				'akcja' => 'zwykle',
			);
		}
		else if ($zadanie['kodModulu'] == 'KonfiguracjaSystemu' && $zadanie['akcja'] == 'edytujKategorie')
		{
			$sciezka[] = array(
				'kodModulu' => 'KategorieZarzadzanie',
				'akcja' => 'index',
			);
			$sciezka[] = array(
				'kodModulu' => 'KategorieZarzadzanie',
				'akcja' => 'edytuj',
				'parametry' => array('id' => Zadanie::pobierz('id','intval','abs')),
			);
		}
		else if ($zadanie['kodModulu'] == 'KonfiguracjaSystemu' && $zadanie['akcja'] == 'edytujBlok')
		{
			$sciezka[] = array(
				'kodModulu' => 'WidokiZarzadzanie',
				'akcja' => 'index',
			);
			$sciezka[] = array(
				'kodModulu' => 'WidokiZarzadzanie',
				'akcja' => 'bloki',
			);
			$sciezka[] = array(
				'kodModulu' => 'WidokiZarzadzanie',
				'akcja' => 'edytujBlok',
				'parametry' => array('id' => Zadanie::pobierz('id','intval','abs')),
			);
		}
		else if ($zadanie['kodModulu'] == 'UprawnieniaZarzadzanie' && $zadanie['akcja'] == 'edytuj')
		{
			$sciezka[] = array(
				'kodModulu' => 'UprawnieniaZarzadzanie',
				'akcja' => 'index',
			);
			$sciezka[] = array(
				'kodModulu' => 'UprawnieniaZarzadzanie',
				'akcja' => 'podglad',
				'parametry' => array('id' => Zadanie::pobierz('id','intval','abs')),
			);
		}
		else if ($zadanie['kodModulu'] == 'UprawnieniaZarzadzanie' && $zadanie['akcja'] == 'uprawnieniaTresci')
		{
			$sciezka[] = array(
				'kodModulu' => 'UprawnieniaZarzadzanie',
				'akcja' => 'index',
			);
			$sciezka[] = array(
				'kodModulu' => 'UprawnieniaZarzadzanie',
				'akcja' => 'podglad',
				'parametry' => array('id' => Zadanie::pobierz('id','intval','abs')),
			);
		}
		else if ($zadanie['kodModulu'] == 'UprawnieniaZarzadzanie' && $zadanie['akcja'] == 'uprawnieniaAdministracyjne')
		{
			$sciezka[] = array(
				'kodModulu' => 'UprawnieniaZarzadzanie',
				'akcja' => 'index',
			);
			$sciezka[] = array(
				'kodModulu' => 'UprawnieniaZarzadzanie',
				'akcja' => 'podglad',
				'parametry' => array('id' => Zadanie::pobierz('id','intval','abs')),
			);
		}
		else if ($zadanie['kodModulu'] == 'WidokiZarzadzanie' && in_array($zadanie['akcja'], array('dodajBlok','edytujBlok')))
		{
			$sciezka[] = array(
				'kodModulu' => 'WidokiZarzadzanie',
				'akcja' => 'index',
			);
			if (isset(Cms::inst()->sesja->idWidoku) && Cms::inst()->sesja->idWidoku > 0)
			{
				$sciezka[] = array(
					'kodModulu' => 'WidokiZarzadzanie',
					'akcja' => 'edytuj',
					'parametry' => array('id' => Cms::inst()->sesja->idWidoku),
				);
			}
			else
			{
				$sciezka[] = array(
					'kodModulu' => 'WidokiZarzadzanie',
					'akcja' => 'bloki',
				);
			}
		}
		else if ($zadanie['idKategorii'] > 0)
		{
			$stronaStartowa = $this->kategorieMapper->pobierzStartowaAdmin();
			$sciezka[] = array(
				'idKategorii' => $stronaStartowa->id,
				'akcja' => 'index',
			);
			if ($zadanie['akcja'] != '' && $zadanie['akcja'] != 'index')
			{
				$sciezka[] = array(
					'idKategorii' => $zadanie['idKategorii'],
					'akcja' => 'index',
				);
			}
		}
		else if ($zadanie['idBloku'] > 0)
		{
			$sciezka[] = array(
				'kodModulu' => 'WidokiZarzadzanie',
				'akcja' => 'index',
			);
			if (isset(Cms::inst()->sesja->idWidoku) && Cms::inst()->sesja->idWidoku > 0)
			{
				$sciezka[] = array(
					'kodModulu' => 'WidokiZarzadzanie',
					'akcja' => 'edytuj',
					'parametry' => array('id' => Cms::inst()->sesja->idWidoku),
				);
			}
			else
			{
				$sciezka[] = array(
					'kodModulu' => 'WidokiZarzadzanie',
					'akcja' => 'bloki',
				);
			}
			if ($zadanie['akcja'] != '' && $zadanie['akcja'] != 'index')
			{
				$sciezka[] = array(
					'idBloku' => $zadanie['idBloku'],
					'akcja' => 'index',
				);
			}
		}
		else if($zadanie['idKategorii'] == '' && $zadanie['idBloku'] == '' && $zadanie['kodModulu'] == '' && $zadanie['akcja'] == '')
		{
			$sciezka[] = array(
				'idKategorii' => null,
				'idBloku' => null,
				'kodModulu' => null,
				'akcja' => null,
			);
		}

		return $sciezka;
	}



	private function _pobierzTlumaczenia($klasa, $kategoria, $blok)
	{
		if (!isset($this->tlumaczeniaModulow[$klasa]))
		{
			$modul = new $klasa;
			$modul->inicjuj($this->sterownik, $kategoria, $blok);
			$this->tlumaczeniaModulow[$klasa] = $modul->pobierzTlumaczeniaPelne();
		}
		return $this->tlumaczeniaModulow[$klasa];
	}



	private function wyswietlPozycje(Array $zadanie)
	{
		$link['obiekt'] = null;
		$link['tlumaczenia'] = null;

		if (isset($zadanie['url']) && $zadanie['url'] != '')
		{
			$link['url'] = $zadanie['url'];
			if (isset($zadanie['etykieta']) && $zadanie['etykieta'] != '')
			{
				$link['etykieta'] = $zadanie['etykieta'];
			}
			else
			{
				$link['etykieta'] = $zadanie['url'];
				trigger_error('Nie podano etykiety dla niestandardowego URL w ścieżce ('.$zadanie['url'].')', E_USER_NOTICE);
			}
		}
		elseif (isset($zadanie['idKategorii']) && $zadanie['idKategorii'] > 0)
		{
			$kategoria = $this->kategorieMapper->pobierzPoId($zadanie['idKategorii']);
			if ($kategoria instanceof Kategoria\Obiekt)
			{
				$link['obiekt'] = $kategoria;
				$link['tlumaczenia'] = $this->_pobierzTlumaczenia('Generic\\Modul\\'.$kategoria->kodModulu.'\\Admin', $kategoria, null);
			}
		}
		elseif (isset($zadanie['idBloku']) && $zadanie['idBloku'] > 0)
		{
			$blok = $this->blokiMapper->pobierzPoId($zadanie['idBloku']);
			if ($blok instanceof Blok\Obiekt)
			{
				$link['obiekt'] = $blok;
				$link['tlumaczenia'] = $this->_pobierzTlumaczenia('Generic\\Modul\\'.$blok->kodModulu.'\\Admin', null, $blok);
			}
		}
		elseif (isset($zadanie['kodModulu']) && $zadanie['kodModulu'] != '')
		{
			$modul = $this->modulyMapper->pobierzPoKodzie($zadanie['kodModulu']);
			if ($modul instanceof DostepnyModul\Obiekt)
			{
				$link['obiekt'] = $modul;
				$link['tlumaczenia'] = $this->_pobierzTlumaczenia('Generic\\Modul\\'.$modul->kod.'\\Admin', null, null);
			}
		}
		else
		{
			$link['obiekt'] = null;
			$link['tlumaczenia'] = null;
		}

		if (!is_null($link['obiekt']) && !is_null($link['tlumaczenia']))
		{
			$this->szablon->ustawBlok('index/link', array(
				'url' => htmlspecialchars(Router::urlAdmin($link['obiekt'], $zadanie['akcja'], isset($zadanie['parametry']) ? $zadanie['parametry'] : array())),
				'nazwa' => $link['tlumaczenia'][$zadanie['akcja'].'.tytul_strony'],
				'znak_rozdzielajacy' => $this->k->k['index.znak_rozdzielajacy'],
			));
		}
		else if (isset($link['url']) && !is_null($link['url']) && !is_null($link['etykieta']))
		{
			$this->szablon->ustawBlok('index/link', array(
				'url' => htmlspecialchars($link['url']),
				'nazwa' => $link['etykieta'],
				'znak_rozdzielajacy' => $this->k->k['index.znak_rozdzielajacy'],
			));
		}
	}
	
	
	public function wykonajZalogujLokalizacje()
	{
		if (czyMobilnyKlient())
		{
			$lat = Zadanie::pobierz('lat', 'floatval');
			$lng = Zadanie::pobierz('lng', 'floatval');
			$accuracy = Zadanie::pobierz('accuracy', 'intval');

			$user = Cms::inst()->profil()->login;
			$czas = date("Y-m-d H:i");
			$referer = Zadanie::adresWywolujacego();

			error_log($user.'@'.$czas.' Coords: ['.$lat.' '.$lng.'], Accuracy: '.$accuracy.' Ref: '.$referer."\n", 3, LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-location-grabber.log');

			$dane = array('success' => true, 'logged' => true);
			echo json_encode($dane);
			die;
		}
		else
		{
			echo json_encode(array(
				'success' => true,
				'logged' => false,
			));
			die;
		}
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
		return true;
	}

}
