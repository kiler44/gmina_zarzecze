<?php
namespace Generic\Biblioteka\Pomocnik;
use Generic\Model\Zamowienie;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Cms;

class GetApiMap extends GetApi{
	
	private $listaZamowien = array();
	private $listaKlientow = array();
	private $listaProduktow = array();
	private $listaPracownikow = array();
	
	
	private $zamowienieCache = null;


	private $idKoordynatora = 42;
	private $idType = 1;
	private $numberCustomer = 1;
	
	private $pominZamowienia = array(
		'workDescription' => array(
				'wyrazenie' => '/MDU LEVERANSE/',
			)
	);
	private $statusMap = array(
		'SENT' => 'new',
		'CANCELLED' => 'done',
		'COMPLETE' => 'done',
		'INCOMPLETE' => 'not done',
	);
	
	private $_confMapujZamowienie = array(
		'hoursInterval' => 'timeSlot' ,
		'numberOrderGet' => 'workOrderId',
		'jobDescription' => 'workDescription' ,
		'city' => 'address|city',
		'postcode' => 'address|postalCode',
		'address' => 'address|street.houseNumberNumeric.houseNumberAlpha',
		'apartment' => 'address|flatOrApartment',
		'dateStart' => 'serviceDate',
		'totalTime' => 'orderedItems|totalTimeEstimate',
		//'numberPrivatCustomer' => 'func|pobierzIdKlienta'
	);
	
	/**
	 * Pobiera informacje o zamówieniu z listy zamówień do przydzielenia
	 * @param \Generic\Model\Zamowienie\Obiekt $zamowienie
	 * @return array / null
	 */
	public function pobierzZamowienieZListy(Zamowienie\Obiekt $zamowienie, Uzytkownik\Obiekt $pracownik = null)
	{
		return $this->szukajZamowieniaWLiscie($zamowienie, $pracownik);
	}
	
	/**
	 * Pobiera produkty wybrane przez Team z listy zamówień do przydzielenia
	 * @param \Generic\Model\Zamowienie\Obiekt $zamowienie
	 * @return type
	 */
	public function pobierzProduktyWybrane(Zamowienie\Obiekt $zamowienie, Uzytkownik\Obiekt $pracownik = null)
	{
		$zamowienie = $this->szukajZamowieniaWLiscie($zamowienie, $pracownik);
		
		if(isset($zamowienie['orderedItems']['itemSummary']))
			return $this->mapujProduktyWybrane($zamowienie['orderedItems']['itemSummary']);
		else
			return array();
	}
	
	public function pobierzProduktyWybraneZHistorii(Zamowienie\Obiekt $zamowienie)
	{
		$zamowienie = $this->szukajZamowieniaWHistorii($zamowienie);
		if(isset($zamowienie['orderedItems']['itemSummary']))
			return $this->mapujProduktyWybrane($zamowienie['orderedItems']['itemSummary']);
		else
			return array();
	}
	
	public function pobierzWorkStatusZamowienia(Zamowienie\Obiekt $zamowienie, \Generic\Model\Uzytkownik\Obiekt $uzytkownik = null)
	{
		$zamowienieGet = $this->szukajZamowieniaWLiscie($zamowienie, $uzytkownik);
		
		if($zamowienieGet != null)
			return $this->statusMap[$zamowienieGet['status']];

		return null;
	}
	
	public function pobierzStatusZamowienia(Zamowienie\Obiekt $zamowienie, \Generic\Model\Uzytkownik\Obiekt $uzytkownik = null)
	{
		$zamowienieGet = $this->szukajZamowieniaWLiscie($zamowienie, $uzytkownik);
		
		if($zamowienieGet != null)
			return $this->mapujStatus($zamowienieGet['status']);
		
		return null;
	}
	
	public function pobierzStatusZamowieniaZHistorii(Zamowienie\Obiekt $zamowienie)
	{
		$zamowienie = $this->szukajZamowieniaWHistorii($zamowienie);
		
		if($zamowienie != null)
			return $zamowienie['status'];

		return null;
	}
	
	public function pobierzKomentarzZamowienia(Zamowienie\Obiekt $zamowienie)
	{
		$zamowienieGet = $this->szukajZamowieniaWHistorii($zamowienie);

		if($zamowienieGet != null)
			return $zamowienieGet['actionTaken'];

		return null;
	}
	
