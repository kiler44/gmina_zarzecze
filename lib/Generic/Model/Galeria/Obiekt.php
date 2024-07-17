<?php
namespace Generic\Model\Galeria;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\ObiektDanych;
use Generic\Model\GaleriaZdjecie;
/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property int $idKategorii
 * @property string $nazwa
 * @property string $opis
 * @property string $autor
 * @property string $dataDodania
 * @property string $zdjecieGlowne
 * @property int $publikuj
 *
 * dostepne tylko z poziomu cache
 * @property array $zdjecia
 */

class Obiekt extends ObiektDanych
{

	// pola obslugiwane przez obiekt
	protected $_pola = array(
		'id',
		'idProjektu',
		'kodJezyka',
		'nazwa',
		'opis',
		'autor',
		'dataDodania',
		'zdjecieGlowne',
		'publikuj',
		'idKategorii',
	);



	public function pobierzZdjecia()
	{

		$zdjeciaMapper = new GaleriaZdjecie\Mapper();

		$this->_cache['zdjecia'] = $zdjeciaMapper->pobierzDlaGalerii($this->_wartosci['id']);
		return $this->_cache['zdjecia'];
	}

	public function pobierzKategorie():\Generic\Model\Kategoria\Obiekt
    {
        $kategoriaMapper = new \Generic\Model\Kategoria\Mapper();
        return $kategoriaMapper->pobierzPoId($this->idKategorii);
    }

	public function dodajZdjecie(string $nazwaPliku, ?string $opis = ''):bool
    {
        $zdjeciaMapper = new GaleriaZdjecie\Mapper();
        $zdjecieObiekt = new GaleriaZdjecie\Obiekt();

        $zdjecieObiekt->dataDodania =  new \DateTime();
        //$zdjecieObiekt->autor = Cms::inst()->profil()->id;
        $zdjecieObiekt->nazwaPliku = $nazwaPliku;
        $zdjecieObiekt->opis = $opis;
        $zdjecieObiekt->idGalerii = $this->id;
        $zdjecieObiekt->publikuj = true;
        $zdjecieObiekt->kodJezyka = KOD_JEZYKA;


        return $zdjecieObiekt->zapisz($zdjeciaMapper);
    }

    public function aktualizujOpisZdjecia(int $id, ?string $opis):bool
    {
        $zdjeciaMapper = new GaleriaZdjecie\Mapper();
        if( ( $zdjecie = $zdjeciaMapper->pobierzPoId($id) ) instanceof GaleriaZdjecie\Obiekt )
        {
            $zdjecie->opis = $opis;
            return $zdjecie->zapisz($zdjeciaMapper);
        }
        else
        {
            return false;
        }


    }

}
