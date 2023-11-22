<?php
namespace Generic\Biblioteka\Grafika;
use Generic\Biblioteka\Grafika;


/**
 * Klas obslugujaca operacje na plikach graficznych za pomocą biblioteki ImageMagic.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class IMagic implements Grafika\Interfejs
{

	/**
	 * Klasa obslugujaca operacje graficzne.
	 *
	 * @var Imagick
	 */
	protected $imagick;


	/**
	 * Źródło czcionek w formacie TTF
	 *
	 * @var string
	 */
	protected $ttf_dir;


	protected $aktualna_szerokosc;


	protected $aktualna_wysokosc;


	/**
	 * Inicjuje klase ImageMagic dla PHP.
	 */
	public function __construct()
	{
		$this->imagick = new \Imagick();
	}



	/**
	 * Wczytuje plik z obrazkiem.
	 *
	 * @param string $sciezka Sciezka do pliku.
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function wczytaj($sciezka)
	{
		return (bool)$this->imagick->readImage($sciezka);
	}



	/**
	 * Zapisuje plik z obrazkiem do pliku.
	 *
	 * @param string $sciezka Sciezka do pliku.
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function zapisz($sciezka)
	{
		return (bool)$this->imagick->writeImage($sciezka);
	}



	/**
	 * Czysci obrazek z danych Exif i komentarzy.
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function czysc()
	{
		return (bool)$this->imagick->stripImage();
	}


	/**
	 * Tworzy miniaturke obrazka.
	 *
	 * @param integer $szerokosc Nowa szerokosc obrazka.
	 * @param integer $wysokosc Nowa wyskokosc obrazka.
	 * @param boolean $obcinanie Czy obcinac czesc wystajaca po zmniejszeniu poza okreslony obszar.
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function zmienRozmiar($szerokosc, $wysokosc)
	{
		$this->aktualna_szerokosc = $szerokosc;
		$this->aktualna_wysokosc = $wysokosc;
		return ($this->imagick->resizeImage($szerokosc, $wysokosc, \Imagick::FILTER_LANCZOS, 1)
				&& $this->imagick->setImagePage($szerokosc, $wysokosc, 0, 0));
	}



	/**
	 * Skaluje obrazek.
	 *
	 * @param integer $szerokosc Nowa szerokosc obrazka.
	 * @param integer $wysokosc Nowa wyskokosc obrazka.
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function skaluj($szerokosc, $wysokosc)
	{
		$wysObr = $this->imagick->getImageHeight();
		$szerObr = $this->imagick->getImageWidth();

		if ($wysObr < $wysokosc && $szerObr < $szerokosc) return true;

		// okreslenie maksymalnych rozmiarow obrazka
		$wysMaks = ($wysObr < $wysokosc) ? $wysObr : $wysokosc;
		$szerMaks = ($szerObr < $szerokosc) ? $szerObr : $szerokosc;
		// okreslenie wspolczynnika skali do pomniejszania obrazka na podstawie rozmiarow
		$wspWys = ($wysMaks < $wysObr) ? $wysMaks / $wysObr : $wysObr / $wysMaks;
		$wspSzer = ($szerMaks < $szerObr) ? $szerMaks / $szerObr : $szerObr / $szerMaks;
		// wybieramy mniejszy wspolczynnik bo dostosowujemy do mniejszego rozmiaru
		$wspSkali = ($wspWys < $wspSzer) ? $wspWys : $wspSzer;
		// jezeli granice wieksze od obrazka to nie powiekszamy
		$wspSkali = ($wspSkali < 1) ? $wspSkali : 1;
		$szerokosc = round($wspSkali * $szerObr);
		$wysokosc = round($wspSkali * $wysObr);
/*
		if (strtoupper($this->imagick->getImageFormat()) == 'GIF')
			return ($this->imagick->scaleImage($szerokosc, $wysokosc)
					&& $this->imagick->setImagePage($szerokosc, $wysokosc, 0, 0));
		else
			return $this->imagick->scaleImage($szerokosc, $wysokosc);
*/		$this->aktualna_szerokosc = $szerokosc;
		$this->aktualna_wysokosc = $wysokosc;
		return ($this->imagick->scaleImage($szerokosc, $wysokosc)
				&& $this->imagick->setImagePage($szerokosc, $wysokosc, 0, 0));
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
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function skalujUtnij($szerokosc, $wysokosc, $gora = null, $lewa = null, $dol = null, $prawa = null)
	{
		if (is_null($gora) || is_null($lewa) || is_null($dol) || is_null($prawa))
		{
			$wysObr = $this->imagick->getImageHeight();
			$szerObr = $this->imagick->getImageWidth();

			if ($wysObr <= $wysokosc && $szerObr <= $szerokosc) return true;

			// okreslenie maksymalnych rozmiarow ciecia
			$wysokosc = ($wysObr < $wysokosc) ? $wysObr : $wysokosc;
			$szerokosc = ($szerObr < $szerokosc) ? $szerObr : $szerokosc;

			$this->aktualna_szerokosc = $szerokosc;
			$this->aktualna_wysokosc = $wysokosc;

			return ($this->imagick->cropThumbnailImage($szerokosc ,$wysokosc)
					&& $this->imagick->setImagePage($szerokosc, $wysokosc, 0, 0));
		}
		else
		{
			if (!is_float($gora) || !is_float($lewa) || !is_float($dol) || !is_float($prawa))
			{
				trigger_error('Koordynaty do wycinania miniaturek nie sa liczbami', E_USER_WARNING);
				return false;
			}
			if ($gora > $dol || $lewa > $prawa)
			{
				trigger_error('Gorny lewy i prawy dolny rog obszaru do wyciecia nie zgadzaja sie', E_USER_WARNING);
				return false;
			}
			if (($gora < 0 && $gora > 100) || ($lewa < 0 && $lewa > 100) || ($dol < 0 && $dol > 100) || ($prawa < 0 && $prawa > 100))
			{
				trigger_error('Koordynaty powinny byc liczbami float od 0 do 100', E_USER_WARNING);
				return false;
			}

			$szerokoscObrazka = $this->imagick->getImageWidth();
			$wysokoscObrazka = $this->imagick->getImageHeight();
			if ($szerokoscObrazka == 0 || $wysokoscObrazka == 0)
			{
				trigger_error('Szerokosc i wysokosc musza byc wieksze od 0', E_USER_WARNING);
				return false;
			}
			$xLewa = $szerokoscObrazka * ($lewa / 100);
			$xPrawa = $szerokoscObrazka * ($prawa / 100);
			$szerokoscWyciecia = $xPrawa - $xLewa;
			if ((($xLewa + $szerokoscWyciecia) > $szerokoscObrazka) || $szerokoscWyciecia == 0)
			{
				trigger_error('Szerokosc do wyciecia nie zgadza sie z szerokoscia obrazka', E_USER_WARNING);
				return false;
			}

			$yGora = $wysokoscObrazka * ($gora / 100);
			$yDol = $wysokoscObrazka * ($dol / 100);
			$wysokoscWyciecia = $yDol - $yGora;
			if ((($yGora + $wysokoscWyciecia) > $wysokoscObrazka) || $wysokoscWyciecia == 0)
			{
				trigger_error('Wysokosc do wyciecia nie zgadza sie z wysokoscia obrazka', E_USER_WARNING);
				return false;
			}
			$this->aktualna_szerokosc = $szerokosc;
			$this->aktualna_wysokosc = $wysokosc;
			if ($this->imagick->cropImage($szerokoscWyciecia , $wysokoscWyciecia, $xLewa, $yGora))
			{
				if (strtoupper($this->imagick->getImageFormat()) == 'GIF')
				{
					$this->imagick->setImagePage(0, 0, 0, 0);
				}
				return $this->skaluj($szerokosc, $wysokosc);
			}
			else
				return false;
		}
	}


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
	public function skalujUtnijJesliPotrzeba($szerokosc, $wysokosc, $gora = null, $lewa = null, $dol = null, $prawa = null)
	{
		if (is_null($gora) || is_null($lewa) || is_null($dol) || is_null($prawa))
		{
			$wysObr = $this->imagick->getImageHeight();
			$szerObr = $this->imagick->getImageWidth();

			if ($wysObr <= $wysokosc && $szerObr <= $szerokosc) return true;

			// okreslenie maksymalnych rozmiarow ciecia
			$wysokosc = ($wysObr < $wysokosc) ? $wysObr : $wysokosc;
			$szerokosc = ($szerObr < $szerokosc) ? $szerObr : $szerokosc;

			if ($szerokosc > $wysokosc)
			{
				$szerokosc_skalowania = $szerokosc;
				$wysokosc_skalowania = $szerokosc;
			}
			else
			{
				$szerokosc_skalowania = $wysokosc;
				$wysokosc_skalowania = $wysokosc;
			}
			if (!$this->skaluj($szerokosc_skalowania, $wysokosc_skalowania)) return false;

			if ($this->aktualna_szerokosc <= $szerokosc && $this->aktualna_wysokosc <= $wysokosc) return true;

			$this->aktualna_szerokosc = $szerokosc;
			$this->aktualna_wysokosc = $wysokosc;

			return ($this->imagick->cropThumbnailImage($szerokosc ,$wysokosc)
					&& $this->imagick->setImagePage($szerokosc, $wysokosc, 0, 0));
		}
		else
		{
			if (!is_float($gora) || !is_float($lewa) || !is_float($dol) || !is_float($prawa))
			{
				trigger_error('Koordynaty do wycinania miniaturek nie sa liczbami', E_USER_WARNING);
				return false;
			}
			if ($gora > $dol || $lewa > $prawa)
			{
				trigger_error('Gorny lewy i prawy dolny rog obszaru do wyciecia nie zgadzaja sie', E_USER_WARNING);
				return false;
			}
			if (($gora < 0 && $gora > 100) || ($lewa < 0 && $lewa > 100) || ($dol < 0 && $dol > 100) || ($prawa < 0 && $prawa > 100))
			{
				trigger_error('Koordynaty powinny byc liczbami float od 0 do 100', E_USER_WARNING);
				return false;
			}

			$szerokoscObrazka = $this->imagick->getImageWidth();
			$wysokoscObrazka = $this->imagick->getImageHeight();
			if ($szerokoscObrazka == 0 || $wysokoscObrazka == 0)
			{
				trigger_error('Szerokosc i wysokosc musza byc wieksze od 0', E_USER_WARNING);
				return false;
			}
			$xLewa = $szerokoscObrazka * ($lewa / 100);
			$xPrawa = $szerokoscObrazka * ($prawa / 100);
			$szerokoscWyciecia = $xPrawa - $xLewa;
			if ((($xLewa + $szerokoscWyciecia) > $szerokoscObrazka) || $szerokoscWyciecia == 0)
			{
				trigger_error('Szerokosc do wyciecia nie zgadza sie z szerokoscia obrazka', E_USER_WARNING);
				return false;
			}

			$yGora = $wysokoscObrazka * ($gora / 100);
			$yDol = $wysokoscObrazka * ($dol / 100);
			$wysokoscWyciecia = $yDol - $yGora;
			if ((($yGora + $wysokoscWyciecia) > $wysokoscObrazka) || $wysokoscWyciecia == 0)
			{
				trigger_error('Wysokosc do wyciecia nie zgadza sie z wysokoscia obrazka', E_USER_WARNING);
				return false;
			}
			$this->aktualna_szerokosc = $szerokosc;
			$this->aktualna_wysokosc = $wysokosc;
			if ($this->imagick->cropImage($szerokoscWyciecia , $wysokoscWyciecia, $xLewa, $yGora))
			{
				if (strtoupper($this->imagick->getImageFormat()) == 'GIF')
				{
					$this->imagick->setImagePage(0, 0, 0, 0);
				}
				return $this->skaluj($szerokosc, $wysokosc);
			}
			else
				return false;
		}
	}



	/**
	 * Obraca obrazek o podany kat.
	 *
	 * @param integer $kat Kat obrotu obrazka.
	 * @param string $tlo Kolor tla obrazka (np.: "blue", "#0000ff", "rgb(0,0,255)", "cmyk(100,100,100,10)").
	 *
	 * @return boolean True jezeli sukces, False jezeli porazka.
	 */
	public function obroc($kat, $tlo = 'white')
	{
		return $this->imagick->rotateImage(new \ImagickPixel($tlo), $kat);
	}



	/**
	 * Wycina fragment obrazka
	 *
	 * @param integer $wysokosc - wysokość wycięcia
	 * @param integer $szerokosc - szerokość wycięcia
	 * @param integer $x - przesunięcie wycięcia na osi X
	 * @param integer $y - przesunięcie wycięcia na osi Y
	 */
	public function utnij($szerokosc, $wysokosc, $x = 0, $y = 0)
	{
		$this->aktualna_szerokosc = $szerokosc;
		$this->aktualna_wysokosc = $wysokosc;
		return $this->imagick->cropImage($szerokosc , $wysokosc, $x, $y);
	}



	/**
	 * Odbija obrazek w poziomie lub w pionie
	 *
	 * @param string $kierunek - kierunek odbicia ("x" lub "y")
	 */
	public function odbij($kierunek = 'x')
	{
		switch($kierunek)
		{
			case 'x': return $this->imagick->flopImage(); break;
			case 'y': return $this->imagick->flipImage(); break;
			default: return;
		}
	}



	/**
	 * Dodaje znak wodny
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
		$txt = new \ImagickDraw();

		$pozycje = array(
			'srodek'		=> \Imagick::GRAVITY_CENTER,
			'gora'			=> \Imagick::GRAVITY_NORTH,
			'prawy_gorny'	=> \Imagick::GRAVITY_NORTHEAST,
			'prawa'			=> \Imagick::GRAVITY_EAST,
			'prawy_dolny'	=> \Imagick::GRAVITY_SOUTHEAST,
			'dol'			=> \Imagick::GRAVITY_SOUTH,
			'lewy_dolny'	=> \Imagick::GRAVITY_SOUTHWEST,
			'lewa'			=> \Imagick::GRAVITY_WEST,
			'lewy_gorny'	=> \Imagick::GRAVITY_NORTHWEST,
		);
		$pozycja = (isset($pozycje[$pozycja])) ? $pozycje[$pozycja] : \Imagick::GRAVITY_CENTER;
		$txt->setGravity($pozycja);

		if ($czcionka != '')
		{
			if (file_exists($czcionka))
				$txt->setFont($czcionka);
			else
				trigger_error('Brak czcionki '.$czcionka, E_USER_WARNING);
		}

		$rozmiar = ($rozmiar > 0) ? (int)$rozmiar : 12;
		$txt->setFontSize($rozmiar);

		$kolor = (preg_match('#[a-f0-9]{6}#si', $kolor)) ? '#'.$kolor : '#000000';
		$txt->setFillColor(new \ImagickPixel($kolor));

		if ($przezroczystosc >= 100) { $przezroczystosc = 100; }
		if ($przezroczystosc < 0) { $przezroczystosc = 0; }
		$txt->setFillAlpha(number_format(($przezroczystosc/100),1,'.',''));

		$kat = (int)ceil(abs($kat));
		if ($kat > 360) { $kat = $kat % 360; }

		return $this->imagick->annotateImage($txt, 0, 0, $kat, $tekst);
	}



	/**
	 * Zwraca tabelę asocjacyjną z szerokością i wysokością obrazka
	 *
	 * @return array
	 */
	public function pobierzWymiary()
	{
		return $this->imagick->getImageGeometry();
	}



	// TODO: dopisywac kolejne metody do obrobki grafiki



	public function __destruct()
	{
		$this->imagick->clear();
		$this->imagick->destroy();
		$this->imagick = null;
	}

}

