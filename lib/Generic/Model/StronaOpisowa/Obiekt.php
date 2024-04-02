<?php
namespace Generic\Model\StronaOpisowa;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca stronę opisową.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property int $idKategorii
 * @property string $tytul
 * @property string $tresc
 * @property int $idAutora
 * @property int $idGalerii
 * @property string $dataDodania
 */

class Obiekt extends ObiektDanych
{
    public function pobierzKatalog():Katalog
    {
        if($this->id > 0)
            $katalog = new Katalog(Cms::inst()->katalog('strona_opisowa', $this->id), true);
        else
            $katalog = new Katalog(Cms::inst()->katalog('strona_opisowa'), true);
        return $katalog;
    }

    public function pobierzZalaczniki():array
    {
        $zalacznikiMapper = new \Generic\Model\Zalacznik\Mapper();
        return  $zalacznikiMapper->pobierzDlaObjektu('StronaOpisowa', $this->id);
    }

    public function dodajZalacznik(\Generic\Model\Zalacznik\Obiekt $zalacznik)
    {
        $zalacznik->ustawObiekt($this);
        $zalacznik->zapisz(new \Generic\Model\Zalacznik\Mapper());
    }
}
