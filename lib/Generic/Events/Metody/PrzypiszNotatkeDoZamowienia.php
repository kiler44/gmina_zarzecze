<?php
namespace Generic\Events\Metody;
use Generic\Biblioteka\Events\Metoda;
use Generic\Model\Notes;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;
use Generic\Model\EventMetody;
/*

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrzypiszNotatkeDoZamowienia
 *
 * @author Marcin
 */
class PrzypiszNotatkeDoZamowienia  extends Metoda {
	
	private $zamknijEvent = 0;


	public function __construct(\Generic\Model\Event\Obiekt $event, $kod, $daneStartowe = array()) {
		parent::__construct($event, $kod, $daneStartowe);
	}
	
	public function start(EventMetody\Obiekt $eventMetoda)
	{
		$daneWejsciowe = $eventMetoda->daneWejsciowe;
		$maperNotes = $this->_cms->dane()->Notes();
		$maperZamowienie = $this->_cms->dane()->Zamowienie();
		
		$mapperMetoda = $this->_cms->dane()->EventMetody();
		
		$notatka = $maperNotes->pobierzPoId($daneWejsciowe['idNotatki']);
		
		$zamowienie = $maperZamowienie->szukaj(array('number_order_get' => $notatka->orderNumber));
		
		if(isset($zamowienie[0]) && $zamowienie[0] instanceof \Generic\Model\Zamowienie\Obiekt)
		{
			$notatka->idObject = $zamowienie[0]->id;
			$notatka->object = 'Zamowienie';
			$notatka->zapisz($maperNotes);
			$this->zamknijEvent = 1;
			
		}
		elseif(date('H') >= 23)
		{
			$eventMetoda->dataWykonania = $this->liczDateWykonania($eventMetoda->dataWykonania->format('Y-m-d H:i:s'), '+ 1 day');
			$eventMetoda->zapisz($mapperMetoda);
		}
		
	}
	
	public function stop(EventMetody\Obiekt $eventMetoda)
	{
		if($this->zamknijEvent)
			$this->zamknijEvent($eventMetoda);
	}
	
	public function usunEventAkcja(EventMetody\Obiekt $akcja)
	{
		$maperNotes = $this->_cms->dane()->Notes();
		$notatka = $maperNotes->pobierzPoId($akcja->daneWejsciowe['idNotatki']);
		if($notatka instanceof Notes\Obiekt)
		{
			return $notatka->usun($maperNotes);
		}
		return true;
	}
	
	
}
