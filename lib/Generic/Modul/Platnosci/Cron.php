<?php
namespace Generic\Modul\Platnosci;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\Platnosc;


/**
 * Moduł obsługujący zadania cykliczne dla płatności.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Cron extends Modul\Cron
{

	/**
	 * @var \Generic\Konfiguracja\Modul\Platnosci\Cron
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\Platnosci\Cron
	 */
	protected $j;


	protected $uprawnienia = array(
		'wykonajUsunNieprawidlowe',
	);


	protected $zdarzenia = array(
		'zmieniono_status_platnosci',
	);


	/**
	 * Przetrzymuje obiekt sterownika platnosci
	 * @var Platnosc_PlatnosciPl
	 */
	protected $systemPlatnosci = null;



	public function wykonajUsunNieprawidlowe()
	{
		$platnosci = $this->dane()->Platnosc();

		$data = clone $this->dataDanych;
		$data->modify('-'.$this->k->k['wykonajUsunNieprawidlowe.anuluj_niedokonczone_po'].' minutes');

		$baza = Cms::inst()->Baza();

		$kryteria = array(
			'status' => array('nowa', 'nierozpoczeta'),
			'data_dodania_max' => $data->format('Y-m-d H:i:s'),
		);

		foreach ($platnosci->szukaj($kryteria) as $platnosc)
		{
			$baza->transakcjaStart();

			$sukces = $platnosc->aktualizujStatus();

/* Wyłączamy mechanizm auto-anulowania
			if ($sukces && $platnosc->status == 'nowa')
			{
				$sukces = ($platnosc->anuluj() && $platnosc->aktualizujStatus() && $platnosc->aktualizujPowiazanyObiekt());

				if ($sukces)
				{
					$this->zdarzenie('zmieniono_status_platnosci', array(
						'uzytkownik' => Cms::inst()->profil()->nazwaOrazLogin,
						'opis' => $platnosc->opis,
						'kwota' => $platnosc->kwota.' '.$platnosc->waluta,
						'status' => $platnosc->status,
					));
				}
			}
			else
*/			if ($sukces && $platnosc->status == 'nierozpoczeta')
			{
				$sukces = ($platnosc->aktualizujPowiazanyObiekt(Platnosc\Obiekt::DO_USUNIECIA) && $platnosc->usun($mapper));
			}

			if ($sukces)
			{
				$baza->transakcjaPotwierdz();
			}
			else
			{
				$baza->transakcjaCofnij();
				trigger_error('Problem z zapisem platnosci '.$platnosc->id, E_USER_WARNING);
			}
		}
	}

}