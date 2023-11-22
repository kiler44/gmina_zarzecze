<?php
namespace Generic\Biblioteka\Events;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;
use Generic\Model\Event;
use Generic\Model\EventMetody;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Szablon
 *
 * @author Marcin
 */
class EventKontener extends Szablon {
	
	protected $_nazwaSzablonu;
	protected $_cms;
	protected $_obiektGlowny;
	private $_tekstDoPodmiany = array(
		'{USER_NAME}' => 'Uzytkownik', 
		'{TEAM_NAME}' => 'Team',
		'{DATA_START}' => 'dataStart',
		'{DATA_STOP}' => 'dataStop',
	);
	/*
	 * dorobić możliwośc wstawienia w konstruktorze obiektu eventu wtedy można by zrobić spujny interfejs dla pobierania informacji o szablonie jesli event to z bazy jest niema to z szablony.php - zastanowic sie
	 */
	public function __construct($nazwaSzablonu) {

		parent::__construct($nazwaSzablonu);
		$this->pobierszKonfiguracjeSzablonu();
		
	}

	private function pobierzObiektGlowny($idTeam = null, $idUser = null)
	{
		if(!is_object($this->_obiektGlowny))
		{
			if(!isset($this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['typObiektu'])){ trigger_error('Nie ustawiono typu obiektu głównego', E_USER_ERROR); return false; }
			if(!isset($this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['idObiektu'])){ trigger_error('Nie ustawiono id obiektu głównego', E_USER_ERROR); return false; }
			
			// jesli obiekt główny nie istnieje tylko jest dodawany podczas dodawania eventu określamy metodę i akcję która zapisze obiekt główny
			if(is_array($this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['idObiektu']) && preg_match('/(akcja)([a-zA-Z0-9]+)/', $this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['idObiektu']['akcja'], $matches))
			{
				$nameSpace = '\\Generic\\Events\\Metody\\'.$matches[2];
				//$kluczMetody = array_search($this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['idObiektu'], $this->_konfiguracjaSzablonu['akcje']);
				$kluczMetody = array_search($this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['idObiektu'], array_column($this->_konfiguracjaSzablonu['akcje'], 'nazwa'));
				$metoda = $this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['idObiektu']['metoda'];
				$this->_obiektGlowny = $nameSpace::$metoda();
			}
			else
			{
				$obiektGlowny = $this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['typObiektu'];
				if($obiektGlowny == 'Uzytkownik' && ($idUser != null && $idUser > 0))
					$idObiektGlowny = $idUser;
				elseif($obiektGlowny == 'Team' && ($idTeam != null && $idTeam > 0))
					$idObiektGlowny = $idTeam;
				else
					$idObiektGlowny = Zadanie::pobierz('daneForm')[$this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['idObiektu']];

				$obiektMapper = $this->_cms->dane()->$obiektGlowny();
				$this->_obiektGlowny = $obiektMapper->pobierzPoId($idObiektGlowny);
			}
		}
		
		return $this->_obiektGlowny;
	}

	private function generujNazweWyswietlana($nazwaWyswietlana, $idTeam, $idUser, $dataStart, $dataStop)
	{
		if($dataStart instanceof \DateTime)
			$dataStart = $dataStart->format ('d-m-Y');
		if($dataStop instanceof \DateTime)
			$dataStop = $dataStop->format ('d-m-Y');
		
		foreach($this->_tekstDoPodmiany as $znajdz => $metoda)
		{
			if(strpos($nazwaWyswietlana, $znajdz) != FALSE)
			{
				switch($metoda)
				{
					case 'Uzytkownik' : $zamien = $this->pobierzNazweUzytkownika($idUser);
						break;
					case 'Team' : $zamien = $this->pobierzNazweTeamu($idTeam);
						break;
					case 'dataStart' : $zamien = $dataStart;
						break;
					case 'dataStop' : $zamien = $dataStop;
						break;
				}
				
				$nazwaWyswietlana = str_replace($znajdz, $zamien, $nazwaWyswietlana);
			
			}
				
		}
		return $nazwaWyswietlana;
	}
	
