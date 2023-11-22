<?php
namespace Generic\Model\ZamowienieRaport;

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
	);



	/**
	* Pola tabeli bazy danych tworzÄ…ce klucz główny.
	* @var array
	*/
	protected $polaTabeliKlucz = array(
		'id',
		'id_projektu',
	);



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
	
	public function szukaj($kryteria, Sorter $sorter = null)
	{
		$sql = 'SELECT mz.id AS bkt_id , mz.number_order_get, mz.data_zakonczenia , mz.order_name, mz.address, mz.apartment, mz.postcode, mz.city, mk.name, mk.surname,'
				  . ' ( SELECT  string_agg(DISTINCT(CONCAT(mp.name, \' x \',mpz2.quantity )), \' , \')  FROM modul_produkty_zakupione mpz2 JOIN modul_produkty mp ON (mpz2.id_product = mp.id ) WHERE mpz2.id_order = mz.id AND mp.import = FALSE AND mpz2.confirmation_status <> \'rejected\' ) as product_list,'
				  . '( SELECT SUM(mpz1.netto_price) FROM modul_produkty_zakupione mpz1 JOIN modul_produkty mp ON(mpz1.id_product = mp.id) WHERE mpz1.id_order = mz.id AND mp.import = FALSE AND mpz1.confirmation_status <> \'rejected\' ) AS sum_price'
				  . ' FROM ' . $this->tabela .' AS mz'
				  . ' LEFT JOIN modul_klienci AS mk ON (mk.id = mz.number_privat_customer) '
				  . ' WHERE mz.id_projektu = '.ID_PROJEKTU ;
		if(isset($kryteria['id_types']) && count($kryteria['id_types']))
		{
			$sql .= ' AND mz.id_type IN ('.implode(',', $kryteria['id_types']).')';
		}
		if(isset($kryteria['status_work']) && count($kryteria['status_work']))
		{
			$sql .= ' AND mz.status_work IN (\''.implode('\',\'', $kryteria['status_work']).'\')';
		}
		if(isset($kryteria['status']) && count($kryteria['status']))
		{
			$sql .= ' AND mz.status IN (\''.implode('\',\'', $kryteria['status']).'\')';
		}
		if(isset($kryteria['wyslano_do_raportu']))
		{
			if($kryteria['wyslano_do_raportu'])
			{
				$sql .= ' AND mz.wyslano_do_raportu = TRUE';
			}
			else
			{
				$sql .= ' AND mz.wyslano_do_raportu = FALSE';
			}
		}
		if(isset($kryteria['sprawdzony']))
		{
			if($kryteria['sprawdzony'])
			{
				$sql .= ' AND mz.sprawdzony = TRUE';
			}
			else
			{
				$sql .= ' AND mz.sprawdzony = FALSE';
			}
		}
		if (isset($kryteria['data_zakonczenia_od']) && $kryteria['data_zakonczenia_od'] != '' && isset($kryteria['data_zakonczenia_do']) && $kryteria['data_zakonczenia_do'] != '')
		{
			if (strlen($kryteria['data_zakonczenia_od']) == 10) $data_zakonczenia_od = $kryteria['data_zakonczenia_od'].' 00:00:00';
			else $data_zakonczenia_od = $kryteria['data_zakonczenia_od'];
			
			if (strlen($kryteria['data_zakonczenia_do']) == 10) $data_zakonczenia_do = $kryteria['data_zakonczenia_do'].' 23:59:59';
			else $data_zakonczenia_do = $kryteria['data_zakonczenia_do'];
			
			$sql .= ' AND mz.data_zakonczenia IS NOT null AND (mz.data_zakonczenia BETWEEN \''.$data_zakonczenia_od.'\' AND \''.$data_zakonczenia_do.'\')';
		}
		
		return $this->pobierzWiele($sql, null, $sorter);
		
	}
	
	
}