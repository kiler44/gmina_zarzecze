<?php
namespace Generic\Tlumaczenie\Pl\Model;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['mainType.etykieta']
 * @property string $t['mainType.opis']
 * @property string $t['active.etykieta']
 * @property string $t['active.opis']
 * @property string $t['childOrders.etykieta']
 * @property string $t['childOrders.opis']
 * @property string $t['possibleChargeTypes.etykieta']
 * @property string $t['possibleChargeTypes.opis']
 * @property string $t['parentTypes.etykieta']
 * @property string $t['parentTypes.opis']
 * @property string $t['formFields.etykieta']
 * @property string $t['formFields.opis']
 * @property string $t['parameters.etykieta']
 * @property string $t['parameters.opis']
 */
class ZamowienieTyp extends Tlumaczenie
{

	protected $tlumaczeniaDomyslne = array(
      'mainType.etykieta' => 'Czy typ główny',
      'mainType.opis' => 'Jeśli zaznaczone, ten typ zamówień pojawi się na zakładkach',
		'active.etykieta' => 'Czy aktywny?',
      'active.opis' => 'Nieaktywne typy bedą przetrzymywane dla utrzymania historii zamówień',
		'childOrders.etykieta' => 'Czy może mieć dzieci',
      'childOrders.opis' => 'Zaznaczenie oznacza że zamówienia danego typu moga mieć przypiete podzamówienia',
		'dateAdded.etykieta' => 'Data dodania',
      'dateAdded.opis' => '',
		'possibleChargeTypes.etykieta' => 'Możliwe typy płatnosci',
      'possibleChargeTypes.opis' => 'Lista możliwych typów płatnosci',
		'parentTypes.etykieta' => 'Możliwe typy rodziców',
      'parentTypes.opis' => 'Lista typów rodziców do jakich podzadania danego typu moga byc podpinane',
		'formFields.etykieta' => 'Pola formularza',
      'formFields.opis' => 'Litsta pól formularza dla danego typu z zakresu możliwych do wykorzystania pól',
		'idConfigTemplate.etykieta' => 'Szablon konfiguracji',
		'requiredSkills.etykieta' => 'Wymagane umiejętności',
      'parameters.opis' => 'Lista parametrów na podstawie której dany typ zamówienia jest skonfigurowany',
      'name.etykieta' => 'Nazwa',
      'name.opis' => '',
		'previewTemplate.etykieta' => 'Szablon podgladu zamówienia',
		'orderGroup.etykieta' => 'Grupa zamówień',
		'isReclamation.etykieta' => 'Jest reklamacją',
		'directAssignment.etykieta' => 'Przydzielanie bezpośrednie',
		'requireAppointment.etykieta' => 'Wymaga umówienia z klientem',
		'previewTemplate.opis' => 'Na podstawie tego szablonu wyświetlany jest podgląd zamówienia. Każda zmienna posiada stosowną etykiete np.:  LABEL-ORDER_NAME. Zmienne możliwe do użycia:<br/><br/>
			ORDER_NAME, ID_ORDER_BKT, NUMBER_ORDER_GET, NUMBER_ORDER_BKT, NUMBER_PROJECT_GET, CHARGE_TYPE, DATE_ADDED, HOURS_INTERVAL, TOTAL_TIME, DATE_START, DATE_STOP, 
			STATUS_WORK, ADDRESS, CITY, POSTCODE, LOCATION_LAT, LOCATION_LNG, BUDGET, NODE_VILLA_CODE, <br/>
			{{BEGIN ATTRIBUTES}} {{$NAME}} : {{$VALUE}} {{END}}<br/>
			{{BEGIN SERVICES}} {{$NAME}} : {{$QUANTITY}} : {{$TIME}} : {{$VAT}} : {{$BRUTTO}} {{END}}<br/>
			{{BEGIN SERVICES_TOTAL}} {{$QUANTITY}} : {{$TIME}} : {{$VAT}} : {{$BRUTTO}} {{END}}<br/>
			{{BEGIN ATTACHEMENTS}} {{$FILE}} : {{$DATE_ADDED}} : {{$PATH}} {{END}}<br/>
			JOB_DESCRIPTION,<br/>{{BEGIN NOTES}} {{$ID}} : {{$DESCRIPTION}} : {{$DATE_ADDED}} : {{$AUTHOR}} {{END}},<br/>
			CUSTOMER-ID, CUSTOMER-IDCUSTOMER, CUSTOMER-FULLCOMPANYNAME, CUSTOMER-PHONENUMBERS, CUSTOMER-NAME, CUSTOMER-SECONDNAME, CUSTOMER-SURNAME, CUSTOMER-ORGNUMBER, 
			CUSTOMER-COMPANYNAME, CUSTOMER-ADDRESS, CUSTOMER-POSTCODE, CUSTOMER-CITY, CUSTOMER-PHONENUMBER, CUSTOMER-PHONENUMBER1, CUSTOMER-PHONENUMBER2 ,CUSTOMER-PHONEMOBILE, 
			CUSTOMER-FAX, CUSTOMER-EMAIL, CUSTOMER-DATAADDED, CUSTOMER-WWW, PRIVATCUSTOMER-ID, PRIVATCUSTOMER-IDCUSTOMER, PRIVATCUSTOMER-FULLNAME, PRIVATCUSTOMER-PHONENUMBERS, 
			PRIVATCUSTOMER-NAME, PRIVATCUSTOMER-SECONDNAME, PRIVATCUSTOMER-SURNAME, PRIVATCUSTOMER-ORGNUMBER, PRIVATCUSTOMER-COMPANYNAME, PRIVATCUSTOMER-ADDRESS, 
			PRIVATCUSTOMER-POSTCODE, PRIVATCUSTOMER-CITY, PRIVATCUSTOMER-PHONENUMBER, PRIVATCUSTOMER-PHONENUMBER1, PRIVATCUSTOMER-PHONENUMBER2, PRIVATCUSTOMER-PHONEMOBILE, 
			PRIVATCUSTOMER-FAX, PRIVATCUSTOMER-EMAIL, PRIVATCUSTOMER-DATAADDED, PRIVATCUSTOMER-WWW, CONTACT-ID, CONTACT-PHONENUMBERS, CONTACT-NAME,
			CONTACT-SECONDNAME, CONTACT-SURNAME, CONTACT-ADDRESS, CONTACT-POSTCODE, CONTACT-CITY, CONTACT-PHONENUMBER, CONTACT-PHONENUMBER1,
			CONTACT-PHONENUMBER2, CONTACT-PHONEMOBILE, CONTACT-FAX, CONTACT-EMAIL, CONTACT-DATAADDED, LABEL-CONTACT-WWW, LABEL-CUSTOMER-SECTION, LABEL-CONTACT-SECTION, 
			LABEL-SERVICES, LABEL-SERVICES-TOTAL, LABEL-SUBORDERS, LABEL-SUBORDERS-ORDER_NAME, LABEL-SUBORDERS-DATE_ADDED, LABEL-SUBORDERS-DATE_START, LABEL-SUBORDERS-DATE_STOP, 
			LABEL-SUBORDERS-ORDER_TYPE
		',
      
      'possibleChargeTypes.wartosci' => array(
         'given price' => 'Cena ustalona z góry',
			'price per hour' => 'Płatne za godzinę',
			'by products' => 'Płatne po sumie produktów',
      )
	);
}