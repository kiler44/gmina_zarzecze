<?php
namespace Generic\Tlumaczenie\Pl\Modul\RaportyGet;

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
		'gridApartamenty.address' => 'Adres',
		'gridApartamenty.akceptacja_get' => 'Sprawdzony',
		'gridApartamenty.apartment' => 'Apartament',
		'gridApartamenty.city' => 'Miasto',
		'gridApartamenty.data_zakonczenia' => 'Data zakończenia',
		'gridApartamenty.date_start' => 'Data',
		'gridApartamenty.druga_tura_apartament' => 'Druga runda',
		'gridApartamenty.hours_interval' => 'Czas',
		'gridApartamenty.klient' => 'Klient',
		'gridApartamenty.podglad' => 'Podgląd',
		'gridApartamenty.postcode' => 'Kod pocztowy',
		'gridApartamenty.status' => 'Status',
		'gridProjekty.date_start' => 'Data start',
		'gridProjekty.date_stop' => 'Data stop',
		'gridProjekty.linkPodglad' => 'Podgląd',
		'gridProjekty.number_project_get' => 'Number project GET',
		'gridProjekty.number_project_inkjops' => 'Project inkjops',
		'gridProjekty.order_name' => 'Nazwa projektu',
		'gridProjektyZApartamentami.linkListaApartamentow' => 'Lista apartamentów',
		'index.projektyZApartamentamiEtykieta' => 'Projekty z apartamentami',
		'index.szukajProjektEtykieta' => 'Szukaj',
		'index.tytul_modulu' => 'Raporty GET',
		'index.tytul_strony' => 'Raporty GET',
		'index.znaleziono_zamowien' => 'Znaleziono ',
		'listaApartamentow.etykietaDone' => 'wykonane',
		'listaApartamentow.etykietaInProgress' => 'w trakcie',
		'listaApartamentow.etykietaNew' => 'nowy',
		'listaApartamentow.etykietaNotDone' => 'nie wykonany',
		'listaApartamentow.nieSprawdzony' => 'Nie',
		'listaApartamentow.powrotDoListaProjektowEtykieta' => 'Lista projektów',
		'listaApartamentow.sprawdzony' => 'Tak',
		'listaApartamentow.sprawdzonyEtykieta' => 'Sprawdzony : ',
		'listaApartamentow.statusyEtykieta' => 'Statusy : ',
		'listaApartamentow.tytul_modulu' => 'Lista apartamentów',
		'listaApartamentow.tytul_strony' => 'Lista apartamentów',
		'listaApartamentow.xlsExportEtykieta' => 'Eksportuj do pliku excel',
		'listaApartemantow.naglowek' => '{PROJEKT} lista apartmentow',
		'listaApartemantow.projekt_nie_istnieje' => 'Wybrany projekt nie istnieje',

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}