<?php
namespace Generic\Biblioteka\Grafika;


/**
 * Interfejs dla klas obslugujacych operacje na plikach graficznych.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
interface Interfejs
{

	/**
	 * Wczytuje plik z obrazkiem.
	 *
	 * @param string $sciezka Sciezka do pliku.
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function wczytaj($sciezka);



	/**
	 * Zapisuje plik z obrazkiem do pliku.
	 *
	 * @param string $sciezka Sciezka do pliku.
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function zapisz($sciezka);



	/**
	 * Czysci obrazek z danych Exif i komentarzy.
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function czysc();



	/**
	 * Zmienia rozmiar obrazka.
	 *
	 * @param integer $szerokosc Nowa szerokosc obrazka.
	 * @param integer $wysokosc Nowa wyskokosc obrazka.
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function zmienRozmiar($szerokosc, $wysokosc);



	/**
	 * Skaluje obrazek.
	 *
	 * @param integer $szerokosc Nowa szerokosc obrazka.
	 * @param integer $wysokosc Nowa wyskokosc obrazka.
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function skaluj($szerokosc, $wysokosc);



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
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function skalujUtnij($szerokosc, $wysokosc, $gora = null, $lewa = null, $dol = null, $prawa = null);



	/**
	 * Skaluje obrazek a potem, jeśli jest taka potrzeba ucina go do okreslonych rozmiarów.
	 *
	 * @param integer $szerokosc Nowa szerokosc obrazka.
	 * @param integer $wysokosc Nowa wyskokosc obrazka.
	 * @param float $gora Gorna granica obszaru wyciecia w procentach(opcjonalne).
	 * @param float $lewa Lewa granica obszaru wyciecia w procentach(opcjonalne).
	 * @param float $dol Dolna granica obszaru wyciecia w procentach(opcjonalne).
	 * @param float $prawa Prawa granica obszaru wyciecia w procentach(opcjonalne).
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function skalujUtnijJesliPotrzeba($szerokosc, $wysokosc, $gora = null, $lewa = null, $dol = null, $prawa = null);


	/**
	 * Obraca obrazek o podany kat.
	 *
	 * @param integer $kat Kat obrotu obrazka.
	 * @param string $tlo Tlo obrazka (np.: "blue", "#0000ff", "rgb(0,0,255)", "cmyk(100,100,100,10)").
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function obroc($kat, $tlo = 'white');



	/**
	 * Wycina fragment obrazka
	 *
	 * @param integer $wysokosc - wysokość wycięcia
	 * @param integer $szerokosc - szerokość wycięcia
	 * @param integer $x - przesunięcie wycięcia na osi X
	 * @param integer $y - przesunięcie wycięcia na osi Y
	 */
	public function utnij($szerokosc, $wysokosc, $x = 0, $y = 0);



	/**
	 * Odbija obrazek w poziomie lub w pionie
	 * @param string $kierunek - kierunek odbicia ("x" lub "y")
	 */
	public function odbij($kierunek = 'x');



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
	public function wstawTekst($tekst, $pozycja = 'srodek', $czcionka = null, $rozmiar = 12, $kolor = '#000000', $przezroczystosc = 0, $kat = 0);



	/**
	 * Zwraca tabelę asocjacyjną z szerokością i wysokością obrazka
	 *
	 * @return array
	 */
	public function pobierzWymiary();


	// TODO: dopisywac kolejne metody do obrobki grafiki

}

