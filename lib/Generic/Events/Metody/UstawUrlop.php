<?php
namespace Generic\Events\Metody;
use Generic\Biblioteka\Events\Metoda;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Szablon as SzablonWidoku;
use Generic\Biblioteka\Pomocnik\Poczta;
use Generic\Model\EventMetody;
use Generic\Model\Uzytkownik;
use Generic\Model\Timelist;

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
class UstawUrlop extends Metoda {
	
	private $daneWejsciowe;
	private $konfiguracjaSzablonu;

	public function __construct($nazwaSzablonu, $kod, $daneStartowe = array()) {
		parent::__construct($nazwaSzablonu, $kod, $daneStartowe);
	}
	
	public function start(EventMetody\Obiekt $eventMetoda)
	{
		$daneWejsciowe = $eventMetoda->daneWejsciowe;
		$eventMaper = new EventMetody\Mapper();
		
		$idUser = isset($daneWejsciowe['idUser']) ? $daneWejsciowe['idUser'] : trigger_error('Kalendarz akcja ustaw urlop id uzytkownika nie zostało ustawione');
		$dataStart = isset($daneWejsciowe['dataStart']) ? $daneWejsciowe['dataStart'] : trigger_error('Kalendarz akcja ustaw urlop dataStart nie zostało ustawiona');
		$dataStop = isset($daneWejsciowe['dataStop']) ? $daneWejsciowe['dataStop'] : trigger_error('Kalendarz akcja ustaw urlop dataStop nie zostało ustawiona');
		
		$uzytkownik = $this->_cms->dane()->Uzytkownik()->pobierzPoId($idUser);
		
		if($uzytkownik instanceof Uzytkownik\Obiekt)
		{
			$daneWejsciowe = $eventMetoda->daneWejsciowe;
			switch($daneWejsciowe['rodzajDniWolnych'])
			{
				case 'dayOff' : $daneWejsciowe['dayOff'] = $this->ustawDayOff($uzytkownik, $dataStart, $dataStop);
					break;
				case 'sickDay' : $daneWejsciowe['sickDay'] = $this->ustawSickDay($uzytkownik, $dataStart, $dataStop);
					break;
				default : trigger_error('Nie znany typ dni wolnych : '.$daneWejsciowe['rodzajDniWolnych'].'. Dla uzytkownika o id : '.$idUser);
			}
			$eventMetoda->daneWejsciowe = $daneWejsciowe;
		}
		else
		{
			trigger_error('Nie znaleziono uzytkownika o id: '.$idUser);
		}
		$eventMetoda->zapisz($eventMaper);
	}
	
	public function stop(EventMetody\Obiekt $eventMetoda)
	{
		$this->zamknijEvent($eventMetoda);
	}
	
