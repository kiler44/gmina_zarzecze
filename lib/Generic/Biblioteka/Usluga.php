<?php
namespace Generic\Biblioteka;


/**
 * Klasa abstrakcyjna dla wszystkich uslug udostepnianych w cms
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

abstract class Usluga
{

	/**
	 * Metoda startujaca usluge
	 */
	public abstract function start();



	/**
	 * Zwraca kod usługi
	 *
	 * @return string
	 */
	public function kod()
	{
		$kodRozbity = explode('\\',get_class($this));
		return array_pop($kodRozbity);
	}
	
	protected function ustawSzablony()
	{
		define('NOWY_SZABLON', 0);
		if(NOWY_SZABLON)
		{
			define('SZABLON_KOMUNIKATU', 'communiqueNew.tpl');
			define('SZABLON_FORMULARZ', 'formNew.tpl');
			define('SZABLON_FORMULARZ_GRID', 'form_gridNew.tpl');
			define('SZABLON_UKLADY', 'admin_layoutNew.tpl');
			define('SZABLON_KONTENER', 'containersNew.tpl');
			define('SZABLON_MODUL', 'moduleNew.tpl');
			define('SZABLON_MANAGER_PLIKOW', 'fileManagerNew.tpl');
			define('SZABLON_TABELA_DANYCH', 'dataTableNew.tpl');
			define('SZABLON_TABELA_DANYCH2', 'dataTable2New.tpl');
			define('SZABLON_TABELA_SORTOWANIE', 'dataTableSortNew.tpl');
			define('SZABLON_UKLAD_HTML', 'html_layoutNew.tpl');
			define('SZABLON_RAPORTY', 'reports_layoutNew.tpl');
		}
		else
		{
			define('SZABLON_KOMUNIKATU', 'komunikat.tpl');
			define('SZABLON_FORMULARZ_GRID', 'formularz_grid.tpl');
			define('SZABLON_FORMULARZ', 'formularz.tpl');
			define('SZABLON_UKLADY', 'admin_uklad.tpl');
			define('SZABLON_KONTENER', 'kontenery.tpl');
			define('SZABLON_MODUL', 'modul.tpl');
			define('SZABLON_MANAGER_PLIKOW', 'szablon_manager_plikow.tpl');
			define('SZABLON_TABELA_DANYCH', 'tabela_danych.tpl');
			define('SZABLON_TABELA_DANYCH2', 'tabela_danych2.tpl');
			define('SZABLON_TABELA_SORTOWANIE', 'tabela_sortowanie.tpl');
			define('SZABLON_UKLAD_HTML', 'uklad_html_szablon.tpl');
			define('SZABLON_RAPORTY', 'raporty.tpl');
		}
	}
}

class UslugaWyjatek extends \Exception {}


