<?php
namespace Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\Szablon;


/**
 * Zawiera mechanizmy do generowania wykresów, tabel sorterów
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class Raporty
{
	protected $dane = array();
	protected $nazwyPol = array();
	protected $typWykresu = '';
	protected $typWykresuModyfikowalny = false;
	protected $kolumnyWykresu = array();
	protected $typyKolumnTabeli = array();
	protected $filtry = array();
	protected $kolumnaWykresuDaty = '';
	protected $szablon;
	protected $tlumaczenia = array();
	protected $filtrDatyMin;
	protected $filtrDatyMax;


	public function __construct()
	{
		$this->filtrDatyMin = strtotime('2030-01-01');
		$this->filtrDatyMax = strtotime('1970-01-01');
	}
	public function ustawDane(Array $dane)
	{
		$this->dane = $dane;
	}

	public function ustawNazwyPol(Array $dane)
	{
		$this->nazwyPol = $dane;
	}

	public function ustawTypWykresu($typ)
	{
		$this->typWykresu = $typ;
	}

	public function ustawTypWykresuModyfikowalny($wartosc)
	{
		$this->typWykresuModyfikowalny = (bool) $wartosc;
	}

	public function ustawKolumnyWykresu(Array $kolumny)
	{
		$this->kolumnyWykresu = $kolumny;
	}

	public function ustawTypyKolumnTabeli(Array $typy)
	{
		$this->typyKolumnTabeli = $typy;
	}

	public function ustawFiltry(Array $filtry)
	{
		$this->filtry = $filtry;
	}

	public function ustawKolumnaWykresuDaty($kolumna)
	{
		$this->kolumnaWykresuDaty = $kolumna;
	}

	public function ustawSzablon($plikSzablonu)
	{
		$this->szablon = new Szablon($plikSzablonu);
	}

	public function ustawTlumaczenia(Array $dane)
	{
		$this->tlumaczenia = $dane;
	}

	public function generuj()
	{
		if ( ! ($this->szablon instanceof Szablon))
		{
			trigger_error('Brak poprawnego szablonu!');
			return null;
		}

		$this->wygenerujDane();

		$this->wygenerujWykres();

		$this->wygenerujFiltry();

		$this->wygenerujTabele();

		
		return $this->szablon->parsujBlok('wykres', array(
			'etykieta_licznik' => $this->tlumaczenia['etykieta_ilosc_wierszy'],
		));
	}

	protected function wygenerujKolumny()
	{
		foreach ($this->nazwyPol as $klucz => $wartosc)
		{
			$this->szablon->ustawBlok('wykres/kolumna', array(
				'etykieta' => $wartosc,
				'typ' => isset($this->typyKolumnTabeli[$klucz]) ? $this->typyKolumnTabeli[$klucz] : 'string',
			));
		}
	}

	protected function wygenerujDane()
	{
		$this->wygenerujKolumny();

		foreach($this->dane as $wiersz)
		{
			$this->szablon->ustawBlok('wykres/wiersz');

			foreach ($this->nazwyPol as $klucz => $wartosc)
			{
				$pos = strpos($klucz,'::');
				$kluczOrg = $klucz;
				if ($pos !== false)
				{
					$klucz = substr($klucz, 0, $pos);
				}
				$this->szablon->ustawBlok('wykres/wiersz/wartosc', array(
					'wartoscPola' => $this->parsujWartosc($wiersz[$klucz], isset($this->typyKolumnTabeli[$kluczOrg]) ? $this->typyKolumnTabeli[$kluczOrg] : 'string'),
				));

				if (isset($this->filtry[$klucz]) && $this->filtry[$klucz] == 'date')
				{
					$aktualnyCzas = strtotime($wiersz[$klucz]);

					if ($aktualnyCzas > $this->filtrDatyMax)
					{
						$this->filtrDatyMax = $aktualnyCzas;
					}

					if ($aktualnyCzas < $this->filtrDatyMin)
					{
						$this->filtrDatyMin = $aktualnyCzas;
					}
				}
			}

		}
	}

	protected function wygenerujWykres()
	{
		if ($this->typWykresu != '' && count($this->kolumnyWykresu) > 0)
		{
			$this->szablon->ustawBlok('wykres/chart', array(
				'typ' => $this->typWykresu,
			));

			if ($this->typWykresuModyfikowalny)
			{
				$this->szablon->ustawBlok('wykres/chartEdit', array(
					'etykieta_modyfikuj_wykres' => $this->tlumaczenia['etykieta_modyfikuj_wykres']
				));
			}

			foreach ($this->kolumnyWykresu as $kolumna)
			{
				$this->szablon->ustawBlok('wykres/chart/kolumna', array(
					'numerKolumny' => intval(array_search($kolumna, array_keys($this->nazwyPol))),
				));
			}

		}
	}

	protected function wygenerujFiltry()
	{
		$this->licznikFiltrow = 0;
		foreach ($this->filtry as $pole => $typ)
		{
			$typWykresu = '';
			switch (trim($typ))
			{
				case 'range': {
					$this->wygenerujFiltrRange($pole);
				}; break;

				case 'select': {
					$this->wygenerujFiltrSelect($pole);
				} break;

				case 'text': {
					$this->wygenerujFiltrText($pole);
				} break;

				case 'date': {
					$this->wygenerujFiltrDate($pole);
				} break;
			}
		}
	}

	protected function wygenerujFiltrRange($pole)
	{
		$this->szablon->ustawBlok('wykres/filtr', array(
			'id' => $this->licznikFiltrow + 1
			));

		$this->szablon->ustawBlok('wykres/filtr/przyciskiRange', array(
			'id' => $this->licznikFiltrow + 1,
			'licznik' => $this->licznikFiltrow,
			'etykietaOd' => $this->tlumaczenia['range_etykieta_od'],
			'etykietaDo' => $this->tlumaczenia['range_etykieta_do'],
			'etykietaUstaw' => $this->tlumaczenia['range_etykieta_ustaw'],
			'komunikat_wartosci_nieprawidlowe' => $this->tlumaczenia['komunikat_wartosci_nieprawidlowe'],
			));

		$this->szablon->ustawBlok('wykres/range', array(
			'id' => $this->licznikFiltrow + 1,
			'licznik' => $this->licznikFiltrow,
			'kolumna' => $this->nazwyPol[$pole],
			'pole' => $pole,
		));
		++$this->licznikFiltrow;
	}

	protected function wygenerujFiltrSelect($pole)
	{
		$this->szablon->ustawBlok('wykres/filtr', array(
			'id' => $this->licznikFiltrow + 1
			));

		$this->szablon->ustawBlok('wykres/select', array(
			'id' => $this->licznikFiltrow + 1,
			'licznik' => $this->licznikFiltrow,
			'kolumna' => $this->nazwyPol[$pole],
			'pole' => $pole,
		));
		++$this->licznikFiltrow;
	}

	protected function wygenerujFiltrText($pole)
	{
		$this->szablon->ustawBlok('wykres/filtr', array(
			'id' => $this->licznikFiltrow + 1
			));

		$this->szablon->ustawBlok('wykres/text', array(
			'id' => $this->licznikFiltrow + 1,
			'licznik' => $this->licznikFiltrow,
			'kolumna' => $this->nazwyPol[$pole],
			'pole' => $pole,
		));
		++$this->licznikFiltrow;
	}

	protected function wygenerujFiltrDate($pole)
	{
		$this->szablon->ustawBlok('wykres/date', array(
			'id' => $this->licznikFiltrow + 1,
			'licznik' => $this->licznikFiltrow,
			'etykieta' => $this->tlumaczenia['etykieta_filtr_daty'],
			'filtrujKolumne' => intval(array_search($pole, array_keys($this->nazwyPol))),
			'kolumnaWykresuDaty' => intval(array_search($this->kolumnaWykresuDaty, array_keys($this->nazwyPol))),
			'minimum' => date('Y-m-d', $this->filtrDatyMin),
			'maximum' => date('Y-m-d', $this->filtrDatyMax),
			'kolumna' => $this->nazwyPol[$pole],
			'pole' => $pole,
		));

		$this->szablon->ustawBlok('wykres/date/przyciskiDate', array(
			'id' => $this->licznikFiltrow + 1,
			'licznik' => $this->licznikFiltrow,
			'etykietaOd' => $this->tlumaczenia['range_etykieta_od'],
			'etykietaDo' => $this->tlumaczenia['range_etykieta_do'],
			'etykietaUstaw' => $this->tlumaczenia['range_etykieta_ustaw'],
			));

		++$this->licznikFiltrow;
	}

	protected function wygenerujTabele()
	{
		for ($i = 0; $i < count($this->nazwyPol); ++$i)
		{
			$this->szablon->ustawBlok('/wykres/kolumnaTab', array(
				'numerKolumny' => $i
			));
		}
	}

	protected function parsujWartosc($wartosc, $typ)
	{
		//$wartosc = str_replace(array('\'', '"'), array("'", '"'), $wartosc);

		if ($typ == 'number')
		{
			return floatval($wartosc);
		}
		if ($typ == 'date')
		{
			return ' new Date(\'' . $wartosc .'\')';
		}
		if ($typ == 'string')
		{
			return '\'' . $this->oczyscString($wartosc) . '\'';
		}
		if ($typ == 'boolean')
		{
			return ($wartosc) ? 'true' : 'false';
		}

		return $wartosc;
	}
	
	protected function oczyscString($str)
	{
		$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
		$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
		return str_replace($search, $replace, $str);
	}
}