	public function aktualizujEventAkcja(EventMetody\Obiekt $eventMetoda)
	{
		$this->usunEventAkcja($eventMetoda);
		/*
		$idUser = isset($eventMetoda->daneWejsciowe['idUser']) ? $eventMetoda->daneWejsciowe['idUser'] : trigger_error('Kalendarz akcja ustaw urlop id uzytkownika nie zostało ustawione');
		$timelistMapper = new Timelist\Mapper();
		if(isset($eventMetoda->daneWejsciowe['dayOff']))
		{
			$timelistWpis = $timelistMapper->pobierzPoId($eventMetoda->daneWejsciowe['dayOff']);
			if($timelistWpis instanceof Timelist\Obiekt)
			{
				if($eventMetoda->wykonany)
				{
					$timelistWpis->dataStart = $eventMetoda->daneWejsciowe['dataStart'];
					$timelistWpis->dataStop = $eventMetoda->daneWejsciowe['dataStop'];
					$timelistWpis->zapisz($timelistMapper);
				}
			}
		}
		if(isset($eventMetoda->daneWejsciowe['sickDay']))
		{
			foreach($eventMetoda->daneWejsciowe['sickDay'] as $idTimelist)
			{
				$timelistWpis = $timelistMapper->pobierzPoId($idTimelist);
				if($timelistWpis instanceof Timelist\Obiekt)
				{
					if($eventMetoda->wykonany)
					{
						foreach($eventMetoda->daneWejsciowe['sickDay'] as $idTimelist)
						{
							$timelistWpis = $timelistMapper->pobierzPoId($idTimelist);
							$timelistWpis->usun($timelistMapper);
						}
					}
				}
			}
		}
		 * 
		 */
	}
	
	
	public function usunEventAkcja(EventMetody\Obiekt $eventMetoda)
	{
		$idUser = isset($eventMetoda->daneWejsciowe['idUser']) ? $eventMetoda->daneWejsciowe['idUser'] : trigger_error('Kalendarz akcja ustaw urlop id uzytkownika nie zostało ustawione');
		$timelistMapper = new Timelist\Mapper();
		if(isset($eventMetoda->daneWejsciowe['dayOff']))
		{
			$timelistWpis = $timelistMapper->pobierzPoId($eventMetoda->daneWejsciowe['dayOff']);
			if ($timelistWpis instanceof Timelist\Obiekt) $timelistWpis->usun($timelistMapper);
		}
		if(isset($eventMetoda->daneWejsciowe['sickDay']))
		{
			foreach($eventMetoda->daneWejsciowe['sickDay'] as $idTimelist)
			{
				$timelistWpis = $timelistMapper->pobierzPoId($idTimelist);
				if ($timelistWpis instanceof Timelist\Obiekt) $timelistWpis->usun($timelistMapper);
			}
		}
		return true;
	}
	
	public function ustawDayOff(Uzytkownik\Obiekt $pracownik, $dataStart, $dataStop)
	{
		$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
		$konfiguracja = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('konfiguracja.typ.holiday' , 'Timelist_Admin');
		
		$mapperTimelist = new Timelist\Mapper();
		
		$tablicaDniWolne = $this->liczDniWolne($dataStart, $dataStop);
		
		$obiekt = new Timelist\Obiekt();
		$obiekt->idProjektu = ID_PROJEKTU;
		$obiekt->idUser = $pracownik->id;
		$obiekt->stawka = $pracownik->stawkaGodzinowa;
		$obiekt->taxTable = $pracownik->tabelaPodatkowa;
		$obiekt->dataStart = $dataStart.' '.$konfiguracja['przedzial_godzin_od'];
		$obiekt->dataStop = $dataStop.' '.$konfiguracja['przedzial_godzin_do'];
		$obiekt->multiplier = $konfiguracja['przelicznik'];
		$obiekt->type = $konfiguracja['typ_nazwa'];
		$obiekt->hours = count($tablicaDniWolne) * $konfiguracja['domyslna_ilosc_godzin'];
		if($konfiguracja['stawka'] != '')
		{
			$obiekt->stawka = $konfiguracja['stawka'];
		}

		if(!$obiekt->zapisz($mapperTimelist))
		{
			trigger_error('Nie udało sie zapisać dni wolnych dla użytkownika o id '.$pracownik->id.' ('.$dataStart.' - '.$dataStop.')');
			return false;
		}
		return $obiekt->id;
	}
	
	private function ustawSickDay(Uzytkownik\Obiekt $pracownik, $dataStart, $dataStop)
	{
		$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
		$konfiguracja = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('konfiguracja.typ.seek_day' , 'Timelist_Admin');
		
		$tablicaDniWolne = $this->liczDniWolne($dataStart, $dataStop);
		
		$mapperTimelist = new Timelist\Mapper();
		$wpisyTimelist = array();				  
		foreach($tablicaDniWolne as $data)
		{
			$obiekt = new Timelist\Obiekt();
			$obiekt->idProjektu = ID_PROJEKTU;
			$obiekt->idUser = $pracownik->id;
			$obiekt->stawka = $pracownik->stawkaGodzinowa;
			$obiekt->taxTable = $pracownik->tabelaPodatkowa;

			$dataStart = $data.' '.$konfiguracja['przedzial_godzin_od'];
			$dataStop = $data.' '.$konfiguracja['przedzial_godzin_do'];

			$obiekt->dataStart = $dataStart;
			$obiekt->dataStop = $dataStop;
			$obiekt->multiplier = $konfiguracja['przelicznik'];
			$obiekt->type = $konfiguracja['typ_nazwa'];
			$obiekt->hours = $konfiguracja['domyslna_ilosc_godzin'];
			if($konfiguracja['stawka'] != '')
			{
				$obiekt->stawka = $konfiguracja['stawka'];
			}

			if(!$obiekt->zapisz($mapperTimelist))
			{
				trigger_error('Nie udało sie zapisać dni chorobowych dla użytkownika o id '.$pracownik->id.' ('.$dataStart.' - '.$dataStop.')');
			}
			else
			{
				array_push($wpisyTimelist, $obiekt->id);
			}
		}
		return $wpisyTimelist;
	}
					
