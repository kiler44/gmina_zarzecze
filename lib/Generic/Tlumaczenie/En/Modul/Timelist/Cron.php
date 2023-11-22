<?php
namespace Generic\Tlumaczenie\En\Modul\Timelist;

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
		'wyslijSms.auto_wylogowanie' => 'You are not logged out from your last task. Your team was logged out automatically. Working time of the last task has been reset.',
		'wyslijSms.auto_zakonczenie_dnia' => 'You are not closed work day of your Team. The working day was closed automatically. Working time of the last task has been reset.',
		'wyslijSmsLider.powiadomienie' => 'If there are any delays and you will late for subsequent customers, you must immediately stop work and contact another customer to inform him about the delay.',
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}