<?php

namespace Generic\Model\ZamowieniaBm;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;
use Generic\Model\Klient;

/**
 * Maper tabeli w bazie: modul_zamowienia_bm
 */
class Mapper extends Biblioteka\Mapper\Baza
{


    /**
     * Zwracany obiekt przez mapper
     * @var string
     */
    protected $zwracanyObiekt = 'Generic\Model\ZamowieniaBm\Obiekt';


    /**
     * Nazwa tabeli w bazie danych.
     * @var string
     */
    protected $tabela = 'modul_zamowienia_bm';


    /**
     * Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
     * @var array
     */
    protected $polaTabeliObiekt = array(
        'id' => 'id',
        'id_projektu' => 'idProjektu',
        'id_klienta' => 'idKlienta',
        'model' => 'model',
        'id_model' => 'idModel',
        'zloto' => 'zloto',
        'platyna' => 'platyna',
        'srebro' => 'srebro',
        'kamienie' => 'kamienie',
        'cena' => 'cena',
        'grawer' => 'grawer',
        'rabat' => 'rabat',
        'opis' => 'opis',
        'status' => 'status',
        'autor' => 'autor',
        'wykonawca' => 'wykonawca',
        'data_dodania' => 'dataDodania',
        'tytul' => 'tytul',
        'indywidualne' => 'indywidualne',
        'model_tekst' => 'modelTekst',
        'dane_zlota' => 'daneZlota',
        'rodzaj_oprawy' => 'rodzajOprawy',
        'kamien_klienta' => 'kamienKlienta',
        'rozmiar' => 'rozmiar',
        'zaliczka' => 'zaliczka',
        'wysokosc' => 'wysokosc',
        'termin' => 'termin',
        'rodzaj' => 'rodzaj',
        'materialy_klienta' => 'materialyKlienta'
    );


    /**
     * Pola tabeli bazy danych tworzące klucz główny.
     * @var array
     */
    protected $polaTabeliKlucz = array(
        'id',
        'id_projektu',
    );


    /**
     * Zwraca ilość w tabeli modul_zamowienia_bm.
     * @return int
     */
    public function iloscWszystko()
    {
        $sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
            . ' WHERE id_projektu = ' . ID_PROJEKTU;

        return $this->pobierzWartosc($sql);
    }


    /**
     * Zwraca dla podanego id w tabeli modul_zamowienia_bm.
     * @return \Generic\Model\Generic\Model\ZamowieniaBm\Obiekt\Obiekt
     */
    public function pobierzPoId($id)
    {
        $sql = 'SELECT * FROM ' . $this->tabela
            . ' WHERE id = ' . intval($id)
            . ' AND id_projektu = ' . ID_PROJEKTU;

        return $this->pobierzJeden($sql);
    }

    public function pobierzPoWieleId(array $ids)
    {
        $sql = 'SELECT * FROM ' . $this->tabela
            . ' WHERE id IN (' . implode(',' , $ids).')'
            . ' AND id_projektu = ' . ID_PROJEKTU;

        return $this->pobierzWiele($sql, null, null);
    }


    /**
     * Zwraca wszystko z tabeli modul_zamowienia_bm.
     * @return Array
     */
    public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
    {
        $sql = 'SELECT * FROM ' . $this->tabela
            . ' WHERE id_projektu = ' . ID_PROJEKTU;

        return $this->pobierzWiele($sql, $pager, $sorter);
    }