	private function pobierzNazweUzytkownika($idUser)
	{
		$nazwaUzytkownika = '';
		$uzytkownik = $this->_cms->dane()->Uzytkownik()->pobierzPoId($idUser);
		if($uzytkownik instanceof \Generic\Model\Uzytkownik\Obiekt)
			$nazwaUzytkownika = $uzytkownik->imie.' '.$uzytkownik->nazwisko;

		return $nazwaUzytkownika;
	}
	
	private function pobierzNazweTeamu($idTeam)
	{
		$nazwaTeamu = '';
		$team = $this->_cms->dane()->Team()->pobierzPoId($idUser);
		if($team instanceof \Generic\Model\Team\Obiekt)
			$nazwaTeamu = $uzytkownik->imie.' '.$uzytkownik->nazwisko;

		return $nazwaTeamu;
	}


	/**
	 * 
	 * @param type $idTeam - id teamu dla którego dodajemy event
	 * @param type $idUser - id uzytkownika któremu dodajemy event
	 * @param type $dataStart - data start eventu
	 * @param type $dataStop - data stop eventu
	 * @param type $daneFormularza - dane z formularza
	 * @param type $daneDataTeam - tablica [id_team_1][daty][istnieje] [id_team_2][daty][istnieje]
	 * @return boolean|\Generic\Model\Event\Obiekt
	 */
	public function zapiszEvent($idTeam = null , $idUser = null, $dataStart, $dataStop, $daneFormularza, $daneDataTeam)
	{
		$obiekt = $this->pobierzObiektGlowny($idTeam, $idUser);
		$bladTransakcji = 0;
		$maperEvent = $this->_cms->dane()->Event();
		$idEventuTeamu = array();
		
		$event = new Event\Obiekt();
		$event->nazwaSzablonu = $this->_nazwaSzablonu;
		$event->konfiguracjaSzablon = $this->_konfiguracjaSzablonu;
		$event->nazwa = $this->generujNazweWyswietlana($daneFormularza['nazwaWyswietlana'], $idTeam, $idUser, $dataStart, $dataStop);
		$event->idObiekt = $obiekt->id;
		$event->obiekt = $this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['typObiektu'];
		$daneStartowe = array(
			'dataStart' => $dataStart,
			'dataStop' => $dataStop,
			'idTeam' => $idTeam,
			'idUser' => $idUser,
			//'obiektGlowny' => $obiekt,
					  );
		
		if($event->zapisz($maperEvent))
		{
			foreach($this->pobierzAkcjeSzablonu() as $klucz => $akcja)
			{
				$nameSpace = '\\Generic\\Events\\Metody\\'.$akcja;
				$akcjaObiekt = new $nameSpace($event, $klucz, $daneStartowe);
				if(!$akcjaObiekt->zapisz($event, $idTeam, $idUser, $dataStart, $dataStop, $daneDataTeam)){ $bladTransakcji++; }
			}
		}
		else
			$bladTransakcji++;

		if($bladTransakcji){ return false; }else{ return $event; }
	}
	
