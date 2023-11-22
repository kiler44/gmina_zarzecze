<?php
namespace Generic\Tlumaczenie\Pl\Modul\Notes;

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
		'przypomnienie_brak_notatki' => 'Przypomnienie. Nie dodales dzisiaj notatki do projektu ktorego jestes liderem ({PROJEKT_NAZWA} BKT Id. {BKT_ID}). Zaloguj sie do panelu zeby dodac notatke.',
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}