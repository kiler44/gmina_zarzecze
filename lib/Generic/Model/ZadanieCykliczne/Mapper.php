<?php
namespace Generic\Model\ZadanieCykliczne;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Cms;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących zadania cykliczne.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\ZadanieCykliczne\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_zadania_cykliczne';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'aktywne' => 'aktywne',
		'data_rozpoczecia' => 'dataRozpoczecia',
		'data_zakonczenia' => 'dataZakonczenia',
		'minuty' => 'minuty',
		'godziny' => 'godziny',
		'dni' => 'dni',
		'miesiace' => 'miesiace',
		'dni_tygodnia' => 'dniTygodnia',
		'id_kategorii' => 'idKategorii',
		'kod_modulu' => 'kodModulu',
		'akcja' => 'akcja',
		'opis_zadania' => 'opisZadania',
		'dodawane_wielokrotnie' => 'dodawaneWielokrotnie',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id', 'id_projektu');



	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	public function pobierzDoWykonania()
	{
		$data = getdate();
		$dataPelna = date('Y-m-d H:i:s');

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND aktywne = true'
			. ' AND (data_rozpoczecia <= \'' . $dataPelna .'\' OR data_rozpoczecia IS NULL)'
			. ' AND (data_zakonczenia >= \'' . $dataPelna .'\' OR data_zakonczenia IS NULL)'
			. ' AND (minuty = \'' . $data['minutes'] .'\' OR minuty = \'*\')'
			. ' AND (godziny = \'' . $data['hours'] .'\' OR godziny = \'*\')'
			. ' AND (dni = \'' . $data['mday'] .'\' OR dni = \'*\')'
			. ' AND (miesiace = \'' . $data['mon'] .'\' OR miesiace = \'*\')'
			. ' AND (dni_tygodnia = \'' . $data['wday'] .'\' OR dni_tygodnia = \'*\')';

		$zadania = $this->pobierzWiele($sql);
		return $zadania;
	}



	public function pobierzDlaModulu($kodModulu, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_modulu = \'' . addslashes($kodModulu) .'\'';

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function pobierzWszystko(Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscWszystko()
	{
		$sql = 'SELECT  COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}


	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		if (isset($kryteria['dodawane_wielokrotnie']) && $kryteria['dodawane_wielokrotnie'] >= 0)
		{
			$sql .= ' AND dodawane_wielokrotnie = ' . intval($kryteria['dodawane_wielokrotnie']);
		}
		if (isset($kryteria['kod_modulu']) && $kryteria['kod_modulu'] != '')
		{
			$sql .= ' AND kod_modulu = \'' . addslashes($kryteria['kod_modulu']) .'\'';
		}
		if (isset($kryteria['akcja']) && $kryteria['akcja'] != '')
		{
			$sql .= ' AND akcja = \'' . addslashes($kryteria['akcja']) .'\'';
		}
		if (isset($kryteria['aktywne']) && $kryteria['aktywne'] != '')
		{
			if ($kryteriap['aktywne'])
			{
				$sql .= ' AND aktywne = true';
			}
			else
			{
				$sql .= ' AND aktywne = false';
			}
		}
		return $this->pobierzWiele($sql, $pager, $sorter);
	}


	public function iloscSzukaj($kryteria)
	{
		$sql = 'SELECT  COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		if (isset($kryteria['dodawane_wielokrotnie']) && $kryteria['dodawane_wielokrotnie'] >= 0)
		{
			$sql .= ' AND dodawane_wieokrotnie = ' . intval($kryteria['dodawane_wielokrotnie']);
		}

		return $this->pobierzWartosc($sql);

	}


	public function pobierzPrzedzialCzasowy($czasOd, $czasDo)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND ((data_rozpoczecia <= \''.$czasOd.'\' AND data_zakonczenia >= \''.$czasDo.'\') OR ( data_rozpoczecia IS NULL AND data_zakonczenia >= \''.$czasOd.'\') OR (data_zakonczenia IS NULL AND data_rozpoczecia <= \''.$czasDo.'\') OR ( data_rozpoczecia IS NULL AND data_zakonczenia IS NULL))'
			. ' AND aktywne = TRUE'
			;

		$dane = $this->pobierzWiele($sql);

		$daneWynikowe = array();

		$czasOd = new \DateTime($czasOd, new \DateTimeZone('Europe/Warsaw'));
		$czasDo = new \DateTime($czasDo, new \DateTimeZone('Europe/Warsaw'));
		$mapperMailing = Cms::inst()->dane()->Mailing();
		foreach ($dane as $zadanie)
		{
			if ($zadanie['kod_modulu'] == 'Mailing')
			{
				//dla mailingow pobranie daty rozpoczecia i zakonczenia
				$mailing = $mapperMailing
					->zwracaTablice(array('data_wysylki', 'data_zakonczenia'))
					->pobierzPoIdZadaniaCron($zadanie['id']);

				if (((strtotime($mailing['data_wysylki']) >= $czasOd->format('U') && strtotime($mailing['data_wysylki']) <= $czasDo->format('U')) || (strtotime($mailing['data_zakonczenia']) >= $czasOd->format('U') && strtotime($mailing['data_zakonczenia']) <= $czasDo->format('U'))) || (strtotime($mailing['data_wysylki']) < $czasOd->format('U') && strtotime($mailing['data_zakonczenia']) > $czasDo->format('U')))
				{
					$zadanie['data_zakonczenia'] = $mailing['data_zakonczenia'];
					$daneWynikowe[] = $zadanie;
				}
			}
			else
			{
				//zmienne do obliczenia czasu wykonania zadania
				$czasOd2 = new \DateTime($czasOd->format('Y-m-d H:i:s'), new \DateTimeZone('Europe/Warsaw'));
				$min = $zadanie['minuty'] == '*' ? $czasOd2->format('i') : $zadanie['minuty'];
				//godzina zawsze + 1 ponieważ mamy minimalny zakres +/- 1h
				$czasOd2->modify('+ 1 hour');
				$godz = $zadanie['godziny'] == '*' ? $czasOd2->format('H') : $zadanie['godziny'];
				//jesli mamy wiecej niz 1 dzien to sprawdzamy czy wykona sie w pierwszym, czy w nast.
				if ($czasDo->format('j') != $czasOd2->format('j') && $czasDo->format('G') >= $godz)
				{
					$czasOd2->modify('+ 1 day');
				}
				$dzien = $zadanie['dni'] == '*' ? $czasOd2->format('d') : $zadanie['dni'];
				//jesli daty zawieraja sie w wiecej niz 1 miesiacu
				if ($czasDo->format('n') > $czasOd2->format('n') && $czasDo->format('j') >= $dzien)
				{
					$czasOd2->modify('+ 1 month');
				}
				$miesiac = $zadanie['miesiace'] == '*' ? $czasOd2->format('m') : $zadanie['miesiace'];
				$rok = $czasOd2->format('Y');

				//jeśli ustawiony jest dzień tyg to ustawiamy datę w tym dniu
				if ($zadanie['dni_tygodnia'] != '*')
				{
					$czasOd2->modify(($zadanie['dni_tygodnia'] - $czasOd2->format('w') > 0?'+ ':'').($zadanie['dni_tygodnia'] - $czasOd2->format('w')).' day');
					//sprawdzenie czy nie wyskoczylismy poza dolny i gorny zakres
					if ($czasOd2->format('U') < $czasOd->format('U'))
					{//próbujemy trafić w datę z aktualnego zakrestu
						$czasOd2->modify('+ 7 day');
					}
					elseif ($czasDo->format('U') > $czasDo->format('U'))
					{//próbujemy trafić w datę z aktualnego zakrestu
						$czasOd2->modify('- 7 day');
					}

					$dzien = $czasOd2->format('d');
					$miesiac = $czasOd2->format('m');
					$rok = $czasOd2->format('Y');
				}

				$dataZadania = mktime($godz, $min, 0, $miesiac, $dzien, $rok);
				if ($dataZadania <= $czasDo->format('U') && $dataZadania >= $czasOd->format('U'))
				{
					$daneWynikowe[] = $zadanie;
				}
			}
		}

		return $daneWynikowe;
	}

}
