<?php
namespace Generic\Modul\Sms;
use Generic\Biblioteka\Modul;


/**
 * Moduł API do wysyłania SMS.
 *
 * @author Łukasz Wrucha
 * @package moduly
 */

class Api extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\Sms\Api
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\En\Modul\Sms\Api
	 */
	protected $j;

	/**
	 * Returns array with info wether SMS was sent or not
	 * @param string $to Norwegian mobile number
	 * @param string $content Message text
	 * @param bool $premium If message should be sent as BKT AS (true) or PSK number (false) - there is possibility to reply to PSK number
	 * @return array with info wether SMS was sent or not
	 */
	public function apiSendSms($to, $content, $premium)
	{
		$conf = \Generic\Biblioteka\Cms::inst()->config['sms_norwegia'];
		
		$fromId = ($premium) ? $conf['fromIdPremium'] : $conf['fromId'];
		$sms = new \Other\SMSApi($conf['serviceId'], $fromId, $conf['psk_password']);
		
		$wynik = array();
		if (! $conf['tryb_nie_wysylaj_sms'])
		{
			$to = ($conf['tryb_testowy']) ? $conf['numer_testowy_do'] : $to;
			$content = iconv('UTF-8', 'ISO-8859-1', $content);
			$sms->send($to, $content);

			if ($sms->isSent())
			{
				$wynik['status'] = 'sent';
				$wynik['code'] = 1;
			}
			else
			{
				$wynik['status'] = 'not sent';
				$wynik['code'] = 0;
				$wynik['error'] = $sms->getErrorMessages();
			}
		}
		else
		{
			$wynik['status'] = 'sent';
			$wynik['code'] = -1;
			$wynik['info'] = 'Fake sent - service is set not to send SMS';
		}
		
		return json_encode($wynik);
	}
}