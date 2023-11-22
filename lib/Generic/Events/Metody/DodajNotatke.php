<?php
namespace Generic\Events\Metody;
use Generic\Biblioteka\Events\Metoda;
use Generic\Model\Notes;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;
use Generic\Model\EventMetody;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of przydzielTeam
 *
 * @author Marcin
 */
final class DodajNotatke extends Metoda {
	
	
	public function start(EventMetody\Obiekt $eventMetoda)
	{
		
	}
	
	public function stop(EventMetody\Obiekt $eventMetoda)
	{
		
	}
	
	public static function zapiszNotatke()
	{ 
		$notatkaMapper = new Notes\Mapper();
		$notatka = new Notes\Obiekt();
		$notatka->description = Zadanie::pobierz('daneForm')['trescNotatki'];
		$notatka->orderNumber = (isset(Zadanie::pobierz('daneForm')['orderNumber']) && Zadanie::pobierz('daneForm')['orderNumber'] != '') ? Zadanie::pobierz('daneForm')['orderNumber'] : '';
		$notatka->author = Cms::inst()->profil()->id;
		$notatka->zapisz($notatkaMapper);
		return $notatka;
	}
	
}
