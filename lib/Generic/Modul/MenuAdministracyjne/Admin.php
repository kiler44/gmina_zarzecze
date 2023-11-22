<?php
namespace Generic\Modul\MenuAdministracyjne;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Zadanie;


/**
 * Blok administracyjny odpowiedzialny za wyświetlanie menu administracyjnego.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\MenuAdministracyjne\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\MenuAdministracyjne\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{

		$modulyNowe = array(
			'pliki_menu' => array (
				'pliki_publiczne' => array('modul' => 'PlikiPubliczne', 'akcja' => 'index'),
				'pliki_prywatne' => array('modul' => 'PlikiPrywatne', 'akcja' => 'index'),
				'edytor_graficzny' => array('modul' => 'EdytorGraficzny', 'akcja' => 'index'),
				),
			'aplikacje_menu' => array(
				'testy' => array('modul' => 'Testy', 'akcja' => 'index'),
				'zadania_cykliczne' => array('modul' => 'ZadaniaCykliczne', 'akcja' => 'index'),
				'mailing' => array('modul' => 'Mailing', 'akcja' => 'index'),
				),
			'zarzadzanie_menu' => array(
				'zarzadzanie_kategoriami' => array('modul' => 'KategorieZarzadzanie', 'akcja' => 'index'),
				'zarzadzanie_widokami' => array('modul' => 'WidokiZarzadzanie', 'akcja' => 'index'),
			),
			'ustawienia_menu' => array(
				'konfiguracja_systemu' => array('modul' => 'KonfiguracjaSystemu', 'akcja' => 'index'),
				'ustawienia_jezykowe' => array('modul' => 'UstawieniaJezykowe', 'akcja' => 'index'),
				),
			'system_menu' => array(
				'logowanie_operacji' => array('modul' => 'LogowanieOperacji', 'akcja' => 'index'),
				'zarzadzanie_modulami' => array('modul' => 'ModulyZarzadzanie', 'akcja' => 'index'),
				'zarzadzanie_projektami' => array('modul' => 'ProjektyZarzadzanie', 'akcja' => 'index'),
				'zarzadzanie_cache' => array('modul' => 'CacheZarzadzanie', 'akcja' => 'index'),
				'routing' => array('modul' => 'Routing', 'akcja' => 'index'),
				'zarzadzanie_email' => array('modul' => 'EmailZarzadzanie', 'akcja' => 'index'),
			),
			'uzytkownicy_menu' => array(
				'zarzadzanie_uzytkownikami' => array('modul' => 'UzytkownicyZarzadzanie', 'akcja' => 'index'),
				'zarzadzanie_uprawnieniami' => array('modul' => 'UprawnieniaZarzadzanie', 'akcja' => 'index'),
				),
			/*
			'konto_uzytkownika_menu' => array(
				'konto_uzytkownika' => array('modul' => 'UserAccount', 'akcja' => 'index'),
				),
			*/
		);

		$ikony = array (
			//'strona_glowna' => '/_system/admin/ikony/menu/glowna.png',
			'pliki_menu' => 'icon-file',
			'aplikacje_menu' => 'icon-beaker',
			'zarzadzanie_menu' => 'icon-sitemap',
			'ustawienia_menu' => 'icon-wrench',
			'system_menu' => 'icon-cogs',
			'uzytkownicy_menu' => 'icon-group',
			'konto_uzytkownika_menu' => 'icon-user',
			'konto_uzytkownika' => 'icon-user',

			'pliki_publiczne' => 'icon-file',
			'pliki_prywatne' => 'icon-lock',
			'edytor_graficzny' => 'icon-picture',

			'testy' => 'icon-magic',
			'zadania_cykliczne' => 'icon-time',
			'mailing' => 'icon-envelope-alt',

			'zarzadzanie_kategoriami' => 'icon-sitemap',
			'zarzadzanie_widokami' => 'icon-eye-open',

			'konfiguracja_systemu' => 'icon-wrench',
			'ustawienia_jezykowe' => 'icon-flag',

			'logowanie_operacji' => 'icon-twitter',
			'zarzadzanie_modulami' => 'icon-th-large',
			'zarzadzanie_projektami' => 'icon-star',
			'zarzadzanie_cache' => 'icon-dashboard',
			'zarzadzanie_email' => 'icon-envelope',
			'routing' => 'icon-link',

			'zarzadzanie_uzytkownikami' => 'icon-group',
			'zarzadzanie_uprawnieniami' => 'icon-key',
		);

		$cms = Cms::inst();
		$uzytkownik = $cms->profil();
		
		$projektObiekt = new \Generic\Model\Projekt\Obiekt();
		
		$jezykiProjektu = [];
		foreach ($projektObiekt->jezyki as $jezyk)
		{
			$jezykiProjektu[$jezyk->kod] = $jezyk->nazwa;
		}
		