    /**
     * Wyszukuje w tabeli modul_zamowienia_bm dla podanych kryteriów.
     * @return Array
     */
    public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
    {
        $sql = 'SELECT * '
            . ' FROM ' . $this->tabela
            . ' WHERE id_projektu = ' . ID_PROJEKTU;

        if (isset($kryteria['status']) && $kryteria['status'] != '') {
            $fraza = addslashes($kryteria['status']);
            $sql .= ' AND status = \'' . $fraza . '\' ';
        }
        if (isset($kryteria['rodzaj']) && $kryteria['rodzaj'] != '') {
            $fraza = addslashes($kryteria['rodzaj']);
            $sql .= ' AND rodzaj = \'' . $fraza . '\' ';
        }
        if(isset($kryteria['nie_status']) && $kryteria['nie_status'] != '')
        {
            $fraza = addslashes($kryteria['nie_status']);
            $sql .= ' AND status <> \'' . $fraza . '\' ';
        }
        if (isset($kryteria['autor']) && $kryteria['autor'] != '') {
            $fraza = intval($kryteria['autor']);
            $sql .= ' AND autor  = ' . $fraza;
        }
        if (isset($kryteria['wykonawca']) && $kryteria['wykonawca'] != '') {
            $fraza = intval($kryteria['wykonawca']);
            $sql .= ' AND wykonawca  = ' . $fraza;
        }
        if (isset($kryteria['fraza']) && $kryteria['fraza'] != '') {
            $fraza = addslashes($kryteria['fraza']);
            $sql .= ' AND opis ILIKE \'%' . $fraza . '%\'';
            $sql .= ' OR tytul ILIKE \'%' . $fraza . '%\'';
            $klientMapper = new Klient\Mapper();
            $listaKlientow = $klientMapper->zwracaTablice(array('id'))->szukaj(array('fraza' => $fraza, 'status' => 'active'));
            if (count($listaKlientow)) {
                $sql .= ' OR id_klienta IN (' . implode(',', array_keys(listaZTablicy($listaKlientow, 'id'))) . ')';
            }
            $sql .= ' OR id = '.intval($kryteria['fraza']);
        }

        return $this->pobierzWiele($sql, $pager, $sorter);
    }


    /**
     * Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_zamowienia_bm.
     * @return int
     */
    public function iloscSzukaj(Array $kryteria)
    {
        $sql = 'SELECT COUNT(*) '
            . ' FROM ' . $this->tabela
            . ' WHERE id_projektu = ' . ID_PROJEKTU;

        if (isset($kryteria['status']) && $kryteria['status'] != '') {
            $fraza = addslashes($kryteria['status']);
            $sql .= ' AND status = \'' . $fraza . '\' ';
        }
        if (isset($kryteria['rodzaj']) && $kryteria['rodzaj'] != '') {
            $fraza = addslashes($kryteria['rodzaj']);
            $sql .= ' AND rodzaj = \'' . $fraza . '\' ';
        }
        if(isset($kryteria['nie_status']) && $kryteria['nie_status'] != '')
        {
            $fraza = addslashes($kryteria['nie_status']);
            $sql .= ' AND status <> \'' . $fraza . '\' ';
        }
        if (isset($kryteria['autor']) && $kryteria['autor'] != '') {
            $fraza = intval($kryteria['autor']);
            $sql .= ' AND autor  = ' . $fraza;
        }
        if (isset($kryteria['wykonawca']) && $kryteria['wykonawca'] != '') {
            $fraza = intval($kryteria['wykonawca']);
            $sql .= ' AND wykonawca  = ' . $fraza;
        }
        if (isset($kryteria['fraza']) && $kryteria['fraza'] != '') {
            $fraza = addslashes($kryteria['fraza']);
            $sql .= ' AND opis ILIKE \'%' . $fraza . '%\'';
            $sql .= ' OR tytul ILIKE \'%' . $fraza . '%\'';
            $klientMapper = new Klient\Mapper();
            $listaKlientow = $klientMapper->zwracaTablice(array('id'))->szukaj(array('fraza' => $fraza, 'status' => 'active'));
            if (count($listaKlientow)) {
                $sql .= ' OR id_klienta IN (' . implode(',', array_keys(listaZTablicy($listaKlientow, 'id'))) . ')';
            }
            $sql .= ' OR id = '.intval($kryteria['fraza']);
        }

        return $this->pobierzWartosc($sql);
    }


    /**
     * Wykonuje wyszukiwanie według podanych kryteriów.
     * @return Array
     */
    protected function zapytanieWyszukiwanie($kryteria)
    {
        $zapytanie = $this->przygotujZapytanieWyszukujace();

        $warunki = $this->piszKryteria($kryteria);

        $zapytanie['kryteria'] = array_merge($zapytanie['kryteria'], $warunki);

        return $zapytanie;
    }


}