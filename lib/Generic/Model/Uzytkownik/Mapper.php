<?php
namespace Generic\Model\Uzytkownik;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących użytkowników.
 * @author Łukasz Wrucha
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{
	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_uzytkownicy';


	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane wersji
	 * @var string
	 */
	protected $tabelaWersje = 'UzytkownikWersja';


	protected $identyfikatorBazyWersje = 'mongo';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'login' => 'login',
		'haslo' => 'haslo',
		'email' => 'email',
		'data_dodania' => 'dataDodania',
		'data_aktywacji' => 'dataAktywacji',
		'token' => 'token',
		'czy_admin' => 'czyAdmin',
		'status' => 'status',
		'imie' => 'imie',
		'nazwisko' => 'nazwisko',
		'data_urodzenia' => 'dataUrodzenia',
		'tel_komorka_firmowa' => 'telKomorkaFirmowa',
		'tel_komorka_prywatna' => 'telKomorkaPrywatna',
		'tel_domowy' => 'telDomowy',
		'kontakt_adres' => 'kontaktAdres',
		'kontakt_kod_pocztowy' => 'kontaktKodPocztowy',
		'kontakt_miasto' => 'kontaktMiasto',
		'jezyk' => 'jezyk',
		'kraj_pochodzenia' => 'krajPochodzenia',
		'zdjecie' => 'zdjecie',
		'stawka_godzinowa' => 'stawkaGodzinowa',
		'tabela_podatkowa' => 'tabelaPodatkowa',
		'umiejetnosci' => 'umiejetnosci',
		'dane' => 'dane',
		'tidsbanken_kod' => 'tidsbankenKod',
		'tidsbanken_numer_pracownika' => 'tidsbankenNumerPracownika',
		'tidsbanken_haslo' => 'tidsbankenHaslo',
		'tidsbanken_loguj_przez_haslo' => 'tidsbankenLogujPrzezHaslo',
		'dzial' => 'dzial',
		'etat' => 'etat',
		'stanowisko' => 'stanowisko',
		'konto_bankowe' => 'kontoBankowe',
		'wlasciciel_konta' => 'wlascicielKonta',
		'dni_wolne' => 'dniWolne',
		'opiekun' => 'opiekun',
		'telefon_opiekun' => 'telefonOpiekun',
		'email_opiekun' => 'emailOpiekun',
		'praktykant' => 'praktykant',
		'praktykant_data_do' => 'praktykantDataDo',
		'dni_chorobowe' => 'dniChorobowe',
		'stala_wyplata' => 'stalaWyplata',
		'wyswietlaj_w_tidsbanken' => 'wyswietlajWTidsbanken',
		'kod_get' => 'kodGet'
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

	public function pobierzPoKodzie($kod)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE tidsbanken_kod = ' . $this->baza->formatujTekst($kod)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	public function pobierzPoTidsbankenNumer($tidsbankenNumerPracownika)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE tidsbanken_numer_pracownika = ' . $this->baza->formatujTekst($tidsbankenNumerPracownika)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}

	public function pobierzPoLoginie($login)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE login = ' . $this->baza->formatujTekst($login)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}


	public function szukajPoKodGet($kod)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE kod_get = ' . $this->baza->formatujTekst($kod)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	public function pobierzPoLoginieHasle($login, $haslo)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE login = ' . $this->baza->formatujTekst($login)
			. ' AND haslo = ' . $this->baza->formatujTekst($haslo)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}


	public function pobierzDoAktywacji($token)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE token = ' . $this->baza->formatujTekst($token)
			. ' AND status = \'nieaktywny\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	public function pobierzDlaTokenu($token)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE token = ' . $this->baza->formatujTekst($token)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	public function pobierzDlaRoli(Array $role)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE token IS NULL'
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND id IN (SELECT id_uzytkownika FROM cms_uzytkownicy_role WHERE id_roli IN ('.implode(',',$role).'))';

		return $this->pobierzWiele($sql);
	}


	public function pobierzDlaRoliPoKodach(Array $role)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
		. ' WHERE id_projektu = ' . ID_PROJEKTU
		. ' AND id IN (
				SELECT ur.id_uzytkownika FROM cms_uzytkownicy_role ur LEFT JOIN cms_role r ON ur.id_roli = r.id
					WHERE r.kod IN (\''.implode('\', \'',$role).'\'))';

		return $this->pobierzWiele($sql);
	}



	public function pobierzWszystko(Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	public function sprawdzZgodaMailing($listaEmaili)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU.' AND email IN (\''.implode('\',\'', $listaEmaili).'\') AND zgoda_mailing = true'
			. ' GROUP BY email';

		return $this->pobierzWiele($sql);
	}



	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * ';
		if(isset($kryteria['tidsbankenSortujPoProdukt']) && $kryteria['tidsbankenSortujPoProdukt'] )
		{
			$sql .= ', ( SELECT id FROM modul_tidsbanken_hours th WHERE th.id_user = '.$this->tabela.'.id AND th.stop IS NULL ) AS produkt';
		}
		$sql	.=  ' FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					login ILIKE \'%'.$fraza.'%\''
				. ' OR imie ILIKE \'%'.$fraza.'%\''
				. ' OR nazwisko ILIKE \'%'.$fraza.'%\''
				. ' OR kontakt_adres ILIKE \'%'.$fraza.'%\''
				. ' OR kontakt_miasto ILIKE \'%'.$fraza.'%\''
				. ')';
		}
		if(isset($kryteria['imie']) && $kryteria['imie'] != '')
		{
			$sql .= ' AND imie  ILIKE \'%'.trim($kryteria['imie']).'%\' ';
		}
		if(isset($kryteria['nazwisko']) && $kryteria['nazwisko'] != '')
		{
			$sql .= ' AND nazwisko ILIKE \'%'.trim($kryteria['nazwisko']).'%\' ';
		}
		if (isset($kryteria['dzial']) && $kryteria['dzial'] > 0)
		{
			$sql .= ' AND dzial = '.$kryteria['dzial'];
		}
		if (isset($kryteria['email']) && $kryteria['email'] != '')
		{
			$fraza = addslashes($kryteria['email']);
			$sql .= ' AND (
					email ILIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['wiele_id']) && is_array($kryteria['wiele_id']))
		{
			$sql .= ' AND id IN (' . implode(',', $kryteria['wiele_id']) . ')';
		}
		if (isset($kryteria['rola']) && $kryteria['rola'] != '')
		{
			$sql .= ' AND id IN (SELECT id_uzytkownika FROM cms_uzytkownicy_role WHERE id_roli = '.intval($kryteria['rola']).')';
		}
		if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '')
		{
			$sql .= ' AND data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}
		if (isset($kryteria['data_dodania_od']) && $kryteria['data_dodania_od'] != '')
		{
			$sql .= ' AND data_dodania >= \''.$kryteria['data_dodania_od'].'\'';
		}
		if (isset($kryteria['data_dodania_do']) && $kryteria['data_dodania_do'] != '')
		{
			$sql .= ' AND data_dodania <= \''.$kryteria['data_dodania_do'].' 23:59:59\'';
		}
		if (isset($kryteria['status']) && $kryteria['status'] != '')
		{
			$sql .= ' AND status = \''.addslashes($kryteria['status']).'\'';
		}
		if (isset($kryteria['wyswietlajWTidsbanken']) )
		{
			if($kryteria['wyswietlajWTidsbanken'])
			{
				$sql .= ' AND wyswietlaj_w_tidsbanken = true';
			}
			else
			{
				$sql .= ' AND wyswietlaj_w_tidsbanken = false';
			}
			
		}
		if (isset($kryteria['typ_aktywacji']) && $kryteria['typ_aktywacji'] != '')
		{
			$sql .= ' AND typ_aktywacji = \''.addslashes($kryteria['typ_aktywacji']).'\'';
		}
		if (isset($kryteria['data_aktywacji_od']) && $kryteria['data_aktywacji_od'] != '')
		{
			$sql .= ' AND data_aktywacji >= \''.$kryteria['data_aktywacji_od'].'\'';
		}
		if (isset($kryteria['data_aktywacji_do']) && $kryteria['data_aktywacji_do'] != '')
		{
			$sql .= ' AND data_aktywacji <= \''.$kryteria['data_aktywacji_do'].'\'';
		}
		if (isset($kryteria['czy_admin']))
		{
			$sql .= ' AND czy_admin = '.$this->warunekBool($kryteria['czy_admin']);
		}
		if (isset($kryteria['kody_rol']) && is_array($kryteria['kody_rol']) && count($kryteria['kody_rol']) > 0)
		{
			$sql .= ' AND id IN (SELECT ur.id_uzytkownika FROM cms_uzytkownicy_role ur LEFT JOIN cms_role r ON ur.id_roli = r.id
					WHERE r.kod IN (\''.implode('\', \'',array_map('addslashes',array_filter($kryteria['kody_rol']))).'\'))';
		}
		if(isset($kryteria['praktykant']))
		{
			if($kryteria['praktykant'])
			{
				$sql .= ' AND praktykant = TRUE';
			}
			else
			{
				$sql .= ' AND praktykant = FALSE';
			}
		}
		if(isset($kryteria['waznoscPraktyk']) && $kryteria['waznoscPraktyk'] != '' )
		{
			$sql .= ' AND praktykant_data_do < \''.$kryteria['waznoscPraktyk'].'\'';
		}
		if(isset($kryteria['login']) && !empty($kryteria['login']))
		{
			if(is_array($kryteria['login']))
			{
				$sql .= ' AND login IN (\'' . join('\', \'', $kryteria['login']) . '\')';
			}
			else
			{
				$sql .= ' AND login = ' . $this->baza->formatujTekst($kryteria['login']);
			}
		}

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					login ILIKE \'%'.$fraza.'%\''
				. ' OR imie ILIKE \'%'.$fraza.'%\''
				. ' OR nazwisko ILIKE \'%'.$fraza.'%\''
				. ' OR kontakt_adres ILIKE \'%'.$fraza.'%\''
				. ' OR kontakt_miasto ILIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['email']) && $kryteria['email'] != '')
		{
			$fraza = addslashes($kryteria['email']);
			$sql .= ' AND (
					email ILIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['wiele_id']) && is_array($kryteria['wiele_id']))
		{
			$sql .= ' AND id IN (' . implode(',', $kryteria['wiele_id']) . ')';
		}
		if (isset($kryteria['rola']) && $kryteria['rola'] != '')
		{
			$sql .= ' AND id IN (SELECT id_uzytkownika FROM cms_uzytkownicy_role WHERE id_roli = '.intval($kryteria['rola']).')';
		}
		if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '')
		{
			$sql .= ' AND data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}
		if (isset($kryteria['data_dodania_od']) && $kryteria['data_dodania_od'] != '')
		{
			$sql .= ' AND data_dodania >= \''.$kryteria['data_dodania_od'].'\'';
		}
		if (isset($kryteria['data_dodania_do']) && $kryteria['data_dodania_do'] != '')
		{
			$sql .= ' AND data_dodania <= \''.$kryteria['data_dodania_do'].' 23:59:59\'';
		}
		if (isset($kryteria['status']) && $kryteria['status'] != '')
		{
			$sql .= ' AND status = \''.addslashes($kryteria['status']).'\'';
		}
		if (isset($kryteria['wyswietlajWTidsbanken']) )
		{
			if($kryteria['wyswietlajWTidsbanken'])
			{
				$sql .= ' AND wyswietlaj_w_tidsbanken = true';
			}
			else
			{
				$sql .= ' AND wyswietlaj_w_tidsbanken = false';
			}
			
		}
		if (isset($kryteria['typ_aktywacji']) && $kryteria['typ_aktywacji'] != '')
		{
			$sql .= ' AND typ_aktywacji = \''.addslashes($kryteria['typ_aktywacji']).'\'';
		}
		if (isset($kryteria['data_aktywacji_od']) && $kryteria['data_aktywacji_od'] != '')
		{
			$sql .= ' AND data_aktywacji >= \''.$kryteria['data_aktywacji_od'].'\'';
		}
		if (isset($kryteria['data_aktywacji_do']) && $kryteria['data_aktywacji_do'] != '')
		{
			$sql .= ' AND data_aktywacji <= \''.$kryteria['data_aktywacji_do'].'\'';
		}
		if (isset($kryteria['czy_admin']))
		{
			$sql .= ' AND czy_admin = '.$this->warunekBool($kryteria['czy_admin']);
		}
		if(isset($kryteria['praktykant']))
		{
			if($kryteria['praktykant'])
			{
				$sql .= ' AND praktykant = TRUE';
			}
			else
			{
				$sql .= ' AND praktykant = FALSE';
			}
		}
		if(isset($kryteria['waznoscPraktyk']) && $kryteria['waznoscPraktyk'] != '' )
		{
			$sql .= ' AND praktykant_data_do < \''.$kryteria['waznoscPraktyk'].'\'';
		}
		if (isset($kryteria['kody_rol']) && is_array($kryteria['kody_rol']) && count($kryteria['kody_rol']) > 0)
		{
			$sql .= ' AND id IN (SELECT ur.id_uzytkownika FROM cms_uzytkownicy_role ur LEFT JOIN cms_role r ON ur.id_roli = r.id
					WHERE r.kod IN (\''.implode('\', \'',array_map('addslashes',array_filter($kryteria['kody_rol']))).'\'))';
		}

		return $this->pobierzWartosc($sql);
	}



	public function pobierzPoNrKonta($postfixNrKonta)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE numer_konta_bankowego LIKE \'%' . addslashes($postfixNrKonta) . '%\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
}