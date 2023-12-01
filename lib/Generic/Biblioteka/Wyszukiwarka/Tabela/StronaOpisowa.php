<?php
namespace Generic\Biblioteka\Wyszukiwarka\Tabela;

use Generic\Biblioteka\Router;
use Generic\Model\StronaOpisowa as Strona;
use Generic\Biblioteka\Wyszukiwarka\Wynik;

class StronaOpisowa implements TabelaInterface
{
    protected $kryteria;
    protected $mapper;

    public function __construct()
    {
        $this->mapper = new Strona\Mapper();
    }

    public function pobierzWyniki():array
    {
        $strony = $this->mapper->szukaj($this->kryteria);
        $wyniki = [];
        /**
         * @var Strona\Obiekt $strona
         */
        foreach ($strony as $strona) {
            $oWynik = new Wynik();
            $oWynik->tytul = $strona->tytul;
            $oWynik->tresc = $strona->tresc;
            $oWynik->kategoria = 'Strona Opisowa';
            $oWynik->data = $strona->dataDodania;
            $oWynik->link = Router::urlHttp($strona->idKategorii);
            $wyniki[] = $oWynik;
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