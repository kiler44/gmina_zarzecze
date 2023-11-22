<?php
namespace Generic\Model\Drzewo;
use Generic\Biblioteka\BazaWyjatek;


/**
 * Klasa obslugujaca zapis i odczyt struktury drzewiastej w bazie.
 * @author Krzysztof Lesiczka
 * @package dane
 */

class Obiekt
{

	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela;



	/**
	 * Nazwy pol okreslajace klucz glowny tabeli.
	 */
	protected $tabela_id;
	protected $tabela_id_projektu;
	//protected $tabela_kod_jezyka;



	/**
	 * Nazwa pola okreslajaca identyfikator lewego rekordu.
	 */
	protected $tabela_lewy;



	/**
	 * Nazwa pola okreslajaca identyfikator prawego rekordu.
	 */
	protected $tabela_prawy;



	/**
	 * Nazwa pola okreslajaca poziom zaglebienia.
	 */
	protected $tabela_poziom;



	protected $id_projektu;
	protected $kod_jezyka;

	/**
	 * Konstruktor ustawia zmiene tabeli kategorii
	 *
	 * @param Baza $baza Obiekt polaczenia z baza danych
	 * @param array $dane Dodatkowe dane wiersza w tabeli (jezeli sa): array('nazwa_pola' => 'wartosc', ...)
	 * @param integer $id_projektu Id projektu
	 * @param string $kod_jezyka Kod jezyka
	 */
	function __construct($baza, $tabela, $id_projektu)//, $kod_jezyka)
	{
		$this->baza = $baza;
		$this->tabela = $tabela;
		$this->tabela_id = 'id';
		$this->tabela_id_projektu = 'id_projektu';
		$this->tabela_kod_jezyka = 'kod_jezyka';
		$this->tabela_lewy = 'lewy';
		$this->tabela_prawy = 'prawy';
		$this->tabela_poziom = 'poziom';
		$this->id_projektu = $id_projektu;
		//$this->kod_jezyka = $kod_jezyka;
	}



	/**
	 * Czysci drzewo w bazie danych i ostawia wartosci startowe
	 *
	 * @param array $dane Dodatkowe dane wiersza w tabeli (jezeli sa): array('nazwa_pola' => 'wartosc', ...)
	 * @return bool True jezeli sukces False w przeciwnym wypadku
	 */
	function czysc($dane = array())
	{
		try
		{
			$this->baza->transakcjaStart();

			$sql = 'DELETE FROM ' . $this->tabela
				. ' WHERE ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			$this->baza->zapytanie($sql);

			$nazwy_pol = '';
			$wartosci_pol = '';
			if (!empty($dane))
			{
				$nazwy_pol .= implode(', ', array_keys($dane)) . ', ';
				$wartosci_pol .= '\'' . implode('\', \'', array_values($dane)) . '\', ';
			}

			$nazwy_pol .= $this->tabela_lewy . ', ' . $this->tabela_prawy . ', ' . $this->tabela_poziom;

			$wartosci_pol .= '1, 2, 0';

			$sql = 'INSERT INTO ' . $this->tabela . ' (' . $this->tabela_id . ', ' . $nazwy_pol . ') VALUES (' . $this->pobierzId() . ', ' . $wartosci_pol . ')';

			$this->baza->zapytanie($sql);

			$this->baza->transakcjaPotwierdz();

			return true;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();

			return false;
		}
	}