	public function pobierzIdKlienta(Zamowienie\Obiekt $zamowienie)
	{
		return $this->pobierzIdKlientaGET($zamowienie->numberOrderGet);
	}
	
	
	/**
	 * Pobiera informacje o zamówieniu z listy zamówień do rozdzielenia
	 * 
	 * @param \Generic\Model\Zamowienie\Obiekt $zamowienie
	 * @param \Generic\Model\Uzytkownik\Obiekt $pracownik
	 * @return type
	 */
	private function szukajZamowieniaWLiscie(Zamowienie\Obiekt $zamowienie, Uzytkownik\Obiekt $pracownik = null)
	{
		if($this->zamowienieCache != null && $this->zamowienieCache['workOrderId'] == $zamowienie->numberOrderGet)
		{
			return $this->zamowienieCache;
		}
		if($pracownik != null)
			$listaZamowien = parent::pobierzListeZamowien($pracownik->kodGet);
		else
			$listaZamowien = parent::pobierzListeZamowien();
		
		if(is_array($listaZamowien) && count($listaZamowien) > 0)
		{
			foreach($listaZamowien as $zamowienieGet)
			{
				if($zamowienieGet['workOrderId'] == $zamowienie->numberOrderGet)
				{
					$this->zamowienieCache = $zamowienieGet;
					return $zamowienieGet;
				}
			}
		}
		return null;
	}
	
	private function szukajZamowieniaWHistorii(Zamowienie\Obiekt $zamowienie)
	{
		if($this->zamowienieCache != null && $this->zamowienieCache['workOrderId'] == $zamowienie->numberOrderGet)
		{
			return $this->zamowienieCache;
		}
		$listaZamowien = parent::pobierzZamowienie($zamowienie->numberOrderGet);
		foreach($listaZamowien as $zamowienieGet)
		{
			if($zamowienieGet['workOrderId'] == $zamowienie->numberOrderGet)
			{
				$this->zamowienieCache = $zamowienieGet;
				return $zamowienieGet;
			}
		}
		
		return null;
	}

	public function pobierzProduktyKlienta(Zamowienie\Obiekt $zamowienie) {
		
		parent::pobierzProduktyKlientaGet($this->pobierzIdKlienta($zamowienie));
	}
	
	public function pobierzHistorieZamowienia(Zamowienie\Obiekt $zamowienie) {
		return parent::pobierzZamowienie($zamowienie->numberOrderGet);
	}
	
	public function ustawIdKoordynatora($idKoordynatora)
	{
		$this->idKoordynatora = $idKoordynatora;
	}
	
	/**
	 * ustawia id Get z bazy Bkt do mapowania zamówień
	 * @param type $numberCustomer
	 */
	public function ustawNumberCustomer($numberCustomer)
	{
		$this->numberCustomer = $numberCustomer;
	}

	public function mapujStatus($status)
	{
		if($status == 'CANCELLED')
			return 'cancelled';
		elseif($status == 'INCOMPLETE')
			return 'closed';
		else
			return 'active';
	}
	
	public function mapujStatusWork($status)
	{
		return $this->statusMap[$status];
	}
	
	
	private function wykluczZamowienie(array $zamowienie)
	{
		foreach($this->pominZamowienia as $klucz => $sprawdz)
		{
			if(isset($zamowienie[$klucz]))
			{
				foreach($sprawdz as $metoda => $wartosc)
				{
					switch($metoda)
					{
						case 'wyrazenie' : $return = $this->sprawdzWyrazenie($wartosc, $zamowienie[$klucz]);
							break;
						case 'wartosc' : $return = $this->sprawdzWartosc($wartosc, $zamowienie[$klucz]);
							break;
					}
					if($return) return $return;
				}
			}
		}
		return false;
				  
	}
	
	private function sprawdzWyrazenie($wyrazenie, $fraza)
	{
		return preg_match($wyrazenie, $fraza);
	}
	
	private function sprawdzWartosc($wartosc, $fraza)
	{
		return $wartosc == $fraza;
	}


