<?php
namespace Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\Kontener;
use Generic\Model\Faktura as FakturaModel;
use Generic\Model\FakturaPozycje;
use Generic\Model\Klient;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka;

/**
 * Description of Faktura
 *
 * @author Marcin Mucha
 */
class Faktura {

	private $dane = array();
	private $_konfiguracja;
	private $klient;
	private $obiektPowiazany;
	private $idTypowZamowienPrywatnych = array();
	
	public function __construct()
	{
		$kategoriaMapper = new \Generic\Model\Kategoria\Mapper();
		$idKategorii = $kategoriaMapper->pobierzDlaModulu('Faktura');
		
		$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
		$this->_konfiguracja = $mapperKonfiguracja->pobierzDlaModuluPelna('Faktura\\Admin', $idKategorii[0]->id);
		/*
		$this->_konfiguracja['grupa_zamowien_odbiorcy_prywatni'] = 'other_orders';
		$this->_konfiguracja['id_klient_get'] = 1;
		$this->_konfiguracja['vat'] = 25;
		$this->_konfiguracja['domyslny_typ_faktury'] = 'zwykla';
		$this->_konfiguracja['domyslna_ilosc_dni_na_platnosc'] = 14;
		$this->_konfiguracja['ilosc_dni_na_platnosc_projekt'] = 30;
		$this->_konfiguracja['ilosc_dni_na_platnosc_raport'] = 30;
		$this->_konfiguracja['ilosc_dni_na_platnosc_odbiorcy_prywatni'] = 14;
		$this->_konfiguracja['typ_produktu_raport'] = 'Installation';
		$this->_konfiguracja['typ_produktu_klienci_prywatni'] = 'Installation';
		$this->_konfiguracja['klient_prywatny_nazwa_faktury'] = '{KOD} {MIASTO}, {ADRES}';
		$this->_konfiguracja['raport_villa_nazwa_faktury'] = 'Villainstallasjon {DATA_OD} - {DATA_DO}';
		$this->_konfiguracja['raport_b2b_nazwa_faktury'] = 'Installasjon B2B {DATA_OD} - {DATA_DO}';
		$this->_konfiguracja['raport_digging_nazwa_faktury'] = 'Digging {DATA_OD} - {DATA_DO}';
		$this->_konfiguracja['raport_domyslna_nazwa_faktury'] = 'Raport id {ID}';
		 * 
		 */
	}
	
	/**
	 * 
	 * @param type $obiekt - obiekt do którego ma zostać przypisana faktura
	 * @return boolean
	 */
	public function ustawObiekt($obiekt)
	{
		if(is_object($obiekt))
		{
			$this->obiektPowiazany = $obiekt;
			$this->ustawIdObiektu($obiekt);
			$this->ustawTypObiektu($obiekt);
			//$this->ustawVat();
			$this->ustawNazwaFaktury();
			if($this->dane['typObiektu'] == 'Reports') { $this->ustawOpis(); }
			if($this->dane['typObiektu'] == 'Zamowienie' && in_array($this->obiektPowiazany->idType,  $this->pobierzIdTypowZamowienPrywatnych())){ $this->ustawOpis(); }
			$this->ustawOdbiorce();
			$this->ustawIdOsobaKontaktowa();
			//$this->ustawNumerFaktury();
			$this->ustawAdresFaktury();
			$this->ustawAutora();
			$this->ustawIloscDniNaPlatnosc();
			$this->ustawTypFaktury($this->_konfiguracja['domyslny_typ_faktury']);
		}
		else
		{
			trigger_error('Błąd. Podana wartość nie jest obiektem .', E_USER_WARNING);
			return false;
		}
	}
	

	public function ustawDane(Array $dane)
	{
		if(is_array($dane) && count($dane) > 0)
		{
			$this->dane = $dane;
			//$this->ustawVat();
			$this->ustawAutora();
			if(isset($dane['odbiorca']) && $dane['odbiorca'] > 0)
			{
				$klient = $this->ustawOdbiorce($dane['odbiorca']);
				$this->ustawMetodaWyslania($klient);
			}
			$this->ustawIloscDniNaPlatnosc();
			//$this->ustawNumerFaktury();
			$this->ustawMaDzieci();
		}
		else
		{
			trigger_error('Przekazano pustą tablicę z danymi .', E_USER_WARNING);
			return false;
		}
	}

	public function zapisz()
	{
		if(isset($this->dane['pozycjeFaktury']) && count($this->dane['pozycjeFaktury']) > 0)
		{
			$cms = Cms::inst();
			$blad = 0;
			$obiektFaktura = new FakturaModel\Obiekt();
			$mapperFaktura = $cms->dane()->Faktura();
			
			$cms->Baza()->transakcjaStart();
			
			// nie sprawdzamy bo faktury reczne nie mają tego pola
			//if(isset($this->dane['idObiektu']) && $this->dane['idObiektu'] > 0 )
			//{
				
				foreach($this->dane as $klucz => $wartosc)
				{
					if($klucz == 'pozycje_faktury')
						continue;
					
					$obiektFaktura->$klucz = $wartosc;
				}
				
				if($obiektFaktura->zapisz($mapperFaktura))
				{
					$mapperPozycjeFaktury = $cms->dane()->FakturaPozycje();
				
					foreach ($this->dane['pozycjeFaktury'] as $pozycjaFaktury)
					{
						$obiektPozycjeFaktury = new FakturaPozycje\Obiekt();
						$obiektPozycjeFaktury->idFaktury = $obiektFaktura->id;
						foreach($pozycjaFaktury as $klucz => $wartosc)
						{
							$obiektPozycjeFaktury->$klucz = $wartosc;
						}
						
						if(!$obiektPozycjeFaktury->zapisz($mapperPozycjeFaktury))
						{
							$blad = 1;
						}
						else
						{
							if($obiektPozycjeFaktury->varenr == "")
							{
								$obiektPozycjeFaktury->varenr = str_replace('{ID}', $obiektPozycjeFaktury->id , $this->_konfiguracja['varenr_szablon_pozycje_faktury']);
								$obiektPozycjeFaktury->zapisz($mapperPozycjeFaktury);
							}
						}
					}
				}
				else
				{
					$blad = 1;
					trigger_error('Błąd zapisu faktury .', E_USER_WARNING);
					return false;
				}
			//}
			
			if($blad)
			{
				$cms->Baza()->transakcjaCofnij(); return false;
			}
			else
			{
				$cms->Baza()->transakcjaPotwierdz(); return $obiektFaktura->id;
			}
				
		}
		else
		{
			trigger_error('Błąd. Nie wprowadzono pozycji faktury .', E_USER_WARNING);
			return false;
		}
		
	}
	
