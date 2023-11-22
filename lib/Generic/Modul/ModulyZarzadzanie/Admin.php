<?php
namespace Generic\Modul\ModulyZarzadzanie;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\Mapper;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Zadanie;


/**
 * Modul administracyjny informujacy o modułach dostepnych w cms-ie oraz konfiguracji php.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\ModulyZarzadzanie\Admin
	 */
	protected $k;


	/**
	 * opisy ustawien konfiguracyjnych
	 * @var array
	 */
	protected $opisKonfiguracji = array(
		'index.wierszy_na_stronie' => array(
			'opis' => 'Ilość wierszy na stronie w liście modułów',
			'typ' => 'int',
			'maks' => 100,
		),
		'index.domyslne_sortowanie' => array(
			'typ' => 'select',
			'dozwolone' => array('kod', 'nazwa'),
		),

		'szablon.formularz_wyszukiwarka' => array(
			'typ' => 'varchar',
			'opis' => '',
		),
	);



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\ModulyZarzadzanie\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajPodglad',

	);



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('kod', '', null, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['index.etykieta_nazwa'], null, Router::urlAdmin('ModulyZarzadzanie','podglad',array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('typ', $this->j->t['index.etykieta_typ'], 200);

		$grid->dodajPrzyciski(
			Router::urlAdmin('ModulyZarzadzanie','{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array('podglad')
		);

		$kryteria = $this->formularzWyszukiwania($grid);

		$mapper = DostepnyModul\Mapper::wywolaj(Mapper::ZWRACA_TABLICE);
		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

			$sorter = new DostepnyModul\Sorter($kolumna, $kierunek);
			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);

			$grid->ustawSortownie(array('nazwa','typ'), $kolumna, $kierunek,
				Router::urlAdmin('ModulyZarzadzanie', '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			$grid->pager($pager->html(Router::urlAdmin('ModulyZarzadzanie', '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			foreach($mapper->szukaj($kryteria, $pager, $sorter) as $modul)
			{
				$modul['typ'] = $this->j->t['index.modul_typy'][$modul['typ']];
				$grid->dodajWiersz($modul);
			}
		}
		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'grid' => $grid->html(),
		));
	}



	public function wykonajPodglad()
	{
		$mapper = DostepnyModul\Mapper::wywolaj();
		$modul = $mapper->pobierzPoKodzie(Zadanie::pobierzGet('kod', 'strval'));
		if ($modul instanceof DostepnyModul\Obiekt)
		{
			$this->ustawGlobalne(array('tytul_strony' => $this->j->t['podglad.tytul_strony']));

			$dane['kod'] = $modul->kod;
			$dane['nazwa'] = $modul->nazwa;
			$dane['opis'] = $modul->opis;
			$dane['typ'] = $this->j->t['index.modul_typy'][$modul->typ];
			$dane['uslugi'] = implode(', ', $modul->uslugi);
			$dane['dla_zalogowanych'] = ($modul->dlaZalogowanych) ? $this->j->t['podglad.etykieta_tak'] : $this->j->t['podglad.etykieta_nie'];
			$dane['cache'] = ($modul->cache) ? $this->j->t['podglad.etykieta_tak'] : $this->j->t['podglad.etykieta_nie'];

			if (count($modul->wymagane) > 0)
			{
				foreach ($modul->wymagane as $kod)
				{
					$wymagany = $mapper->pobierzPoKodzie($kod);
					$this->szablon->ustawBlok('/podglad/wymagane', array(
						'nazwa' => $wymagany->nazwa,
						'kod' => $wymagany->kod,
					));
				}
			}
			$projekty = $this->dane()->Projekt();
			$projekty = $projekty->pobierzZawierajaceModul($modul->kod);
			if (is_array($projekty) && count($projekty) > 0)
			{
				foreach ($projekty as $projekt)
				{
					$this->szablon->ustawBlok('/podglad/projekty', array(
						'nazwa' => $projekt->nazwa,
						'domena' => $projekt->domena,
					));
				}
			}
			$this->tresc .= $this->szablon->parsujBlok('podglad', $dane);
		}
		else
		{
			$this->komunikat($this->j->t['podglad.blad_brak_modulu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('ModulyZarzadzanie', 'index'));
		}
	}



	private function formularzWyszukiwania(TabelaDanych $grid)
	{
		$obiektFormularza = new \Generic\Formularz\Modul\Wyszukiwanie();
		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('index'));

		$grid->naglowek($obiektFormularza->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

		$kryteria = array_merge(array(), $obiektFormularza->pobierzZmienioneWartosci());

		return $kryteria;
	}
}