<?php
namespace Generic\Tlumaczenie\En\Model;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['mainType.etykieta']
 * @property string $t['mainType.opis']
 * @property string $t['active.etykieta']
 * @property string $t['active.opis']
 * @property string $t['childOrders.etykieta']
 * @property string $t['childOrders.opis']
 * @property string $t['dateAdded.etykieta']
 * @property string $t['dateAdded.opis']
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
      'mainType.etykieta' => 'Is it main type?',
      'mainType.opis' => 'If checked this type will be visible on the order types tabs',
		'active.etykieta' => 'Active?',
      'active.opis' => 'Deactivated types are for keeping history purposes',
		'childOrders.etykieta' => 'Can have child orders',
      'childOrders.opis' => 'Checking it will allow this type to have children',
		'dateAdded.etykieta' => 'Date added',
      'dateAdded.opis' => '',
		'possibleChargeTypes.etykieta' => 'Possible charge types',
      'possibleChargeTypes.opis' => 'List of possible charge types',
		'parentTypes.etykieta' => 'Parent types',
      'parentTypes.opis' => 'List of types of orders that this order can be child of',
		'formFields.etykieta' => 'Form fields',
      'formFields.opis' => 'List of form fields for this type of order',
		'idConfigTemplate.etykieta' => 'Configuration template',
		'requiredSkills.etykieta' => 'Required skills',
      'parameters.opis' => 'List of parameters that configures this order type',
      'name.etykieta' => 'Name',
      'name.opis' => '',
		'previewTemplate.etykieta' => 'Preview template',
		'orderGroup.etykieta' => 'Group of orders',
		'isReclamation.etykieta' => 'This is a reclamation',
		'directAssignment.etykieta' => 'Assign directly',
		'requireAppointment.etykieta' => 'Require appointment',
		'previewTemplate.opis' => 'Template that will be used to show order preview. Every variable has it\'s corresponding label eg.: LABEL-ORDER_NAME. Possible variables to use:<br/><br/>
			ORDER_NAME, ID_ORDER_BKT, NUMBER_ORDER_GET, NUMBER_ORDER_BKT, NUMBER_PROJECT_GET, CHARGE_TYPE, DATE_ADDED, HOURS_INTERVAL, TOTAL_TIME, DATE_START, DATE_STOP, 
			STATUS_WORK, ADDRESS, CITY, POSTCODE, LOCATION_LAT, LOCATION_LNG, BUDGET, NODE_VILLA_CODE, <br/>
			{{BEGIN ATTRIBUTES}} {{$NAME}} : {{$VALUE}} {{END}}<br/>
			{{BEGIN SERVICES}} {{$NAME}} : {{$QUANTITY}} : {{$TIME}} : {{$VAT}} : {{$BRUTTO}} {{END}}<br/>
			{{BEGIN SERVICES_TOTAL}} {{$QUANTITY}} : {{$TIME}} : {{$VAT}} : {{$BRUTTO}} {{END}}<br/>
			{{BEGIN ATTACHEMENTS}} {{$FILE}} : {{$DATE_ADDED}} : {{$PATH}} {{END}}<br/>
			{{BEGIN SUBORDERS}} {{$ORDER_NAME}} : {{$DATE_ADDED}} : {{$DATE_START}} : {{$DATE_STOP}} {{END}}
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
         'given price' => 'The given price',
			'price per hour' => 'Price per hour',
			'by products' => 'By selected products',
      )
	);
}