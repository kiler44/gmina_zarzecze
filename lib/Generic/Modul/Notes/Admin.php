<?php
namespace Generic\Modul\Notes;

use Generic\Model\Notes;
use Generic\Model\Zamowienie;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Notatka;


class Admin extends Modul\Admin
{

    protected $uprawnienia = array(
        'wykonajIndex',
        'wykonajAddNote',
        'wykonajDeleteNote',
        'wykonajEditNote',
        'wykonajEditNoteAjax',
        'wykonajTrash',
        'wykonajRevert',
        'wykonajPreviewObject',
        'wykonajPobierzDlaObiektu',
    );

    /**
     * @var \Generic\Konfiguracja\Modul\Klienci\Admin
     */
    protected $k;

    /**
     * @var \Generic\Tlumaczenie\Pl\Modul\Klienci\Admin
     */
    protected $j;


    public function wykonajIndex()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['index.tytul_strony'],
            'tytul_modulu' => $this->j->t['index.tytul_modulu'],
        ));

        $this->dodajMenuKontekstowe(array(
            'notes_trash' => array(
                'url' => Router::urlAdmin($this->kategoria, 'trash'),
                'ikona' => 'icon-trash',
            ),
        ));

        $this->wyswietlMenuKontekstowe();

        $przyciski = array(
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'deleteNote', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-remove',
                'etykieta' => $this->j->t['index.tabela_etykieta_usun'],
                'target' => '_self',
                'klucz' => 'deleteNote',
                'onclick' => 'return potwierdzenieUsun(\'' . $this->j->t['index.etykieta_potwierdz_usun'] . '\', $(this))',
            ),
            array(
                'akcja' => Router::urlAjax('Admin', $this->kategoria, 'editNote', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-pencil',
                'etykieta' => $this->j->t['index.tabela_etykieta_edytuj'],
                'target' => '_self',
                'class' => 'link_test',
                'klucz' => 'editNote',
                'onclick' => 'return otworzOkno(this.href);',
            ),
        );

        $kryteria['status'] = 'active';

        $grid = $this->grid($przyciski, $kryteria);

        $linkAjax = Router::urlAjax('Admin', $this->kategoria, 'AddNote', array('id' => 10, 'object' => 'Zamowienie'));


        $this->tresc .= $this->szablon->parsujBlok('/index', array(
            'tabela_danych' => $grid->html(),
            'linkAjax' => $linkAjax,

        ));

    }

    public function wykonajAddNote()
    {

        $idObjektu = Zadanie::pobierz('id', 'intval', 'abs');
        $typObjekt = Zadanie::pobierz('object');
        $nieWyswietlajLista = Zadanie::pobierz('nieWyswietlajLista', 'intval', 'abs');

        $notatka = new Notes\Obiekt();

        if ($idObjektu > 0) {

            if (in_array(strtolower($typObjekt), $this->k->k['objekty_notatek'])) {

                $notatka->idProjektu = ID_PROJEKTU;
                $notatka->idObject = $idObjektu;
                $notatka->object = $typObjekt;
                $grid = '';
                if (!$nieWyswietlajLista) {
                    $kryteria['status'] = 'active';
                    $kryteria['object'] = $typObjekt;
                    $kryteria['idObject'] = $idObjektu;

                    $grid = $this->gridAjax($kryteria);
                }

                $url_ajax_edycja = Router::urlAjax('Admin', $this->kategoria, 'editNoteAjax');

                $this->tresc .= $this->szablon->parsujBlok('dodaj', array(
                    'form' => $this->formularz($notatka, $typObjekt, $idObjektu),
                    'tabela_danych' => $grid,
                    'url_ajax_edycja' => $url_ajax_edycja,
                    'przycisk_cancel' => $this->j->t['ajax_edytuj_cancel'],
                    'przycisk_ok' => $this->j->t['ajax_edytuj_zapisz'],
                    'jeditable_tooltip' => $this->j->t['ajax_edytuj_tooltip'],
                    'etykieta_dodaj' => $this->j->t['addNote.etykieta_dodaj'],
                    'nieWyswietlajLista' => !$nieWyswietlajLista,
                ));

            } else {
                $this->komunikat($this->j->t['addNote.brak_objektu_w_konfiguracji'], 'error');
            }

        } else {
            $this->komunikat($this->j->t['addNote.brak_id_objektu'], 'error');
        }

    }

    public function wykonajEditNoteAjax()
    {
        $mapper = $this->Dane()->Notes();
        $objekt = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if ($objekt instanceof Notes\Obiekt) {
            $wartosc = Zadanie::pobierz('value');;
            $objekt->description = $wartosc;
            $objekt->zapisz($mapper);
            echo $wartosc;
        }

    }

    public function wykonajEditNote()
    {
        $mapper = $this->Dane()->Notes();
        $objekt = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));
        if ($objekt instanceof Notes\Obiekt) {
            $form = $this->formularz($objekt);
            $this->tresc .= $this->szablon->parsujBlok('dodaj', array(
                'form' => $form,
            ));
        } else {

            $this->komunikat($this->j->t['editnotes.blad_nie_mozna_pobrac_notatki'], 'error', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));

        }
    }

    public function wykonajDeleteNote()
    {
        $cms = Cms::inst();

        $mapper = $this->dane()->Notes();
        $objekt = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if ($objekt instanceof Notes\Obiekt) {
            $objekt->status = 'delete';
            $objekt->zapisz($mapper);

            if ($cms->usluga instanceof \Generic\Biblioteka\Usluga\Ajax) {
                $kryteria['status'] = 'active';
                $kryteria['object'] = $objekt->object;
                $kryteria['idObject'] = $objekt->idObject;

                $grid = $this->gridAjax($kryteria);
                $informacja['grid'] = $grid;
                $informacja['idObiekt'] = $objekt->idObject;
                echo json_encode($informacja);
                die;
            } else {
                $this->komunikat($this->j->t['delete.notatka_usunieta'], 'info', 'sesja');
                Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
            }

        } else {
            $this->komunikat($this->j->t['delete.blad_nie_mozna_pobrac_notatki'], 'error', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
        }
    }

    public function wykonajRevert()
    {
        $mapper = $this->dane()->Notes();

        $notatka = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));
        if ($notatka instanceof Notes\Obiekt) {
            $notatka->status = 'active';
            $notatka->zapisz($mapper);
            $this->komunikat($this->j->t['revert.notatka_przywrocona_z_kosza'], 'info', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'trash'));

        } else {
            $this->komunikat($this->j->t['revert.blad_nie_mozna_pobrac_notatki'], 'error', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'trash'));
        }
    }

    public function wykonajTrash()
    {

        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['trash.tytul_strony'],
            'tytul_modulu' => $this->j->t['trash.tytul_modulu'],
        ));

        $this->dodajMenuKontekstowe(array(
            'notes_index' => array(
                'url' => Router::urlAdmin($this->kategoria, 'index'),
                'ikona' => 'icon-list',
            ),

        ));
        $this->wyswietlMenuKontekstowe();

        $przyciski = array(
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'revert', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-repeat',
                'etykieta' => $this->j->t['index.tabela_etykieta_revert'],
                'target' => '_self',
                'klucz' => 'revert',
            ),
        );

        $kryteria['status'] = 'delete';
        $grid = $this->grid($przyciski, $kryteria);

        $this->tresc .= $this->szablon->parsujBlok('/index', array(
            'tabela_danych' => $grid->html(),
        ));
    }

    public function wykonajPreviewObject()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['previewObject.tytul_strony'],
            'tytul_modulu' => $this->j->t['previewObject.tytul_modulu'],
        ));

        $mapper = $this->dane()->Notes();
        $notatka = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if ($notatka instanceof Notes\Obiekt) {
            if (isset($this->k->k['previewobject.akcja_podgladu_objektu'][strtolower($notatka->object)])) {
                $cms = Cms::inst();
                $mapperKategoria = $cms->dane()->Kategoria();
                $idKategorii = $mapperKategoria->pobierzPoKodModulu($this->k->k['previewobject.modul_dla_modelu'][strtolower($notatka->object)]);

                if ($idKategorii->id > 0) {
                    $akcja = $this->k->k['previewobject.akcja_podgladu_objektu'][strtolower($notatka->object)];
                    $parametry = array('id' => $notatka->idObject);
                    $url = Router::urlAdmin($idKategorii, $akcja, $parametry);
                    Router::przekierujDo($url);
                } else {
                    $this->komunikat($this->j->t['previewobject.kategoria_nie_istnieje'], 'error');
                }

            } else {
                $this->komunikat($this->j->t['previewobject.brak_akcji_podgladu'], 'error');
            }

        } else {
            $this->komunikat($this->j->t['preview.error_notatka_nie_istnieje'], 'error', 'sesja');
        }
    }

    private function gridAjax($kryteria = array())
    {
        $url_ajax_edycja = Router::urlAjax('Admin', $this->kategoria, 'editNoteAjax');

        $script = '<script type="text/javascript">
										$(document).ready(function () {
											$(\'.edit_textarea\').editable(\'' . $url_ajax_edycja . '\', { 
												type      : \'textarea\',
												cancel    : \'' . $this->j->t['ajax_edytuj_cancel'] . '\',
												submit    : \'' . $this->j->t['ajax_edytuj_zapisz'] . '\',
												indicator : \'<img src="/_system/img/spinner.gif">\',
												tooltip   : \'' . $this->j->t['ajax_edytuj_tooltip'] . '\',
												width     : 650,
												height    : 70
										  });
										  });
									</script>';

        $grid = new TabelaDanych();
        $grid->dodajKolumne('id', '', 0, '', true);
        $grid->dodajKolumne('description', $this->j->t['index.etykieta_description']);
        $grid->dodajKolumne('data_added', $this->j->t['index.etykieta_data_dodania']);
        $grid->dodajKolumne('author', $this->j->t['index.etykieta_author']);
        $przyciski = array(
            array(
                'akcja' => Router::urlAjax("Admin", $this->kategoria, 'deleteNote', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-remove',
                'etykieta' => $this->j->t['index.tabela_etykieta_usun'],
                'target' => '_self',
                'klucz' => 'deleteNote',
                'onclick' => 'return usunNotatka(this.href);',
                'style' => 'background-color: #DA4F49; background-image: linear-gradient(to bottom, #EE5F5B, #BD362F); background-repeat: repeat-x;'
            ),
        );
        $grid->dodajPrzyciski(Router::urlAdmin($this->kategoria, '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')), $przyciski);

        $mapper = $this->dane()->Notes();
        $ilosc = $mapper->iloscSzukaj($kryteria);
        $pobraneWiersze = $mapper->zwracaTablice()->szukaj($kryteria);

        //$tytulyObiektow = $this->pobierzTytulObiektu($pobraneWiersze);
        if ($ilosc > 0) {
            foreach ($pobraneWiersze as $notatka) {
                if ($notatka['description']) {
                    $notatka['description'] = '<div id = "' . $notatka['id'] . '"class="edit_textarea tip-left" >' . $notatka['description'] . '</div>';
                }
                if ($notatka['data_added']) {
                    $notatka['data_added'] = date($this->k->k['index.grid_format_daty_dodania'], strtotime($notatka['data_added']));
                }
                $grid->dodajWiersz($notatka);
            }
        }

        return $script . $grid->html();

    }

    private function grid($przyciski = array(), $kryteria = array())
    {
        $grid = new TabelaDanych();
        $kryteriaSzukaj = $this->formularzWyszukaj($grid);

        $grid->dodajKolumne('id', '', 0, '', true);
        $grid->dodajKolumne('object', $this->j->t['index.etykieta_object'], '', Router::urlAdmin($this->kategoria, 'previewObject', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('id_object', $this->j->t['index.etykieta_id_object'], '', Router::urlAdmin($this->kategoria, 'previewObject', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('description', $this->j->t['index.etykieta_description']);
        $grid->dodajKolumne('author', $this->j->t['index.etykieta_author']);
        $grid->dodajKolumne('data_added', $this->j->t['index.etykieta_data_added']);
        $kryteria = array_merge($kryteria, $kryteriaSzukaj);
        $grid->dodajPrzyciski(
            Router::urlAdmin($this->kategoria, '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')), $przyciski
        );

        $mapper = $this->dane()->Notes();

        if (isset($kryteriaSzukaj['fraza']) && $kryteriaSzukaj['fraza'] != '') {
            $kryteria['wiele_id'] = $this->pobierzIdNoteDoWyszukania($kryteriaSzukaj['fraza']);
        }

        $iloscWierszy = $mapper->iloscSzukaj($kryteria);

        if ($iloscWierszy > 0) {

            $naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval', 'abs'));
            $nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval', 'abs'));
            $kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
            $kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

            $akcja = $this->pobierzParametr('a', 'index');
            $sorter = new Notes\Sorter($kolumna, $kierunek);
            $grid->ustawSortownie(
                array('id', 'object', 'id_object', 'description', 'data_added'),
                $kolumna, $kierunek,
                Router::urlAdmin($this->kategoria, $akcja, array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
            );

            $pager = new Pager\Html($iloscWierszy, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
            $grid->pager($pager->html(Router::urlAdmin($this->kategoria, $akcja, array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

            $pobraneWiersze = $mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter);

            $tytulyObiektow = $this->pobierzTytulObiektu($pobraneWiersze);
            foreach ($pobraneWiersze as $notatka) {
                if (isset($tytulyObiektow[$notatka['object']][$notatka['id_object']])) {
                    $notatka['id_object'] = $tytulyObiektow[$notatka['object']][$notatka['id_object']];
                }
                $notatka['object'] = $this->j->t['objekty_notatek'][strtolower($notatka['object'])];

                if ($notatka['data_added'] != '') {
                    $notatka['data_added'] = date("d-m-Y h:i A", strtotime($notatka['data_added']));
                }
                $grid->dodajWiersz($notatka);
            }
        }

        return $grid;
    }

    private function pobierzIdNoteDoWyszukania($fraza)
    {
        $kryteria['fraza'] = $fraza;
        $mapper = $this->dane()->Notes();
        $tabelaIdObiektow = array();
        $daneObiektow = $mapper->zwracaTablice()->pobierzObiektyNotatek();

        foreach ($daneObiektow as $obiekt) {

            if (!isset($tabelaIdObiektow[$obiekt['object']])) {
                $tabelaIdObiektow[$obiekt['object']] = array();
            }

            $tabelaIdObiektow[$obiekt['object']][$obiekt['id_object']] = $obiekt['id'];

        }
        $tablicaIdNote = array();
        if (count($tabelaIdObiektow) > 0) {
            foreach ($tabelaIdObiektow as $klucz => $value) {
                $nazwaObiektu = strtolower($klucz);
                if (!isset($this->k->k['obiekt_nazwa_mappera'][$nazwaObiektu])) {
                    $this->komunikat($this->j->t['brak_nazwy_mapera'], 'error');
                    continue;
                } else {
                    $nazwaMapera = $this->k->k['obiekt_nazwa_mappera'][$nazwaObiektu];
                }

                $namespace = 'Generic\\Model\\' . $nazwaMapera . '\Mapper';
                $maperObiekt = new $namespace();
                $znalezioneDopasowania = $maperObiekt->zwracaTablice()->szukaj($kryteria);

                foreach ($znalezioneDopasowania as $obiekt) {
                    if (isset($tabelaIdObiektow[$klucz][$obiekt['id']]) && $tabelaIdObiektow[$klucz][$obiekt['id']] > 0) {
                        $tablicaIdNote[] = $tabelaIdObiektow[$klucz][$obiekt['id']];
                    }

                }

            }

        }

        return $tablicaIdNote;

    }

    private function pobierzTytulObiektu($pobraneWiersze)
    {
        // tworzymy tablice z typem obiekty jako klucz i id typu obiektu
        $tablicaObiektow = array();
        foreach ($pobraneWiersze as $obiekt) {
            $nazwaObiektu = strtolower($obiekt['object']);
            if (!isset($this->k->k['obiekt_nazwa_mappera'][$nazwaObiektu])) {
                $this->komunikat($this->j->t['brak_nazwy_mapera'], 'error');
                continue;
            } else {
                $nazwaMapera = $this->k->k['obiekt_nazwa_mappera'][$nazwaObiektu];
            }

            if (isset($tablicaObiektow[$nazwaMapera]) && !empty($tablicaObiektow[$nazwaMapera])) {
                array_push($tablicaObiektow[$nazwaMapera], $obiekt['id_object']);
            } else {
                $tablicaObiektow[$nazwaMapera] = array($obiekt['id_object']);
            }

        }

        // pobieramy obiekty na podstawie wcześniej utworzonej tablicy
        foreach ($tablicaObiektow as $maper => $ids) {
            $metoda = $this->k->k['obiekt_nazwa_metody_mappera'][$maper];
            $namespace = 'Generic\\Model\\' . $maper . '\Mapper';
            $maperObiekt = new $namespace();

            $listaObiektow[$maper] = $maperObiekt->$metoda($ids);
        }
        $tytulyObiektow = array();
        // z pobranych obiektów wyciągamy tylko to co nam trzeba do wpiasania w grid czyli nazwe tablica[nazwa_obiektu][id_obiektu] => tytul_obiektu
        foreach ($listaObiektow as $nazwaObiektu => $obiekty) {

            foreach ($obiekty as $obiekt) {
                $nazwaKolumny = $this->k->k['obiekt_kolumna_nazwa'][$nazwaObiektu];
                $tablicaNazwaKolumn = explode(',', $nazwaKolumny);
                if (count($tablicaNazwaKolumn) > 0) {
                    $nazwa = '';
                    foreach ($tablicaNazwaKolumn as $kolumna) {
                        $kolumna = trim($kolumna);
                        $nazwa .= ' ' . $obiekt->$kolumna;
                    }
                } elseif (isset($obiekt->$nazwaKolumny) && $obiekt->$nazwaKolumny != '') {
                    $nazwa = $obiekt->$nazwaKolumny;
                } else {
                    $nazwa = $obiekt->id;
                }
                $tytulyObiektow[$nazwaObiektu][$obiekt->id] = $nazwa;
            }

        }
        return $tytulyObiektow;
    }

    private function formularz(Notes\Obiekt $notatka, $typObjekt = null, $idObjektu = null)
    {
        $obiektFormularza = new \Generic\Formularz\Notes\EdycjaNotes();
        $obiektFormularza->ustawObiekt($notatka)
            ->ustawKonfiguracje($this->k->pobierzKonfiguracje())
            ->ustawTlumaczenia($this->j->pobierzBlokTlumaczen('formularz'))
            ->ustawUrlPowrotny(Router::urlAdmin($this->kategoria));

        if ($typObjekt == 'Zamowienie' && $idObjektu > 0) {
            $zamowienie = $this->dane()->Zamowienie()->pobierzPoId($idObjektu);
            $idTypuApartamenty = $this->dane()->WierszKonfiguracji()->pobierzWartoscWierszaKonfiguracji('id_type_apartament', 'AssignTeams_Admin');
            if ($zamowienie instanceof Zamowienie\Obiekt && in_array($zamowienie->idType, $idTypuApartamenty) && $zamowienie->statusWork == 'done') {
                $obiektFormularza->zwrocFormularz()->input(new \Generic\Biblioteka\Input\Checkbox('sygnal'))->ustawEtykiete($this->j->t['formularz.ustaw_jako_sygnal']);
            }
        }

        if ($notatka->id > 0) {

        }

        if ($obiektFormularza->wypelniony()) {
            if ($obiektFormularza->danePoprawne()) {
                $wartosci = $obiektFormularza->pobierzWartosci();
                $mapper = $this->dane()->Notes();

                $cms = Cms::inst();
                $zalogowanaOsoba = $cms->profil();
                $notatka->author = $zalogowanaOsoba->id;

                foreach ($wartosci as $klucz => $wartosc) {
                    if ($klucz == 'sygnal') continue;

                    $notatka->$klucz = $wartosc;
                }
                if (isset($wartosci['sygnal']) && $wartosci['sygnal']) {
                    $notatka->dataAdded = $zamowienie->dataZakonczenia;
                }

                if ($notatka->zapisz($mapper)) {
                    if (Cms::inst()->usluga instanceof \Generic\Biblioteka\Usluga\Ajax) {
                        $informacja['kod'] = '2';
                        $kryteria['status'] = 'active';
                        $kryteria['object'] = $notatka->object;
                        $kryteria['idObject'] = $notatka->idObject;

                        $informacja['idObject'] = $notatka->idObject;
                        $informacja['description'] = $notatka->description;

                        $grid = $this->gridAjax($kryteria);
                        $obiektFormularza->zwrocFormularz()->resetuj();

                        $informacja['notatka'] = $grid;
                        $informacja['formularz'] = $obiektFormularza->zwrocFormularz()->html('', null, false);

                        echo json_encode($informacja);
                        die;
                    } else {
                        $this->komunikat($this->j->t['formularz.poprawne'], 'info', 'sesja');
                    }
                } else {
                    $this->komunikat($this->j->t['formularz.blad_zapisu'], 'info', 'sesja');
                }

            } else {
                if (Cms::inst()->usluga instanceof \Generic\Biblioteka\Usluga\Ajax) {
                    $informacja['kod'] = '1';
                    $informacja['info'] = $obiektFormularza->zwrocFormularz()->html('', null, false);
                    echo json_encode($informacja);
                    die;
                } else {
                    $this->komunikat($this->j->t['formularz.blad'], 'error');
                }
            }
        }
        if (Cms::inst()->usluga instanceof \Generic\Biblioteka\Usluga\Ajax) {
            $html = $obiektFormularza->zwrocFormularz()->html('', null, false);
        } else {
            $html = $obiektFormularza->zwrocFormularz()->html();
        }
        return $html;
    }

    private function formularzWyszukaj(TabelaDanych $grid)
    {
        $obiektFormularza = new \Generic\Formularz\Notes\Wyszukiwanie();
        $obiektFormularza->ustawTlumaczenia(
            $this->pobierzBlokTlumaczen('formularzSzukaj')
        );
        $szablon = $this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']);
        $dolaczJS = true;
        if (Cms::inst()->usluga instanceof \Generic\Biblioteka\Usluga\Ajax) {
            $dolaczJS = false;
        }
        $grid->naglowek($obiektFormularza->zwrocFormularz()->html($szablon, true, $dolaczJS));
        return $obiektFormularza->pobierzZmienioneWartosci();
    }

    public function wykonajPobierzDlaObiektu()
    {
        $id = Zadanie::pobierzGet('id', 'intval', 'abs');
        $object = Zadanie::pobierzGet('object', 'strval', 'filtr_xss');

        if ($id > 0 && $object !== '') {
            $notatkiMapper = $this->dane()->Notes();

            $listaNotatek = $notatkiMapper->szukaj(array(
                'object' => $object,
                'idObject' => $id,
                'status' => 'active',
            ));

            $notatkiAjax = '';
            foreach ($listaNotatek as $notatka) {
                $notatkiAjax .= "<p>" . $notatka->description . "</p>";
            }

            echo $notatkiAjax;
        }

        // return false;
    }
}

?>
