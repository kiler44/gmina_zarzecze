<?php

namespace Generic\Modul\ZamowieniaBm;


use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Input\Select;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Zadanie;
use Generic\Formularz\ZamowieniaBm;
use Generic\Model\Blok;
use Generic\Model\Kategoria;
use Generic\Model\Klient;
use Generic\Model\ProduktyMagazyn;
use Generic\Model\Uzytkownik;
use Generic\Model\ZamowieniaBm as Zamowienia;
use Generic\Model\Zalacznik;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\SmsBm;
use Generic\Biblioteka\Pomocnik;


class Admin extends Modul\Admin
{

    protected $uprawnienia = array(
        'wykonajIndex',
        'wykonajDodaj',
        'wykonajUsun',
        'wykonajUsunPlik',
        'wykonajDodajPlik',
        'wykonajPodglad',
        'wykonajPodgladZalacznikiWszystkie',
        'wykonajZmienStatus'
    );
    protected $akcjeAjax = array(
        'wykonajUsunPlik',
        'wykonajDodajPlik',
        'wykonajZmienStatus'
    );
    /**
     * @var \Generic\Konfiguracja\Modul\ZamowieniaBm\Admin
     */
    protected $k;

    /**
     * @var \Generic\Tlumaczenie\Pl\Modul\ZamowieniaBm\Admin
     */
    protected $j;

    public function inicjuj(\Generic\Biblioteka\Sterownik $sterownik, Kategoria\Obiekt $kategoria = null, Blok\Obiekt $blok = null)
    {
        parent::inicjuj($sterownik, $kategoria, $blok);
        $this->dodajMenuKontekstowe(array(
            'dodaj' => array(
                'url' => Router::urlAdmin($this->kategoria, 'dodaj'),
                'ikona' => 'icon-plus-sign',
            ),
            'index' => array(
                'url' => Router::urlAdmin($this->kategoria, 'index'),
                'ikona' => 'icon-list',
            ),
            'archiwum' => array(
                'url' => Router::urlAdmin($this->kategoria, 'index', array('status' => 'archiwum')),
                'ikona' => 'icon-file',
            ),
        ));
    }

    public function wykonajIndex()
    {
        $cms = Cms::inst();
        $this->ustawGlobalne(array(
            'tytul_strony' => $this->j->t['index.tytul_strony'],
            'tytul_modulu' => $this->j->t['index.tytul_modulu'],
        ));

        $status = Zadanie::pobierz('status');

        $this->wyswietlMenuKontekstowe();

        $kryteria = array();
        $form = new ZamowieniaBm\Wyszukiwarka();
        $form->ustawObiekt(new Zamowienia\Obiekt())->ustawTlumaczenia($this->pobierzBlokTlumaczen('wyszukiwarka'));
        $kryteriaSzukaj = [];

        if ($form->wypelniony() && $form->danePoprawne())
            $kryteriaSzukaj = $form->pobierzWartosci();

        if ($cms->profil()->maRole(array('manager', 'admin')))
        {

        }
        else if($cms->profil()->maRole(array('pracownia')))
        {
            $kryteria['wykonawca'] = $cms->profil()->id;
        }
        else
        {
            $kryteria['autor'] = $cms->profil()->id;
        }

        if($status == 'archiwum')
        {
            $kryteria['status'] = 'archiwum';
        }
        else {
                $kryteria['nie_status'] = 'archiwum';
        }


        $kryteria = array_merge($kryteria, $kryteriaSzukaj);
        $mapperKategoria = $cms->dane()->Kategoria();
        $idKategorii = $mapperKategoria->pobierzPoKodModulu('Notes');
        $this->tresc .= $this->szablon->parsujBlok('index',
            array(
                'grid' => $this->grid($kryteria, $form, $status)->html(),
                'aktualizujNotatke' => Router::urlAjax('Admin', $idKategorii, 'PobierzDlaObiektu', array('object' => 'Zamowienie')),
                'urlZmienStatus' => Router::urlAjax('Admin', $this->kategoria, 'zmienStatus'),
            ));

    }

