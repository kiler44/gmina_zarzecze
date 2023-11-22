<?php
namespace Generic\Events\Metody;
use Generic\Biblioteka\Events\Metoda;
use Generic\Model\EventMetody;
use Generic\Model\Team;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of przydzielTeam
 *
 * @author Marcin
 */
final class PrzydzielTeam extends Metoda {
	
	private $zamknijEvent = 0;


	public function __construct(\Generic\Model\Event\Obiekt $event, $kod, $daneStartowe = array()) {
		parent::__construct($event, $kod, $daneStartowe);
	}

	public function start(EventMetody\Obiekt $eventMetoda)
	{
		$daneWejsciowe = $eventMetoda->daneWejsciowe;
		//dump($eventMetoda->konfiguracjaSzablon);
		$mapperMetoda = $this->_cms->dane()->EventMetody();
		$mapperTeam = $this->_cms->dane()->Team();
		$team = $mapperTeam->pobierzPoId($daneWejsciowe['idTeam']);
		
		if($team instanceof Team\Obiekt)
		{
			$this->zamknijEvent = 1;
			$team->przydzielProjekt($daneWejsciowe['idProjektu']);
		}
		else
		{
			$eventMetoda->dataWykonania = $this->liczDateWykonania($eventMetoda->dataWykonania->format('Y-m-d H:i:s'), '+ 1 day');
			$eventMetoda->zapisz($mapperMetoda);
		}
		
		$daneWyjsciowe = $eventMetoda->daneWyjsciowe;
		$daneWyjsciowe['dataWykonania'] = date('Y-m-d');
		$eventMetoda->daneWyjsciowe = $daneWyjsciowe;
		$eventMetoda->zapisz($mapperMetoda); 
	}
	
	public function stop(EventMetody\Obiekt $eventMetoda)
	{
		$this->aktualizujDaneWejscioweMetodWymaganych($eventMetoda); 
		
		if($this->zamknijEvent )
			$this->zamknijEvent($eventMetoda);
	}
	
	public function usunEventAkcja(EventMetody\Obiekt $akcja)
	{
		(isset($akcja->daneWejsciowe['idTeam'])) ? null : trigger_error('Brak danych idTeamu w akcji o id : '.$akcja->id);
		(isset($akcja->daneWejsciowe['idProjektu'])) ? null : trigger_error('Brak danych idProjektu w akcji o id : '.$akcja->id);
		
		$mapperMetoda = $this->_cms->dane()->EventMetody();
		$mapperTeam = $this->_cms->dane()->Team();
		$team = $mapperTeam->pobierzPoId($akcja->daneWejsciowe['idTeam']);
		
		if($team instanceof Team\Obiekt)
		{
			$team->usunPrzydzielenieProjektu($akcja->daneWejsciowe['idProjektu']);
			return true;
		}
		return false;
	}
	
	public function aktualizujTeam(EventMetody\Obiekt $eventMetoda, $idTeam)
	{
		if($eventMetoda->wykonany)
		{
			$zamowienie = $eventMetoda->pobierzEvent()->pobierzObiektGlowny();
			if($zamowienie instanceof \Generic\Model\Zamowienie\Obiekt)
			{
				$nowyTeam = $this->_cms->dane()->Team()->pobierzPoId($idTeam);
				if($nowyTeam instanceof Team\Obiekt)
					$nowyTeam->przydzielProjekt($zamowienie->id);
				
				$staryTeam = $this->_cms->dane()->Team()->pobierzPoId($eventMetoda->daneWejsciowe['idTeam']);
				
				if($staryTeam instanceof Team\Obiekt)
					$staryTeam->usunPrzydzielenieProjektu($zamowienie->id);
			}
			
			$mapper = $this->_cms->dane()->EventMetody();
			$eventMetoda->wykonany = false;
			$eventMetoda->zapisz($mapper);
		}
		
		return parent::aktualizujTeam($eventMetoda, $idTeam);
			
	}
	
	
}
