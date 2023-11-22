<?php
namespace Generic\Modul\Testy;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Katalog;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\Mapper;
use Generic\Model\Wizytowka;
use Generic\Model\Klient;
use Generic\Model\WierszKonfiguracji;


/**
 * Modul administracyjny informujący o ustawieniach php umozliwajacy testy
 *
 * @author Konrad Rudowski
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\Testy\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Testy\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajPowielProdukty',
		'wykonajPhpinfo',
		'wykonajLogi',
		'wykonajPorownaj',
		'wykonajWyslijEmailTestowy',
		'wykonajSprawdzKatalogi',
		'wykonajKonfiguracja',
		'wykonajSprawdzTlumaczenia',
		'wykonajTlumaczenia',
		'wykonajSprawdzKonfiguracje',
		'wykonajResetujDaneUzytkownikow',
		'wykonajAktualizujProduktyZakupione',
		'wykonajListaWspolpracownikow',
		'wykonajPoprawTidsbanken',
		'wykonajImportProdukty'
	);


	public function wykonajPoprawTidsbanken()
	{
		$tidsbankenGodzinyMapper = $this->dane()->TidsbankenHours();
		$wpisy = $tidsbankenGodzinyMapper->szukaj(array('data_start_poczatek' => '2019-03-24 07:23:31'));

		foreach($wpisy as $wpis)
		{
			if($wpis->stop != null)
			{
				$kolekcja = new \Generic\Tidsbanken\Kolekcja($wpis);
				$kolekcja->uruchm();
				$kolekcja->zapisz();
			}
		}
			
	}
	
	public function wykonajPowielProdukty()
	{
		$cenaNowa = 612;
		$cenaStara = 595;
		$vat = 1.25;
		
		$produkty = $this->dane()->Produkt()->szukaj(array('status' => 'active', 'visible_in_order' => array(1, 2), 'import' => false, 'not_done' => false));
		$produktMapper = $this->dane()->Produkt();
		$tablica = array();
		$tablicaNowych = array();
		$kodProduktu = new \Generic\Model\Produkt\Obiekt();
		$dzisiaj = new \DateTime();
		foreach($produkty as $produkt)
		{
			$nowyProdukt = new \Generic\Model\Produkt\Obiekt();
			foreach($produkt as $klucz => $wartosc)
			{
				 
				if($klucz == 'id') continue;
				if($klucz == 'dataAdded') continue;
				if($klucz == 'dataWaznosciOd' || $klucz == 'dataWaznosciDo') continue;
				
				if($klucz == 'visibleInOrder')
				{
					$nowyProdukt->$klucz = array_filter(explode('|', $wartosc));
					continue;
				}
				if($klucz == 'kombinacje')
				{
					$nowyProdukt->$klucz = array_unique(array_filter(explode('|', $wartosc)));
					continue;
				}
				if($klucz == 'code')
				{
					$nowyProdukt->$klucz = $kodProduktu->generujKodProduktu($produkt->name);
				}
				
				$nowyProdukt->$klucz =  $wartosc;
				
				
			}
			
			$produkt->status = 'delete';
			$produkt->dataWaznosciDo = $dzisiaj;
			
			$produkt->zapisz($produktMapper);
				
			$nowyProdukt->zapisz($produktMapper);
			$tablicaNowych[$nowyProdukt->id] = $nowyProdukt;
			$tablica[$produkt->id] = $nowyProdukt->id;
			 
		}
		$datetime = new \DateTime();
		$datetime->add(new \DateInterval('P1D'));
		
		foreach($tablicaNowych as $klucz => $nowy)
		{
			$kombinacje = $nowy->kombinacje;
			$kombinacje = '|'.implode('|', $kombinacje).'|';
			foreach($tablica as $stareId => $noweId)
			{
				$kombinacje = str_replace('|'.$stareId.'|', '|'.$noweId.'|', $kombinacje);
			}
			$nowy->kombinacje = array_filter(explode('|', $kombinacje));
			$nowy->nettoPrice =  round( (round(($nowy->nettoPrice / $cenaStara), 2) * $cenaNowa) , 0);
			$nowy->bruttoPrice  = $nowy->nettoPrice * $vat;
			$idStarePolaczony = $nowy->idPolaczony;
			$nowy->dataWaznosciOd = $datetime;
			$nowy->idPolaczony = isset($tablica[$idStarePolaczony]) ? $tablica[$idStarePolaczony] : null;
			$nowy->zapisz($produktMapper);
		}
		$this->porownajProdukty($tablica);
		//dump($tablica);
	}
	
	public function wykonajImportProdukty()
	{
		$p = array (
			0 => 
			array (
			  'description' => 'TilkoblingshjelpWIFIX-pakken (3-pack)',
			  'serviceCode' => 'I-AIRT',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 450,
					'extended' => NULL,
					'invoiceText' => 'Tilkobling Trådløs Boligpakke',
					'listPriceConditionId' => 3397,
					'listPriceId' => 2717,
				 ),
			  ),
			  'timeUnitPerService' => 0.5,
			  'serviceId' => 3038,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			1 => 
			array (
			  'description' => 'Godkjente løpende timer',
			  'serviceCode' => 'I-GOD',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0.5,
			  'serviceId' => 3032,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			2 => 
			array (
			  'description' => 'Ekstra tid installasjon',
			  'serviceCode' => 'I-EKS',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0.5,
			  'serviceId' => 3030,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			3 => 
			array (
			  'description' => 'Dokumantasjon',
			  'serviceCode' => 'I-DOK',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0.1700000000000000122124532708767219446599483489990234375,
			  'serviceId' => 3005,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			4 => 
			array (
			  'description' => 'Inst. Extender (AP)',
			  'serviceCode' => 'I-EXT',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0.5,
			  'serviceId' => 2978,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			5 => 
			array (
			  'description' => 'Oppstart',
			  'serviceCode' => 'I-OPPS',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 350,
					'extended' => NULL,
					'invoiceText' => 'Oppstart',
					'listPriceConditionId' => 3278,
					'listPriceId' => 2659,
				 ),
			  ),
			  'timeUnitPerService' => 0.5,
			  'serviceId' => 2923,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			6 => 
			array (
			  'description' => 'Inst. Villaprosjekt',
			  'serviceCode' => 'I-INVA',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 990,
					'extended' => NULL,
					'invoiceText' => 'Installajon Villaprosjekt',
					'listPriceConditionId' => 3233,
					'listPriceId' => 2637,
				 ),
			  ),
			  'timeUnitPerService' => 2.5,
			  'serviceId' => 2922,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			7 => 
			array (
			  'description' => 'Inst kontakt',
			  'serviceCode' => 'I-INKO',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 860,
					'extended' => NULL,
					'invoiceText' => 'Installsjon kontakt',
					'listPriceConditionId' => 3234,
					'listPriceId' => 2638,
				 ),
			  ),
			  'timeUnitPerService' => 1.25,
			  'serviceId' => 2921,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			8 => 
			array (
			  'description' => 'Tilkoblingshjelp',
			  'serviceCode' => 'I-TILK',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 450,
					'extended' => NULL,
					'invoiceText' => 'Tilkoblingshjelp',
					'listPriceConditionId' => 3235,
					'listPriceId' => 2639,
				 ),
			  ),
			  'timeUnitPerService' => 0.5,
			  'serviceId' => 2920,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			9 => 
			array (
			  'description' => 'Hente Get Box II',
			  'serviceCode' => 'I-GBII',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0,
			  'serviceId' => 2526,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			10 => 
			array (
			  'description' => 'Hente Get box Mikro',
			  'serviceCode' => 'I-MICR',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0,
			  'serviceId' => 2525,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			11 => 
			array (
			  'description' => 'Hjemlev EMTA 3.0 (8 CH) WLAN',
			  'serviceCode' => 'I-EMTA',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0,
			  'serviceId' => 1541,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			12 => 
			array (
			  'description' => 'Timespris installatør',
			  'serviceCode' => 'I-330',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 550,
					'extended' => NULL,
					'invoiceText' => 'Timespris installatør',
					'listPriceConditionId' => 1714,
					'listPriceId' => 1576,
				 ),
			  ),
			  'timeUnitPerService' => 0,
			  'serviceId' => 1495,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			13 => 
			array (
			  'description' => 'Oppmøtegebyr',
			  'serviceCode' => 'I-329',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 550,
					'extended' => NULL,
					'invoiceText' => 'Oppmøtegebyr',
					'listPriceConditionId' => 1689,
					'listPriceId' => 1563,
				 ),
			  ),
			  'timeUnitPerService' => 0,
			  'serviceId' => 1380,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			14 => 
			array (
			  'description' => 'Montere nedføringsrør',
			  'serviceCode' => 'I-328',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0.5,
			  'serviceId' => 1378,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			15 => 
			array (
			  'description' => 'Befaring',
			  'serviceCode' => 'I-325',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 0,
					'extended' => NULL,
					'invoiceText' => 'Befaring',
					'listPriceConditionId' => 1659,
					'listPriceId' => 1545,
				 ),
			  ),
			  'timeUnitPerService' => 0.5,
			  'serviceId' => 1368,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			16 => 
			array (
			  'description' => 'Gigaset trådløs',
			  'serviceCode' => 'I-322',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0,
			  'serviceId' => 1365,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			17 => 
			array (
			  'description' => 'Bytte kontakt',
			  'serviceCode' => 'I-321',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 159,
					'extended' => NULL,
					'invoiceText' => 'Bytte kontakt',
					'listPriceConditionId' => 1658,
					'listPriceId' => 1544,
				 ),
			  ),
			  'timeUnitPerService' => 0.25,
			  'serviceId' => 1361,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			18 => 
			array (
			  'description' => 'Hente modem',
			  'serviceCode' => 'I-318',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0,
			  'serviceId' => 1355,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			19 => 
			array (
			  'description' => 'Hente Get box PVR',
			  'serviceCode' => 'I-317',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0,
			  'serviceId' => 1354,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			20 => 
			array (
			  'description' => 'Hente Get box HDi',
			  'serviceCode' => 'I-316',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0,
			  'serviceId' => 1353,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			21 => 
			array (
			  'description' => 'Retilkoble med ekstra arbeid',
			  'serviceCode' => 'I-RETI',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 0,
					'extended' => NULL,
					'invoiceText' => 'Retilkoble med ekstra arbeide',
					'listPriceConditionId' => 1563,
					'listPriceId' => 1463,
				 ),
			  ),
			  'timeUnitPerService' => 0.5,
			  'serviceId' => 24,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			22 => 
			array (
			  'description' => 'Oppgradering villa',
			  'serviceCode' => 'I-OPVI',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 0,
					'extended' => NULL,
					'invoiceText' => 'Oppgradering Villa',
					'listPriceConditionId' => 214,
					'listPriceId' => 146,
				 ),
			  ),
			  'timeUnitPerService' => 1.25,
			  'serviceId' => 22,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			23 => 
			array (
			  'description' => 'Inst. Husforsterker',
			  'serviceCode' => 'I-HUSF',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 490,
					'extended' => NULL,
					'invoiceText' => 'Inst. Husforsterker',
					'listPriceConditionId' => 1420,
					'listPriceId' => 1320,
				 ),
			  ),
			  'timeUnitPerService' => 0.5,
			  'serviceId' => 14,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			24 => 
			array (
			  'description' => 'Inst. Blokk stjerne',
			  'serviceCode' => 'I-BLST',
			  'servicePrices' => 
			  array (
				 0 => 
				 array (
					'amount' => 1674,
					'extended' => NULL,
					'invoiceText' => 'Inst. blokk stjerne',
					'listPriceConditionId' => 1559,
					'listPriceId' => 1459,
				 ),
			  ),
			  'timeUnitPerService' => 1.5,
			  'serviceId' => 13,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
			25 => 
			array (
			  'description' => 'Installation',
			  'serviceCode' => 'I',
			  'servicePrices' => 
			  array (
			  ),
			  'timeUnitPerService' => 0,
			  'serviceId' => 10,
			  'serviceTypeId' => 1,
			  'serviceTypeCode' => 'I',
			),
		);
		
		$produktyMapper = new \Generic\Model\Produkt\Mapper();
		
		$i = 0;
		foreach ($p as $prod)
		{
			$produkt = new \Generic\Model\Produkt\Obiekt();
			$cena = ceil(($prod['timeUnitPerService']*595));
			$produkt->idProjektu = 1;
			$produkt->kolejnosc = $i++;
			$produkt->name = $prod['description'];
			$produkt->code = $produkt->generujKodProduktu($prod['description']);
			$produkt->status = 'active';
			$produkt->measureUnit = 'szt';
			$produkt->visibleInOrder = array('1', '2');
			$produkt->dateAdded = date("Y-m-d");
			$produkt->import = FALSE;
			if (! empty($prod['servicePrices']))
			{
				$produkt->textDoSms = $prod['servicePrices'][0]['invoiceText'].' x ?';
			}
			else
			{
				$produkt->textDoSms = $prod['description'].' x ?';
			}
			$produkt->mainProduct = TRUE;
			$produkt->multiplied = TRUE;
			$produkt->dataWaznosciOd = new \DateTime('-1 day');
			$wartoscBrutto = $this->liczBrutto($cena, 25);
			$produkt->vat = 25;
			$produkt->nettoPrice = $cena;
			$produkt->bruttoPrice = $wartoscBrutto;
			
			if ($produkt->zapisz($produktyMapper))
			{
				dump('Zapisano '.$prod['description']);
			}
			else
			{
				dump('!!! NIE zapisano '.$prod['description']);
			}
		}
	}

	private function liczBrutto($netto, $vat)
	{
		intval($vat) ;
		
		$netto = str_replace(',', '.', $netto);
		$brutto = ($netto * (1 + ($vat/100)));
		return round($brutto, 2);
	}

	private function porownajProdukty(Array $tablica)
	{
		$idStarych = array_keys($tablica);
		$idNowych = array_values($tablica);
		
		$produktyStare = listaZTablicy($this->dane()->Produkt()->zwracaTablice()->szukaj(array('id' => $idStarych)), 'id');
		$produktyNowe = listaZTablicy($this->dane()->Produkt()->zwracaTablice()->szukaj(array('id' => $idNowych)), 'id');
		
		$this->komunikat('Ilość produktów usuniętych '.count($produktyStare).' ilość produktów dodanych '.count($produktyNowe), 'info');
		
		foreach($produktyStare as $id => $produktStary)
		{
			$idNowyProdukt = $tablica[$id];
			if(isset($produktyNowe[$idNowyProdukt]))
			{
				$ks = array_filter(explode('|', $produktStary['kombinacje']));
				sort($ks);
				$kn = array_filter(explode('|', $produktyNowe[$idNowyProdukt]['kombinacje']));
				sort($kn);
				$kombinacjeNazwyStary = '';
				$iloscProdPol = 0;
				$iloscProdPolK = 0;
				if(count($ks))
				{
					$prodPol = listaZTablicy(
									 $this->dane()->Produkt()->zwracaTablice()->szukaj(array('id' => $ks)), 
									 'name', 
									 'name'
									 );
					$iloscProdPol = count($prodPol);
					$kombinacjeNazwyStary = implode(
						  ',',
						  $prodPol
						  );
				}
				$kombinacjeNazwyNowy = '';
				if(count($kn))
				{
					
					$prodPol = listaZTablicy(
									 $this->dane()->Produkt()->zwracaTablice()->szukaj(array('id' => $kn)), 
									 'name', 
									 'name'
									 );
					$iloscProdPolK = count($prodPol);
					$kombinacjeNazwyNowy = implode(
						  ',',
						  $prodPol
						  );
				}
				
						  
				$this->tresc .= $this->szablon->ustawBlok('powielProdukty/produkt', array(
					'staryId' => $produktStary['id'],
					'staryNazwa' =>$produktStary['name'],
					'staryKombinacjeIlosc' => count(explode('|', $produktStary['kombinacje'])) - 2,
					'staryKombinacje' =>  $produktStary['kombinacje'],
					'staryCena' => $produktStary['netto_price'],
					'stary_polaczone' => $produktStary['id_polaczony'],
					'staryPolaczonyNazwa' => isset($produktyStare[$produktStary['id_polaczony']]) ? $produktyStare[$produktStary['id_polaczony']]['name'] : '...',
					'kombinacjeNazwyStary' => $kombinacjeNazwyStary,
					
					'nowyNazwa' => $produktyNowe[$idNowyProdukt]['name'],
					'nowyId' => $produktyNowe[$idNowyProdukt]['id'],
					'nowyKombinacjeIlosc' => count(explode('|', $produktyNowe[$idNowyProdukt]['kombinacje'])) -2,
					'nowyKombinacje' =>  $produktyNowe[$idNowyProdukt]['kombinacje'],
					'nowyCena' => $produktyNowe[$idNowyProdukt]['netto_price'],
					'nowy_polaczone' => $produktyNowe[$idNowyProdukt]['id_polaczony'],
					'nowyPolaczonyNazwa' => isset($produktyNowe[$produktyNowe[$idNowyProdukt]['id_polaczony']]) ? $produktyNowe[$produktyNowe[$idNowyProdukt]['id_polaczony']]['name'] : '...',
					'kombinacjeNazwyNowy' => $kombinacjeNazwyNowy,
					'iloscPol' => $iloscProdPol,
					'iloscPolK' => $iloscProdPolK,
				));
				
			}
			else
			{
				$this->komunikat('Brak dopasowania produktu o id '.$produktStary['id'].' i nazwie '.$produktStary['name'], 'error');
			}
			
		}
		
		$this->tresc .= $this->szablon->parsujBlok('powielProdukty', array(
				
			));
		
	}
	
	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));



		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'grid' => '',
			'link_phpinfo' => Router::urlAdmin('Testy', 'phpinfo'),
			'link_logi' => Router::urlAdmin('Testy', 'logi'),
			'link_porownanie_konfiguracji' => Router::urlAdmin('Testy', 'porownaj'),
			'link_email_testowy' => Router::urlAdmin('Testy', 'wyslijEmailTestowy'),
			'link_sprawdz_tlumaczenia' => Router::urlAdmin('Testy', 'sprawdzTlumaczenia'),
			'link_sprawdz_konfiguracje' => Router::urlAdmin('Testy', 'sprawdzKonfiguracje'),
			'link_aktualizuj_produkty_zakupione_villa' => Router::urlAdmin('Testy', 'aktualizujProduktyZakupione', array('idType' => 1)),
			'link_aktualizuj_produkty_zakupione_b2b' => Router::urlAdmin('Testy', 'aktualizujProduktyZakupione', array('idType' => 2)),
		));

		if (Cms::inst()->profil()->maUprawnieniaDo('Testy_wykonajResetujDaneUzytkownikow') && strpos($_SERVER['SERVER_NAME'], 'supertraders.pl') === false)
		{
			$this->tresc .= $this->szablon->parsujBlok('index/resetDanych', array(
			'link_resetuj_dane' => Router::urlAdmin('Testy', 'ResetujDaneUzytkownikow'),
			'onclick_resetuj_dane' => 'if (confirm(\'' . $this->j->t['index.etykieta_resetuj_dane_potwierdzenie'] . '\')) {return confirm(\'' . $this->j->t['index.etykieta_resetuj_dane_potwierdzenie2'] . '\');} else {return false;}',
		));

		}
	}



	public function wykonajPhpinfo()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['phpinfo.tytul_strony']));

		ob_start();
		phpinfo();
		$phpinfo = ob_get_contents();
		ob_clean();

		// the name attribute "module_Zend Optimizer" of an anker-tag is not xhtml valide, so replace it with "module_Zend_Optimizer"
		$phpinfo = preg_replace( '%^.*<body>(.*)</body>.*$%ms', '$1', $phpinfo);
		$phpinfo = (str_replace("module_Zend Optimizer", "module_Zend_Optimizer", $phpinfo));
		//$phpinfo = (str_replace('width="600"', '', $phpinfo));

		$this->tresc .= $this->szablon->parsujBlok('phpinfo', array('grid' => $phpinfo));
	}



	public function wykonajLogi()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['logi.tytul_strony']));

		$plik = Zadanie::pobierz('plik','strtolower', 'filtr_xss', 'trim');
		if ($plik != '' && substr($plik, -4) == '.log')
		{
			$plik = LOGI_KATALOG.'/'.$plik;
			if (is_file($plik))
			{
				$this->tresc .= $this->szablon->parsujBlok('/logi/plik', array(
					'tresc' => file_get_contents($plik),
				));
			}
		}
		else
		{
			$grid = new TabelaDanych();
			$grid->dodajKolumne('plik', '', null, '', true);
			$grid->dodajKolumne('nazwa', $this->j->t['logi.etykieta_nazwa'], null, Router::urlAdmin('Testy','logi',array('{KLUCZ}' => '{WARTOSC}')));

			$kryteria = $this->formularzWyszukiwaniaLogi($grid);

			$dane = array();

			$katalog = new Katalog(LOGI_KATALOG);
			if ($katalog->istnieje())
			{
				$lista = array_keys($katalog->pobierzZawartosc(1));
				foreach ($lista as $plik)
				{
				//	if (substr($plik, -4) != '.log' || (stripos($plik,'sql') === false && stripos($plik,'php') === false)) continue;
				//	if ($kryteria['typ'] == 'sql' && stripos($plik,'sql') === false) continue;
				//	if ($kryteria['typ'] == 'php' && stripos($plik,'php') === false) continue;
					if ($kryteria['fraza'] != '' && stripos($plik, $kryteria['fraza']) === false) continue;
					$dane[] = $plik;
				}
			}
			$ilosc = count($dane);

			if ($ilosc > 0)
			{
				$naStronie = $this->pobierzParametr('naStronie', $this->k->k['logi.wierszy_na_stronie'], true, array('intval','abs'));
				$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
				$kolumna = $this->pobierzParametr('kolumna', 'nazwa', true, array('strval'));
				$kierunek = $this->pobierzParametr('kierunek', $this->k->k['logi.domyslny_kierunek'], true, array('strval'));

				$sorter = new DostepnyModul\Sorter($kolumna, $kierunek);
				$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);

				$grid->ustawSortownie(array('nazwa'), $kolumna, $kierunek,
					Router::urlAdmin('Testy', 'logi', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
				);
				$grid->pager($pager->html(Router::urlAdmin('Testy', 'logi', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

				($kierunek == 'asc') ? sort($dane) : rsort($dane);
				$licznik = 1;
				$poczatek = $pager->pierwszyNaStronie();
				$koniec = $pager->ostatniNaStronie();
				$bufor = array();

				foreach ($dane as $wiersz)
				{
					if ($licznik >= $poczatek && $licznik <= $koniec)
					{
						$grid->dodajWiersz(array('plik' => $wiersz, 'nazwa' => $wiersz));
					}
					$licznik++;
				}
			}
			$this->tresc .= $this->szablon->parsujBlok('/logi', array(
				'grid' => $grid->html(),
			));
		}
	}



	public function wykonajKonfiguracja()
	{
		$konfiguracja = $this->wezKonfiguracje();
		zwrocTrescDoPrzegladarki($konfiguracja, 'konfiguracja.csv');
	}



	public function wykonajTlumaczenia()
	{
		$mapper = $this->dane()->WierszTlumaczen();

		$tlumaczenia = array();
		foreach ($mapper->zwracaTablice()->pobierzPelna(KOD_JEZYKA) as $wiersz)
		{
			$tlumaczenia[] = implode('|',array(
				$wiersz['kod_modulu'],
				$wiersz['id_kategorii'],
				$wiersz['id_bloku'],
				$wiersz['nazwa'],
				$wiersz['typ'],
				strtr($wiersz['wartosc'], array("\r\n" => '\r\n',"\n" => '\n')),
			));
		}
		sort($tlumaczenia);
		$tlumaczenia = implode("\n",$tlumaczenia);
		zwrocTrescDoPrzegladarki($tlumaczenia, 'tlumaczenia.csv');
	}



	public function wykonajPorownaj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['porownajKonfiguracje.tytul_strony']));

		$obiektFormularza = new \Generic\Formularz\Konfiguracja\Porownanie();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('porownajKonfiguracje'))
			->ustawKonfiguracje(array('dozwolone_formaty_plikow' => $this->k->k['porownajKonfiguracje.dozwolone_formaty_plikow']));

		if ($obiektFormularza->wypelniony())
		{
			if ($obiektFormularza->danePoprawne())
			{
				$plik_konfiguracja = $obiektFormularza->zwrocFormularz()->plik->pobierzWartosc();
				$plik = new Plik($plik_konfiguracja['tmp_name']);

				$wczytana_konfiguracja = array();
				$bazowa_konfiguracja = array();
				$roznice_konfiguracji = array();

				if($plik->pobierzZawartosc())
				{
					foreach(explode("\n", $plik->pobierzZawartosc()) as $wiersz)
					{
						$dane = explode("|", $wiersz);
						$wczytana_konfiguracja[$dane[0] . '_' . $dane[1] . '_' . $dane[2] . '_' . $dane[3]] = $dane;
					}
				}

				if($plik->pobierzZawartosc($this->wezKonfiguracje()))
				{
					foreach(explode("\n", $this->wezKonfiguracje()) as $wiersz)
					{
						$dane = explode("|", $wiersz);
						$bazowa_konfiguracja[$dane[0] . '_' .  $dane[1] . '_' . $dane[2] . '_' . $dane[3]] = $dane;
					}
				}

				foreach($wczytana_konfiguracja as $klucz => $wartosc)
				{
					if( ! isset($bazowa_konfiguracja[$klucz]['5']))
					{
						$roznice_konfiguracji[] = array(
							'id' => $klucz,
							'modul' => $wartosc['0'],
							'kategoria_id' => ($wartosc['1'] != '') ? $wartosc['1'] : $wartosc['2'],
							'klucz' => $wartosc['3'],
							'wartosc_bazowa' => '&nbsp;',
							'wartosc_wczytana' => $wartosc['5'],
							'status' => 'Nowa');
					}
					elseif($wartosc['5'] != $bazowa_konfiguracja[$klucz]['5'])
					{
						$roznice_konfiguracji[] = array(
							'id' => $klucz,
							'modul' => $wartosc['0'],
							'kategoria_id' => ($wartosc['1'] != '') ? $wartosc['1'] : $wartosc['2'],
							'klucz' => $wartosc['3'],
							'wartosc_bazowa' => $bazowa_konfiguracja[$klucz]['5'],
							'wartosc_wczytana' => $wartosc['5'],
							'status' => 'Zmieniona');
					}
				}

				$grid = new TabelaDanych();
				$grid->dodajKolumne('id', '', null, null, true);
				$grid->dodajKolumne('modul', $this->j->t['porownajKonfiguracje.etykieta_modul']);
				$grid->dodajKolumne('klucz', $this->j->t['porownajKonfiguracje.etykieta_klucz_konfiguracji']);
				$grid->dodajKolumne('wartosc_bazowa', $this->j->t['porownajKonfiguracje.etykieta_wartosc_konfiguracji_bazowa']);
				$grid->dodajKolumne('wartosc_wczytana', $this->j->t['porownajKonfiguracje.etykieta_wartosc_konfiguracji_wczytana']);
				$grid->dodajKolumne('status', $this->j->t['porownajKonfiguracje.etykieta_status']);

				$kategorie = $this->dane()->WierszKonfiguracji();

				$kategorie = $kategorie->pobierzDlaModulu('KonfiguracjaSystemu');

				foreach($roznice_konfiguracji as $wiersz)
				{
					if(strpos($wiersz['modul'], 'Blok') === 0)
						$akcja = 'edytujBlok';
					else
						$akcja = 'edytujKategorie';

					$wiersz['modul'] = '<u><a href="' . Router::urlAdmin('KonfiguracjaSystemu', $akcja, array('id' => $wiersz['kategoria_id'])) . '">' . $wiersz['modul'] . '</a></u>';

					$grid->dodajWiersz($wiersz);
				}

				$this->tresc .= $grid->html();
			}
			else
				$this->tresc .= $obiektFormularza->html();
		}
		else
		{
			$this->tresc .= $obiektFormularza->html();
		}
	}


	public function wykonajWyslijEmailTestowy()
	{
		$cms = Cms::inst();

		$obiektFormularza = new \Generic\Formularz\Mailing\WysylkaTestowa();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('emailTestowy'))
			->ustawUrlPowrotny(Router::urlAdmin('Testy'))
			->ustawKonfiguracje(array('wymaganePola' => $this->k->k['emailTestowy.wymagane_pola']));

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$dane = $obiektFormularza->pobierzWartosci();

			$poczta = new Pomocnik\Poczta();
			$poczta->wczytajUstawienia(array(
				'emailNadawcaEmail' => $dane['odEmail'],
				'emailNadawcaNazwa' => $dane['odNazwa'],
				'emailOdbiorcy' => array($dane['doEmail'] => $dane['doNazwa']),
				'emailTytul' => $dane['tytul'],
				'emailTrescHtml' => isset($dane['trescHtml']) ? $dane['trescHtml'] : '',
				'emailTrescTxt' => $dane['tresc'],
			));

			if ($poczta->wyslij())
			{
				$this->komunikat($this->j->t['emailTestowy.info_wyslano_poprawnie'], 'info');
			}
			else
			{
				$this->komunikat($this->j->t['emailTestowy.blad.nie_mozna_wyslac_emaila'], 'error');
			}

			if ($dane['smtpDebug'] > 0)
			{
				$obiektFormularza->zwrocFormularz()->otworzZakladke('debugInfo');

				$obiektFormularza->zwrocFormularz()->input(new Input\TextArea('debugInfoArea'));
				$obiektFormularza->zwrocFormularz()->debugInfoArea->ustawWartosc($cms->temp('smtp_debug'));

				$obiektFormularza->zwrocFormularz()->zamknijZakladke('debugInfo');
				$obiektFormularza->zwrocFormularz()->ustawTlumaczenia($this->pobierzBlokTlumaczen('emailTestowy'));
			}

		}

		$this->tresc .= $obiektFormularza->html();
	}


	public function wykonajSprawdzTlumaczenia()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['sprawdzTlumaczenia.tytul_strony']));

		$wykonaj = Zadanie::pobierz('wykonaj', 'filtr_xss', 'trim');
		$id = Zadanie::pobierz('id', 'intval', 'abs');

		$mapper = DostepnyModul\Mapper::wywolaj(Mapper::ZWRACA_TABLICE);
		foreach($mapper->pobierzWszystko() as $klucz => $wartosc)
		{
			$moduly[$wartosc['kod']] = $wartosc;
		}

		foreach($moduly as $klucz => $modul)
		{
			foreach($modul['uslugi'] as $usluga)
			{
				//Dla uslugi Cron nic nie robimy
			//	if($usluga == 'Cron') continue;
				$klasa = 'Generic\\Modul\\' . $modul['kod'] . '\\' . $usluga;
				$objekt = new $klasa();
				$tlumaczenia = $objekt->pobierzTlumaczenia();

				$nazwaModulu = $objekt->pobierzNazweModulu();
				foreach($tlumaczenia as $klucz => $wartosc)
				{
					if(is_array($wartosc)) $wartosc = serialize($wartosc);
					$tlumaczeniaPliki[$nazwaModulu . '.' . $klucz] = $wartosc;
				}
			}
		}

		$mapperTlumaczenia = $this->dane()->WierszTlumaczen();
		$tempBledy[0] = $tempBledy[1] = $tempBledy[2] = array();
		$bledneWpisy = array();
		$zamien = array('_Http' => '', '_Admin' => '');

		//Wykrywanie nie istniejacych tlumaczen
		//Wykrywanie takich samych wpisow wartosci w bazie i modulach
		foreach($mapperTlumaczenia->pobierzPelna() as $klucz => $obiekt)
		{
			//Porownujemy tylko tlumaczenia z modulow
			if($obiekt->kodModulu == false) continue;

			$naprawione = false;
			$kodBledu = false;

			$klucz = $obiekt->kodModulu . '.' . $obiekt->nazwa;

			if( (! array_key_exists($klucz, $tlumaczeniaPliki) && $wykonaj == 'naprawWszystko') || $id == $obiekt->id)
				if($obiekt->usun($mapperTlumaczenia)) $naprawione = true;

			if((isset($tlumaczeniaPliki[$klucz]) && $tlumaczeniaPliki[$klucz] ===  $obiekt->wartosc && $wykonaj == 'naprawWszystko') || $id == $obiekt->id)
				if($obiekt->usun($mapperTlumaczenia)) $naprawione = true;

			if($naprawione === true) continue;

			if( ! array_key_exists($klucz, $tlumaczeniaPliki))
				$kodBledu = 0;
			elseif(isset($tlumaczeniaPliki[$klucz]) && $tlumaczeniaPliki[$klucz] ===  $obiekt->wartosc)
				$kodBledu = 1;

			$kodModulu = strtr($obiekt->kodModulu, $zamien);
			if($kodBledu !== false)
				$tempBledy[$kodBledu][] = array(
					'id' => $obiekt->id,
					'klucz' => $klucz,
					'typ' => (isset($moduly[$kodModulu])) ? $moduly[$kodModulu]['typ'] : '',
					'kod_modulu' => $obiekt->kodModulu,
					'id_kategorii' => $obiekt->idKategorii,
					'id_bloku' => $obiekt->idBloku,
					'wartosc' => htmlspecialchars($obiekt->wartosc),
					'blad' => $this->j->t['sprawdz.typy_bledow'][$kodBledu]);
		}

		//Sprawdzenie czy nie mamy naprawic tlumaczen jesli tak sprawdzamy czy sie naprawily i jesli tak nie wykonujemy petli
		if( ! (($wykonaj == 'usunDuplikaty' || $wykonaj == 'naprawWszystko') && $mapperTlumaczenia->usunZduplikowaneWpisy()))
		{
			//Wykrywanie zduplikowaych wpisow w bazie
			foreach($mapperTlumaczenia->pobierzZduplikowaneWpisy() as $klucz => $obiekt)
			{
				$klucz = $obiekt->kodModulu . '.' . $obiekt->nazwa;
				$kodModulu = strtr($obiekt->kodModulu, $zamien);
				$tempBledy[2][] = array(
					'id' => $obiekt->id,
					'klucz' => $klucz,
					'typ' => (isset($moduly[$kodModulu])) ? $moduly[$kodModulu]['typ'] : '',
					'kod_modulu' => $obiekt->kodModulu,
					'id_kategorii' => $obiekt->idKategorii,
					'id_bloku' => $obiekt->idBloku,
					'wartosc' => htmlspecialchars($obiekt->wartosc),
					'blad' => $this->j->t['sprawdz.typy_bledow'][2]);
			}
		}

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', null, null, true);
		$grid->dodajKolumne('klucz', $this->j->t['sprawdzTlumaczenia.etykieta_klucz']);
		$grid->dodajKolumne('id_kategorii', $this->j->t['sprawdzTlumaczenia.etykieta_id_kategorii']);
		$grid->dodajKolumne('id_bloku', $this->j->t['sprawdzTlumaczenia.etykieta_id_bloku']);
		$grid->dodajKolumne('wartosc', $this->j->t['sprawdzTlumaczenia.etykieta_wartosc']);
		$grid->dodajKolumne('blad', $this->j->t['sprawdzTlumaczenia.etykieta_blad']);


		$grid->dodajPrzyciski(
			Router::urlAdmin('Testy', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
			array(
				'napraw' =>array(
					'klucz' => 'napraw',
					'akcja' => Router::urlAdmin('Testy', 'sprawdzTlumaczenia', array('{KLUCZ}' => '{WARTOSC}')),
					'etykieta' => $this->j->t['sprawdzTlumaczenia.etykieta_napraw'],
					'ikona' => 'icon-wrench',
					'onclick' => 'return potwierdzenieUsun(\''.$this->j->t['sprawdzTlumaczenia.etykieta_potwierdz_napraw'].'\', $(this))',
				)
			)
		);

		$bledneWpisy = array_merge_recursive($tempBledy[0],$tempBledy[1],$tempBledy[2]);
		foreach($bledneWpisy as $wiersz)
		{
			$wiersz['wartosc'] = str_cut($wiersz['wartosc'], 100);

			if($wiersz['blad'] == $this->j->t['sprawdz.typy_bledow'][2])
				$grid->usunPrzyciski(array('napraw'));

			if($wiersz['id_kategorii'] != false)
			{
				$id = $wiersz['id_kategorii'];
				$akcja = 'edytujKategorie';
			}
			elseif($wiersz['id_bloku'] != false)
			{
				$id = $wiersz['id_bloku'];
				$akcja = 'edytujBlok';
			}

			if( ! ($wiersz['id_kategorii'] == false && $wiersz['id_bloku'] == false))
			{
				$klucz = explode('_', $wiersz['kod_modulu']);
				$wiersz['klucz'] = '<a href="' . Router::urlAdmin('UstawieniaJezykowe', $akcja, array('id' => $id)) . '#' . $klucz[1] . '|' . $klucz[1] . str_replace('.', '_', str_replace($wiersz['kod_modulu'], '', $wiersz['klucz'])) . '">' . $wiersz['klucz'] . '</a>';
			}
			elseif($wiersz['kod_modulu'] == false)
			{
				$klucz = explode('.', trim($wiersz['klucz'], '.'));
				$wiersz['klucz'] = '<a href="' . Router::urlAdmin('UstawieniaJezykowe', 'biblioteki#' . $klucz[0]) . '|' . substr(str_replace('.', '_', $wiersz['klucz']), 1, strlen($wiersz['klucz']) - 1) . '">' . $wiersz['klucz'] . '</a>';
			}
			else
			{
				$klucz = explode('_', $wiersz['kod_modulu']);
				$wiersz['klucz'] = '<a href="' . Router::urlAdmin('UstawieniaJezykowe', (($wiersz['typ'] == 'administracyjny') ? 'edytujAdministracyjny' : 'edytujZwykly'), array('kod' => $klucz[0])) . '#' . $klucz[1] . '|' . $klucz[1] . str_replace('.', '_', str_replace($wiersz['kod_modulu'], '', $wiersz['klucz'])) . '">' . $wiersz['klucz'] . '</a>';
			}
			$grid->dodajWiersz($wiersz);
		}

		$dane = array(
			'tabela_danych' => $grid->html(),
			'link_napraw' => Router::urlAdmin('Testy', 'sprawdzTlumaczenia', array('wykonaj' => 'naprawWszystko')),
			'link_usun_duplikaty' => Router::urlAdmin('Testy', 'sprawdzTlumaczenia', array('wykonaj' => 'usunDuplikaty')),
		);

		$this->tresc .= $this->szablon->parsujBlok('sprawdz', $dane);
	}



	public function wykonajSprawdzKonfiguracje()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['sprawdzKonfiguracje.tytul_strony']));

		$wykonaj = Zadanie::pobierz('wykonaj', 'filtr_xss', 'trim');
		$id = Zadanie::pobierz('id', 'intval', 'abs');

		$mapper = DostepnyModul\Mapper::wywolaj(Mapper::ZWRACA_TABLICE);
		foreach($mapper->pobierzWszystko() as $klucz => $wartosc)
		{
			$moduly[$wartosc['kod']] = $wartosc;
		}

		foreach($moduly as $klucz => $modul)
		{
			foreach($modul['uslugi'] as $usluga)
			{
				//Dla uslugi Cron nic nie robimy
				//	if($usluga == 'Cron') continue;
				$klasa = 'Generic\\Modul\\' . $modul['kod'] . '\\' . $usluga;
				$objekt = new $klasa();
				$konfiguracja = $objekt->pobierzKonfiguracje();

				$nazwaModulu = $objekt->pobierzNazweModulu();
				foreach($konfiguracja as $klucz => $wartosc)
				{
					if(is_array($wartosc)) $wartosc = serialize($wartosc);
					$konfiguracjaPliki[$nazwaModulu . '.' . $klucz] = $wartosc;
				}
			}
		}
		$mapperKonfiguracja = $this->dane()->WierszKonfiguracji();
		$tempBledy[0] = $tempBledy[1] = $tempBledy[2] = array();
		$bledneWpisy = array();
		$zamien = array('_Http' => '', '_Admin' => '');

		//Wykrywanie nie istniejacych konfiguracji
		//Wykrywanie takich samych wpisow wartosci w bazie i modulach
		foreach($mapperKonfiguracja->pobierzPelna() as $klucz => $obiekt)
		{
			//Porownujemy tylko konfiguracje z modulow
			if($obiekt->kodModulu == false) continue;

			$naprawione = false;
			$kodBledu = false;

			$klucz = $obiekt->kodModulu . '.' . $obiekt->nazwa;

			if( (! array_key_exists($klucz, $konfiguracjaPliki) && $wykonaj == 'naprawWszystko') || $id == $obiekt->id)
				if($obiekt->usun($mapperKonfiguracja)) $naprawione = true;

			if((isset($konfiguracjaPliki[$klucz]) && $konfiguracjaPliki[$klucz] ===  $obiekt->wartosc && $wykonaj == 'naprawWszystko') || $id == $obiekt->id)
				if($obiekt->usun($mapperKonfiguracja)) $naprawione = true;

			if($naprawione === true) continue;

			if( ! array_key_exists($klucz, $konfiguracjaPliki))
				$kodBledu = 0;
			elseif(isset($konfiguracjaPliki[$klucz]) && $konfiguracjaPliki[$klucz] ===  $obiekt->wartosc)
				$kodBledu = 1;

			$kodModulu = strtr($obiekt->kodModulu, $zamien);
			if($kodBledu !== false)
				$tempBledy[$kodBledu][] = array(
					'id' => $obiekt->id,
					'klucz' => $klucz,
					'typ' => (isset($moduly[$kodModulu])) ? $moduly[$kodModulu]['typ'] : '',
					'kod_modulu' => $obiekt->kodModulu,
					'id_kategorii' => $obiekt->idKategorii,
					'id_bloku' => $obiekt->idBloku,
					'wartosc' => htmlspecialchars($obiekt->wartosc),
					'blad' => $this->j->t['sprawdz.typy_bledow'][$kodBledu]);
		}

		if( ! (($wykonaj == 'usunDuplikaty' || $wykonaj == 'naprawWszystko') && $mapperKonfiguracja->usunZduplikowaneWpisy()))
		{
			//Wykrywanie zduplikowaych wpisow w bazie
			foreach($mapperKonfiguracja->pobierzZduplikowaneWpisy() as $klucz => $obiekt)
			{
				$klucz = $obiekt->kodModulu . '.' . $obiekt->nazwa;
				$kodModulu = strtr($obiekt->kodModulu, $zamien);
				$tempBledy[2][] = array(
					'id' => $obiekt->id,
					'klucz' => $klucz,
					'typ' => (isset($moduly[$kodModulu])) ? $moduly[$kodModulu]['typ'] : '',
					'kod_modulu' => $obiekt->kodModulu,
					'id_kategorii' => $obiekt->idKategorii,
					'id_bloku' => $obiekt->idBloku,
					'wartosc' => htmlspecialchars($obiekt->wartosc),
					'blad' => $this->j->t['sprawdz.typy_bledow'][2]);
			}
		}

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', null, null, true);
		$grid->dodajKolumne('klucz', $this->j->t['sprawdzKonfiguracje.etykieta_klucz']);
		$grid->dodajKolumne('id_kategorii', $this->j->t['sprawdzKonfiguracje.etykieta_id_kategorii']);
		$grid->dodajKolumne('id_bloku', $this->j->t['sprawdzKonfiguracje.etykieta_id_bloku']);
		$grid->dodajKolumne('wartosc', $this->j->t['sprawdzKonfiguracje.etykieta_wartosc']);
		$grid->dodajKolumne('blad', $this->j->t['sprawdzKonfiguracje.etykieta_blad']);

		$grid->dodajPrzyciski(
			Router::urlAdmin('Testy', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
			array(
				'napraw' =>array(
					'klucz' => 'napraw',
					'akcja' => Router::urlAdmin('Testy', 'sprawdzKonfiguracje', array('{KLUCZ}' => '{WARTOSC}')),
					'etykieta' => $this->j->t['sprawdzKonfiguracje.etykieta_napraw'],
					'ikona' => 'icon-wrench',
					'onclick' => 'return potwierdzenieUsun(\''.$this->j->t['sprawdzKonfiguracje.etykieta_potwierdz_napraw'].'\', $(this))',
				)
			)
		);

		$bledneWpisy = array_merge($tempBledy[0],$tempBledy[1],$tempBledy[2]);
		foreach($bledneWpisy as $wiersz)
		{
			$wiersz['wartosc'] = str_cut($wiersz['wartosc'], 100);

			if($wiersz['blad'] == $this->j->t['sprawdz.typy_bledow'][2])
				$grid->usunPrzyciski(array('napraw'));

			if($wiersz['id_kategorii'] != false)
			{
				$id = $wiersz['id_kategorii'];
				$akcja = 'edytujKategorie';
			}
			elseif($wiersz['id_bloku'] != false)
			{
				$id = $wiersz['id_bloku'];
				$akcja = 'edytujBlok';
			}

			if( ! ($wiersz['id_kategorii'] == false && $wiersz['id_bloku'] == false))
			{
				$klucz = explode('_', $wiersz['kod_modulu']);
				$wiersz['klucz'] = '<a href="' . Router::urlAdmin('KonfiguracjaSystemu', $akcja, array('id' => $id)) . '#' . $klucz[1] . '|' . $klucz[1] . str_replace('.', '_', str_replace($wiersz['kod_modulu'], '', $wiersz['klucz'])) . '">' . $wiersz['klucz'] . '</a>';
			}
			elseif($wiersz['kod_modulu'] != false)
			{
				$klucz = explode('_', $wiersz['kod_modulu']);
				$wiersz['klucz'] = '<a href="' . Router::urlAdmin('KonfiguracjaSystemu', ($klucz[1] = 'Http') ? 'edytujZwykly' : 'edytujAdministracyjny', array('kod' => $klucz[0])) .  '#' . $klucz[1] . '|' . $klucz[1] . str_replace('.', '_', str_replace($wiersz['kod_modulu'], '', $wiersz['klucz'])) . '">' . $wiersz['klucz'] . '</a>';
			}
			$grid->dodajWiersz($wiersz);
		}

		$dane = array(
			'tabela_danych' => $grid->html(),
			'link_napraw' => Router::urlAdmin('Testy', 'sprawdzKonfiguracje', array('wykonaj' => 'naprawWszystko')),
			'link_usun_duplikaty' => Router::urlAdmin('Testy', 'sprawdzKonfiguracje', array('wykonaj' => 'usunDuplikaty')),
		);

		$this->tresc .= $this->szablon->parsujBlok('sprawdz', $dane);
	}


	private function wezKonfiguracje()
	{
		$mapper = $this->dane()->WierszKonfiguracji();

		$konfiguracja = array();
		foreach ($mapper->zwracaTablice()->pobierzPelna() as $wiersz)
		{
			$konfiguracja[] = implode('|',array(
				$wiersz['kod_modulu'],
				$wiersz['id_kategorii'],
				$wiersz['id_bloku'],
				$wiersz['nazwa'],
				$wiersz['typ'],
				strtr($wiersz['wartosc'], array("\r\n" => '\r\n',"\n" => '\n')),
			));
		}
		sort($konfiguracja);
		$konfiguracja = implode("\n",$konfiguracja);
		return $konfiguracja;
	}


	private function formularzWyszukiwaniaLogi(TabelaDanych $grid)
	{
		$kryteria = array(
			'typ' => $this->pobierzParametr('typ', '', true, array('strval', 'strtolower')),
			'fraza' => $this->pobierzParametr('fraza', '', true, array('strval', 'strtolower')),
		);

		$obiektFormularza = new \Generic\Formularz\Log\Wyszukiwanie();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('logi'))
			->ustawObiekt($kryteria);

		$grid->naglowek($obiektFormularza->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

		$kryteria = array_merge($kryteria, $obiektFormularza->pobierzZmienioneWartosci());

		return $kryteria;
	}

	public function wykonajResetujDaneUzytkownikow()
	{
		if (strpos($_SERVER['SERVER_NAME'], 'supertraders.pl') === false)
		{
			$przedrostekNazwy = '[lh]';
			if (strpos($_SERVER['SERVER_NAME'], 'devel') !== false)
			{
				$przedrostekNazwy = '[dev]';
			}
			elseif (strpos($_SERVER['SERVER_NAME'], 'qa') !== false)
			{
				$przedrostekNazwy = '[qa]';
			}
			elseif (strpos($_SERVER['SERVER_NAME'], 'beta') !== false)
			{
				$przedrostekNazwy = '[beta]';
			}

			$mapperUzytkownicy = $this->dane()->Uzytkownik();
			$mapperWizytowki = $this->dane()->Wizytowka();
			$mapperKlienci = $this->dane()->Klient();

			Cms::inst()->Baza()->transakcjaStart();
			$wystapilBlad = false;

			$licznikLoginy = 0;
			$licznikTelefony = 0;
			$licznikKonfiguracja = 0;
			$licznikWiersze = 0;
			$licznikWiersze2 = 0;
			$licznikWiersze3 = 0;
			$licznikKlienci = 0;
			$licznikPrzedstawiciele = 0;
			$licznikUzytkownicySw = 0;

			foreach ($mapperUzytkownicy->pobierzWszystko() as $uzytkownik)
			{
				$wizytowka = $mapperWizytowki->pobierzPoIdUzytkownika($uzytkownik->id);
				$klient = $mapperKlienci->pobierzPoIdUzytkownika($uzytkownik->id);

				if ($wizytowka instanceof Wizytowka\Obiekt)
				{
					if (strpos($uzytkownik->email, '@supertraders.pl') > 0 || strpos($uzytkownik->email, '@m-media.pl') > 0)
					{
						//jeśli użytkownik posiada maila w domenie serwisu to nie zmieniamy danych
						continue;
					}

					$uzytkownik->login = 'user' . $wizytowka->id;
					$uzytkownik->ustawHaslo('haslo' . $wizytowka->id);
					$uzytkownik->email = $this->k->k['resetujDaneUzytkownikow.ustawiany_email'];
					$uzytkownik->kontaktTelefon = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];
					$uzytkownik->kontaktKomorka = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];
					$uzytkownik->kontaktFax = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];

					if ($uzytkownik->zapisz($mapperUzytkownicy))
					{
						++$licznikLoginy;
					}
					else
					{
						$wystapilBlad = true;
						break;
					}

					if ($klient instanceof Klient\Obiekt)
					{
						$klient->ksiegowyEmail = $this->k->k['resetujDaneUzytkownikow.ustawiany_email'];
						$klient->technicznyEmail = $this->k->k['resetujDaneUzytkownikow.ustawiany_email'];
						$klient->reprezentantEmail = $this->k->k['resetujDaneUzytkownikow.ustawiany_email'];

						$klient->ksiegowyTelefon = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];
						$klient->technicznyTelefon = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];
						$klient->reprezentantTelefon = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];

						if ($klient->zapisz($mapperKlienci))
						{
							++$licznikKlienci;
						}
						else
						{
							$wystapilBlad = true;
							break;
						}
					}

					$wizytowka->kontaktEmail = $this->k->k['resetujDaneUzytkownikow.ustawiany_email'];
					$wizytowka->kontaktTelefon = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];
					$wizytowka->kontaktKomorka = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];
					$wizytowka->kontaktFax = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];

					if ($wizytowka->zapisz($mapperWizytowki))
					{
						++$licznikTelefony;
					}
					else
					{
						$wystapilBlad = true;
						break;
					}
				}
			}
			//zresetowanie przedstawicieli handlowych

			$listaIdRol = array();
			foreach ($this->k->k['resetujDaneUzytkownikow.kod_roli_ph'] as $rolaKod)
			{
				$rola = $this->dane()->Rola()->pobierzPoKodzie($rolaKod);
				$listaIdRol[] = $rola->id;
			}


			$stareNoweLoginyPh = array();

			foreach ($mapperUzytkownicy->pobierzDlaRoli($listaIdRol) as $uzytkownik)
			{
				$nowyLogin = 'userph' . $uzytkownik->id;

				$stareNoweLoginyPh[strtoupper($uzytkownik->login)] = strtoupper($nowyLogin);

				$uzytkownik->login = $nowyLogin;
				$uzytkownik->ustawHaslo('haslo' . $uzytkownik->id);
				$uzytkownik->email = $this->k->k['resetujDaneUzytkownikow.ustawiany_email'];
				$uzytkownik->kontaktTelefon = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];
				$uzytkownik->kontaktKomorka = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];
				$uzytkownik->kontaktFax = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];

				if ($uzytkownik->zapisz($mapperUzytkownicy))
				{
					++$licznikPrzedstawiciele;
				}
				else
				{
					$wystapilBlad = true;
					break;
				}
			}

			// ustawienie na wizytówkach nowych kodów handlowca
			$listaWizytowek = $this->dane()->Wizytowka()->pobierzWszystko();

			foreach ($listaWizytowek as $wizytowka)
			{
				if (isset($stareNoweLoginyPh[strtoupper($wizytowka->kodHandlowca)]))
				{
					$wizytowka->kodHandlowca = $stareNoweLoginyPh[strtoupper($wizytowka->kodHandlowca)];
					if ( ! $wizytowka->zapisz($this->dane()->Wizytowka()))
					{
						$wystapilBlad = true;
						break;
					}

				}
			}

			$konfiguracjaDane = Cms::inst()->konfiguracjaDomyslna();

			$plikKonfiguracja = TEMP_KATALOG.'/config.inc.php';

			if (is_file($plikKonfiguracja) && is_readable($plikKonfiguracja))
			{
				$konfiguracjaPlik = include($plikKonfiguracja);
				$konfiguracjaTemp = $konfiguracjaDane;
				$konfiguracjaDane = array_replace_recursive($konfiguracjaTemp, $konfiguracjaPlik);
				unset($konfiguracjaTemp);
			}
			if (isset($konfiguracjaDane['superuzytkownik'])) unset($konfiguracjaDane['superuzytkownik']);
			if (isset($konfiguracjaDane['logi'])) unset($konfiguracjaDane['logi']);
			if (isset($konfiguracjaDane['bledy']['logowanie_plik_nazwa'])) unset($konfiguracjaDane['bledy']['logowanie_plik_nazwa']);


			$konfiguracjaDane['sms']['api_user'] = '';
            $konfiguracjaDane['sms']['api_pass'] = '';
            $konfiguracjaDane['email']['from_name'] = $przedrostekNazwy . 'SuperTraders';

			$dane = $konfiguracjaDane;

			$danePlik = array();
			foreach ($konfiguracjaDane as $blok => $wiersze)
			{
				foreach ($wiersze as $klucz => $wartosc)
				{
					$kluczPelny = $blok.'.'.$klucz;
					if ($kluczPelny == 'bledy.logowanie_plik_nazwa') continue;
					$danePlik[$blok][$klucz] = $konfiguracjaDane[$blok][$klucz];
				}
			}

			if (($licznikWiersze = $this->ustawNadawcowEmaili()) < 0)
			{
				$wystapilBlad = true;
			}

			if (($licznikWiersze2 = $this->ustawOdbiorcowEmaili()) < 0)
			{
				$wystapilBlad = true;
			}

			if (($licznikWiersze3 = $this->ustawOdbiorcowKontakt()) < 0)
			{
				$wystapilBlad = true;
			}

			if (($licznikUzytkownicySw = $this->resetujUzytkownicySw()) < 0)
			{
				$wystapilBlad = true;
			}

			if ( ! $wystapilBlad)
			{
				if (file_put_contents($plikKonfiguracja, "<?php
namespace Generic\Modul\Testy;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Katalog;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\Mapper;
use Generic\Model\Wizytowka;
use Generic\Model\Ogloszenie;
use Generic\Model\Klient;
use Generic\Model\WierszKonfiguracji;
 return ".var_export($danePlik,true).";\n"))
				{
					++$licznikKonfiguracja;
				}
			}

			if ($wystapilBlad)
			{
				Cms::inst()->Baza()->transakcjaCofnij();
				$this->komunikat($this->j->t['resetujDaneUzytkownikow.komunikat_blad'], 'error', 'sesja');
			}
			else
			{
				Cms::inst()->Baza()->transakcjaPotwierdz();
				$this->komunikat(
					str_replace(
						array('{{ILE_LOGINOW}}', '{{ILE_TELEFONOW}}', '{{CZY_SMSAPI}}', '{{ILE_WIERSZE}}', '{{ILE_WIERSZE2}}', '{{ILE_WIERSZE3}}', '{{ILE_KLIENCI}}', '{{ILE_PRZEDSTAWICIELE}}', '{{ILE_UZYTKOWNICY_SW}}'),
						array($licznikLoginy, $licznikTelefony, ($licznikKonfiguracja > 0 ? $this->j->t['resetujDaneUzytkownikow.komunikat_wykonano_SMSTAK'] : $this->j->t['resetujDaneUzytkownikow.komunikat_wykonano_SMSNIE']), $licznikWiersze, $licznikWiersze2, $licznikWiersze3, $licznikKlienci, $licznikPrzedstawiciele, $licznikUzytkownicySw),
						$this->j->t['resetujDaneUzytkownikow.komunikat_wykonano']),
					'info', 'sesja'
					);
				if ($this->k->k['resetujDaneUzytkownikow.raport_wyslij'])
				{
					$this->wyslijRaportResetowaniaDanych($licznikLoginy, $licznikTelefony, ($licznikKonfiguracja > 0 ? $this->j->t['resetujDaneUzytkownikow.komunikat_wykonano_SMSTAK'] : $this->j->t['resetujDaneUzytkownikow.komunikat_wykonano_SMSNIE']), $licznikWiersze, $licznikKlienci, $licznikPrzedstawiciele, $licznikUzytkownicySw, $licznikWiersze2, $licznikWiersze3);
				}
			}


		}

		Router::przekierujDo(Router::urlAdmin('Testy', 'index'));
	}



	protected function wyslijRaportResetowaniaDanych($licznikLoginy, $licznikTelefony, $zmienionaKonfiguracja, $licznikWiersze, $licznikKlienci, $licznikPrzedstawiciele, $licznikUzytkownicySw, $licznikWiersze2, $licznikWiersze3)
	{
		$dane = array(
			'ileLoginow' => $licznikLoginy,
			'ileTelefonow' => $licznikTelefony,
			'czySMSApi' => $zmienionaKonfiguracja,
			'ileWiersze' => $licznikWiersze,
			'ileWiersze2' => $licznikWiersze2,
			'ileWiersze3' => $licznikWiersze3,
			'data' => date('d.m.Y H:i:s'),
			'nazwaSerwera' => $_SERVER['SERVER_NAME'],
			'ileKlienci' => $licznikKlienci,
			'ilePrzedstawiciele' => $licznikPrzedstawiciele,
			'ileUzytkownicySw' => $licznikUzytkownicySw,
		);
		$poczta = new Pomocnik\Poczta($this->k->k['resetujDaneUzytkownikow.id_formatki_email'], $dane);
		$poczta->wyslij();
	}


	/*
	 * Metoda ustawia nadawców dla wszystkich odnalezionych emaili wysylanych z serwisu
	 * Zwraca int -1 jeśli błąd lub int LICZBA jeśli poprawnie, gdzie LICZBA == ilość zmodyfikowanych wierszy
	 */
	protected function ustawNadawcowEmaili()
	{
		$wystapilBlad = false;
		$zmienionychWierszy = 0;

		$pliki = $this->znajdzModuly('*.php', 0, CMS_KATALOG.'/moduly/');

		$mapperKategorie = $this->dane()->Kategoria();
		$mapperBloki = $this->dane()->Blok();

		//ładuję kolejno wszystkie moduły
		foreach ( $pliki as $sciezka)
		{
			$sciezka2 = explode('/', $sciezka);

			$nazwa = $sciezka2[count($sciezka2) - 2];
			$usluga = str_replace('.php', '', $sciezka2[count($sciezka2) - 1]);
			$nazwaModulu = 'Generic\\Modul\\' . $nazwa . '\\' . $usluga;

			if ($nazwaModulu == 'Generic\Modul\Http\\Widoki')
			{
				continue;
			}
			if ( ! class_exists($nazwaModulu))
			{
				continue;
			}

			$modul = new $nazwaModulu();

			//wczytuję konfiguracje modulu
			$konfiguracjaModulu = $modul->pobierzKonfiguracje();

			foreach ($konfiguracjaModulu as $wierszKonfiguracji => $wartoscWiersza)
			{
				//jesli wystepuje ustawienie zawierajace fraze 'nazwa_nadawcy'
				if (strpos($wierszKonfiguracji, 'nazwa_nadawcy') !== false)
				{
					//sprawdzam czy dany modul wystepuje w tabeli kategorie
					foreach ($mapperKategorie->pobierzDlaModulu($nazwa) as $kategoria)
					{
						//zapisuje wiersz konfiguracji dla kategorii
						if ($this->zapiszWierszKonfiguracji($wierszKonfiguracji, '', $nazwa, $usluga, $kategoria->id))
						{
							$wystapilBlad = true;
							break;
						}
						++$zmienionychWierszy;
					}
					//sprawdzam czy dany modul wystepuj w tabeli bloki
					foreach ($mapperBloki->pobierzDlaModulu($nazwa) as $blok)
					{
						//zapisuje wiersz konfiguracji dla bloku
						if ($this->zapiszWierszKonfiguracji($wierszKonfiguracji, '', $nazwa, $usluga, null, $blok->id))
						{
							$wystapilBlad = true;
							break;
						}
						++$zmienionychWierszy;
					}

					//zapisuje wiersz konfiguracji dla modulu
					if ($this->zapiszWierszKonfiguracji($wierszKonfiguracji, '', $nazwa, $usluga))
					{
						$wystapilBlad = true;
						break;
					}
					++$zmienionychWierszy;
				}
			}

			if ($wystapilBlad)
			{
				break;
			}
		}

		return $wystapilBlad ? -1 : $zmienionychWierszy;
	}

	/*
	 * Resetuje dane tematów formularza kontaktowego
	 */

	protected function ustawOdbiorcowKontakt()
	{
		$wystapilBlad = false;
		$zmienionychWierszy = 0;

		foreach($this->dane()->FormularzKontaktowyTemat()->pobierzWszystko() as $temat)
		{
			$temat->email = serialize(array(serialize(array($this->k->k['resetujDaneUzytkownikow.ustawiany_email_odbiorcy']))));
			$temat->emailDw = serialize(array());
			if ( ! $temat->zapisz($this->dane()->FormularzKontaktowyTemat()))
			{
				return -1;
			}
			++$zmienionychWierszy;
		}
		return $wystapilBlad ? -1 : $zmienionychWierszy;
	}

	/*
	 * Metoda ustawia odbiorców dla wszystkich odnalezionych emaili wysylanych z serwisu
	 * Zwraca int -1 jeśli błąd lub int LICZBA jeśli poprawnie, gdzie LICZBA == ilość zmodyfikowanych wierszy
	 */
	protected function ustawOdbiorcowEmaili()
	{
		$wystapilBlad = false;
		$zmienionychWierszy = 0;

		$pliki = $this->znajdzModuly('*.php', 0, CMS_KATALOG.'/moduly/');

		$mapperKategorie = $this->dane()->Kategoria();
		$mapperBloki = $this->dane()->Blok();

		//ładuję kolejno wszystkie moduły
		foreach ( $pliki as $sciezka)
		{
			$sciezka2 = explode('/', $sciezka);

			$nazwa = $sciezka2[count($sciezka2) - 2];
			$usluga = str_replace('.php', '', $sciezka2[count($sciezka2) - 1]);
			$nazwaModulu = 'Generic\\Modul\\' . $nazwa . '\\' . $usluga;

			if ($nazwaModulu == 'Generic\Modul\Http\\Widoki')
			{
				continue;
			}
			if ( ! class_exists($nazwaModulu))
			{
				continue;
			}

			$modul = new $nazwaModulu();

			//wczytuję konfiguracje modulu
			$konfiguracjaModulu = $modul->pobierzKonfiguracje();
			$opisyKonfiguracji = $modul->pobierzOpisKonfiguracji();

			foreach ($konfiguracjaModulu as $wierszKonfiguracji => $wartoscWiersza)
			{
				//jesli wystepuje ustawienie jest na liście maili
				if (in_array($wierszKonfiguracji, $this->k->k['resetujDaneUzytkownikow.konfiguracje_email_odbiorcy']))
				{
					//sprawdzam czy dany modul wystepuje w tabeli kategorie
					foreach ($mapperKategorie->pobierzDlaModulu($nazwa) as $kategoria)
					{
						//zapisuje wiersz konfiguracji dla kategorii
						if ($this->zapiszWierszKonfiguracji($wierszKonfiguracji, ($opisyKonfiguracji[$wierszKonfiguracji]['typ'] == 'list' || $opisyKonfiguracji[$wierszKonfiguracji]['typ'] == 'array') ? serialize(array($this->k->k['resetujDaneUzytkownikow.ustawiany_email_odbiorcy'])) : $this->k->k['resetujDaneUzytkownikow.ustawiany_email_odbiorcy'], $nazwa, $usluga, $kategoria->id, null, ($opisyKonfiguracji[$wierszKonfiguracji]['typ'] == 'list' || $opisyKonfiguracji[$wierszKonfiguracji]['typ'] == 'array') ? 'array' : null))
						{
							$wystapilBlad = true;
							break;
						}
						++$zmienionychWierszy;
					}
					//sprawdzam czy dany modul wystepuj w tabeli bloki
					foreach ($mapperBloki->pobierzDlaModulu($nazwa) as $blok)
					{
						//zapisuje wiersz konfiguracji dla bloku
						if ($this->zapiszWierszKonfiguracji($wierszKonfiguracji, ($opisyKonfiguracji[$wierszKonfiguracji]['typ'] == 'list' || $opisyKonfiguracji[$wierszKonfiguracji]['typ'] == 'array') ? serialize(array($this->k->k['resetujDaneUzytkownikow.ustawiany_email_odbiorcy'])) : $this->k->k['resetujDaneUzytkownikow.ustawiany_email_odbiorcy'], $nazwa, $usluga, null, $blok->id, $opisyKonfiguracji[$wierszKonfiguracji]['typ']))
						{
							$wystapilBlad = true;
							break;
						}
						++$zmienionychWierszy;
					}

					//zapisuje wiersz konfiguracji dla modulu
					if ($this->zapiszWierszKonfiguracji($wierszKonfiguracji, ($opisyKonfiguracji[$wierszKonfiguracji]['typ'] == 'list' || $opisyKonfiguracji[$wierszKonfiguracji]['typ'] == 'array') ? serialize(array($this->k->k['resetujDaneUzytkownikow.ustawiany_email_odbiorcy'])) : $this->k->k['resetujDaneUzytkownikow.ustawiany_email_odbiorcy'], $nazwa, $usluga, null, null, ($opisyKonfiguracji[$wierszKonfiguracji]['typ'] == 'list' || $opisyKonfiguracji[$wierszKonfiguracji]['typ'] == 'array') ? 'array' : null))
					{
						$wystapilBlad = true;
						break;
					}
					++$zmienionychWierszy;
				}
			}

			if ($wystapilBlad)
			{
				break;
			}
		}

		return $wystapilBlad ? -1 : $zmienionychWierszy;
	}

	/*
	 * Resetuje dane użytkowników superwebsite
	 */

	protected function resetujUzytkownicySw()
	{
		$wystapilBlad = false;
		$zmienionychWierszy = 0;

		foreach ($this->dane()->UzytkownikSuperwebsite()->szukaj(array()) as $uzytkownikSw)
		{
			$uzytkownikSw->email = $this->k->k['resetujDaneUzytkownikow.ustawiany_email'];
			$uzytkownikSw->reprezentantEmail = $this->k->k['resetujDaneUzytkownikow.ustawiany_email'];
			$uzytkownikSw->technicznyEmail = $this->k->k['resetujDaneUzytkownikow.ustawiany_email'];
			$uzytkownikSw->ksiegowyEmail = $this->k->k['resetujDaneUzytkownikow.ustawiany_email'];
			$uzytkownikSw->reprezentantTelefon = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];
			$uzytkownikSw->technicznyTelefon = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];
			$uzytkownikSw->ksiegowyTelefon = $this->k->k['resetujDaneUzytkownikow.ustawiany_telefon'];

			if ($uzytkownikSw->zapisz($this->dane()->UzytkownikSuperwebsite()))
			{
				++$zmienionychWierszy;
			}
			else
			{
				$wystapilBlad = true;
				break;
			}
		}

		return $wystapilBlad ? -1 : $zmienionychWierszy;
	}



	private function zapiszWierszKonfiguracji($wiersz, $wartosc, $kodModulu, $usluga, $idKategorii = null, $idBloku = null, $typ = null)
	{
		$mapperKonfiguracja = $this->dane()->WierszKonfiguracji();

		$wierszZBazy = $mapperKonfiguracja->pobierzWierszDlaModulu($wiersz, $kodModulu.'_'.$usluga, $idKategorii, $idBloku);

		if ( ! ($wierszZBazy instanceof WierszKonfiguracji\Obiekt))
		{
			$wierszZBazy = new WierszKonfiguracji\Obiekt;
			$wierszZBazy->idProjektu = ID_PROJEKTU;
			$wierszZBazy->kodJezyka = KOD_JEZYKA;
			$wierszZBazy->typ = $typ != null ? $typ : gettype($wartosc);
			$wierszZBazy->nazwa = $wiersz;
			$wierszZBazy->idKategorii = $idKategorii;
			$wierszZBazy->idBloku = $idBloku;
			$wierszZBazy->kodModulu = $kodModulu.'_'.$usluga;
		}

		$wierszZBazy->wartosc = $wartosc;

		return ! $wierszZBazy->zapisz($mapperKonfiguracja);

	}



	private function znajdzModuly($pattern='*', $flags = 0, $path = '')
	{
		$paths = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
		$files = glob($path.$pattern, $flags);
		foreach ($paths as $path) {
			$files = array_merge($files, $this->znajdzModuly($pattern, $flags, $path));
		}
		return $files;
	}
	
	
	public function wykonajListaWspolpracownikow()
	{
		$dataOd = Zadanie::pobierz('data_od', 'strval', 'filtr_xss');
		$idUzytkownika = Zadanie::pobierz('id_user', 'intval', 'abs');
		
		$kryteria = array(
			'pracownik' => $idUzytkownika,
			'data_od' => $dataOd,
			'type' => 'orders',
		);
		
		$logowaniaTimeListy = $this->dane()->Timelist()->zwracaTablice()->szukaj($kryteria, null, new \Generic\Model\Timelist\Sorter('data_start', 'ASC'));
		$teamy = $this->dane()->Team()->zwracaTablice()->pobierzWszystko();
		$pracownicy = listaZTablicy($this->dane()->Uzytkownik()->zwracaTablice()->pobierzWszystko(), 'id');
		$dni = array();
		$echo = '';
		foreach ($logowaniaTimeListy as $k => $logowanie)
		{
			$dni[substr($logowanie['data_start'], 0, 10)] = array(
				'team' => $teamy[$logowanie['id_team']]['team_number'],
				'id_team' => $logowanie['id_team'],
				'data' => $logowanie['data_start'],
			);
		}
		
		foreach ($dni as $data => $team)
		{
			$echo .= $data.' '.$team['team'].': ';
			$wspolpracownicy = $this->dane()->Timelist()->zwracaTablice()->szukaj(array(
				'id_team' => $team['id_team'],
				'data_start_rowna' => $team['data'],
				//'nie_pracownik' => $idUzytkownika,
			));
			foreach ($wspolpracownicy as $wspolpracownik)
			{
				$echo .= $pracownicy[$wspolpracownik['id_user']]['imie'].' '.$pracownicy[$wspolpracownik['id_user']]['nazwisko'].', ';
			}
			$echo .='<br/>';
		}
		dump($echo);
	}
	
	public function wykonajAktualizujProduktyZakupione()
	{
		$chargeTypes = array(
			'1' => 'by products',
			'2' => 'price per hour',
			'24' => 'price per hour',
			
		);
		$workStatuses = array(
			'1' => array('done', 'not done'),
			'2' => array('done'),
			'24' => array('done', 'not done'),
			'26' => array('done', 'not done'),
		);
		
		$idTypes = array(
			'26' => array('26', '27', '28', '29'),
		);
		$idType = Zadanie::pobierz('idType', 'intval', 'abs');
		
		if (isset($workStatuses[$idType]))
		{
			$statusWork = $workStatuses[$idType];
		}
		else
		{
			$statusWork = array('done', 'not done');
		}
		
		if (isset($idTypes[$idType]))
		{
			$idType = $idTypes[$idType];
		}
		else
		{
			$chargeType = $chargeTypes[$idType];
		}
		
		$kryteria = array(
			'id_types' => $idType,
			'wyslano_do_raportu' => false,
			'status_work' => $statusWork,
			'status' => array('closed'),
			'data_zakonczenia_do' => date("Y-m-d", time()),
		);
		if (isset($chargeTypes[$idType]))
		{
			$kryteria['charge_type'] = $chargeTypes[$idType];
		}
		
		$zamowienia = listaZTablicy($this->dane()->Zamowienie()->zwracaTablice(array('id'))->szukaj($kryteria, null, new \Generic\Model\Zamowienie\Sorter('data_zakonczenia', 'ASC')), 'id');
		$idsZamowien = array_keys($zamowienia);
		
		if (count($idsZamowien) > 0)
		{
		
			$produkty = listaZTablicy($this->dane()->Produkt()->zwracaTablice()->szukaj(array('import' => false, 'ukryty' => true, 'visible_in_order' => $idType)), 'id');

			$zakupioneMapper = $this->dane()->ProduktyZakupione();
			$produktyZakupione = $zakupioneMapper->szukajTylkoZakupione(array(
				'id_order' => $idsZamowien,
				'id_product' => listaZTablicy($produkty, null, 'id'),
				'confirmation_status' => array('confirmed', 'not confirmed'),
			), null, new \Generic\Model\ProduktyZakupione\Sorter('id_order', 'ASC'));

			$zamowieniaZakupione = array();
			$tablicaZamowienNieDoliczacWizyty = array();
			$kodyProduktyPomijaneWizyty = array(
				'nd_kunde_har_ringt_til_get_og_kanselert_avtale',
				'nd_vi_kom_for_sent_til_kunde',
				'oppmote',
			);

			/* @var $produktZakupiony \Generic\Model\ProduktyZakupione\Obiekt[] */
			foreach ($produktyZakupione as $produktZakupiony)
			{
				$zamowieniaZakupione[$produktZakupiony->idOrder][] = $produktZakupiony;
				if (in_array($produkty[$produktZakupiony->idProduct]['code'], $kodyProduktyPomijaneWizyty))
				{
					$tablicaZamowienNieDoliczacWizyty[$produktZakupiony->idOrder] = $produktZakupiony->idOrder;
				}
			}
			unset($produktyZakupione);
			$sumaStara = 0;
			$sumaNowa = 0;

			$produktWizyta = (isset($produkty[159])) ? $produkty[159] : null;
			$cms = Cms::inst();

			$cms->Baza()->transakcjaStart();

			$error = 0;
			foreach ($idsZamowien as $idZamowienia)
			{
				$sumaStaraZamowienia = 0;
				$sumaNowaZamowienia = 0;
				/* @var $produktZamowienia \Generic\Model\ProduktyZakupione\Obiekt[] */
				foreach ($zamowieniaZakupione[$idZamowienia] as $produktZamowienia)
				{
					$wynikDodaniawizyty = '';
					if (isset($produkty[$produktZamowienia->idProduct]))
					{
						$sumaStara += $produktZamowienia->nettoPrice;
						$sumaStaraZamowienia += $produktZamowienia->nettoPrice;
						$produkt = $produkty[$produktZamowienia->idProduct];
						$produktZamowienia->nettoPrice = $produkt['netto_price'] * $produktZamowienia->quantity;

						$sumaNowa += $produktZamowienia->nettoPrice;
						$sumaNowaZamowienia += $produktZamowienia->nettoPrice;

						$produktZamowienia->bruttoPrice = ($produkt['netto_price'] + ($produkt['netto_price'] * $produkt['vat']/100)) * $produktZamowienia->quantity;

						if ($produktZamowienia->zapisz($zakupioneMapper))
							$wynik = '... Saved succesfully';
						else
						{
							$wynik = '!!! ERROR SAVING !!!';
							$error++;
						}
					}
				}
				// Dodajemy produkt wizyty
				if ($produktWizyta !== null && !array_key_exists($idZamowienia, $tablicaZamowienNieDoliczacWizyty))
				{
					$wynikDodaniawizyty = '  !!! Error adding OPPMØTE !!! ';
					$produkZakupionyWizyta = new \Generic\Model\ProduktyZakupione\Obiekt();
					$produkZakupionyWizyta->idProjektu = 1;
					$produkZakupionyWizyta->idOrder = $idZamowienia;
					$produkZakupionyWizyta->confirmationStatus = 'not confirmed';
					$produkZakupionyWizyta->description = $produktWizyta['name'];
					$produkZakupionyWizyta->dataAdded = $zamowienia[$idZamowienia]['data_zakonczenia'];
					$produkZakupionyWizyta->idProduct = $produktWizyta['id'];
					$produkZakupionyWizyta->nettoPrice = $produktWizyta['netto_price'];
					$produkZakupionyWizyta->bruttoPrice = $produktWizyta['netto_price'] + ($produktWizyta['netto_price'] * $produktWizyta['vat']/100);
					$produkZakupionyWizyta->quantity = 1;
					if ($produkZakupionyWizyta->zapisz($zakupioneMapper))
					{
						$sumaNowa += $produkZakupionyWizyta->nettoPrice;
						$sumaNowaZamowienia += $produkZakupionyWizyta->nettoPrice;
						$wynikDodaniawizyty = 'OPPMØTE added';
					}
					else
					{
						$error++;
					}
				}
				$this->tresc .= 'WO: '.$zamowienia[$idZamowienia]['number_order_get'].', BKT ID:'.$idZamowienia.' Old price = '.$sumaStaraZamowienia.'; New price = '.$sumaNowaZamowienia.' Result: '. (($sumaNowaZamowienia >= $sumaStaraZamowienia) ?  '+++ more +++ ' : ' !!! LESS !!! ');
				$this->tresc .= $wynikDodaniawizyty.$wynik.'<br/>';
			}

			$znak = (($sumaNowa - $sumaStara) >= 0) ? '+' : '-';
			$procent = \round((($sumaNowa/$sumaStara)-1) * 100, 2);
			$this->tresc .= '<br/><br/>========================================================================================================================================================<br/>';
			$this->tresc .= 'Update finished '.(($error > 0) ? 'with '.$error.' errors! ': 'with no errors ').'<br/>Update total price difference is: ('.$znak.$procent.'%); KR '.  number_format(($sumaNowa - $sumaStara), 0, ',', ' ').',-; Old price: KR '.number_format($sumaStara, 0, ',', ' ').',-; New updated total price is: KR '.number_format($sumaNowa, 0, ',', ' ').',-';
			$cms->Baza()->transakcjaPotwierdz();
		}
		else
		{
			$this->komunikat('No orders to be updated here ... Script was terminated.', 'info');
		}
	}
}