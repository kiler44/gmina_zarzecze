<?php
namespace Generic\Biblioteka\Pomocnik;

use Generic\Biblioteka\{
	Cms,
	Bledy,
	Plik
};
use Generic\Model\Zamowienie;

class GetApi extends Curl{
	
	private $user;
	private $users = array(
		'getSetvice' => array(
			'login' => 's_getservice_bkt',
			'password' => 'b3kriuJm',
		),
		't712' => array(
			'login' => 'T712',
			'password' => '6NQk2HK9',
		),
	);
	//private $username = 's_getservice_bkt';
	//private $username = 'T712';
	//private $username = 'bktdampis';
	//private $password = 'b3kriuJm';
	//private $password = '6NQk2HK9';
	private $_baseUrl = 'https://getservice.get.no/';
	//private $_baseUrl = 'https://feltportal-qa.get.no/';
	private  $zapisujTokenWPliku = false;
	protected $_url = array(
		'autoryzacja' => 'auth',
		//'pobierzZamowienieT712' => 'work-orders',
		'pobierzZamowienieT712' => 'work-orders',
		//'pobierzListeZamowien' => 'control/work-orders',
		'pobierzListeZamowien' => 'control/work-orders',
		'pobieListeZamowienWszystkich' => 'control/work-orders/all',
		'pobierzZamowienie' => 'control/addresses/history',
		'pobierzListePracownikow' => 'control/employees',
		'pobierzProduktyKlienta' => 'control/products/current',
		'przydzielZamowienia' => 'control/work-orders/assign'
	);
	
	public function __construct() {
		parent::__construct($this->_baseUrl);
		$this->user = $this->users['getSetvice'];
	}
	
	public function setUser($name)
	{
		if(isset($this->users[$name]))
		{
			$this->user = $this->users[$name];
		}
		else
		{
			throw new Exception('Uzytkownik nie istnieje');
		}
	}
	
	private function tokenZapiszDoPliku($token)
	{
		$data = new \DateTime();
		$username = $this->user['login'];
		$nazwaPliku = $username;
		$tresc = $data->format('Y-m-d H').'|'.$token;
		file_put_contents(Cms::inst()->katalog('get_api_token').'/'.$nazwaPliku.'.txt', $tresc );
	}
	
	private function pobierzToken()
	{
		$data = new \DateTime();
		$username = $this->user['login'];
		$nazwaPliku = $username;
		
		if(file_exists(Cms::inst()->katalog('get_api_token').'/'.$nazwaPliku.'.txt'))
		{
			$tresc = file_get_contents(Cms::inst()->katalog('get_api_token').'/'.$nazwaPliku.'.txt');
			list($dataPlik, $token) = explode('|', $tresc);
			if($dataPlik == $data->format('Y-m-d H'))
				return $token;
			else
				return null;
		}
		else
			return null;
	}
	
	protected function pobierzZamowienieT712($orderNumber)
	{
		$url = $this->ustawAdres(__FUNCTION__, array(), $orderNumber);
		$this->ustawGetType();
		return $this->pobierzWynik();
	}

	public function autoryzacja()
	{
		$dane = '{ "username":"'.$this->user['login'].'", "password":"'.$this->user['password'].'" }';
		$url = $this->ustawAdres(__FUNCTION__);
		
		$this->ustawDanePost($dane);
		
		$tokent = null;
		if($this->zapisujTokenWPliku)
			$tokent = $this->pobierzToken();

		if($tokent != null && $this->zapisujTokenWPliku)
		{
			
			//dump('token z pliku '.$tokent);
			$this->ustawToken($tokent);
		}
		else
		{
			$wynik = $this->pobierzWynik();
			$kod = $this->pobierzHttpCode();
			if($kod == 200 && isset($wynik['token']))
			{
				//dump('token z serwera '.$wynik['token']);
				$this->ustawToken($wynik['token']);
				if($this->zapisujTokenWPliku) $this->tokenZapiszDoPliku($wynik['token']);
			}
			else
			{
				return null;
			}
			
		}

		return $this;
		
	}
	
	public function pobierzUrlGlowny()
	{
		return $this->_baseUrl;
	}
	
	public function pobierzUrlZamowienia($numberOrderGet)
	{
		return $this->_baseUrl.'#/workOrder/'.$numberOrderGet;
	}
	
	public function pobierzUrlZamowienieZamknij($numberOrderGet)
	{
		return $this->_baseUrl.'#/workOrder/'.$numberOrderGet.'/workLog';
	}
	
	public function pobieListeZamowienWszystkich()
	{
		$daneGet = array();
		$url = $this->ustawAdres(__FUNCTION__, $daneGet);
		$this->ustawGetType();
		return $this->pobierzWynik();
	}

	/*
	 * Lista zamówień do przydzielenia
	 */
	public function pobierzListeZamowien($employee = null)
	{
		$daneGet = array();
		if($employee != null)
			$daneGet = array('employee' => $employee);

		$url = $this->ustawAdres(__FUNCTION__, $daneGet);
		$this->ustawGetType();
		return $this->pobierzWynik();
	}
	
	/*
	 * szczegóły zamówienia
	 */
	public function pobierzZamowienie($orderNumberGet)
	{
		$dane = array('workOrderId' => $orderNumberGet);
		
		$url = $this->ustawAdres(__FUNCTION__, $dane);
		$this->ustawGetType();
		
		return $this->pobierzWynik();
	}
	
	
	public function pobierzIdKlientaGET($orderNumberGet)
	{
		$historiaZamowien = $this->pobierzZamowienie($orderNumberGet);
		$zamowienie = (isset($historiaZamowien[0])) ? $historiaZamowien[0] : '';
		return (isset($zamowienie['customerId'])) ? $zamowienie['customerId'] : '';
	}


	public function przydzielZamowienia($pracownik, $listaZamowien)
	{
		$daneGet = array('externalEmployeeCode' => $pracownik);
		$listaDoWyslania = (count($listaZamowien) > 0) ? implode(',' , $listaZamowien) :  array();
		$danePost = '{ "workOrderIds": ['.$listaDoWyslania.'] }';
		$url = $this->ustawAdres(__FUNCTION__, $daneGet);
		$this->ustawPostType();
		$this->ustawDanePost($danePost);
	
		return $this->pobierzWynik();
	}

	/*
	 * lista naszych pracowników w systemie GET
	 */
	public function pobierzListePracownikow()
	{
		$url = $this->ustawAdres(__FUNCTION__);
		$this->ustawGetType();
		
		return $this->pobierzWynik();
	}
	
	/*
	 * pobiera szczegółowe informacje na temat produktów
	 */
	public function pobierzProduktyKlientaGet($customerId)
	{
		$dane = array('customerId' => $customerId);

		$url = $this->ustawAdres(__FUNCTION__ , $dane);
		$this->ustawGetType();
		
		return $this->pobierzWynik();
	}
	
}

class ApiException extends \Exception
{
	
}