    public function wykonajPodglad()
    {
        $id = Zadanie::pobierz('id', 'intval');
        $zamowienie = $this->dane()->ZamowieniaBm()->pobierzPoId($id);
        $dane = [];
        if ($zamowienie instanceof Zamowienia\Obiekt) {

            $dane['zloto'] = $zamowienie->zloto;
            $dane['srebro'] = $zamowienie->srebro;
            $dane['platyna'] = $zamowienie->platyna;
            $dane['cena'] = $zamowienie->cena;
            $dane['rabat'] = $zamowienie->rabat;
            $dane['zaliczka'] = $zamowienie->zaliczka;
            $dane['zamowienieNo'] = $zamowienie->id;
            $dane['dataEtykieta'] = $zamowienie->dataDodania->format('Y-m-d H:i');
            $dane['opis'] = $zamowienie->opis;
            $dane['kamienKlienta'] = $zamowienie->kamienKlienta;
            $dane['tytul'] = $zamowienie->tytul;
            $dane['rodzajOprawy'] = $zamowienie->rodzajOprawy;
            $dane['opis'] = $zamowienie->opis;
            $dane['rozmiar'] = $zamowienie->rozmiar;
            $dane['wysokosc'] = $zamowienie->wysokosc;
            $dane['termin'] = $zamowienie->termin;
            $dane['grawer'] = $zamowienie->grawer;
            $dane['materialKlienta'] = $zamowienie->materialyKlienta;

            if(count($zamowienie->kamienie))
                foreach ($zamowienie->kamienie as $kamien)
                    $this->szablon->ustawBlok('podglad/kamien', ['nazwa' => $kamien['nazwa'], 'ilosc' => $kamien['ilosc']]);

            if(count($zamowienie->daneZlota) && is_array($zamowienie->daneZlota))
                foreach( $zamowienie->daneZlota as $zlotoInfo)
                    $this->szablon->ustawBlok('podglad/zlotoInfo', ['nazwa' => $zlotoInfo]);

            $klient = $zamowienie->pobierzKlienta();
            if ($klient instanceof Klient\Obiekt) {
                $dane['klient'] = $klient->name . ' ' . $klient->surname;
                $dane['klient_ulica'] = $klient->address;
                $dane['klient_miasto'] = $klient->postcode . ' ' . $klient->city;
                $dane['klient_telefon'] = $klient->phoneMobile;
                $dane['klient_email'] = $klient->email;
                $dane['etykietaNaglowek'] = str_replace(['{KLIENT}', '{ID}'], [$klient->name . ' ' . $klient->surname, $zamowienie->id], $this->j->t['podglad.etykieta_naglowke']);
            }

            $autor = $zamowienie->pobierzAutora();
            if ($autor instanceof Uzytkownik\Obiekt)
                $dane['dane_przyjmujacego'] = $autor->imie . ' ' . $autor->nazwisko;

            $wykonawca = $zamowienie->pobierzWykonawce();
            if ($wykonawca instanceof Uzytkownik\Obiekt)
                $dane['wykonawca'] = $wykonawca->imie . ' ' . $wykonawca->nazwisko;

            $produkt = $zamowienie->pobierzModel();
            if ($produkt instanceof ProduktyMagazyn\Obiekt)
                $dane['wybrany_model'] = $produkt->nazwaProduktu;
            else
                $dane['wybrany_model'] = $zamowienie->modelTekst;

            foreach ($zamowienie->pobierzNotatki() as $notatka) {
                $this->szablon->ustawBlok('podglad/notatki',
                    [
                        'notatka' => $notatka->description,
                        'data' => date('Y-m-d H:i', strtotime($notatka->dataAdded)),
                        'autor' => $notatka->author,
                    ]
                );
            }
        } else {
            $this->komunikat($this->j->t['podglad.brak_zamowienia'], 'error');
        }
        $dane['linkDrukuj'] = Router::urlAjax('admin', $this->kategoria, 'drukujPdf', array('id' => $zamowienie->id));
        $dane['etykietaDrukuj'] = $this->j->t['podglad.etykieta_drukuj'];
        $dane['zamowienieNoEtykieta'] = $this->j->t['podglad.zamowienieNoEtykieta'];
        $dane['dane_etykieta'] = $this->j->t['podglad.dane_etykieta'];
        $dane['dane_klienta_etykieta'] = $this->j->t['podglad.dane_klienta_etykieta'];
        $dane['dane_przyjmujacego_etykieta'] = $this->j->t['podglad.dane_przyjmujacego_etykieta'];
        $dane['szczeguly_zamowienia_etykieta'] = $this->j->t['podglad.szczeguly_zamowienia_etykieta'];
        $dane['model_etykieta'] = $this->j->t['podglad.model_etykieta'];
        $dane['kamienie_etykieta'] = $this->j->t['podglad.kamienie_etykieta'];
        $dane['zloto_etykieta'] = $this->j->t['podglad.zloto_etykieta'];
        $dane['srebro_etykieta'] = $this->j->t['podglad.srebro_etykieta'];
        $dane['platyna_etykieta'] = $this->j->t['podglad.platyna_etykieta'];
        $dane['cena_etykieta'] = $this->j->t['podglad.cena_etykieta'];
        $dane['rabat_etykieta'] = $this->j->t['podglad.rabat_etykieta'];
        $dane['dane_wykonawcy_etykieta'] = $this->j->t['podglad.dane_wykonawcy_etykieta'];
        $dane['dane_wykonawcy'] = $this->j->t['podglad.dane_wykonawcy_etykieta'];
        $dane['opis_etykieta'] = $this->j->t['podglad.opis_etykieta'];
        $dane['etykieta_notatka'] = $this->j->t['podglad.etykieta_notatka'];
        $dane['etykieta_rodzajOprawy'] =  $this->j->t['podglad.etykieta_rodzajOprawy'];
        $dane['zloto_info_etykieta'] = $this->j->t['podglad.zloto_info_etykieta'];
        $dane['etykieta_kamienKlienta'] = $this->j->t['podglad.etykieta_kamienKlienta'];
        $dane['tel_etykieta'] = $this->j->t['podglad.tel_etykieta'];
        $dane['mail_etykieta'] = $this->j->t['podglad.mail_etykieta'];

        $dane['rozmiar_etykieta'] = $this->j->t['podglad.rozmiar_etykieta'];
        $dane['wysokosc_etykieta'] = $this->j->t['podglad.wysokosc_etykieta'];
        $dane['termin_etykieta'] = $this->j->t['podglad.termin'];


        $return['html'] = $this->szablon->parsujBlok('podglad', $dane);
        $return['status'] = 1;
        echo json_encode($return);
        die;
    }