	/**
	 * 
	 * @param \Generic\Model\Event\Obiekt $event
	 * @return boolean
	 */
	public function usunEvent(Event\Obiekt $event)
	{
		$maperEventAkcja = new \Generic\Model\EventMetody\Mapper();
		$maperEvent = new \Generic\Model\Event\Mapper();
		$blad = 0;
		$akcjeEventu = $event->pobierzMetody();
		foreach($akcjeEventu as $akcja)
		{
			$nameSpace = '\\Generic\\Events\\Metody\\'.$akcja->akcja;
			$akcjaObiekt = new $nameSpace($event, $akcja->kod);
			if(method_exists($akcjaObiekt, 'usunEventAkcja'))
			{
				($akcjaObiekt->usunEventAkcja($akcja)) ? (($akcja->usun($maperEventAkcja)) ? null : $blad++) : $blad++;
			}
			else
			{
				($akcja->usun($maperEventAkcja)) ? null : $blad++;
			}
		}
		if($blad == 0)
			return $event->usun($maperEvent);
		else
			return false;
	}
	/**
	 * 
	 * @param \Generic\Model\Event\Obiekt $event
	 * @param type $idTeam
	 * @param type $dataStart
	 * @param type $dataStop
	 * @param type $idUserNowy
	 * @return type
	 */
	public function aktualizujEvent(Event\Obiekt $event, $idTeam, $dataStart, $dataStop, $idUserNowy = null)
	{
		$listaMetodEventu = $event->pobierzMetody();
		$blad = 0;
		
		$mapperEvent = new Event\Mapper();
		if($this->pobierzNazwaWyswietlana() != null)
			$event->nazwa = $this->generujNazweWyswietlana($this->pobierzNazwaWyswietlana(), $idTeam, $idUserNowy, $dataStart, $dataStop);
		
		$event->wykonany = false;
		$event->zapisz($mapperEvent);
		
		foreach($listaMetodEventu as $akcja)
		{
			$nameSpace = '\\Generic\\Events\\Metody\\'.$akcja->akcja;
			$akcjaObiekt = new $nameSpace($event, $akcja->kod);
			$akcjaObiekt->aktualizuj($akcja, $idTeam, $dataStart, $dataStop, $idUserNowy);
		}
		
		$kalendarz = new \Generic\Events\Metody\DaneKalendarza($event, $akcja->kod);
		$kalendarz->aktualizujEventAkcja(null, $dataStart, $dataStop, $idTeam, $idUserNowy);
		
		return ($blad > 0) ? false : true;
	}
	
	
	/**
	 * 
	 * @param \Generic\Model\Event\Obiekt $event
	 * @param type $idTeam
	 * @param type $idUser
	 * @param type $dataStart
	 * @param type $dataStop
	 * @return int|\Generic\Model\Event\Obiekt
	 */
	public function klonujEvent(Event\Obiekt $event, $idTeam, $idUser, $dataStart, $dataStop)
	{
		$blad = 0;
		$listaMetodEventu = $event->pobierzMetody();
		$mapperEvent = $this->_cms->dane()->Event();
		$nowyEvent = new Event\Obiekt();
		$nowyEvent->wykonany = false;
		$nowyEvent->idObiekt = $event->idObiekt;
		$nowyEvent->konfiguracjaSzablon = $event->konfiguracjaSzablon;
		
		if($this->pobierzNazwaWyswietlana() != null)
			$nowyEvent->nazwa = $this->generujNazweWyswietlana($this->pobierzNazwaWyswietlana(), $idTeam, $idUser, $dataStart, $dataStop);
		else
			$nowyEvent->nazwa = $event->nazwa;
		
		$nowyEvent->nazwaSzablonu = $event->nazwaSzablonu;
		$nowyEvent->obiekt = $event->obiekt;
		$nowyEvent->zapisz($mapperEvent);
		
		$mapperEventMetody = $this->_cms->dane()->EventMetody();
		foreach($listaMetodEventu as $akcja)
		{
			$eventMetoda = new \Generic\Model\EventMetody\Obiekt();
			$eventMetoda->akcja = $akcja->akcja;
			$eventMetoda->daneWejsciowe = $akcja->daneWejsciowe;
			$eventMetoda->daneWyjsciowe = $akcja->daneWyjsciowe;
			if($akcja->dataWykonania != ''){ $eventMetoda->dataWykonania = $akcja->dataWykonania;  }
			$eventMetoda->idEvent = $nowyEvent->id;
			$eventMetoda->idWymagane = $akcja->idWymagane;
			$eventMetoda->kod = $akcja->kod;
			$eventMetoda->konfiguracja = $akcja->konfiguracja;
			$eventMetoda->konfiguracjaSzablon = $akcja->konfiguracjaSzablon;
			$eventMetoda->opis = $akcja->opis;
			$eventMetoda->szablon = $akcja->szablon;
			$eventMetoda->wykonany = false;
			if(!$eventMetoda->zapisz($mapperEventMetody))
				return 0;
		}
		
		$listaMetodNowegoEventu = $nowyEvent->pobierzMetody();
		$kodKalendarza = $this->pobierzKodKalendarz();
		$kalendarz = new \Generic\Events\Metody\DaneKalendarza($nowyEvent, $kodKalendarza, array(
			'dataStart' => $dataStart,
			'dataStop' => $dataStop,
			'idTeam' => $idTeam,
			'idUser' => $idUser,
		));
		
		$aktualizujKalendarz = $kalendarz->aktualizujEventAkcja(null, $dataStart, $dataStop, $idTeam, $idUser, $event->id);
		
		dump($aktualizujKalendarz);die;
		foreach($listaMetodNowegoEventu as $akcja)
		{
			$nameSpace = '\\Generic\\Events\\Metody\\'.$akcja->akcja;
			$akcjaObiekt = new $nameSpace($nowyEvent, $akcja->kod);
			$akcjaObiekt->aktualizuj($akcja, $idTeam, $dataStart, $dataStop, $idUser);
		}
		
		
		
		//
		// return ($this->aktualizujEvent($nowyEvent, $idTeam, $roznicaData)) ? $nowyEvent->id : 0;
		return $nowyEvent;
	}
	
