<?php
namespace Generic\Tlumaczenie\No\Modul\Timelist;

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
		'wyslijSms.auto_wylogowanie' => 'Du er ikke logget ut fra din siste oppgave. Ditt team ble logget ut automatisk. Driftstid for den siste oppgaven har blitt tilbakestilt.',
		'wyslijSms.auto_zakonczenie_dnia' => 'Du er ikke lukke arbeidsdagen din Team. Arbeidsdagen ble stengt automatisk. Driftstid for den siste oppgaven har blitt tilbakestilt.',
		'wyslijSmsLider.powiadomienie' => 'Er det oppstått forsinkelser og du blir forsinket til de neste kundene må du umiddelbart avbryte arbeidet og kontakte de neste kunden og informere om forsinkelse.',
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}