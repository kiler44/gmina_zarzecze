<?php
namespace Generic\Modul\Reports;
use Generic\Biblioteka;
use Generic\Model\Reports;
use Generic\Model\RaportyExcelDane;
use Generic\Model\RaportyNadgodziny;
use Generic\Model\Zamowienie;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Model\RaportEdytowalny;
use Generic\Biblioteka\Pomocnik\Poczta;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Pomocnik\Faktura as PomocnikFaktura;
use Generic\Model\ZamowieniaTemp;


/**
 * Moduł raportow standardowych i specjalnych BKT
 *
 * @author Łukasz Wrucha 
 * @package moduly
 */
class Admin extends Modul\Admin
{
	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajRaportyPdf',
		'wykonajRaportyExcel',
		'wykonajDelete',
		'wykonajRevert',
		'wykonajTrash',
		'wykonajTest',
		'wykonajWyslijRaportMailem',
		// Uprawnienia z modulu istniejacego
		'wykonajIndexZarzadzanie',
		'wykonajEdytujZarzadzanie',
		'wykonajDodajZarzadzanie',
		'wykonajUsunZarzadzanie',
		'wykonajKasujCacheZarzadzanie',
		// Uprawnienia z modulu istniejacego HTTP
		'wykonajListaRaportowKlient',
		'wykonajPodgladKlient',
		'wykonajDoCsvKlient',
		'wykonajWykresKlient',
		'wszystkieRaportyKlient',
		'wykonajFiltryPoczatkoweKlient',
		'wykonajZapiszNadgodziny',
		'wykonajZapiszDzien',
		'wykonajEdytujDzien',
		'wykonajDownloadExcel',
		'wykonajUsunPracownika',
		'wykonajRaportyVillaProdukt',
		'wykonajZapiszProblem',
		'wykonajUsunProblem',
		'wykonajAktualizujJazda'
	);
	
	protected $akcjeAjax = array(
		'wykonajZapiszNadgodziny',
		'wykonajZapiszDzien',
		'wykonajEdytujDzien',
		'wykonajDownloadExcel',
		'wykonajUsunPracownika',
		'wykonajZapiszProblem',
		'wykonajUsunProblem'
	);
	
	protected $zdarzenia = array(
		
	);

	/**
	 * @var \Generic\Konfiguracja\Modul\Reports\Admin
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Reports\Admin
	 */
	protected $j;
	
	
	protected $aktualnaData;
	protected $plikCache;
	protected $czasCache = '';
	
	public function wykonajIndex()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['indexKlient.tytul_strony'],
			'tytul_modulu' => $this->j->t['indexKlient.tytul_modulu'],
		));
		
		$this->dodajMenuKontekstowe(array(
			'zarzadzanie_raportami' => array(
				 'url' => Router::urlAdmin($this->kategoria, 'indexZarzadzanie'),
				 'ikona' => 'icon-cog',
			),
		));

		$this->wyswietlMenuKontekstowe();

		$raporty = array();
		if ($this->moznaWykonacAkcje('wszystkieRaportyKlient'))
		{
			$raporty = $this->dane()->RaportEdytowalny()->zwracaTablice('id', 'nazwa', 'opis', 'grupa')->szukaj(array());
		}
		else
		{
			$raporty = $this->dane()->RaportEdytowalny()->zwracaTablice('id', 'nazwa', 'opis', 'grupa')->pobierzPoIdUzytkownika(Cms::inst()->profil()->id);
		}
		
		$listaRaportow = array();

		if (count($raporty) == 0)
		{
			$this->komunikat($this->j->t['listaRaportowKlient.komunikat.brak_raportow'], 'info');
		}
		else
		{
			foreach ($raporty as $raport)
			{
				if ( !isset ($listaRaportow[$raport['grupa']]))
				{
					$listaRaportow[$raport['grupa']] = array();
				}

				$listaRaportow[$raport['grupa']][] = $raport;
			}
		}

		unset($raporty);

		$jestPierwszy = true;
		foreach ($listaRaportow as $klucz => $raporty)
		{
			
			$this->szablon->ustawBlok('lista/zakladka', array(
				'etykieta' => $this->k->k['grupy_raportow'][$klucz],
				'id_raportu' => intval($klucz),
				'klasa' => $jestPierwszy ? 'active' : '',
			));

			$this->szablon->ustawBlok('lista/grupa', array(
				'tabela' => $this->wygenereujTabeleDanych($raporty, intval($klucz)),
				'klasa' => $jestPierwszy ? '' : 'hidden',
				'id_raportu' => intval($klucz),
			));

			$jestPierwszy = false;
		}

		$raportyPdf = false;
		if (Cms::inst()->profil()->maUprawnieniaDo('Admin_'.$this->kategoria->id.'_wykonajRaportyPdf'))
		{
			$raportyPdf = Router::urlAdmin($this->kategoria, 'raportyPdf');
		}
		
		$raportyExcel = false;
		if (Cms::inst()->profil()->maUprawnieniaDo('Admin_'.$this->kategoria->id.'_wykonajRaportyExcel'))
		{
			$raportyExcel = Router::urlAdmin($this->kategoria, 'raportyExcel');
		}
		$raportyVilla = false;
		if (Cms::inst()->profil()->maUprawnieniaDo('Admin_'.$this->kategoria->id.'_wykonajRaportyVillaProdukt'))
		{
			$raportyVilla = Router::urlAdmin($this->kategoria, 'raportyVillaProdukt');
		}

		$dane = array(
			'etykieta_raportyPdf' => $this->j->t['index.etykieta_raportyPdf'],
			'raportyPdfUrl' => $raportyPdf,
			'etykieta_raportyExcel' => $this->j->t['index.etykieta_raportyExcel'],
			'raportyExcelUrl' => $raportyExcel,
			'raportyVillaProdukt' => $raportyVilla
		);

		$this->tresc .= $this->szablon->parsujBlok('lista', $dane);
	}
	public function wykonajAktualizujJazda()
	{
		$mapperZamowiniaTemp = new ZamowieniaTemp\Mapper();
		$trasaMapper = new RaportyExcelDane\Mapper();
		$zamowienia = $mapperZamowiniaTemp->zwracaTablice()->pobierzWszystko(false, null, null, false);
		foreach($zamowienia as $zamowienie)
		{
			$trasa = $trasaMapper->pobierzPoIdOrder($zamowienie['bkt_id']);
				

			$zamowienieTemp = $mapperZamowiniaTemp->pobierzPoBktId($zamowienie['bkt_id']);
			if($zamowienieTemp instanceof ZamowieniaTemp\Obiekt)
			{
				if($trasa instanceof RaportyExcelDane\Obiekt && $zamowienieTemp->fromAddress == '' )
				{
					$zamowienieTemp->fromAddress = $trasa->fromAddress;
					$zamowienieTemp->toAddress = $trasa->toAddress;
					$zamowienieTemp->km = $trasa->kilometry;
					$zamowienieTemp->czas = $trasa->minutyJazdy;
					$zamowienieTemp->czasTrafic = $trasa->minutyJazdyTraffik;

				}
				$zamowienieTemp->zapisz($mapperZamowiniaTemp);
			}
		}
		
	}
	public function wykonajRaportyVillaProdukt()
	{
		$cms = Cms::inst();
		$aktualizujTabele = Zadanie::pobierz('aktualizuj');
		$aktualizujNotatke =  Zadanie::pobierz('aktualizujNotatke');
		$resetujFormularz =  Zadanie::pobierz('resetuj');
		$pokazWszystkieZamowienia = Zadanie::pobierz('pokazWszystkie');
		$trasaMapper = new RaportyExcelDane\Mapper();
		
		if($pokazWszystkieZamowienia != null)
			$cms->sesja->pokazWszystkieZamowienia = $pokazWszystkieZamowienia;
		if(!isset($cms->sesja->produktMain))
			$cms->sesja->produktMain = 0;
		
		$naStronie = $this->pobierzParametr('naStronie',  $this->k->k['villaRaport.pager_konfiguracja']['zakres'], true, array('intval','abs'));
		$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			
		$akcja = Router::urlAdmin($this->kategoria, 'raportyVillaProdukt', array('nrStrony' => $nrStrony , 'naStronie' => $naStronie ));
		
		$formFilter = new Biblioteka\Formularz($akcja, 'formFilter');
		$listaProduktow = array(
			0 => 'All',
			498 => 'Inst. Villaprosjekt',
			464 => 'Tilkoblingshjelp',
			504 => 'Inst. Blokk stjerne'
		);
		
		$formFilter->input(new Input\Radio('produktMain', array('lista' => $listaProduktow, 'wartosc' => $cms->sesja->produktMain)));
		$formFilter->input(new Input\Submit('filtruj', array('wartosc' => 'search', 'etykieta' => 'Search')));
		
		if ($formFilter->wypelniony())
		{
			if ($formFilter->danePoprawne())
			{
				$wartosciFilter = $formFilter->pobierzWartosci();
				$cms->sesja->produktMain = $wartosciFilter['produktMain'];
			}
		}
		
		
		$form = new Biblioteka\Formularz($akcja, 'formularzPrzelicz');
		
		// 463 - opstart
		// 498 - villa installa
		// 503 - inst kontakt
		// 464 - tilkoblingshjelp
		if($resetujFormularz)
		{
			unset($cms->sesja->noweCzasyProduktu);
			unset($cms->sesja->dodajDoProduktu);
		}
			
		$wartoscV = (isset($cms->sesja->noweCzasyProduktu[498])) ? $cms->sesja->noweCzasyProduktu[498] : 2.5;
		$form->input(new Input\Text('498', array('wartosc' => $wartoscV ), 'Inst. Villaprosjekt'));
		
		$wartoscK = (isset($cms->sesja->noweCzasyProduktu[503])) ? $cms->sesja->noweCzasyProduktu[503] : 1.25;
		$form->input(new Input\Text('503', array('wartosc' => $wartoscK, ), 'Inst. kontakt'));
		
		$wartoscO = (isset($cms->sesja->noweCzasyProduktu[463])) ? $cms->sesja->noweCzasyProduktu[463] : 0.5;
		$form->input(new Input\Text('463', array('wartosc' => $wartoscO, ), 'Oppstart'));
		
		$wartoscT = (isset($cms->sesja->noweCzasyProduktu[464])) ? $cms->sesja->noweCzasyProduktu[464] : 0.5;
		$form->input(new Input\Text('464', array('wartosc' => $wartoscT ), 'Tilkoblingshjelp'));
		
		$form->input(new Input\Submit('count', array('wartosc' => 'Count', 'etykieta' => 'Count')));
		
		$dodajDoProduktu = array();
		$formularzAktywny = 0;
		$noweCzasyProduktu = array();
		
		if ($form->wypelniony())
		{
			if ($form->danePoprawne())
			{
				$formularzAktywny = 1;
				$wartosci = $form->pobierzWartosci();
				foreach($wartosci as $idProd => $wartosc)
				{
					$produkt = $this->dane()->Produkt()->pobierzPoId($idProd);
					$czas = $produkt->nettoPrice/612;
					
					$dodajDoProduktu[$idProd] = $wartosc - $czas;
					$noweCzasyProduktu[$idProd] = $wartosc;
					
					$cms->sesja->dodajDoProduktu[$idProd] = $wartosc - $czas;
					$cms->sesja->noweCzasyProduktu[$idProd] = $wartosc;
					
				}
			}
		}
		
		$form->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzFiltrDat'));
		
		
		$frazy = array(
			'customer_problem' => array(
				'/probleme med kunde/', '/diffucult custom/', '/old custom/', '/visible cable/', '/gammel/'
			),
			'driving' => array(
				'/long way/', '/drive/', '/trafikk/', '/trafic/', '/lang tur/', '/kjor/', '/kjør/', '/kjoring/', '/kjøring/', '/traffik/', '/trafik/', '/traffic/', '/lang vei/', '/parkering/', '/vei til/'
			),
			'installasjon_problem' => array(
				'/difficult installation/', '/stor jobb/', '/vanskelig/', '/problem med aktive/', '/problem med modem/', '/problem aktive/', '/difficult job/' , '/get teknike/', '/erik/'
			),
			'ekstra_stolpe' => array(
				'/ekstra stolpe/', '/extra stolpe/', '/3 stolpe/', '/2 stolpe/'
			),
			
		);
		
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['raportyPdf.tytul_strony'],
			'tytul_modulu' => $this->j->t['raportyPdf.tytul_modulu'],
		));
		
		$mapperZamowiniaTemp = new ZamowieniaTemp\Mapper();
		
		if($aktualizujTabele)
		{
			$zamowienia = $this->dane()->Zamowienie()->szukajVillaProduktRaport(array('import_from_get_api' => true, 'status_work' => array('done', 'not done'), '!status' => 'cancelled' ));
			//$zamowienia = $this->dane()->Zamowienie()->szukajVillaProduktRaportAll(array('import_from_get_api' => true, 'status_work' => array('done', 'not done'), '!status' => 'cancelled' ));
			
			//$zamowieniaTemp = $mapperZamowiniaTemp->pobierzWszystko();
			
			//foreach($zamowieniaTemp as $zamTemp)
				//$zamTemp->usun($mapperZamowiniaTemp);
		}
		else
		{
			if($cms->sesja->pokazWszystkieZamowienia)
				$ilosc = $mapperZamowiniaTemp->iloscWszystko(false, $cms->sesja->produktMain);
			else
				$ilosc = $mapperZamowiniaTemp->iloscWszystko(true, $cms->sesja->produktMain);
			
			$iloscZamowien = $ilosc;
			$sorter = new ZamowieniaTemp\Sorter('bkt_id');
			
			$iloscOd = ($nrStrony - 1) * $naStronie;
			$iloscDo = $nrStrony * $naStronie;
			
			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['villaRaport.pager_konfiguracja']);
			$pagerHtml = $pager->html(Router::urlAdmin($this->kategoria, 'raportyVillaProdukt', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}')));
			
			if($cms->sesja->pokazWszystkieZamowienia)
				$zamowienia = $mapperZamowiniaTemp->zwracaTablice()->pobierzWszystko(false, null, $sorter, true, $cms->sesja->produktMain);
			else
				$zamowienia = $mapperZamowiniaTemp->zwracaTablice()->pobierzWszystko(true, null, $sorter, true, $cms->sesja->produktMain);
		}
		
		$grupySum = array();
		$grupySumLopende = array();
		$grupySumLopendeSimulate = array();

		$kategorieMapper = $this->dane()->Kategoria();
		$kategoriaOrders = $kategorieMapper->pobierzDlaModulu('Orders');
		$sumTimeSpent = 0;
		$sumLopendetimer = 0;
		$sumSimulate = 0;
		$simulateNettoPrice = 0;
		
		$xSumaNetto = 0;
		$xSumNettoBezLopende = 0;
		$xSimulateNettoPrice = 0;
		$xSumPlusMinus = 0;
		
		$xSumaIloscOpstart = 0;
		$xSumaIloscVilla = 0;
		$xSumaIloscTilkoblingshjelp = 0;
		$xSumaIloscInstKontakt = 0;
		$xSumaIloscKontakt = 0;
		$xSumKm = 0;
		$xSumDriveTime = 0;
		
		$i = 0;
		
		$grupyStr = array();
		$grupyStrTmp = array();
		foreach($zamowienia as $zamowienie)
		{
			$simulateTime = -$zamowienie['time_lopendetimer'];
			
			$produktyWybrane = unserialize($zamowienie['products_ids']);
			
			$klucze = array_keys($produktyWybrane);
			//dump($klucze);
			//dump($cms->sesja->dodajDoProduktu);
			//die;
			if(isset($cms->sesja->dodajDoProduktu))
			{
				foreach($cms->sesja->dodajDoProduktu as $idProduktu => $wartoscDodaj)
				{
					if(in_array($idProduktu, $klucze))
					{
						$simulateTime = $simulateTime + ($wartoscDodaj * $produktyWybrane[$idProduktu]);
					}
				}
			}
			
			
			if($aktualizujTabele)
			{
				$grupy = $this->szukajWNotatce($zamowienie['note'], $frazy);
				$grupySum = array_merge($grupySum, $grupy);
				$grupyStr = implode(',', $grupy);
				
				$tabProduktow = array();
			
				$tabTemp = explode(';', $zamowienie['products_ids'] );
				foreach($tabTemp as $prod)
				{
					$ilosc = explode('x', $prod);
					$tabProduktow[$ilosc[0]] = $ilosc[1];
				}
			}
			else if($aktualizujNotatke)
			{
				$grupy = $this->szukajWNotatce($zamowienie['note'], $frazy);
				$grupySum = array_merge($grupySum, $grupy);
				$grupyStr = implode(',', $grupy);
				
				$zamowienieTemp = $mapperZamowiniaTemp->pobierzPoId($zamowienie['id']);
				if($zamowienieTemp->problem != '')
				{
					
				}
				else
				{
					$zamowienieTemp->problem = $grupyStr;
				}
				
				$zamowienieTemp->zapisz($mapperZamowiniaTemp);
			}
			else
			{
				
				if($zamowienie['bez_lopende'] != TRUE)
				{
					$grupyStr = trim($zamowienie['problem']);
					$grupyStrTmp = explode(',', $grupyStr);
					$iloscWgrupie = count($grupyStrTmp);

					if($iloscWgrupie > 1)
					{
						$grupyStrTmp = array_filter($grupyStrTmp);
						$czasNaProblem = $zamowienie['time_lopendetimer'] / count($grupyStrTmp);

						$czasNaProblemSimulate = $simulateTime / count($grupyStrTmp);

						foreach($grupyStrTmp as $grupa)
						{
							if(!isset($grupySumLopende[$grupa])) $grupySumLopende[$grupa] = 0;
							if(!isset($grupySumLopendeSimulate[$grupa])) $grupySumLopendeSimulate[$grupa] = 0;
							$grupySumLopende[$grupa] += $czasNaProblem;
							$grupySumLopendeSimulate[$grupa] += $czasNaProblemSimulate;
						}
					}
					else
					{
						if(!isset($grupySumLopende[$grupyStrTmp[0]])) $grupySumLopende[$grupyStrTmp[0]] = 0;
						$grupySumLopende[$grupyStrTmp[0]] += $zamowienie['time_lopendetimer'];
						if(!isset($grupySumLopendeSimulate[$grupyStrTmp[0]])) $grupySumLopendeSimulate[$grupyStrTmp[0]] = 0;
						$grupySumLopendeSimulate[$grupyStrTmp[0]] += $simulateTime;
					}
					$grupySum = array_merge($grupySum, $grupyStrTmp);
				}
			}
			
			
			if(in_array(463, $klucze)) $xSumaIloscOpstart += $produktyWybrane[463];
			if(in_array(498, $klucze)) $xSumaIloscVilla += $produktyWybrane[498];
			if(in_array(464, $klucze)) $xSumaIloscTilkoblingshjelp +=$produktyWybrane[464];
			if(in_array(503, $klucze)) $xSumaIloscKontakt += $produktyWybrane[503];
			
			$sumTimeSpent += $zamowienie['time_spent'];
			$sumLopendetimer+=$zamowienie['time_lopendetimer'];
			$sumSimulate+=$simulateTime;
			
			
			$simulateNetto = $this->liczSimulateNettoPrice($zamowienie['netto_price'], $simulateTime);
			$plusMinus = $simulateNetto - $zamowienie['netto_price'];
			
			$xSumaNetto+= $zamowienie['netto_price'];
			$xSumNettoBezLopende+=$zamowienie['netto_price_without_lopendetimer'];
			$xSimulateNettoPrice+= $simulateNetto;
			$xSumPlusMinus+=$plusMinus;
			
			$xSumKm+=$zamowienie['km'];
			$xSumDriveTime+=$zamowienie['czas_trafic'];
			
			
			if( $iloscOd <= $i && $i < $iloscDo )
			{
				$this->szablon->ustawBlok('villaProduktRaport/zamowienie', array(
					'wo' => $zamowienie['number_order_get'],
					'note' => $zamowienie['note'],
					'time_spent' => $zamowienie['time_spent'],
					'lopendetimer' => $zamowienie['time_lopendetimer'],
					'products' => $this->formatujListaProduktow($zamowienie['products']),
					'grupa' => $grupyStr,
					'nettoPrice' => $zamowienie['netto_price'],
					'nettoPriceBezLopende' => $zamowienie['netto_price_without_lopendetimer'],
					'simulateNettoPrice' => $simulateNetto,
					'plusMinus' => $plusMinus,
					'simulateTime' => $simulateTime,
					'km' => round($zamowienie['km'], 2),
					'czasJazdy' => round($zamowienie['czas_trafic'], 2),
					'fromTo' => $zamowienie['from_address'].' - '.$zamowienie['to_address'],
					'id' => $zamowienie['bkt_id'],
					'bez_frazy' => (count(array_filter($grupyStrTmp)) || $zamowienie['bez_lopende'] == TRUE) ? '' : 'tdCzerwony',
					'urlZamowienie' => Router::urlAdmin($kategoriaOrders[0], 'previewOrder', array('id' => $zamowienie['bkt_id']))
				));
				
				if($zamowienie['bez_lopende'] != TRUE)
				{
					foreach($frazy as $fraza => $opcje)
					{
						$checked = (in_array($fraza , $grupyStrTmp)) ? true : false;
						if($fraza != '')
							$this->szablon->ustawBlok('villaProduktRaport/zamowienie/problemCheckbox', array(
								'grupa' => $fraza,
								'checked' => $checked,
								'id' => $zamowienie['bkt_id'],
							));
					}
				}
				
			}
			
			$i++;
			
			if($aktualizujTabele)
			{
				$trasa = $trasaMapper->pobierzPoIdOrder($zamowienie['bkt_id']);
				
				$zamowienie['time_lopendetimer'] += $zamowienie['time_lopendetimer_1'] + $zamowienie['time_lopendetimer_2'];
				
				$zamowienieTemp = $mapperZamowiniaTemp->pobierzPoBktId($zamowienie['bkt_id']);
				if($zamowienieTemp instanceof ZamowieniaTemp\Obiekt)
				{
					if($trasa instanceof RaportyExcelDane\Obiekt)
					{
						$zamowienieTemp->fromAddress = $trasa->fromAddress;
						$zamowienieTemp->toAddress = $trasa->toAddress;
						$zamowienieTemp->km = $trasa->kilometry;
						$zamowienieTemp->czas = $trasa->minutyJazdy;
						$zamowienieTemp->czasTrafic = $trasa->minutyJazdyTraffik;
						
						if($zamowienieTemp->timeLopendetimer != $zamowienie['time_lopendetimer'])
						{
							$zamowienieTemp->timeLopendetimer = $zamowienie['time_lopendetimer'];
						}
					}
					$zamowienieTemp->zapisz($mapperZamowiniaTemp);
				}
				else
				{
					if(!in_array(523, array_keys($tabProduktow)))
					{
						$zamowienieTemp = new \Generic\Model\ZamowieniaTemp\Obiekt();
						$zamowienieTemp->idProjektu = 1;
						if( $zamowienie['time_lopendetimer'] <= 0 )
						{
							$zamowienieTemp->bezLopende = true;
						}
						$zamowienieTemp->timeLopendetimer = $zamowienie['time_lopendetimer'];
						$zamowienieTemp->note = $zamowienie['note'];
						$zamowienieTemp->numberOrderGet = $zamowienie['number_order_get'];
						if( $zamowienie['time_lopendetimer'] > 0)
						{
							$zamowienieTemp->problem = $grupyStr;
						}
						$zamowienieTemp->products = $zamowienie['products'];
						$zamowienieTemp->timeSpent = $zamowienie['time_spent'];
						$zamowienieTemp->bktId = $zamowienie['bkt_id'];
						$zamowienieTemp->nettoPrice = $zamowienie['netto_price'];
						$zamowienieTemp->nettoPriceWithoutLopendetimer = $this->liczCenaBezLopendetimera($zamowienie['netto_price'], $zamowienie['time_lopendetimer']);
						$zamowienieTemp->productsIds = $tabProduktow;
						
						if($trasa instanceof RaportyExcelDane\Obiekt)
						{
							$zamowienieTemp->fromAddress = $trasa->fromAddress;
							$zamowienieTemp->toAddress = $trasa->toAddress;
							$zamowienieTemp->km = $trasa->kilometry;
							$zamowienieTemp->czas = $trasa->minutyJazdy;
							$zamowienieTemp->czasTrafic = $trasa->minutyJazdyTraffik;
						}
						$zamowienieTemp->zapisz($mapperZamowiniaTemp);
					}
					
				}
				
			}
		}

		$sumGrup = array_count_values($grupySum);
		
		foreach($sumGrup as $grupa => $ilosc)
		{
			$sumaGodzin = $grupySumLopende[$grupa];
			$sumaGodzinSimulate = $grupySumLopendeSimulate[$grupa];
			
			if($grupa == '') $grupa = 'not classified';
			
			$this->szablon->ustawBlok('villaProduktRaport/sumaGrup', array(
				'grupa' => $grupa,
				'ilosc' => $ilosc,
				'godziny' => round($sumaGodzin, 2),
				'godzinySimulate' => round($sumaGodzinSimulate, 2),
				'avg' => round(($sumaGodzin / $ilosc), 2)
			));
		}

		$dane = array(
			'pagerHtml' => $pagerHtml,
			'iloscZamowien' => count($zamowienia),
			'form' => $form->html(),
			'formFilter' => $formFilter->html(),
			'sumTimeSpent' => number_format($sumTimeSpent, 2, ',', ' ' ),
			'sumLopendetimer' => number_format($sumLopendetimer, 2, ',', ' ' ),
			'sumSimulate' => number_format($sumSimulate, 2, ',', ' ' ),
			'xSumaNetto' => number_format($xSumaNetto, 2, ',', ' ' ),
			'xSumNettoBezLopende' => number_format($xSumNettoBezLopende, 2, ',', ' ' ),
			'xSimulateNettoPrice' => number_format($xSimulateNettoPrice, 2, ',', ' ' ),
			'xSumPlusMinus' => number_format($xSumPlusMinus, 2, ',', ' ' ),
			'classMinusPlus' => ($xSumPlusMinus <= 0) ? 'red' : '',
			'classSumSimulate' => ($sumSimulate <= 0) ? 'red' : '',
			'xSumaIloscOpstart' => $xSumaIloscOpstart,
			'xSumaIloscVilla' => $xSumaIloscVilla,
			'xSumaIloscKontakt' => $xSumaIloscKontakt,
			'xSumaIloscTilkoblingshjelp' => $xSumaIloscTilkoblingshjelp,
			'czasTilkoblingshjelp' => ($xSumaIloscTilkoblingshjelp * 0.5),
			'simulateCzasTilkoblingshjelp' => ($xSumaIloscTilkoblingshjelp * (isset($cms->sesja->noweCzasyProduktu[464]) ? $cms->sesja->noweCzasyProduktu[464] : 0.5 ) ),
			'czasOppstart' => ($xSumaIloscOpstart * 0.5),
			'czasVilla' =>  ($xSumaIloscVilla * 2.5),
			'czasKontakt' => ($xSumaIloscKontakt * 1.25),
			'simulateCzasOppstart' => ($xSumaIloscOpstart * (isset($cms->sesja->noweCzasyProduktu[463]) ? $cms->sesja->noweCzasyProduktu[463] : 0.5 ) ),
			'simulateCzasVilla' => ($xSumaIloscVilla * (isset($cms->sesja->noweCzasyProduktu[498]) ? $cms->sesja->noweCzasyProduktu[498] : 2.5 ) ),
			'simulateCzasKontakt' => ($xSumaIloscKontakt * (isset($cms->sesja->noweCzasyProduktu[503]) ? $cms->sesja->noweCzasyProduktu[503] : 1.25 ) ),
			'dodajProblem' => Router::urlAjax('Admin', $this->kategoria, 'zapiszProblem', array()),
			'usunProblem' => Router::urlAjax('Admin', $this->kategoria, 'usunProblem', array()),
			'linkResetuj' => Router::urlAdmin($this->kategoria, 'raportyVillaProdukt', array('resetuj' => 1, 'nrStrony' => $nrStrony , 'naStronie' => $naStronie )),
			'linkOdswierz' => Router::urlAdmin($this->kategoria, 'raportyVillaProdukt', array('nrStrony' => $nrStrony , 'naStronie' => $naStronie )),
			'pokazWszystkie' => Router::urlAdmin($this->kategoria, 'raportyVillaProdukt', array('nrStrony' => $nrStrony , 'naStronie' => $naStronie, 'pokazWszystkie' => 1 )),
			'pokazLop' => Router::urlAdmin($this->kategoria, 'raportyVillaProdukt', array('nrStrony' => $nrStrony , 'naStronie' => $naStronie, 'pokazWszystkie' => 0 )),
			'classActiveAll' => ($cms->sesja->pokazWszystkieZamowienia) ? 'active' : '',
			'classActiveLop' => ($cms->sesja->pokazWszystkieZamowienia) ? '' : 'active',
			'xSumKm' => number_format($xSumKm, 2, ',', ' ' ),
			'xSumDriveTime' => number_format($xSumDriveTime, 2, ',', ' ' ),
			'avg_km' => number_format($xSumKm/$iloscZamowien, 2, ',', ' ' ),
			'avg_time' => number_format($xSumDriveTime/$iloscZamowien, 2, ',', ' ' ),
		);
		$this->tresc .= $this->szablon->parsujBlok('villaProduktRaport', $dane);
	}
	
	private function liczSimulateNettoPrice($nettoPrice, $simulateTime)
	{
		$simulateNettoPrice = $nettoPrice + ($simulateTime * 612);
		return $simulateNettoPrice;
	}
	
	public function wykonajUsunProblem()
	{
		$id = Zadanie::pobierz('id');
		$wartosc = trim(Zadanie::pobierz('wartosc'));
		
		
		$zamowienieMapper = new ZamowieniaTemp\Mapper();
		$zamowienie = $zamowienieMapper->pobierzPoBktId($id);
		
		$zamowienie instanceof \Generic\Model\ZamowieniaTemp\Obiekt;
		$tab = explode(',',$zamowienie->problem);
		
		$newTab = array();
		foreach($tab as $w)
		{
			if(preg_match('/'.$wartosc.'/' , $w)) continue;
			array_push($newTab, $w);
		}
		
		$tabStr = implode(',', $newTab);
		$zamowienie->problem = $tabStr;
		$zamowienie->zapisz($zamowienieMapper);
		$str = '';
		foreach($newTab as $w)
		{
			if($w != '')
				$str.='<li>'.$w.'<button class="delete" data-attr="'.$w.'" data-id="'.$id.'" >X</button></li>';
		}
		echo json_encode(array('id' => $id, 'wartosc' => $str));
		die;
		
	}
	
	public function wykonajZapiszProblem()
	{
		$id = Zadanie::pobierz('id');
		$wartosc = Zadanie::pobierz('wartosc');
		
		$zamowienieMapper = new ZamowieniaTemp\Mapper();
		$zamowienie = $zamowienieMapper->pobierzPoBktId($id);
		
		$zamowienie instanceof \Generic\Model\ZamowieniaTemp\Obiekt;
		$tab = explode(',',$zamowienie->problem);
		array_push($tab, $wartosc);
		$tabStr = implode(',', $tab);
		$zamowienie->problem = $tabStr;
		$zamowienie->zapisz($zamowienieMapper);
		$str = '';
		foreach($tab as $w)
		{
			if($w != '')
				$str.='<li>'.$w.'<button class="delete" data-attr="'.$w.'" data-id="'.$id.'" >X</button></li>';
		}
		echo json_encode(array('id' => $id, 'wartosc' => $str));
		die;
		
	}
	
	private function liczCenaBezLopendetimera($suma, $lopendetimer)
	{
		$cenaBez = $suma - ($lopendetimer * 612);
		return $cenaBez;
	}
	
	private function formatujListaProduktow($listaProduktow)
	{
		$listaFraz = array(
			'Oppstart', 'Inst kontakt', 'Inst. Villaprosjekt', 'Tilkoblingshjelp'
		);
		$zdanie = $listaProduktow;
		foreach($listaFraz as $fraza)
		{
			$zdanie = str_replace($fraza,'<b>'.$fraza.'</b>',$zdanie);
		}
		return $zdanie;
	}
	
	
	private function szukajWNotatce($notatka, $frazy)
	{
		
		$grupy = array();
		foreach($frazy as $grupa => $frazaTab)
		{
			foreach($frazaTab as $fraza)
			{
				if(preg_match($fraza, strtolower($notatka)) )
				{
					$grupy[] = trim($grupa);				
					break;
				}
			}
		}
		return $grupy;
	}


	public function wykonajRaportyPdf()
	{
		$cms = Cms::inst();
							
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['raportyPdf.tytul_strony'],
			'tytul_modulu' => $this->j->t['raportyPdf.tytul_modulu'],
		));
		$this->dodajMenuKontekstowe(array(
			'trash' => array(
				 'url' => Router::urlAdmin($this->kategoria, 'trash'),
				 'ikona' => 'icon-trash',
			),
		));

		$this->wyswietlMenuKontekstowe();
		
		$kategoriaMapper = $cms->dane()->Kategoria();
		$kategoriaZalaczniki = $kategoriaMapper->pobierzPoKodModulu('Attachments');
		
		$przyciski = array(
			array(
				'akcja' => Router::urlAjax('Admin', $this->kategoria, 'edit', array('{KLUCZ}' => '{WARTOSC}')),
				'ikona' => 'icon-pencil',
				'etykieta' => $this->j->t['raportyPdf.tabela_etykieta_edytuj'],
				'target' => '_self',
				'klucz' => 'edit',
				//'onclick' => 'return otworzOkno(this.href);',
				),
			array(
				'akcja' => Router::urlAdmin($kategoriaZalaczniki->id, 'downloadAttachments', array('{KLUCZ}' => '{WARTOSC}')),
				'etykieta' => $this->j->t['raportyPdf.etykieta_zalacznik'],
				'ikona' => 'icon-paste',
				'target' => '_blank',
				'klucz' => 'attachments',
				//'onclick' => 'return otworzOkno(this.href);',
				),
			array(
				'akcja' => "javascript:modalIFrame('".Router::urlAdmin($kategoriaZalaczniki->id, 'previewAttachments', array('{KLUCZ}' => '{WARTOSC}'))."');",
				'ikona' => 'icon-search',
				'etykieta' => $this->j->t['raportyPdf.tabela_etykieta_podglad'],
				'target' => '_self',
				'klucz' => 'podglad',
				),
			array(
				'akcja' => Router::urlAdmin($this->kategoria, 'wyslijRaportMailem', array('{KLUCZ}' => '{WARTOSC}')),
				'etykieta' => $this->j->t['raportyPdf.etykieta_wyslij_raport'],
				'ikona' => 'icon-envelope',
				'target' => '_self',
				'klucz' => 'wylijEmail',
				//'onclick' => 'return otworzOkno(this.href);',
				),
			 array(
				'akcja' => Router::urlAdmin($this->kategoria, 'delete', array('{KLUCZ}' => '{WARTOSC}')),
				'ikona' => 'icon-remove',
				'etykieta' => $this->j->t['raportyPdf.tabela_etykieta_usun'],
				'target' => '_self',
				'klucz' => 'delete',
				'onclick' => 'return potwierdzenieUsun(\''.$this->j->t['raportyPdf.etykieta_potwierdz_usun'].'\', $(this))',
				),
			);
		
		$kryteria['status'] = 'active';
		$tabela = $this->grid($przyciski, $kryteria);
		
		$dane['tabela'] = $tabela->html();
		$dane['lista_raportow_url'] = Router::urlAdmin($this->kategoria, 'index');
		$dane['lista_raportow_etykieta'] = $this->j->t['raportyPdf.etykieta_lista_raportow'];
		
		$this->tresc .= $this->szablon->parsujBlok('raportyPdf', $dane);
	}
	
	
	public function wykonajRaportyExcel()
	{
		$cms = Cms::inst();
		
		$dataEdycji = Zadanie::pobierz('dataEdycji', 'filtr_xss');
		
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['raportyExcel.tytul_strony'],
			'tytul_modulu' => $this->j->t['raportyExcel.tytul_modulu'],
		));
		
		// Tutaj miejsce na obsluge ewentualnych dodatkowych zakladek
		$this->szablon->ustawBlok('raportyExcel/zakladka', array(
			'active' => true,
			'url' => Router::urlAdmin($this->kategoria, 'raportyExcel'),
			'etykieta' => $this->j->t['raportyExcel.etykieta_daily_reports'],
		));
		
		$dataOd = new \DateTime('now', new \DateTimeZone('Europe/Oslo'));
		$dataOd->modify('-1 month');
		$dataOd->modify('-1 day');

		$dataDo = new \DateTime('now', new \DateTimeZone('Europe/Oslo'));
		$dataDo->modify('-1 day');
		$formDaty = $this->formularzFiltry($dataOd, $dataDo);
		
		if ($formDaty->wypelniony() && $formDaty->danePoprawne())
		{
			$wartosci = $formDaty->pobierzWartosci();
			$dataOd = new \DateTime($wartosci['dataOd'], new \DateTimeZone('Europe/Oslo'));
			$dataDo = new \DateTime($wartosci['dataDo'], new \DateTimeZone('Europe/Oslo'));
		}
		
		$daneMapper = $cms->dane()->RaportyExcelDane();
		
		$pracownicyDnia = $daneMapper->zwracaTablice()->pobierzPracownikowDniaZakonczoneOrdery($dataOd->format('Y-m-d'), $dataDo->format('Y-m-d').' 23:59:59');
		$nadgodzinyMapper = $cms->dane()->RaportyNadgodziny();
		
		$ids_pracownikow = listaZTablicy($pracownicyDnia, null, 'id_user');
		
		//dump($nadgodziny);
		
		$dni = array();
		$check_pracownicy = array();
		
		foreach ($pracownicyDnia as $d)
		{
			$data_zakonczenia = substr($d['data_zakonczenia'], 0, 10);
			if (isset($dni[$data_zakonczenia][$d['team_number']]))
			{
				$dni[$data_zakonczenia][$d['team_number']]['pracownicy'][$d['id_user']] = $d['pracownik'];
			}
			else
			{
				$dni[$data_zakonczenia][$d['team_number']] = array(
					'id_team' => $d['id_team'],
					'team' => $d['team_number'],
					'pracownicy' => array(
						$d['id_user'] => $d['pracownik'],
					),
				);
			}
			$check_pracownicy[$data_zakonczenia][$d['id_user']] = $d['pracownik'];
		}
		
		$daneNadgodziny = $nadgodzinyMapper->zwracaTablice()->szukaj(array(
			'data_od' => $dataOd->format('Y-m-d'),
			'data_do' => $dataDo->format('Y-m-d'),
			'id_user' => $ids_pracownikow,
		), null, new \Generic\Model\RaportyNadgodziny\Sorter('data', 'ASC'));
		
		$nadgodziny = array();
		$wypelnione_dni = array();
		foreach ($daneNadgodziny as $nadgodzina)
		{	
			unset($check_pracownicy[$nadgodzina['data']][$nadgodzina['id_user']]);
			
			if (empty($check_pracownicy[$nadgodzina['data']]))
			{
				unset($check_pracownicy[$nadgodzina['data']]);
				$wypelnione_dni[$nadgodzina['data']] = $nadgodzina['data'];
			}
			
			$nadgodziny[$nadgodzina['data']][$nadgodzina['id_user']] = $nadgodzina;
		}
		
		$daneDojazdyMapper = $cms->dane()->RaportyExcelDane();
		$daneDojazdy = listaZTablicy($daneDojazdyMapper->zwracaTablice('data')->szukaj(array(
			'daty' => array_keys($wypelnione_dni),
		)), 'data');
		
		$dzien_wypelniony_z_danymi = 0;
		foreach ($wypelnione_dni as $dzien)
		{
			if ($dzien == $dataEdycji)
				continue;
			/// Tut sprawdzić czy są dane, jak nie ma to na czerwono
			$dane_ok = false;
			if (isset($daneDojazdy[$dzien]))
			{
				$dane_ok = true;
				++ $dzien_wypelniony_z_danymi;
			}
			
			$szablon['dzien_wypelniony'][] = array(
				'data' => $dzien,
				'title' => ($dane_ok) ? $dzien : $this->j->t['raportyExcel.etykieta_brak_danych'].$dzien,
				'dane_ok' => $dane_ok, 
			);
		}
		
		$i = 0;
		foreach ($dni as $data => $teamy)
		{
			if (!empty($check_pracownicy[$data]) || $data == $dataEdycji)
			{
				$dataObiekt = new \DateTime($data, new \DateTimeZone('Europe/Oslo'));
				$szablon['dzien'][$i] = array(
					'data' => date($this->k->k['raportyExcel.formatDatyNaglowekDnia'], strtotime($data)),
					'data_id' => date('Y-m-d', strtotime($data)),
					'dzien_tygodnia' => $this->j->t['raportyExcel.dni_tygodnia'][$dataObiekt->format('N')],
				);
				$j = 0;
				
				ksort($teamy, SORT_NATURAL);
				foreach ($teamy as $team => $daneTeamu)
				{
					$szablon['dzien'][$i]['team'][$j] = array(
						'team' => $team,
						'data' => $data,
					);
					$ilosc_ukrytych_pracownikow = 0;
					foreach ($daneTeamu['pracownicy'] as $id_pracownika => $pracownik)
					{
						if (isset($nadgodziny[$data][$id_pracownika]['godziny']) && $nadgodziny[$data][$id_pracownika]['godziny'] == 0 && $nadgodziny[$data][$id_pracownika]['pauza'] == 0 && $nadgodziny[$data][$id_pracownika]['nadgodziny'] == 0)
						{
							++ $ilosc_ukrytych_pracownikow;
							$szablon['dzien'][$i]['team'][$j]['pracownik_ukryty'][] = array(
								'pracownik' => $pracownik,
								'id_user' => $id_pracownika,
								'id_team' => $daneTeamu['id_team'],
								'data' => $data,
								'wartosc_godziny' => (isset($nadgodziny[$data][$id_pracownika]['godziny'])) ? $nadgodziny[$data][$id_pracownika]['godziny'] : $this->k->k['raportyExcel.domyslne_godziny'],
								'wartosc_pauza' => (isset($nadgodziny[$data][$id_pracownika]['pauza'])) ? $nadgodziny[$data][$id_pracownika]['pauza'] : $this->k->k['raportyExcel.domyslne_pauza'],
								'wartosc_nadgodziny' => (isset($nadgodziny[$data][$id_pracownika]['nadgodziny'])) ? $nadgodziny[$data][$id_pracownika]['nadgodziny'] : $this->k->k['raportyExcel.domyslne_nadgodziny'],
								'wartosc_id' => (isset($nadgodziny[$data][$id_pracownika]['id'])) ? $nadgodziny[$data][$id_pracownika]['id'] : 0,
							);
							continue;
						}
							
						$szablon['dzien'][$i]['team'][$j]['pracownik'][] = array(
							'pracownik' => $pracownik,
							'id_user' => $id_pracownika,
							'id_team' => $daneTeamu['id_team'],
							'data' => $data,
							'wartosc_godziny' => (isset($nadgodziny[$data][$id_pracownika]['godziny'])) ? $nadgodziny[$data][$id_pracownika]['godziny'] : $this->k->k['raportyExcel.domyslne_godziny'],
							'wartosc_pauza' => (isset($nadgodziny[$data][$id_pracownika]['pauza'])) ? $nadgodziny[$data][$id_pracownika]['pauza'] : $this->k->k['raportyExcel.domyslne_pauza'],
							'wartosc_nadgodziny' => (isset($nadgodziny[$data][$id_pracownika]['nadgodziny'])) ? $nadgodziny[$data][$id_pracownika]['nadgodziny'] : $this->k->k['raportyExcel.domyslne_nadgodziny'],
							'wartosc_id' => (isset($nadgodziny[$data][$id_pracownika]['id'])) ? $nadgodziny[$data][$id_pracownika]['id'] : 0,
						);
					}
					if ($ilosc_ukrytych_pracownikow > 0)
					{
						$szablon['dzien'][$i]['team'][$j]['ukrytych'] = $ilosc_ukrytych_pracownikow;
					}
					$j++;
				}
				$i++;
			}
		}
		unset($pracownicyDnia);
		
		//dump($dni);
		$this->szablon->ustawGlobalne(array(
			'etykieta_do_wypelnienia_dni' => $this->j->t['raportyExcel.etykieta_do_wypelnienia_dni'],
			'etykieta_domyslne_godziny' => $this->j->t['raportyExcel.etykieta_domyslne_godziny'],
			'etykieta_domyslne_pauza' => $this->j->t['raportyExcel.etykieta_domyslne_pauza'],
			'etykieta_domyslne_nadgodziny' => $this->j->t['raportyExcel.etykieta_domyslne_nadgodziny'],
			'etykieta_zapisz_dzien' => $this->j->t['raportyExcel.etykieta_zapisz_dzien'],
			'etykieta_wypelnione_dni' => $this->j->t['raportyExcel.etykieta_wypelnione_dni'],
			'etykieta_pokaz_ukrytych_pracownikow' => $this->j->t['raportyExcel.etykieta_pokaz_ukrytych_pracownikow'],
			'etykieta_usun_pracownika' => $this->j->t['raportyExcel.etykieta_usun_pracownika'],
			'komunikat_tresc' => $this->j->t['raportExcel.komunikat_zapis_dnia'],
			'url_zapisz_godziny' => Router::urlAdmin($this->kategoria, 'zapiszNadgodziny'),
			'url_zapisz_dzien' => Router::urlAdmin($this->kategoria, 'zapiszDzien'),
			'url_edytuj_dzien' => Router::urlAdmin($this->kategoria, 'raportyExcel'),
			'url_usun_pracownika' => Router::urlAdmin($this->kategoria, 'usunPracownika'),
			'download_url' => Router::urlAdmin($this->kategoria, 'downloadExcel'),
		));
		
		$szablon['form'] = $formDaty->html();
		if ($dzien_wypelniony_z_danymi > 0)
		{
			$szablon['downloadExcel'] = array(
				'download_url' => Router::urlAdmin($this->kategoria, 'downloadExcel'),
				'etykieta_not_ready' => $this->j->t['raportyExcel.etykieta_not_ready'],
				'etykieta_download_excel' => $this->j->t['raportyExcel.etykieta_download_excel'],
			);
		}
		
		$this->tresc .= $this->szablon->parsujBlok('raportyExcel', $szablon);
	}
	
	public function wykonajUsunPracownika()
	{
		$subject = Zadanie::pobierzPost('data', 'strval', 'filtr_xss');
		$czesci = explode('.', $subject);
		
		$mapperNadgodziny = $this->dane()->RaportyNadgodziny();
		$nadgodziny = $mapperNadgodziny->szukaj(array(
			'data' => $czesci[0],
			'id_user' => $czesci[1],	
		));
		
		if (isset($nadgodziny[0]) && $nadgodziny[0] instanceof RaportyNadgodziny\Obiekt)
		{
			$nadgodzina = $nadgodziny[0];
		}
		else
		{
			$nadgodzina = new \Generic\Model\RaportyNadgodziny\Obiekt();
			$nadgodzina->idProjektu = 1;
			
			$nadgodzina->data = $czesci[0];
			$nadgodzina->idUser = $czesci[1];
			$nadgodzina->idTeam = $czesci[2];
		}
			
		$nadgodzina->nadgodziny = 0;
		$nadgodzina->pauza = 0;
		$nadgodzina->godziny = 0;
		
		$dane = [];
		if ($nadgodzina->zapisz($mapperNadgodziny))
		{
			$dane['status'] = 'ok';
		}
		else
		{
			$dane['status'] = 'error';
			$dane['problem'] = $this->j->t['usunPracownika.etykieta_blad_zapisu'];
		}
		echo json_encode($dane);
		die;
	}
	
	public function wykonajZapiszNadgodziny()
	{
		$dane = array();
		$wartosc = Zadanie::pobierzPost('value', 'floatval', 'abs');
		$pk = Zadanie::pobierzPost('pk', 'strval', 'filtr_xss');
		$czesci = explode('.', $pk);
		
		$mapperNadgodziny = $this->dane()->RaportyNadgodziny();
		$nadgodziny = $mapperNadgodziny->szukaj(array(
			'data' => $czesci[1],
			'id_user' => $czesci[2],	
		));
		
		if (isset($nadgodziny[0]) && $nadgodziny[0] instanceof \Generic\Model\RaportyNadgodziny\Obiekt)
		{
			$nadgodzina = $nadgodziny[0];
		}
		else
		{
			$nadgodzina = new \Generic\Model\RaportyNadgodziny\Obiekt();
			$nadgodzina->idProjektu = 1;
			
			// Ustawiam domyślne wartości dla nadgodzin i pauzy - to co zostało przesłane i tak zostanie nadpisane
			$nadgodzina->nadgodziny = $this->k->k['raportyExcel.domyslne_nadgodziny'];
			$nadgodzina->pauza = $this->k->k['raportyExcel.domyslne_pauza'];
			$nadgodzina->godziny = $this->k->k['raportyExcel.domyslne_godziny'];
		}
		
		$nadgodzina->data = $czesci[1];
		$nadgodzina->idUser = $czesci[2];
		$nadgodzina->idTeam = $czesci[3];
		
		switch ($czesci[0])
		{
			case 'overtime': $nadgodzina->nadgodziny = $wartosc;
				break;
			case 'pause' : $nadgodzina->pauza = $wartosc;
				break;
			default : $nadgodzina->godziny = $wartosc;
				break;
		}
		
		if ($nadgodzina->zapisz($mapperNadgodziny))
		{
			$dane['status'] = 'ok';
		}
		else
		{
			$dane['status'] = 'error';
			$dane['problem'] = $this->j->t['zapiszNadgodziny.etykieta_blad_zapisu_nadgodziny'];
		}
		
		echo json_encode($dane);
		die;
	}
	
	public function wykonajZapiszDzien()
	{
		$cms = Cms::inst();
		$data = Zadanie::pobierz('data', 'strval', 'filtr_xss');
		
		$dataOd = $data.' 00:00:00';
		$dataDo = $data.' 23:59:59';
		
		$daneMapper = $cms->dane()->RaportyExcelDane();
		$pracownicyDnia = listaZTablicy($daneMapper->zwracaTablice()->pobierzPracownikowDniaZakonczoneOrdery($dataOd, $dataDo), 'id_user');
		
		$ids_pracownikow = listaZTablicy($pracownicyDnia, null, 'id_user');
		
		$nadgodzinyMapper = $cms->dane()->RaportyNadgodziny();
		
		$daneNadgodziny = $nadgodzinyMapper->zwracaTablice()->szukaj(array(
			'data_od' => $dataOd,
			'data_do' => $dataDo,
			'id_user' => $ids_pracownikow,
		));
		
		foreach ($daneNadgodziny as $nadgodzina)
		{
			unset($pracownicyDnia[$nadgodzina['id_user']]);
		}
		
		
		$cms->Baza()->transakcjaStart();
		
		$blad_zapisu = 0;
		
		foreach ($pracownicyDnia as $pracownik)
		{
			$ng = new \Generic\Model\RaportyNadgodziny\Obiekt();
			
			$ng->idProjektu = 1;
			$ng->idUser = $pracownik['id_user'];
			$ng->idTeam = $pracownik['id_team'];
			$ng->data = $data;
			$ng->godziny = $this->k->k['raportyExcel.domyslne_godziny'];
			$ng->nadgodziny = $this->k->k['raportyExcel.domyslne_nadgodziny'];
			$ng->pauza = $this->k->k['raportyExcel.domyslne_pauza'];
			
			if (! $ng->zapisz($nadgodzinyMapper))
				$blad_zapisu ++;
		}
		
		if ($blad_zapisu === 0)
		{
			$cms->Baza()->transakcjaPotwierdz();
		}
		else
		{
			$cms->Baza()->transakcjaCofnij();
			$dane['error_text'] .= $this->j->t['zapiszDzian.bladZapisu'];
		}
		
		if ($blad_zapisu == 0)
		{
			$dane['status'] = 'ok';
		}
		else
		{
			$dane['status'] = 'error';
		}
		
		echo json_encode($dane);
		die;
	}
	
	
	public function wykonajEdytujDzien()
	{
		$cms = Cms::inst();
		$data = Zadanie::pobierzPost('data', 'strval', 'filtr_xss');
		
		$daneMapper = $cms->dane()->RaportyExcelDane();
		$pracownicyDnia = listaZTablicy($daneMapper->zwracaTablice()->pobierzPracownikowDnia($data, $data), 'id_user');
		
		$ids_pracownikow = listaZTablicy($pracownicyDnia, null, 'id_user');
		
		$nadgodzinyMapper = $cms->dane()->RaportyNadgodziny();
		
		$daneNadgodziny = $nadgodzinyMapper->zwracaTablice()->szukaj(array(
			'data_od' => $data,
			'data_do' => $data,
			'id_user' => $ids_pracownikow,
		));
		
		foreach ($daneNadgodziny as $nadgodzina)
		{
			unset($pracownicyDnia[$nadgodzina['id_user']]);
		}
		
		
		$cms->Baza()->transakcjaStart();
		
		$blad_zapisu = 0;
		foreach ($pracownicyDnia as $pracownik)
		{
			$ng = new \Generic\Model\RaportyNadgodziny\Obiekt();
			
			$ng->idProjektu = 1;
			$ng->idUser = $pracownik['id_user'];
			$ng->data = $data;
			$ng->godziny = $this->k->k['raportyExcel.domyslne_godziny'];
			$ng->nadgodziny = $this->k->k['raportyExcel.domyslne_nadgodziny'];
			$ng->pauza = $this->k->k['raportyExcel.domyslne_pauza'];
			
			if (! $ng->zapisz($nadgodzinyMapper))
				$blad_zapisu ++;
		}
		
		$dane = array();
		if ($blad_zapisu === 0)
		{
			$cms->Baza()->transakcjaPotwierdz();
			$dane['status'] = 'ok';
		}
		else
		{
			$cms->Baza()->transakcjaCofnij();
			$dane['status'] = 'error';
			$dane['error_text'] = $this->j->t['zapiszDzian.bladZapisu'];
		}	
		
		echo json_encode($dane);
		die;
	}
	
	public function wykonajDownloadExcel()
	{
		$cms = Cms::inst();
		
		$daty = Zadanie::pobierzPost('daty', 'strval', 'filtr_xss');
		$defaults = Zadanie::pobierzPost('not_ready', 'intval', 'abs');
		
		if ($defaults == 'on')
		{
			$defaults = true;
		}
		
		$nadgodzinyMapper = $cms->dane()->RaportyNadgodziny();
		$daneMapper = $cms->dane()->RaportyExcelDane();
		$produktyZakupioneMapper = $cms->dane()->ProduktyZakupione();
		$nadgodziny = $nadgodzinyMapper->zwracaTablice()->szukaj(array('daty' => $daty));
		
		$daneNadgodziny = array();
		foreach ($nadgodziny as $nadgodzina)
		{
			$daneNadgodziny[$nadgodzina['data']][$nadgodzina['id_team']][$nadgodzina['id_user']] = $nadgodzina;
		}
		unset($nadgodziny);
		
		$dane = $daneMapper->zwracaTablice()->szukaj(array('daty' => $daty), null, new RaportyExcelDane\Sorter('data', 'ASC'));
		$daneJazda = array();
		
		
		foreach ($dane as $wiersz)
		{
			$daneJazda[$wiersz['data']][$wiersz['id_team']][$wiersz['id']] = $wiersz;
			if (! $this->k->k['downloadExcel.pokazuj_pelen_adres'])
			{
				$parts = explode(',', $wiersz['to_address']);
				if ($wiersz['to_address'] != $this->k->k['zapiszaDzien.lokalizacjaBazy'])
				{
					$daneJazda[$wiersz['data']][$wiersz['id_team']][$wiersz['id']]['to_address'] = trim($parts[1]);
				}
				else
				{
					$daneJazda[$wiersz['data']][$wiersz['id_team']][$wiersz['id']]['to_address'] = trim($parts[0]);
				}
			}
		}
		unset($dane);
		
		$zamowieniaMapper = $cms->dane()->Zamowienie();
		
		$teamyMapper = $cms->dane()->Team();
		$teamy = listaZTablicy($teamyMapper->zwracaTablice(array('id', 'team_number'))->pobierzWszystko(), 'id', 'team_number');
		$uzytkownicyMapper = $cms->dane()->Uzytkownik();
		$uzytkownicy = listaZTablicy($uzytkownicyMapper->zwracaTablice(array('id', 'imie', 'nazwisko'))->pobierzWszystko(), 'id');
		
		$xls = Biblioteka\Excel::UtworzSzablon();
		$xls->setVersion(8);
		$xls->setCustomColor(56, 180, 198, 231);
		//$xls->setCustomColor(61, 45,75,92);
		//$xls->setCustomColor(60, 240,240,240);

		$format_naglowek = $xls->addFormat();
		$format_naglowek->setTextWrap();
		//$format_naglowek->setBold();
		$format_naglowek->setBorder(1);
		$format_naglowek->setColor($this->k->k['downloadExcel.naglowek_kolor']);
		$format_naglowek->setPattern(0.5);
		$format_naglowek->setFgColor('downloadExcel.naglowek_kolor_tla');
		$format_naglowek->setAlign('downloadExcel.naglowek_wyrownanie');

		$format_domyslny = $xls->addFormat($this->k->k['downloadExcel.format_domyslny']);

		$format_domyslny_dziesietny =& $xls->addFormat($this->k->k['downloadExcel.format_domyslny']);
		$format_domyslny_dziesietny->setNumFormat('0.00');
		
		$format_domyslny_dziesietny_kolor =& $xls->addFormat($this->k->k['downloadExcel.format_domyslny']);
		$format_domyslny_dziesietny_kolor->setNumFormat('0.00;[Red]-0.00');
		
		$format_team = $xls->addFormat($this->k->k['downloadExcel.format_domyslny']);
		
		$format_team->setTop(2);
		//$format_team->setBgColor(56);
		$format_team_pogrubiony = $xls->addFormat($this->k->k['downloadExcel.format_domyslny']);
		$format_team_pogrubiony->setBold();
		$format_team_pogrubiony->setTop(2);
		$format_border_top = $xls->addFormat();
		$format_border_top->setTop(2);
		$format_border_top_dziesietny = $xls->addFormat($this->k->k['downloadExcel.format_domyslny']);
		$format_border_top_dziesietny->setTop(2);
		$format_border_top_dziesietny->setNumFormat('0.00');
		$format_border_bottom = $xls->addFormat($this->k->k['downloadExcel.format_domyslny']);
		$format_border_bottom->setBottom(2);
		$format_border_bold_top_bottom = $xls->addFormat($this->k->k['downloadExcel.format_domyslny']);
		$format_border_bold_top_bottom->setTop(2);
		$format_border_bold_top_bottom->setBottom(2);
		
		$format_border_bold_top_bottom_dziesietny = $xls->addFormat($this->k->k['downloadExcel.format_domyslny']);
		$format_border_bold_top_bottom_dziesietny->setTop(2);
		$format_border_bold_top_bottom_dziesietny->setBottom(2);
		$format_border_bold_top_bottom_dziesietny->setNumFormat('0.00');
		
		$formaty = array(
			'format_domyslny' => $format_domyslny,
			'format_domyslny_dziesietny' => $format_domyslny_dziesietny,
			'format_naglowek' => $format_naglowek,
			'format_team' => $format_team,
			'format_border_top' => $format_border_top,
			'format_border_bold_top_bottom' => $format_border_bold_top_bottom,
		);
      
		$alfabet = $this->k->k['raportExcel.polaExcela'];

		$kryteriaCeny = array(
			'confirmation_status' => array('not confirmed', 'confirmed'),
			'not_id_product' => 92,
			'import' => false,
		);
		
		foreach ($daty as $data)
		{
			$ids_ordery = [];
			$max_ilosc_orderow = 0;
			
			foreach($daneJazda[$data] as $team_ordery)
			{
				$ilosc_orderow_per_team = count($team_ordery);
				if ($ilosc_orderow_per_team > $max_ilosc_orderow)
					$max_ilosc_orderow = $ilosc_orderow_per_team; 
			}
			$ostatnia_kolumna = $max_ilosc_orderow + 5;
			
			$arkusz = $xls->addWorksheet(date('d.m.Y' ,strtotime($data)));
			$arkusz->setInputEncoding('UTF-8');
			$arkusz->write(0, 0, 'Omsetning villa '.$this->k->k['downloadExcel.dni_tygodnia'][date('w', strtotime($data))].' '.date('d.m.Y', strtotime($data)));
			
			$licznik = 0;
			foreach ($this->k->k['downloadExcel.nazwy_kolumn'] as $kolumna => $nazwa)
			{
				$rozmiar = (isset($this->k->k['downloadExcel.szerokosc_kolumny'][$licznik])) ? $this->k->k['downloadExcel.szerokosc_kolumny'][$licznik] : $this->k->k['downloadExcel.szerokosc_kolumny_default'];
				$arkusz->setColumn(0, $licznik, $rozmiar);
				$arkusz->write(1, $licznik, $nazwa, $format_naglowek);
				++$licznik;
			}
			
			for ($i = 1; $i <= $max_ilosc_orderow; $i++)
			{
				$rozmiar = $this->k->k['downloadExcel.szerokosc_kolumny_default'];
				$arkusz->setColumn(0, $licznik, $rozmiar);
				$arkusz->write(1, $licznik, 'Ordre '.$i, $format_naglowek);
				++$licznik;
			}
			// Kolumna na czas jazdy
			$rozmiar = $this->k->k['downloadExcel.szerokosc_kolumny_default'];
			$arkusz->setColumn(0, $licznik, $rozmiar);
			$arkusz->write(1, $licznik, $this->k->k['downloadExcel.nazwa_kolumy_czas_jazdy'], $format_naglowek);
			++$licznik;
			// Kolumna na kilometry jazdy
			$rozmiar = $this->k->k['downloadExcel.szerokosc_kolumny_default'];
			$arkusz->setColumn(0, $licznik, $rozmiar);
			$arkusz->write(1, $licznik, $this->k->k['downloadExcel.nazwa_kolumy_kilometry_jazdy'], $format_naglowek);
			
			$wiersz = 2;
			
         $team = '';
			
			$ilosc_wszystkich_orderow = 0;
			
			foreach($daneJazda[$data] as $id_team => $team_ordery)
			{
				$ilosc_wszystkich_orderow += count($team_ordery);
            if ($team != $id_team)
            {
               $f = $format_team;
            }
            else
            {
               $f = $format_domyslny;
            }
            $team = $id_team;
				// Nagłówek teamu
				$arkusz->write($wiersz, 0, $teamy[$id_team], $format_team_pogrubiony);
				$arkusz->writeBlank($wiersz, 1, $f);
				$arkusz->writeBlank($wiersz, 2, $f);
				$arkusz->writeBlank($wiersz, 3, $f);
				$i = 0;
				$suma_minuty = 0;
				$suma_kilometry = 0;
				
				foreach($team_ordery as $order)
				{
					$ids_ordery[] = $order['id_order'];
					$suma_minuty += $order['minuty_jazdy_traffik'];
					$suma_kilometry += $order['kilometry'];
					$arkusz->write($wiersz, $i+4, $order['to_address'], $f);
               $arkusz->write($wiersz + 1, $i+4, $order['kilometry'], $format_domyslny_dziesietny);
               $arkusz->write($wiersz + 2, $i+4, $order['minuty_jazdy_traffik'], $format_domyslny_dziesietny);
					++ $i;
				}
				//die;
            				
				// Dopełniam puste komórki z odpowiednim formatowaniem (inaczej nie ma formatowania)
				for ($l = ($i + 4); $l < ($max_ilosc_orderow + 6); $l++)
				{
					$arkusz->writeBlank($wiersz, $l, $f);
               $arkusz->writeBlank($wiersz + 1, $l, $format_domyslny);
               $arkusz->writeBlank($wiersz + 2, $l, $format_domyslny);
				}
				 
				
				
				$ilosc_pracownikow = 0;
				foreach ($daneNadgodziny[$data][$id_team] as $id_uzytkownika => $nadgodzina)
				{
					if ($nadgodzina['godziny'] == 0 && $nadgodzina['pauza'] == 0 && $nadgodzina['nadgodziny'] == 0)
						continue;
					
					++ $ilosc_pracownikow;
					++ $wiersz;
					$pracownik = $uzytkownicy[$id_uzytkownika]['imie'].' '.$uzytkownicy[$id_uzytkownika]['nazwisko'];
					//var_dump($wiersz);
					$arkusz->write($wiersz, 0, $pracownik, $format_domyslny);
					$arkusz->write($wiersz, 1, $nadgodzina['godziny'], $format_domyslny);
					$arkusz->write($wiersz, 2, $nadgodzina['pauza'], $format_domyslny);
					$arkusz->write($wiersz, 3, $nadgodzina['nadgodziny'], $format_domyslny);
					
					$funkcja = '=SUM('.$alfabet[4].($wiersz + 1).':'.$alfabet[$ostatnia_kolumna-2].($wiersz + 1).')';
					switch ($ilosc_pracownikow)
					{
						case 1: {
							
							if ($arkusz->writeFormula($wiersz, $ostatnia_kolumna - 1, $funkcja, $format_domyslny_dziesietny) !== 0)
							{
								user_error('Formuła sumy dla minut zwrociła bład', E_USER_WARNING);
							}
						} break;
						case 2: {
							
							if ($arkusz->writeFormula($wiersz, $ostatnia_kolumna, $funkcja, $format_domyslny_dziesietny) !== 0)
							{
								user_error('Formuła sumy dla kilometrów zwrociła bład', E_USER_WARNING);
							}
						} break;
						default: {
							for ($k = 4; $k < $max_ilosc_orderow + 6; $k++)
							{
								$arkusz->writeBlank($wiersz, $k, $format_domyslny);
							}
						} break;
					}
				}
				++ $wiersz;
				if ($ilosc_pracownikow == 1)
				{
					$funkcja = '=SUM('.$alfabet[4].($wiersz + 1).':'.$alfabet[$ostatnia_kolumna-2].($wiersz + 1).')';
					$arkusz->writeBlank($wiersz, 0, $format_domyslny);
					$arkusz->writeBlank($wiersz, 1, $format_domyslny);
					$arkusz->writeBlank($wiersz, 2, $format_domyslny);
					$arkusz->writeBlank($wiersz, 3, $format_domyslny);
					$arkusz->writeFormula($wiersz, $ostatnia_kolumna, $funkcja, $format_domyslny_dziesietny);
					++ $wiersz;
				}
			}
			
			$suma_godziny_zamowione = $zamowieniaMapper->zliczPlanowanyCzasZamowienPoIDs($ids_ordery);
			
			// Format z pogrubioną linią u góry
			for ($i = 0; $i <= $ostatnia_kolumna; $i++)
			{
				$arkusz->writeBlank($wiersz, $i, $format_border_top);
			}
			
			$arkusz->writeString($wiersz, 0, $this->j->t['raportyExcel.etykieta_suma'], $format_border_bold_top_bottom);
			$arkusz->writeFormula($wiersz, 1, '=SUM(B3:B'.($wiersz).')', $format_border_bold_top_bottom_dziesietny);
			$suma_godziny = '=B'.($wiersz + 1);
			$arkusz->writeFormula($wiersz, 2, '=SUM(C3:C'.($wiersz).')', $format_border_bold_top_bottom_dziesietny);
			$suma_pauzy = '=C'.($wiersz + 1);
			$arkusz->writeFormula($wiersz, 3, '=SUM(D3:D'.($wiersz).')', $format_border_bold_top_bottom_dziesietny);
			$suma_nadgodziny = '=D'.($wiersz + 1);
			
			$arkusz->writeFormula($wiersz, $ostatnia_kolumna-1, '=SUM('.$alfabet[$ostatnia_kolumna-1].'3:'.$alfabet[$ostatnia_kolumna-1].($wiersz).')', $format_border_bold_top_bottom_dziesietny);
			$adres_suma_czas_jazdy = $alfabet[$ostatnia_kolumna-1].($wiersz+1);
			$arkusz->writeFormula($wiersz, $ostatnia_kolumna, '=SUM('.$alfabet[$ostatnia_kolumna].'3:'.$alfabet[$ostatnia_kolumna].($wiersz).')', $format_border_bold_top_bottom_dziesietny);
			$adres_suma_kilometry_jazdy = $alfabet[$ostatnia_kolumna].($wiersz+1);
			
			//Oppsumeringi
			
			$format_border_bold_top_bottom->setNumFormat('0');
			
			$wiersz = $wiersz + 3;
			$arkusz->write($wiersz, 0, $this->j->t['raportyExcel.etykieta_oppsumering_timer'], $format_border_bold_top_bottom);
			$arkusz->writeBlank($wiersz, 1, $format_border_bold_top_bottom);
			$arkusz->writeBlank($wiersz, 2, $format_border_bold_top_bottom);
			$arkusz->writeBlank($wiersz, 3, $format_border_bold_top_bottom);
			$arkusz->setMerge($wiersz, 0, $wiersz, 3);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_sum_godziny'], $format_domyslny);
			$wiersz_poczatek_suma_godziny = ($wiersz + 1);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->write($wiersz, 3, $suma_godziny, $format_domyslny);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_sum_pauzy'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->write($wiersz, 3, $suma_pauzy, $format_domyslny);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_sum_nadgodziny'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->write($wiersz, 3, $suma_nadgodziny, $format_domyslny);
			$wiersz_koniec_suma_godziny = ($wiersz + 1);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_sum_total'], $format_border_bold_top_bottom);
			$arkusz->writeBlank($wiersz, 1, $format_border_bold_top_bottom);
			$arkusz->writeBlank($wiersz, 2, $format_border_bold_top_bottom);
			$arkusz->writeFormula($wiersz, 3, '=SUM(D'.$wiersz_poczatek_suma_godziny.':D'.$wiersz_koniec_suma_godziny.')', $format_border_bold_top_bottom);
			$wiersz_suma_wszystkich_godzin = ($wiersz + 1);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_sum_oversendt'], $format_border_bold_top_bottom);
			$arkusz->writeBlank($wiersz, 1, $format_border_bold_top_bottom);
			$arkusz->writeBlank($wiersz, 2, $format_border_bold_top_bottom);
			$arkusz->write($wiersz, 3, $suma_godziny_zamowione, $format_border_bold_top_bottom);
			
			$format_korony = $xls->addFormat($this->k->k['downloadExcel.format_domyslny']);
			$format_korony->setNumFormat('kr # ##0.00;[Red]kr # ##0.00');
			$format_korony_border_bottom = $xls->addFormat($this->k->k['downloadExcel.format_domyslny']);
			$format_korony_border_bottom->setBottom(2);
			$format_korony_border_bottom->setNumFormat('kr # ##0.00;[Red]kr # ##0.00');
				
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_sum_regular_costs'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->writeFormula($wiersz, 3, '=D'.$wiersz_suma_wszystkich_godzin.'*'.$cms->config['bkt_cena_za_godzine']['ogolna'], $format_korony_border_bottom);
			$wiersz_koszt_bez_nadgodzin = ($wiersz + 1);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_sum_overtime_costs'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->writeFormula($wiersz, 3, '=(D'.$wiersz_suma_wszystkich_godzin.'*'.$cms->config['bkt_cena_za_godzine']['ogolna'].')-(D'.$wiersz_koniec_suma_godziny.'*'.$cms->config['bkt_cena_za_godzine']['ogolna'].')+(D'.$wiersz_koniec_suma_godziny.'*('.$cms->config['bkt_cena_za_godzine']['ogolna'].'*'.$cms->config['bkt_cena_za_godzine']['mnoznik_nadgodziny'].'))', $format_korony);
			$wiersz_koszt_nadgodziny = ($wiersz + 1);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_bkt_income'], $format_border_bottom);
			$arkusz->writeBlank($wiersz, 1, $format_border_bottom);
			$arkusz->writeBlank($wiersz, 2, $format_border_bottom);
			$cena_dnia = $produktyZakupioneMapper->pobierzKwoteDlaZamowienia($ids_ordery, $kryteriaCeny);
			$arkusz->write($wiersz, 3, $cena_dnia, $format_korony_border_bottom);
			$wiersz_zysk = ($wiersz + 1);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_bkt_profit'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->writeFormula($wiersz, 3, '=D'.$wiersz_zysk.'-D'.$wiersz_koszt_bez_nadgodzin, $format_korony);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_bkt_profit_overtime'], $format_border_bottom);
			$arkusz->writeBlank($wiersz, 1, $format_border_bottom);
			$arkusz->writeBlank($wiersz, 2, $format_border_bottom);
			$arkusz->writeFormula($wiersz, 3, '=D'.$wiersz_zysk.'-D'.$wiersz_koszt_nadgodziny, $format_korony_border_bottom);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_avg_timepris'], $format_border_bottom);
			$arkusz->writeBlank($wiersz, 1, $format_border_bottom);
			$arkusz->writeBlank($wiersz, 2, $format_border_bottom);
			$arkusz->writeFormula($wiersz, 3, '=D'.$wiersz_zysk.'/D'.$wiersz_suma_wszystkich_godzin, $format_korony_border_bottom);
			$wiersz_srednia_za_godzine = ($wiersz + 1);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_diff_real_hour_income'], $format_border_bottom);
			$arkusz->writeBlank($wiersz, 1, $format_border_bottom);
			$arkusz->writeBlank($wiersz, 2, $format_border_bottom);
			$arkusz->writeFormula($wiersz, 3, '=D'.$wiersz_srednia_za_godzine.'-'.$cms->config['bkt_cena_za_godzine']['ogolna'], $format_korony_border_bottom);
			
			// Oppsumeringi koncowe
			$wiersz = $wiersz + 3;
			$arkusz->write($wiersz, 0, $this->j->t['raportyExcel.etykieta_oppsumering_kjoring'], $format_border_bold_top_bottom);
			$arkusz->writeBlank($wiersz, 1, $format_border_bold_top_bottom);
			$arkusz->writeBlank($wiersz, 2, $format_border_bold_top_bottom);
			$arkusz->writeBlank($wiersz, 3, $format_border_bold_top_bottom);
			$arkusz->setMerge($wiersz, 0, $wiersz, 3);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_reel_kjortid_1'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->writeFormula($wiersz, 3, '='.$adres_suma_czas_jazdy.'/60', $format_domyslny_dziesietny);
			$wiersz_suma_godziny_jazdy = ($wiersz + 1);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_reel_kjortid_2'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->writeFormula($wiersz, 3, '=D'.$wiersz_suma_godziny_jazdy.'*2', $format_domyslny_dziesietny);
			$wiersz_suma_czas_jazdy_team = ($wiersz + 1);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_avg_reel_kjortid_2'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->writeFormula($wiersz, 3, '=D'.$wiersz_suma_czas_jazdy_team.'/'.count($daneJazda[$data]), $format_domyslny_dziesietny);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_reel_kilometer_total'], $format_border_top);
			$arkusz->writeBlank($wiersz, 1, $format_border_top);
			$arkusz->writeBlank($wiersz, 2, $format_border_top);
			$arkusz->writeFormula($wiersz, 3, '='.$adres_suma_kilometry_jazdy, $format_border_top_dziesietny);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_avg_kilometer_per_team'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->writeFormula($wiersz, 3, '='.$adres_suma_kilometry_jazdy.'/'.count($daneJazda[$data]), $format_domyslny_dziesietny);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_oppstart_for_team'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->writeFormula($wiersz, 3, '='.$ilosc_wszystkich_orderow.'*0.5', $format_domyslny);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_oppstart_for_1_guy'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->writeFormula($wiersz, 3, '='.$ilosc_wszystkich_orderow.'*0.25', $format_domyslny);
			
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_diff_oppstart'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->writeFormula($wiersz, 3, '=D'.$wiersz.'-D'.$wiersz_suma_czas_jazdy_team, $format_domyslny_dziesietny_kolor);
			
			$format_korony_border_bottom_znak = $xls->addFormat($this->k->k['downloadExcel.format_domyslny']);
			$format_korony_border_bottom_znak->setBottom(2);
			$format_korony_border_bottom_znak->setNumFormat('kr # ##0.00;[Red]kr -# ##0.00');
			$arkusz->write(++ $wiersz, 0, $this->j->t['raportyExcel.etykieta_loses_on_oppstart'], $format_domyslny);
			$arkusz->writeBlank($wiersz, 1, $format_domyslny);
			$arkusz->writeBlank($wiersz, 2, $format_domyslny);
			$arkusz->writeFormula($wiersz, 3, '=D'.$wiersz.'*'.$cms->config['bkt_cena_za_godzine']['ogolna'], $format_korony_border_bottom_znak);
			
			
		}
		unset($daneJazda);
		
		end($daty);
		$nazwaPliku = Biblioteka\Plik::unifikujNazwe(str_replace(array('{DATA_OD}', '{DATA_DO}'), array($daty[0],$daty[key($daty)]), $this->k->k['downloadExcel.nazwa_pliku']));
		
		$xls->send($nazwaPliku . '.xls');
		$xls->close();
	}

	private function formularzFiltry(\DateTime $dataOd, \DateTime $dataDo)
	{
		$form = new \Generic\Biblioteka\Formularz(Router::urlAdmin($this->kategoria, 'raportyExcel'), 'no-focus-filtr');
		$form->input(new Input\Data('dataOd', array('wartosc' => $dataOd->format('Y-m-d')), $this->j->t['raportyExcel.filtr_dataOd.etykieta']));
		$form->dataOd->dodajWalidator(new \Generic\Biblioteka\Walidator\DataIso());
				  
		$form->input(new Input\Data('dataDo', array('wartosc' => $dataDo->format('Y-m-d')), $this->j->t['raportyExcel.filtr_dataDo.etykieta']));
		$form->dataDo->dodajWalidator(new \Generic\Biblioteka\Walidator\DataIso());
		$form->input(new Input\Hidden('dataEdycji', ''));
		
		$form->input(new Input\Submit('szukaj', array('wartosc' => $this->j->t['raportyExcel.filtr_szukaj.wartosc'])));
		/*
		if(!($idRaportu > 0))
			$form->input(new Input\Czysc('czysc', array('wartosc' => $this->j->t['raportyExcel.filtr_czysc.wartosc'])));
		 */
		
		return $form;
	}
	

	public function wykonajDelete()
	{
		$cms = Cms::inst();

		$mapper = $cms->dane()->Reports();
		$objekt = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

		if($objekt instanceof Reports\Obiekt)
		{
			$objekt->status = 'delete';
			if($objekt->zapisz($mapper))
			{
				$this->komunikat($this->j->t['delete.obiekt_usuniety'], 'info', 'sesja');
				Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
			}
			else
		  {
				$this->komunikat($this->j->t['delete.obiekt_usuniety_blad'], 'info', 'sesja');
				Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
			}

		}
		else
		{
			$this->komunikat($this->j->t['delete.blad_nie_mozna_pobrac_obiektu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
		}
	}
	
	public function wykonajRevert()
	{
		$mapper = $this->dane()->Reports();

		$objekt = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));
		if($objekt instanceof Reports\Obiekt)
		{
			$objekt->status = 'active';
			$objekt->zapisz($mapper);
			$this->komunikat($this->j->t['revert.obiekt_przywrocona_z_kosza'], 'info', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'trash'));

		}
		else
		{
			$this->komunikat($this->j->t['revert.blad_nie_mozna_pobrac_obiektu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'trash'));
		}
	}
	
	
	public function wykonajTrash()
	{

		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['trash.tytul_strony'],
			'tytul_modulu' => $this->j->t['trash.tytul_modulu'],
		  ));

		$this->dodajMenuKontekstowe(array(
			'index' => array(
				'url' => Router::urlAdmin($this->kategoria, 'raportyPdf'),
				'ikona' => 'icon-list',
			),

		));
		$this->wyswietlMenuKontekstowe();

		$przyciski = array(
			array(
				'akcja' => Router::urlAdmin($this->kategoria, 'revert', array('{KLUCZ}' => '{WARTOSC}')),
				'ikona' => 'icon-repeat',
				'etykieta' => $this->j->t['index.tabela_etykieta_revert'],
				'target' => '_self',
				'klucz' => 'revert',
				),
			 );

		$kryteria['status'] = 'delete';
		$grid = $this->grid($przyciski, $kryteria);

		$this->tresc .= $this->szablon->parsujBlok('raportyPdf', array(
			'tabela' => $grid->html(),
			'lista_raportow_url' => Router::urlAdmin($this->kategoria, 'index'),
			'lista_raportow_etykieta' => $this->j->t['raportyPdf.etykieta_lista_raportow'],
		));	
	}
	
	/**
	 * 
	 * @param type $przyciski
	 * @param type $kryteria
	 * @return \Generic\Biblioteka\TabelaDanych
	 */
	private function grid($przyciski = array(), $kryteria = array())
	{
		
		$cms = Cms::inst();
		$grid = new TabelaDanych();

		$najnowszeDoPodswietlenia = $this->pobierzIdNajnowszych();
		
		$kryteriaSzukaj = $this->formularzWyszukaj($grid);
		
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('autor', $this->j->t['index.etykieta_autor']);
		$grid->dodajKolumne('data_dodania', $this->j->t['index.etykieta_data_dodania']);
		$grid->dodajKolumne('data_od', $this->j->t['index.etykieta_data_od']);
		$grid->dodajKolumne('data_do', $this->j->t['index.etykieta_data_do']);
		$grid->dodajKolumne('kategoria', $this->j->t['index.etykieta_kategoria']);
		$grid->dodajKolumne('wyslany', $this->j->t['index.etykieta_wyslany']);
		$grid->dodajKolumne('obiekt', $this->j->t['index.etykieta_obiekt']);

		$kryteria = array_merge($kryteria, $kryteriaSzukaj);
			 
		$kategoriaMapper = $cms->dane()->Kategoria();
		$kategoriaZalaczniki = $kategoriaMapper->pobierzPoKodModulu('Attachments');
		
		$mapper = $cms->dane()->Reports();
		$iloscWierszy = $mapper->iloscSzukaj($kryteria);
		
		$podswietleniaWierszy = '';
		
		if($iloscWierszy > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'desc', true, array('strval'));

			$akcja = $this->pobierzParametr('a', 'index');
			
			$sorter = new Reports\Sorter($kolumna, $kierunek);
			
			$grid->ustawSortownie(
					  array('id', 'obiekt', 'data_od', 'data_do', 'data_dodania', 'kategoria'), 
					  $kolumna, $kierunek,
					  Router::urlAdmin($this->kategoria, $akcja, array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
				);

			$pager = new Pager\Html($iloscWierszy, $naStronie, $nrStrony);
			$pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
			$grid->pager($pager->html(Router::urlAdmin($this->kategoria, $akcja, array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			$pobraneWiersze = $mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter);
			
			$zalaczniki = $this->sprawdzCzyZalacznikIstnieje($pobraneWiersze);
			
			foreach ($pobraneWiersze as $wiersz)
			{

				if(in_array($wiersz['id'], $najnowszeDoPodswietlenia))
				{
					$kolor = (isset($this->k->k['podswietl_najnowsze_kolor_kategoria'][$wiersz['kategoria']])) ? $this->k->k['podswietl_najnowsze_kolor_kategoria'][$wiersz['kategoria']] : $this->k->k['podswietl_najnowsze_kolor_domyslny'];
					$podswietleniaWierszy.= '\''.$wiersz['id'].'\' : \''.$kolor.'\' , ';
				}
				
				if(isset($this->j->t['objekty_raportow'][strtolower($wiersz['obiekt'])]))
					$wiersz['obiekt'] = $this->j->t['objekty_raportow'][strtolower($wiersz['obiekt'])];
				
				if($wiersz['autor'] != '')
				{
					($wiersz['autor_nazwa'] != '') ? $alt = $wiersz['autor_nazwa'] : $alt = '';
					
					if($wiersz['autor_zdjecie'] != '')
					{
						$zdjecie = $this->k->k['grid_zdjecia_przedrostek'].'-'.$wiersz['autor_zdjecie'];
						$obrazek = $cms->url('zdjecia_pracownikow' ,$zdjecie);
					}
					
					if($wiersz['wyslany'] == true)
					{
						$wiersz['wyslany'] = '<i class="icon icon-check"></i>';
					}
					else
					{
						$wiersz['wyslany'] = '<i class="icon icon-check-empty"></i>';
					}
					
					if($obrazek)
						$wiersz['autor'] = '<img src="'.$obrazek.'" class="tip top" alt="'.$alt.'" title="'.$alt.'" />';
					else
						$wiersz['autor'] = $alt;
				}
				
				if(!array_key_exists($wiersz['kategoria'], $this->k->k['kategorie_wyslij_email']))
				{
					$grid->usunPrzyciski(array('wylijEmail'));
				}
				
				if(isset($zalaczniki[$wiersz['id']]) && $zalaczniki[$wiersz['id']] > 0)
				{
					$url = Router::urlAdmin($kategoriaZalaczniki, 'downloadAttachments', array('id' => $zalaczniki[$wiersz['id']]));
					$grid->zmienAkcjePrzycisk('attachments', $url);
					$urlPodglad = "javascript: modalIFrame('".Router::urlAdmin($kategoriaZalaczniki, 'previewAttachments', array('id' => $zalaczniki[$wiersz['id']]))."');";
					$grid->zmienAkcjePrzycisk('podglad', $urlPodglad);
				}
				else
				{
					$grid->usunPrzyciski(array('podglad'));
					$grid->usunPrzyciski(array('attachments'));
				}
				
				if (array_key_exists($wiersz['kategoria'], $this->k->k['kategorie_edycja']))
				{
					
					$url = \Generic\Biblioteka\Reports::pobierzLinkEdycji($wiersz['id']);
					if($url != false)
						$grid->zmienAkcjePrzycisk('edit', $url);
					else
						$grid->usunPrzyciski(array('edit'));
				}
				else
				{
					$grid->usunPrzyciski(array('edit'));
				}
				
				if($wiersz['kategoria'] != '')
					if(isset ( $this->j->t['kategorie_raportow'][$wiersz['kategoria']]) )
						$wiersz['kategoria'] = $this->j->t['kategorie_raportow'][$wiersz['kategoria']];
					
				if($wiersz['data_od'] != '')
					$wiersz['data_od'] = date($this->k->k['index.format_daty_od'], strtotime($wiersz['data_od']));
				
				if($wiersz['data_dodania'] != '')
					$wiersz['data_dodania'] = date($this->k->k['index.format_data_dodania'], strtotime($wiersz['data_dodania']));
				
				if($wiersz['data_do'] != '')
					$wiersz['data_do'] = date($this->k->k['index.format_daty_do'], strtotime($wiersz['data_do']));
				
				$grid->dodajWiersz($wiersz);
			}
		}

		$this->tresc .= $this->szablon->parsujBlok('podswietl', array('podswietleniaWierszy' => $podswietleniaWierszy));
		
		$grid->dodajPrzyciski(
				  Router::urlAdmin($this->kategoria, '{AKCJA}' ,array('{KLUCZ}' => '{WARTOSC}')),
				  $przyciski
				  );
		
		return $grid;
	}
	
	
	private function pobierzIdNajnowszych()
	{
		$mapperReports = Cms::inst()->dane()->Reports();
		$idNajnowszych = $mapperReports->zwracaTablice('id')->pobierzNajnowszyZkategorii();
		$tablicaIdNajnowszych = array();
		foreach ($idNajnowszych as $klucz => $wartosc )
		{
			$tablicaIdNajnowszych[] = $wartosc['id'];
		}
		return $tablicaIdNajnowszych;
	}
	
	/**
	 * 
	 * @param array $tablicaRaportow
	 * @return array $tablicaZalacznikow
	 */
	private function sprawdzCzyZalacznikIstnieje(Array $tablicaRaportow)
	{

		$mapper = Cms::inst()->dane()->Zalacznik();
		$idRaportow = array();
		foreach($tablicaRaportow as $raport)
		{
			$idRaportow[] = $raport['id'];
		}
		$kryteria['wiele_id_object'] = $idRaportow;
		$kryteria['object'] = 'Reports';
		$zalaczniki = $mapper->szukaj($kryteria);

		$tablicaZalacznikow = array();
		foreach($zalaczniki as $zalacznik)
		{
			$tablicaZalacznikow[$zalacznik->idObject] = $zalacznik->id;
		}
		
		return $tablicaZalacznikow;
	}
	
	private function formularzWyszukaj(TabelaDanych $grid)
	{
		$obiektFormularza = new \Generic\Formularz\Reports\Wyszukiwanie();
		$obiektFormularza->ustawTlumaczenia(
			array_merge(
						$this->pobierzBlokTlumaczen('formularzSzukaj'), 
						array('kategorie_raportow' => $this->j->t['kategorie_raportow'])
					  )
		);
		$szablon = $this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']);
		$dolaczJS = true;
		if (Cms::inst()->usluga instanceof \Generic\Biblioteka\Usluga\Ajax)
		{
			$dolaczJS = false;
		}
		$grid->naglowek($obiektFormularza->zwrocFormularz()->html($szablon, true, $dolaczJS));
		return $obiektFormularza->pobierzZmienioneWartosci();
	}
	
	public function wykonajWyslijRaportMailem()
	{
		$id = Zadanie::pobierz('id', 'intval', 'abs');
		
		$mapperReports = Cms::inst()->dane()->Reports();
		$raport = $mapperReports->pobierzPoId($id);
		$dane = array();
		if($raport instanceof Reports\Obiekt)
		{
			$idTemplatki = $this->k->k['kategorie_wyslij_email'][$raport->kategoria];
			$poczta = new Poczta($idTemplatki, $dane);
			
			$zalacznikiLista = $this->pobierzZalaczniki($raport);
			foreach($zalacznikiLista as $zalacznik)
			{
				$zalaczniki[] = $zalacznik->file;
			}
		
			$katalog = Cms::inst()->katalog('reports', $raport->id);
			$poczta->dodajZalaczniki($zalaczniki, $katalog, $zalacznikiLista);
			$status = $poczta->wyslij();
			if($status)
			{
				$raport->wyslany = true;
				$raport->zapisz($mapperReports);
				$this->komunikat($this->j->t['wyslijRaport.raport_wyslany'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['wyslijRaport.raport_nie_wyslany'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['wyslijRaport.brak_raportu'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
	}
	
	/**
	 * 
	 * @param \Generic\Model\Reports\Obiekt $raport
	 * @return array $zalaczniki
	 */
	private function pobierzZalaczniki(Reports\Obiekt $raport)
	{
		$maperZalaczniki = Cms::inst()->dane()->Zalacznik();
		
		$kryteria = array(
			'object' => 'Reports',
			'id_object' => $raport->id,
		);
		$zalacznikiLista = $maperZalaczniki->szukaj($kryteria);
		
		return $zalacznikiLista;
	}
	
	
	public function wykonajTest()
	{
		
		$tuCurl = curl_init();
		$data = json_encode(array(
			'knr' => 301, 
			'gnr' => 47, 
			'bnr' => 27, 
			'fnr' => 0, 
			'snr' => 0, 
			'customer' => 'kartverket',
		));
		curl_setopt($tuCurl, CURLOPT_URL, "http://www.seeiendom.no/services/matrikkel.svc/GetMatrikkelinfo");
		curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($tuCurl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($tuCurl, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json",
			'Content-Length: ' . strlen($data),
			"__RequestVerificationToken: 86307736-3de1-4cd7-861f-9a491c61a89e",
			"Cookie: ASP.NET_SessionId=2l4kn54b0cg4vfhftxsmgqfj; __RequestVerificationToken=86307736-3de1-4cd7-861f-9a491c61a89e" 
		)); 
		curl_setopt($tuCurl, CURLOPT_POSTFIELDS, $data);
		//dump(json_decode(curl_exec($tuCurl)));
		$this->tresc .= $this->szablon->parsujBlok('test', array());
	}
	
	/*
	 *  Akcje Administracyjne z istniejacego modulu
	 */
	
	public function wykonajIndexZarzadzanie()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['indexZarzadzanie.tytul_strony'],
			'tytul_modulu' => $this->j->t['indexZarzadzanie.tytul_modulu'],
		));
		$this->dodajMenuKontekstowe(array(
			'indexZarzadzanie_dodaj' => array(
				'url' => Router::urlAdmin($this->kategoria, 'dodajZarzadzanie'),
				'ikona' => 'icon-plus',
			)
		));
		$this->wyswietlMenuKontekstowe();
		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['indexZarzadzanie.etykieta_nazwa'], 200, Router::urlAdmin($this->kategoria, 'edytujZarzadzanie', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('data_dodania', $this->j->t['indexZarzadzanie.etykieta_data_dodania'], 150);

		$grid->dodajPrzyciski(
			Router::urlAdmin($this->kategoria, '{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array(
				array(
					'akcja' => Router::urlAdmin($this->kategoria, 'edytujZarzadzanie',array('{KLUCZ}' => '{WARTOSC}')),
					'etykieta' => $this->j->t['indexZarzadzanie.etykieta_edytujZarzadzanie'],
					'ikona' => 'icon-pencil',
				),
				array(
					'akcja' => Router::urlAdmin($this->kategoria, 'kasujCacheZarzadzanie',array('{KLUCZ}' => '{WARTOSC}')),
					'etykieta' => $this->j->t['indexZarzadzanie.etykieta_kasujCache'],
					'ikona' => 'icon-fire',
				),
				array(
					'akcja' => Router::urlAdmin($this->kategoria, 'usunZarzadzanie',array('{KLUCZ}' => '{WARTOSC}')),
					'etykieta' => $this->j->t['indexZarzadzanie.etykieta_usunZarzadzanie'],
					'ikona' => 'icon-remove',
				),
			)
		);

		$kryteria = array();

		$ilosc = $this->dane()->RaportEdytowalny()->iloscSzukaj($kryteria);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['indexZarzadzanie.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['indexZarzadzanie.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'desc', true, array('strval'));

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$grid->pager($pager->html(Router::urlAdmin($this->kategoria, '', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			$sorter = new RaportEdytowalny\Sorter($kolumna, $kierunek);
			$grid->ustawSortownie(array('nazwa'), $kolumna, $kierunek,
				Router::urlAdmin($this->kategoria, '', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			foreach ($this->dane()->RaportEdytowalny()->zwracaTablice()->szukaj($kryteria, $pager, $sorter) as $raport)
			{
				$grid->dodajWiersz($raport);
			}

		}

		$this->ustawUrlPowrotny(null, 'system');

		$this->tresc .= $this->szablon->parsujBlok('/indexZarzadzanie', array(
			'tabela_danych' => $grid->html(),
			//'link_dodaj' => ,
		));
	}

	public function wykonajDodajZarzadzanie()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['dodajZarzadzanie.tytul_strony'],
			'tytul_modulu' => $this->j->t['dodajZarzadzanie.tytul_modulu'],
		));

		$raport = new \Generic\Model\RaportEdytowalny\Obiekt();
		$raport->idProjektu = ID_PROJEKTU;
		$raport->kodJezyka = KOD_JEZYKA;

		$this->tresc .= $this->szablon->parsujBlok('dodaj', array(
			'form' => $this->budujFormularz($raport),
		));

	}

	public function wykonajEdytujZarzadzanie()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['edytujZarzadzanie.tytul_strony'],
			'tytul_modulu' => $this->j->t['edytujZarzadzanie.tytul_modulu'],
		));

		$raport = $this->dane()->RaportEdytowalny()->pobierzPoId(Zadanie::pobierz('id','intval','abs'));

		if ($raport instanceof RaportEdytowalny\Obiekt)
		{
			$this->tresc .= $this->szablon->parsujBlok('dodaj', array(
				'form' => $this->budujFormularz($raport),
			));
		}
		else
		{
			$this->komunikat($this->j->t['edytujZarzadzanie.blad_nie_mozna_pobrac_raportu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'indexZarzadzanie'));
		}

	}

	protected function budujFormularz(\Generic\Model\RaportEdytowalny\Obiekt $raport)
	{
		$formularz = new Biblioteka\Formularz('', 'raportFormularz');

		$formularz->input(new Input\Text('nazwa'));
		$formularz->nazwa->dodajFiltr('strip_tags', 'addslashes', 'filtr_xss', 'trim');

		$formularz->input(new Input\TextArea('opis'));
		$formularz->opis->dodajFiltr('filtr_xss', 'addslashes', 'trim');

		$formularz->input(new Input\TextArea('kodSql'));
		$formularz->kodSql->dodajFiltr('filtr_xss', 'trim');

		$formularz->input(new Input\Tablica('subZapytania', array(
			'dodawanie_wierszy' => true,
		)));
		$formularz->subZapytania->dodajFiltr('filtr_xss', 'trim');

		$formularz->input(new Input\Select('grupa', array(
			'lista' => $this->pobierzListeGrup(),
		)));
		$formularz->grupa->dodajFiltr('strip_tags', 'filtr_xss', 'trim', 'intval');

		$formularz->input(new Input\Tablica('nazwyPol', array(
			'dodawanie_wierszy' => true,
		)));
		$formularz->nazwyPol->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$formularz->input(new Input\AutocompleteLista('uprawnieniUzytkownicy', array(
			'lista' => $this->pobierzPracownikowDoListy(),
		)));
		$formularz->uprawnieniUzytkownicy->dodajFiltr('strip_tags', 'filtr_xss', 'trim');


		$formularz->otworzRegion('widokZaawansowany');

			$formularz->input(new Input\Hidden('zezwolZaawansowany', 1));
			$formularz->zezwolZaawansowany->dodajFiltr('strip_tags', 'filtr_xss', 'trim', 'intval');

			$formularz->input(new Input\Select('typWykresu', array(
				'lista' => $this->pobierzTypyWykresow(),
			)));
			$formularz->typWykresu->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$formularz->input(new Input\Checkbox('typWykresuModyfikowalny'));
			$formularz->typWykresuModyfikowalny->dodajFiltr('strip_tags', 'filtr_xss', 'trim', 'intval');

			$formularz->input(new Input\Lista('kolumnyWykresu', array(
				'dodawanie_wierszy' => true,
			)));
			$formularz->kolumnyWykresu->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$formularz->input(new Input\Tablica('typyKolumnTabeli', array(
				'dodawanie_wierszy' => true,
			)));
			$formularz->typyKolumnTabeli->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$formularz->input(new Input\Tablica('filtry', array(
				'dodawanie_wierszy' => true,
			)));
			$formularz->filtry->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$formularz->input(new Input\Text('kolumnaWykresuDaty'));
			$formularz->kolumnaWykresuDaty->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$formularz->input(new Input\Select('cache', array(
				'lista' => $this->k->k['formularz.cache.lista'],
			)));
			$formularz->cache->dodajFiltr('strip_tags', 'filtr_xss', 'trim', 'intval');

		$formularz->zamknijRegion('widokZaawansowany');

		$formularz->otworzRegion('filtryPoczatkoweRegion');

			$formularz->input(new Input\Tablica('filtryPoczatkowe', array(
					'dodawanie_wierszy' => true,
				)));
			$formularz->filtryPoczatkowe->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$formularz->input(new Input\Tablica('filtryPoczatkoweWartosci', array(
					'dodawanie_wierszy' => true,
				)));
			$formularz->filtryPoczatkoweWartosci->dodajFiltr('filtr_xss', 'trim');

			$formularz->input(new Input\Tablica('filtryPoczatkoweEtykiety', array(
					'dodawanie_wierszy' => true,
				)));
			$formularz->filtryPoczatkoweEtykiety->dodajFiltr('filtr_xss', 'trim');

		$formularz->zamknijRegion('filtryPoczatkoweRegion');


		$formularz->stopka(new Input\Submit('zapisz'));

		$formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin($this->kategoria, 'indexZarzadzanie').'\'' )
		)));

		$formularz->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'));

		foreach ($formularz as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->k->k['formularz.wymagane_pola']))
			{
				$formularz->$nazwaInputa->wymagany = true;
				$formularz->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}

			$formularz->$nazwaInputa->ustawWartosc($raport->$nazwaInputa);

		}

		if ($formularz->wypelniony() && $formularz->danePoprawne())
		{
			if ($this->zapiszRaport($raport, $formularz->pobierzWartosci()))
			{
				if (in_array('kodSql', array_keys($formularz->pobierzZmienioneWartosci())))
				{
					if ($this->czyscCacheRaportu($raport))
					{
						$this->komunikat($this->j->t['formularz.info_wyczyszono_cache'], 'info', 'sesja');
					}
					else
					{
						$this->komunikat($this->j->t['formularz.error_nie_wyczyszono_cache'], 'info', 'sesja');
					}
				}

				$this->komunikat($this->j->t['formularz.info_zapisano_dane'], 'info', 'sesja');
				Router::przekierujDo(Router::urlAdmin($this->kategoria, 'indexZarzadzanie'));
			}
			else
			{
				$this->komunikat($this->j->t['formularz.blad_nie_mozna_zapisac'], 'error');
			}
		}

		return $formularz->html();
	}


	protected function zapiszRaport(\Generic\Model\RaportEdytowalny\Obiekt $raport, Array $wartosci)
	{
		foreach ($wartosci as $nazwaInputa => $wartosc)
		{
			$raport->$nazwaInputa = $wartosc;
		}

		if ($raport->id < 1)
		{
			$raport->dataDodania = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
		}

		$raport->dataModyfikacji = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);

		return $raport->zapisz($this->dane()->RaportEdytowalny());

	}

	protected function czyscCacheRaportu(RaportEdytowalny\Obiekt $raport)
	{
		$katalogCache = new Biblioteka\Katalog(CACHE_KATALOG . '/raporty/', true);
		if ($raport->cache > 0)
		{
			if ($katalogCache->istnieje())
			{
				$plikZapisu = new Biblioteka\Plik($katalogCache . '/cache_' . $raport->id .'.dat', true);
				if ($plikZapisu instanceof Biblioteka\Plik)
				{
					return $plikZapisu->usun();
				}
			}
		}
		// JeĂ„Ä…Ă˘â‚¬Ĺźli plik nie istnieje to wszystko ok
		return true;
	}

	protected function pobierzPracownikowDoListy()
	{
		$pracownicy = array();
		foreach ($this->dane()->Uzytkownik()
				->zwracaTablice('id', 'imie', 'nazwisko', 'login')
				->szukaj(array(
					'kody_rol' => $this->k->k['formularz.pracownicy_role'],
					'status' => 'aktywny'
					)) as $pracownik)
		{
			$pracownicy[$pracownik['id']] = $pracownik['nazwisko'] . ' ' . $pracownik['imie'].' (' . $pracownik['login'] . ')';
		}
		asort($pracownicy);
		$pracownicy = array_unique($pracownicy);

		return $pracownicy;
	}

	protected function pobierzTypyWykresow()
	{
		return $this->k->k['dopuszczalne_typy_wykresow'];
	}

	protected function pobierzListeGrup()
	{
		return $this->k->k['grupy_raportow'];
	}


	public function wykonajUsunZarzadzanie()
	{
		$raport = $this->dane()->RaportEdytowalny()->pobierzPoId(Zadanie::pobierz('id', 'intval'));
		if (($raport instanceof RaportEdytowalny\Obiekt) && $this->czyscCacheRaportu($raport) && $raport->usun($this->dane()->RaportEdytowalny()))
		{
			$this->komunikat($this->j->t['usunZarzadzanie.usunieto'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['usunZarzadzanie.blad'], 'error', 'sesja');
		}

		Router::przekierujDo(Router::urlAdmin($this->kategoria, 'indexZarzadzanie'));
	}



	public function wykonajKasujCacheZarzadzanie()
	{
		$raport = $this->dane()->RaportEdytowalny()->pobierzPoId(Zadanie::pobierz('id', 'intval'));
		if (($raport instanceof RaportEdytowalny\Obiekt) && $this->czyscCacheRaportu($raport))
		{
			$this->komunikat($this->j->t['kasujCacheZarzadzanie.usunieto'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['kasujCacheZarzadzanie.blad'], 'error', 'sesja');
		}

		Router::przekierujDo(Router::urlAdmin($this->kategoria, 'indexZarzadzanie'));
	}
	

	protected function wygenereujTabeleDanych(Array $dane, $idGrupy = 0)
	{
		$grid = new TabelaDanych();
		$grid->dodajKolumne('id','' ,10, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['tabelaKlient.etykieta_nazwa'] ,280, Router::urlAdmin($this->kategoria, 'podgladKlient', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('opis', $this->j->t['tabelaKlient.etykieta_opis']);

		$grid->dodajPrzyciski(
			Router::urlAdmin($this->kategoria, '', array('{AKCJA}', '{WARTOSC},{KLUCZ}')), array(
				'podgladKlient' => array(
					'akcja' => Router::urlAdmin($this->kategoria, '', array('a' => 'podgladKlient', '{KLUCZ}' => '{WARTOSC}')),
					'etykieta' => $this->j->t['listaRaportowKlient.etylieta.podgladKlient'],
					'ikona' => 'icon-search',
				),
			)
		);

		foreach ($dane as $raport)
		{
			$opisRaportu = explode('{PODZIAL}', $raport['opis']);
			$raport['opis'] = $opisRaportu[0];
			$grid->dodajWiersz($raport);
		}

		return $grid->html($this->ladujSzablonZewnetrzny($this->k->k['szablonKlient.tabela_danych']), true);
	}

	public function wykonajPodgladKlient()
	{
		$this->wykonajAkcje('wykresKlient');
		return;

		//PoniĂ„Ä…Ă„Ëťszy kod nie jest uĂ„Ä…Ă„Ëťywany, ale moĂ„Ä…Ă„Ëťe siÄ‚â€žĂ˘â€žË� przydaÄ‚â€žĂ˘â‚¬Ë‡

		$raport = $this->dane()->RaportEdytowalny()->pobierzPoId(Zadanie::pobierz('url_parametr_1', 'intval'));

		if ( !($raport instanceof RaportEdytowalny\Obiekt))
		{
			$this->komunikat($this->tlumaczenia['podglad.komunikat_error_brak_raportu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlHttp($this->kategoria));
			return;
		}

		if (( ! $raport->czyUzytkownikUprawniony(Cms::inst()->profil()->id) || ! $raport->zezwolZaawansowany) && ! $this->moznaWykonacAkcje('wszystkieRaportyKlient'))
		{
			$this->komunikat($this->tlumaczenia['podglad.komunikat_error_brak_uprawnien'], 'error', 'sesja');
			Router::przekierujDo(Router::urlHttp($this->kategoria));
			return;
		}

		$this->ustawGlobalne(array(
			'tytul_strony' => sprintf($this->tlumaczenia['podglad.tytul_strony'], $raport->nazwa),
			'tytul_modulu' => sprintf($this->tlumaczenia['podglad.tytul_modulu'], $raport->nazwa),
		));

		$filtry = '';

		if ($this->moznaWykonacAkcje('wykonajDoCsv'))
		{
			$this->szablon->ustawBlok('podglad/przycisk_csv', array(
				'etykieta' => $this->tlumaczenia['podglad.etykieta_doCsv'],
				'link' => Router::urlAdmin($this->kategoria, 'doCsvKlient', array('id' => $raport->id)),
			));
		}

		if ($this->moznaWykonacAkcje('wykonajWykres') && $raport->zezwolZaawansowany)
		{
			$this->szablon->ustawBlok('podglad/przycisk_csv', array(
				'etykieta' => $this->tlumaczenia['podglad.etykieta_wykres'],
				'link' => Router::urlAdmin($this->kategoria, 'wykresKlient', array('id', $raport->id)),
			));
		}

		$this->tresc .= $this->szablon->parsujBlok('podglad', array(
			'tabela' => $this->wygenerujGrid($raport, $filtry),
			'filtry' => '',
			'link_powrot' => Router::urlAdmin($this->kategoria, 'index'),
			'etykieta_powrot' => $this->tlumaczenia['podglad.etykieta_powrot'],
		));

	}

	public function wykonajWykresKlient()
	{
		$raport = $this->dane()->RaportEdytowalny()->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

		if ( !($raport instanceof RaportEdytowalny\Obiekt))
		{
			$this->komunikat($this->j->t['podgladKlient.komunikat_error_brak_raportu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
			return;
		}

		if (( ! $raport->czyUzytkownikUprawniony(Cms::inst()->profil()->id)) && ! $this->moznaWykonacAkcje('wszystkieRaportyKlient'))
		{
			$this->komunikat($this->j->t['podgladKlient.komunikat_error_brak_uprawnien'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
			return;
		}

		if ( ! $this->przygotowaneFiltryPoczatkowe($raport))
		{
			$this->wykonajAkcje('filtryPoczatkoweKlient');
			return;
		}

		$opisRaportu = explode('{PODZIAL}', $raport->opis);

		if (isset($opisRaportu[2]))
		{
			$this->komunikat(nl2br($opisRaportu[2]));
		}

		if ($this->moznaWykonacAkcje('wykonajDoCsvKlient'))
		{
			$this->szablon->ustawBlok('wykres/przycisk_csv', array(
				'etykieta' => $this->j->t['podgladKlient.etykieta_doCsv'],
				'link' => Router::urlAdmin($this->kategoria, 'doCsvKlient', array('id' => $raport->id, 'hash' => md5($_SERVER['REQUEST_TIME']))),
			));
		}

		if (count($raport->filtryPoczatkowe) > 0)
		{
			$this->szablon->ustawBlok('wykres/przycisk_filtry', array(
				'etykieta' => $this->j->t['podgladKlient.etykieta_doFiltry'],
				'link' => Router::urlAdmin($this->kategoria, 'podgladKlient', array('id' => $raport->id)),
			));
		}

		$this->tresc .= $this->szablon->parsujBlok('wykres', array(
			'link_powrot' => Router::urlAdmin($this->kategoria, 'index') . '#' . intval($raport->grupa),
			'etykieta_powrot' => $this->j->t['podgladKlient.etykieta_powrot'],
			'tresc' => $this->wygenerujWidokZaawansowany($raport),
		));

		$etykietaCzasRaportu = '';

		if ($this->czasCache != '')
		{
			$etykietaCzasRaportu = ' (' . date('Y-m-d H:i', $this->czasCache) . ')';
		}

		$this->ustawGlobalne(array(
			'tytul_strony' => sprintf($this->j->t['podgladKlient.tytul_strony'], $raport->nazwa . $etykietaCzasRaportu),
			'tytul_modulu' => sprintf($this->j->t['podgladKlient.tytul_modulu'], $raport->nazwa . $etykietaCzasRaportu),
		));

	}


	protected function przygotowaneFiltryPoczatkowe(RaportEdytowalny\Obiekt $raport)
	{
		//brak filtrĂ„â€šÄąâ€šw poczatkowych
		if (count($raport->filtryPoczatkowe) == 0)
		{
			return true;
		}
		$cms = Cms::inst();
		if (isset($cms->sesja->filtryPoczatkoweUstawione) && $cms->sesja->filtryPoczatkoweUstawione)
		{
			$cms->sesja->filtryPoczatkoweUstawione = false;
			return true;
		}

		return false;
	}


	protected function wygenerujWidokZaawansowany(RaportEdytowalny\Obiekt $raport)
	{
		$cms = Cms::inst();
		if ($cms->sesja->filtryPoczatkowe === null)
		{
			$cms->sesja->filtryPoczatkowe = array();
		}

		$ilosc = count($this->pobierzDane($raport, '', '', ' LIMIT 0,1', false, $cms->sesja->filtryPoczatkowe));
		if ($ilosc > 0)
		{
			define('SZABLON_RAPORTY', 'raporty.tpl');
			$moznaZapisacCache = count($cms->sesja->filtryPoczatkowe) == 0;

			$pomocnik = new Biblioteka\Pomocnik\Raporty();
			$pomocnik->ustawDane($this->pobierzDane($raport, '', '', '', $moznaZapisacCache, $cms->sesja->filtryPoczatkowe));
			$pomocnik->ustawFiltry($raport->filtry);
			$pomocnik->ustawKolumnaWykresuDaty($raport->kolumnaWykresuDaty);
			$pomocnik->ustawKolumnyWykresu($raport->kolumnyWykresu);
			$pomocnik->ustawTypWykresu($raport->typWykresu);
			$pomocnik->ustawTypWykresuModyfikowalny($raport->typWykresuModyfikowalny);
			$pomocnik->ustawTypyKolumnTabeli($raport->typyKolumnTabeli);
			$pomocnik->ustawNazwyPol($raport->nazwyPol);
			$pomocnik->ustawSzablon(SZABLON_KATALOG.'/'.SZABLON_RAPORTY);
			$pomocnik->ustawTlumaczenia($this->pobierzBlokTlumaczen('wykresKlient'));

			if (isset($cms->sesja->filtryPoczatkoweCsv))
			{
				$cms->sesja->filtryPoczatkoweCsv = array();
			}

			$cms->sesja->filtryPoczatkoweCsv[md5($_SERVER['REQUEST_TIME'])] = $cms->sesja->filtryPoczatkowe;

			$cms->sesja->filtryPoczatkowe = array();

			$html = $pomocnik->generuj();
			
			return $html;

		}
		else
		{
			$this->komunikat($this->j->t['wykresKlient.komunikat_error_brak_danych'], 'info');
		}
	}

	protected function wygenerujGrid(RaportEdytowalny\Obiekt $raport, $filtry)
	{
		$akcja = Zadanie::pobierz('url_parametr_0','strval', 'trim', 'strtolower');

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', null, '', true);
		$nazwyPol = $raport->nazwyPol;
		if (isset($nazwyPol['id']))
		{
			unset($nazwyPol['id']);
		}

		foreach ($nazwyPol as $klucz => $wartosc)
		{
			$grid->dodajKolumne($klucz, $wartosc);
		}

		$ilosc = count($this->pobierzDane($raport, $filtry, '', ' LIMIT 0,1'));
		if ($ilosc > 0)
		{
			$nrStrony = $this->pobierzParametr('url_parametr_3', 1, false, array('intval','abs'));
			$naStronie = $this->pobierzParametr('url_parametr_4', $this->konfiguracja['podglad.wierszy_na_stronie'], false, array('intval', 'abs'));
			$kolumna = $this->pobierzParametr('url_parametr_5', 'id', false, array('strval', 'trim', 'addslashes', 'strip_tags'));
			$kierunek = $this->pobierzParametr('url_parametr_6', 'desc', false, array('strval', 'trim', 'strtolower'));

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$pager->ustawSzablon($this->ladujSzablonZewnetrzny($this->k->k['szablon.pager']), false);
			$grid->pager($pager->html(Router::urlAdmin($this->kategoria, $akcja, array('id' => $raport->id, '{NR_STRONY}', '{NA_STRONIE}', $kolumna, $kierunek))));

			$grid->ustawSortownie(array_keys($nazwyPol), $kolumna, $kierunek,
				Router::urlAdmin($this->kategoria, $akcja, array('id' => $raport->id, $nrStrony, $naStronie, '{KOLUMNA}', '{KIERUNEK}'))
			);


			$limit = ' LIMIT ' . (($pager->nrStrony() - 1) * $naStronie) . ', '.$naStronie;
			$sorter = ' ORDER BY ' . ($kolumna) . ' ' . ($kierunek == 'desc' ? 'DESC' : 'ASC');

			foreach($this->pobierzDane($raport, $filtry, $sorter, $limit) as $wiersz)
			{
				$grid->dodajWiersz($wiersz);
			}
		}
		$html = $grid->html();
		
		return $html;
	}


	protected function pobierzDane(RaportEdytowalny\Obiekt $raport, $filtry, $sorter, $limit, $cache = false, $filtryPoczatkowe = array())
	{
		if ($cache)
		{
			$zawartoscCache = $this->wczytajCache($raport);
			if (isset($zawartoscCache[0]))
			{
				return $zawartoscCache;
			}
		}

		
		$sql = $this->przygotujZapytanie($raport, $filtry, $sorter, $limit, $filtryPoczatkowe);
		
		$wynik = $this->wykonajZapytanie($sql, $raport->subZapytania);

		if ($cache)
		{
			$this->zapiszCache($raport, $wynik);
		}

		return $wynik;
	}


	protected function wykonajZapytanie($sql, $subZapytania = array())
	{
		foreach ($subZapytania as $klucz => $subZapytanie)
		{
			$podstawienie = array();

			foreach($this->wykonajZapytanie($subZapytanie) as $wiersz)
			{
				$podstawienie[] = array_shift($wiersz);
			}

			$sql = str_ireplace($klucz, implode(',', $podstawienie), $sql);
		}

		$cms = Cms::inst();
		$cms->Baza()->zapytanie($sql);

		$wynik = array();
		while($wiersz = $cms->Baza()->pobierzWynik())
		{
			$wynik[] = $wiersz;
		}

		return $wynik;
	}


	protected function wczytajCache(RaportEdytowalny\Obiekt $raport)
	{
		$katalogCache = new Katalog(CACHE_KATALOG . '/raporty/', true);
		if ($raport->cache > 0 && $katalogCache->istnieje())
		{
			if ( !($this->plikCache instanceof Biblioteka\Plik))
			{
				$this->plikCache = new Biblioteka\Plik($katalogCache . '/cache_' . $raport->id .'.dat');
			}

			if ($this->plikCache instanceof Biblioteka\Plik && $this->plikCache->istnieje())
			{
				$cacheInfo = $this->plikCache->info();
				//cache nie jest zbyt stary
				if ((time() - $raport->cache * 3600) < $cacheInfo['mtime'])
				{
					$this->czasCache = $cacheInfo['mtime'];
					return unserialize(gzuncompress($this->plikCache->pobierzZawartosc()));
				}
			}
		}

		return null;
	}


	protected function zapiszCache(RaportEdytowalny\Obiekt $raport, $wynik)
	{
		$katalogCache = new Katalog(CACHE_KATALOG . '/raporty/', true);
		if ($raport->cache > 0)
		{
			if ($katalogCache->istnieje())
			{
				$plikZapisu = new Biblioteka\Plik($katalogCache . '/cache_' . $raport->id .'.dat', true);
				$plikZapisu->ustawZawartosc(gzcompress(serialize($wynik), 9));
			}
		}
	}


	protected function przygotujZapytanie(RaportEdytowalny\Obiekt $raport, $filtry, $sorter, $limit, Array $filtryPoczatkowe = array())
	{
		$filtryDoPodstawienia = array();
		$zmienneBlitz = array();

		foreach ($raport->filtryPoczatkowe as $filtr => $typ)
		{
			$kodFiltra = '';
			switch ($typ)
			{
				case 'boolean': {
					$kodFiltra = ($filtryPoczatkowe[$filtr] == 'true') ? true : false;
				} break;
				case 'date_range': {
					if (isset($filtryPoczatkowe[$filtr . '_od']) && isset($filtryPoczatkowe[$filtr . '_do']))
					{
						$kodFiltra = ' BETWEEN \'' . $filtryPoczatkowe[$filtr . '_od'] . '\' AND \'' . $filtryPoczatkowe[$filtr . '_do'] . '\'';
					}
				} break;
				default: {
					if (isset($filtryPoczatkowe[$filtr]))
					{
						$kodFiltra = htmlspecialchars(trim(addslashes($filtryPoczatkowe[$filtr])));
					}
				} break;
			}

			$filtryDoPodstawienia['{FILTR_' . $filtr . '}'] = $kodFiltra;
			$zmienneBlitz['FILTR_' . $filtr] = $kodFiltra;
		}

		$kodSql = str_replace(array_merge(array(
			'{FILTRY}',
			'{LIMIT}',
			'{SORTER}',
		), array_keys($filtryDoPodstawienia)), array_merge(array(
			$filtry,
			$limit,
			$sorter,
		), $filtryDoPodstawienia), $raport->kodSql);

		//dump($kodSql);die;
		$szablonZapytania = new Biblioteka\Szablon();
		$szablonZapytania->ladujTresc($kodSql);
		$szablonZapytania->ustaw($zmienneBlitz);

		return $szablonZapytania->parsuj();
	}


	public function wykonajFiltryPoczatkoweKlient()
	{
		$raport = $this->dane()->RaportEdytowalny()->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));
		if ( !($raport instanceof RaportEdytowalny\Obiekt))
		{
			$this->komunikat($this->j->t['podgladKlient.komunikat_error_brak_raportu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria));
			return;
		}

		if (( ! $raport->czyUzytkownikUprawniony(Cms::inst()->profil()->id)) && ! $this->moznaWykonacAkcje('wszystkieRaporty'))
		{
			$this->komunikat($this->j->t['podgladKlient.komunikat_error_brak_uprawnien'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria));
			return;
		}

		$this->ustawGlobalne(array(
			'tytul_strony' => $raport->nazwa,
			'tytul_modulu' => $raport->nazwa,
		));

		$this->tresc .= $this->szablon->parsujBlok('filtryPoczatkowe', array(
			'formularz' => $this->formularzFiltryPoczatkowe($raport),
		));

	}


	protected function formularzFiltryPoczatkowe(RaportEdytowalny\Obiekt $raport)
	{
		$formularz = new Biblioteka\Formularz('', 'raportFiltryPoczatkowe' . $raport->id, 'multipart/form-data', 'post', true, true);

		foreach ($raport->filtryPoczatkowe as $pole => $filtr)
		{
			switch ($filtr)
			{
				case 'date_range': {
					$wartosc = array('', '');
					if (isset($raport->filtryPoczatkoweWartosci[$pole]))
					{
						$wartosc = explode('|', $raport->filtryPoczatkoweWartosci[$pole]);
					}

					$formularz->input(new Input\Data($pole . '_od', array('datepicker_cfg' => array('changeYear' => 'true')), $raport->filtryPoczatkoweEtykiety[$pole] . ' ' . $this->j->t['formularzFiltryPoczatkowe.etykieta.od']))
						->dodajWalidator(new Walidator\DataIso)
						->dodajFiltr('addslashes', 'trim', 'htmlspecialchars')
						->ustawWartosc($wartosc[0])
						->wymagany = true;
					$formularz->input(new Input\Data($pole . '_do', array('datepicker_cfg' => array('changeYear' => 'true')), $raport->filtryPoczatkoweEtykiety[$pole] . ' ' . $this->j->t['formularzFiltryPoczatkowe.etykieta.do']))
						->dodajWalidator(new Walidator\DataIso)
						->dodajFiltr('addslashes', 'trim', 'htmlspecialchars')
						->ustawWartosc($wartosc[1])
						->wymagany = true;

				} break;
				case 'date': {
					$formularz->input(new Input\Data($pole, array('datepicker_cfg' => array('changeYear' => 'true')), $raport->filtryPoczatkoweEtykiety[$pole]))
						->dodajWalidator(new Walidator\DataIso)
						->dodajFiltr('addslashes', 'trim', 'htmlspecialchars')
						->ustawWartosc(isset($raport->filtryPoczatkoweWartosci[$pole]) ? $raport->filtryPoczatkoweWartosci[$pole] : '')
						->wymagany = true;
				} break;
				case 'text': {
					$formularz->input(new Input\Text($pole, array(), $raport->filtryPoczatkoweEtykiety[$pole]))
						->dodajFiltr('addslashes', 'trim', 'htmlspecialchars')
						->ustawWartosc(isset($raport->filtryPoczatkoweWartosci[$pole]) ? $raport->filtryPoczatkoweWartosci[$pole] : '');
				} break;
				case 'checkbox': {
					$formularz->input(new Input\Checkbox($pole, array(), $raport->filtryPoczatkoweEtykiety[$pole]))
						->dodajFiltr('addslashes', 'trim', 'htmlspecialchars')
						->ustawWartosc(isset($raport->filtryPoczatkoweWartosci[$pole]) ? $raport->filtryPoczatkoweWartosci[$pole] : '');
				} break;
				case 'select': {
					if (isset($raport->filtryPoczatkoweWartosci[$pole]))
					{
						Cms::inst()->Baza()->zapytanie($raport->filtryPoczatkoweWartosci[$pole]);
						$wartosciSelect = array('' => $this->j->t['formularzFiltryPoczatkowe.wybierz.etykieta']);
						while($wiersz = Cms::inst()->Baza()->pobierzWynik())
						{
							$wartosciSelect[$wiersz['wartosc']] = $wiersz['etykieta'];
						}
						$formularz->input(new Input\Select($pole, array(
							'lista' => $wartosciSelect,
						), $raport->filtryPoczatkoweEtykiety[$pole]))
							->dodajFiltr('addslashes', 'trim', 'htmlspecialchars');
					}
				} break;
			}
		}

		$formularz->stopka(new Input\Submit('zapisz', array(
			'klasa' => 'buttonSet buttonRed3'
		)));
		$formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin($this->kategoria).'#' . intval($raport->grupa) . '\'; return false')
		)));

		$formularz->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzFiltryPoczatkowe'));

		$opisRaportu = explode('{PODZIAL}', $raport->opis);

		if ($formularz->wypelniony() && $formularz->danePoprawne())
		{
			Cms::inst()->sesja->filtryPoczatkoweUstawione = true;
			Cms::inst()->sesja->filtryPoczatkowe = $formularz->pobierzWartosci();

			$this->wykonajAkcje('podgladKlient');
			return '';
		}
		else
		{
			if (isset($opisRaportu[1]))
			{
				$this->komunikat(nl2br($opisRaportu[1]), 'info');
			}
		}

		return $formularz->html();

	}


	public function wykonajDoCsvKlient()
	{
		$raport = $this->dane()->RaportEdytowalny()->pobierzPoId(Zadanie::pobierz('id', 'intval'));

		if ( !($raport instanceof RaportEdytowalny\Obiekt))
		{
			$this->komunikat($this->j->t['podgladKlient.komunikat_error_brak_raportu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria));
			return;
		}

		if ( !$raport->czyUzytkownikUprawniony(Cms::inst()->profil()->id)  && ! $this->moznaWykonacAkcje('wszystkieRaportyKlient'))
		{
			$this->komunikat($this->j->t['podgladKlient.komunikat_error_brak_uprawnien'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin($this->kategoria));
			return;
		}

		$this->tresc = '';

		$nazwaPliku = Biblioteka\Plik::unifikujNazwe($raport->nazwa. '-' . date('Y-m-d H-i'));

		$delimiter = ',';
		$nowaLinia = "\r\n";

		$bufor = '';

		$nazwyPol = $raport->nazwyPol;
		$klucze = array_keys($nazwyPol);

		$xls = Biblioteka\Excel::UtworzSzablon();
		$xls->setVersion(8);
		$xls->setCustomColor(61, 45,75,92);
		$xls->setCustomColor(60, 240,240,240);

		$format_naglowek = $xls->addFormat();
		$format_naglowek->setTextWrap();
		$format_naglowek->setBold();
		$format_naglowek->setColor($this->k->k['doCsvRaport.naglowek_kolor_czcionki']);
		$format_naglowek->setPattern(1);
		$format_naglowek->setFgColor($this->k->k['doCsvRaport.naglowek_kolor_tla']);
		$format_naglowek->setAlign('center');

		$format_domyslny = array(
			'Pattern' => 1,
			'Align' => 'left',
		);

		$format_dane_n = $xls->addFormat($format_domyslny);
		$format_dane_n->setFgColor($this->k->k['doCsvRaport.wiersz_nieparzysty_kolor_tla']);

		$format_dane_p = $xls->addFormat($format_domyslny);
		$format_dane_p->setFgColor($this->k->k['doCsvRaport.wiersz_parzysty_kolor_tla']);

		$arkusz = $xls->addWorksheet($raport->nazwa);
		
		$arkusz->setInputEncoding('UTF-8');
		$licznik = 0;
		foreach ($nazwyPol as $klucz => $wartosc)
		{
			$arkusz->setColumn(0, $licznik, 20);
			++$licznik;
		}
		$licznik = 0;
		foreach ($nazwyPol as $klucz => $wartosc)
		{
			$arkusz->write(0, $licznik, $wartosc, $format_naglowek);
			++$licznik;
		}

		$filtry = $this->przygotujFiltry($raport);
		
		$hash = Zadanie::pobierz('hash');
		
		$filtryPoczatkowe = isset(Cms::inst()->sesja->filtryPoczatkoweCsv[$hash]) ? Cms::inst()->sesja->filtryPoczatkoweCsv[$hash] : array();

		$licznikWierszy = 1;
		
		foreach ($this->pobierzDane($raport, $filtry, '', '', false, $filtryPoczatkowe) as $wiersz)
		{
			
			$format_dane = ($licznikWierszy % 2) ? $format_dane_n : $format_dane_p;
			$licznikKolumn = 0;
			foreach ($klucze as $wartosc)
			{
				$wartoscOrg = $wartosc;
				$pos = strpos($wartosc,'::');
				if ($pos !== false)
				{
					$wartosc = substr($wartosc, 0, $pos);
				}
				$typDanych = 'string';
				if (isset($raport->typyKolumnTabeli[$wartoscOrg]))
				{
					$typDanych = $raport->typyKolumnTabeli[$wartoscOrg];
				}
				
				if ($typDanych == 'boolean')
				{
					$w = ($wiersz[$wartosc]) ? 'true' : 'false';
					$arkusz->write($licznikWierszy, $licznikKolumn, $w, $format_dane);
				}
				else
				{
					if (is_int($wiersz[$wartosc]) || is_float($wiersz[$wartosc]))
					{
						$arkusz->writeNumber($licznikWierszy, $licznikKolumn, $wiersz[$wartosc], $format_dane);
					}
					else
					{
						$arkusz->writeString($licznikWierszy, $licznikKolumn, $wiersz[$wartosc], $format_dane);
					}
				}
				
				
				++$licznikKolumn;
			}
			++$licznikWierszy;
		}
		
		$xls->send($nazwaPliku . '.xls');
		$xls->close();
		exit(0);
	}


	protected function przygotujFiltry(RaportEdytowalny\Obiekt $raport)
	{
		$filtry = '';

		foreach($raport->filtry as $pole => $typFiltru)
		{
			if (Zadanie::pobierzGet($pole) != '' && Zadanie::pobierzGet($pole) != '|')
			{
				switch ($typFiltru)
				{
					case'text': {
						$filtry .= ' AND ' . $pole . ' LIKE \'%' . Zadanie::pobierzGet($pole, 'trim', 'addslashes', 'strip_tags', 'htmlspecialchars') . '%\' ';
					} break;
					case'range': {
						$zakres = explode('|', Zadanie::pobierzGet($pole, 'trim', 'addslashes', 'strip_tags', 'htmlspecialchars'));
						$filtry .= ' AND ' . $pole . ' >= ' . intval($zakres[0]) . ' AND ' . $pole . ' <= ' . intval($zakres[1]) ;
					} break;
					case'select': {
						$wartosc = Zadanie::pobierzGet($pole, 'trim', 'addslashes', 'strip_tags', 'htmlspecialchars');
						if ($wartosc == 'true' || $wartosc == 'false')
						{
							if ($wartosc == 'false')
							{
								$filtry .= ' AND (' . $pole . ' = ' . $wartosc . ' OR ' . $pole . ' IS NULL) ';
							}
							else
							{
								$filtry .= ' AND ' . $pole . ' = ' . $wartosc . ' ';
							}
						}
						else
						{
							$filtry .= ' AND ' . $pole . ' = \'' . $wartosc . '\' ';
						}
					} break;
					case'date': {
						$zakres = explode('|', Zadanie::pobierzGet($pole, 'trim', 'addslashes', 'strip_tags', 'htmlspecialchars'));
						$zakres[0] = date('Y-m-d', strtotime($zakres[0]));
						$zakres[1] = date('Y-m-d', strtotime($zakres[1]));

						if (strlen($zakres[0]) < 12)
						{
							//$zakres[0] .= ' 00:00:00';
						}
						if (strlen($zakres[1]) < 12)
						{
							$zakres[1] .= ' 23:59:59';
						}
						$filtry .= ' AND ' . $pole . ' >= \'' . $zakres[0] . '\' AND ' . $pole . ' <= \'' . $zakres[1] . '\'';
					} break;
				}
			}
		}
		return $filtry;
	}
}