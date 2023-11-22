<?php
namespace Generic\Tlumaczenie\En\Model;

use Generic\Tlumaczenie\Tlumaczenie;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
class Produkt extends Tlumaczenie
{

	protected $tlumaczeniaDomyslne = array(
		'name.etykieta' => 'Name',
		'name.opis' => '',

		'measureUnit.etykieta' => 'Measure Unit',
		'measureUnit.opis' => '',
		
		'technologia.etykieta' => 'Technology',
		'technologia.opis' => '',

		'visibleInOrder.etykieta' => 'Category',
		'visibleInOrder.opis' => '',

		'vat.etykieta' => 'Tax',
		'vat.opis' => '',

		'nettoPrice.etykieta' => 'Netto price',
		'nettoPrice.opis' => '',

		'idPolaczony.etykieta' => 'Connected parent product',
		'idPolaczony.opis' => '',
		
		'bruttoPrice.etykieta' => 'Brutto price',
		'bruttoPrice.opis' => '',

		'mainProduct.etykieta' => 'Main product?',
		'mainProduct.opis' => '',
		
		'multiplied.etykieta' => 'Can be multiplied?',
		'multiplied.opis' => '',
		
		'textDoSms.etykieta' => 'Text to SMS',
		'textDoSms.opis' => '',

		'pojedynczy.etykieta' => 'Closing product?',
		'pojedynczy.opis' => 'Closing product means that after selecting this one nothing else can be selected.',
		
		'notDone.etykieta' => 'Not done',
		'notDone.opis' => 'Select this only if this product is for NOT DONE',
		
		'serial.etykieta' => 'SN/MAC field will be provided to fill',
		'serial.opis' => '',
		
		'noteRequired.etykieta' => 'How many characters will be required for note',
		'noteRequired.opis' => '',
		
		'serial.wartosci' => array(
			'' => '- Select -',
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
