<?php
namespace Generic\Model\Zamowienie;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
//use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_zamowienia
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\Zamowienie\Obiekt';


	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_zamowienia';



	/**
	* Tablica tlumaczaca pola tabeli bazy danych na nazwy pol obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_parent' => 'idParent',
		'id_team' => 'idTeam',
		'id_type' => 'idType',
		'number_order_get' => 'numberOrderGet',
		'number_order_bkt' => 'numberOrderBkt',
		'number_customer' => 'numberCustomer',
		'number_privat_customer' => 'numberPrivatCustomer',
		'number_project_get' => 'numberProjectGet',
		'number_contact_id' => 'numberContactId',
		'charge_type' => 'chargeType',
		'date_added' => 'dateAdded',
		'hours_interval' => 'hoursInterval',
		'total_time' => 'totalTime',
		'date_start' => 'dateStart',
		'date_stop' => 'dateStop',
		'status' => 'status',
		'status_work' => 'statusWork',
		'address' => 'address',
		'city' => 'city',
		'postcode' => 'postcode',
		'location_lat' => 'locationLat',
		'location_lng' => 'locationLng',
		'budget' => 'budget',
		'node_villa_code' => 'nodeVillaCode',
		'attributes' => 'attributes',
		'job_description' => 'jobDescription',
		'order_name' => 'orderName',
		'is_reclamation' => 'isReclamation',
		'id_coordinator' => 'idCoordinator',
		'id_project_leader_get_contact' => 'idProjectLeaderGetContact',
		'id_project_leader_bkt' => 'idProjectLeaderBkt',
		'id_priced_by' => 'idPricedBy',
		'number_project_inkjops' => 'numberProjectInkjops',
		'reference' => 'reference',
		'high_priority' => 'highPriority',
		'position' => 'position',
		'sprawdzony' => 'sprawdzony',
		'wyslano_do_raportu' => 'wyslanoDoRaportu',
		'id_notatki_do_raportu' => 'idNotatkiDoRaportu',
		'data_zakonczenia' => 'dataZakonczenia',
		'id_user_zamknij_zamowienie' => 'idUserZamknijZamowienie',
		'kategoria' => 'kategoria',
		'not_charge' => 'notCharge',
		'blokada_edycji' => 'blokadaEdycji',
		'blokada_poprawiania' => 'blokadaPoprawiania',
		'wyslany_do_fakturowania' => 'wyslanyDoFakturowania',
		'zafakturowano' => 'zafakturowano',
		'apartment' => 'apartment',
		'additional_data' => 'additionalData',
		'id_pdf' => 'idPdf',
		'id_user_przydziel_apartamenty' => 'idUserPrzydzielApartamenty',
		'druga_tura_apartament' => 'drugaTuraApartament',
		'id_user_otworz_zamowienie' => 'idUserOtworzZamowienie',
		'typ_projektu' => 'typProjektu',
		'akceptacja_get' => 'akceptacjaGet',
		'akceptacja_form' => 'akceptacjaForm',
		'import_from_get_api' => 'importFromGetApi',
		'get_api_info' => 'getApiInfo'
	);



	/**
	* Pola tabeli bazy danych tworzÄ…ce klucz główny.
	* @var array
	*/
	protected $polaTabeliKlucz = array(
		'id',
		'id_projektu',
	);


	public function pobierzOstatniNumberOrderBkt()
	{
		$sql  = 'SELECT number_order_bkt FROM '.$this->tabela;
		$sql .= ' WHERE number_order_bkt > 0 ';
		$sql .= ' ORDER BY number_order_bkt DESC LIMIT 1';
		
		return $this->pobierzJeden($sql);
	}

	/**
	* Zwraca iloĹ›Ä‡ w tabeli modul_zamowienia.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}


	/**
	* Zwraca dla podanego id w tabeli modul_zamowienia.
	* @return \Generic\Model\Generic\Model\Zamowienie\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	/**
	* Zwraca dla podanego id w tabeli modul_zamowienia.
	* @return \Generic\Model\Generic\Model\Zamowienia\Obiekt
	*/
	public function pobierzPoWieleId(array $ids)
	{
		if (count($ids) == 0) return array();
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id IN (' . implode(',' , $ids) .')'
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql);
	}
	
	public function listaProjektowZApartamentami($kryteria, $sorter, $pager = null)
	{
		$sql = 'SELECT * FROM '.$this->tabela.' WHERE '
				. ' id_projektu = 1'
				. ' AND id IN (SELECT id_parent FROM modul_zamowienia WHERE id_type = 32 AND id_parent IS NOT NULL GROUP BY id_parent) ';
				
		if(isset($kryteria['id_type']))
		{
			if(is_array($kryteria['id_type']))
			{
				$sql .= ' AND id_type IN ('.implode( ',', $kryteria['id_type']).')';
			}
			else
			{
				$sql .= ' AND id_type = '.$kryteria['id_type'];
			}
		}
		if (isset($kryteria['date_added_od']) && $kryteria['date_added_od'] != '')
		{
			$sql .= ' AND date_added >= \''.$kryteria['date_added_od'].'\'';
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	
	public function pobierzListeApartamentow($idProjektu, $kryteria, $sorter)
	{
			$sql = 'SELECT *, (SELECT CONCAT(name , \' \', second_name, \' \' , surname ) FROM modul_klienci WHERE modul_klienci.id = o.number_privat_customer) AS klient FROM '.$this->tabela.' o WHERE '
				. ' o.id_projektu = 1'
				. ' AND o.id_parent = '.$idProjektu;
			if(isset($kryteria['statusy']) && is_array($kryteria['statusy']) && count($kryteria['statusy']))
			{
				$sql .= ' AND o.status_work IN(\''.implode('\',\'', $kryteria['statusy']).'\')';
			}
			if(isset($kryteria['akceptacjaGet']))
			{
				if($kryteria['akceptacjaGet'])
				{
					$sql .= ' AND o.akceptacja_get = true';
				}
				else
				{
					$sql .= ' AND (o.akceptacja_get = false OR o.akceptacja_get IS NULL)';
				}
			}

			return $this->pobierzWiele($sql, null, $sorter);
	}
	
	/**
	* Zwraca dla podanych id rodziców zamówienia dzieci.
	* @return \Generic\Model\Generic\Model\Zamowienia\Obiekt
	*/
	public function pobierzPoWieleIdRodzicow(array $ids)
	{
		if (count($ids) == 0) return array();
		$sql = 'SELECT * FROM ' . $this->tabela .' o'
			. ' WHERE id_parent IN (' . implode(',' , $ids) .')'
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, null, new \Generic\Model\Zamowienie\Sorter('address_appartment_natural', 'ASC'));
	}

	public function pobierzPrzydzieloneApartamenty(Array $kryteria)
	{
		$sql = 'SELECT * FROM ' . $this->tabela.' mz'
				  . ' JOIN modul_zamowienie_pdf mzp ON (mz.id_pdf = mzp.id_pdf) '
				  . ' WHERE mz.id_projektu = ' . ID_PROJEKTU
				  . ' AND mzp.data_dostarczenia IS NOT NULL';
		if(isset($kryteria['druga_tura']) && $kryteria['druga_tura'] > 0)
		{
			$sql .= ' AND (mz.druga_tura_apartament > 0 AND mzp.druga_tura_apartament > 0)';
		}
		else
		{
			$sql .= ' AND ((mz.druga_tura_apartament = 0 OR mz.druga_tura_apartament IS NULL) AND (mzp.druga_tura_apartament = 0 OR mzp.druga_tura_apartament IS NULL))';
		}
		if(isset($kryteria['id_parent']) && $kryteria['id_parent'] > 0)
		{
			$sql .= ' AND mz.id_parent ='.intval($kryteria['id_parent']);
		}
		if (isset($kryteria['status']) && $kryteria['status'] != '')
		{
			if (is_array($kryteria['status']) && count($kryteria['status']) > 0)
			{
				$sql .= ' AND mz.status IN(\''.implode('\',\'', $kryteria['status']).'\') ';
			}
			else
			{
				$sql .= ' AND mz.status = \''.$kryteria['status'].'\'';
			}
		}
		if (isset($kryteria['status_work']) && $kryteria['status_work'] != '')
		{
			if (is_array($kryteria['status_work']))
			{
				$sql .= ' AND mz.status_work IN(\''.implode('\',\'', $kryteria['status_work']).'\')';
			}
			else
			{	
				$sql .= ' AND mz.status_work = \''.$kryteria['status_work'].'\'';
			}
		}
		if (isset($kryteria['przydzielone']) && $kryteria['przydzielone'] == 1)
		{
			$sql .= ' AND mz.id_team > 0 ';
		}
		return $this->pobierzWiele($sql);
	}
	
	/**
	* Zwraca najnowszy obiekt zamówień dla podanego number_order_get w tabeli modul_zamowienia.
	* @param string $numberOrderGet
	* @return \Generic\Model\Generic\Model\Zamowienia\Obiekt
	*/
	public function pobierzPoNumberOrderGet($numberOrderGet, $dateStart = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE number_order_get = ' . intval($numberOrderGet)
			. ' AND id_projektu = ' . ID_PROJEKTU;
		if($dateStart != null)
		{
			$sql.=' AND date_start = \''.$dateStart.'\'';
		}
		$sql .= ' ORDER BY date_added DESC LIMIT 1';

		return $this->pobierzJeden($sql);
	}
	
	public function raportOrderType($idTypu, $kryteria)
	{
		$sql = '	SELECT mz.*, mz.id as zamowienie_id, mt.*, mt.id as timelist_id, mk.*, mk.id as klient_id FROM '.$this->tabela.' mz'
			. ' LEFT JOIN modul_timelist mt ON mz.id = mt.id_object'
			. ' LEFT JOIN modul_klienci mk ON mz.number_privat_customer = mk.id'
			. ' WHERE mz.id_type =  '.intval($idTypu)
			. ' AND mz.id_projektu = ' . ID_PROJEKTU
			. ' AND mt.data_stop IS NOT NULL';
		
		if(isset($kryteria['data_stop_od']) && $kryteria['data_stop_od'] != "")
		{
			$sql .= ' AND mt.data_stop > \''.$kryteria['data_stop_od'].'\'';
		}
		if(isset($kryteria['data_stop_do']) && $kryteria['data_stop_do'] != "")
		{
			$sql .= ' AND mt.data_stop < \''.$kryteria['data_stop_do'].'\'';
		}
		$sql .= ' ORDER BY mt.id_object, mt.data_stop DESC, mt.id_team ASC';
		
		return $this->pobierzWiele($sql);
	}
	
	public function zliczPoTypie($kryteria)
	{
		$sql = 'SELECT COUNT(id_type) AS ilosc, id_type FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		if (isset($kryteria['status']) && $kryteria['status'] != '')
		{
			$sql .= ' AND status = \''.$kryteria['status'].'\'';
		}
		if (isset($kryteria['status_work']) && $kryteria['status_work'] != '')
		{
			if (is_array($kryteria['status_work']))
			{
				$sql .= ' AND status_work IN(\''.implode('\',\'', $kryteria['status_work']).'\')';
			}
			else
			{	
				$sql .= ' AND status_work = \''.$kryteria['status_work'].'\'';
			}
		}
		if (isset($kryteria['bez_teamu']) && $kryteria['bez_teamu'] == 1)
		{
			$sql .= ' AND ( id_team IS NULL OR id_team < 1 )';
		}
		
		if (isset($kryteria['id_team']) && $kryteria['id_team'] > 0)
		{
			$sql .= ' AND id_team = '.intval($kryteria['id_team']);
		}
		
		$sql .= ' GROUP BY id_type';
		
		return $this->pobierzWiele($sql);
	}

	/**
	* Zwraca wszystko z tabeli modul_zamowienia.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	
	public function pobierzListaDatApartamentow(Array $kryteria, Sorter $sorter = null)
	{
		$sql = 'SELECT date_start, COUNT(*) as ilosc FROM ' . $this->tabela
				. ' WHERE id_projektu = ' . ID_PROJEKTU ;
		
		if(isset($kryteria['date_start_ustawiona']) && $kryteria['date_start_ustawiona'])
		{
			$sql .= ' AND date_start IS NOT NULL ';
		}
		if(isset($kryteria['date_start_nie_ustawiona']) && $kryteria['date_start_nie_ustawiona'])
		{
			$sql .= ' AND date_start IS NULL ';
		}
		if(isset($kryteria['id_parent']) && $kryteria['id_parent'] > 0)
		{
			$sql .= ' AND id_parent = '.intval($kryteria['id_parent']);
		}
		if(isset($kryteria['id_team']) && $kryteria['id_team'] > 0)
		{
			$sql .= ' AND id_team = '.intval($kryteria['id_team']);
		}
		if (isset($kryteria['id_types']) && is_array($kryteria['id_types']) && count($kryteria['id_types']) > 0 )
		{
			$sql .= ' AND id_type IN ('.implode(', ', $kryteria['id_types']).') ';
		}
		if (isset($kryteria['status']) && is_array($kryteria['status']) && count($kryteria['status']) > 0 )
		{
			$sql .= ' AND status IN(\''.implode('\',\'', $kryteria['status']).'\') ';
		}
		if (isset($kryteria['status_work']) && is_array($kryteria['status_work']) && count($kryteria['status_work']) > 0 )
		{
			$sql .= ' AND status_work IN(\''.implode('\',\'', $kryteria['status_work']).'\')';
		}
		if (isset($kryteria['id_pdf_ustawione']) && $kryteria['id_pdf_ustawione'] )
		{
			$sql .= ' AND id_pdf IS NOT NULL';
		}
		$sql .= ' GROUP BY date_start HAVING COUNT(*) > 0';

		return $this->pobierzWiele($sql, null, $sorter);
		
	}
	
	public function pobierzListaAdresow(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT address, COUNT(address) as ilosc FROM ' . $this->tabela .' mz';
				  
		if(isset($kryteria['zlicz_dostarczone']) && $kryteria['zlicz_dostarczone'])
		{
			$sql .= ' JOIN modul_zamowienie_pdf mzp ON (mzp.id_pdf = mz.id_pdf)';
		}
		
		$sql .= ' WHERE mz.id_projektu = ' . ID_PROJEKTU;
		if(isset($kryteria['zlicz_dostarczone']) && $kryteria['zlicz_dostarczone'])
		{
			$sql .= ' AND mzp.data_dostarczenia IS NOT NULL ';
			
			if(isset($kryteria['pierwsza_tura']) && $kryteria['pierwsza_tura'])
				$sql .= ' AND (mzp.druga_tura_apartament IS NULL OR mzp.druga_tura_apartament = 0)';
			elseif(isset($kryteria['druga_tura']) && $kryteria['druga_tura'])
				$sql .= ' AND mzp.druga_tura_apartament > 0';
		}
		if(isset($kryteria['pierwsza_tura']) && $kryteria['pierwsza_tura'])
		{
			$sql .= ' AND (mz.druga_tura_apartament IS NULL OR mz.druga_tura_apartament = 0 )';
		}
		if(isset($kryteria['druga_tura']) && $kryteria['druga_tura'])
		{
			$sql .= ' AND mz.druga_tura_apartament > 0';
		}
		if (isset($kryteria['id_parent']) && $kryteria['id_parent'] > 0)
		{
			$sql .= ' AND mz.id_parent = '.intval($kryteria['id_parent']).' ';
		}
		if (isset($kryteria['apartament_istnieje']) && $kryteria['apartament_istnieje'])
		{
			$sql .= ' AND mz.apartment  IS NOT NULL';
		}
		if (isset($kryteria['bez_apartamentu']) && $kryteria['bez_apartamentu'])
		{
			$sql .= ' AND mz.apartment  IS NULL';
		}
		if (isset($kryteria['status']) && $kryteria['status'] != '')
		{
			if (is_array($kryteria['status']) && count($kryteria['status']) > 0)
			{
				$sql .= ' AND mz.status IN(\''.implode('\',\'', $kryteria['status']).'\') ';
			}
			else
			{
				$sql .= ' AND mz.status = \''.$kryteria['status'].'\'';
			}
		}
		if (isset($kryteria['status_work']) && $kryteria['status_work'] != '')
		{
			if (is_array($kryteria['status_work']))
			{
				$sql .= ' AND mz.status_work IN(\''.implode('\',\'', $kryteria['status_work']).'\')';
			}
			else
			{	
				$sql .= ' AND mz.status_work = \''.$kryteria['status_work'].'\'';
			}
		}
		$sql .= ' GROUP BY mz.address ';

		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	
	public function szukajApartamentuPoAdresie($address, $postcode, $city, $hnummer, $idProjektu)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
				. ' WHERE id_projektu = ' . ID_PROJEKTU
				. ' AND id_type  IN (32, 33) '
				. ' AND address = \''.$address.'\''
				. ' AND postcode = \''.$postcode.'\''
				. ' AND city = \''.$city.'\'';
				if($hnummer != null)
				{
				$sql .= ' AND apartment = \''.$hnummer.'\'';
				}
				$sql .= ' AND id_parent = '.$idProjektu;
		
		return $this->pobierzWiele($sql);
	}

	/**
	 * Zwraca liste projektów do których apartamentów przydzielony jest wybrany team
	 * @param type $idTeamu
	 */
	public function pobierzProjektyApartamentowTeamu($idTeamu, Array $idType)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND id IN (SELECT id_parent FROM modul_zamowienia WHERE id_team = '.$idTeamu.' AND id_type IN ('.  implode(", ", $idType) .') AND status IN (\'active\') )';
		
		return $this->pobierzWiele($sql);
	}
	
	public function szukajVillaProduktRaport(Array $kryteria)
	{
		$sql = 'SELECT number_order_get, mz.id AS bkt_id,
		(SELECT  description FROM modul_notes mn WHERE mz.id = mn.id_object ORDER BY data_added DESC LIMIT 1 ) AS note,
		(SELECT SUM(hours)*2 FROM modul_timelist mt WHERE mt.id_object = mz.id AND mt.lider = TRUE GROUP BY mt.id_object) AS time_spent,
		(SELECT SUM(mpz3.quantity) * 0.5 FROM modul_produkty_zakupione mpz3 WHERE mz.id = mpz3.id_order AND mpz3.quantity > 0 AND mpz3.id_product = 508 AND mpz3.confirmation_status <> \'rejected\' GROUP BY mpz3.id_product ) AS time_lopendetimer,
		(SELECT SUM(mpz3.quantity) * 0.5 FROM modul_produkty_zakupione mpz3 WHERE mz.id = mpz3.id_order AND mpz3.quantity > 0 AND mpz3.id_product = 506 AND mpz3.confirmation_status <> \'rejected\' GROUP BY mpz3.id_product ) AS time_lopendetimer_1,
		(SELECT SUM(mpz3.quantity) * 0.5 FROM modul_produkty_zakupione mpz3 WHERE mz.id = mpz3.id_order AND mpz3.quantity > 0 AND mpz3.id_product = 495 AND mpz3.confirmation_status <> \'rejected\' GROUP BY mpz3.id_product ) AS time_lopendetime_2,
		(SELECT SUM(mpz1.netto_price) FROM modul_produkty_zakupione mpz1 JOIN modul_produkty ON modul_produkty.id=mpz1.id_product WHERE mz.id = mpz1.id_order AND modul_produkty.import=FALSE AND mpz1.confirmation_status <> \'rejected\' GROUP BY mpz1.id_order ) AS netto_price
		';
		$sql.=', (SELECT STRING_AGG(mp1.name || \' x \' || mpz2.quantity  , \' ; \' ORDER BY mp1.netto_price DESC) FROM modul_produkty_zakupione mpz2 JOIN modul_produkty mp1 ON (mp1.id = mpz2.id_product ) WHERE mpz2.id_order = mz.id AND mp1.import = FALSE AND mpz2.confirmation_status <> \'rejected\' ) AS products ';
		$sql.=', (SELECT STRING_AGG(mp1.id || \'x\' || mpz2.quantity  , \';\' ORDER BY mp1.netto_price DESC) FROM modul_produkty_zakupione mpz2 JOIN modul_produkty mp1 ON (mp1.id = mpz2.id_product ) WHERE mpz2.id_order = mz.id AND mp1.import = FALSE AND mpz2.confirmation_status <> \'rejected\' ) AS products_ids ';
		$sql.=' FROM modul_zamowienia mz
		JOIN modul_produkty_zakupione mpz ON (mz.id = mpz.id_order) 
		WHERE  mz.date_start > \'2019-06-21\' AND mz.id_type = 1 AND mz.status_work <> \'new\' AND ( mpz.id_product = 508 OR mpz.id_product = 506 OR mpz.id_product = 495 ) AND mpz.confirmation_status <> \'rejected\' ';
		
		return $this->zwracaTablice()->pobierzWiele($sql);
	}
	
	public function szukajVillaProduktRaportAll(Array $kryteria)
	{
		$sql = 'SELECT number_order_get, mz.id AS bkt_id,
		(SELECT  description FROM modul_notes mn WHERE mz.id = mn.id_object ORDER BY data_added DESC LIMIT 1 ) AS note,
		(SELECT SUM(hours)*2 FROM modul_timelist mt WHERE mt.id_object = mz.id AND mt.lider = TRUE GROUP BY mt.id_object) AS time_spent,
		(SELECT SUM(mpz3.quantity) * 0.5 FROM modul_produkty_zakupione mpz3 WHERE mz.id = mpz3.id_order AND mpz3.quantity > 0 AND mpz3.id_product = 508 AND mpz3.confirmation_status <> \'rejected\' GROUP BY mpz3.id_product ) AS time_lopendetimer,
		(SELECT SUM(mpz1.netto_price) FROM modul_produkty_zakupione mpz1 JOIN modul_produkty ON modul_produkty.id=mpz1.id_product WHERE mz.id = mpz1.id_order AND modul_produkty.import=FALSE AND mpz1.confirmation_status <> \'rejected\' GROUP BY mpz1.id_order ) AS netto_price,
		(SELECT SUM(mpz4.quantity) FROM modul_produkty_zakupione mpz4 JOIN modul_produkty mp2 ON (mp2.id = mpz4.id_product ) WHERE mpz4.id_order = mz.id AND mp2.netto_price > 0 AND mp2.import = FALSE AND mpz4.confirmation_status <> \'rejected\' AND mpz4.id_product <> 508 ) AS product_quantity_without_lopendetimer
		';
		$sql.=', (SELECT STRING_AGG(mp1.name || \' x \' || mpz2.quantity  , \' ; \' ORDER BY mp1.netto_price DESC) FROM modul_produkty_zakupione mpz2 JOIN modul_produkty mp1 ON (mp1.id = mpz2.id_product ) WHERE mpz2.id_order = mz.id AND mp1.import = FALSE AND mpz2.confirmation_status <> \'rejected\' ) AS products ';
		$sql.=', (SELECT STRING_AGG(mp1.id || \'x\' || mpz2.quantity  , \';\' ORDER BY mp1.netto_price DESC) FROM modul_produkty_zakupione mpz2 JOIN modul_produkty mp1 ON (mp1.id = mpz2.id_product ) WHERE mpz2.id_order = mz.id AND mp1.import = FALSE AND mpz2.confirmation_status <> \'rejected\' ) AS products_ids ';
		$sql.=' FROM modul_zamowienia mz
		JOIN modul_timelist mt ON (mz.id = mt.id_object )
		WHERE mz.status_work <> \'new\' AND mt.data_start > \'2019-06-21\' AND mt.lider = TRUE AND id_type = 1 ';
		
		return $this->zwracaTablice()->pobierzWiele($sql);
	}
	
	public function liczBudget(Array $kryteria)
	{
		$sql = '';
		$sql.='SELECT SUM(budget) FROM '.$this->tabela.' AS o ';
		$sql.=' WHERE id_projektu = '.ID_PROJEKTU;
		if (isset($kryteria['id_types']))
		{
			if (is_array($kryteria['id_types']))
			{
				$sql .= ' AND o.id_type IN ('.implode(', ', $kryteria['id_types']).')';
			}
			else
			{
				$sql .= ' AND o.id_type = '.intval($kryteria['id_types']);
			}
		}
		if (isset($kryteria['status_work']) && $kryteria['status_work'] != '')
		{
			if (is_array($kryteria['status_work']))
			{
				$sql .= ' AND o.status_work IN(\''.implode('\',\'', $kryteria['status_work']).'\')';
			}
			else
			{	
				$sql .= ' AND o.status_work = \''.$kryteria['status_work'].'\'';
			}
		}
		if (isset($kryteria['status']) && $kryteria['status'] != '')
		{
			if (is_array($kryteria['status']) && count($kryteria['status']) > 0)
			{
				$sql .= ' AND o.status IN(\''.implode('\',\'', $kryteria['status']).'\') ';
			}
			else
			{
				$sql .= ' AND o.status = \''.$kryteria['status'].'\'';
			}
		}
		if (isset($kryteria['data_zakonczenia_od']) && $kryteria['data_zakonczenia_od'] != '' && isset($kryteria['data_zakonczenia_do']) && $kryteria['data_zakonczenia_do'] != '')
		{
			if (strlen($kryteria['data_zakonczenia_od']) == 10) $data_zakonczenia_od = $kryteria['data_zakonczenia_od'].' 00:00:00';
			else $data_zakonczenia_od = $kryteria['data_zakonczenia_od'];
			
			if (strlen($kryteria['data_zakonczenia_do']) == 10) $data_zakonczenia_do = $kryteria['data_zakonczenia_do'].' 23:59:59';
			else $data_zakonczenia_do = $kryteria['data_zakonczenia_do'];
			
			$sql .= ' AND o.data_zakonczenia IS NOT null AND (o.data_zakonczenia BETWEEN \''.$data_zakonczenia_od.'\' AND \''.$data_zakonczenia_do.'\')';
		}
		else
		{
			if (isset($kryteria['data_zakonczenia_od']) && $kryteria['data_zakonczenia_od'] != '')
			{
				$sql .= ' AND o.data_zakonczenia IS NOT null AND o.data_zakonczenia >= \''.$kryteria['data_zakonczenia_od'].' 00:00:00\'';
			}
			if (isset($kryteria['data_zakonczenia_do']) && $kryteria['data_zakonczenia_do'] != '')
			{
				$sql .= ' AND o.data_zakonczenia IS NOT null AND o.data_zakonczenia <= \''.$kryteria['data_zakonczenia_do'].' 23:59:59\'';
			}
		}
		if (isset($kryteria['wyslano_do_raportu']))
		{
			if ($kryteria['wyslano_do_raportu'] !== true)
			{
				$sql .= ' AND wyslano_do_raportu = FALSE';
			}
			else
			{
				$sql .= ' AND wyslano_do_raportu = TRUE';
			}
		}
		if (isset($kryteria['charge']) && $kryteria['charge'])
		{
			$sql .= ' AND not_charge = FALSE';
		}
		if (isset($kryteria['sprawdzony']))
		{
			if ($kryteria['sprawdzony'] !== true)
			{
				$sql .= ' AND sprawdzony = FALSE';
			}
			else
			{
				$sql .= ' AND sprawdzony = TRUE';
			}
		}
		return $this->pobierzWartosc($sql);
	}
	/**
	* Wyszukuje w tabeli modul_zamowienia dla podanych kryteriow.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null, $count = false)
	{
		$sql = 'SELECT o.*, ot.name as type_name, o.additional_data,
					k.name, k.second_name, k.surname, k.org_number, k.company_name, k.address as kAddress, k.city as kCity, k.postcode as kpostcode, k.phone_number, k.phone_number_1, k.phone_number_2, k.phone_mobile, k.fax, k.email, k.type, k.www, k.id_customer';
		if(isset($kryteria['sprawdz_druga_tura']) && $kryteria['sprawdz_druga_tura'])
		{
			$sql .= ' , (SELECT COUNT(*) FROM modul_zamowienia mz WHERE o.id = mz.druga_tura_apartament ) AS druga_tura_istnieje';
		}
		$sql .= ' FROM ' . $this->tabela . ' o'
				. ' LEFT JOIN modul_klienci k ON o.number_privat_customer = k.id LEFT JOIN modul_zamowienia_typy ot ON o.id_type = ot.id WHERE'
				. ' o.id_projektu = ' . ID_PROJEKTU;
		
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			
			$sql .= ' AND (k.surname ILIKE \'%'.$fraza.'%\''
				. ' OR o.order_name ILIKE \'%'.$fraza.'%\''
				. ' OR k.name ILIKE \'%'.$fraza.'%\''
				. ' OR CONCAT(k.name, \' \', k.surname) ILIKE \'%'.$fraza.'%\''
				. ' OR CONCAT(k.surname, \' \', k.name) ILIKE \'%'.$fraza.'%\''
					  
				. ' OR CONCAT(k.company_name, \' \', k.name, \' \', k.surname) ILIKE \'%'.$fraza.'%\''
				. ' OR CONCAT(k.company_name, \' \', k.surname, \' \', k.name) ILIKE \'%'.$fraza.'%\''
					  
				. ' OR k.company_name ILIKE \'%'.$fraza.'%\''
				. ' OR o.job_description ILIKE \'%'.$fraza.'%\''
				. ' OR k.id_customer::character varying ILIKE \'%'.$fraza.'%\''
				. ' OR k.id::character varying ILIKE \'%'.$fraza.'%\''
				. ' OR k.org_number ILIKE \'%'.$fraza.'%\''
				. ' OR k.email ILIKE \'%'.$fraza.'%\''
				. ' OR k.www ILIKE \'%'.$fraza.'%\''
				. ' OR k.phone_number::character varying LIKE \'%'.$fraza.'%\''
				. ' OR o.city ILIKE \'%'.$fraza.'%\''
				. ' OR o.address ILIKE \'%'.$fraza.'%\''
				. ' OR o.postcode ILIKE \'%'.$fraza.'%\''
				. ' OR CONCAT(o.city, \' \', o.address, \' \', o.apartment) ILIKE \'%'.$fraza.'%\''
				. ' OR o.number_project_get ILIKE \'%'.$fraza.'%\''
				. ' OR o.number_project_inkjops ILIKE \'%'.$fraza.'%\''
				. ' OR o.number_order_get::character varying LIKE \'%'.$fraza.'%\''
				. ' OR o.id::character varying LIKE \'%'.$fraza.'%\''
				. ' OR o.apartment LIKE \'%'.$fraza.'%\''
				. ' OR o.id_pdf LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if(isset($kryteria['import_from_get_api']))
		{
			if($kryteria['import_from_get_api'])
				$sql .= ' AND o.import_from_get_api = TRUE';
			else
				$sql .= ' AND o.import_from_get_api = FALSE';
				
		}
		if(isset($kryteria['number_order_get']) && $kryteria['number_order_get'] != '')
		{
			if(is_array($kryteria['number_order_get']) && count($kryteria['number_order_get']))
			{
				$sql .= ' AND o.number_order_get IN ('.implode(',', $kryteria['number_order_get']).')';
			}
			else
			{
				$fraza = addslashes($kryteria['number_order_get']);
				$sql .= ' AND o.number_order_get = '.$fraza.'';
			}
		}
		if(isset($kryteria['id']) && $kryteria['id'])
		{
			$sql .= ' AND o.id = '.intval($kryteria['id']);
		}
		if(isset($kryteria['pierwsza_tura']) && $kryteria['pierwsza_tura'])
		{
			$sql .= ' AND (o.druga_tura_apartament IS NULL OR o.druga_tura_apartament = 0)';
		}
		if(isset($kryteria['druga_tura']) && $kryteria['druga_tura'])
		{
			$sql .= ' AND o.druga_tura_apartament > 0';
		}
		if(isset($kryteria['druga_tura_apartament']) && $kryteria['druga_tura_apartament'] > 0)
		{
			if(is_array($kryteria['druga_tura_apartament']))
				$sql .= ' AND o.druga_tura_apartament IN ('.implode(',', $kryteria['druga_tura_apartament']).') ';
			else
				$sql .= ' AND o.druga_tura_apartament = '.$kryteria['druga_tura_apartament'];
		}
		if(isset($kryteria['id_user_przydziel_apartamenty']) && $kryteria['id_user_przydziel_apartamenty'] > 0)
		{
			$sql .= ' AND o.id_user_przydziel_apartamenty = '.intval($kryteria['id_user_przydziel_apartamenty']).' ';
		}
		if(isset($kryteria['bez_apartmentu']) && $kryteria['bez_apartmentu'])
		{
			$sql .= ' AND o.apartment IS NULL ';
		}
		if(isset($kryteria['dokladny_address']) && $kryteria['dokladny_address'] !='')
		{
			$fraza = addslashes($kryteria['dokladny_address']);
			$sql .= ' AND o.address = \''.$fraza.'\' ';
		}
		if(isset($kryteria['dokladny_city']) && $kryteria['dokladny_city'] !='')
		{
			$fraza = addslashes($kryteria['dokladny_city']);
			$sql .= ' AND o.city = \''.$fraza.'\' ';
		}
		if(isset($kryteria['apartament']) && $kryteria['apartament'] !='')
		{
			$fraza = addslashes($kryteria['apartament']);
			$sql .= ' AND o.apartment = \''.$fraza.'\' ';
		}
		if(isset($kryteria['dokladny_postcode']) && $kryteria['dokladny_postcode'] !='')
		{
			$fraza = addslashes($kryteria['dokladny_postcode']);
			$sql .= ' AND o.postcode = \''.$fraza.'\' ';
		}
		if(isset($kryteria['id_project_leader_bkt']) && $kryteria['id_project_leader_bkt'] !='' && $kryteria['id_project_leader_bkt'] > 0)
		{
			$sql .= ' AND o.id_project_leader_bkt = '.intval($kryteria['id_project_leader_bkt']).'';
		}
		if(isset($kryteria['!wiele_id']) && is_array($kryteria['!wiele_id']) && count($kryteria['!wiele_id']) > 0 )
		{
			$sql .= ' AND o.id NOT IN ('.implode(', ', $kryteria['!wiele_id']).')';
		}
		if(isset($kryteria['wiele_id']) && is_array($kryteria['wiele_id']) && count($kryteria['wiele_id']) > 0 )
		{
			$sql .= ' AND o.id IN ('.implode(', ', $kryteria['wiele_id']).')';
		}
		if (isset($kryteria['id_parent']) && $kryteria['id_parent'] > 0)
		{
			$sql .= ' AND o.id_parent = '.intval($kryteria['id_parent']);
		}
		if (isset($kryteria['bez_rodzica']) && $kryteria['bez_rodzica'] == 1)
		{
			$sql .= ' AND o.id_parent IS NULL';
		}
		if (isset($kryteria['id_team']) && $kryteria['id_team'] > 0)
		{
			$sql .= ' AND o.id_team = '.intval($kryteria['id_team']);
		}
		if (isset($kryteria['id_team_array']) && $kryteria['id_team_array'] > 0)
		{
			$sql .= ' AND o.id_team IN('.implode(', ', $kryteria['id_team_array']).')';
		}
		if (isset($kryteria['bez_teamu']) && $kryteria['bez_teamu'] == 1)
		{
			$sql .= ' AND ( o.id_team IS NULL OR o.id_team < 1 )';
		}
		if (isset($kryteria['przydzielone']) && $kryteria['przydzielone'] == 1)
		{
			$sql .= ' AND o.id_team > 0 ';
		}
		if (isset($kryteria['!id_team']) && $kryteria['!id_team'] != '')
		{
			if(is_array($kryteria['!id_team']) && count($kryteria['!id_team']) > 0)
				$sql .= ' AND ( id_team NOT IN ('.implode(', ', $kryteria['!id_team']).'))';
			else
				$sql .= ' AND id_team != '.$kryteria['!id_team'];
				
		}
		if (isset($kryteria['id_type']))
		{
			if (is_array($kryteria['id_type']))
			{
				$sql .= ' AND o.id_type IN ('.implode(', ', $kryteria['id_type']).')';
			}
			else
			{
				$sql .= ' AND o.id_type = '.intval($kryteria['id_type']);
			}
		}
		if (isset($kryteria['id_types']))
		{
			if (is_array($kryteria['id_types']))
			{
				$sql .= ' AND o.id_type IN ('.implode(', ', $kryteria['id_types']).')';
			}
			else
			{
				$sql .= ' AND o.id_type = '.intval($kryteria['id_types']);
			}
		}
		if (isset($kryteria['number_order_get']))
		{
			if (is_array($kryteria['number_order_get']))
			{
				$sql .= ' AND o.number_order_get IN (\''.implode('\',\'', $kryteria['number_order_get']).'\') ';
			}
			else
			{
				$sql .= ' AND o.number_order_get = '.intval($kryteria['number_order_get']);
			}
		}
		if (isset($kryteria['number_order_bkt']))
		{
			if (is_array($kryteria['number_order_bkt']))
			{
				$sql .= ' AND o.number_order_bkt IN (\''.implode('\',\'', $kryteria['number_order_bkt']).'\') ';
			}
			else
			{
				$sql .= ' AND o.number_order_bkt = '.intval($kryteria['number_order_bkt']);
			}
		}
		if (isset($kryteria['number_customer']) && $kryteria['number_customer'] > 0)
		{
			$sql .= ' AND o.number_customer = '.intval($kryteria['number_customer']);
		}
		if (isset($kryteria['not_number_customer']) && $kryteria['not_number_customer'] > 0)
		{
			$sql .= ' AND o.number_customer <> '.intval($kryteria['not_number_customer']);
		}
		if (isset($kryteria['number_privat_customer']) && $kryteria['number_privat_customer'] > 0)
		{
			$sql .= ' AND o.number_privat_customer = '.intval($kryteria['number_privat_customer']);
		}
		if (isset($kryteria['number_project_get']) && $kryteria['number_project_get'] != '')
		{
			$sql .= ' AND o.number_project_get ILIKE \''.strval($kryteria['number_project_get']).'%\'';
		}
		if (isset($kryteria['number_contact_id']) && $kryteria['number_contact_id'] > 0)
		{
			$sql .= ' AND o.number_contact_id = '.intval($kryteria['number_contact_id']);
		}
		if (isset($kryteria['charge_type']) && $kryteria['charge_type'] != '')
		{
			if (is_array($kryteria['charge_type']))
			{
				$sql .= ' AND o.charge_type IN(\''.implode('\',\'', $kryteria['charge_type']).'\') ';
			}
			else
			{
				$sql .= ' AND o.charge_type = \''.$kryteria['charge_type'].'\'';
			}
		}
		// Daty warunki
		if (isset($kryteria['date_added_od']) && $kryteria['date_added_od'] != '')
		{
			$sql .= ' AND o.date_added >= \''.$kryteria['date_added_od'].'\'';
		}
		if (isset($kryteria['date_start_rowne']) && $kryteria['date_start_rowne'] != '')
		{
			$sql .= ' AND o.date_start = \''.$kryteria['date_start_rowne'].'\'';
		}
		if (isset($kryteria['data_zakonczenia_rowne']) && $kryteria['data_zakonczenia_rowne'] != '')
		{
			$sql .= ' AND o.data_zakonczenia = \''.$kryteria['data_zakonczenia_rowne'].'\'';
		}
		if (isset($kryteria['data_start_array']) && count($kryteria['data_start_array']) > 0)
		{
			$sql .= ' AND o.date_start IN(\''.implode('\',\'', $kryteria['data_start_array']).'\')';
		}
		if (isset($kryteria['date_start_od']) && $kryteria['date_start_od'] != '')
		{
			$sql .= ' AND o.date_start >= \''.$kryteria['date_start_od'].'\'';
		}
		if (isset($kryteria['date_stop_od']) && $kryteria['date_stop_od'] != '')
		{
			$sql .= ' AND o.date_stop >= \''.$kryteria['date_stop_od'].'\'';
		}
		if (isset($kryteria['date_added_do']) && $kryteria['date_added_do'] != '')
		{
			$sql .= ' AND o.date_added <= \''.$kryteria['date_added_do'].'\'';
		}
		if (isset($kryteria['date_start_do']) && $kryteria['date_start_do'] != '')
		{
			$sql .= ' AND o.date_start <= \''.$kryteria['date_start_do'].'\'';
		}
		if (isset($kryteria['date_stop_do']) && $kryteria['date_stop_do'] != '')
		{
			$sql .= ' AND o.date_stop <= \''.$kryteria['date_stop_do'].'\'';
		}
		if (isset($kryteria['data_zakonczenia_od']) && $kryteria['data_zakonczenia_od'] != '' && isset($kryteria['data_zakonczenia_do']) && $kryteria['data_zakonczenia_do'] != '')
		{
			if (strlen($kryteria['data_zakonczenia_od']) == 10) $data_zakonczenia_od = $kryteria['data_zakonczenia_od'].' 00:00:00';
			else $data_zakonczenia_od = $kryteria['data_zakonczenia_od'];
			
			if (strlen($kryteria['data_zakonczenia_do']) == 10) $data_zakonczenia_do = $kryteria['data_zakonczenia_do'].' 23:59:59';
			else $data_zakonczenia_do = $kryteria['data_zakonczenia_do'];
			
			$sql .= ' AND o.data_zakonczenia IS NOT null AND (o.data_zakonczenia BETWEEN \''.$data_zakonczenia_od.'\' AND \''.$data_zakonczenia_do.'\')';
		}
		else
		{
			if (isset($kryteria['data_zakonczenia_od']) && $kryteria['data_zakonczenia_od'] != '')
			{
				$sql .= ' AND o.data_zakonczenia IS NOT null AND o.data_zakonczenia >= \''.$kryteria['data_zakonczenia_od'].' 00:00:00\'';
			}
			if (isset($kryteria['data_zakonczenia_do']) && $kryteria['data_zakonczenia_do'] != '')
			{
				$sql .= ' AND o.data_zakonczenia IS NOT null AND o.data_zakonczenia <= \''.$kryteria['data_zakonczenia_do'].' 23:59:59\'';
			}
		}
		if (isset($kryteria['status']) && $kryteria['status'] != '')
		{
			if (is_array($kryteria['status']) && count($kryteria['status']) > 0)
			{
				$sql .= ' AND o.status IN(\''.implode('\',\'', $kryteria['status']).'\') ';
			}
			else
			{
				$sql .= ' AND o.status = \''.$kryteria['status'].'\'';
			}
		}
		if (isset($kryteria['!status']) && $kryteria['!status'] != '')
		{
			if (is_array($kryteria['!status']) && count($kryteria['!status']) > 0)
			{
				$sql .= ' AND o.status NOT IN(\''.implode('\',\'', $kryteria['!status']).'\') ';
			}
			else
			{
				$sql .= ' AND o.status <> \''.$kryteria['!status'].'\'';
			}
		}
		if (isset($kryteria['hours_interval']) && $kryteria['hours_interval'] != '')
		{
			$sql .= ' AND o.hours_interval LIKE \'%'.$kryteria['hours_interval'].'%\'';
		}
		if (isset($kryteria['hours_interval_array']) && count($kryteria['hours_interval_array']) > 0)
		{
			$sql .= ' AND o.hours_interval IN(\''.implode('\',\'', $kryteria['hours_interval_array']).'\')';
		}
		if (isset($kryteria['total_time']) && $kryteria['total_time'] > 0)
		{
			$sql .= ' AND o.total_time = '.intval($kryteria['total_time']);
		}
		if (isset($kryteria['status_work']) && $kryteria['status_work'] != '')
		{
			if (is_array($kryteria['status_work']))
			{
				$sql .= ' AND o.status_work IN(\''.implode('\',\'', $kryteria['status_work']).'\')';
			}
			else
			{	
				$sql .= ' AND o.status_work = \''.$kryteria['status_work'].'\'';
			}
		}
		if (isset($kryteria['!status_work']) && $kryteria['!status_work'] != '')
		{
			if (is_array($kryteria['!status_work']))
			{
				$sql .= ' AND o.status_work NOT IN(\''.implode('\',\'', $kryteria['!status_work']).'\')';
			}
			else
			{	
				$sql .= ' AND o.status_work <> \''.$kryteria['!status_work'].'\'';
			}
		}
		if (isset($kryteria['address']) && $kryteria['address'] != '')
		{
			$sql .= ' AND o.address ILIKE \'%'.$kryteria['address'].'%\'';
		}
		if (isset($kryteria['city']) && $kryteria['city'] != '')
		{
			$sql .= ' AND o.city ILIKE \'%'.$kryteria['city'].'%\'';
		}
		if (isset($kryteria['postcode']) && $kryteria['postcode'] != '')
		{
			$sql .= ' AND o.postcode = \''.$kryteria['postcode'].'\'';
		}
		if (isset($kryteria['postcode_od']) && $kryteria['postcode_od'] != '')
		{
			$sql .= ' AND o.postcode >= \''.$kryteria['postcode_od'].'\'';
		}
		if (isset($kryteria['postcode_do']) && $kryteria['postcode_do'] != '')
		{
			$sql .= ' AND o.postcode <= \''.$kryteria['postcode_do'].'\'';
		}
		if (isset($kryteria['budget']) && $kryteria['budget'] > 0)
		{
			$sql .= ' AND o.budget = \''.$kryteria['budget'].'\'';
		}
		if (isset($kryteria['node_villa_code']) && $kryteria['node_villa_code'] != '')
		{
			$sql .= ' AND o.node_villa_code ILIKE \''.$kryteria['node_villa_code'].'%\'';
		}
		if (isset($kryteria['is_reclamation']))
		{
			$is_reclamation = ($kryteria['is_reclamation']) ? 'true': 'false';
			$sql .= ' AND o.is_reclamation = '. $is_reclamation;
		}
		if (isset($kryteria['ma_dzieci']) && $kryteria['ma_dzieci'] != '')
		{	
			$pierwsze_zapytanie = 'SELECT id_parent FROM '.$this->tabela.' WHERE id_parent IS NOT NULL AND '; 
			if(isset($kryteria['ma_dzieci_statusy']))
			{
				$pierwsze_zapytanie .= ' status IN (\''.implode('\',\'', $kryteria['ma_dzieci_statusy']).'\') AND is_reclamation = false'; 
			}
			else
			{
				$pierwsze_zapytanie .= ' status = \'active\' AND is_reclamation = false'; 
			}
			$pierwsze_zapytanie .= ' GROUP BY id_parent';
			$typ = $this->pobierzZwracanyTyp();
			$wynik = listaZTablicy($this->zwracaTablice()->pobierzWiele($pierwsze_zapytanie), null, 'id_parent');
			if ($typ == 'zwracaTablice')
				$this->zwracaTablice ();
			if (empty($wynik)) $wynik = array(0);
			$sql .= ' AND (o.id IN ('.  implode(',', $wynik).'))';
			unset($wynik);
		}
		if (isset($kryteria['ma_dzieci_open']) && $kryteria['ma_dzieci_open'] != '')
		{
			$a = '';
			if (isset($kryteria['druga_tura_licz']) && $kryteria['druga_tura_licz'])
			{
				$a .= ' AND druga_tura_apartament > 0';
			}
			if (isset($kryteria['pierwsza_tura_licz']) && $kryteria['pierwsza_tura_licz'])
			{
				$a .= ' AND (druga_tura_apartament IS NULL OR druga_tura_apartament = 0)';
			}
			$pierwsze_zapytanie = 'SELECT id_parent FROM '.$this->tabela.' WHERE id_parent IS NOT NULL AND ';
			if(isset($kryteria['ma_dzieci_open_statusy']))
			{
				$pierwsze_zapytanie .= 'status IN (\''.implode('\' , \'', $kryteria['ma_dzieci_open_statusy'] ).'\') ';
			}
			else
			{
				$pierwsze_zapytanie .= 'status IN (\'active\' , \'open\') ';
			}
			$pierwsze_zapytanie .= 'AND is_reclamation = false'; 
			$pierwsze_zapytanie .= $a.' GROUP BY id_parent';
			
			$typ = $this->pobierzZwracanyTyp();
			$wynik = listaZTablicy($this->zwracaTablice()->pobierzWiele($pierwsze_zapytanie), null, 'id_parent');
			if ($typ == 'zwracaTablice')
				$this->zwracaTablice ();
			if (empty($wynik)) $wynik = array(0);
			$sql .= ' AND (o.id IN ('.  implode(',', $wynik).'))';
			unset($wynik);
		}
		if (isset($kryteria['ma_dzieci_tylko_open_new_progress']) && $kryteria['ma_dzieci_tylko_open_new_progress'] != '')
		{
			$pierwsze_zapytanie = 'SELECT id_parent FROM '.$this->tabela.' WHERE id_parent IS NOT NULL AND status = \'open\' AND status_work IN(\'new\',\'in progress\') AND is_reclamation = false'; 
			$pierwsze_zapytanie .= ' GROUP BY id_parent';
			
			$typ = $this->pobierzZwracanyTyp();
			$wynik = listaZTablicy($this->zwracaTablice()->pobierzWiele($pierwsze_zapytanie), null, 'id_parent');
			if ($typ == 'zwracaTablice')
				$this->zwracaTablice ();
			if (empty($wynik)) $wynik = array(0);
			$sql .= ' AND (o.id IN ('.  implode(',', $wynik).'))';
			unset($wynik);
		}
		
		if (isset($kryteria['ma_reklamacje']) && $kryteria['ma_reklamacje'] != '')
		{
			$pierwsze_zapytanie = 'SELECT id_parent FROM '.$this->tabela.' WHERE id_parent IS NOT NULL AND status = \'active\' AND is_reclamation = true GROUP BY id_parent'; 
			
			$typ = $this->pobierzZwracanyTyp();
			$wynik = listaZTablicy($this->zwracaTablice()->pobierzWiele($pierwsze_zapytanie), null, 'id_parent');
			if ($typ == 'zwracaTablice')
				$this->zwracaTablice ();
			if (empty($wynik)) $wynik = array(0);
			$sql .= ' AND (o.id IN ('.  implode(',', $wynik).'))';
			unset($wynik);
		}
		if (isset($kryteria['idKoordynatora']) && $kryteria['idKoordynatora'] > 0 )
		{
			$sql .= ' AND o.id_coordinator = '.$kryteria['idKoordynatora'].' ';
		}
		if (isset($kryteria['sprawdzony']))
		{
			if ($kryteria['sprawdzony'] !== true)
			{
				$sql .= ' AND sprawdzony = FALSE';
			}
			else
			{
				$sql .= ' AND sprawdzony = TRUE';
			}
		}
		
		if (isset($kryteria['wyslano_do_raportu']))
		{
			if ($kryteria['wyslano_do_raportu'] !== true)
			{
				$sql .= ' AND wyslano_do_raportu = FALSE';
			}
			else
			{
				$sql .= ' AND wyslano_do_raportu = TRUE';
			}
		}
		if (isset($kryteria['wyslano_do_fakturowania']))
		{
			if ($kryteria['wyslano_do_fakturowania'] !== true)
			{
				$sql .= ' AND wyslany_do_fakturowania = FALSE';
			}
			else
			{
				$sql .= ' AND wyslany_do_fakturowania = TRUE';
			}
		}
		if(isset($kryteria['zafakturowano']))
		 {
			 if ($kryteria['zafakturowano'])
			 {
				 $sql.= ' AND zafakturowano = TRUE';
			 }
			 else
			 {
				 $sql.= ' AND zafakturowano = FALSE';
			 }
		}
		if (isset($kryteria['not_charge']) && $kryteria['not_charge'])
		{
			$sql .= ' AND not_charge = TRUE';
		}
		if (isset($kryteria['charge']) && $kryteria['charge'])
		{
			$sql .= ' AND not_charge = FALSE';
		}
		if(isset($kryteria['hours_interval_wymagane']) && $kryteria['hours_interval_wymagane'])
		{
			$sql .= ' AND hours_interval != \'\' ';
		}
		if(isset($kryteria['date_start_wymagane']) && $kryteria['date_start_wymagane'])
		{
			$sql .= ' AND date_start IS NOT NULL ';
		}
		if(isset($kryteria['date_start_null']) && $kryteria['date_start_null'])
		{
			$sql .= ' AND date_start IS NULL ';
		}
		if (isset($kryteria['id_pdf_ustawione']) && $kryteria['id_pdf_ustawione'] )
		{
			$sql .= ' AND id_pdf IS NOT NULL';
		}
		if (isset($kryteria['id_pdf']) && $kryteria['id_pdf'] )
		{
			$sql .= ' AND id_pdf = \''.$kryteria['id_pdf'].'\'';
		}
		if (isset($kryteria['id_user_otworz_zamowienie']) && $kryteria['id_user_otworz_zamowienie'] )
		{
			$sql .= ' AND id_user_otworz_zamowienie = '.$kryteria['id_user_otworz_zamowienie'];
		}
		if (isset($kryteria['id_user_otworz_zamowienie_istnieje']) && $kryteria['id_user_otworz_zamowienie_istnieje'] )
		{
			$sql .= ' AND id_user_otworz_zamowienie > 0 ';
		}
		
		$wynik = $this->pobierzWiele($sql, $pager, $sorter);
		
		if ($count)
		{
			if (isset($wynik[0]) && is_object($wynik[0]))
				$ids = listaZObiektow($wynik, null, 'id');
			else
			{
				$ids = listaZTablicy($wynik, null, 'id');
			}
			if (empty($ids)) $ids = array(0);
			
			$sqlCount = 'SELECT (SELECT COUNT(*) FROM '.$this->tabela.' WHERE id_team = o.id_team AND status = \'active\' AND is_reclamation = false GROUP BY id_team) AS ilosc_przydzielen, '
					. '(SELECT COUNT(*) FROM '.$this->tabela.' WHERE id_parent = o.id AND status IN (\'active\', \'open\') AND is_reclamation = false ';
					if (isset($kryteria['druga_tura_licz']) && $kryteria['druga_tura_licz'])
					{
						$sqlCount .= ' AND druga_tura_apartament > 0';
					}
					if (isset($kryteria['pierwsza_tura_licz']) && $kryteria['pierwsza_tura_licz'])
					{
						$sqlCount .= ' AND (druga_tura_apartament IS NULL OR druga_tura_apartament = 0)';
					}
			$sqlCount.= ') AS ilosc_dzieci, '
				   . '(SELECT COUNT(*) FROM '.$this->tabela.' WHERE id_parent = o.id AND status = \'active\' AND is_reclamation = true) AS ilosc_reklamacji, '
				   . '(SELECT COUNT(*) FROM '.$this->tabela.' WHERE (number_order_get = o.number_order_get AND id_type = o.id_type) ) AS ilosc_zamowien, o.id '
					. 'FROM '.$this->tabela.' o WHERE id IN ('.  implode(',', $ids).')';
		 
			$count = $this->zwracaTablice()->pobierzWiele($sqlCount, null, $sorter);

			$wynik = array_merge_recursive_distinct($count, $wynik);		
		}
		unset($ids);
		
		return $wynik;
	}


	/**
	* Zwraca iloĹ›Ä‡ pasujÄ…cych elementĂłw dla podanych kryteriĂłw w tabeli modul_zamowienia.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT COUNT(*) AS ilosc  FROM ' . $this->tabela . ' o'
				. ' LEFT JOIN modul_klienci k ON o.number_privat_customer = k.id WHERE'
				. ' o.id_projektu = ' . ID_PROJEKTU;
		
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			
			$sql .= ' AND (k.surname ILIKE \'%'.$fraza.'%\''
				. ' OR o.order_name ILIKE \'%'.$fraza.'%\''
				. ' OR k.name ILIKE \'%'.$fraza.'%\''
				. ' OR CONCAT(k.name, \' \', k.surname) ILIKE \'%'.$fraza.'%\''
				. ' OR CONCAT(k.surname, \' \', k.name) ILIKE \'%'.$fraza.'%\''
					  
				. ' OR CONCAT(k.company_name, \' \', k.name, \' \', k.surname) ILIKE \'%'.$fraza.'%\''
				. ' OR CONCAT(k.company_name, \' \', k.surname, \' \', k.name) ILIKE \'%'.$fraza.'%\''
					  
				. ' OR k.company_name ILIKE \'%'.$fraza.'%\''
				. ' OR o.job_description ILIKE \'%'.$fraza.'%\''
				. ' OR k.id_customer::character varying ILIKE \'%'.$fraza.'%\''
				. ' OR k.id::character varying ILIKE \'%'.$fraza.'%\''
				. ' OR k.org_number ILIKE \'%'.$fraza.'%\''
				. ' OR k.email ILIKE \'%'.$fraza.'%\''
				. ' OR k.www ILIKE \'%'.$fraza.'%\''
				. ' OR k.phone_number::character varying LIKE \'%'.$fraza.'%\''
				. ' OR o.city ILIKE \'%'.$fraza.'%\''
				. ' OR o.address ILIKE \'%'.$fraza.'%\''
				. ' OR CONCAT(o.city, \' \', o.address, \' \', o.apartment) ILIKE \'%'.$fraza.'%\''
				. ' OR o.postcode ILIKE \'%'.$fraza.'%\''
				. ' OR o.number_project_get ILIKE \'%'.$fraza.'%\''
				. ' OR o.number_project_inkjops ILIKE \'%'.$fraza.'%\''
				. ' OR o.number_order_get::character varying LIKE \'%'.$fraza.'%\''
				. ' OR o.id::character varying LIKE \'%'.$fraza.'%\''
				. ' OR o.apartment LIKE \'%'.$fraza.'%\''
				. ' OR o.id_pdf LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if(isset($kryteria['id']) && $kryteria['id'])
		{
			$sql .= ' AND o.id = '.intval($kryteria['id']);
		}
		if(isset($kryteria['pierwsza_tura']) && $kryteria['pierwsza_tura'])
		{
			$sql .= ' AND (o.druga_tura_apartament IS NULL OR o.druga_tura_apartament = 0)';
		}
		if(isset($kryteria['druga_tura']) && $kryteria['druga_tura'])
		{
			$sql .= ' AND o.druga_tura_apartament > 0';
		}
		if(isset($kryteria['druga_tura_apartament']) && $kryteria['druga_tura_apartament'] > 0)
		{
			if(is_array($kryteria['druga_tura_apartament']))
				$sql .= ' AND o.druga_tura_apartament IN ('.implode(',', $kryteria['druga_tura_apartament']).') ';
			else
				$sql .= ' AND o.druga_tura_apartament = '.$kryteria['druga_tura_apartament'];
		}
		if(isset($kryteria['id_user_przydziel_apartamenty']) && $kryteria['id_user_przydziel_apartamenty'] > 0)
		{
			$sql .= ' AND o.id_user_przydziel_apartamenty = '.intval($kryteria['id_user_przydziel_apartamenty']).' ';
		}
		if(isset($kryteria['bez_apartmentu']) && $kryteria['bez_apartmentu'])
		{
			$sql .= ' AND o.apartment IS NULL ';
		}
		if(isset($kryteria['dokladny_address']) && $kryteria['dokladny_address'] !='')
		{
			$fraza = addslashes($kryteria['dokladny_address']);
			$sql .= ' AND o.address = \''.$fraza.'\' ';
		}
		if(isset($kryteria['dokladny_city']) && $kryteria['dokladny_city'] !='')
		{
			$fraza = addslashes($kryteria['dokladny_city']);
			$sql .= ' AND o.city = \''.$fraza.'\' ';
		}
		if(isset($kryteria['dokladny_postcode']) && $kryteria['dokladny_postcode'] !='')
		{
			$fraza = addslashes($kryteria['dokladny_postcode']);
			$sql .= ' AND o.postcode = \''.$fraza.'\' ';
		}
		if(isset($kryteria['id_project_leader_bkt']) && $kryteria['id_project_leader_bkt'] !='' && $kryteria['id_project_leader_bkt'] > 0)
		{
			$sql .= ' AND o.id_project_leader_bkt = '.intval($kryteria['id_project_leader_bkt']).'';
		}
		if(isset($kryteria['!wiele_id']) && is_array($kryteria['!wiele_id']) && count($kryteria['!wiele_id']) > 0 )
		{
			$sql .= ' AND o.id NOT IN ('.implode(', ', $kryteria['!wiele_id']).')';
		}
		if(isset($kryteria['wiele_id']) && is_array($kryteria['wiele_id']) && count($kryteria['wiele_id']) > 0 )
		{
			$sql .= ' AND o.id IN ('.implode(', ', $kryteria['wiele_id']).')';
		}
		if (isset($kryteria['id_parent']) && $kryteria['id_parent'] > 0)
		{
			$sql .= ' AND o.id_parent = '.intval($kryteria['id_parent']);
		}
		if (isset($kryteria['bez_rodzica']) && $kryteria['bez_rodzica'] == 1)
		{
			$sql .= ' AND o.id_parent IS NULL';
		}
		if (isset($kryteria['id_team']) && $kryteria['id_team'] > 0)
		{
			$sql .= ' AND o.id_team = '.intval($kryteria['id_team']);
		}
		if (isset($kryteria['id_team_array']) && $kryteria['id_team_array'] > 0)
		{
			$sql .= ' AND o.id_team IN('.implode(', ', $kryteria['id_team_array']).')';
		}
		if (isset($kryteria['bez_teamu']) && $kryteria['bez_teamu'] == 1)
		{
			$sql .= ' AND ( o.id_team IS NULL OR o.id_team < 1 )';
		}
		if (isset($kryteria['przydzielone']) && $kryteria['przydzielone'] == 1)
		{
			$sql .= ' AND o.id_team > 0 ';
		}
		if (isset($kryteria['!id_team']) && $kryteria['!id_team'] != '')
		{
			if(is_array($kryteria['!id_team']) && count($kryteria['!id_team']) > 0)
				$sql .= ' AND ( o.id_team NOT IN ('.implode(', ', $kryteria['!id_team']).'))';
			else
				$sql .= ' AND o.id_team != '.$kryteria['!id_team'];
				
		}
		if (isset($kryteria['id_type']))
		{
			if (is_array($kryteria['id_type']))
			{
				$sql .= ' AND o.id_type IN ('.implode(', ', $kryteria['id_type']).')';
			}
			else
			{
				$sql .= ' AND o.id_type = '.intval($kryteria['id_type']);
			}
		}
		if (isset($kryteria['id_types']))
		{
			if (is_array($kryteria['id_types']))
			{
				$sql .= ' AND o.id_type IN ('.implode(', ', $kryteria['id_types']).')';
			}
			else
			{
				$sql .= ' AND o.id_type = '.intval($kryteria['id_types']);
			}
		}
		if (isset($kryteria['number_order_get']) && $kryteria['number_order_get'] > 0)
		{
			if(is_array($kryteria['number_order_get']) && count($kryteria['number_order_get']))
			{
				$sql .= ' AND o.number_order_get IN ('.implode(',', $kryteria['number_order_get']).')';
			}
			else
			{
				$fraza = addslashes($kryteria['number_order_get']);
				$sql .= ' AND o.number_order_get = '.$fraza.'';
			}
			// $sql .= ' AND o.number_order_get = '.intval($kryteria['number_order_get']);
		}
		if (isset($kryteria['number_order_bkt']) && $kryteria['number_order_bkt'] > 0)
		{
			$sql .= ' AND o.number_order_bkt = '.intval($kryteria['number_order_bkt']);
		}
		if (isset($kryteria['number_customer']) && $kryteria['number_customer'] > 0)
		{
			$sql .= ' AND o.number_customer = '.intval($kryteria['number_customer']);
		}
		if (isset($kryteria['not_number_customer']) && $kryteria['not_number_customer'] > 0)
		{
			$sql .= ' AND o.number_customer <> '.intval($kryteria['not_number_customer']);
		}
		if (isset($kryteria['number_privat_customer']) && $kryteria['number_privat_customer'] > 0)
		{
			$sql .= ' AND o.number_privat_customer = '.intval($kryteria['number_privat_customer']);
		}
		if (isset($kryteria['number_project_get']) && $kryteria['number_project_get'] != '')
		{
			$sql .= ' AND o.number_project_get ILIKE \''.strval($kryteria['number_project_get']).'%\'';
		}
		if (isset($kryteria['number_contact_id']) && $kryteria['number_contact_id'] > 0)
		{
			$sql .= ' AND o.number_contact_id = '.intval($kryteria['number_contact_id']);
		}
		if (isset($kryteria['charge_type']) && $kryteria['charge_type'] != '')
		{
			if (is_array($kryteria['charge_type']))
			{
				$sql .= ' AND o.charge_type IN(\''.implode('\',\'', $kryteria['charge_type']).'\') ';
			}
			else
			{
			$sql .= ' AND o.charge_type = \''.$kryteria['charge_type'].'\'';
		}
		}
		// Daty warunki
		if (isset($kryteria['date_added_od']) && $kryteria['date_added_od'] != '')
		{
			$sql .= ' AND o.date_added >= \''.$kryteria['date_added_od'].'\'';
		}
		if (isset($kryteria['date_start_rowne']) && $kryteria['date_start_rowne'] != '')
		{
			$sql .= ' AND o.date_start = \''.$kryteria['date_start_rowne'].'\'';
		}
		if (isset($kryteria['data_zakonczenia_rowne']) && $kryteria['data_zakonczenia_rowne'] != '')
		{
			$sql .= ' AND o.data_zakonczenia = \''.$kryteria['data_zakonczenia_rowne'].'\'';
		}
		if (isset($kryteria['data_start_array']) && count($kryteria['data_start_array']) > 0)
		{
			$sql .= ' AND o.date_start IN(\''.implode('\',\'', $kryteria['data_start_array']).'\')';
		}
		if (isset($kryteria['date_start_od']) && $kryteria['date_start_od'] != '')
		{
			$sql .= ' AND o.date_start >= \''.$kryteria['date_start_od'].'\'';
		}
		if (isset($kryteria['date_stop_od']) && $kryteria['date_stop_od'] != '')
		{
			$sql .= ' AND o.date_stop >= \''.$kryteria['date_stop_od'].'\'';
		}
		
		if (isset($kryteria['date_added_do']) && $kryteria['date_added_do'] != '')
		{
			$sql .= ' AND o.date_added <= \''.$kryteria['date_added_do'].'\'';
		}
		if (isset($kryteria['date_start_do']) && $kryteria['date_start_do'] != '')
		{
			$sql .= ' AND o.date_start <= \''.$kryteria['date_start_do'].'\'';
		}
		if (isset($kryteria['date_stop_do']) && $kryteria['date_stop_do'] != '')
		{
			$sql .= ' AND o.date_stop <= \''.$kryteria['date_stop_do'].'\'';
		}
		
		if (isset($kryteria['data_zakonczenia_od']) && $kryteria['data_zakonczenia_od'] != '' && isset($kryteria['data_zakonczenia_do']) && $kryteria['data_zakonczenia_do'] != '')
		{
			if (strlen($kryteria['data_zakonczenia_od']) == 10) $data_zakonczenia_od = $kryteria['data_zakonczenia_od'].' 00:00:00';
			else $data_zakonczenia_od = $kryteria['data_zakonczenia_od'];
			
			if (strlen($kryteria['data_zakonczenia_do']) == 10) $data_zakonczenia_do = $kryteria['data_zakonczenia_do'].' 23:59:59';
			else $data_zakonczenia_do = $kryteria['data_zakonczenia_do'];
			
			$sql .= ' AND o.data_zakonczenia IS NOT null AND (o.data_zakonczenia BETWEEN \''.$data_zakonczenia_od.'\' AND \''.$data_zakonczenia_do.'\')';
		}
		else
		{
			if (isset($kryteria['data_zakonczenia_od']) && $kryteria['data_zakonczenia_od'] != '')
			{
				$sql .= ' AND o.data_zakonczenia IS NOT null AND o.data_zakonczenia >= \''.$kryteria['data_zakonczenia_od'].' 00:00:00\'';
			}
			if (isset($kryteria['data_zakonczenia_do']) && $kryteria['data_zakonczenia_do'] != '')
			{
				$sql .= ' AND o.data_zakonczenia IS NOT null AND o.data_zakonczenia <= \''.$kryteria['data_zakonczenia_do'].' 23:59:59\'';
			}
		}
		
		if (isset($kryteria['status']) && $kryteria['status'] != '')
		{
			if (is_array($kryteria['status']) && count($kryteria['status']) > 0)
			{
				$sql .= ' AND o.status IN(\''.implode('\',\'', $kryteria['status']).'\') ';
			}
			else
			{
				$sql .= ' AND o.status = \''.$kryteria['status'].'\'';
			}
		}
		if (isset($kryteria['!status']) && $kryteria['!status'] != '')
		{
			if (is_array($kryteria['!status']) && count($kryteria['!status']) > 0)
			{
				$sql .= ' AND o.status NOT IN(\''.implode('\',\'', $kryteria['!status']).'\') ';
			}
			else
			{
				$sql .= ' AND o.status <> \''.$kryteria['!status'].'\'';
			}
		}
		if (isset($kryteria['hours_interval']) && $kryteria['hours_interval'] != '')
		{
			$sql .= ' AND o.hours_interval LIKE \'%'.$kryteria['hours_interval'].'%\'';
		}
		if (isset($kryteria['hours_interval_array']) && count($kryteria['hours_interval_array']) > 0)
		{
			$sql .= ' AND o.hours_interval IN(\''.implode('\',\'', $kryteria['hours_interval_array']).'\')';
		}
		if (isset($kryteria['total_time']) && $kryteria['total_time'] > 0)
		{
			$sql .= ' AND o.total_time = '.intval($kryteria['total_time']);
		}
		if (isset($kryteria['status_work']) && $kryteria['status_work'] != '')
		{
			if (is_array($kryteria['status_work']))
			{
				$sql .= ' AND o.status_work IN(\''.implode('\',\'', $kryteria['status_work']).'\')';
			}
			else
			{	
				$sql .= ' AND o.status_work = \''.$kryteria['status_work'].'\'';
			}
		}
		if (isset($kryteria['!status_work']) && $kryteria['!status_work'] != '')
		{
			if (is_array($kryteria['!status_work']))
			{
				$sql .= ' AND o.status_work NOT IN(\''.implode('\',\'', $kryteria['!status_work']).'\')';
			}
			else
			{	
				$sql .= ' AND o.status_work <> \''.$kryteria['!status_work'].'\'';
			}
		}
		if (isset($kryteria['address']) && $kryteria['address'] != '')
		{
			$sql .= ' AND o.address ILIKE \'%'.$kryteria['address'].'%\'';
		}
		if (isset($kryteria['city']) && $kryteria['city'] != '')
		{
			$sql .= ' AND o.city ILIKE \'%'.$kryteria['city'].'%\'';
		}
		if (isset($kryteria['postcode']) && $kryteria['postcode'] != '')
		{
			$sql .= ' AND o.postcode = \''.$kryteria['postcode'].'\'';
		}
		if (isset($kryteria['postcode_od']) && $kryteria['postcode_od'] != '')
		{
			$sql .= ' AND o.postcode >= \''.$kryteria['postcode_od'].'\'';
		}
		if (isset($kryteria['postcode_do']) && $kryteria['postcode_do'] != '')
		{
			$sql .= ' AND o.postcode <= \''.$kryteria['postcode_do'].'\'';
		}
		if (isset($kryteria['budget']) && $kryteria['budget'] > 0)
		{
			$sql .= ' AND o.budget = \''.$kryteria['budget'].'\'';
		}
		if (isset($kryteria['node_villa_code']) && $kryteria['node_villa_code'] != '')
		{
			$sql .= ' AND o.node_villa_code ILIKE \''.$kryteria['node_villa_code'].'%\'';
		}
		if (isset($kryteria['is_reclamation']))
		{
			$is_reclamation = ($kryteria['is_reclamation']) ? 'true': 'false';
			$sql .= ' AND o.is_reclamation = '. $is_reclamation;
		}
		if (isset($kryteria['ma_dzieci']) && $kryteria['ma_dzieci'] != '')
		{	
			$pierwsze_zapytanie = 'SELECT id_parent FROM '.$this->tabela.' WHERE id_parent IS NOT NULL AND '; 
			if(isset($kryteria['ma_dzieci_statusy']))
			{
				$pierwsze_zapytanie .= ' status IN (\''.implode('\',\'', $kryteria['ma_dzieci_statusy']).'\') AND is_reclamation = false'; 
			}
			else
			{
				$pierwsze_zapytanie .= ' status = \'active\' AND is_reclamation = false'; 
			}
			$pierwsze_zapytanie .= ' GROUP BY id_parent';
			
			$typ = $this->pobierzZwracanyTyp();
			$wynik = listaZTablicy($this->zwracaTablice()->pobierzWiele($pierwsze_zapytanie), null, 'id_parent');
			if ($typ == 'zwracaTablice')
				$this->zwracaTablice ();
			if (empty($wynik)) $wynik = array(0);
			$sql .= ' AND (o.id IN ('.  implode(',', $wynik).'))';
			unset($wynik);
		}
		if (isset($kryteria['ma_dzieci_open']) && $kryteria['ma_dzieci_open'] != '')
		{
			$a = '';
			if (isset($kryteria['druga_tura_licz']) && $kryteria['druga_tura_licz'])
			{
				$a .= ' AND druga_tura_apartament > 0';
			}
			if (isset($kryteria['pierwsza_tura_licz']) && $kryteria['pierwsza_tura_licz'])
			{
				$a .= ' AND (druga_tura_apartament IS NULL OR druga_tura_apartament = 0)';
			}
			$pierwsze_zapytanie = 'SELECT id_parent FROM '.$this->tabela.' WHERE id_parent IS NOT NULL AND ';
			if(isset($kryteria['ma_dzieci_open_statusy']))
			{
				$pierwsze_zapytanie .= 'status IN (\''.implode('\' , \'', $kryteria['ma_dzieci_open_statusy'] ).'\') ';
			}
			else
			{
				$pierwsze_zapytanie .= 'status IN (\'active\' , \'open\') ';
			}
			$pierwsze_zapytanie .= 'AND is_reclamation = false'; 
			$pierwsze_zapytanie .= $a.' GROUP BY id_parent';
			$typ = $this->pobierzZwracanyTyp();
			$wynik = listaZTablicy($this->zwracaTablice()->pobierzWiele($pierwsze_zapytanie), null, 'id_parent');
			if ($typ == 'zwracaTablice')
				$this->zwracaTablice ();
			if (empty($wynik)) $wynik = array(0);
			$sql .= ' AND (o.id IN ('.  implode(',', $wynik).'))';
			unset($wynik);
		}
		if (isset($kryteria['ma_dzieci_tylko_open_new_progress']) && $kryteria['ma_dzieci_tylko_open_new_progress'] != '')
		{
			$pierwsze_zapytanie = 'SELECT id_parent FROM '.$this->tabela.' WHERE id_parent IS NOT NULL AND status = \'open\' AND status_work IN(\'new\',\'in progress\') AND is_reclamation = false'; 
			$pierwsze_zapytanie .= ' GROUP BY id_parent';
			
			$typ = $this->pobierzZwracanyTyp();
			$wynik = listaZTablicy($this->zwracaTablice()->pobierzWiele($pierwsze_zapytanie), null, 'id_parent');
			if ($typ == 'zwracaTablice')
				$this->zwracaTablice ();
			if (empty($wynik)) $wynik = array(0);
			$sql .= ' AND (o.id IN ('.  implode(',', $wynik).'))';
			unset($wynik);
		}
		
		if (isset($kryteria['ma_reklamacje']) && $kryteria['ma_reklamacje'] != '')
		{
			$pierwsze_zapytanie = 'SELECT id_parent FROM '.$this->tabela.' WHERE id_parent IS NOT NULL AND status = \'active\' AND is_reclamation = true GROUP BY id_parent'; 
			
			$typ = $this->pobierzZwracanyTyp();
			$wynik = listaZTablicy($this->zwracaTablice()->pobierzWiele($pierwsze_zapytanie), null, 'id_parent');
			if ($typ == 'zwracaTablice')
				$this->zwracaTablice ();
			if (empty($wynik)) $wynik = array(0);
			$sql .= ' AND (o.id IN ('.  implode(',', $wynik).'))';
			unset($wynik);
		}
		if (isset($kryteria['idKoordynatora']) && $kryteria['idKoordynatora'] > 0 )
		{
			$sql .= ' AND o.id_coordinator = '.$kryteria['idKoordynatora'].' ';
		}
		
		if (isset($kryteria['sprawdzony']))
		{
			if ($kryteria['sprawdzony'] !== true)
			{
				$sql .= ' AND sprawdzony = FALSE';
			}
			else
			{
				$sql .= ' AND sprawdzony = TRUE';
			}
		}
		
		if (isset($kryteria['wyslano_do_raportu']))
		{
			if ($kryteria['wyslano_do_raportu'] !== true)
			{
				$sql .= ' AND wyslano_do_raportu = FALSE';
			}
			else
			{
				$sql .= ' AND wyslano_do_raportu = TRUE';
			}
		}
		if (isset($kryteria['wyslano_do_fakturowania']))
		{
			if ($kryteria['wyslano_do_fakturowania'] !== true)
			{
				$sql .= ' AND wyslany_do_fakturowania = FALSE';
			}
			else
			{
				$sql .= ' AND wyslany_do_fakturowania = TRUE';
			}
		}
		if(isset($kryteria['zafakturowano']))
		 {
			 if ($kryteria['zafakturowano'])
			 {
				 $sql.= ' AND zafakturowano = TRUE';
			 }
			 else
			 {
				 $sql.= ' AND zafakturowano = FALSE';
			 }
		}
		if (isset($kryteria['not_charge']) && $kryteria['not_charge'])
		{
			$sql .= ' AND not_charge = TRUE';
		}
		if (isset($kryteria['charge']) && $kryteria['charge'])
		{
			$sql .= ' AND not_charge = FALSE';
		}
		if(isset($kryteria['hours_interval_wymagane']) && $kryteria['hours_interval_wymagane'])
		{
			$sql .= ' AND hours_interval != \'\' ';
		}
		if(isset($kryteria['date_start_wymagane']) && $kryteria['date_start_wymagane'])
		{
			$sql .= ' AND date_start IS NOT NULL ';
		}
		if (isset($kryteria['id_pdf_ustawione']) && $kryteria['id_pdf_ustawione'] )
		{
			$sql .= ' AND id_pdf IS NOT NULL';
		}
		if (isset($kryteria['id_pdf']) && $kryteria['id_pdf'] )
		{
			$sql .= ' AND id_pdf = \''.$kryteria['id_pdf'].'\'';
		}
		if (isset($kryteria['id_user_otworz_zamowienie']) && $kryteria['id_user_otworz_zamowienie'] )
		{
			$sql .= ' AND id_user_otworz_zamowienie = '.$kryteria['id_user_otworz_zamowienie'];
		}
		if (isset($kryteria['id_user_otworz_zamowienie_istnieje']) && $kryteria['id_user_otworz_zamowienie_istnieje'] )
		{
			$sql .= ' AND id_user_otworz_zamowienie > 0 ';
		}

		return $this->pobierzWartosc($sql);
	}
	
	public function iloscSzukajZamowienia($kryteria)
	{
		$sql = 'SELECT COUNT(*) AS ilosc  FROM ' . $this->tabela . ' o WHERE'
				. ' id_projektu = ' . ID_PROJEKTU;
		
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			
			$sql .= ' AND order_name ILIKE \'%'.$fraza.'%\''
				. ' OR job_description ILIKE \'%'.$fraza.'%\''
				. ' OR city ILIKE \'%'.$fraza.'%\''
				. ' OR address ILIKE \'%'.$fraza.'%\''
				. ' OR postcode ILIKE \'%'.$fraza.'%\''
				. ' OR number_project_get ILIKE \'%'.$fraza.'%\''
				. ' OR number_project_inkjops ILIKE \'%'.$fraza.'%\''
				. ' OR number_order_get::character varying LIKE \'%'.$fraza.'%\''
				. ' OR id::character varying LIKE \'%'.$fraza.'%\''
				. ' OR apartment LIKE \'%'.$fraza.'%\''
				. ' OR id_pdf LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if(isset($kryteria['pierwsza_tura']) && $kryteria['pierwsza_tura'])
		{
			$sql .= ' AND (druga_tura_apartament IS NULL OR druga_tura_apartament = 0)';
		}
		if(isset($kryteria['druga_tura']) && $kryteria['druga_tura'])
		{
			$sql .= ' AND druga_tura_apartament > 0';
		}
		if(isset($kryteria['id_user_przydziel_apartamenty']) && $kryteria['id_user_przydziel_apartamenty'] > 0)
		{
			$sql .= ' AND id_user_przydziel_apartamenty = '.intval($kryteria['id_user_przydziel_apartamenty']).' ';
		}
		if(isset($kryteria['bez_apartmentu']) && $kryteria['bez_apartmentu'])
		{
			$sql .= ' AND apartment IS NULL ';
		}
		if(isset($kryteria['dokladny_address']) && $kryteria['dokladny_address'] !='')
		{
			$fraza = addslashes($kryteria['dokladny_address']);
			$sql .= ' AND address = \''.$fraza.'\' ';
		}
		if(isset($kryteria['dokladny_city']) && $kryteria['dokladny_city'] !='')
		{
			$fraza = addslashes($kryteria['dokladny_city']);
			$sql .= ' AND city = \''.$fraza.'\' ';
		}
		if(isset($kryteria['dokladny_postcode']) && $kryteria['dokladny_postcode'] !='')
		{
			$fraza = addslashes($kryteria['dokladny_postcode']);
			$sql .= ' AND postcode = \''.$fraza.'\' ';
		}
		if(isset($kryteria['id_project_leader_bkt']) && $kryteria['id_project_leader_bkt'] !='' && $kryteria['id_project_leader_bkt'] > 0)
		{
			$sql .= ' AND id_project_leader_bkt = '.intval($kryteria['id_project_leader_bkt']).'';
		}
		if(isset($kryteria['!wiele_id']) && is_array($kryteria['!wiele_id']) && count($kryteria['!wiele_id']) > 0 )
		{
			$sql .= ' AND id NOT IN ('.implode(', ', $kryteria['!wiele_id']).')';
		}
		if(isset($kryteria['wiele_id']) && is_array($kryteria['wiele_id']) && count($kryteria['wiele_id']) > 0 )
		{
			$sql .= ' AND id IN ('.implode(', ', $kryteria['wiele_id']).')';
		}
		if (isset($kryteria['id_parent']) && $kryteria['id_parent'] > 0)
		{
			$sql .= ' AND id_parent = '.intval($kryteria['id_parent']);
		}
		if (isset($kryteria['bez_rodzica']) && $kryteria['bez_rodzica'] == 1)
		{
			$sql .= ' AND id_parent IS NULL';
		}
		if (isset($kryteria['id_team']) && $kryteria['id_team'] > 0)
		{
			$sql .= ' AND id_team = '.intval($kryteria['id_team']);
		}
		if (isset($kryteria['id_team_array']) && $kryteria['id_team_array'] > 0)
		{
			$sql .= ' AND id_team IN('.implode(', ', $kryteria['id_team_array']).')';
		}
		if (isset($kryteria['bez_teamu']) && $kryteria['bez_teamu'] == 1)
		{
			$sql .= ' AND ( id_team IS NULL OR id_team < 1 )';
		}
		if (isset($kryteria['!id_team']) && $kryteria['!id_team'] != '')
		{
			if(is_array($kryteria['!id_team']) && count($kryteria['!id_team']) > 0)
				$sql .= ' AND ( id_team NOT IN ('.implode(', ', $kryteria['!id_team']).'))';
			else
				$sql .= ' AND id_team != '.$kryteria['!id_team'];
				
		}
		if (isset($kryteria['przydzielone']) && $kryteria['przydzielone'] == 1)
		{
			$sql .= ' AND id_team > 0 ';
		}
		if (isset($kryteria['id_type']))
		{
			if (is_array($kryteria['id_type']))
			{
				$sql .= ' AND id_type IN ('.implode(', ', $kryteria['id_type']).')';
			}
			else
			{
				$sql .= ' AND id_type = '.intval($kryteria['id_type']);
			}
		}
		if (isset($kryteria['id_types']))
		{
			if (is_array($kryteria['id_types']))
			{
				$sql .= ' AND id_type IN ('.implode(', ', $kryteria['id_types']).')';
			}
			else
			{
				$sql .= ' AND id_type = '.intval($kryteria['id_types']);
			}
		}
		if (isset($kryteria['number_order_get']) && $kryteria['number_order_get'] > 0)
		{
			$sql .= ' AND number_order_get = '.intval($kryteria['number_order_get']);
		}
		if (isset($kryteria['number_order_bkt']) && $kryteria['number_order_bkt'] > 0)
		{
			$sql .= ' AND number_order_bkt = '.intval($kryteria['number_order_bkt']);
		}
		if (isset($kryteria['number_customer']) && $kryteria['number_customer'] > 0)
		{
			$sql .= ' AND number_customer = '.intval($kryteria['number_customer']);
		}
		if (isset($kryteria['not_number_customer']) && $kryteria['not_number_customer'] > 0)
		{
			$sql .= ' AND number_customer <> '.intval($kryteria['not_number_customer']);
		}
		if (isset($kryteria['number_privat_customer']) && $kryteria['number_privat_customer'] > 0)
		{
			$sql .= ' AND number_privat_customer = '.intval($kryteria['number_privat_customer']);
		}
		if (isset($kryteria['number_project_get']) && $kryteria['number_project_get'] != '')
		{
			$sql .= ' AND number_project_get ILIKE \''.strval($kryteria['number_project_get']).'%\'';
		}
		if (isset($kryteria['number_contact_id']) && $kryteria['number_contact_id'] > 0)
		{
			$sql .= ' AND number_contact_id = '.intval($kryteria['number_contact_id']);
		}
		if (isset($kryteria['charge_type']) && $kryteria['charge_type'] != '')
		{
			if (is_array($kryteria['charge_type']))
			{
				$sql .= ' AND charge_type IN(\''.implode('\',\'', $kryteria['charge_type']).'\') ';
			}
			else
			{
			$sql .= ' AND charge_type = \''.$kryteria['charge_type'].'\'';
		}
		}
		// Daty warunki
		if (isset($kryteria['date_added_od']) && $kryteria['date_added_od'] != '')
		{
			$sql .= ' AND date_added >= \''.$kryteria['date_added_od'].'\'';
		}
		if (isset($kryteria['date_start_rowne']) && $kryteria['date_start_rowne'] != '')
		{
			$sql .= ' AND date_start = \''.$kryteria['date_start_rowne'].'\'';
		}
		if (isset($kryteria['data_zakonczenia_rowne']) && $kryteria['data_zakonczenia_rowne'] != '')
		{
			$sql .= ' AND data_zakonczenia = \''.$kryteria['data_zakonczenia_rowne'].'\'';
		}
		if (isset($kryteria['data_start_array']) && count($kryteria['data_start_array']) > 0)
		{
			$sql .= ' AND date_start IN(\''.implode('\',\'', $kryteria['data_start_array']).'\')';
		}
		if (isset($kryteria['date_start_od']) && $kryteria['date_start_od'] != '')
		{
			$sql .= ' AND date_start >= \''.$kryteria['date_start_od'].'\'';
		}
		if (isset($kryteria['date_stop_od']) && $kryteria['date_stop_od'] != '')
		{
			$sql .= ' AND date_stop >= \''.$kryteria['date_stop_od'].'\'';
		}
		
		if (isset($kryteria['date_added_do']) && $kryteria['date_added_do'] != '')
		{
			$sql .= ' AND date_added <= \''.$kryteria['date_added_do'].'\'';
		}
		if (isset($kryteria['date_start_do']) && $kryteria['date_start_do'] != '')
		{
			$sql .= ' AND date_start <= \''.$kryteria['date_start_do'].'\'';
		}
		if (isset($kryteria['date_stop_do']) && $kryteria['date_stop_do'] != '')
		{
			$sql .= ' AND date_stop <= \''.$kryteria['date_stop_do'].'\'';
		}
		
		if (isset($kryteria['data_zakonczenia_od']) && $kryteria['data_zakonczenia_od'] != '' && isset($kryteria['data_zakonczenia_do']) && $kryteria['data_zakonczenia_do'] != '')
		{
			if (strlen($kryteria['data_zakonczenia_od']) == 10) $data_zakonczenia_od = $kryteria['data_zakonczenia_od'].' 00:00:00';
			else $data_zakonczenia_od = $kryteria['data_zakonczenia_od'];
			
			if (strlen($kryteria['data_zakonczenia_do']) == 10) $data_zakonczenia_do = $kryteria['data_zakonczenia_do'].' 23:59:59';
			else $data_zakonczenia_do = $kryteria['data_zakonczenia_do'];
			
			$sql .= ' AND data_zakonczenia IS NOT null AND (data_zakonczenia BETWEEN \''.$data_zakonczenia_od.'\' AND \''.$data_zakonczenia_do.'\')';
		}
		else
		{
			if (isset($kryteria['data_zakonczenia_od']) && $kryteria['data_zakonczenia_od'] != '')
			{
				$sql .= ' AND data_zakonczenia IS NOT null AND data_zakonczenia >= \''.$kryteria['data_zakonczenia_od'].' 00:00:00\'';
			}
			if (isset($kryteria['data_zakonczenia_do']) && $kryteria['data_zakonczenia_do'] != '')
			{
				$sql .= ' AND data_zakonczenia IS NOT null AND data_zakonczenia <= \''.$kryteria['data_zakonczenia_do'].' 23:59:59\'';
			}
		}
		
		if (isset($kryteria['status']) && $kryteria['status'] != '')
		{
			if (is_array($kryteria['status']) && count($kryteria['status']) > 0)
			{
				$sql .= ' AND status IN(\''.implode('\',\'', $kryteria['status']).'\') ';
			}
			else
			{
				$sql .= ' AND status = \''.$kryteria['status'].'\'';
			}
		}
		if (isset($kryteria['!status']) && $kryteria['!status'] != '')
		{
			if (is_array($kryteria['!status']) && count($kryteria['!status']) > 0)
			{
				$sql .= ' AND status NOT IN(\''.implode('\',\'', $kryteria['!status']).'\') ';
			}
			else
			{
				$sql .= ' AND status <> \''.$kryteria['!status'].'\'';
			}
		}
		if (isset($kryteria['hours_interval']) && $kryteria['hours_interval'] != '')
		{
			$sql .= ' AND hours_interval LIKE \'%'.$kryteria['hours_interval'].'%\'';
		}
		if (isset($kryteria['hours_interval_array']) && count($kryteria['hours_interval_array']) > 0)
		{
			$sql .= ' AND hours_interval IN(\''.implode('\',\'', $kryteria['hours_interval_array']).'\')';
		}
		if (isset($kryteria['total_time']) && $kryteria['total_time'] > 0)
		{
			$sql .= ' AND total_time = '.intval($kryteria['total_time']);
		}
		if (isset($kryteria['status_work']) && $kryteria['status_work'] != '')
		{
			if (is_array($kryteria['status_work']))
			{
				$sql .= ' AND status_work IN(\''.implode('\',\'', $kryteria['status_work']).'\')';
			}
			else
			{	
				$sql .= ' AND status_work = \''.$kryteria['status_work'].'\'';
			}
		}
		if (isset($kryteria['!status_work']) && $kryteria['!status_work'] != '')
		{
			if (is_array($kryteria['!status_work']))
			{
				$sql .= ' AND status_work NOT IN(\''.implode('\',\'', $kryteria['!status_work']).'\')';
			}
			else
			{	
				$sql .= ' AND status_work <> \''.$kryteria['!status_work'].'\'';
			}
		}
		if (isset($kryteria['address']) && $kryteria['address'] != '')
		{
			$sql .= ' AND address ILIKE \'%'.$kryteria['address'].'%\'';
		}
		if (isset($kryteria['city']) && $kryteria['city'] != '')
		{
			$sql .= ' AND city ILIKE \'%'.$kryteria['city'].'%\'';
		}
		if (isset($kryteria['postcode']) && $kryteria['postcode'] != '')
		{
			$sql .= ' AND postcode = \''.$kryteria['postcode'].'\'';
		}
		if (isset($kryteria['postcode_od']) && $kryteria['postcode_od'] != '')
		{
			$sql .= ' AND postcode >= \''.$kryteria['postcode_od'].'\'';
		}
		if (isset($kryteria['postcode_do']) && $kryteria['postcode_do'] != '')
		{
			$sql .= ' AND postcode <= \''.$kryteria['postcode_do'].'\'';
		}
		if (isset($kryteria['budget']) && $kryteria['budget'] > 0)
		{
			$sql .= ' AND budget = \''.$kryteria['budget'].'\'';
		}
		if (isset($kryteria['node_villa_code']) && $kryteria['node_villa_code'] != '')
		{
			$sql .= ' AND node_villa_code ILIKE \''.$kryteria['node_villa_code'].'%\'';
		}
		if (isset($kryteria['is_reclamation']))
		{
			$is_reclamation = ($kryteria['is_reclamation']) ? 'true': 'false';
			$sql .= ' AND is_reclamation = '. $is_reclamation;
		}
		if (isset($kryteria['ma_dzieci']) && $kryteria['ma_dzieci'] != '')
		{
			$sql .= ' AND (SELECT COUNT(*) FROM '.$this->tabela.' WHERE id_parent = o.id AND status = \'active\' AND is_reclamation = false) > 0';
		}
		if (isset($kryteria['ma_dzieci']) && $kryteria['ma_dzieci'] != '')
		{	
			$pierwsze_zapytanie = 'SELECT id_parent FROM '.$this->tabela.' WHERE id_parent IS NOT NULL AND ';
			if(isset($kryteria['ma_dzieci_statusy']))
			{
				$pierwsze_zapytanie .= 'status IN '.implode(',', $kryteria['ma_dzieci_statusy']).' AND is_reclamation = false'; 
			}
			else
			{
				$pierwsze_zapytanie .= 'status = \'active\' AND is_reclamation = false'; 
			}
			$pierwsze_zapytanie .= ' GROUP BY id_parent';
			
			$typ = $this->pobierzZwracanyTyp();
			$wynik = listaZTablicy($this->zwracaTablice()->pobierzWiele($pierwsze_zapytanie), null, 'id_parent');
			if ($typ == 'zwracaTablice')
				$this->zwracaTablice();
			if (empty($wynik)) $wynik = array(0);
			
			$sql .= ' AND (o.id IN ('.  implode(',', $wynik).'))';
			unset($wynik);
		}
		if (isset($kryteria['ma_dzieci_open']) && $kryteria['ma_dzieci_open'] != '')
		{
			$a = '';
			if (isset($kryteria['druga_tura_licz']) && $kryteria['druga_tura_licz'])
			{
				$a .= ' AND druga_tura_apartament > 0';
			}
			if (isset($kryteria['pierwsza_tura_licz']) && $kryteria['pierwsza_tura_licz'])
			{
				$a .= ' AND (druga_tura_apartament IS NULL OR druga_tura_apartament = 0) ';
			}
			$pierwsze_zapytanie = 'SELECT id_parent FROM '.$this->tabela.' WHERE id_parent IS NOT NULL AND ';
			if(isset($kryteria['ma_dzieci_open_statusy']))
			{
				$pierwsze_zapytanie .= 'status IN (\''.implode('\' , \'', $kryteria['ma_dzieci_open_statusy'] ).'\') ';
			}
			else
			{
				$pierwsze_zapytanie .= 'status IN (\'active\' , \'open\') ';
			}
			$pierwsze_zapytanie .= 'AND is_reclamation = false'; 
			$pierwsze_zapytanie .= $a.' GROUP BY id_parent';
			
			$typ = $this->pobierzZwracanyTyp();
			$wynik = listaZTablicy($this->zwracaTablice()->pobierzWiele($pierwsze_zapytanie), null, 'id_parent');
			if ($typ == 'zwracaTablice')
				$this->zwracaTablice();
			if (empty($wynik)) $wynik = array(0);
			$sql .= ' AND (o.id IN ('.  implode(',', $wynik).'))';
			unset($wynik);
		}
		if (isset($kryteria['ma_dzieci_tylko_open_new_progress']) && $kryteria['ma_dzieci_tylko_open_new_progress'] != '')
		{
			$pierwsze_zapytanie = 'SELECT id_parent FROM '.$this->tabela.' WHERE id_parent IS NOT NULL AND status = \'open\' AND status_work IN(\'new\',\'in progress\') AND is_reclamation = false'; 
			$pierwsze_zapytanie .= ' GROUP BY id_parent';
			
			$typ = $this->pobierzZwracanyTyp();
			$wynik = listaZTablicy($this->zwracaTablice()->pobierzWiele($pierwsze_zapytanie), null, 'id_parent');
			if ($typ == 'zwracaTablice')
				$this->zwracaTablice();
			if (empty($wynik)) $wynik = array(0);
			$sql .= ' AND (o.id IN ('.  implode(',', $wynik).'))';
			unset($wynik);
		}
		
		if (isset($kryteria['ma_reklamacje']) && $kryteria['ma_reklamacje'] != '')
		{
			$pierwsze_zapytanie = 'SELECT id_parent FROM '.$this->tabela.' WHERE id_parent IS NOT NULL AND status = \'active\' AND is_reclamation = true GROUP BY id_parent'; 
			
			$typ = $this->pobierzZwracanyTyp();
			$wynik = listaZTablicy($this->zwracaTablice()->pobierzWiele($pierwsze_zapytanie), null, 'id_parent');
			if ($typ == 'zwracaTablice')
				$this->zwracaTablice ();
			if (empty($wynik)) $wynik = array(0);
			$sql .= ' AND (o.id IN ('.  implode(',', $wynik).'))';
			unset($wynik);
		}
		if (isset($kryteria['ma_reklamacje']) && $kryteria['ma_reklamacje'] != '')
		{
			$sql .= ' AND (SELECT COUNT(*) FROM '.$this->tabela.' WHERE id_parent = o.id AND status = \'active\' AND is_reclamation = true) > 0';
		}
		if (isset($kryteria['idKoordynatora']) && $kryteria['idKoordynatora'] > 0 )
		{
			$sql .= ' AND id_coordinator = '.$kryteria['idKoordynatora'].' ';
		}
		
		if (isset($kryteria['sprawdzony']))
		{
			if ($kryteria['sprawdzony'] !== true)
			{
				$sql .= ' AND sprawdzony = FALSE';
			}
			else
			{
				$sql .= ' AND sprawdzony = TRUE';
			}
		}
		
		if (isset($kryteria['wyslano_do_raportu']))
		{
			if ($kryteria['wyslano_do_raportu'] !== true)
			{
				$sql .= ' AND wyslano_do_raportu = FALSE';
			}
			else
			{
				$sql .= ' AND wyslano_do_raportu = TRUE';
			}
		}
		if (isset($kryteria['wyslano_do_fakturowania']))
		{
			if ($kryteria['wyslano_do_fakturowania'] !== true)
			{
				$sql .= ' AND wyslany_do_fakturowania = FALSE';
			}
			else
			{
				$sql .= ' AND wyslany_do_fakturowania = TRUE';
			}
		}
		if(isset($kryteria['zafakturowano']))
		 {
			 if ($kryteria['zafakturowano'])
			 {
				 $sql.= ' AND zafakturowano = TRUE';
			 }
			 else
			 {
				 $sql.= ' AND zafakturowano = FALSE';
			 }
		}
		if (isset($kryteria['not_charge']) && $kryteria['not_charge'])
		{
			$sql .= ' AND not_charge = TRUE';
		}
		if (isset($kryteria['charge']) && $kryteria['charge'])
		{
			$sql .= ' AND not_charge = FALSE';
		}
		if(isset($kryteria['hours_interval_wymagane']) && $kryteria['hours_interval_wymagane'])
		{
			$sql .= ' AND hours_interval != \'\' ';
		}
		if(isset($kryteria['date_start_wymagane']) && $kryteria['date_start_wymagane'])
		{
			$sql .= ' AND date_start IS NOT NULL ';
		}
		if (isset($kryteria['id_pdf_ustawione']) && $kryteria['id_pdf_ustawione'] )
		{
			$sql .= ' AND id_pdf IS NOT NULL';
		}
		if (isset($kryteria['id_pdf']) && $kryteria['id_pdf'] )
		{
			$sql .= ' AND id_pdf = \''.$kryteria['id_pdf'].'\'';
		}
		
		return $this->pobierzWartosc($sql);
	}
	
	public function zliczIloscPrzydzielenDlaTeamu($kryteria = Array())
	{
		$sql = 'SELECT COUNT(id_team) AS ilosc_przydzielen, id_team FROM '.$this->tabela.' o WHERE';
		$sql .= ' o.id_projektu = 1 AND o.id_team > 0 ';
		if(isset($kryteria['id_parent']) && $kryteria['id_parent'] > 0)
		{
			$sql .= ' AND o.id_parent = '.intval($kryteria['id_parent']);
		}
		if(isset($kryteria['date_start_rowne']) && $kryteria['date_start_rowne'] != '')
		{
			$sql .= ' AND o.date_start =  \''.$kryteria['date_start_rowne'].'\'';
		}
		if(isset($kryteria['status']) && $kryteria['status'] != '')
		{
			$sql .= ' AND o.status =  \''.$kryteria['status'].'\'';
		}
		if(isset($kryteria['hours_interval']) && $kryteria['hours_interval'] != '')
		{
			$sql .= ' AND o.hours_interval LIKE  \'%'.$kryteria['hours_interval'].'%\'';
		}	
		if(isset($kryteria['status_work']) && $kryteria['status_work'] != '')
		{
			$sql .= ' AND o.status_work =  \''.$kryteria['status_work'].'\' ';
		}	
		$sql .= ' GROUP BY id_team';
			
		return $this->pobierzWiele($sql, null, null);
	}
	
	public function pobierzRodzicowWyszukanych(array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$this->zwracaTablice();
		$warunki_wspolne = '';
		$warunki_wyswietlanie = '';
		$warunki_zleczanie = '';
		$warunki_ilosc_dzieci_biezace = '';
		if (isset($kryteria['id_typow']))
		{
			if (is_array($kryteria['id_typow']))
			{
				$warunki_wspolne .= ' id_type IN ('. implode(',', $kryteria['id_typow']).')';
				$warunki_ilosc_dzieci_biezace .= ' id_type IN ('. implode(',', $kryteria['id_typow']).')'; 
			}
			else
			{
				$warunki_wspolne .= ' id_type = '.intval($kryteria['id_typow']);
				$warunki_ilosc_dzieci_biezace .= ' id_type = '.intval($kryteria['id_typow']);
			}
		}
		if (isset($kryteria['id_team']))
		{
			if (is_array($kryteria['id_team']))
			{
				$warunki_wspolne .= ' AND id_team IN ('. implode(',', $kryteria['id_team']).')';
			}
			else
			{
				$warunki_wspolne .= ' AND id_team = '.intval($kryteria['id_team']);
			}
		}
		if (isset($kryteria['status']))
		{
			if (is_array($kryteria['status']))
			{
				$warunki_wspolne .= ' AND status IN (\''. implode('\',\'', $kryteria['status']).'\')';
				$warunki_ilosc_dzieci_biezace .= ' AND status IN (\''. implode('\',\'', $kryteria['status']).'\')';
			}
			else
			{
				$warunki_wspolne .= ' AND status = \''.$kryteria['status'].'\'';
				$warunki_ilosc_dzieci_biezace .= ' AND status = \''.$kryteria['status'].'\'';
			}
		}
		if (isset($kryteria['status_work']))
		{
			if (is_array($kryteria['status_work']))
			{
				$warunki_wspolne .= ' AND status_work IN (\''. implode('\',\'', $kryteria['status_work']).'\')';
				$warunki_ilosc_dzieci_biezace .= ' AND status_work IN (\''. implode('\',\'', $kryteria['status_work']).'\')';
			}
			else
			{
				$warunki_wspolne .= ' AND status_work = \''.$kryteria['status_work'].'\'';
				$warunki_ilosc_dzieci_biezace .= ' AND status_work = \''.$kryteria['status_work'].'\'';
			}
		}
		if(isset($kryteria['id_pdf']) && $kryteria['id_pdf'])
		{
			$warunki_wspolne .= ' AND id_pdf IS NOT NULL';
			$warunki_ilosc_dzieci_biezace .= ' AND id_pdf IS NOT NULL';
		}
		if (isset($kryteria['data_start_mniejsza_od']))
		{
			$warunki_wspolne .= ' AND date_start <= \''.$kryteria['data_start_mniejsza_od'].'\'';
		}
		
		$sql = 'SELECT '
				. '(SELECT date_start FROM modul_zamowienia WHERE  '.$warunki_wspolne.' '.$warunki_wyswietlanie.' AND id_parent = mz.id ORDER BY date_start ASC LIMIT 1) AS data_pierwszego_zamowienia,'
				. '(SELECT COUNT(id) FROM '.$this->tabela.' WHERE '.$warunki_ilosc_dzieci_biezace.' AND id_parent = mz.id) AS ilosc_dzieci, '
				. '(SELECT COUNT(id) FROM '.$this->tabela.' WHERE '.$warunki_wspolne.' '.$warunki_wyswietlanie.' AND id_parent = mz.id) AS ilosc_dzieci_biezace, '
				. '* FROM '.$this->tabela.' mz WHERE'
				. ' id_projektu = ' . ID_PROJEKTU .'
					  AND id IN (SELECT id_parent FROM '.$this->tabela.' WHERE '.$warunki_wspolne;
		
		
		$sql .= ' GROUP BY id_parent)';
		$sql .= $warunki_wyswietlanie;
		$sql .= ' ORDER BY data_pierwszego_zamowienia';

		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	
	public function pobierzRodzicowWyszukanych2(array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$this->zwracaTablice();
		$warunki_wspolne = '';
		$warunki_wyswietlanie = '';
		$warunki_zleczanie = '';
		if (isset($kryteria['id_typow']))
		{
			if (is_array($kryteria['id_typow']))
			{
				$warunki_wspolne .= ' id_type IN ('. implode(',', $kryteria['id_typow']).')';
			}
			else
			{
				$warunki_wspolne .= ' id_type = '.intval($kryteria['id_typow']);
			}
		}
		if (isset($kryteria['status']))
		{
			if (is_array($kryteria['status']))
			{
				$warunki_wspolne .= ' AND status IN (\''. implode('\',\'', $kryteria['status']).'\')';
			}
			else
			{
				$warunki_wspolne .= ' AND status = \''.$kryteria['status'].'\'';
			}
		}
		if (isset($kryteria['status_work']))
		{
			if (is_array($kryteria['status_work']))
			{
				$warunki_wspolne .= ' AND status_work IN (\''. implode('\',\'', $kryteria['status_work']).'\')';
			}
			else
			{
				$warunki_wspolne .= ' AND status_work = \''.$kryteria['status_work'].'\'';
			}
		}
		$warunki_wszystkie_apartamenty = $warunki_wspolne;
		if (isset($kryteria['id_team']))
		{
			if (is_array($kryteria['id_team']))
			{
				$warunki_wspolne .= ' AND id_team IN ('. implode(',', $kryteria['id_team']).')';
			}
			else
			{
				$warunki_wspolne .= ' AND id_team = '.intval($kryteria['id_team']);
			}
		}
		if (isset($kryteria['data_start_mniejsza_od']))
		{
			$warunki_wyswietlanie .= ' AND date_start <= \''.$kryteria['data_start_mniejsza_od'].'\'';
		}
		if(isset($kryteria['id_pdf']) && $kryteria['id_pdf'])
		{
			$warunki_wspolne .= ' AND id_pdf IS NOT NULL';
		}
		
		$przedzapytanie = 'SELECT COUNT(*) as ilosc_przydzielonych, id_team, id_parent FROM '.$this->tabela.' WHERE '.$warunki_wspolne.' AND id_parent IS NOT NULL GROUP BY id_team, id_parent ORDER BY id_parent';

		$wynikPrzedzapytania = $this->zwracaTablice()->pobierzWiele($przedzapytanie);
		if (empty($wynikPrzedzapytania)) $wynikPrzedzapytania = array(0);
		
		$sql = 'SELECT *, '
				. '(SELECT COUNT(id) FROM '.$this->tabela.' WHERE '.$warunki_wszystkie_apartamenty.' '.$warunki_wyswietlanie.' AND id_parent = mz.id) AS ilosc_dzieci '
				. ' FROM '.$this->tabela.' mz WHERE'
				. ' id_projektu = ' . ID_PROJEKTU .'
					  AND id IN (SELECT id_parent FROM '.$this->tabela.' WHERE '.$warunki_wspolne;
		
		
		$sql .= ' GROUP BY id_parent)';
		$sql .= $warunki_wyswietlanie;

		$wynikGlowny = listaZTablicy($this->zwracaTablice()->pobierzWiele($sql, $pager, $sorter), 'id');
		$wynikDataPierwszegoZamowienia = array();
		$return = array();
		if(count($wynikGlowny) > 0)
		{
			$sqlDataPierwszegoZamowienia = 'SELECT MIN(date_start) AS date_start, id_team, id_parent FROM modul_zamowienia '
					  . 'WHERE  '.$warunki_wspolne.' '.$warunki_wyswietlanie.' AND id_parent IN('.implode(',',  array_keys($wynikGlowny)).') 
						  AND date_start IS NOT NULL GROUP BY id_team, id_parent';


			foreach($this->zwracaTablice()->pobierzWiele($sqlDataPierwszegoZamowienia, $pager, $sorter) as $dane)
			{
				$wynikDataPierwszegoZamowienia[$dane['id_team']][$dane['id_parent']]['date_pierwszego_apartamentu'] = $dane['date_start'];
			}
			
			foreach ($wynikPrzedzapytania as $wynik)
			{
				$return[$wynik['id_team']][$wynik['id_parent']] = $wynikGlowny[$wynik['id_parent']];
				$return[$wynik['id_team']][$wynik['id_parent']]['ilosc_dzieci_biezace'] = $wynik['ilosc_przydzielonych'];
				$return[$wynik['id_team']][$wynik['id_parent']]['date_pierwszego_apartamentu'] = (isset($wynikDataPierwszegoZamowienia[$wynik['id_team']][$wynik['id_parent']]['date_pierwszego_apartamentu'])) ? $wynikDataPierwszegoZamowienia[$wynik['id_team']][$wynik['id_parent']]['date_pierwszego_apartamentu'] : '';
			}
		}

		unset($wynikPrzedzapytania);
		unset($wynikGlowny);
		unset($wynikDataPierwszegoZamowienia);
		return $return;
	}
	
	public function pobierzZamowieniaTeamow($kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM '.$this->tabela.' WHERE id_projektu = '.ID_PROJEKTU;
		
		if (isset($kryteria['id_team']) && $kryteria['id_team'] != '')
		{
			if (is_array($kryteria['id_team']) && !empty($kryteria['id_team']))
				$sql .= ' AND id_team IN(\''.implode('\',\'', $kryteria['id_team']).'\')';
			else
				$sql .= ' AND id_team = \''.$kryteria['id_team'].'\'';
		}
		if (isset($kryteria['id_type']) && $kryteria['id_type'] != '')
		{
			if (is_array($kryteria['id_type']) && !empty($kryteria['id_type']))
				$sql .= ' AND id_type IN(\''.implode('\',\'', $kryteria['id_type']).'\')';
			else
				$sql .= ' AND id_type = \''.$kryteria['id_type'].'\'';
		}
		if (isset($kryteria['status']) && $kryteria['status'] != '')
		{
			if (is_array($kryteria['status']) && !empty($kryteria['status']))
				$sql .= ' AND status IN(\''.implode('\',\'', $kryteria['status']).'\')';
			else
				$sql .= ' AND status = \''.$kryteria['status'].'\'';
		}
		if (isset($kryteria['status_work']) && $kryteria['status_work'] != '')
		{
			if (is_array($kryteria['status_work']) && !empty($kryteria['status_work']))
				$sql .= ' AND status_work IN(\''.implode('\',\'', $kryteria['status_work']).'\')';
			else
				$sql .= ' AND status_work = \''.$kryteria['status_work'].'\'';
		}
		if (isset($kryteria['data_od']) && $kryteria['data_od'] != '')
		{
			$sql .= ' AND to_char(data_zakonczenia, \'YYYY-MM-DD\')::timestamp >= \''.$kryteria['data_od'].'\'';
		}
		if (isset($kryteria['data_do']) && $kryteria['data_do'] != '')
		{
			$sql .= ' AND to_char(data_zakonczenia, \'YYYY-MM-DD\')::timestamp <= \''.$kryteria['data_do'].'\'';
		}
		if (isset($kryteria['daty']) && !empty($kryteria['daty']) != '')
		{
			$sql .= ' AND to_char(data_zakonczenia, \'YYYY-MM-DD\')::timestamp IN(\''.implode('\',\'', $kryteria['daty']).'\')';
		}
		if (isset($kryteria['data_zakonczenia_niepusta']) && $kryteria['data_zakonczenia_niepusta'])
		{
			$sql .= ' AND data_zakonczenia is not null';
		}
		
		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	
	public function pobierzOstatniDoSprawdzenia($kryteria = null)
	{
		$sql = 'SELECT * FROM '.$this->tabela.' WHERE'
			  . ' data_zakonczenia IS NOT null';
		
		if ($kryteria != null)
		{
			if (isset($kryteria['status']))
			{
				if(is_array($kryteria['status']))
				{
					$sql .= ' AND status IN (\''.implode('\',\'', $kryteria['status']).'\')';
				}
				else
				{
					$sql .= ' AND status = \''.$kryteria['status'].'\'';
				}
			}
			if (isset($kryteria['status_work']))
			{
				if (is_array($kryteria['status_work']))
				{
					$sql .= ' AND status_work IN (\''.implode('\',\'', $kryteria['status_work']).'\')';
				}
				else
				{
					$sql .= ' AND status_work = \''.$kryteria['status_work'].'\'';
				}
			}
			if (isset($kryteria['wyslano_do_raportu']))
			{
				if ($kryteria['wyslano_do_raportu'])
				{
					$sql .= ' AND wyslano_do_raportu = TRUE';
				}
				else
				{
					$sql .= ' AND wyslano_do_raportu = FALSE';
				}
			}
			if (isset($kryteria['id_types']))
			{
				if (is_array($kryteria['id_types']))
				{
					$sql .= ' AND id_type IN(\''.implode('\',\'', $kryteria['id_types']).'\')';
				}
				else
				{
					$sql .= ' AND id_type = \''.$kryteria['id_types'].'\'';
				}
			}
			if (isset($kryteria['charge_type']) && $kryteria['charge_type'] != '')
			{
				if (is_array($kryteria['charge_type']))
				{
					$sql .= ' AND charge_type IN(\''.implode('\',\'', $kryteria['charge_type']).'\') ';
				}
				else
				{
				$sql .= ' AND charge_type = \''.$kryteria['charge_type'].'\'';
			}
		}
		}
		
		$sql .= ' ORDER BY data_zakonczenia ASC LIMIT 1';
		return $this->pobierzJeden($sql);
	}
	
	public function pobierzZamknieteNieZafakurowaneWCalosci($kryteria = array())
	{
		$sql = 'SELECT mz.id AS mz_id FROM '.$this->tabela.' mz '
			. ' LEFT JOIN modul_produkty_zakupione mpz ON (mz.id = mpz.id_order)'
			. ' WHERE ((mpz.quantity > 1 AND mpz.quantity > mpz.procent_wykonania) OR (mpz.quantity = 1 AND mpz.procent_wykonania < 100))'
			. ' AND mz.id_projektu = '.ID_PROJEKTU;
		if(isset($kryteria['id_type']))
		{
			if(is_array($kryteria['id_type']) && count($kryteria['id_type']))
				$sql .= ' AND mz.id_type IN ('.  implode(',', $kryteria['id_type']).') ';
			else
				$sql .= ' AND mz.id_type = '.$kryteria['id_type'];
		}
		if(isset($kryteria['zafakturowano']))
		{
			if($kryteria['zafakturowano'])
				$sql .= ' AND mz.zafakturowano = TRUE ';
			else
				$sql .= ' AND mz.zafakturowano = FALSE ';
		}
		if(isset($kryteria['status']))
		{
			if(is_array($kryteria['status']) && count($kryteria['status']))
				$sql .= ' AND mz.status IN ('.  implode(',', $kryteria['status']).') ';
			else
				$sql .= ' AND mz.status = \''.$kryteria['status'].'\'';
		}
		if(isset($kryteria['status_work']))
		{
			if(is_array($kryteria['status_work']) && count($kryteria['status_work']))
				$sql .= 'AND mz.status_work IN ('.  implode(',', $kryteria['status_work']).') ';
			else
				$sql .= ' AND mz.status_work = \''.$kryteria['status_work'].'\'';
		}
		$sql .= ' GROUP BY mz.id';

		return $this->zwracaTablice()->pobierzWiele($sql);
		
	}
	
	
	public function pobierzIlosciZamowienPerDzien($kryteria)
	{	
		$sql = 'SELECT date_start, COUNT(*) AS ilosc FROM '.$this->tabela.' WHERE id_projektu = '.ID_PROJEKTU. ' AND date_start IS NOT NULL';
		
		if (isset($kryteria['id_type']) && $kryteria['id_type'] != '')
		{
			if (is_array($kryteria['id_type']))
			{
				$sql .= ' AND id_type IN('.implode(',', $kryteria['id_type']).')';
			}
			else
			{
				$sql .= ' AND id_type = '.intval($kryteria['id_type']);
			}
		}
		if (isset($kryteria['status_work']) && $kryteria['status_work'] != '')
		{
			if (! is_array($kryteria['status_work']))
				$kryteria['status_work'] = array($kryteria['status_work']);
			
			$sql .= ' AND status_work IN(\''.implode('\',\'', $kryteria['status_work']).'\')';
		}
		if (isset($kryteria['status_work']) && $kryteria['status_work'] != '')
		{
			if (! is_array($kryteria['status']))
				$kryteria['status'] = array($kryteria['status']);
			
			$sql .= ' AND status IN(\''.implode('\',\'', $kryteria['status']).'\')';
		}
		if (isset($kryteria['date_start_od']) && $kryteria['date_start_od'] != '')
		{
			$sql .= ' AND date_start >= \''.$kryteria['date_start_od'].'\'';
		}
		if (isset($kryteria['date_start_do']) && $kryteria['date_start_do'] != '')
		{
			$sql .= ' AND date_start <= \''.$kryteria['date_start_do'].'\'';
		}
		if (isset($kryteria['additional_data']) && $kryteria['additional_data'] != '')
		{
			$sql .= ' AND additional_data ILIKE \'%'.$kryteria['additional_data'].'\'%';
		}
		
		$sql .= 'GROUP BY date_start ORDER BY date_start';
		
		return $this->zwracaTablice()->pobierzWiele($sql);
	}
	
	public function pobierzProjektyPoKodziePocztowym($postcode, Pager $pager = null, Sorter $sorter = null, $dodatkoweKryteria = null)
	{
		$kryteria = $dodatkoweKryteria;
		
		$sql = 'SELECT * FROM '.$this->tabela.' WHERE id_parent IS NULL'
			  . ' AND id IN (SELECT DISTINCT(id_parent) FROM '.$this->tabela.' WHERE postcode = \''.$postcode.'\' AND id_parent IS NOT NULL';
		
		if (isset($kryteria['id_typow_apartamenty']))
		{
			if (!is_array($kryteria['id_typow_apartamenty']))
				$ids = array($kryteria['id_typow_apartamenty']);
			else
				$ids = $kryteria['id_typow_apartamenty'];
			$sql .= ' AND id_type IN ('.  implode(', ', $ids).')';
		}
		$sql .= ')';
		
		if ($kryteria != null)
		{
			if (isset($kryteria['id_typow_projekty']))
			{
				if (!is_array($kryteria['id_typow_projekty']))
					$ids = array($kryteria['id_typow_projekty']);
				else
					$ids = $kryteria['id_typow_projekty'];
				$sql .= ' AND id_type IN ('.  implode(', ', $ids).')';
			}
			if (isset($kryteria['status_work']))
			{
				if (is_array($kryteria['status_work']))
				{
					$sql .= ' AND status_work IN (\''.implode('\',\'', $kryteria['status_work']).'\')';
				}
				else
				{
					$sql .= ' AND status_work = \''.$kryteria['status_work'].'\'';
				}
			}
			if (isset($kryteria['wyslano_do_raportu']))
			{
				if ($kryteria['wyslano_do_raportu'])
				{
					$sql .= ' AND wyslano_do_raportu = TRUE';
				}
				else
				{
					$sql .= ' AND wyslano_do_raportu = FALSE';
				}
			}
			if (isset($kryteria['id_types']))
			{
				if (is_array($kryteria['id_types']))
				{
					$sql .= ' AND id_type IN(\''.implode('\',\'', $kryteria['id_types']).'\')';
				}
				else
				{
					$sql .= ' AND id_type = \''.$kryteria['id_types'].'\'';
				}
			}
			if (isset($kryteria['charge_type']) && $kryteria['charge_type'] != '')
			{
				if (is_array($kryteria['charge_type']))
				{
					$sql .= ' AND charge_type IN(\''.implode('\',\'', $kryteria['charge_type']).'\') ';
				}
				else
				{
				$sql .= ' AND charge_type = \''.$kryteria['charge_type'].'\'';
				}
			}
		}
		
		//$sql .= '';
		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	
	public function pobierzZamowieniaZPrzekroczonymCzasem($dataStart, $dataStop, $idType)
	{
		$sql = "SELECT mz.id, mz.id_team, mz.date_start, mz.total_time, (SELECT SUM(hours) FROM modul_timelist mt WHERE mz.id = mt.id_object GROUP BY mt.id_object ) AS hours_spend 
				FROM modul_zamowienia mz 
				WHERE mz.id_type = ".$idType." 
				AND ( mz.date_start > '".$dataStart."' AND mz.date_start < '".$dataStop."' )
				AND mz.total_time < (SELECT SUM(hours) FROM modul_timelist mt WHERE mz.id = mt.id_object GROUP BY mt.id_object )";
		
		return $this->pobierzWiele($sql, null, null);
	}
	
	public function pobierzPoIDs($ids, $pager = null, $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela.' WHERE ';
		
		if (is_array($ids) && count($ids) > 0)
		{
			$sql .= 'id IN('.implode(',', $ids).') ';
		}
		return $this->pobierzWiele($sql, $pager, $sorter);
	}
	
	public function zliczPlanowanyCzasZamowienPoIDs($ids)
	{
		$sql = 'SELECT SUM(total_time) FROM ' . $this->tabela.' WHERE ';
		
		if (is_array($ids) && count($ids) > 0)
		{
			$sql .= 'id IN(\''.implode('\',\'', $ids).'\') ';
		}
		$sql .= 'AND sprawdzony=TRUE';
		
		return $this->pobierzWartosc($sql);
	}
}