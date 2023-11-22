<?php
namespace Generic\Model\ZamowienieRaport;
use Generic\Biblioteka\ObiektDanych;

/**
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idParent 
 * @property int $idTeam 
 * @property string $idType 
 * @property int $numberOrderGet 
 * @property int $numberOrderBkt 
 * @property int $numberCustomer 
 * @property int $numberPrivatCustomer 
 * @property string $numberProjectGet 
 * @property int $numberContactId 
 * @property string $chargeType 
 * @property string $dateAdded
 * @property string $hoursInterval
 * @property float $totalTime
 * @property string $dateStart 
 * @property string $dateStop 
 * @property string $status 
 * @property string $statusWork 
 * @property string $address 
 * @property string $city 
 * @property string $postcode 
 * @property float $locationLat 
 * @property float $locationLng 
 * @property float $budget
 * @property string $nodeVillaCode
 * @property array $attributes
 * @property string $jobDescription
 * @property string $orderName
 * @property bool $isReclamation
 * @property int $idCoordinator
 * @property int $idProjectLeaderGetContact
 * @property int $idProjectLeaderBkt
 * @property int $idPricedBy
 * @property string $numberProjectInkjops
 * @property string $reference
 * @property bool $highPriority
 * @property int $position
 * @property bool $sprawdzony
 * @property bool $wyslanoDoRaportu
 * @property int $idNotatkiDoRaportu
 * @property string $dataZakonczenia
 * @property int idUserZamknijZamowienie
 * @property string $kategoria
 * @property bool $notCharge
 * @property bool $blokadaEdycji
 * @property bool $blokadaPoprawiania
 * @property bool $wyslanyDoFakturowania
 * @property bool $zafakturowano
 * @property string $apartment
 * @property string $additionalData
 * @property string $idPdf
 * @property int $idUserPrzydzielApartamenty
 * @property int $drugaTuraApartament
 * @property int $idUserOtworzZamowienie
 */
