<?php
namespace Generic\Tlumaczenie\Pl\Model;

use Generic\Tlumaczenie\Tlumaczenie;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
class Produkt extends Tlumaczenie
{

	protected $tlumaczeniaDomyslne = array(
		'name.etykieta' => 'Nazwa',
		'name.opis' => '',

		'measureUnit.etykieta' => 'Jednostka miary',
		'measureUnit.opis' => '',

		'visibleInOrder.etykieta' => 'Typ',
		'visibleInOrder.opis' => '',
		
		'technologia.etykieta' => 'Technologia',
		'technologia.opis' => '',
		
		'vat.etykieta' => 'Tax',
		'vat.opis' => '',

		'idPolaczony.etykieta' => 'Połączony z produktem rodzicem',
		'idPolaczony.opis' => '',
		
		'nettoPrice.etykieta' => 'Cena netto',
		'nettoPrice.opis' => '',

		'bruttoPrice.etykieta' => 'Cena brutto',
		'bruttoPrice.opis' => '',
		
		'mainProduct.etykieta' => 'Czy produkt główny',
		'mainProduct.opis' => '',
		
		'multiplied.etykieta' => 'Czy może być mnożony',
		'multiplied.opis' => '',
		
		'textDoSms.etykieta' => 'Tekst do SMS',
		'textDoSms.opis' => '',

		'pojedynczy.etykieta' => 'Czy końcowy produkt',
		'pojedynczy.opis' => 'Po wybraniu końcowego produktu nic już więcej nie można wybrać',
		
		'notDone.etykieta' => 'Nie wykonane',
		'notDone.opis' => 'Wybieraj tą opcję tylko dla produktów NIE WYKONANYCH',
		
		'serial.etykieta' => 'Grupa pól do wpisania SN/MAC',
		'serial.opis' => '',
		
		'noteRequired.etykieta' => 'Ilość znaków wymaganych przy notatce',
		'noteRequired.opis' => '',
		
		'kombinacje.etykieta' => 'Kombinacje',
		'kombinacje.opis' => '',
		
		'serial.wartosci' => array(
			'' => '- Wybierz -',
			'dekoder' => 'Dekoder',
			'modem' => 'Modem',
			'ont' => 'ONT',
			'voip' => 'VoIP',
			'h_dek' => 'Hentet dekoder',
			'h_modem' => 'Hentet modem',
		),
		
		'photosRequired.etykieta' => 'Ilość wymaganych zdjęć',
		'photosRequired.opis' => 'Ile zdjęć jest wymaganych dla danego produktu',
		
		'photosExplanation.etykieta' => 'Wytłumaczenie zdjęcia',
		'photosExplanation.opis' => 'Tekst jaki pojawi się jeśli przy produkcie wymagane są jakieś zdjęcia',
	);
}
?>