    public function wykonajZmienStatus()
    {
        $idZamowienia = Zadanie::pobierz('id');
        $status = Zadanie::pobierz('status');
        $id = str_replace('wiersz_', '', $idZamowienia);
        $zamowienieMapper = $this->dane()->ZamowieniaBm();

        $dane['blad'] = 1;
        $dane['smsWyslany'] = 0;
        if (($zamowienie = $zamowienieMapper->pobierzPoId($id)) instanceof Zamowienia\Obiekt) {
            $zamowienie->status = $status;
            if($zamowienie->zapisz($zamowienieMapper)){

                $this->zmianaStatusu($zamowienie);

                $dane['blad'] = 0;
                $dane['idZamowienia'] = $zamowienie->id;
                $dane['select'] = $this->przyciskZmienStatus($id);
            }
        }

        echo json_encode($dane);
        die;
    }

    private function zmianaStatusu(Zamowienia\Obiekt $zamowienie)
    {
        if(isset($this->j->t['sms_powiadomienia_klienta'][$zamowienie->status]))
        {
            if( ($klient = $zamowienie->pobierzKlienta()) instanceof Klient\Obiekt)
            {
                $smsapi = new SmsBm\SmsApiPl();
                $smsapi->odbiorca = $klient;
                $smsapi->wiadomosc = str_replace(array('{ID}', '{KLIENT}'), array($zamowienie->id, $klient->name), $this->j->t['sms_powiadomienia_klienta'][$zamowienie->status]);
                if($smsapi->wyslijSms()){ $dane['smsWyslany'] = 1; }
            }
        }

        if($zamowienie->status == 'do akceptacji')
            $this->wyslijEmailZamowienie($zamowienie, $this->dane()->Uzytkownik()->pobierzPoId(2), $this->k->k['email_zamowienie_do_akceptacji.id_formatki']);
        if($zamowienie->status == 'do poprawy' && $zamowienie->pobierzWykonawce() instanceof Uzytkownik\Obiekt)
            $this->wyslijEmailZamowienie($zamowienie, $zamowienie->pobierzWykonawce(), $this->k->k['email_zamowienie_do_poprawy.id_formatki']);
        if($zamowienie->status == 'przyjete')
            $this->wyslijEmailZamowienie($zamowienie, $zamowienie->pobierzWykonawce(), $this->k->k['email_zamowienie_przypisane.id_formatki']);
        if($zamowienie->status == 'oprawa')
            $this->wyslijEmailZamowienie($zamowienie, $zamowienie->pobierzWykonawce(), $this->k->k['email_zamowienie_przypisane.id_formatki']);
        if($zamowienie->status == 'nowe')
            $this->wyslijEmailZamowienie($zamowienie, $this->dane()->Uzytkownik()->pobierzPoId(2), $this->k->k['email_nowe_zamowienie.id_formatki'] );
    }

