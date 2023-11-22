<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Other\SMSApi;
use Other\SMSApiPSK;
use Generic\Model\Sms;
use Generic\Model\Uzytkownik;

class SmsNorwegia
{
	private $rodzajObiektu = null; // PSK || tel
	private $obiektyTransportujace = array(); // Tablica przechowujaca obiekty transportujace
	private $statusInfo = '';
	private $obiektSms = null; // Sms\Obiekt
	private $zezwolMiedzynarodoweSms = false;


	private $idReferencyjneSms = null;
			  
	
	/**
	 * Wysyła wiadomość SMS
	 * 
	 * @param mixed $do - Uzytkownik / norweski nr komórki / numer PSK (26114XXXXXXXXX)
	 * @param mixed $od - Uzytkownik / norweski nr komórki / 'system' - superadmin jeśli wysyłka systemowa
	 * @param string $wiadomosc - Treść wiadomosci UTF-8 do 612 znaków 
	 * @param string $kategoria - nazwa kategorii wiadomosci - będzie możliwość grupowania wysłanych wiadomości po kategoriach w przyszłości
	 * @param ObiektDanych $obiektPowiazany - obiekt połączony z wysłaną wiadomością np.: Zamowienie
	 * @return bool 
	 */
	public function wyslijSms($do, $od, $wiadomosc, $kategoria, $obiektPowiazany = null)
	{
		$cms = Cms::inst();
		
		$wiadomoscOrginal = $wiadomosc;
		
		//$wiadomosc = iconv('UTF-8', 'ISO-8859-1', $wiadomosc);
		//$wiadomosc = utf8_decode($wiadomosc);
		//$wiadomosc = mb_convert_encoding($wiadomosc, 'ISO-8859-1', 'UTF-8');
		if ($od == 'system')
		{
			$od = $this->pobierzSuperUzytkownika();
		}
		$blad = true;
		$numerDo = $this->zwrocNumerDo($do);
		
		if ($numerDo !== false)
		{
			$numerOd = $this->zwrocNumerOd($od);
			if ($numerOd !== false)
			{
				if ($this->ustawObiektTransportujacy())
				{
					$this->idReferencyjneSms = null;
					if ($this->rodzajObiektu == 'PSK')
					{
						// tryb testowy
						if($cms->config['sms_norwegia']['tryb_testowy']) $numerDo = $cms->config['sms_norwegia']['PSK_numer_testowy_do'];
						
						if($cms->config['sms_norwegia']['tryb_nie_wysylaj_sms'])
						{
							$this->statusInfo = 'Sms w trybie nie wysyłaj, jedynie zapis do bazy.';
						}
						else
						{
							$this->obiektTransportujacy['PSK']->send($numerDo, $numerOd, $wiadomosc);
							$this->statusInfo = $this->obiektTransportujacy['PSK']->getErrorMessages();
							if ($this->obiektTransportujacy['PSK']->isSent())
							{
								$blad = false;
							}
						}
						
					}
					else
					{
						$wiadomosc = iconv('UTF-8', 'ISO-8859-1', $wiadomosc);
						// tryb testowy
						if($cms->config['sms_norwegia']['tryb_testowy']) $numerDo = $cms->config['sms_norwegia']['numer_testowy_do'];
						
						if($cms->config['sms_norwegia']['tryb_nie_wysylaj_sms'])
						{
							$this->statusInfo = 'Sms w trybie nie wysyłaj, jedynie zapis do bazy.';
						}
						else
						{
							$this->obiektTransportujacy['tel']->send($numerDo, $wiadomosc);
							$this->statusInfo = $this->obiektTransportujacy['tel']->getErrorMessages();

							if ($this->obiektTransportujacy['tel']->isSent())
							{
								$blad = false;
								$this->idReferencyjneSms = $this->obiektTransportujacy['tel']->getMessageId();
							}
						}
					}
					$this->zapiszDoBazy($do, $od, $wiadomoscOrginal, $kategoria, $obiektPowiazany, !$blad);
				}
			}
		}
		
		if ($blad) // Obsługa bledu
		{
			if ($do instanceof Uzytkownik\Obiekt)
			{
				$numerDo = '['.$do->login.'], tel: '.$numerDo;
			}
			if ($od instanceof Uzytkownik\Obiekt)
			{
				$numerOd = '['.$od->login.'], tel: '.$numerOd;
			}
			
			$obiekt = 'brak';
			if ($obiektPowiazany !== null && is_object($obiektPowiazany))
			{
				$obiekt = get_class($obiektPowiazany).', id->'.$obiektPowiazany->id;
			}
			$user = Cms::inst()->profil()->login;
			$czas = date("Y-m-d H:i");
			$referer = (PHP_SAPI != 'cli') ? ', '.Zadanie::wywolanyUrl().', '.Zadanie::adresIp() : ', '.$_SERVER['SCRIPT_NAME'].', User:'.$_SERVER['USER'];

			error_log($user.'@'.$czas.', Do: '.$numerDo.', od: '.$numerOd.', wiadomosc: "'.$wiadomosc.'", kategoria: '.$kategoria.', obiekt powiazany: '.$obiekt.', API response: '.$this->statusInfo.' adres: '.$referer."\n", 3, LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-sms-error.log');
		}
		else
		{
			
		}
		
		return !$blad;
		
	}
	
	/*
	 * Wysyła istniejącą w bazie wiadomość sms 
	 * 
	 * @param int idSms - id wiadomości sms do ponownego wysłania
	 * 
	 */
	public function wyslijSmsPonownie($idSms)
	{
		if($idSms > 0)
		{
			$smsMapper = Cms::inst()->dane()->Sms();
			$obiektSms = $smsMapper->pobierzPoId($idSms);
			
			if($obiektSms instanceof Sms\Obiekt)
			{
				$this->obiektSms = $obiektSms;
				return $this->wyslijSms($obiektSms->recipientNumber, $obiektSms->senderNumber, $obiektSms->message, $obiektSms->type);
			}
			else
			{
				trigger_error('Wiadomość SMS którą próbujesz wysłać ponownie nie istnieje w bazie', E_USER_WARNING);
				return false;
			}
			
		}
	}
	
	private function ustawObiektTransportujacy()
	{
		$cms = Cms::inst();
		if ($this->rodzajObiektu == 'PSK')
		{
			if (isset($this->obiektTransportujacy['PSK']) && $this->obiektTransportujacy['PSK'] instanceof SMSApiPSK)
			{
				return true;
			}
			else
			{
				$this->obiektTransportujacy['PSK'] = new SMSApiPSK($cms->config['sms_norwegia']['serviceId'], $cms->config['sms_norwegia']['psk_password']);
			}
		}
		else if ($this->rodzajObiektu == 'tel')
		{
			if (isset($this->obiektTransportujacy['tel']) && $this->obiektTransportujacy['tel'] instanceof SMSApi)
			{
				return true;
			}
			else
			{
				$this->obiektTransportujacy['tel'] = new SMSApi($cms->config['sms_norwegia']['serviceId'], $cms->config['sms_norwegia']['fromId']);
			}
		}
		else
		{
			trigger_error('Klasa do wysylanie SMS nie byla w stanie okreslic rodzaju numeru na jaki chcesz wyslac SMS', E_USER_WARNING);
			return false;
		}
		return true;
	}
	
	private function zwrocNumerDo($do)
	{
		if ($do instanceof Uzytkownik\Obiekt)
		{
			$numer = $do->telKomorkaFirmowa;
		}
		else
		{
			$numer = $do;
		}
		
		if ($this->poprawnyNumerPSK($numer))
		{
			$this->rodzajObiektu = 'PSK';
		}
		else if ($this->poprawnyNumerTelefonu($this->filtrujNumerTelefonu($numer)))
		{
			$numer = $this->filtrujNumerTelefonu($numer);
			$this->rodzajObiektu = 'tel';
		}
		else
		{
			trigger_error('Podany docelowy numer nie jest prawidlowy, dozwolone sa norweski/szwedzki numer telefonu komorkowego lub nr PSK. Podano: '.$numer, E_USER_WARNING);
			return false;
		}
		return $numer;
	}
	
	private function zwrocNumerOd($od)
	{
		if ($od instanceof Uzytkownik\Obiekt)
		{
			$numer = $od->telKomorkaFirmowa;
		}
		else
		{
			$numer = $od;
		}
		if ($this->rodzajObiektu == 'PSK' && $this->poprawnyNumerTelefonu($this->filtrujNumerTelefonu($numer)))
		{
			$numer = $this->filtrujNumerTelefonu($numer);
			return $numer;
		}
		else if ($this->rodzajObiektu == 'tel' && $this->poprawnyNumerPSK($numer))
		{
			return $numer;
		}
		else
		{
			trigger_error('Podano nieprawidlowy numer od: "'.$numer.'", oczekiwano '.($this->rodzajObiektu == 'PSK') ? 'norweskiego/szwedzkiego numeru tel komórowego' : 'numeru PSK (26114XXXXXXXXX)', E_USER_WARNING);
			return false;
		}
	}
	
	private function zwrocIdWysylajacego($od)
	{
		$idWysylajacego = null;
		
		if ($od instanceof Uzytkownik\Obiekt)
		{
			$u = Cms::inst()->profil();
			if ($od->id != $u->id && $u instanceof Uzytkownik\Obiekt)
				$idWysylajacego = $u->id;
			else
				$idWysylajacego = $od->id;
		}
		
		return $idWysylajacego;
		
	}
	
	private function zwrocIdOdbiorcy($do)
	{
		$idOdbiorcy = null;
		
		if ($do instanceof Uzytkownik\Obiekt)
		{
			$idOdbiorcy = $do->id;
		}
		
		return $idOdbiorcy;
	}

	private function poprawnyNumerTelefonu($numer)
	{
		if ($this->zezwolMiedzynarodoweSms) return true;
		if ((\strlen($numer) == 12 && (\strpos($numer, '00474') !== false || \strpos($numer, '00479') !== false)) || (\strlen($numer) == 13 && \strpos($numer, '00467') !== false))
		{
			return true;
		}
		return false;
	}
	
	private function poprawnyNumerPSK($numer)
	{
		if (strpos($numer, '26114') !== false && strlen($numer) == 14)
		{
			return true;
		}
		return false;
	}
	
	private function filtrujNumerTelefonu($numer)
	{
		$numer = str_replace(array('+', ' ', '  ', '-', '(', ')'), '', $numer);
		$numer = ((substr($numer, 0, 2) == '00') ? '' : '00').$numer;
		
		return $numer;
	}
	
	private function pobierzSuperUzytkownika()
	{
		$od = new Uzytkownik\Obiekt();
		$od->superUzytkownik(Cms::inst()->config['superuzytkownik']);
		
		return $od;
	}

	private function poprawnyObiektPowiazany($obiektPowiazany)
	{
		if(is_object($obiektPowiazany) && $obiektPowiazany->id > 0)
		{
			return true;
		}
		else
		{
			trigger_error('Błąd. Podana wartość nie jest objektem .', E_USER_WARNING);
			return false;
		}
	}
	
	private function pobierzTypObiektPowiazany($obiektPowiazany)
	{
		$chunks = explode('\\', get_class($obiektPowiazany));
		return $chunks[count($chunks)-2];
	}
	
	/**
	 * Zapisuje wiadomość SMS do bazy
	 * 
	 * @param mixed $do - Uzytkownik / norweski nr komórki / numer PSK (26114XXXXXXXXX)
	 * @param mixed $od - Uzytkownik / norweski nr komórki / 'system' - superadmin jeśli wysyłka systemowa
	 * @param string $wiadomosc - Treść wiadomosci UTF-8 do 612 znaków 
	 * @param string $kategoria - nazwa kategorii wiadomosci - będzie możliwość grupowania wysłanych wiadomości po kategoriach w przyszłości
	 * @param ObiektDanych $obiektPowiazany - obiekt połączony z wysłaną wiadomością np.: Zamowienie
	 * @param bool $czyWyslane - 1 - wiadomość wysłana / 0 wiadomość nie wysłana
	 */
	public function zapiszDoBazy($do, $od, $wiadomosc, $kategoria, $obiektPowiazany, $czyWyslane)
	{
		$mapperSms = Cms::inst()->dane()->Sms();
		if($this->obiektSms instanceof Sms\Obiekt)
		{
			$obiektSms = $this->obiektSms;
		}
		else 
		{
			$obiektSms = new Sms\Obiekt();
			$obiektSms->idProjektu = ID_PROJEKTU;
			if($obiektPowiazany != null && $this->poprawnyObiektPowiazany($obiektPowiazany))
			{
				$obiektSms->object = $this->pobierzTypObiektPowiazany($obiektPowiazany);
				$obiektSms->idObject = $obiektPowiazany->id;
			}
			$obiektSms->idSender = $this->zwrocIdWysylajacego($od);
			$obiektSms->idRecipient = $this->zwrocIdOdbiorcy($do);
		}
		
		
		$obiektSms->idSmsReference = $this->idReferencyjneSms;

		$obiektSms->message  = $wiadomosc;
		$obiektSms->type = $kategoria;
		$obiektSms->dateSent = date('Y-m-d H:i:s');
		$obiektSms->recipientNumber = $this->zwrocNumerDo($do);
		$obiektSms->senderNumber = $this->zwrocNumerOd($od);
		$obiektSms->statusInfo   = $this->statusInfo;
		$obiektSms->sent = $czyWyslane;
		
		// $obiektSms->requireSend = ''
		// $obiektSms->dateDelivered = '';
		
		if(!$obiektSms->zapisz($mapperSms))
		{
			trigger_error('Nie udało się zapisać wiadomości sms', E_USER_NOTICE);
			return false;
		}
		return true;
		
	}
	
	public function pobierzBlad()
	{
		return $this->statusInfo;
	}
	
	public function pozwolNaMiedzynarodoweSms()
	{
		$this->zezwolMiedzynarodoweSms = true;
	}
	
	public function zabronNaMiedzynarodoweSms()
	{
		$this->zezwolMiedzynarodoweSms = false;
	}
}
