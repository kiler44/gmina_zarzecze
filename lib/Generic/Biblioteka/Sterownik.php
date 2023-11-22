<?php
namespace Generic\Biblioteka;
use Generic\Model\Kategoria;
use Generic\Model\Blok;
use Generic\Biblioteka;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\SterownikWyjatek;


/**
 * Klasa abstrakcyjna (interfejs do budowy modulow) dla klas poszczegolnych modulow.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class SterownikWyjatek extends \Exception {}

class Sterownik
{

	/**
	 * Nazwa uslugi dla jakiej pracuje sterownik.
	 *
	 * @var string
	 */
	private $nazwaUslugi;

    /**
     * Klasa css jaka jest dodawana do glownego kontenera strony
     *
     * @var int
     */
    private $klasa = null;



    /**
	 * Rodzaj kontenera w jakiej ma wyswietlic sie strona
	 *
	 * @var string
	 */
	private $kontener = null;


	/**
	 * Identyfikator ukladu strony w jakim ma wyswietlic sie strona
	 *
	 * @var int
	 */
	private $idWidoku = null;


	/**
	 * Akcja ktora bedzie wykonywana w kolejnym wywolaniu.
	 *
	 * @var array
	 */
	private $nastepnaAkcja = array(
		'blok' => null,
		'kategoria' => null,
		'modul' => null,
		'akcja' => null,
	);


	/**
	 * Akcja wykonywana w bierzacym wywolaniu.
	 *
	 * @var array
	 */
	protected $wykonywanaAkcja = array(
		'blok' => null,
		'kategoria' => null,
		'modul' => null,
		'akcja' => null,
	);


	/**
	 * Moduly zaladowane do tej pory przez sterownik.
	 *
	 * @var array
	 */
	protected $zaladowaneModuly = array();


	/**
	 * Tresc zwracana przez moduly.
	 *
	 * @var array
	 */
	protected $zwracanaTresc = array();


	/**
	 * Zmienne globalne dla szablonow.
	 *
	 * @var array
	 */
	protected $zmienneGlobalne = array();




	/**
	 * Ustawia nazwe uslugi dla jakiej pracuje sterownik
	 *
	 * @param string $nazwaUslugi Nazwa uslugi dla jakiej ustawiamy sterownik. Potrzebna do konstruowania nazw klas.
	 */
	public function __construct($nazwaUslugi)
	{
		$this->nazwaUslugi = $nazwaUslugi;
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
		if ($blok instanceof Blok\Obiekt)
		{
			$modul = $this->pobierzModul($blok->kodModulu);
		}
		elseif ($kategoria instanceof Kategoria\Obiekt)
		{
			$modul = $this->pobierzModul($kategoria->kodModulu);
		}
		elseif((string)$nazwaModulu != '')
		{
			$modul = $this->pobierzModul($nazwaModulu);
		}
		else
		{
			throw new SterownikWyjatek('Brak danych potrzebnych do ustalenia modulu', E_USER_ERROR);
		}
		$this->nastepnaAkcja = array(
			'blok' => $blok,
			'kategoria' => $kategoria,
			'modul' => $modul,
			'akcja' => $akcja,
		);
	}



	/**
	 * Wykonuje ustawiona wczesniej akcje.
	 */
	public function wykonaj()
	{
		$this->wykonywanaAkcja = $this->nastepnaAkcja;
		$this->nastepnaAkcja = array(
			'blok' => null,
			'kategoria' => null,
			'modul' => null,
			'akcja' => null,
		);

		$modul = $this->wykonywanaAkcja['modul'];
		if ($modul instanceof Modul)
		{
			$modul->inicjuj($this, $this->wykonywanaAkcja['kategoria'], $this->wykonywanaAkcja['blok']);
			$modul->wykonajAkcje((string)$this->wykonywanaAkcja['akcja']);
			$this->zwracanaTresc[] = $modul->pobierzTresc(true);
			/*
			 * Podczas wykonywania akcji modul moze ustawic kolejna akcje do wykonania i przekazac ja do sterownika.
			 * Zostanie ona zapisana w lokalnej zmiennnej $nastepnaAkcja.
			 * Jeżeli zmienna ustawiona to wykonujemy nowa akcje.
			 */
			if ($this->nastepnaAkcja['modul'] instanceof Modul)
			{
				$this->wykonaj();
			}
		}
	}



	/**
	 * Ustawia dane obowiazujace dla calej strony.
	 *
	 * @param array $dane Tablica z danymi globalnymi w formacie array('nazwa' => 'wartosc').
	 */
	public function ustawGlobalne(Array $dane)
	{
		$this->zmienneGlobalne = array_merge($this->zmienneGlobalne, $dane);
	}



	/**
	 * Zwraca dane obowiazujace dla calej strony w formacie array('nazwa' => 'wartosc').
	 *
	 * @return array
	 */
	public function pobierzGlobalne()
	{
		return $this->zmienneGlobalne;
	}



	/**
	 * Zwraca tresc wygenerowana podczas wykonywania sie modulow.
	 *
	 * @param bool $czysc Czy wyczyscic tresc wygenerowana do tej pory.
	 *
	 * @return string
	 */
	public function pobierzTresc($czysc = false)
	{
		$bufor = $this->zwracanaTresc;

		if ($czysc)
		{
			$this->zwracanaTresc = array();
		}

		return $bufor;
	}



	/**
	 * Zwraca modul na podstawie nazwy.
	 *
	 * @param string $nazwaModulu Nazwa wywolywanego modulu (tekst albo null).
	 *
	 * @return Object
	 */
	protected function pobierzModul($nazwaModulu)
	{
		/*if ($nazwaModulu == '')
		{
			return false;
		}
		elseif (isset($this->zaladowaneModuly[$nazwaModulu]))
		{
			return $this->zaladowaneModuly[$nazwaModulu];
		}
		else
		{*/
			$nazwaKlasy = 'Generic\\Modul\\'.$nazwaModulu.'\\'.$this->nazwaUslugi;
			$modul = new $nazwaKlasy();

			$this->zaladowaneModuly[$nazwaModulu] = $modul;
			return $modul;
		//}
	}



	/**
	 * Zwraca nazwe uslugi dla ktorej zainicjowany zostal sterownik.
	 *
	 * @return string
	 */
	public function nazwaUslugi()
	{
		return $this->nazwaUslugi;
	}



	/**
	 * Ustawienie identyfikatora ukladu strony
	 *
	 * @param int $ukladStrony
	 */
	public function ustawIdWidoku($idWidoku)
	{
		$this->idWidoku = (int) $idWidoku;
	}



	/**
	 * Pobranie identyfikatora ukladu strony
	 *
	 * @return int
	 */
	public function pobierzIdWidoku()
	{
		return $this->idWidoku;
	}



	/**
	 * Ustawienie kontenara dla strony
	 *
	 * @param string $kontener
	 */
	public function ustawKontener($kontener)
	{
		$this->kontener = $kontener;
	}



	/**
	 * Pobranie kontenera dla strony
	 *
	 * @return int
	 */
	public function pobierzKontener()
	{
		return $this->kontener;
	}



	/**
	 * Ustawienie klasy css dla strony
	 *
	 * @param string $klasa
	 */
	public function ustawKlase($klasa)
	{
		$this->klasa = $klasa;
	}



	/**
	 * Pobranie klasy css dla strony
	 *
	 * @return int
	 */
	public function pobierzKlase()
	{
		return $this->klasa;
	}
}
