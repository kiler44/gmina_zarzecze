<?php
namespace Generic\Model\Sms;

use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

/**
* Maper tabeli w bazie: modul_sms
*/
class Mapper extends Biblioteka\Mapper\Baza
{



	/**
	* Zwracany obiekt przez mapper
	* @var string
	*/
	protected $zwracanyObiekt = 'Generic\Model\Sms\Obiekt';



	/**
	* Nazwa tabeli w bazie danych.
	* @var string
	*/
	protected $tabela = 'modul_sms';



	/**
	* Tablica tłumacząca pola tabeli bazy danych na nazwy pól obiektu.
	* @var array
	*/
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_sms_reference' => 'idSmsReference',
		'date_sent' => 'dateSent',
		'date_delivered' => 'dateDelivered',
		'object' => 'object',
		'id_object' => 'idObject',
		'sender_number' => 'senderNumber',
		'id_sender' => 'idSender',
		'id_recipient' => 'idRecipient',
		'recipient_number' => 'recipientNumber',
		'message' => 'message',
		'status_info' => 'statusInfo',
		'sent' => 'sent',
		'type' => 'type',
		'require_send' => 'requireSend',
	);



	/**
	* Pola tabeli bazy danych tworzące klucz główny.
	* @var array
	*/
	protected $polaTabeliKlucz = array(
		'id',
		'id_projektu',
	);



	/**
	* Zwraca ilość w tabeli modul_sms.
	* @return int
	*/
	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}



	/**
	* Zwraca dla podanego id w tabeli modul_sms.
	* @return \Generic\Model\Generic\Model\Sms\Obiekt\Obiekt
	*/
	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	/**
	* Zwraca wszystko z tabeli modul_sms.
	* @return Array
	*/
	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}

	public function pobierzNieWyslaneZzamowieniami($teamId = null)
	{
		$sql = 'SELECT * '
			. ' FROM '.$this->tabela.' sms '
			. ' LEFT JOIN modul_zamowienia mz ON (mz.id = sms.id_object )'
			. ' WHERE sms.id_projektu = ' . ID_PROJEKTU
			. ' AND sms.sent = false '
			. ' AND sms.object = \'Zamowienie\' ';
		if($teamId > 0)
		{
			$fraza = intval($teamId);
			$sql.= ' AND mz.id_team = '.$fraza.' ';
		}

		return $this->pobierzWiele($sql);
		
	}

	/**
	* Wyszukuje w tabeli modul_sms dla podanych kryteriów.
	* @return Array
	*/
	public function szukaj(Array $kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * '
			. ' FROM '.$this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		 if(isset($kryteria['date_sent_od']) && $kryteria['date_sent_od'] != '')
		 {
			 $fraza = addslashes($kryteria['date_sent_od']);
			 $sql.= ' AND date_sent >= \''.$fraza.'\' ';
		 }
		 if(isset($kryteria['date_sent_do']) && $kryteria['date_sent_do'] != '')
		 {
			 $fraza = addslashes($kryteria['date_sent_do']);
			 $sql.= ' AND date_sent <= \''.$fraza.'\' ';
		 }
		 if (isset($kryteria['sender_number']) && $kryteria['sender_number'] != '')
       {
          $fraza = addslashes($kryteria['sender_number']);
          $sql.= ' AND sender_number ILIKE \'%'.$fraza.'%\'';
       }
		 if (isset($kryteria['recipient_number']) && $kryteria['recipient_number'] != '')
       {
          $fraza = addslashes($kryteria['recipient_number']);
          $sql.= ' AND recipient_number ILIKE \'%'.$fraza.'%\'';
       }
		 if (isset($kryteria['message']) && $kryteria['message'] != '')
       {
          $fraza = addslashes($kryteria['message']);
          $sql.= ' AND message ILIKE \'%'.$fraza.'%\'';
       }
		 if (isset($kryteria['object']) && $kryteria['object'] != '')
       {
          $fraza = addslashes($kryteria['object']);
          $sql.= ' AND object ILIKE \'%'.$fraza.'%\'';
       }
		 if (isset($kryteria['id_object']) && $kryteria['id_object'] != '')
       {
          $fraza = intval($kryteria['id_object']);
          $sql.= ' AND id_object = '.$fraza.' ';
       }
		 if (isset($kryteria['wiele_idObject']) && $kryteria['wiele_idObject'] != '')
       {
          $sql.= ' AND id_object IN(\''.implode('\',\'', $kryteria['wiele_idObject']).'\') ';
       }
		 if (isset($kryteria['type']) && $kryteria['type'] != '')
       {
          $fraza = addslashes($kryteria['type']);
          $sql.= ' AND type ILIKE \'%'.$fraza.'%\'';
       }
		 if (isset($kryteria['id_sender']) && $kryteria['id_sender'] > 0)
		 {
			 if (is_array($kryteria['id_sender']))
			 {
				 $sql .= ' AND id_sender IN('.implode(',', $kryteria['id_sender']).')';
			 }
			 else
			 {
				 $sql .= ' AND id_sender = '.intval($kryteria['id_sender']);
			 }
		 }
		 if (isset($kryteria['id_recipient']) && $kryteria['id_recipient'] > 0)
		 {
			 if (is_array($kryteria['id_recipient']))
			 {
				 $sql .= ' AND id_recipient IN('.implode(',', $kryteria['id_recipient']).')';
			 }
			 else
			 {
				 $sql .= ' AND id_recipient = '.intval($kryteria['id_recipient']);
			 }
		 }
		 if(isset($kryteria['sent']) && $kryteria['sent'] != '')
		 {
			if ($kryteria['sent'])
			{
				$sql.= ' AND sent = true';
			}
			else
			{
				 $sql.= ' AND sent = false';
			}
		 }
		 
		 return $this->pobierzWiele($sql, $pager, $sorter);
	}



	/**
	* Zwraca ilość pasujących elementów dla podanych kryteriów w tabeli modul_sms.
	* @return int
	*/
	public function iloscSzukaj(Array $kryteria)
	{
		$sql = 'SELECT COUNT(*) '
			. ' FROM '.$this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;
		
		if(isset($kryteria['date_sent_od']) && $kryteria['date_sent_od'] != '')
		 {
			 $fraza = addslashes($kryteria['date_sent_od']);
			 $sql.= ' AND date_sent >= \''.$fraza.'\' ';
		 }
		 if(isset($kryteria['date_sent_do']) && $kryteria['date_sent_do'] != '')
		 {
			 $fraza = addslashes($kryteria['date_sent_do']);
			 $sql.= ' AND date_sent <= \''.$fraza.'\' ';
		 }
		 if (isset($kryteria['sender_number']) && $kryteria['sender_number'] != '')
       {
          $fraza = addslashes($kryteria['sender_number']);
          $sql.= ' AND sender_number ILIKE \'%'.$fraza.'%\'';
       }
		 if (isset($kryteria['recipient_number']) && $kryteria['recipient_number'] != '')
       {
          $fraza = addslashes($kryteria['recipient_number']);
          $sql.= ' AND recipient_number ILIKE \'%'.$fraza.'%\'';
       }
		 if (isset($kryteria['message']) && $kryteria['message'] != '')
       {
          $fraza = addslashes($kryteria['message']);
          $sql.= ' AND message ILIKE \'%'.$fraza.'%\'';
       }
		 if (isset($kryteria['object']) && $kryteria['object'] != '')
       {
          $fraza = addslashes($kryteria['object']);
          $sql.= ' AND object ILIKE \'%'.$fraza.'%\'';
       }
		 if (isset($kryteria['id_object']) && $kryteria['id_object'] != '')
       {
          $fraza = intval($kryteria['id_object']);
          $sql.= ' AND object = '.$fraza.' ';
       }
		 if (isset($kryteria['wiele_idObject']) && $kryteria['wiele_idObject'] != '')
       {
          $sql.= ' AND id_object IN(\''.implode('\',\'', $kryteria['wiele_idObject']).'\') ';
       }
		 if (isset($kryteria['type']) && $kryteria['type'] != '')
       {
          $fraza = addslashes($kryteria['type']);
          $sql.= ' AND type ILIKE \'%'.$fraza.'%\'';
       }
		 if (isset($kryteria['id_sender']) && $kryteria['id_sender'] > 0)
		 {
			 if (is_array($kryteria['id_sender']))
			 {
				 $sql .= ' AND id_sender IN('.implode(',', $kryteria['id_sender']).')';
			 }
			 else
			 {
				 $sql .= ' AND id_sender = '.intval($kryteria['id_sender']);
			 }
		 }
		 if (isset($kryteria['id_recipient']) && $kryteria['id_recipient'] > 0)
		 {
			 if (is_array($kryteria['id_recipient']))
			 {
				 $sql .= ' AND id_recipient IN('.implode(',', $kryteria['id_recipient']).')';
			 }
			 else
			 {
				 $sql .= ' AND id_recipient = '.intval($kryteria['id_recipient']);
			 }
		 }
		 if(isset($kryteria['sent']) && $kryteria['sent'] != '')
		 {
			if ($kryteria['sent'])
			{
				$sql.= ' AND sent = true';
			}
			else
			{
				 $sql.= ' AND sent = false';
			}
		 }

		 return $this->pobierzWartosc($sql);
	}



	/**
	* Wykonuje wyszukiwanie według podanych kryteriów.
	* @return Array
	*/
	protected function zapytanieWyszukiwanie($kryteria)
	{
		$zapytanie = $this->przygotujZapytanieWyszukujace();

		$warunki = $this->piszKryteria($kryteria);

		$zapytanie['kryteria'] = array_merge($zapytanie['kryteria'], $warunki);

		return $zapytanie;
	}



}