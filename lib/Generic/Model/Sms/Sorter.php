<?php
namespace Generic\Model\Sms;
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
		'id' => array(
			'id',
			'id_projektu' => 'ASC',//TODO:
			'date_sent' => 'ASC',//TODO:
			'sender_number' => 'ASC',//TODO:
			'recipient_number' => 'ASC',//TODO:
			'message' => 'ASC',//TODO:
			'status_info' => 'ASC',//TODO:
			'sent' => 'ASC',//TODO:
			'type' => 'ASC',//TODO:
		),
		
		'id_projektu' => array(
			'id_projektu',
			'id' => 'ASC',//TODO:
			'date_sent' => 'ASC',//TODO:
			'sender_number' => 'ASC',//TODO:
			'recipient_number' => 'ASC',//TODO:
			'message' => 'ASC',//TODO:
			'status_info' => 'ASC',//TODO:
			'sent' => 'ASC',//TODO:
			'type' => 'ASC',//TODO:
		),
		
		'date_sent' => array(
			'date_sent',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'sender_number' => 'ASC',//TODO:
			'recipient_number' => 'ASC',//TODO:
			'message' => 'ASC',//TODO:
			'status_info' => 'ASC',//TODO:
			'sent' => 'ASC',//TODO:
			'type' => 'ASC',//TODO:
		),
		
		'date_delivered' => array(
			'date_delivered',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'sender_number' => 'ASC',//TODO:
			'recipient_number' => 'ASC',//TODO:
			'message' => 'ASC',//TODO:
			'status_info' => 'ASC',//TODO:
			'sent' => 'ASC',//TODO:
			'type' => 'ASC',//TODO:
		),
		
		'sender_number' => array(
			'sender_number',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'date_sent' => 'ASC',//TODO:
			'recipient_number' => 'ASC',//TODO:
			'message' => 'ASC',//TODO:
			'status_info' => 'ASC',//TODO:
			'sent' => 'ASC',//TODO:
			'type' => 'ASC',//TODO:
		),
		
		'recipient_number' => array(
			'recipient_number',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'date_sent' => 'ASC',//TODO:
			'sender_number' => 'ASC',//TODO:
			'message' => 'ASC',//TODO:
			'status_info' => 'ASC',//TODO:
			'sent' => 'ASC',//TODO:
			'type' => 'ASC',//TODO:
		),
		
		'message' => array(
			'message',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'date_sent' => 'ASC',//TODO:
			'sender_number' => 'ASC',//TODO:
			'recipient_number' => 'ASC',//TODO:
			'status_info' => 'ASC',//TODO:
			'sent' => 'ASC',//TODO:
			'type' => 'ASC',//TODO:
		),
		
		'status_info' => array(
			'status_info',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'date_sent' => 'ASC',//TODO:
			'sender_number' => 'ASC',//TODO:
			'recipient_number' => 'ASC',//TODO:
			'message' => 'ASC',//TODO:
			'sent' => 'ASC',//TODO:
			'type' => 'ASC',//TODO:
		),
		
		'sent' => array(
			'sent',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'date_sent' => 'ASC',//TODO:
			'sender_number' => 'ASC',//TODO:
			'recipient_number' => 'ASC',//TODO:
			'message' => 'ASC',//TODO:
			'status_info' => 'ASC',//TODO:
			'type' => 'ASC',//TODO:
		),
		
		'type' => array(
			'type',
			'id' => 'ASC',//TODO:
			'id_projektu' => 'ASC',//TODO:
			'date_sent' => 'ASC',//TODO:
			'sender_number' => 'ASC',//TODO:
			'recipient_number' => 'ASC',//TODO:
			'message' => 'ASC',//TODO:
			'status_info' => 'ASC',//TODO:
			'sent' => 'ASC',//TODO:
		),
		
	);	



	/**
	* Domyślny rodzaj sortowania.
	* @var string
	*/
	protected $_domyslne = 'id';
}