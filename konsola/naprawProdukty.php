<?php

/**
 * Odpowiada za tworzenie plików tłumaczeń i konfiguracji na rzecz danego modułu.
 * @author Marek Bar
 */
require_once 'cli.inc.php';
require_once 'cli-cms.inc.php';

use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Plik;
use Generic\Model\Produkt;
use Generic\Model\Zamowienie;
use Generic\Model\ProduktyZakupione;
use Generic\Modul\Notes;

wykonajNaprawProdukty();


function wykonajNaprawProdukty()
{

	$cms = Cms::inst();
	$maperProdukty = $cms->dane()->Produkt();
	$sorter = new Produkt\Sorter('text_do_sms', 'DESC');
	$wszystkieProdukty = $maperProdukty->szukaj(array('import' => false), null, $sorter);
	$mapperSms = $cms->dane()->Sms();
	$smsWszystkie = $mapperSms->szukaj(array('type' => 'orders_get_done'));
	$zamowienieMapper = $cms->dane()->Zamowienie();

	$zbieraDane = array();

	foreach($smsWszystkie as $sms)
	{
		// flaga jeśli nie znaleziono żadnego produku w sms-ie
		$znalezionoProduktyWsms = 0;
		
		foreach($wszystkieProdukty as $produkt)
		{
			if($produkt->textDoSms !='')
			{
				// szukam produktu po kodzie sms w wysłanych sms-ach
				$tekstProduktSms = str_replace(array('?', '/'), array('([1-9]{1,2})', '\/'), $produkt->textDoSms);
				//dump('szukam produktu : ' . $tekstProduktSms . ' w sms ' . $sms->message);
				$pattern = '/'.$tekstProduktSms.'/';

				//$zbieraDane[$sms->idObject][$sms->dateSent]['szukam'][] = 'szukam : '.$pattern.' w sms : '.$sms->message;
				if(preg_match($pattern, $sms->message))
				{
					$znalezionoProduktyWsms = 1;
					preg_match($pattern, $sms->message, $wynik);
					if(isset($wynik[1]))
					{
						$ilosc = $wynik[1];
					}
					else
					{
						$ilosc = 1;
					}
					// jeżeli zakupiono więcej niż jeden produkt
					if($ilosc > 1)
					{
						//jeżeli jest to produkt główny to rozbijamy go na jeden główny i reszta nie główne
						if($produkt->mainProduct)
						{
							$iloscNowa = $ilosc - 1;
							$pobierzNieGlowny = $maperProdukty->zwracaTablice()->szukaj(array('text_do_sms' => $produkt->textDoSms, 'main_product' => FALSE));
							$zbieraDane[$sms->idObject][$sms->dateSent]['idSms'] = $sms->id;
							$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$pobierzNieGlowny[0]['id']]['dodano_nie_glowny'] = 1;
							$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$pobierzNieGlowny[0]['id']]['nazwa'] = $pobierzNieGlowny[0]['name'];
							$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$pobierzNieGlowny[0]['id']]['sms_produkt'] = $pobierzNieGlowny[0]['text_do_sms'];
							$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$pobierzNieGlowny[0]['id']]['ilosc'] = $iloscNowa;
							$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$pobierzNieGlowny[0]['id']]['sms'] = $sms->message;
							$ilosc = 1;

						}
						else
						{

							// gdy jest to produkt nie główny to dodajemy jeden główny reszte zapisujemy normalnie
							$pobierzGlowny = $maperProdukty->zwracaTablice()->szukaj(array('text_do_sms' => $produkt->textDoSms, 'main_product' => TRUE));
							if(isset($pobierzGlowny[0]))
							{
								$ilosc--;
								$zbieraDane[$sms->idObject][$sms->dateSent]['idSms'] = $sms->id;
								$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$pobierzGlowny[0]['id']]['dodano_glowny'] = 1;
								$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$pobierzGlowny[0]['id']]['nazwa'] = $pobierzGlowny[0]['name'];
								$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$pobierzGlowny[0]['id']]['sms_produkt'] = $pobierzGlowny[0]['text_do_sms'];
								$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$pobierzGlowny[0]['id']]['ilosc'] = 1;
								$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$pobierzGlowny[0]['id']]['sms'] = $sms->message;
							}

						}
					}
					$zbieraDane[$sms->idObject][$sms->dateSent]['idSms'] = $sms->id;
					$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$produkt->id]['produkt_glowny'] = $produkt->mainProduct;
					$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$produkt->id]['nazwa'] = $produkt->name;
					$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$produkt->id]['sms_produkt'] = $produkt->textDoSms;
					$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$produkt->id]['ilosc'] = $ilosc;
					$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$produkt->id]['sms'] = $sms->message;

					$sms->message = preg_replace($pattern, '', $sms->message, 1);
				}
				else
				{
					// $zbieraDane[$sms->idObject][$sms->dateSent]['nie_znalazlem'][] = ' ' . $tekstProduktSms . ' w sms ' . $sms->message;
				}
			}
		}
		// jeśli sms istnieje a nie znaleziono w nim żadnego produktu
		if(!$znalezionoProduktyWsms)
		{
			$zbieraDane[$sms->idObject][$sms->dateSent]['idSms'] = $sms->id;
			//$zbieraDane[$sms->idObject][$sms->dateSent]['znalazlem'][$produkt->id]['sms'] = $sms->message;
		}
	}

	$maperProduktyZakupione = $cms->dane()->ProduktyZakupione();
	$i = 0;
	$iloscZaktualizowanychProduktow = 0;
	$iloscDodanychProduktow = 0;
	$iloscZaktualizowanychZamowien = 0;
	$iloscDodanychZamowien = 0;
	$iloscZaktualizowanychSms = 0;
	$iloscZaktualizowanychNotes = 0;
	$il = count($zbieraDane);

	foreach($zbieraDane as $idZamowienia => $daty)
	{

		$produktyZakupione = $maperProduktyZakupione->zwracaTablice('id', 'id_order', 'id_product', 'name')->pobierzDlaZamowieniaNaprawProdukty($idZamowienia, array('import' =>false));

		// jeżeli jest wiecej sms do zamówienia niż jeden
		if(count($daty) > 1)
		{
			$zamowienieObjekt = $zamowienieMapper->pobierzPoId($idZamowienia);

			if(!($zamowienieObjekt instanceof Zamowienie\Obiekt))
			{
				zapiszLogiNaprawProdukty('BŁĄD : Nie znaleziono zamówienia o id : '.$idZamowienia);
			}

			$zamowienieObjektTablica = $zamowienieMapper->zwracaTablice()->pobierzPoId($idZamowienia);

			$i++;
			$il += (count($daty)-1);
			$liczSms = 0;
			$iloscSms = count($daty);

			// przeglądamy tablice z produktami wyciągniętymi z sms
			foreach($daty as $data => $produkty)
			{
				
				$liczSms++;
				// jeżeli jest to ostatnie wykonanie pętli to aktualizujemy zamówienie do tego zamówienia są przpisane wszystkie obecne produkty zakupione
				if($iloscSms == $liczSms)
				{
					$iloscZaktualizowanychZamowien++;
					$zamowienieObjekt->dataZakonczenia = $data;
					$zamowienieObjekt->dateAdded = date('Y-m-d H:i:s', strtotime($data.' -1 day'));
					$zamowienieObjekt->zapisz($zamowienieMapper);
					zapiszLogiNaprawProdukty('Aktualizuje date zakończenia ('.$zamowienieObjekt->dataZakonczenia.') oraz date dodania ('.$zamowienieObjekt->dateAdded.') zamówienia o id : '.$idZamowienia.'('.$zamowienieObjekt->numberOrderGet.')');
					foreach($produktyZakupione as $produkt)
					{
						$iloscZaktualizowanychProduktow++;
						$produktyZakupioneObiekt = $maperProduktyZakupione->pobierzPoId($produkt['id']);
						$produktyZakupioneObiekt->dataAdded = $data;
						zapiszLogiNaprawProdukty('Aktualizuje date dodania produktów ('.$produktyZakupioneObiekt->dataAdded .') dla zamówienia o id : '.$idZamowienia.'('.$zamowienieObjekt->numberOrderGet.') produkt id : '.$produkt['id']);
						$produktyZakupioneObiekt->zapisz($maperProduktyZakupione);
					}

				}
				else
				{
					// tworzymy nowe brakujące zamówienia na podstawie $zamowienieObjekt i dodajemy brakujące produkty
					$noweZamowienie = new Zamowienie\Obiekt();
					$iloscDodanychZamowien++;
					foreach($zamowienieObjekt as $nazwa => $wartosc)
					{
						if($nazwa == 'id')	continue;
						if($nazwa == 'attributes') { $wartosc = unserialize($wartosc);}
						if($nazwa == 'dateAdded') { $wartosc = date('Y-m-d H:i:s', strtotime($data.' -1 day')); }
						if($nazwa == 'dateStart') { $wartosc = date('Y-m-d', strtotime($data)); }
						if($nazwa == 'dateStop') { $wartosc = date('Y-m-d', strtotime($data)); }
						$noweZamowienie->$nazwa = $wartosc;
					}
					$noweZamowienie->dataZakonczenia = $data;
					$noweZamowienie->zapisz($zamowienieMapper);
					zapiszLogiNaprawProdukty('Dodaje nowe zamówienie o number order get : '.$noweZamowienie->numberOrderGet.'(Id zamówienia : '.$noweZamowienie->id.')');
					
					$maperNotatki = $cms->dane()->Notes();
					$notatki = $maperNotatki->szukaj(array('idObject' => $zamowienieObjekt->id, 'data_dodania' => date('Y-m-d', strtotime($data)) ));
					
					if(count($notatki) > 0)
					{
						foreach($notatki as $notatka)
						{
							$notatka->idObject = $noweZamowienie->id;
							$notatka->zapisz($maperNotatki);
							$iloscZaktualizowanychNotes++;
							zapiszLogiNaprawProdukty('Aktualizuję id_object ('.$noweZamowienie->id.') w notatce o id : '.$notatka->id);
						}
					
					}
					
					$smsEdytujIdObjekt = $mapperSms->pobierzPoId($produkty['idSms']);
					if($smsEdytujIdObjekt instanceof \Generic\Model\Sms\Obiekt )
					{
						$smsEdytujIdObjekt->idObject = $noweZamowienie->id;
						$smsEdytujIdObjekt->zapisz($mapperSms);
						zapiszLogiNaprawProdukty('Aktualizuję id_object ('.$noweZamowienie->id.') w sms o id : '.$produkty['idSms']);
						$iloscZaktualizowanychSms++;

					}
					else
					{
						zapiszLogiNaprawProdukty('BŁĄD : Nie znaleziono sms o id : '.$produkty['idSms']);
					}
					// jeżeli znaleziono produkty w sms
					if(isset($produkty['znalazlem']))
					{
						foreach($produkty['znalazlem'] as $idProdukt => $produktInfo)
						{
							$produktDoWstawienia = $maperProdukty->pobierzPoId($idProdukt);
							if($produktDoWstawienia instanceof Produkt\Obiekt)
							{
								$maperProduktyZakupioneDodaj = $cms->dane()->ProduktyZakupione();
								$iloscDodanychProduktow++;
								$nowyProduktZakupiony = new ProduktyZakupione\Obiekt();
								$nowyProduktZakupiony->idProjektu = ID_PROJEKTU;
								$nowyProduktZakupiony->idProduct = $produktDoWstawienia->id;
								$nowyProduktZakupiony->idOrder = $noweZamowienie->id;
								$nowyProduktZakupiony->quantity = $produktInfo['ilosc'];
								$nowyProduktZakupiony->vat = 25;
								$nowyProduktZakupiony->nettoPrice = $produktDoWstawienia->nettoPrice * $produktInfo['ilosc'];
								$nowyProduktZakupiony->bruttoPrice = $produktDoWstawienia->bruttoPrice * $produktInfo['ilosc'];
								$nowyProduktZakupiony->dataAdded = $data;

								$nowyProduktZakupiony->zapisz($maperProduktyZakupioneDodaj);

								zapiszLogiNaprawProdukty('Dodaje nowe produkty do zamówienia o orderNumberGet : '.$noweZamowienie->numberOrderGet.' ('.$noweZamowienie->id.')');
								
							}
							else
							{
								zapiszLogiNaprawProdukty('Nie znaleziono produktu do dodania : '.$idProdukt.' do zamówienia o id : '.$noweZamowienie->id);
							}
						}
					}
				}

			}

		}
		else
		{
			// aktualizujemy date zamówień z jednym sms
			foreach($daty as $data => $dane)
			{
				$zamowienieObjekt = $zamowienieMapper->pobierzPoId($idZamowienia);
				$zamowienieObjekt->dataZakonczenia = $data;
				$zamowienieObjekt->zapisz($zamowienieMapper);
				zapiszLogiNaprawProdukty('Aktualizuje date zamówienia ('.$zamowienieObjekt->dataZakonczenia.') w zamówieniu : '.$zamowienieObjekt->numberOrderGet.'('.$zamowienieObjekt->id.')');
				$iloscZaktualizowanychZamowien++;

				foreach($produktyZakupione as $produkt)
				{
					$iloscZaktualizowanychProduktow++;
					$produktyZakupioneObiekt = $maperProduktyZakupione->pobierzPoId($produkt['id']);
					$produktyZakupioneObiekt->dataAdded = $data;
					$produktyZakupioneObiekt->zapisz($maperProduktyZakupione);
					zapiszLogiNaprawProdukty('Aktualizuje date dodania produktów ('.$data.') w zamówieniu : '.$zamowienieObjekt->numberOrderGet.' ('.$zamowienieObjekt->id.')');
				}
			}
		}
	}

	echo "\nIlość zaktualizowanych zamówień : ".$iloscZaktualizowanychZamowien."\n";
	echo "\nIlość dodanych zamówień : ".$iloscDodanychZamowien."\n";
	echo "\nIlość zaktualizowanych Sms : ".$iloscZaktualizowanychSms."\n";
	echo "\nIlość zaktualizowaych produktów : ".$iloscZaktualizowanychProduktow."\n";
	echo "\nIlość dodanych produktów : ".$iloscDodanychProduktow."\n";
	echo "\nIlość zaktualizowanych notatek : ".$iloscZaktualizowanychNotes."\n";
	
	zapiszLogiNaprawProdukty('Ilość zaktualizowanych zamówień : '.$iloscZaktualizowanychZamowien);
	zapiszLogiNaprawProdukty('Ilość dodanych zamówień : '.$iloscDodanychZamowien);
	zapiszLogiNaprawProdukty('Ilość zaktualizowanych Sms : '.$iloscZaktualizowanychSms);
	zapiszLogiNaprawProdukty('Ilość zaktualizowaych produktów : '.$iloscZaktualizowanychProduktow);
	zapiszLogiNaprawProdukty('Ilość dodanych produktów : '.$iloscDodanychProduktow);
	zapiszLogiNaprawProdukty('Ilość zaktualizowanych notatek : '.$iloscZaktualizowanychNotes);
}


function zapiszLogiNaprawProdukty($informacja)
{
		$cms = Cms::inst();
		
		$logWykonywania = new Plik(LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-poprawa_produktow.log', true);

		$logWiersz = date('Y-m-d H:i:s ').$informacja." \n";
		$logWykonywania->ustawZawartosc($logWiersz , true);
		
}