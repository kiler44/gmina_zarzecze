<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\GoogleWebmasterTool;
use Generic\Biblioteka\GoogleAuth;
use Generic\Biblioteka\Entry;
use Generic\Biblioteka\CrawlIssues;
use Generic\Biblioteka\Keywords;

/*
 * Klasa obslugi Google Webmaster Tools API
 * Pochodzi z:
 * http://www.simplesoft.it/google-webmaster-tools-api-in-php.html
 * opakowany w pojedyncza klase przez: Konrad Rudowski tylko dla uzytkowanych opcji
 *
 */

class Entry {

	private $map = array();


	public function addProperty($key,$value) {
		$this->map[$key] = $value;
	}


	public function getPropertyValue($key) {
		if (!isset($this->map[$key])) return false;
		return $this->map[$key];
	}


	public function getArrayResult() {
		return $this->map;
	}

}


class GoogleAuth {

	protected static $_URL_LOGIN_GOOGLE = "https://www.google.com/accounts/ClientLogin";


	public static function getAuth($email, $pwd, $service) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, GoogleAuth::$_URL_LOGIN_GOOGLE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST, true);
		$postRequest = array(
			'accountType' => 'HOSTED_OR_GOOGLE',
			'Email' => $email,
			'Passwd' => $pwd,
			'service' => $service,
			'source' => ''
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postRequest);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		if ($info['http_code'] == 200) {
			preg_match('/Auth=(.*)/', $output, $match);
			if(isset($match[1])) {
				return $match[1];
			}
		}
		return $info['http_code'];
	}

}


abstract class GoogleWebmasterTool {

	protected $baseUrl = "https://www.google.com/webmasters/tools/feeds/";

	protected $auth;
	protected $service;


	function __construct($auth) {
		$this->auth = $auth;
	}


	protected function urlencoding($site) {
		return str_replace(".", "%2E", urlencode($site));
	}

	protected function executeService($site, $operation) {
		if (strlen($site)>0)
			$request = $this->urlencoding($site)."/".$operation."/";
		else
			$request = $operation."/";

		$url = $this->baseUrl.$request;
		$xml = $this->getFeed($url, $this->auth);
		return $xml;
	}


	protected function requestHttpPutXml($url,$xml, $put=false) {
		$ch = curl_init();
		$aut = $this->auth;
		$header = array("Authorization: GoogleLogin auth=".$aut,"GData-Version: 2","Content-type: application/atom+xml");
		if ($put)
			array_push($header, "X-HTTP-Method-Override: PUT");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		$r = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		return $info['http_code'];
	}


	protected function requestHttpDelete($url) {
		//$url = $this->baseUrl."sites/".urlencode($site);
		$aut = $this->auth;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: GoogleLogin auth=".$aut,"GData-Version: 2","X-HTTP-Method-Override: DELETE"));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		return $info['http_code'];
	}


	public function getFeed($url) {
		$ch = curl_init();
		$head = array("Authorization: GoogleLogin auth=".$this->auth,"GData-Version: 2");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
			if ($info['http_code']!=200) return $info['http_code'];
		return $result;
	}


	protected function getEtag() {

	}


	public function getDataResult($site="") {
		$data = array();
		$xml = $this->executeService($site, $this->service);
		if (is_integer($xml)) {
			$this->errorCode = $xml;
			return false;
		}
		$dom = new \DOMDocument();
		$dom->loadXML($xml);
		$entries = $dom->getElementsByTagName("entry");
		foreach($entries as $entry) {
			$objectEntry = new Entry();
			$nodes = $entry->childNodes;
			foreach($nodes as $node) {
				$objectEntry->addProperty($node->nodeName, $node->nodeValue);
			}
			array_push($data, $objectEntry);
		}
		return $data;
	}

}



class Keywords extends GoogleWebmasterTool {


	function __construct($auth) {
		$this->auth = $auth;
		$this->service = "keywords";
	}


	public function getDataResult($site) {
		$external = array();
		$internal = array();
		$xml = $this->executeService($site, "keywords");
		if (is_integer($xml)) {
			$this->errorCode = $xml;
			echo $xml;
			return false;
		}
		$data = array();
		$dom = new \DOMDocument();
		$dom->loadXML($xml);
		$keywords = $dom->getElementsByTagName("keyword");
		foreach ($keywords as $keyword) {
			if (strcasecmp($keyword->getAttribute("source"),"external")==0) {
				array_push($external, $keyword->nodeValue);
			} else {
				array_push($internal, $keyword->nodeValue);
			}
		}
		return array(
			"external" => $external,
			"internal" => $internal
		);
	}

}



class ManagingSitemaps extends GoogleWebmasterTool {

	function __construct($auth) {
		$this->auth = $auth;
		$this->service = "sitemaps";
	}


	public function submitRegularSitemap($site, $sitemap_url, $type="WEB") {
		$url = $this->baseUrl.$this->urlencoding($site)."/sitemaps/";
		$xml = "<atom:entry xmlns:atom='http://www.w3.org/2005/Atom'><atom:id>".$sitemap_url."</atom:id><atom:category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/webmasters/tools/2007#sitemap-regular'/><wt:sitemap-type xmlns:wt='http://schemas.google.com/webmasters/tools/2007'>".$type."</wt:sitemap-type></atom:entry>";
		return $this->requestHttpPutXml($url, $xml);
	}


