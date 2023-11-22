<?php
namespace Generic\Modul\Sms;
use Generic\Model\Sms;
use Generic\Model\EmailWpisKolejki;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka;


/**
 * Moduł odpowiedzialny za edytowanie strony opisowej.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 * 
 */

class Admin extends Modul\Admin
{

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajEdytujSmsAjax',
		'wykonajWyslijWiadomosci',
		'wykonajHistoriaWiadomosci',
		'wykonajLadujStarsze',
	);
	
	protected $akcjeAjax = array(
		'wykonajWyslijWiadomosci',
		'wykonajLadujStarsze'
	);
	
	/**
	 * @var \Generic\Konfiguracja\Modul\StronaOpisowa\Admin
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\StronaOpisowa\Admin
	 */
	protected $j;
	
	private $listaObiektowUzytkownikow = array();
	private $obiektSms = null;

	public function wykonajIndex()
	{
		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['index.tytul_strony'],
			'tytul_modulu' => $this->j->t['index.tytul_modulu'],
		  ));
		$przyciski = array(
           array(
              'akcja' => Router::urlAdmin($this->kategoria, 'deleteSms', array('{KLUCZ}' => '{WARTOSC}')),
              'ikona' => 'icon-remove',
              'etykieta' => $this->j->t['index.tabela_etykieta_usun'],
              'target' => '_self',
              'klucz' => 'deleteNote',
              'onclick' => 'return potwierdzenieUsun(\''.$this->j->t['index.etykieta_potwierdz_usun'].'\', $(this))',
              ),
           );
		//$grid = $this->grid($przyciski);
		$this->tresc .= $this->szablon->parsujBlok('/index', array(
			 // 'tabela_danych' => $grid->html(),
		  ));
	}
	
	private function grid($przyciski = array(), $kryteria = array())
	{
		  $grid = new TabelaDanych();
		  $kryteriaSzukaj = array();
        $kryteria = array();
		 // $kryteriaSzukaj = $this->formularzWyszukaj($grid);
		  
        $grid->dodajKolumne('id', '', 0, '', true);
        $grid->dodajKolumne('date_sent', $this->j->t['index.date_sent']);
        $grid->dodajKolumne('sender_number', $this->j->t['index.sender_number']);
        $grid->dodajKolumne('recipient_number', $this->j->t['index.recipient_number']);
		  $grid->dodajKolumne('message', $this->j->t['index.message']);
		  $grid->dodajKolumne('sent', $this->j->t['index.sent']);
        $grid->dodajKolumne('status_info', $this->j->t['index.status_info']);
		  $grid->dodajKolumne('type', $this->j->t['index.type']);
		  
		  // $kryteria = array_merge($kryteria, $kryteriaSzukaj);
		  
		  $grid->dodajPrzyciski(
                Router::urlAdmin($this->kategoria,'{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),$przyciski
                );
		  
		  $mapper = $this->dane()->Sms();
		  
		  $iloscWierszy = $mapper->iloscSzukaj($kryteria);
		  
		  if($iloscWierszy > 0)
        {
			  
				$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
				$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
				$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
				$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));
				
				$akcja = $this->pobierzParametr('a', 'index');
				$sorter = new Sms\Sorter($kolumna, $kierunek);
				$grid->ustawSortownie(
						  array('id', 'date_sent', 'type', 'sender_number', 'recipient_number'), 
						  $kolumna, $kierunek,
						  Router::urlAdmin($this->kategoria, $akcja, array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
				 );

				$pager = new Pager\Html($iloscWierszy, $naStronie, $nrStrony);
				$pager->ustawKonfiguracje($this->k->k['index.pager_konfiguracja']);
				$grid->pager($pager->html(Router::urlAdmin($this->kategoria, $akcja, array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

				$pobraneWiersze = $mapper->zwracaTablice()->szukaj($kryteria, $pager, $sorter);

				foreach ($pobraneWiersze as $smsWiadomosc)
				{
					if(isset($smsWiadomosc['type']) && $smsWiadomosc['type'] !='')
					{
						$smsWiadomosc['type'] = $this->j->t['kategorie_sms'][$smsWiadomosc['type']];
					}
					if(isset($smsWiadomosc['sent']))
					{
						$smsWiadomosc['sent'] = $this->j->t['wiadomosc_wyslana'][$smsWiadomosc['sent']];
					}
					if($smsWiadomosc['date_sent'] != '')
					{
						$smsWiadomosc['date_sent'] = date("d-m-Y h:i A", strtotime($smsWiadomosc['date_sent']));
					}

					$grid->dodajWiersz($smsWiadomosc);
				}
        }
		  
		  return $grid;
	 }
	 
	 public function wykonajEdytujSmsAjax()
	 {
		$id = Zadanie::pobierz('id', 'intval', 'abs');
		if($id > 0)
		{
			$mapperSms = Cms::inst()->dane()->Sms();
			$obiektSms = $mapperSms->pobierzPoId($id);
			if($obiektSms instanceof Sms\Obiekt)
			{
				$wiadomosc = Zadanie::pobierz('value', 'trim', 'filtr_xss');
				$obiektSms->message = $wiadomosc;
				$obiektSms->zapisz($mapperSms);
				echo $wiadomosc;
				
			}
			
		}
		die;
	 }

	 	 private function formularzWyszukaj(TabelaDanych $grid)
	 {
		 $obiektFormularza = new \Generic\Formularz\Sms\Wyszukiwanie();
       $obiektFormularza->ustawTlumaczenia(
               array_merge(
							  $this->pobierzBlokTlumaczen('formularzSzukaj'),
							  array('wiadomosc_wyslana' => $this->j->t['wiadomosc_wyslana'])
							  )
       );
		// $szablon = $this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']);
		 
		 $grid->naglowek($obiektFormularza->zwrocFormularz()->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka'])));
		 
		 return $obiektFormularza->pobierzZmienioneWartosci();
	 } 

	public function wykonajWyslijWiadomosci()
	{
		if (empty($this->listaObiektowUzytkownikow))
		{
			$this->listaObiektowUzytkownikow = listaZObiektow($this->dane()->Uzytkownik()->pobierzWszystko(), 'id');
		}
		
		$rodzaj_wysylki = Zadanie::pobierzPost('rodzaj_wysylki', 'strval');
		$odbiorcy = Zadanie::pobierzPost('odbiorcy');
		$id_bkt = Zadanie::pobierzPost('id_bkt', 'intval', 'abs');
		
		$zamowienie = null;
		if ($id_bkt > 0)
		{
			$zamowienie = $this->dane()->Zamowienie()->pobierzPoId($id_bkt);
			if (! $zamowienie instanceof \Generic\Model\Zamowienie\Obiekt) $zamowienie = null;
		}
		$id_get = Zadanie::pobierzPost('id_get', 'intval', 'abs');
		
		$wiadomosc = Zadanie::pobierzPost('wiadomosc', 'filtr_xss');
		
		$bledy = 0;
		if ($rodzaj_wysylki == 'tryb_sms')
		{
			foreach ($odbiorcy as $odbiorca)
			{
				//$odbiorcaObiekt = $this->dane()->Uzytkownik()->pobierzPoId($odbiorca['id']);
				$wynik = $this->wyslijSms($this->listaObiektowUzytkownikow[$odbiorca['id']], $wiadomosc, $zamowienie);
				if ($wynik !== true)
				{
					$this->komunikat(str_replace(array('{ODBIORCA}', '{BLAD}'), array($odbiorca['nazwa'], $wynik), $this->j->t['wyslijWiadomosci.blad_wyslania_sms']), 'warning');
					$bledy++;
				}
			}
		}
		else if ($rodzaj_wysylki == 'tryb_email')
		{
			$nadawca = Cms::inst()->profil();
			$nadawca_nazwa = $nadawca->imie.' '.$nadawca->nazwisko;
			
			$wo_get = '';
			$wo_bkt = '';
			if ($id_get > 0)
			{
				$wo_get = ' - WO: '.$id_get;
			}
			else if ($id_bkt > 0)
			{
				$wo_bkt = ' - BKT ID: '.$id_bkt;
			}
			
			$tytul = str_replace(array(
				'{NADAWCA}', '{ID_BKT}', '{ID_GET}'), array(
				$nadawca_nazwa, $wo_bkt, $wo_get),
			$this->j->t['wyslijWiadomosci.tytulWiadomosciEmail']);
			foreach ($odbiorcy as $odbiorca)
			{
				if (!$this->wyslijEmail($odbiorca, $wiadomosc, $tytul, $zamowienie))
				{
					$this->komunikat(str_replace(array('{ODBIORCA}'), array($odbiorca['nazwa']), $this->j->t['wyslijWiadomosci.blad_wyslania_email']), 'warning');
					$bledy++;
				}
			}
		}
		else
		{
			$bledy++;
			$this->komunikat($this->j->t['wyslijWiadomosci.niepoprawny_rodzaj_wysylki'], 'error');
		}
		
		$dane = array();
		if ($bledy > 0)
		{
			$dane['komunikaty'] = $this->komunikatyHtml();
			$dane['success'] = false;
		}
		else
		{
			$this->komunikat($this->j->t['wyslijWiadomosci.sukces_wiadomosci_wyslane'], 'info');
			$dane['komunikaty'] = $this->komunikatyHtml();
			$dane['success'] = true;
		}
		echo json_encode($dane);
		die;
	}
	
	private function wyslijSms($odbiorca, $wiadomosc, $powiazany_obiekt = null)
	{
		if ($this->obiektSms == null)
		{
			$this->obiektSms = new Biblioteka\SmsNorwegia();
			$this->obiektSms->pozwolNaMiedzynarodoweSms();
		}
		
		if (! $this->obiektSms->wyslijSms($odbiorca, 'system', $wiadomosc, 'komunikator', $powiazany_obiekt))
		{
			return $this->obiektSms->pobierzBlad();
		}
		return true;
	}
	 
	private function wyslijEmail($odbiorca, $wiadomosc, $tytul, $powiazany_obiekt = null)
	{
		$poczta = new Biblioteka\Pomocnik\Poczta();
		
		$zalogowany = Cms::inst()->profil();
		
		$object = '';
		$idObject = '';
		$dotyczy = '';
		if ($powiazany_obiekt instanceof \Generic\Model\Zamowienie\Obiekt)
		{
			$object = 'Zamowienie';
			$idObject = $powiazany_obiekt->id;
			$dotyczy = $powiazany_obiekt->pobierzStandardowyTytulZamowienia();
		}
		
		$poczta->wczytajUstawienia(array(
			'przygotujWiadomosc' => false,
			'idOdbiorcy' => $odbiorca['id'],
			'idNadawcy' => Cms::inst()->profil()->id,
			'emailOdbiorcy' => array($odbiorca['email']),
			'emailOdpowiedzi' => array($zalogowany->email),
			'emailTytul' => $tytul,
			'emailTrescHtml' => $dotyczy.'<br/><br/>'.nl2br($wiadomosc),
			'emailTrescTxt' => $dotyczy."\n\n".htmlspecialchars($wiadomosc),
			'zapiszStanWKolejce' => true,
			'nieWysylaj' => true,
			//'emailNadawcaEmail' => $zalogowany->email,
			//'emailNadawcaNazwa' => $zalogowany->imie.' '.$zalogowany->nazwisko,
			'object' => $object,
			'idObject' => $idObject,
		));
		
		$wynik = $poczta->wyslij();
		return $wynik;
	}
	
	public function wykonajHistoriaWiadomosci()
	{
		$idUzytkownika = Zadanie::pobierz('uid', 'intval', 'abs');
		$uzytkownik = $this->dane()->Uzytkownik()->pobierzPoId($idUzytkownika);
		
		$tytul_modulu = $this->j->t['historiaWiadomosci.tytul_modulu'];
		$tytul_strony = $this->j->t['historiaWiadomosci.tytul_strony'];
		
		if ($uzytkownik instanceof \Generic\Model\Uzytkownik\Obiekt)
		{
			$cms = Cms::inst();
			$status = 1;
			
			$zdjecie = ($uzytkownik->zdjecie != '') ? $cms->url('zdjecia_pracownikow' , (($this->k->k['historiaWiadomosci.prefix_zdjecia'] != '') ? $this->k->k['historiaWiadomosci.prefix_zdjecia'].'-' : $this->k->k['historiaWiadomosci.prefix_zdjecia']).$uzytkownik->zdjecie) : '';
			
			$znajdz = array('{IMIE}','{NAZWISKO}','{TELEFON}','{EMAIL}');
			$zamien = array($uzytkownik->imie, $uzytkownik->nazwisko, $uzytkownik->telKomorkaFirmowa, $uzytkownik->email);
			
			$dataOd = new \DateTime('now', new \DateTimeZone('Europe/Oslo'));
			$dataDo = new \DateTime('tomorrow midnight', new \DateTimeZone('Europe/Oslo'));
			
			$dataOd->modify($this->k->k['historiaWiadomosci.pokazuj_wiadomosci_ile_wstecz']);
			
			$wiersze = $this->zwrocWierszeHistorii($idUzytkownika, $dataOd->format("Y-m-d H:i:s"), $dataDo->format("Y-m-d H:i:s"));
			if ($wiersze === 0)
			{
				$this->szablon->ustawBlok('historiaWiadomosci/wiersze/pustyWiersz', array(
					'etykieta_brak_wynikow' => $this->j->t['historiaWiadomosci.etykieta_brak_wynikow'],
					'etykieta_zamknij_historie' => $this->j->t['historiaWiadomosci.etykieta_zamknij_historie'],
				));
				$wiersze = $this->szablon->parsujBlok('historiaWiadomosci/wiersze', array());
			}
			
			$html_modulu = $this->szablon->parsujBlok('historiaWiadomosci', array(
				'kontakt_nazwa_wyswietlania' => str_replace($znajdz, $zamien, $this->j->t['historiaWiadomosci.nazwa_wyswietlania']),
				'etykieta_historia_kontaktow' => $this->j->t['historiaWiadomosci.etykieta_historia_kontaktow'],
				'etykieta_naglowek' => $this->j->t['historiaWiadomosci.etykieta_naglowek'],
				'etykieta_placeholder' => $this->j->t['historiaWiadomosci.etykieta_placeholder'],
				'etykieta_od' => $this->j->t['historiaWiadomosci.etykieta_data_od'],
				'etykieta_do' => $this->j->t['historiaWiadomosci.etykieta_data_do'],
				'etykieta_starsze' => $this->j->t['historiaWiadomosci.etykieta_starsze'],
				'data_od' => $dataOd->format($this->k->k['historiaWiadomosci.format_daty']),
				'data_do' => $dataDo->format($this->k->k['historiaWiadomosci.format_daty']),
				'zdjecie' => $zdjecie,
				'uid' => $uzytkownik->id,
				'wierszeHistorii' => $wiersze,
				'etykieta_brak_wynikow_filtr' => $this->j->t['historiaWiadomosci.etykieta_brak_wynikow_filtr'],
				'uid' => $idUzytkownika,
			));
		}
		else
		{
			$status = 0;
			$this->komunikat($this->j->t['historiaWiadomosci.bledne_id_uzytkownika'], 'error');
		}
		
		if (Zadanie::czyAjax())
		{
			$html = '';
			$html .= $html_modulu;
			$dane_json = array(
				'status' => $status,
				'tytul' => $tytul_modulu,
				'html' => $html,
				'komunikaty' => $this->komunikatyHtml(),
			);
			echo json_encode($dane_json);
			die;
		}
		else
		{
			$this->ustawGlobalne(array(
				'tytul_strony' => $tytul_strony,
				'tytul_modulu' => $tytul_modulu,
			));
			$this->tresc .= $html_modulu;
		}
	}

	
	public function wykonajLadujStarsze()
	{
		$cms = Cms::inst();
		
		$idUzytkownika = Zadanie::pobierzGet('uid', 'intval', 'abs');
		
		$dataOd = new \DateTime($cms->sesja->wiadomosciDataOd, new \DateTimeZone('Europe/Oslo'));
		$dataOd->modify("-1 day");
		$dataDo = new \DateTime($cms->sesja->wiadomosciDataOd, new \DateTimeZone('Europe/Oslo'));
		$dataDo->modify("-1 second");
		
		$dataOd->modify($this->k->k['historiaWiadomosci.pokazuj_wiadomosci_ile_wstecz']);
		
		$wiersze = $this->zwrocWierszeHistorii($idUzytkownika, $dataOd->format("Y-m-d H:i:s"), $dataDo->format("Y-m-d H:i:s"));
		
		if ($wiersze === 0) $wiersze = '';
		$dane = array(
			'status' => 1,
			'html' => $wiersze,
			'dataOd' => $dataOd->format("d-m-Y"),
		);
		echo json_encode($dane);
		die;
	}

	
	private function zwrocWierszeHistorii($idUzytkownika, $dataOd, $dataDo)
	{
		$cms = Cms::inst();
		$cms->sesja->wiadomosciDataOd = $dataOd;
		$cms->sesja->wiadomosciDataDo = $dataDo;
		
		$idNadawcy = Cms::inst()->profil()->id;
		$kryteriaSms = array(
			'id_sender' => $idNadawcy,
			'id_recipient' => $idUzytkownika,
			'date_sent_od' => $dataOd,
			'date_sent_do' => $dataDo,
		);
		$kryteriaMail = array(
			'idNadawcy' => $idNadawcy,
			'idOdbiorcy' => $idUzytkownika,
			'data_dodania_od' => $dataOd,
			'data_dodania_do' => $dataDo,
		);
		
		$smsy = $this->dane()->Sms()->zwracaTablice()->szukaj($kryteriaSms, null, new Sms\Sorter('date_sent', 'DESC'));
		
		$emaile = $this->dane()->EmailWpisKolejki()->zwracaTablice()->szukaj($kryteriaMail, null, new EmailWpisKolejki\Sorter('data_dodania', 'DESC'));
		
		$idsZamowien = array_filter(array_merge(listaZTablicy($smsy, null, 'id_object'), listaZTablicy($emaile, null, 'id_object')));
		$zamowienia = listaZTablicy($this->dane()->Zamowienie()->zwracaTablice('id', 'number_order_get', 'order_name')->pobierzPoWieleId($idsZamowien), 'id');
		
		/*
		 * @var $wiadomosci połączone wyniki SMSsów i Maili
		 * array(
		 *		'typ' => 'sms/mail',
		 *		'data' => 'data wysłania',
		 *		'nazwa_zamowienia' => 'string/null',
		 *		'wiadomosc' => 'string',
		 *		'status' => 'sent/not sent',
		 * )
		 */
		$wiadomosci = array();
		
		foreach ($smsy as $sms)
		{
			$wiadomosci[] = array(
				'id' => 'sms-'.$sms['id'],
				'typ' => 'SMS',
		 		'data' => $sms['date_sent'],
		 		'nazwa_zamowienia' => ($sms['id_object'] > 0 && isset($zamowienia[$sms['id_object']]) && $sms['object'] == 'Zamowienie') ? $zamowienia[$sms['id_object']]['order_name'] : '',
		 		'wiadomosc' => $sms['message'],
		 		'status' => $sms['sent'],
				'id_bkt' => ($sms['object'] == 'Zamowienie' && $sms['id_object'] > 0) ? $sms['id_object'] : '',
			);
		}
		
		foreach ($emaile as $email)
		{
			$wiadomosci[] = array(
				'id' => 'email-'.$email['id'],
				'typ' => 'Mail',
		 		'data' => $email['data_dodania'],
		 		'nazwa_zamowienia' => ($email['id_object'] > 0 && isset($zamowienia[$email['id_object']]) && $email['object'] == 'Zamowienie') ? $zamowienia[$email['id_object']]['order_name'] : '',
		 		'wiadomosc' => $email['email_tresc_txt'],
		 		'status' => ($email['bledy_licznik'] < 1) ? 'sent' : 'not_sent',
				'id_bkt' => ($email['object'] == 'Zamowienie' && $email['id_object'] > 0) ? $email['id_object'] : '',
			);
		}
		
		$kategoriaZamowien = $this->dane()->Kategoria()->pobierzPoKodModulu('Orders');
		
		$iloscWiadomosci = count($wiadomosci);
		if ($iloscWiadomosci > 0)
		{
			foreach ($wiadomosci as $k => $v){$kolumna[] = $v['data'];}
			array_multisort($kolumna, SORT_DESC, SORT_NATURAL, $wiadomosci);
			foreach ($wiadomosci as $wiadomosc)
			{
				$this->szablon->ustawBlok('historiaWiadomosci/wiersze/wiersz', array(
					'id' => $wiadomosc['id'],
					'typ' => $wiadomosc['typ'],
					'ikona' => ($wiadomosc['typ'] == 'SMS') ? 'icon-mobile-phone' : 'icon-envelope-alt',
					'data' => $wiadomosc['data'],
					'wo' => $wiadomosc['nazwa_zamowienia'],
					'tresc' => $wiadomosc['wiadomosc'],
					'status' => ($wiadomosc['status'] == 'sent') ? $this->j->t['historiaWiadomosci.etykiety_statusow']['sent'] : $this->j->t['historiaWiadomosci.etykiety_statusow']['not_sent'],
					'klasa' => ($wiadomosc['status'] == 'sent') ? 'success' : 'danger',
					'url_preview_order' => ($wiadomosc['id_bkt'] > 0) ? Router::urlAdmin($kategoriaZamowien, 'previewOrder', array('id' => $wiadomosc['id_bkt'])) : '',
				));
			}
		}
		else
		{
			return 0;
		}
		
		return $this->szablon->parsujBlok('historiaWiadomosci/wiersze', array());
	}
}


