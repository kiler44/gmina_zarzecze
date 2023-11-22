<?php
namespace Generic\Biblioteka\Plik;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Grafika;
use Generic\Biblioteka\PlikWyjatek;


/**
 * Obsluguje operacje na pojedynczym pliku zdjęcia
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Zdjecie extends Plik
{

	/*
	 * Klasa obslugujaca operacje graficzne.
	 *
	 * @var Grafika_Interfejs
	 */
	protected $bibliotekaGraficzna;


	/*
	 * Czy wyczyscic obrazek z danych Exif i komentarzy przed zapisem.
	 *
	 * @var bool
	 */
	public $czyscNaglowki = true;


	/**
	 * Sprawdza czy plik istnieje i opcjonalnie tworzy nowy.
	 *
	 * @param string $sciezkaNazwa Sciezka i nazwa pliku.
	 * @param boolean $utworzNowy Czy tworzyc nowy jezeli nie znaleziono pliku.
	 * @param Grafika_Interfejs Biblioteka graficzna.
	 */
	public function __construct($sciezkaNazwa, $utworzNowy = false, Grafika\Interfejs $bibliotekaGraficzna = null)
	{
		parent::__construct($sciezkaNazwa, $utworzNowy);
		$this->bibliotekaGraficzna = ($bibliotekaGraficzna instanceof Grafika\Interfejs) ? $bibliotekaGraficzna : new Grafika\IMagic();
	}



	/**
	 * Tworzy miniaturke zdjecia wedlug parametrow podanych w kodzie
	 *
	 * @param string $sciezkaNazwa Sciezka i nazwa pliku miniaturki.
	 * @param string $kod Kod zawierajacy parametry do tworzenia miniaturki.
	 * Kod w formacie "szerokosc.wysokosc.operacja.[parametry_operacji]" np. kod "100.100.resize"
	 * Dostepne operacje:
	 * - "scale" (domyslnie) zmienia rozmiar z zachowaniem proporcji,
	 * - "resize" zmienia rozmiar i rozciaga obrazek do podanych wymiarow,
	 * - "crop" zmienia rozmiar i obcina nadmiar,
	 *
	 * @return boolean
	 */
	public function tworzMiniaturke($sciezkaNazwa, $kod)
	{
		$kod = explode('.', $kod);
		if (count($kod) < 2 || !is_numeric($kod[0]) || !is_numeric($kod[1]))
		{
			throw new PlikWyjatek('Nieprawidlowe parametry w kodzie '.$kod);
		}
		$miniaturka = new Grafika($this->bibliotekaGraficzna);
		$miniaturka->wczytaj($this->sciezkaPliku);

		$szerokosc = $kod[0];
		$wysokosc = $kod[1];
		$operacja = (isset($kod[2])) ? $kod[2] : 'scale';
		switch ($operacja)
		{
			case 'resize':
				$miniaturka->zmienRozmiar($szerokosc, $wysokosc);
				break;

			case 'crop':
				$miniaturka->skalujUtnij($szerokosc, $wysokosc);
				break;

			case 'scaleCrop':
				$miniaturka->skalujUtnij($szerokosc, $wysokosc);
				break;

			case 'scale':
				$miniaturka->skaluj($szerokosc, $wysokosc);
				break;

			default:
				$miniaturka->skaluj($szerokosc, $wysokosc);
				break;
		}
		if ($this->czyscNaglowki) $miniaturka->czysc();

		if ($miniaturka->zapisz($sciezkaNazwa))
			return new Plik\Zdjecie($sciezkaNazwa);
		else
			return false;
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
		if ($kat < 0 || $kat > 360)
		{
			throw new PlikWyjatek('Nieprawidlowy kat obrotu '.$kat);
		}
		$obrazek = new Grafika($this->bibliotekaGraficzna);
		$obrazek->wczytaj($this->sciezkaPliku);
		$obrazek->obroc($kat, $tlo);
		if ($this->czyscNaglowki) $obrazek->czysc();

		return $obrazek->zapisz($this->sciezkaPliku);
	}


	/**
	 * Obraca obrazek o podany kat.
	 *
	 * @return array
	 */
	public function pobierzWymiary()
	{
		$obrazek = new Grafika($this->bibliotekaGraficzna);
		$obrazek->wczytaj($this->sciezkaPliku);
		return $obrazek->pobierzWymiary();
	}

}

