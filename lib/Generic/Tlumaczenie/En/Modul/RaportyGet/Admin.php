<?php
namespace Generic\Tlumaczenie\En\Modul\RaportyGet;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['akceptacjaGet.apartament_nie_istnieje']
 * @property string $t['akceptacjaGet.blad_zapisu']
 * @property string $t['gridApartamenty.address']
 * @property string $t['gridApartamenty.akceptacja_get']
 * @property string $t['gridApartamenty.apartment']
 * @property string $t['gridApartamenty.city']
 * @property string $t['gridApartamenty.data_zakonczenia']
 * @property string $t['gridApartamenty.date_start']
 * @property string $t['gridApartamenty.druga_tura_apartament']
 * @property string $t['gridApartamenty.hours_interval']
 * @property string $t['gridApartamenty.klient']
 * @property string $t['gridApartamenty.podglad']
 * @property string $t['gridApartamenty.postcode']
 * @property string $t['gridApartamenty.status']
 * @property string $t['gridProjekty.date_start']
 * @property string $t['gridProjekty.date_stop']
 * @property string $t['gridProjekty.linkPodglad']
 * @property string $t['gridProjekty.number_project_get']
 * @property string $t['gridProjekty.number_project_inkjops']
 * @property string $t['gridProjekty.order_name']
 * @property string $t['gridProjektyZApartamentami.linkListaApartamentow']
 * @property string $t['index.projektyZApartamentamiEtykieta']
 * @property string $t['index.szukajProjektEtykieta']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.znaleziono_zamowien']
 * @property string $t['listaApartamentow.etykietaDone']
 * @property string $t['listaApartamentow.etykietaInProgress']
 * @property string $t['listaApartamentow.etykietaNew']
 * @property string $t['listaApartamentow.etykietaNotDone']
 * @property string $t['listaApartamentow.nieSprawdzony']
 * @property string $t['listaApartamentow.powrotDoListaProjektowEtykieta']
 * @property string $t['listaApartamentow.sprawdzony']
 * @property string $t['listaApartamentow.sprawdzonyEtykieta']
 * @property string $t['listaApartamentow.statusyEtykieta']
 * @property string $t['listaApartamentow.tytul_modulu']
 * @property string $t['listaApartamentow.tytul_strony']
 * @property string $t['listaApartamentow.xlsExportEtykieta']
 * @property string $t['listaApartemantow.naglowek']
 * @property string $t['listaApartemantow.projekt_nie_istnieje']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'akceptacjaGet.apartament_nie_istnieje' => '[ETYKIETA:akceptacjaGet.apartament_nie_istnieje]',	//TODO
		'akceptacjaGet.blad_zapisu' => '[ETYKIETA:akceptacjaGet.blad_zapisu]',	//TODO
		'gridApartamenty.address' => 'Adress',
		'gridApartamenty.akceptacja_get' => 'Checked',
		'gridApartamenty.apartment' => 'Apartment',
		'gridApartamenty.city' => 'City',
		'gridApartamenty.data_zakonczenia' => 'Date stop',
		'gridApartamenty.date_start' => 'Date start',
		'gridApartamenty.druga_tura_apartament' => 'Second round',
		'gridApartamenty.hours_interval' => 'Time',
		'gridApartamenty.klient' => 'Customer',
		'gridApartamenty.podglad' => 'Preview',
		'gridApartamenty.postcode' => 'Postcode',
		'gridApartamenty.status' => 'Status',
		'gridProjekty.date_start' => 'Date start',
		'gridProjekty.date_stop' => 'Date stop',
		'gridProjekty.linkPodglad' => 'Preview',
		'gridProjekty.number_project_get' => 'Number project GET',
		'gridProjekty.number_project_inkjops' => 'Project inkjops',
		'gridProjekty.order_name' => 'Project name',
		'gridProjektyZApartamentami.linkListaApartamentow' => 'List of apartments',
		'index.projektyZApartamentamiEtykieta' => 'Projects with apartments',
		'index.szukajProjektEtykieta' => 'Search',
		'index.tytul_modulu' => 'Reports GET',
		'index.tytul_strony' => 'Reports GET',
		'index.znaleziono_zamowien' => 'Projects found : ',
		'listaApartamentow.etykietaDone' => 'done',
		'listaApartamentow.etykietaInProgress' => 'in progress',
		'listaApartamentow.etykietaNew' => 'new',
		'listaApartamentow.etykietaNotDone' => 'not done',
		'listaApartamentow.nieSprawdzony' => 'No',
		'listaApartamentow.powrotDoListaProjektowEtykieta' => 'Back to projects list',
		'listaApartamentow.sprawdzony' => 'Yes',
		'listaApartamentow.sprawdzonyEtykieta' => 'Checked : ',
		'listaApartamentow.statusyEtykieta' => 'Statuses : ',
		'listaApartamentow.tytul_modulu' => 'List of apartments',
		'listaApartamentow.tytul_strony' => 'List of apartments',
		'listaApartamentow.xlsExportEtykieta' => 'Export to excel file',
		'listaApartemantow.naglowek' => '{PROJEKT} list of apartments',
		'listaApartemantow.projekt_nie_istnieje' => 'The selected project does not exist',

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}