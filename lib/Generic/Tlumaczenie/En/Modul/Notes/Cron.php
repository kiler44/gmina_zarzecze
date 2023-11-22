<?php
namespace Generic\Tlumaczenie\En\Modul\Notes;

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
		'przypomnienie_brak_notatki' => 'Reminder. You have not added today note to the project which you are a leader ({PROJEKT_NAZWA} BKT Id. {BKT_ID}). Sign in to the panel and add note.',
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}