class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\Zamowienie\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\Zamowienie\Obiekt
	 */
	protected $j;
	
	public function __isset($name)
	{
		return in_array($name, $this->_pola);
	}

	/**
	 * 
	 * @return \Generic\Model\ZamowienieTyp\Obiekt
	 */
	public function pobierzTypZamowienia()
	{
		if ( ! isset($this->_cache['zamowienieTyp']))
		{
			$mapper = $this->dane()->ZamowienieTyp();
			$this->_cache['zamowienieTyp'] = ($this->idType > 0) ? $mapper->pobierzPoId($this->idType) : null;
		}
		return $this->_cache['zamowienieTyp'];
	}
	
	public function pobierzAdres()
	{
		return trim($this->postcode).' '.trim($this->city).', '.trim($this->address);
	}

	/**
	 * 
	 * @return \Generic\Model\Klient\Obiekt
	 */
	public function pobierzCustomer()
	{
		if ( ! isset($this->_cache['customer']))
		{
			$mapper = $this->dane()->Klient();
			$this->_cache['customer'] = ($this->numberCustomer > 0) ? $mapper->pobierzPoId($this->numberCustomer) : null;
		}
		return $this->_cache['customer'];
	}
	
	/**
	 * 
	 * @return \Generic\Model\Klient\Obiekt
	 */
	public function pobierzPrivatCustomer()
	{
		if ( ! isset($this->_cache['privateCustomer']))
		{
			$mapper = $this->dane()->Klient();
			$this->_cache['privateCustomer'] = ($this->numberPrivatCustomer > 0) ? $mapper->pobierzPoId($this->numberPrivatCustomer) : null;
		}
		return $this->_cache['privateCustomer'];
	}
	
	
	/**
	 * 
	 * @return \Generic\Model\Klient\Obiekt
	 */
	public function pobierzProjectLeaderGet()
	{
		if ( ! isset($this->_cache['projectLeaderGet']))
		{
			$mapper = $this->dane()->Klient();
			$this->_cache['projectLeaderGet'] = ($this->idProjectLeaderGetContact > 0) ? $mapper->pobierzPoId($this->idProjectLeaderGetContact) : null;
		}
		return $this->_cache['projectLeaderGet'];
	}
	
	public function pobierzidPricedByTyp($typ)
	{
		if ( ! isset($this->_cache['idPricedBy']))
		{
			if($typ == "Klient")
			{
				$mapper = $this->dane()->Klient();
				$this->_cache['idPricedBy'] = ($this->idPricedBy > 0) ? $mapper->pobierzPoId($this->idPricedBy) : null;
			}
			else
			{
				$mapper = $this->dane()->Uzytkownik();
				$this->_cache['idPricedBy'] = ($this->idPricedBy > 0) ? $mapper->pobierzPoId($this->idPricedBy) : null;
			}
			
		}
		return $this->_cache['idPricedBy'];
	}
	
	public function pobierzProjectLeaderBkt()
	{
		if ( ! isset($this->_cache['projectLeaderBkt']))
		{
			$mapper = $this->dane()->Uzytkownik();
			$this->_cache['projectLeaderBkt'] = ($this->idProjectLeaderBkt > 0) ? $mapper->pobierzPoId($this->idProjectLeaderBkt) : null;
		}
		return $this->_cache['projectLeaderBkt'];
	}
	
	public function pobierzContact()
	{
		if ( ! isset($this->_cache['contact']))
		{
			$mapper = $this->dane()->Klient();
			$this->_cache['contact'] = ($this->numberContactId > 0) ? $mapper->pobierzPoId($this->numberContactId) : null;
		}
		return $this->_cache['privateCustomer'];
	}
	
	/**
	 * 
	 * @return \Generic\Model\Zamowienie\Obiekt
	 */
	public function pobierzParent()
	{
		if ( ! isset($this->_cache['parent']))
		{
			$mapper = $this->dane()->Zamowienie();
			$this->_cache['parent'] = ($this->idParent > 0) ? $mapper->pobierzPoId($this->idParent) : null;
		}
		return $this->_cache['parent'];
	}
	
	public function pobierzNotes()
	{
		if ( ! isset($this->_cache['notes']))
		{
			$mapper = $this->dane()->Notes();
			$sorter = new \Generic\Model\Notes\Sorter('data_added', 'DESC');
			$notes = $mapper->szukaj(array('idObject' => $this->id, 'object' => 'Zamowienie', 'status' => 'active'), null, $sorter);
			$this->_cache['notes'] = (!empty($notes)) ? $notes : null;
		}
		return $this->_cache['notes'];
	}
	
	public function pobierzSmsWersje()
	{
		if ( ! isset($this->_cache['sms_wersje']))
		{
			$mapperZamowienia = $this->dane()->Zamowienie();
			
			$listaIdZamowien = array_filter(listaZTablicy($mapperZamowienia->zwracaTablice('id')->szukaj(array('number_order_get' => $this->numberOrderGet, 'id_type' => $this->idType)), null, 'id'));
			if (count($listaIdZamowien))
			{
				$mapperSms = $this->dane()->Sms();
				$this->_cache['sms_wersje'] = $mapperSms->szukaj(array('wiele_idObject' => $listaIdZamowien, 'object' => 'Zamowienie', 'status' => 'active'));
			}
			else
			{
				$this->_cache['sms_wersje'] = array();
			}
		}
		return $this->_cache['sms_wersje'];
	}
	
	public function pobierzNotesWersje()
	{
		if ( ! isset($this->_cache['notes_wersje']))
		{
			$mapperZamowienia = $this->dane()->Zamowienie();
			
			if($this->numberOrderGet == '' || empty($this->numberOrderGet))
			{
				$this->_cache['notes_wersje'] = array();
			}
			else
			{
				$listaZamowienWersje = $mapperZamowienia->szukaj(array('number_order_get' => $this->numberOrderGet, 'id_type' => $this->idType));
			
				$listaIdZamowien = array();

				foreach($listaZamowienWersje as $zamowienie)
				{
					$listaIdZamowien[] = $zamowienie->id;
				}
				$mapperNotes = $this->dane()->Notes();
				$this->_cache['notes_wersje'] = $mapperNotes->zwracaTablice()->szukaj(array('wiele_idObject' => $listaIdZamowien, 'object' => 'Zamowienie', 'status' => 'active'));
			}
		}
		return $this->_cache['notes_wersje'];
	}
	
	public function pobierzServices()
	{
		if ( ! isset($this->_cache['services']))
		{
			$mapper = $this->dane()->ProduktyZakupione();
			$services = $mapper->zwracaTablice()->szukaj(array('id_order' => $this->id));
			$this->_cache['services'] = (count($services) > 0) ? $services : array();
		}
		return $this->_cache['services'];
	}
	
	public function pobierzAttachements()
	{
		if ( ! isset($this->_cache['attachements']))
		{
			$mapper = $this->dane()->Zalacznik();
			$attachements = $mapper->pobierzDlaObjektu('Orders', $this->id);
			$this->_cache['attachements'] = (count($attachements) > 0) ? $attachements : null;
		}
		return $this->_cache['attachements'];
	}
	
	/**
	 * 
	 * @return \Generic\Model\Uzytkownik\Obiekt
	 */
	public function pobierzKoordynator()
	{
		if ( ! isset($this->_cache['koordynator']))
		{
			$mapper = $this->dane()->Uzytkownik();
			$koordynator = $mapper->pobierzPoId($this->idCoordinator);
			$this->_cache['koordynator'] = ($koordynator instanceof \Generic\Model\Uzytkownik\Obiekt) ? $koordynator : null;
		}
		return $this->_cache['koordynator'];
	}

	/**
	 * 
	 * @return \Generic\Model\Team\Obiekt
	 */
	public function pobierzTeam()
	{
		if ( ! isset($this->_cache['team']))
		{
			$mapper = $this->dane()->Team();
			$team = $mapper->pobierzPoId($this->idTeam);
			$this->_cache['team'] = ($team instanceof \Generic\Model\Team\Obiekt) ? $team : null;
		}
		return $this->_cache['team'];
	}
	
	/**
	 * 
	 * @return \Generic\Model\Notes\Obiekt
	 */
	public function pobierzNotatkaDoRaportu()
	{
		if ( ! isset($this->_cache['notatkaDoRaportu']))
		{
			$mapper = $this->dane()->Notes();
			$note = $mapper->pobierzPoId($this->idNotatkiDoRaportu);
			$this->_cache['notatkaDoRaportu'] = ($note instanceof \Generic\Model\Notes\Obiekt) ? $note : null;
		}
		return $this->_cache['notatkaDoRaportu'];
	}
	
	public function pobierzCene($kryteria = array())
	{
		if ( ! isset($this->_cache['cena']))
		{
			$mapper = $this->dane()->ProduktyZakupione();
			$cena = $mapper->pobierzKwoteDlaZamowienia($this->id, array_merge(array(
				'import' => false,
				'confirmation_status' => array('not confirmed', 'confirmed'),
				'not_id_product' => 92, // TODO: !!! Nie doliczam longest distance tutaj
			), $kryteria));
			$this->_cache['cena'] = ($cena >= 0) ? $cena : null;
		}
		return $this->_cache['cena'];
	}
	
	public function pobierzTekstProduktow($kryteriaProduktow = array(), $bezStatusu = false)
	{
		$maperProdukty = new \Generic\Model\Produkt\Mapper();
		$produktySorter = new \Generic\Model\Produkt\Sorter('kolejnosc', 'ASC');
		$wszystkieProdukty = listaZTablicy($maperProdukty->zwracaTablice()->szukaj(array(
			'status' => 'active',
			'import' => false,
			'ukryty' => true,
			//'visible_in_order' => array($this->idType),
		), null, $produktySorter), 'id');
		
		$produktyZakupioneMapper = new \Generic\Model\ProduktyZakupione\Mapper();
		/* zmieniony kod w taki sposób żeby brał pod uwgagę też produky specjalne
		 * 
		$produktyZakupione = listaZTablicy($produktyZakupioneMapper->zwracaTablice()->pobierzDlaZamowienia($this->id, array_merge(array(
			'import' => false,
			'confirmation_status' => array('not confirmed', 'confirmed'),
			'not_id_product' => 92, // TODO: !!! Nie doliczam longest distance tutaj
		), $kryteriaProduktow)), 'id_product');
		
		$smsChunks = array();
		
		$i = 0;
		foreach ($produktyZakupione as $id => $produkt)
		{
			$tresc = ($wszystkieProdukty[$id]['text_do_sms'] != "" && $wszystkieProdukty[$id]['name'] != "") ? $wszystkieProdukty[$id]['text_do_sms'] : $wszystkieProdukty[$id]['product_name'];
			
			$text = str_replace(array(
				'{QUANTITY}', 
				'{PRICE}'), array(
				$produkt['quantity'],
				$wszystkieProdukty[$id]['netto_price']
			), $tresc);
			$smsChunks[$id] = ($text != '' && $i == 0) ? ' '.$text : $text;
			$i++;
		}
		 * 
		 */
		
		$produktyZakupione = listaZTablicy($produktyZakupioneMapper->zwracaTablice()->pobierzDlaZamowienia($this->id, array_merge(array(
			'import' => false,
			'confirmation_status' => array('not confirmed', 'confirmed'),
			'not_id_product' => 92, // TODO: !!! Nie doliczam longest distance tutaj
		), $kryteriaProduktow)), 'id');
		//dump($produktyZakupione);
		$smsChunks = array();
		$i = 0;
		foreach ($produktyZakupione as $produkt)
		{
			//$tresc = ($produkt['text_do_sms'] != "" && $produkt['name'] != "") ? $produkt['text_do_sms'] : $produkt['product_name'];
			if($produkt['text_do_sms'] != "" && $produkt['name'] != "")
				$tresc = $produkt['text_do_sms'];
			else if($produkt['product_name'] != "")
				$tresc = $produkt['product_name'].' {QUANTITY} x kr {PRICE},-';
			else
				continue;

			$nettoPrice = ($produkt['netto_price'] != '') ? $produkt['netto_price'] : ( $produkt['netto_price_pz'] / $produkt['quantity'] );
			
			$text = str_replace(array(
				'{QUANTITY}', 
				'{PRICE}'), array(
				$produkt['quantity'],
				$nettoPrice,
			), $tresc);
			$idTmp = $produkt['id'];
			$smsChunks[$idTmp] = ($text != '' && $i == 0) ? ' '.$text : $text;
			$i++;
		}
		
		if($bezStatusu)
			$trescSms = '';
		else
			$trescSms = ($this->statusWork == 'done') ? 'OK' : 'ND';
		
		$szukane = array();
		$i = 0;
		foreach ($smsChunks as $id => $txt)
		{
			if (in_array($txt, $szukane))
				continue;
			$szukane[] = $txt;
			$ilosc = 0;
			$znalezione = array_keys($smsChunks, $txt);
			if (count($znalezione) > 1)
			{
				foreach ($znalezione as $id)
				{
					$ilosc += $produktyZakupione[$id]['quantity'];	
				}
			}
			else
			{
				$ilosc += $produktyZakupione[$id]['quantity'];
			}
			if ($i > 0)
			{
				$trescSms .= ' + ';
			}
			$trescSms .= str_replace(array('?', '  '), array($ilosc, ' '), $txt);
			if ($produktyZakupione[$id]['measure_unit'] == 'h')
			{
				$trescSms .= ' '.$produktyZakupione[$id]['quantity'].'h';
			}
			$i++;
		}
		return $trescSms;
	}
	
	public function dodajDoAdditionalData($parametr, $wartosc)
	{
		if(is_array($this->additionalData) && count($this->additionalData))
			$this->additionalData = array_merge($this->additionalData, array($parametr => $wartosc));
		else
			$this->additionalData = array($parametr => $wartosc);
	}
	

	public function zmienStatusPracy($nowyStatus, $oczekiwanyStatus = null)
	{
		$dopuszczalneWartosci = $this->definicjaObiektu->dopuszczalneWartosci['statusWork'];
		if (!in_array($nowyStatus, $dopuszczalneWartosci))
		{
			trigger_error('Proba zmiany statusu pracy zamowienia za niedozwolony status: '.$nowyStatus, E_USER_WARNING);
			return false;
			
			if ($oczekiwanyStatus !== null)
			{
				if (!in_array($oczekiwanyStatus, $dopuszczalneWartosci))
				{
					trigger_error('Proba zmiany statusu pracy zamowienia - niedopuszczalna wartosc oczekiwanego statusu: '.$oczekiwanyStatus, E_USER_WARNING);
					return false;
				}
			}
		}
		$zmiana = false;
		if ($oczekiwanyStatus !== null)
		{
			if ($this->statusWork == $oczekiwanyStatus)
			{
				$this->statusWork = $nowyStatus;
				$zmiana = true;
			}
		}
		else
		{
			$this->statusWork = $nowyStatus;
			$zmiana = true;
		}
		
		if ($zmiana)
		{
			$mapper = new \Generic\Model\Zamowienie\Mapper();
			if ($this->zapisz($mapper))
			{
				return true;
			}
		}
		return false;
	}
	
	public function pobierzStandardowyTytulZamowienia()
	{
		$z = $this;
		$znajdz = array(
			'{NUMBER_ORDER_GET}', '{NUMBER_ORDER_BKT}', '{NUMBER_PROJECT_GET}', '{DATE_ADDED}', '{PARENT_ORDER_NAME}', '{ORDER_POSTCODE}', '{ORDER_CITY}', '{ORDER_ADDRESS}', '{ID}',
			'{NUMBER_CUSTOMER}', '{ID_CUSTOMER}', '{NAME}', '{SECOND_NAME}', '{SURNAME}', '{COMPANY_NAME}', '{POSTCODE}', '{CITY}', '{ADDRESS}', '{APARTAMENT}',
			'    ', '   ', '  ', ', ,'
		);
		
		$parent = $z->pobierzParent();
		if ($parent instanceof \Generic\Model\Zamowienie\Obiekt)
		{
			$parentOrderName = $parent->orderName;
		}
		else
			$parentOrderName = '';
		
		$klient = $z->pobierzPrivatCustomer();
		
		$maperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
		$idTypowApartamentow = $maperKonfiguracja->pobierzWartoscWierszaKonfiguracji('widokProjektApartamenty.id_typu_apartament', 'Orders_Admin');
		
		if(in_array($this->idType, $idTypowApartamentow))
		{
			if($klient instanceof \Generic\Model\Klient\Obiekt)
			{
				$zamien = array(
					$z->numberOrderGet, $z->id, $z->numberProjectGet, $z->dateAdded, $parentOrderName, $z->postcode, $z->city, $z->address, $z->id,
					($klient->idCustomer > 0) ? $klient->idCustomer : $klient->id.'(BKT)', $klient->id, $klient->name, $klient->secondName, $klient->surname, $klient->companyName, $z->postcode, $z->city, $z->address, $z->apartment,
					' ', ' ', ' ', ''
				);
			}
			else
			{
				$zamien = array(
					$z->numberOrderGet, $z->id, $z->numberProjectGet, $z->dateAdded, $parentOrderName, $z->postcode, $z->city, $z->address, $z->id,
					'', '', '', '', '', '', $z->postcode, $z->city, $z->address, $z->apartment,
					' ', ' ', ' ', ''
				);
			}
			
		}
		elseif($klient instanceof \Generic\Model\Klient\Obiekt)
		{
			$zamien = array(
				$z->numberOrderGet, $z->id, $z->numberProjectGet, $z->dateAdded, $parentOrderName, $z->postcode, $z->city, $z->address, $z->id,
				($klient->idCustomer > 0) ? $klient->idCustomer : $klient->id.'(BKT)', $klient->id, $klient->name, $klient->secondName, $klient->surname, $klient->companyName, $klient->postcode, $klient->city, $klient->address, $klient->apartament,
				' ', ' ', ' ', ''
			);
		}
		else
		{
			$zamien = array(
				$z->numberOrderGet, $z->id, $z->numberProjectGet, $z->dateAdded, $parentOrderName, $z->postcode, $z->city, $z->address, $z->id,
				'', '', '', '', '', '', $z->postcode, $z->city, $z->address, $z->apartment,
				' ', ' ', ' ', ''
			);
		}
			$konfiguracjaTypu = $z->pobierzTypZamowienia()->pobierzKonfiguracjeTypu();

			$tytulZamowienia = str_replace('  ', '', trim(str_replace($znajdz, $zamien, $konfiguracjaTypu['order_auto_name'])));

			if (substr($tytulZamowienia, -1) == ',')
			{
				$tytulZamowienia = substr ($tytulZamowienia, 0, -1);
			}
		
		return $tytulZamowienia;
	}


	public function blokujDoEdycji()
	{
		if(!$this->blokadaEdycji)
		{
			$this->blokadaEdycji = TRUE;
			$mapper = new \Generic\Model\Zamowienie\Mapper();
			if($this->zapisz($mapper))
				return true;
			else
				return false;
		}
		return true;
	}

	public function blokujDoPoprawiania()
	{
		if(!$this->blokadaPoprawiania)
		{
			$this->blokadaPoprawiania = TRUE;
			$mapper = new \Generic\Model\Zamowienie\Mapper();
			if($this->zapisz($mapper))
				return true;
			else
				return false;
		}
		return true;
	}
	
	public function odblokujDoEdycja()
	{
		if($this->blokadaEdycji)
		{
			$this->blokadaEdycji = FALSE;
			$mapper = new \Generic\Model\Zamowienie\Mapper();
			if($this->zapisz($mapper))
				return true;
			else
				return false;
		}
		return true;
	}
	
	public function odblokujDoPoprawiania()
	{
		if($this->blokadaPoprawiania)
		{
			$this->blokadaPoprawiania = FALSE;
			$mapper = new \Generic\Model\Zamowienie\Mapper();
			if($this->zapisz($mapper))
				return true;
			else
				return false;
		}
		return true;
	}
}