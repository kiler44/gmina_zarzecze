<?php
namespace Generic\Modul\Produkty;
use Generic\Biblioteka\Modul;
use Generic\Model\KategorieMagazyn;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Cms;
use Generic\Formularz\Magazyn\EdycjaProduktuMagazyn;
use Generic\Model\ProduktyMagazyn;
use Generic\Model\Uzytkownik;
use Generic\Model\MagazynWydane;
use Generic\Model\MagazynWydaneProdukty;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Katalog;
use Generic\Model\Zalacznik;
use Generic\Biblioteka\Pomocnik\Poczta;
use Generic\Model\MagazynPrzyja;
use Generic\Model\MagazynPrzyjeteProdukty;
use Generic\Model\Kamienie;

class Admin extends Modul\Admin
{

    protected $uprawnienia = array(
        'wykonajIndex',
        'wykonajDrzewoKategorii',
        'wykonajDodaj',
        'wykonajSortowanie',
        'wykonajEdytuj',
        'wykonajUsun',
        'wykonajMagazyn',
        'wykonajPobierzWynikiSzukaj',
        'wykonajProduktyLista',
        'wykonajProduktyDodaj',
        'wykonajDodajDoZamowienia',
        'wykonajPobierzZawartoscKoszyka',
        'wykonajUsunProduktZKoszyka',
        'wykonajEdytujProduktZKoszyka',
        'wykonajFinalizujZamowienie',
        'wykonajKartaZamowienia',
        'wykonajCzyscKoszyk',
        'wykonajAnulujZamowienie',
        'wykonajUsunZdjecie',
        'wykonajDrukujPdf',
        'wykonajUstawZaakceptowane',
        'wykonajZestawienieOdbiorcy',
        'wykonajSzukajProduktowSelectAjax',
        'wykonajZapiszPlik',
        'wykonajUsunPlik',
        'wykonajPodgladProduktu',
        'wykonajWidokPracownika',
        'wykonajMojeZamowienia',
        'wykonajMojeProdukty',
        'wykonajZamowNowyProdukt',
        'wykonajZwrocProdukty',
        'wykonajZatwierdzZwrotProduktow',
        'wykonajPrzyjmijTowar',
        'wykonajDrukujKartaZwrotuPdf',
        'wykonajKartaZwrotuProduktow',
        'wykonajFormularzDodajProdukt',
        'wykonajUstawJakoNaprawiony',
        'wykonajListaPrzyjec',
        'wykonajListaKamieni',
        'wykonajDodajKamien',
    );

    protected $kategorieGlowne = array(
        'produkty',
    );

    /**
     * @var \Generic\Konfiguracja\Modul\Klienci\Admin
     */
    protected $k;

    /**
     * @var \Generic\Tlumaczenie\Pl\Modul\Klienci\Admin
     */
    protected $j;

    public function inicjuj(Biblioteka\Sterownik $sterownik, \Generic\Model\Kategoria\Obiekt $kategoria = null, \Generic\Model\Blok\Obiekt $blok = null)
    {
        parent::inicjuj($sterownik, $kategoria, $blok);
        if(klientMobilny())
            $this->tresc .= $this->szablon->parsujBlok('/klientMobilny', array());
    }

