<?php
namespace Generic\Modul\CropperZdjec;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\Router;


/**
 * Modul przycina zdjęcia i wyświetla odpowiedni formularz
 *
 * @author Konrad Rudowski
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\CropperZdjec\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\CropperZdjec\Http
	 */
	protected $j;


	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajFormularz',
		'wykonajPrzytnij',
	);


	protected $zdarzenia = array(
	);

	protected $akcjeAjax = array(
		'formularz',
		'przytnij',
	);

	public function wykonajIndex()
	{
		cms_blad_404(Cms::inst()->lang['bledy']['blad_zadania'], Cms::inst()->lang['bledy']['nie_znaleziono_stony']);
	}

	public function wykonajFormularz()
	{
		$zdjecieDoPrzyciecia = odkoduj(Zadanie::PobierzGet('obraz', 'trim'), Cms::inst()->config['cropper']['klucz_szyfrowania']);
		$sciezkaZdjecia = odkoduj(Zadanie::PobierzGet('sciezka', 'trim'), Cms::inst()->config['cropper']['klucz_szyfrowania']);

		$dozwoloneMiniatury = Cms::inst()->sesja->dozwoloneMiniatury;

		if (isset($dozwoloneMiniatury[$zdjecieDoPrzyciecia]))
		{
			if (Zadanie::PobierzGet('saved', 'trim') != '1')
			{
				$this->komunikat($this->j->t['wykonajPrzytnij.komunikat_info'], 'info');
				Pomocnik\Cropper::zresetujOstaniaMiniaturka();
			}

			$linkPrzycinania = Router::urlAjax('http', $this->kategoria, 'przytnij', array(
				'obraz' => urlencode(zakoduj($zdjecieDoPrzyciecia, Cms::inst()->config['cropper']['klucz_szyfrowania'])),
				'sciezka' => urlencode(zakoduj($sciezkaZdjecia, Cms::inst()->config['cropper']['klucz_szyfrowania'])),
				'kod' => '{KOD}', 'x1' => '{X1}', 'x2' => '{X2}', 'y1' => '{Y1}', 'y2' => '{Y2}', 'podobne' => '{PODOBNE}', 'coords' => '{COORDS}'));

			$this->tresc .= $this->szablon->parsujBlok('formularz', array(
				'formatka' => Pomocnik\Cropper::fomularzPrzycinania($zdjecieDoPrzyciecia, $linkPrzycinania, $dozwoloneMiniatury[$zdjecieDoPrzyciecia], $this->j->t['wykonajFormularz.nazwyMiniatur'], $this->j->t['wykonajFormularz.etykietyFormularza']),
				));
		}
		else
		{
			cms_blad_404(Cms::inst()->lang['bledy']['blad_zadania'], Cms::inst()->lang['bledy']['nie_znaleziono_stony']);
		}

	}

	public function wykonajPrzytnij()
	{
		$obrazekDoPrzyciecia = odkoduj(Zadanie::PobierzGet('obraz', 'trim'), Cms::inst()->config['cropper']['klucz_szyfrowania']);
		$sciezkaZdjecia = odkoduj(Zadanie::PobierzGet('sciezka', 'trim'), Cms::inst()->config['cropper']['klucz_szyfrowania']);
		$kod = Zadanie::PobierzGet('kod', 'trim');
		$skalujPodobne = true; //Zadanie::PobierzGet('podobne', 'trim') == 'true';
		$dozwoloneMiniatury = Cms::inst()->sesja->dozwoloneMiniatury;
		
		if (isset($dozwoloneMiniatury[$obrazekDoPrzyciecia]) && isset($dozwoloneMiniatury[$obrazekDoPrzyciecia][$kod]))
		{
			if (Zadanie::pobierz('y1', 'trim', 'floatval') == Zadanie::pobierz('y2', 'trim', 'floatval') || Zadanie::pobierz('x1', 'trim', 'floatval') == Zadanie::pobierz('x2', 'trim', 'floatval'))
			{
				$this->komunikat($this->j->t['wykonajPrzytnij.komunikat_nie_zaznaczono'], 'error', 'sesja');
			}
			else
			{
				if (Pomocnik\Cropper::przytnijObraz($obrazekDoPrzyciecia, $sciezkaZdjecia, $dozwoloneMiniatury[$obrazekDoPrzyciecia], $kod, $skalujPodobne))
				{
					$this->komunikat($this->j->t['wykonajPrzytnij.komunikat_zapisano'], 'success', 'sesja');
				}
				else
				{
					$this->komunikat($this->j->t['wykonajPrzytnij.komunikat_blad'], 'error', 'sesja');
				}
			}

			$koordynanty = Zadanie::pobierzGet('coords');

			if ($koordynanty != '')
			{
				$koordynanty = explode('|', $koordynanty);

				Pomocnik\Cropper::zapamietajCropowanyObszar($obrazekDoPrzyciecia, $kod, intval($koordynanty[0]), intval($koordynanty[1]), intval($koordynanty[2]), intval($koordynanty[3]));
			}

			$linkCropper = Router::urlAjax('http', $this->kategoria, 'formularz', array(
				'obraz' => urlencode(zakoduj($obrazekDoPrzyciecia, Cms::inst()->config['cropper']['klucz_szyfrowania'])),
				'sciezka' => urlencode(zakoduj($sciezkaZdjecia, Cms::inst()->config['cropper']['klucz_szyfrowania'])),
				'saved' => 1
				));
			
			Router::przekierujDo($linkCropper);

		}
		else
		{
			cms_blad_404(Cms::inst()->lang['bledy']['blad_zadania'], Cms::inst()->lang['bledy']['nie_znaleziono_stony']);
		}


	}

}
