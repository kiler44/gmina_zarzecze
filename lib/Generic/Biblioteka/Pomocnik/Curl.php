<?php
namespace Generic\Biblioteka\Pomocnik;

use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Bledy;
use Generic\Biblioteka\Plik;

class Curl {
	
	private $wyswietlajBledy = true;
	private $_baseUrl;
	private $curlOpt = array(
		CURLOPT_POST => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_VERBOSE => 1,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json'
		)
	);
	
	private $ch;
	
	public function __construct($url) {
		$this->_baseUrl = $url;
		$this->ch = curl_init();
		curl_setopt_array($this->ch, $this->curlOpt);
	}
	
	public function __destruct() {
		$this->zapiszBledy();
		curl_close($this->ch);
	}
	
	protected function ustawDanePost($dane)
	{
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $dane);
	}
	
	/**
	 * @param Array $dane
	 */
	private function ustawDaneGet($dane)
	{
		$getArray = array();
		
		foreach($dane as $parametr => $wartosc)
		{
			$getArray[] = $parametr.'='.$wartosc;
		}
		$get = '?'.implode('&', $getArray);
		return $get;
	}

	protected function ustawToken($token)
	{
		$naglowek = $this->curlOpt[CURLOPT_HTTPHEADER];
		array_push($naglowek, "Authorization: Bearer ".$token);
		$this->curlOpt[CURLOPT_HTTPHEADER] = $naglowek;
		curl_setopt_array($this->ch, $this->curlOpt);
	}
	
	protected function setCookie()
	{
		$tmpfname = dirname(__FILE__).'/cookie.txt';
		curl_setopt($session, CURLOPT_COOKIEJAR, $tmpfname);
		curl_setopt($session, CURLOPT_COOKIEFILE, $tmpfname);
	}

	public function pobierzKlienta()
	{
		$this->ustawGetType();
		curl_setopt($this->ch, CURLOPT_URL, 'https://feltportal-qa.get.no/work-orders/2062876');
		return $this->pobierzWynik();
	}
	protected function ustawAdres($metoda, $getParam = array(), $doklej = null)
	{
		$url = $this->_baseUrl;
		
		if(isset($this->_url[$metoda]))
			$url .= $this->_url[$metoda];
		
		if(count($getParam)){ $url.=$this->ustawDaneGet($getParam);  }
		
		if($doklej != null)
		{
			$url.='/'.$doklej;
		}
		curl_setopt($this->ch, CURLOPT_URL, $url);
		
		return $url;
	}
	
	protected function ustawGetType()
	{
		$this->curlOpt[CURLOPT_POST] = false;
		curl_setopt_array($this->ch, $this->curlOpt);
	}
	
	protected function ustawPostType()
	{
		$this->curlOpt[CURLOPT_POST] = true;
		curl_setopt_array($this->ch, $this->curlOpt);
	}
	
	protected function pobierzContentType()
	{
		$return = '';
		$type = isset($this->getInfo()['content_type']) ?  $this->getInfo()['content_type'] : '';
		if(count($typeTab = explode(';', $type)))
		{
			$return = $typeTab[0];
		}
		return $return;
	}
	
	protected function parsujWynik($wynik)
	{
		if($this->pobierzContentType() == 'application/json')
		{
			$wynik = json_decode($wynik, true);
		}
		return $wynik;
	}
	
	protected function pobierzWynik()
	{
		$return = curl_exec($this->ch);
		
		switch ($this->pobierzHttpCode())
		{
			case 200 : $return = $this->parsujWynik($return);
				break;
			case 201 : $return = 'Dane zapisane';
				break;
			case 401 : $return = 'Brak autoryzacji';
				break;
			case 403 : $return = 'Brak dostępu';
				break;
			case 404 : $return = 'Nie znaleziono zasobu';
				break;
			case 500 : $return = 'Server problem';
				break;
		}
		
		return $return;
	}
	
	public function pobierzHttpCode()
	{
		return isset($this->getInfo()['http_code']) ?  $this->getInfo()['http_code'] : '';
	}
	
	protected function getInfo()
	{
		$info = curl_getinfo($this->ch);
		return $info;
	}
	
	protected function zapiszBledy()
	{
		
		if (curl_errno($this->ch))
		{
			$errors = '';
			$errors.=  date('Y-m-d H:i:s').' Error #' . curl_errno($this->ch) . ': ' . curl_error($this->ch);
			$logBledu = new Plik(LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-error-api-get.log', true);
			//if($wyswietlajBledy) 
			
			return $logBledu->ustawZawartosc($errors, true);
		
		}
		return true;
	}
}
