<?php
namespace Generic\Events\Metody;
use Generic\Biblioteka\Events\Metoda;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Szablon as SzablonWidoku;
use Generic\Biblioteka\Pomocnik\Poczta;
use Generic\Model\EventMetody;
use Generic\Model\Uzytkownik;

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
class Powiadomienie extends Metoda {
	
	private $daneWejsciowe;
	private $konfiguracjaSzablonu;
	private $trescDoPodmiany = array(
		'{TEAM_NAME}' => array(
				'obiekt' => 'obiekt_NowyTeam' ,
				'wlasnosc' => 'teamNumber'
			),
		'{ZAMOWIENIE_NAZWA}' => array(
			'obiekt' => 'obiekt_Zamowienie' ,
			'wlasnosc' => 'orderName'
		),
		'{NOTATKA_TRESC}' => array(
			'obiekt' => 'obiekt_Notes' ,
			'wlasnosc' => 'description'
		),
	);

	/**
	 * wywoływana w Cronie jako pierwsza
	 * @param \Generic\Model\EventMetody\Obiekt $eventMetoda
	 */
	public function start(EventMetody\Obiekt $eventMetoda)
	{
		$this->daneWejsciowe = $eventMetoda->daneWejsciowe;
		$this->konfiguracjaSzablonu = $eventMetoda->konfiguracjaSzablon; 
		
		$teamMapper = $this->_cms->dane()->Team();
		
		$teamObiekt = $teamMapper->pobierzPoId($eventMetoda->daneWejsciowe['idTeam']);
		
		if(isset($eventMetoda->daneWejsciowe['powiadomUzytkownikSms']))
			$this->wyslijPowiadomienieSms($teamObiekt, $eventMetoda->daneWejsciowe['powiadomUzytkownikSms'], $eventMetoda);
		
		if(isset($eventMetoda->daneWejsciowe['powiadomUzytkownikEmail']))
			$this->wyslijPowiadomienieEmail($teamObiekt, $eventMetoda->daneWejsciowe['powiadomUzytkownikEmail'], $eventMetoda);
		
	}
	
	/**
	 * wywoływana w cronie po wywołaniu start
	 * @param \Generic\Model\EventMetody\Obiekt $eventMetoda
	 */
	public function stop(EventMetody\Obiekt $eventMetoda)
	{
		$this->zamknijEvent($eventMetoda);
	}
	
	//$idTeam, $idUser, $dataStart, $dataStop, $daneDataTeam, $daneFormularza, $eventMetoda
	public function zapiszEventAkcja($idTeam, $idUser, $dataStart, $dataStop, $daneDataTeam, $daneFormularza, $eventMetoda)
	{
		$opisMetody = $this->pobierzOpisZSzablonu();
		if(isset($daneFormularza['powiadomSmsIdUzytkownika']) && count($daneFormularza['powiadomSmsIdUzytkownika']) > 1)
		{
			$maperEventMetoda = $this->_cms->dane()->EventMetody();
			$uzytkownikMaper = new Uzytkownik\Mapper();
			$i = 0;
			foreach($daneFormularza['powiadomSmsIdUzytkownika'] as $idUzytkownika)
			{
				$uzytkownik = $uzytkownikMaper->pobierzPoId($idUzytkownika);
				if($uzytkownik instanceof Uzytkownik\Obiekt)
				{
					$klonSms = clone $eventMetoda;
					$iloscDni = $daneFormularza['powiadomSmsDni'][$i];
					$odKiedy = $daneFormularza['powiadomSmsKiedy'][$i];
					$dataWykonania = $this->generujDateWykonania($dataStart, $dataStop, $odKiedy, $iloscDni );
					$klonSms->dataWykonania = $dataWykonania;
					$klonSms->daneWejsciowe = array_merge($eventMetoda->daneWejsciowe, array('powiadomUzytkownikSms' => $idUzytkownika));
					$klonSms->daneWyjsciowe = (is_array($eventMetoda->daneWyjsciowe)) 
							  ?  array_merge($eventMetoda->daneWyjsciowe, array('dataWykonania' => $dataWykonania->format('d-m-Y'))) :  array('dataWykonania' => $dataWykonania->format('d-m-Y')) ;
				
					$klonSms->opis = str_replace(array('{TYP}', '{UZYTKOWNIK_IMIE}', '{UZYTKOWNIK_NAZWISKO}'), array('Sms', $uzytkownik->imie, $uzytkownik->nazwisko ), $opisMetody);
					$klonSms->zapisz($maperEventMetoda);
				}
				$i++;
			}

			$j = 0;
			foreach($daneFormularza['powiadomEmailIdUzytkownika'] as $idUzytkownika)
			{
				$uzytkownik = $uzytkownikMaper->pobierzPoId($idUzytkownika);
				if($uzytkownik instanceof Uzytkownik\Obiekt)
				{
					$klonEmail = clone $eventMetoda;
					$iloscDni = $daneFormularza['powiadomEmailDni'][$j];
					$odKiedy = $daneFormularza['powiadomEmailKiedy'][$j];
					$dataWykonania = $this->generujDateWykonania($dataStart, $dataStop, $odKiedy, $iloscDni);
					$klonEmail->dataWykonania = $dataWykonania;
					$klonEmail->daneWejsciowe = array_merge($eventMetoda->daneWejsciowe, array('powiadomUzytkownikEmail' => $idUzytkownika));
					$klonEmail->daneWyjsciowe = (is_array($eventMetoda->daneWyjsciowe)) 
								  ?  array_merge($eventMetoda->daneWyjsciowe, array('dataWykonania' => $dataWykonania->format('d-m-Y'))) :  array('dataWykonania' => $dataWykonania->format('d-m-Y')) ;
					
					$klonEmail->opis = str_replace(array('{TYP}', '{UZYTKOWNIK_IMIE}', '{UZYTKOWNIK_NAZWISKO}'), array('Email', $uzytkownik->imie, $uzytkownik->nazwisko ), $opisMetody);
					$klonEmail->zapisz($maperEventMetoda);
				}
				$j++;
			}
			
		}

		return true;
	}


