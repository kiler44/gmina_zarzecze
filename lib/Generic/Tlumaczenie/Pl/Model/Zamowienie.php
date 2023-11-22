<?php
namespace Generic\Tlumaczenie\Pl\Model;

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
      'type.etykieta' => 'Typ zamówienia',
		'type.opis' => '',
		
		'orderName.etykieta' => 'Nazwa zamówienia',
		'orderName.opis' => '',
		
		'numberPrivatCustomer.wartosci' => array(),
		
		'numberOrderGet.etykieta' => 'Order # Get',
		'numberOrderGet.opis' => '',

		'numberOrderBkt.etykieta' => 'Order # BKT',
		'numberOrderBkt.opis' => '',

		'numberProjectGet.etykieta' => 'PO-nummer',
		'numberProjectGet.opis' => '',
		
		'numberProjectInkjops.etykieta' => 'Kod projektu',
		'numberProjectInkjops.opis' => '',

		'numberContactId.etykieta' => 'Kontakt ID',
		'numberContactId.opis' => '',
		
		'numberPrivatCustomer.etykieta' => 'Prywatny klient ID',
		'numberPrivatCustomer.opis' => '',
		
		'idPricedBy.etykieta' => 'Osoba wyceniająca projekt',
		'idPricedBy.opis' => '',

		'chargeType.etykieta' => 'Rodzaj rozliczenia',
		'chargeType.opis' => '',

		'dateStart.etykieta' => 'Data rozpoczęcia',
		'dateStart.opis' => '',

		'notCharge.etykieta' => 'NIE pobieraj opłaty za to zamówienie?',
		'notCharge.opis' => '',
		
		'dateStop.etykieta' => 'Data zakończenia',
		'dateStop.opis' => '',

		'status.etykieta' => 'Status',
		'status.opis' => '',

		'statusWork.etykieta' => 'Status zamówienia',
		'statusWork.opis' => '',

		'address.etykieta' => 'Adres',
		'address.opis' => '',
		
		'apartment.etykieta' => 'Apartament',
		'apartment.opis' => '',

		'city.etykieta' => 'Miasto',
		'city.opis' => '',

		'postcode.etykieta' => 'Kod pocztowy',
		'postcode.opis' => '',
		
		'jobDescription.etykieta' => 'Opis zlecenia',
		'jobDescription.opis' => '',
		
		'nodeVillaCode.etykieta' => 'Node/Villa kod',
		'nodeVillaCode.opis' => '',
		
		'locationLat.etykieta' => 'Latitude',
		'locationLat.opis' => '',

		'locationLng.etykieta' => 'Longitude',
		'locationLng.opis' => '',
		
		'hoursInterval.etykieta' => 'Working hours',
		'hoursInterval.opis' => '',
		
		'totalTime.etykieta' => 'Całkowity czas',
		'totalTime.opis' => '',
		
		'attributes.etykieta' => 'Atrybuty',
		'attributes.opis' => '',

		'budget.etykieta' => 'Budżet',
		'budget.opis' => '',
		
		'caloscOplacaGet.etykieta' => 'Ekstra kontakty opłaca GET',
		'caloscOplacaGet.opis' => 'Jeśli to jest projekt z apartamentami, wszystkie eksta kontakty opłaca GET',
		
		'podstawowe.region' => 'Informacje podstawowe',
		'details.region' => 'Szczeguły',
		
		'order_address.region' => 'Adres zamówienia',
		'job_information.region' => 'Informacje zamówienia',
      
      'status.wartosci' => array(
			'' => '- Wybierz -',
			'open' => 'Otwarte',
         'active' => 'Aktywne',
			'cancelled' => 'Anulowane',
			//'out dated' => 'Przeterminowane',
			'closed' => 'Zamknięte',
      ),
		
		'statusWork.wartosci' => array(
			'' => '- Wybierz -',
			'new' => 'Nowe',
			'in progress' => 'W realizacji',
			'done' => 'Zakończone',
			'not done' => 'Nie wykonane',
		),
	);
}