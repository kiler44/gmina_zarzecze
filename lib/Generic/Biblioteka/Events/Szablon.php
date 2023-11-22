<?php
namespace Generic\Biblioteka\Events;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;
use Generic\Model\Event;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Szablon
 *
 * @author Marcin
 */
class Szablon {
	
	private static $_sciezka = CMS_KATALOG . '/lib/Generic/Events/Szablony';
	protected $_konfiguracjaSzablonu;
	protected $_nazwaSzablonu;
	protected $_cms;


	public function __construct($nazwaSzablonu) {
		
		$this->_nazwaSzablonu = ucfirst($nazwaSzablonu);
		$this->pobierszKonfiguracjeSzablonu();
		$this->_cms = Cms::inst();
	}

	public static function pobierzSzablony()
	{
		$listaSzablonow = array();
		$szablony = array_diff( scandir(self::$_sciezka), ['.', '..'] );
		
		if(!count($szablony)) 
			trigger_error('Nie znaleziono szablonów w systemie' , E_USER_ERROR);
		else
		{
			foreach($szablony as $szablon)
			{
				$nazwa = str_replace('.php', '', $szablon);
				$listaSzablonow[] = $nazwa;
				//$listaSzablonow[$nazwa] = $this->pobierzNazweSzablonu($nazwa);
			}
		}
		
		return $listaSzablonow;
	}
	
	public function pobierzNazweSzablonu()
	{
		return $this->_konfiguracjaSzablonu['nazwa'];
	}
	
	public function pobierzNazwaWyswietlana()
	{
		return (isset($this->_konfiguracjaSzablonu['nazwaWyswietlana'])) ? $this->_konfiguracjaSzablonu['nazwaWyswietlana'] : null;
	}

	public function pobierzOpisSzablonu()
	{
		return $this->_konfiguracjaSzablonu['opis'];
	}
	
	public function pobierzTypWyswietlania()
	{
		return $this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['typWyswietlania'];
	}

	public function pobierzWyswietlajWMenu()
	{
		return $this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['wyswietlajWMenu'];
	}
	
	public function pobierzMultiEvent()
	{
		return (isset($this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['multiEvent'])) ? $this->_konfiguracjaSzablonu['konfiguracjaPodstawowa']['multiEvent'] : false ;
	}


	public function pobierszKonfiguracjeSzablonu()
	{
		$konfiguracja = array();
		
		if(isset($this->_konfiguracjaSzablonu))
		{
			$konfiguracja = $this->_konfiguracjaSzablonu;
		}
		else if(is_file(self::$_sciezka.'/'.$this->_nazwaSzablonu.'.php'))
			$konfiguracja = $this->_konfiguracjaSzablonu = require self::$_sciezka.'/'.$this->_nazwaSzablonu.'.php';
		else
			trigger_error('Nie znaleziono szablonu '.$this->_nazwaSzablonu, E_USER_ERROR);
		
		return $konfiguracja;
	}
	
	
	public function pobierzAkcjeSzablonu()
	{
		$akcje = array();
		foreach($this->_konfiguracjaSzablonu['akcje'] as $klucz => $dane)
		{
			if(preg_match('/(akcja)([a-zA-Z0-9]+)/', $dane['nazwa'], $matches))
			{
				$akcje[$klucz] = $matches[2];
			}
		}
		
		if(!count($akcje)){ trigger_error('Nie znaleziono akcji  w szablonie '.$this->_nazwaSzablonu , E_USER_ERROR); }
		
		return $akcje;
	}
	
	public function pobierzKodKalendarz()
	{
		$akcjeSzablonu = $this->pobierzAkcjeSzablonu();
		foreach($akcjeSzablonu as $kod => $akcja)
		{
			if($akcja == 'DaneKalendarza') return $kod;
		}
		
		return null;
	}

	public function pobierzKonfiguracjeAkcjiZSzablonu($nazwaAkcji, $klucz)
	{
		$nazwaAkcji = 'akcja'.$nazwaAkcji;
		
		$konfiguracjaAkcji = array();
		
		if(isset($this->_konfiguracjaSzablonu['akcje'][$klucz]))
		{
			$konfiguracjaAkcji = $this->_konfiguracjaSzablonu['akcje'][$klucz];
		}
		else
		{
			trigger_error('Nie znaleziono akcji '.$nazwaAkcji.' w szablonie '.$this->_nazwaSzablonu , E_USER_ERROR);
		}
		
		return $konfiguracjaAkcji;
	}
	
	public function pobierzInputyAkcjiZSzablonu($nazwaAkcji, $klucz)
	{
		$nazwaAkcji = 'akcja'.$nazwaAkcji;
		
		$inputy = array();
		
		if(isset($this->_konfiguracjaSzablonu['akcje'][$klucz]['inputy']))
		{
			$inputy = $this->_konfiguracjaSzablonu['akcje'][$klucz]['inputy'];
		}
		 
		
		return $inputy;
	}
	
	public function akcjaIstnieje($nazwaAkcji, $klucz)
	{
		return (isset($this->_konfiguracjaSzablonu['akcje'][$klucz]) && ($this->_konfiguracjaSzablonu['akcje'][$klucz]['nazwa'] === $nazwaAkcji));
	}
}
