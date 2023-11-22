<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Grafika;


/**
 * Klasa do obrobki plikow graficznych.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Grafika
{

	/**
	 * Klasa obslugujaca operacje graficzne.
	 *
	 * @var mixed
	 */
	protected $silnik;



	/**
	 * Konstruktor ustawia klase silnika graficznego.
	 *
	 * @param Grafika_Interfejs $klasa Klasa z implementacja silnika graficznego
	 */
	public function __construct(Grafika\Interfejs $klasa)
	{
		$this->silnik = $klasa;
	}



	/**
	 * Wczytuje plik z obrazkiem.
	 *
	 * @param string $sciezka Sciezka do pliku.
	 *
	 * @return boolean
	 */
	public function wczytaj($sciezka)
	{
		return $this->silnik->wczytaj($sciezka);
	}



	/**
	 * Zapisuje plik z obrazkiem do pliku.
	 *
	 * @param string $sciezka Sciezka do pliku.
	 *
	 * @return boolean
	 */
	public function zapisz($sciezka)
	{
		return $this->silnik->zapisz($sciezka);
	}



	/**
	 * Czysci obrazek z danych Exif i komentarzy.
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function czysc()
	{
		return $this->silnik->czysc();
	}



	/**
	 * Zmienia rozmiar obrazka do wartosci podanych jako parametry(rozciaga go).
	 *
	 * @param integer $szerokosc Nowa szerokosc obrazka.
	 * @param integer $wysokosc Nowa wyskokosc obrazka.
	 * @param boolean $obcinanie Czy obcinac czesc wystajaca po zmniejszeniu poza okreslony obszar. jezeli false to przeskaluje obrazek
	 *
	 * @return boolean
	 */
	public function zmienRozmiar($szerokosc, $wysokosc)
	{
		return $this->silnik->zmienRozmiar($szerokosc, $wysokosc);
	}



	/**
	 * Skaluje obrazek.
	 *
	 * @param integer $szerokosc Nowa szerokosc obrazka.
	 * @param integer $wysokosc Nowa wyskokosc obrazka.
	 *
	 * @return boolean
	 */
	public function skaluj($szerokosc, $wysokosc)
	{
		return $this->silnik->skaluj($szerokosc, $wysokosc);
	}



	/**
	 * Skaluje obrazek a potem ucina go do okreslonych rozmiarów.
	 *
	 * @param integer $szerokosc Nowa szerokosc obrazka.
	 * @param integer $wysokosc Nowa wyskokosc obrazka.
	 * @param float $gora Gorna granica obszaru wyciecia w procentach(opcjonalne).
	 * @param float $lewa Lewa granica obszaru wyciecia w procentach(opcjonalne).
	 * @param float $dol Dolna granica obszaru wyciecia w procentach(opcjonalne).
	 * @param float $prawa Prawa granica obszaru wyciecia w procentach(opcjonalne).
	 *
	 * @return boolean
	 */
	public function skalujUtnij($szerokosc, $wysokosc, $gora = null, $lewa = null, $dol = null, $prawa = null)
	{
		return $this->silnik->skalujUtnij($szerokosc, $wysokosc, $gora, $lewa, $dol, $prawa);
	}



	/**
	 * Wycina fragment obrazka
	 *
	 * @param integer $wys - wysokość wycięcia
	 * @param integer $szer - szerokość wycięcia
	 * @param integer $pozx - przesunięcie wycięcia na osi X
	 * @param integer $pozy - przesunięcie wycięcia na osi Y
	 */
	public function utnij($szer,$wys,$pozx,$pozy)
	{
		return $this->silnik->utnij($szer , $wys, $pozx, $pozy);
	}



	/**
	 * Odbija obrazek
	 *
	 * @param string $kierunek - kierunek odbicia - x / y
	 */
	public function odbij($kierunek = 'x')
	{
		return $this->silnik->odbij($kierunek);
	}



	/**
	 * Obraca obrazek o podany kat.
	 *
	 * @param integer $kat Kat obrotu obrazka.
	 * @param string $tlo Tlo obrazka (np.: "blue", "#0000ff", "rgb(0,0,255)", "cmyk(100,100,100,10)").
	 *
	 * @return boolean
	 */
	public function obroc($kat, $tlo = 'white')
	{
		return $this->silnik->obroc($kat, $tlo);
	}



	/**
	 * Dodaje znak wodny
	 *
	 * @param string $tekst - wyświetlany tekst
	 * @param string $pozycja - pozycja znaku wodnego
	 * - srodek			- środek
	 * - gora			- góra
	 * - prawy_gorny	- prawy górny
	 * - prawa			- prawa
	 * - prawy_dolny	- prawy dół
	 * - dol			- dół
	 * - lewy_dolny		- lewy dół
	 * - lewa			- lewa
	 * - lewy_gorny		- lewy górny
	 * @param string $czcionka - plik czcionki
	 * @param integer $rozmiar - rozmiar czcionki
	 * @param string $kolor - kolor czcionki w formacie #000000
	 * @param integer $przezroczystosc - określa przeźroczystość (0-100)
	 * @param integer $kat - kąt nachylenia tekstu
	 */
	public function wstawTekst($tekst, $pozycja = 'srodek', $czcionka = null, $rozmiar = 12, $kolor = '#000000', $przezroczystosc = 0, $kat = 0)
	{
		return $this->silnik->wstawTekst($tekst, $pozycja, $czcionka, $rozmiar, $kolor, $przezroczystosc, $kat);
	}



	/**
	 * Zwraca tabelę asocjacyjną z szerokością i wysokością obrazka
	 *
	 * @return array
	 */
	public function pobierzWymiary()
	{
		return $this->silnik->pobierzWymiary();
	}

}