// ================== Tutaj początek drzewa kategorii

		$aktualneIdkategorii = Zadanie::pobierz('cat', 'intval', 'abs');
		$mapper = $this->dane()->Kategoria();
		$kategorie = $mapper->pobierzWszystko();
		
		$drzewo = '';
		$ilosc_kategorii = count($kategorie);
		
		if (is_array($kategorie) && $ilosc_kategorii > 0)
		{
			// sprawdzanie wyswietlania dla zablokanych uzytkownikow
			$licznik_wierszy = 0;
		
			$drzewo .= $this->szablon->parsujBlok('/drzewo', array(
				'link_glowna' => Router::urlAdmin($this->dane()->Kategoria()->pobierzStartowaAdmin(), 'index'),
			));
			
			$drzewo .= $this->szablon->parsujBlok('/drzewo/listaStart');

			$poziom = null;
            $rodzicId = null;
			foreach ($kategorie as $kategoria)
			{
				/**
				 * @var $kategoria \Generic\Model\Kategoria\Obiekt
				 */
				
				if ($kategoria->blokada || !$kategoria->czyWidoczna || $kategoria->poziom < 2){
                    continue;
                }

				$klasa_wiersza = ($licznik_wierszy % 2) ? 'nieparzysty' : 'parzysty';
				$licznik_wierszy ++;
				
				switch ($kategoria->typ)
				{
					case 'kategoria':
						$url = Router::urlAdmin($kategoria);
						break;
					case 'link_zewnetrzny':
						$url = $kategoria->adresZewnetrzny;
						break;
					default:
						$url = '';
						break;
				}
	
				// niekomplatne kategrie
				if ($kategoria->kodModulu == '') $url = '';
	
				// obsluga uprawnien
				$kodUprawnienia = 'Admin_'.$kategoria->id.'_wykonajIndex';
		
				if ( ! $cms->profil()->maUprawnieniaDo($kodUprawnienia)) $url = '';
	
				if ($url != '')
				{
				    $ukryj = false;
                    if($poziom != null && $kategoria->poziom > $poziom  )
                        $ukryj = true;
                    else
                    {
                        $rodzicId = null;
                        $poziom = null;
                    }


					$drzewo .= $this->szablon->parsujBlok('/drzewo/element', array(
                        'kategoria_id' => $kategoria->id,
					    'rodzic_id' => $rodzicId,
					    'ukryj' => $ukryj,
					    'poziom' => $kategoria->poziom,
						'klasa' => $klasa_wiersza,
						'url' => htmlspecialchars($url),
						'nazwa' => $kategoria->nazwa,
						'nazwaPelna' => (isset($kategoria->nazwaPrzyjazna[KOD_JEZYKA_ITERFEJSU]) && $kategoria->nazwaPrzyjazna[KOD_JEZYKA_ITERFEJSU] != '') ? $kategoria->nazwaPrzyjazna[KOD_JEZYKA_ITERFEJSU] : $kategoria->nazwa,
						'ikona' => ($kategoria->ikona != '') ? $kategoria->ikona : '',
						'aktywny' => ($aktualneIdkategorii == $kategoria->id) ? true : false,
					));
				}
				else
                {
                    $drzewo .= $this->szablon->parsujBlok('/drzewo/elementRozwijalny', array(
                        'kategoria_id' => $kategoria->id,
                        'poziom' => $kategoria->poziom,
                        'klasa' => $klasa_wiersza,
                        'nazwa' => $kategoria->nazwa,
                        'nazwaPelna' => (isset($kategoria->nazwaPrzyjazna[KOD_JEZYKA_ITERFEJSU]) && $kategoria->nazwaPrzyjazna[KOD_JEZYKA_ITERFEJSU] != '') ? $kategoria->nazwaPrzyjazna[KOD_JEZYKA_ITERFEJSU] : $kategoria->nazwa,
                        'ikona' => ($kategoria->ikona != '') ? $kategoria->ikona : '',
                        'aktywny' => ($aktualneIdkategorii == $kategoria->id) ? true : false,
                    ));
                    $poziom = $kategoria->poziom;
                    $rodzicId = $kategoria->id;
                }
			}
			$drzewo .= $this->szablon->parsujBlok('/drzewo/listaStop');
			unset($kategorie);
		}
		//dump($drzewo);
		 
		
