<?php
namespace Generic\Modul\Mailing;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Pager;
use Generic\Model\Mailing;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Katalog;
use Generic\Model\ZadanieCykliczne;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Pomocnik;


/**
 * Modul administracyjny informujący o ustawieniach php umozliwajacy testy
 *
 * @author Konrad Rudowski
 * @package moduly
 */


class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\Mailing\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Mailing\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajDodaj',
		'wykonajEdytuj',
		'wykonajPodglad',
		'wykonajUsun',
		'wykonajPobierzRaport',
	);



	public function wykonajIndex()
	{
		$cms = Cms::inst();

		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$naStronie = $this->pobierzParametr('naStronie', $this->k->k['index.wierszy_na_stronie'], true, array('intval','abs'));
		$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
		$kolumna = $this->pobierzParametr('kolumna', $this->k->k['index.domyslne_sortowanie'], true, array('strval'));
		$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval'));

		$mapper = $this->dane()->Mailing();
		$pager = new Pager\Html($mapper->iloscWszystko(), $naStronie, $nrStrony);
		$sorter = new Mailing\Sorter($kolumna, $kierunek);

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['index.etykieta_nazwa'], 250, Router::urlAdmin('Mailing','edytuj', array('{KLUCZ}' => '{WARTOSC}')));
		$grid->dodajKolumne('data_dodania', $this->j->t['index.etykieta_dataDodania'], 110);
		$grid->dodajKolumne('data_wysylki', $this->j->t['index.etykieta_dataWysylki'], 110);
		$grid->dodajKolumne('data_zakonczenia', $this->j->t['index.etykieta_dataZakonczenia'], 110);
		$grid->dodajKolumne('ile_adresow', $this->j->t['index.etykieta_ileAdresow'], 70);
		$grid->dodajKolumne('ile_wyslano', $this->j->t['index.etykieta_ileWyslano'], 70);
		$grid->dodajKolumne('ile_bledow', $this->j->t['index.etykieta_ileBledow'], 70);
		$grid->dodajKolumne('postep', $this->j->t['index.etykieta_postep'], 70);
		$grid->dodajKolumne('aktywna', $this->j->t['index.etykieta_aktywna'], 70);

		$grid->dodajPrzyciski(
			Router::urlAdmin('Mailing','{AKCJA}',array('{KLUCZ}' => '{WARTOSC}')),
			array(
				'podglad', 'edytuj','usun'
			)
		);

		$grid->ustawSortownie(array('nazwa', 'data_wysylki', 'data_dodania'), $kolumna, $kierunek,
			Router::urlAdmin('Mailing', 'index', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
		);

		$grid->pager($pager->html(Router::urlAdmin('Mailing', 'index', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));


		foreach ($mapper->zwracaTablice()->pobierzWszystko($pager, $sorter) as $mailing)
		{
			if ($mailing['ile_adresow'] > 0)
			{
				$mailing['postep'] = round((($mailing['ile_wyslano'] + $mailing['ile_bledow']) * 100) / $mailing['ile_adresow']).'%';
			}
			else
			{
				$mailing['postep'] = '0%';
			}

			if ($mailing['id_zadania_cron'] > 0)
			{
				$mailing['aktywna'] = $this->j->t['index.tak'];
			}
			else
			{
				$mailing['aktywna'] = $this->j->t['index.nie'];
			}

			if (($mailing['ile_wyslano'] + $mailing['ile_bledow']) >= $mailing['ile_adresow'])
			{
				$grid->usunPrzyciski(array('edytuj'));
			}
			else
			{
				$grid->usunPrzyciski(array('podglad'));
			}

			$grid->dodajWiersz($mailing);
		}

		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'etykieta_dodaj' => $this->j->t['etykieta_dodaj'],
			'tabela_danych' => $grid->html(),
			'link_dodaj' => Router::urlAdmin('Mailing', 'dodaj'),
		));
	}

	public function wykonajPobierzRaport()
	{
		$zip = new \ZipArchive();
		$plikZip = TEMP_KATALOG.'/private/mailingi/'.Zadanie::pobierzGet('id', 'filtr_xss', 'intval').'/Raport.zip';

		$plik = new Plik($plikZip);

		if ($plik->istnieje())
		{
			zwrocPlikDoPrzegladarki($plikZip, "Raport.zip");
		}

		if ( ! $plik->istnieje() && $zip->open($plikZip, ZIPARCHIVE::CREATE) == true)
		{
			$zip->addFile(TEMP_KATALOG.'/private/mailingi/'.Zadanie::pobierzGet('id', 'filtr_xss', 'intval').'/doWysylki.csv','DoWysylki.csv');
			$zip->addFile(TEMP_KATALOG.'/private/mailingi/'.Zadanie::pobierzGet('id', 'filtr_xss', 'intval').'/wykonane.csv','Wykonane.csv');
			$zip->addFile(TEMP_KATALOG.'/private/mailingi/'.Zadanie::pobierzGet('id', 'filtr_xss', 'intval').'/bledy.csv','Bledy.csv');
			$zip->close();

			zwrocPlikDoPrzegladarki($plikZip, "Raport.zip");
		}

	}

	public function wykonajDodaj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['dodaj.tytul_strony']));

		$mailing = new Mailing\Obiekt();
		$mailing->ileAdresow = 0;
		$mailing->ileBledow = 0;
		$mailing->ileWyslano = 0;


		$formularz = $this->budujFormularz($mailing);

		$this->tresc .= $this->szablon->parsujBlok('/dodaj', array(
			'form' => $formularz->html(),
		));
	}

	public function wykonajEdytuj()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytuj.tytul_strony']));

		$mapper = $this->dane()->Mailing();

		$mailing = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval','abs'));

		if (!($mailing instanceof Mailing\Obiekt))
		{
			$this->komunikat($this->j->t['edytuj.blad_brak_mailingu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('Mailing', 'index'));
			return;
		}

		if (($mailing->ileBledow + $mailing->ileWyslano) >= $mailing->ileAdresow)
		{
			$this->komunikat($this->j->t['edytuj.blad_nie_mozna_edytowac'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('Mailing', 'podglad', array('id' => Zadanie::pobierz('id', 'intval','abs'))));
			return;
		}

		$formularz = $this->budujFormularz($mailing);

		$this->tresc .= $this->szablon->parsujBlok('/dodaj', array(
			'form' => $formularz->html(),
		));
	}

	public function wykonajPodglad()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['podglad.tytul_strony']));

		$mapper = $this->dane()->Mailing();

		$mailing = $mapper->pobierzPoId(Zadanie::pobierz('id', 'intval','abs'));

		if ( ! ($mailing instanceof Mailing\Obiekt))
		{
			$this->komunikat($this->j->t['edytuj.blad_brak_mailingu'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('Mailing', 'index'));
			return;
		}

		if (($mailing->ileBledow + $mailing->ileWyslano) < $mailing->ileAdresow)
		{
			Router::przekierujDo(Router::urlAdmin('Mailing', 'edytuj', array('id' => Zadanie::pobierz('id', 'intval','abs'))));
			return;
		}

		$formularz = $this->budujFormularz($mailing, true);

		$this->tresc .= $this->szablon->parsujBlok('/dodaj', array(
			'form' => $formularz->html(),
		));
	}

	public function wykonajUsun()
	{
		$mapper = $this->dane()->Mailing();
		$mapperCron = $this->dane()->ZadanieCykliczne();
		$mailing = $mapper->pobierzPoId(Zadanie::pobierzGet('id', 'intval','abs'));
		if ($mailing instanceof Mailing\Obiekt)
		{
			$zadanieCron = $mapperCron->pobierzPoId($mailing->idZadaniaCron);
			$katalog = new Katalog(str_replace('doWysylki.csv', '', $mailing->plikZLista));
			$katalog->usun();

			if ($mailing->usun($mapper)
					&& ($zadanieCron instanceof ZadanieCykliczne\Obiekt ? $zadanieCron->usun($mapperCron) : true)
					&& ! $katalog->istnieje())
			{
				$this->komunikat($this->j->t['usun.info_mailing_usuniety'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_mailingu'], 'error', 'sesja');
			}
		}
		else
		{
			$this->komunikat($this->j->t['usun.blad_brak_mailingu'],'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('Mailing', 'index'));
	}

	protected function budujFormularz (Mailing\Obiekt $mailing, $tylkoPodglad = false)
	{
		$celFormularza = '';

		if ( ! $tylkoPodglad)
		{
			$celFormularza = Router::urlAdmin('Mailing',$this->wykonywanaAkcja, Zadanie::pobierz('id', 'intval', 'abs')>0 ? array('id' => Zadanie::pobierz('id', 'intval', 'abs')) : array() );
		}
		else
		{
			$celFormularza = Router::urlAdmin('Mailing','index');
		}

		$obiektFormularza = new \Generic\Formularz\Mailing\Edycja();
		$obiektFormularza->ustawObiekt($mailing)
			->ustawCelFormularza($celFormularza)
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawUrlPowrotny(Router::urlAdmin('Mailing','index'))
			->ustawTylkoPodglad($tylkoPodglad)
			->ustawWykonywanaAkcja($this->wykonywanaAkcja);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne() && Zadanie::pobierz('wysylkaTestowa') != 'TAK')
		{
			$this->zapiszMailing($mailing, $obiektFormularza->pobierzWartosci());
		}
		elseif (Zadanie::pobierz('wysylkaTestowa') == 'TAK')
		{
			$this->wyslijTestowo($formularz->pobierzWartosci());
		}

		return $obiektFormularza->zwrocFormularz();
	}

	protected function wyslijTestowo (Array $dane)
	{
		if ($dane['tytul'] != '' && ($dane['tresc'] != '' || $dane['trescHtml'] != '') && $dane['emailTestowy'] != '')
		{
			$poczta = new Pomocnik\Poczta();
			$poczta->wczytajUstawienia(array(
				'zapiszStanWKolejce' => false,
				'emailNadawcaEmail' => $dane['emailNadawcy'],
				'emailNadawcaNazwa' => $dane['nazwaNadawcy'],
				'emailOdbiorcy' => array($dane['emailTestowy']),
				'emailTytul' => $dane['tytul'],
				'emailTrescHtml' => $dane['trescHtml'],
				'emailTrescTxt' => $dane['tresc'],
				'emailSzablon' => $dane['zaladujSzablon'] ? 1 : 0,
			));
			if ($poczta->wyslij())
			{
				$this->komunikat($this->j->t['emailTestowy.info_wyslano_poprawnie'], 'info');
			}
			else
			{
				$this->komunikat($this->j->t['emailTestowy.blad.nie_mozna_wyslac_emaila'], 'error');
			}
		}
		else
		{
			$this->komunikat($this->j->t['wyslijTestowo.blad_niepelne_dane'], 'error');
		}
	}

	protected function zapiszMailing (Mailing\Obiekt $mailing, Array $dane)
	{

		$cms = Cms::inst();

		foreach ($dane as $klucz => $wartosc)
		{
			if ($klucz != 'plikZLista' && $klucz != 'emailTestowy')
			{
				$mailing->$klucz = $wartosc;
			}
		}

		if (($mailing->ileBledow + $mailing->ileWyslano) >= $mailing->ileAdresow && $mailing->ileAdresow > 0)
		{
			$this->komunikat($this->j->t['edytuj.blad_nie_mozna_edytowac'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('Mailing', 'index'));
			return;
		}


		//zaokraglenie minut do wielokrotnosci 5
		$data = new \DateTime($mailing->dataWysylki, new \DateTimeZone('Europe/Warsaw'));

		$minuty = intval($data->format('i'));
		$minuty = ceil($minuty / 5) * 5;

		$mailing->dataWysylki = $data->format("Y-m-d H:$minuty:00");

		if ($mailing->id < 1)
		{
			$mailing->idProjektu = ID_PROJEKTU;
			$mailing->kodJezyka = KOD_JEZYKA;
			$mailing->dataDodania = date('Y-m-d H:i:s');

			$komunikat_sukces = $this->j->t['dodaj.info_zapisano_dane_mailingu'];
			$komunikat_blad = $this->j->t['dodaj.blad_nie_mozna_zapisac_mailingu'];
		}
		else
		{
			$komunikat_sukces = $this->j->t['edytuj.info_zapisano_dane_mailingu'];
			$komunikat_blad = $this->j->t['edytuj.blad_nie_mozna_zapisac_mailingu'];
		}

		$baza = Cms::inst()->Baza();
		$baza->transakcjaStart();

		if ($mailing->zapisz($this->dane()->Mailing()))
		{
			if ( ! ($idZadaniaCron = $this->zapiszZadanieCron($mailing)))
			{
				$this->komunikat($this->j->t['dodaj.blad_nie_mozna_zapisac_cron'], 'error');
				$baza->transakcjaCofnij();
				return;
			}

			$wystapilBlad = false;

			if (isset($_FILES['plikZLista']))
			{
				$katalog = new Katalog(TEMP_KATALOG.'/private/mailingi/'.$mailing->id, true);
				$plik = new Plik($_FILES['plikZLista']['tmp_name']);
				$plikDocelowySciezka = $katalog.'/doWysylki.csv';

				if ( ! $katalog->istnieje() || ! $this->parsujListeAdresowIZapisz($plik, $plikDocelowySciezka))
				{
					$this->komunikat($this->j->t['dodaj.blad_nie_mozna_przeniesc_pliku'], 'error');
					$baza->transakcjaCofnij();
					$wystapilBlad = true;
				}
				else
				{
					$mailing->plikZLista = $plikDocelowySciezka;
					$mailing->ileAdresow = count(explode("\n",$plik->pobierzZawartosc())) - 1;
				}
			}

			//zapisanie estymowanej daty zakonczenia
			$data = new \DateTime($mailing->dataWysylki, new \DateTimeZone('Europe/Warsaw'));
			$data->modify('+ '.(ceil($mailing->ileAdresow / $this->k->k['mailing.ilosc_wysylanych_jednorazowo']) * 5).' minute');
			$mailing->dataZakonczenia = $data->format('Y-m-d H:i:s');

			$mapper = $this->dane()->Mailing();
			$inneWTymCzasie = $mapper->iloscWOkresie($mailing->dataWysylki, $mailing->dataZakonczenia, $mailing->id > 0 ? $mailing->id : null);

			if ( ! $wystapilBlad && $inneWTymCzasie == 0 )
			{
				$mailing->idZadaniaCron = $idZadaniaCron;

				if ($mailing->zapisz($this->dane()->Mailing()))
				{
					$baza->transakcjaPotwierdz();
					$this->komunikat($komunikat_sukces, 'info', 'sesja');
					Router::przekierujDo(Router::urlAdmin('Mailing', 'index'));
				}
				else
				{
					$this->komunikat($komunikat_blad, 'error');
					$baza->transakcjaCofnij();
				}
			}
			elseif ($inneWTymCzasie > 0) {
					$this->komunikat($this->j->t['dodaj.blad_istnieja_w_tym_czasie'], 'error');
					$baza->transakcjaCofnij();
			}
		}
		else
		{
			$this->komunikat($komunikat_blad, 'error');
			$baza->transakcjaCofnij();
		}
	}




	protected function  parsujListeAdresowIZapisz(Plik $plik, $sciezkaDocelowa)
	{
		$walidator = new Walidator\Email();
		$zawartoscWyjsciowa = array();
		$daneDoPliku = '';

		foreach (explode("\n", $plik->pobierzZawartosc()) as $linia)
		{
			$linia = trim($linia);
			if ($linia != null && $linia !='')
			{
				$linia = explode(',', $linia);
				if ($walidator->sprawdz($linia[0]))
				{
					if ( ! $this->emailNaLiscie($linia[0], $zawartoscWyjsciowa))
						$zawartoscWyjsciowa []= $linia;
				}
			}

		}

		foreach ($zawartoscWyjsciowa as $wiersz)
		{
			$daneDoPliku .= implode(',', $wiersz)."\n";
		}

		if ($plik->przeniesDo($sciezkaDocelowa) && $plik->ustawZawartosc($daneDoPliku))
		{
			return true;
		}
		else
		{
			$plik->usun();
			return false;
		}
	}


	protected function emailNaLiscie($email, Array $lista)
	{
		foreach ($lista as $pozycja)
		{
			if ($pozycja[0] == $email)
				return true;
		}

		return false;
	}



	protected function zapiszZadanieCron (Mailing\Obiekt $mailing)
	{
		$mapper = $this->dane()->ZadanieCykliczne();
		$zadanie;
		if ($mailing->idZadaniaCron>0)
			$zadanie = $mapper->pobierzPoId($mailing->idZadaniaCron);
		else
		{
			$zadanie = new ZadanieCykliczne\Obiekt();
			$zadanie->idProjektu = ID_PROJEKTU;
			$zadanie->kodJezyka = KOD_JEZYKA;
			$zadanie->minuty = '*';
			$zadanie->godziny = '*';
			$zadanie->dni = '*';
			$zadanie->miesiace = '*';
			$zadanie->dniTygodnia = '*';
			$zadanie->aktywne = 1;
			$zadanie->kodModulu = 'Mailing';
			$zadanie->idKategorii = 1; //idKategorii = root
			$zadanie->akcja = 'wykonajWyslijMailing';
		}

		$zadanie->opisZadania = 'Wysłanie listy wysyłkowej: ' . $mailing->nazwa;
		$zadanie->dataRozpoczecia = $mailing->dataWysylki;
		if ($zadanie->zapisz($this->dane()->ZadanieCykliczne()))
		{
			return $zadanie->id;
		}
		else
		{
			return false;
		}
	}



	public function pobierzAktualnaKonfiguracje()
	{
		return $this->k->k;
	}
}