	private function ustawRodzajRabatu($val)
	{
		if(in_array($val, $this->_konfiguracja['rodzajeRabatu']))
		{
			$this->dane['rodzajRabatu'] = $val;
		}
		else
		{
			trigger_error('Błąd. Nie znany rodzaj rabatu .', E_USER_WARNING);
		}
		
	}
	
	private function ustawNazwaFaktury()
	{
		if(isset($this->dane['typObiektu']) )
		{
			if($this->dane['typObiektu'] == "Zamowienie")
			{
				// odbiorcy prywatni
				if(in_array($this->obiektPowiazany->idType,  $this->pobierzIdTypowZamowienPrywatnych()))
				{
					$this->dane['nazwaFaktury'] = str_replace(array('{KOD}', '{MIASTO}', '{ADRES}'), array($this->obiektPowiazany->postcode, $this->obiektPowiazany->city, $this->obiektPowiazany->address ), $this->_konfiguracja['klient_prywatny_nazwa_faktury']);
				}
				else // projekty
				{
					$this->dane['nazwaFaktury'] = $this->obiektPowiazany->orderName;
				}
			}// raporty
			elseif($this->dane['typObiektu'] == "Reports")
			{
				switch ($this->obiektPowiazany->kategoria)
				{
					case 'villa instalacje raport faktura' : 
						$nazwaFaktury = str_replace(
								  array('{DATA_OD}', '{DATA_DO}'), 
								  array(date('d.m', strtotime($this->obiektPowiazany->dataOd)), date('d.m', strtotime($this->obiektPowiazany->dataDo))), 
								  $this->_konfiguracja['raport_villa_nazwa_faktury']
								  );
								  break;
					case 'gravebefaring raport faktura' : 
						$nazwaFaktury = str_replace(
								  array('{DATA_OD}', '{DATA_DO}'), 
								  array(date('d.m', strtotime($this->obiektPowiazany->dataOd)), date('d.m', strtotime($this->obiektPowiazany->dataDo))), 
								  $this->_konfiguracja['raport_gravebefaring_nazwa_faktury']
								  );
								  break;
					case 'b2b befaring raport faktura' : 
						$nazwaFaktury = str_replace(
								  array('{DATA_OD}', '{DATA_DO}'), 
								  array(date('d.m', strtotime($this->obiektPowiazany->dataOd)), date('d.m', strtotime($this->obiektPowiazany->dataDo))), 
								  $this->_konfiguracja['raport_b2b_befaring_nazwa_faktury']
								  );
								  break;
					case 'b2b instalacje raport faktura' : 
						$nazwaFaktury = str_replace(
								  array('{DATA_OD}', '{DATA_DO}'), 
								  array(date('d.m', strtotime($this->obiektPowiazany->dataOd)), date('d.m', strtotime($this->obiektPowiazany->dataDo))), 
								  $this->_konfiguracja['raport_b2b_nazwa_faktury']
								  );
								  break;
					case 'digging report' : $nazwaFaktury = str_replace(
								  array('{DATA_OD}', '{DATA_DO}'), 
								  array(date('d.m', strtotime($this->obiektPowiazany->dataOd)), date('d.m', strtotime($this->obiektPowiazany->dataDo))), 
								  $this->_konfiguracja['raport_digging_nazwa_faktury']
								  );
								  break;
					default : $nazwaFaktury = str_replace(
								  array('{ID}'), 
								  array($this->obiektPowiazany->id), 
								  $this->_konfiguracja['raport_domyslna_nazwa_faktury']
								  );
				}
				$this->dane['nazwaFaktury'] = $nazwaFaktury;
			}
		}
		else
		{
			
		}
	}

	public function ustawIloscDniNaPlatnosc($iloscDniNaPlatnosc = null)
	{
		if($iloscDniNaPlatnosc > 0)
			$this->dane['iloscDniNaPlatnosc'] = $iloscDniNaPlatnosc;
		else
		{
			// ilosc dni dla raporty
			if(isset($this->dane['typObiektu']) && $this->dane['typObiektu'] == 'Reports') $this->dane['iloscDniNaPlatnosc'] = $this->_konfiguracja['ilosc_dni_na_platnosc_raport'];
			elseif(isset($this->dane['typObiektu']) && $this->dane['typObiektu'] == 'Zamowienie')
			{
				// ilosc dni dla odbiorcy prywatni
				if(in_array($this->obiektPowiazany->idType,  $this->pobierzIdTypowZamowienPrywatnych()))
					$this->dane['iloscDniNaPlatnosc'] = $this->_konfiguracja['ilosc_dni_na_platnosc_odbiorcy_prywatni'];
				else if(
						  $this->klient instanceof Klient\Obiekt && 
						  isset($this->_konfiguracja['ilosc_dni_na_platnosc_id_klienta'][$this->klient->id]) && 
						  $this->_konfiguracja['ilosc_dni_na_platnosc_id_klienta'][$this->klient->id] > 0)
				{
					$this->dane['iloscDniNaPlatnosc'] = $this->_konfiguracja['ilosc_dni_na_platnosc_id_klienta'][$this->klient->id];
				}
				else // ilosc dni dla projekty
					$this->dane['iloscDniNaPlatnosc'] = $this->_konfiguracja['ilosc_dni_na_platnosc_projekt'];
			}
			else
			{
				if($this->klient instanceof Klient\Obiekt)
				{
					
					if(isset($this->_konfiguracja['ilosc_dni_na_platnosc_id_klienta'][$this->klient->id]) && $this->_konfiguracja['ilosc_dni_na_platnosc_id_klienta'][$this->klient->id] > 0)
					{
						$this->dane['iloscDniNaPlatnosc'] = $this->_konfiguracja['ilosc_dni_na_platnosc_id_klienta'][$this->klient->id];
					}
					else if($this->klient->type == "private")
					{
						$this->dane['iloscDniNaPlatnosc'] = $this->_konfiguracja['ilosc_dni_na_platnosc_klient_prywatny'];
					}
					elseif($this->klient->type == "company")
					{
						$this->dane['iloscDniNaPlatnosc'] = $this->_konfiguracja['ilosc_dni_na_platnosc_firma'];
					}
					else
					{
						$this->dane['iloscDniNaPlatnosc'] = $this->_konfiguracja['domyslna_ilosc_dni_na_platnosc'];
					}
				}
				else
				{
					$this->dane['iloscDniNaPlatnosc'] = $this->_konfiguracja['domyslna_ilosc_dni_na_platnosc'];
				}
			}
		}
		
			
	}

