<?php
namespace Other;
/*
*	SDK for sending PSK messages to Front (www.fro.no)
*	
* 	By Front Information (22 20 24 00/kontakt@fro.no)
*
*	October 2013
*/

class SMSApiPSK
{
	protected $serviceId;
	protected $password;

	protected $to;
	protected $from;
	protected $message;

	protected $errorMessage;
	protected $isSent = false;

	protected $sendMethod = 'curl';	
	protected $apiUrl = 'http://www.pling.as/incoming/psk_gateway.php';

	
	public function __construct($serviceId, $password, $sendMethod = null)
	{
		$this->serviceId = $serviceId;
		$this->password = $password;

		if($sendMethod)
		{
			// Validation / Checks is needed
			$this->sendMethod = $sendMethod;
		}

	}

	public function send($to, $from, $message)
	{
		$this->to 	= $to;
		$this->from = $from;
		$this->message = $message;

		$result = false;

		switch($this->sendMethod) {
			case "curl":
			default:
				$result = $this->sendWithCurl();
				break;
			case "fileGetContents":
				$result = $this->sendWithFileGetContents();
				break;
		}

		$this->isSent = $result;

		return $result;
	}

	public function getErrorMessages()
	{
		return $this->errorMessage;
	}


	private function sendWithCurl()
	{
		$curl = curl_init();		
		curl_setopt_array($curl, array(
		    CURLOPT_FOLLOWLOCATION => true, 
		    CURLOPT_MAXREDIRS => 5,
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_CONNECTTIMEOUT => 15,
		    CURLOPT_TIMEOUT => 15, 
		    CURLOPT_URL => $this->getApiUrl()
		));

		$response = curl_exec($curl);

		if(!$response)
		{
			$this->errorMessage = "Could not connect to API with cURL, error: " . curl_error($curl) . " - Code: " . curl_errno($curl);
			return false;
		}

		curl_close($curl);	

		return $this->parseApiJsonResponse($response);
	}

	private function sendWithFileGetContents()
	{
		$response = file_get_contents($this->getApiUrl());

		if(!$response)
		{
			$this->errorMessage = "Could not connect to API with file_get_contents()";
			return false;
		}
		
		return $this->parseApiJsonResponse($response);
	}

	private function getApiUrl()
	{
		$data = array(
					'serviceid' => $this->serviceId,
					'password' 	=> $this->password,
					'to'		=> $this->to,
					'from'		=> $this->from,
					'message'	=> $this->message
					);

		return $this->apiUrl . '?' . http_build_query($data);
	}

	public function isSent()
	{
		return $this->isSent;
	}

	private function parseApiJsonResponse($response)
	{
		$response = json_decode($response);

		$this->errorMessage = $response->message;
		return $response->success;
	}
}