<?php
namespace Generic\Tlumaczenie\No\Model;

use Generic\Tlumaczenie\Tlumaczenie;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
class Produkt extends Tlumaczenie
{

	protected $tlumaczeniaDomyslne = array(
		'name.etykieta' => 'Navn',
		'name.opis' => '',

		'measureUnit.etykieta' => 'Mål unit',
		'measureUnit.opis' => '',

		'visibleInOrder.etykieta' => 'Kategori',
		'visibleInOrder.opis' => '',
		
		'technologia.etykieta' => 'Technology',
		'technologia.opis' => '',

		'vat.etykieta' => 'Tax',
		'vat.opis' => '',

		'nettoPrice.etykieta' => 'Netto pris',
		'nettoPrice.opis' => '',

		
		'idPolaczony.etykieta' => 'Connected parent product',
		'idPolaczony.opis' => '',
		
		'bruttoPrice.etykieta' => 'Brutto pris',
		'bruttoPrice.opis' => '',
		
		'mainProduct.etykieta' => 'Hovedprodukt?',
		'mainProduct.opis' => '',
		
		'multiplied.etykieta' => 'Kan multipliseres?',
		'multiplied.opis' => '',
		
		'textDoSms.etykieta' => 'Tekst til SMS',
		'textDoSms.opis' => '',

		'pojedynczy.etykieta' => 'Lukke produktet?',
		'pojedynczy.opis' => 'Lukke produkt betyr at etter å ha valgt dette ingenting annet kan velges.',
		
		'notDone.etykieta' => 'Ikke ferdig',
		'notDone.opis' => 'Velg dette bare dersom dette produktet er for IKKE FERDIG',
		
		'serial.etykieta' => 'SN/MAC feltet vil bli gitt for å fylle',
		'serial.opis' => '',
		
		'noteRequired.etykieta' => 'Hvor mange tegn vil være nødvendig for note',
		'noteRequired.opis' => '',
		
		'kombinacje.etykieta' => 'Kombinasjoner',
		'kombinacje.opis' => '',
		
		'serial.wartosci' => array(
			'' => '- Velg -',
			'dekoder' => 'Dekoder',
			'modem' => 'Modem',
			'ont' => 'ONT',
			'voip' => 'VoIP',
			'h_dek' => 'Hentet dekoder',
			'h_modem' => 'Hentet modem',
		),
		
		'photosRequired.etykieta' => 'Photos required',
		'photosRequired.opis' => 'How many photos are required for documentation',
		
		'photosExplanation.etykieta' => 'Photos explanation',
		'photosExplanation.opis' => 'Text that will apear if any photo is required for this this product',
	);
}
?>
