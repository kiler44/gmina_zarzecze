<?php
namespace Generic\Modul\Notes;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\WierszKonfiguracji;
use Generic\Biblioteka\Notatka;


/**
 * Moduł odpowiedzialny za zdarzenia cykliczne dotyczące zamówień.
 *
 * @author Marcin Mucha
 * @package moduly
 */

class Cron extends Modul\Cron
{

	/**
	 * @var \Generic\Konfiguracja\Modul\Notes\Cron
	 */
	protected $k;

	protected $uprawnienia = array(
		'wykonajWyslijPrzypomnienieDodajNotatke',
	);


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Notes\Cron
	 */
	protected $j;

	protected $zdarzenia = array(
		
	);

	/**
	 * wysyła przypomnienie o konieczności dodania notatki do zamówienia
	 * 1. szukamy liderów projektów po idProjectLiderGet
	 * 2. sprawdzamy czy w dniu bierzącym została dodana notatka
	 * 3. sprawdzamy czy w dniu bierzącym jakaś ekipa była zalogowana do zadania
	 * 4. jeśli 2 nie została dodana notatka i 3 ekipa była zalogowana to wyślij przypomnienie
	 */
	public function wykonajWyslijPrzypomnienieDodajNotatke()
	{
		$cms = Cms::inst();
		$zamowieniaMapper = $cms->dane()->Zamowienie();
		
		$kryteria = array(
			'status' => $this->k->k['status_zamowien'],
			'work_status' => $this->k->k['work_status_zamowien'],
			'id_type' => $this->k->k['typy_zamowien'],
		);
		
		$listaZamowien = $zamowieniaMapper->szukaj($kryteria);
		
		if ( count($listaZamowien) > 0)
		{
			$listaPrzypomnienDoWyslania = array();
			
			foreach($listaZamowien as $zamowienie)
			{
				$kryteriaNotatek = array(
					'author' => $zamowienie->idProjectLeaderBkt,
					'data_dodania' => date('Y-m-d'),
					'object' => "Zamowienie",
					'idObject' => $zamowienie->id,
				);
				$notatki = new Notatka($zamowienie);
				$notatki->ustawDodatkoweKryteriaSzukania($kryteriaNotatek);
				$listaNotatek = $notatki->pobierzNotatki();
				
				if(count($listaNotatek) > 0)
				{
					continue;
				}
				else
				{
					if($this->k->k['uwzglednij_wpisy_timelisty'])
					{
						$timelistMapper = $cms->dane()->Timelist();
						$timelistKryteria = array(
							'id_zamowienia' => $zamowienie->id,
							'data_start_rowna_dzien' => date('Y-m-d'),
						);
						$wpisyIstnieja = $timelistMapper->szukaj($timelistKryteria);

						if(count($wpisyIstnieja) > 0)
						{
							$listaPrzypomnienDoWyslania[$zamowienie->idProjectLeaderBkt][] = $zamowienie;
						}
					}
					else
					{
						$listaPrzypomnienDoWyslania[$zamowienie->idProjectLeaderBkt][] = $zamowienie;
					}
					
				}
			}

			$this->wyslijPrzypomnienie($listaPrzypomnienDoWyslania);
			
		}
		
	}
	
	private function wyslijPrzypomnienie($listaPrzypomnienDoWyslania)
	{
		$sms = new \Generic\Biblioteka\SmsNorwegia();
		$userMapper = Cms::inst()->dane()->Uzytkownik();
		
		foreach($listaPrzypomnienDoWyslania as $idLiderBkt => $projekty)
		{
			$liderBkt = $userMapper->pobierzPoId($idLiderBkt);
			foreach($projekty as $projekt)
			{
				$system = new \Generic\Model\Projekt\Obiekt();
				
				foreach ($system->jezykiKody as $jezyk)
				{
					$this->ladujTlumaczenia($jezyk);
					$trescWiadomosciWylogowanie[$jezyk] = str_replace(array('{PROJEKT_NAZWA}', '{BKT_ID}'), array($projekt->orderName, $projekt->id), $this->j->t['przypomnienie_brak_notatki']);
				}
				$wiadomosc = $trescWiadomosciWylogowanie[$liderBkt->jezyk];
				$sms->wyslijSms($liderBkt, 'system', $wiadomosc, 'przypomnienie_dodaj_notatke_projekt', $projekt);
			}
			
		}
	}
	
	
}