<?php
namespace Generic\Biblioteka\Wyszukiwarka\Tabela;

use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Wyszukiwarka\Wynik;
use Generic\Model\Kategoria;

class Baza implements TabelaInterface
{

    protected $kryteria;
    protected $baza;
    protected $sorter;
    protected $pager = null;

    public function __construct()
    {
        $this->baza = Cms::inst()->Baza();
    }

    public function ustawKryteria(array $kryteria)
    {
        $this->kryteria = $kryteria;
    }

    public function ustawPager( Pager $pager)
    {
        $this->pager = $pager;
    }

    public function pobierzWyniki(): array
    {
        $sql = $this->budujSql();
        $sql = $this->baza->sqlSelect($sql, $this->pager);
        $this->baza->zapytanie($sql);

        $kategoriaMapper = new Kategoria\Mapper();
        $kategorieAktualnosci = [];

        $wyniki = [];
        while($wiersz = $this->baza->pobierzWynik())
        {
            $oWynik = new Wynik();
            $oWynik->tytul = $wiersz['tytul'];
            $oWynik->tresc = $wiersz['zajawka'];

            if($wiersz['modul'] == 'strona')
                $kategoria = 'Strona opisowa';
            else
                if(isset($kategorieAktualnosci[$wiersz['id']]))
                    $kategoria = $kategorieAktualnosci[$wiersz['id']];
                else
                    $kategoria = ($kategoriaMapper->pobierzPoId($wiersz['id_kategorii']) instanceof Kategoria\Obiekt) ? $kategoriaMapper->pobierzPoId($wiersz['id_kategorii'])->nazwa : '';

            if($wiersz['zdjecie_glowne'] != '')
                $oWynik->zdjecie = $this->pobierzUrlZdjecia($wiersz);

            $oWynik->kategoria = $kategoria;
            $oWynik->data = $wiersz['data_dodania'];
            $oWynik->link = $this->pobierzLink($wiersz);
            $wyniki[] = $oWynik;
        }

        return $wyniki;
    }

    protected function pobierzUrlZdjecia(array $aktualnosc):string
    {
        $prefix = 'mid-';
        return Cms::inst()->url('aktualnosci', $aktualnosc['id']).'/'.$prefix.$aktualnosc['zdjecie_glowne'];
    }

    protected function pobierzKategorie(array $wiersz)
    {

    }

    private function pobierzLink(array $wiersz):string
    {
        $link = '';
        switch($wiersz['modul'])
        {
            case 'aktualnosci' :  $link = Router::urlHttp($wiersz['id_kategorii'], ['aktualnosc', $wiersz['id']]);
            break;
            case 'strona' : $link = Router::urlHttp($wiersz['id_kategorii']);
            break;
        }
        return $link;
    }

    private function budujSql():string
    {
        $fraza = addslashes($this->kryteria['fraza']);
        $sql = "( 
            SELECT id, 'aktualnosci' as modul, zdjecie_glowne , tytul, ma.zajawka as zajawka, tresc, id_kategorii, data_dodania FROM modul_aktualnosci as ma WHERE ma.id_projektu = ".ID_PROJEKTU." AND  (
                        ma.tytul ILIKE '%".$fraza."%' OR ma.zajawka ILIKE '%".$fraza."%' OR ma.tresc LIKE '%".$fraza."%') AND ma.publikuj = true
            UNION ALL 
            SELECT id, 'strona' as modul, '' as zdjecie_glowne, tytul, ms.tresc as zajawka, tresc, id_kategorii, data_dodania FROM modul_strona_opisowa as ms  WHERE ms.id_projektu = ".ID_PROJEKTU." AND (
                            ms.tytul ILIKE '%".$fraza."%' OR ms.tresc ILIKE '%".$fraza."%'
                        )
        )";

        return $sql;
    }

    public function pobierzIlosc(): int
    {
        $sql = $this->budujSql();
        $this->baza->zapytanie($sql);
        $ilosc = 0;
        while($wiersz = $this->baza->pobierzWynik())
            $ilosc++;

        return $ilosc;
    }
}