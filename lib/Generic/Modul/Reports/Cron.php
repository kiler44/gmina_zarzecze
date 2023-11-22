<?php
namespace Generic\Modul\Reports;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka;


/**
 * Moduł odpowiedzialny za zdarzenia cykliczne dotyczące raportow.
 *
 * @author Łukasz Wrucha
 * @package moduly
 */

class Cron extends Modul\Cron
{

	/**
	 * @var \Generic\Konfiguracja\Modul\Reports\Cron
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Reports\Cron
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajPobierzMaciezOdleglosci',
		'wykonajPobierzMaciezOdleglosciDzienPoprzedni',
	);
	
	protected $zdarzenia = array(
		
	);

	protected $bledy_zapisu = 0;

	public function wykonajPobierzMaciezOdleglosci()
	{
		$dataDanych = $this->dataDanych;
		
		$zamowieniatMapper = $this->dane()->Zamowienie();
		
		$dataDzis = date('Y-m-d');
		
		$limitDzienny = $this->k->k['googleDistanceMartix_API__day_limit'];
		
		$cms = Cms::inst();
		
		$plik_daty = new Biblioteka\Plik($cms->katalog('public_temp').$this->k->k['zapiszDzien.plik_ostatniej_pobieranej_daty'], true);
		
		$dane_z_pliku = $plik_daty->pobierzZawartosc();
		
		if ($dane_z_pliku == '')
		{
			$data = $dataDanych->format('Y-m-d');
			$dataPobrano = $dataDzis;
			$iloscDzisPobranych = 0;
			$plik_daty->ustawZawartosc($dataDzis.'|'.$data.'|0');
		}
		else
		{
			$dane = explode('|', $dane_z_pliku);
			
			$data = $dane[1];
			$dataPobrano = $dane[0];
			$iloscDzisPobranych = $dane[2];
		}
		
		$ostatnieZamowienie = $zamowieniatMapper->zwracaTablice('id', 'data_zakonczenia')->pobierzZamowieniaTeamow(array(
			'id_type' => $this->k->k['zapiszDzien.idTypowZamowien'],
			'status' => $this->k->k['zapiszDzien.zamowieniaStatusy'],
			'status_work' => $this->k->k['zapiszDzien.zamowieniaWorkStatusy'],
			'data_zakonczenia_niepusta' => true,
		), new Biblioteka\Pager(1,1), new \Generic\Model\Zamowienie\Sorter('data_zakonczenia', 'ASC'));
		
		// Deaktywacja tego Crona jeśli przejedzie wszystkie Zamowienia
		if ($data <= $ostatnieZamowienie[0]['data_zakonczenia'])
		{
			$cronMapper = $cms->dane()->ZadanieCykliczne();
			$cron = $cronMapper->szukaj(array(
				'akcja' => 'wykonajPobierzMaciezOdleglosci',
				'kod_modulu' => 'Reports',
				'aktywne' => true,
			));
			if ($cron[0] instanceof \Generic\Model\ZadanieCykliczne\Obiekt)
			{
				$cron[0]->aktywne = false;
				$cron[0]->zapisz($cronMapper);
				return;
			}
		}
		
		$zamowienia = $zamowieniatMapper->zwracaTablice('id', 'id_team')->pobierzZamowieniaTeamow(array(
			'id_type' => $this->k->k['zapiszDzien.idTypowZamowien'],
			'data_od' => $data.' 00:00:00',
			'data_do' => $data.' 23:59:59',
			'status' => $this->k->k['zapiszDzien.zamowieniaStatusy'],
			'status_work' => $this->k->k['zapiszDzien.zamowieniaWorkStatusy'],
		));
		
		$iloscZamowienDnia = count($zamowienia);
		$iloscTeamow = count(listaZTablicy($zamowienia, 'id_team'));
		
		$doSciagniecia = $iloscZamowienDnia + $iloscTeamow;
		
		if ($dataPobrano == $dataDzis)
		{
			// Przekroczę limit przy pobieraniu więc odkladam na kiedyś :)
			if (($doSciagniecia + $iloscDzisPobranych) >= $limitDzienny)
			{
				return;
			}  ///////////////////////////
			
			$wynik = $this->pobierzOdleglosci($data);
			if ($wynik == -1)
			{
				$this->wyslijMailaZBledem($data);
			}
			else
			{
				$iloscDzisPobranych += $wynik;
			}
			$dataO = new \DateTime($data, new \DateTimeZone('Europe/oslo'));
			$dataO->modify('-1 day');
			$data = $dataO->format('Y-m-d');
			$dataPobrano = $dataDzis;
		}
		else
		{
			$dataO = new \DateTime($data, new \DateTimeZone('Europe/Oslo'));
			$dataO->modify('-1 day');
			$data = $dataO->format('Y-m-d');
			$dataPobrano = $dataDzis;
			
			$wynik = $this->pobierzOdleglosci($data);
			
			if ($wynik == -1)
			{
				$iloscDzisPobranych = 0;
				$this->wyslijMailaZBledem($data);
			}
			else
			{
				$iloscDzisPobranych = $wynik;
			}
		}
		
		$plik_daty->ustawZawartosc($dataPobrano.'|'.$data.'|'.$iloscDzisPobranych);
		die;
	}
	
	
	
	public function wykonajPobierzMaciezOdleglosciDzienPoprzedni()
	{
		$dataO = $this->dataDanych;
		$dataO->modify('-1 day');
		if ($this->pobierzOdleglosci($dataO->format('Y-m-d')) == -1)
		{
			
		}
	}
	
	private function pobierzOdleglosci($data)
	{
		$cms = Cms::inst();
		$daneMapper = $cms->dane()->RaportyExcelDane();
		
		$dataOd = $data.' 00:00:00';
		$dataDo = $data.' 23:59:59';
		
		$pracownicyDnia = listaZTablicy($daneMapper->zwracaTablice()->pobierzPracownikowDniaZakonczoneOrdery($dataOd, $dataDo), 'id_user');
		
		$teamyDnia = listaZTablicy($pracownicyDnia, 'id_team', 'id_team');
		
		$teamMapper = $cms->dane()->Team();

		// Sobota, Niedziela, dni wolne nie było teamów
		if (count($teamyDnia) == 0 || count($pracownicyDnia) == 0)
		{
			return 0;
		}
		
		$teamy = listaZTablicy($teamMapper->zwracaTablice(array('id', 'baza_teamu'))->szukaj(array('wiele_id' => $teamyDnia)), 'id');
		$bazy = $cms->config['bkt_bazy']['bkt_bazy'];
		
		$zamowieniatMapper = $this->dane()->Zamowienie();
		$zamowieniaSorter = new \Generic\Model\Zamowienie\Sorter('id_team_data_zakonczenia', 'ASC');
		
		$zamowienia = $zamowieniatMapper->zwracaTablice('id', 'number_order_get', 'data_zakonczenia', 'id_team', 'address', 'postcode', 'city')->pobierzZamowieniaTeamow(array(
			'id_team' => $teamyDnia,
			'id_type' => $this->k->k['zapiszDzien.idTypowZamowien'],
			'data_od' => $data,
			'data_do' => $data,
			'status' => $this->k->k['zapiszDzien.zamowieniaStatusy'],
			'status_work' => $this->k->k['zapiszDzien.zamowieniaWorkStatusy'],
		), null, $zamowieniaSorter);
		
		$cms->Baza()->transakcjaStart();
		$raportyExcelDaneMapper = $this->dane()->RaportyExcelDane();
		$excelDane = listaZTablicy($raportyExcelDaneMapper->zwracaTablice()->szukaj(array(
			'data_od' => $data,
			'data_do' => $data,
			'id_team' => $teamyDnia,
		)), 'id_order');
		
		$departureDate = new \DateTime('now', new \DateTimeZone('Europe/Oslo'));
		
		$departureDate->modify('next '.date('l', strtotime($data)));
		
		$departureDateStr = $departureDate->format('Y-m-d'); 
		
		$i = 0;
		$team = '';
		$bledy_distance_matrix = 0;
		$ilosc_zamowien = count($zamowienia);
		$ilosc_pobranych = 0;
		
		foreach ($zamowienia as $zamowienie)
		{
			if (! isset($excelDane[$zamowienie['id']]))
			{
				$lokalizacjaBazy = $bazy[$teamy[$zamowienie['id_team']]['baza_teamu']];
				
				if ($team != $zamowienie['id_team']) // Kolejny team
				{
					if ($i != 0)
					{
						$adresPoczatkowy = substr($zamowienia[$i-1]['address'], 0, -6).', '.$zamowienia[$i-1]['postcode'].' '.$zamowienia[$i-1]['city'].', Norge';
						$adresDocelowy = $bazy[$teamy[$zamowienia[$i-1]['id_team']]['baza_teamu']];
						
						$godzina = substr($zamowienia[$i-1]['data_zakonczenia'], -8);
						$departureTime = strtotime($departureDateStr.' '.$godzina);
						
						$wynik = $this->zwrocWynik(array(
							'pelny' => $adresPoczatkowy,
							'bezpieczny' => $zamowienia[$i-1]['postcode'].' '.trim($zamowienia[$i-1]['city']).', Norge'), array(
							'pelny' => $adresDocelowy,
							'bezpieczny' => $adresDocelowy), $departureTime
						);
						
						if ($wynik['route']['status'] == 'OK')
						{
							$this->zapiszWierszDanych($wynik, $zamowienia[$i-1], $adresPoczatkowy, $adresDocelowy, $departureDate->format('l'), $godzina);
							++ $ilosc_pobranych;
						}
						else
						{
							user_error('Błąd pobrania odległości, status: '.$wynik['route']['status'].', Adres p: '.$adresPoczatkowy.', adres k: '.$adresDocelowy, E_USER_NOTICE);
							$bledy_distance_matrix++;
						}
					}
					
					$adresPoczatkowy = $lokalizacjaBazy;
					$adresDocelowy = substr($zamowienie['address'], 0, -6).', '.$zamowienie['postcode'].' '.$zamowienie['city'].', Norge';
					
					$godzina = $this->k->k['zapiszDzien.godzina_startu_pracy'];
					$departureTime = strtotime($departureDateStr.' '.$godzina);
					
					$wynik = $this->zwrocWynik(array(
						'pelny' => $adresPoczatkowy,
						'bezpieczny' => $adresPoczatkowy), array(
						'pelny' => $adresDocelowy,
						'bezpieczny' => $zamowienie['postcode'].' '.trim($zamowienie['city']).', Norge'), $departureTime
					);
				}
				else
				{
					$adresPoczatkowy = substr($zamowienia[$i-1]['address'], 0, -6).', '.$zamowienia[$i-1]['postcode'].' '.$zamowienia[$i-1]['city'].', Norge';
					$adresDocelowy = substr($zamowienie['address'], 0, -6).', '.$zamowienie['postcode'].' '.$zamowienie['city'].', Norge';
					
					$godzina = substr($zamowienia[$i-1]['data_zakonczenia'], -8);
					$departureTime = strtotime($departureDateStr.' '.$godzina);
					
					$wynik = $this->zwrocWynik(array(
						'pelny' => $adresPoczatkowy,
						'bezpieczny' => $zamowienia[$i-1]['postcode'].' '.trim($zamowienia[$i-1]['city']).', Norge'), array(
						'pelny' => $adresDocelowy,
						'bezpieczny' => $zamowienie['postcode'].' '.trim($zamowienie['city']).', Norge'), $departureTime
					);
				}
				
				$team = $zamowienie['id_team'];
				if ($wynik['route']['status'] == 'OK')
				{
					$this->zapiszWierszDanych($wynik, $zamowienie, $adresPoczatkowy, $adresDocelowy, $departureDate->format('l'), $godzina);
					++ $ilosc_pobranych;
				}
				else
				{
					user_error('Błąd pobrania odległości, status: '.$wynik['route']['status'].', Adres p: '.$adresPoczatkowy.', adres k: '.$adresDocelowy, E_USER_NOTICE);
					$bledy_distance_matrix++;
				}
				
				if ($i == ($ilosc_zamowien-1)) // Ostatnie zamowienie dnia dla ostatniego teamu
				{
					$adresPoczatkowy = substr($zamowienie['address'], 0, -6).', '.$zamowienie['postcode'].' '.$zamowienie['city'].', Norge';
					$adresDocelowy = $lokalizacjaBazy;

					$godzina = substr($zamowienie['data_zakonczenia'], -8);
					$departureTime = strtotime($departureDateStr.' '.$godzina);

					$wynik = $this->zwrocWynik(array(
						'pelny' => $adresPoczatkowy,
						'bezpieczny' => $zamowienie['postcode'].' '.trim($zamowienie['city']).', Norge'), array(
						'pelny' => $adresDocelowy,
						'bezpieczny' => $adresDocelowy), $departureTime
					);
					if ($wynik['route']['status'] == 'OK')
					{
						$this->zapiszWierszDanych($wynik, $zamowienie, $adresPoczatkowy, $adresDocelowy, $departureDate->format('l'), $godzina);
						++ $ilosc_pobranych;
					}
					else
					{
						user_error('Błąd pobrania odległości, status: '.$wynik['route']['status'].', Adres p: '.$adresPoczatkowy.', adres k: '.$adresDocelowy, E_USER_NOTICE);
						$bledy_distance_matrix++;
					}
				}
			}
			
			$i++;
		}
		
		if ($this->bledy_zapisu == 0 && $bledy_distance_matrix == 0)
		{
			$cms->Baza()->transakcjaPotwierdz();
			return $ilosc_pobranych;
		}
		else
		{
			$cms->Baza()->transakcjaCofnij();
			$dane['status'] = 'error';
			$dane['error_text'] = $this->j->t['zapiszDzien.blad_zapisu_danych_raportu'].' ';
			user_error('Problem with getting data for the day: '.$data.', Błędy zapisu: '.$this->bledy_zapisu.', Błedy pobrania odległości: '.$bledy_distance_matrix, E_USER_ERROR);
		}
		return -1;
	}
	
	private function distanceMatrix($origins, $destinations, $parameters = array())
	{
		$pojedynczyAdres = true;
		if (is_array($origins))
		{
			$originsString = implode('|', $origins);
			$pojedynczyAdres = false;
		}
		else
		{
			$originsString = $origins;
		}
		if (is_array($destinations))
		{
			$destinationsString = implode('|', $destinations);
			$pojedynczyAdres = false;
		}
		else
		{
			$destinationsString = $destinations;
		}
		
		$parametersString = '';
		foreach ($parameters as $key => $val)
		{
			$parametersString .= '&'.$key.'='.urlencode($val);
		}
		
		$URL = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.urlencode($originsString).'&destinations='.urlencode($destinationsString).'&key='.$this->k->k['googleDistanceMartix_API_key'].$parametersString;
		//user_error(var_export($parameters,true), E_USER_NOTICE);
		//user_error($URL, E_USER_NOTICE);

		$data = json_decode(file_get_contents($URL));
		
		$return = array();
		$return['url'] = $URL;
		if (isset($data->rows))
		{
			//dump($data);
			$i = 0;
			foreach ($data->rows as $rowNo => $row)
			{
				if (! $pojedynczyAdres)
				{
					foreach ($row->elements as $elemNo => $element)
					{
						// TODO: Dorobić obsługę statusów
						$return['routes'][$rowNo][$elemNo] = array(
							'distance_text' => $row->elements[$elemNo]->distance->text,
							'distance_value' => $row->elements[$elemNo]->distance->value,
							'duration_text' => $row->elements[$elemNo]->duration->text,
							'duration_value' => $row->elements[$elemNo]->duration->value,
						);
					}
				}
				else
				{
					if ($row->elements[0]->status == 'OK')
					{
						$return['route'] = array(
							'distance_text' => $row->elements[0]->distance->text,
							'distance_value' => $row->elements[0]->distance->value,
							'duration_text' => $row->elements[0]->duration->text,
							'duration_value' => $row->elements[0]->duration->value,
							'duration_in_traffic_text' => $row->elements[0]->duration_in_traffic->text,
							'duration_in_traffic_value' => $row->elements[0]->duration_in_traffic->value,
							'status' => $row->elements[0]->status,
						);
					}
					else
					{
						if ($data->origin_addresses[0] == '')
						{
							$powod = 'Origin address not found';
						}
						else 
						{
							$return['origin'] = 'OK';
						}
						if ($data->destination_addresses[0] == '')
						{
							$powod = ', destination assress not found too.';
						}
						else
						{
							$return['destination'] = 'OK';
							$powod .= '.';
						}
						
						$return['route']['reason'] = $powod;
						$return['route']['status'] = $row->elements[0]->status;
					}
				}
				$i++;
			}
		}
		//dump($return);
		return $return;
	}
	
	private function zapiszWierszDanych($wynik, $zamowienie, $adresPoczatkowy, $adresDocelowy, $day, $hour)
	{
		$raportDaneMapper = Cms::inst()->dane()->RaportyExcelDane();
		$raportDane = new \Generic\Model\RaportyExcelDane\Obiekt();
		$raportDane->idProjektu = ID_PROJEKTU;
		$raportDane->idOrder = $zamowienie['id'];
		$raportDane->idTeam = $zamowienie['id_team'];
		$raportDane->data = $zamowienie['data_zakonczenia'];
		$raportDane->fromAddress = $adresPoczatkowy;
		$raportDane->toAddress = $adresDocelowy;
		$raportDane->kilometry = ($wynik['route']['distance_value'] / 1000);
		if (isset($wynik['route']['duration_in_traffic_value']))
		{
			$raportDane->minutyJazdy = $wynik['route']['duration_value'] / 60;
			$raportDane->minutyJazdyTraffik = $wynik['route']['duration_in_traffic_value'] / 60;
		}
		else
		{
			$raportDane->minutyJazdy = $wynik['route']['duration_value'] / 60;
		}
		$raportDane->dayOfSimulation = $day;
		$raportDane->hourOfSimulation = $hour;
		
		if (! $raportDane->zapisz($raportDaneMapper))
		{
			$this->bledy_zapisu++;
		}
	}
	
	private function zwrocWynik(Array $adresyOd, Array $adresyDo, $departureTime)
	{
		
		$wynik = $this->distanceMatrix($adresyOd['pelny'], $adresyDo['pelny'], array(
			'traffic_model' => $this->k->k['zapiszDzien.rodzaj_estymacji_trasy'],
			'departure_time' => $departureTime,
		));

		if (!isset($wynik['route']) || $wynik['route']['status'] != 'OK')
		{
			$wynik = $this->distanceMatrix($adresyOd['bezpieczny'], $adresyDo['bezpieczny'], array(
				'traffic_model' => $this->k->k['zapiszDzien.rodzaj_estymacji_trasy'],
				'departure_time' => $departureTime,
			));
		}
		
		if (!isset($wynik['route']) || $wynik['route']['status'] != 'OK')
		{
			$plik_error = new Biblioteka\Plik(Cms::inst()->katalog('public_temp').'distanceMatrix_error.txt', TRUE);
			$plik_error->ustawZawartosc(print_r($wynik, true), true);
		}
		return $wynik;
	}
	
	private function wyslijMailaZBledem($data)
	{
		$mail = new Biblioteka\Poczta();
		$mail->wyslijEmail('marcinmuch@gmail.com', 'Błąd pobrania danych z Google Distance Matrix dla dnia: '.$data, 'Jak powyżej - sprawdzić co poszło nie tak...');
	}
}