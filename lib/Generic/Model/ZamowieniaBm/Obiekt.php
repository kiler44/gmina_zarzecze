<?php

namespace Generic\Model\ZamowieniaBm;

use Generic\Biblioteka\ObiektDanych;
use Generic\Model\Klient;
use Generic\Model\Uzytkownik;
use Generic\Model\ProduktyMagazyn;
use Generic\Model\Notes;
use Generic\Model\Zalacznik;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property int $idKlienta
 * @property string $model
 * @property int $idModel
 * @property double $zloto
 * @property double $platyna
 * @property double $srebro
 * @property string $kamienie
 * @property double $cena
 * @property string $grawer
 * @property int $rabat
 * @property string $opis
 * @property string $status
 * @property int $autor
 * @property int $wykonawca
 * @property  date $dataDodania
 * @property  string $tytul
 * @property  bool $indywidualne
 * @property string $modelTekst
 * @property array $daneZlota
 * @property string $rodzajOprawy
 * @property string $kamienKlienta
 * @property float $zaliczka
 * @property array $rozmiar
 */
class Obiekt extends ObiektDanych
{
    /**
     * @var \Generic\Konfiguracja\Model\ZamowieniaBm\Obiekt
     */
    protected $k;

    /**
     * @var \Generic\Tlumaczenie\Pl\Model\ZamowieniaBm\Obiekt
     */
    protected $j;

    public function pobierzKlienta()
    {
        $klientMapper = new Klient\Mapper();
        return $klientMapper->pobierzPoId($this->idKlienta);
    }

    public function pobierzDozwoloneWartosciPola($pole)
    {
        $wartosci = parent::pobierzDozwoloneWartosciPola($pole);
        /*
        if($pole != 'status') return  $wartosci;
        switch($this->status)
        {
            //'nowy', 'przyjete', 'w trakcie', 'wykonane', 'do poprawy', 'akceptacja', 'do akceptacji', 'wydane'
            case 'nowe' : $wartosci = $this->unsetPola($wartosci, [ 'w trakcie', 'wykonane', 'do poprawy', 'akceptacja', 'do akceptacji', 'wydane']);
            break;
            case 'przyjete' :  $wartosci = $this->unsetPola($wartosci, ['wykonane', 'do poprawy', 'akceptacja', 'wydane']);
            break;
            case 'w trakcie' : $wartosci = $this->unsetPola($wartosci, ['nowy', 'przyjete', 'wykonane', 'do poprawy', 'akceptacja', 'wydane']);
            break;
            case 'do akceptacji' : $wartosci = $this->unsetPola($wartosci, ['nowy', 'przyjete', 'w trakcie']);
            break;
            case 'do poprawy' : $wartosci = $this->unsetPola($wartosci, [ 'nowy', 'wykonane', 'do poprawy', 'akceptacja', 'wydane']);
            break;
            case 'akceptacja' : $wartosci = $this->unsetPola($wartosci, [ 'nowy', 'przyjete', 'w trakcie', 'wykonane', 'do poprawy', 'do akceptacji']);
            break;
            case 'wydane' : $wartosci = $this->unsetPola($wartosci, [ 'nowy', 'przyjete', 'w trakcie', 'wykonane', 'do poprawy', 'akceptacja', 'do akceptacji']);
            break;
            case 'wykonane' : $wartosci = $this->unsetPola($wartosci, [ 'nowy', 'przyjete', 'w trakcie', 'do poprawy', 'akceptacja', 'do akceptacji']);
            break;
            case 'oprawa' : $wartosci = $this->unsetPola($wartosci, [ 'nowy', 'wykonane', 'do poprawy', 'akceptacja', 'wydane']);
            break;
        }
        */

        return $wartosci;
    }

    private function unsetPola($wartosci , array $pola)
    {
        return array_diff($wartosci, $pola);
    }

    public function pobierzWykonawce()
    {
        $uzytkownikMapper = new Uzytkownik\Mapper();
        return $uzytkownikMapper->pobierzPoId($this->wykonawca);
    }

    public function pobierzAutora()
    {
        $uzytkownikMapper = new Uzytkownik\Mapper();
        return $uzytkownikMapper->pobierzPoId($this->autor);
    }

    public function pobierzModel()
    {
        $produktyMapper = new ProduktyMagazyn\Mapper();
        return $produktyMapper->pobierzPoId($this->idModel);
    }

    public function pobierzNotatki()
    {
        $notesMapper = new Notes\Mapper();
        return $notesMapper->szukaj(['object' => 'zamowieniaBm', 'idObject' => $this->id]);
    }

    public function pobierzZalaczniki()
    {
        $zalacznikiMapper = new Zalacznik\Mapper();
        return $zalacznikiMapper->pobierzDlaObjektu('ZamowieniaBm', $this->id);
    }
}