	private function wyslijPowiadomienieSms($teamObiekt, $users, $eventMetoda)
	{
		/*
		$uzytkownicy = $this->pobierzUzytkownikowDoPowiadomienia($teamObiekt, $users);
		
		foreach($uzytkownicy as $uzytkownik)
		{
			$sms = new \Generic\Biblioteka\SmsNorwegia();
			$wiadomosc = $this->pobierzWiadomoscSms($uzytkownik);

			$sms->wyslijSms($uzytkownik, 'system', $wiadomosc, 'sms_kalendarz', $eventMetoda);
		}
		 * 
		 */
		$maperUzytkownik = new Uzytkownik\Mapper();
		$uzytkownik = $maperUzytkownik->pobierzPoId($users);
		$sms = new \Generic\Biblioteka\SmsNorwegia();
		$wiadomosc = $this->pobierzWiadomoscSms($uzytkownik);
		
		if($uzytkownik->telKomorkaFirmowa != '')
			$sms->wyslijSms($uzytkownik, 'system', $wiadomosc, 'sms_kalendarz', $eventMetoda);
		
	}
	
	private function pobierzWiadomoscSms($uzytkownik)
	{
		$wiadomosc = $this->konfiguracjaSzablonu['konfiguracjaMetody']['wiadomoscSms'][$uzytkownik->jezyk];
		$dane = $this->pobierzObiektyDoPowiadomien();
		
		foreach($this->trescDoPodmiany as $szukaj => $infoObiekt)
		{
			if(isset($dane[$infoObiekt['obiekt']]))
				$wiadomosc = str_replace($szukaj, $dane[$infoObiekt['obiekt']]->$infoObiekt['wlasnosc'] , $wiadomosc);
		}

		return $wiadomosc;
	}
	
	private function wyslijPowiadomienieEmail($teamObiekt, $users, $eventMetoda)
	{
		/*
		$uzytkownicy = $this->pobierzUzytkownikowDoPowiadomienia($teamObiekt, $users);

		$dane = $this->pobierzObiektyDoPowiadomien();
		foreach($uzytkownicy as $uzytkownik)
		{
			$dane['obiekt_Uzytkownik'] = $uzytkownik;
			
			$poczta = new Poczta($this->konfiguracjaSzablonu['konfiguracjaMetody']['idSzablonEmail'], $dane);
			$status = $poczta->wyslij();
		}
		 * 
		 */
		$maperUzytkownik = new Uzytkownik\Mapper();
		$uzytkownik = $maperUzytkownik->pobierzPoId($users);
		
		$dane['obiekt_Uzytkownik'] = $uzytkownik;
		foreach($this->pobierzObiektyPowiazane($eventMetoda) as $obiektNazwa => $obiekt )
		{
			$dane['obiekt_'.$obiektNazwa] = $obiekt;
		}
		
		$poczta = new Poczta($this->konfiguracjaSzablonu['konfiguracjaMetody']['idSzablonEmail'], $dane);
		$status = $poczta->wyslij();
	}
	
