<?php
namespace Generic\Modul\RejestrowanieZdarzen;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\WierszKonfiguracji;


/**
 * Moduł odpowiedzialny za rejestrowanie zdarzeń.
 *
 * @author Konrad Rudowski
 * @package moduly
 */

class Cron extends Modul\Cron
{

	/**
	 * @var \Generic\Konfiguracja\Modul\RejestrowanieZdarzen\Cron
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\RejestrowanieZdarzen\Cron
	 */
	protected $j;

	protected $zdarzenia = array(
		'BladAktualizacjiIdentyfikatorow' => 'Generic\\Zdarzenie\\RejestrowanieZdarzenBladAktualizacjiIdentyfikatorow',
		'IdentyfikatoryZaktualizowane' => 'Generic\\Zdarzenie\\RejestrowanieZdarzenZaktualizowanoIdentyfikatory',
		);


	public function wykonajUaktualnijIdObiektow()
	{
		$czasAktualny = new \DateTime(date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']));

		$czasOstatniegoUaktualnienia = new \DateTime($this->k->k['uaktualnijIdObiektow.czasOstatniegoUruchomienia']);

		$czasPobieraniaZdarzen = clone $czasAktualny;
		$czasPobieraniaZdarzen->modify('- ' . $this->k->k['uaktualnijIdObiektow.okresWyszukiwania']);

		//zabezpieczenie przed "luką" w wygenerowanych logach
		if ($czasOstatniegoUaktualnienia < $czasPobieraniaZdarzen)
		{
			$czasPobieraniaZdarzen = clone $czasOstatniegoUaktualnienia;
		}

		$start = new \MongoDate($czasPobieraniaZdarzen->format('U'));
		$koniec = new \MongoDate($czasAktualny->format('U'));

		$kryteria = array(
			'idObiektuGlownego' => array('wieksze' => 0),
			'timestamp' => array('wiekszerowne' => $start, 'mniejsze' => $koniec),
			'tokenProcesu' => array('nierowne' => ''),
		);

		$wystapilBlad = false;

		Cms::inst()->transakcjaSystemowaStart();

		foreach ($this->dane()->LogZdarzen()->szukaj($kryteria) as $log)
		{
			if ( ! $this->aktualizujZdarzeniaDlaLoga($log))
			{
				$wystapilBlad = true;
				break;
			}
		}

		if ( ! $this->aktualizujCzasOstatniegoUruchomienia($czasAktualny))
		{
			$wystapilBlad = true;
		}

		$daneZdarzenia = array(
			'zakresOd' => $czasPobieraniaZdarzen->format('Y-m-d H:i:s'),
			'zakresDo' => $czasAktualny->format('Y-m-d H:i:s'),
		);

		if ($wystapilBlad)
		{
			$this->zdarzenie('BladAktualizacjiIdentyfikatorow', $daneZdarzenia);
			Cms::inst()->transakcjaSystemowaCofnij();
		}
		else
		{
			$this->zdarzenie('IdentyfikatoryZaktualizowane', $daneZdarzenia);
			Cms::inst()->transakcjaSystemowaPotwierdz();
		}
	}


	protected function aktualizujZdarzeniaDlaLoga(\Generic\ModelNosql\LogZdarzen $log)
	{
		$kryteria = array(
			'tokenProcesu' => $log->tokenProcesu,
		);

		try
		{
			foreach ($this->dane()->LogZdarzen()->szukaj($kryteria) as $logDoAktualizacji)
			{
				if ($logDoAktualizacji->idObiektuGlownego == '')
				{
					$logDoAktualizacji->idObiektuGlownego = $log->idObiektuGlownego;
					$logDoAktualizacji->typObiektuGlownego = $log->typObiektuGlownego;
					$logDoAktualizacji->zapisz();
				}
			}

			return true;
		}
		catch(Exception $e)
		{
			return false;
		}
	}


	protected function aktualizujCzasOstatniegoUruchomienia(\DateTime $czasUruchomienia)
	{
		$kategoria = $this->dane()->Kategoria()->pobierzDlaModulu('RejestrowanieZdarzen');

		$ustawienie = $this->dane()->Konfiguracja()->pobierzWierszDlaModulu('uaktualnijIdObiektow.czasOstatniegoUruchomienia', 'RejestrowanieZdarzen_Cron', $kategoria[0]->id, null);

		if ( ! ($ustawienie instanceof WierszKonfiguracji\Obiekt))
		{
			$ustawienie = new WierszKonfiguracji\Obiekt();

			$ustawienie->kodModulu = 'RejestrowanieZdarzen_Cron';
			$ustawienie->idKategorii = $kategoria[0]->id;
			$ustawienie->nazwa = 'uaktualnijIdObiektow.czasOstatniegoUruchomienia';
			$ustawienie->typ = 'string';

		}

		$ustawienie->wartosc = $czasUruchomienia->format('Y-m-d H:i:s');

		return $ustawienie->zapisz($this->dane()->Konfiguracja());
	}

}


