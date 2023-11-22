<?php
namespace Generic\Modul\EmailZarzadzanie;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\EmailWpisKolejki;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Pomocnik;


/**
 * Moduł obsługujący zadania cykliczne dla wysylania wiadomości email.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Cron extends Modul\Cron
{

	/**
	 * @var \Generic\Konfiguracja\Modul\EmailZarzadzanie\Cron
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\EmailZarzadzanie\Cron
	 */
	protected $j;

	public function wykonajObslugaKolejki()
	{
		$cms = Cms::inst();
		$wpisyMapper = $this->dane()->EmailWpisKolejki();
		$sorter = new EmailWpisKolejki\Sorter('data_dodania', 'desc');
		$ilosc = $this->k->k['wykonajObslugaKolejki.wiersze_do_pobrania'];
		$pager = new Pager\Html($ilosc, $ilosc, 1);
		$kryteria = array(
			'bledy_licznik_mniejsze_' => 3,
			'typ_wysylania_rowne_' => 'cron',
			'nie_wysylaj' => false,
		);

		foreach ($wpisyMapper->szukaj($kryteria, $pager, $sorter) as $wpis)
		{
			$ustawienia = Pomocnik\Poczta::przygotujUstawieniaDlaWpisu($wpis);

			$poczta = new Pomocnik\Poczta();
			$poczta->wczytajUstawienia($ustawienia);

			if ($poczta->wyslij())
			{
				$wpis->usun($wpisyMapper);
			}
			else
			{
				$wpis->bledyLicznik++;
				$wpis->bledyOpis .= "\n".trim($cms->temp('smtp_debug'));
				$wpis->zapisz($wpisyMapper);
			}
		}

	}

}