    public function wykonajDodajKamien()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['dodajKamien.tytul_strony'],
            'tytul_modulu' => $this->j->t['dodajKamien.tytul_modulu'],
        ));

        $id = Zadanie::pobierz('id');
        $usun = Zadanie::pobierz('usun');
        $typ = Zadanie::pobierz('typ');

        $mapperKamienie = $this->dane()->Kamienie();
        if ($id > 0)
        {
            $kamien = $mapperKamienie->pobierzPoId($id);
            if($usun){ $kamien->usun($mapperKamienie); Router::przekierujDo(Router::urlAdmin($this->kategoria, 'dodajKamien', array('typ' => $typ))); }
        }
        else
            $kamien = new Kamienie\Obiekt();


        $formularz = new Formularz('', 'dodajKamien');
        $formularz->otworzRegion('dane_podstawowe');
        $formularz->input(new Input\Text('nazwa', array('wymagany' => true, 'wartosc' => $kamien->nazwa)));
        $formularz->input(new Input\Hidden('typ', $typ));
        $formularz->stopka(new Input\Submit('zapisz', array('atrybuty' => array('class' => 'btn btn-primary'))));
        $formularz->zamknijRegion('dane_podstawowe');
        $formularz->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzKamien'));

        if($formularz->wypelniony())
        {
            if($formularz->danePoprawne())
            {
                $wartosci = $formularz->pobierzWartosci();

                $kamien->nazwa = $wartosci['nazwa'];
                $kamien->typ = $wartosci['typ'];
                if($kamien->id > 0)
                {
                    $kamien->zapisz($mapperKamienie);
                    $this->komunikat('Edycja przebiegła pomyślnie', 'info', 'modul');
                }
                else
                {
                    $kamien->zapisz($mapperKamienie);
                    $this->komunikat('Dane zapisane poprawnie', 'info');
                }

                Router::przekierujDo(Router::urlAdmin($this->kategoria, 'dodajKamien', array('typ' => $typ)) );

            }
            else
                $this->komunikat('Nie wszystkie pola zostały poprawnie wypełnione', 'error');
        }

        $this->tresc .= $this->szablon->parsujBlok('/dodajKamien', array(
            'form' => $formularz->html(),
            'grid' => $this->gridKamienie($typ)->html(),
            'zakladki' => $this->ustawZakladki('kamienie'),
        ));
    }

    private function gridKamienie($typ)
    {
        $mapperKamienie = $this->dane()->Kamienie();

        $grid = new TabelaDanych();
        $grid->dodajKolumne('id', $this->j->t['index.id'], '', '', true);
        $grid->dodajKolumne('nazwa', $this->j->t['kamienie.nazwa']);

        $przyciski = array(
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'dodajKamien', array('{KLUCZ}' => '{WARTOSC}', 'typ' => $typ)),
                'ikona' => 'icon-pencil',
                'etykieta' => $this->j->t['dodajKamien.edytuj'],
                'target' => '_self',
                'klucz' => 'edycja',
            ),
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'dodajKamien', array('{KLUCZ}' => '{WARTOSC}', 'usun' => 1, 'typ' => $typ) ),
                'ikona' => 'icon-minus',
                'etykieta' => $this->j->t['dodajKamien.usun'],
                'target' => '_self',
                'klucz' => 'usun',
            ),
        );

        $kryteria = array('typ' => $typ);
        $ilosc = $mapperKamienie->iloscSzukaj($kryteria);

        if($ilosc > 0)
        {
            $grid->dodajPrzyciski(
                Router::urlAdmin($this->kategoria,'{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')) , $przyciski
            );

            $naStronie = $this->pobierzParametr('naStronie', $this->k->k['kamienie.wierszy_na_stronie'], true, array('intval','abs'));
            $nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
            $kolumna = $this->pobierzParametr('kolumna', $this->k->k['kamienie.domyslne_sortowanie'], true, array('strval'));
            $kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

            $sorter = new Kamienie\Sorter($kolumna, $kierunek);
            $grid->ustawSortownie(array('id', 'nazwa'), $kolumna, $kierunek,
                Router::urlAdmin($this->kategoria, 'dodajKamien', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}', 'typ' => $typ))
            );

            $pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['kamienie.pager_konfiguracja']);
            $grid->pager($pager->html(Router::urlAdmin($this->kategoria, 'dodajKamien', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}', 'typ' => $typ))));

            $pobraneWiersze =  $mapperKamienie->zwracaTablice('id', 'nazwa')->szukaj($kryteria, $pager, $sorter);

            foreach($pobraneWiersze as $wiersz)
            {
                $grid->dodajWiersz($wiersz);
            }
        }

        return $grid;
    }

    public function wykonajIndex()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['index.tytul_strony'],
            'tytul_modulu' => $this->j->t['index.tytul_modulu'],
        ));

        /*
        $kryteria = array();
        $form = $this->formularzSzukaj();
        $kryteriaSzukaj = $form->pobierzWartosci();

        $kryteria['osobaWydajaca'] = Cms::inst()->profil()->id;
        if(isset($kryteriaSzukaj['tylkoMoje']) && $kryteriaSzukaj['tylkoMoje'] == 0)
            unset($kryteria['osobaWydajaca']);

        $kryteria = array_merge($kryteria, $kryteriaSzukaj);

        $grid = new TabelaDanych();
        $grid->dodajKolumne('id', $this->j->t['index.id'], '', '', true);
        $grid->dodajKolumne('id_odbiorcy', $this->j->t['index.odbiorca'], '', Router::urlAdmin($this->kategoria,'kartaZamowienia', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('id_osoby_wydajacej', $this->j->t['index.id_osoby_wydajacej']);
        $grid->dodajKolumne('status', $this->j->t['index.status']);
        $grid->dodajKolumne('data_dodania', $this->j->t['index.data_dodania']);
        $grid->dodajKolumne('data_wydania', $this->j->t['index.data_wydania']);
        $grid->dodajKolumne('opis', $this->j->t['index.opis'], '', Router::urlAdmin($this->kategoria,'kartaZamowienia', array('{KLUCZ}' => '{WARTOSC}')));

        $przyciski = array(
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'kartaZamowienia', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-search',
                'etykieta' => $this->j->t['index.kartaZamowieniaPodglad'],
                'target' => '_self',
                'klucz' => 'podglad',
            ),
            array(
                'akcja' => Router::urlAjax('admin', $this->kategoria, 'anulujZamowienie', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-remove',
                'etykieta' => $this->j->t['index.anulujZamowienieEtykieta'],
                'klucz' => 'anuluj',
                'onclick' => 'anulujZamowienie(this); return false;',
            ),
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'magazyn', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-pencil',
                'etykieta' => $this->j->t['index.edytujZamowienieEtykieta'],
                'target' => '_self',
                'klucz' => 'edytuj',
            ),
            array(
                'akcja' => Router::urlAjax('admin', $this->kategoria, 'ustawZaakceptowane', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-ok-sign',
                'etykieta' => $this->j->t['index.ustawZaakceptowaneEtykieta'],
                'target' => '_self',
                'klucz' => 'ustawZaakceptowane',
                'onclick' => 'zaakceptujZamowienie(this); return false;',
            ),
            array(
                'akcja' =>  Router::urlAjax('admin', $this->kategoria, 'drukujPdf', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-file',
                'etykieta' => $this->j->t['index.podgladPdf'],
                'target' => '_self',
                'klucz' => 'podgladPdf',
                'onclick' => 'modalIFrame(this); return false;',
            ),
        );

        $status = Zadanie::pobierz('status', 'strval', 'filtr_xss');
        if($status == '')
            $status = $this->k->k['index.domyslny_status'];

        if($status != 'wszystkie' && $status != '')
            $kryteria = array_merge($kryteria, ['status' => $status]);

        $mapper = $this->dane()->MagazynWydane();
        $ilosc = $mapper->iloscSzukaj($kryteria);

        if($ilosc > 0)
        {
            $grid->dodajPrzyciski(
                Router::urlAdmin($this->kategoria,'{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),$przyciski
            );

            $naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
            $nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
            $kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
            $kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

            $sorter = new MagazynWydane\Sorter($kolumna, $kierunek);
            $grid->ustawSortownie(array('id', 'data_dodania'), $kolumna, $kierunek,
                Router::urlAdmin($this->kategoria, 'index', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}', 'status' => $status))
            );

            $pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
            $grid->pager($pager->html(Router::urlAdmin($this->kategoria, 'index', array('status' => $status, 'nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

            $pobraneWiersze = $mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter);

            $idUzytkownikow = array();
            $idTeamow = array();
            $idOsobWydajacych = array();
            foreach($pobraneWiersze as $wiersz)
            {
                ($wiersz['obiekt_odbiorcy'] == 'Uzytkownik') ? array_push($idUzytkownikow, $wiersz['id_odbiorcy']) : array_push($idTeamow, $wiersz['id_odbiorcy']);
                array_push($idOsobWydajacych, $wiersz['id_osoby_wydajacej']);
            }

            if(count($idUzytkownikow))
                $odbiorcyUzytkownk = listaZTablicy($this->dane()->Uzytkownik()->zwracaTablice()->szukaj(array('wiele_id' => $idUzytkownikow)), 'id');
            if(count($idTeamow))
                $odbiorcyTeamy = listaZTablicy($this->dane()->Team()->zwracaTablice()->szukaj(array('wiele_id' => $idTeamow)), 'id');
            if(count($idOsobWydajacych))
                $osobyWydajace = listaZTablicy($this->dane()->Uzytkownik()->zwracaTablice()->szukaj(array('wiele_id' => array_filter($idOsobWydajacych))), 'id');

            foreach($pobraneWiersze as $wiersz)
            {
                if($wiersz['status'] == 'anulowane' || $wiersz['status'] == 'wydane')
                    $grid->usunPrzyciski(array('edytuj', 'anuluj', 'ustawZaakceptowane'));
                if($wiersz['status'] == 'zaakceptowane')
                    $grid->usunPrzyciski(array('ustawZaakceptowane'));

                $wiersz['data_wydania'] = ($wiersz['data_wydania'] != '') ? $wiersz['data_wydania'] : '...';
                $wiersz['id_osoby_wydajacej'] = (isset($osobyWydajace[$wiersz['id_osoby_wydajacej']])) ? $osobyWydajace[$wiersz['id_osoby_wydajacej']]['imie'].' '.$osobyWydajace[$wiersz['id_osoby_wydajacej']]['nazwisko'] : '' ;
                $wiersz['id_odbiorcy'] = ($wiersz['obiekt_odbiorcy'] == 'Uzytkownik') ? $odbiorcyUzytkownk[$wiersz['id_odbiorcy']]['imie'].' '.$odbiorcyUzytkownk[$wiersz['id_odbiorcy']]['nazwisko'] : $odbiorcyTeamy[$wiersz['id_odbiorcy']]['team_number'];
                $wiersz['status'] = $this->j->t['index.status_'.$wiersz['status']];
                $grid->dodajWiersz($wiersz);
            }
        }


        $this->tresc .= $this->szablon->parsujBlok('index', array(
            'zakladki' => $this->ustawZakladki('index'),
            'status' => ($status != '') ? $status : 'wszystkie',
            'grid' => $grid->html(),
            'etykieta_oczujace' => $this->j->t['index.status_oczekuje'],
            'etykieta_zaakceptowane' => $this->j->t['index.status_zaakceptowane'],
            'etykieta_wydane' => $this->j->t['index.status_wydane'],
            'etykieta_anulowane' => $this->j->t['index.status_anulowane'],
            'etykieta_wszystkie' => $this->j->t['index.wszystkie'],
            'link_oczekujace' => Router::urlAdmin($this->kategoria, 'index', array('status' => 'oczekuje')),
            'link_anulowane' => Router::urlAdmin($this->kategoria, 'index', array('status' => 'anulowane')),
            'link_zaakceptowane' => Router::urlAdmin($this->kategoria, 'index', array('status' => 'zaakceptowane')),
            'link_wydane' => Router::urlAdmin($this->kategoria, 'index', array('status' => 'wydane')),
            'link_wszystkie' => Router::urlAdmin($this->kategoria, 'index', array('status' => 'wszystkie')),
            'etykieta_filtr_po_statusie' => $this->j->t['index.filtr_po_statusie_etykieta'],
            'form' => $form->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true),
        ));
        */
        $this->tresc .= $this->szablon->parsujBlok('indexKamienie', array( 'zakladki' => $this->ustawZakladki('index'), ));
    }

    public function wykonajListaPrzyjec()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['listaPrzyjec.tytul_strony'],
            'tytul_modulu' => $this->j->t['listaPrzyjec.tytul_modulu'],
        ));

        $kryteria = array();
        $form = $this->formularzSzukaj(false,false,true);
        $kryteriaSzukaj = $form->pobierzWartosci();

        if(isset($kryteriaSzukaj['odbiorcaUzytkownik']) && $kryteriaSzukaj['odbiorcaUzytkownik']) $kryteria['oddajacyUzytkownik'] = $kryteriaSzukaj['odbiorcaUzytkownik'];
        if(isset($kryteriaSzukaj['odbiorcaTeam']) && $kryteriaSzukaj['odbiorcaTeam']) $kryteria['oddajacyTeam'] = $kryteriaSzukaj['odbiorcaTeam'];
        if(isset($kryteriaSzukaj['przyjete']) && $kryteriaSzukaj['przyjete']) $kryteria['przyjecie'] = true;

        $grid = new TabelaDanych();
        $grid->dodajKolumne('id', $this->j->t['listaPrzyjec.id'], '', '', true);
        $grid->dodajKolumne('data_dodania', $this->j->t['listaPrzyjec.data_dodania']);
        $grid->dodajKolumne('id_przyjmujacego', $this->j->t['listaPrzyjec.id_przyjmujacego']);
        $grid->dodajKolumne('id_oddajacego', $this->j->t['listaPrzyjec.id_oddajacego']);

        $przyciski = array(
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'kartaZwrotuProduktow', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-search',
                'etykieta' => $this->j->t['listaPrzyjec.podglad'],
                'target' => '_self',
                'klucz' => 'podglad',
            ),
        );

        $mapper = $this->dane()->MagazynPrzyja();
        $ilosc = $mapper->iloscSzukaj(array());

        if($ilosc > 0)
        {
            $grid->dodajPrzyciski(
                Router::urlAdmin($this->kategoria,'{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),$przyciski
            );

            $naStronie = $this->pobierzParametr('naStronie', $this->k->k['listaPrzyjec.wierszy_na_stronie'], true, array('intval','abs'));
            $nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
            $kolumna = $this->pobierzParametr('kolumna', $this->k->k['listaPrzyjec.domyslne_sortowanie'], true, array('strval'));
            $kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

            $sorter = new MagazynPrzyja\Sorter($kolumna, $kierunek);
            $grid->ustawSortownie(array('id', 'data_dodania'), $kolumna, $kierunek,
                Router::urlAdmin($this->kategoria, 'listaPrzyjec', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
            );

            $pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
            $grid->pager($pager->html(Router::urlAdmin($this->kategoria, 'listaPrzyjec', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

            $pobraneWiersze = $mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter);

            $idUzytkownikow = array();
            $idTeamow = array();
            $idOsobPrzyjmujacych = array();
            foreach($pobraneWiersze as $wiersz)
            {
                if($wiersz['obiekt_oddajacy'] == 'Uzytkownik') array_push($idUzytkownikow, $wiersz['id_oddajacego']);
                if($wiersz['obiekt_oddajacy'] == 'Team') array_push($idTeamow, $wiersz['id_oddajacego']);
                array_push($idOsobPrzyjmujacych, $wiersz['id_przyjmujacego']);
            }

            if(count($idUzytkownikow))
                $odbiorcyUzytkownk = listaZTablicy($this->dane()->Uzytkownik()->zwracaTablice()->szukaj(array('wiele_id' => $idUzytkownikow)), 'id');
            if(count($idTeamow))
                $odbiorcyTeamy = listaZTablicy($this->dane()->Team()->zwracaTablice()->szukaj(array('wiele_id' => $idTeamow)), 'id');
            if(count($idOsobPrzyjmujacych))
                $idOsobPrzyjmujacych = listaZTablicy($this->dane()->Uzytkownik()->zwracaTablice()->szukaj(array('wiele_id' => array_filter($idOsobPrzyjmujacych))), 'id');


            foreach($pobraneWiersze as $wiersz)
            {
                $wiersz['id_przyjmujacego'] = (isset($idOsobPrzyjmujacych[$wiersz['id_przyjmujacego']])) ? $idOsobPrzyjmujacych[$wiersz['id_przyjmujacego']]['imie'].' '.$idOsobPrzyjmujacych[$wiersz['id_przyjmujacego']]['nazwisko'] : '...' ;
                if($wiersz['obiekt_oddajacy'] == 'Uzytkownik')
                {
                    $wiersz['id_oddajacego'] = $odbiorcyUzytkownk[$wiersz['id_oddajacego']]['imie'].' '.$odbiorcyUzytkownk[$wiersz['id_oddajacego']]['nazwisko'];
                }
                else if($wiersz['obiekt_oddajacy'] == 'Team')
                {
                    $wiersz['id_oddajacego'] = $odbiorcyTeamy[$wiersz['id_oddajacego']]['team_number'];
                }
                else
                {
                    $grid->zmienAkcjePrzycisk('podglad', Router::urlAdmin($this->kategoria, 'kartaZwrotuProduktow', array('id' => $wiersz['id'], 'przyjecie' => 1)));
                    $wiersz['id_oddajacego'] = '...';
                }
                $grid->dodajWiersz($wiersz);
            }

        }

        $this->tresc .= $this->szablon->parsujBlok('listaPrzyjec', array(
            'zakladki' => $this->ustawZakladki('listaPrzyjec'),
            'grid' => $grid->html(),
            'form' => $form->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true),
        ));
    }

    private function formularzSzukaj($wyswietlajFraza = true, $wyswietlajTylkoMoje = true, $wyswietlajPrzyjecie = false)
    {
        $form = new Formularz('', 'wyszukiwanieKlientow', 'multipart/form-data', 'post', true, true);
        $form->input(new Input\Czysc('czysc'));
        $form->input(new Input\Submit('szukaj'));
        $form->input($this->pobierzInputSelect($this->pobierzPracownikow(), 'id', array('imie', 'nazwisko'), 'odbiorcaUzytkownik'));
        $form->input($this->pobierzInputSelect($this->pobierzTeamy(), 'id', array('team_number'), 'odbiorcaTeam'));

        if($wyswietlajFraza)
            $form->input(new Input\Text('fraza'));
        if($wyswietlajTylkoMoje)
            $form->input(new Input\Checkbox('tylkoMoje', array()))->ustawWartosc(true);
        if($wyswietlajPrzyjecie)
            $form->input(new Input\Checkbox('przyjete', array()))->ustawWartosc(false);

        $form->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzSzukaj'));

        if (Zadanie::pobierz('czysc', 'trim') != '') $form->resetuj();

        return $form;
    }

    public function wykonajUstawZaakceptowane()
    {
        $id = Zadanie::pobierz('id', 'intval', 'abs');
        $dane['success'] = false;
        $dane['kod'] = 1;
        $dane['id'] = $id;
        $blad = 0;

        if($id)
        {
            $mapper = $this->dane()->MagazynWydane();
            $zamowienie = $mapper->pobierzPoId($id);

            if($zamowienie instanceof MagazynWydane\Obiekt)
            {
                $zamowienie->status = 'zaakceptowane';
                $this->wyslijEmailZamowienieZaakceptowane($zamowienie);

                $dane['statusZamowienia'] = $this->j->t['index.status_'.$zamowienie->status];

                if($zamowienie->zapisz($mapper))
                    $dane['success'] = true;
                else
                    $blad++;
            }
            else
                $blad++;
        }
        else
            $blad++;

        if($blad)
            $dane['error'] = $this->j->t['ustawZaakceptowane.blad'];

        echo json_encode($dane);
        die;

    }

    public function wykonajAnulujZamowienie()
    {
        $id = Zadanie::pobierz('id', 'intval', 'abs');
        $dane['success'] = false;
        $dane['kod'] = 1;
        $dane['id'] = $id;
        $blad = 0;

        if($id)
        {
            Cms::inst()->Baza()->transakcjaStart();

            $mapper = $this->dane()->MagazynWydane();
            $zamowienie = $mapper->pobierzPoId($id);
            if($zamowienie instanceof MagazynWydane\Obiekt)
            {
                $zamowienie->status = 'anulowane';
                if($zamowienie->zapisz($mapper))
                {
                    foreach ($zamowienie->pobierzProdukty() as $produkt)
                        (!$this->korygujIloscProduktow($produkt['id'], $produkt['ilosc'], 'dodaj')) ? $blad++ : '';

                }
                else
                    $blad++;

                if($blad)
                    Cms::inst()->baza()->transakcjaCofnij();
                else
                {
                    Cms::inst()->baza()->transakcjaPotwierdz();
                    $dane['success'] = true;
                }
            }
            else
                $blad++;
        }
        else
            $blad++;

        if($blad)
            $dane['error'] = $this->j->t['anulujZamowienie.blad'];
        else
            $dane['statusZamowienia'] = $this->j->t['index.status_'.$zamowienie->status];

        echo json_encode($dane);
        die;
    }

    private function wyslijEmailZamowienieAnulowane(MagazynWydane\Obiekt $zamowienie)
    {
        $cms = Cms::inst();

        $osobaAnulujaca = $cms->dane()->Uzytkownik()->pobierzPoId($cms->profil()->id);
        $osobaZamawiajaca = $cms->dane()->Uzytkownik()->pobierzPoId($zamowienie->idOdbiorcy);

        foreach($zamowienie->pobierzProdukty() as $produkt )
        {
            $listaProduktow['produkt'][] = array(
                'nazwa' => $produkt['nazwa_produktu'],
                'ilosc' => $produkt['ilosc'],
            );
        }

        $dane = array(
            'obiekt_Pracownik' => $osobaAnulujaca,
            'obiekt_Uzytkownik' => $osobaZamawiajaca,
            'dataZamowienia' => $zamowienie->dataDodania,
            'listaProduktow' => $listaProduktow,
        );
        $poczta = new Poczta($this->k->k['wyslijEmailZamowienieAnulowane.id_email_anulowane'], $dane);
        $poczta->wyslij();
    }

    private function wyslijEmailZamowienieZaakceptowane(MagazynWydane\Obiekt $zamowienie)
    {
        $cms = Cms::inst();

        $osobaAkceptujaca = $cms->dane()->Uzytkownik()->pobierzPoId($cms->profil()->id);
        $osobaZamawiajaca = $cms->dane()->Uzytkownik()->pobierzPoId($zamowienie->idOdbiorcy);

        foreach($zamowienie->pobierzProdukty() as $produkt )
        {
            $listaProduktow['produkt'][] = array(
                'nazwa' => $produkt['nazwa_produktu'],
                'ilosc' => $produkt['ilosc'],
            );
        }

        $dane = array(
            'obiekt_Pracownik' => $osobaAkceptujaca,
            'obiekt_Uzytkownik' => $osobaZamawiajaca,
            'dataZamowienia' => $zamowienie->dataDodania->format('Y-m-d H:i'),
            'listaProduktow' => $listaProduktow,
        );
        $poczta = new Poczta($this->k->k['wyslijEmailZamowienieZaakceptowane.id_email_zaakceptowane'], $dane);
        $poczta->wyslij();
    }

    private function wyslijEmailZamowienieDoOdbioru(MagazynWydane\Obiekt $zamowienie)
    {
        $cms = Cms::inst();

        $osobaAkceptujaca = $cms->dane()->Uzytkownik()->pobierzPoId($cms->profil()->id);
        $osobaZamawiajaca = $cms->dane()->Uzytkownik()->pobierzPoId($zamowienie->idOdbiorcy);

        foreach($zamowienie->pobierzProdukty() as $produkt )
        {
            $listaProduktow['produkt'][] = array(
                'nazwa' => $produkt['nazwa_produktu'],
                'ilosc' => $produkt['ilosc'],
            );
        }

        $dane = array(
            'obiekt_Pracownik' => $osobaAkceptujaca,
            'obiekt_Uzytkownik' => $osobaZamawiajaca,
            'dataZamowienia' => $zamowienie->dataDodania,
            'listaProduktow' => $listaProduktow,
        );
        $poczta = new Poczta($this->k->k['wyslijEmailZamowienieDoOdbioru.id_email_zamowienie_do_odbioru'], $dane);
        $poczta->wyslij();
    }

    /**
     * Metoda przechowuje strukture zakładek
     * @return type
     */
    private function ustawZakladki($aktywna = 'magazyn')
    {
        $zakladki = array(
            'index' => array(
                'nazwa' => $this->j->t['zakladki.index'],
                'akcja' => 'index',
                'ikona' => 'icon-list',
            ),
            /*
            'listaPrzyjec' => array(
                'nazwa' => $this->j->t['zakladki.listaPrzyjec'],
                'akcja' => 'listaPrzyjec',
                'ikona' => 'icon-list',
            ),


            'przyjmowanieTowaru' => array(
                'nazwa' => $this->j->t['zakladki.przyjmij_towar'],
                'akcja' => 'przyjmijTowar',
                'ikona' => 'icon-upload',
            ),
            'widokPracownika' => array(
                'nazwa' => $this->j->t['zakladki.widokPracownika'],
                'akcja' => 'widokPracownika',
                'ikona' => 'icon-group',
                'parametry' => array('typ' => 'produkty'),
            ),
            'mojeZamowienia' => array(
                'nazwa' => $this->j->t['zakladki.mojMagazyn'],
                'akcja' => 'mojeZamowienia',
                'ikona' => 'icon-user',
                'sublinki' => array(
                    1 => array('nazwa' => $this->j->t['zakladki.mojeProdukty'], 'akcja' => 'mojeProdukty' ),
                    2 => array('nazwa' => $this->j->t['zakladki.mojeZamowienia'], 'akcja' => 'mojeZamowienia', 'parametry' => array('typ' => 'produkty') ),
                    3 => array('nazwa' => $this->j->t['zakladka.noweZamowienie'], 'akcja' => 'zamowNowyProdukt'),
                ),
            ),
            */
            'produkty' => array(
                'nazwa' => $this->j->t['zakladki.produkty'],
                'akcja' => 'produktyDodaj',
                'ikona' => 'icon-plus-sign',
                'parametry' => array('typ' => 'produkty'),
                'sublinki' => array(
                    1 => array('nazwa' => $this->j->t['zakladki.produkty_dodaj'], 'akcja' => 'produktyDodaj' ),
                    2 => array('nazwa' => $this->j->t['zakladki.magazyn'], 'akcja' => 'magazyn', 'parametry' => array('typ' => 'produkty') ),
                ),
            ),
            'kamienie' => array(
                'nazwa' => $this->j->t['zakladki.kamienie'],
                'akcja' => 'listaKamieni',
                'ikona' => 'icon-plus-sign',
                'parametry' => array('typ' => 'produkty'),
                'sublinki' => array(
                    1 => array('nazwa' => $this->j->t['zakladki.kamien_dodaj'], 'akcja' => 'dodajKamien' , 'parametry' => array('typ' => 'kamien') ),
                    2 => array('nazwa' => $this->j->t['zakladki.rodzaj_zlota_dodaj'], 'akcja' => 'dodajKamien' , 'parametry' => array('typ' => 'rodzaj_zlota') ),
                ),
            ),
            'kategorie' => array(
                'nazwa' => $this->j->t['zakladki.kategorie'],
                'akcja' => 'drzewoKategorii',
                'ikona' => 'icon-sitemap',
                'sublinki' => array(
                    1 => array('nazwa' => $this->j->t['zakladki.kategorie_drzewo'], 'akcja' => 'drzewoKategorii', 'parametry' => array('typ' => 'produkty') ),
                    2 => array('nazwa' => $this->j->t['zakladki.kategorie_sortowanie'], 'akcja' => 'sortowanie', 'parametry' => array('typ' => 'produkty') ),
                ),
            ),
        );
        if($aktywna == 'finalizacja')
        {
            $zakladki['finalizacja'] = array(
                'nazwa' => $this->j->t['zakladki.finalizacja'],
                'akcja' => 'finalizujZamowienie',
            );
        }
        return $this->ustawZakladkiHtml($zakladki, $aktywna);
    }

    /**
     * Metoda parsuje widok struktury zakładek
     * @return type
     */
    private function ustawZakladkiHtml(Array $zakladkiTablica, $aktywna)
    {
        if(is_array($zakladkiTablica) && count($zakladkiTablica) > 0)
        {
            $profil = Cms::inst()->profil();
            $klientMobilny = klientMobilny();
            foreach($zakladkiTablica as $klucz => $zakladka)
            {
                if($klientMobilny && in_array($klucz, $this->k->k['ustawZakladki.nie_wyswietlaj_mobilnie'])) continue;

                $klasa = ($klucz == $aktywna) ? 'active' : '';
                $ikona = (isset($zakladka['ikona'])) ? $zakladka['ikona'] : null;

                if(!$profil->maUprawnieniaDo('Admin_'.$this->kategoria->id.'_wykonaj'.ucfirst($zakladka['akcja'])))
                {
                    continue;
                }
                $wyswietlajIlosc2 = false;
                $iloscKlasa2 = '';
                $ilosc2 = 0;
                $iloscKlasa = '';
                $ilosc = 0;

                if($klucz == 'index')
                {
                    $ilosc = $this->dane()->MagazynWydane()->iloscSzukaj(array('status' => 'oczekuje', 'osobaWydajaca' => Cms::inst()->profil()->id));
                    $wyswietlajIlosc = ($ilosc) ? true : false;
                    $iloscKlasa = 'label-important';
                }
                if($klucz == 'magazyn')
                {
                    $ilosc2 = $this->dane()->ProduktyMagazyn()->iloscSzukaj(array('kategorie' => 2));
                    $wyswietlajIlosc2 = ($ilosc2) ? true : false;
                    $iloscKlasa2 = 'label-success';

                }

                if(isset($zakladka['sublinki']) && count($zakladka['sublinki']))
                {
                    $this->szablon->ustawBlok('/zakladki/subzakladki/',
                        array('link' => '#', 'nazwa' => $zakladka['nazwa'], 'klasa' => $klasa, 'ikona' => $zakladka['ikona'], 'wyswietlajIlosc' => $wyswietlajIlosc, 'ilosc' => $ilosc) );
                    foreach($zakladka['sublinki'] as $klucz => $subzakladka)
                    {
                        if(!$profil->maUprawnieniaDo('Admin_'.$this->kategoria->id.'_wykonaj'.ucfirst($subzakladka['akcja'])))
                            continue;

                        $parametry = (isset($subzakladka['parametry']) && count($subzakladka['parametry'])) ? $subzakladka['parametry'] : array();
                        $this->szablon->ustawBlok('/zakladki/subzakladki/subzakladka/', array('link' => Router::urlAdmin($this->kategoria, $subzakladka['akcja'], $parametry), 'nazwa' => $subzakladka['nazwa'], 'klasa' => $klasa) );
                    }
                }
                else
                {
                    $parametry = (isset($zakladka['parametry']) && count($zakladka['parametry'])) ? $zakladka['parametry'] : array();

                    $this->szablon->ustawBlok('/zakladki/zakladka/',
                        array('link' => Router::urlAdmin($this->kategoria, $zakladka['akcja'], $parametry), 'nazwa' => $zakladka['nazwa'],
                            'klasa' => $klasa, 'ikona' => $ikona, 'wyswietlajIlosc' => $wyswietlajIlosc, 'ilosc' => $ilosc, 'iloscKlasa' => $iloscKlasa,
                            'wyswietlajIlosc2' => $wyswietlajIlosc2, 'ilosc2' => $ilosc2, 'iloscKlasa2' => $iloscKlasa2, ));
                }

            }
        }

        return $this->szablon->parsujBlok('/zakladki');
    }

    public function wykonajPodgladProduktu()
    {
        $id = Zadanie::pobierzGet('id_produktu', 'intval', 'abs');
        $idPracownika = Zadanie::pobierzGet('id_pracownika', 'intval', 'abs');
        $iloscPobrana = Zadanie::pobierz('ilosc', 'intval', 'abs');


        $produkt = $this->dane()->ProduktyMagazyn()->pobierzPoId($id);

        $html = '';

        if($produkt instanceof ProduktyMagazyn\Obiekt)
        {
            $zdjecie = '';

            if($produkt->zdjecie != '')
                $zdjecie = Cms::inst()->url('zdjecia_produktow', $produkt->id).'/mid-'.$produkt->zdjecie;

            foreach($produkt->sciezkaKategorii as $sciezka)
            {
                $this->szablon->ustawBlok('podgladProduktu/sciezka', array('nazwaKategorii' => $sciezka->nazwa));
            }

            $zalaczniki = Cms::inst()->dane()->Zalacznik()->pobierzDlaObjektu('ProduktyMagazyn', $produkt->id);
            if(count($zalaczniki))
            {
                $kategorieMapper = new \Generic\Model\Kategoria\Mapper();
                $kategoriaZalacznik = $kategorieMapper->pobierzDlaModulu('Attachments');
                $this->szablon->ustawBlok('podgladProduktu/zalaczniki',array('t_zalaczniki' => $this->j->t['podgladProduktu.zalaczniki'],));
                foreach($zalaczniki as $zalacznik)
                {
                    $this->szablon->ustawBlok('podgladProduktu/zalaczniki/zalacznik', array(
                        'id' => $zalacznik->id,
                        'nazwa' => $zalacznik->file,
                        'link' => Router::urlAdmin($kategoriaZalacznik[0], 'downloadAttachments', array('id' => $zalacznik->id)),
                    ));
                }
            }

            $wyswietlajCena = false;
            if( ($iloscPobrana == null || $iloscPobrana  == '' || empty($iloscPobrana)) && $produkt->cena > 0 && (!Cms::inst()->sesja->mojeZamowienie)) $wyswietlajCena = true;
            $ilosc = ($iloscPobrana > 0) ? $iloscPobrana : $produkt->ilosc;

            $dane = array(
                'zdjecie' => $zdjecie,
                'nazwa' => $produkt->nazwaProduktu,
                'kod' => $produkt->kod,
                'ilosc' => $ilosc,
                'opis' => $produkt->opis,
                'status' => $produkt->status,
                't_status' => $this->j->t['podgladProduktu.status'],
                't_dodany_przez' => $this->j->t['podgladProduktu.dodany_przez'],
                't_kod_produktu' => $this->j->t['podgladProduktu.kod_produktu'],
                't_ilosc' => $this->j->t['podgladProduktu.ilosc'],
                't_szt'  => $this->j->t['podgladProduktu.szt'],
                't_kategoria' => $this->j->t['podgladProduktu.kategoria'],
                'wyswietlajCena' => $wyswietlajCena,
                't_cena' =>  $this->j->t['podgladProduktu.cena'],
                't_kr' => $this->j->t['podgladProduktu.kr'],
                'cena' => $produkt->cena,
            );

            if($produkt->osobaDodajaca instanceof Uzytkownik\Obiekt)
                $dane = array_merge ($dane, array('osoba_dodajaca' => $produkt->osobaDodajaca->imie.' '.$produkt->osobaDodajaca->nazwisko,));

            if($produkt->opiekunProduktu instanceof Uzytkownik\Obiekt)
                $dane = array_merge ($dane, array('opiekun' => $produkt->opiekunProduktu->imie.' '.$produkt->opiekunProduktu->nazwisko,));

            $html = $this->szablon->parsujBlok('podgladProduktu', $dane );

        }
        else
        {
            $this->komunikat($this->j->t['podgladProduktu.wybrany_produkt_nie_istnieje'], 'error');
        }



        $dane['html'] = $html;
        $dane['tytul'] = 'Karta produktu';
        $dane['status'] = 1;

        echo json_encode($dane);
        die;
    }

    /**
     *
     * @param type $edytujId - id edytowanego zamówienia
     * @return html
     */
    private function parsujWyszukiwarka($edytujId = null)
    {

        $nieWyswietlajZablokowanych = true;

        $this->szablon->ustawBlok('/wyszukiwarka/listaWynikow/pustaLista', array('brakWynikowWyszukiwania' => $this->j->t['magazyn.minimalna_ilosc_znakow_informacja'],));

        $dane = array(
            'szukajFraza' => $this->j->t['magazyn.fraza_szukaj'],
            'szukajFrazaPlaceholder' => $this->j->t['magazyn.szukajFrazaPlaceholder'],
            'znaleziono_ilosc_etykieta' => $this->j->t['magazyn.znaleziono_ilosc_etykieta'],
            'linkPobierzWyniki' => Router::urlAjax('admin', $this->kategoria, 'pobierzWynikiSzukaj'),
            'nrStrony' => 0,
            'naStronie' => $this->k->k['magazyn.wyszukiwarka_wierszy_na_stronie'],
            'iloscZnakow' => $this->k->k['pobierzWynikiSzukaj.iloscZnakow'],
            'kategorie' => $this->menuKategorii('produkty', $nieWyswietlajZablokowanych),
            'koszykEtykieta' => $this->j->t['magazyn.koszykEtykieta'],
            'dodajDoZamowieniaLink' => Router::urlAjax('Admin', $this->kategoria, 'dodajDoZamowienia'),
            'koszykIlosc' => $this->pobierzLacznaIloscProduktow(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']),
            'pobierzZawartoscKoszykaLink' => Router::urlAjax('admin', $this->kategoria, 'pobierzZawartoscKoszyka'),
            'usunZKoszykaLink' => Router::urlAjax('admin', $this->kategoria, 'usunProduktZKoszyka'),
            'edytujProduktZKoszyka' => Router::urlAjax('admin', $this->kategoria, 'edytujProduktZKoszyka'),
            'bladEdycjiProduktu' => $this->j->t['magazyn.bladEdycjiProduktu'],
            'podgladProduktu' => Router::urlAjax('Admin', $this->kategoria, 'podgladProduktu'),
            'urlUstawJakoNaprawiony' => Router::urlAdmin($this->kategoria, 'ustawJakoNaprawiony'),
        );
        if(Cms::inst()->sesja->przyjmijTowar)
        {
            $this->szablon->ustawBlok('wyszukiwarka/dodajNowyProdukt', array(
                'urlDodajProdukt' => Router::urlAdmin($this->kategoria, 'produktyDodaj', array('typ' => 'produkty', 'przyjmijTowar' => 1)),
                'dodajProduktEtykieta' => $this->j->t['magazyn.dodajProduktEtykieta'],
            ));
        }
        $html  = $this->szablon->parsujBlok('wyszukiwarka', $dane);

        return $html;
    }

    public function wykonajMagazyn()
    {
        Cms::inst()->sesja->mojeZamowienie = false;
        Cms::inst()->sesja->przyjmijTowar = false;

        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['magazyn.tytul_strony'],
            'tytul_modulu' => $this->j->t['magazyn.tytul_modulu'],
        ));

        $edytujId = Zadanie::pobierz('id', 'intval', 'abs');
        $koszykRozwiniety = false;

        $wyszukiwarka = $this->parsujWyszukiwarka($edytujId);

        $this->tresc .= $this->szablon->parsujBlok('magazyn',
            array(
                'zakladki' => $this->ustawZakladki('magazyn'),
                'wyszukiwarka' => $wyszukiwarka,

            ));
    }

    private function pobierzNazweKoszyka()
    {
        $nazwaKoszyka = '';

        $cms = Cms::inst();

        if(isset($cms->sesja->mojeZamowienie) && $cms->sesja->mojeZamowienie)
            $nazwaKoszyka = 'mojeZamowienie';
        else if(isset($cms->sesja->przyjmijTowar) && $cms->sesja->przyjmijTowar)
            $nazwaKoszyka = 'przyjecie';
        else
            $nazwaKoszyka = 'zamowienie';

        (!isset($cms->sesja->koszyk[$nazwaKoszyka])) ? $cms->sesja->koszyk[$nazwaKoszyka] = array() : '';
        (!isset($cms->sesja->koszyk[$nazwaKoszyka]['listaProduktow'])) ? $cms->sesja->koszyk[$nazwaKoszyka]['listaProduktow'] = array() : '';

        return $nazwaKoszyka;
    }

    private function ustawKoszykDoEdycjiZamowienia($edytujId)
    {
        $zamowienie = $this->dane()->MagazynWydane()->pobierzPoId($edytujId);
        if($zamowienie instanceof MagazynWydane\Obiekt)
        {
            $listaProduktow = $zamowienie->pobierzProdukty();

            $cms = Cms::inst();

            if(isset($cms->sesja->koszyk[$this->pobierzNazweKoszyka()])) unset($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]);

            $cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['edycja'] = true;
            $cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['idZamowienia'] = $edytujId;
            foreach($listaProduktow as $produkt)
            {
                $cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$produkt['id']]['ilosc'] = $produkt['ilosc'];
                $cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$produkt['id']]['produktNazwa'] = $produkt['nazwa_produktu'];
                $cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$produkt['id']]['kod'] = $produkt['kod'];
                $cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$produkt['id']]['maxIlosc'] = $produkt['iloscmagazyn'];
            }
        }
        else
            $this->komunikat ($this->j->t['magazyn.edycja_brak_zamowienia'], 'error');
    }

    public function wykonajPobierzZawartoscKoszyka()
    {
        $cms = Cms::inst();

        $dane['html'] = '';
        if(isset($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']) && count($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']))
        {
            foreach($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'] as $produktId => $produkt)
            {
                $this->szablon->ustawBlok('/wyszukiwarka/zawartoscKoszyka/pozycja',
                    array(
                        'produkt_id' => $produktId,
                        'produkt_nazwa' => $produkt['produktNazwa'],
                        'produkt_ilosc' => $produkt['ilosc'],
                        'produkt_kod' => $produkt['kod'],
                        'maxIlosc' => $produkt['maxIlosc'],
                    ));
            }

            $dane['html'] = $this->szablon->parsujBlok('/wyszukiwarka/zawartoscKoszyka/', array(
                'koszykNazwaEtykieta' => $this->j->t['magazyn.koszyk_nazwa_etykieta'],
                'koszykIloscEtykieta' => $this->j->t['magazyn.koszyk_ilosc_etykieta'],
                'koszykUsunEtykieta' => $this->j->t['magazyn.koszyk_usun_etykieta'],
                'koszykFinalizuj' => $this->j->t['magazyn.koszyk_finalizuj_etykieta'],
                'czyscKoszyk' => $this->j->t['magazyn.czyscKoszyk'],
                'koszykFinalizujLink' => Router::urlAdmin($this->kategoria, 'finalizujZamowienie'),
                'koszykKodEtykieta' => $this->j->t['magazyn.koszyk_kod_etykieta'],
            ));

        }
        else
        {
            $dane['html'] = $this->szablon->parsujBlok('/wyszukiwarka/koszykPusty', array('koszyk_pusty_tresc' => $this->j->t['magazyn.koszyk_pusty']));
        }

        echo json_encode($dane);
        die;
    }

    public function wykonajSzukajProduktowSelectAjax()
    {
        $cms = Cms::inst();
        $fraza = html2txt(Zadanie::pobierzGet('fraza', 'strval', 'filtr_xss'));
        $nrStrony = Zadanie::pobierz('nrStrony', 'intval', 'abs');

        $kryteria = array(
            'fraza' => trim($fraza),
            'status' => 'active',
            'grupa' => false,
            '!kategorie' => array($this->k->k['zwrocProdukty.kategoria_produkty_niepelne'], $this->k->k['zwrocProdukty.kategoria_produkty_serwis']),
        );

        $mapperProduktyMagazyn = $cms->dane()->ProduktyMagazyn();

        $sorter = new ProduktyMagazyn\Sorter('nazwa_produktu');
        $iloscWierszy = $mapperProduktyMagazyn->iloscSzukaj($kryteria);

        $pager = new Pager($iloscWierszy, 20, $nrStrony);

        $produkty = $mapperProduktyMagazyn->zwracaTablice()->szukaj($kryteria ,$pager ,$sorter);

        foreach($produkty as $id => $produkt)
        {
            if($produkt['zdjecie'] != '')
            {
                $produkty[$id]['zdjecie'] = Cms::inst()->url('zdjecia_produktow', $produkt['id']).'/'.$this->k->k['parsujPojedynczyWierszWyszukiwania.prefix_miniaturka'].$produkt['zdjecie'];
            }
        }

        $dane = array('total' => $iloscWierszy, 'produkty' => $produkty, 'page' => $nrStrony);
        echo json_encode($dane);
        die;
    }

    public function wykonajPobierzWynikiSzukaj()
    {
        $cms = Cms::inst();
        $fraza = html2txt(Zadanie::pobierzPost('fraza', 'strval', 'filtr_xss'));
        $kategoria = Zadanie::pobierzPost('kategoria', 'intval');
        $dane['ilosc'] = 0;

        if($fraza != "" && strlen($fraza) > $this->k->k['pobierzWynikiSzukaj.iloscZnakow'] && ($kategoria == 0 || $kategoria == null ))
        {
            $kryteria = array(
                'fraza' => trim($fraza),
                'status' => 'active',
            );
        }
        elseif($kategoria > 0)
        {
            $kategorieMapper = $cms->dane()->KategorieMagazyn();
            $kategoriaSciezka = $kategorieMapper->zwracaTablice()->pobierzSciezke($kategoria);

            $galazDrzewa = listaZTablicy($kategorieMapper->pobierzGalazDoPoziomu($kategoria, 5), 'id', 'id');

            foreach($kategoriaSciezka as $element)
            {
                if($element['nazwa'] == 'Root') continue;

                $this->szablon->ustawBlok('breadcrumbs/strona', array('nazwa' => $element['nazwa'], 'id' => $element['id']));
            }

            $dane['sciezka'] = $this->szablon->parsujBlok('breadcrumbs', array('sciezka_label' => $this->j->t['pobierzWynikiSzukaj.sciezka_label']));

            $kryteria = array(
                'kategorie' => $galazDrzewa,
                'status' => 'active',
            );

            if($fraza != "" )
                $kryteria = array_merge ($kryteria, array('fraza' => $fraza));

        }
        else
        {
            $dane['kod'] = 3;
            $daneHtml = array(
                'brakWynikowWyszukiwania' => $this->j->t['pobierzWynikiSzukaj.minimalna_ilosc_znakow_informacja'],
            );
            $this->szablon->ustawBlok('/wyszukiwarka/listaWynikow//pustaLista' , $daneHtml);
            $dane['html'] = $this->szablon->parsujBlok('/wyszukiwarka/listaWynikow/listaZamowien/');
            echo json_encode($dane);
            die;
        }

        $mapperProduktyMagazyn = $cms->dane()->ProduktyMagazyn();

        $sorter = new ProduktyMagazyn\Sorter('nazwa_produktu');
        $iloscWierszy = $mapperProduktyMagazyn->iloscSzukaj($kryteria);

        if($iloscWierszy > 0)
        {
            $naStronie = $this->pobierzParametr('naStronie', $this->k->k['magazyn.wyszukiwarka_wierszy_na_stronie'], true, array('intval','abs'));
            $nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));

            $pager = new Pager\Html($iloscWierszy, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['pobierzWynikiSzukaj.pager_konfiguracja']);

            $produkty = $mapperProduktyMagazyn->zwracaTablice()->szukaj($kryteria ,$pager ,$sorter);

            foreach ($produkty as $produkt)
            {
                $this->parsujPojedynczyWierszWyszukiwania($produkt);
            }

            $dane['kod'] = 1;
            $dane['ilosc'] = $iloscWierszy;
            $dane['naStronie'] = $naStronie;
            $dane['nrStrony'] = $nrStrony+1;
            $dane['html'] = $this->szablon->parsujBlok('/wyszukiwarka/listaWynikow/');
        }
        else
        {
            $dane['kod'] = 3;

            $daneHtml = array(
                'brakWynikowWyszukiwania' => $this->j->t['pobierzWynikiSzukaj.brak_wynikow_wyszukiwania'],
            );
            $this->szablon->ustawBlok('/wyszukiwarka/listaWynikow/pustaLista' , $daneHtml);
            $dane['html'] = $this->szablon->parsujBlok('/wyszukiwarka/listaWynikow/');
        }

        echo json_encode($dane);
        die;
    }

    private function parsujPojedynczyWierszWyszukiwania($produkt, $zwracaWiersz = false)
    {
        $zdjecieLink = null;
        $zdjecieMiniaturka = null;
        if($produkt['zdjecie'] != '')
        {
            $zdjecieMiniaturka = Cms::inst()->url('zdjecia_produktow', $produkt['id']).'/'.$this->k->k['parsujPojedynczyWierszWyszukiwania.prefix_miniaturka'].$produkt['zdjecie'];
            $zdjecieLink = Cms::inst()->url('zdjecia_produktow', $produkt['id']).'/'.$this->k->k['parsujPojedynczyWierszWyszukiwania.prefix_podglad'].$produkt['zdjecie'];
        }


        $wyswietlajEdytujProdukt = false;

        if(Cms::inst()->profil()->maUprawnieniaDo('Admin_'.$this->kategoria->id.'_wykonajProduktyDodaj'))
            $wyswietlajEdytujProdukt = true;


        $blokujSpinner = $this->k->k['parsujPojedynczyWierszWyszukiwania.blokujSpinner'];
        $ustawMaxSpinner = true;
        if(Cms::inst()->sesja->przyjmijTowar )
        {
            $ustawMaxSpinner = false;
            $blokujSpinner = false;
        }

        $dane = array(
            'zdjecieMiniaturka' => $zdjecieMiniaturka,
            'zdjecieLink' => $zdjecieLink,
            'kategoria' => $produkt['kategoria_nazwa'],
            'produktNazwa' => $produkt['nazwa_produktu'],
            'produktIlosc' => $produkt['ilosc'],
            'produktKod' => $produkt['kod'],
            'podgladGrupyEtykieta' => $this->j->t['parsujPojedynczyWierszWyszukiwania.podgladGrupyEtykieta'],
            'dodajDoZamowieniaEtykieta' => $this->j->t['parsujPojedynczyWierszWyszukiwania.dodajDoZamowieniaEtykieta'],
            'idProduktu' => $produkt['id'],
            'ilosc_etykieta' => $this->j->t['parsujPojedynczyWierszWyszukiwania.ilosc_etykieta'],
            'edytujProduktEtykieta' => $this->j->t['parsujPojedynczyWierszWyszukiwania.edytujProduktEtykieta'],
            'zapiszIloscEtykieta' => $this->j->t['parsujPojedynczyWierszWyszukiwania.zapiszIloscEtykieta'],
            'blokujSpinner' => $blokujSpinner,
            'ustawMaxSpinner' => $ustawMaxSpinner,
            'wyswietlajEdytujProdukt' => $wyswietlajEdytujProdukt,
            'wyswietlajDodajDoKoszyka' => false,
            'edytujProduktLink' => Router::urlAdmin($this->kategoria, 'produktyDodaj', array('id' => $produkt['id'], 'typ' => 'produkty')),
        );

        if($zwracaWiersz)
            return $this->szablon->parsujBlok('/wyszukiwarka/listaWynikow/produkt' , $dane);
        else
        {
            $this->szablon->ustawBlok('/wyszukiwarka/listaWynikow/produkt' , $dane);
        }

    }

    public function wykonajUstawJakoNaprawiony()
    {
        $idProduktu = Zadanie::pobierz('id', 'intval', 'abs');
        $mapperProduktyMagazyn = $this->dane()->ProduktyMagazyn();

        $dane = array();
        $dane['error'] = 0;
        $produktDoNaprawy = $mapperProduktyMagazyn->pobierzPoId($idProduktu);

        if($produktDoNaprawy instanceof ProduktyMagazyn\Obiekt)
        {
            $produktGlowny = $mapperProduktyMagazyn->pobierzPoKodzie($produktDoNaprawy->kod);
            if($produktGlowny instanceof ProduktyMagazyn\Obiekt)
            {
                $produktGlowny->ilosc = $produktGlowny->ilosc + $produktDoNaprawy->ilosc;

                if($produktGlowny->zapisz($mapperProduktyMagazyn))
                {
                    $dane['id'] = $produktDoNaprawy->id;
                    $produktDoNaprawy->usun($mapperProduktyMagazyn);
                }
                else
                {
                    $dane['error'] = 1;
                    $dane['komunikat'] = $this->j->t['ustawJakoNaprawiony.bladZapisu']; // nie udało sie przenieść produktu do magazynu
                }
            }
            else
            {
                $dane['error'] = 1;
                $dane['komunikat'] = $this->j->t['ustawJakoNaprawiony.produktGlownyNieIstnieje']; // nie udało sie przenieść produktu do magazynu
            }

        }
        else
        {
            $dane['error'] = 1;
            $dane['komunikat'] = $this->j->t['ustawJakoNaprawiony.produktNieIstanieje'];
        }

        echo json_encode($dane);
        die;
    }

    public function wykonajDodajDoZamowienia()
    {
        $dane['success'] = false;
        $idProduktu = Zadanie::pobierz('idProduktu', 'intval', 'abs');
        $ilosc = Zadanie::pobierz('ilosc', 'intval', 'abs');

        if($idProduktu > 0 && $ilosc > 0)
        {
            $produkt = $this->dane()->ProduktyMagazyn()->pobierzPoId($idProduktu);
            if($produkt instanceof ProduktyMagazyn\Obiekt)
            {
                if($this->dodajProduktDoSesji($produkt, $ilosc))
                    $dane['succes'] = true;
                else
                    $this->komunikat ($this->j->t['dodajDoZamowienia.ilosc_za_duza'], 'error');

            }
            else
                $this->komunikat ($this->j->t['dodajDoZamowienia.produkt_nie_istnieje'], 'error');
        }
        else
            $this->komunikat ($this->j->t['dodajDoZamowienia.nie_przekazano_wszystkich_parametrow'], 'error');

        $dane['komunikaty'] = $this->komunikatyHtml();
        $dane['iloscProduktow'] = $this->pobierzLacznaIloscProduktow(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']);

        echo json_encode($dane);
        die;
    }

    public function wykonajEdytujProduktZKoszyka()
    {
        $idProduktu = Zadanie::pobierzPost('id', 'intval', 'abs');
        $ilosc = Zadanie::pobierzPost('ilosc', 'intval', 'abs');

        $dane['succes'] = false;
        if($idProduktu > 0 && $ilosc > 0)
            $dane['succes'] = $this->edytujProduktZKoszyka($idProduktu, $ilosc);

        $dane['iloscProduktow'] = $this->pobierzLacznaIloscProduktow(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']);

        echo json_encode($dane);
        die;
    }

    private function edytujProduktZKoszyka($idProduktu, $ilosc)
    {
        if(isset(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$idProduktu]))
        {
            $produkt = $this->dane ()->ProduktyMagazyn()->pobierzPoId($idProduktu);
            if($produkt instanceof ProduktyMagazyn\Obiekt)
                if($produkt->ilosc >= $ilosc)
                    Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$idProduktu]['ilosc'] = $ilosc;
                else if(Cms::inst()->sesja->przyjmijTowar)
                    Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$idProduktu]['ilosc'] = $ilosc;
                else
                    return false;
            else
                return false;
        }
        else
            return false;

        return true;

    }

    private function usunProduktyZKoszyka($produktId)
    {
        $succes = false;

        if($produktId > 0)
        {
            if(isset(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$produktId]))
            {
                unset(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$produktId]);
                $succes = true;
            }
        }
        elseif($produktId === 0)
        {
            unset(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]);
            $succes = true;
        }
        else
            $succes = false;

        return $succes;
    }

    public function wykonajUsunProduktZKoszyka()
    {
        $produktId = Zadanie::pobierz('id', 'intval', 'abs');
        $dane['succes'] = false;
        $dane['kod'] = 1;

        $dane['succes'] = $this->usunProduktyZKoszyka($produktId);

        $dane['iloscProduktow'] = $this->pobierzLacznaIloscProduktow(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']);

        if(Zadanie::czyAjax())
        {
            echo json_encode($dane);
            die;
        }
        else
        {
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'magazyn'));
        }
    }

    private function pobierzLacznaIloscProduktow($koszyk = array())
    {
        $ilosc = 0;

        if(count($koszyk))
            foreach ($koszyk as $produkt)
                $ilosc += $produkt['ilosc'];

        return $ilosc;
    }

    private function dodajProduktDoSesji(\Generic\Model\ProduktyMagazyn\Obiekt $produkt, $ilosc)
    {
        $cms = Cms::inst();
        if(isset($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$produkt->id]))
        {
            $iloscTmp = $cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$produkt->id]['ilosc'] + $ilosc;
            if($iloscTmp > $produkt->ilosc) 	return false;

            $cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$produkt->id]['ilosc'] = $iloscTmp;
        }
        else
        {
            if($ilosc > $produkt->ilosc && !$cms->sesja->przyjmijTowar) return false;

            $cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'][$produkt->id] = array(
                'produktNazwa' => $produkt->nazwaProduktu,
                'kod' => $produkt->kod,
                'grupa' => $produkt->grupa,
                'produkty_grupy' => $produkt->produktyGrupy,
                'maxIlosc' => $produkt->ilosc,
                'ilosc' => $ilosc,
                'zdjecie' => $produkt->zdjecie,
            );
        }

        return true;
    }

    public function wykonajFinalizujZamowienie()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['finalizujZamowienie.tytul_strony'],
            'tytul_modulu' => $this->j->t['finalizujZamowienie.tytul_modulu'],
        ));
        $cms = Cms::inst();

        if($cms->sesja->mojeZamowienie)
        {
            $wsteczLink = Router::urlAdmin($this->kategoria, 'zamowNowyProdukt');
            $formularz = $this->formularzFinalizacjaMojeZmowienie();
        }
        elseif($cms->sesja->przyjmijTowar)
        {
            $wsteczLink = Router::urlAdmin($this->kategoria, 'przyjmijTowar');
            $formularz = $this->formularzPrzyjmijTowar();
        }
        else
        {
            $wsteczLink = Router::urlAdmin($this->kategoria, 'magazyn');
            $formularz = $this->formularzFinalizacja();
        }

        if(isset($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]) && count($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']))
        {
            if(isset($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']) && count($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']))
            {
                $this->szablon->ustawBlok('finalizacja/listaProduktow/', array(
                    'zdjecieEtykieta' => $this->j->t['finalizujZamowienie.zdjecieEtykieta'],
                    'produktKodEtykieta' => $this->j->t['finalizujZamowienie.produktKodEtykieta'],
                    'produktIdEtykieta' => $this->j->t['finalizujZamowienie.produktIdEtykieta'],
                    'produktNazwaEtykieta' => $this->j->t['finalizujZamowienie.produktNazwaEtykieta'],
                    'produktIloscEtykieta' => $this->j->t['finalizujZamowienie.produktIloscEtykieta'],
                    'iloscLacznieEtykieta' => $this->j->t['finalizujZamowienie.iloscLacznieEtykieta'],
                    'usunEtykieta' => $this->j->t['finalizujZamowienie.usunEtykieta'],
                    'iloscLacznie' => $this->pobierzLacznaIloscProduktow($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']),
                    'formularz' => $formularz->html(),
                ));

                foreach ($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'] as $idProduktu => $produkt)
                {
                    $zdjecieLink = null;
                    $zdjecieMiniaturka = null;
                    if(isset($produkt['zdjecie']) && $produkt['zdjecie'] != '')
                    {
                        $zdjecieMiniaturka = Cms::inst()->url('zdjecia_produktow', $idProduktu).'/'.$this->k->k['koszyk.prefix_miniaturka'].$produkt['zdjecie'];
                        $zdjecieLink = Cms::inst()->url('zdjecia_produktow', $idProduktu).'/'.$this->k->k['parsujPojedynczyWierszWyszukiwania.prefix_podglad'].$produkt['zdjecie'];
                    }

                    $this->szablon->ustawBlok('finalizacja/listaProduktow/produkt', array(
                            'produktId' => $idProduktu,
                            'produktKod' => $produkt['kod'],
                            'maxIlosc' => $produkt['maxIlosc'],
                            'wlaczOgraniczenieMaxIlosc' => (Cms::inst()->sesja->przyjmijTowar) ? false : true ,
                            'produktNazwa' => $produkt['produktNazwa'],
                            'produktIlosc' => $produkt['ilosc'],
                            'zdjecie' => $zdjecieMiniaturka,
                            'zdjecieLink' => $zdjecieLink,
                            'brakZdjecia' => $this->j->t['finalizujZamowienie.brakZdjecia'],
                        )
                    );
                }
            }
            else
                $this->komunikat ($this->j->t['finalizujZamowienie.komunikatKoszykPusty'], 'info');

        }
        else
            $this->komunikat($this->j->t['magazyn.koszyk_pusty'], 'info');

        $this->tresc .= $this->szablon->parsujBlok('finalizacja',
            array(
                'zakladki' => $this->ustawZakladki('finalizacja'),
                'listaZamowionychProduktowEtykieta' => $this->j->t['finalizujZamowienie.listaZamowionychProduktowEtykieta'],
                'edytujProduktZKoszyka' => Router::urlAjax('admin', $this->kategoria, 'edytujProduktZKoszyka'),
                'bladEdycjiProduktu' => $this->j->t['magazyn.bladEdycjiProduktu'],
                'usunZKoszykaLink' => Router::urlAjax('admin', $this->kategoria, 'usunProduktZKoszyka'),
                'koszyk_pusty' => $this->j->t['magazyn.koszyk_pusty'],
                'wsteczEtykieta' => $this->j->t['finalizacja.wsteczEtykieta'],
                'wsteczLink' => $wsteczLink,
                'etykietaFinalizacjaCzysc' => $this->j->t['finalizacja.etykietaFinalizacjaCzysc'],
                'urlFinalizacjaCzysc' => Router::urlAdmin($this->kategoria, 'usunProduktZKoszyka', array('id' => 0)),
            )
        );
    }

    private function formularzFinalizacjaMojeZmowienie()
    {
        $formularz = new Formularz('', 'finalizuj');
        $formularz->otworzRegion('main', 'Formularz');

        $uzytkownik = Cms::inst()->dane()->Uzytkownik()->pobierzPoId(Cms::inst()->profil()->id);

        if($uzytkownik instanceof Uzytkownik\Obiekt)
        {
            $team = $uzytkownik->pobierzTeamDlaLidera();
            if($team instanceof \Generic\Model\Team\Obiekt)
                $listaWyboru = array('Uzytkownik' => $uzytkownik->imie.' '.$uzytkownik->nazwisko, 'Team' => $team->teamNumber);
            else
                $listaWyboru = array('Uzytkownik' => $uzytkownik->imie.' '.$uzytkownik->nazwisko);

            $radio = new Input\Radio('wybierzOdbiorce', array('lista' => $listaWyboru, 'inline' => true));
            $radio->dodajWalidator(new Walidator\NiePuste())->wymagany = true;
            $radio->ustawWartosc('Uzytkownik');
            $formularz->input($radio);
            $formularz->input(new Input\TextArea('opis', array('atrybuty' => array('style' => 'width:70%;'))));

            $formularz->stopka(new Input\Submit('zapisz'));
            $formularz->zamknijRegion('main', 'Formularz');

            $formularz->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzFinalizuj'));

            if($formularz->wypelniony())
            {
                $wartosci = $formularz->pobierzWartosci();
                if($formularz->danePoprawne() && isset(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]) && count(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']))
                {
                    if($wartosci['wybierzOdbiorce'] == 'Uzytkownik')
                        $idOdbiorcy = $uzytkownik->id;
                    else
                        $idOdbiorcy = $team->id;

                    $maperProdukty = Cms::inst()->dane()->ProduktyMagazyn();
                    $listaProduktowOpiekunow = $this->pobierzListeOpiekunZamowienie(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']);
                    $listaZamowienOpiekunow = array();
                    foreach($listaProduktowOpiekunow as $opiekun => $listaProduktow)
                    {
                        $idZamowienia = $this->zapiszZamowienie(ucfirst($wartosci['wybierzOdbiorce']), $idOdbiorcy, $wartosci['opis'], $listaProduktow , $opiekun, 'oczekuje');
                        $listaZamowienOpiekunow[$opiekun] = $idZamowienia;
                    }
                    $this->wyslijEmailZMojeZamowienie($listaProduktowOpiekunow);
                    $this->komunikat($this->j->t['finalizacjaZamowienia.zamowienie_zostalo_wyslane_pomyslnie'], 'info', 'sesja');
                    Cms::inst()->sesja->__unset('koszyk');
                    Router::przekierujDo(Router::urlAdmin($this->kategoria, 'mojeZamowienia'));
                }
            }
        }
        else
            $this->komunikat($this->j->t['finalizacjaZamowienia.zalogowany_uzytkownik_nie_istnieje'], 'error');



        return $formularz;
    }

    private function wyslijEmailZMojeZamowienie($listaZamowienOpiekunow)
    {
        $cms = Cms::inst();
        $idEmail = $this->k->k['wyslijEmailZMojeZamowienie.id_email_do_akceptacji'];
        foreach($listaZamowienOpiekunow as $idOpiekuna => $produkty)
        {
            $opiekunObiekt = $cms->dane()->Uzytkownik()->pobierzPoId($idOpiekuna);
            $osobaZamawiajaca = $cms->dane()->Uzytkownik()->pobierzPoId($cms->profil()->id);
            $listaProduktow['produkt'] = $produkty;
            $dane = array(
                'obiekt_Pracownik' => $osobaZamawiajaca,
                'obiekt_OpiekunMagazynu' => $opiekunObiekt,
                'listaProduktow' => $listaProduktow,
            );
            $poczta = new Poczta($idEmail, $dane);
            $poczta->wyslij();
        }

    }

    private function pobierzListeOpiekunZamowienie($produktyKoszyka)
    {
        $maperProdukty = Cms::inst()->dane()->ProduktyMagazyn();
        $listaZamowienOpiekunow = array();

        foreach($produktyKoszyka as $idProduktu => $produkt)
        {
            $produktObiekt = $maperProdukty->pobierzPoId($idProduktu);
            $opiekun = $produktObiekt->pobierzOpiekunProduktu();
            $listaZamowienOpiekunow[$opiekun->id][$idProduktu] = $produkt;
        }

        return $listaZamowienOpiekunow;
    }

    private function formularzFinalizacja()
    {
        $formularz = new Formularz('', 'finalizuj');
        $formularz->otworzRegion('main', 'Formularz');

        $cms = Cms::inst();
        $edycja = false;
        if(isset($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['edycja']) && $cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['edycja'])
        {
            $maper = $cms->dane()->MagazynWydane();
            $zamowienie = $maper->pobierzPoId($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['idZamowienia']);

            if(!($zamowienie instanceof MagazynWydane\Obiekt))
                $this->j->t['finalizujZamowienie.brak_zamowienia_do_edycji'];
            else
                $edycja = true;

        }

        $listaWyboru = array('Uzytkownik' => $this->j->t['inputRadion.uzytkownik'], 'Team' => $this->j->t['inputRadio.team']);
        $radio = new Input\Radio('wybierzOdbiorce', array('lista' => $listaWyboru, 'inline' => true));
        $radio->dodajWalidator(new Walidator\NiePuste())->wymagany = true;

        $radio->ustawWartosc('Uzytkownik');

        $formularz->input($radio);
        if(!$edycja)
            $formularz->input(new Input\Checkbox('dodajGrupowo'));

        $formularz->input($this->pobierzInputSelect($this->pobierzPracownikow(), 'id', array('imie', 'nazwisko'), 'odbiorcaUzytkownik'));
        $formularz->input($this->pobierzInputSelect($this->pobierzTeamy(), 'id', array('team_number'), 'odbiorcaTeam', array('class' => 'js-hide')));

        if(!$edycja)
        {
            $listaGrupowaUzytkownikow = array();
            foreach($this->pobierzPracownikow() as $pracownik)
                $listaGrupowaUzytkownikow[$pracownik['id']] = $pracownik['imie'].' '.$pracownik['nazwisko'];

            $formularz->input(new Input\AutocompleteLista('odbiorcaUzytkownikLista', array('lista' => $listaGrupowaUzytkownikow)));
            $formularz->input('odbiorcaUzytkownikLista')->dodajAtrybuty(array('class' => 'js-hide'));

            $listaGrupowaTeamow = array();
            foreach($this->pobierzTeamy() as $team)
                $listaGrupowaTeamow[$team['id']] = $team['team_number'];

            $formularz->input(new Input\AutocompleteLista('odbiorcaTeamLista', array('lista' => $listaGrupowaTeamow)));
            $formularz->input('odbiorcaTeamLista')->dodajAtrybuty(array('class' => 'js-hide'));
        }

        $formularz->input(new Input\TextArea('opis', array('atrybuty' => array('style' => 'width:70%;'))));
        $formularz->input(new Input\Checkbox('wydaj'));
        $formularz->stopka(new Input\Submit('zapisz'));
        $formularz->zamknijRegion('main');

        if($edycja)
        {
            $formularz->input('wybierzOdbiorce')->ustawWartosc(ucfirst($zamowienie->obiektOdbiorcy))->dodajAtrybuty(array('disabled' => 'disabled'));
            $formularz->input('opis')->ustawWartosc(ucfirst($zamowienie->opis));

            if($zamowienie->obiektOdbiorcy == 'Uzytkownik')
                $formularz->input('odbiorcaUzytkownik')->ustawWartosc($zamowienie->idOdbiorcy)->dodajAtrybuty(array('disabled' => 'disabled'));
            else
                $formularz->input('odbiorcaTeam')->ustawWartosc($zamowienie->idOdbiorcy)->dodajAtrybuty(array('disabled' => 'disabled'));
        }

        $formularz->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzFinalizuj'));

        if($formularz->wypelniony())
        {
            $wartosci = $formularz->pobierzWartosci();

            if($wartosci['wybierzOdbiorce'] == 'Uzytkownik')
            {
                if(isset($wartosci['dodajGrupowo']) && $wartosci['dodajGrupowo'])
                {
                    $formularz->input('odbiorcaUzytkownikLista')->dodajWalidator( new Walidator\NiePuste )->wymagany = true;
                    $idOdbiorcy = $wartosci['odbiorcaUzytkownikLista'];
                }
                else
                {
                    $formularz->input('odbiorcaUzytkownik')->dodajWalidator( new Walidator\NiePuste )->wymagany = true;
                    $idOdbiorcy = $wartosci['odbiorcaUzytkownik'];
                }
            }
            else if ($wartosci['wybierzOdbiorce'] == 'Team')
            {
                if(isset($wartosci['dodajGrupowo']) && $wartosci['dodajGrupowo'])
                {
                    $formularz->input('odbiorcaTeamLista')->dodajWalidator( new Walidator\NiePuste )->wymagany = true;
                    $idOdbiorcy = $wartosci['odbiorcaTeamLista'];
                }
                else
                {
                    $formularz->input ('odbiorcaTeam')->dodajWalidator( new Walidator\NiePuste )->wymagany = true;
                    $idOdbiorcy = $wartosci['odbiorcaTeam'];
                }
            }

            if($formularz->danePoprawne() && isset(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]) && count(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow']))
            {
                $idZamowieniaOdbiorcy = array();
                if($edycja)
                {
                    $id = $this->aktualizujZamowienie(Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['idZamowienia'], Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'], $wartosci['opis']);
                }
                else
                {
                    if(is_array($idOdbiorcy))
                    {
                        $wartosci['wydaj'] = false;
                        $id = 1;
                        foreach ($idOdbiorcy as $klucz => $id)
                            $idZamowieniaOdbiorcy[$id] = $this->zapiszZamowienie(ucfirst($wartosci['wybierzOdbiorce']), $id, $wartosci['opis'], Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'], $cms->profil()->id, 'zaakceptowane');
                    }
                    else
                    {
                        $id = $this->zapiszZamowienie(ucfirst($wartosci['wybierzOdbiorce']), $idOdbiorcy, $wartosci['opis'], Cms::inst()->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'], $cms->profil()->id, 'zaakceptowane');
                        $idZamowieniaOdbiorcy[$idOdbiorcy] = $id;
                    }
                }

                if($id)
                    ($wartosci['wydaj']) ? $this->finalizujZamowienieDoAkceptacji($id) : $this->finalizujZamowienieBezAkceptacji($idZamowieniaOdbiorcy);
                else
                    $this->komunikat($this->j->t['finalizujZamowienie.blad_zapisu_danych'], 'info');
            }
            else
                $this->komunikat($this->j->t['finalizujZamowienie.koszyk_pusty_blad_formularza'], 'error');

        }

        return $formularz;
    }

    private function finalizujZamowienieBezAkceptacji(Array $idZamowieniaOdbiorcy)
    {
        $this->usunProduktyZKoszyka(0);
        $this->komunikat($this->j->t['finalizujZamowienie.dane_zapisane'], 'info', 'sesja');

        foreach($idZamowieniaOdbiorcy as $idOdbiory => $idZamowienia)
        {
            $zamowienie = $this->dane()->MagazynWydane()->pobierzPoId($idZamowienia);

            if($zamowienie instanceof MagazynWydane\Obiekt )
            {
                $this->wyslijEmailZamowienieDoOdbioru($zamowienie);
            }
        }

        Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index', array('status' => 'zaakceptowane')));
    }

    private function finalizujZamowienieDoAkceptacji($id)
    {
        $this->usunProduktyZKoszyka(0);
        $this->komunikat($this->j->t['finalizujZamowienie.dane_zapisane'], 'info', 'sesja');
        Router::przekierujDo(Router::urlAdmin($this->kategoria, 'kartaZamowienia', array('id' => $id)));
    }

    private function aktualizujZamowienie($idZamowienia, $koszyk, $opis)
    {
        $cms = Cms::inst();
        $cms->baza()->transakcjaStart();

        $maperMagazynWydane = $this->dane()->MagazynWydane();
        $maperMagazynWydaneProdukty = $this->dane()->MagazynWydaneProdukty();
        $blad = 0;
        $zamowienie = $maperMagazynWydane->pobierzPoId($idZamowienia);
        if($zamowienie instanceof MagazynWydane\Obiekt)
        {
            $zamowienie->opis = $opis;
            if($zamowienie->zapisz($maperMagazynWydane))
            {
                $produkty = $zamowienie->pobierzProdukty();

                foreach($produkty as $produkt)
                {
                    $produktDoUsuniecia = $maperMagazynWydaneProdukty->pobierzPoId($produkt['idwydane']);
                    if(!$produktDoUsuniecia->usun($maperMagazynWydaneProdukty))
                        $blad++;
                }

                foreach ($koszyk as $idProdukt => $produkt)
                {
                    $obiektMagazynWydaneProdukty = new MagazynWydaneProdukty\Obiekt();
                    $obiektMagazynWydaneProdukty->idZamowienia = $zamowienie->id;
                    $obiektMagazynWydaneProdukty->idProduktu = $idProdukt;
                    $obiektMagazynWydaneProdukty->ilosc = $produkt['ilosc'];
                    $obiektMagazynWydaneProdukty->grupa = $produkt['grupa'];
                    $obiektMagazynWydaneProdukty->produktyGrupy = json_decode($produkt['produkty_grupy']);

                    if(!$obiektMagazynWydaneProdukty->zapisz($maperMagazynWydaneProdukty))
                        $blad++;
                }

            }
            else
                $blad++;
        }

        if($blad)
            $cms->Baza()->transakcjaCofnij();
        else
            $cms->Baza()->transakcjaPotwierdz();

        return $zamowienie->id;
    }

    /**
     *
     * @param string $obiektOdbiorcy
     * @param int $idOdbiorcy
     * @param string $opis
     * @param array $koszyk
     * @param int $idOsobyWydajacej
     * @return bool
     */
    private function zapiszZamowienie($obiektOdbiorcy, $idOdbiorcy, $opis, $koszyk, $idOsobyWydajacej, $status = 'oczekuje')
    {
        $cms = Cms::inst();
        $cms->baza()->transakcjaStart();

        $maperMagazynWydane = $this->dane()->MagazynWydane();
        $maperMagazynWydaneProdukty = $this->dane()->MagazynWydaneProdukty();

        $obiektMagazynWydane = new MagazynWydane\Obiekt();
        $odbiorca = $this->dane()->$obiektOdbiorcy()->pobierzPoId($idOdbiorcy);

        if(is_object($odbiorca))
            $obiektMagazynWydane->idOdbiorcy = $idOdbiorcy;
        else
            trigger_error('wprowadzono błędne parametry funkcji '.__FUNCTION__);

        $obiektMagazynWydane->opis = $opis;
        $obiektMagazynWydane->status = $status;
        $obiektMagazynWydane->obiektOdbiorcy = $obiektOdbiorcy;
        $obiektMagazynWydane->idOsobyWydajacej = $idOsobyWydajacej;


        $blad = 0;

        if($obiektMagazynWydane->zapisz($maperMagazynWydane))
        {
            foreach ($koszyk as $idProdukt => $produkt)
            {
                $obiektMagazynWydaneProdukty = new MagazynWydaneProdukty\Obiekt();
                if($produkt['grupa'])
                {
                    $produktGrupowy = $cms->dane()->ProduktyMagazyn()->pobierzPoId($idProdukt);

                    if($produktGrupowy instanceof ProduktyMagazyn\Obiekt)
                    {
                        $obiektMagazynWydaneProdukty->produktyGrupy = $produktGrupowy->produktyGrupy;
                    }
                }

                $obiektMagazynWydaneProdukty->idZamowienia = $obiektMagazynWydane->id;
                $obiektMagazynWydaneProdukty->idProduktu = $idProdukt;
                $obiektMagazynWydaneProdukty->ilosc = $produkt['ilosc'];
                $obiektMagazynWydaneProdukty->grupa = $produkt['grupa'];


                if(!$obiektMagazynWydaneProdukty->zapisz($maperMagazynWydaneProdukty))
                    $blad++;
                else
                    if(!$this->korygujIloscProduktow ($idProdukt, $produkt['ilosc']))
                        $blad++;
            }
        }
        else
            $blad++;

        if($blad)
            $cms->baza()->transakcjaCofnij();
        else
            $cms->baza()->transakcjaPotwierdz();


        return $obiektMagazynWydane->id;

    }

    /**
     *
     * @param type $idProduktu - id  ProdutkyMagazyn
     * @param type $ilosc - ilosc do skorygowania
     * @param type $akcja - mozliwe opcje zabierz, dodaj
     * @return boolean
     */
    private function korygujIloscProduktow($idProduktu, $ilosc, $akcja = 'zabierz')
    {

        $maperProdukty = $this->dane()->ProduktyMagazyn();
        $produkt = $maperProdukty->pobierzPoId($idProduktu);
        if($produkt instanceof ProduktyMagazyn\Obiekt)
        {
            if($akcja == 'zabierz')
            {
                $produkt->ilosc = $produkt->ilosc - $ilosc;
                $produkt->iloscWydanych = $produkt->iloscWydanych + $ilosc;
            }
            else
            {
                $produkt->ilosc = $produkt->ilosc + $ilosc;
                $produkt->iloscWydanych = $produkt->iloscWydanych - $ilosc;
            }

            if($produkt->zapisz($maperProdukty))
                return true;
        }

        return false;

    }

    public function wykonajKartaZamowienia()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['kartaZamowienia.tytul_strony'],
            'tytul_modulu' => $this->j->t['kartaZamowienia.tytul_modulu'],
        ));

        $idZamowienia = Zadanie::pobierzGet('id', 'intval', 'abs');

        if($idZamowienia > 0)
        {
            $magazyn = $this->dane()->MagazynWydane();
            $zamowienie = $magazyn->pobierzPoId($idZamowienia);

            if($zamowienie instanceof MagazynWydane\Obiekt)
            {
                /**
                 * @var Uzytkownik\Obiekt() $odbiorca
                 */
                $odbiorca = $zamowienie->pobierzOdbiorce();
                $produktyPobrane = $zamowienie->pobierzProdukty();
                $osobaWydajaca = $zamowienie->pobierzOsobeWydajaca();

                $osobaWydajacaNazwa = '';
                if($osobaWydajaca instanceof Uzytkownik\Obiekt)
                    $osobaWydajacaNazwa = $osobaWydajaca->imie.' '.$osobaWydajaca->nazwisko;

                $this->szablon->ustawBlok('kartaZamowienia/informacje', array(
                    'zamowienieNoEtykieta' => $this->j->t['kartaZamowienia.informacjeNo'],
                    'zamowienieNo' => $zamowienie->id,
                    'dataEtykieta' => $this->j->t['kartaZamowienia.dataEtykieta'],
                    'data' => ($zamowienie->dataWydania != '') ? $zamowienie->dataWydania->format('Y-m-d H:i:s') : date('d-m-Y') ,
                    'nazwa_tytul' => $this->j->t['kartaZamowienia.tytul'],
                    'from_etykieta' => $this->j->t['kartaZamowienia.from_etykieta'],
                    'from_nazwa_firmy' => $this->j->t['kartaZamowienia.from_nazwa_firmy'],
                    'from_ulica_firma' => $this->j->t['kartaZamowienia.from_ulica_firma'],
                    'from_miasto_firma' => $this->j->t['kartaZamowienia.from_miasto_firma'],
                    'osobaWydajacaNazwa' => $osobaWydajacaNazwa,
                    'osobaWydajacaEtykieta' => $this->j->t['kartaZamowienia.osobaWydajacaEtykieta'],
                    'produktIdEtykieta' => $this->j->t['kartaZamowienia.produktIdEtykieta'],
                    'produktCodeEtykieta' => $this->j->t['kartaZamowienia.produktCodeEtykieta'],
                    'produktNazwaEtykieta' => $this->j->t['kartaZamowienia.produktNazwaEtykieta'],
                    'produktIloscEtykieta' => $this->j->t['kartaZamowienia.produktIloscEtykieta'],
                    'iloscLacznieEtykieta' => $this->j->t['kartaZamowienia.iloscLacznieEtykieta'],
                    'iloscLacznie' => array_sum(listaZTablicy($produktyPobrane, 'id', 'ilosc')),
                ));
                $odbiorcaNazwa = '';
                if($odbiorca instanceof Uzytkownik\Obiekt)
                {
                    $odbiorcaNazwa = $odbiorca->imie.' '.$odbiorca->nazwisko;

                    $this->szablon->ustawBlok('kartaZamowienia/informacje/odbiorca', array(
                        'to_etykieta' => $this->j->t['kartaZamowienia.to_etykieta'],
                        'to_nazwa' => $odbiorca->imie.' '.$odbiorca->nazwisko,
                        'to_ulica' => $odbiorca->kontaktAdres,
                        'to_miasto' => $odbiorca->kontaktKodPocztowy.' '.$odbiorca->kontaktMiasto,
                    ));
                }
                elseif($odbiorca instanceof \Generic\Model\Team\Obiekt)
                {
                    $osobaAkceptujaca = $zamowienie->pobierzOsobeAkceptujaca();
                    if($osobaAkceptujaca!=null)
                        $odbiorcaNazwa = $osobaAkceptujaca->imie.' '.$osobaAkceptujaca->nazwisko;

                    $this->szablon->ustawBlok('kartaZamowienia/informacje/odbiorca', array(
                        'to_etykieta' => $this->j->t['kartaZamowienia.to_etykieta'],
                        'to_nazwa' => $odbiorca->teamNumber.' ( '.$odbiorcaNazwa.' ) ',
                    ));

                }

                foreach($produktyPobrane as $produkt)
                {
                    $this->szablon->ustawBlok('kartaZamowienia/informacje/produkt', array(
                        'produktId' => $produkt['id'],
                        'produktNazwa' => $produkt['nazwa_produktu'],
                        'produktKod' => $produkt['kod'],
                        'produktIlosc' => $produkt['ilosc'],
                    ));

                    if($produkt['grupa'])
                    {
                        $produktyGrupy = json_decode($produkt['produktygrupyzamowienie']);
                        $this->szablon->ustawBlok('kartaZamowienia/informacje/produkt/produktGrupyBlok/', array(
                            'produktCodeEtykieta' => $this->j->t['kartaZamowienia.produktCodeEtykieta'],
                            'produktNazwaEtykieta' => $this->j->t['kartaZamowienia.produktNazwaEtykieta'],
                            'produktIloscEtykieta' => $this->j->t['kartaZamowienia.produktIloscEtykieta'],
                        ));

                        foreach($produktyGrupy as $produktGrupy)
                        {
                            $this->szablon->ustawBlok('kartaZamowienia/informacje/produkt/produktGrupyBlok/produktGrupy', array(
                                'produktNazwaGrupa' => $produktGrupy->nazwa,
                                'produktIloscGrupa' => $produktGrupy->ilosc,
                                'produktKodGrupa' => $produktGrupy->kod,
                            ));
                        }

                    }
                }

                $wyswietlajFormularz = true;
                if($zamowienie->status == 'oczekuje' || $zamowienie->status == 'zaakceptowane')
                {
                    $inputPodpis = new Input\jSignature('podpis');
                    $inputPodpis->dodajWalidator(new Walidator\NiePuste())->wymagany = true;
                    $form = new Formularz('', 'podpisForm');

                    if($zamowienie->obiektOdbiorcy == 'Team')
                    {
                        $form->input($this->pobierzInputSelect($this->pobierzPracownikow(), 'id', array('imie', 'nazwisko'), 'idOsobyAkceptujacej'));
                        $form->input('idOsobyAkceptujacej')->dodajWalidator(new Walidator\NiePuste())->wymagany = true;
                        $team = $this->dane()->Team()->pobierzPoId($zamowienie->idOdbiorcy);
                        if($team instanceof \Generic\Model\Team\Obiekt)
                        {
                            $lider = $team->pobierzLideraTeamu();
                            if($lider != null) $form->input('idOsobyAkceptujacej')->ustawWartosc($lider->id);
                        }
                    }

                    $form->input($inputPodpis);
                    $form->stopka(new Input\Submit('zapisz',  array('atrybuty' => array('class' => 'btn btn-primary btn-block btn-lg'))));
                    $form->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzPodpis'));

                    if($form->wypelniony())
                    {
                        $wartosci = $form->pobierzWartosci();

                        if($form->danePoprawne())
                        {
                            $zamowienie->status = 'wydane';
                            $zamowienie->podpis = $wartosci['podpis']['wartosc'];
                            $zamowienie->podpisVector = $wartosci['podpis']['wartosc_vector'];
                            $zamowienie->typPodpisu = 'reczny';
                            $zamowienie->idOsobyWydajacej = Cms::inst()->profil()->id;

                            if(isset($wartosci['idOsobyAkceptujacej']))
                                $zamowienie->idOsobyAkceptujacej = $wartosci['idOsobyAkceptujacej'];

                            $data = new \DateTime(date('Y-m-d H:i:s'));
                            $zamowienie->dataWydania = $data;

                            if(!$zamowienie->zapisz($magazyn))
                                $this->komunikat($this->j->t['kartaZamowienia.blad_zapisu_podpisu'], 'error');
                            else
                            {
                                $this->komunikat($this->j->t['kartaZamowienia.zamowienie_zostalo_wydane'], 'info');
                                $wyswietlajFormularz = false;
                            }

                        }
                        else
                        {
                            $this->komunikat($this->j->t['kartaZamowienia.blad_formularza'], 'error');
                        }
                    }
                }
                if($zamowienie->status == 'wydane')
                {
                    $wyswietlajFormularz = false;
                    $this->szablon->ustawBlok('kartaZamowienia/informacje/podpis', array(
                        'podpisImg' => $zamowienie->podpis,
                        'podpisane_przez' => $this->j->t['kartaZamowienia.pdopisane_przez'],
                        'odbiorca' => $odbiorcaNazwa,
                    ));
                }
                if($zamowienie->status == 'anulowane')
                    $wyswietlajFormularz = false;

                if($wyswietlajFormularz)
                    $this->szablon->ustawBlok('kartaZamowienia/informacje/input', array('inputPodpis' => $form->html() ));
            }
            else
            {
                $this->komunikat($this->j->t['kartaZamowienia.zamowienieNieIstnieje'], 'error');
            }
        }
        else
        {
            $this->komunikat($this->j->t['kartaZamowienia.zamowienieNieIstnieje'], 'error');
        }

        $this->tresc .= $this->szablon->parsujBlok('kartaZamowienia',
            array(
                'zakladki' => $this->ustawZakladki('finalizacja'),
                'etykietaDrukuj' => $this->j->t['kartaZamowienia.etykietaDrukuj'],
                'etykietaNaglowek' => $this->j->t['kartaZamowienia.etykietaNaglowek'],
                'linkDrukuj' => Router::urlAjax('admin', $this->kategoria, 'drukujPdf', array( 'id' => $zamowienie->id )),
                'powrotEtykieta' => $this->j->t['kartaZamowienia.powrotEtykieta'],
                'urlPowrot' => Router::urlAdmin($this->kategoria, 'index'),
            )
        );
    }

    public function wykonajDrukujPdf()
    {
        $id = Zadanie::pobierzGet('id', 'intval', 'abs');
        if($id > 0)
        {
            $magazyn = $this->dane()->MagazynWydane();
            $zamowienie = $magazyn->pobierzPoId($id);
            $html = '';
            if($zamowienie instanceof MagazynWydane\Obiekt)
            {
                /**
                 * @var Uzytkownik\Obiekt() $odbiorca
                 */

                $odbiorca = $zamowienie->pobierzOdbiorce();
                $produktyPobrane = $zamowienie->pobierzProdukty();
                $osobaWydajaca = $zamowienie->pobierzOsobeWydajaca();

                $osobaWydajacaNazwa = '';
                if($osobaWydajaca instanceof Uzytkownik\Obiekt)
                    $osobaWydajacaNazwa = $osobaWydajaca->imie.' '.$osobaWydajaca->nazwisko;

                if($odbiorca instanceof Uzytkownik\Obiekt)
                {
                    $odbiorcaNazwa = $odbiorca->imie.' '.$odbiorca->nazwisko;

                    $odbiorcaTablica = array(
                        'to_etykieta' => $this->j->t['kartaZamowienia.to_etykieta'],
                        'to_nazwa' => $odbiorca->imie.' '.$odbiorca->nazwisko,
                        'to_ulica' => $odbiorca->kontaktAdres,
                        'to_miasto' => $odbiorca->kontaktKodPocztowy.' '.$odbiorca->kontaktMiasto,

                    );
                }
                elseif($odbiorca instanceof \Generic\Model\Team\Obiekt)
                {
                    $osobaAkceptujaca = $zamowienie->pobierzOsobeAkceptujaca();
                    $odbiorcaNazwa = $osobaAkceptujaca->imie.' '.$osobaAkceptujaca->nazwisko;

                    $odbiorcaTablica = array(
                        'to_etykieta' => $this->j->t['kartaZamowienia.to_etykieta'],
                        'to_nazwa' => $odbiorca->teamNumber.' ( '.$odbiorcaNazwa.' ) ',
                    );

                }
                $informacje = array(
                    'zamowienieNoEtykieta' => $this->j->t['kartaZamowienia.informacjeNo'],
                    'zamowienieNo' => $zamowienie->id,
                    'dataEtykieta' => $this->j->t['kartaZamowienia.dataEtykieta'],
                    'data' => ($zamowienie->dataWydania != '') ? $zamowienie->dataWydania->format('Y-m-d H:i:s') : date('d-m-Y') ,
                    'nazwa_tytul' => $this->j->t['kartaZamowienia.tytul'],
                    'from_etykieta' => $this->j->t['kartaZamowienia.from_etykieta'],
                    'from_nazwa_firmy' => $this->j->t['kartaZamowienia.from_nazwa_firmy'],
                    'from_ulica_firma' => $this->j->t['kartaZamowienia.from_ulica_firma'],
                    'from_miasto_firma' => $this->j->t['kartaZamowienia.from_miasto_firma'],
                    'osobaWydajacaNazwa' => $osobaWydajacaNazwa,
                    'osobaWydajacaEtykieta' => $this->j->t['kartaZamowienia.osobaWydajacaEtykieta'],
                    'produktIdEtykieta' => $this->j->t['kartaZamowienia.produktIdEtykieta'],
                    'produktCodeEtykieta' => $this->j->t['kartaZamowienia.produktCodeEtykieta'],
                    'produktNazwaEtykieta' => $this->j->t['kartaZamowienia.produktNazwaEtykieta'],
                    'produktIloscEtykieta' => $this->j->t['kartaZamowienia.produktIloscEtykieta'],
                    'iloscLacznieEtykieta' => $this->j->t['kartaZamowienia.iloscLacznieEtykieta'],
                    'iloscLacznie' => array_sum(listaZTablicy($produktyPobrane, 'id', 'ilosc')),
                );
                $this->szablon->ustawBlok(
                    'kartaZamowieniaPdf/informacje',
                    array_merge($informacje, $odbiorcaTablica)
                );


                foreach($produktyPobrane as $produkt)
                {
                    $this->szablon->ustawBlok('kartaZamowieniaPdf/informacje/produkt', array(
                        'produktId' => $produkt['id'],
                        'produktNazwa' => $produkt['nazwa_produktu'],
                        'produktKod' => $produkt['kod'],
                        'produktIlosc' => $produkt['ilosc'],
                    ));
                    if($produkt['grupa'])
                    {
                        $produktyGrupy = json_decode($produkt['produktygrupyzamowienie']);
                        $this->szablon->ustawBlok('kartaZamowieniaPdf/informacje/produkt/produktGrupyBlok/', array(
                            'produktCodeEtykieta' => $this->j->t['kartaZamowienia.produktCodeEtykieta'],
                            'produktNazwaEtykieta' => $this->j->t['kartaZamowienia.produktNazwaEtykieta'],
                            'produktIloscEtykieta' => $this->j->t['kartaZamowienia.produktIloscEtykieta'],
                        ));
                        foreach($produktyGrupy as $produktGrupy)
                        {
                            $this->szablon->ustawBlok('kartaZamowieniaPdf/informacje/produkt/produktGrupyBlok/produktGrupy', array(
                                'produktNazwaGrupa' => $produktGrupy->nazwa,
                                'produktIloscGrupa' => $produktGrupy->ilosc,
                                'produktKodGrupa' => $produktGrupy->kod,
                            ));
                        }

                    }
                }
                if($zamowienie->podpis != '')
                {
                    $this->szablon->ustawBlok('kartaZamowieniaPdf/informacje/podpis', array(
                        'podpisImg' => $zamowienie->podpis,
                    ));
                }

                $header = $this->szablon->parsujBlok('kartaZamowieniaPdf/header', array(
                    'logo' => Cms::inst()->katalog('public_temp').'logo_nowe.png',
                    'adres_etykieta' => $this->j->t['adres_etykieta'],
                    'adres_wartosc' => $this->j->t['adres_wartosc_post'],
                    'miasto_wartosc' => $this->j->t['miasto_wartosc_post'],
                    'telefon_etykieta' => $this->j->t['telefon_etykieta'],
                    'telefon_wartosc' => $this->j->t['telefon_wartosc'],
                    'email_etykieta' => $this->j->t['email_etykieta'],
                    'email_wartosc' => $this->j->t['email_wartosc'],
                    'www_etykieta' => $this->j->t['www_etykieta'],
                    'www_wartosc' => $this->j->t['www_wartosc'],
                    'bankgiro_etykieta' => $this->j->t['bankgiro_etykieta'],
                    'bankgiro_wartosc' => $this->j->t['bankgiro_wartosc'],
                    'org_numer_etykieta' => $this->j->t['org_numer_etykieta'],
                    'org_numer_wartosc' => $this->j->t['org_numer_wartosc'],
                    'znaczek_rozdziel' => $this->j->t['znaczek_rozdziel'],
                ));
                $html.= $this->szablon->parsujBlok('kartaZamowieniaPdf', array(
                    'tlo' => Cms::inst()->katalog('public_temp').'papier_tlo.jpg',
                ));
                $footer = $this->szablon->parsujBlok('kartaZamowieniaPdf/footer', array(
                    'adres_etykieta' => $this->j->t['adres_etykieta'],
                    'adres_wartosc' => $this->j->t['adres_wartosc_post'],
                    'miasto_wartosc' => $this->j->t['miasto_wartosc_post'],
                    'telefon_etykieta' => $this->j->t['telefon_etykieta'],
                    'telefon_wartosc' => $this->j->t['telefon_wartosc'],
                    'email_etykieta' => $this->j->t['email_etykieta'],
                    'email_wartosc' => $this->j->t['email_wartosc'],
                    'www_etykieta' => $this->j->t['www_etykieta'],
                    'www_wartosc' => $this->j->t['www_wartosc'],
                    'bankgiro_etykieta' => $this->j->t['bankgiro_etykieta'],
                    'bankgiro_wartosc' => $this->j->t['bankgiro_wartosc'],
                    'org_numer_etykieta' => $this->j->t['org_numer_etykieta'],
                    'org_numer_wartosc' => $this->j->t['org_numer_wartosc'],
                    'znaczek_rozdziel' => $this->j->t['znaczek_rozdziel'],
                ));

                $this->stworzPdf($header, $html, $footer);
            }
        }
    }

    private function stworzPdf($header, $html, $footer, $podglad = 1, $nazwaPliku = null, $katalogNazwa = null)
    {
        $cms = Cms::inst();
        set_error_handler(function($errno, $errstr, $errfile, $errline)
        {
            return true;
        });

        require_once $this->k->k['stworzPdf.sciezka_do_mPDF'];

        if(!defined('_MPDF_TEMP_PATH')) { define("_MPDF_TEMP_PATH", $cms->katalog('public_temp').'mPDF/tmp/'); }
        //if(!defined('_MPDF_TTFONTPATH')) { define('_MPDF_TTFONTPATH',$cms->katalog('public_temp').'mPDF/ttfonts/'); }
        //if(!defined('_MPDF_TTFONTDATAPATH')) { define('_MPDF_TTFONTDATAPATH',$cms->katalog('public_temp').'mPDF/ttfontdata/'); }

        $mPDF = new \mPDF('utf-8', 'A4', '10pt', 'oswald');

        $mPDF->SetMargins('10px', '10px', '50px');
        $mPDF->keep_table_proportions = true;
        $mPDF->SetVisibility('visible');
        $mPDF->SetHTMLHeader($header);
        $mPDF->SetHTMLFooter($footer);
        $mPDF->WriteHTML($html);
        if($podglad)
        {
            $mPDF->Output();
            restore_error_handler();
        }
        else
        {
            $katalog = $cms->katalog($katalogNazwa);

            $plikDoUsuniecia = new Plik($katalog.'/'.$nazwaPliku.'.pdf');
            if(is_file($plikDoUsuniecia))
            {
                $plikDoUsuniecia->usun();
            }

            $mPDF->Output($katalog.$nazwaPliku.'.pdf', 'F');
            $url = $cms->url($katalogNazwa, $nazwaPliku.'.pdf');
            return $url;
        }
    }


    /**
     *
     * @return array - lista pracownikow
     */
    private function pobierzPracownikow()
    {
        return listaZTablicy($this->dane()->Uzytkownik()->zwracaTablice()->szukaj(array('status' => 'aktywny')), 'id');
    }
    /**
     *
     * @return array - lista teamow
     */
    private function pobierzTeamy()
    {
        return listaZTablicy($this->dane()->Team()->zwracaTablice()->szukaj(array('status' => 'active')), 'id');
    }

    /**
     *
     * @param array $lista
     * @param int $klucz
     * @param array $wartosc
     * @return \Generic\Biblioteka\Input\Select
     */
    private function pobierzInputSelect($lista, $klucz, $wartosc, $nazwa, $attr = array())
    {
        $listaDoSelecta = array(
            0 => $this->j->t['select_wybierz_etykieta'],
        );

        foreach($lista as $zamawiajacy)
        {
            $wartoscSelect = '';
            foreach($wartosc as $w)
                $wartoscSelect .= (isset($zamawiajacy[$w])) ? ' '.$zamawiajacy[$w] : '';

            $listaDoSelecta[$zamawiajacy[$klucz]] = $wartoscSelect;
        }

        $select = new Input\Select($nazwa, array('lista' => $listaDoSelecta));
        $select->dodajFiltr('intval', 'abs');

        if(count($attr))
        {
            //$select->ustawParametry($attr);
            $select->dodajAtrybuty($attr);
        }

        return $select;
    }

    public function wykonajProduktyLista()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['produktylista.tytul_strony'],
            'tytul_modulu' => $this->j->t['produktylista.tytul_modulu'],
        ));

        $this->tresc .= $this->szablon->parsujBlok('produktyLista', array('zakladki' => $this->ustawZakladki('produkty')));
    }

    public function wykonajProduktyDodaj()
    {
        $przyjmijTowar = Zadanie::pobierz('przyjmijTowar', 'intval', 'abs');
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['dodajprodukt.tytul_strony'],
            'tytul_modulu' => $this->j->t['dodajprodukt.tytul_modulu'],
        ));

        $typ = Zadanie::pobierzGet('typ', 'strval');
        $id = Zadanie::pobierzGet('id', 'intval', 'abs');

        $formularz = $this->formularzDodajProdukt($id, $typ = 'produkty', $przyjmijTowar);

        $this->tresc .= $this->szablon->parsujBlok('dodajProdukt', array(
            'zakladki' => $this->ustawZakladki('produkty'),
            'formularz' => $formularz->html(),
        ));
    }

    private function formularzDodajProdukt($id = 0, $typ = 'produkty', $przyjmijTowar)
    {
        $produktMapper = Cms::inst()->dane()->ProduktyMagazyn();
        $produkt = new ProduktyMagazyn\Obiekt();
        if($id > 0)
            $produkt = $produktMapper->pobierzPoId($id);

        $kategorie = $this->dane()->KategorieMagazyn();
        $glowna = $kategorie->pobierzPoKodzie($typ);

        if ( ! ($glowna instanceof KategorieMagazyn\Obiekt) || ! in_array($glowna->kod, $this->kategorieGlowne))
        {
            $this->komunikat($this->j->t['drzewoKategorii.blad_nieprawidlowa_kategoria_glowna'], 'warning', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
            return;
        }
        $listaKategorii = $kategorie->zwracaTablice()->pobierzDlaKategoriiGlownej($typ);

        $formularz = new EdycjaProduktuMagazyn();
        $formularz->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzProduktyDodaj'))
            ->ustawKonfiguracje($this->pobierzKonfiguracje());
        $formularz->ustawObiekt($produkt)->ustawUrlPowrotny(Router::urlAdmin($this->kategoria, 'magazyn'));
        $formularz->zwrocFormularz()->input('kategoria')->ustawParametr('lista', $listaKategorii);


        if($formularz->wypelniony())
        {
            $ilosc = 0;
            $wartosci = $formularz->pobierzZmienioneWartosci();

            if( $formularz->danePoprawne()  )
            {
                $jestZdjecie = false;
                foreach($wartosci as $klucz => $wartosc )
                {
                    if($klucz == 'zdjecie')
                    {
                        if( $wartosc['name'] != '')
                        {
                            $jestZdjecie = true;
                            if($produkt->zdjecie != '')
                            {
                                foreach ($this->k->k['formularz.rozmiary_miniaturek_zdjecia'] as $prefix => $kod)
                                {
                                    $katalog = Cms::inst()->katalog('zdjecia_produktow', $produkt->id);
                                    $prefix = ($prefix != '') ? $prefix.'-' : '';
                                    $stare_zdjecie = new Plik\Zdjecie($katalog.$prefix.$produkt->zdjecie);
                                    $stare_zdjecie->usun();
                                }
                            }

                            $zdjecie = $wartosc;
                            $nazwaPliku = strtolower(hash_file('crc32', $zdjecie['tmp_name']).'.'.file_ext($zdjecie['name']));
                            $wartosc = $nazwaPliku;
                        }
                        else
                        {
                            $wartosc = null;
                        }
                    }


                    if(in_array($klucz, array('produktyGrupy', 'zalaczniki'))) continue;

                    $produkt->$klucz = $wartosc;
                }
                $produkt->idOsobyDodajacej = Cms::inst()->profil()->id;
                if(!$produkt->zapisz($produktMapper))
                    $this->komunikat ($this->j->t['produktyDodaj.blad_zapisu'], 'error');
                else
                {
                    if( isset($wartosci['zalaczniki']) && $wartosc['pliki'])
                    {
                        $katalogDocelowy = new Katalog(Cms::inst()->katalog('produktymagazyn', $produkt->id), true);
                        multiuploadPrzeniesPliki($wartosc['pliki'], $wartosc['token'], $wartosc['pliki'], $katalogDocelowy, 1);
                        $zalacznikMapper = $this->dane()->Zalacznik();
                        foreach($wartosc['pliki'] as $plik)
                        {
                            $zalacznik = new Zalacznik\Obiekt();
                            $zalacznik->idProjektu = ID_PROJEKTU;
                            $zalacznik->idObject = $produkt->id;
                            $zalacznik->object = 'ProduktyMagazyn';
                            $zalacznik->file = $plik['nazwa'];
                            $zalacznik->zapisz($zalacznikMapper);
                        }
                    }
                    if($jestZdjecie)
                    {
                        $katalog = Cms::inst()->katalog('zdjecia_produktow', $produkt->id);
                        $katalogDocelowy = new Biblioteka\Katalog($katalog, true);
                        $zdjecie = new Plik\Zdjecie($zdjecie['tmp_name']);

                        $zdjecie->przeniesDo($katalogDocelowy.'/'.$nazwaPliku);
                        foreach ($this->k->k['formularz.rozmiary_miniaturek_zdjecia'] as $prefix => $kod)
                        {
                            $prefix = ($prefix != '') ? $prefix.'-' : '';
                            if ($prefix == '') $usun = false;
                            $zdjecie->tworzMiniaturke($katalogDocelowy.'/'.$prefix.$nazwaPliku, $kod);
                        }
                    }

                    if($id > 0)
                    {
                        $this->komunikat ($this->j->t['produktyDodaj.komunikat_edycja_ok'], 'info' ,'sesja');
                        Router::przekierujDo(Router::urlAdmin($this->kategoria, 'produktyDodaj', array('id' => $produkt->id, 'typ' => 'produkty')));

                    }
                    else
                    {
                        $this->komunikat ($this->j->t['produktyDodaj.komunikat_dodano_produkt'], 'info');
                        $formularz->zwrocFormularz()->resetuj();
                    }

                }
            }
            else
                $this->komunikat ($this->j->t['produktyDodaj.blad_formularza'], 'error');
        }

        return $formularz;
    }

    private function sprawdzCzyProduktyGrupyTakieSame($listaDoSprawdzenia, $listaDoPorownania)
    {
        if(count($listaDoPorownania) <> count($listaDoSprawdzenia)) return false;

        $listaDoPorownania = listaZTablicy($listaDoPorownania, 'kod', 'ilosc');

        foreach($listaDoSprawdzenia as $produktGr)
        {
            if( !(isset($listaDoPorownania[$produktGr['kod']]) && $listaDoPorownania[$produktGr['kod']]['ilosc'] ==  $produktGr['ilosc']) )
                return false;
        }

        return true;
    }

    public function wykonajZapiszPlik()
    {
        $token = Zadanie::pobierz('token', 'trim');
        $id = Zadanie::pobierz('id', 'trim', 'intval');

        $result = multiuploadZapiszPlik($token, $id, 'zalacznik');

        echo json_encode($result);
        die;
    }

    public function wykonajUsunPlik()
    {
        $ids = Zadanie::pobierz('ids', 'trim', 'strtolower');
        $token = Zadanie::pobierz('token', 'trim');

        $ids = explode(',', $ids);

        foreach ($ids as $key => $val){if ($val < 1) unset($ids[$key]);}

        if (is_array($ids) && count($ids) > 0 && !empty($ids))
        {
            $mapper = new Zalacznik\Mapper();

            $zalaczniki = $mapper->szukaj(array(
                'status' => 'active',
                'id' => $ids,
            ));

            foreach ($zalaczniki as $zalacznik)
            {
                $zalacznik->status = 'delete';
                $zalacznik->zapisz($mapper);
                unset($ids[$zalacznik->id]);
            }
            $result = multiuploadUsunPlikiTemp($ids, $token);
        }
        else
        {
            $result['success'] = true;
        }

        echo json_encode($result);
        die;
    }

    private function liczIloscPoZmianie($iloscGrupa, $iloscGrupaPrzedZmiana, $iloscPaczka, $iloscPaczkaPrzedZmiana)
    {

        $wynikGrupa = 0;
        $wynikPaczka = 0;
        if($iloscGrupaPrzedZmiana == null && $iloscPaczkaPrzedZmiana == null)
        {
            $wynikGrupa = $iloscGrupa * $iloscPaczka;
        }
        else
        {
            if($iloscGrupaPrzedZmiana != $iloscGrupa)
            {
                $wynikGrupa = ($iloscGrupa - $iloscGrupaPrzedZmiana) * $iloscPaczka;
            }
            if($iloscPaczkaPrzedZmiana != $iloscPaczka)
            {
                if($iloscGrupaPrzedZmiana != $iloscGrupa)
                    $wynikPaczka = ($iloscPaczka - $iloscPaczkaPrzedZmiana) * ($iloscGrupa - $iloscGrupaPrzedZmiana);
                else
                    $wynikPaczka = ($iloscPaczka - $iloscPaczkaPrzedZmiana) * $iloscGrupa;

            }
        }
        if($wynikGrupa !=0)
            return $wynikGrupa - abs($wynikPaczka);
        else
            return $wynikPaczka;

    }

    private function walidujProduktyGrupy($idProduktu, $ilosc)
    {

        $produkt = Cms::inst()->dane()->ProduktyMagazyn()->pobierzPoId($idProduktu);
        $bledneProdukty = null;
        if($produkt->ilosc < $ilosc)
        {
            $bledneProdukty = array('id' => $idProduktu, 'nazwa' => $produkt->nazwaProduktu);
        }

        return $bledneProdukty;
    }

    public function wykonajUsunZdjecie()
    {
        $mapper = $this->dane()->ProduktyMagazyn();
        $produkt = $mapper->pobierzPoId(Zadanie::pobierz('id','intval','abs'));

        if ($produkt instanceof ProduktyMagazyn\Obiekt )
        {
            $katalog = new \Generic\Biblioteka\Katalog(Cms::inst()->katalog('zdjecia_produktow', $produkt->id));

            $bledy = 0;
            foreach ($this->k->k['formularz.rozmiary_miniaturek_zdjecia'] as $prefix => $kod)
            {
                $prefix = ($prefix != '') ? $prefix.'-' : '';
                $plik = new Plik($katalog.'/'.$prefix.$produkt->zdjecie);
                if (! ($plik->istnieje() && $plik->usun()))
                    $bledy++;
            }

            $produkt->zdjecie = null;
            if ($produkt->zapisz($mapper))
            {
                $this->komunikat($this->j->t['usunZdjecie.info_usunieto_zdjecie'], 'info', 'sesja');
            }
            else
            {
                $this->komunikat($this->j->t['usunZdjecie.blad_nie_mozna_usunac_zdjecia'], 'error', 'sesja');
            }

            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'produktyDodaj', array('id' => $produkt->id, 'typ' => 'produkty')));
        }
    }

    private function menuKategorii($typ, $nieWyswietlajZablokowanych = false)
    {
        if ( ! in_array($typ, $this->kategorieGlowne))
        {
            $this->komunikat($this->j->t['drzewoKategorii.blad_nieprawidlowa_kategoria_glowna'], 'warning', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
            return;
        }

        $kategorie = $this->dane()->KategorieMagazyn();
        $glowna = $kategorie->pobierzPoKodzie($typ);

        if ( ! ($glowna instanceof KategorieMagazyn\Obiekt) || ! in_array($glowna->kod, $this->kategorieGlowne))
        {
            $this->komunikat($this->j->t['drzewoKategorii.blad_nieprawidlowa_kategoria_glowna'], 'warning', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
            return;
        }
        $tresc = '';
        $poprzednia = null;
        foreach ($kategorie->zwracaTablice()->pobierzGalaz($glowna->id) as $kategoria)
        {
            if($kategoria['blokuj_wyswietlanie'] && $nieWyswietlajZablokowanych)
            {
                continue;
            }
            if ($kategoria['kod'] == $typ)
            {
                $tresc .= $this->szablon->parsujBlok('/kategoria_glowna', array(
                    'nazwa_kategorii' => $kategoria['nazwa'],
                    'poziom' => $kategoria['poziom'],
                    'id_kategorii' => $kategoria['id'],
                ));
                continue;
            }

            if ($poprzednia !== null)
            {
                $kategoria_poziom = (int)$kategoria['poziom'];
                $poprzednia_poziom = (int)$poprzednia['poziom'];
                if ($poprzednia_poziom < $kategoria_poziom)
                {
                    $tresc .= ($kategoria_poziom == 1) ? '' :$this->szablon->parsujBlok('/drzewo/listaStart');
                }
                elseif ($poprzednia_poziom == $kategoria_poziom)
                {
                    $tresc .= ($kategoria_poziom == 1) ? '' : $this->szablon->parsujBlok('/drzewo/elementStop');;
                }
                elseif ($poprzednia_poziom > $kategoria_poziom)
                {
                    $powtorzen = $poprzednia_poziom - $kategoria_poziom;
                    $tresc .= str_repeat($this->szablon->parsujBlok('/drzewo/elementStop').$this->szablon->parsujBlok('/drzewo/listaStop'), (int)$powtorzen);
                    $tresc .= $this->szablon->parsujBlok('/drzewo/elementStop');
                }

                $tresc .= $this->szablon->parsujBlok('/kategoria', array(
                    'nazwa_kategorii' => $kategoria['nazwa'],
                    'poziom' => $kategoria['poziom'],
                    'padding' => ($kategoria['poziom'] * 20) - $kategoria['poziom'],
                    'id_kategorii' => $kategoria['id'],
                    'blokuj_wyswietlanie' => $kategoria['blokuj_wyswietlanie'],
                    'blokuj_przypisywanie' => $kategoria['blokuj_przypisywanie'],
                ));
            }
            else
            {
                $tresc .= $this->szablon->parsujBlok('/kategoria', array(
                    'nazwa_kategorii' => $kategoria['nazwa'],
                    'poziom' => $kategoria['poziom'],
                    'padding' => ($kategoria['poziom'] * 20) - $kategoria['poziom'],
                    'id_kategorii' => $kategoria['id'],
                ));
            }
            $poprzednia = $kategoria;
        }

        return $this->szablon->parsujBlok('kategorieMenu', array(
            'kategorie' => $tresc,
        ));
    }

    /**
     * Metoda wyswietlajaca nowe drzewo kategorii
     * @return type
     */
    public function wykonajDrzewoKategorii()
    {

        $typ = Zadanie::pobierzGet('typ', 'strval');

        if($typ == '' || empty($typ) || $typ == null)
            $typ = 'produkty';


        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['drzewoKategorii.tytul_strony_'.$typ],
            'tytul_modulu' => $this->j->t['drzewoKategorii.tytul_modulu_'.$typ],
        ));

        if ( ! in_array($typ, $this->kategorieGlowne))
        {
            $this->komunikat($this->j->t['drzewoKategorii.blad_nieprawidlowa_kategoria_glowna'], 'warning', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
            return;
        }

        $kategorie = $this->dane()->KategorieMagazyn();
        $glowna = $kategorie->pobierzPoKodzie($typ);

        if ( ! ($glowna instanceof KategorieMagazyn\Obiekt) || ! in_array($glowna->kod, $this->kategorieGlowne))
        {
            $this->komunikat($this->j->t['drzewoKategorii.blad_nieprawidlowa_kategoria_glowna'], 'warning', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
            return;
        }

        $this->ustawGlobalne(array('tytul_strony' => $this->j->t['drzewoKategorii.tytul_strony_'.$typ]));

        $tresc = '';
        $poprzednia = null;
        foreach ($kategorie->zwracaTablice()->pobierzGalaz($glowna->id) as $kategoria)
        {
            if ($kategoria['kod'] == $typ)
            {
                $tresc .= $this->szablon->parsujBlok('/kategoria_glowna', array(
                    'nazwa_kategorii' => $kategoria['nazwa'],
                    'poziom' => $kategoria['poziom'],
                    'id_kategorii' => $kategoria['id'],
                ));
                continue;
            }

            if ($poprzednia !== null)
            {
                $kategoria_poziom = (int)$kategoria['poziom'];
                $poprzednia_poziom = (int)$poprzednia['poziom'];
                if ($poprzednia_poziom < $kategoria_poziom)
                {
                    $tresc .= ($kategoria_poziom == 1) ? '' :$this->szablon->parsujBlok('/drzewo/listaStart');;
                }
                elseif ($poprzednia_poziom == $kategoria_poziom)
                {
                    $tresc .= ($kategoria_poziom == 1) ? '' : $this->szablon->parsujBlok('/drzewo/elementStop');;
                }
                elseif ($poprzednia_poziom > $kategoria_poziom)
                {
                    $powtorzen = $poprzednia_poziom - $kategoria_poziom;
                    $tresc .= str_repeat($this->szablon->parsujBlok('/drzewo/elementStop').$this->szablon->parsujBlok('/drzewo/listaStop'), (int)$powtorzen);
                    $tresc .= $this->szablon->parsujBlok('/drzewo/elementStop');
                }

                $tresc .= $this->szablon->parsujBlok('/kategoria', array(
                    'nazwa_kategorii' => $kategoria['nazwa'],
                    'poziom' => $kategoria['poziom'],
                    'id_kategorii' => $kategoria['id'],
                    'blokuj_wyswietlanie' => $kategoria['blokuj_wyswietlanie'],
                    'blokuj_przypisywanie' => $kategoria['blokuj_przypisywanie'],
                ));
            }
            else
            {
                $tresc .= $this->szablon->parsujBlok('/kategoria', array(
                    'nazwa_kategorii' => $kategoria['nazwa'],
                    'poziom' => $kategoria['poziom'],
                    'id_kategorii' => $kategoria['id'],
                ));
            }
            $poprzednia = $kategoria;
        }

        $this->tresc .= $this->szablon->parsujBlok('drzewoKategorii', array(
            'kategorie' => $tresc,
            'link_sortowanie' => Router::urlAdmin($this->kategoria, 'sortowanie', array('typ' => $typ)),
            'link_usun_wszystkie' => Router::urlAdmin($this->kategoria, 'czysc', array('typ' => $typ)),
            'usun_confirm_naglowek' => $this->j->t['drzewokategorii.usun_confirm_naglowek'],
            'usun_confirm_tresc' => $this->j->t['drzewokategorii.usun_confirm_naglowek'],
            'typ' => $typ,
            'link_kategoria' => Router::urlAjax('Admin', $this->kategoria),
            'zakladki' => $this->ustawZakladki('kategorie'),
        ));
    }

    /**
     * Metoda do dodawania nowej galezi dla nowej wersji kategorii
     */
    public function wykonajDodaj()
    {
        $this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));
        $typ = Zadanie::pobierzGet('typ', 'strval','trim');
        $id = Zadanie::pobierzGet('id', 'intval','abs');
        $json = Zadanie::pobierzGet('json', 'strval');
        $mapper = $this->dane()->KategorieMagazyn();
        $rodzic = $mapper->pobierzPoId($id);

        if($rodzic instanceof KategorieMagazyn\Obiekt)
        {

            $kategoria = new KategorieMagazyn\Obiekt();
            $kategoria->idRodzica = $rodzic->id;


            $formularz = $this->budujFormularz($kategoria, 'dodaj');
            if ($formularz->wypelniony() && $formularz->danePoprawne() && $json == 'true')
            {
                $poziomRodzica = $rodzic->poziom + 1;
                $dzieci = $mapper->pobierzGalazDoPoziomu($id, $poziomRodzica);

                if (count($dzieci) > 0 )
                {
                    $nazwa = Zadanie::pobierzPost('nazwa', 'strval', 'trim');
                    foreach ($dzieci as $dziecko)
                    {
                        if (strtolower($dziecko->nazwa) == strtolower($nazwa))
                        {
                            $dane['tresc'] = $this->j->t['dodaj.blad_duplikacja_kategorii'];
                            $dane['typ'] = 'error';
                            $wynik['status'] = 2;
                            $wynik['html'] = $this->szablon->parsujBlok('komunikat', $dane);
                            echo json_encode($wynik);
                            die;
                        }
                    }
                }

                foreach ($formularz->pobierzZmienioneWartosci() as $klucz => $wartosc)
                {
                    if($klucz == 'nazwa')
                        $nazwa = $wartosc;

                    $kategoria->$klucz = $wartosc;
                }
                $kategoria->kod = usun_polskie_znaki($nazwa);
                $kategoria->kategoriaGlowna = $typ;

                $kategoria->blokujPrzypisywanie = (Zadanie::pobierzPost('blokujPrzypisywanie', 'intval','abs') != null) ? Zadanie::pobierzPost('blokujPrzypisywanie', 'intval','abs') : 0;
                $kategoria->blokujWyswietlanie = (Zadanie::pobierzPost('blokujWyswietlanie', 'intval','abs') != null) ? Zadanie::pobierzPost('blokujWyswietlanie', 'intval','abs') : 0;

                if ($kategoria->zapisz($mapper))
                {
                    /*
					if ($rodzic->poziom == 1)
						$kategoria->url = $kategoria->kod;
					else
						$kategoria->url = $rodzic->kod.'/'.$kategoria->kod;
					 *
					 */

                    $kategoria->zapisz($mapper);

                    $dane['tresc'] = $this->j->t['dodaj.info_zapisano_dane_kategorii'];
                    $dane['typ'] = 'info';
                    $wynik['status'] = 1;
                    $wynik['id'] = $id;
                    $wynik['id_dziecka'] = $kategoria->id;
                    $wynik['akcja'] = 'dodaj';
                    $wynik['blokujWyswietlanie'] = $kategoria->blokujWyswietlanie;
                    $wynik['blokujPrzypisywanie'] = $kategoria->blokujPrzypisywanie;
                    $wynik['nazwa'] = $kategoria->nazwa;
                    $wynik['html'] = $this->szablon->parsujBlok('komunikat', $dane);


                    echo json_encode($wynik);
                    die;
                }
                else
                {
                    $dane['tresc'] = $this->j->t['dodaj.blad_nie_mozna_zapisac_kategorii'];
                    $dane['typ'] = 'error';
                    $wynik['status'] = 2;
                    $wynik['html'] = $this->szablon->parsujBlok('komunikat', $dane);
                    echo json_encode($wynik);
                    die;
                }
            }
            $dane['formularz'] = $formularz->html();
            $dane['link_kategoria_zapisz'] = Router::urlAjax('Admin', $this->kategoria,'dodaj',array('typ'=>$typ, 'id'=> $id, 'json' => 'true'));

            if ($json == 'true')
            {
                $wynik['html'] = $this->szablon->parsujBlok('edytuj', $dane);
                echo json_encode($wynik);
                die;
            }
            else
            {
                $this->tresc .= $this->szablon->parsujBlok('edytuj', $dane);
            }

        }
        else
        {
            $this->komunikat($this->j->t['dodaj.blad_brak_kategorii_nadrzednej'],'error');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'drzewoKategorii', array('typ' => $typ)));
        }
    }


    /**
     * Metoda do edytowania galezi dla nowej wersji kategorii
     */
    public function wykonajEdytuj()
    {
        $mapper = $this->dane()->KategorieMagazyn();
        $id = Zadanie::pobierzGet('id', 'intval','abs');
        $json = Zadanie::pobierzGet('json', 'strval');
        $kategoria = $mapper->pobierzPoId($id);

        $typ = Zadanie::pobierzGet('typ', 'strval');

        if($kategoria instanceof KategorieMagazyn\Obiekt)
        {
            if ($kategoria->id < 2 || in_array($kategoria->kod, $this->kategorieGlowne))
            {
                $this->komunikat($this->j->t['edytuj.blad_nie_mozna_edytowac_kategorii'], 'warning', 'sesja');
                Router::przekierujDo(Router::urlAdmin($this->kategoria, 'drzewoKategorii'));
                return;
            }
            $this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony'].$kategoria->nazwa));

            $rodzic = $mapper->pobierzPoId($kategoria->idRodzica);
            $formularz = $this->budujFormularz($kategoria, 'edytuj', $rodzic);

            if ($formularz->wypelniony() && $formularz->danePoprawne() && $json == 'true')
            {
                $nazwa = Zadanie::pobierzPost('nazwa', 'strval', 'trim');
                if ($kategoria->nazwa != $nazwa)
                {
                    $dzieci = $mapper->pobierzGalazDoPoziomu($kategoria->idRodzica, $kategoria->poziom);

                    if (count($dzieci) > 0 )
                    {
                        foreach ($dzieci as $dziecko)
                        {
                            if (strtolower($dziecko->nazwa) == strtolower($nazwa))
                            {
                                $dane['tresc'] = $this->j->t['dodaj.blad_duplikacja_kategorii'];
                                $dane['typ'] = 'error';
                                $wynik['status'] = 2;
                                $wynik['html'] = $this->szablon->parsujBlok('komunikat', $dane);
                                $this->tresc .= json_encode($wynik);
                                return;
                            }
                        }
                    }
                }

                foreach ($formularz->pobierzZmienioneWartosci() as $klucz => $wartosc)
                {
                    if ($klucz == 'powiazane') continue;
                    if ($klucz == 'powiazaneNowa')
                    {
                        $wartosc = array_merge(explode(',', $kategoria->powiazaneKategorie), array($wartosc));
                        $wartosc = array_values(array_diff($wartosc, array(''))); // wywalamy puste pole
                        $kategoria->powiazaneKategorie = implode(',', array_unique($wartosc));
                        continue;
                    }
                    if ($klucz == 'blokujWyswietlanie')
                    {
                        $mapper->ustawBlokujWyswietlenieDlaGalezi($kategoria->lewy, $kategoria->prawy, $wartosc);
                        $blokujWyswietlanie = $wartosc;
                    }
                    if ($klucz == 'blokujPrzypisywanie')
                    {
                        $mapper->ustawBlokujPrzypisywanieDlaGalezi($kategoria->lewy, $kategoria->prawy, $wartosc);
                        $blokujPrzypisywanie = $wartosc;
                    }

                    $kategoria->$klucz = $wartosc;
                }
                $kategoria->kategoriaGlowna = $typ;
                if ($kategoria->zapisz($mapper))
                {
                    $dane['tresc'] = $this->j->t['edytuj.info_zapisano_dane_kategorii'];
                    $dane['typ'] = 'info';

                    $idKategorii = listaZObiektow($mapper->pobierzGalaz($kategoria->id), null, 'id');

                    $wynik['status'] = 1;
                    $wynik['id'] = $id;
                    $wynik['akcja'] = 'edytuj';
                    $wynik['nazwa'] = $kategoria->nazwa;
                    $wynik['idKategorii'] = implode(',', $idKategorii);
                    $wynik['blokujWyswietlanie'] = (isset($blokujWyswietlanie)) ? $blokujWyswietlanie : $kategoria->blokujWyswietlanie;
                    $wynik['blokujPrzypisywanie'] = (isset($blokujPrzypisywanie)) ? $blokujPrzypisywanie : $kategoria->blokujPrzypisywanie;
                    $wynik['html'] = $this->szablon->parsujBlok('komunikat', $dane);
                    $this->tresc .= json_encode($wynik);

                    return;
                }
                else
                {
                    $dane['tresc'] = $this->j->t['edytuj.blad_nie_mozna_zapisac_kategorii'];
                    $dane['typ'] = 'error';

                    $wynik['status'] = 2;
                    $wynik['html'] = $this->szablon->parsujBlok('komunikat', $dane);
                    $this->tresc .= json_encode($wynik);
                    return;
                }
            }
            $dane['formularz'] = $this->komunikatyHtml().$formularz->html();
            $dane['link_kategoria_zapisz'] = Router::urlAjax('Admin', $this->kategoria,'edytuj',array('typ'=>$typ, 'id'=> $id, 'json' => 'true'));
            if ($json == 'true')
            {
                $wynik['html'] = $this->szablon->parsujBlok('edytuj', $dane);
                $this->tresc .= json_encode($wynik);
            }
            else
            {
                $this->tresc .= $this->szablon->parsujBlok('edytuj', $dane);
            }
        }
        else
        {
            $this->komunikat($this->j->t['edytuj.blad_brak_kategorii'],'error');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'drzewoKategorii', array('typ' => $typ)));
        }
    }

    /**
     * Tworzy formularz edycji dla podanej kategorii
     *
     * @param KategoriaOgloszen $kategoria Obiekt kategorii
     *
     * @return Formularz
     */
    private function budujFormularz(KategorieMagazyn\Obiekt $kategoria, $akcja = null, $rodzic = null)
    {
        $kategorie = $this->dane()->KategorieMagazyn();
        $formularz = new Formularz('', 'kategoriaEdycja');

        $id = ($kategoria->id > 1) ? $kategoria->id : $kategoria->idRodzica;
        $sciezkaTablica = $kategorie->pobierzSciezke($id);
        $sciezka = array();
        foreach ($sciezkaTablica as $element)
        {
            if ($element->id > 1 && $element->id != $kategoria->id) $sciezka[] = $element->nazwa;
        }

        $sciezka = implode(' &raquo; ', $sciezka);
        $formularz->input(new Input\Html('sciezka', array(
            'wartosc' => $sciezka
        )));

        $formularz->input(new Input\Text('nazwa', array(
            'wartosc' => $kategoria->nazwa,
            'atrybuty' => array('maxlength' => 255),
        )))
            ->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

        $listaOpiekunowBaza = $this->dane()->Uzytkownik()->pobierzDlaRoliPoKodach($this->k->k['role_opiekunow_kategorii_prodoktow']);

        if(count($listaOpiekunowBaza))
        {
            $listaOpiekunow = array();
            foreach($listaOpiekunowBaza as $opiekun)
            {
                $listaOpiekunow[$opiekun->id] = $opiekun->imie.' '.$opiekun->nazwisko;
            }

            $formularz->input(new Input\Select('opiekun', array(
                'lista' => $listaOpiekunow,
                'wartosc' => $kategoria->opiekun,
            )))->dodajFiltr('strip_tags', 'filtr_xss', 'trim')->dodajWalidator(new Walidator\NiePuste());
            $formularz->opiekun->wymagany = true;
        }

        /*
		$formularz->otworzZbiorowyInput('generujDane');
		$formularz->input(new Input\Text('kod', array(
			'wartosc' => $kategoria->kod,
			'atrybuty' => array('maxlength' => 100),
		)))
			//->dodajWalidator(new Walidator\NiedozwoloneWartosci($this->kategorieGlowne))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$formularz->input(new Input\Button('generujKod', array(
			'wartosc' => $this->j->t['formularz.generujDane.nazwa'],
		)));
		$formularz->zamknijZbiorowyInput('generujDane');
 *
 */

        if ($akcja == 'edytuj')
        {
            if ($formularz->wypelniony())
            {
                $komunikat_obiekty = array();
                if (count($komunikat_obiekty) > 0)
                {
                    $komunikat_obiekty = sprintf($this->j->t['formularz.info_znaleziono_duplakcje_url'], implode(', ',$komunikat_obiekty));
                    $this->komunikat($komunikat_obiekty, 'info');
                }
            }

            if ($rodzic->poziom == 1)
            {
                $formularz->input(new Input\Hidden('kodRodzica',''));
            }
            else
            {
                $formularz->input(new Input\Hidden('kodRodzica', $rodzic->kod.'/'));
            }
        }

        $blokujWyswietlanie = 0;
        $blokujPrzypisywanie = 0;

        foreach ($sciezkaTablica as $element)
        {
            if ($element->id > 1 && $element->id != $kategoria->id)
            {
                if ($blokujWyswietlanie == 0 && $element->blokujWyswietlanie == 1)
                    $blokujWyswietlanie = 1;

                if ($blokujPrzypisywanie == 0 && $element->blokujPrzypisywanie == 1)
                    $blokujPrzypisywanie = 1;
            }
        }

        if ($blokujWyswietlanie == 0)
        {
            $formularz->input(new Input\Select('blokujWyswietlanie', array(
                'lista' =>  $this->k->k['formularz.lista_tak_nie'],
            )));
            $formularz->blokujWyswietlanie->ustawWartosc($kategoria->blokujWyswietlanie);
            //$formularz->blokujWyswietlanie->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($this->k->k['formularz.lista_tak_nie'])));
        }
        else
        {
            $formularz->input(new Input\Html('blokujWyswietlanie', array(
                'wartosc' => $this->j->t['formularz.info_zablokowana_zmiana_wyswietlania'],
            )));
        }

        if ($blokujPrzypisywanie == 0)
        {
            $formularz->input(new Input\Select('blokujPrzypisywanie', array(
                'lista' => $this->k->k['formularz.lista_tak_nie'],
            )));

            //		if ($kategoria->blokujPrzypisywanie === 0 || $kategoria->blokujPrzypisywanie === 1)
            $formularz->blokujPrzypisywanie->ustawWartosc($kategoria->blokujPrzypisywanie);
            //$formularz->blokujPrzypisywanie->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($this->k->k['formularz.lista_tak_nie'])));
        }
        else
        {
            $formularz->input(new Input\Html('blokujPrzypisywanie', array(
                'wartosc' => $this->j->t['formularz.info_zablokowana_zmiana_przypisywania'],
            )));
        }

        $formularz->stopka(new Input\Button('zapisz', array('atrybuty' => array('class' => 'btn btn-primary'))));
        $formularz->stopka(new Input\Button('wstecz', array(
            'atrybuty' => array('onclick' => 'zamknijModla()' )
        )));

        $formularz->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'));

        foreach ($formularz as $nazwaInputa => $input)
        {
            if (in_array($nazwaInputa, $this->k->k['formularz.wymagane_pola']))
            {
                $formularz->$nazwaInputa->wymagany = true;
                $formularz->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
            }
        }

        return $formularz;
    }

    /**
     * Metoda do usuwania galezi dla nowej wersji kategorii
     */
    public function wykonajUsun()
    {
        $typ = Zadanie::pobierzGet('typ', 'strval');

        $mapper = $this->dane()->KategorieMagazyn();
        $id = Zadanie::pobierzGet('id', 'intval','abs');
        $json = Zadanie::pobierzGet('json', 'strval');
        $kategoria = $mapper->pobierzPoId($id);
        if ($json == 'true')
        {
            if ($kategoria instanceof KategorieMagazyn\Obiekt)
            {
                $kopiaKategorii = clone($kategoria);
                if (in_array($kategoria->kod, $this->kategorieGlowne))
                {
                    $dane['tresc'] = $this->j->t['usun.blad_nie_mozna_usunac_kategorii_glownej'];
                    $dane['typ'] = 'error';

                    $wynik['status'] = 2;
                    $wynik['html'] = $this->szablon->parsujBlok('komunikat', $dane);
                    $this->tresc .= json_encode($wynik);
                    return;
                }
                elseif ($kategoria->usun($mapper))
                {

                    $dane['tresc'] = $this->j->t['usun.info_usuniecie_kategorii'];
                    $dane['typ'] = 'info';

                    $wynik['status'] = 1;
                    $wynik['id'] = $id;
                    $wynik['akcja'] = 'usun';
                    $wynik['html'] = $this->szablon->parsujBlok('komunikat', $dane);
                    $this->tresc .= json_encode($wynik);
                    return;
                }
                else
                {
                    $dane['tresc'] = $this->j->t['usun.blad_nie_mozna_usunac_kategorii'];
                    $dane['typ'] = 'error';

                    $wynik['status'] = 2;
                    $wynik['html'] = $this->szablon->parsujBlok('komunikat', $dane);
                    $this->tresc .= json_encode($wynik);
                    return;
                }
            }
            else
            {
                $dane['tresc'] = $this->j->t['usun.blad_brak_kategorii'];
                $dane['typ'] = 'error';

                $wynik['status'] = 2;
                $wynik['html'] = $this->szablon->parsujBlok('komunikat', $dane);
                $this->tresc .= json_encode($wynik);
            }
        }
        else
        {
            //sprawdzanie ogloszenia
            /**
             * blokada usuwania kategorii jezeli sa do niej jakies ogloszenia
             */
            $kryteria['kategoria_nowa'] = $id;
            $ogloszenia = $this->dane()->Ogloszenie()->szukaj($kryteria);

            $szablonUrl = Ogloszenie\Obiekt::szablonUrl();

            if (count($ogloszenia) > 0)
            {
                $wizytowkaMapper = $this->dane()->Wizytowka();
                $tabela = '';
                foreach ($ogloszenia as $ogloszenie)
                {
                    $this->wizytowka = $wizytowkaMapper->pobierzPoId($ogloszenie->idWizytowki);
                    $dane['nazwa_firmy'] = $this->wizytowka->firmaNazwa;
                    $dane['nazwa_ogloszenie'] = $ogloszenie->tytul;
                    $dane['link_ogloszenie'] = strtr($szablonUrl[$this->wizytowka->typ], array(
                        '{subdomena}' => $this->wizytowka->subdomena,
                        '{id_oferty}' => $ogloszenie->id,
                        '{url_oferty}' => tekstNaUrl($ogloszenie->tytul)
                    ));
                    $tabela .= $this->szablon->parsujBlok('usun_wiersz', $dane);
                }
                $html['tabela'] = $tabela;
                $html['etykieta_anuluj'] = $this->j->t['usun.etykieta_anuluj'];
                $html['etykieta_nazwa_firmy'] = $this->j->t['usun.etykieta_nazwa_firmy'];
                $html['etykieta_nazwa_ogloszenia'] = $this->j->t['usun.etykieta_nazwa_ogloszenia'];
                $html['etykieta_nazwa_zobacz'] = $this->j->t['usun.etykieta_nazwa_zobacz'];
                $html['etykieta_blad_usun'] = $this->j->t['usun.etykieta_blad_usun'];

                $this->tresc .= $this->szablon->parsujBlok('brak_usun', $html);
            }
            else
            {
                $dane['pytanie_usun'] = $this->j->t['usun.etykieta_potwierdzenie_usun'];
                $dane['usun'] = $this->j->t['usun.etykieta_usun'];
                $dane['link_kategoria_usun'] = Router::urlAjax('Admin', $this->kategoria,'usun',array('typ'=>$typ, 'id'=> $id, 'json' => 'true'));
                $dane['anuluj'] = $this->j->t['usun.etykieta_anuluj'];
                $this->tresc .= $this->szablon->parsujBlok('usun', $dane);
            }
        }
    }

    /**
     * Sortowanie kategorii
     * @return type
     */
    public function wykonajSortowanie()
    {
        $typ = Zadanie::pobierzGet('typ', 'strval');

        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['sortowanie.tytul_strony_'.$typ],
            'tytul_modulu' => $this->j->t['sortowanie.tytul_modulu_'.$typ],
        ));

        if ( ! in_array($typ, $this->kategorieGlowne))
        {
            $this->komunikat($this->j->t['sortowanie.blad_nieprawidlowa_kategoria_glowna'], 'warning', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
            return;
        }
        $mapper = $this->dane()->KategorieMagazyn();

        $glowna = $mapper->pobierzPoKodzie($typ);

        if ( ! ($glowna instanceof KategorieMagazyn\Obiekt) || ! in_array($glowna->kod, $this->kategorieGlowne))
        {
            $this->komunikat($this->j->t['sortowanie.blad_nieprawidlowa_kategoria_glowna'], 'warning', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
            return;
        }

        $this->ustawGlobalne(array('tytul_strony' => $this->j->t['sortowanie.tytul_strony_'.$typ]));

        $kategorie = $mapper->pobierzGalaz($glowna->id);

        $rozwin = array();
        if (count($kategorie) > 0)
        {
            $drzewo = '<div id="sortowanieKategorii"><ul id="root">'.
                '<li id="k_'.$glowna->id.'" rel="n_s_k" class="p'.$glowna->poziom.' n_s_k"><a href="#">'.$glowna->nazwa.'</a>'."\n"
                .'<ul>'."\n";
            $rozwin = array('k_'.$glowna->id);
            $poprzednia = null;
            foreach ($kategorie as $kategoria)
            {
                if ($poprzednia instanceof KategorieMagazyn\Obiekt)
                {
                    if ($poprzednia->poziom < $kategoria->poziom)
                    {
                        $drzewo .= ($kategoria->poziom == 1) ? '' : "\n".'<ul>';
                    }
                    elseif ($poprzednia->poziom == $kategoria->poziom)
                    {
                        $drzewo .= ($kategoria->poziom == 1) ? '' : '</li>';
                    }
                    elseif ($poprzednia->poziom > $kategoria->poziom)
                    {
                        $powtorzen = $poprzednia->poziom - $kategoria->poziom;
                        $drzewo .= str_repeat('</li>'."\n".'</ul>'."\n", (int)$powtorzen);
                        $drzewo .= "\n".'</li>';
                    }
                    $sortowalna = ($kategoria->poziom < 1) ? 'n_s_k' : 's_k';

                    $drzewo .= '<li id="k_'.$kategoria->id.'" rel="'.$sortowalna.'" class="p'.$kategoria->poziom.' '.$sortowalna.'"><a href="#">'.$kategoria->nazwa.'</a>'."\n";
                }
                $poprzednia = clone $kategoria;
            }
        }
        $drzewo .= str_repeat('</li>'."\n".'</ul>', $poprzednia->poziom);
        $drzewo .= '</li></ul></div>';

        $form = new Formularz(Router::urlAdmin($this->kategoria, 'sortowanie', array('typ' => $typ)), 'formularzSortowanie');

        $form->input(new Input\Hidden('przenoszona', ''));
        $form->input(new Input\Hidden('cel', ''));
        $form->input(new Input\Hidden('polozenie', ''));

        $form->stopka(new Input\Html('drzewo', '', array(
            'wartosc' => $drzewo
        )));

        if ($form->wypelniony() && $form->danePoprawne())
        {
            $dane = $form->pobierzWartosci();
            $dane['przenoszona'] = intval(str_replace('k_', '', $dane['przenoszona']));
            $dane['cel'] = intval(str_replace('k_', '', $dane['cel']));

            if ($dane['przenoszona'] < 2 || $dane['cel'] < 2)
            {
                $this->komunikat($this->j->t['sortowanie.blad_niepelne_dane_kategorii'], 'error', 'sesja');
                Router::przekierujDo(Router::urlAdmin($this->kategoria, 'sortowanie', array('typ' => $typ)));
            }
            if (!in_array($dane['polozenie'], array('before', 'after', 'inside')))
            {
                $this->komunikat($this->j->t['sortowanie.blad_nieprawidlowe_oznaczenie_polozenia'], 'error', 'sesja');
                Router::przekierujDo(Router::urlAdmin($this->kategoria, 'sortowanie', array('typ' => $typ)));
            }

            $przenoszona = $mapper->pobierzPoId($dane['przenoszona']);
            $cel = $mapper->pobierzPoId($dane['cel']);

            if ($przenoszona instanceof KategorieMagazyn\Obiekt && $przenoszona->poziom > 1
                && $cel instanceof KategorieMagazyn\Obiekt && $cel->poziom > 0)
            {
                if ($dane['polozenie'] == 'inside')
                {
                    if ($przenoszona->zmienRodzica($mapper, $cel->id))
                    {
                        $przenoszona->zapisz($mapper);
                        $this->komunikat($this->j->t['sortowanie.info_zmieniono_rodzica_kategorii'], 'info', 'sesja');
                        Router::przekierujDo(Router::urlAdmin($this->kategoria, 'sortowanie', array('typ' => $typ)));
                        return;
                    }
                    else
                    {
                        $this->komunikat($this->j->t['sortowanie.blad_nie_mozna_zmienic_rodzica_kategorii'], 'error');
                    }
                }
                else
                {
                    $dane['polozenie'] = ($dane['polozenie'] == 'before') ? 'przed' : 'po';

                    if ($przenoszona->idRodzica == $cel->idRodzica)
                    {
                        if ($przenoszona->przeniesObok($mapper, $cel->id, $dane['polozenie']))
                        {
                            $przenoszona->zapisz($mapper);
                            $this->komunikat($this->j->t['sortowanie.info_zmieniono_ustawienie_kategorii'], 'info', 'sesja');
                            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'sortowanie', array('typ' => $typ)));
                            return;
                        }
                        else
                        {
                            $this->komunikat($this->j->t['sortowanie.blad_nie_mozna_zmienic_ustawienia_kategorii'], 'error');
                        }
                    }
                    else
                    {
                        $this->komunikat($this->j->t['sortowanie.blad_nieprawidlowe_dane_sasiada'], 'warning');
                    }
                }
            }
            else
            {
                $this->komunikat($this->j->t['sortowanie.blad_nieprawidlowe_dane_kategorii'], 'error');
            }
        }
        $this->tresc .= $this->szablon->parsujBlok('sortowanie',array(
            'form' => $form->html(),
            'rozwin' => '"'.implode('","', $rozwin).'"',
            'zakladki' => $this->ustawZakladki('kategorie'),
        ));
    }

    public function wykonajWidokPracownika()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['widokPracownika.tytul_strony'],
            'tytul_modulu' => $this->j->t['widokPracownika.tytul_modulu'],
        ));

        $kryteria = array();
        $form = $this->formularzSzukaj(false);

        $this->komunikat($this->j->t['widokPracownika.komunikat_wybierz_team_lub_pracownika'], 'info');

        $idTeam = Zadanie::pobierz('idTeamu', 'intval', 'abs');
        $idPracownika = Zadanie::pobierz('idPracownika', 'intval', 'abs');

        if($form->wypelniony() || $idTeam > 0 || $idPracownika > 0 )
        {
            $kryteriaSzukaj = $form->pobierzWartosci();
            if((isset($kryteriaSzukaj['odbiorcaUzytkownik']) && $kryteriaSzukaj['odbiorcaUzytkownik'] > 0) || $idPracownika > 0)
            {
                $pracownik = $this->dane()->Uzytkownik()->pobierzPoId($kryteriaSzukaj['odbiorcaUzytkownik']);
                if($pracownik instanceof Uzytkownik\Obiekt)
                {
                    $idPracownika = $pracownik->id;
                    $tytulListaProduktowPracownika = str_replace('{PRACOWNIK}', $pracownik->imie.' '.$pracownik->nazwisko , $this->j->t['widokPracownika.tytul_pracownik_lista_produktow']);
                    $kryteria = array('odbiorcaUzytkownik' => $pracownik->id, 'status' => 'wydane', 'zwrocone' => false);
                    $listaProduktow = $this->dane()->MagazynWydane()->szukajZProduktami($kryteria);

                    $gridProduktyUzytkownika = $this->gridProdukty($listaProduktow, $pracownik->id, null, true);
                    $this->szablon->ustawBlok('widokPracownika/gridProduktyPracownika', array(
                        'pracownikNaglowek' => $pracownik->imie.' '.$pracownik->nazwisko,
                        'gridProduktyPracownika' => $gridProduktyUzytkownika->html(),
                        'tytulListaProduktowPracownika' => $tytulListaProduktowPracownika,
                    ));
                }
                else
                {
                    $this->komunikat($this->j->t['widokPracownika.pracownik_nie_istnieje'], 'error');
                }
            }
            if( (isset($kryteriaSzukaj['odbiorcaTeam']) && $kryteriaSzukaj['odbiorcaTeam'] > 0) || $idTeam > 0 )
            {
                $team = $this->dane()->Team()->pobierzPoId($kryteriaSzukaj['odbiorcaTeam']);
                if($team instanceof \Generic\Model\Team\Obiekt)
                {
                    $idTeam = $team->id;
                    $tytulListaProduktowTeamu = str_replace('{TEAM}', $team->teamNumber  , $this->j->t['widokPracownika.tytul_team_lista_produktow']);
                    $kryteria = array('odbiorcaTeam' => $team->id, 'status' => 'wydane', 'zwrocone' => false);

                    $listaProduktowTeamu = $this->dane()->MagazynWydane()->szukajZProduktami($kryteria);

                    $gridProduktyTeamu =  $this->gridProdukty($listaProduktowTeamu, null, $team->id, true);
                    $this->szablon->ustawBlok('widokPracownika/gridProduktyTeamu', array(
                        'teamNaglowek' => $team->teamNumber,
                        'produktyTeamu' => $gridProduktyTeamu->html(),
                        'tytulListaProduktowTeamu' => $tytulListaProduktowTeamu,
                    ));
                }
                else
                {
                    $this->komunikat($this->j->t['widokPracownika.team_nie_istnieje'], 'error');
                }
            }
        }

        $this->tresc .= $this->szablon->parsujBlok('widokPracownika',array(
            'form' => $form->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true),
            'zakladki' => $this->ustawZakladki('widokPracownika'),
            'etykietaZwrotProduktu' => $this->j->t['widokPracownika.etykietaZwrotProduktu'],
            'alertTytulNieZaznaczono' => $this->j->t['widokPracownika.alertTytulNieZaznaczono'],
            'alertTrescNieZaznaczono' => $this->j->t['widokPracownika.alertTrescNieZaznaczono'],
            'linkZwrocProdukty' => Router::urlAdmin($this->kategoria, 'zwrocProdukty', array('idTeamu' => $idTeam, 'idPracownika' => $idPracownika)),
        ));
    }

    // widok produktów do zwrotu z możliwością określenia stanu zwracanego produktu itp
    public function wykonajZwrocProdukty()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['zwrocProdukty.tytul_strony'],
            'tytul_modulu' => $this->j->t['zwrocProdukty.tytul_modulu'],
        ));

        $idTeamu = Zadanie::pobierz('idTeamu', 'intval', 'abs');
        $idPracownika = Zadanie::pobierz('idPracownika', 'intval', 'abs');
        $idProduktow = Zadanie::pobierz('ids', 'strval');

        if($idPracownika > 0)
        {
            $pracownik = $this->dane()->Uzytkownik()->pobierzPoId($idPracownika);
            if(!($pracownik instanceof Uzytkownik\Obiekt))
                $this->komunikat($this->j->t['zwrocProdukty.pracownik_nie_istnieje'], 'error');

            $inputSelectPrzekaz = $this->pobierzInputSelect($this->pobierzPracownikow(), 'id', array('imie', 'nazwisko'), 'odbiorcaUzytkownik');
            $zwrocProduktLabel = $this->j->t['zwrocProdukty.przekazLabel_pracownik'];
        }
        else
        {
            $team = $this->dane()->Team()->pobierzPoId($idTeamu);
            if(!($team instanceof \Generic\Model\Team\Obiekt))
                $this->komunikat($this->j->t['zwrocProdukty.team_nie_istnieje'], 'error');

            $inputSelectPrzekaz = $this->pobierzInputSelect($this->pobierzTeamy(), 'id', array('team_number'), 'odbiorcaTeam', array('class' => 'js-hide'));
            $zwrocProduktLabel = $this->j->t['zwrocProdukty.przekazLabel_team'];
        }

        $ids = explode(',', $idProduktow);

        $idsProdukty = array();
        $idsProduktyZGrupy = array();
        foreach($ids as $id)
        {
            $tab = explode('-', $id);
            if(isset($tab[1]))
            {
                (!isset($idsProduktyZGrupy[$tab[0]])) ? $idsProduktyZGrupy[$tab[0]] = array() : '';
                array_push ($idsProduktyZGrupy[$tab[0]], $tab[1]);
            }
            else
                array_push ($idsProdukty, $tab[0]);

        }

        if(count($idsProdukty) || count($idsProduktyZGrupy))
        {
            $maperWydaneProdukty = $this->dane()->MagazynWydaneProdukty()->zwracaTablice();
            $produktyDoZwrotu  = array();
            if(count($idsProdukty))
                $produktyDoZwrotu = $maperWydaneProdukty->szukaj(array('wiele_id' => $idsProdukty));

            /// produkty z grupy ale nie cała grupa
            $produktyGrupowe = array();
            if(count($idsProduktyZGrupy))
            {
                $maperProdukty = $this->dane()->ProduktyMagazyn()->zwracaTablice();
                $produktyGrupowe = $maperWydaneProdukty->zwracaTablice()->szukaj(array('wiele_id' => array_keys($idsProduktyZGrupy)));
                foreach ($idsProduktyZGrupy as $grupa => $produkty)
                {
                    $produktyGrupy[$grupa] = $maperProdukty->szukaj(array('ids' => $produkty));
                }
            }

            if(count($produktyDoZwrotu) || count($produktyGrupowe))
            {
                $stanLista = array();
                foreach($this->k->k['zwrocProdukty.stanProduktu'] as $stan)
                {
                    if(isset($this->j->t['zwrocProdukty.stan_produktu'][$stan]))
                        $stanLista[$stan] = $this->j->t['zwrocProdukty.stan_produktu'][$stan];
                    else
                        trigger_error('Nie zaleziono tłumaczenia dla stanu: '.$stan);
                }

                $inputSelect = new Input\Select('stan[]', array('lista' => $stanLista, 'atrybuty' => array('class' => 'stan')));
                $inputSelect->ustawWartosc('uzywany');
                $stanInput = $inputSelect->pobierzHtml();

                foreach($produktyGrupowe as $grupa)
                {
                    foreach($produktyGrupy[$grupa['idwydane']] as $produkt)
                    {
                        $grupaP = json_decode($grupa['produktygrupyzamowienie']);
                        $this->parsujWierszZwrocProdukty($stanInput, array(
                            'idwydane' => $grupa['idwydane'].'-'.$produkt['id'],
                            'kod' => $produkt['kod'],
                            'zdjecie' => $produkt['zdjecie'],
                            'nazwa_produktu' => $produkt['nazwa_produktu'].' <small>( '.$grupa['nazwa_produktu'].' )</small> ',
                            'ilosc' => $grupaP->$produkt['id']->ilosc,
                            'iloscmagazyn' => $produkt['ilosc'],
                            'id_produktu' => $produkt['id'],
                        ), '', false, false, 'grupa', false);
                    }
                }
                foreach($produktyDoZwrotu as $produkt)
                {
                    $this->parsujWierszZwrocProdukty($stanInput, $produkt, 'produktGrupaPoczatek');
                    if($produkt['grupa'])
                    {
                        $produktyGrupy = $this->pobierzProduktyGrupy($produkt);
                        $i = 0;
                        $iloscPrGr = count($produktyGrupy);
                        foreach($produktyGrupy as $prGr)
                        {
                            $klasa = ($iloscPrGr == $i) ? 'produktGrupaKoniec' : '';
                            $this->parsujWierszZwrocProdukty($stanInput, array(
                                'idwydane' => $produkt['idwydane'].'-'.$prGr['id_produktu'],
                                'kod' => $prGr['kod'],
                                'zdjecie' => $prGr['zdjecie'],
                                'nazwa_produktu' => $prGr['nazwa_produktu'].' <small>( '.$produkt['nazwa_produktu'].' )</small> ',
                                'ilosc' => $prGr['ilosc_uzytkownik'],
                                'iloscmagazyn' => $prGr['iloscmagazyn'],
                                'id_produktu' => $prGr['id_produktu'],
                            ), $klasa, true, true, 'grupa');
                        }
                    }
                }
            }
            else
            {
                $this->komunikat($this->j->t['zwrocProdukty.wybraneProduktyNieZostalyZnalezione'], 'error');
            }
        }
        else
        {
            $this->komunikat($this->j->t['zwrocProdukty.nieWybranoProduktowDoZwrotu'], 'error');
        }

        $this->tresc .= $this->szablon->parsujBlok('zwrocProdukty',array(
            'zakladki' => $this->ustawZakladki('widokPracownika'),
            'kodEtykieta' => $this->j->t['zwrocProdukty.kodEtykieta'],
            'iloscEtykieta' => $this->j->t['zwrocProdukty.iloscEtykieta'],
            'zdjecieEtykieta' => $this->j->t['zwrocProdukty.zdjecieEtykieta'],
            'nazwaEtykieta' => $this->j->t['zwrocProdukty.nazwaEtykieta'],
            'opisEtykieta' => $this->j->t['zwrocProdukty.opisEtykieta'],
            'statusEtykieta' => $this->j->t['zwrocProdukty.statusEtykieta'],
            'etykietaZatwierdzZwrot' => $this->j->t['zwrocProdukty.etykietaZatwierdzZwrot'],
            'przekazEtykieta' => $this->j->t['zwrocProdukty.przekazEtykieta'],
            'przekazLabel' => $zwrocProduktLabel,
            'wymienEtykieta' => $this->j->t['zwrocProdukty.wymienEtykieta'],
            'inputSelectPrzekaz' => $inputSelectPrzekaz->pobierzHtml(),
            'linkZatwierdzZwrotProduktow' => Router::urlAdmin($this->kategoria, 'zatwierdzZwrotProduktow', array('idTeamu' => $idTeamu, 'idPracownika' => $idPracownika)),
            'powrotDoListaProduktowEtykieta' => $this->j->t['zwrocProdukty.powrotDoListaProduktowEtykieta'],
            'powrotDoListaProduktowUrl' => Router::urlAdmin($this->kategoria, 'widokPracownika', array('idTeamu' => $idTeamu, 'idPracownika' => $idPracownika)),
            'stanProduktuKosz' => '"'.implode('","',$this->k->k['zwrocProdukty.stanProduktuKosz']).'"',
            'idTeamu' => $idTeamu,
            'idPracownika' => $idPracownika,
        ));
    }

    // zwraca wybrane produkty do magazynu
    public function wykonajZatwierdzZwrotProduktow()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['zatwierdzZwrotProduktow.tytul_strony'],
            'tytul_modulu' => $this->j->t['zatwierdzZwrotProduktow.tytul_modulu'],
        ));

        $ids = Zadanie::pobierz('id');
        $ilosc = Zadanie::pobierz('ilosc');
        $opis = Zadanie::pobierz('opis');
        $stan = Zadanie::pobierz('stan');

        $przekazUzytkownikowi = (count(Zadanie::pobierz('przekazUzytkownikowi'))) ? Zadanie::pobierz('przekazUzytkownikowi') : array() ;
        $zmienNaNowe = (count(Zadanie::pobierz('zmienNaNowe'))) ? Zadanie::pobierz('zmienNaNowe') : array() ;
        // obiekt do przekazania produktow
        $odbiorcaUzytkownik = Zadanie::pobierz('odbiorcaUzytkownik');
        $odbiorcaTeam = Zadanie::pobierz('odbiorcaTeam');
        // obiekt zwracający
        $idTeamu = Zadanie::pobierz('idTeamu');
        $idPracownika = Zadanie::pobierz('idPracownika');

        $przekazProduktTypObiektu = null;
        $przekazProduktIdObiektu = null;

        if( $odbiorcaUzytkownik > 0 )
        {
            $przekazProduktIdObiektu = $odbiorcaUzytkownik;
            $przekazProduktTypObiektu = 'Uzytkownik';
        }
        elseif($odbiorcaTeam > 0)
        {
            $przekazProduktIdObiektu = $odbiorcaTeam;
            $przekazProduktTypObiektu = 'Team';
        }

        if($idPracownika > 0)
        {
            $wymienProduktNaNowyIdOdbiorcy = $idPracownika;
            $wymienProduktNaNowyObiektOdbiorcy = 'Uzytkownik';
        }
        else if($idTeamu > 0)
        {
            $wymienProduktNaNowyIdOdbiorcy = $idTeamu;
            $wymienProduktNaNowyObiektOdbiorcy = 'Team';
        }

        $cms = Cms::inst();
        $blad = 0;
        $cms->Baza()->transakcjaStart();

        $maperMagazynPrzyjete = $cms->dane()->MagazynPrzyja();
        $maperMagazynWydaneProdukty = $cms->dane()->MagazynWydaneProdukty();
        $maperMagazynPrzyjeteProdukty = $cms->dane()->MagazynPrzyjeteProdukty();
        $maperMagazynProdukty = $cms->dane()->ProduktyMagazyn();

        $magazynPrzyja = new MagazynPrzyja\Obiekt();
        $magazynPrzyja->idPrzyjmujacego = $cms->profil()->id;
        $magazynPrzyja->zwrot = true;
        $magazynPrzyja->idOddajacego = $wymienProduktNaNowyIdOdbiorcy;
        $magazynPrzyja->obiektOddajacy = $wymienProduktNaNowyObiektOdbiorcy;

        $produktyGrupoweZwracaneWCalosci = array();
        $idProduktowDoWymianyNaNowy = array();
        $idProduktowPrzekazUzytkownikowi = array();

        if($magazynPrzyja->zapisz($maperMagazynPrzyjete))
        {
            $i = 0;
            foreach($ids as $idProdukWydany)
            {
                $idPr = explode('-', $idProdukWydany);

                // zwracamy produkt nalerzacy do grupy produktów
                if(isset($idPr[1]))
                {
                    if(in_array($idPr[0], $produktyGrupoweZwracaneWCalosci)){ $i++; continue ; }

                    $grupaProduktow = $maperMagazynWydaneProdukty->pobierzPoId($idPr[0]);
                    $produktZGrupy = $maperMagazynProdukty->pobierzPoId($idPr[1]);
                    if($produktZGrupy instanceof ProduktyMagazyn\Obiekt)
                    {
                        if(!$this->zwrocProduktZGrupy($grupaProduktow, $produktZGrupy, $stan[$i], $ilosc[$i], $opis[$i], $magazynPrzyja->id)) $blad++;

                        if(in_array($idProdukWydany, $zmienNaNowe))
                            $idProduktowDoWymianyNaNowy[$idPr[1]] =  array('id' => $idPr[1], 'ilosc' => $ilosc[$i], 'produktZGrupy' => true);

                        if(in_array($idProdukWydany, $przekazUzytkownikowi))
                            $idProduktowPrzekazUzytkownikowi[$idPr[1]] =  array('id' => $idPr[1], 'ilosc' => $ilosc[$i], 'produktZGrupy' => true);

                        /*
						$magazynPrzyjetyProdukt = new MagazynPrzyjeteProdukty\Obiekt();
						$magazynPrzyjetyProdukt->idMagazynPrzyja = $magazynPrzyja->id;
						$magazynPrzyjetyProdukt->idProduktu = $produktZGrupy->id;
						$magazynPrzyjetyProdukt->ilosc = $ilosc[$i];
						$magazynPrzyjetyProdukt->opis = $opis[$i];
						$magazynPrzyjetyProdukt->stan = $stan[$i];
						$magazynPrzyjetyProdukt->produktZGrupy = $idPr[0];
						 *
						 */

                        $produktyGrupy = $grupaProduktow->produktyGrupy;
                        unset($produktyGrupy[$produktZGrupy->id]);
                        $grupaProduktow->produktyGrupy = $produktyGrupy;
                        $grupaProduktow->zapisz($maperMagazynWydaneProdukty);

                        //if(!$magazynPrzyjetyProdukt->zapisz($maperMagazynPrzyjeteProdukty))
                        //$blad++;
                    }
                    $i++;
                    continue;
                }

                $produktDoZwrotu = $maperMagazynWydaneProdukty->pobierzPoId($idProdukWydany);
                if($produktDoZwrotu instanceof MagazynWydaneProdukty\Obiekt)
                {
                    if(in_array($idProdukWydany, $zmienNaNowe))
                        $idProduktowDoWymianyNaNowy[$produktDoZwrotu->idProduktu] =  array('id' => $produktDoZwrotu->idProduktu, 'ilosc' => $ilosc[$i], 'produktZGrupy' => false);

                    if(in_array($idProdukWydany, $przekazUzytkownikowi))
                        $idProduktowPrzekazUzytkownikowi[$produktDoZwrotu->idProduktu] =  array('id' => $produktDoZwrotu->idProduktu, 'ilosc' => $ilosc[$i], 'produktZGrupy' => false);

                    $magazynPrzyjetyProdukt = new MagazynPrzyjeteProdukty\Obiekt();
                    $stworzNowyProdukt = false;
                    // produkt grupowy zwracany w całosci
                    if($produktDoZwrotu->grupa)
                    {
                        array_push($produktyGrupoweZwracaneWCalosci, $produktDoZwrotu->id);
                        if(!$this->zwrocProduktGrupowy($produktDoZwrotu, $stan[$i], $ilosc[$i], $opis[$i], $stan, $ilosc, $opis, $magazynPrzyja->id, $ids)) $blad++;
                        /*
						$produktyGrupy = array();

						foreach($produktDoZwrotu->produktyGrupy as $produkt)
						{
							$klucz = array_search($produktDoZwrotu->id.'-'.$produkt['id'], $ids);

							$stworzNowyProdukt = (in_array($stan[$klucz], $this->k->k['zwrocProdukty.stanProduktuKosz'])) ? true : $stworzNowyProdukt;

							$produktyGrupy[$produkt['id']] = array(
								'id' => $produkt['id'],
								'nazwa' => $produkt['nazwa'],
								'ilosc' => $ilosc[$klucz],
								'stan' => $stan[$klucz],
								'opis' => $opis[$klucz],
								'kod' => $produkt['kod'],
							);
						}
						/*
						*  jezeli jeden z produktow grupy nie nadaje sie do uzytku i cała grupa nie została oznaczona jako nie nadajaca
						* sie do uzytku
						* tworzymy nowy niepelny produkt
						*  i przypisujemy go do kategorii produktow niepelnych
						*/
                        /*
						if($stworzNowyProdukt && !in_array($stan[$i], $this->k->k['zwrocProdukty.stanProduktuKosz']))
						{
							$produktDoSklonownia = $maperMagazynProdukty->pobierzPoId($produktDoZwrotu->idProduktu);

							if($produktDoSklonownia instanceof ProduktyMagazyn\Obiekt)
							{
								$nowyProdukt = new ProduktyMagazyn\Obiekt();
								foreach($produktDoSklonownia as $propercja => $wartosc)
								{
									if(in_array($propercja, array('id', 'idProjektu', 'produktyGrupy'))) continue;
									$nowyProdukt->$propercja = $wartosc;
								}
								$nowyProdukt->kategoria = $this->k->k['zwrocProdukty.kategoria_produkty_niepelne'];
								$nowyProdukt->produktyGrupy = $produktyGrupy;
								$nowyProdukt->ilosc = $ilosc[$i];
								$nowyProdukt->idOsobyDodajacej = Cms::inst()->profil()->id;
								$nowyProdukt->zapisz($maperMagazynProdukty);
								$this->komunikat($this->j->t['zwrocProdukty.produktPrzeniesionyDoGrupyNieplene'], 'info', 'sesja');
							}
						}
						$magazynPrzyjetyProdukt->produktyGrupy = $produktyGrupy;
						*/
                    }
                    else
                    {
                        if(!$this->zwrocProduktZwykly($produktDoZwrotu, $stan[$i], $ilosc[$i], $opis[$i], $magazynPrzyja->id)) $blad++;
                    }
                    /*
					$magazynPrzyjetyProdukt->idMagazynPrzyja = $magazynPrzyja->id;
					$magazynPrzyjetyProdukt->idProduktu = $produktDoZwrotu->idProduktu;
					$magazynPrzyjetyProdukt->ilosc = $ilosc[$i];
					$magazynPrzyjetyProdukt->opis = $opis[$i];
					$magazynPrzyjetyProdukt->stan = $stan[$i];

					// produkt nie nadajacy sie do uzytku
					if(in_array($stan[$i], $this->k->k['zwrocProdukty.stanProduktuKosz']) || $stworzNowyProdukt)
					{
						// zmieniamy w MagazynWydaneProdukty ale nie dodajemy w MagazynProduktu
						$produktDoZwrotu->zwrot = $ilosc[$i];
						if(!$produktDoZwrotu->zapisz($maperMagazynWydaneProdukty))
							$blad++;
					}
					// produkt przeznaczon do serwisu
					elseif(in_array($stan[$i], $this->k->k['zwrocProdukty.stanProduktuSerwis']))
					{
						$produktDoZwrotu->zwrot = $ilosc[$i];
						if(!$produktDoZwrotu->zapisz($maperMagazynWydaneProdukty))
							$blad++;

						$produktDoSklonownia = $maperMagazynProdukty->pobierzPoId($produktDoZwrotu->idProduktu);
						if($produktDoSklonownia instanceof ProduktyMagazyn\Obiekt)
						{
							$nowyProdukt = new ProduktyMagazyn\Obiekt();
							foreach($produktDoSklonownia as $propercja => $wartosc)
							{
								if(in_array($propercja, array('id', 'idProjektu', 'produktyGrupy'))) continue;
								$nowyProdukt->$propercja = $wartosc;
							}
							$nowyProdukt->kategoria = $this->k->k['zwrocProdukty.kategoria_produkty_serwis'];
							$nowyProdukt->ilosc = $ilosc[$i];
							$nowyProdukt->produktyGrupy = json_encode($nowyProdukt->produktyGrupy);
							$nowyProdukt->idOsobyDodajacej = Cms::inst()->profil()->id;
							$nowyProdukt->zapisz($maperMagazynProdukty);
							$this->komunikat($this->j->t['zwrocProdukty.produktPrzeniesionyDoGrupySerwis'], 'info', 'sesja');
						}

					}
					else // produkt nadajacy sie do ponownego użytku
					{
						// zmieniamy w MagazynWydaneProdukty i dodajemy w MagazynProduktu
						$produktDoZwrotu->zwrot = $ilosc[$i];
						if(!$produktDoZwrotu->zapisz($maperMagazynWydaneProdukty))
							$blad++;

						$produktMagazyn = $maperMagazynProdukty->pobierzPoId($produktDoZwrotu->idProduktu);
						if($produktMagazyn instanceof ProduktyMagazyn\Obiekt)
						{
							$produktMagazyn->ilosc = $produktMagazyn->ilosc +  $ilosc[$i];
							if(!$produktMagazyn->zapisz($maperMagazynProdukty))
								$blad++;
						}
						else
						{
							trigger_error('Zwracany produkt '.$produktDoZwrotu->idProduktu.' nie został znaleziony w magazynie');
						}
					}

					if(!$magazynPrzyjetyProdukt->zapisz($maperMagazynPrzyjeteProdukty))
						$blad++;
					 *
					 */

                }
                else
                    trigger_error('Zwracany produkt '.$idProdukWydany.' nie został znaleziony na stanie produków wydanych uzytkownikowi  '.$idPracownika);

                $i++;
            }
        }
        else
            $blad++;

        if($blad)
        {
            $this->komunikat($this->j->t['zatwierdzZwrotProduktow.wystapilyBledyPodczasZwrotu'], 'error');
            $cms->Baza()->transakcjaCofnij();
        }
        else
        {
            $cms->Baza()->transakcjaPotwierdz();
            $idZamowieniaWymienProdukty = $this->wymienProduktNaNowy($idProduktowDoWymianyNaNowy, $wymienProduktNaNowyObiektOdbiorcy, $wymienProduktNaNowyIdOdbiorcy);
            $idZamowieniaPrzekazProdukty = $this->przekazProduktyUzytkownikowi($idProduktowPrzekazUzytkownikowi, $przekazProduktTypObiektu , $przekazProduktIdObiektu);


            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'kartaZwrotuProduktow', array(
                'id' => $magazynPrzyja->id, 'idWymienProdukt' => $idZamowieniaWymienProdukty, 'idPrzekazProdukt' => $idZamowieniaPrzekazProdukty
            )));
        }

        $this->tresc .= $this->szablon->parsujBlok('zatwierdzZwrotProduktow',array(

        ));
    }

    private function klonujProdukt($idProduktu, $idKategorii, $ilosc, $produktyGrupy = null)
    {
        $blad = 0;
        $maperMagazynProdukty = $this->dane()->ProduktyMagazyn();
        $produktDoSklonownia = $maperMagazynProdukty->pobierzPoId($idProduktu);
        if($produktDoSklonownia instanceof ProduktyMagazyn\Obiekt)
        {
            $nowyProdukt = new ProduktyMagazyn\Obiekt();
            foreach($produktDoSklonownia as $propercja => $wartosc)
            {
                if(in_array($propercja, array('id', 'idProjektu', 'produktyGrupy'))) continue;
                $nowyProdukt->$propercja = $wartosc;
            }
            $nowyProdukt->kategoria = $idKategorii;
            $nowyProdukt->ilosc = $ilosc;
            $nowyProdukt->produktyGrupy = ($produktyGrupy != null) ? $produktyGrupy : json_encode($nowyProdukt->produktyGrupy);
            $nowyProdukt->idOsobyDodajacej = Cms::inst()->profil()->id;


            if(!$nowyProdukt->zapisz($maperMagazynProdukty)) $blad++;

            if($produktDoSklonownia->zdjecie != '')
            {
                $katalogDoSklonowania = Cms::inst()->katalog('zdjecia_produktow', $produktDoSklonownia->id);
                $katalogDocelowy = Cms::inst()->katalog('zdjecia_produktow', $nowyProdukt->id);
                foreach(new \DirectoryIterator($katalogDoSklonowania) as $plik)
                {
                    if(!$plik->isDot()) copy($katalogDoSklonowania.$plik->getFilename() ,$katalogDocelowy.$plik->getFilename());
                }

            }
        }
        else
        {
            trigger_error('Produkt który probujesz powielić nie istnieje');
            $blad++;
        }
        return ($blad) ? false : true;
    }

    private function zwrocProduktZwykly(MagazynWydaneProdukty\Obiekt $produktDoZwrotu, $stan, $ilosc, $opis, $idMagazynPrzyja)
    {
        $blad = 0;
        $cms = Cms::inst();
        $maperMagazynWydaneProdukty = $cms->dane()->MagazynWydaneProdukty();
        $maperMagazynPrzyjeteProdukty = $cms->dane()->MagazynPrzyjeteProdukty();
        $maperMagazynProdukty = $cms->dane()->ProduktyMagazyn();

        $magazynPrzyjetyProdukt = new MagazynPrzyjeteProdukty\Obiekt();
        // produkt nie nadaje sie do użytku
        if(in_array($stan, $this->k->k['zwrocProdukty.stanProduktuKosz']))
        {
            // zmieniamy w MagazynWydaneProdukty ale nie dodajemy w MagazynProduktu
            $produktDoZwrotu->zwrot = $ilosc;
            if(!$produktDoZwrotu->zapisz($maperMagazynWydaneProdukty))
                $blad++;
        }
        // produkt przeznaczon do serwisu
        elseif(in_array($stan, $this->k->k['zwrocProdukty.stanProduktuSerwis']))
        {
            $produktDoZwrotu->zwrot = $ilosc;
            if(!$produktDoZwrotu->zapisz($maperMagazynWydaneProdukty))
                $blad++;

            if($this->klonujProdukt($produktDoZwrotu->idProduktu, $this->k->k['zwrocProdukty.kategoria_produkty_serwis'], $ilosc))
                $this->komunikat($this->j->t['zwrocProdukty.produktPrzeniesionyDoGrupySerwis'], 'info', 'sesja');
        }
        else // produkt do ponowniego użytku
        {
            // zmieniamy w MagazynWydaneProdukty i dodajemy w MagazynProduktu
            $produktDoZwrotu->zwrot = $ilosc;
            if(!$produktDoZwrotu->zapisz($maperMagazynWydaneProdukty))
                $blad++;

            $produktMagazyn = $maperMagazynProdukty->pobierzPoId($produktDoZwrotu->idProduktu);
            if($produktMagazyn instanceof ProduktyMagazyn\Obiekt)
            {
                $produktMagazyn->ilosc = $produktMagazyn->ilosc +  $ilosc;
                if(!$produktMagazyn->zapisz($maperMagazynProdukty))
                    $blad++;
            }
            else
                trigger_error('Zwracany produkt '.$produktDoZwrotu->idProduktu.' nie został znaleziony w magazynie');
        }

        $magazynPrzyjetyProdukt->idMagazynPrzyja = $idMagazynPrzyja;
        $magazynPrzyjetyProdukt->idProduktu = $produktDoZwrotu->idProduktu;
        $magazynPrzyjetyProdukt->ilosc = $ilosc;
        $magazynPrzyjetyProdukt->opis = $opis;
        $magazynPrzyjetyProdukt->stan = $stan;

        if(!$magazynPrzyjetyProdukt->zapisz($maperMagazynPrzyjeteProdukty))
            $blad++;


        return ($blad) ? false : true;
    }

    private function zwrocProduktGrupowy(MagazynWydaneProdukty\Obiekt $produktDoZwrotu, $stan, $ilosc, $opis, $stanyProduktow, $iloscProduktow, $opisProduktow, $idMagazynPrzyja, $ids)
    {
        $produktyGrupy = array();
        $stworzNowyProduktNiepelny = false;
        $produktyDoSerwisu = array();
        $magazynPrzyjetyProdukt = new MagazynPrzyjeteProdukty\Obiekt();
        $maperMagazynPrzyjeteProdukty = $this->dane()->MagazynPrzyjeteProdukty();
        $maperMagazynWydaneProdukty = $this->dane()->MagazynWydaneProdukty();
        $maperMagazynProdukty = $this->dane()->ProduktyMagazyn();
        $iloscProduktowWGrupie = count($produktDoZwrotu->produktyGrupy);
        $iloscDoPomniejszenia = 0;
        $blad = 0;
        foreach($produktDoZwrotu->produktyGrupy as $produkt)
        {
            $klucz = array_search($produktDoZwrotu->id.'-'.$produkt['id'], $ids);

            if(in_array($stanyProduktow[$klucz], $this->k->k['zwrocProdukty.stanProduktuKosz']))
            {
                $stworzNowyProduktNiepelny = true;
                $iloscDoPomniejszenia++;
                continue;
            }
            if(in_array($stanyProduktow[$klucz], $this->k->k['zwrocProdukty.stanProduktuSerwis']))
            {
                $produktyDoSerwisu[$produkt['id']] = $produkt['ilosc'];
                continue;
            }

            $produktyGrupy[$produkt['id']] = array(
                'id' => $produkt['id'],
                'nazwa' => $produkt['nazwa'],
                'ilosc' => $iloscProduktow[$klucz],
                'stan' => $stanyProduktow[$klucz],
                'opis' => $opisProduktow[$klucz],
                'kod' => $produkt['kod'],
            );
        }
        // wszystkie produkty grupy są w stanie nadającym się do użytku
        if(!$stworzNowyProduktNiepelny && count($produktyDoSerwisu) == 0)
        {
            $produktMagazyn = $maperMagazynProdukty->pobierzPoId($produktDoZwrotu->idProduktu);
            if($produktMagazyn instanceof ProduktyMagazyn\Obiekt)
            {
                $produktMagazyn->ilosc = $produktMagazyn->ilosc +  $ilosc;
                if(!$produktMagazyn->zapisz($maperMagazynProdukty))
                    $blad++;
            }
            else
                trigger_error('Zwracany produkt '.$produktDoZwrotu->idProduktu.' nie został znaleziony w magazynie');
        }
        // w grupie istnieją produkty nie nadające się do urzytku lub takie co trzeba naprawić
        else if( ($stworzNowyProduktNiepelny || count($produktyDoSerwisu)) && $iloscDoPomniejszenia != $iloscProduktowWGrupie)
        {
            // jesli każdy z produktów grupy nie nadaje sie do ponownego użytku
            if($this->klonujProdukt($produktDoZwrotu->idProduktu, $this->k->k['zwrocProdukty.kategoria_produkty_niepelne'], $ilosc, $produktyGrupy))
                $this->komunikat($this->j->t['zwrocProdukty.produktPrzeniesionyDoGrupyNieplene'], 'info', 'sesja');

            if(count($produktyDoSerwisu))
            {
                foreach($produktyDoSerwisu as $idProduktu => $iloscProduktu)
                {
                    $this->klonujProdukt($idProduktu, $this->k->k['zwrocProdukty.kategoria_produkty_serwis'], $iloscProduktu);
                }
            }
            // zmieniamy w MagazynWydaneProdukty
            $produktDoZwrotu->zwrot = $ilosc;
            if(!$produktDoZwrotu->zapisz($maperMagazynWydaneProdukty))
                $blad++;
        }
        // cała grupa nie nadaje sie do użytku
        else if ($iloscDoPomniejszenia == $iloscProduktowWGrupie)
        {
            // zmieniamy w MagazynWydaneProdukty
            $produktDoZwrotu->zwrot = $ilosc;
            if(!$produktDoZwrotu->zapisz($maperMagazynWydaneProdukty))
                $blad++;
        }

        $magazynPrzyjetyProdukt->produktyGrupy = $produktyGrupy;
        $magazynPrzyjetyProdukt->idMagazynPrzyja = $idMagazynPrzyja;
        $magazynPrzyjetyProdukt->idProduktu = $produktDoZwrotu->idProduktu;
        $magazynPrzyjetyProdukt->ilosc = $ilosc;
        $magazynPrzyjetyProdukt->opis = $opis;
        $magazynPrzyjetyProdukt->stan = $stan;

        if(!$magazynPrzyjetyProdukt->zapisz($maperMagazynPrzyjeteProdukty))
            $blad++;

        return ($blad) ? false : true;
    }

    private function zwrocProduktZGrupy(MagazynWydaneProdukty\Obiekt $produktDoZwrotu, ProduktyMagazyn\Obiekt $produkt, $stan, $ilosc, $opis, $idMagazynPrzyja)
    {
        $blad = 0;
        $cms = Cms::inst();
        $maperMagazynWydaneProdukty = $cms->dane()->MagazynWydaneProdukty();
        $maperMagazynPrzyjeteProdukty = $cms->dane()->MagazynPrzyjeteProdukty();
        $maperMagazynProdukty = $cms->dane()->ProduktyMagazyn();

        $magazynPrzyjetyProdukt = new MagazynPrzyjeteProdukty\Obiekt();
        // produkt nie nadaje sie do użytku
        if(in_array($stan, $this->k->k['zwrocProdukty.stanProduktuKosz']))
        {
            // zmieniamy w MagazynWydaneProdukty ale nie dodajemy w MagazynProduktu
            //$produktDoZwrotu->zwrot = $ilosc;
            //if(!$produktDoZwrotu->zapisz($maperMagazynWydaneProdukty))
            //$blad++;
        }
        // produkt przeznaczon do serwisu
        elseif(in_array($stan, $this->k->k['zwrocProdukty.stanProduktuSerwis']))
        {
            //$produktDoZwrotu->zwrot = $ilosc;
            //if(!$produktDoZwrotu->zapisz($maperMagazynWydaneProdukty))
            //$blad++;

            if($this->klonujProdukt($produkt->idProduktu, $this->k->k['zwrocProdukty.kategoria_produkty_serwis'], $ilosc))
                $this->komunikat($this->j->t['zwrocProdukty.produktPrzeniesionyDoGrupySerwis'], 'info', 'sesja');
        }
        else // produkt do ponowniego użytku
        {
            // zmieniamy w MagazynWydaneProdukty i dodajemy w MagazynProduktu
            //$produktDoZwrotu->zwrot = $ilosc;
            //if(!$produktDoZwrotu->zapisz($maperMagazynWydaneProdukty))
            //$blad++;

            //$produktMagazyn = $maperMagazynProdukty->pobierzPoId($produktDoZwrotu->idProduktu);
            //if($produktMagazyn instanceof ProduktyMagazyn\Obiekt)
            //{
            $produkt->ilosc = $produkt->ilosc +  $ilosc;
            if(!$produkt->zapisz($maperMagazynProdukty))
                $blad++;
            //}
            //else
            //trigger_error('Zwracany produkt '.$produktDoZwrotu->idProduktu.' nie został znaleziony w magazynie');
        }

        $magazynPrzyjetyProdukt->idMagazynPrzyja = $idMagazynPrzyja;
        $magazynPrzyjetyProdukt->idProduktu = $produkt->id;
        $magazynPrzyjetyProdukt->ilosc = $ilosc;
        $magazynPrzyjetyProdukt->opis = $opis;
        $magazynPrzyjetyProdukt->stan = $stan;
        $magazynPrzyjetyProdukt->produktZGrupy = $produktDoZwrotu->idProduktu;

        if(!$magazynPrzyjetyProdukt->zapisz($maperMagazynPrzyjeteProdukty))
            $blad++;


        return ($blad) ? false : true;
    }

    public function wykonajKartaZwrotuProduktow()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['kartaZwrotu.tytul_strony'],
            'tytul_modulu' => $this->j->t['kartaZwrotu.tytul_modulu'],
        ));
        $idZwrotu = Zadanie::pobierz('id', 'intval', 'abs');
        $idWymienProdukt = Zadanie::pobierz('idWymienProdukt', 'intval', 'abs');
        $idPrzekazProdukt = Zadanie::pobierz('idPrzekazProdukt', 'intval', 'abs');
        $przyjecie = Zadanie::pobierz('przyjecie', 'intval', 'abs');
        $html = '';

        $magazynZworty = $this->dane()->MagazynPrzyja();
        $zwrot = $magazynZworty->pobierzPoId($idZwrotu);

        $komunikat = '';
        if($idWymienProdukt)
            $komunikat = $this->pobierzKomunikatNoweZamowienie($idWymienProdukt);

        if($idPrzekazProdukt)
            $komunikat = $this->pobierzKomunikatNoweZamowienie($idPrzekazProdukt);

        if($komunikat != '')
            $this->komunikat($komunikat, 'info');

        if($zwrot instanceof MagazynPrzyja\Obiekt)
        {
            /**
             * @var Uzytkownik\Obiekt() $odbiorca
             */
            $osobaZdajaca = $zwrot->pobierzOsobeZdajacaProdukty();
            $produktyPobrane = $zwrot->pobierzProdukty();
            $osobaPrzyjmujaca = $zwrot->pobierzOsobePrzyjmujaca();

            $osobaPrzyjmujacaNazwa = '';
            if($osobaPrzyjmujaca instanceof Uzytkownik\Obiekt)
                $osobaPrzyjmujacaNazwa = $osobaPrzyjmujaca->imie.' '.$osobaPrzyjmujaca->nazwisko;

            $this->szablon->ustawBlok('kartaZwrotu/informacje', array(
                'zamowienieNoEtykieta' => $this->j->t['kartaZamowienia.informacjeNo'],
                'zamowienieNo' => $zwrot->id,
                'dataEtykieta' => $this->j->t['kartaZamowienia.dataEtykieta'],
                'data' => ($zwrot->dataDodania != '') ? $zwrot->dataDodania->format('d-m-Y') : date('d-m-Y') ,
                'nazwa_tytul' => ($przyjecie) ? $this->j->t['kartaZwrotu.tytul_przyjecie'] : $this->j->t['kartaZwrotu.tytul'],
                'from_etykieta' => $this->j->t['kartaZwrotu.from_etykieta'],
                'from_nazwa_firmy' => $this->j->t['kartaZamowienia.from_nazwa_firmy'],
                'from_ulica_firma' => $this->j->t['kartaZamowienia.from_ulica_firma'],
                'from_miasto_firma' => $this->j->t['kartaZamowienia.from_miasto_firma'],
                'osobaWydajacaNazwa' => $osobaPrzyjmujacaNazwa,
                'osobaWydajacaEtykieta' => $this->j->t['kartaZamowienia.osobaWydajacaEtykieta'],
                'produktIdEtykieta' => $this->j->t['kartaZamowienia.produktIdEtykieta'],
                'produktCodeEtykieta' => $this->j->t['kartaZamowienia.produktCodeEtykieta'],
                'produktNazwaEtykieta' => $this->j->t['kartaZamowienia.produktNazwaEtykieta'],
                'produktStanEtykieta' => $this->j->t['kartaZamowienia.produktStanEtykieta'],
                'produktIloscEtykieta' => $this->j->t['kartaZamowienia.produktIloscEtykieta'],
                'iloscLacznieEtykieta' => $this->j->t['kartaZamowienia.iloscLacznieEtykieta'],
                'iloscLacznie' => array_sum(listaZTablicy($produktyPobrane, 'id', 'ilosc')),
                'etykietaNaglowek' => $this->j->t['kartaZwrotu.naglowek'],
                'etykietaDrukuj' => $this->j->t['kartaZwrotu.etykietaDrukuj'],
                'linkDrukuj' =>  Router::urlAjax('admin', $this->kategoria, 'drukujKartaZwrotuPdf', array( 'id' => $zwrot->id, 'przyjecie' => $przyjecie )),
            ));
            $zdajacyNazwa = '';
            if($osobaZdajaca instanceof Uzytkownik\Obiekt)
            {
                $zdajacyNazwa = $osobaZdajaca->imie.' '.$osobaZdajaca->nazwisko;

                $this->szablon->ustawBlok('kartaZwrotu/informacje/odbiorca', array(
                    'to_etykieta' => $this->j->t['kartaZamowienia.to_etykieta'],
                    'to_nazwa' => $osobaZdajaca->imie.' '.$osobaZdajaca->nazwisko,
                    'to_ulica' => $osobaZdajaca->kontaktAdres,
                    'to_miasto' => $osobaZdajaca->kontaktKodPocztowy.' '.$osobaZdajaca->kontaktMiasto,
                ));
            }
            elseif($osobaZdajaca instanceof \Generic\Model\Team\Obiekt)
            {
                $osobaAkceptujaca = $zwrot->pobierzOsobeAkceptujaca();
                if($osobaAkceptujaca!=null)
                    $zdajacyNazwa = $osobaAkceptujaca->imie.' '.$osobaAkceptujaca->nazwisko;

                $this->szablon->ustawBlok('kartaZwrotu/informacje/odbiorca', array(
                    'to_etykieta' => $this->j->t['kartaZamowienia.to_etykieta'],
                    'to_nazwa' => $osobaZdajaca->teamNumber.' ( '.$zdajacyNazwa.' ) ',
                ));
            }

            foreach($produktyPobrane as $produkt)
            {
                $this->szablon->ustawBlok('kartaZwrotu/informacje/produkt', array(
                    'produktId' => $produkt['id'],
                    'produktNazwa' => $produkt['nazwa_produktu'],
                    'produktKod' => $produkt['kod'],
                    'produktIlosc' => $produkt['ilosc'],
                    'produktStan' => (isset($this->j->t['zwrocProdukty.stan_produktu'][$produkt['stan']])) ? $this->j->t['zwrocProdukty.stan_produktu'][$produkt['stan']] : '' ,
                ));

                if($produkt['grupa'])
                {
                    $produktyGrupy = json_decode($produkt['produktygrupyzamowienie']);

                    $this->szablon->ustawBlok('kartaZwrotu/informacje/produkt/produktGrupyBlok/', array(
                        'produktCodeEtykieta' => $this->j->t['kartaZamowienia.produktCodeEtykieta'],
                        'produktNazwaEtykieta' => $this->j->t['kartaZamowienia.produktNazwaEtykieta'],
                        'produktIloscEtykieta' => $this->j->t['kartaZamowienia.produktIloscEtykieta'],

                    ));

                    foreach($produktyGrupy as $produktGrupy)
                    {
                        $this->szablon->ustawBlok('kartaZwrotu/informacje/produkt/produktGrupyBlok/produktGrupy', array(
                            'produktNazwaGrupa' => $produktGrupy->nazwa,
                            'produktIloscGrupa' => $produktGrupy->ilosc,
                            'produktKodGrupa' => $produktGrupy->kod,
                            'produktStan' => (isset($produktGrupy->stan) && isset($this->j->t['zwrocProdukty.stan_produktu'][$produktGrupy->stan])) ? $this->j->t['zwrocProdukty.stan_produktu'][$produktGrupy->stan] : '' ,
                        ));
                    }
                }
            }
            $wyswietlajFormularz = true;

            $inputPodpis = new Input\jSignature('podpis');
            $inputPodpis->dodajWalidator(new Walidator\NiePuste())->wymagany = true;
            $form = new Formularz('', 'podpisForm');

            if($zwrot->obiektOddajacy == 'Team')
            {
                $form->input($this->pobierzInputSelect($this->pobierzPracownikow(), 'id', array('imie', 'nazwisko'), 'idOsobyAkceptujacej'));
                $form->input('idOsobyAkceptujacej')->dodajWalidator(new Walidator\NiePuste())->wymagany = true;

                $team = $this->dane()->Team()->pobierzPoId($zwrot->idOddajacego);
                if($team instanceof \Generic\Model\Team\Obiekt)
                {
                    $lider = $team->pobierzLideraTeamu();
                    if($lider != null) $form->input('idOsobyAkceptujacej')->ustawWartosc($lider->id);
                }

            }

            if($przyjecie)
                $wyswietlajFormularz = false;

            $form->input($inputPodpis);
            $form->stopka(new Input\Submit('zapisz',  array('atrybuty' => array('class' => 'btn btn-primary btn-block btn-lg'))));
            $form->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzPodpis'));

            if($form->wypelniony())
            {
                $wartosci = $form->pobierzWartosci();

                if($form->danePoprawne())
                {
                    $zwrot->podpis = $wartosci['podpis']['wartosc'];
                    $zwrot->podpisVector = $wartosci['podpis']['wartosc_vector'];
                    $zwrot->idPrzyjmujacego = Cms::inst()->profil()->id;

                    if(isset($wartosci['idOsobyAkceptujacej']))
                        $zwrot->idOsobyAkceptujacej = $wartosci['idOsobyAkceptujacej'];

                    $data = new \DateTime(date('Y-m-d H:i:s'));
                    $zwrot->dataDodania = $data;

                    if(!$zwrot->zapisz($magazynZworty))
                        $this->komunikat($this->j->t['kartaZamowienia.blad_zapisu_podpisu'], 'error');
                    else
                        $wyswietlajFormularz = false;

                }
                else
                {
                    $this->komunikat($this->j->t['kartaZamowienia.blad_formularza'], 'error');
                }
            }
            if($zwrot->podpis != '')
            {
                $wyswietlajFormularz = false;
                $this->szablon->ustawBlok('kartaZwrotu/informacje/podpis', array(
                    'podpisImg' => $zwrot->podpis,
                    'podpisane_przez' => $this->j->t['kartaZamowienia.pdopisane_przez'],
                    'odbiorca' => $zdajacyNazwa,
                ));
            }

            if($wyswietlajFormularz)
            {
                $this->szablon->ustawBlok('kartaZwrotu/informacje/input', array(
                    'inputPodpis' => $form->html(),
                ));
            }
        }

        $this->tresc .= $this->szablon->parsujBlok('kartaZwrotu', array(
            'zakladki' => $this->ustawZakladki('widokPracownika'),
            'backToEtykieta' => ($przyjecie) ? $this->j->t['kartaZwrotu.wroc_do_lista_przyjec'] : $this->j->t['kartaZwrotu.wroc_do_lista_uzytkownikow'],
            'backToUrl' => ($przyjecie) ? Router::urlAdmin($this->kategoria, 'listaPrzyjec') : Router::urlAdmin($this->kategoria, 'przyjmijTowar'),
        ));
    }

    public function wykonajDrukujKartaZwrotuPdf()
    {
        $id = Zadanie::pobierzGet('id', 'intval', 'abs');
        $przyjecie = Zadanie::pobierzGet('przyjecie', 'intval', 'abs');

        if($id > 0)
        {
            $magazyn = $this->dane()->MagazynPrzyja();
            $zamowienie = $magazyn->pobierzPoId($id);
            $html = '';
            if($zamowienie instanceof MagazynPrzyja\Obiekt)
            {
                /**
                 * @var Uzytkownik\Obiekt() $odbiorca
                 */

                $osobaZdajaca = $zamowienie->pobierzOsobeZdajacaProdukty();
                $produktyPobrane = $zamowienie->pobierzProdukty();
                $osobaPrzyjmujaca = $zamowienie->pobierzOsobePrzyjmujaca();
                $osobaZdjacaTablica = array();

                $osobaPrzyjmujacaNazwa = '';
                if($osobaPrzyjmujaca instanceof Uzytkownik\Obiekt)
                    $osobaPrzyjmujacaNazwa = $osobaPrzyjmujaca->imie.' '.$osobaPrzyjmujaca->nazwisko;

                if($osobaZdajaca instanceof Uzytkownik\Obiekt)
                {
                    $osobaZdjacaNazwa = $osobaZdajaca->imie.' '.$osobaZdajaca->nazwisko;

                    $osobaZdjacaTablica = array(
                        'to_etykieta' => $this->j->t['kartaZamowienia.to_etykieta'],
                        'to_nazwa' => $osobaZdajaca->imie.' '.$odbiorca->nazwisko,
                        'to_ulica' => $osobaZdajaca->kontaktAdres,
                        'to_miasto' => $osobaZdajaca->kontaktKodPocztowy.' '.$osobaZdajaca->kontaktMiasto,

                    );
                }
                elseif($osobaZdajaca instanceof \Generic\Model\Team\Obiekt)
                {
                    $osobaAkceptujaca = $zamowienie->pobierzOsobeAkceptujaca();
                    $osobaZdjacaNazwa = $osobaAkceptujaca->imie.' '.$osobaAkceptujaca->nazwisko;

                    $osobaZdjacaTablica = array(
                        'to_etykieta' => $this->j->t['kartaZamowienia.to_etykieta'],
                        'to_nazwa' => $osobaZdajaca->teamNumber.' ( '.$osobaZdjacaNazwa.' ) ',
                    );
                }

                $informacje = array(
                    'zamowienieNoEtykieta' => $this->j->t['kartaZamowienia.informacjeNo'],
                    'zamowienieNo' => $zamowienie->id,
                    'dataEtykieta' => $this->j->t['kartaZamowienia.dataEtykieta'],
                    'data' => ($zamowienie->dataDodania != '') ? $zamowienie->dataDodania->format('Y-m-d H:i:s') : date('d-m-Y') ,
                    ($przyjecie) ? $this->j->t['kartaZwrotu.tytul_przyjecie'] : $this->j->t['kartaZwrotu.tytul'],
                    'from_etykieta' => $this->j->t['kartaZwrotu.from_etykieta'],
                    'from_nazwa_firmy' => $this->j->t['kartaZamowienia.from_nazwa_firmy'],
                    'from_ulica_firma' => $this->j->t['kartaZamowienia.from_ulica_firma'],
                    'from_miasto_firma' => $this->j->t['kartaZamowienia.from_miasto_firma'],
                    'osobaWydajacaNazwa' => $osobaPrzyjmujacaNazwa,
                    'osobaWydajacaEtykieta' => $this->j->t['kartaZamowienia.osobaWydajacaEtykieta'],
                    'produktIdEtykieta' => $this->j->t['kartaZamowienia.produktIdEtykieta'],
                    'produktCodeEtykieta' => $this->j->t['kartaZamowienia.produktCodeEtykieta'],
                    'produktNazwaEtykieta' => $this->j->t['kartaZamowienia.produktNazwaEtykieta'],
                    'produktIloscEtykieta' => $this->j->t['kartaZamowienia.produktIloscEtykieta'],
                    'produktStanEtykieta' => $this->j->t['kartaZwrotu.produktStanEtykieta'],
                    'iloscLacznieEtykieta' => $this->j->t['kartaZamowienia.iloscLacznieEtykieta'],
                    'iloscLacznie' => array_sum(listaZTablicy($produktyPobrane, 'id', 'ilosc')),
                );
                $this->szablon->ustawBlok(
                    'kartaZwrotuPdf/informacje',
                    array_merge($informacje, $osobaZdjacaTablica)
                );

                foreach($produktyPobrane as $produkt)
                {
                    $this->szablon->ustawBlok('kartaZwrotuPdf/informacje/produkt', array(
                        'produktId' => $produkt['id'],
                        'produktNazwa' => $produkt['nazwa_produktu'],
                        'produktKod' => $produkt['kod'],
                        'produktIlosc' => $produkt['ilosc'],
                        'produktStan' => $this->j->t['zwrocProdukty.stan_produktu'][$produkt['stan']],
                    ));
                    if($produkt['grupa'])
                    {
                        $produktyGrupy = json_decode($produkt['produktygrupyzamowienie']);
                        $this->szablon->ustawBlok('kartaZwrotuPdf/informacje/produkt/produktGrupyBlok/', array(
                            'produktCodeEtykieta' => $this->j->t['kartaZamowienia.produktCodeEtykieta'],
                            'produktNazwaEtykieta' => $this->j->t['kartaZamowienia.produktNazwaEtykieta'],
                            'produktIloscEtykieta' => $this->j->t['kartaZamowienia.produktIloscEtykieta'],
                        ));
                        foreach($produktyGrupy as $produktGrupy)
                        {
                            $this->szablon->ustawBlok('kartaZwrotuPdf/informacje/produkt/produktGrupyBlok/produktGrupy', array(
                                'produktNazwaGrupa' => $produktGrupy->nazwa,
                                'produktIloscGrupa' => $produktGrupy->ilosc,
                                'produktKodGrupa' => $produktGrupy->kod,
                                'produktStan' => $this->j->t['zwrocProdukty.stan_produktu'][$produktGrupy->stan],
                            ));
                        }

                    }
                }
                if($zamowienie->podpis != '')
                {
                    $this->szablon->ustawBlok('kartaZwrotuPdf/informacje/podpis', array(
                        'podpisImg' => $zamowienie->podpis,
                    ));
                }

                $header = $this->szablon->parsujBlok('kartaZwrotuPdf/header', array(
                    'logo' => Cms::inst()->katalog('public_temp').'logo_nowe.png',
                    'adres_etykieta' => $this->j->t['adres_etykieta'],
                    'adres_wartosc' => $this->j->t['adres_wartosc_post'],
                    'miasto_wartosc' => $this->j->t['miasto_wartosc_post'],
                    'telefon_etykieta' => $this->j->t['telefon_etykieta'],
                    'telefon_wartosc' => $this->j->t['telefon_wartosc'],
                    'email_etykieta' => $this->j->t['email_etykieta'],
                    'email_wartosc' => $this->j->t['email_wartosc'],
                    'www_etykieta' => $this->j->t['www_etykieta'],
                    'www_wartosc' => $this->j->t['www_wartosc'],
                    'bankgiro_etykieta' => $this->j->t['bankgiro_etykieta'],
                    'bankgiro_wartosc' => $this->j->t['bankgiro_wartosc'],
                    'org_numer_etykieta' => $this->j->t['org_numer_etykieta'],
                    'org_numer_wartosc' => $this->j->t['org_numer_wartosc'],
                    'znaczek_rozdziel' => $this->j->t['znaczek_rozdziel'],
                ));

                $html.= $this->szablon->parsujBlok('kartaZwrotuPdf', array(
                    'tlo' => Cms::inst()->katalog('public_temp').'papier_tlo.jpg',
                ));
                $footer = $this->szablon->parsujBlok('kartaZwrotuPdf/footer', array(
                    'adres_etykieta' => $this->j->t['adres_etykieta'],
                    'adres_wartosc' => $this->j->t['adres_wartosc_post'],
                    'miasto_wartosc' => $this->j->t['miasto_wartosc_post'],
                    'telefon_etykieta' => $this->j->t['telefon_etykieta'],
                    'telefon_wartosc' => $this->j->t['telefon_wartosc'],
                    'email_etykieta' => $this->j->t['email_etykieta'],
                    'email_wartosc' => $this->j->t['email_wartosc'],
                    'www_etykieta' => $this->j->t['www_etykieta'],
                    'www_wartosc' => $this->j->t['www_wartosc'],
                    'bankgiro_etykieta' => $this->j->t['bankgiro_etykieta'],
                    'bankgiro_wartosc' => $this->j->t['bankgiro_wartosc'],
                    'org_numer_etykieta' => $this->j->t['org_numer_etykieta'],
                    'org_numer_wartosc' => $this->j->t['org_numer_wartosc'],
                    'znaczek_rozdziel' => $this->j->t['znaczek_rozdziel'],
                ));

                $this->stworzPdf($header, $html, $footer);
            }
        }
    }

    private function pobierzKomunikatNoweZamowienie($idZamowienia)
    {
        $zamowienie = $this->dane()->MagazynWydane()->pobierzPoId($idZamowienia);
        $nazwa = '';
        if($zamowienie instanceof MagazynWydane\Obiekt)
        {
            $odbiorca = $zamowienie->pobierzOdbiorce();
            $nazwaOdbiorcy = '';
            if($odbiorca instanceof Team\Obiekt)
                $nazwaOdbiorcy = $odbiorca->teamNumber;
            elseif($odbiorca instanceof Uzytkownik\Obiekt)
                $nazwaOdbiorcy = $odbiorca->imie.' '.$odbiorca->nazwisko;
            else
                trigger_error('Odbiorca '.$zamowienie->obiektOdbiorcy.' o id '.$zamowienie->idOdbiorcy.' nie istnieje' );
        }
        else
        {
            trigger_error('Nie odnaleziono zamówienia o id : '.$idZamowienia.' w bazie');
        }
        $link = Router::urlAdmin($this->kategoria, 'kartaZamowienia', array('id' => $idZamowienia));
        return str_replace(array('{LINK}', '{NAZWA}'), array($link, $nazwaOdbiorcy), $this->j->t['zatwierdzZwrotProduktow.infoPrzekazProdukt']);
    }

    private function przekazProduktyUzytkownikowi($idsProduktow, $obiektOdbiorcy, $idOdbiorcy)
    {
        $idZamowienia = null;
        if(count($idsProduktow))
        {
            $idsProduktowZapytanie = array_keys($idsProduktow);
            $listaProdoktow = $this->dane()->ProduktyMagazyn()->szukaj(array('ids' => $idsProduktowZapytanie));
            foreach($listaProdoktow as $produkt)
            {
                $koszyk[$produkt->id] = array(
                    'produktNazwa' => $produkt->nazwaProduktu,
                    'kod' => $produkt->kod,
                    'grupa' => $produkt->grupa,
                    'maxIlosc' => $produkt->ilosc,
                    'ilosc' => $idsProduktow[$produkt->id]['ilosc'],
                    'zdjecie' => $produkt->zdjecie,
                );
            }
            $idZamowienia = $this->zapiszZamowienie($obiektOdbiorcy, $idOdbiorcy, '', $koszyk, Cms::inst()->profil()->id);
        }

        return $idZamowienia;
    }

    private function wymienProduktNaNowy($idsProduktow, $obiektOdbiorcy, $idOdbiorcy)
    {
        $idZamowienia = null;
        if(count($idsProduktow))
        {
            $idsProduktowZapytanie = array_keys($idsProduktow);
            $listaProdoktow = $this->dane()->ProduktyMagazyn()->szukaj(array('ids' => $idsProduktowZapytanie));
            foreach($listaProdoktow as $produkt)
            {
                $koszyk[$produkt->id] = array(
                    'produktNazwa' => $produkt->nazwaProduktu,
                    'kod' => $produkt->kod,
                    'grupa' => $produkt->grupa,
                    'maxIlosc' => $produkt->ilosc,
                    'ilosc' => $idsProduktow[$produkt->id]['ilosc'],
                    'zdjecie' => $produkt->zdjecie,
                );
            }
            $idZamowienia = $this->zapiszZamowienie($obiektOdbiorcy, $idOdbiorcy, '', $koszyk, Cms::inst()->profil()->id);
        }

        return $idZamowienia;
    }

    private function parsujWierszZwrocProdukty($stanInput, $produkt, $klasa = '', $blokujTransfer = false, $blokujZamiana = false, $grupa = '', $wymusZamiana = false)
    {
        $zdjecieMiniaturka = $this->j->t['finalizujZamowienie.brakZdjecia'];
        $zdjecieLink = '';
        if($produkt['zdjecie'] != '')
        {
            $zdjecieMiniaturka = Cms::inst()->url('zdjecia_produktow', $produkt['id_produktu']).'/'.$this->k->k['koszyk.prefix_miniaturka'].$produkt['zdjecie'];
            $zdjecieLink = Cms::inst()->url('zdjecia_produktow', $produkt['id_produktu']).'/'.$this->k->k['parsujPojedynczyWierszWyszukiwania.prefix_podglad'].$produkt['zdjecie'];
        }

        $this->szablon->ustawBlok('zwrocProdukty/produkt', array(
            'stanInput' => $stanInput,
            'id' => $produkt['idwydane'],
            'kod' => $produkt['kod'],
            'zdjecie' => $zdjecieMiniaturka,
            'zdjecieLink' => $zdjecieLink,
            'nazwa' => $produkt['nazwa_produktu'],
            'ilosc' => $produkt['ilosc'],
            'iloscMagazyn' => $produkt['iloscmagazyn'],
            'klasa' => $klasa,
            'blokujTransfer' => $blokujTransfer,
            'blokujZamiana' => $blokujZamiana,
            'grupa' => $grupa,
            'wymusZmiana' => $wymusZamiana,
        ));
    }

    public function wykonajMojeZamowienia()
    {
        Cms::inst()->sesja->mojeZamowienie = true;
        Cms::inst()->sesja->przyjmijTowar = false;
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['mojeZamowienia.tytul_strony'],
            'tytul_modulu' => $this->j->t['mojeZamowienia.tytul_modulu'],
        ));

        $idPracownika = Cms::inst()->profil()->id;
        $pracownik = $this->dane()->Uzytkownik()->pobierzPoId($idPracownika);
        $tytulRegion = '';
        $tytulRegionTeam = '';
        $gridHtml = '';
        $gridTeamHtml = '';
        if($pracownik instanceof Uzytkownik\Obiekt)
        {
            $tytulRegion = str_replace('{UZYTKOWNIK}', $pracownik->imie.' '.$pracownik->nazwisko, $this->j->t['mojeZamowienia.tytulRegionu']);
            $kryteria = array('odbiorcaUzytkownik' => $pracownik->id);
            $pobraneWiersze  = $this->dane()->MagazynWydane()->zwracaTablice()->szukaj($kryteria);

            $grid = $this->gridZamowienia($pobraneWiersze, $pracownik);
            $gridHtml = $grid->html();
            $team = $pracownik->pobierzTeamDlaPracownika();
            if($team instanceof \Generic\Model\Team\Obiekt)
            {
                $tytulRegionTeam = str_replace('{TEAM}', $team->teamNumber, $this->j->t['mojeZamowienia.tytulRegionuTeam']);
                $kryteria = array('odbiorcaTeam' => $team->id);
                $pobraneWiersze  = $this->dane()->MagazynWydane()->zwracaTablice()->szukaj($kryteria);
                $gridTeam = $this->gridZamowienia($pobraneWiersze, null , $team);
                $gridTeamHtml = $gridTeam->html();
            }
        }
        else
        {
            $this->komunikat($this->j->t['widokPracownika.pracownik_nie_istnieje'], 'error');
        }
        $this->tresc .= $this->szablon->parsujBlok('listaKartPracownika',array(
            'zakladki' => $this->ustawZakladki('mojeZamowienia'),
            'grid' => $gridHtml,
            'gridTeam' => $gridTeamHtml,
            'tytulListaZamowienPracownika' => $tytulRegion,
            'tytulListaZamowienTeam' => $tytulRegionTeam,
        ));
    }

    public function wykonajMojeProdukty()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['mojeProdukty.tytul_strony'],
            'tytul_modulu' => $this->j->t['mojeProdukty.tytul_modulu'],
        ));

        $idPracownika = Cms::inst()->profil()->id;
        $pracownik = $this->dane()->Uzytkownik()->pobierzPoId($idPracownika);

        if($pracownik instanceof Uzytkownik\Obiekt)
        {
            $tytulListaProduktowPracownika = str_replace('{PRACOWNIK}', $pracownik->imie.' '.$pracownik->nazwisko , $this->j->t['widokPracownika.tytul_pracownik_lista_produktow']);
            $kryteria = array('odbiorcaUzytkownik' => $pracownik->id, 'status' => 'wydane', 'zwrocone' => false);
            $listaProduktow = $this->dane()->MagazynWydane()->szukajZProduktami($kryteria);

            $gridProduktyUzytkownika = $this->gridProdukty($listaProduktow, $idPracownika);
            $this->szablon->ustawBlok('mojeProdukty/gridProduktyPracownika', array(
                'pracownikNaglowek' => $pracownik->imie.' '.$pracownik->nazwisko,
                'gridProduktyPracownika' => $gridProduktyUzytkownika->html(),
                'tytulListaProduktowPracownika' => $tytulListaProduktowPracownika,
            ));

            $team = $pracownik->pobierzTeamDlaPracownika();
            if($team instanceof \Generic\Model\Team\Obiekt)
            {
                $tytulListaProduktowTeamu = str_replace('{TEAM}', $team->teamNumber  , $this->j->t['widokPracownika.tytul_team_lista_produktow']);
                $kryteria = array('odbiorcaTeam' => $team->id, 'status' => 'wydane', 'zwrocone' => false);

                $listaProduktowTeamu = $this->dane()->MagazynWydane()->szukajZProduktami($kryteria);
                $gridProduktyTeamu =  $this->gridProdukty($listaProduktowTeamu, $idPracownika);
                $this->szablon->ustawBlok('mojeProdukty/gridProduktyTeamu', array(
                    'teamNaglowek' => $team->teamNumber,
                    'produktyTeamu' => $gridProduktyTeamu->html(),
                    'tytulListaProduktowTeamu' => $tytulListaProduktowTeamu,
                ));
            }
        }
        else
        {
            $this->komunikat($this->j->t['widokPracownika.pracownik_nie_istnieje'], 'error');
        }

        $this->tresc .= $this->szablon->parsujBlok('mojeProdukty',array(
            'zakladki' => $this->ustawZakladki('mojeZamowienia'),
            'urlListaProduktow' => Router::urlAdmin($this->kategoria, 'widokPracownika', array('id' => $idPracownika)),
            'urlKartyZamowien' => Router::urlAdmin($this->kategoria, 'listaKartZamowienPracownika', array('id' => $idPracownika)),
        ));
    }

    public function wykonajZamowNowyProdukt()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['zamowNowyProdukt.tytul_strony'],
            'tytul_modulu' => $this->j->t['zamowNowyProdukt.tytul_modulu'],
        ));

        Cms::inst()->sesja->mojeZamowienie = true;
        Cms::inst()->sesja->przyjmijTowar = false;

        $idPracownika = Cms::inst()->profil()->id;
        $pracownik = $this->dane()->Uzytkownik()->pobierzPoId($idPracownika);
        if($pracownik instanceof Uzytkownik\Obiekt)
        {
            $wyszukiwarka = $this->parsujWyszukiwarka(null, true);
        }
        else
        {
            $this->komunikat($this->j->t['widokPracownika.pracownik_nie_istnieje'], 'error');
        }
        $this->tresc .= $this->szablon->parsujBlok('zamowNowyProdukt',array(
            'zakladki' => $this->ustawZakladki('mojeZamowienia'),
            'wyszukiwarka' => $wyszukiwarka
        ));
    }

    private function gridZamowienia($pobraneWiersze, $pracownik = null, $team = null)
    {
        $grid = new TabelaDanych();
        $grid->dodajKolumne('id', $this->j->t['index.id'], '', '', true);
        $grid->dodajKolumne('id_odbiorcy', $this->j->t['index.odbiorca'], '');
        $grid->dodajKolumne('status', $this->j->t['index.status']);
        $grid->dodajKolumne('data_dodania', $this->j->t['index.data_dodania']);
        $grid->dodajKolumne('opis', $this->j->t['index.opis'], '');

        $przyciski = array(
            array(
                'akcja' =>  Router::urlAjax('admin', $this->kategoria, 'drukujPdf', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-file',
                'etykieta' => $this->j->t['index.podgladPdf'],
                'target' => '_self',
                'klucz' => 'podgladPdf',
                'onclick' => 'modalIFrame(this); return false;',
            ),
        );
        $odbiorca = '';
        if($pracownik != null)
            $odbiorca = $pracownik->imie.' '.$pracownik->nazwisko;
        if($team != null)
            $odbiorca = $team->teamNumber;

        if(count($pobraneWiersze) > 0)
        {
            $grid->dodajPrzyciski(
                Router::urlAdmin($this->kategoria,'{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),$przyciski
            );

            $idUzytkownikow = array();

            foreach($pobraneWiersze as $wiersz)
            {
                $wiersz['data_dodania'] = ($wiersz['data_dodania'] != '') ? date('Y-m-d', strtotime($wiersz['data_dodania'])) : '...';
                $wiersz['id_odbiorcy'] = $odbiorca;
                $wiersz['status'] = $this->j->t['index.status_'.$wiersz['status']];

                $grid->dodajWiersz($wiersz);
            }
        }
        return $grid;
    }

    private function gridProdukty($listaProduktow, $idPracownika = null, $idTeamu = null, $zwort = null)
    {
        $grid = new TabelaDanych();
        $grid->dodajKolumne('produkt_wydany_id', $this->j->t['widokPracownika.id'], '', '', true);
        $grid->dodajKolumne('kod', $this->j->t['widokPracownika.kod']);
        $grid->dodajKolumne('zdjecie', $this->j->t['widokPracownika.zdjecie']);
        $grid->dodajKolumne('nazwa_produktu', $this->j->t['widokPracownika.nazwa_produktu']);
        $grid->dodajKolumne('data_dodania', $this->j->t['widokPracownika.data_dodania']);
        $grid->dodajKolumne('ilosc_uzytkownik', $this->j->t['widokPracownika.ilosc']);
        if($idPracownika != null)
        {
            $przyciski = array(
                array(
                    'akcja' => Router::urlAjax('admin', $this->kategoria, 'podgladProduktu', array('{KLUCZ}' => '{WARTOSC}', 'id_pracownika' => $idPracownika)),
                    'ikona' => 'icon-search',
                    'etykieta' => $this->j->t['widokPracownika.kartaProduktu'],
                    'target' => '_self',
                    'klucz' => 'podglad',
                    'onclick' => 'modalAjax(this.href); return false;',
                ),
            );
        }
        if($idTeamu != null)
        {
            $przyciski = array(
                array(
                    'akcja' => Router::urlAjax('admin', $this->kategoria, 'podgladProduktu', array('{KLUCZ}' => '{WARTOSC}', 'id_teamu' => $idTeamu)),
                    'ikona' => 'icon-search',
                    'etykieta' => $this->j->t['widokPracownika.kartaProduktu'],
                    'target' => '_self',
                    'klucz' => 'podglad',
                    'onclick' => 'modalAjax(this.href); return false;',
                ),
            );
        }

        if($zwort)
        {
            $grid->dodajPrzyciskiGrupowe(
                Router::urlAdmin($this->kategoria, '{AKCJA}'),
                array(
                    'zaznacz',
                    'odwroc',
                ));
        }

        if(count($listaProduktow))
        {
            $grid->dodajPrzyciski(
                Router::urlAdmin($this->kategoria,'{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),$przyciski
            );
            foreach($listaProduktow as $wiersz)
            {
                if($wiersz['grupa'])
                {
                    $wiersz['kod'] = '&darr; '.$wiersz['kod'];
                    $grid->ustawKlase('produktGrupaPoczatek');
                    $grid->ustawAtrybuty(array('data-grupa' => $wiersz['produkt_wydany_id']));
                }

                $wiersz = $this->parsujWiersz($wiersz);
                $grid->zmienAkcjePrzycisk('podglad', Router::urlAdmin($this->kategoria, 'podgladProduktu', array('id_produktu' => $wiersz['id_produktu'],  'id_teamu' => $idTeamu,
                    'id_pracownika' => $idPracownika, 'ilosc' => $wiersz['ilosc_uzytkownik'])));
                $grid->dodajWiersz($wiersz);

                if($wiersz['grupa'])
                {
                    $produktyGrupy = $this->pobierzProduktyGrupy($wiersz);

                    $iloscWGrupie = count($produktyGrupy);
                    $i = 0;
                    foreach($produktyGrupy as $gProdukt)
                    {
                        $i++;
                        $gWiersz = $this->parsujWiersz($gProdukt);
                        $gWiersz['produkt_wydany_id'] = $wiersz['produkt_wydany_id'].'-'.$gProdukt['id_produktu'];
                        $gWiersz['data_dodania'] = $wiersz['data_dodania'];

                        if($i == $iloscWGrupie)
                            $grid->ustawKlase('produktGrupaKoniec');

                        $grid->zmienAkcjePrzycisk('podglad', Router::urlAdmin($this->kategoria, 'podgladProduktu', array('id_produktu' => $gProdukt['id_produktu'],  'id_teamu' => $idTeamu,
                            'id_pracownika' => $idPracownika, 'ilosc' => $wiersz['ilosc_uzytkownik'])));

                        $grid->ustawAtrybuty(array('data-produktgrupa' => $wiersz['produkt_wydany_id']));
                        $grid->dodajWiersz($gWiersz);
                    }
                }
            }
        }

        return $grid;
    }

    private function pobierzProduktyGrupy($wiersz)
    {
        $listaProduktow = array();
        $maperProduktyMagazyn = $this->dane()->ProduktyMagazyn();

        foreach(json_decode($wiersz['produkty_grupy']) as $id => $produkt)
        {
            $produktObiekt = $maperProduktyMagazyn->pobierzPoId($id);

            if($produktObiekt instanceof ProduktyMagazyn\Obiekt)
                $zdjecie = $produktObiekt->zdjecie;

            $listaProduktow[] = array(
                'kod' => '&rarr; '.$produkt->kod,
                'ilosc_uzytkownik' => $produkt->ilosc,
                'nazwa_produktu' => $produkt->nazwa.'<br/> ( <small>'.$wiersz['nazwa_produktu'].'</small> )',
                'zdjecie' => $zdjecie,
                'id_produktu' => $produkt->id,
                'iloscmagazyn' => $produktObiekt->ilosc,
            );
        }
        return $listaProduktow;
    }

    private function parsujWiersz($wiersz)
    {
        if($wiersz['zdjecie'] != '' && isset($wiersz['zdjecie']))
        {
            $zdjecieMiniaturka = Cms::inst()->url('zdjecia_produktow', $wiersz['id_produktu']).'/'.$this->k->k['koszyk.prefix_miniaturka'].$wiersz['zdjecie'];
            $zdjecieLink = Cms::inst()->url('zdjecia_produktow', $wiersz['id_produktu']).'/'.$this->k->k['parsujPojedynczyWierszWyszukiwania.prefix_podglad'].$wiersz['zdjecie'];
            $wiersz['zdjecie'] = '<a  rel="lightbox" href="'.$zdjecieLink.'"><img src="'.$zdjecieMiniaturka.'" /></a>';
        }
        else
            $wiersz['zdjecie'] = $this->j->t['finalizujZamowienie.brakZdjecia'];

        return $wiersz;
    }

    public function wykonajPrzyjmijTowar()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['przyjmijTowar.tytul_strony'],
            'tytul_modulu' => $this->j->t['przyjmijTowar.tytul_modulu'],
        ));

        Cms::inst()->sesja->przyjmijTowar = true;
        Cms::inst()->sesja->mojeZamowienie = false;

        $wyszukiwarka = $this->parsujWyszukiwarka(null);

        $this->tresc .= $this->szablon->parsujBlok('przyjmijTowar',array(
            'zakladki' => $this->ustawZakladki('przyjmowanieTowaru'),
            'wyszukiwarka' => $wyszukiwarka,
            //'urlZaladujFormularzDodajProdukt' => Router::urlAjax('admin' , $this->kategoria, 'formularzDodajProdukt'),
            'urlDodajProdukt' => Router::urlAdmin($this->kategoria, 'produktyDodaj', array('typ' => 'produkty', 'przyjmijTowar' => 1)),
        ));
    }

    private function formularzPrzyjmijTowar()
    {
        $formularz = new Formularz('', 'finalizuj');
        $formularz->stopka(new Input\Submit('zapisz'));
        $formularz->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzFinalizuj'));

        if($formularz->wypelniony())
        {
            $this->zapiszPrzyjmijTowar();
        }

        return $formularz;
    }

    public function wykonajFormularzDodajProdukt()
    {
        $formularz = $this->formularzDodajProdukt(0, 'produkty', true);
        $dane['html'] = $formularz->html();
        echo json_encode($dane);
        die;
    }


    private function zapiszPrzyjmijTowar()
    {
        $cms = Cms::inst();
        if(isset($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]) && count($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]))
        {
            $blad = 0;
            $cms->Baza()->transakcjaStart();

            $mapperPrzyjete = $this->dane()->MagazynPrzyja();
            $obiektPrzyjete = new MagazynPrzyja\Obiekt();

            $obiektPrzyjete->idPrzyjmujacego = $cms->profil()->id;

            if($obiektPrzyjete->zapisz($mapperPrzyjete))
            {
                $maperProduktyPrzyjete = $cms->dane()->MagazynPrzyjeteProdukty();
                $maperProduktyMagazyn = $cms->dane()->ProduktyMagazyn();

                foreach($cms->sesja->koszyk[$this->pobierzNazweKoszyka()]['listaProduktow'] as $id => $produkt)
                {
                    $obiektProduktPrzyjety = new MagazynPrzyjeteProdukty\Obiekt();
                    $obiektProduktPrzyjety->idMagazynPrzyja = $obiektPrzyjete->id;
                    $obiektProduktPrzyjety->idProduktu = $id;
                    $obiektProduktPrzyjety->ilosc = $produkt['ilosc'];
                    $obiektProduktPrzyjety->stan = "nowy";
                    $obiektProduktPrzyjety->produktyGrupy = (isset($produkt['produkty_grupy']) && count($produkt['produkty_grupy']) && $produkt['produkty_grupy'] != false ) ? $produkt['produkty_grupy'] : null;

                    if(!$obiektProduktPrzyjety->zapisz($maperProduktyPrzyjete)) $blad++;

                    $obiektProduktyMagazyn = $maperProduktyMagazyn->pobierzPoId($id);
                    if($obiektProduktyMagazyn instanceof ProduktyMagazyn\Obiekt)
                    {
                        $obiektProduktyMagazyn->ilosc = $obiektProduktyMagazyn->ilosc + $obiektProduktPrzyjety->ilosc;
                        ($obiektProduktyMagazyn->zapisz($maperProduktyMagazyn)) ? '' : $blad++;
                    }
                    else
                        $blad++;
                }
            }
            else
                $blad++;

            if($blad)
            {
                $cms->Baza()->transakcjaCofnij();
            }
            else
            {
                $this->usunProduktyZKoszyka(0);
                $cms->Baza()->transakcjaPotwierdz();
                $this->komunikat($this->j->t['przyjmijTowar.komunikatTowarPrzyjety'], 'info');
            }

        }
        else
        {
            $this->komunikat($this->j->t['przyjmijTowar.koszykPusty'], 'error');
        }
    }

}