	private function pobierzObiektyDoPowiadomien()
	{
		$obiekty = array();
		foreach($this->konfiguracjaSzablonu['konfiguracjaMetody']['obiekty'] as $obiektNazwa => $dane)
		{
			$obiekt = $this->_cms->dane()->$dane['dane']()->pobierzPoId($this->daneWejsciowe[$dane['daneWejsciowe']]);
			
			$obiekty[$obiektNazwa] = $obiekt;
		}
		return $obiekty;
	}
	
	private function pobierzUzytkownikowDoPowiadomienia($teamObiekt, $uzytkownicy)
	{
		$uzytkownicyDoPowiadomienia = array();
		$maperUzytkownicy = $this->_cms->dane()->Uzytkownik();
		if(isset($uzytkownicy['lider']) && $uzytkownicy['lider'])
		{
			$uzytkownicyDoPowiadomienia[] = $teamObiekt->pobierzLideraTeamu();
		}
		if(isset($uzytkownicy['profil']) && $uzytkownicy['profil'] > 0)
		{
			$uzytkownicyDoPowiadomienia[] = $maperUzytkownicy->pobierzPoId($uzytkownicy['profil']);
		}
		if(count($uzytkownicy['users']))
		{ 
			$uzytkownicyZbazy = $maperUzytkownicy->szukaj(array('wiele_id' => $uzytkownicy['users']));
			foreach($uzytkownicyZbazy as $usr)
			{
				$uzytkownicyDoPowiadomienia[] = $usr;
			}
		}
		
		return $uzytkownicyDoPowiadomienia;
	}
	
	
	
	
	/**
	 * @param array $dane - tablica id uzytkownikow do powiadomienia
	 * @param int $idTeam - idTeamu do powiadomienia
	 * @return array - lista uzytkownikow do powiaodmienia array(
	 * lider - jesli 1 znaczy ze lider ma zostac powiadomiony (nie zapisujemy id lider bo może on sie zmienić poza modulem)
	 * users - lista id uzytkownikow do powiadomienia
	 * )
	 */
	public function powiadomUzytkownikSmsZapisz($daneForm, $idTeam, $idUser, $daneDataTeam)
	{
		$return = array();
		//dump($daneDataTeam);
		$liders = listaZObiektow($this->pobierzListeLiderow($daneDataTeam), 'id', 'id');
		
		$team = $this->_cms->dane()->Team()->pobierzPoId($idTeam);
		$liderTeamu = $team->pobierzLideraTeamu();
		
		$uzytkownicy = (count($daneForm['powiadomUzytkownikSms']) > 1) ? $daneForm['powiadomUzytkownikSms'] : array($daneForm['powiadomUzytkownikSms']);

		foreach($uzytkownicy as $idUser)
		{
			if(isset($daneForm['kiedy_sms_'.$idUser]) && is_array($daneForm['kiedy_sms_'.$idUser]))
			{
				foreach($daneForm['kiedy_sms_'.$idUser] as $kiedy)
				{
					
				}
			}
			else
			{
				
			}
			
			if($liderTeamu instanceof Uzytkownik\Obiekt && $idUser == $liderTeamu->id){
				$return['lider'] = 1;			
				continue;
			}
			
			if($idUser == $this->_cms->profil()->id)
			{
				$return['profil'] = $idUser;
				continue;
			}
				
			if(in_array($idUser, $liders))
			{
				continue;
			}
			
			$return['users'][] = $idUser;
		}

		return $return;
	}
	/**
	 * 
	 * @param array $dane - tablica id uzytkownikow do powiadomienia
	 * @param int $idTeam - idTeamu do powiadomienia
	 * @return array - lista uzytkownikow do powiaodmienia array(
	 * lider - jesli 1 znaczy ze lider ma zostac powiadomiony (nie zapisujemy id lider bo może ono ulec zmianie poza modulem)
	 * users - lista id uzytkownikow do powiadomienia
	 * )
	 */
	public function powiadomUzytkownikEmailZapisz($dane, $idTeam, $idUser, $daneDataTeam)
	{
		$return = array();
		$liders = listaZObiektow($this->pobierzListeLiderow($daneDataTeam), 'id', 'id');
		
		$team = $this->_cms->dane()->Team()->pobierzPoId($idTeam);
		$liderTeamu = $team->pobierzLideraTeamu();
		$dane = (count($dane) > 1) ? $dane : array($dane);
		
		foreach($dane as $idUser)
		{
			if($liderTeamu instanceof Uzytkownik\Obiekt && $idUser == $liderTeamu->id){
				$return['lider'] = 1;
				continue;
			}
			if($idUser == $this->_cms->profil()->id)
			{
				$return['profil'] = $idUser;
				continue;
			}
			if(in_array($idUser, $liders))
			{
				continue;
			}
			
			$return['users'][] = $idUser;
		}

		return $return;
	}
	