	public function sprawdzCzyEventDoUruchomienia(Event\Obiekt $event)
	{
		$akcjeEventu = $event->pobierzMetody();
		$dataDzisiaj = new \DateTime();
		/* @var  $akcja \Generic\Model\EventMetody\Obiekt	*/
		foreach($akcjeEventu as $akcja)
		{
			$roznicaDat = $dataDzisiaj->diff($akcja->dataWykonania, false);
			if($roznicaDat->format("%r%a") < 1) return true;
		}
		return false;
	}

	public function uruchomEvent(Event\Obiekt $event)
	{
		$listaMetodEventu = $event->pobierzMetody();
		$dataDzisiaj = new \DateTime(date('Y-m-d'));
		$maperMetodyEventu = $this->_cms->dane()->EventMetody();

		foreach($listaMetodEventu as $metodaId)
		{
			// pobieramy ponownie metodeEventu bo mogła zostać zaktualizowana przez inną metode Eventu
			$metoda = $maperMetodyEventu->pobierzPoId($metodaId->id);
			
			if(!$metoda->wykonany && $metoda->dataWykonania != null && $metoda->dataWykonania != '')
			{
				$interval = $dataDzisiaj->diff($metoda->dataWykonania);
				if($interval->format('%R%a') <= 0)
				{
					$namespace = '\\Generic\\Events\\Metody\\'.$metoda->akcja;
					$akcja = new $namespace($event, $metoda->kod);
					$akcja->start($metoda);
					$akcja->stop($metoda);
				}
			}
		}
		return true;
	}

	/**
	 * 
	 * @param array $tabInfo - [idTeam][daty]
	 * @return string - html
	 */
	public function budujWidokEventu($tabInfo)
	{
		$akcjeSzablonu = $this->pobierzAkcjeSzablonu();
		$event = new Event\Obiekt();
		$event->nazwaSzablonu = $this->_nazwaSzablonu;
		$html = '';
		$i = 0;
		$akcjaDaneKalendarzaIstnieje = false;
		foreach($akcjeSzablonu as $klucz => $akcja)
		{
			if($akcja == 'DaneKalendarza'){ $akcjaDaneKalendarzaIstnieje = true; }
				
			$nameSpace = '\\Generic\\Events\\Metody\\'.$akcja;
			$akcjaObiekt = new $nameSpace($event, $klucz);
			$html .= $akcjaObiekt->budujWidok($tabInfo);
		}
		if(!$akcjaDaneKalendarzaIstnieje){  trigger_error('Brak akcji DaneKalendarza w szablonie '.$this->_nazwaSzablonu , E_USER_ERROR); }
		
		return $html;
	}
	
}
