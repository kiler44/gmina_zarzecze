<?php
namespace Generic\Model\Produkt;
use Generic\Biblioteka\ObiektDanych;
use Generic\Model\ProduktyZakupione;
use Generic\Biblioteka\Cms;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property string $code
 * @property string $name 
 * @property mixed $status 
 * @property string $measureUnit 
 * @property string $visibleInOrder 
 * @property int $vat 
 * @property double $nettoPrice 
 * @property double $bruttoPrice 
 * @property string $dateAdded
 * @property bool $import
 * @property string $kombinacje
 * @property string $textDoSms
 *	@property bool $mainProduct
 * @property bool $multiplied	
 * @property int $noteRequired	
 * @property string $serial
 * @property bool $pojedynczy
 * @property int $kolejnosc
 * @property bool $notDone
 * @property int $idPolaczony
 * @property int $technologia
 * @property int $photosRequired
 * @property string $photosExplanation 
 * @property double $czas 
 * @property string $dataWaznosciOd
 * @property string $dataWaznosciDo
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\Produkty\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\Produkty\Obiekt
	 */
	protected $j;
	
	/**
	 * 
	 * @param type $idZamowienia
	 * @param array $kryteria
	 * @param type $pobierzNiestandardowe
	 * @return type
	 */
	public function pobierzProduktyZakupione($idZamowienia, $kryteria = array(), $pobierzNiestandardowe = 1)
	{
		$produktyZakupione = array();
		$produktyZakupioneNieZapisane = array();
		$produktyTablicaZwracana = array();
		
		$kryteria['idOrder'] = $idZamowienia;
		$maperProduktyZakupione = new ProduktyZakupione\Mapper();
		$sorter = new ProduktyZakupione\Sorter('kolejnosc', 'ASC');
		$produktyZakupione = $maperProduktyZakupione->zwracaTablice()->szukaj($kryteria, null, $sorter);
		if($pobierzNiestandardowe)
		{
			$produktyZakupioneNieZapisane = $maperProduktyZakupione->zwracaTablice()->szukajZakupioneNiedopisane($kryteria);
			$produkty = array_merge($produktyZakupione, $produktyZakupioneNieZapisane);
		}
		else
		{
			$produkty = $produktyZakupione;
		}

		foreach($produkty as $produkt)
		{
			/*
			// dla produktów niestandardowych cene pobieramy z tabeli produkty_zakupione i dzielimy ją przez ilość
			if(empty($produkt['id_product']) || $produkt['id_product'] == '')
			{
				$produkt['netto_price'] = $produkt['netto_price'] / $produkt['quantity'];
				$produkt['brutto_price'] = $produkt['brutto_price'] / $produkt['quantity'];
			}
			// produkty które nie posiadają ceny w tabeli produkty a posiadają cene w tabeli produkty_zakupione
			elseif($produkt['netto_price'] == 0)
			{
				$produkt['netto_price_z_sumy'] = $produkt['netto_price_suma'] / $produkt['quantity'];
				$produkt['brutto_price_z_sumy'] = $produkt['brutto_price_suma'] / $produkt['quantity'];
			}
			 * 
			 */
			if($produkt['netto_price_suma'] > 0)
			{
				if($produkt['quantity'] == 0)
					$produkt['quantity'] = 1;
				
				$produkt['netto_price'] = $produkt['netto_price_suma'] / $produkt['quantity'];
				$produkt['brutto_price'] = $produkt['brutto_price_suma'] / $produkt['quantity'];
			}
			else
			{
				$produkt['netto_price'] = 0;
				$produkt['brutto_price'] = 0;
			}
			
			foreach($produkt as $klucz => $wartosc)
			{
				$produktyTablicaZwracana[$produkt['id_produkt_zakupiony']][$klucz] = $wartosc;
			}
		}
		
		return $produktyTablicaZwracana;
	}
	
	/**
	 * 
	 * @param type $idZamowienia
	 * @param array $kryteria
	 * @param type $pobierzNiestandardowe
	 * @return type
	 */
	public function pobierzProduktyZakupioneJednostkowe($idZamowienia, $kryteria = array(), $pobierzNiestandardowe = 1)
	{
		$produktyZakupione = array();
		$produktyZakupioneNieZapisane = array();
		$produktyTablicaZwracana = array();
		
		$kryteria['idOrder'] = $idZamowienia;
		$maperProduktyZakupione = new ProduktyZakupione\Mapper();
		$sorter = new ProduktyZakupione\Sorter('kolejnosc', 'ASC');
		$produktyZakupione = $maperProduktyZakupione->zwracaTablice()->szukaj($kryteria, null, $sorter);
		if($pobierzNiestandardowe)
		{
			$produktyZakupioneNieZapisane = $maperProduktyZakupione->zwracaTablice()->szukajZakupioneNiedopisane($kryteria);
			$produkty = array_merge($produktyZakupione, $produktyZakupioneNieZapisane);
		}
		else
		{
			$produkty = $produktyZakupione;
		}

		foreach($produkty as $produkt)
		{
			foreach($produkt as $klucz => $wartosc)
			{
				$produktyTablicaZwracana[$produkt['id_produkt_zakupiony']][$klucz] = $wartosc;
			}
		}
		return $produktyTablicaZwracana;
	}
	
	/**
	 * 
	 * @param array $tablicaZamowien - tablica obiektów zamówień
	 * @return array - tablica przechowująca ilość produktów
	 */
	public function pobierzSumaProduktow($tablicaIdZamowien)
	{	
		$produktyZakupione = $this->pobierzProduktyZakupione($tablicaIdZamowien, array('status' => 'active',));
		
		$listaProduktowSuma = array();
		foreach($produktyZakupione as $produkt)
		{
			if($produkt['id_product'] > 1)
			{
				if(isset($listaProduktowSuma[$produkt['id_product']]))
				{
					$listaProduktowSuma[$produkt['id_product']]['ilosc'] = $listaProduktowSuma[$produkt['id_product']]['ilosc'] + $produkt['quantity'];
				}
				else
				{
					$listaProduktowSuma[$produkt['id_product']]['ilosc'] = $produkt['quantity'];
					$listaProduktowSuma[$produkt['id_product']]['nazwa'] = $produkt['name'];
				}
			}
			else 
			{
				$listaProduktowSuma[$produkt['name']]['ilosc'] = $produkt['quantity'];
				$listaProduktowSuma[$produkt['name']]['nazwa'] = $produkt['name'];
			}
			
		}
		
		/*
		$kryteria = array(
			'idOrder' => $tablicaIdZamowien,
			'status' => 'active',
		);
		
		$produktyZakupioneDoZamowien = Cms::inst()->dane()->Produkt();
		$listaProduktow = $produktyZakupioneDoZamowien->zwracaTablice()->szukaj($kryteria);
		
		$listaProduktowSuma = array();
		foreach($listaProduktow as $produkt)
		{
			if(isset($listaProduktowSuma[$produkt['code']]))
			{
				$listaProduktowSuma[$produkt['code']]['ilosc'] = $listaProduktowSuma[$produkt['code']]['ilosc'] + $produkt['quantity'];
			}
			else
			{
				$listaProduktowSuma[$produkt['code']]['ilosc'] = $produkt['quantity'];
				$listaProduktowSuma[$produkt['code']]['nazwa'] = $produkt['name'];
			}
		}
		 * 
		 */
		
		return $listaProduktowSuma;
		
	}
	
	public function generujKodProduktu($nazwa)
	{
		$stop = 0;
		$numer_nazwa = 1;
		
		while($stop == 0)
		{
			$kod = generuj_kod($nazwa);
			$maperProdukt = new \Generic\Model\Produkt\Mapper();
			$produktIstnieje = $maperProdukt->pobierzPoCode($kod);

			if($produktIstnieje instanceof \Generic\Model\Produkt\Obiekt)
			{
				$stop = 0;
				
				$nazwaRozbita = explode('_', $nazwa);
				$nazwaPobrana_numer = end($nazwaRozbita);
				
				if(is_numeric($nazwaPobrana_numer))
				{
					$nazwa = str_replace($nazwaPobrana_numer, $numer_nazwa, $nazwa);
				}
				else
				{
					$nazwa = $nazwa.'_'.$numer_nazwa;
				}
				
				$numer_nazwa++;
			}
			else
			{
				$stop = 1;
			}
		}
		
		return $kod;
	}
	
	
}