	public function submitSitemapMobile($site, $sitemap_url, $markup_language="HTML") {
		$url = $this->baseUrl.$this->urlencoding($site)."/sitemaps/";
		$xml = "<atom:entry xmlns:atom='http://www.w3.org/2005/Atom'><atom:id>".$sitemap_url."</atom:id><atom:category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/webmasters/tools/2007#sitemap-mobile'/> <wt:sitemap-mobile-markup-language xmlns:wt='http://schemas.google.com/webmasters/tools/2007'>".$markup_language."</wt:sitemap-mobile-markup-language></atom:entry>";
		return $this->requestHttpPutXml($url, $xml);
	}


	public function submitSitemapNews($site, $sitemap_url, $publication_label="") {
		$url = $this->baseUrl.$this->urlencoding($site)."/sitemaps/";
		$xml = "<atom:entry xmlns:atom='http://www.w3.org/2005/Atom'><atom:id>".$sitemap_url."</atom:id><atom:category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/webmasters/tools/2007#sitemap-news'/>";
		if ($publication_label!="") $xml .= "<wt:sitemap-news-publication-label xmlns:wt='http://schemas.google.com/webmasters/tools/2007'>".$publication_label."</wt:sitemap-news-publication-label>";
		$xml.="</atom:entry>";
		return $this->requestHttpPutXml($url, $xml);
	}


	public function deleteSitemap($site, $sitemap_url) {
		$url = $this->baseUrl.$this->urlencoding($site)."/sitemaps/".$this->urlencoding($sitemap_url);
		return $this->requestHttpDelete($url);
	}

}



class CrawlIssues  extends GoogleWebmasterTool {

	function __construct($auth) {
		$this->auth = $auth;
		$this->service = "crawlissues";
	}

}

class ManagingSites extends GoogleWebmasterTool {

	function __construct($auth) {
		$this->auth = $auth;
		$this->service = "sites";
	}


	public function addSite($site) {
		$url = $this->baseUrl."sites/";
		$xml ="<atom:entry xmlns:atom='http://www.w3.org/2005/Atom'><atom:content src=\"".$site."\" /></atom:entry>";
		return $this->requestHttpPutXml($url, $xml);
	}


	public function deleteSite($site) {
		return $this->requestHttpDelete($site);
	}


	public function setGeolocation($site,$tld) {
		$url = $this->baseUrl."sites/".$this->urlencoding($site)."/";
		$xml = "<atom:entry xmlns:atom=\"http://www.w3.org/2005/Atom\"xmlns:wt=\"http://schemas.google.com/webmasters/tools/2007\">
			<atom:id>".$site."</atom:id>
			<atom:category scheme='http://schemas.google.com/g/2005#kind'term='http://schemas.google.com/webmasters/tools/2007#site-info'/>
			<wt:geolocation>".$tld."</wt:geolocation>
			</atom:entry>";
		return $this->requestHttpPutXml($url, $xml);
	}


	public function setCrawlRate($site,$crawl_rate){
		$url = $this->baseUrl."sites/".$this->urlencoding($site)."/";
		echo $url."<br>";
		$xml = "<atom:entry xmlns:atom='http://www.w3.org/2005/Atom'><atom:category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/webmasters/tools/2007#site-info'/><wt:crawl-rate xmlns:wt='http://schemas.google.com/webmasters/tools/2007'>faster</wt:crawl-rate></atom:entry>";
		return $this->requestHttpPutXml($url, $xml, true);
	}


	public function setPreferredDomain($site) {
		$xml = "<atom:entry xmlns:atom=\"http://www.w3.org/2005/Atom\" xmlns:wt=\"http://schemas.google.com/webmasters/tools/2007\">
			<atom:id>http://www.example.com/news/sitemap-index.xml</atom:id>
			<atom:category scheme='http://schemas.google.com/g/2005#kind' term='http://schemas.google.com/webmasters/tools/2007#site-info'/>
			<wt:preferred-domain>preferwww</wt:preferred-domain>
			</atom:entry>";
	}

}



class GoogleWebmasterTools
{
	private $authCode;

	 /**
	 * Autoryzuje uzytkownika dla GWebmaster Tools.
	 *
	 * @param string $login login uzytkownika gmaps
	 * @param string $haslo haslo uzytkownika gmaps
	 * @param string $uprawnienia uprawnienia jakich potrzebujemy
	 * @return mixed kod bledu w rpzypadku niepowodzenia lub true jesli poprawne
	 */
	public function __construct($login, $haslo, $uprawnienia)
	{
		$this->authCode = GoogleAuth::getAuth ( $login, $haslo, $uprawnienia );
		if(is_int($this->authCode))
			return $this->authCode;
		else
			return true;
	}



	/**
	 * Pobiera i zwraca informacje o bledach indeksowania podstron
	 *
	 * @param string $addres adres witryny z webmaster tools
	 */
	public function pobierzBledyIndeksowania($addres)
	{
		$crawlIusses =  new  CrawlIssues( $this->authCode );
		return $crawlIusses->getDataResult ( $addres );
	}



	/**
	 * Pobiera i zwraca informacje o slowach kluczowych
	 *
	 * @param string $addres adres witryny z webmaster tools
	 */
	public function pobierzSlowaKluczowe($addres)
	{
		$keywords =new Keywords( $this->authCode );
		return $keywords->getDataResult( $addres );
	}

}