	public function mapujZamowieniaNaObiekt($zamowieniaPrzydzielone = false)
	{
		// status SENT,  CANCELLED, COMPLETE
		$listaZamowienImport = $this->pobierzListeZamowien();
		if($zamowieniaPrzydzielone)
		{
			$zamowieniaPrzydzielone = array();
			foreach($this->pobierzListePracownikow() as $pracownik)
			{
				$listaPrzydzielonych = $this->pobierzListeZamowien($pracownik['id']);
				if(count($listaPrzydzielonych))
					$listaZamowienImport = array_merge($listaZamowienImport , $listaPrzydzielonych);
			}
		}
		foreach($listaZamowienImport as $zamowienie)
		{
			//if($this->wykluczZamowienie($zamowienie))	continue;
			$obiekt = new Zamowienie\Obiekt();
			$obiekt->idProjektu = ID_PROJEKTU;
			$obiekt->idType = $this->idType;
		//	$obiekt->dateAdded = date();
			$obiekt->importFromGetApi = true;
			$obiekt->chargeType = 'by products';
			$obiekt->idCoordinator = $this->idKoordynatora;
			$obiekt->numberCustomer = $this->numberCustomer;
			$obiekt->status = $this->mapujStatus($zamowienie['status']);
			$obiekt->statusWork = $this->mapujStatusWork($zamowienie['status']);
			$obiekt->isReclamation = false;
			foreach($this->_confMapujZamowienie as $wlasnosc => $index)
			{
				$obiekt->$wlasnosc = $this->pobierzWartoscDlaObiektu($zamowienie, $index);
			}
			
			$this->listaZamowien[] = $obiekt;
			
			$this->mapujProdukt($obiekt->numberOrderGet, $zamowienie['orderedItems']['itemSummary']);
		}
		
		return $this->listaZamowien;
	}
	
	public function pobierzListeKlientow($listaZamowien)
	{
		foreach($listaZamowien as $zamowienie)
		{
			$zamowienieGet = $this->pobierzZamowienieT712($zamowienie->numberOrderGet);
			$this->listaKlientow[$zamowienie->numberOrderGet] = isset($zamowienieGet['customer']) ? $zamowienieGet['customer'] : null;
		}
		
		return $this->listaKlientow;
	}
	
	/**
	 * Pobiera liste produktów dla zmapowanych zamówień
	 * @before mapujZamowieniaNaObiekt
	 * @return type
	 */
	public function pobierzListeProduktow()
	{
		return $this->listaProduktow;
	}

	private function mapujProduktyWybrane(Array $produktyWybrane)
	{
		$return = array();
		$produktObiekt = new \Generic\Model\Produkt\Obiekt();
		$produktMapper = new \Generic\Model\Produkt\Mapper();
		$dzisiaj = new \DateTime();
		$i = 0;
		foreach($produktyWybrane as $produktGet)
		{
			$nazwa = $produktGet['name'];
			$ilosc = $produktGet['quantity'];
			$czas = $produktGet['timeEstimate'];
			$kod = generuj_kod($nazwa);
			$produkt = $produktMapper->pobierzPoCode($kod, 0, $dzisiaj->format('Y-m-d'));
			if($produkt instanceof \Generic\Model\Produkt\Obiekt)
			{
				$return[$i]['czas'] = $czas;
				$return[$i]['ilosc'] = $ilosc;
				$return[$i]['obiekt'] = $produkt;
			}
			else			
			{
				$return[$i]['czas'] = $czas;
				$return[$i]['ilosc'] = $ilosc;
				$return[$i]['obiekt'] = $this->dodajProduktWybranyDoBazy(array('nazwa' => $nazwa, 'ilosc' => $ilosc, 'czas' => $czas, 'kod' => $kod));
			}
			$i++;
		}

		return $return;
	}

	private function mapujProdukt($orderNumberGet, $listaProduktow)
	{
		$i = 0;
		foreach($listaProduktow as $produkt)
		{
			$maperProdukt = new \Generic\Model\Produkt\Mapper();
			$kodProduktu = generuj_kod($produkt['name']);
			
			$produktO = $maperProdukt->pobierzPoCode($kodProduktu, 1);
			// jeżeli zamówiony produkt istnieje w bazie produktów 
			if(!($produktO instanceof \Generic\Model\Produkt\Obiekt))
			{
				$produktO = $this->dodajProduktZaimportowanyDoBazy($produkt);
			}
			
			$this->listaProduktow[$orderNumberGet][$i]['obiekt'] = $produktO;
			$this->listaProduktow[$orderNumberGet][$i]['ilosc'] = $produkt['quantity'];
			$this->listaProduktow[$orderNumberGet][$i]['czas'] = $produkt['timeEstimate'];
			$i++;
		}
		return $this->listaProduktow;
	}
	
