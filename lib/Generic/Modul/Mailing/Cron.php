<?php
namespace Generic\Modul\Mailing;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Sterownik;
use Generic\Model\Kategoria;
use Generic\Model\Blok;
use Generic\Biblioteka\Cms;
use Generic\Model;
use Generic\Biblioteka\Pomocnik;


/**
 * Moduł obsługujący wysylanie mailingu.
 *
 * @author Konrad Rudowski
 * @package moduly
 */

class Cron extends Modul\Cron
{

	/**
	 * @var \Generic\Konfiguracja\Modul\Mailing\Cron
	 */
	protected $k;


	/**
	 * opisy ustawien konfiguracyjnych
	 * @var array
	 */
	protected $opisKonfiguracji = array(
	);


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Mailing\Cron
	 */
	protected $j;


	protected $uprawnienia = array(
		'wykonajWyslijMailing',
	);


	protected $zdarzenia = array(
		'wyslano_mailing'
	);

	//uchwyty do plikow
	protected $plikOdbiorcy, $plikBledy, $plikWykonane;


	public function inicjuj(Sterownik $sterownik, Kategoria\Obiekt $kategoria = null, Blok\Obiekt $blok = null)
	{
		parent::inicjuj($sterownik, $kategoria, $blok);
		//to trzeba naprawic - tylko obejscie niewczytania konfiguracji - brakuje ponizeszgo _p_
		$this->cms = Cms::inst();
		$this->cms->konfiguracjaPlik();
		$this->ladujKonfiguracje();
	}



	public function wykonajWyslijMailing()
	{
		$zadanieCron = Cms::inst()->temp('zadanie');

		$mailingMapper = $this->dane()->Mailing();

		$mailing = $mailingMapper->pobierzPoIdZadaniaCron($zadanieCron->id);

		if ($mailing instanceof Model\Mailing\Obiekt)
		{
			$listaOdbiorcow = $this->pobierzListeOdbiorcow($mailing);

			$listaAdresow = array();
			foreach ($listaOdbiorcow as $odbiorca)
			{
				$listaAdresow[] = $odbiorca[0];
			}

			$mapperUzytkownicy = $this->dane()->Uzytkownik();
			//sprawdzamy zgode otrzymywanie mailingow  -zwracana jest lista emaili ze zgodą
			$uzytkownicyZeZgoda = $mapperUzytkownicy->zwracaTablice(array('email'))->sprawdzZgodaMailing($listaAdresow);

			if (count($uzytkownicyZeZgoda))
			{
				$tmp = array();
				foreach($uzytkownicyZeZgoda as $wiersz)
				{
					$tmp[] = $wiersz['email'];
				}
				$uzytkownicyZeZgoda = $tmp;
			}

			foreach ($listaOdbiorcow as $odbiorca)
			{

				if (in_array($odbiorca[0], $uzytkownicyZeZgoda) || $mailing->pominSprawdzanieZgody)
				{
					if ($this->wyslijEmail($mailing, $odbiorca))
					{
						fwrite($this->plikWykonane, implode(',',$odbiorca)."\n");
						++$mailing->ileWyslano;
					}
					else
					{
						fwrite($this->plikBledy, implode(',',$odbiorca)."\n");
						++$mailing->ileBledow;
					}
				}
				else
				{
					fwrite($this->plikBledy, implode(',',$odbiorca)."\n");
					++$mailing->ileBledow;
				}
			}

			if ( ! (count($listaOdbiorcow) && $mailing->ileAdresow > ($mailing->ileWyslano + $mailing->ileBledow)))
			{
				//nie bylo juz odbiorcow
				$cronMapper = $this->dane()->ZadanieCykliczne();
				$cronMapper->usun($zadanieCron);

				$mailing->ileBledow = $mailing->ileAdresow - $mailing->ileWyslano;

				$this->wyslijRaport($mailing);
			}

			$mailing->zapisz($this->dane()->Mailing());

			$this->zwolnijUchwytyPlikow();

			$dodatkowe_dane = array(
				'wyslano' => $mailing->ileWyslano,
				'bledow' => $mailing->ileBledow,
				'ileAdresow' => $mailing->ileAdresow,
				'nazwa' => $mailing->nazwa,
			);
			$this->zdarzenie('wyslano_mailing', $dodatkowe_dane);
		}
	}



	protected function wyslijRaport(Model\Mailing\Obiekt $mailing)
	{
		$modulAdmin = new Mailing\Admin();
		$modulAdmin->ladujKonfiguracje();
		$konfiguracja = $modulAdmin->pobierzAktualnaKonfiguracje();

		if ( ! $konfiguracja['raport.wysylaj'])
		{
			return true;
		}

		$dane = array(
			'obiekt_Mailing' => $mailing,
			'aktualnaData' => date('d.m.Y H:i:s'),
			'listaWyslane' => file_get_contents(str_replace('doWysylki.csv', 'wykonane.csv', $mailing->plikZLista)),
			'listaBledy' => file_get_contents(str_replace('doWysylki.csv', 'bledy.csv', $mailing->plikZLista)),
		);

		$poczta = new Pomocnik\Poczta($konfiguracja['raport.id_formatki_email'], $dane);
		return $poczta->wyslij();
	}