	public function pobierzUzytkownika(EventMetody\Obiekt $eventMetoda, $parametr)
	{
		if($parametr == 'profil')
		{
			$id = $eventMetoda->daneWejsciowe['powiadomUzytkownikEmail'][$parametr];
		}
		return $id;
	}

	
	public function ustawListeUzytkownikowDoPowiadomieniaWidok(SzablonWidoku $widok, $parametry, $daneDataTeam)
	{
		$konfiguracjaMetody = $this->pobierzKonfiguracjeMetody();
		$listaUzytkownikow = array();
		
		if(isset($konfiguracjaMetody['powiadomienie']['uzytkownicy']) && count($konfiguracjaMetody['powiadomienie']['uzytkownicy']))
		{
			$listaUzytkownikow = $this->_cms->dane()->Uzytkownik()->szukaj(array('wiele_id' => $konfiguracjaMetody['powiadomienie']['uzytkownicy']));
		}
		if(isset($konfiguracjaMetody['powiadomienie']['grupyUzytkownikow']))
		{
			foreach($konfiguracjaMetody['powiadomienie']['grupyUzytkownikow'] as $grupa)
			{
				switch($grupa)
				{
					case 'lider' : $listaUzytkownikow = array_merge($listaUzytkownikow, $this->pobierzListeLiderow($daneDataTeam));
				}
			}
		}
		if(isset($konfiguracjaMetody['powiadomienie']['profil']) && $konfiguracjaMetody['powiadomienie']['profil'])
		{
			array_push($listaUzytkownikow, $this->_cms->profil());
		}
		array_filter($listaUzytkownikow);
		if(count($listaUzytkownikow))
		{
			foreach($listaUzytkownikow as $uzytkownik)
			{
				if($uzytkownik == '') continue;
				
				$zdjecie_tmp = 'min-'.$uzytkownik->zdjecie;
				$zdjecie =  $this->_cms->url('zdjecia_pracownikow' ,$zdjecie_tmp);

				$widok->ustawBlok('index/uzytkownicySelect/uzytkownikPowiadom', array(
					'domyslnyStartSms' => (isset($parametry['domyslnyStartSms'])) ? $parametry['domyslnyStartSms'] : '',
					'domyslnyStartEmail' => (isset($parametry['domyslnyStartEmail'])) ? $parametry['domyslnyStartEmail'] : '',
					'dniSms' => (isset($parametry['dniSms'])) ? $parametry['dniSms'] : '',
					'dniEmail' => (isset($parametry['dniEmail'])) ? $parametry['dniEmail'] : '',
					'uId' => $uzytkownik->id,
					'zdjecie' => $zdjecie,
					'imie' => $uzytkownik->imie.' '.$uzytkownik->nazwisko,
					'zaznaczPowiadomienieSms' => $konfiguracjaMetody['zaznaczPowiadomienieSms'],
					'zaznaczPowiadomienieEmail' => $konfiguracjaMetody['zaznaczPowiadomienieEmail'],
				));
			}
		}
		
		return $widok;
	}
	
	private function pobierzListeLiderow($daneDataTeam)
	{
		$idsTeam = $this->pobierzIdTeamow($daneDataTeam);
		
		if($idsTeam != '' && !count($idsTeam) || $idsTeam[0] == '') return array();
			
		$listaTeamow = $this->_cms->dane()->Team()->szukaj(array('wiele_id' => $idsTeam));
		$liderLista = array();
		if(count($listaTeamow))
		{
			foreach($listaTeamow as $team)
			{
				$lider = $team->pobierzLideraTeamu();
				if($lider!=null)
					$liderLista[] = $lider;
			}
		}
		return $liderLista;
	}
	
}