	public function mapujListePracownikow() {
		
		$listaPracownikowGet = parent::pobierzListePracownikow();
		$listaPracownikowBkt = $this->pracownicyBKT();
		
		$maperUzytkownicy = new Uzytkownik\Mapper();
		$tabPracownicy = array();
		foreach ($listaPracownikowGet as $pracownik)
		{
			if(($lider = $maperUzytkownicy->szukajPoKodGet($pracownik['id'])) instanceof Uzytkownik\Obiekt)
			{
				$this->listaPracownikow[$lider->id] = $lider;
			}
			else 
			{
				$danePracownikaWGet = explode(' ', trim($pracownik['name']));
				$imie = $danePracownikaWGet[0];
				$nazwisko = $danePracownikaWGet[count($danePracownikaWGet)-1];
				
				if(isset($listaPracownikowBkt[$imie][$nazwisko]))
				{
					$lider = $listaPracownikowBkt[$imie][$nazwisko];
					if($lider instanceof Uzytkownik\Obiekt)
					{
						if($lider->kodGet=='')
							$this->aktualizujKodPracownika($lider, $pracownik['id']);

						$this->listaPracownikow[$lider->id] = $lider;
					}
				}
			}
		}
		
		return $this->listaPracownikow;
	}

	private function pracownicyBKT()
	{
		$maperUzytkownicy = new Uzytkownik\Mapper();
		$listaBkt = array();
		foreach($maperUzytkownicy->pobierzWszystko() as $pracownik)
		{
			if(count($tab = explode(' ', trim($pracownik->imie)) ) > 1)
				$imie = $tab[0];
			else
				$imie = trim($pracownik->imie);
			
			$listaBkt[usun_polskie_znaki($imie)][usun_polskie_znaki(trim($pracownik->nazwisko))] = $pracownik;
		}
		return $listaBkt;
	}
	
	public function przydzielZamowieniaMap(Uzytkownik\Obiekt $pracownik, Array $listaZamowien) 
	{
		$this->mapujListePracownikow();
		
		if($this->sprawdzCzyPracownikIstniejeWGet($pracownik))
		{
			$listaZamowienGet = $this->pobierzOrdersNumberGet($listaZamowien);
			
			if(count($listaZamowienGet['ok']))
				parent::przydzielZamowienia($pracownik->kodGet, $listaZamowienGet['ok']);
			
			return $listaZamowienGet;
		}
		else
		{
			return 0;
		}
	}
	
	public function usunPrzydzielenie(Array $zamowienia)
	{
		/*
		$listaZamowien = array_keys(listaZObiektow($zamowienia, 'numberOrderGet', 'numberOrderGet'));
		if(count($listaZamowien))
		{
			parent::przydzielZamowienia('', $listaZamowien);
			$kod = $this->pobierzHttpCode();
			if($kod == 500)
			{
				$lista = $this->pobierzOrdersNumberGet($zamowienia, true);
				
				if(isset($lista['ok']) && count($lista['ok']) )
					parent::przydzielZamowienia('', $lista['ok']);
			}
		}
		 * 
		 */
		if(count($zamowienia))
		{
			
			$lista = $this->pobierzOrdersNumberGet($zamowienia, true);
				
			if(isset($lista['ok']) && count($lista['ok']) )
				parent::przydzielZamowienia('', $lista['ok']);
		}
	}
	
	
	public function pobierzOrdersNumberGet($listaZamowien, $szukajWZamowieniachPracownika = false)
	{
		$listaZamowienGet = listaZTablicy($this->pobierzListeZamowien(), 'workOrderId');
		if($szukajWZamowieniachPracownika)
		{
			foreach($this->pobierzListePracownikow() as $pracownik)
			{
				$zamowieniaPracownika = $this->pobierzListeZamowien($pracownik['id']);
				
				$listaDoMerge = listaZTablicy($zamowieniaPracownika, 'workOrderId');
				$listaZamowienGet = array_merge($listaZamowienGet, $listaDoMerge);
			}
		}
		$listaZamowienGet = listaZTablicy($listaZamowienGet, 'workOrderId');
		
		$returnListaZamowien['brak'] = array();
		$returnListaZamowien['ok'] = array();
		foreach($listaZamowien as $zamowienie)
		{
			(isset($listaZamowienGet[$zamowienie->numberOrderGet])) ? ($returnListaZamowien['ok'][] = $zamowienie->numberOrderGet) : ($returnListaZamowien['brak'][] = $zamowienie->numberOrderGet);
		}

		return $returnListaZamowien;
	}

