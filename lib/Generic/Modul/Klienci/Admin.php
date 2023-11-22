<?php

namespace Generic\Modul\Klienci;

use Generic\Model\Klient;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka;
use Generic\Biblioteka\Cms;

class Admin extends Modul\Admin
{

    protected $uprawnienia = array(
        'wykonajIndex',
        'wykonajAddCustomer',
        'wykonajDelete',
        'wykonajEditCustomer',
        'wykonajTrash',
        'wykonajRevert',
        'wykonajWyszukajKlientowAjax',
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

        $grid = new TabelaDanych();
        $kryteria = $this->formularzWyszukaj($grid);
        $grid->dodajKolumne('id', '', 0, '', true);
        $grid->dodajKolumne('type', $this->j->t['index.etykieta_type']);
        $grid->dodajKolumne('name', $this->j->t['index.etykieta_name'], '', Router::urlAdmin($this->kategoria, 'editCustomer', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('surname', $this->j->t['index.etykieta_surname'], '', Router::urlAdmin($this->kategoria, 'editCustomer', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('company_name', $this->j->t['index.etykieta_company_name'], '', Router::urlAdmin($this->kategoria, 'editCustomer', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('email', $this->j->t['index.etykieta_email']);
        $grid->dodajKolumne('phone_number', $this->j->t['index.etykieta_phone_number']);

        $przyciski = array(
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'editCustomer', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-pencil',
                'etykieta' => $this->j->t['editCustomer.klienci_etykieta_edytuj'],
                'target' => '_self',
                'klucz' => 'editCustomer',
            ),
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'addCustomer', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-plus-sign',
                'etykieta' => $this->j->t['addCustomer.klienci_etykieta_dodaj'],
                'target' => '_self',
                'klucz' => 'addCustomer',
            ),
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'delete', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-remove',
                'etykieta' => $this->j->t['usun.klienci_etykieta_usun'],
                'target' => '_self',
                'klucz' => 'delete',
                'onclick' => 'return potwierdzenieUsun(\'' . $this->j->t['usun.etykieta_potwierdz_usun'] . '\', $(this))',
            )
        );

        if ($this->k->k['index.wyswietlaj_dzieci_nowy_widok']) {
            $przyciskPrzejdzDalej[] = array(
                'akcja' => Router::urlAdmin($this->kategoria, 'index', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => ' icon-search',
                'etykieta' => $this->j->t['index.klienci_etykieta_przejdz_dalej'],
                'target' => '_self',
                'klucz' => 'index',
            );
            $przyciski = array_merge($przyciski, $przyciskPrzejdzDalej);
        }
        $grid->dodajPrzyciski(
            Router::urlAdmin($this->kategoria, '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')), $przyciski
        );

        if ($this->k->k['index.wyswietlaj_drzewo']) {
            $kryteria['bez_rodzica'] = 1;
        }
        if (Zadanie::pobierz('id', 'intval', 'abs') > 0) {
            $daneKlienta = $this->pobierzKlienta(Zadanie::pobierz('id', 'intval', 'abs'));

            $naglowek = $this->j->t['index.tytul_strony_kategoria'] . ' '
                . $daneKlienta->name . ' ' . $daneKlienta->secondName
                . '(' . $daneKlienta->companyName . ')';
            $this->ustawGlobalne(array('tytul_strony' => $naglowek));

            Biblioteka\Cms::inst()->temp('sciezka', array(
                array('idKategorii' => $this->kategoria->id, 'akcja' => 'index'),
            ));
            $kryteria['id_parent'] = Zadanie::pobierz('id', 'intval', 'abs');
            $kryteria['bez_rodzica'] = null;
        }

        $kryteria['status'] = 'active';

        //$mapper = $this->dane()->Klient();
        $mapper = new Klient\SphinxMapper();
        $ilosc = $mapper->iloscSzukaj($kryteria);

        if ($ilosc > 0) {
            $naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval', 'abs'));
            $nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval', 'abs'));
            $kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
            $kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

            $sorter = new Klient\Sorter('id', $kierunek);
            $grid->ustawSortownie(array('name', 'surname', 'company_name'), $kolumna, $kierunek,
                Router::urlAdmin($this->kategoria, 'index', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
            );

            $pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
            $grid->pager($pager->html(Router::urlAdmin($this->kategoria, 'index', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

            $zliczIloscDzieci = new Klient\Obiekt();
            $tablicaKlientMaDzieci = $zliczIloscDzieci->zliczDzieci();

            $pobraniKlienci = $mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter);

            foreach ($pobraniKlienci as $klient) {
                if ($klient['id_parent'] > 0) {
                    $grid->usunPrzyciski(array('addCustomer', 'index'));
                }

                if ($klient['status']) {
                    $klient['status'] = $this->j->t['klienci_status'][$klient['status']];
                }
                if ($klient['type'] == 'private') {
                    $grid->usunPrzyciski(array('addCustomer', 'index'));
                }
                if ($klient['type']) {
                    $klient['type'] = $this->j->t['formularz.klienci_typy'][$klient['type']];
                }
                if (!in_array($klient['id'], $tablicaKlientMaDzieci)) {
                    $grid->usunPrzyciski(array('index'));
                }
                $telefon = array();
                if (isset($klient['phone_number']) && $klient['phone_number'] != '') {
                    $telefon[] = $klient['phone_number'];
                }
                if (isset($klient['phone_number_1']) && $klient['phone_number_1'] != '') {
                    $telefon[] = $klient['phone_number_1'];
                }
                if (isset($klient['phone_number_2']) && $klient['phone_number_2'] != '') {
                    $telefon[] = $klient['phone_number_2'];
                }
                if (isset($klient['phone_mobile']) && $klient['phone_mobile'] != '') {
                    $telefon[] = $klient['phone_mobile'];
                }
                $klient['phone_number'] = implode(', ', $telefon);
                $grid->dodajWiersz($klient);

                if ($this->k->k['index.wyswietlaj_drzewo'] && !$this->k->k['index.wyswietlaj_dzieci_nowy_widok']) {
                    $dzieci = $this->pobierzDzieciPoWieleId($pobraniKlienci);
                    if (isset($dzieci[$klient['id']])) {
                        $iloscDzieci = count($dzieci[$klient['id']]);
                        for ($i = 0; $i < $iloscDzieci; $i++) {
                            $grid->usunPrzyciski(array('addCustomer', 'index'));
                            $grid->ustawKlase('podkategoria');
                            $grid->dodajWiersz($dzieci[$klient['id']][$i]);
                        }
                    }
                }

            }

        }

        $this->dodajMenuKontekstowe(array(
            'klienci_dodaj' => array(
                'url' => Router::urlAdmin($this->kategoria, 'addCustomer'),
                'ikona' => 'icon-plus-sign',
            ),
            'klienci_trash' => array(
                'url' => Router::urlAdmin($this->kategoria, 'trash'),
                'ikona' => 'icon-trash',
            ),
        ));
        $this->wyswietlMenuKontekstowe();

        $urlAjax = Router::urlAjax("Admin", $this->kategoria, "addCustomer");
        $this->tresc .= $this->szablon->parsujBlok('/index', array(
            'tabela_danych' => $grid->html(),
            'urlAjax' => $urlAjax,
        ));
    }

    public function wykonajAddCustomer()
    {
        $cms = Cms::inst();


        $id = Zadanie::pobierz('id', 'intval', 'abs');

        if ($id > 0) {
            $klient = $this->dane()->Klient()->pobierzPoId($id);
            if (!$klient instanceof Klient\Obiekt) {
                trigger_error('Błędne ID klienta - nie ma takiego klienta w bazie', E_USER_ERROR);
            }
            $this->ustawGlobalne(array(
                'tytul_strony' => $this->j->t['edytuj.tytul_strony'],
                'tytul_modulu' => $this->j->t['editCustomer.klienci_etykieta_edytuj'],
            ));
            $naglowek = $this->j->t['editCustomer.klienci_etykieta_edytuj'];
        } else {
            $this->ustawGlobalne(array(
                'tytul_strony' => $this->j->t['dodaj.tytul_strony'],
                'tytul_modulu' => $this->j->t['dodaj.tytul_modulu'],
            ));
            $naglowek = $this->j->t['dodaj.tytul_modulu'];
            $klient = new Klient\Obiekt();
            $klient->idProjektu = ID_PROJEKTU;
        }

        $idRodzica = Zadanie::pobierzGet('idParent', 'intval', 'abs');

        /*
        $type = \Generic\Biblioteka\Zadanie::pobierzGet('type');

        if($type == 'branch contact person')
        {
            $idRodzica = 1;
        }
         *
         */
        if (isset($idRodzica) && $idRodzica > 0) {
            $mapper = $this->dane()->Klient();
            $rodzic = $mapper->pobierzPoId($idRodzica);
            if ($rodzic instanceof Klient\Obiekt) {
                $naglowek = $this->j->t['dodaj.tytul_strony_kategoria_dodaj'] . ' '
                    . $rodzic->name . ' ' . $rodzic->secondName
                    . '(' . $rodzic->companyName . ')';
                $this->ustawGlobalne(array('tytul_strony' => $naglowek));

                $klient->idParent = $idRodzica;
                $klient->companyName = $rodzic->companyName;
                $klient->address = $rodzic->address;
                $klient->postcode = $rodzic->postcode;
                $klient->apartament = $rodzic->apartament;
                $klient->city = $rodzic->city;
            } else {
                $this->komunikat($this->j->t['dodaj.blad_nie_mozna_pobrac_rodzica'], 'error', 'sesja');
                Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
            }

        }

        $urlAjax = Router::urlAjax("Admin", $this->kategoria, "addCustomer");
        $this->tresc .= $this->szablon->parsujBlok('script');
        $form = $this->formularz($klient);
        if ($cms->usluga instanceof Biblioteka\Usluga\Ajax) {
            $developer = '';
            $company = '';
            $developer = ' \'0\' : \'' . $this->j->t['etykieta_select_wybierz'] . '\' , ';
            $company = ' \'0\' : \'' . $this->j->t['etykieta_select_wybierz'] . '\' , ';

            foreach ($this->j->t['formularz.klienci_typy'] as $typ => $tlumaczenie) {
                if (array_key_exists($typ, $this->k->k['formularz.company.typy_dzieci'])) {

                    $company .= '\'' . $typ . '\' : \'' . $tlumaczenie . '\' , ';

                }
                if (array_key_exists($typ, $this->k->k['formularz.developer.typy_dzieci'])) {
                    $developer .= '\'' . $typ . '\' : \'' . $tlumaczenie . '\' , ';

                }

            }
            $urlAjax = Router::urlAjax("Admin", $this->kategoria, "addCustomer");

            $rodzajFormularza = Zadanie::pobierz('formType', 'strval', 'filtr_xss');
            if ($rodzajFormularza == '') $rodzajFormularza = 'simple';

            $this->tresc .= $this->szablon->parsujBlok('dodajAjax', array(
                'form' => $form,
                'typyDlaDeveloper' => $developer,
                'typyDlaCompany' => $company,
                'urlAjax' => $urlAjax,
                'etykieta_tytul' => $naglowek,
                'etykieta_prosty_form' => $this->j->t['formularz.etykieta_prosty_form'],
                'etykieta_pelny_form' => $this->j->t['formularz.etykieta_pelny_form'],
                'prosty_active' => ($rodzajFormularza == 'simple') ? 'active' : '',
                'pelny_active' => ($rodzajFormularza == 'complex') ? 'active' : '',
            ));
        } else {
            $this->dodajMenuKontekstowe(array(
                'klienci_index' => array(
                    'url' => Router::urlAdmin($this->kategoria, 'index'),
                    'ikona' => 'icon-list',
                ),
                'klienci_trash' => array(
                    'url' => Router::urlAdmin($this->kategoria, 'trash'),
                    'ikona' => 'icon-trash',
                ),
            ));
            $this->wyswietlMenuKontekstowe();

            $rodzajFormularza = Zadanie::pobierz('formType', 'strval', 'filtr_xss');
            if ($rodzajFormularza == '') $rodzajFormularza = 'simple';


            $this->tresc .= $this->szablon->parsujBlok('dodaj', array(
                'form' => $form,
                'etykieta_prosty_form' => $this->j->t['formularz.etykieta_prosty_form'],
                'etykieta_pelny_form' => $this->j->t['formularz.etykieta_pelny_form'],
                'prosty_active' => ($rodzajFormularza == 'simple') ? 'active' : '',
                'pelny_active' => ($rodzajFormularza == 'complex') ? 'active' : '',
            ));
            $this->tresc .= $this->szablon->parsujBlok('script');

        }

    }

    public function wykonajTrash()
    {
        $this->ustawGlobalne(array('tytul_strony' => $this->j->t['trash.tytul_strony']));

        $formularzWyszukaj = new \Generic\Formularz\Klienci\Wyszukiwanie();
        $formularzWyszukaj->ustawTlumaczenia(array_merge(
                $this->pobierzBlokTlumaczen('formularzSzukaj'),
                array(
                    'etykieta_select_wybierz' => $this->j->t['etykieta_select_wybierz'],
                    'klienci_typy' => $this->j->t['formularz.klienci_typy'],
                )
            )
        );

        $grid = new TabelaDanych();

        $grid->naglowek($formularzWyszukaj->zwrocFormularz()->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

        $grid->dodajKolumne('id', '', 0, '', true);
        $grid->dodajKolumne('type', $this->j->t['index.etykieta_type'], 10);
        $grid->dodajKolumne('name', $this->j->t['index.etykieta_name'], 150);
        $grid->dodajKolumne('surname', $this->j->t['index.etykieta_surname'], 150);
        $grid->dodajKolumne('company_name', $this->j->t['index.etykieta_company_name'], 150);
        $grid->dodajKolumne('email', $this->j->t['index.etykieta_email']);
        $grid->dodajKolumne('phone_number', $this->j->t['index.etykieta_phone_number']);
        $grid->dodajPrzyciski(
            Router::urlAdmin($this->kategoria, '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
            array(
                array(
                    'akcja' => Router::urlAdmin($this->kategoria, 'revert', array('{KLUCZ}' => '{WARTOSC}')),
                    'ikona' => 'icon-repeat',
                    'etykieta' => $this->j->t['revert.klienci_etykieta_przywroc'],
                    'target' => '_self',
                    'klucz' => 'revert',
                    'onclick' => 'return potwierdzenieUsun(\'' . $this->j->t['revert.etykieta_potwierdz_przywroc'] . '\', $(this))',
                )
            )
        );
        $kryteria = $formularzWyszukaj->pobierzZmienioneWartosci();
        $kryteria['status'] = 'delete';

        $mapper = $this->dane()->Klient();
        $ilosc = $mapper->iloscSzukaj($kryteria);

        if ($ilosc > 0) {

            $naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval', 'abs'));
            $nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval', 'abs'));
            $kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
            $kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

            $sorter = new Klient\Sorter($kolumna, $kierunek);
            $grid->ustawSortownie(array('name', 'surname', 'company_name'), $kolumna, $kierunek,
                Router::urlAdmin($this->kategoria, 'trash', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
            );

            $pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
            $grid->pager($pager->html(Router::urlAdmin($this->kategoria, 'trash', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

            foreach ($mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter) as $klient) {

                if ($klient['type']) {
                    $klient['type'] = $this->j->t['formularz.klienci_typy'][$klient['type']];
                }
                $telefon = array();
                if (isset($klient['phone_number']) && $klient['phone_number'] != '') {
                    $telefon[] = $klient['phone_number'];
                }
                if (isset($klient['phone_number_1']) && $klient['phone_number_1'] != '') {
                    $telefon[] = $klient['phone_number_1'];
                }
                if (isset($klient['phone_number_2']) && $klient['phone_number_2'] != '') {
                    $telefon[] = $klient['phone_number_2'];
                }
                if (isset($klient['phone_mobile']) && $klient['phone_mobile'] != '') {
                    $telefon[] = $klient['phone_mobile'];
                }
                $klient['phone_number'] = implode(', ', $telefon);
                $grid->dodajWiersz($klient);
            }

        }

        $this->dodajMenuKontekstowe(array(
            'klienci_dodaj' => array(
                'url' => Router::urlAdmin($this->kategoria, 'addCustomer'),
                'ikona' => 'icon-plus-sign',
            ),
            'klienci_index' => array(
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
        $mapper = $this->dane()->Klient();
        $klient = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if ($klient instanceof Klient\Obiekt) {
            if ($klient->idParent > 0) {
                $rodzic = $mapper->pobierzPoId($klient->idParent);
                if ($rodzic instanceof Klient\Obiekt) {
                    if ($rodzic->status == 'active') {
                        $klient->status = 'active';
                        $klient->zapisz($mapper);
                        $this->komunikat($this->j->t['revert.klient_przywrocony_z_kosza'], 'info', 'sesja');
                        Router::przekierujDo(Router::urlAdmin($this->kategoria, 'trash'));
                    } else {
                        $this->komunikat($this->j->t['revert.blad_rodzic_ma_status_delete'], 'error', 'sesja');
                        Router::przekierujDo(Router::urlAdmin($this->kategoria, 'trash'));
                    }
                } else {
                    $this->komunikat($this->j->t['revert.blad_rodzic_nie_istnieje'], 'error', 'sesja');
                    Router::przekierujDo(Router::urlAdmin($this->kategoria, 'trash'));
                }
            } else {
                $klient->status = 'active';
                $klient->zapisz($mapper);
                $this->komunikat($this->j->t['revert.klient_przywrocony_z_kosza'], 'info', 'sesja');
                Router::przekierujDo(Router::urlAdmin($this->kategoria, 'trash'));
            }

        } else {
            $this->komunikat($this->j->t['revert.blad_nie_mozna_pobrac_klienta'], 'error', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'trash'));
        }
    }

    public function wykonajDelete()
    {
        $mapper = $this->dane()->Klient();
        $klient = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

        if ($klient instanceof Klient\Obiekt) {

            if ($mapper->maDzieci($klient->id) > 0) {
                $this->komunikat($this->j->t['usun.blad_klient_ma_dzieci'], 'error', 'sesja');
                Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
            } else {
                $klient->status = 'delete';
                $klient->zapisz($mapper);
                $this->komunikat($this->j->t['usun.klient_usuniety'], 'info', 'sesja');
                Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
            }

        } else {
            $this->komunikat($this->j->t['usun.blad_nie_mozna_pobrac_klienta'], 'error', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
        }

    }

    public function wykonajEditCustomer()
    {
        $this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

        $mapper = $this->Dane()->Klient();
        $klient = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));
        if ($klient instanceof Klient\Obiekt) {
            $rodzajFormularza = Zadanie::pobierz('formType', 'strval', 'filtr_xss');
            if ($rodzajFormularza == '') $rodzajFormularza = 'simple';
            $this->tresc .= $this->szablon->parsujBlok('dodaj', array(
                'form' => $this->formularz($klient),
                'etykieta_prosty_form' => $this->j->t['formularz.etykieta_prosty_form'],
                'etykieta_pelny_form' => $this->j->t['formularz.etykieta_pelny_form'],
                'prosty_active' => ($rodzajFormularza == 'simple') ? 'active' : '',
                'pelny_active' => ($rodzajFormularza == 'complex') ? 'active' : '',
            ));
            $this->tresc .= $this->szablon->parsujBlok('script');
        } else {

            $this->komunikat($this->j->t['edytuj.blad_nie_mozna_pobrac_klienta'], 'error', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));

        }

        $this->dodajMenuKontekstowe(array(
            'klienci_index' => array(
                'url' => Router::urlAdmin($this->kategoria, 'index'),
                'ikona' => 'icon-list',
            ),
            'klienci_trash' => array(
                'url' => Router::urlAdmin($this->kategoria, 'trash'),
                'ikona' => 'icon-trash',
            ),
        ));
        $this->wyswietlMenuKontekstowe();

    }

    /**
     * @var $pobraniKlienci lista klientów bez rodzica
     */
    private function pobierzDzieciPoWieleId($pobraniKlienci)
    {
        $tablicaIdKlienta = array();
        if (count($pobraniKlienci) > 0) {
            foreach ($pobraniKlienci as $klient) {
                array_push($tablicaIdKlienta, $klient['id']);
            }
        }

        $maper = $this->dane()->Klient();
        $pobraneDzieci = $maper->pobierzDlaRodzicow($tablicaIdKlienta);

        $tablicaPoIdRodzica = array();
        if (count($pobraneDzieci) > 0) {
            foreach ($pobraneDzieci as $dziecko) {
                $tablicaPoIdRodzica[$dziecko->idParent][] = array(
                    'id' => $dziecko->id,
                    'name' => $dziecko->name,
                    'surname' => $dziecko->surname,
                    'second_name' => $dziecko->secondName,
                    'company_name' => $dziecko->companyName,
                    'type' => $this->j->t['formularz.klienci_typy'][$dziecko->type],
                    'status' => $this->j->t['klienci_status'][$dziecko->status],
                    'org_number' => $dziecko->orgNumber,
                    'data_added' => $dziecko->dataAdded,
                );
            }
        }
        return $tablicaPoIdRodzica;
    }

    private function formularz(Klient\Obiekt $klient)
    {
        $type = Zadanie::pobierz('type');
        if (Cms::inst()->usluga instanceof Biblioteka\Usluga\Ajax) {
            if (Zadanie::pobierz('type') != 'private') {
                // daje możliwość wybrania rodzica z listy
                $this->k->k['formularz.ajax'] = true;
            }
        }


        $updateField = Zadanie::pobierz('field', 'strval', 'filtr_xss');
        $obiektFormularza = new \Generic\Formularz\Klienci\Edycja();
        $obiektFormularza->ustawTlumaczenia($this->j->pobierzBlokTlumaczen('formularz'));
        $obiektFormularza->ustawObiekt($klient);
        $obiektFormularza->ustawUrlPowrotny(Router::urlAdmin($this->kategoria));
        $obiektFormularza->ustawKonfiguracje(array_merge($this->k->k, array('updateField' => $updateField)));

        if (in_array($klient->id, $this->k->k['formularz.zabron_edycji_klienta'])) {
            $this->komunikat($this->j->t['formularz.edycja_klienta_zablokowana'], 'warning');
            $form = $obiektFormularza->zwrocFormularz();
            foreach ($this->k->k['formularz.zabron_edycji_zablokowani'] as $pole) {
                $form->input($pole)->dodajAtrybuty(array('disabled' => 'disabled'));
            }
        }

        // jezeli klient nie istnieje
        if ($klient->id < 1) {
            $idParent = Zadanie::pobierz('idParent', 'intval', 'abs');
            if ($idParent > 0) {
                $rodzic = $this->pobierzKlienta($idParent);
                $type = str_replace(' ', '_', $rodzic->type);
                $obiektFormularza->zwrocFormularz()->input('type')->ustawWartosc($this->k->k['formularz.' . $type . '.domyslny_typ']);
            }
            /*
            else
            {
                // dla zwykłego formularza usuwamy pole branch contact person
                $usunElement = $this->j->t['formularz.klienci_typy'];
                array_pop( $usunElement );

                $parametry = $usunElement;
                $obiektFormularza->zwrocFormularz()->input('type')->ustawParametr('lista', $parametry);
            }
             */

            $klient->dataAdded = date("Y-m-d H:i:s");
            $komunikatDanePoprawne = $this->j->t['dodaj.info_klient_zapisany'];
        } else {
            // jezeli klient istnieje i posiada rodzica
            if ($klient->idParent > 0) {
                $rodzic = $this->pobierzKlienta($klient->idParent);
                $type = str_replace(' ', '_', $rodzic->type);
            } else {
                $type = $klient->type;
            }
            $komunikatDanePoprawne = $this->j->t['dodaj.info_klient_edycja_zapisany'];
        }

        // jeżeli dodajemy do rodzica albo edytujemy klienta posiadającego rodzica
        if (isset($rodzic) && $rodzic->id > 0) {
            // ustawiaomy tłumaczenia dla typów klienta dostępnych dla danego rodzica
            foreach ($this->j->t['formularz.klienci_typy'] as $typ => $tlumaczenie) {
                if (array_key_exists($typ, $this->k->k['formularz.' . $type . '.typy_dzieci'])) {
                    $parametry[$typ] = $tlumaczenie;
                }
            }

            $obiektFormularza->zwrocFormularz()->input('type')
                ->ustawParametr('lista', $parametry)
                ->ustawWartosc($this->k->k['formularz.' . $type . '.domyslny_typ']);
        } else {
            $obiektFormularza->zwrocFormularz()->input('type')->ustawWartosc($type, true);
        }

        if ($obiektFormularza->wypelniony()) {
            $wartosci = $obiektFormularza->pobierzWartosci();

            // @TODO dorobić konfiguracje do pola wymagane tutaj i w js
            if ($wartosci['type'] == 'private') {
                foreach ($this->k->k['formularz.wymagane_wartosci_dla_private'] as $key => $value) {
                    $obiektFormularza->zwrocFormularz()->input($key)->wymagany = $value;
                }

            }
            if ($wartosci['type'] == 'company') {
                foreach ($this->k->k['formularz.wymagane_wartosci_dla_company'] as $key => $value) {
                    $obiektFormularza->zwrocFormularz()->input($key)->wymagany = $value;
                }

                $obiektFormularza->zwrocFormularz()->input('name')->wymagany = false;
                $obiektFormularza->zwrocFormularz()->input('surname')->wymagany = false;
            }
            if ($wartosci['type'] == 'developer') {
                foreach ($this->k->k['formularz.wymagane_wartosci_dla_developer'] as $key => $value) {
                    $obiektFormularza->zwrocFormularz()->input($key)->wymagany = $value;
                }
                $obiektFormularza->zwrocFormularz()->input('name')->wymagany = false;
                $obiektFormularza->zwrocFormularz()->input('surname')->wymagany = false;
            }
            if ($wartosci['type'] == 'branch contact person') {
                foreach ($this->k->k['formularz.wymagane_wartosci_dla_branch_contact_person'] as $key => $value) {
                    if ($key == 'kostsenter') continue;
                    $obiektFormularza->zwrocFormularz()->input($key)->wymagany = $value;
                }
                $obiektFormularza->zwrocFormularz()->usunInput('idCustomer');
                $obiektFormularza->zwrocFormularz()->input('idParent')->wymagany = true;
                $obiektFormularza->zwrocFormularz()->input('idParent')->dodajWalidator(new Biblioteka\Walidator\RozneOd('0'));
            }

            if ($obiektFormularza->danePoprawne()) {
                $mapper = $this->dane()->Klient();

                foreach ($wartosci as $klucz => $wartosc) {
                    if ($klucz == 'formType' || $klucz == 'id') continue;
                    $klient->$klucz = $wartosc;
                }

                if (isset($wartosci['idParent']) && $wartosci['idParent'] > 0) {
                    $rodzic = $this->pobierzKlienta($wartosci['idParent']);
                    if ($rodzic instanceof Klient\Obiekt) {
                        $klient->idParent = $wartosci['idParent'];
                        $klient->companyName = $rodzic->companyName;
                        $klient->address = $rodzic->address;
                        $klient->apartament = $rodzic->apartament;
                        $klient->korespondencjaApartament = $rodzic->korespondencjaApartament;
                        $klient->postcode = $rodzic->postcode;
                        $klient->city = $rodzic->city;
                        $klient->korespondencjaAddress = $rodzic->korespondencjaAddress;
                        $klient->korespondencjaCity = $rodzic->korespondencjaCity;
                        $klient->korespondencjaPostcode = $rodzic->korespondencjaPostcode;
                    }
                }

                if ($klient->zapisz($mapper)) {

                    if ($klient->type == 'private') {
                        $zamowieniaMapper = $this->dane()->Zamowienie();
                        $zamowienia = $zamowieniaMapper->szukaj(array('number_privat_customer' => $klient->id));
                        /*
                        if($zamowienia[0]->apartament != '')
                        {
                            $klient->apartment = $zamowienia[0]->apartament;
                        }
                         *
                         */

                        /* @var $zamowienia \Generic\Model\Zamowienie\Obiekt[] */
                        foreach ($zamowienia as $zamowienie) {
                            if (!in_array($zamowienie->idType, $this->k->k['editCustomer.id_typu_nie_zmieniaj_nazwy_zamowienia'])) {
                                $zamowienie->orderName = $zamowienie->pobierzStandardowyTytulZamowienia();
                                if (!$zamowienie->zapisz($zamowieniaMapper)) {
                                    trigger_error('Blad zapisu nowo wygenerowanego tytulu zamowienia po zmianie klienta', E_USER_WARNING);
                                }
                            }
                        }
                    }
                    if (Cms::inst()->usluga instanceof Biblioteka\Usluga\Ajax) {
                        $ajaxKlient = $mapper->zwracaTablice()->pobierzPoId($klient->id);
                        $ajaxKlient['kod'] = '2';

                        echo json_encode($ajaxKlient);
                        die;
                    } else {
                        $this->komunikat($komunikatDanePoprawne, 'info', 'sesja');
                        Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
                    }
                } else {
                    if (Cms::inst()->usluga instanceof Biblioteka\Usluga\Ajax) {
                        $informacja['kod'] = '0';
                        $informacja['info'] = $this->j->t['dodaj.blad_nie_mozna_zapisac_klienta'];
                        echo json_encode($informacja);
                        die;
                    } else {
                        $this->komunikat($this->j->t['dodaj.blad_nie_mozna_zapisac_klienta'], 'error', 'sesja');
                    }
                }
            } else {
                if (Cms::inst()->usluga instanceof Biblioteka\Usluga\Ajax) {
                    $obiektFormularza->zwrocFormularz()->valid();
                    $informacja['kod'] = '1';
                    $informacja['info'] = $obiektFormularza->zwrocFormularz()->html('', null, false);

                    echo json_encode($informacja);
                    die;
                } else {
                    $this->komunikat($this->j->t['formularz.edycja_admin_blad_walidacji'], 'warning');
                }
            }
        }

        if (Cms::inst()->usluga instanceof Biblioteka\Usluga\Ajax) {
            $form = $obiektFormularza->zwrocFormularz()->html('', null, false);
        } else {
            $form = $obiektFormularza->zwrocFormularz()->html();
        }
        return $form;
    }

    private function formularzWyszukaj(TabelaDanych $grid)
    {
        $formularzWyszukaj = new \Generic\Formularz\Klienci\Wyszukiwanie();
        $formularzWyszukaj->ustawTlumaczenia(array_merge(
                $this->pobierzBlokTlumaczen('formularzSzukaj'),
                array(
                    'etykieta_select_wybierz' => $this->j->t['etykieta_select_wybierz'],
                    'klienci_typy' => $this->j->t['formularz.klienci_typy'],
                )
            )
        );
        $grid->naglowek($formularzWyszukaj->zwrocFormularz()->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));
        return $formularzWyszukaj->pobierzZmienioneWartosci();
    }

    private function pobierzKlienta($id)
    {
        $maperKlientWybrany = $this->dane()->Klient();
        $daneKlienta = $maperKlientWybrany->pobierzPoId($id);
        if ($daneKlienta instanceof Klient\Obiekt) {
            return $daneKlienta;
        } else {
            $this->komunikat($this->j->t['edytuj.blad_nie_mozna_pobrac_klienta'], 'error', 'sesja');
            Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
            return null;
        }
    }


    public function wykonajWyszukajKlientowAjax()
    {
        $fraza = Zadanie::pobierz('fraza', 'strval', 'filtr_xss');
        $typKlienta = Zadanie::pobierz('typKlienta', 'strval', 'filtr_xss');

        $mapper = utworzObiektRaz('\\Generic\\Model\\Klient\\SphinxMapper');

        $mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
        $getId = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('orders.get_id', 'Orders_Admin');

        $kryteriaDomyslne = array('status' => 'active', 'fraza' => $fraza);

        switch ($typKlienta) {
            case 'get_contacts':
                $type = 'branch contact person';
                $kryteria = array('id_parent' => $getId, 'typ' => $type);
                break;
            /*
                case 'customer_contacts':
                    $type = 'branch contact person';
                    $kryteria = array('id_parent' => $this->obiekt->numberPrivatCustomer, 'typ' => $type);
                break;
                case 'billing_customer_contacts':
                    $type = 'branch contact person';
                    $kryteria = array('id_parent' => $this->obiekt->numberCustomer, 'typ' => $type);
                break;

                case 'parent_customer':
                    $zamowienieMapper = utworzObiektRaz('\\Generic\\Model\\Zamowienie\\Mapper');
                    $parent = $zamowienieMapper->pobierzPoId($this->obiekt->idParent);
                    $kryteria = array('typ' => $type);
                break;
                case 'parent_billing_customer':
                    $zamowienieMapper = utworzObiektRaz('\\Generic\\Model\\Zamowienie\\Mapper');
                    $parent = $zamowienieMapper->pobierzPoId($this->obiekt->idParent);
                    $type = $parent->customer->type;
                    $kryteria = array('typ' => $type);
                break;
             */
            default :
                if (in_array($typKlienta, array('private', 'company', 'developer', 'branch contact person'))) {
                    $kryteria = array('typ' => $typKlienta);
                } else {
                    $kryteria = array();
                }
                break;
        }

        $kryteria = array_merge($kryteriaDomyslne, $kryteria);

        $iloscWynikow = $mapper->iloscSzukaj($kryteria);

        $naStronie = Zadanie::pobierz('naStronie', 'intval', 'abs');
        $nrStrony = Zadanie::pobierz('nrStrony', 'intval', 'abs');

        $pager = new Pager($iloscWynikow, $naStronie, $nrStrony);
        //$klienci = $mapper->zwracaTablice()->szukaj($kryteria, $pager);


        $wyniki = $mapper->zwracaTablice()->szukaj($kryteria, $pager);

        $dane = array('total' => $iloscWynikow, 'cust' => $wyniki, 'page' => $nrStrony);
        echo json_encode($dane);
        die;

        //return array('lista' => $lista, 'wartosc' => $wartosc, 'type' => $type);
    }

}