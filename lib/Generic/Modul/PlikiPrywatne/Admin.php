<?php
namespace Generic\Modul\PlikiPrywatne;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Zadanie;
use Generic\Model\PlikPrywatny;
use Generic\Biblioteka\Router;
use Generic\Model\Uzytkownik;
use Generic\Model\PlikPrywatnyUzytkownikPowiazanie;
use Generic\Model\PlikPrywatnyRolaPowiazanie;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\MenedzerPlikow;


/**
 * Modul administracyjny odpowiadajacy za zarzadzanie plikami z chronionym dostępem.
 *
 * @author Półtorak Dariusz
 * @package moduly
 */

class Admin extends Modul\System
{
	/**
	 * @var \Generic\Konfiguracja\Modul\PlikiPrywatne\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\PlikiPrywatne\Admin
	 */
	protected $j;


	protected $MenedzerPlikow = null;


	protected $prefixBaza = 'temp/'; // Dokleja do url-i zapisanych w bazie


	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajNowy',
		'wykonajUpload',
		'wykonajUsun',
		'wykonajZmien',
		'wykonajPrzenies',
		'wykonajUprawnienia',
	);



	public function wykonajIndex()
	{
		$this->init();
		$this->wyswietl();
	}



	public function wykonajNowy()
	{
		$this->init();

		// Nowy folder
		if (Zadanie::pobierzPost('nowy_folder', 'trim') !== null)
		{
			$this->MenedzerPlikow->nowyKatalog(Zadanie::pobierz('sciezka','trim'), Zadanie::pobierzPost('nazwa','trim'));
		}

		$this->wyswietl();
	}



	public function wykonajUpload()
	{
		$this->init();

		// Upload
		if (Zadanie::pobierzPost('upload', 'trim') !== null)
		{
			$url = $this->MenedzerPlikow->zapiszPlik(Zadanie::pobierz('sciezka','trim'), $_FILES['plik']);
			if ($url !== false)
			{
				$plik = new PlikPrywatny\Obiekt;
				$plik->url = $this->prefixBaza.$url;
				$plik->idProjektu = ID_PROJEKTU;
				$plik->zapisz($this->dane()->PlikPrywatny());
			}
		}

		$this->wyswietl();
	}



	public function wykonajUsun()
	{
		$this->init();

		// Usuwanie
		if (($sciezkaDoUsuniecia = Zadanie::pobierzGet('usun', 'trim')) !== null)
		{
			if (false !== ($urlUsunietego = $this->MenedzerPlikow->usun($sciezkaDoUsuniecia)))
			{
				$pliki_mapper = $this->dane()->PlikPrywatny();
				$plik = $pliki_mapper->pobierzPoUrl($this->prefixBaza.$urlUsunietego);
				if ($plik instanceof PlikPrywatny\Obiekt)
				{
					$plik->usun($pliki_mapper);
				}
			}
		}

		$this->wyswietl();
	}



	public function wykonajZmien()
	{
		$this->init();

		// Zmiana nazwy
		if (($plik = Zadanie::pobierzGet('plik', 'trim')) != null && ($nowaNazwa = Zadanie::pobierzGet('nazwa', 'trim')) != null)
		{
			$sciezki = $this->MenedzerPlikow->zmienNazwe($plik, $nowaNazwa);
			if (is_array($sciezki))
			{
				$pliki_mapper = $this->dane()->PlikPrywatny();
				$plik = $pliki_mapper->pobierzPoUrl($this->prefixBaza.$sciezki['stara']);
				if ($plik instanceof PlikPrywatny\Obiekt)
				{
					$plik->url = $this->prefixBaza.$sciezki['nowa'];
					$plik->usun($pliki_mapper);
				}
			}
		}

		$this->wyswietl();
	}



	public function wykonajPrzenies()
	{
		$this->init();

		// Przenoszenie
		if (($zrodlo = Zadanie::pobierzGet('zrodlo', 'trim')) != null && ($cel = Zadanie::pobierzGet('cel', 'trim')) != null)
		{
			$sciezki = $this->MenedzerPlikow->przenies($zrodlo, $cel);
			if (is_array($sciezki))
			{
				$pliki_mapper = $this->dane()->PlikPrywatny();
				$plik = $pliki_mapper->pobierzPoUrl($this->prefixBaza.$sciezki['stara']);
				if ($plik instanceof PlikPrywatny\Obiekt)
				{
					$plik->url = $this->prefixBaza.$sciezki['nowa'];
					$plik->usun($pliki_mapper);
				}
			}
		}

		$this->wyswietl();
	}



	public function wykonajUprawnienia()
	{
		$PlikiUzytkownikMapper = $this->dane()->PlikPrywatnyUzytkownikPowiazanie();
		$PlikiRoleMapper = $this->dane()->PlikPrywatnyRolaPowiazanie();

		$urlPlik = Zadanie::pobierzGet('wybrany', 'trim');
		// Jeżeli nie ma wybranego pliku to sorry - wracamy do index
		if (trim($urlPlik) == '')
		{
			$this->komunikat($this->j->t['uprawnienia.blad_nieprawidlowa_sciezka'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('PlikiPrywatne','index'));
			exit;
		}
		$urlPlik = ltrim($urlPlik, '/');	//Wywalam pierwszy znak z racji tego że tu url zaczyna się od / a w bazie nie
		$wybranyPlik = $this->dane()->PlikPrywatny()->zwracaTablice()->pobierzPoUrl($this->prefixBaza.$urlPlik);

		// Jak wybranego pliku nie ma w bazie to sorry, wracamy do index
		if (!is_array($wybranyPlik))
		{
			$this->komunikat($this->j->t['uprawnienia.blad_nie_znaleziono_pliku'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('PlikiPrywatne','index'));
			exit;
		}

		/*
		 * wybranyPlikId to id pliku który wybraliśmy
		 * wybranyPlik to po prostu jego url
		 */
		$wybranyPlikId = $wybranyPlik['id'];

		$wszyscyUzytkownicy = $this->dane()->Uzytkownik()->zwracaTablice()->pobierzWszystko(null, new Uzytkownik\Sorter('nazwisko','asc'));
		$wszystkieRole = $this->dane()->Rola()->zwracaTablice()->pobierzWszystko();

		// Jeżeli nie znaleziono ról bądź użytkowników to sorry - wracamy do index
		if (count($wszyscyUzytkownicy) == 0 && count($wszystkieRole) == 0)
		{
			$this->komunikat($this->j->t['uprawnienia.blad_nie_znaleziono_rol_uzytkownikow'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('PlikiPrywatne','index'));
			exit;
		}
		foreach ($wszyscyUzytkownicy as $k => $w)
		{
			$nazwaFirmy = (isset($w['firma_nazwa'])) ? $w['firma_nazwa'] : '';
			$tab[$w['id']] = $w['nazwisko'].' '.$w['imie'].' '.$nazwaFirmy.' ('.$w['login'].')';
		}
		$wszyscyUzytkownicy = $tab;
		unset($tab);

		$wszystkieRole = listaZTablicy($wszystkieRole, 'id', 'nazwa');

		$obiektFormularza = new \Generic\Formularz\PlikPrywatny\Edycja();
		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('uprawnienia'))
			->ustawUrlPowrotny(Router::urlAdmin('PlikiPrywatne', 'index'))
			->ustawObiekt($wybranyPlik)
			->ustawWszyscyUzytkownicy($wszyscyUzytkownicy)
			->ustawWszystkieRole($wszystkieRole);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$wartosci = $obiektFormularza->pobierzWartosci();
			$uzytkownicy = $wartosci['uzytkownicy'];
			$role = $wartosci['role'];

			if (is_array($uzytkownicy))
			{
				$PlikiUzytkownikMapper->usunDlaPliku($wybranyPlikId);
				if (count($uzytkownicy) > 0)
				{
					foreach($uzytkownicy as $uzytkownikId)
					{
						$PlikiUzytkownik = new PlikPrywatnyUzytkownikPowiazanie\Obiekt();
						$PlikiUzytkownik->idProjektu = ID_PROJEKTU;
						$PlikiUzytkownik->idPliku = $wybranyPlikId;
						$PlikiUzytkownik->idUzytkownika = $uzytkownikId;
						$PlikiUzytkownik->zapisz($PlikiUzytkownikMapper);
					}
				}
			}

			if (is_array($role))
			{
				$PlikiRoleMapper->usunDlaPliku($wybranyPlikId);
				if (count($role) > 0)
				{
					foreach($role as $rolaId)
					{
						$PlikiRole = new PlikPrywatnyRolaPowiazanie\Obiekt();
						$PlikiRole->idProjektu = ID_PROJEKTU;
						$PlikiRole->idPliku = $wybranyPlikId;
						$PlikiRole->idRoli = $rolaId;
						$PlikiRole->zapisz($PlikiRoleMapper);
					}
				}
			}
			$this->komunikat($this->j->t['uprawnienia.info_zapisano_uprawnienia'], 'info', 'sesja');
			Router::przekierujDo(Router::urlAdmin('PlikiPrywatne','index'));
			exit;
		}
		$this->tresc .= $obiektFormularza->html();
	}



	protected function init()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$cms = Cms::inst();
		$nazwaUslugi = explode('\\',get_class($cms->usluga));
		$usluga = end($nazwaUslugi);

		$urlPlikow = ($usluga == 'Popup') ? Cms::inst()->url('private_temp') : Router::urlAdmin('PlikiPrywatne','uprawnienia',array('wybrany' => ''));

		$this->MenedzerPlikow = new MenedzerPlikow(Cms::inst()->katalog('private_temp'), $urlPlikow);
		
		$linki = array();

		if ($usluga == 'Popup')
		{
			$this->MenedzerPlikow->ustawTlumaczenia(array(
				'menedzer_plikow_kom_domyslny' => $this->j->t['index.komunikat_domyslny'],
			));

			$linki = array(
				'link_katalog' => Router::urlPopup('admin', 'PlikiPrywatne','index',array(
				//'link' => 'javascript:SetUrl({SCIEZKA});',
				//'link' => Router::urlPopup('admin', 'PlikiPrywatne','index',array(
					'sciezka' => '{SCIEZKA}',
				)),
				'link_nowy' => Router::urlPopup('admin', 'PlikiPrywatne','nowy',array(
					'sciezka' => '{SCIEZKA}',
				)),
				'link_upload' => Router::urlPopup('admin', 'PlikiPrywatne','upload',array(
					'sciezka' => '{SCIEZKA}',
				)),
				'link_usun' => Router::urlPopup('admin', 'PlikiPrywatne','usun',array(
					'sciezka' => '{SCIEZKA}',
					'usun' => '{USUN}',
				)),
				'link_zmienNazwe' => Router::urlPopup('admin', 'PlikiPrywatne','zmien',array(
					'sciezka' => '{SCIEZKA}',
					'plik' => '{PLIK}',
					'nazwa' => '{NAZWA}',
				)),
				'link_przenies' => Router::urlPopup('admin', 'PlikiPrywatne','przenies',array(
					'sciezka' => '{SCIEZKA}',
					'zrodlo' => '{ZRODLO}',
					'cel' => '{CEL}',
				)),
			);
		}
		elseif ($usluga == 'Admin')
		{
			$linki = array(
				'link_katalog' => Router::urlAdmin('PlikiPrywatne','index',array(
					'sciezka' => '{SCIEZKA}',
				)),
				'link_nowy' => Router::urlAdmin('PlikiPrywatne','nowy',array(
					'sciezka' => '{SCIEZKA}',
				)),
				'link_upload' => Router::urlAdmin('PlikiPrywatne','upload',array(
					'sciezka' => '{SCIEZKA}',
				)),
				'link_usun' => Router::urlAdmin('PlikiPrywatne','usun',array(
					'sciezka' => '{SCIEZKA}',
					'usun' => '{USUN}',
				)),
				'link_zmienNazwe' => Router::urlAdmin('PlikiPrywatne','zmien',array(
					'sciezka' => '{SCIEZKA}',
					'plik' => '{PLIK}',
					'nazwa' => '{NAZWA}',
				)),
				'link_przenies' => Router::urlAdmin('PlikiPrywatne','przenies',array(
					'sciezka' => '{SCIEZKA}',
					'zrodlo' => '{ZRODLO}',
					'cel' => '{CEL}',
				)),
			);
		}

		$config = array(
			'tworzenie_katalogow' => false,
			'upload' => $this->moznaWykonacAkcje('wykonajUpload'),
			'usuwanie' => $this->moznaWykonacAkcje('wykonajUsun'),
			'zmianaNazwy' => false,
			'przenoszenie' => false,
		);
		$ck_func = Zadanie::pobierzGet('CKEditorFuncNum', 'intval');
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
			$plikSzablonu = CMS_KATALOG . DIRECTORY_SEPARATOR . SZABLON_SYSTEM . DIRECTORY_SEPARATOR . 'szablon_manager_plikow.tpl';
			$plik = new \Generic\Biblioteka\Plik($plikSzablonu);
			$this->MenedzerPlikow->ustawSzablon($plikSzablonu, true);
		}

		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'menedzer_plikow' => $this->MenedzerPlikow->html(Zadanie::pobierzGet('sciezka','trim'), 99, false)
		));
	}

}