	/**
	 * 
	 * @param \Generic\Model\Klient $klient
	 */
	protected function ustawMetodaWyslania(\Generic\Model\Klient\Obiekt $klient)
	{
		if($klient->email != '')
		{
			$this->dane['metodaWyslania'] = 'mail';
		}
		else
		{
			$this->dane['metodaWyslania'] = 'poczta';
		}
		
	}
	
	/**
	 * 
	 * @param type $typFaktury - zwykla, reczna, material
	 * @return boolean
	 */
	public function ustawTypFaktury($typFaktury)
	{
		$faktura = new FakturaModel\Definicja();
		if(in_array($typFaktury, $faktura->dopuszczalneWartosci['typFaktury']))
		{
			$this->dane['typFaktury'] = $typFaktury;
		}
		else
		{
			trigger_error('Błąd. Nieznany typ faktury.', E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * pobiera numer ostatnio dodanej faktury i na jego podstawie generuje numer o jeden większy
	 */
	protected function ustawNumerFaktury()
	{
		$faktura = Cms::inst()->dane()->Faktura()->pobierzOstaniaFaktura();
		
		if($faktura instanceof FakturaModel\Obiekt)
			$this->dane['numerFaktury'] = $faktura->numerFaktury + 1;
		else
			$this->dane['numerFaktury'] = $this->_konfiguracja['pierwszy_numer_faktury'];
	}

	/**
	 * 
	 * @param type $vat - jeśli nie ustawione wartość zostanie pobrana z konfiguracji
	 */
	public function ustawVat($vat = null)
	{
		if(is_null($vat))
			$this->dane['vat'] = $this->_konfiguracja['vat'];
		else
			$this->dane['vat'] = $vat;
	}
	
	/**
	 * 
	 * @param string $naglowek
	 */
	public function ustawNaglowek($naglowek)
	{
		$this->dane['naglowekFaktury'] = $naglowek;
	}
	
	/**
	 * 
	 * @param string $naglowek
	 */
	public function ustawOpis($opis = null)
	{
		if(isset($this->dane['typObiektu']) && ($this->dane['typObiektu'] == "Zamowienie" || $this->dane['typObiektu'] == "Reports") && $opis == null)
		{
			if(isset($this->obiektPowiazany->additionalData['opisDoFaktury']) && $this->obiektPowiazany->additionalData['opisDoFaktury'] != '')
				$opis = $this->obiektPowiazany->additionalData['opisDoFaktury'];
		}
		
		$this->dane['opis'] = $opis;
	}
	 
	/**
	 * 
	 * @param type $idOdbiorcy - jeśli nie podane dla zamówień prywatnych odbiorca zostaje pobrany z obiektu
	 * w przeciwnym razie odbiorca to GET
	 * @return boolean
	 */
	public function ustawOdbiorce($idOdbiorcy = null)
	{
		if(is_null($idOdbiorcy))
		{
			if(isset($this->dane['typObiektu']) && $this->dane['typObiektu'] == "Zamowienie")
			{
				// odbiorcy prywatni - dla grupy other orders
				if(in_array($this->obiektPowiazany->idType,  $this->pobierzIdTypowZamowienPrywatnych()))
				{
					$idOdbiorcy = $this->obiektPowiazany->numberPrivatCustomer;
				}
				else // odbiorca GET dla grupy get_project
				{
					//$idOdbiorcy = $this->_konfiguracja['id_klient_get'];
					if($this->obiektPowiazany->numberCustomer > 0)
					{
						$idOdbiorcy = $this->obiektPowiazany->numberCustomer;
					}
					else
					{
						trigger_error('Błąd. Nie udało się automatycznie ustawić odbiorcy faktury.', E_USER_WARNING);
						return false;
					}
				}
			}
			elseif(isset($this->dane['typObiektu']) && $this->dane['typObiektu'] == "Reports")
			{
				$idOdbiorcy = $this->_konfiguracja['id_klient_get'];
			}
			else
			{
				trigger_error('Błąd. Nie udało się automatycznie ustawić odbiorcy faktury.', E_USER_WARNING);
				return false;
			}
			
			$klient = Cms::inst()->dane()->Klient()->pobierzPoId($idOdbiorcy);
			if($klient instanceof \Generic\Model\Klient\Obiekt)
			{
				$this->dane['odbiorca'] = $idOdbiorcy;
				$this->klient = $klient;
			}
			else
			{
				trigger_error('Błąd. Klient dla którego chcesz wystawić fakture nie istnieje w bazie.', E_USER_WARNING);
				return false;
			}
		}
		else
		{  // odbiorca ustawiany ręcznie
			$klient = Cms::inst()->dane()->Klient()->pobierzPoId($idOdbiorcy);
			if($klient instanceof \Generic\Model\Klient\Obiekt)
			{
				$this->ustawMetodaWyslania($klient);
				$this->dane['odbiorca'] = $klient->id;
				$this->klient = $klient;
			}
			else
			{
				trigger_error('Błąd. Klient dla którego chcesz wystawić fakture nie istnieje w bazie.', E_USER_WARNING);
				return false;
			}
		}
		
		return $this->klient;
		 
	}
	
	private function ustawAdresFaktury()
	{
		if(isset($this->dane['odbiorca']) && $this->dane['odbiorca'] > 0)
		{
			$klient = Cms::inst()->dane()->Klient()->pobierzPoId($this->dane['odbiorca']);
			if($klient instanceof Klient\Obiekt)
			{
				if($this->_konfiguracja['tylko_adres_podstawowy_faktury'])
				{
					$this->dane['adres'] = $klient->address;
					$this->dane['postcode'] = $klient->postcode;
					$this->dane['city'] = $klient->city;
				}
				else
				{
					if($klient->korespondencjaPostcode != "" && $klient->korespondencjaAddress != "" && $klient->korespondencjaCity != "")
					{
						$this->dane['adres'] = $klient->korespondencjaAddress;
						$this->dane['postcode'] = $klient->korespondencjaPostcode;
						$this->dane['city'] = $klient->korespondencjaCity;
					}
					else
					{
						$this->dane['address'] = $klient->address;
						$this->dane['postcode'] = $klient->postcode;
						$this->dane['city'] = $klient->city;
					}
					
				}
			}
			
		}
		else
		{
			trigger_error('Błąd. Nie zostało wprowadzone id klienta.', E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * 
	 * @return array
	 */
	private function pobierzIdTypowZamowienPrywatnych()
	{
		if(count($this->idTypowZamowienPrywatnych) > 0){}
		else
		{
			/*
			$typyZamowienPrywatnych = Cms::inst()->dane()->ZamowienieTyp()->zwracaTablice('id')->pobierzPoGrupie($this->_konfiguracja['grupa_zamowien_odbiorcy_prywatni']);
			$this->idTypowZamowienPrywatnych = array_keys(listaZTablicy($typyZamowienPrywatnych, 'id'));
			 * 
			 */
			$this->idTypowZamowienPrywatnych = $this->_konfiguracja['id_typow_prywatnych'];
		}
		return $this->idTypowZamowienPrywatnych;
	}
	
	/**
	 * 
	 * @param type  - obiekt do którego ma zostać przypisana faktura
	 * @return boolean
	 */
	private function ustawIdObiektu($obiekt)
	{
		if(is_int($obiekt->id) && $obiekt->id > 0 )
		{
			$this->dane['idObiektu'] = $obiekt->id;
		}
		else
		{
			trigger_error('Błąd. Podano błędną wartość dla pola idObjektu .', E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * 
	 * @param object $obiekt - przekazujemy obiekt do rozpoznania jakiego typ jest obiekt
	 * @return string - zwraca typ obiektu
	 */
	private function ustawTypObiektu($obiekt)
	{
		$chunks = explode('\\', get_class($obiekt));
		$this->dane['typObiektu'] = $chunks[count($chunks)-2];
		
		return $this->dane['typObiektu'];
	}
	
	/**
	 * ustawia autora raportu na podstawie zalogowanego użytkownika
	 *
	 */
	private function ustawAutora()
	{
		$cms = Cms::inst();
		$zalogowanaOsoba = $cms->profil();
		$this->dane['autor'] = $zalogowanaOsoba->id;
	}
	
	
	public function ustawPozycjeFakturyOdbiorcaPrywatny($produktyZRabatem, $rodzajRabatu)
	{
		
		$produkty = new \Generic\Model\Produkt\Obiekt();
		$kryteria = array('confirmation_status' => array('not confirmed', 'confirmed'), 'import' => false, 'not_id_product' => 92 );
		$produktyDoFaktury = $produkty->pobierzProduktyZakupione($this->obiektPowiazany->id, $kryteria, 1);
		
		$i = 0;
		$kwotaDoZaplatyNetto = 0;
		$kwotaDoZaplatyBrutto = 0;
		$kwotaVatFaktura = 0;
		$tVat = null;
		$vatIdentycznyDlaWszystkichPozycji = true;
		
		foreach($produktyDoFaktury as $klucz => $produkt)
		{
			if($tVat != null && $tVat != $produkt['vat'])
				$vatIdentycznyDlaWszystkichPozycji = false;
			
			$tVat = $produkt['vat'];
			
			if($produkt['id_product'] > 0)
			{
				$varenr = str_replace('{ID}', $produkt['id_product'], $this->_konfiguracja['varenr_szablon_produkty']);
			}
			else
			{
				$varenr = str_replace('{ID}', $produkt['id_produkt_zakupiony'], $this->_konfiguracja['varenr_szablon_produkty_zakupione']);
			}
			
			$cenaNettoPozycja = $produkt['netto_price'] * $produkt['quantity'];
			
			if( ($rodzajRabatu != null && $rodzajRabatu != '' && !empty($rodzajRabatu) ) && $produktyZRabatem[$klucz]['rabat'] ) 
			{
				$this->ustawRodzajRabatu($rodzajRabatu);
				$this->dane['pozycje_faktury'][$i]['rabatRodzaj'] = $rodzajRabatu;
				$this->dane['pozycje_faktury'][$i]['rabatWartosc'] = $produktyZRabatem[$klucz]['rabat'];
				$this->dane['pozycje_faktury'][$i]['rabatKwota'] = $cenaNettoPozycja - $produktyZRabatem[$klucz]['kwota_po_rabacie'];
				$this->dane['pozycje_faktury'][$i]['rabatKwotaPrzedRabatem'] = $cenaNettoPozycja;
				
				$cenaNettoPozycja = $produktyZRabatem[$klucz]['kwota_po_rabacie'];
			}
			
			$vat = $this->liczKwotaVat(($produkt['netto_price'] * $produkt['quantity']), $produkt['vat']);
			$cenaBruttoPozycja = $this->liczKwotaBrutto($cenaNettoPozycja, $produkt['vat']);
			$this->dane['pozycje_faktury'][$i]['idObiektu'] = $klucz;
			$this->dane['pozycje_faktury'][$i]['typObiektu'] = 'ProduktyZakupione';
			$this->dane['pozycje_faktury'][$i]['kwotaNettoCalosc'] = $produkt['netto_price'];
			$this->dane['pozycje_faktury'][$i]['kwotaNetto'] = $cenaNettoPozycja;
			$this->dane['pozycje_faktury'][$i]['nazwaPozycji'] = $produkt['name'];
			$this->dane['pozycje_faktury'][$i]['typProduktu'] = $this->_konfiguracja['typ_produktu_klienci_prywatni'];
			$this->dane['pozycje_faktury'][$i]['ilosc'] = $produkt['quantity'];
			$this->dane['pozycje_faktury'][$i]['varenr'] = $varenr;
			$this->dane['pozycje_faktury'][$i]['vat'] = $produkt['vat'];
			$this->dane['pozycje_faktury'][$i]['kwotaBrutto'] = $cenaBruttoPozycja;
			$this->dane['pozycje_faktury'][$i]['kwotaVat'] = $vat;
			
			$kwotaDoZaplatyNetto += $cenaNettoPozycja;
			$kwotaDoZaplatyBrutto += $cenaBruttoPozycja;
			$kwotaVatFaktura += $vat;
			$i++;
		}
		
		$this->dane['pozycjeFaktury'] = $this->dane['pozycje_faktury'];
		$this->dane['kwotaDoZaplatyNetto'] = $kwotaDoZaplatyNetto;
		$this->dane['pelnaKwotaDoZaplatyNetto'] = $kwotaDoZaplatyNetto;
		$this->dane['kwotaInstallation'] = $kwotaDoZaplatyNetto;
		
		if($vatIdentycznyDlaWszystkichPozycji)
			$this->ustawVat($tVat);
		
		$this->dane['kwotaDoZaplatyBrutto'] = $kwotaDoZaplatyBrutto;
	   $this->dane['kwotaVat'] = $kwotaVatFaktura;
		
		/*
		if(isset($this->dane['vat']))
		{
			$this->dane['kwotaDoZaplatyBrutto'] = $this->liczKwotaBrutto($kwotaDoZaplatyNetto , $this->dane['vat']);
			$this->dane['kwotaVat'] = $this->liczKwotaVat($kwotaDoZaplatyNetto, $this->dane['vat']);
		}
		else 
		{
			trigger_error('Błąd. Nie ustawiono wartosci procentowej podatku vat .', E_USER_WARNING);
		}
		 * 
		 */
	}
	
	public function ustawPozycjeFakturyRaport($rabat, $rodzajRabatu)
	{
		$cenaNettoPozycja = $this->obiektPowiazany->nettoPrice;
		$cenaNettoPozycjaTmp = $this->obiektPowiazany->nettoPrice;
		if( ($rodzajRabatu != null && $rodzajRabatu != '' && !empty($rodzajRabatu) ) && $rabat[0]['rabat'] ) 
		{
			$this->ustawRodzajRabatu($rodzajRabatu);
			$this->dane['pozycje_faktury'][0]['rabatRodzaj'] = $rodzajRabatu;
			$this->dane['pozycje_faktury'][0]['rabatWartosc'] = $rabat[0]['rabat'];
			$this->dane['pozycje_faktury'][0]['rabatKwota'] = $cenaNettoPozycja - $rabat[0]['kwota_po_rabacie'];
			$this->dane['pozycje_faktury'][0]['rabatKwotaPrzedRabatem'] = $cenaNettoPozycja;

			$cenaNettoPozycja = $rabat[0]['kwota_po_rabacie'];
		}
			
		$this->dane['pozycje_faktury'][0]['idObiektu'] = $this->obiektPowiazany->id;
		$this->dane['pozycje_faktury'][0]['typObiektu'] = 'Reports';
		$this->dane['pozycje_faktury'][0]['kwotaNettoCalosc'] = $cenaNettoPozycjaTmp;
		$this->dane['pozycje_faktury'][0]['kwotaNetto'] = $cenaNettoPozycja;
		$this->dane['pozycje_faktury'][0]['nazwaPozycji'] = $this->dane['nazwaFaktury'];
		$this->dane['pozycje_faktury'][0]['typProduktu'] = $this->_konfiguracja['typ_produktu_raport'];
		$this->dane['pozycje_faktury'][0]['varenr'] = str_replace('{ID}', $this->obiektPowiazany->id, $this->_konfiguracja['varenr_szablon_raport']);
		
		$this->dane['pozycjeFaktury'] = $this->dane['pozycje_faktury'];
		$this->dane['kwotaDoZaplatyNetto'] = $cenaNettoPozycja;
		$this->dane['pelnaKwotaDoZaplatyNetto'] = $cenaNettoPozycja;
		$this->dane['kwotaInstallation'] = $cenaNettoPozycja;
		
		$this->ustawVat();
		$this->dane['kwotaDoZaplatyBrutto'] = $this->liczKwotaBrutto($cenaNettoPozycja , $this->dane['vat']);
		$this->dane['kwotaVat'] = $this->liczKwotaVat($cenaNettoPozycja, $this->dane['vat']);
		
		
	}
	
	/**
	 * ustawiam pozycje faktury dla projektów
	 * 
	 * @param array $produktyZakupione[idProduktZakupiony]{
	 *		[nazwa]
    *		[cena]
    *		[kategoria]
    *		[procent_wykonania]
	 * }
	 */
	public function dodajPozycjeFakturyProdukty(Array $produktyZakupione, $rodzajRabatu = null)
	{

		if(isset($this->dane['pozycje_faktury']) && count($this->dane['pozycje_faktury']) > 0)
		{
			trigger_error('Błąd. Pozycje faktury zostały już ustawione .', E_USER_WARNING);
			return false;
		}
		
		$mapperPozycjeFaktury = Cms::inst()->dane()->FakturaPozycje();
		
		$kwotaFaktury = 0;
		$kwotaGraving = 0;
		$kwotaInstallation = 0;
		$pelnaKwotaDoZaplatyNetto = 0;
		$kwotaDoZaplatyBrutto = 0;
		$vatIdentycznyDlaWszystkichPozycji = true;
		$tVat = null;
		$i = 0;
		
		foreach($produktyZakupione as $klucz => $wartosc)
		{
			/*
			$kryteria['idObiektu'] = $klucz;
			$kryteria['typObiektu'] = 'ProduktyZakupione';
			$kryteria['kreditnota'] = false;

			$znalezionePozycje = $mapperPozycjeFaktury->szukaj($kryteria);
			
			$procentKwoty = 0;
			$iloscPozycja = 0;
			
			if(count($znalezionePozycje) > 0)
			{
				foreach ($znalezionePozycje as $pozycja)
				{
					$kryteriaKreditnota['fakturaGlowna'] = false;
					$kryteriaKreditnota['fakturaRodzaj'] = 'kreditnota';
					$kryteriaKreditnota['idRodzica'] = $pozycja->idFaktury;
					
					$jestKreditnota = 0;
					$nowyProcent = 0;
					$kreditnotaDoFaktury = Cms::inst()->dane()->Faktura()->szukaj($kryteriaKreditnota);
					
					$iloscKreditnota = 0;
					if(count($kreditnotaDoFaktury) > 0)
					{
						$roznicaMiedzyFakturaAKreditnota = 0;
						foreach($kreditnotaDoFaktury as $kreditnota)
						{
							$pozycjaKreditnoty = $mapperPozycjeFaktury->pobierzPoIdProduktuIdFaktury($kreditnota->id, $pozycja->idObiektu);
							
							if($pozycjaKreditnoty instanceof FakturaPozycje\Obiekt)
							{
								if($roznicaMiedzyFakturaAKreditnota > 0)
								{
									$roznicaMiedzyFakturaAKreditnota -= ($pozycja->kwotaNetto - abs($pozycjaKreditnoty->kwotaNetto));
								}
								else
								{
									$roznicaMiedzyFakturaAKreditnota = $pozycja->kwotaNetto - abs($pozycjaKreditnoty->kwotaNetto);
								}
								
								$iloscKreditnota+=$pozycjaKreditnoty->ilosc;
								
								$jestKreditnota = 1;
							}
						}
						
						if($roznicaMiedzyFakturaAKreditnota > 0)
							$nowyProcent = ($roznicaMiedzyFakturaAKreditnota/$wartosc['cena']) * 100;
						
					}
					
					if($jestKreditnota)
					{
						//dump($nowyProcent);
						$procentKwoty += $nowyProcent;
					}
					else
					{
						//dump($pozycja->procentKwoty);
						$procentKwoty += $pozycja->procentKwoty;
					}
					
					if($wartosc['ilosc'] > 1)
					{
						if($iloscKreditnota>0)
							$iloscPozycja = $iloscPozycja-$iloscKreditnota;
							
						$iloscPozycja += $pozycja->ilosc;
					}
				}
			}
			 * 
			 */
			
			if($tVat != null && $tVat != $wartosc['vat'])
				$vatIdentycznyDlaWszystkichPozycji = false;
				
			
			$tVat = $wartosc['vat'];
			
			if($wartosc['ilosc'] > 1)
			{
				//$procentKwotyPozycja = (( $wartosc['procent_wykonania'] / $wartosc['ilosc'] ) * 100) - $procentKwoty;
				$ilosc = $wartosc['procent_wykonania'] - $wartosc['procent_wykonania_wczesniej'];
				$procentKwotyPozycja = $ilosc / $wartosc['ilosc'];
				$cenaNettoPozycja = $ilosc * $wartosc['cena'];
				$kwotaNettoCalosc = $wartosc['cena'];
				$kwotaNettoCaloscSuma = $wartosc['cena'] * $wartosc['ilosc'];
			}
			else
			{
				$procentKwotyPozycja = $wartosc['procent_wykonania'] - $wartosc['procent_wykonania_wczesniej'];
				$cenaNettoPozycja = round($wartosc['cena'] * ($procentKwotyPozycja) / 100);
				$ilosc = number_format(($procentKwotyPozycja / 100), 2);
				$kwotaNettoCalosc = $wartosc['cena'];
				$kwotaNettoCaloscSuma = $wartosc['cena'];
			}
			
			if( ($rodzajRabatu != null && $rodzajRabatu != '' && !empty($rodzajRabatu) ) && $wartosc['rabat'] ) 
			{
				$this->ustawRodzajRabatu($rodzajRabatu);
				
				$this->dane['pozycje_faktury'][$i]['rabatRodzaj'] = $rodzajRabatu;
				$this->dane['pozycje_faktury'][$i]['rabatWartosc'] = $wartosc['rabat'];
				$this->dane['pozycje_faktury'][$i]['rabatKwota'] = $cenaNettoPozycja - $wartosc['kwota_po_rabacie'];
				$this->dane['pozycje_faktury'][$i]['rabatKwotaPrzedRabatem'] = $cenaNettoPozycja;
				
				$cenaNettoPozycja = $wartosc['kwota_po_rabacie'];
			}
			
			if($wartosc['kategoria'] == 'Graving')
				$kwotaGraving += $cenaNettoPozycja;
			if($wartosc['kategoria'] == 'Installation')
				$kwotaInstallation += $cenaNettoPozycja;
			
			$kwotaBruttoPozycja = $this->liczKwotaBrutto($cenaNettoPozycja, $wartosc['vat']);
			$kwotaDoZaplatyBrutto+=$kwotaBruttoPozycja;
			
			$this->dane['pozycje_faktury'][$i]['idObiektu'] = $klucz;
			$this->dane['pozycje_faktury'][$i]['typObiektu'] = 'ProduktyZakupione';
			$this->dane['pozycje_faktury'][$i]['ilosc'] = $ilosc;
			$this->dane['pozycje_faktury'][$i]['procentKwoty'] = $procentKwotyPozycja;
			$this->dane['pozycje_faktury'][$i]['kwotaNettoCalosc'] = $kwotaNettoCalosc;
			$this->dane['pozycje_faktury'][$i]['kwotaNetto'] = $cenaNettoPozycja;
			$this->dane['pozycje_faktury'][$i]['typProduktu'] = $wartosc['kategoria'];
			$this->dane['pozycje_faktury'][$i]['nazwaPozycji'] = $wartosc['nazwa'];
			$this->dane['pozycje_faktury'][$i]['vat'] = $wartosc['vat'];
			$this->dane['pozycje_faktury'][$i]['kwotaVat'] = ($kwotaBruttoPozycja - $cenaNettoPozycja);
			$this->dane['pozycje_faktury'][$i]['kwotaBrutto'] = $kwotaBruttoPozycja;
			$this->dane['pozycje_faktury'][$i]['varenr'] = str_replace('{ID}', $klucz, $this->_konfiguracja['varenr_szablon_produkty_zakupione']);
			
			$i++;
			
			$kwotaFaktury += $cenaNettoPozycja;
			$pelnaKwotaDoZaplatyNetto += $kwotaNettoCaloscSuma;
		}
		
		$this->dane['kwotaGraving'] = $kwotaGraving;
		$this->dane['kwotaInstallation'] = $kwotaInstallation;
		$this->dane['pozycjeFaktury'] = $this->dane['pozycje_faktury'];
		$this->dane['kwotaDoZaplatyNetto'] = $kwotaFaktury;
		$this->dane['pelnaKwotaDoZaplatyNetto'] = $pelnaKwotaDoZaplatyNetto;
		
		if($vatIdentycznyDlaWszystkichPozycji)
			$this->ustawVat($tVat);
		
		$this->dane['kwotaDoZaplatyBrutto'] = $kwotaDoZaplatyBrutto;
		$this->dane['kwotaVat'] = $kwotaDoZaplatyBrutto - $kwotaFaktury;
		
		/*
		if(isset($this->dane['vat']))
		{
			$this->dane['kwotaDoZaplatyBrutto'] = $this->liczKwotaBrutto($kwotaFaktury, $this->dane['vat']);
			$this->dane['kwotaVat'] = $this->liczKwotaVat($kwotaFaktury, $this->dane['vat']);
		}
		else 
		{
			trigger_error('Błąd. Nie ustawiono wartosci procentowej podatku vat .', E_USER_WARNING);
		}
		 * 
		 */
		//dump($this->dane['pozycje_faktury']); die;
	}
	
	private function ustawMaDzieci()
	{
		if(isset($this->dane['idRodzica']) && $this->dane['idRodzica'] > 0 )
		{
			$mapperFaktura = Cms::inst()->dane()->Faktura();
			$fakturaGlowna = $mapperFaktura->pobierzPoId($this->dane['idRodzica']);
			$fakturaGlowna->maDzieci = true;
			$fakturaGlowna->zapisz($mapperFaktura);
		}
	}
	
	/**
	 * 
	 * @param array $produktyZakupione
	 * @return boolean
	 */
	public function ustawNiestandardoweProduktyFaktury(Array $produktyZakupione, $rodzajRabatu = null, $fakturaDzielona)
	{

		if(isset($this->dane['pozycje_faktury']) && count($this->dane['pozycje_faktury']) > 0)
		{
			trigger_error('Błąd. Pozycje faktury zostały już ustawione .', E_USER_WARNING);
			return false;
		}
		
		$mapperPozycjeFaktury = Cms::inst()->dane()->FakturaPozycje();
		
		$kwotaFaktury = 0;
		$kwotaGraving = 0;
		$kwotaInstallation = 0;
		$pelnaKwotaDoZaplatyNetto = 0;
		$kwotaBruttoFaktura = 0;
		$vatIdentycznyDlaWszystkichPozycji = true;
		$tVat = null;
		$i = 0;
		
		foreach($produktyZakupione as $klucz => $wartosc)
		{
			if($tVat != null && $tVat != $wartosc['vat'])
				$vatIdentycznyDlaWszystkichPozycji = false;
			
			$tVat = $wartosc['vat'];
			
			$idObiektu = null;
			$typObiektu = '';
			$vareNr = '';
			$procentKwoty = 0;
			$iloscWystawiona = 0;
			$kryteria = array();
			// jeśli cyferka to produkt jest z tabeli produkty
			if(is_int($klucz) && $klucz > 0)
			{
				$vareNr = str_replace('{ID}', $klucz, $this->_konfiguracja['varenr_szablon_produkty']);
				$idObiektu = $klucz;
				$typObiektu = 'Produkty';
			}
			// dla faktur cząstkowych
			if(isset($this->dane['idRodzica']) && $this->dane['idRodzica'] > 0 )
			{
				// jeśli cyferka to produkt jest z tabeli produkty
				if(is_int($klucz) && $klucz > 0)
				{
					$kryteria['idObiektu'] = $klucz;
					$kryteria['typObiektu'] = 'Produkty';
				}
				// jeśli string to produkt jest niestandardowy i zapisany tylko w tabeli pozycje_faktury
				elseif(is_string($klucz) && strlen($klucz) > 0)
				{
					$kryteria['dokladnaNazwaPozycji'] = $klucz;
				}
				
				$mapperFaktura = Cms::inst()->dane()->Faktura();
				$fakturyDzieci = $mapperFaktura->szukaj(array('idRodzica' => $this->dane['idRodzica']));
				// faktury cząstkowe były wystawione juz wcześniej
				if(count($fakturyDzieci) > 0)
				{
					$idFakturDzieci = array_keys(listaZObiektow($fakturyDzieci, 'id'));
					$kryteria['idFaktur'] = $idFakturDzieci;
					
					$kryteria['kreditnota'] = false;
					$kryteria['bezIdFaktur'] = array($this->dane['idRodzica']);
					//dump($kryteria);
					$znalezionePozycje = $mapperPozycjeFaktury->szukaj($kryteria);
					//dump($znalezionePozycje);
					if(count($znalezionePozycje) > 0)
					{
						foreach ($znalezionePozycje as $pozycja)
						{
							$vareNr = $pozycja->varenr;
							$iloscWystawiona += $pozycja->ilosc;
							$procentKwoty += $pozycja->procentKwoty;
						}
					}
				}
				else
				{
					// pobieramy varnr z rodzica
					if(is_string($klucz) && strlen($klucz) > 0)
					{
						$kryteria['idFaktury'] = $this->dane['idRodzica'];
						$pozycjaRodzica = $mapperPozycjeFaktury->szukaj($kryteria);
						$vareNr = $pozycjaRodzica[0]->varenr;
					}
					
				}
				// faktura ilościowa
				if($wartosc['ilosc'] > 1)
				{
					$iloscWystawionaPozycja = $wartosc['procent'] - $iloscWystawiona;
					if($wartosc['procent'] == $wartosc['ilosc'])
						$procentKwotyPozycja = 100 - $procentKwoty;
					else
						$procentKwotyPozycja = ($wartosc['procent'] / ($wartosc['ilosc']))*100;
				}
				// faktura procentowa
				else
				{
					$procentKwotyPozycja = $wartosc['procent'] - $procentKwoty;
				}
			}
			// dla faktury głównej
			else
			{
				$procentKwotyPozycja = 100;
				$iloscWystawionaPozycja = $wartosc['ilosc'];
			}
			
			
			if($wartosc['ilosc'] > 1)
			{
				/*
				if($wartosc['kategoria'] == 'Graving')
					$kwotaGraving += ($wartosc['cena'] * $iloscWystawionaPozycja);
				if($wartosc['kategoria'] == 'Installation')
					$kwotaInstallation += ($wartosc['cena'] * $iloscWystawionaPozycja);
				 * 
				 */
				
				$ilosc = $iloscWystawionaPozycja;
			}
			else
			{
				/*
				if($wartosc['kategoria'] == 'Graving')
					$kwotaGraving += ($wartosc['cena'] * ($procentKwotyPozycja) / 100);
				if($wartosc['kategoria'] == 'Installation')
					$kwotaInstallation += ($wartosc['cena'] * ($procentKwotyPozycja) / 100);
				 * 
				 */
				
				$ilosc = number_format(($wartosc['ilosc'] * ($procentKwotyPozycja) / 100),2);
			}
			
			if( ($rodzajRabatu != null && $rodzajRabatu != '' && !empty($rodzajRabatu)) && $wartosc['rabat'] && !$fakturaDzielona )
			{
				$this->ustawRodzajRabatu($rodzajRabatu);
				
				$cenaNettoPozycja = ($wartosc['cena']*$ilosc);
				$kwotaRabatu = ($cenaNettoPozycja - $wartosc['kwota_po_rabacie']);
				
				$this->dane['pozycje_faktury'][$i]['rabatRodzaj'] = $rodzajRabatu;
				$this->dane['pozycje_faktury'][$i]['rabatWartosc'] = $wartosc['rabat'];
				$this->dane['pozycje_faktury'][$i]['rabatKwota'] = $kwotaRabatu;
				$this->dane['pozycje_faktury'][$i]['rabatKwotaPrzedRabatem'] = $cenaNettoPozycja;
				
				
				$cenaNettoPozycja = $wartosc['kwota_po_rabacie'];
			}
			else
			{
				$cenaNettoPozycja = ($wartosc['cena']*$ilosc);
			}
			
			if($wartosc['kategoria'] == 'Graving')
				$kwotaGraving += $cenaNettoPozycja;
			if($wartosc['kategoria'] == 'Installation')
				$kwotaInstallation += $cenaNettoPozycja;
			
			$kwotaBruttoPozycja = $this->liczKwotaBrutto($cenaNettoPozycja, $wartosc['vat']);
			$kwotaBruttoFaktura += $kwotaBruttoPozycja;
			
			$this->dane['pozycje_faktury'][$i]['idObiektu'] = $idObiektu;
			$this->dane['pozycje_faktury'][$i]['typObiektu'] = $typObiektu;
			$this->dane['pozycje_faktury'][$i]['procentKwoty'] = $procentKwotyPozycja;
			$this->dane['pozycje_faktury'][$i]['kwotaNettoCalosc'] = $wartosc['cena'];
			$this->dane['pozycje_faktury'][$i]['kwotaVat'] = $this->liczKwotaVat($cenaNettoPozycja, $wartosc['vat']);
			$this->dane['pozycje_faktury'][$i]['ilosc'] = $ilosc;
			$this->dane['pozycje_faktury'][$i]['kwotaNetto'] = $cenaNettoPozycja;
			$this->dane['pozycje_faktury'][$i]['typProduktu'] = $wartosc['kategoria'];
			$this->dane['pozycje_faktury'][$i]['nazwaPozycji'] = $wartosc['nazwa'];
			$this->dane['pozycje_faktury'][$i]['vat'] = $wartosc['vat'];
			$this->dane['pozycje_faktury'][$i]['kwotaBrutto'] = $kwotaBruttoPozycja;
			$this->dane['pozycje_faktury'][$i]['varenr'] = $vareNr;
			
			$i++;
			
			$kwotaFaktury += $cenaNettoPozycja;
			$pelnaKwotaDoZaplatyNetto += $wartosc['cena'];
		}
		//dump($this->dane['pozycje_faktury']); die;
		$this->dane['kwotaGraving'] = $kwotaGraving;
		$this->dane['kwotaInstallation'] = $kwotaInstallation;
		$this->dane['pozycjeFaktury'] = $this->dane['pozycje_faktury'];
		$this->dane['kwotaDoZaplatyNetto'] = $kwotaFaktury;
		$this->dane['pelnaKwotaDoZaplatyNetto'] = $pelnaKwotaDoZaplatyNetto;
		
		$this->dane['kwotaDoZaplatyBrutto'] = $kwotaBruttoFaktura;
		$this->dane['kwotaVat'] = $kwotaBruttoFaktura - $kwotaFaktury;
		
		if($vatIdentycznyDlaWszystkichPozycji)
			$this->ustawVat($tVat);
		
		/*	
		if(isset($this->dane['vat']))
		{
			$this->dane['kwotaDoZaplatyBrutto'] = $this->liczKwotaBrutto($kwotaFaktury, $this->dane['vat']);
			$this->dane['kwotaVat'] = $this->liczKwotaVat($kwotaFaktury, $this->dane['vat']);
		}
		else 
		{
			trigger_error('Błąd. Nie ustawiono wartosci procentowej podatku vat .', E_USER_WARNING);
		}
		 * 
		 */
	}
	
	public function ustawIdOsobaKontaktowa($idOsobaKontaktowa = null)
	{
		if($idOsobaKontaktowa != null)
			$this->dane['idOsobaKontaktowa'] = $idOsobaKontaktowa;
		else
		{
			if(isset($this->dane['typObiektu']) && $this->dane['typObiektu'] == "Reports" && $this->dane['odbiorca'] == $this->_konfiguracja['id_klient_get'])
			{
				if(isset($this->_konfiguracja['kategorie_raport_osoba_kontaktowa'][$this->obiektPowiazany->kategoria]) 
						 && $this->_konfiguracja['kategorie_raport_osoba_kontaktowa'][$this->obiektPowiazany->kategoria] > 0 )
				{
					$this->dane['idOsobaKontaktowa'] = $this->_konfiguracja['kategorie_raport_osoba_kontaktowa'][$this->obiektPowiazany->kategoria];
				}
			}
		}
	}
	
	private function liczKwotaVat($kwotaNetto, $vat)
	{
		return ($kwotaNetto * ($vat) / 100);
	}
	
	private function liczKwotaBrutto($kwotaNetto, $vat)
	{
		return round(($kwotaNetto + ($kwotaNetto * ($vat) / 100))*2)/2;
	}
	
}
