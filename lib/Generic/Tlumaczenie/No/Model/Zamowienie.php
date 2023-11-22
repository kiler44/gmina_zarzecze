<?php
namespace Generic\Tlumaczenie\No\Model;

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
      'type.etykieta' => 'Ordretype',
		'type.opis' => '',
		
		'orderName.etykieta' => 'Ordrenavn',
		'orderName.opis' => '',
		
		'numberPrivatCustomer.wartosci' => array(),
		
		'numberOrderGet.etykieta' => 'Bestill # Get',
		'numberOrderGet.opis' => '',

		'numberOrderBkt.etykieta' => 'Bestill # BKT',
		'numberOrderBkt.opis' => '',

		'numberProjectGet.etykieta' => 'PO-nummer',
		'numberProjectGet.opis' => '',
		
		'numberProjectInkjops.etykieta' => 'Prosjekt code',
		'numberProjectInkjops.opis' => '',

		'numberContactId.etykieta' => 'Kontakt ID',
		'numberContactId.opis' => '',
		
		'numberPrivatCustomer.etykieta' => 'Customer',
		'numberPrivatCustomer.opis' => '',
		
		'idPricedBy.etykieta' => 'Priced by ',
		'idPricedBy.opis' => '',
		
		'numberCustomer.etykieta' => 'Billing customer',
		'numberCustomer.opis' => '',

		'chargeType.etykieta' => 'Charge typen',
		'chargeType.opis' => '',

		'dateStart.etykieta' => 'Start dato',
		'dateStart.opis' => '',

		'notCharge.etykieta' => 'IKKE belaste denne kunden for denne bestillingen?',
		'notCharge.opis' => '',
		
		'dateStop.etykieta' => 'Stopp dato',
		'dateStop.opis' => '',

		'status.etykieta' => 'Status',
		'status.opis' => '',

		'statusWork.etykieta' => 'Arbeid status',
		'statusWork.opis' => '',

		'address.etykieta' => 'Adresse',
		'address.opis' => '',
		
		'apartment.etykieta' => 'Apartment',
		'apartment.opis' => '',

		'city.etykieta' => 'Stadt',
		'city.opis' => '',

		'postcode.etykieta' => 'Postnummeret',
		'postcode.opis' => '',
		
		'jobDescription.etykieta' => 'Stillingsbeskrivelse',
		'jobDescription.opis' => '',
		
		'nodeVillaCode.etykieta' => 'Node / Villa koden',
		'nodeVillaCode.opis' => '',
		
		'locationLat.etykieta' => 'Latitude',
		'locationLat.opis' => '',

		'locationLng.etykieta' => 'Longitude',
		'locationLng.opis' => '',
		
		'hoursInterval.etykieta' => 'Arbeidstid',
		'hoursInterval.opis' => '',
		
		'totalTime.etykieta' => 'Total tid',
		'totalTime.opis' => '',
		
		'attributes.etykieta' => 'Attributter',
		'attributes.opis' => '',

		'budget.etykieta' => 'Budsjett',
		'budget.opis' => '',
		
		'caloscOplacaGet.etykieta' => 'Ekstrakontakts paid by GET',
		'caloscOplacaGet.opis' => 'Hvis dette er leilighetene prosjektet, vil alle ekstrak kontakter betales av GET',
		
		'podstawowe.region' => 'Generell informasjon',
		'details.region' => 'Detaljer',
		
		'order_address.region' => 'Ordre adresse',
		'job_information.region' => 'Ordreinformasjon',
      
		'status.wartosci' => array(
			'' => '- Velg -',
			'open' => 'Åpent',
         'active' => 'Aktiv',
			'cancelled' => 'Avbrutt',
			//'out dated' => 'Ut datert',
			'closed' => 'Stengt',
      ),
		
		'statusWork.wartosci' => array(
			'' => '- Velg -',
			'new' => 'Ny',
			'in progress' => 'In progress',
			'done' => 'Ferdig',
			'not done' => 'Ikke ferdig',
		),
	);
}
