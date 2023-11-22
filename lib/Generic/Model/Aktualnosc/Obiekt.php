<?php
namespace Generic\Model\Aktualnosc;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca aktualności.
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property int $idKategorii
 * @property string $tytul
 * @property string $zajawka
 * @property string $zdjecieGlowne
 * @property string $tresc
 * @property int $idUzytkownika
 * @property string $autor
 * @property string $dataDodania
 * @property int $priorytetowa
 * @property int $publikuj
 */
class Obiekt extends ObiektDanych
{

	/**
	 * pola obslugiwane przez obiekt
	 * @var array
	 */
	protected $_pola = array(
		'id',
		'idProjektu',
		'kodJezyka',
		'idKategorii',
		'tytul',
		'zajawka',
		'zdjecieGlowne',
		'tresc',
		'idUzytkownika',
		'autor',
		'dataDodania',
		'dataWaznosci',
		'priorytetowa',
		'publikuj',
		'idGalerii',
	);

	private $zalaczniki;

	public function pobierzKatalog():Katalog
    {
        if($this->id > 0)
            $katalog = new Katalog(Cms::inst()->katalog('aktualnosci', $this->id), true);
        else
            $katalog = new Katalog(Cms::inst()->katalog('aktualnosci'), true);
        return $katalog;
    }

	public function pobierzZalaczniki():array
    {
        $zalacznikiMapper = new \Generic\Model\Zalacznik\Mapper();
        return  $zalacznikiMapper->pobierzDlaObjektu('Aktualnosc', $this->id);
    }

    public function dodajZalacznik(\Generic\Model\Zalacznik\Obiekt $zalacznik)
    {
        $zalacznik->ustawObiekt($this);
        $zalacznik->zapisz(new \Generic\Model\Zalacznik\Mapper());
    }
}
