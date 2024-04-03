<?php
namespace Generic\Modul\PlikiPubliczne;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\MenedzerPlikow;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Katalog;


/**
 * Modul odpowiadajacy za zarzadzanie plikami publicznymi.
 *
 * @author Półtorak Dariusz
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\PlikiPubliczne\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\PlikiPubliczne\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajNowy',
		'wykonajUpload',
		'wykonajUsun',
		'wykonajZmien',
		'wykonajPrzenies',
	);

	protected $MenedzerPlikow = null;



	public function wykonajIndex()
	{
		$this->init();
		$this->wyswietl();
	}



	public function wykonajNowy()
	{
		$this->init();

		// Nowy folder
		if (Zadanie::pobierzPost('nowy_folder', 'trim') != null)
		{
			$sciezka = Zadanie::pobierzGet('sciezka', 'trim');
			$nazwaKatalogu = Zadanie::pobierzPost('nazwa', 'trim');
			$this->MenedzerPlikow->nowyKatalog($sciezka, $nazwaKatalogu);
		}

		$this->wyswietl();
	}



	public function wykonajUpload()
	{
		$this->init();

		// Upload
		if (Zadanie::pobierzPost('upload') !== null)
		{
			$sciezka = Zadanie::pobierzGet('sciezka', 'trim');
			$plik = $this->MenedzerPlikow->zapiszPlik($sciezka,$_FILES['plik']);
		}

		$this->wyswietl();
	}



	public function wykonajUsun()
	{
		$this->init();

		// Usuwanie
		if (($sciezkaPliku = Zadanie::pobierzGet('usun', 'trim')) != null)
		{
			$this->MenedzerPlikow->usun($sciezkaPliku);
		}

		$this->wyswietl();
	}



	public function wykonajZmien()
	{
		$this->init();

		// Zmiana nazwy
		if (($plik = Zadanie::pobierzGet('plik', 'trim')) != null && ($nowaNazwa = Zadanie::pobierzGet('nazwa', 'trim')) != null)
		{
			$this->MenedzerPlikow->zmienNazwe($plik, $nowaNazwa);
		}

		$this->wyswietl();
	}



	public function wykonajPrzenies()
	{
		$this->init();

		// Przenoszenie
		if (($zrodlo = Zadanie::pobierzGet('zrodlo', 'trim')) != null && ($cel = Zadanie::pobierzGet('cel', 'trim')) != null)
		{
			$this->MenedzerPlikow->przenies($zrodlo,$cel);
		}

		$this->wyswietl();
	}



	protected function init()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$this->MenedzerPlikow = new MenedzerPlikow(Cms::inst()->katalog('public_temp'), Cms::inst()->url('public_temp'));

		$cms = Cms::inst();
		$nazwaUslugi = explode('\\',get_class($cms->usluga));
		$usluga = end($nazwaUslugi);

		$tryb = strtolower(Zadanie::pobierzGet('tryb', 'trim'));
		$akceptowane_rozszerzenia = false;
		$linki = array();

		if (strlen(trim((string)$tryb)) > 0)
		{
			if (isset($this->k->k['index.akceptowane_rozszerzenia'][$tryb]))
			{
				$akceptowane_rozszerzenia = explode(',', $this->k->k['index.akceptowane_rozszerzenia'][$tryb]);
				if (count($akceptowane_rozszerzenia) > 0)
				{
					$akceptowane_rozszerzenia = array_map('trim', $akceptowane_rozszerzenia);
				}
				else
				{
					trigger_error('Filtr '.htmlspecialchars($tryb).' w menedzerze plikow publicznych nie zawiera rozszerzen');
				}
			}
			else
			{
				trigger_error('Brak filtru '.htmlspecialchars($tryb).' w menedzerze plikow publicznych');
			}
		}

		if ($usluga == 'Popup')
		{
			$this->MenedzerPlikow->ustawTlumaczenia(array(
				'menedzer_plikow_kom_domyslny' => $this->j->t['index.komunikat_domyslny'],
			));

			$linki = array(
				'link_katalog' => Router::urlPopup('admin', 'PlikiPubliczne','index',array(
					'sciezka' => '{SCIEZKA}',
					'tryb' => $tryb,
				)),
				'link_nowy' => Router::urlPopup('admin', 'PlikiPubliczne','nowy',array(
					'sciezka' => '{SCIEZKA}',
					'tryb' => $tryb,
				)),
				'link_upload' => Router::urlPopup('admin', 'PlikiPubliczne','upload',array(
					'sciezka' => '{SCIEZKA}',
					'tryb' => $tryb,
				)),
				'link_usun' => Router::urlPopup('admin', 'PlikiPubliczne','usun',array(
					'sciezka' => '{SCIEZKA}',
					'usun' => '{USUN}',
					'tryb' => $tryb,
				)),
				'link_zmienNazwe' => Router::urlPopup('admin', 'PlikiPubliczne','zmien',array(
					'sciezka' => '{SCIEZKA}',
					'plik' => '{PLIK}',
					'nazwa' => '{NAZWA}',
					'tryb' => $tryb,
				)),
				'link_przenies' => Router::urlPopup('admin', 'PlikiPubliczne','przenies',array(
					'sciezka' => '{SCIEZKA}',
					'zrodlo' => '{ZRODLO}',
					'cel' => '{CEL}',
					'tryb' => $tryb,
				)),
			);
		}
		elseif ($usluga == 'Admin')
		{
			$linki = array(
				'link_katalog' => Router::urlAdmin('PlikiPubliczne','index',array(
					'sciezka' => '{SCIEZKA}',
					'tryb' => $tryb,
				)),
				'link_nowy' => Router::urlAdmin('PlikiPubliczne','nowy',array(
					'sciezka' => '{SCIEZKA}',
					'tryb' => $tryb,
				)),
				'link_upload' => Router::urlAdmin('PlikiPubliczne','upload',array(
					'sciezka' => '{SCIEZKA}',
					'tryb' => $tryb,
				)),
				'link_usun' => Router::urlAdmin('PlikiPubliczne','usun',array(
					'sciezka' => '{SCIEZKA}',
					'usun' => '{USUN}',
					'tryb' => $tryb,
				)),
				'link_zmienNazwe' => Router::urlAdmin('PlikiPubliczne','zmien',array(
					'sciezka' => '{SCIEZKA}',
					'plik' => '{PLIK}',
					'nazwa' => '{NAZWA}',
					'tryb' => $tryb,
				)),
				'link_przenies' => Router::urlAdmin('PlikiPubliczne','przenies',array(
					'sciezka' => '{SCIEZKA}',
					'zrodlo' => '{ZRODLO}',
					'cel' => '{CEL}',
					'tryb' => $tryb,
				)),
			);
		}

		$katalogMiniatur = new Katalog(Cms::inst()->katalog('miniatury'), true);

		$config = array(
			'tworzenie_katalogow' => $this->moznaWykonacAkcje('wykonajNowy'),
			'upload' => $this->moznaWykonacAkcje('wykonajUpload'),
			'usuwanie' => $this->moznaWykonacAkcje('wykonajUsun'),
			'zmianaNazwy' => $this->moznaWykonacAkcje('wykonajZmien'),
			'przenoszenie' => $this->moznaWykonacAkcje('wykonajPrzenies'),
			'akceptowane_rozszerzenia' => $akceptowane_rozszerzenia,
			'katalog_miniaturek' => ($katalogMiniatur->istnieje()) ? (string)$katalogMiniatur : false,
			'url_miniaturek' => Cms::inst()->url('miniatury'),
			'podglad_miniatur' => $this->k->k['index.podglad_obrazkow'],
		);

		$ck_func = Zadanie::pobierzGet('CKEditorFuncNum', 'intval', 'abs');
		if ($ck_func > 0) {
			$config['CKEditorFuncNum'] = $ck_func;
		}

		$config = array_merge($config, $linki);

		$this->MenedzerPlikow->ustawKonfiguracje($config);
	}



	protected function wyswietl()
	{
		if ($this->k->k['index.szablon_managera'] != '')
		{
			$plikSzablonu = CMS_KATALOG . DIRECTORY_SEPARATOR . SZABLON_SYSTEM . DIRECTORY_SEPARATOR . $this->k->k['index.szablon_managera'];
			$this->MenedzerPlikow->ustawSzablon($plikSzablonu, true);
		}

		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'menedzer_plikow' => $this->MenedzerPlikow->html(Zadanie::pobierzGet('sciezka', 'trim'), 99, false)
		));
	}

}