    private function grid($kryteria, $form, $status)
    {

        $grid = new TabelaDanych();
        $grid->dodajKolumne('id', $this->j->t['index.id'], null, Router::urlAdmin($this->kategoria, 'podglad', array('{KLUCZ}' => '{WARTOSC}')), true);
        $grid->dodajKolumne('idZam', $this->j->t['index.id'], null, Router::urlAdmin($this->kategoria, 'podglad', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('rodzaj', $this->j->t['index.rodzaj'], null, Router::urlAdmin($this->kategoria, 'podglad', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('tytul', $this->j->t['index.tytul'], null, Router::urlAdmin($this->kategoria, 'podglad', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('data_dodania', $this->j->t['index.data_dodania']);
        $grid->dodajKolumne('termin', $this->j->t['index.termin']);
        $grid->dodajKolumne('id_klienta', $this->j->t['index.id_klienta'], '', Router::urlAdmin($this->kategoria, 'podglad', array('{KLUCZ}' => '{WARTOSC}')));
        $grid->dodajKolumne('id_model', $this->j->t['index.id_model']);
        $grid->dodajKolumne('autor', $this->j->t['index.autor']);
        $grid->dodajKolumne('wykonawca', $this->j->t['index.wykonawca']);
        $grid->dodajKolumne('status', $this->j->t['index.status']);
        $szablon = $this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']);
        $grid->naglowek($form->zwrocFormularz()->html($szablon, true, false));

        $kategorieMapper = $this->dane()->Kategoria();
        $kategoriaNotes = $kategorieMapper->pobierzDlaModulu('Notes');

        $przyciski = array(
            array(
                'akcja' => Router::urlAjax('admin', $this->kategoria, 'podglad', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-search',
                'etykieta' => $this->j->t['index.podglad'],
                'target' => '_self',
                'klucz' => 'podglad',
                'onclick' => 'modalAjax(this.href); return false;',
            ),
            array(
                'akcja' => Router::urlAjax('admin', $this->kategoria, 'usun', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-remove',
                'etykieta' => $this->j->t['index.usun'],
                'target' => '_self',
                'klucz' => 'usun',
                'onclick' => 'usunZamowienie(this); return false;',
            ),
            array(
                'akcja' => Router::urlAdmin($this->kategoria, 'dodaj', array('{KLUCZ}' => '{WARTOSC}')),
                'ikona' => 'icon-pencil',
                'etykieta' => $this->j->t['index.edytujZamowienieEtykieta'],
                'target' => '_self',
                'klucz' => 'edytuj',
            ),
            array(
                'akcja' => Router::urlAjax('Admin', $kategoriaNotes[0], 'addNote', array('{KLUCZ}' => '{WARTOSC}', 'object' => 'ZamowieniaBm')),
                'ikona' => 'icon-comments',
                'etykieta' => $this->j->t['index.dodajNotatke'],
                'target' => '_self',
                'klucz' => 'notatka',
                'onclick' => 'return otworzOkno(this.href);'
            ),
            $przyciski[] = array(
                'akcja' => Router::urlAjax('admin', $this->kategoria, 'podgladZalacznikiWszystkie', array('{KLUCZ}' => '{WARTOSC}')), // link bedzie podmieniany w metodzie grid
                'ikona' => 'icon-paper-clip',
                'etykieta' => $this->j->t['index.tabela_etykieta_zalaczniki_wszystkie'],
                'target' => '_self',
                'klucz' => 'podgladZalacznikiWszystkie',
                'onclick' => 'modalAjax(this); return false;',
            )
        );

        $mapper = $this->dane()->ZamowieniaBm();
        $iloscWierszy = $mapper->iloscSzukaj($kryteria);
        $grid->dodajPrzyciski(
            Router::urlAdmin($this->kategoria, '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')), $przyciski
        );

        if ($iloscWierszy) {
            $naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval', 'abs'));
            $nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval', 'abs'));
            $kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
            $kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

            $akcja = $this->pobierzParametr('a', 'index');
            $sorter = new Zamowienia\Sorter($kolumna, $kierunek);
            $grid->ustawSortownie(
                array('id', 'data_dodania', 'status', 'termin', 'rodzaj'),
                $kolumna, $kierunek,
                Router::urlAdmin($this->kategoria, $akcja, array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}', 'status' => $status))
            );

            $pager = new Pager\Html($iloscWierszy, $naStronie, $nrStrony);
            $pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
            $grid->pager($pager->html(Router::urlAdmin($this->kategoria, $akcja, array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}', 'status' => $status))));

            $pobraneWiersze = $mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter);
            $idZamowien = array_keys(listaZTablicy($pobraneWiersze, 'id'));
            $mapperZalacznikow = new Zalacznik\Mapper();
            $zalacznikiIlosc = listaZTablicy($mapperZalacznikow->zwracaTablice()->liczIloscZalacznikowDlaObiektow(array(
                'wiele_id_object' => $idZamowien,
                'object' => 'ZamowieniaBm',
                'status' => 'active',
            )), 'id_object', 'ilosc');
            $kategorieMapper = $this->dane()->Kategoria();
            $kategoriaZalaczniki = $kategorieMapper->pobierzPoKodModulu('Attachments');

            foreach ($pobraneWiersze as $wiersz) {
                if (isset($zalacznikiIlosc[$wiersz['id']]))
                    $grid->zmienAkcjePrzycisk('podgladZalacznikiWszystkie', Router::urlAdmin($kategoriaZalaczniki, 'previewAttachments', array('idObiektu' => $wiersz['id'], 'typObiektu' => 'ZamowieniaBm', 'listaWymus' => 1)));
                else
                    $grid->usunPrzyciski(array('podgladZalacznikiWszystkie'));

                if ($wiersz['id'])
                    $wiersz['idZam'] = $wiersz['id'];
                if ($wiersz['autor'])
                    $wiersz['autor'] = $this->dane()->Uzytkownik()->pobierzPoId($wiersz['autor']);
                if ($wiersz['id_klienta'])
                    $wiersz['id_klienta'] = $this->dane()->Klient()->pobierzPoId($wiersz['id_klienta']);


                    if($wiersz['id_model'] > 0) $wiersz['id_model'] = $this->dane()->ProduktyMagazyn()->pobierzPoId($wiersz['id_model']);
                    else $wiersz['id_model'] = $wiersz['model_tekst'];


                if ($wiersz['wykonawca'])
                    $wiersz['wykonawca'] = $this->dane()->Uzytkownik()->pobierzPoId($wiersz['wykonawca']);
                if ($wiersz['status'])
                    $wiersz['status'] = $this->przyciskZmienStatus($wiersz['id']);

                $grid->dodajWiersz($wiersz);
            }
        }
        return $grid;
    }

    private function przyciskZmienStatus($id)
    {
        $zamowienie = $this->dane()->ZamowieniaBm()->pobierzPoId($id);
        $statusy = $zamowienie->pobierzDozwoloneWartosciPola('status');

        $lista = [];
        foreach($statusy as $status)
            $lista[$status] = $status;

        $przycisk = new Select('zmienStatus_' . $id, ['lista' => $lista, 'atrybuty' => array('class' => 'zmienStatus')]);
        $przycisk->ustawWartosc($zamowienie->status);
        return $przycisk->pobierzHtml();
    }

    public function wykonajDodaj()
    {
        $this->wyswietlMenuKontekstowe();

        $id = Zadanie::pobierz('id', 'intval');
        $noweZamowienie = 0;
        $mapperZamowienie = $this->dane()->ZamowieniaBm();
        if ($id > 0)
        {
            $zamowienie = $mapperZamowienie->pobierzPoId($id);
        }
        else
        {
            $noweZamowienie = 1;
            $zamowienie = new Zamowienia\Obiekt();
        }
        $zamowienieTmp = $zamowienie;


        $formularz = new ZamowieniaBm\EdycjaZamowien();
        $formularz->ustawObiekt($zamowienie);
        $formularz->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzZamowienie'));
        $formularz->ustawKonfiguracje(array_merge($this->pobierzKonfiguracje(), array('kategoriaZamowienie' => $this->kategoria)));
        $formularz->ustawUrlPowrotny(Router::urlAdmin($this->kategoria, 'index'));

        if ($formularz->wypelniony()) {
            if ($formularz->danePoprawne()) {
                $pliki = [];
                $wartosci = $formularz->pobierzWartosci();

                foreach ($wartosci as $klucz => $wartosc) {

                    if ($klucz == 'pliki') {
                        if ((!empty($wartosc['pliki']) || count($wartosc['pliki']) > 0) && (!empty($wartosc['token']) || $wartosc['token'] != '')) {
                            foreach ($wartosc['pliki'] as $plik) {
                                $pliki[] = $plik;
                            }
                        }
                        continue;
                    }

                    if ($noweZamowienie) $zamowienie->status = 'nowe';
                    if ($klucz == 'wykonawca') ($wartosc > 0) ? '' : $zamowienie->status = 'przyjete';

                    $zamowienie->$klucz = $wartosc;
                }
                ($zamowienie->autor) ? '' : $zamowienie->autor = Cms::inst()->profil()->id;
                $zamowienie->dataDodania = new \DateTime();

                if ($zamowienie->zapisz($mapperZamowienie)) {

                    if($zamowienie->status != $zamowienieTmp->status){  $this->zmianaStatusu($zamowienie); }

                    if (count($pliki)) {
                        $katalogDocelowy = new Katalog(Cms::inst()->katalog('zamowieniabm', $zamowienie->id), true);
                        multiuploadPrzeniesPliki($wartosci['pliki']['pliki'], $wartosci['pliki']['token'], $wartosci['pliki']['pliki'], $katalogDocelowy, 1);
                        foreach ($pliki as $plik) $this->zapiszZalacznik($plik['nazwa'], $zamowienie->id, 'ZamowieniaBm');
                    }


                    $this->komunikat($this->j->t['formularz.dane_zapisane']);
                } else
                    $this->komunikat($this->j->t['formularz.blad_zapisu'], 'error');
            } else {
                $this->komunikat($this->j->t['formularz.blad'], 'error');
            }
        }

        $this->tresc .= $this->szablon->parsujBlok('dodaj', ['formularz' => $formularz->zwrocFormularz()->html()]);
    }

    public function wykonajDodajPlik()
    {
        $token = Zadanie::pobierz('token', 'trim');
        $id = Zadanie::pobierz('id', 'trim', 'intval');

        $upload = new Plik\MultiUpload($token);
        $plik = $upload->zapiszPlik($id, 'zdjecia');

        $return = $upload->pobierzWynikUploadu();

        if (!$wynikSkanowania = $plik->skanuj(true) && $return['success'] == true)
            $return['success'] = false;

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

    private function zapiszZalacznik($plik, $idObjektu, $objekt, $komunikaty = true)
    {
        $plik = Plik::unifikujNazwe($plik);
        $cms = Cms::inst();
        $mapperZalacznik = $this->dane()->Zalacznik();
        $zalacznik = $mapperZalacznik->pobierzDlaObjektu($objekt, $idObjektu);

        $katalogDocelowy = new Katalog($cms->katalog(strtolower($objekt)), true);
        $zalacznikPlik = $katalogDocelowy->__toString() . '/' . $idObjektu . '/' . $plik;

        if (is_file($zalacznikPlik)) {
            if (!($zalacznik instanceof Zalacznik\Obiekt)) {
                $zalacznik = new Zalacznik\Obiekt();
                $zalacznik->idProjektu = ID_PROJEKTU;
                $zalacznik->idObject = $idObjektu;
                $zalacznik->object = $objekt;
                $zalacznik->idAuthor = Cms::inst()->profil()->id;
            }

            $zalacznik->file = $plik;

            if ($zalacznik->zapisz($mapperZalacznik)) {
                $this->komunikat($this->j->t['import.zapisz_zalacznik_ok'], 'info');
            } else {
                $this->komunikat($this->j->t['import.zapisz_zalacznik_error'], 'error');
                $error['object'] = 1;
            }
        } else {
            $this->komunikat($this->j->t['import.zapisz_zalacznik_brak_zalacznika'], 'error');
            $error['plik'] = 1;
        }
        return (empty($error)) ? true : false;
    }

    public function wykonajUsun()
    {
        $id = Zadanie::pobierz('id', 'intval');
        $mapper = $this->dane()->ZamowieniaBm();
        $zamowienie = $mapper->pobierzPoId($id);
        if ($zamowienie instanceof Zamowienia\Obiekt) {
            ($zamowienie->usun($mapper)) ?
                $this->komunikat($this->j->t['usun.usuniete'], 'info', 'sesja') :
                $this->komunikat($this->j->t['usun.blad_usuwania'], 'error', 'sesja');
        } else {
            $this->komunikat($this->j->t['usun.brak_zamowienia'], 'error', 'sesja');
        }
        Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
    }

    private function wyslijEmailZamowienie(Zamowienia\Obiekt $zamowienie, Uzytkownik\Obiekt $uzytkownik, int $idFormatki)
    {

        $dane = array(
            'obiekt_Zamowienie' => $zamowienie,
            'obiekt_Uzytkownik' => $uzytkownik,
        );

        $poczta = new Pomocnik\Poczta($idFormatki, $dane);
        $status = $poczta->wyslij();

        return $status;
    }

}