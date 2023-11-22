<?php
namespace Generic\Modul\EdytorGraficzny;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\EdytorGrafiki;
use Generic\Biblioteka\Grafika;


/**
 * Modul odpowiadajacy za interfejs edytora graficznego.
 *
 * @author Półtorak Dariusz
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\EdytorGraficzny\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\EdytorGraficzny\Admin
	 */
	protected $j;



	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajEdytor',
	);

	protected $rozszerzenia_dla_miniatur = array('bmp', 'gif', 'jpg', 'jpeg', 'png', 'svg');



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$infoSesja = array();

		$katalog = new Katalog(Cms::inst()->katalog('edytor_graficzny', (int)Cms::inst()->profil()->id), true);
		if ( ! $katalog->istnieje())
		{
			trigger_error('Katalog roboczy użytkownika nie istnieje', E_USER_WARNING);
		}
		if (file_exists(Cms::inst()->katalog('edytor_graficzny', (int)Cms::inst()->profil()->id).'info'))
		{
			$infoSesja = explode("\n", file_get_contents(Cms::inst()->katalog('edytor_graficzny', (int)Cms::inst()->profil()->id).'info'));
		}

		$aktualnyPlik = $infoSesja[1];

		$aktualnaSesja = $this->podmien(Cms::inst()->katalog('public_temp'), Cms::inst()->url('miniatury'), $infoSesja[0]);
		$aktualneZdjecie = $this->podmien(Cms::inst()->katalog('public_temp'),  Cms::inst()->url('public_temp'), $infoSesja[0]);
		$aktualnaMiniatura = $infoSesja[0];
		$obraz = $aktualnaSesja;

		if (Cms::inst()->katalog('miniatury') != '')
		{
			$test = $this->podmien(Cms::inst()->katalog('public_temp'), Cms::inst()->katalog('miniatury'), $infoSesja[0]);
			if ( ! file_exists($test) || ! is_file($test))
			{
				$obraz = '/_system/edytor_grafiki/brak.png';
			}
		}
		else
		{
			$obraz = '/_system/edytor_grafiki/brak.png';
		}

		if (strlen($aktualnaSesja) > 0)
		{
			$this->szablon->ustawBlok('/sciana/wznow', array(
				'link' => Router::urlPopup('admin','EdytorGraficzny','edytor', array(
					'odswiez' => 'tak',
					'obraz' => $aktualneZdjecie
				)),
				'obraz' => $obraz,
				'plik' => htmlspecialchars($aktualnyPlik),
			));
		}
		else
		{
			$obraz = '';
		}

		$katalogZdjec = Cms::inst()->katalog('public_temp');
		$filtr = Zadanie::pobierzGet('filtr');
		if ($filtr != null)
		{
			$filtr = $this->podmien( Cms::inst()->url('public_temp'), Cms::inst()->katalog('public_temp'), $filtr);
			$filtr = str_replace('\\','/',realpath($filtr));
			if(strpos($filtr, Cms::inst()->katalog('public_temp')) === 0)
			{
				$filtr = rtrim($filtr, '/'); $filtr .= '/';
				$katalogZdjec = $filtr;
			}
		}

		$zdjecia = $this->przeszukajKatalog($katalogZdjec, $this->rozszerzenia_dla_miniatur);
		$count_zdjecia = count($zdjecia);
		if ($count_zdjecia > 0)
		{
			$cut_start = strlen(Cms::inst()->katalog('public_temp'));
			foreach ($zdjecia as $min)
			{
				$obraz = $min;
				$min = substr($min, $cut_start, strlen($min)-$cut_start);

				$test = Cms::inst()->katalog('miniatury').$min;
				if (Cms::inst()->katalog('miniatury') != '' && file_exists($test) && is_file($test))
				{
					$link = Cms::inst()->url('miniatury').$min;
				}
				else
				{
					$link = '/_system/edytor_grafiki/brak.png';
				}

				$min =  Cms::inst()->url('public_temp').$min;

				$wybrany = (strlen($aktualnaMiniatura) > 0 && $aktualnaMiniatura == $obraz) ? 'eg_sciana_minwybrany' : '';
				$this->szablon->ustawBlok('/sciana/miniatury/miniatura', array(
					'link' => $link,
					'nazwa' => basename($min),
					'obraz' => $min,
					'url' => Router::urlPopup('admin','EdytorGraficzny','edytor', array(
						'odswiez' => 'tak',
						'obraz' => $min,
						'reset' => 1,
					)),
					'wybrany' => $wybrany,
				));

				if ($wybrany == '')
				{
					$this->szablon->ustawBlok('/sciana/miniatury/miniatura/warning', array(
						'pytanie' => $this->j->t['index.pytanie_nowa_sesja'],
					));
					$wybrany = '';
				}

			}
		}
		else
		{
			$this->szablon->ustawBlok('/sciana/miniatury/brak', array(
				'komunikat' => $this->j->t['index.komunikat_brak_miniatur'],
			));
		}
		$this->szablon->ustawBlok('/sciana/listaFiltrow', array(
			'link' => Router::urlAdmin('EdytorGraficzny','index', array()),
			'wybrany' => ($filtr == null) ? 'wybrany' : '',
			'filtry' => $this->wypiszDrzewo(Cms::inst()->katalog('public_temp')),
		));
		$this->tresc .= $this->szablon->parsujBlok('/sciana');
	}



	public function wykonajEdytor()
	{
		$katalogZdjecia = $this->podmien( Cms::inst()->url('public_temp'), Cms::inst()->katalog('public_temp'), $this->poprawSciezke(Zadanie::pobierzGet('obraz')));

		$edytor = new EdytorGrafiki();
		$edytor->zrodloCzcionek(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/czcionki_ttf/');
		$edytor->ustawKonfiguracje(array(
			'temp' => Cms::inst()->katalog('edytor_graficzny', (int)Cms::inst()->profil()->id),
			'link' => Cms::inst()->url('edytor_graficzny', (int)Cms::inst()->profil()->id),
			'linkHistoria' => Router::urlPopup('admin','EdytorGraficzny','edytor', array(
				'obraz' => $this->poprawSciezke(Zadanie::pobierzGet('obraz')),
				'wybrany' => '{NUMER}',
			)),
		));

		$edytor->ustawSzablon(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/' . $this->k->k['plikSzablonuEdytora']);
		$edytor->inicjuj($katalogZdjecia, Zadanie::pobierzGet('wybrany'), Zadanie::pobierzGet('reset') ? true : false);

		$wykonanoZadanie = false;
		if (Zadanie::pobierzPost('wykonaj') != null)
		{
			$parametryLinku = '';
			switch (Zadanie::pobierzPost('akcjaEdytora'))
			{
				case 'skaluj':
					$edytor->skaluj(Zadanie::pobierzPost('szerokosc'), Zadanie::pobierzPost('wysokosc'), Zadanie::pobierzPost('zachowanie'));
				break;
				case 'tnij':
					$edytor->utnij(Zadanie::pobierzPost('szerokosc'), Zadanie::pobierzPost('wysokosc'), Zadanie::pobierzPost('pozx'),Zadanie::pobierzPost('pozy'));
				break;
				case 'obroc':
					$edytor->obroc(Zadanie::pobierzPost('kat'));
				break;
				case 'odbij':
					$edytor->odbij(Zadanie::pobierzPost('kierunek'));
				break;
				case 'tekst':
					$edytor->tekst(Zadanie::pobierzPost('pozycja'), Zadanie::pobierzPost('czcionka'), Zadanie::pobierzPost('rozmiar'), str_replace('#','', Zadanie::pobierzPost('kolor')), Zadanie::pobierzPost('przezroczystosc'), Zadanie::pobierzPost('kat'), Zadanie::pobierzPost('tekst'));
				break;
				case 'zapisz':
					if (Zadanie::pobierzPost('zapiszJako'))
					{
						$nazwa = $this->poprawNazwe(Zadanie::pobierzPost('nazwa'));
						$edytor->zapiszOryginal($nazwa);
						$katalog = dirname($katalogZdjecia).'/';
						$plik = basename($katalogZdjecia);
						$rozszerzenie = end(explode('.',$plik));

						if ($rozszerzenie == $plik)
						{
							$rozszerzenie = '';
						}

						$nowaMiniatura = $this->podmien(Cms::inst()->katalog('public_temp'), Cms::inst()->katalog('miniatury'), $katalog . $nazwa . '.' . $rozszerzenie);
					}
					else
					{
						$edytor->zapiszOryginal();
						$nowaMiniatura = $this->podmien(Cms::inst()->katalog('public_temp'), Cms::inst()->katalog('miniatury'), $katalogZdjecia);
					}

					if(Cms::inst()->katalog('miniatury') != '' && file_exists($nowaMiniatura) && is_file($nowaMiniatura))
					{
						$grafika = new Grafika(new Grafika\IMagic);
						$grafika->wczytaj($katalogZdjecia);
						$grafika->skaluj($this->k->k['wielkosc_miniatury']['szerokosc'], $this->k->k['wielkosc_miniatury']['wysokosc']);
						$grafika->zapisz($nowaMiniatura);
						$parametryLinku = '&odswiez=tak';
					}
				break;
			}
			$wykonanoZadanie = true;

			Router::przekierujDo($edytor->polozenie() . $parametryLinku);
			$this->tresc .= '<a href=' . $edytor->polozenie() . '>' . $this->j->t['etykieta_przekierowanie_klik'] . '</a>';
		}
		if ( ! $wykonanoZadanie)
		{
			$this->tresc .= $edytor->html();
		}
	}



	protected function wypiszDrzewo($sciezka = '', $poziom = 99)
	{
		$filtr = Zadanie::pobierzGet('filtr');
		$html = '';
		$poziomPoczatkowy = $poziom = (int) $poziom;

		if ($poziom > 0)
		{
			if (is_dir($sciezka) && $uchwyt = opendir($sciezka))
			{
				while (false !== ($plik = readdir($uchwyt)))
				{
					$nowaSciezka = $sciezka.'/'.$plik;
					if ($plik != '.' && $plik != '..' && is_dir($nowaSciezka))
					{
						$nowyFiltr = $this->podmien(Cms::inst()->katalog('public_temp'),  Cms::inst()->url('public_temp'), $nowaSciezka);
						$wybrany = ($nowyFiltr == $filtr) ? 'wybrany' : '';
						$html .= $this->szablon->parsujBlok('/drzewo/menu/katalog', array(
							'plik' => htmlspecialchars($plik),
							'lista' =>$this->wypiszDrzewo($nowaSciezka,$poziom-1),
							'link' => Router::urlAdmin('EdytorGraficzny','index', array(
								'filtr' => $nowyFiltr,
							)),
							'wybrany' => $wybrany,
							'poziom' => abs (99 - $poziomPoczatkowy + 2)
						));
					}
				}
				closedir($uchwyt);
			}
		}
		return $this->szablon->parsujBlok('/drzewo/lista', array(
			'lista' => $html,
		));
	}



	protected function przeszukajKatalog($katalog, $ext = null)
	{
		$tablica = Array();
		if ( ! file_exists($katalog) || ! is_dir($katalog))
		{
			return $tablica;
		}
		$it = new \RecursiveDirectoryIterator($katalog);
		foreach(new \RecursiveIteratorIterator($it) as $file)
		{
			$nazwaPliku = $file->getFilename();
			$sciezka = $this->poprawSciezke($file->getRealPath());
			if (is_array($ext))
			{
				$rozszerzenie = explode('.', basename($nazwaPliku));
				if (is_array($rozszerzenie)
					&& count($rozszerzenie) > 1
					&& in_array(end($rozszerzenie), $ext)
					&& $nazwaPliku != '.'
					&& $nazwaPliku != '..'
					&& strpos($sciezka, '/.svn') === false)
				{
					$tablica[] = $sciezka;
				}
			}
			else
			{
				if ($nazwaPliku != '.'
					&& $nazwaPliku != '..'
					&& strpos($sciezka, '/.svn') === false)
				{
					$tablica[] = $sciezka;
				}
			}
		}
		return $tablica;
	}


	protected function podmien($zamien, $na, $w)
	{
		return str_replace('//', '/', str_replace($zamien, $na, $w));
	}

	protected function poprawSciezke($url) {
		return str_replace(array('//', '\\'), '/', trim($url));
	}



	protected function poprawNazwe($nazwa)
	{
		$nazwa = trim($nazwa);
		$nazwa = preg_replace("#ę#i","e",$nazwa);
		$nazwa = preg_replace("#ż#i","z",$nazwa);
		$nazwa = preg_replace("#ó#i","o",$nazwa);
		$nazwa = preg_replace("#ł#i","l",$nazwa);
		$nazwa = preg_replace("#ć#i","c",$nazwa);
		$nazwa = preg_replace("#ś#i","s",$nazwa);
		$nazwa = preg_replace("#ź#i","z",$nazwa);
		$nazwa = preg_replace("#ń#i","n",$nazwa);
		$nazwa = preg_replace("#ą#i","a",$nazwa);
		$nazwa = preg_replace("#Ą#i","A",$nazwa);
		$nazwa = preg_replace("#[^-_A-Z\.0-9\s\.]#i","",$nazwa);
		$nazwa = preg_replace("#^\s+|\s+$#i","",$nazwa);
		$nazwa = preg_replace("#\s+#i","",$nazwa);
		return $nazwa;
	}
}