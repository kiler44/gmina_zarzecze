<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Model\Wizytowka;
use Generic\Model\Uzytkownik;
use Generic\Model\WizytowkaObciazeniePracownika;
use Generic\Biblioteka\Sterownik;
use Generic\Modul\KontoSerwisowe;

/**
 * Zawiera w sobie mechnikę rozdzielania wizytówek.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class RozdzielanieWizytowek
{
	protected $cms;

	protected $dolnyLimitObciazenia = 0;

	protected $gornyLimitObciazenia = 0;

	protected $okresWyliczaniaStatystyk = '-3 month';

	protected $typDzialania = 'wypelnianie';

	protected $godzinRoboczych = 8;

	protected $uwzgledniajWeekendy = true;

	protected $uwzgledniajUrlopy = true;

	protected $trybPracy = 'czasowy';

	protected $kodyRol = array('otrzymujezad');

	protected $automatWlaczony = true;

	public function __construct()
	{
		$this->cms = Cms::inst();

		$this->cms->config;

		if (isset($this->cms->config['rozdzielanie_wizytowek']['automat_wlaczony']))
		{
			$this->automatWlaczony = $this->cms->config['rozdzielanie_wizytowek']['automat_wlaczony'];
		}

		if (isset($this->cms->config['rozdzielanie_wizytowek']['okres_wyliczania_statystyk']) && $this->cms->config['rozdzielanie_wizytowek']['okres_wyliczania_statystyk'] != '')
		{
			$this->okresWyliczaniaStatystyk = $this->cms->config['rozdzielanie_wizytowek']['okres_wyliczania_statystyk'];
		}

		if (isset($this->cms->config['rozdzielanie_wizytowek']['godzin_roboczych_dziennie']) && $this->cms->config['rozdzielanie_wizytowek']['godzin_roboczych_dziennie'] > 0 && $this->cms->config['rozdzielanie_wizytowek']['godzin_roboczych_dziennie'] < 24)
		{
			$this->godzinRoboczych = $this->cms->config['rozdzielanie_wizytowek']['godzin_roboczych_dziennie'];
		}

		if (isset($this->cms->config['rozdzielanie_wizytowek']['uwzgledniaj_weekendy']))
		{
			$this->uwzgledniajWeekendy = $this->cms->config['rozdzielanie_wizytowek']['uwzgledniaj_weekendy'];
		}

		if (isset($this->cms->config['rozdzielanie_wizytowek']['uwzgledniaj_urlopy']))
		{
			$this->uwzgledniajUrlopy = $this->cms->config['rozdzielanie_wizytowek']['uwzgledniaj_urlopy'];
		}

		if (isset($this->cms->config['rozdzielanie_wizytowek']['tryb_pracy']))
		{
			$this->trybPracy = $this->cms->config['rozdzielanie_wizytowek']['tryb_pracy'] == 'wagowy' ? 'wagowy' : 'czasowy';
		}

		if (isset($this->cms->config['rozdzielanie_wizytowek']['kody_rol']) && is_array($this->cms->config['rozdzielanie_wizytowek']['kody_rol']))
		{
			$this->kodyRol = $this->cms->config['rozdzielanie_wizytowek']['kody_rol'];
		}

	}


	public function ustawDolnyLimitObciazenia($limit)
	{
		if ($limit > 0)
		{
			$this->dolnyLimitObciazenia = intval($limit);
		}
	}


	public function ustawGornyLimitObciazenia($limit)
	{
		if ($limit > 0)
		{
			$this->gornyLimitObciazenia = intval($limit);
		}
	}


	public function przydzielWizytowkePracownikowi(Wizytowka\Obiekt $wizytowka, Uzytkownik\Obiekt $pracownik, $zmienStatusWizytowki = true)
	{

		if ( ! $this->zapiszNoweObciazenie($wizytowka, $pracownik))
		{
			return false;
		}

		$wizytowka->idPracownika = $pracownik->id;

		if (strpos($wizytowka->statusWypelnienia, 'wykonan') === false)
		{
			if ( ! $this->zapiszStatusWizytowki($wizytowka, 'nowy', $zmienStatusWizytowki))
			{
				return false;
			}
		}


		return true;
	}


	public function przydzielWizytowkePoOdnowieniu(Wizytowka\Obiekt $wizytowka)
	{

		if ( ! $this->zapiszNoweObciazenie($wizytowka, null, true))
		{
			return false;
		}

		if ( ! $this->zapiszStatusWizytowki($wizytowka, 'uaktualnienie'))
		{
			return false;
		}

		return true;


	}

	protected function zapiszNoweObciazenie(Wizytowka\Obiekt $wizytowka, $pracownik = null, $odnowienie = false)
	{
		$kryteria = array(
			'status_rozny' => 'anulowane',
			'id_wizytowki' => $wizytowka->id,
			'typ_dzialania' => $this->typDzialania,
		);

		if ($odnowienie)
		{
			unset($kryteria['status_rozny']);
			$kryteria['status'] = 'przydzielone';
		}

		$istniejaceObciazenie = $this->cms->dane()->WizytowkaObciazeniePracownika()->szukaj($kryteria);

		$noweObciazenie = new WizytowkaObciazeniePracownika\Obiekt();

		if (isset($istniejaceObciazenie[0]) && $istniejaceObciazenie[0] instanceof WizytowkaObciazeniePracownika\Obiekt)
		{
			if ($istniejaceObciazenie[0]->idPracownika == $pracownik->id && ! $odnowienie)
			{
				trigger_error('Wizytówka jest już przypisana do podanego pracownika.', E_USER_WARNING);
				return true; // true ponieważ tutaj nie zachodzi zmiana w obciążeniach - to nie jest błąd.
			}

			$poprzedniStatusObciazenia = $istniejaceObciazenie[0]->status;
			$istniejaceObciazenie[0]->status = 'anulowane';

			if ( ! $istniejaceObciazenie[0]->zapisz($this->cms->dane()->WizytowkaObciazeniePracownika()))
			{
				trigger_error('Bład zapisu obciążenia.', E_USER_WARNING);
				return false;
			}

			$noweObciazenie->liczbaUzupelnien = $istniejaceObciazenie[0]->liczbaUzupelnien;
			$noweObciazenie->waga = $istniejaceObciazenie[0]->waga - $istniejaceObciazenie[0]->wagaWykorzystana;
			$noweObciazenie->dataStart = $istniejaceObciazenie[0]->dataKoniec != '' ? $istniejaceObciazenie[0]->dataStart : null;
			$noweObciazenie->dataKoniec = $istniejaceObciazenie[0]->dataKoniec;
			$noweObciazenie->status = $poprzedniStatusObciazenia;
		}
		else
		{
			$noweObciazenie->liczbaUzupelnien = $this->cms->dane()->OgloszenieUzupelnienie()->iloscZakupionychDlaIdWizytowki($wizytowka->id);
			$noweObciazenie->waga = $this->obliczWageWizytowki($wizytowka);
			$noweObciazenie->status = strpos($wizytowka->statusWypelnienia, 'wykonan') !== false ? 'wykonane' : 'przydzielone';
		}

		$noweObciazenie->liczbaUzupelnien = $noweObciazenie->liczbaUzupelnien > 0 ? $noweObciazenie->liczbaUzupelnien : 0;

		$noweObciazenie->idProjektu = ID_PROJEKTU;
		$noweObciazenie->kodJezyka = KOD_JEZYKA;
		$noweObciazenie->idPracownika = $odnowienie ? $wizytowka->idPracownika : $pracownik->id;
		$noweObciazenie->idTypuKonta = $wizytowka->idTypuKonta;
		$noweObciazenie->typDzialania = $this->typDzialania;
		$noweObciazenie->exp = 0;
		$noweObciazenie->idWizytowki = $wizytowka->id;
		$noweObciazenie->wagaWykorzystana = 0;


		if ( ! $noweObciazenie->zapisz($this->cms->dane()->WizytowkaObciazeniePracownika()))
		{
			trigger_error('Bład zapisu obciążenia wizytówki o ID='. $wizytowka->id .'.', E_USER_WARNING);
			return false;
		}

		return true;
	}

	protected function zapiszStatusWizytowki(Wizytowka\Obiekt $wizytowka, $status, $zmienStatusWizytowki = true)
	{
		if ($zmienStatusWizytowki)
		{
			$wizytowka->statusWypelnienia = $status;
		}

		if ( ! $wizytowka->zapisz($this->cms->dane()->Wizytowka()))
		{
			trigger_error('Bład zapisu wizytowki o ID='. $wizytowka->id .' .', E_USER_WARNING);
			return false;
		}

		return true;
	}


	public function zapiszRozpoczeciePracyNadWizytowka(Wizytowka\Obiekt $wizytowka, $dataRozpoczecia = null)
	{
		$obciazenie = $this->cms->dane()->WizytowkaObciazeniePracownika()->szukaj(array(
			'status' => 'przydzielone',
			'id_wizytowki' => $wizytowka->id,
			'typ_dzialania' => $this->typDzialania,
		));

		if ( ! (isset($obciazenie[0])  && $obciazenie[0] instanceof WizytowkaObciazeniePracownika\Obiekt))
		{
			//trigger_error('Obciążenie dla podanej wizytówki nie istnieje.', E_USER_WARNING);
			return false;
		}

		if ($obciazenie[0]->dataStart != '')
		{
			return true;
		}

		$obciazenie[0]->dataStart = $dataRozpoczecia != null ? $dataRozpoczecia : date('Y-m-d H:i:s');

		if ( ! $obciazenie[0]->zapisz($this->cms->dane()->WizytowkaObciazeniePracownika()))
		{
			trigger_error('Bład zapisu obciążenia wizytówki o ID='. $wizytowka->id .' .', E_USER_WARNING);
			return false;
		}
		else
		{
			return true;
		}
	}

	public function zapiszZakonczeniePracyNadWizytowka(Wizytowka\Obiekt $wizytowka, $dataZakonczenia = null)
	{
		$obciazenie = $this->cms->dane()->WizytowkaObciazeniePracownika()->szukaj(array(
			'status' => 'przydzielone',
			'id_wizytowki' => $wizytowka->id,
			'typ_dzialania' => $this->typDzialania,
		));

		if ( ! (isset($obciazenie[0])  && $obciazenie[0] instanceof WizytowkaObciazeniePracownika\Obiekt))
		{
			trigger_error('Obciążenie wizytówki o ID='. $wizytowka->id .' nie istnieje.', E_USER_WARNING);
			return true;
		}

		if ($obciazenie[0]->dataStart == null || $obciazenie[0]->dataStart == '0000-00-00 00:00:00' || $obciazenie[0]->status =='anulowane' || $obciazenie[0]->status =='wykonane')
		{
			trigger_error('Obciążenie wizytówki o ID='. $wizytowka->id .' nie jest w trakcie wypełniania.', E_USER_WARNING);
			return false;
		}

		$obciazenie[0]->dataKoniec = $dataZakonczenia != null ? $dataZakonczenia : date('Y-m-d H:i:s');
		$obciazenie[0]->przepracowaneGodziny = $this->obliczPrzepracowaneGodziny($obciazenie[0]);
		$obciazenie[0]->wagaWykorzystana = $this->obliczWykorzystanaWage($wizytowka, $obciazenie[0]);
		$obciazenie[0]->exp = $this->obliczExpZaObciazenie($obciazenie[0]);
		$obciazenie[0]->status = 'wykonane';


		if ( ! $obciazenie[0]->zapisz($this->cms->dane()->WizytowkaObciazeniePracownika()))
		{
			trigger_error('Bład zapisu obciążenia wizytówki o ID='. $wizytowka->id .'.', E_USER_WARNING);
			return false;
		}
		else
		{
			return true;
		}
	}

	protected function obliczPrzepracowaneGodziny(WizytowkaObciazeniePracownika\Obiekt $obciazenie)
	{
		if ($obciazenie->dataStart == '' || $obciazenie->dataKoniec == '')
		{
			return null;
		}

		$dataStart = new \DateTime($obciazenie->dataStart);
		$dataKoniec = new \DateTime($obciazenie->dataKoniec);
		$czasPracy = $dataKoniec->diff($dataStart);

		$dniPracy = $czasPracy->d;

		if ($this->uwzgledniajWeekendy)
		{
			if ($dataStart->format('W') < $dataKoniec->format('W'))
			{
				$dniPracy -= 2 * ($dataKoniec->format('W') - $dataStart->format('W'));
			}
		}

		if ($this->uwzgledniajUrlopy)
		{
			$pracownik = $this->cms->dane()->Uzytkownik()->pobierzPoId($obciazenie->idPracownika);

			$dniPracy -= $this->cms->dane()->UrlopPracownika()->iloscDniWolnychDlaPracownika($pracownik->id, $dataStart->format('Y-m-d 00:00:00'), $dataKoniec->format('Y-m-d 23:23:59'));
		}

		$resztaGodzin = $czasPracy->h;

		if ($resztaGodzin > $this->godzinRoboczych)
		{
			$resztaGodzin -= 24 - $this->godzinRoboczych;
		}

		$liczbaGodzinPracy = $dniPracy * ($this->godzinRoboczych) + $resztaGodzin;

		if ($czasPracy->i > 45)
		{
			$liczbaGodzinPracy += 1;
		}

		if ($liczbaGodzinPracy < 1)
		{
			$liczbaGodzinPracy = 1;
		}

		return $liczbaGodzinPracy;

	}

	protected function obliczWykorzystanaWage(Wizytowka\Obiekt $wizytowka, WizytowkaObciazeniePracownika\Obiekt $obciazenie)
	{
		$koncoweSaldo = $this->cms->dane()->OgloszenieUzupelnienie()->saldoDlaIdWizytowki($wizytowka->id);

		return $obciazenie->waga - $koncoweSaldo;
	}

	protected function obliczExpZaObciazenie(WizytowkaObciazeniePracownika\Obiekt $obciazenie)
	{
		if ($obciazenie->przepracowaneGodziny > 0 && $obciazenie->wagaWykorzystana)
		{
			return intval($obciazenie->wagaWykorzystana * ($obciazenie->wagaWykorzystana / $obciazenie->przepracowaneGodziny) * 10);
		}
		else
		{
			return null;
		}
	}


	public function przydzielWizytowkeAutomatycznie(Wizytowka\Obiekt $wizytowka)
	{

		if ( ! $this->automatWlaczony)
		{
			trigger_error('Automatyczne przydzielanie wizytówek jest WYŁĄCZONE!.', E_USER_WARNING);
			return true;
		}

		$pracownik = null;

		if ($this->trybPracy == 'czasowy')
		{
			$pracownik = $this->zwrocPracownikaZNajnizszymObciazeniemCzasowymDlaWizytowki($wizytowka, $wizytowka->idPracownika);
		}
		else
		{
			$pracownik = $this->zwrocPracownikaZNajnizszymObciazeniemWagowym($wizytowka->idPracownika);
		}

		$poprzednieIdPracownika = $wizytowka->idPracownika;


		if($this->przydzielWizytowkePracownikowi($wizytowka, $pracownik))
		{

			$czyPowiadomicKlienta = true;
			$czyPierwszePrzypisanie = ($poprzednieIdPracownika == 0) ? true : false;
			$sterownik = new Sterownik('Http');
			$kategoria = $this->cms->dane()->Kategoria()->pobierzDlaModulu('KontoSerwisowe');
			$kontoSerwisowe = new KontoSerwisowe\Http();
			$kontoSerwisowe->inicjuj($sterownik, $kategoria[0]);
			$kontoSerwisowe->wyslijPowiadomienieZmianyOpiekunaWizytowki($wizytowka, $pracownik->id, $czyPowiadomicKlienta, $czyPierwszePrzypisanie, $poprzednieIdPracownika);

			return true;

		}
		else
		{
			return false;
		}

	}


	public function zwolnijObciazeniePracownika(Uzytkownik\Obiekt $pracownik)
	{
		$obciazenia = $this->cms->dane()->WizytowkaObciazeniePracownika()->szukaj(array(
			'id_pracownika' => $pracownik->id,
			'status' => 'przydzielone'
		));

		foreach ($obciazenia as $obciazenie)
		{
			/* @var $obciazenie WizytowkaObciazeniePracownika */
			$this->przydzielWizytowkeAutomatycznie($this->cms->dane()->Wizytowka()->pobierzPoId($obciazenie->idWizytowki));
		}
	}


	protected function zwrocPracownikaZNajnizszymObciazeniemCzasowymDlaWizytowki(Wizytowka\Obiekt $wizytowka, $pomijajIdPracownika = null)
	{
		$pracownicy =  $this->pobierzAktywnychPracownikow();

		$obciazenia = listaZTablicy($this->cms->dane()->WizytowkaObciazeniePracownika()->pobierzObciazeniePracownikow($this->typDzialania), 'id_pracownika');

		$wagaWizytowki = $this->obliczWageWizytowki($wizytowka);

		$dataStart = new \DateTime('now');

		$minimalnaLiczbaDni = 999999;
		$pracownikDoZwrotu = null;

		foreach ($pracownicy as $pracownik)
		{
			if ($pracownik->id == $pomijajIdPracownika)
			{
				continue;
			}

			$aktualneObciazenieWagowe = (isset($obciazenia[$pracownik->id]) ? $obciazenia[$pracownik->id]['obciazenie'] : 0);
			$noweObciazenieWagowe = $wagaWizytowki + $aktualneObciazenieWagowe;

			$estymowanyCzasPracy = $noweObciazenieWagowe / $this->obliczPredkoscPracyPracownika($pracownik);

			$liczbaDni = $this->obliczDniRoboczeDlaPracownika($pracownik, $estymowanyCzasPracy, $dataStart);

			if ($liczbaDni <= 1 && $aktualneObciazenieWagowe < 1)
			{
				return $pracownik;
			}
			elseif($liczbaDni < $minimalnaLiczbaDni)
			{
				$minimalnaLiczbaDni = $liczbaDni;
				$pracownikDoZwrotu = $pracownik;
			}

		}

		return  $pracownikDoZwrotu;
	}

	public function obliczPredkoscPracyPracownika(Uzytkownik\Obiekt $pracownik)
	{
		$kryteria = array(
			'id_pracownika' => $pracownik->id,
			'typ_dzialania' => $this->typDzialania,
			'status' => 'wykonane',
			'data_koniec_wieksza' => strtotime($this->okresWyliczaniaStatystyk),
		);

		$wykonaneObciazenia = $this->cms->dane()->WizytowkaObciazeniePracownika()->zwracaTablice()->szukaj($kryteria);

		$sumaWykorzystaneObciazenia = 0;
		$sumaPrzepracowaneGodziny = 0;

		foreach($wykonaneObciazenia as $obciazenie)
		{
			$sumaWykorzystaneObciazenia += $obciazenie['waga_wykorzystana'];
			$sumaPrzepracowaneGodziny += $obciazenie['przepracowane_godziny'];
		}

		if ($sumaPrzepracowaneGodziny > 0)
		{
			return $sumaWykorzystaneObciazenia / $sumaPrzepracowaneGodziny;
		}
		else
		{
			return 2;
		}
	}


	protected function obliczDniRoboczeDlaPracownika(Uzytkownik\Obiekt $pracownik, $estymowanyCzasPracy, \DateTime $dataStart)
	{
		$liczbaDni = round($estymowanyCzasPracy / $this->godzinRoboczych, 0);

		if ($this->uwzgledniajWeekendy)
		{
			$liczbaWeekendow = intval($liczbaDni / 5);

			$pozostaleDni = $liczbaDni - 5 * $liczbaWeekendow;

			if ($pozostaleDni + $dataStart->format('w') >= 6)
			{
				$liczbaWeekendow += 1;
			}

			$liczbaDni += $liczbaWeekendow * 2;
		}

		if ($this->uwzgledniajUrlopy)
		{
			$liczbaDni += $this->obliczDniUrlopuDlaPracownika($pracownik, $dataStart, $liczbaDni);
		}

		return $liczbaDni;
	}

	protected function obliczDniUrlopuDlaPracownika(Uzytkownik\Obiekt $pracownik, \DateTime $dataStart, $liczbaDni)
	{

		$dataKoniec = new \DateTime($dataStart->format('Y-m-d'));
		$dataKoniec->modify('+ ' . $liczbaDni . 'day');

		$dniUrlopu = 0;
		$liczbaIteracji = 0;

		while (($noweDniUrlopu = $this->cms->dane()->UrlopPracownika()->iloscDniWolnychDlaPracownika($pracownik->id, $dataStart->format('Y-m-d'), $dataKoniec->format('Y-m-d'))) != $dniUrlopu)
		{
			$dataKoniec->modify('+ ' . abs($noweDniUrlopu - $dniUrlopu) . 'day');
			$dniUrlopu = $noweDniUrlopu;
			//To jest zabezpiczenie przed długim czasem wykonania
			if ($liczbaIteracji > 5)
			{
				break;
			}
		}

		return $dniUrlopu;
	}


	public function ustawStatusObciazeniaWizytowkaAnulowana(Wizytowka\Obiekt $wizytowka)
	{
		$obciazenie = $this->cms->dane()->WizytowkaObciazeniePracownika()->szukaj(array(
			'id_wizytowki' => $wizytowka->id,
			'status' => 'przydzielone',
			'typ_dzialania' => $this->typDzialania,
			));

		if (isset($obciazenie[0]) && $obciazenie[0] instanceof WizytowkaObciazeniePracownika\Obiekt)
		{
			$obciazenie[0]->status = 'anulowane';
			return $obciazenie[0]->zapisz($this->cms->dane()->WizytowkaObciazeniePracownika());
		}
		else
		{
			trigger_error('Obciążenie dla podanej wizytówki nie istnieje.', E_USER_WARNING);
			return true;
		}
	}

	public function obliczExpPracownika(Uzytkownik\Obiekt $pracownik)
	{
		return intval($this->cms->dane()->WizytowkaObciazeniePracownika()->pobierzExpPoIdPracownika($pracownik->id, $this->typDzialania));
	}

	public function pobierzRaportObciazen()
	{
		$pracownicy =  $this->pobierzAktywnychPracownikow();

		$obciazeniaWagowe = listaZTablicy($this->cms->dane()->WizytowkaObciazeniePracownika()->pobierzObciazeniePracownikow($this->typDzialania), 'id_pracownika');

		$raportObciazen = array();

		foreach ($pracownicy as $pracownik)
		{
			/* @var $pracownik Uzytkownik */
			$predkoscPracy = $this->obliczPredkoscPracyPracownika($pracownik);
			$obciazenieWagowePracownika = isset($obciazeniaWagowe[$pracownik->id]) ? $obciazeniaWagowe[$pracownik->id]['obciazenie'] : 0;
			$estymowanyCzasPracy = $obciazenieWagowePracownika / $predkoscPracy;

			$raportDlaPracownika = array();

			$raportDlaPracownika = array(
				'id' => $pracownik->id,
				'imie' => $pracownik->imie,
				'nazwisko' => $pracownik->nazwisko,
				'login' => $pracownik->login,
				'email' => $pracownik->email,
				'obciazenieWagowe' => $obciazenieWagowePracownika,
				'obciazenieCzasowe' => $this->obliczDniRoboczeDlaPracownika($pracownik, $estymowanyCzasPracy, new \DateTime('now')),
				'obciazenieWykonane' => $this->obliczWykonaneObciazenie($pracownik),
				'predkoscPracy' => $predkoscPracy,
				'exp' => $this->obliczExpPracownika($pracownik)
			);

			$raportObciazen[$pracownik->id] = $raportDlaPracownika;
		}

		return $raportObciazen;

	}


	protected function obliczWykonaneObciazenie(Uzytkownik\Obiekt $pracownik)
	{
		return intval($this->cms->dane()->WizytowkaObciazeniePracownika()->pobierzWykonaneObciazeniePoIdPracownika($pracownik->id, $this->typDzialania));
	}


	protected function obliczWageWizytowki(Wizytowka\Obiekt $wizytowka)
	{
		$typKonta = $this->cms->dane()->Produkt()->zwracaTablice()->pobierzPoId($wizytowka->idTypuKonta);

		$parametry = unserialize($typKonta['parametry']);

		return intval($this->cms->dane()->OgloszenieUzupelnienie()->iloscZakupionychDlaIdWizytowki($wizytowka->id) + $parametry['uzupelnienia_gratis'] + intval($parametry['banner_graficzny'] != 'standardowy') + 2);
	}

	protected function obliczWagoweObciazeniePracownika(Uzytkownik\Obiekt $pracownik)
	{
		return intval($this->cms->dane()->WizytowkaObciazeniePracownika()->pobierzObciazeniePoIdPracownika($pracownik->id, $this->typDzialania));
	}

	public function zwrocPracownikowBezObciazenia()
	{

		return $this->zwrocPracownikowZObciazeniemWagowymNizszym(0);

	}

	protected function zwrocPracownikowZObciazeniemWagowymNizszym($granica = 0)
	{
		$pracownicy =  $this->pobierzAktywnychPracownikow();

		foreach ($pracownicy as $klucz => $pracownik)
		{
			if ($this->obliczWagoweObciazeniePracownika($pracownik, $this->typDzialania) > $granica)
			{
				unset($pracownicy[$klucz]);
			}
		}

		return $pracownicy;
	}

	protected function zwrocPracownikaZNajnizszymObciazeniemWagowym($pomijajIdPracownika = null)
	{
		$pracownicy =  $this->pobierzAktywnychPracownikow();

		$min = 999999;

		$najmniejObciazony = null;

		foreach ($pracownicy as $klucz => $pracownik)
		{
			if ($pracownik->id == $pomijajIdPracownika)
			{
				continue;
			}

			if (($obciazenie = $this->obliczWagoweObciazeniePracownika($pracownik, $this->typDzialania)) < $min)
			{
				$min = $obciazenie;
				$najmniejObciazony = $pracownik;

				if ($min == 0)
				{
					break;
				}
			}
		}

		return $najmniejObciazony;
	}

	protected function zwrocPracownikowZObciazeniemWagowymWyzszym($granica = 0)
	{
		$pracownicy = $this->pobierzAktywnychPracownikow();

		foreach ($pracownicy as $klucz => $pracownik)
		{
			if ($this->obliczWagoweObciazeniePracownika($pracownik, $this->typDzialania) < $granica)
			{
				unset($pracownicy[$klucz]);
			}
		}

		return $pracownicy;
	}

	protected function zwrocIdRol(Array $kodyRol)
	{
		$listaRol = array();
		foreach ($kodyRol as $rola)
		{
			$rola = $this->cms->dane()->Rola()->zwracaTablice('id')->pobierzPoKodzie($rola);
			if ($rola['id'] > 0)
			{
				$listaRol[] = $rola['id'];
			}
		}

		return $listaRol;
	}

	public function zwrocPracownikowZNiskimObciazeniemWagowym()
	{
		return $this->zwrocPracownikowZObciazeniemWagowymNizszym($this->dolnyLimitObciazenia);
	}

	public function zwrocPracownikowZWysokimObciazeniemWagowym()
	{
		return $this->zwrocPracownikowZObciazeniemWagowymWyzszym($this->gornyLimitObciazenia);
	}

	protected function zwrocPracownikowZNajwyzszymObciazeniemWagowym()
	{
		$maxObciazenie = $this->cms->dane()->WizytowkaObciazeniePracownika()->pobierzMaxObciazeniePracownika($this->typDzialania);

		return $this->zwrocPracownikowZObciazeniemWagowymWyzszym($maxObciazenie - 1);
	}

	protected function zwrocPracownikowZNajnizszymNieZerowymObciazeniemWagowym()
	{
		$minObciazenie = $this->cms->dane()->WizytowkaObciazeniePracownika()->pobierzMinObciazeniePracownika($this->typDzialania);

		return $this->zwrocPracownikowZObciazeniemWagowymWyzszym($minObciazenie + 1);
	}

	protected function pobierzAktywnychPracownikow()
	{
		$pracownicy = $this->cms->dane()->Uzytkownik()->pobierzDlaRoli($this->zwrocIdRol($this->kodyRol));

		foreach ($pracownicy as $klucz => $pracownik)
		{
			/* @var $pracownik Uzytkownik*/
			if ($pracownik->status != 'aktywny')
			{
				unset ($pracownicy[$klucz]);
			}
		}

		return $pracownicy;
	}

}
