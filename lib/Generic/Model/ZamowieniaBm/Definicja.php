<?php

namespace Generic\Model\ZamowieniaBm;
use Generic\Biblioteka\Cms;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property int $id_klienta 
 * @property string $model 
 * @property int $id_model 
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
 */
class Definicja extends Biblioteka\DefinicjaObiektu
{



	/**
	* Przetrzymuje typy pól w bazie.
	* @var array
	*/
	public $polaObiektuTypy = array(
		'id' => self::_INTEGER,
		'idProjektu' => self::_INTEGER,
		'idKlienta' => self::_INTEGER,
		'model' => self::_STRING,
		'idModel' => self::_INTEGER,
		'zloto' => self::_DOUBLE,
		'platyna' => self::_DOUBLE,
		'srebro' => self::_DOUBLE,
		'kamienie' => self::_ARRAY,
		'cena' => self::_STRING,
		'grawer' => self::_STRING,
		'rabat' => self::_INTEGER,
		'opis' => self::_STRING,
		'status' => self::_STRING,
		'autor' => self::_INTEGER,
		'wykonawca' => self::_INTEGER,
        'dataDodania' => self::_DATETIME,
        'tytul' => self::_STRING,
        'indywidualne' => self::_BOOLEAN,
        'modelTekst' => self::_STRING,
        'daneZlota' => self::_ARRAY,
        'rodzajOprawy' => self::_STRING,
        'kamienKlienta' => self::_STRING,
        'rozmiar' => self::_STRING,
        'zaliczka' => self::_STRING,
        'wysokosc' => self::_STRING,
        'termin' => self::_STRING,
        'rodzaj' => self::_STRING,
        'materialyKlienta' => self::_STRING,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = [
	    'idProjektu' => ID_PROJEKTU,
        'status' => 'nowy',
    ];



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
	    'status' => array(
	        'nowy', 'przyjete', 'w trakcie', 'wykonane', 'do poprawy', 'akceptacja', 'do akceptacji', 'wydane', 'oprawa', 'archiwum'
        )
	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $formularz = array(
        'dane_podstawowe' => '_region_',
		'idKlienta' => array(
			'input' => 'SelectKlienci',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),
		'tytul' => array(
            'input' => 'Text',
            'filtry' => array(
            ),
            'walidatory' => array(
            ),
        ),
		'rodzaj' => array(
            'input' => 'Select',
            'filtry' => array(
            ),
            'walidatory' => array(
            ),
        ),
		'idModel' => array(
			'input' => 'Select',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),
        'indywidualne' => array(
            'input' => 'Checkbox',
            'filtry' => array(
            ),
            'walidatory' => array(
            ),
        ),
        'modelTekst' => array(
            'input' => 'Text',
            'filtry' => array(
            ),
            'walidatory' => array(
            ),
        ),
        'rozmiar' => array(
            'input' => 'Text',
        ),
        'wysokosc' => array(
            'input' => 'Text',
        ),
        'termin' => array(
            'input' => 'Data',
        ),
        'zaliczka' => array(
            'input' => 'Text',
            'filtry' => array(
                'floatval'
            ),
            'walidatory' => array(
            ),
        ),
        'dane_zamowienia' => '_region_',
		'daneZlota' => array(
            'input' => 'MultiCheckbox',
        ),
		'zloto' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'walidatory' => array(
			),
		),

		'platyna' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'walidatory' => array(
			),
		),

