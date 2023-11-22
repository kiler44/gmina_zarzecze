<?php
namespace Generic\Model\Zamowienie;
use Generic\Biblioteka;

/**
 * Klasa obsługująca sortowanie list danych obiektów odwzorowujących.
 */
class Sorter extends Biblioteka\Sorter
{
	/**
	* Tablica przetrzymująca rodzaje sortowania i tlumaczaca je na kolumny.
	* Porzadek sortowania jest dodawany tylko do pierwszej kolumny.
	* @var array
	*/
	public $_rodzaje = array(
		'id' => array('id', 'id_type' => 'ASC'),
		'order_id' => array('id', 'id_type' => 'ASC'),
		'id_team' => array('id_team', 'date_start', 'id' => 'ASC', 'id_type' => 'ASC'),
		'id_team_data_zakonczenia' => array('id_team', 'data_zakonczenia' => 'ASC'),
		'id_type' => array('id_type', 'date_added' => 'ASC'),
		'order_name' => array('order_name', 'id' => 'ASC'),
		'number_order_get' => array('number_order_get', 'date_added' => 'ASC'),
		'number_order_bkt' => array('number_order_bkt','date_added' => 'ASC'),
		'number_customer' => array('number_customer','date_added' => 'ASC'),
		'number_privat_customer' => array('number_privat_customer','date_added' => 'ASC'),
		'number_project_get' => array('number_project_get','date_added' => 'ASC'),
		'number_contact_id' => array('number_contact_id','date_added' => 'ASC'),
		'charge_type' => array('charge_type','id_type' => 'ASC','date_added' => 'ASC'),
		'date_added' => array('date_added','id_type' => 'ASC'),
		'hours_interval' => array('date_start', 'hours_interval', 'date_added' => 'ASC'),
		'auto_team' => array('date_start', 'hours_interval', 'id_team' => 'DESC'),
		'client' => array('surname', 'name', 'second_name'),
		'total_time' => array('total_time', 'date_start' => 'ASC', 'date_added' => 'ASC'),
		'date_start' => array('date_start', 'hours_interval','id_type' => 'ASC', 'id'),
		'samo_date_start' => array('date_start' => 'ASC'),
		'date_stop' => array('date_stop','id_type' => 'ASC'),
		'status' => array('status', 'date_added' => 'ASC'),
		'status_work' => array('status_work', 'date_start' => 'ASC', 'hours_interval' => 'ASC'),
		'data_start_tylko' => array('date_start'),
		'address' => array('city', 'address', 'apartment' => 'DESC'),
		'address_appartment' => array('city', 'regexp_replace(o.address, \'([\w\s]+)\s+([\d]+)\s*([\w]*)\', \'\1\', \'g\')', 'regexp_replace(o.address, \'([\w]+\s)+([\d]+)\s*([\w]*)\', \'\2\', \'g\')::int', 'regexp_replace(o.address, \'([\w]+)\s+([\d]+)\s*([\w]*)\', \'\3\', \'g\')', 'apartment' => 'DESC'),
		'address_appartment_natural' => array('city', 'regexp_replace(o.address, \'([\w\s]+)\s+([\d]+)\s*([\w]*)\', \'\1\', \'g\')', 'regexp_replace(o.address, \'([\w]+\s)+([\d]+)\s*([\w]*)\', \'\2\', \'g\')::int', 'regexp_replace(o.address, \'([\w]+)\s+([\d]+)\s*([\w]*)\', \'\3\', \'g\')', 'apartment'),
		'address_appartment_grupowany' => array('regexp_replace(address, \'([\w\s]+)\s+([\d]+)\s*([\w]*)\', \'\1\', \'g\')', 'regexp_replace(address, \'([\w]+\s)+([\d]+)\s*([\w]*)\', \'\2\', \'g\')::int', 'regexp_replace(address, \'([\w]+)\s+([\d]+)\s*([\w]*)\', \'\3\', \'g\')'),
		'search' => array('id_pdf', 'address', 'date_added'),
		'tylko_address' => array('address'),
		'city' => array('city','postcode' => 'ASC'),
		'postcode' => array('postcode','city' => 'ASC'),
		'location_lat' => array('location_lat'),
		'location_lng' => array('location_lng'),
		'budget' => array('budget','id_type' => 'ASC'),
		'node_villa_code' => array('node_villa_code', 'number_order_get' => 'ASC'),
		'ilosc_dzieci' => array('ilosc_dzieci'),
		'position' => array('position', 'date_start' => 'ASC'),
		'data_zakonczenia' => array('data_zakonczenia', 'id_team' => 'ASC'),
		'wyslany_do_fakturowania' => array('wyslany_do_fakturowania', 'data_zakonczenia' => 'DESC'),
		'number_project_inkjops' => array('number_project_inkjops'),
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}