// ================== Tutaj koniec drzewa kategorii
		
		
		$this->szablon->ustawBlok('/index', array(
			//'czas_sesji' => ($cms->config['sesja']['czasZyciaSesji'] > 0) ? $cms->config['sesja']['czasZyciaSesji'] : -1,
			'etykieta_styl' => $this->j->t['index.etykieta_styl'],
			'menu_zwykle' => (czyMobilnyKlient()) ? '' : $drzewo,
		));

		$kategoriaKontoUzytkownika = $this->dane()->Kategoria()->pobierzDlaModulu('KontoUzytkownika');
		
		//wykasowanie elementów tablicy, do których nie mamy uprawnień
		foreach ($modulyNowe as $opis2 => $modul2)
		{
			foreach ($modul2 as $opis => $modul)
			{
				$kod = $modul['modul'].'_'."wykonaj".ucfirst($modul['akcja']);
				if ( ! $uzytkownik->maUprawnieniaDo($kod) && $modul['modul'] != '')
				{
					unset($modulyNowe[$opis2][$opis]);
				}
			}
		}

		$aktualnyModul = Zadanie::pobierz('modul', 'addslashes', 'strip_tags');

		foreach ($modulyNowe as $opis2 => $modul2)
		{
			if (count($modul2) == 0)
			{
				continue;
			}

			if (count($modul2) == 1)
			{
				foreach ($modul2 as $opis => $modul)
				{
					if ($modul['modul'] != '')
					{
						$this->szablon->ustawBlok('/index/menu_nowe/elementPojedynczy', array(
							'link_url' => htmlspecialchars(Router::urlAdmin($modul['modul'], $modul['akcja'])),
							'link_etykieta' => $this->j->t['index.etykieta_'.$opis],
							'ikona' => $ikony[$opis],
							'aktywny' => $aktualnyModul == $modul['modul'],
						));
					}
					else
					{
						$this->szablon->ustawBlok('/index/menu_nowe/elementPojedynczy', array(
							'link_url' => '/',
							'link_etykieta' => $this->j->t['index.etykieta_'.$opis],
							'ikona' => $ikony[$opis],
							'aktywny' => $aktualnyModul == $modul['modul'],
						));
					}
				}
			}
			else
			{
				$aktywneMenu = false;
				foreach ($modul2 as $modul)
				{
					if ($aktualnyModul == $modul['modul'])
					{
						$aktywneMenu = true;
						break;
					}
				}

				$this->szablon->ustawBlok('/index/menu_nowe/element', array(
					'link_url' => '#',
					'link_etykieta' => $this->j->t['index.etykieta_'.$opis2],
					'ikona' => $ikony[$opis2],
					'aktywny' => $aktywneMenu,
				));
				foreach ($modul2 as $opis => $modul)
				{
					$this->szablon->ustawBlok('/index/menu_nowe/element/subElement', array(
						'link_url' => htmlspecialchars(Router::urlAdmin($modul['modul'], $modul['akcja'])),
						'link_etykieta' => $this->j->t['index.etykieta_'.$opis],
						'ikona' => $ikony[$opis],
						'aktywny' => $aktualnyModul == $modul['modul'],
					));
				}
			}
		}
		$this->szablon->ustawGlobalne(array(
			'jestAdminem' => (count(array_filter($modulyNowe)) > 4) ? 1 : 0,
		));

		$this->tresc .= $this->szablon->parsujBlok('index');
	}



	/**
	 *  Przeciazona metoda z klasy Modul. Zwraca true bo zawsze chcemy wyswietlac ten blok
	 *
	 * @param string $metoda Nazwa wywolywanej akcji (tekst albo null).
	 *
	 * @return bool True.
	 */
	protected function moznaWykonacAkcje($metoda, $wlasnyKod = false, $obiektKontekstu = null)
	{
		return true;
	}

}
