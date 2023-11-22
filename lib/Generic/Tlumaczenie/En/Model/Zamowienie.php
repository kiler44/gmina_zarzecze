<?php
namespace Generic\Tlumaczenie\En\Model;

use Generic\Tlumaczenie\Tlumaczenie;

/**
* @property string $t['type.etykieta']
* @property string $t['type.opis']
* @property string $t['numberOrderGet.etykieta']
* @property string $t['numberOrderGet.opis']
* @property string $t['numberOrderBkt.etykieta']
* @property string $t['numberOrderBkt.opis']
* @property string $t['numberProjectGet.etykieta']
* @property string $t['numberProjectGet.opis']
* @property string $t['numberContactId.etykieta']
* @property string $t['numberContactId.opis']
* @property string $t['chargeType.etykieta']
* @property string $t['chargeType.opis']
* @property string $t['dateStart.etykieta']
* @property string $t['dateStart.opis']
* @property string $t['dateStop.etykieta']
* @property string $t['dateStop.opis']
* @property string $t['status.etykieta']
* @property string $t['status.opis']
* @property string $t['statusWork.etykieta']
* @property string $t['statusWork.opis']
* @property string $t['address.etykieta']
* @property string $t['address.opis']
* @property string $t['city.etykieta']
* @property string $t['city.opis']
* @property string $t['postcode.etykieta']
* @property string $t['postcode.opis']
* @property string $t['jobDescription.etykieta']
* @property string $t['jobDescription.opis']
* @property string $t['nodeVillaCode.etykieta']
* @property string $t['nodeVillaCode.opis']
* @property string $t['locationLat.etykieta']
* @property string $t['locationLat.opis']
* @property string $t['locationLng.etykieta']
* @property string $t['locationLng.opis']
* @property string $t['hoursInterval.etykieta']
* @property string $t['hoursInterval.opis']
* @property string $t['totalTime.etykieta']
* @property string $t['totalTime.opis']
* @property string $t['attributes.etykieta']
* @property string $t['attributes.opis']
* @property string $t['budget.etykieta']
* @property string $t['budget.opis']
 */
class Zamowienie extends Tlumaczenie
{

	protected $tlumaczeniaDomyslne = array(
      'type.etykieta' => 'Order type',
		'type.opis' => '',
		
		'orderName.etykieta' => 'Order name',
		'orderName.opis' => '',
		
		'numberPrivatCustomer.wartosci' => array(),
		
		'numberOrderGet.etykieta' => 'Order # Get',
		'numberOrderGet.opis' => '',
		
		'numberProjectInkjops.etykieta' => 'Project code',
		'numberProjectInkjops.opis' => '',
		
		'numberOrderBkt.etykieta' => 'Order # BKT',
		'numberOrderBkt.opis' => '',

		'numberProjectGet.etykieta' => 'PO-nummer',
		'numberProjectGet.opis' => '',

		'numberContactId.etykieta' => 'Contact ID',
		'numberContactId.opis' => '',
		
		'numberPrivatCustomer.etykieta' => 'Customer',
		'numberPrivatCustomer.opis' => '',
		
		'idPricedBy.etykieta' => 'Osoba wyceniająca projekt',
		'idPricedBy.opis' => '',
		
		'numberCustomer.etykieta' => 'Billing customer',
		'numberCustomer.opis' => '',

		'chargeType.etykieta' => 'Charge type',
		'chargeType.opis' => '',

		'dateStart.etykieta' => 'Start date',
		'dateStart.opis' => '',
		
		'notCharge.etykieta' => 'DO NOT charge this customer for this order?',
		'notCharge.opis' => '',

		'dateStop.etykieta' => 'Stop date',
		'dateStop.opis' => '',

		'status.etykieta' => 'Status',
		'status.opis' => '',

		'statusWork.etykieta' => 'Work status',
		'statusWork.opis' => '',

		'address.etykieta' => 'Address',
		'address.opis' => '',
		
		'apartment.etykieta' => 'Apartment',
		'apartment.opis' => '',

		'city.etykieta' => 'City',
		'city.opis' => '',

		'postcode.etykieta' => 'Postcode',
		'postcode.opis' => '',
		
		'jobDescription.etykieta' => 'Job description',
		'jobDescription.opis' => '',
		
		'nodeVillaCode.etykieta' => 'Node/Villa code',
		'nodeVillaCode.opis' => '',
		
		'locationLat.etykieta' => 'Latitude',
		'locationLat.opis' => '',

		'locationLng.etykieta' => 'Longitude',
		'locationLng.opis' => '',
		
		'hoursInterval.etykieta' => 'Working hours',
		'hoursInterval.opis' => '',
		
		'totalTime.etykieta' => 'Total time',
		'totalTime.opis' => '',
		
		'attributes.etykieta' => 'Attributes',
		'attributes.opis' => '',

		'budget.etykieta' => 'Budget',
		'budget.opis' => '',
		
		'caloscOplacaGet.etykieta' => 'Ekstrakontakts paid by GET',
		'caloscOplacaGet.opis' => 'If this is apartments project, all ekstrakontakts will be paid by GET',
		
		'podstawowe.region' => 'General information',
		'details.region' => 'Details',
		
		'order_address.region' => 'Order address',
		'job_information.region' => 'Order information',
      
      'status.wartosci' => array(
			'' => '- Select -',
			'open' => 'Open',
         'active' => 'Active',
			'cancelled' => 'Cancelled',
			//'out dated' => 'Out dated',
			'closed' => 'Closed',
      ),
		
		'statusWork.wartosci' => array(
			'' => '- Select -',
			'new' => 'New',
			'in progress' => 'In progress',
			'done' => 'Done',
			'not done' => 'Not done',
		),
	);
}