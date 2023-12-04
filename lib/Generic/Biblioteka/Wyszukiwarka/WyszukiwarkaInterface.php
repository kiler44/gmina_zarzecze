<?php
namespace Generic\Biblioteka\Wyszukiwarka;

use Generic\Biblioteka\Wyszukiwarka\Tabela;

interface WyszukiwarkaInterface
{
    public function ustawKryteria(array $kryteria);

    public function ustawTabele(Tabela\TabelaInterface $tabela);

    public function pobierzWyniki():array;

    public function pobierzIlosc():int;
}