	private function liczDniWolne($dataStart, $dataStop)
	{
		$data_od = strtotime($dataStart);
		$data_do = strtotime($dataStop);
		if ( $data_od <= $data_do )
		{
			$roznicaDat = $data_do - $data_od;
			$iloscDni = round(($roznicaDat/86400));
			$dzienOd = date('d', $data_od);
			$dzienDo = date('d', $data_do);

			$daty = array();
			$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
			$konfiguracja = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('liczDniWolne.pomin_dni_tygodnia' , 'Timelist_Admin');
			$daty[] = date("Y-m-d", $data_od);
			for($i = 0 ; $i < $iloscDni; $i++ )
			{
				$dzienTygodnia = date("l", $data_od);
				$data_od = date("Y-m-d", strtotime("+ 1 day", $data_od));
				
				if(in_array($dzienTygodnia, $konfiguracja))
				{
					$data_od = strtotime($data_od);
					continue;
				}

				$daty[] = $data_od;
				$data_od = strtotime($data_od);
			}

			return $daty;
				
	  }
	  else
	  {
		  return 0;
	  }
	}
	 
	public function wstawListeUzytkownikowIDniWolnychWidok(SzablonWidoku $widok, Array $parametry = array(), $dataTeam)
	{
	
		if(count($dataTeam))
		{
			$maperUzytkownik = $this->_cms->dane()->Uzytkownik();
			
			foreach($dataTeam as $idUser => $daty)
			{
				$uzytkownik = $maperUzytkownik->pobierzPoId($idUser);
				if($uzytkownik instanceof Uzytkownik\Obiekt)
				{
					$zdjecie_tmp = 'min-'.$uzytkownik->zdjecie;
					$zdjecie = $this->_cms->url('zdjecia_pracownikow' ,$zdjecie_tmp);
					$widok->ustawBlok('index/uzytkownik', array(
						'imie' => $uzytkownik->imie,
						'nazwisko' => $uzytkownik->nazwisko,
						'zdjecie' => $zdjecie,
					));
					//$this->widokDataStartStop($widok, $daty);
					$widok->ustawBlok('index/uzytkownik/sumaDni', array('sumaDni' => count($daty)));
				}
				foreach($daty as $data)
				{
					
				}
			}
		}
		else
		{
			
		}
		return $widok;
	}
	
	/*
	public function widokDataStartStop(SzablonWidoku $widok, $daty)
	{
		/*
		$dataTmp = new \DateTime($daty[0]);
		
		$dataStart = $daty[0];
		$dataStop = null;
		
		unset($daty[0]);
		$iloscDat = count($daty);
		$i = 0;
		foreach($daty as $data)
		{
			$i++;
			$dataTmp->add(new \DateInterval('P1D'));
			
			if($dataTmp->format('Y-m-d') !== $data)
				$dataStop = $daty[$i-1];
			elseif($iloscDat == $i)
				$dataStop = $data;
			
			if($dataStart != null && $dataStop != null)
			{
				$widok->ustawBlok('index/uzytkownik/dataStartStop', array(
					'dataStart' => $dataStart,
					'dataStop' => $dataStop,
				));
				$dataTmp = new \DateTime($data);
				$dataStart = $dataTmp->format('Y-m-d');
				$dataStop = null;
			}
		}
		 * 
		 */
		
		//return $widok;
	//}
	
}
