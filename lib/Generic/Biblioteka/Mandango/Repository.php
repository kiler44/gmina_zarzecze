<?php
namespace Generic\Biblioteka\Mandango;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Pager;

trait Repository
{
	/**
	 * Okresla kolumny ktore maja byc zwracane
	 * Jezeli zmienna pusta to zwraca wszystkie kolumny
	 *
	 * @var array
	 */
	protected $zwracaneKolumny = array();


	/**
	 * Tablica mapowania zapytan z naszego na mongodb
	 *
	 * @var Array;
	 */
	protected $mapowanieZapytan = array (
		'nierowne'  => '$ne',
		'zawiera' => '$in',
		'niezawiera' => '$nin',
		'zawierawszystkie' => '$all',
		'wyrazenie' => '$regex',
		'wieksze' => '$gt',
		'wiekszerowne' => '$gte',
		'mniejsze' => '$lt',
		'mniejszerowne' => '$lte',
		'posiada' => '$where',
	);


	public static function pobierzIdentyfikatorBazy()
	{
		return self::$identyfikatorBazy;
	}


	/**
	 * Zwraca instancje kontenera przechowującego mappery
	 *
	 * @return \Generic\Biblioteka\Kontener\Mappery
	 */
	public function dane()
	{
		return Cms::inst()->dane();
	}


	/**
	 * Pobiere obiekt po identyfikatorze
	 * @param $id identyfikator wpisu
	 *
	 * @return \Mandango\Document
	 */
	public function pobierzPoId($id)
	{
		return $this->findOneById($id);
	}


	/**
	 * Pobiere listę obiektów na podstawie tablicy identyfikatorow
	 * @param $listaId identyfikator wpisu
	 *
	 * @return \Mandango\Repository
	 */
	public function pobierzWielePoId(Array $listaId)
	{
		return $this->findById($listaId);
	}


	public function pobierzWszystko(Pager $pager = null, Array $sortowanie = null)
	{
		return $this->szukaj(array(), $pager, $sortowanie);
	}



	public function iloscWszystko()
	{
		return $this->iloscSzukaj(array());
	}


	public function szukaj(Array $kryteria = array(), Pager $pager = null, Array $sortowanie = null)
	{
		$zapytanie = $this->createQuery($this->przetworzKryteria($kryteria));

		if (count($this->zwracaneKolumny) > 0)
		{
			$zapytanie->fields(array_combine($this->zwracaneKolumny, array_fill(0, count($this->zwracaneKolumny), 1)));
			$this->zwracaneKolumny = array();
		}

		if ($sortowanie != null)
		{
			foreach($sortowanie as $klucz => $wartosc)
			{
				$sortowanie[$klucz] = strtoupper($wartosc) == 'DESC' ? -1 : 1;
			}
			$zapytanie->sort($sortowanie);
		}

		if ($pager instanceof Pager)
		{
			$zapytanie->skip($pager->pierwszyNaStronie() - 1)
				->limit($pager->naStronie());
		}

		return $zapytanie->all();
	}

	public function iloscSzukaj(Array $kryteria = array())
	{
		return $this->createQuery($this->przetworzKryteria($kryteria))->count();
	}

	/**
	 * Ustawia zwracane kolumny wiersza
	 *
	 * @param array $kolumny Kolumny ktore powinny byc pobierane
	 *
	 * @return \Mandango\Repository
	 */
	public function zwracaTablice(Array $kolumny = array())
	{
		$this->zwracaneKolumny = $kolumny;
	}


	/**
	 * Przetwarza kryteria z naszego zapisu na zapis mandango
	 *
	 * @param Array $kryteria
	 *
	 * @return Array
	 */
	protected function przetworzKryteria(Array $kryteria)
	{
		foreach ($kryteria as $pole => $definicja)
		{
			if (is_array($definicja))
			{
				foreach ($definicja as $kryterium => $wartosc)
				{
					if (isset($this->mapowanieZapytan[$kryterium]))
					{
						$definicja[$this->mapowanieZapytan[$kryterium]] = $definicja[$kryterium];
						unset($definicja[$kryterium]);
					}
				}
			}

			$kryteria[$pole] = $definicja;
		}

		return $kryteria;
	}

	/**
	 * Zwraca nowy obiekt przynależny do danego repozytorium
	 * @param Array $wartosciInicjalizujace tablica z wartościami do zainicjalizowania dla obiektu
	 *
	 * @return \Mandango\Document
	 */
	public function pobierzNowyObiekt($wartosciInicjalizujace = array())
	{
		$nazwaKlasy = str_replace('Repository', '', get_class($this));
		
		return Cms::inst()->Baza(self::pobierzIdentyfikatorBazy())->pobierzMongo()->create($nazwaKlasy, $wartosciInicjalizujace);
	}
}
