<?php
namespace Generic\Modul\Aktualnosci;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Plik\MultiUpload;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Pager;
use Generic\Model\Aktualnosc;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Grafika;
use Generic\Biblioteka\Plik;
use Generic\Model\Galeria;
use Generic\Model\Zalacznik;


/**
 * Moduł odpowiedzialny za zarządzanie aktualnościami
 *
 * @author Marcin Mucha
 * @package moduly
 */

class Admin extends Modul\Admin
{

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajUsun',
		'wykonajUsunZdjecie',
		'wykonajPoprawMiniaturke',
        'wykonajZapiszPlik',
        'wykonajUsunPlik'
	);


	/**
	 * @var \Generic\Konfiguracja\Modul\Aktualnosci\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Aktualnosci\Admin
	 */
	protected $j;


	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$formularzObiekt = new \Generic\Formularz\Aktualnosc\Wyszukiwanie();
		$formularzObiekt->ustawTlumaczenia($this->pobierzBlokTlumaczen('index'));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('tytul', $this->j->t['index.etykieta_tytul'], 0, Router::urlAdmin($this->kategoria, 'edytuj', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('data_dodania', $this->j->t['index.etykieta_data_dodania'], 150);
		$grid->dodajKolumne('autor', $this->j->t['index.etykieta_autor'], 250);
		$grid->dodajKolumne('publikuj', $this->j->t['index.etykieta_publikuj'], 100);

		$grid->naglowek($formularzObiekt->zwrocFormularz()->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

		$grid->dodajPrzyciski(
			Router::urlAdmin($this->kategoria, '{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array('edytuj','usun')
		);

		$kryteria = array();
		$kryteria['id_kategorii'] = $this->kategoria->id;
		$kryteria = array_merge($kryteria, $formularzObiekt->pobierzZmienioneWartosci());

		$ilosc = $this->dane()->Aktualnosc()->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'desc', true, array('strval'));

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
			$grid->pager($pager->html(Router::urlAdmin($this->kategoria, '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			$sorter = new Aktualnosc\Sorter($kolumna, $kierunek);
			$grid->ustawSortownie(array('data_dodania', 'tytul'), $kolumna, $kierunek,
				Router::urlAdmin($this->kategoria, '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			foreach ($this->dane()->Aktualnosc()
						->zwracaTablice(array('id', 'data_dodania', 'tytul', 'autor', 'publikuj'))
						->szukaj($kryteria, $pager, $sorter) as $aktualnosc)
			{
				$aktualnosc['publikuj'] = $this->j->t['publikuj_statusy'][$aktualnosc['publikuj']];
				$grid->dodajWiersz($aktualnosc);
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('/index', array(
			'tabela_danych' => $grid->html(),
			'link_dodaj' => Router::urlAdmin($this->kategoria, 'dodaj'),
		));
	}

	public function wykonajDodaj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));

		$aktualnosc = new Aktualnosc\Obiekt();

		$this->tresc .= $this->szablon->parsujBlok('dodaj', array(
			'form' => $this->formularz($aktualnosc),
		));
	}

	public function wykonajEdytuj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

		$mapper = $this->dane()->Aktualnosc();
		$aktualnosc = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));

		if ($aktualnosc instanceof Aktualnosc\Obiekt)
		{
			$this->tresc .= $this->szablon->parsujBlok('dodaj', array(
				'form' => $this->formularz($aktualnosc),
			));
		}
		else
		{
			$this->komunikat($this->j->t['edytuj.blad_nie_mozna_pobrac_aktualnosci'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
		}
	}



	public function wykonajUsun()
	{
		$ids = (array)Zadanie::pobierz('id', 'intval');
		$mapper = $this->dane()->Aktualnosc();

		foreach ($ids as $id)
		{
			if ($id < 1) continue;

			$aktualnosc = $mapper->pobierzPoId($id);

			if ($aktualnosc instanceof Aktualnosc\Obiekt)
			{
				$katalog = new Katalog(Cms::inst()->katalog('aktualnosci', $aktualnosc->id));

				if (( ! $katalog->istnieje() || $katalog->usun()) && $aktualnosc->usun($mapper))
				{
					$this->komunikat($this->j->t['usun.info_usunieto_aktualnosc'], 'info', 'sesja');
				}
				else
				{
					$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_aktualnosci'], 'error', 'sesja');
				}
			}
			else
			{
				$this->komunikat($this->j->t['usun.blad_nie_mozna_pobrac_aktualnosci'], 'error', 'sesja');
			}
		}
		Router::przekierujDo(Router::urlAdmin($this->kategoria));
	}



	public function wykonajUsunZdjecie()
	{
		$mapper = $this->dane()->Aktualnosc();
		$aktualnosc = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));

		if ($aktualnosc instanceof Aktualnosc\Obiekt)
		{
			$katalog = new Katalog(Cms::inst()->katalog('aktualnosci', $aktualnosc->id));

			if ( ! $katalog->istnieje() || $katalog->usun())
			{
				$aktualnosc->zdjecieGlowne = null;
				$aktualnosc->zapisz($mapper);
				$this->komunikat($this->j->t['usunZdjecie.info_usunieto_zdjecie'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usunZdjecie.blad_nie_mozna_usunac_zdjecia'], 'error', 'sesja');
			}
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'edytuj', array('id' => $aktualnosc->id)));
		}
		else
		{
			$this->komunikat($this->j->t['usunZdjecie.blad_nie_mozna_pobrac_aktualnosci'], 'error');
		}
	}



	public function wykonajPoprawMiniaturke()
	{
		$mapper = $this->dane()->Aktualnosc();
		$aktualnosc = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));

		if (!($aktualnosc instanceof Aktualnosc\Obiekt))
		{
			$this->komunikat($this->j->t['poprawMiniaturke.blad_nie_mozna_pobrac_aktualnosci'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria));
			return;
		}

		$kod = Zadanie::pobierz('kod', 'strval', 'trim');
		$gora = Zadanie::pobierz('y1', 'trim', 'floatval');
		$lewa = Zadanie::pobierz('x1', 'trim', 'floatval');
		$dol = Zadanie::pobierz('y2', 'trim', 'floatval');
		$prawa = Zadanie::pobierz('x2', 'trim', 'floatval');

		if (!isset($this->k->k['rozmiary_miniaturek'][$kod]))
		{
			$this->komunikat($this->j->t['poprawMiniaturke.blad_nieprawidlowy_kod_miniaturki'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'edytuj', array('id' => $aktualnosc->id)));
			return;
		}

		$dane = explode('.',$this->k->k['rozmiary_miniaturek'][$kod]);
		$katalog = $aktualnosc->pobierzKatalog();

		$grafika = new Grafika(new Grafika\IMagic());
		$grafika->wczytaj($katalog.$this->k->k['formularz.prefix_zdjecia'].'-'.$aktualnosc->zdjecieGlowne);

		if ($grafika->skalujUtnij($dane[0], $dane[1], $gora, $lewa, $dol, $prawa)
			&& $grafika->zapisz($katalog.$kod.'-'.$aktualnosc->zdjecieGlowne))
		{
			$this->komunikat($this->j->t['poprawMiniaturke.info_poprawiono_miniaturke'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['poprawMiniaturke.blad_nie_mozna_poprawic_miniaturki'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin($this->kategoria, 'edytuj', array('id' => $aktualnosc->id)));
	}

    public function wykonajZapiszPlik()
    {
        $token = Zadanie::pobierz('token', 'trim');
        $id = Zadanie::pobierz('id', 'trim', 'intval');

        $upload = new Plik\MultiUpload($token);
        $plik = $upload->zapiszPlik($id, 'zalaczniki');

        $return = $upload->pobierzWynikUploadu();

        if (!$wynikSkanowania = $plik->skanuj(true) && $return['success'] == true)
            $return['success'] = false;

        $return['wynikSkanowania'] = $wynikSkanowania;
        $katalog = new Katalog(TEMP_KATALOG . '/public/trash/' . $token, true);

        echo json_encode($return);
        die;
    }

    public function wykonajUsunPlik()
    {
        $ids = Zadanie::pobierz('ids', 'trim', 'strtolower');
        $token = Zadanie::pobierz('token', 'trim');

        $ids = explode(',', $ids);

        foreach ($ids as $key => $val) {
            if ($val < 1) unset($ids[$key]);
        }

        if (is_array($ids) && count($ids) > 0 && !empty($ids)) {
            $mapper = new Zalacznik\Mapper();

            $zalaczniki = $mapper->szukaj(array(
                'status' => 'active',
                'id' => $ids,
            ));

            foreach ($zalaczniki as $zalacznik) {
                $zalacznik->status = 'delete';
                $zalacznik->zapisz($mapper);
                unset($ids[$zalacznik->id]);
            }
            $result = multiuploadUsunPlikiTemp($ids, $token);
        } else {
            $result['success'] = true;
        }

        echo json_encode($result);
        die;
    }

	private function formularz(Aktualnosc\Obiekt $aktualnosc)
	{

        $katalog = $aktualnosc->pobierzKatalog();
        if (!$katalog->doZapisu())
        {
            $this->komunikat($this->j->t['formularz.blad_katalog_niedostepny'], 'warning');
        }

		if ($aktualnosc->id < 1) // Domyślne ustawienia dla nowo tworzonej aktualności
		{
			$aktualnosc->publikuj = 1;
			$aktualnosc->dataDodania = date("Y-m-d H:i:s");
		}
        $plikiUzytkownika = [];

		$galerie = $this->dane()->Galeria()
			->zwracaTablice(array('id', 'nazwa'))
			->szukaj(array(), null, new Galeria\Sorter('nazwa', 'asc'));

		$lista = listaZTablicy($galerie, 'id', 'nazwa');

		$obiektFormularza = new \Generic\Formularz\Aktualnosc\Edycja();

		$obiektFormularza->ustawKatalog($katalog)
			->ustawKonfiguracje($this->k->pobierzKonfiguracje())
			->ustawTlumaczenia($this->j->pobierzBlokTlumaczen('formularz'))
			->ustawObiekt($aktualnosc)
			->ustawListeGalerii($lista)
			->ustawKategorieLinkow($this->kategoria);

		if ($obiektFormularza->wypelniony())
		{
			if ($obiektFormularza->danePoprawne())
			{
                $wartosci = $obiektFormularza->pobierzWartosci();

				foreach($wartosci as $klucz => $wartosc)
				{
					if ($klucz == 'zdjecieGlowne')
					{
						$zdjecieGlowne = $wartosc;
						continue;
					}
					if($klucz == 'zalaczniki')
                    {
                        $multiUpload = new MultiUpload($wartosci['zalaczniki']['token']);
                        $katalogDocelowy = new \Generic\Biblioteka\Katalog($aktualnosc->pobierzKatalog());

                        $plikiUzytkownika = $multiUpload->przeniesPliki(
                            listaZTablicy($wartosci['zalaczniki']['pliki'], null, 'nazwa'),
                            $wartosci['zalaczniki']['pliki'], $katalogDocelowy, 1);

                        continue;
                    }
					$aktualnosc->$klucz = $wartosc;
				}

				if ($aktualnosc->dataWaznosci == '') $aktualnosc->dataWaznosci = null;

				if(count($plikiUzytkownika))
                {
                    foreach($plikiUzytkownika as $plik)
                    {
                        $zalacznikPlik = new Plik($katalogDocelowy.'/'.$plik['nazwa']);

                        $zalacznik = new Zalacznik\Obiekt();
                        $zalacznik->file = $plik['nazwa'];
                        $zalacznik->dateAdded = new \DateTime();
                        $zalacznik->rozmiar = $plik['rozmiar'];
                        $zalacznik->type = $zalacznikPlik->getMimeType();

                        $aktualnosc->dodajZalacznik($zalacznik);
                    }
                }
				$this->zapiszAktualnosc($aktualnosc, $zdjecieGlowne);
				Router::przekierujDo(Router::urlAdmin($this->kategoria, 'edytuj', ['id' => $aktualnosc->id]));
			}
		}
		else
		{
			$obiektFormularza->ustawWartosciDomyslneObiektu();
		}
		return $obiektFormularza->zwrocFormularz()->html();
	}



	protected function zapiszAktualnosc($aktualnosc, $zdjecieGlowne)
	{
		$cms = Cms::inst();

		if ($aktualnosc->id > 0)
		{
			$info = $this->j->t['edytuj.info_aktualnosc_zapisana'];
			$blad = $this->j->t['edytuj.blad_nie_mozna_zapisac_aktualnosci'];
		}
		else
		{
			$info = $this->j->t['dodaj.info_aktualnosc_zapisana'];
			$blad = $this->j->t['dodaj.blad_nie_mozna_zapisac_aktualnosci'];

			$aktualnosc->idUzytkownika = $cms->profil()->id;
			$aktualnosc->idProjektu = ID_PROJEKTU;
			$aktualnosc->kodJezyka = KOD_JEZYKA;
			$aktualnosc->idKategorii = $this->kategoria->id;
		}
		if ($aktualnosc->autor == '')
		{
			$aktualnosc->autor = $cms->profil()->pelnaNazwa;
		}

		$mapper = $this->dane()->Aktualnosc();
		if ($aktualnosc->zapisz($mapper))
		{
			$this->komunikat($info, 'info', 'sesja');
		}
		else
		{
			$this->komunikat($blad, 'error', 'sesja');
		}

		if (is_array($zdjecieGlowne) && isset($zdjecieGlowne['error']) && $zdjecieGlowne['error'] === UPLOAD_ERR_OK)
		{
			$katalog = Cms::inst()->katalog('aktualnosci', $aktualnosc->id);
			$k = new Katalog($katalog, true);

			$nazwa_pliku = Plik::unifikujNazwe($zdjecieGlowne['name']);
			$zdjecie = new Plik\Zdjecie($zdjecieGlowne['tmp_name']);
			$zdjecie->przeniesDo($katalog.$nazwa_pliku);

			foreach ($this->k->k['rozmiary_miniaturek'] as $prefix => $kod)
			{
				$zdjecie->tworzMiniaturke($katalog.$prefix.'-'.$nazwa_pliku, $kod);
			}
			$zdjecie->usun();

			$aktualnosc->zdjecieGlowne = $nazwa_pliku;
			$aktualnosc->zapisz($mapper);
		}
	}

}