	/**
	 * Zwraca id lewego, prawego i poziom dla kategorii i podanym id.
	 *
	 * @param integer $id id kategorii
	 * @return array lewy, prawy, poziom
	 */
	function info($id)
	{
		try
		{
			$sql = 'SELECT ' . $this->tabela_lewy . ', ' . $this->tabela_prawy . ', ' . $this->tabela_poziom
				. ' FROM ' . $this->tabela
				. ' WHERE ' . $this->tabela_id . ' = ' .intval($id)
				. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';

			$this->baza->zapytanie($sql);

			if ($dane = $this->baza->pobierzWynik())
			{
				return array($dane[$this->tabela_lewy], $dane[$this->tabela_prawy], $dane[$this->tabela_poziom]);
			}

			return false;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}




	/**
	 * Zwraca dane rodzica kategorii o podanym id.
	 *
	 * @param integer $id_kategorii id kategorii
	 * @param array $warunek Tablica ze struktura warunku: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), itd. gdzie klucz - warunek (AND, OR, itd.), wartosc - kolejny warunek
	 * @return array tablica z danymi rodzica
	 */
	function pobierzRodzica($id_kategorii, $warunek = '')
	{
		try
		{
			$info = $this->info($id_kategorii);

			if (false === $info)
			{
				return false;
			}

			if (!empty($warunek))
			{
				$warunek .= ' AND ' . $this->baza->sqlWhere($warunek);
			}

			list($lewyId, $prawyId, $poziom) = $info;

			$poziom--;

			$sql = 'SELECT * FROM ' . $this->tabela
				. ' WHERE ' . $this->tabela_lewy . ' < ' . $lewyId
				. ' AND ' . $this->tabela_prawy . ' > ' . $prawyId
				. ' AND ' . $this->tabela_poziom . ' = ' . $poziom
				. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\''
				. $warunek
				. ' ORDER BY ' . $this->tabela_lewy;

			$this->baza->zapytanie($sql);

			return $this->baza->pobierzWynik();
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}

	}



	/**
	 * Wstawia nowy element do drzewa jako galaz elementu o podanym id.
	 *
	 * @param integer $id Id elementu pod ktory wstawiamy
	 * @param array $warunek Tablica ze struktura dodatkowego warunku: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), itd. klucz jest operatorem (AND, OR, itd.), a wartosc(i) trescia warunku
	 * @param array $dane Dodatkowe dane wiersza w tabeli (if jezeli sa): array('nazwa_pola' => 'wartosc', ...)
	 * @return integer Id wstawianego elementu
	 */
	function wstawPod($id, $warunek = '', $dane = array())
	{
		$info = $this->info($id);

		if (false === $info)
		{
			return false;
		}

		list($lewyId, $prawyId, $poziom) = $info;

		$dane[$this->tabela_lewy] = $prawyId;
		$dane[$this->tabela_prawy] = ($prawyId + 1);
		$dane[$this->tabela_poziom] = ($poziom + 1);

		try
		{
			$this->baza->transakcjaStart();

			$sql = 'UPDATE ' . $this->tabela . ' SET '
				. $this->tabela_lewy . '= CASE
					WHEN ' . $this->tabela_lewy . '>' . $prawyId
				. ' THEN ' . $this->tabela_lewy . '+2
					ELSE ' . $this->tabela_lewy . ' END, '
				. $this->tabela_prawy . '= CASE
					WHEN ' . $this->tabela_prawy . '>=' . $prawyId
				. ' THEN ' . $this->tabela_prawy . '+2
					ELSE ' . $this->tabela_prawy . ' END '
				. ' WHERE ' . $this->tabela_prawy . '>=' . $prawyId
				. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';

			if (!empty($warunek))
			{
				$sql .= $this->baza->sqlWhere($warunek);
			}

			$this->baza->zapytanie($sql);

			$dane[$this->tabela_id] = $this->pobierzId();

			$sql = $this->baza->sqlInsert($this->tabela, $dane);
			$this->baza->zapytanie($sql);

			$this->baza->transakcjaPotwierdz();

			return $dane[$this->tabela_id];
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}



	/**
	 * Wstawia nowy element drzewa obok elementu o podanym id.
	 *
	 * @param integer $id Id elementu obok ktorego wstawiamy
	 * @param array $warunek Tablica ze struktura dodatkowego warunku: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), itd. klucz jest operatorem (AND, OR, itd.), a wartosc(i) trescia warunku
	 * @param array $dane Dodatkowe dane wiersza w tabeli (if jezeli sa): array('nazwa_pola' => 'wartosc', ...)
	 * @return integer Id wstawianego elementu
	 */
	function wstawObok($id, $warunek = '', $dane = array())
	{
		try
		{
			$this->baza->transakcjaStart();

			$info = $this->info($id);

			if (false === $info)
			{
				return false;
			}

			list($lewyId, $prawyId, $poziom) = $info;

			$dane[$this->tabela_lewy] = ($prawyId + 1);
			$dane[$this->tabela_prawy] = ($prawyId + 2);
			$dane[$this->tabela_poziom] = ($poziom);

			$sql = 'UPDATE ' . $this->tabela . ' SET '
				. $this->tabela_lewy . ' = CASE
					WHEN ' . $this->tabela_lewy . ' > ' . $prawyId
				. ' THEN ' . $this->tabela_lewy . ' + 2
					ELSE ' . $this->tabela_lewy . ' END, '
				. $this->tabela_prawy . ' = CASE
					WHEN ' . $this->tabela_prawy . '> ' . $prawyId
				. ' THEN ' . $this->tabela_prawy . ' + 2
					ELSE ' . $this->tabela_prawy . ' END, '
				. ' WHERE ' . $this->tabela_prawy . ' > ' . $prawyId
				. ' AND ' . $this->tabela_id_projektu . ' = ' . $dane['id_projektu'];
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $dane['kod_jezyka'] . '\'';

			if (!empty($warunek))
			{
				$sql .= $this->baza->sqlWhere($warunek);
			}
			$this->baza->zapytanie($sql);

			$dane[$this->tabela_id] = $this->pobierzId();
			$sql = $this->baza->sqlInsert($this->tabela, $dane);

			if (!empty($sql))
			{
				$this->baza->zapytanie($sql);
			}

			$this->baza->transakcjaPotwierdz();

			return $dane[$this->tabela_id];
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}


	/**
	 * Przenosi element wraz z podleglymi do rodzica o podanym id.
	 *
	 * @param integer $id Id elementu
	 * @param integer $idNowegoRodzica Id nowego rodzica
	 * @param array $warunek Tablica ze struktura dodatkowego warunku: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), itd. klucz jest operatorem (AND, OR, itd.), a wartosc(i) trescia warunku
	 * @return bool True jezeli sukces False w przeciwnym wypadku
	 */
	function przeniesWszystkie($id, $idNowegoRodzica, $warunek = '')
	{
		try
		{
			$info = $this->info($id);

			if (false === $info)
			{
				return false;
			}

			list($lewyId, $prawyId, $poziom) = $info;

			$info = $this->info($idNowegoRodzica);

			if (false === $info)
			{
				return false;
			}

			list($lewyIdRodzic, $prawyIdRodzic, $poziomRodzic) = $info;

			if ($id == $idNowegoRodzica || $lewyId == $lewyIdRodzic || ($lewyIdRodzic >= $lewyId && $lewyIdRodzic <= $prawyId) || ($poziom == $poziomRodzic+1 && $lewyId > $lewyIdRodzic && $prawyId < $prawyIdRodzic))
			{
				return false;
			}

			if (!empty($warunek))
			{
				$warunek = $this->baza->sqlWhere($warunek);
			}

			if ($lewyIdRodzic < $lewyId && $prawyIdRodzic > $prawyId && $poziomRodzic < $poziom - 1)
			{
				$sql = 'UPDATE ' . $this->tabela . ' SET '
					. $this->tabela_poziom . ' = CASE
						WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
					. ' THEN ' . $this->tabela_poziom.sprintf('%+d', -($poziom-1)+$poziomRodzic)
					. ' ELSE ' . $this->tabela_poziom . ' END, '
					. $this->tabela_prawy . ' = CASE
						WHEN ' . $this->tabela_prawy . ' BETWEEN ' . ($prawyId+1) . ' AND ' . ($prawyIdRodzic-1)
					. ' THEN ' . $this->tabela_prawy . ' - ' . ($prawyId-$lewyId+1)
					. ' WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
					. ' THEN ' . $this->tabela_prawy . ' + ' . ((($prawyIdRodzic-$prawyId-$poziom+$poziomRodzic)/2)*2+$poziom-$poziomRodzic-1)
					. ' ELSE ' . $this->tabela_prawy . ' END, '
					. $this->tabela_lewy . ' = CASE
						WHEN ' . $this->tabela_lewy . ' BETWEEN ' . ($prawyId+1) . ' AND ' .($prawyIdRodzic-1)
					. ' THEN ' . $this->tabela_lewy . ' - ' . ($prawyId-$lewyId+1)
					. ' WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
					. ' THEN ' . $this->tabela_lewy . ' + ' . ((($prawyIdRodzic-$prawyId-$poziom+$poziomRodzic)/2)*2+$poziom-$poziomRodzic-1)
					. ' ELSE ' . $this->tabela_lewy . ' END '
					. ' WHERE ' . $this->tabela_lewy . ' BETWEEN ' .($lewyIdRodzic+1) . ' AND ' .($prawyIdRodzic-1)
					. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
					//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			}
			elseif($lewyIdRodzic < $lewyId)
			{
				$sql = 'UPDATE ' . $this->tabela . ' SET '
					. $this->tabela_poziom . ' = CASE
						WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
					. ' THEN ' . $this->tabela_poziom.sprintf('%+d', -($poziom-1)+$poziomRodzic)
					. ' ELSE ' . $this->tabela_poziom . ' END, '
					. $this->tabela_lewy . ' = CASE
						WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $prawyIdRodzic . ' AND ' .($lewyId-1)
					. ' THEN ' . $this->tabela_lewy . ' + ' . ($prawyId-$lewyId+1)
					. ' WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
					. ' THEN ' . $this->tabela_lewy . ' - ' . ($lewyId-$prawyIdRodzic)
					. ' ELSE ' . $this->tabela_lewy . ' END, '
					. $this->tabela_prawy . ' = CASE
						WHEN ' . $this->tabela_prawy . ' BETWEEN ' . $prawyIdRodzic . ' AND ' . $lewyId
					. ' THEN ' . $this->tabela_prawy . ' + ' . ($prawyId-$lewyId+1)
					. ' WHEN ' . $this->tabela_prawy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
					. ' THEN ' . $this->tabela_prawy . ' - ' . ($lewyId-$prawyIdRodzic)
					. ' ELSE ' . $this->tabela_prawy . ' END '
					. ' WHERE (' . $this->tabela_lewy . ' BETWEEN ' . $lewyIdRodzic . ' AND ' . $prawyId. ' '
					. ' OR ' . $this->tabela_prawy . ' BETWEEN ' . $lewyIdRodzic . ' AND ' . $prawyId . ')'
					. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
					//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			}
			else
			{
				$sql = 'UPDATE ' . $this->tabela . ' SET '
					. $this->tabela_poziom . ' = CASE
						WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
					. ' THEN ' . $this->tabela_poziom.sprintf('%+d', -($poziom-1)+$poziomRodzic)
					. ' ELSE ' . $this->tabela_poziom . ' END, '
					. $this->tabela_lewy . ' = CASE
						WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $prawyId . ' AND ' . $prawyIdRodzic
					. ' THEN ' . $this->tabela_lewy . ' - ' . ($prawyId-$lewyId+1)
					. ' WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
					. ' THEN ' . $this->tabela_lewy . ' + ' . ($prawyIdRodzic-1-$prawyId)
					. ' ELSE ' . $this->tabela_lewy . ' END, '
					. $this->tabela_prawy . ' = CASE
						WHEN ' . $this->tabela_prawy . ' BETWEEN ' .($prawyId+1) . ' AND ' .($prawyIdRodzic-1)
					. ' THEN ' . $this->tabela_prawy . '-' . ($prawyId-$lewyId+1)
					. ' WHEN ' . $this->tabela_prawy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
					. ' THEN ' . $this->tabela_prawy . ' + ' . ($prawyIdRodzic-1-$prawyId)
					. ' ELSE ' . $this->tabela_prawy . ' END '
					. ' WHERE (' . $this->tabela_lewy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyIdRodzic
					. ' OR ' . $this->tabela_prawy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyIdRodzic . ')'
					. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
					//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			}

			if (!empty($warunek))
			{
				$sql .= ' AND ' . $this->baza->sqlWhere($warunek);
			}

			$this->baza->transakcjaStart();

			$this->baza->zapytanie($sql);

			$this->baza->transakcjaPotwierdz();

			return true;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}


	/**
	 * Zamienia dwa elementy pozycjami.
	 *
	 * @param integer $id1 Id pierwszego elementu
	 * @param integer $id2 Id drugiego elementu
	 * @return bool True jezeli sukces False w przeciwnym wypadku
	 */
	function zamienPozycje($id1, $id2)
	{
		try
		{
			$info = $this->info($id1);

			if (false === $info)
			{
				return false;
			}

			list($lewyId1, $prawyId1, $poziom1) = $info;

			$info = $this->info($id2);

			if (false === $info)
			{
				return false;
			}

			list($lewyId2, $prawyId2, $poziom2) = $info;

			$this->baza->transakcjaStart();

			$sql = 'UPDATE ' . $this->tabela . ' SET '
				. $this->tabela_lewy . ' = ' . $lewyId2 .', '
				. $this->tabela_prawy . ' = ' . $prawyId2 .', '
				. $this->tabela_poziom . ' = ' . $poziom2
				. ' WHERE ' . $this->tabela_id . ' = ' .(int)$id1
				. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			$this->baza->zapytanie($sql);

			$sql = 'UPDATE ' . $this->tabela . ' SET '
				. $this->tabela_lewy . ' = ' . $lewyId1 .', '
				. $this->tabela_prawy . ' = ' . $prawyId1 .', '
				. $this->tabela_poziom . ' = ' . $poziom1
				. ' WHERE ' . $this->tabela_id . ' = ' .(int)$id2
				. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			$this->baza->zapytanie($sql);

			$this->baza->transakcjaPotwierdz();

			return true;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}



	/**
	 * Ustawia element o $id1 wraz z jego dziecmi 'przed' lub 'po' elemencie o $id2.
	 * Obydwa elementy musza miec tego samego rodzica i byc na tym samym poziomie.
	 *
	 * @param integer $id1 Id pierwszego elementu
	 * @param integer $id2 Id drugiego elementu
	 * @param string $ustawienie Ustawienie 'przed' lub 'po' $id2
	 * @param array $warunek Tablica ze struktura dodatkowego warunku: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), itd. klucz jest operatorem (AND, OR, itd.), a wartosc(i) trescia warunku
	 * @return bool True jezeli sukces False w przeciwnym wypadku
	 */
	function zamienPozycjeWszystkich($id1, $id2, $ustawienie = 'po', $warunek = '')
	{
		try
		{
			$info = $this->info($id1);

			list($lewyId1, $prawyId1, $poziom1) = $info;

			$info = $this->info($id2);

			list($lewyId2, $prawyId2, $poziom2) = $info;

			if ($poziom1 <> $poziom2)
			{
				return false;
			}

			if ('przed' == $ustawienie)
			{
				if ($lewyId1 > $lewyId2)
				{
					$sql = 'UPDATE ' . $this->tabela . ' SET '
						. $this->tabela_prawy . ' = CASE
							WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId1 . ' AND ' . $prawyId1
						. ' THEN ' . $this->tabela_prawy . ' - ' . ($lewyId1 - $lewyId2)
						. ' WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId2 . ' AND ' . ($lewyId1 - 1)
						. ' THEN ' . $this->tabela_prawy . ' + ' . ($prawyId1 - $lewyId1 + 1)
						. ' ELSE ' . $this->tabela_prawy . ' END, '
						. $this->tabela_lewy . ' = CASE
							WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId1 . ' AND ' . $prawyId1
						. ' THEN ' . $this->tabela_lewy . ' - ' . ($lewyId1 - $lewyId2)
						. ' WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId2 . ' AND ' . ($lewyId1 - 1)
						. ' THEN ' . $this->tabela_lewy . ' + ' . ($prawyId1 - $lewyId1 + 1)
						. ' ELSE ' . $this->tabela_lewy . ' END '
						. ' WHERE ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId2 . ' AND ' . $prawyId1
						. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
						//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
				}
				else
				{
					$sql = 'UPDATE ' . $this->tabela . ' SET '
						. $this->tabela_prawy . ' = CASE
							WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId1 . ' AND ' . $prawyId1
						. ' THEN ' . $this->tabela_prawy . ' + ' . (($lewyId2 - $lewyId1) - ($prawyId1 - $lewyId1 + 1))
						. ' WHEN ' . $this->tabela_lewy . ' BETWEEN ' . ($prawyId1 + 1) . ' AND ' . ($lewyId2 - 1)
						. ' THEN ' . $this->tabela_prawy . ' - ' . ($prawyId1 - $lewyId1 + 1)
						. ' ELSE ' . $this->tabela_prawy . ' END, '
						. $this->tabela_lewy . ' = CASE
							WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId1 . ' AND ' . $prawyId1
						. ' THEN ' . $this->tabela_lewy . ' + ' . (($lewyId2 - $lewyId1) - ($prawyId1 - $lewyId1 + 1))
						. ' WHEN ' . $this->tabela_lewy . ' BETWEEN ' . ($prawyId1 + 1) . ' AND ' . ($lewyId2 - 1)
						. ' THEN ' . $this->tabela_lewy . ' - ' . ($prawyId1 - $lewyId1 + 1)
						. ' ELSE ' . $this->tabela_lewy . ' END '
						. ' WHERE ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId1 . ' AND ' . ($lewyId2 - 1)
						. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
						//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
				}
			}

			if ('po' == $ustawienie)
			{
				if ($lewyId1 > $lewyId2)
				{
					$sql = 'UPDATE ' . $this->tabela . ' SET '
						. $this->tabela_prawy . ' = CASE
							WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId1 . ' AND ' . $prawyId1
						. ' THEN ' . $this->tabela_prawy . ' - ' . ($lewyId1 - $lewyId2 - ($prawyId2 - $lewyId2 + 1))
						. ' WHEN ' . $this->tabela_lewy . ' BETWEEN ' . ($prawyId2 + 1) . ' AND ' . ($lewyId1 - 1)
						. ' THEN ' . $this->tabela_prawy . ' + ' . ($prawyId1 - $lewyId1 + 1)
						. ' ELSE ' . $this->tabela_prawy . ' END, '
						. $this->tabela_lewy . ' = CASE
							WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId1 . ' AND ' . $prawyId1
						. ' THEN ' . $this->tabela_lewy . ' - ' . ($lewyId1 - $lewyId2 - ($prawyId2 - $lewyId2 + 1))
						. ' WHEN ' . $this->tabela_lewy . ' BETWEEN ' . ($prawyId2 + 1) . ' AND ' . ($lewyId1 - 1)
						. ' THEN ' . $this->tabela_lewy . ' + ' . ($prawyId1 - $lewyId1 + 1)
						. ' ELSE ' . $this->tabela_lewy . ' END '
						. ' WHERE ' . $this->tabela_lewy . ' BETWEEN ' . ($prawyId2 + 1) . ' AND ' . $prawyId1
						. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
						//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
				}
				else
				{
					$sql = 'UPDATE ' . $this->tabela . ' SET '
					. $this->tabela_prawy . ' = CASE
						WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId1 . ' AND ' . $prawyId1
					. ' THEN ' . $this->tabela_prawy . ' + ' . ($prawyId2 - $prawyId1)
					. ' WHEN ' . $this->tabela_lewy . ' BETWEEN ' . ($prawyId1 + 1) . ' AND ' . $prawyId2
					. ' THEN ' . $this->tabela_prawy . ' - ' . ($prawyId1 - $lewyId1 + 1)
					. ' ELSE ' . $this->tabela_prawy . ' END, '
					. $this->tabela_lewy . ' = CASE
						WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId1 . ' AND ' . $prawyId1
					. ' THEN ' . $this->tabela_lewy . ' + ' . ($prawyId2 - $prawyId1)
					. ' WHEN ' . $this->tabela_lewy . ' BETWEEN ' . ($prawyId1 + 1) . ' AND ' . $prawyId2
					. ' THEN ' . $this->tabela_lewy . ' - ' . ($prawyId1 - $lewyId1 + 1)
					. ' ELSE ' . $this->tabela_lewy . ' END '
					. ' WHERE ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId1 . ' AND ' . $prawyId2
					. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
					//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
				}
			}

			if (!empty($warunek))
			{
				$warunek = $this->baza->sqlWhere($warunek);
			}

			$sql .= $warunek;

			$this->baza->transakcjaStart();

			$this->baza->zapytanie($sql);

			$this->baza->transakcjaPotwierdz();

			return true;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}



	/**
	 * Usuwa element o podanym $id bez usuwania jego dzieci.
	 *
	 * @param integer $id Id elementu
	 * @param array $warunek Tablica ze struktura dodatkowego warunku: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), itd. klucz jest operatorem (AND, OR, itd.), a wartosc(i) trescia warunku
	 * @return bool True jezeli sukces False w przeciwnym wypadku
	 */
	function usun($id, $warunek = '')
	{
		try
		{
			if ($id < 2)
			{
				return false;
			}
			$info = $this->info($id);

			if (false === $info)
			{
				return false;
			}

			list($lewyId, $prawyId) = $info;

			$this->baza->transakcjaStart();

			$sql = 'DELETE FROM ' . $this->tabela
				. ' WHERE ' . $this->tabela_id . ' = ' .(int)$id
				. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			$this->baza->zapytanie($sql);

			$sql = 'UPDATE ' . $this->tabela . ' SET '
				. $this->tabela_poziom . ' = CASE
					WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
				. ' THEN ' . $this->tabela_poziom . ' - 1 ELSE ' . $this->tabela_poziom . ' END, '
				. $this->tabela_prawy . ' = CASE
					WHEN ' . $this->tabela_prawy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
				. ' THEN ' . $this->tabela_prawy . ' - 1 '
				. ' WHEN ' . $this->tabela_prawy . ' > ' . $prawyId
				. ' THEN ' . $this->tabela_prawy . ' - 2
					ELSE ' . $this->tabela_prawy . ' END, '
				. $this->tabela_lewy . ' = CASE
					WHEN ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
				. ' THEN ' . $this->tabela_lewy . ' - 1 '
				. ' WHEN ' . $this->tabela_lewy . ' > ' . $prawyId
				. ' THEN ' . $this->tabela_lewy . ' - 2
					ELSE ' . $this->tabela_lewy . ' END '
				. ' WHERE ' . $this->tabela_prawy . ' > ' . $lewyId
				. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';

			if (!empty($warunek))
			{
				$sql .= $this->baza->sqlWhere($warunek);
			}

			$this->baza->zapytanie($sql);

			$this->baza->transakcjaPotwierdz();

			return true;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}


	/**
	 * Usuwa element o podanym $id wraz z wszystkimi jego dziecmi.
	 *
	 * @param integer $id Id elementu
	 * @param array $warunek Tablica ze struktura dodatkowego warunku: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), itd. klucz jest operatorem (AND, OR, itd.), a wartosc(i) trescia warunku
	 * @return bool True jezeli sukces False w przeciwnym wypadku
	 */
	function usunzDziecmi($id, $warunek = '')
	{
		try
		{
			if ($id < 2)
			{
				return false;
			}
			$info = $this->info($id);

			if (false === $info)
			{
				return false;
			}

			list($lewyId, $prawyId) = $info;

			$this->baza->transakcjaStart();

			$sql = 'DELETE FROM ' . $this->tabela
				. ' WHERE ' . $this->tabela_lewy . ' BETWEEN ' . $lewyId . ' AND ' . $prawyId
				. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			$this->baza->zapytanie($sql);

			$deltaId = (($prawyId - $lewyId) + 1);

			$sql = 'UPDATE ' . $this->tabela . ' SET '
				. $this->tabela_lewy . ' = CASE
					WHEN ' . $this->tabela_lewy . ' > ' . $lewyId
				. ' THEN ' . $this->tabela_lewy . ' - ' . $deltaId
				. ' ELSE ' . $this->tabela_lewy . ' END, '
				. $this->tabela_prawy . ' = CASE
					WHEN ' . $this->tabela_prawy . ' > ' . $lewyId
				. ' THEN ' . $this->tabela_prawy . ' - ' . $deltaId
				. ' ELSE ' . $this->tabela_prawy . ' END '
				. ' WHERE ' . $this->tabela_prawy . ' > ' . $prawyId
				. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';

			if (!empty($warunek))
			{
				$sql .= $this->baza->sqlWhere($warunek);
			}

			$this->baza->zapytanie($sql);

			$this->baza->transakcjaPotwierdz();

			return true;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}



	/**
	 * Zwraca pelne drzewo z ementami posortowanymi od lewego
	 *
	 * @param array $pola Pobierane pola: array('nazwa_pola1', 'nazwa_pola2', itd.)
	 * @param array $warunek Tablica ze struktura dodatkowego warunku: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), itd. klucz jest operatorem (AND, OR, itd.), a wartosc(i) trescia warunku
	 * @return array tablica z posortowanymi elementami
	 */
	function pobierzDrzewo($pola = null, $warunek = '')
	{
		try
		{
			if (is_array($pola))
			{
				$pola = implode(', ', $pola);
			}
			else
			{
				$pola = '*';
			}

			$sql = 'SELECT ' . $pola . ' FROM ' . $this->tabela
				. ' WHERE ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			if (!empty($warunek))
			{
				$sql .= ' AND ' . $this->baza->sqlWhere($warunek);
			}
			$sql .= ' ORDER BY ' . $this->tabela_lewy;
			$this->baza->zapytanie($sql);

			$wyniki = array();

			while ($wiersz = $this->baza->pobierzWynik())
			{
				$wyniki[] = $wiersz;
			}

			return (count($wyniki) > 0) ? $wyniki : false;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}


	/**
	 * Zwraca galaz z wszystkimi ementami podleglymi zaczynajac od elementu o podanym $id.
	 *
	 * @param integer $id Id elementu
	 * @param array $pola Pobierane pola: array('nazwa_pola1', 'nazwa_pola2', itd.)
	 * @param array $warunek Tablica ze struktura dodatkowego warunku: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), itd. klucz jest operatorem (AND, OR, itd.), a wartosc(i) trescia warunku
	 * @return array tablica z posortowanymi elementami
	 */
	function pobierzGalaz($id, $pola = null, $warunek = '')
	{
		try
		{
			if (is_array($pola))
			{
				$pola = 'A.' . implode(', A.', $pola);
			}
			else
			{
				$pola = 'A.*';
			}

			$sql = 'SELECT ' . $pola /*. ', CASE
					WHEN A.' . $this->tabela_lewy . ' + 1 < A.' . $this->tabela_prawy . ' THEN 1 ELSE 0 END AS nflag'
			*/	. ' FROM ' . $this->tabela . ' A, ' . $this->tabela . ' B '
				. ' WHERE B.' . $this->tabela_id . ' = ' .(int)$id
				. ' AND A.' . $this->tabela_lewy . ' >= B.' . $this->tabela_lewy
				. ' AND A.' . $this->tabela_prawy . ' <= B.' . $this->tabela_prawy
				. ' AND A.' . $this->tabela_id_projektu . ' = ' . $this->id_projektu
				//. ' AND A.' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\''
				. ' AND B.' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND B.' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			if (!empty($warunek))
			{
				$sql .= ' AND ' . $this->baza->sqlWhere($warunek, 'A.');
			}
			$sql .= ' ORDER BY A.' . $this->tabela_lewy;

			$this->baza->zapytanie($sql);

			$wyniki = array();

			while ($wiersz = $this->baza->pobierzWynik())
			{
				//unset($wiersz['nflag']);
				$wyniki[] = $wiersz;
			}

			return (count($wyniki) > 0) ? $wyniki : false;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}



	/**
	 * Zwraca wszystkich rodzicow elementu o podanym $id.
	 *
	 * @param integer $id Id elementu
	 * @param array $pola Pobierane pola: array('nazwa_pola1', 'nazwa_pola2', itd.)
	 * @param array $warunek Tablica ze struktura dodatkowego warunku: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), itd. klucz jest operatorem (AND, OR, itd.), a wartosc(i) trescia warunku
	 * @return array tablica z posortowanymi elementami
	 */
	function pobierzSciezke($id, $pola = null, $warunek = '')
	{
		try
		{
			if (is_array($pola))
			{
				$pola = 'A.' . implode(', A.', $pola);
			}
			else
			{
				$pola = 'A.*';
			}

			$sql = 'SELECT ' . $pola /*. ', CASE
					//WHEN A.' . $this->tabela_lewy . ' + 1 < A.' . $this->tabela_prawy . ' THEN 1 ELSE 0 END AS nflag '
			*/	. ' FROM ' . $this->tabela . ' A, ' . $this->tabela . ' B '
				. ' WHERE B.' . $this->tabela_id . ' = ' .(int)$id
				. ' AND B.' . $this->tabela_lewy . ' BETWEEN A.' . $this->tabela_lewy . ' AND A.' . $this->tabela_prawy
				. ' AND A.' . $this->tabela_id_projektu . ' = ' . $this->id_projektu
				//. ' AND A.' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\''
				. ' AND B.' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND B.' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			if (!empty($warunek))
			{
				$sql .= ' AND ' . $this->baza->sqlWhere($warunek, 'A.');
			}
			$sql .= ' ORDER BY A.' . $this->tabela_lewy;

			$this->baza->zapytanie($sql);

			$wyniki = array();

			while ($wiersz = $this->baza->pobierzWynik())
			{
				//unset($wiersz['nflag']);
				$wyniki[] = $wiersz;
			}

			return (count($wyniki) > 0) ? $wyniki : false;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}



	/**
	 * Pobiera liste kategorii podleglych bezposrednio pod kategorie o podanym $id.
	 *
	 * @param integer $id Id elementu
	 * @param array $pola Pobierane pola: array('nazwa_pola1', 'nazwa_pola2', itd.)
	 * @param array $warunek Tablica ze struktura dodatkowego warunku: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), itd. klucz jest operatorem (AND, OR, itd.), a wartosc(i) trescia warunku
	 * @return array tablica z posortowanymi elementami
	 */
	function pobierzDzieci($id, $pola_tablica = null, $warunek = '')
	{
		try
		{
			if (is_array($pola_tablica))
			{
				$pola = 'A.' . implode(', A.', $pola_tablica);
			}
			else
			{
				$pola = 'A.*';
			}

			$sql = 'SELECT A.' . $this->tabela_lewy . ', A.' . $this->tabela_prawy . ', A.' . $this->tabela_poziom
				. ' FROM ' . $this->tabela . ' A, ' . $this->tabela . ' B '
				. ' WHERE B.' . $this->tabela_id . ' = ' .(int)$id
				. ' AND B.' . $this->tabela_lewy . ' BETWEEN A.' . $this->tabela_lewy
				. ' AND A.' . $this->tabela_prawy
				. ' AND A.' . $this->tabela_id_projektu . ' = ' . $this->id_projektu
				//. ' AND A.' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\''
				. ' AND B.' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND B.' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			if (!empty($warunek))
			{
				$sql .= $this->baza->sqlWhere($warunek, 'B.');
			}
			$sql .= ' ORDER BY A.' . $this->tabela_lewy;
			$this->baza->zapytanie($sql);

			$wyniki = array();

			while ($wiersz = $this->baza->pobierzWynik())
			{
				$wyniki[] = $wiersz;
			}

			$ilosc = count($wyniki);

			if ($ilosc == 0)
			{
				return false;
			}

			$i = 0;

			if (is_array($pola_tablica))
			{
				$pola = implode(', ', $pola_tablica);
			}
			else
			{
				$pola = '*';
			}

			$sql = 'SELECT ' . $pola . ' FROM ' . $this->tabela
				. ' WHERE (' . $this->tabela_poziom . ' = 1'
				. ' AND ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
				//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
			foreach($wyniki as $wiersz)
			{
				if ((++$i == $ilosc) && ($wiersz[$this->tabela_lewy] + 1) == $wiersz[$this->tabela_prawy])
				{
					break;
				}
				$sql .= ' OR (' . $this->tabela_poziom . ' = ' .($wiersz[$this->tabela_poziom] + 1)
					. ' AND ' . $this->tabela_lewy . ' > ' . $wiersz[$this->tabela_lewy]
					. ' AND ' . $this->tabela_prawy . ' < ' . $wiersz[$this->tabela_prawy] . ')';
			}
			$sql .= ') ';

			if (!empty($warunek))
			{
				$sql .= 'AND '. $this->baza->sqlWhere($warunek);
			}
			$sql .= ' ORDER BY ' . $this->tabela_lewy;

			$this->baza->zapytanie($sql);

			$wyniki = array();

			while ($wiersz = $this->baza->pobierzWynik())
			{
				$wyniki[] = $wiersz;
			}

			return (count($wyniki) > 0) ? $wyniki : false;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}



	/*
	 * Pisze zapytanie na podstawie pol klucza glownego i pobiera nowe id z bazy
	 *
	 * @return int wartosc id
	 */
	protected function pobierzId()
	{
		$sql = 'SELECT COALESCE(MAX(id),0)+1 AS id FROM ' . $this->tabela
			. ' WHERE ' . $this->tabela_id_projektu . ' = ' . $this->id_projektu;
			//. ' AND ' . $this->tabela_kod_jezyka . ' = \'' . $this->kod_jezyka . '\'';
		$this->baza->zapytanie($sql);
		$dane = $this->baza->pobierzWynik();
		return $dane['id'];
	}

}

