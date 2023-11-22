<?php
namespace Other;
/*
*	SDK for sending outgoing messages to regular mobile phones by Front (www.fro.no)
*	
* 	Based on Front Information (22 20 24 00/kontakt@fro.no), Łukasz Wrucha
*
*	March 2014
*/

class SMSApi
{
	protected $errorTranslations = array(
		'0' => 'OK (Message is sent)',
		'1' => 'Illegal mobile number',
		'2' => 'Message sent from illegal IP address',
		'3' => 'Invalid fromid',
		'4' => 'Illegal value SMS',
		'5' => 'No remaining SMS messages on account',
		'6' => 'Not access to valued SMS',
		'7' => 'Your account has been blocked by Front',
		'8' => 'serviceid is blank / parameter is missing',
		'9' => 'phoneno is blank / missing parameter',
		'10' => 'txt is blank / missing parameter',
		'11' => 'fromid is blank / missing parameter',
		'12' => 'Illegal mobile number valued SMS',
		'13' => 'Invalid password ',
		'14' => 'The message is too long (max 612characters)',
	);
	
	protected $sentMsgID = null;
	
	protected $serviceId;
	protected $password;

	protected $phoneNo;
	protected $fromId;
	protected $message;

	protected $errorMessage;
	protected $isSent = false;

	protected $sendMethod = 'curl';	
	protected $apiUrl = 'http://pling.as/psk/push.php';

	/**
	 * 
	 * @param int $serviceId
	 * @param string $fromId
	 * @param string $password
	 * @param string $sendMethod
	 */
	public function __construct($serviceId, $fromId, $password = '', $sendMethod = null)
	{
		$this->fromId = $fromId;
		$this->serviceId = $serviceId;
		if ($password !== '')
		{
			$this->password = $password;
		}

		if($sendMethod)
		{
			// Validation / Checks is needed
			$this->sendMethod = $sendMethod;
		}

	}

	/**
	 * 
	 * @param string $to - Norewgian/Swidish mobile phone number starting with 0047
	 * @param string $message - Text message maximum 612 characters
	 * @return bool - Returns wheter sms was sent or not
	 */
	public function send($to, $message)
	{
		$this->phoneNo 	= $to;
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
		    CURLOPT_CONNECTTIMEOUT => 30,
		    CURLOPT_TIMEOUT => 30, 
		    CURLOPT_URL => $this->getApiUrl()
		));

		$response = curl_exec($curl);

		if(!$response)
		{
			$this->errorMessage = "Could not connect to API with cURL, error: " . curl_error($curl) . " - Code: " . curl_errno($curl);
			return false;
		}

		curl_close($curl);	

		return $this->parseResponse($response);
	}

	private function sendWithFileGetContents()
	{
		$response = file_get_contents($this->getApiUrl());

		if(!$response)
		{
			$this->errorMessage = "Could not connect to API with file_get_contents()";
			return false;
		}
		
		return $this->parseResponse($response);
	}

	private function getApiUrl()
	{
		$data = array(
			'serviceid' => $this->serviceId,
			'phoneno'		=> $this->phoneNo,
			'fromid'		=> $this->fromId,
			'txt'	=> $this->message,
		);
		
		if ($this->password != '')
		{
			$data = array_merge($data, array('password' => $this->password));
		}
		
		$apiUrl = $this->apiUrl . '?' . http_build_query($data);
		return $apiUrl;
	}

	public function isSent()
	{
		return $this->isSent;
	}
	
	public function getMessageId()
	{
		return $this->sentMsgID;
	}

	private function parseResponse($response)
	{
		$_r = explode(', ', $response);
		
		if (isset($_r[0]) && $_r[0] != '')
		{
			$response = explode('=', $_r[0]);
			$this->errorMessage = $this->errorTranslations[$response[1]];
			if ($response[1] == 0)
			{
				$this->sentMsgID = \intval(\str_replace('ID=', '', $_r[1]));	
				return true;
			}
			return false;
		}
		$this->errorMessage = 'Invalid SMS API response - check API URL';
		return false;
	}
}