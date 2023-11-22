<?php
namespace Generic\Tlumaczenie\No\Model;

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
      'mainType.etykieta' => 'Er det viktigste type?',
      'mainType.opis' => 'Hvis sjekket denne typen vil være synlig på ordretyper kategoriene',
		'active.etykieta' => 'Active?',
      'active.opis' => 'Deaktiverte typer er for å holde historie formål',
		'childOrders.etykieta' => 'Kan ha barnet bestillinger',
      'childOrders.opis' => 'Kontrollere det vil tillate denne typen til å få barn',
		'dateAdded.etykieta' => 'Dato lagt',
      'dateAdded.opis' => '',
		'possibleChargeTypes.etykieta' => 'Mulige charge typer',
      'possibleChargeTypes.opis' => 'Liste over mulige charge typer',
		'parentTypes.etykieta' => 'Foreldre typer',
      'parentTypes.opis' => 'Liste over typer bestillinger som denne rekkefølgen kan være barn av',
		'formFields.etykieta' => 'Skjemafelt',
      'formFields.opis' => 'Liste over skjemafelt for denne type ordre',
		'idConfigTemplate.etykieta' => 'Konfigurasjonsmal',
		'requiredSkills.etykieta' => 'Nødvendige ferdigheter',
      'parameters.opis' => 'Liste over parametre som konfigurerer denne ordretype',
      'name.etykieta' => 'Navn',
      'name.opis' => '',
		'previewTemplate.etykieta' => 'Forhåndsvisning mal',
		'orderGroup.etykieta' => 'Gruppe av ordre',
		'isReclamation.etykieta' => 'Dette er en gjenvinning',
		'directAssignment.etykieta' => 'Tildele direkte',
		'requireAppointment.etykieta' => 'Krev avtale',
		'previewTemplate.opis' => 'Mal som skal brukes til å vise for forhåndsvisning. Hver variabel har det tilsvarende etiketten f.eks:. LABEL-ORDER_NAME. Mulige variabler å bruke:<br/><br/>
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
         'given price' => 'Den oppgitte pris',
			'price per hour' => 'Pris per time',
			'by products' => 'Av utvalgte produkter',
      )
	);
}