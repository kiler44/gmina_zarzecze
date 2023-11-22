<?php
namespace Generic\Model\Sms;
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $id_projektu 
 * @property string $object
 * @property int $id_object
 * @property mixed $date_sent
 * @property int $id_sender
 * @property int $id_reciptient
 * @property string $sender_number 
 * @property string $recipient_number 
 * @property string $message 
 * @property string $status_info 
 * @property bool $sent 
 * @property string $type
 * @property bool $requireSend
 */
class Definicja extends Biblioteka\DefinicjaObiektu
{

	/**
	* Przetrzymuje typy pól w bazie.
	* @var array
	*/
	public $polaObiektuTypy = array(
		'id' => self::_INTEGER,
		'idProjektu' => self::_INTEGER,
		'idSmsReference' => self::_INTEGER,
		'object' => self::_STRING,
		'idObject' => self::_INTEGER,
		'dateSent' => self::_STRING,
		'dateDelivered' => self::_STRING,
		'idSender' => self::_INTEGER,
		'idRecipient' => self::_INTEGER,
		'senderNumber' => self::_STRING,
		'recipientNumber' => self::_STRING,
		'message' => self::_STRING,
		'statusInfo' => self::_STRING,
		'sent' => self::_BOOLEAN,
		'type' => self::_STRING,
		'requireSend' => self::_BOOLEAN,
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
	);



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $polaFormularza = array(
		'dateSent' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

		'senderNumber' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 14,
			),
		),

		'recipientNumber' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 14,
			),
		),

		'message' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 400,
			),
		),

		'statusInfo' => array(
			'input' => 'Select',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 60,
			),
		),

		'sent' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval',
				'abs',
			),
			'walidatory' => array(
			),
		),

		'type' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'KrotszeOd' => 60,
			),
		),

	);
}