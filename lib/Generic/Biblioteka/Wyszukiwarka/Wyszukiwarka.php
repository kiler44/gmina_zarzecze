<?php
namespace Generic\Biblioteka\Wyszukiwarka;

use Generic\Biblioteka\Wyszukiwarka\Tabela;

class Wyszukiwarka
{
    private $wyszukiwarkaSilnik;

    public function __construct(WyszukiwarkaInterface $silnik)
    {
        $this->wyszukiwarkaSilnik = $silnik;
    }

    public function ustawKryteria(array $krteria)
    {
        $this->wyszukiwarkaSilnik->ustawKryteria($krteria);
    }

    public function ustawTabele(Tabela\TabelaInterface $tabela)
    {
        $this->wyszukiwarkaSilnik->ustawTabele($tabela);
    }

    /**
     * @var Wynik[]
     */
    public function pobierzWyniki():array
    {
        return $this->wyszukiwarkaSilnik->pobierzWyniki();
    }

    public function pobierzIlosc():int
    {
        return $this->wyszukiwarkaSilnik->pobierzIlosc();
    }


}