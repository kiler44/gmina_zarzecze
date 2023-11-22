<?php
namespace Generic\Modul\Attachments;

use Generic\Biblioteka\Modul;
use Generic\Model\Zalacznik;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Formularz\Attachments;
use Generic\Biblioteka\Katalog;

class Admin extends Modul\Admin
{

    protected $uprawnienia = array(
        'wykonajIndex',
        'wykonajTrash',
        'wykonajDelete',
        'wykonajRevert',
        'wykonajPreviewAttachments',
        'wykonajPreviewObject',
        'wykonajDownloadAttachments',
    );

    /**
     * @var \Generic\Konfiguracja\Modul\ZamowieniaBm\Admin
     */
    protected $k;

    /**
     * @var \Generic\Tlumaczenie\Pl\Modul\ZamowieniaBm\Admin
     */
    protected $j;


    public function wykonajIndex()
    {

        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['index.tytul_strony'],
            'tytul_modulu' => $this->j->t['index.tytul_modulu'],
        ));

        $grid = new TabelaDanych();
        $kryteria = $this->formularzWyszukaj($grid);
        $grid->dodajKolumne('id', '', 0, '', true);
        $grid->dodajKolumne('object', $this->j->t['index.etykieta_object'], '', Router::urlAdmin($this->kategoria, 'previewObject', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('id_object', $this->j->t['index.etykieta_id_object'], '', Router::urlAdmin($this->kategoria, 'previewObject', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('file', $this->j->t['index.etykieta_file'], '', Router::urlAdmin($this->kategoria, 'previewAttachments', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('date_added', $this->j->t['index.etykieta_data_added']);

        $przyciski = array(
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'delete', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-remove',
                'etykieta' => $this->j->t['index.tabela_etykieta_usun'],
                'target' => '_self',
                'klucz' => 'delete',
                'onclick' => 'return potwierdzenieUsun(\'' . $this->j->t['index.etykieta_potwierdz_usun'] . '\', $(this))',
            ),
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'previewAttachments', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-search',
                'etykieta' => $this->j->t['index.tabela_etykieta_podglad'],
                'target' => '_blank',
                'rel' => 'lightbox',
                'klucz' => 'previewAttachments',
            ),
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'downloadAttachments', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-download',
                'etykieta' => $this->j->t['index.tabela_etykieta_download'],
                'target' => '_self',
                'klucz' => 'downloadAttachments',
            )
        );

        $grid->dodajPrzyciski(
            Router::urlAdmin($this->kategoria, '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')), $przyciski
        );

        $kryteria['status'] = 'active';

        if (isset($kryteria['fraza']) && $kryteria['fraza'] != '') {
            $wieleId = $this->pobierzIdZalacznikaDoWyszukania($kryteria['fraza']);
            if (count($wieleId) > 0)
                $kryteria['wiele_id'] = $wieleId;
        }

        $mapper = $this->dane()->Zalacznik();
        $ilosc = $mapper->iloscSzukaj($kryteria);

        if ($ilosc > 0) {

            $naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval', 'abs'));
            $nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval', 'abs'));
            $kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
            $kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

            $sorter = new Zalacznik\Sorter($kolumna, $kierunek);
            $grid->ustawSortownie(array('object', 'id_object', 'file', 'date_added'), $kolumna, $kierunek,
                Router::urlAdmin($this->kategoria, 'index', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
            );

            $pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
            $grid->pager($pager->html(Router::urlAdmin($this->kategoria, 'index', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

            $pobraneZalaczniki = $mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter);

            $tytulyObiektow = $this->pobierzTytulObiektu($pobraneZalaczniki);

            array_flip($this->k->k['obiekt_nazwa_mappera']);
            foreach ($pobraneZalaczniki as $zalacznik) {
                $nazwaObiektu = $this->k->k['obiekt_nazwa_mappera'][strtolower($zalacznik['object'])];
                if (isset($tytulyObiektow[$nazwaObiektu][$zalacznik['id_object']])) {
                    $zalacznik['id_object'] = $tytulyObiektow[$nazwaObiektu][$zalacznik['id_object']];
                }
                if ($zalacznik['date_added'] != '') {
                    $zalacznik['date_added'] = date("d-m-Y h:i A", strtotime($zalacznik['date_added']));
                }
                $grid->dodajWiersz($zalacznik);
            }
        }

        $this->dodajMenuKontekstowe(array(
            'attachments_trash' => array(
                'url' => Router::urlAdmin($this->kategoria, 'trash'),
                'ikona' => 'icon-trash',
            ),
        ));
        $this->wyswietlMenuKontekstowe();

        $this->tresc .= $this->szablon->parsujBlok('/index', array(
            'tabela_danych' => $grid->html(),
        ));
    }

    private function wyswietlWieleZalacznikow($zalaczniki)
    {
        $obiekt = new Zalacznik\Obiekt();
        $grid = new TabelaDanych();
        $grid->dodajKolumne('id', '', 0, '', true);
        $grid->dodajKolumne('object', $this->j->t['index.etykieta_object'], '');
        $grid->dodajKolumne('id_object', $this->j->t['index.etykieta_id_object'], '');
        $grid->dodajKolumne('file', $this->j->t['index.etykieta_file'], '');
        $grid->dodajKolumne('kod', 'Url', '');
        $grid->dodajKolumne('date_added', $this->j->t['index.etykieta_data_added']);

        $przyciski = array(
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'previewAttachments', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-search',
                'etykieta' => $this->j->t['index.tabela_etykieta_podglad'],
                'target' => '_blank',
                //'rel' => 'lightbox',
                'onclick' => 'modalWModaluIFrame(this); return false;',
                'klucz' => 'previewAttachments',
            ),
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'downloadAttachments', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-download',
                'etykieta' => $this->j->t['index.tabela_etykieta_download'],
                'target' => '_self',
                'klucz' => 'downloadAttachments',
            )
        );

        $grid->dodajPrzyciski(
            Router::urlAdmin($this->kategoria, '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')), $przyciski
        );

        if (count($zalaczniki) > 0) {
            array_flip($this->k->k['obiekt_nazwa_mappera']);
            foreach ($zalaczniki as $zalacznik) {
                $nazwaObiektu = $this->k->k['obiekt_nazwa_mappera'][strtolower($zalacznik['object'])];
                if (isset($tytulyObiektow[$nazwaObiektu][$zalacznik['id_object']])) {
                    $zalacznik['id_object'] = $tytulyObiektow[$nazwaObiektu][$zalacznik['id_object']];
                }
                if ($zalacznik['date_added'] != '') {
                    $zalacznik['date_added'] = date("d-m-Y h:i A", strtotime($zalacznik['date_added']));
                }
                if ($zalacznik['kod'] != '') {

                    $zalacznik['kod'] = $obiekt->generujUrlZewnetrznyZTablicyObiektu($zalacznik, true);
                }
                $grid->dodajWiersz($zalacznik);
            }
        }

        return $this->szablon->parsujBlok('/index', array(
            'tabela_danych' => $grid->html(),
        ));

    }

    public function wykonajDownloadAttachments()
    {
        $cms = Cms::inst();
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['preview.tytul_strony'],
            'tytul_modulu' => $this->j->t['preview.tytul_modulu'],
        ));
        $mapper = $this->dane()->Zalacznik();
        $zalacznik = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if ($zalacznik instanceof Zalacznik\Obiekt) {

            $katalogDocelowy = new Katalog($cms->katalog(strtolower($zalacznik->object)));
            $zalacznikPlik = $katalogDocelowy->__toString() . '/' . $zalacznik->idObject . '/' . $zalacznik->file;

            if (is_file($zalacznikPlik)) {
                $file = new \finfo(FILEINFO_MIME);

                $content_type = $file->file($zalacznikPlik);

                header('Content-Type:application/force-download');
                header('Content-Disposition: attachment; filename="' . basename($zalacznikPlik) . '"');
                header('Content-Length:' . @filesize($zalacznikPlik));
                @readfile($zalacznikPlik) or die('File not found.');//czytamy plik
            } else {
                $this->komunikat($this->j->t['preview.error_zalacznik_nie_istnieje_plik'], 'error');
                $this->tresc .= $this->szablon->parsujBlok('/index', array());
            }
        } else {
            $this->komunikat($this->j->t['preview.error_zalacznik_nie_istnieje'], 'error');
            $this->tresc .= $this->szablon->parsujBlok('/index', array());
        }

    }

    /**
     * @todo dorobić podgląd plików - pogadać o opcji z załącznikami prywatnymi
     */
    public function wykonajPreviewAttachments()
    {
        $cms = Cms::inst();
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['preview.tytul_strony'],
            'tytul_modulu' => $this->j->t['preview.tytul_modulu'],
        ));
        $mapper = $this->dane()->Zalacznik();

        $id = Zadanie::pobierz('id', 'intval', 'abs');
        if ($id > 0) {
            $zalacznik = $mapper->pobierzPoId($id);
        } else {
            $zalacznik = null;
            $idObiektu = Zadanie::pobierz('idObiektu', 'intval', 'abs');
            $typObiektu = Zadanie::pobierz('typObiektu', 'strval', 'filtr_xss');
            $nazwaZalacznika = (Zadanie::pobierz('nazwaZalacznika', 'strval', 'filtr_xss') != '') ? Zadanie::pobierz('nazwaZalacznika', 'strval', 'filtr_xss') : null;
            $listaWymus = (Zadanie::pobierz('listaWymus', 'intval', 'abs')) ? 1 : 0;

            $zalaczniki = $mapper->pobierzDlaObjektu($typObiektu, $idObiektu, 'active', $nazwaZalacznika);

            if (count($zalaczniki) > 1 || $listaWymus) {
                $zalacznikiTab = $mapper->zwracaTablice()->pobierzDlaObjektu($typObiektu, $idObiektu, 'active', $nazwaZalacznika);

                $dane_json = array(
                    'status' => 1,
                    'tytul' => $this->j->t['preview.tytul_strony'],
                    'html' => $this->wyswietlWieleZalacznikow($zalacznikiTab),
                );
                //echo $this->wyswietlWieleZalacznikow($zalacznikiTab);
                echo json_encode($dane_json);
                die;
                return;
                //trigger_error('Obiekt o podanym ID posiada wiele zalacznikow. Metoda obsluguje pojedyncze zalaczniki.', E_USER_ERROR);
            }
            if (count($zalaczniki) == 1) {
                $zalacznik = $zalaczniki[0];
            }
        }

        if ($zalacznik instanceof Zalacznik\Obiekt) {

            $katalogDocelowy = new Katalog($cms->katalog(strtolower($zalacznik->object)));
            $zalacznikPlik = $katalogDocelowy->__toString() . '/' . $zalacznik->idObject . '/' . $zalacznik->file;

            if (is_file($zalacznikPlik)) {
                $url = $cms->url(strtolower($zalacznik->object), $zalacznik->idObject, $zalacznik->file, 'preview');
                Router::przekierujDo($url);
            } else {
                $this->komunikat($this->j->t['preview.error_zalacznik_nie_istnieje_plik'], 'error');
            }
        } else {
            $this->komunikat($this->j->t['preview.error_zalacznik_nie_istnieje'], 'error');
        }

    }

    public function wykonajPreviewObject()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['previewObject.tytul_strony'],
            'tytul_modulu' => $this->j->t['previewObject.tytul_modulu'],
        ));
        $mapper = $this->dane()->Zalacznik();
        $zalacznik = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if ($zalacznik instanceof Zalacznik\Obiekt) {
            if (isset($this->k->k['previewobject.akcja_podgladu_objektu'][$zalacznik->object])) {
                $cms = Cms::inst();
                $mapperKategoria = $cms->dane()->Kategoria();
                $idKategorii = $mapperKategoria->pobierzPoKodModulu($zalacznik->object);

                if ($idKategorii->id > 0) {
                    $akcja = $this->k->k['previewobject.akcja_podgladu_objektu'][$zalacznik->object];
                    $parametry = array('id' => $zalacznik->idObject);
                    $url = Router::urlAdmin($idKategorii, $akcja, $parametry);
                    Router::przekierujDo($url);
                } else {
                    $this->komunikat($this->j->t['previewobject.kategoria_nie_istnieje'], 'error');
                }

            } else {
                $this->komunikat($this->j->t['previewobject.brak_akcji_podgladu'], 'error');
            }

        } else {
            $this->komunikat($this->j->t['preview.error_zalacznik_nie_istnieje'], 'error', 'sesja');
        }

    }

    public function wykonajTrash()
    {
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['trash.tytul_strony'],
            'tytul_modulu' => $this->j->t['trash.tytul_modulu'],
        ));

        $grid = new TabelaDanych();
        $kryteria = $this->formularzWyszukaj($grid);
        $grid->dodajKolumne('id', '', 0, '', true);
        $grid->dodajKolumne('object', $this->j->t['index.etykieta_object']);
        $grid->dodajKolumne('id_object', $this->j->t['index.etykieta_id_object'], 50);
        $grid->dodajKolumne('file', $this->j->t['index.etykieta_file']);
        $grid->dodajKolumne('date_added', $this->j->t['index.etykieta_data_added']);

        $przyciski = array(
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'revert', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-repeat',
                'etykieta' => $this->j->t['trash.tabela_etykieta_przywroc'],
                'target' => '_self',
                'klucz' => 'revert',
                'onclick' => 'return potwierdzenieUsun(\'' . $this->j->t['trash.etykieta_potwierdz_przywroc'] . '\', $(this))',
            ),
        );

        $grid->dodajPrzyciski(
            Router::urlAdmin($this->kategoria, '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')), $przyciski
        );

        if (isset($kryteria['fraza']) && $kryteria['fraza'] != '') {
            $kryteria['wiele_id'] = $this->pobierzIdZalacznikaDoWyszukania($kryteria['fraza']);
        }
        $kryteria['status'] = 'delete';

        $mapper = $this->dane()->Zalacznik();
        $ilosc = $mapper->iloscSzukaj($kryteria);

        if ($ilosc > 0) {
            $naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval', 'abs'));
            $nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval', 'abs'));
            $kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
            $kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

            $sorter = new Zalacznik\Sorter($kolumna, $kierunek);
            $grid->ustawSortownie(array('object', 'id_object', 'file', 'date_added'), $kolumna, $kierunek,
                Router::urlAdmin($this->kategoria, 'index', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
            );

            $pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
            $grid->pager($pager->html(Router::urlAdmin($this->kategoria, 'index', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

            $pobraneZalaczniki = $mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter);

            foreach ($pobraneZalaczniki as $zalacznik) {
                if (isset($tytulyObiektow[$zalacznik['object']][$zalacznik['id_object']])) {
                    $zalacznik['id_object'] = $tytulyObiektow[$zalacznik['object']][$zalacznik['id_object']];
                }
                $grid->dodajWiersz($zalacznik);
            }

        }

        $this->dodajMenuKontekstowe(array(
            'attachments_index' => array(
                'url' => Router::urlAdmin($this->kategoria, 'index'),
                'ikona' => 'icon-list',
            ),
        ));
        $this->wyswietlMenuKontekstowe();

        $this->tresc .= $this->szablon->parsujBlok('/index', array(
            'tabela_danych' => $grid->html(),
        ));
    }

    public function wykonajRevert()
    {
        $mapper = $this->dane()->Zalacznik();
        $zalacznik = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if ($zalacznik instanceof Zalacznik\Obiekt) {
            $zalacznik->status = 'active';
            $zalacznik->zapisz($mapper);
            $this->komunikat($this->j->t['revert.info_przywrocono_zalacznik'], 'info', 'sesja');
        } else {
            $this->komunikat($this->j->t['revert.error_zalacznik_nie_istnieje'], 'error', 'sesja');
        }
        Router::przekierujDo(Router::urlAdmin($this->kategoria, 'trash'));
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
        foreach ($listaObiektow as $nazwaObiektu => $obiekt) {

            foreach ($obiekt as $obiekt) {
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

    public function wykonajDelete()
    {
        $mapper = $this->dane()->Zalacznik();
        $zalacznik = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if ($zalacznik instanceof Zalacznik\Obiekt) {
            $zalacznik->status = 'delete';
            $zalacznik->zapisz($mapper);
            $this->komunikat($this->j->t['delete.info_usunieta_zalacznik'], 'info', 'sesja');
        } else {
            $this->komunikat($this->j->t['delete.error_zalacznik_nie_istnieje'], 'error', 'sesja');
        }
        Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));

    }

    private function formularzWyszukaj(TabelaDanych $grid)
    {
        $formularzWyszukaj = new \Generic\Formularz\Attachments\Wyszukiwanie();
        $formularzWyszukaj->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzSzukaj'));

        $grid->naglowek($formularzWyszukaj->zwrocFormularz()->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));
        return $formularzWyszukaj->pobierzZmienioneWartosci();
    }

    private function pobierzIdZalacznikaDoWyszukania($fraza)
    {
        $kryteria['fraza'] = $fraza;
        $mapper = $this->dane()->Zalacznik();
        $tabelaIdObiektow = array();
        $daneObiektow = $mapper->zwracaTablice()->pobierzObiektyZalacznikow();

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
}

?>
