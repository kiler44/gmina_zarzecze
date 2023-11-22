<?php
namespace Generic\Tlumaczenie\En\Modul\Team;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['mail.adres_zadania_teamu']
 * @property string $t['mail.ekipa_etykieta']
 * @property string $t['mail.lista_pozostalych_ekip_naglowek']
 * @property string $t['mail.lista_pracownikow_teamu']
 * @property string $t['mail.powitanie_lider']
 * @property string $t['mail.powitanie_pracownik']
 * @property string $t['mail.pracownicy_etykieta']
 * @property string $t['mail.zadania_teamu_nazwa']
 */
class Cron extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'mail.adres_zadania_teamu' => 'Address of the first order for your team is ',
		'mail.ekipa_etykieta' => 'Team  ',
		'mail.lista_pozostalych_ekip_naglowek' => '<h3>Other teams  </h3>',
		'mail.lista_pracownikow_teamu' => '<strong>You are working with  </strong>',
		'mail.powitanie_lider' => 'Hi {$IMIE},<br/> today ({$DATA}) you are working in a team <strong> {$EKIPA} </strong> which you are a leader. <br/> ',
		'mail.powitanie_pracownik' => 'Hi {$IMIE},<br/> today ({$DATA}) you are working in a team <strong>{$EKIPA}</strong> which leader is {$LIDER} <br/>',
		'mail.pracownicy_etykieta' => 'Workers  <br/>',
		'mail.zadania_teamu_nazwa' => 'The first order for your team is ',
		'mail.lider_etykieta' => 'Leader  ',

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}