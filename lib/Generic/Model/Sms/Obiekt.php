<?php
namespace Generic\Model\Sms;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idSmsReference 
 * @property string $object
 * @property int $idObject
 * @property mixed $dateSent
 * @property string $dateDelivered 
 * @property int $idSender
 * @property int $idRecipient
 * @property string $senderNumber
 * @property string $recipientNumber 
 * @property string $message 
 * @property string $statusInfo 
 * @property bool $sent 
 * @property string $type
 * @property bool $requireSend
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\Sms\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\Sms\Obiekt
	 */
	protected $j;
}