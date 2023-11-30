<?php
namespace Generic\Biblioteka\Wyszukiwarka\Tabela;

interface TabelaInterface
{
    public function ustawKryteria(array $kryteria);
    public function pobierzWyniki():array;
    public function pobierzIlosc():int;
}