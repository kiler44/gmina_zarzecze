<?php
namespace Generic\Biblioteka\Wyszukiwarka\Tabela;

use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Sorter;
use Generic\Model\Aktualnosc as mAktualnosc;
use Generic\Biblioteka\Wyszukiwarka\Wynik;
use Generic\Model\Kategoria;

class Aktualnosc implements TabelaInterface
{
    protected $kryteria;
    protected $mapper;
    protected $sorter;
    protected $pager;

    public function __construct(Sorter $sorter = null)
    {
        $this->sorter = $sorter;
        $this->mapper = new mAktualnosc\Mapper();
    }

    public function ustawPager( Pager $pager)
    {
        $this->pager = $pager;
    }

    public function pobierzWyniki():array
    {
        $aktualnosci = $this->mapper->szukaj($this->kryteria);
        $kategoriaMapper = new Kategoria\Mapper();
        $wyniki = [];
        $kategorieAktualnosci = [];
        /**
         * @var Strona\Obiekt $strona
         */
        foreach ($aktualnosci as $aktualnosc) {

            $kategoria = isset($kategorieAktualnosci[$aktualnosc->id]) ? $kategorieAktualnosci[$aktualnosc->id] : $kategoriaMapper->pobierzPoId($aktualnosc->idKategorii)->nazwa;

            $oWynik = new Wynik();
            $oWynik->tytul = $aktualnosc->tytul;
            $oWynik->tresc = $aktualnosc->zajawka;
            $oWynik->kategoria = $kategoria;
            $oWynik->data = $aktualnosc->dataDodania;
            $oWynik->link = Router::urlHttp($aktualnosc->idKategorii, ['aktualnosc' => $aktualnosc->id]);
            $wynik[] = $oWynik;
        }
        return $wyniki;
    }

    public function pobierzIlosc():int
    {
        return $this->mapper->iloscSzukaj($this->kryteria);
    }

    public function ustawKryteria(array $kryteria)
    {
        $this->kryteria = $kryteria;
    }
}