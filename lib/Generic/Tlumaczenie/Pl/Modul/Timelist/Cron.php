<?php
namespace Generic\Tlumaczenie\Pl\Modul\Timelist;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 */
class Cron extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
			'wyslijSms.auto_wylogowanie' => 'Nie wylogowales sie z ostatniego zadania. Twoj Team zostal wylogowany automatycznie. Czas pracy za ostatnie zadanie zostal wyzerowany.',
			'wyslijSms.auto_zakonczenie_dnia' => 'Nie zamknales dnia pracy swojego Teamu. Dzien pracy zostal zamkniety automatycznie. Czas pracy za ostatnie zadanie zostal wyzerowany.',
			'wyslijSmsLider.powiadomienie' => 'Czy pojawily sie opoznienia i bedziesz spozniony do kolejnych klientow, musisz natychmiast przerwac prace i skontaktowac sie z kolejnym klientem, aby poinformowac go opoznieniu.',
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}