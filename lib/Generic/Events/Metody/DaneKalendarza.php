<?php
namespace Generic\Events\Metody;
use Generic\Biblioteka\Events\Metoda;
use Generic\Model\EventMetody;
use Generic\Biblioteka\Cms;
use Generic\Model\Kalendarz;
use Generic\Biblioteka\Zadanie;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Powiadomienie
 *
 * @author Marcin
 */
class DaneKalendarza extends Metoda {
	
	
	public function start(EventMetody\Obiekt $eventMetoda)
	{
		
	}
	
	public function stop(EventMetody\Obiekt $eventMetoda)
	{
		
	}
	
	public function zapiszEventAkcja($idTeam, $idUser, $dataStart, $dataStop, $daneDataTeam, $daneFormularza, $eventMetoda)
	{
		$daneFormularza = Zadanie::pobierz('daneForm');
		$obiektKalendarz = new Kalendarz\Obiekt();
		$obiektKalendarz->idAutora = Cms::inst()->profil()->id;
		$obiektKalendarz->tytul =  $daneFormularza['nazwaWyswietlana'];
		$obiektKalendarz->komentarz =  $daneFormularza['komentarz'];
		$obiektKalendarz->opcjeDodatkowe = array('kolor' => $daneFormularza['kolor'], 'kolorCzcionki' => $this->ustawKolorCzcionki($daneFormularza['kolor']));
		$obiektKalendarz->tytul = $this->_event->nazwa;
		
		$maperKalendarz = new Kalendarz\Mapper();
		$dataStart = new \DateTime($dataStart);
		$dataStop = new \DateTime($dataStop);
		
		$blad = 0;
		while($dataStart->diff($dataStop)->format('%R%') == '+')
		{
			$nowyObiekt = clone $obiektKalendarz;
					  
			if($idUser != null && $idUser > 0)
				$nowyObiekt->idUser = $idUser;

			$nowyObiekt->idEvent = $this->_event->id;
			$nowyObiekt->data = $dataStart;
			$nowyObiekt->idTeam = $idTeam;
			
			if(!$nowyObiekt->zapisz($maperKalendarz))
				$blad++;
			
			$dataStart->add(new \DateInterval('P1D'));
		}
		return ($blad > 0) ? false : true;
	}
	
	public function aktualizujEventAkcja($eventMetoda, $dataStart, $dataStop, $idTeam, $idUser, $usunWpis = true, $idEventKlonowany = null)
	{
		$maperKalendarz = new Kalendarz\Mapper();
		if($idEventKlonowany!=null)
			$kalendarz = $maperKalendarz->szukaj(array('id_event' => $idEventKlonowany));
		else
			$kalendarz = $maperKalendarz->szukaj(array('id_event' => $this->_event->id));
		
		dump($kalendarz[0]);
		die;
		if(!($dataStart instanceof \DateTime ))
			$dataStart = new \DateTime($dataStart);
		if(!($dataStop instanceof \DateTime ))
			$dataStop = new \DateTime($dataStop);
		
		$blad = 0;
		$iloscDni = $dataStart->diff($dataStop)->d;
		if($iloscDni)
		{
			$wpisKalendarza = $kalendarz[0];
			
			while($dataStart->diff($dataStop)->format('%R%') == '+')
			{
				$nowyObiekt = clone $wpisKalendarza;
				
            $nowyObiekt->godziny = $wpisKalendarza->godziny;
				$nowyObiekt->idObiekt = $wpisKalendarza->idObiekt;
            $nowyObiekt->obiekt = $wpisKalendarza->obiekt;
            $nowyObiekt->idAutora = $wpisKalendarza->idAutora;
            //$nowyObiekt->dataDodania = $wpisKalendarza->dataDodania;
            $nowyObiekt->tytul = $this->_event->nazwa;
            $nowyObiekt->powiadomienie = $wpisKalendarza->powiadomienie;
				
            $nowyObiekt->powiadomienieUzytkownicy = $wpisKalendarza->powiadomienieUzytkownicy;
				
            $nowyObiekt->komentarz = $wpisKalendarza->komentarz;
            $nowyObiekt->opcjeDodatkowe = $wpisKalendarza->opcjeDodatkowe;

				if($idUser != null && $idUser > 0)
					$nowyObiekt->idUser = $idUser;

				$nowyObiekt->idEvent = $this->_event->id;
				$nowyObiekt->data = $dataStart;
				$nowyObiekt->idTeam = $idTeam;
				$nowyObiekt->idProjektu = ID_PROJEKTU;

				if(!$nowyObiekt->zapisz($maperKalendarz))
					$blad++;

				$dataStart->add(new \DateInterval('P1D'));
			}
			
			if($usunWpis)
			{
				foreach($kalendarz as $wpis)
				{
					$wpis->usun($maperKalendarz);
				}
			}
			
		}
		
		return ($blad > 0) ? false : true;
		
	}

	public function ustawDataStartStopTeamWidok($widok, $parametry, $dataTeam)
	{
		$cms = Cms::inst();
		$maperTeam = $cms->dane()->Team()->zwracaTablice('id', 'team_number');
		$listaTeamow = listaZTablicy($maperTeam->szukaj(array('status' => 'active')), 'id', 'team_number');
		
		$widok->ustawBlok('index/dataStartStopTeam/', array('powitanie' => 'Witam'));
		
		foreach($dataTeam as $team => $daty )
		{
			$daty = array_keys($daty);
			$widok->ustawBlok('index/dataStartStopTeam/team', array('teamS' => $listaTeamow[$team], 'dataStart' => $daty[0], 'dataStop' => $daty[count($daty)-1] ));
		}
		
		return $widok;
	}
	
	private function ustawKolorCzcionki($kolorTla)
	{
		return array_sum(hex2rgb($kolorTla)) > 128*3 ? '#000' : '#fff';
	}
	
}
