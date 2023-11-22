<?php
namespace Generic\Model\GaleriaZdjecie;


use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

class Mapper extends Biblioteka\Mapper\Baza
{

    // nazwa klasy tworzonego obiektu
    protected $zwracanyObiekt = 'Generic\Model\GaleriaZdjecie\Obiekt';


    // przetrzymuje nazwe tabeli w bazie do ktorej beda zapisywane dane
    protected $tabela = 'modul_galeria_zdjecia';


    // przetrzymuje tablice tlumaczaca kolumny tabeli na nazwy pol obiektu
    protected $polaTabeliObiekt = array(
        'id' => 'id',
        'id_projektu' => 'idProjektu',
        'kod_jezyka' => 'kodJezyka',
        'id_galerii' => 'idGalerii',
        'nazwa_pliku' => 'nazwaPliku',
        'tytul' => 'tytul',
        'opis' => 'opis',
        'data_dodania' => 'dataDodania',
        'autor' => 'autor',
        'publikuj' => 'publikuj',
        'pozycja' => 'pozycja',
    );


    // pola tabeli tworzace klucz glowny
    protected $polaTabeliKlucz = array('id', 'id_projektu', 'kod_jezyka');


    public function pobierzPoId($id)
    {
        $sql = 'SELECT * FROM ' . $this->tabela
            . ' WHERE id = ' . intval($id)
            . ' AND id_projektu = ' . ID_PROJEKTU
            . ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

        return $this->pobierzJeden($sql);
    }


    public function pobierzDlaGalerii($idGalerii, Pager $pager = null, Sorter $sorter = null)
    {
        $sql = 'SELECT * FROM ' . $this->tabela
            . ' WHERE id_galerii = ' . intval($idGalerii)
            . ' AND id_projektu = ' . ID_PROJEKTU
            . ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

        return $this->pobierzWiele($sql, $pager, $sorter);
    }


    public function iloscDlaGalerii($idGalerii)
    {
        $sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
            . ' WHERE id_galerii = ' . intval($idGalerii);

        return $this->pobierzWartosc($sql);
    }


    public function pobierzOpublikowane($idGalerii, Pager $pager = null, Sorter $sorter = null)
    {
        $sql = 'SELECT * FROM ' . $this->tabela
            . ' WHERE id_galerii = ' . intval($idGalerii)
            . ' AND id_projektu = ' . ID_PROJEKTU
            . ' AND kod_jezyka = \'' . KOD_JEZYKA . '\''
            . ' AND publikuj = true';

        return $this->pobierzWiele($sql, $pager, $sorter);
    }


    public function iloscOpublikowane($idGalerii)
    {
        $sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
            . ' WHERE id_galerii = ' . intval($idGalerii)
            . ' AND id_projektu = ' . ID_PROJEKTU
            . ' AND kod_jezyka = \'' . KOD_JEZYKA . '\''
            . ' AND publikuj = true';

        return $this->pobierzWartosc($sql);
    }


    public function szukaj($kryteria, Pager $pager = null, Sorter $sorter = null)
    {
        $sql = 'SELECT * FROM ' . $this->tabela
            . ' WHERE id_projektu = ' . ID_PROJEKTU
            . ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

        if (isset($kryteria['publikuj'])) {
            $sql .= ' AND publikuj = ' . (bool)$kryteria['publikuj'];
        }
        if (isset($kryteria['galeria'])) {
            $sql .= ' AND id_galerii = ' . intval($kryteria['galeria']);
        }
        if(isset($kryteria['id']) && count($kryteria['id']) > 0)
        {
            $sql .= ' AND id IN ('.implode($kryteria['id']).')';
        }
        if (isset($kryteria['fraza']) && $kryteria['fraza'] != '') {
            $fraza = addslashes($kryteria['fraza']);
            $sql .= ' AND (
					tytul LIKE \'%' . $fraza . '%\''
                . ' OR opis LIKE \'%' . $fraza . '%\''
                . ' OR autor LIKE \'%' . $fraza . '%\''
                . ')';
        }
        if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '') {
            $sql .= ' AND data_dodania > DATE_SUB(\'' . date('Y-m-d') . '\', INTERVAL ' . intval($kryteria['data_dodania']) . ' DAY)';
        }

        return $this->pobierzWiele($sql, $pager, $sorter);
    }


    public function iloscSzukaj($kryteria)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->tabela
            . ' WHERE id_projektu = ' . ID_PROJEKTU
            . ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

        if (isset($kryteria['publikuj'])) {
            $sql .= ' AND publikuj = ' . (bool)$kryteria['publikuj'];
        }
        if (isset($kryteria['galeria'])) {
            $sql .= ' AND id_galerii = ' . intval($kryteria['galeria']);
        }
        if(isset($kryteria['id']) && count($kryteria['id']) > 0)
        {
            $sql .= ' AND id IN ('.implode($kryteria['id']).')';
        }
        if (isset($kryteria['fraza']) && $kryteria['fraza'] != '') {
            $fraza = addslashes($kryteria['fraza']);
            $sql .= ' AND (
					tytul LIKE \'%' . $fraza . '%\''
                . ' OR opis LIKE \'%' . $fraza . '%\''
                . ' OR autor LIKE \'%' . $fraza . '%\''
                . ')';
        }
        if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '') {
            $sql .= ' AND data_dodania > DATE_SUB(\'' . date('Y-m-d') . '\', INTERVAL ' . intval($kryteria['data_dodania']) . ' DAY)';
        }

        return $this->pobierzWartosc($sql);
    }
}