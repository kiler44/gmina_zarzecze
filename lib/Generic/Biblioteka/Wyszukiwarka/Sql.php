<?php
namespace Generic\Biblioteka\Wyszukiwarka;

use Generic\Biblioteka\Wyszukiwarka\Tabela;

class Sql implements WyszukiwarkaInterface
{
    protected $kryteria;

    protected $tabela;

    public function ustawKryteria(array $kryteria)
    {
        $this->kryteria = $kryteria;
    }

    public function ustawTabele(Tabela\TabelaInterface $tabela)
    {
        $this->tabela = $tabela;
    }

    public function pobierzWyniki():array
    {
        return $this->tabela->pobierzWyniki();
    }

    public function pobierzIlosc():int
    {
        return $this->tabela->pobierzIlosc();
    }
}