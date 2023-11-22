<?php
namespace Generic\Modul\ZamowieniaBm;
use Generic\Biblioteka\Modul;

class Http extends Modul\Http
{

    protected $uprawnienia = array(
        'wykonajIndex',
        'wykonajDodaj',
    );
    protected $akcjeAjax = array(

    );
    /**
     * @var \Generic\Konfiguracja\Modul\ZamowieniaBm\Http
     */
    protected $k;

    /**
     * @var \Generic\Tlumaczenie\Pl\Modul\ZamowieniaBm\Http
     */
    protected $j;

    public function wykonajIndex()
    {
        dump('test'); die;
        $this->szablon->parsujBlok('index', array());

    }

    public function wykonajDodaj()
    {
        $this->szablon->parsujBlok('dodaj', array( ));
    }

}