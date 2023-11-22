<?php
namespace Generic\Tlumaczenie\Pl\Modul\Team;

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
		'mail.adres_zadania_teamu' => ' Adres pierwszego zadanie dla Twojej Ekipy to ',
		'mail.ekipa_etykieta' => 'Ekipa : ',
		'mail.lista_pozostalych_ekip_naglowek' => '<h3>Składy pozostałych ekip : </h3>',
		'mail.lista_pracownikow_teamu' => '<strong> Pracujesz z : </strong>',
		'mail.powitanie_lider' => 'Cześć {$IMIE},<br/> dzisiaj ({$DATA}) pracujesz w ekipie <strong>{$EKIPA}</strong> której jesteś liderem. <br/>',
		'mail.powitanie_pracownik' => 'Cześć {$IMIE},<br/> dzisiaj ({$DATA}) pracujesz w ekipie <strong>{$EKIPA}</strong> której liderem jest {$LIDER} <br/>',
		'mail.pracownicy_etykieta' => 'Pracownicy : <br/>',
		'mail.zadania_teamu_nazwa' => 'Pierwsze zadanie dla Twojej Ekipy to ',
		'mail.lider_etykieta' => 'Lider : ',

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}