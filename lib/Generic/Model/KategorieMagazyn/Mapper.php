<?php
namespace Generic\Model\KategorieMagazyn;
use Generic\Biblioteka;
use Generic\Model\Drzewo;
use Generic\Model\Kategoria;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\MapperWyjatek;
use Generic\Biblioteka\BazaWyjatek;


/**
* Maper tabeli w bazie: modul_kategorie_magazyn
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\KategorieMagazyn\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_kategorie_magazyn';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'prawy' => 'prawy',
		'lewy' => 'lewy',
		'kod' => 'kod',
		'poziom' => 'poziom',
		'nazwa' => 'nazwa',
		'kategoria_glowna' => 'kategoriaGlowna',
		'blokuj_wyswietlanie' => 'blokujWyswietlanie',
		'blokuj_przypisywanie' => 'blokujPrzypisywanie',
		'id_rodzica' => 'idRodzica',
		'opiekun' => 'opiekun',
	);



	/**
	* Pola tabeli bazy danych tworzące klucz główny.
	* @var array
	*/
	protected $polaTabeliKlucz = array(
		'id',
		'id_projektu',
	);

	// pola tabeli potrzebne do zapisu drzewa
	protected $polaTabeliDrzewo = array('id', 'prawy', 'lewy', 'poziom');

	public function __construct($zwracaTablice = false)
	{
		parent::__construct($zwracaTablice);
		$this->drzewo = new Drzewo\Obiekt($this->baza, $this->tabela, ID_PROJEKTU);
		$this->obiektPolaTabeli = array_flip($this->polaTabeliObiekt);
	}
	
	function przeniesObok(KategoriaOgloszen\Obiekt $kategoria, $idSasiada, $polozenie)
	{
		return $this->drzewo->zamienPozycjeWszystkich($kategoria->id, $idSasiada, $polozenie);
	}

	function pobierzKategorieUkryte()
	{
		$sql = 'SELECT * FROM ' . $this->tabela
		. ' WHERE id_projektu = ' . ID_PROJEKTU
	   . ' AND blokuj_wyswietlanie = \'1\' ';

		return $this->pobierzWiele($sql);
	}

	function zmienRodzica(KategoriaOgloszen\Obiekt $kategoria, $idRodzica)
	{
		return $this->drzewo->przeniesWszystkie($kategoria->id, $idRodzica);
	}



	function info(KategoriaOgloszen\Obiekt $kategoria)
	{
		return $this->drzewo->info($kategoria->id);
	}
	

	/*
	 * Przeciazona metoda zapisz. Zapisuje obiekt w bazie
	 *
	 * @param ObiektDanych $kategoria Obiekt do utrwalenia w bazie
	 *
	 * @return boolean w zaleznosci od wyniku z bazy
	 */
	function wstaw(ObiektDanych $kategoria)
	{
		if ( ! $this->obiektObslugiwany($kategoria))
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($kategoria).' w bazie.');
		}
		if ((int)$kategoria->idRodzica < 1)
		{
			return false;
		}
		$dane = array();
		foreach ($kategoria->daneDoZapisu() as $zmienna => $wartosc)
		{
			$poleTabeli = $this->obiektPolaTabeli[$zmienna];
			if (in_array($poleTabeli, $this->polaTabeliDrzewo)) continue;
			$dane[$poleTabeli] = $this->formatujWartosc($poleTabeli, $wartosc);
		}
		return $this->drzewo->wstawPod($kategoria->idRodzica, '', $dane);
	}



	function czysc()
	{
		$dane = array(
			'id_projektu' => ID_PROJEKTU,
			'nazwa' => 'Root',
			'kod' => '_root_',
			'kategoria_glowna' => '_root_',
		);
		return $this->drzewo->czysc($dane);
	}

	/*
	 * Przeciazona metoda usun. Usuwa obiekt z bazy
	 *
	 * @param ObiektDanych $kategoria Obiekt do utrwalenia w bazie
	 *
	 * @return boolean w zaleznosci od wyniku z bazy
	 */
	function usun(ObiektDanych $kategoria)
	{
		if ( ! $this->obiektObslugiwany($kategoria))
		{
			throw new MapperWyjatek('Nie mozna zapisac danych obiektu '.get_class($kategoria).' w bazie.');
		}
		return $this->drzewo->usunzDziecmi($kategoria->id);
	}
	
	/**
	* Zwraca dla podanego id w tabeli modul_kategorie_magazyn.
	* @return \Generic\Model\Generic\Model\KategorieMagazyn\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	function pobierzPoKodzie($kod)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE kod = \'' . addslashes($kod) . '\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	function pobierzDlakategoriiGlownej($kategoriaGlowna, $kryteria = array())
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE kategoria_glowna = \'' . addslashes($kategoriaGlowna) . '\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		if (isset($kryteria['blokuj_wyswietlanie']) && is_int($kryteria['blokuj_wyswietlanie']))
		{
			$sql .= ' AND blokuj_wyswietlanie = '.intval($kryteria['blokuj_wyswietlanie']);
		}
		if (isset($kryteria['blokuj_przypisywanie']) && is_int($kryteria['blokuj_przypisywanie']))
		{
			$sql .= ' AND blokuj_przypisywanie = '.intval($kryteria['blokuj_przypisywanie']);
		}

		$sql .= ' ORDER BY lewy';

		return $this->pobierzWiele($sql);
	}



	function ustawBlokujWyswietlenieDlaGalezi($lewy, $prawy, $status)
	{
		$sql = 'UPDATE ' . $this->tabela
			. ' SET blokuj_wyswietlanie = ' . intval($status)
			. ' WHERE lewy > ' . intval($lewy)
			. ' AND prawy < ' . intval($prawy);

		$this->baza->zapytanie($sql);
	}



	function ustawBlokujPrzypisywanieDlaGalezi($lewy, $prawy, $status)
	{
		$sql = 'UPDATE ' . $this->tabela
			. ' SET blokuj_przypisywanie = ' . intval($status)
			. ' WHERE lewy > ' . intval($lewy)
			. ' AND prawy < ' . intval($prawy);

		$this->baza->zapytanie($sql);
	}
	
	function pobierzPoziom($poziom)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE poziom = ' . intval($poziom)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' ORDER BY nazwa';

		return $this->pobierzWiele($sql);
	}


/*
	// UWAGA: ta metoda będzie zawsze zwracać tablice
	function pobierzDlaBlokuDoPoziomu($poziom)
	{
		$this->zwracaTablice = self::ZWRACA_TABLICE;

		$sql = 'SELECT k.id, k.poziom, k.nazwa, k.url, '
			. ' (SELECT COUNT(DISTINCT p.id)
					FROM modul_ogloszenia_kategorie_powiazania AS p
					WHERE p.id_kategorii_ogloszen = k.id
					AND p.id_projektu = '.ID_PROJEKTU.'
					AND p.id_ogloszenia IN (
						SELECT DISTINCT o.id
						FROM modul_ogloszenia AS o
						WHERE id_projektu = '.ID_PROJEKTU.'
						AND status = \'aktywny\'
						AND publikuj = 1
					)
				) as ilosc'
			. ' FROM ' . $this->tabela . ' AS k'
			. ' WHERE poziom < ' . intval($poziom)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' ORDER BY lewy';

		return $this->pobierzWiele($sql);
	}



	// UWAGA: ta metoda będzie zawsze zwracać tablice
	function pobierzDoPrzypisania($lewy, $prawy)
	{
		$this->zwracaTablice = self::ZWRACA_TABLICE;

		$sql = 'SELECT k.id, k.poziom, k.nazwa, k.kod, k.kategoria_glowna, '
			. ' (SELECT COUNT(DISTINCT p.id_ogloszenia)
					FROM modul_ogloszenia_kategorie_powiazania AS p
					WHERE p.id_kategorii_ogloszen = k.id
					AND p.id_projektu = '.ID_PROJEKTU.'
					AND p.kod_jezyka = \''.KOD_JEZYKA.'\'
				) as ilosc'
			. ' FROM ' . $this->tabela . ' AS k'
			. ' WHERE k.id_projektu = ' . ID_PROJEKTU
			. ' AND k.kod_jezyka = \'' . KOD_JEZYKA . '\''
			. ' AND k.lewy >= ' . $lewy
			. ' AND k.prawy <= ' . $prawy
			. ' ORDER BY k.lewy';

		return $this->pobierzWiele($sql);
	}



	function pobierzPodkategorieIlosciDoPoziomu($id, $poziomMaks, $poziomyIlosci = array())
	{
		$this->zwracaTablice = self::ZWRACA_TABLICE;

		$sql = 'SELECT A.id, A.poziom, A.nazwa, A.kod, A.kategoria_glowna, A.url, '
			. '(IF (A.poziom IN ('.implode(',', $poziomyIlosci).'),
				(SELECT COUNT(DISTINCT p.id)
					FROM modul_ogloszenia_kategorie_powiazania AS p
					WHERE p.id_kategorii_ogloszen = A.id
					AND p.id_projektu = '.ID_PROJEKTU.'
					AND p.kod_jezyka = \''.KOD_JEZYKA.'\'
					AND p.id_ogloszenia IN
					(
						SELECT o.id
						FROM modul_ogloszenia AS o
						WHERE o.id_projektu = '.ID_PROJEKTU.'
						AND o.kod_jezyka = \''.KOD_JEZYKA.'\'
						AND (o.data_waznosci >= \''.date('Y-m-d', $_SERVER['REQUEST_TIME']).'\'
							 OR o.data_waznosci = \'\' OR o.data_waznosci IS NULL)
						AND o.publikuj = 1
		 				AND o.status = \'aktywny\'
		 			)
		 		), 0)) AS ilosc'
			. ' FROM ' . $this->tabela . ' AS A, ' . $this->tabela . ' AS B'
			. ' WHERE A.poziom <= ' . intval($poziomMaks)
			. ' AND B.id = ' . intval($id)
			. ' AND A.lewy >= B.lewy'
			. ' AND A.prawy <= B.prawy'
			. ' AND A.id_projektu = '.ID_PROJEKTU
			. ' AND A.kod_jezyka = \''.KOD_JEZYKA.'\''
			. ' AND B.id_projektu =  '.ID_PROJEKTU
			. ' AND B.kod_jezyka =  \''.KOD_JEZYKA.'\''
			. ' ORDER BY A.lewy';

		return $this->pobierzWiele($sql);
	}



	// UWAGA: ta metoda będzie zawsze zwracać tablice
	function pobierzPodkategorieDoPoziomu($id, $poziom, $id_ogloszen = array())
	{
		$this->zwracaTablice = self::ZWRACA_TABLICE;

		$sql = 'SELECT A.id, A.poziom, A.nazwa, A.kod, A.kategoria_glowna, A.url, '
			. ' (SELECT COUNT(DISTINCT p.id)
					FROM modul_ogloszenia_kategorie_powiazania AS p
					WHERE p.id_kategorii_ogloszen = A.id
					AND p.id_projektu = '.ID_PROJEKTU.'
					AND p.kod_jezyka = \''.KOD_JEZYKA.'\'
					AND p.id_ogloszenia IN (' . implode(',', $id_ogloszen) . ')
				) as ilosc'
			. ' FROM ' . $this->tabela . ' AS A, ' . $this->tabela . ' AS B'
			. ' WHERE B.id = ' . intval($id)
			. ' AND A.lewy >= B.lewy'
			. ' AND A.prawy <= B.prawy'
			. ' AND A.id_projektu = '.ID_PROJEKTU
			. ' AND A.kod_jezyka = \''.KOD_JEZYKA.'\''
			. ' AND B.id_projektu =  '.ID_PROJEKTU
			. ' AND B.kod_jezyka =  \''.KOD_JEZYKA.'\''
			. ' AND A.poziom <= ' . intval($poziom)
			. ' ORDER BY A.nazwa';

		return $this->pobierzWiele($sql);
	}



	// UWAGA: ta metoda będzie zawsze zwracać tablice
	function pobierzZakresPodkategoriiDlaPoziomu($lewy, $prawy, $poziom, $id_ogloszen = array())
	{
		$this->zwracaTablice = self::ZWRACA_TABLICE;

		$sql = 'SELECT A.id, A.poziom, A.lewy, A.prawy, A.nazwa, A.kod, A.kategoria_glowna, A.url, '
			. ' (SELECT COUNT(DISTINCT p.id)
					FROM modul_ogloszenia_kategorie_powiazania AS p
					WHERE p.id_kategorii_ogloszen = A.id
					AND p.id_projektu = '.ID_PROJEKTU.'
					AND p.kod_jezyka = \''.KOD_JEZYKA.'\'
					AND p.id_ogloszenia IN (' . implode(',', $id_ogloszen) . ')
				) as ilosc'
			. ' FROM ' . $this->tabela . ' AS A'
			. ' WHERE A.poziom = ' . intval($poziom)
			. ' AND A.lewy >= ' . intval($lewy)
			. ' AND A.prawy <= ' . intval($prawy)
			. ' AND A.blokuj_wyswietlanie = 0'
			. ' AND A.id_projektu = '.ID_PROJEKTU
			. ' AND A.kod_jezyka = \''.KOD_JEZYKA.'\''
			. ' HAVING ilosc > 0'
			. ' ORDER BY lewy';

		return $this->pobierzWiele($sql);
	}
 * 
 */

	function pobierzWspolnyRodzicOrazPoziom($id)
	{
		//info o wybranej kategorii
		$KategoriaOgloszen = $this->drzewo->info((int)$id);
		// pobieranie rodzica
		$rodzic = $this->drzewo->pobierzRodzica((int)$id);
		// pobieranie calej galezi lacznie z bierzacym elementem
		$dane = $this->drzewo->pobierzGalaz($rodzic['id'], null, array('and' => array('poziom = ' . $KategoriaOgloszen['poziom'])));

		return $this->przetworzWynikDrzewa($dane);
	}

	function pobierzSciezke($id, $lewy = 0, $prawy = 0)
	{
		// pobieranie listy kategorii nadrzednych az do glownej
		if ($lewy > 0 && $prawy > 0)
		{
			$sql = 'SELECT * FROM '.$this->tabela.' WHERE lewy <= '.$lewy.' AND prawy >= '.$prawy.' ORDER BY lewy ASC;';
			return $this->pobierzWiele($sql);
		}
		else
		{
			$dane = $this->drzewo->pobierzSciezke((int)$id);
			return $this->przetworzWynikDrzewa($dane);
		}
	}



	function pobierzRodzica($id)
	{
		return $this->przetworzWynik($this->drzewo->pobierzRodzica((int)$id));
	}



	function pobierzDzieci($id)
	{
		// pobieranie listy kategorii podleglych bezposrednio pod bierzaca
		$dane = $this->drzewo->pobierzDzieci((int)$id);

		return $this->przetworzWynikDrzewa($dane);
	}



	function pobierzNiepelneDrzewo($id)
	{
		$KategoriaOgloszen = $this->drzewo->info((int)$id);
		// drzewo z kategoriami posiadajacymi podkategorie
		$dane = $this->drzewo->pobierzDrzewo(null, array('or' => array('lewy <= ' . $KategoriaOgloszen['lewy'], 'prawy >= ' . $KategoriaOgloszen['prawy'])));

		return $this->przetworzWynikDrzewa($dane);
	}



	function pobierzGalaz($id, $pola = null, $warunek = '')
	{
		return $this->przetworzWynikDrzewa($this->drzewo->pobierzGalaz((int)$id, $pola = null, $warunek = ''));
	}



	function pobierzWszystko()
	{
		$dane = $this->drzewo->pobierzDrzewo();

		return $this->przetworzWynikDrzewa($dane);
	}



	function przetworzWynikDrzewa($dane)
	{
		if (empty($dane)) return array();

		$lista = array();
		foreach($dane as $wiersz)
		{
			$lista[] = $this->przetworzWynik($wiersz);
		}

		return $lista;
	}

	function pobierzGalazDoPoziomu($id, $poziom)
	{
		$dane = $this->drzewo->pobierzGalaz((int)$id, null, array('and' => array('poziom <=' => (int)$poziom)));

		return $this->przetworzWynikDrzewa($dane);
	}


}