		'srebro' => array(
			'input' => 'Text',
			'filtry' => array(
				'doubleval',
			),
			'walidatory' => array(
			),
		),
        'materialyKlienta' => array(
            'input' => 'Text',
        ),
		'kamienie' => array(
			'input' => 'SelectProdukty',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
			),
		),
        'kamienKlienta' => array(
            'input' => 'Text',
        ),
        'rodzajOprawy' => array(
            'input' => 'Text',
        ),
		'cena' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

		'grawer' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 1000,
			),
		),

		'rabat' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),
        'informacje_dodatkowe' => '_region_',
		'opis' => array(
			'input' => 'Textarea',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
			),
		),
		'status' => array(
			'input' => 'Select',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
			),
		),

		'autor' => array(
			'input' => 'Text',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

		'wykonawca' => array(
			'input' => 'Select',
			'filtry' => array(
				'intval',
			),
			'walidatory' => array(
			),
		),

	);

    public function lista_status()
    {
        $tlumaczeniaMapper = new \Generic\Model\WierszTlumaczen\Mapper();
        $wiersz = $tlumaczeniaMapper->pobierzWartoscWierszaTlumaczen('formularzEdycji.opcje_kostsentral', 'Klienci_Admin');

        $centraRozliczen = array();

        return $centraRozliczen;
    }

    public function lista_daneZlota()
    {
        $mapperKamienie = new \Generic\Model\Kamienie\Mapper();
        $pobraneWiersze =  $mapperKamienie->zwracaTablice('id', 'nazwa')->szukaj(array('typ' => 'rodzaj_zlota'));
        $return = [];
        foreach($pobraneWiersze as $wiersz)
        {
            $return[$wiersz['nazwa']] = $wiersz['nazwa'];
        }
        return $return;
    }

    public function lista_idKlienta()
    {
        $mapper = Cms::inst()->dane()->Klient();
        $kryteria = [];
        $klienci = $mapper->zwracaTablice()->szukaj($kryteria);

        $lista = array('' => 'wybierz');
        if (count($klienci) > 0)
        {
            foreach ($klienci as $klient)
            {
                switch ($klient['type'])
                {
                    case 'private' :
                        $lista[$klient['id']] = $klient['name'].(($klient['second_name'] != '') ? ' ' : '').$klient['second_name'].' '.$klient['surname'].' ('.$klient['postcode'].' '.$klient['city'].', '.$klient['address'].')';
                        break;
                    case 'branch contact person' :
                        $lista[$klient['id']] = $klient['name'].(($klient['second_name'] != '') ? ' ' : '').$klient['second_name'].' '.$klient['surname'].' ('.$klient['phone_mobile'].', '.$klient['email'].')';
                        break;
                    default :
                        $lista[$klient['id']] = $klient['company_name'].' ('.$klient['postcode'].' '.$klient['city'].', '.$klient['address'].')';
                        break;
                }
            }
        }

        return $lista;
    }

    public function lista_rodzaj()
    {
        $tlumaczeniaMapper = new \Generic\Model\WierszTlumaczen\Mapper();
        $wiersze = $tlumaczeniaMapper->pobierzWartoscWierszaTlumaczen('rodzaj_wyrobu', 'ZamowieniaBm_Admin');


        return $wiersze;
    }

    public function lista_idModel()
    {
        $produkty = Cms::inst()->dane()->ProduktyMagazyn();
        $lista = $produkty->zwracaTablice('id', 'nazwa_produktu')->szukaj( array('status' => 'active'));
        $return = array('' => 'wybierz');
        foreach($lista as $produkt)
        {
            $return[$produkt['id']] = $produkt['nazwa_produktu'];
        }
        return $return;
    }

    public function lista_kamienie()
    {
        $kamienie = Cms::inst()->dane()->Kamienie();
        $lista = $kamienie->zwracaTablice('id', 'nazwa')->pobierzWszystko();

        foreach($lista as $produkt)
        {
            $return[$produkt['id']] = array(
                'etykieta' => $produkt['nazwa'],
                'main' => 1,
                'multiple' => true,
                'jednostka' => 'gr'
                );
        }
        return $return;
    }

    public function lista_wykonawca()
    {
        $kamienie = Cms::inst()->dane()->Uzytkownik();
        $lista = $kamienie->zwracaTablice('id', 'imie', 'nazwisko')->pobierzDlaRoliPoKodach(array('pracownia'));
        $return = array('' => 'wybierz');
        foreach($lista as $produkt)
        {
            $return[$produkt['id']] = $produkt['imie'].' '.$produkt['nazwisko'];
        }
        return $return;
    }
}