	protected function pobierzUchwytyPlikow(Model\Mailing\Obiekt $mailing)
	{
		//zakladamy blokady na pliki - nikt w tym samym czasie nie moze wylonywac na nich operacji
		//zapobiega to nalozeniu sie wykonywanych zadan
		$this->plikOdbiorcy = fopen($mailing->plikZLista, 'r');
		$this->plikWykonane = fopen(str_replace('doWysylki.csv', 'wykonane.csv', $mailing->plikZLista), 'c+');
		$this->plikBledy = fopen(str_replace('doWysylki.csv', 'bledy.csv', $mailing->plikZLista), 'c+');
		if (flock($this->plikOdbiorcy, LOCK_EX) && flock($this->plikWykonane, LOCK_EX) && flock($this->plikBledy, LOCK_EX))
		{
			return true;
		}
		else
		{
			return false;
		}
	}



	protected function zwolnijUchwytyPlikow()
	{
		flock($this->plikOdbiorcy, LOCK_UN);
		flock($this->plikWykonane, LOCK_UN);
		flock($this->plikBledy, LOCK_UN);

		fclose($this->plikOdbiorcy);
		fclose($this->plikWykonane);
		fclose($this->plikBledy);
	}



	protected function pobierzListeOdbiorcow(Model\Mailing\Obiekt $mailing)
	{
		$listaWynikowa = array();

		$modulAdmin = new Mailing\Admin();
		$modulAdmin->ladujKonfiguracje();
		$konfiguracja = $modulAdmin->pobierzAktualnaKonfiguracje();

		if ($this->pobierzUchwytyPlikow($mailing))
		{
			$ostatniOdbiorca = $this->pobierzOstatniZPliku($this->plikWykonane);
			$ostatniOdbiorcaBlad = $this->pobierzOstatniZPliku($this->plikBledy);
			$listaOdbiorcow = $this->pobierzWszystkoZPliku($this->plikOdbiorcy);
			$start = $this->sprawdzPozycjeOdbiorcy($listaOdbiorcow, $ostatniOdbiorca) + 1;
			$start2 = $this->sprawdzPozycjeOdbiorcy($listaOdbiorcow, $ostatniOdbiorcaBlad) + 1;

			//wybranie wyzszej pozycji
			$start = $start2 > $start?$start2:$start;

			$iluOdbiorcow = count($listaOdbiorcow);

			for ($i = $start; $i < $iluOdbiorcow && $i < ($start + $konfiguracja['mailing.ilosc_wysylanych_jednorazowo']); ++$i)
			{
				$listaWynikowa[] = $listaOdbiorcow[$i];
			}
		}

		return $listaWynikowa;
	}



	protected function pobierzWszystkoZPliku($uchwyt)
	{
		$dane = array();

		while ($linia = fgets($uchwyt, 1000))
		{
			if (($rekord = $this->parsujLiniePliku($linia)) !== null)
			{
				$dane[] = $rekord;
			}
		}
		return $dane;
	}



	protected function pobierzOstatniZPliku($uchwyt)
	{
		$liniaNiePusta='';
		while ($linia = fgets($uchwyt))
		{
			$linia = trim($linia);
			if ($linia != null && $linia != '')
			{
				$liniaNiePusta = $linia;
			}
		}

		return $this->parsujLiniePliku($liniaNiePusta);
	}



	protected function parsujLiniePliku($linia)
	{
		if (strlen(trim($linia)))
		{
			$linia = explode(',', trim($linia));
			if (isset($linia[1]) && strlen($linia[1])>0)
				return array(trim($linia[0]), trim($linia[1]));
			else
				return array(trim($linia[0]), '');
		}
		else
		{
			return false;
		}
	}


	protected function sprawdzPozycjeOdbiorcy($listaOdbiorcow, $odbiorca)
	{
		if (!is_array($odbiorca))
			return -1;

		foreach ($listaOdbiorcow as $klucz => $wartosc)
		{
			if ($wartosc[0] === $odbiorca[0])
				return $klucz;
		}
	}



	protected function wyslijEmail(Model\Mailing\Obiekt $mailing, $odbiorca)
	{
		if (count($odbiorca > 1))
		{
			$odbiorcy = array($odbiorca[0] => $odbiorca[1]);
		}
		else
		{
			$odbiorcy = array($odbiorca[0]);
		}

		$poczta = new Pomocnik\Poczta();
		$poczta->wczytajUstawienia(array(
			'zapiszStanWKolejce' => false,
			'emailNadawcaEmail' => $mailing->emailNadawcy,
			'emailNadawcaNazwa' => $mailing->nazwaNadawcy,
			'emailOdbiorcy' => $odbiorcy,
			'emailTytul' => $mailing->tytul,
			'emailTrescHtml' => $mailing->trescHtml,
			'emailTrescTxt' => $mailing->tresc,
			'emailSzablon' => $mailing->zaladujSzablon > 0 ? 1 : 0,
		));
		return $poczta->wyslij();
	}
}