	private function sprawdzCzyPracownikIstniejeWGet(Uzytkownik\Obiekt $pracownik)
	{
		return (isset($this->listaPracownikow[$pracownik->id])) ? true : false;
	}

	private function pobierzWartoscDlaObiektu($tablicaWartosci, $index)
	{
		$wartosc = '';
		if( count($tab = explode('|', $index)) > 1 )
		{
			if($tab[0] == 'func')
			{
				if(method_exists($this, $tab[1]))
				{
					$wartosc = $this->$tab[1]($tablicaWartosci);
				}
			}
			else
			{
				foreach ($tab as $i)
				{
					if(isset($tablicaWartosci[$i]))
					{
						$tablicaWartosci = $tablicaWartosci[$i];
					}
					else
					{
						$index = $i ;
					}
				}
				if(count($tabI = explode('.', $index) ) > 1)
				{
					foreach($tabI as $j) $wartosc .=' '.$tablicaWartosci[$j];
				}
				else 
				{
					$wartosc = $tablicaWartosci;
				}
			}
			
		}
		else	
			$wartosc = isset($tablicaWartosci[$index]) ? $tablicaWartosci[$index] : '';
		
		return $wartosc;
	}
	
	private function dodajProduktZaimportowanyDoBazy($produkt)
	{
		$produktObj = new \Generic\Model\Produkt\Obiekt;
		if(isset($produkt) && count($produkt) > 0 )
		{
			$mapperProdukty = new \Generic\Model\Produkt\Mapper();
			
			$produktObj->idProjektu = ID_PROJEKTU;
			$czas = $produkt['timeEstimate'];
			$produktObj->code =  generuj_kod($produkt['name']);
			$produktObj->name = $produkt['name'];
			$produktObj->import = true;
			$produktObj->czas = $czas;
			$produktObj->visibleInOrder = array($this->idType);
			$produktObj->measureUnit = 'szt';
			$produktObj->status = 'active';
					
			$produktObj->zapisz($mapperProdukty);
		}
		
		return $produktObj;
	}
	
	/**
	 * 
	 * @param array $produkt
	 * @return \Generic\Model\Produkt\Obiekt
	 */
	private function dodajProduktWybranyDoBazy($produkt)
	{
		$produktObj = new \Generic\Model\Produkt\Obiekt;
		if(isset($produkt) && count($produkt) > 0 )
		{
			$mapperProdukty = new \Generic\Model\Produkt\Mapper();
			$dataWaznosci = new \DateTime();
			$dataWaznosci->add(\DateInterval::createFromDateString('yesterday'));
			
			$cenaNetto = $this->liczCeneNettoProduktu($produkt['czas']);
			$produktObj->idProjektu = ID_PROJEKTU;
			$produktObj->code =  $produkt['kod'];
			$produktObj->name = $produkt['nazwa'];
			$produktObj->import = false;
			$produktObj->czas = $produkt['czas'];
			$produktObj->visibleInOrder = array($this->idType);
			$produktObj->dataWaznosciOd = $dataWaznosci;
			$produktObj->nettoPrice = $cenaNetto;
			$produktObj->vat = 25;
			$produktObj->bruttoPrice = $cenaNetto * 1.25;
			$produktObj->measureUnit = 'szt';
			$produktObj->status = 'active';
			$produktObj->kolejnosc = 1;
			$produktObj->mainProduct = true;
			$produktObj->multiplied = true;
			$produktObj->textDoSms = $produkt['nazwa'].' x ?';
			$produktObj->zapisz($mapperProdukty);
		}
		
		return $produktObj;
	}
	
	private function liczCeneNettoProduktu($czas)
	{
		return ceil($czas * Cms::inst()->config['bkt_cena_za_godzine']['ogolna']);
	}
	
	private function aktualizujKodPracownika($pracownik, $kod)
	{
		$maperUzytkownicy = new Uzytkownik\Mapper();
		$pracownik->kodGet = $kod;
		$pracownik->zapisz($maperUzytkownicy);
	}
	
}
