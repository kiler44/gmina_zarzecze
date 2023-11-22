<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\WierszKonfiguracji;
use Generic\Biblioteka\Tlumaczenia;
use Generic\Biblioteka\Sterownik;
use Generic\Model\Kategoria;
use Generic\Model\Blok;
use Generic\Biblioteka\Zdarzenia;
use Generic\Biblioteka\ModulWyjatek;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Szablon;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Router;


/**
 * Klasa abstrakcyjna (interfejs do budowy modulow) dla klas poszczegolnych modulow.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Modul implements Konfiguracja\Interfejs, Tlumaczenia\Interfejs
{

	/**
	 * Domyslna akcja dla wszystkich modulow.
	 *
	 * @var string
	 */
	protected $domyslnaAkcja = 'index';


	/**
	 * Akcja wykonywana w bierzacym wywolaniu.
	 *
	 * @var string
	 */
	protected $wykonywanaAkcja;


	/**
	 * Sterownik odpowiedzialny za wybieranie i zarzadzanie akcjami.
	 *
	 * @var Sterownik
	 */
	protected $sterownik;


	/**
	 * Obiekt obslugiwanej kategorii.
	 *
	 * @var Kategoria
	 */
	protected $kategoria;


	/**
	 * Obiekt bloku jezeli wystepuje.
	 *
	 * @var Blok
	 */
	protected $blok;


	/**
	 * Szablon modulu.
	 *
	 * @var Szablon
	 */
	protected $szablon;


	/**
	 * Tresc zwracana przez modul.
	 *
	 * @var string
	 */
	protected $tresc;


	/**
	 * Komunikaty zwracane przez modul.
	 *
	 * @var array
	 */
	protected $komunikaty = array();


	/*
	 * Zmienna przechowuje uprawnienia
	 *
	 * @var array
	 */
	protected $uprawnienia = array('wykonajIndex');



	private $daneOstatniegoZdarzenia;



	protected $zdarzenia;



	private $obserwatorzy = array();


	/**
	 * @var \Generic\Tlumaczenie\Tlumaczenie
	 */
	protected $j;


	/**
	 * @var \Generic\Konfiguracja\Konfiguracja
	 */
	protected $k;


	public function __construct()
	{
		$kod = explode('_', $this->pobierzNazweModulu());

		$namespaceJezykaDomyslnego = '\\Generic\\Tlumaczenie\\Pl\\Modul\\' . $kod[0] . '\\' . $kod[1];
		
		$namespaceJezyka = '\\Generic\\Tlumaczenie\\'.ucfirst(KOD_JEZYKA_ITERFEJSU).'\\Modul\\' . $kod[0] . '\\' . $kod[1];
		if (class_exists($namespaceJezyka, true))
		{
			$this->j = new $namespaceJezyka;
		}
		else
		{
			$this->j = new $namespaceJezykaDomyslnego;
			trigger_error('Brak tłumaczeń dla języka: '. ucfirst(KOD_JEZYKA_ITERFEJSU) .' dla modułu: '. get_class($this) .', Wczytano tumaczenia języka domyślnego', E_USER_WARNING);
		}

		$namespaceKonfiguracji = '\\Generic\\Konfiguracja\\Modul\\' . $kod[0] . '\\' . $kod[1];
		$this->k = new $namespaceKonfiguracji;
	}



	/**
	 * Ustawia parametry startowe dla modulu.
	 *
	 * @param Sterownik $sterownik Sterownik odpowiedzialny za wybieranie i zarzadzanie akcjami.
	 * @param Kategoria $kategoria Kategoria dla ktorej wywolywany jest modul.
	 * @param Blok $blok Obslugiwany blok jezeli ustawiono.
	 */
	public function inicjuj(Sterownik $sterownik, Kategoria\Obiekt $kategoria = null, Blok\Obiekt $blok = null)
	{
		if(isset(Cms::inst()->sesja) && Cms::inst()->sesja->linkBlokady != null)
		{
			if(isset($_SERVER['SCRIPT_URI']) && isset($_SERVER['QUERY_STRING']) && $_SERVER['SCRIPT_URI'].'?'.$_SERVER['QUERY_STRING'] != Cms::inst()->sesja->linkBlokady && !Zadanie::czyAjax() && !Zadanie::czyApi())
			{
				Router::przekierujDo(Cms::inst()->sesja->linkBlokady);
			}
		}
		
		
		$this->sterownik = $sterownik;
		$this->kategoria = $kategoria;
		$this->blok = $blok;

		$this->ladujKonfiguracje();
		$this->ladujTlumaczenia();
		$this->ladujSzablon();
		$this->ladujKomunikaty();
	}

	/**
	 * 
	 * @param type $usluga - Admin lub Http
	 * @param type $kategoria - Id kategorii modulu
	 * @param type $akcja - akcja modułu
	 * @param type $parametry - tablica z parametrami
	 */
	protected function ustawLinkBlokady($usluga, $kategoria, $akcja, $parametry)
	{
		if($usluga == 'Admin')
			$link = Router::urlAdmin($kategoria, $akcja, $parametry);
		else if($usluga == 'Http')
			$link = Router::urlHttp($kategoria, $akcja, $parametry);
		else
			$link = null;

		Cms::inst()->sesja->linkBlokady = $link;
	}
	
	protected function usunLinkBlokady()
	{
		Cms::inst()->sesja->linkBlokady = null;
	}


	public function pobierzZdarzenia()
	{
		return ( ! empty($this->zdarzenia) ) ? $this->zdarzenia : array();
	}



	final protected function zdarzenie($kodZdarzenia, $dodatkowe_dane = array(), $tokenProcesu = '')
	{
		$kod = null;
		$klasa = null;
		
		foreach ($this->zdarzenia as $kod => $klasa)
		{
			if ((string)$kod == (string)$kodZdarzenia) break;

			if ((string)$klasa == (string)$kodZdarzenia)
			{
				$kod = $klasa;
				$klasa = 'Generic\\Biblioteka\\Zdarzenia\\Zdarzenie';
				break;
			}
		}
		if ($klasa == '')
		{
			trigger_error('Nieznane zdarzenie', E_USER_WARNING);
			return;
		}
		
		$zdarzenie = new $klasa;

		list($kodModulu, $usluga) = explode('_', $this->pobierzNazweModulu());
		if ($this->kategoria instanceof Kategoria\Obiekt)
			$pelnyKodZdarzenia = $usluga.'_'.$kodModulu.'_'.$this->kategoria->id.'_'.$kodZdarzenia;
		else
			$pelnyKodZdarzenia = $kodModulu.'_'.$kodZdarzenia;

		$zdarzenie->ustawKod($pelnyKodZdarzenia);

		$dodatkowe_dane['zdarzenie'] = $kodZdarzenia;
		$zdarzenie->ustawDane($dodatkowe_dane);

		$zdarzenie->ustawZrodlo($this);
		$zdarzenie->ustawTokenProcesu($tokenProcesu);

		$menedzer = new Zdarzenia\Menedzer();
		$menedzer->przechwycZdarzenie($zdarzenie);
	}



	/**
	 * Zwraca uprawnienia
	 *
	 * @return array
	 */
	public function pobierzUprawnienia()
	{
		foreach ($this->uprawnienia as $wartosc)
		{
			if ($wartosc == 'wykonajAkcje')
				throw new ModulWyjatek('Nazwa uprawnienia "wykonajAkcje" jest zarezerwowana.', E_USER_ERROR);
			if (preg_match("/[^a-zA-Z0-9]/", $wartosc))
				throw new ModulWyjatek('Nazwa uprawnienia moze zawierac tylko litery i cyfry.', E_USER_ERROR);
		}
		return $this->uprawnienia;
	}



	/**
	 * Zwraca nazwe modulu.
	 *
	 * @return string
	 */
	public function pobierzNazweModulu()
	{
		return str_replace(array('Generic\\Modul\\', '\\'), array('', '_'), get_class($this));
	}



	/**
	 * Szuka i zwraca wartosc parametru z nastepujacych zrodel: Zadanie Http, Sesja(gdy zaznaczone), Wartosc domyslna(gdy ustawiona).
	 *
	 * @param string $nazwa Nazwa parametru.
	 * @param mixed $wartoscDomyslna Domyslna wartosc parametru.
	 * @param boolean $uzyjSesji Czy uzywac sesji do zapamietywania i odtwarzania parametru.
	 * @param array $filtry filtry do zastosowania podczas pobierania parametru.
	 *
	 * @return mixed
	 */
	protected function pobierzParametr($nazwa, $wartoscDomyslna = null, $uzyjSesji = false, Array $filtry = array())
	{
		$wartosc = null;
		$parametry = array($nazwa);
		if (count($filtry) > 0)
		{
			foreach ($filtry as $filtr)
			{
				array_push($parametry, $filtr);
			}
		}
		switch(count($parametry))
		{
			case 1: $wartosc = Zadanie::pobierz($parametry[0]); break;
			case 2: $wartosc = Zadanie::pobierz($parametry[0],$parametry[1]); break;
			case 3: $wartosc = Zadanie::pobierz($parametry[0],$parametry[1],$parametry[2]); break;
			case 4: $wartosc = Zadanie::pobierz($parametry[0],$parametry[1],$parametry[2],$parametry[3]); break;
			case 5: $wartosc = Zadanie::pobierz($parametry[0],$parametry[1],$parametry[2],$parametry[3],$parametry[4]); break;
			case 6: $wartosc = Zadanie::pobierz($parametry[0],$parametry[1],$parametry[2],$parametry[3],$parametry[4],$parametry[5]); break;
			case 7: $wartosc = Zadanie::pobierz($parametry[0],$parametry[1],$parametry[2],$parametry[3],$parametry[4],$parametry[5],$parametry[6]); break;
			case 8: $wartosc = Zadanie::pobierz($parametry[0],$parametry[1],$parametry[2],$parametry[3],$parametry[4],$parametry[5],$parametry[6],$parametry[7]); break;
			case 9: $wartosc = Zadanie::pobierz($parametry[0],$parametry[1],$parametry[2],$parametry[3],$parametry[4],$parametry[5],$parametry[6],$parametry[7],$parametry[8]); break;
			default: throw new ModulWyjatek('Zbyt duzo parametrow. popraw metode "pobierzParametr"', E_USER_ERROR); break;
		}

		$wartosc = $this->parametrWSesji($nazwa, $wartosc, (bool)$uzyjSesji);

		if (empty($wartosc) && $wartoscDomyslna !== null)
		{
			return $wartoscDomyslna;
		}
		return $wartosc;
	}



	/**
	 * Szuka i zwraca wartosc parametru z Sesji
	 *
	 * @param string $nazwa Nazwa parametru.
	 * @param mixed $wartosc Wartosc parametru.
	 * @param boolean $uzyjSesji Czy uzywac sesji do zapamietywania i odtwarzania parametru.
	 *
	 * @return mixed
	 */
	protected function parametrWSesji($nazwa, $wartosc = null, $uzyjSesji = false)
	{
		if ($uzyjSesji)
		{
			$sesja = Cms::inst()->sesja;
			$modul = get_class($this);
			$kategoria = (empty($this->kategoria->id)) ? 0 : $this->kategoria->id;
			$blok = (empty($this->blok->id)) ? 0 : $this->blok->id;
			$akcja = $this->wykonywanaAkcja;
		}
		if ($wartosc !== null && $uzyjSesji)
		{
			$sesja->moduly[$modul][$kategoria][$blok][$akcja]['parametry'][$nazwa] = $wartosc;
			return $wartosc;
		}
		if ($wartosc === null && $uzyjSesji && isset($sesja->moduly[$modul][$kategoria][$blok][$akcja]['parametry'][$nazwa]))
		{
			$wartosc = $sesja->moduly[$modul][$kategoria][$blok][$akcja]['parametry'][$nazwa];
		}
		return $wartosc;
	}



	/**
	 * Szuka i czysci wartosc parametru danych modulu w sesji.
	 *
	 * @param string $nazwa Nazwa parametru.
	 */
	protected function czyscParametr($nazwa)
	{
		$sesja = Cms::inst()->sesja;
		$modul = get_class($this);
		$kategoria = (empty($this->kategoria->id)) ? 0 : $this->kategoria->id;
		$blok = (empty($this->blok->id)) ? 0 : $this->blok->id;
		$akcja = $this->wykonywanaAkcja;

		if (isset($sesja->moduly[$modul][$kategoria][$blok][$akcja]['parametry'][$nazwa]))
		{
			unset($sesja->moduly[$modul][$kategoria][$blok][$akcja]['parametry'][$nazwa]);
		}
	}



	/**
	 * Laduje szablon dla modulu.
	 */
	public function ladujSzablon()
	{
		$plikSzablonu = SZABLON_KATALOG.'/'.SZABLON_KOMUNIKATU;
		$szablonKomunikatu = Plik::pobierzTrescPliku($plikSzablonu);
		if ($szablonKomunikatu == '')
		{
			trigger_error('Nie mozna znalezc pliku szablonu komunikatu'.$plikSzablonu, E_USER_WARNING);
			$szablonKomunikatu = Plik::pobierzTrescPliku(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.SZABLON_KOMUNIKATU);
		}
		$plikSzablonu = SZABLON_KATALOG.'/moduly/'.str_replace('_', '/', $this->pobierzNazweModulu()).'.tpl';
		$szablon = Plik::pobierzTrescPliku($plikSzablonu);
		if ($szablon == '')
		{
			trigger_error('Nie mozna znalezc pliku szablonu '.$plikSzablonu, E_USER_WARNING);
			$szablon = Plik::pobierzTrescPliku(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.SZABLON_MODUL);
		}

		$this->szablon = new Szablon();
		$this->szablon->ladujTresc($szablonKomunikatu.$szablon);
	}



	/**
	 * Laduje szablon zewnetrzny dla elementow takich jak grid, formularz, pager, itd.
	 *
	 * @param string $sciezkaSzablonu Sciezka do pliku szablonu (domyślnie częściowa)
	 * @param bool $pelnaSciezka Parametr określający czy podano pelna(bezwzględną) sciezke do pliku szablonu
	 */
	public function ladujSzablonZewnetrzny($sciezkaSzablonu, $pelnaSciezka = false)
	{
		if (empty($sciezkaSzablonu))
		{
			trigger_error('Nie podano sciezki do pliku szablonu', E_USER_WARNING);
		}
		$cms = Cms::inst();

		if ($pelnaSciezka)
			$plikSzablonu = $sciezkaSzablonu;
		else
			$plikSzablonu = SZABLON_KATALOG.'/'.ltrim($sciezkaSzablonu, '/');

		return Plik::pobierzTrescPliku($plikSzablonu);
	}



	/**
	 * Zwraca tresc wygenerowana podczas wykonywania sie modulu.
	 *
	 * @param boolean $czysc Czy wyczyscic tresc wygenerowana do tej pory w module.
	 *
	 * @return string
	 */
	public function pobierzTresc($czysc = false)
	{
		$bufor = '';
		if (count($this->komunikaty) > 0)
		{
			if ($this->szablon->zawieraBlok('komunikat'))
			{
				foreach ($this->komunikaty as $komunikat)
				{
					$bufor .= $this->szablon->parsujBlok('komunikat', $komunikat);
				}
			}
			else
			{
				throw new ModulWyjatek('Nie mozna wyswietlic komunikatow w module '.$this->pobierzNazweModulu(), E_USER_ERROR);
			}
		}
		// Komunikaty z sesji czyszczone dopiero tutaj żeby nie znikały podczas redirect-a
		$cms = Cms::inst();
		$modul = get_class($this);
		$kategoria = ($this->kategoria instanceof Kategoria\Obiekt && $this->kategoria->id > 0) ? $this->kategoria->id : 0;
		$blok = ($this->blok instanceof Blok\Obiekt && $this->blok->id > 0) ? $this->blok->id : 0;
		if (isset($cms->sesja->komunikaty) && !($this->blok instanceof Blok\Obiekt))
		{
			$cms->sesja->komunikaty = array();
		}
		if (isset($cms->sesja->moduly[$modul][$kategoria][$blok]['komunikaty']))
		{
			$cms->sesja->moduly[$modul][$kategoria][$blok]['komunikaty'] = array();
		}

		$bufor .= $this->tresc;
		if ($czysc)
		{
			$this->tresc = null;
			$this->komunikaty = array();
		}
		return $bufor;
	}



	/**
	 * Wywoluje akcje podana jako parametr. W przypadku braku wywoluje akcje domyslna.
	 *
	 * @param string $wybranaAkcja Nazwa akcji do wykonania.
	 */
	public function wykonajAkcje($wybranaAkcja = null)
	{
		/**
		 * Ustawianie kontenera, szablonu i ukladu strony dla konkretnej akcji
		 */
		if ( ! empty($wybranaAkcja) && $this->kategoria instanceof Kategoria\Obiekt)
		{
			//Ustawienie ukladu strony
			$this->sterownik->ustawIdWidoku($this->kategoria->pobierzIdWidokuDlaAkcji($wybranaAkcja));
			//Ustawienie kontenera
			$this->sterownik->ustawKontener($this->kategoria->pobierzKontenerDlaAkcji($wybranaAkcja));
			//Ustawienie klasy css
			$this->sterownik->ustawKlase($this->kategoria->pobierzKlaseDlaAkcji($wybranaAkcja));
			//Ustawienie szablonu
			$szablon = $this->kategoria->pobierzSzablonDlaAkcji($wybranaAkcja);
			if ( ! empty($szablon))
				$this->ladujSzablon($szablon);
		}

		if (empty($wybranaAkcja))
		{
			$wybranaAkcja = $this->domyslnaAkcja;
		}

		$metoda = "wykonaj".ucfirst($wybranaAkcja);
		if (method_exists($this, $metoda))
		{
			if ($this->moznaWykonacAkcje($metoda))
			{
				$this->wstawDoSzablonuBlokTlumaczen($wybranaAkcja);

				$this->wykonywanaAkcja = $wybranaAkcja;

				if ($this->blok instanceof Blok\Obiekt)
				{
					// Jeżeli w konfiguracji bloku występuje tablica określająca
					// dla jakich akcji danej kategorii (podstrony) blok ma się wyświetlać
					// to wykorzystujemy sprawdzanie
					if (isset($this->k->k['wyswietlaj_dla_akcji_modulu'])
						&& is_array($this->k->k['wyswietlaj_dla_akcji_modulu'])
						&& count($this->k->k['wyswietlaj_dla_akcji_modulu']) > 0)
					{
						if (in_array(Cms::inst()->temp('WYKONYWANA_AKCJA_MODULU'), $this->k->k['wyswietlaj_dla_akcji_modulu']))
						{
							$this->$metoda();
						}
					}
					else
					{
						$this->$metoda();
					}
				}
				else
				{
					Cms::inst()->temp('WYKONYWANA_AKCJA_MODULU', $this->pobierzNazweModulu().'_'.$wybranaAkcja);
					$this->$metoda();
				}
			}
			else
			{
				$this->komunikat(Cms::inst()->lang['ogolne']['modul_brak_uprawnien_do_akcji'], 'warning');
			}
		}
		else
		{
			throw new ModulWyjatek('Nie znaleziono akcji "'.$wybranaAkcja.'" w module '.$this->pobierzNazweModulu(), E_USER_ERROR);
		}
	}



	/**
	 * Ustawia nastepna akcje do wywolania.
	 *
	 * @param Blok $blok Obslugiwany blok jezeli ustawiono.
	 * @param Kategoria $kategoria Wywolywana kategoria.
	 * @param string $nazwaModulu Nazwa wywolywanego modulu (tekst albo null).
	 * @param string $akcja Nazwa wywolywanej akcji (tekst albo null).
	 */
	public function nastepnaAkcja(Blok\Obiekt $blok = null, Kategoria\Obiekt $kategoria = null, $nazwaModulu = null, $akcja = null)
	{
		$this->sterownik->nastepnaAkcja($blok, $kategoria, $nazwaModulu, $akcja);
	}



	/**
	 * Wstawia blok tlumaczen do szablonu.
	 *
	 * @param string $nazwaBloku Nazwa bloku.
	 */
	protected function wstawDoSzablonuBlokTlumaczen($nazwaBloku)
	{
		$tlumaczenia = array();
		$nazwaBloku = $nazwaBloku.'.';
		foreach ($this->j->t as $kod => $tresc)
		{
			if (strpos($kod, $nazwaBloku) !== false)
			{
				$klucz = str_replace($nazwaBloku, '', $kod);
				$tlumaczenia[$klucz] = $tresc;
			}
		}
		$this->szablon->ustawGlobalne($tlumaczenia);
	}



	/**
	 * Zwraca blok tlumaczen rozbijajac je na segmenty.
	 *
	 * @param string $nazwaBloku Nazwa bloku.
	 *
	 * @return array
	 */
	protected function pobierzBlokTlumaczen(string $nazwaBloku) : Array
	{
		$tlumaczenia = array();
		$nazwaBloku = $nazwaBloku.'.';
		foreach ($this->j->t as $k => $v)
		{
			if (strpos($k, $nazwaBloku) === 0)
			{
				$k = str_replace($nazwaBloku, '', $k);

				// nowa wersja budowania tablicy
				$k = array_reverse(explode('.', $k));
				$arr = array(array_shift($k) => $v);
				while ($subk = array_shift($k))
				{
					$arr = array($subk => $arr);
				}
				$tlumaczenia = array_merge_recursive($tlumaczenia, $arr);
				}
		}
		return $tlumaczenia;
	}



	/**
	 * Sprawdza czy metoda może byc wykonywana.
	 *
	 * @param string $metoda Nazwa wywolywanej akcji (tekst albo null).
	 * @param boolean $wlasnyKod Czy podajemy własny kod uprawnienia
	 * @param \Generic\Biblioteka\ObiektDanych $obiektKontekstu jesli podany, sprawdzone zostaną również uprawnienia kontekstowe dla obiektu
	 *
	 * @return boolean
	 */
	protected function moznaWykonacAkcje($metoda, $wlasnyKod = false, $obiektKontekstu = null)
	{
		if ($obiektKontekstu != null)
		{
			if (! $obiektKontekstu instanceof ObiektDanych)
			{
				trigger_error('Podano nie prawidłowy obiektKontekstu', E_USER_ERROR);
			}
		}

		$kod = explode('_', $this->pobierzNazweModulu());
		$usluga = $kod[1];
		$kodModulu = $kod[0];
		$kod = null;

		// Okreslamy w jakich sytuacjach maja byc sprawdzane uprawnienia
		if ($wlasnyKod == true)
		{
			$kod = $metoda;
		}
		// dla blokow sprawdzamy tylko jezeliw usludze Admin
		elseif ($this->blok instanceof Blok\Obiekt && $usluga == 'Admin')
		{
			$kod = 'Bloki_'.$this->blok->kodModulu.'_'.$this->blok->id.'_'.$metoda;
		}
		// dla kategorii sprawdzamy jezeli usluga Admin to wszystkie, lub jezeli usluga Http to tylko dla zalogowanych
		elseif ($this->kategoria instanceof Kategoria\Obiekt && !($this->blok instanceof Blok\Obiekt) &&
		($usluga == 'Admin' || ($usluga == 'Http' && $this->kategoria->dlaZalogowanych == 1)))
		{
			$kod = $this->sterownik->nazwaUslugi().'_'.$this->kategoria->id.'_'.$metoda;
		}
		// dla modulow administracyjnych sprawdzmy wszystko
		else if (!($this->kategoria instanceof Kategoria\Obiekt) && !($this->blok instanceof Blok\Obiekt))
		{
			$kod = $kodModulu.'_'.$metoda;
		}

		$uzytkownik = Cms::inst()->profil();

		if (trim($kod) != '')
		{
			return ($uzytkownik instanceof Uzytkownik\Obiekt) ? $uzytkownik->maUprawnieniaDo((string)$kod, $obiektKontekstu) : false;
		}
		else
		{
			return true;
		}
	}



	/**
	 * Inicjuje komunikaty dla modulu.
	 */
	public function ladujKomunikaty()
	{
		$cms = Cms::inst();
		$modul = get_class($this);
		$kategoria = ($this->kategoria instanceof Kategoria\Obiekt && $this->kategoria->id > 0) ? $this->kategoria->id : 0;
		$blok = ($this->blok instanceof Blok\Obiekt && $this->blok->id > 0) ? $this->blok->id : 0;
		if (isset($cms->sesja->komunikaty) && !($this->blok instanceof Blok\Obiekt))
		{
			$this->komunikaty = array_merge($this->komunikaty, $cms->sesja->komunikaty);
			//$cms->sesja->komunikaty = array(); // Teraz komunikaty z sesji sa czyszczone dopiero po wyswietleniu tresci
		}
		if (isset($cms->sesja->moduly[$modul][$kategoria][$blok]['komunikaty']))
		{
			$this->komunikaty = array_merge($this->komunikaty,$cms->sesja->moduly[$modul][$kategoria][$blok]['komunikaty']);
			//$cms->sesja->moduly[$modul][$kategoria][$blok]['komunikaty'] = array(); // Teraz komunikaty z sesji sa czyszczone dopiero po wyswietleniu tresci
		}
	}



	/**
	 * Ustawia komunikat do wyswietlenia.
	 *
	 * @param string $tresc Tresc komunikatu.
	 * @param string $typ Typ komunikatu ('info', 'warning', 'error').
	 * @param string $zasieg Zasieg komunikatu ('modul', 'sesja', 'sysem').
	 * Rodzaje zasiegu:
	 * - "modul" komunikat bedzie wyswietlony w bierzacym wywolaniu modulu,
	 * - "sesja" komunikat zapamietany w sesji i bedzie wyswietlony w bierzacym module,
	 * - "system" komunikat zapamietany w sesji i bedzie wyswietlony w nastepnym wywolaniu dowolnym module
	 * @param string $klas dodatkowa klasa komunikatu.
	 *
	 */
	protected function komunikat($tresc, $typ = 'info', $zasieg = 'modul', $klasa = '')
	{
		$typ = strtolower($typ);

		if ($tresc != '' && in_array($typ, array('info', 'warning', 'error', 'success')))
		{
			if ($zasieg == 'system')
			{
				$sesja = Cms::inst()->sesja;
				if (!isset($sesja->komunikaty))
				{
					$sesja->komunikaty = array();
				}
				$sesja->komunikaty[] = array('tresc' => $tresc, 'typ' => $typ, 'klasa' => $klasa);
			}
			elseif ($zasieg == 'sesja')
			{
				$sesja = Cms::inst()->sesja;
				$modul = get_class($this);
				$kategoria = ($this->kategoria instanceof Kategoria\Obiekt && $this->kategoria->id > 0) ? $this->kategoria->id : 0;
				$blok = ($this->blok instanceof Blok\Obiekt && $this->blok->id > 0) ? $this->blok->id : 0;
				if (!isset($sesja->moduly[$modul][$kategoria][$blok]['komunikaty']))
				{
					$sesja->moduly[$modul][$kategoria][$blok]['komunikaty'] = array();
				}
				$sesja->moduly[$modul][$kategoria][$blok]['komunikaty'][] = array('tresc' => $tresc, 'typ' => $typ, 'klasa' => $klasa);
			}
			else
			{
				$this->komunikaty[] = array('tresc' => $tresc, 'typ' => $typ, 'klasa' => $klasa);
			}
		}
		else
		{
			trigger_error('Podano nieprawidlowe parametry komunikatu w module '.$this->pobierzNazweModulu(), E_USER_WARNING);
		}
	}



	/**
	 * Zwraca tresc html komunikatów i czyści tabele przechowujące dane komunikatów
	 *
	 * @return string
	 */
	public function komunikatyHtml()
	{
		$html = '';
		$sesja = Cms::inst()->sesja;

		if (isset($sesja->komunikaty))
		{
			foreach($sesja->komunikaty as $komunikat)
			{
				$html .= $this->szablon->parsujBlok('komunikat', array('tresc' => $komunikat['tresc'], 'typ' => $komunikat['typ']));
			}
		}

		if (isset($this->komunikaty))
		{
			foreach($this->komunikaty as $komunikat)
			{
				$html .= $this->szablon->parsujBlok('komunikat', array('tresc' => $komunikat['tresc'], 'typ' => $komunikat['typ']));
			}
		}

		$sesja->komunikaty = array();
		$this->komunikaty = array();

		return $html;
	}



	/**
	 * Ustawia dane obowiazujace dla calej strony.
	 *
	 * @param array $dane Tablica z danymi globalnymi w formacie array('nazwa' => 'wartosc').
	 */
	public function ustawGlobalne(Array $dane)
	{
		$this->szablon->ustawGlobalne($dane);
		$this->sterownik->ustawGlobalne($dane);
	}



	/**
	 * Domyslana akcja dla wszystkich modulow.
	 * Powinna byc zaimplementowana w kazdej klasie modulu.
	 */
	public function wykonajIndex()
	{
		throw new \Exception('Brak deklaracji metody w module '.get_class($this));
	}



	/**
	 * Ustawia konfiguracje startowa dla modulu.
	 */
	public function ladujKonfiguracje()
	{
		$mapper = $this->dane()->WierszKonfiguracji();
		$konfiguracja = array();
		if ($this->blok instanceof Blok\Obiekt)
		{
			$konfiguracja = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), null, $this->blok->id, KOD_JEZYKA_ITERFEJSU);
		}
		elseif ($this->kategoria instanceof Kategoria\Obiekt)
		{
			$konfiguracja = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), $this->kategoria->id, null, KOD_JEZYKA_ITERFEJSU);
		}
		$this->ustawKonfiguracje($mapper->przetworzNaListe($konfiguracja));
	}



	/**
	 * Zwraca id kategorii.
	 *
	 * @return int
	 */
	public function pobierzIdKategorii()
	{
		return ($this->kategoria instanceof Kategoria\Obiekt) ? $this->kategoria->id : 0;
	}



	/**
	 * Implementacja interfejsu Konfiguracja_Interfejs
	 */

	/**
	 * Zwraca tablice z konfiguracja dla modulu.
	 *
	 * @return array
	 */
	public function pobierzKonfiguracje()
	{
		return $this->k->pobierzKonfiguracje();
	}



	/**
	 * Ustawia nowa konfiguracje dla modulu.
	 *
	 * @param array $konfiguracja Tablica z konfiguracja dla modulu.
	 *
	 * @return boolean
	 */
	public function ustawKonfiguracje($konfiguracja)
	{
		$this->k->ustawKonfiguracje($konfiguracja);
	}



	/**
	 * Zwraca tablice z opisem konfiguracji dla modulu.
	 *
	 * @return array
	 */
	public function pobierzOpisKonfiguracji()
	{
		return $this->k->pobierzOpisKonfiguracji();
	}



	/**
	 * Ustawia tlumaczenia startowe dla modulu.
	 */
	public function ladujTlumaczenia()
	{
		$mapper = $this->dane()->WierszTlumaczen();
		$tlumaczenia = array();
		if ($this->blok instanceof Blok\Obiekt)
		{
			$tlumaczenia = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), null, $this->blok->id, KOD_JEZYKA_ITERFEJSU);
		}
		elseif($this->kategoria instanceof Kategoria\Obiekt)
		{
			$tlumaczenia = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), $this->kategoria->id, null, KOD_JEZYKA_ITERFEJSU);
		}

		$this->ustawTlumaczenia($mapper->przetworzNaListe($tlumaczenia));
		$this->j->ustawTlumaczenia($mapper->przetworzNaListe($tlumaczenia));
	}



	/**
	 * Zwraca url powrotny.
	 *
	 * @param string $zasieg Okresla czy pobrac ogolny url czy ustawiony pod unikalnym kluczem
	 * @param bool $czysc Okresla, czy usunac z sesji pobierany URL
	 *
	 * @return string
	 */
	function pobierzUrlPowrotny($zasieg = 'system', $czysc = false)
	{
		$urlPowrotny = Cms::inst()->sesja->urlPowrotny;
		$urlPowrotny = (is_array($urlPowrotny)) ? $urlPowrotny : array();

		if (isset($urlPowrotny[$zasieg]) && $urlPowrotny[$zasieg] != '')
		{
			if ($czysc)
			{
				Cms::inst()->sesja->urlPowrotny[$zasieg] = '';
			}
			return $urlPowrotny[$zasieg];
		}
		else
		{
			return Zadanie::wywolanyUrl();
		}
	}



	/**
	 * Ustawia url powrotny na bieżące zadanie.
	 *
	 * @param string $url Wlasnorecznie ustawiony url
	 * @param string $zasieg Okresla czy ustawic url jako ogolny czy ustawiony pod unikalnym kluczem
	 */
	function ustawUrlPowrotny($url = null, $zasieg = 'system')
	{
		Cms::inst()->sesja->urlPowrotny[$zasieg] = (empty($url)) ? Zadanie::wywolanyUrl() : $url;
	}



	/**
	 * Tworzy url dla modulu/kategorii i podanej akcji
	 *
	 * @param Kategoria|string $modul Nazwa modulu do ktorego sie odwolujemy
	 * @param string $akcja Akcja modulu do ktorej sie odwolujemy
	 * @param array $parametry Dodatkowe parametry w adresie url
	 *
	 * @return bool|string
	 */
	public function urlHttp($kategoria, $akcja, Array $parametry = array())
	{
		
		return Router\Http::inst()->url($kategoria, $akcja, $parametry);
	}



	/**
	 * Implementacja interfejsu Tlumaczenia_Interfejs
	 */

	/**
	 * Zwraca tablice z tlumaczeniami dla modulu.
	 *
	 * @return array
	 */
	public function pobierzTlumaczenia()
	{
		return $this->j->pobierzTlumaczenia();
	}



	/**
	 * Ustawia nowe tlumaczeniami dla modulu.
	 *
	 * @param array $tlumaczenia Tablica z tlumaczeniami dla modulu.
	 */
	public function ustawTlumaczenia($tlumaczenia = array())
	{
		$this->j->t = array_merge($this->j->pobierzTlumaczenia(), $tlumaczenia);
	}



	/**
	 * Zwraca tablice z pelnymi tlumaczeniami dla modulu.
	 *
	 * @return array
	 */
	public function pobierzTlumaczeniaPelne()
	{
		return $this->j->t;
	}



	/**
	 * Zwraca tablice z pelna konfiguracja dla modulu.
	 *
	 * @return array
	 */
	public function pobierzKonfiguracjePelna()
	{
		return $this->k->k;
	}



	/**
	 * Zwraca tablice z akcjami dostepnymi w module
	 * Metoda pobiera wszystkie akcje zadeklarowane w module w polu 'akcje' oraz wszystkie metody 'wykonaj' wystepujace w danym module
	 *
	 * @return array
	 */
	public function pobierzAkcje()
	{
		foreach(get_class_methods($this) as $metoda)
		{
			if (strpos($metoda, 'wykonaj') === 0 && $metoda !== 'wykonajAkcje')
				$akcje[] = lcfirst(str_replace('wykonaj', '', $metoda));
		}

		$this->akcje = (isset($this->akcje) && is_array($this->akcje)) ? $this->akcje : array();

		return array_merge($this->akcje, $akcje);
	}



	/**
	 * Zwraca instancje kontenera przechowującego mappery
	 *
	 * @return \Generic\Biblioteka\Kontener\Mappery
	 */

	public function dane()
	{
		return Cms::inst()->dane();
	}

}

class ModulWyjatek extends \Exception {}
