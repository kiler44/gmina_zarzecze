<?php
namespace Generic\Modul\Galeria;
use Generic\Biblioteka\Input\MultiUploadZdjec;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Plik\MultiUpload;
use Generic\Biblioteka\Sterownik;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Pager;
use Generic\Model\Galeria;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Plik;
use Generic\Model\GaleriaZdjecie;
use Generic\Model\Zalacznik\Obiekt;


/**
 * Modul odpowiadajacy za zarządzanie galeriami i zdjęciami.
 *
 * @author Lukasz Wrucha
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\Galeria\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Galeria\Admin
	 */
	protected $j;

	protected $urlZdjec;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajUsun',
		'wykonajUsunZdjecie',
		'wykonajUpload',
		'wykonajZapiszPlik',
		'wykonajUsunPlik',
	);

	public function wykonajIndex()
	{
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['index.tytul_strony'],
            'tytul_modulu' => $this->j->t['index.tytul_strony'].' '.$this->kategoria->nazwa,
        ));

		$obiektFormularza = new \Generic\Formularz\Galeria\Wyszukiwanie();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('index'));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['index.etykieta_nazwa'], 0, Router::urlAdmin($this->kategoria, 'edytuj', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('data_dodania', $this->j->t['index.etykieta_data_dodania'], 150);
		$grid->dodajKolumne('autor', $this->j->t['index.etykieta_autor'], 250);
		$grid->dodajKolumne('publikuj', $this->j->t['index.etykieta_publikuj'], 100);

		$grid->naglowek($obiektFormularza->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

		$grid->dodajPrzyciski(
			Router::urlAdmin($this->kategoria, '{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array('edytuj','usun')
		);

		$kryteria = array_merge(array(), $obiektFormularza->pobierzZmienioneWartosci());
        $kryteria['id_kategorii'] = $this->kategoria->id;

		$mapper = $this->dane()->Galeria();
		$ilosc = $mapper->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

			$pager = new Pager\Html($mapper->iloscWszystko(), $naStronie, $nrStrony);
			$sorter = new Galeria\Sorter($kolumna, $kierunek);

            $pager->ustawKonfiguracje(20);
            $grid->pager($pager->html(Router::urlAdmin($this->kategoria, 'index', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			$grid->ustawSortownie(array('nazwa', 'data_dodania', 'autor'), $kolumna, $kierunek,
				Router::urlAdmin($this->kategoria, '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			foreach($mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter) as $galeria)
			{
				$galeria['publikuj'] = $this->j->t['galeria.publikacja'][$galeria['publikuj']];

				$grid->dodajWiersz($galeria);
			}
		}

		$this->szablon->ustawBlok('/index', array(
				'tabela_danych' => $grid->html(),
				'link_dodaj' => Router::urlAdmin($this->kategoria, 'dodaj'),
		));
		$this->tresc .= $this->szablon->parsujBlok('index');
	}



	public function wykonajDodaj()
	{
		$cms = Cms::inst();
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));

		$galeria = new Galeria\Obiekt();
		$galeria->katalog = '';
		$galeria->idKategorii = $this->kategoria->id;

		$dane['form'] = $this->formularz($galeria);

		$this->tresc .= $this->szablon->parsujBlok('dodaj', $dane);
	}

	public function wykonajEdytuj()
	{
		$cms = Cms::inst();

		$mapper = $this->dane()->Galeria();
		$galeria = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval','abs'));
		if ($galeria instanceof Galeria\Obiekt)
		{
			$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony'].$galeria->nazwa));
			$dane['form'] = $this->formularz($galeria);
			$this->tresc .= $this->szablon->parsujBlok('dodaj', $dane);
		}
		else
		{
			$this->komunikat($this->j->t['edytuj.blad_brak_galerii'], 'error');
			$this->wykonajIndex();
		}
	}



	public function wykonajUsun()
	{
		$ids = (array)Zadanie::pobierz('id', 'intval','abs');
		$mapper = $this->dane()->Galeria();

		foreach ($ids as $id)
		{
			if ($id < 1) continue;

			$galeria = $mapper->pobierzPoId($id);
			if ($galeria instanceof Galeria\Obiekt)
			{
				$katalog = new Katalog(Cms::inst()->katalog('galeria', $id));

				if (( ! $katalog->istnieje() || $katalog->usun()) && $galeria->usun($mapper))
				{
					$this->komunikat($this->j->t['usun.info_galeria_usunieta'], 'info', 'sesja');
				}
				else
				{
					$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_galerii'], 'error', 'sesja');
				}
			}
			else
			{
				$this->komunikat($this->j->t['usun.blad_brak_galerii'],'error', 'sesja');
			}
		}
		Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
	}



	public function wykonajUsunZdjecie()
	{
		$baza = Cms::inst()->Baza();
		$glowne = Zadanie::pobierz('glowne');

        $id = Zadanie::pobierz('id', 'intval','abs');
        $galeria_mapper = $this->dane()->Galeria();

        $galeria_zmien = false;

        $baza->transakcjaStart();
        $galeria_zmien = true;

        if($glowne)
        {
            $galeria = $this->dane()->Galeria()->pobierzPoId($id);
            if($galeria instanceof Galeria\Obiekt)
            {
                $id_galerii = $id;
                $nazwa_pliku = $galeria->zdjecieGlowne;
                $galeria->zdjecieGlowne = '';
                if ($galeria->zapisz($galeria_mapper)) $zdjecie_usun = true;
            }
        }
        else
        {
            $mapper = new GaleriaZdjecie\Mapper();
            $zdjecie = $mapper->pobierzPoId($id);
            if ($zdjecie instanceof GaleriaZdjecie\Obiekt) {
                $nazwa_pliku = $zdjecie->nazwaPliku;
                $id_galerii = $zdjecie->idGalerii;

                $galeria = $galeria_mapper->pobierzPoId($id_galerii);

                if ($galeria->zdjecieGlowne == $nazwa_pliku) {
                    $galeria->zdjecieGlowne = '';
                    $galeria_zmien = $galeria->zapisz($galeria_mapper);
                }
            }
            else
            {
                $this->komunikat($this->j->t['usun.blad_brak_zdjecia'],'error', 'sesja');
            }
        }

        if($nazwa_pliku != '')
        {
            $doUsuniecia = 0;
            $usuniete = 0;
            foreach ($this->k->k['upload.miniaturki_kody'] as $prefix => $kod)
            {
                $doUsuniecia++;
                $nazwa_pliku_do_usuniecia = ($prefix == '') ? $nazwa_pliku : $prefix.'-'.$nazwa_pliku;

                $plik = new Plik(Cms::inst()->katalog('galeria', $id_galerii).$nazwa_pliku_do_usuniecia);

                if ( ! $plik->istnieje() || $plik->usun()) $usuniete++;
            }

            if ($doUsuniecia != $usuniete)
            {
                $this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_plikow_zdjecia'], 'warning', 'sesja');
            }

            if ($galeria_zmien && $zdjecie_usun)
            {
                $baza->transakcjaPotwierdz();
                $this->komunikat($this->j->t['usun.info_usunieto_zdjecie'], 'info', 'sesja');
            }
            else
            {
                $baza->transakcjaCofnij();
                $this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_zdjecia'], 'error', 'sesja');
            }
        }


		Router::przekierujDo(Router::urlAdmin($this->kategoria, 'edytuj', array('id' => $id_galerii)));
	}



	public function wykonajUpload()
	{
		if (!isset($_FILES['Filedata'])) return;
		if ($_FILES['Filedata']['error'] !== UPLOAD_ERR_OK) return;

		$id_galerii = Zadanie::pobierzPost('id_galerii', 'intval', 'abs');
		if ($id_galerii < 1) return;

		$galerieMapper = $this->dane()->Galeria();
		$galeria = $galerieMapper->pobierzPoId($id_galerii);
		if (!($galeria instanceof Galeria\Obiekt)) return;

		$katalog = new Katalog(Cms::inst()->katalog('galeria', $id_galerii), true);

		$nazwa = Plik::unifikujNazwe($_FILES['Filedata']['name']);

		$licznik = 1;
		while (file_exists($katalog.'/'.$nazwa))
		{
			$czesci = explode('.', $nazwa);
			$ilosc_czesci = count($czesci);
			$rozszerzenie = $czesci[($ilosc_czesci-1)];
			$nazwa = '';
			for($i = 0; $i < ($ilosc_czesci - 1); $i++)
			{
				$nazwa .= $czesci[$i];
			}
			$nazwa = substr($nazwa, 0, -1).'_'.$licznik.'.'.$rozszerzenie;
			$licznik++;
		}

		move_uploaded_file($_FILES['Filedata']['tmp_name'], $katalog.$nazwa);

		$zdjecie = new Plik\Zdjecie($katalog.'/'.$nazwa);
		$zdjecieKopia = $zdjecie->kopiujDo($katalog.'/kopia_'.$nazwa);

		$miniaturki = array();
		foreach ($this->k->k['upload.miniaturki_kody'] as $prefix => $kod)
		{
			$prefix = ($prefix == '') ? null : $prefix.'-';
			$miniaturki[] = $zdjecieKopia->tworzMiniaturke($katalog.$prefix.$nazwa, $kod);
		}

		$mapper = new GaleriaZdjecie\Mapper();
		$galeria_zdjecie = new GaleriaZdjecie\Obiekt;

		$galeria_zdjecie->idGalerii = $id_galerii;
		$galeria_zdjecie->nazwaPliku = $nazwa;
		$galeria_zdjecie->idProjektu = ID_PROJEKTU;
		$galeria_zdjecie->kodJezyka = KOD_JEZYKA;
		$galeria_zdjecie->dataDodania = date("Y-m-d H:i:s");

		if ($galeria_zdjecie->zapisz($mapper))
		{
			echo $nazwa;
		}
	}



	private function formularz(Galeria\Obiekt $galeria)
	{
		$obiektFormularza = new \Generic\Formularz\Galeria\Edycja();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawObiekt($galeria)
			->ustawKategorieLinkow($this->kategoria)
			->ustawKonfiguracje(array_merge(array(
			    'wymagane_pola' => $this->k->k['formularz.wymagane_pola'],
                'urlZalacznikow' => Cms::inst()->url('galeria' ,$galeria->id),
                'kody_miniatur' => $rozmiaryMiniatur = $this->k->k['upload.miniaturki_kody'],

                ), $this->pobierzKonfiguracje()));

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
			$this->zapiszGalerie($galeria, $obiektFormularza->pobierzWartosci());

		return $obiektFormularza->html();
	}



	protected function zapiszGalerie(Galeria\Obiekt $galeria, $wartosci = array())
	{
        $plikiUzytkownika = [];
	    if(isset($wartosci['zdjecia']['token']))
        {
            $rozmiaryMiniatur = $this->k->k['upload.miniaturki_kody'];
            $multiUpload = new MultiUpload($wartosci['zdjecia']['token']);
            $katalogDocelowy = new \Generic\Biblioteka\Katalog(Cms::inst()->katalog('galeria', $galeria->id), true);

            $plikiUzytkownika = $multiUpload->przeniesZdjecia($wartosci['zdjecia']['pliki'], $katalogDocelowy, $rozmiaryMiniatur);

        }
	    
        foreach ($wartosci as $klucz => $wartosc)
        {
            if ($klucz == 'zdjecieGlowne')
            {
                $zdjecieGlowne = $wartosc;
                continue;
            }
            $galeria->$klucz = $wartosc;
        }

		if ($galeria->id > 0)
		{
		    if(count($plikiUzytkownika))
            {
                foreach ($plikiUzytkownika as $plik) {

                    if($plik['kod'])
                        $galeria->dodajZdjecie($plik['kod'], $plik['opis']);
                    else
                        $galeria->aktualizujOpisZdjecia($plik['zdjecie_id'], $plik['opis']);
                }
            }
			$trescKomunikatu = $this->j->t['formularz.info_zapisano_galerie'];
			$przekierujUrl = Router::urlAdmin($this->kategoria, 'index');
		}
		else
		{
			$trescKomunikatu = $this->j->t['formularz.info_dodano_galerie'];
			$przekierujUrl = Router::urlAdmin($this->kategoria, 'edytuj', array('id' => '{ID_GALERII}'));

			if ($galeria->publikuj == '') $galeria->publikuj = 0;

			$galeria->dataDodania = new \DateTime();
			$galeria->idProjektu = ID_PROJEKTU;
			$galeria->kodJezyka = KOD_JEZYKA;
		}

		$mapper = $this->dane()->Galeria();
		if ($galeria->zapisz($mapper))
		{
            if (is_array($zdjecieGlowne) && isset($zdjecieGlowne['error']) && $zdjecieGlowne['error'] === UPLOAD_ERR_OK)
            {
                $katalog = Cms::inst()->katalog('galeria', $galeria->id);
                $k = new Katalog($katalog, true);

                $nazwa_pliku = Plik::unifikujNazwe($zdjecieGlowne['name']);

                $zdjecie = new Plik\Zdjecie($zdjecieGlowne['tmp_name']);
                $zdjecie->przeniesDo($katalog.$nazwa_pliku);

                $prefixJest = true;

                foreach ($this->k->k['upload.miniaturki_kody'] as $prefix => $kod)
                {
                    if ($prefix == '')
                    {
                        $prefixJest = false;
                        $zdjecie->tworzMiniaturke($katalog.$nazwa_pliku, $kod);
                    }
                    else {
                        $zdjecie->tworzMiniaturke($katalog.$prefix.'-'.$nazwa_pliku, $kod);
                    }
                }

                if ($prefixJest) $zdjecie->usun();

                $galeria->zdjecieGlowne = $nazwa_pliku;
                $galeria->zapisz($mapper);
            }
			$this->komunikat($trescKomunikatu, 'info', 'sesja');
			Router::przekierujDo(str_replace('{ID_GALERII}', $galeria->id, $przekierujUrl));
		}
		else
		{
			$this->komunikat($this->j->t['formularz.blad_nie_mozna_zapisac_galerii'], 'error');
		}
	}

    public function wykonajZapiszPlik()
    {
        $token = Zadanie::pobierz('token', 'trim');
        $id = Zadanie::pobierz('id', 'trim', 'intval');

        $rozmiaryMiniatur = $this->k->k['upload.miniaturki_kody'];

        $upload = new Plik\MultiUpload($token);
        $plik = $upload->zapiszZdjecie($id, $rozmiaryMiniatur, 'zdjecia');

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
            $mapper = new GaleriaZdjecie\Mapper();

            $zalaczniki = $mapper->szukaj(array(
                'id' => $ids,
            ));
            if (empty($zalaczniki))
            {
                $idGalerii = $zalaczniki[0]->idGalerii;
                $galeria = $this->dane()->Galeria()->pobierzPoId($idGalerii);
            }
            /**
             * @var GaleriaZdjecie\Obiekt $zalacznik
             */
            foreach ($zalaczniki as $zalacznik) {
                if($zalacznik->nazwaPliku != '' && $galeria->zdjecieGlowne != $zalacznik->nazwaPliku)
                {
                    $doUsuniecia = 0;
                    $usuniete = 0;
                    foreach ($this->k->k['upload.miniaturki_kody'] as $prefix => $kod)
                    {
                        $doUsuniecia++;
                        $nazwa_pliku_do_usuniecia = ($prefix == '') ? $zalacznik->nazwaPliku : $prefix.'-'.$zalacznik->nazwaPliku;

                        $plik = new Plik(Cms::inst()->katalog('galeria', $zalacznik->idGalerii).$nazwa_pliku_do_usuniecia);

                        if ( ! $plik->istnieje() || $plik->usun()) $usuniete++;
                    }

                    if ($doUsuniecia != $usuniete)
                    {
                        $this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_plikow_zdjecia'], 'warning', 'sesja');
                    }
                }
                $zalacznik->usun($mapper);

                unset($ids[$zalacznik->id]);
            }
            $result = multiuploadUsunPlikiTemp($ids, $token);
        } else {
            $result['success'] = true;
        }

        echo json_encode($result);
        die;
    }

}

