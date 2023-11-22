<?php
namespace Generic\Biblioteka;

/**
 * SmsApi
 *
 * Copyright (c) 2010, ComVision
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *  - Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation and/or
 *    other materials provided with the distribution.
 *  - Neither the name of the smsAPI.pl nor the names of its contributors may be used to
 *    endorse or promote products derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
 * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
 * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author ComVision <info@smsapi.pl>
 * @copyright 2010 ComVision
 * @license BSD-3
 * @package smsapi
 * @version 1.0 14.10.2010
 */

/**
 * SmsApi
 *
 * <code>
 * require_once 'smsapi.php';
 * //Instrukcja odpowiedziala za automatyczne wczytywanie class
 * spl_autoload_register(array('smsAPI','__autoload'));
 * </code>
 */
class SmsAPI
{
	/**
	 * vCard UDH
	 */
	const UDH_VCARD			= '06050423F40000';
	/**
	 * WAPPush UDH
	 */
	const UDH_WAPPUSH		= '0605040b8423f0';
	/**
	 * DATACODING BIN dla vCard i WAPPush
	 */
	const DATACODING_BIN	= 'bin';

	/**
	 * Generator wiadomości WAPPush
	 *
	 * Przyklad:
	 * <code>
	 * $msg->datacoding = smsAPI::DATACODING_BIN;
	 * $msg->udh		= smsAPI::UDH_WAPPUSH;
	 * $msg->message	= smsAPI::make_WAPPush_message(
	 *						'smsapi.pl', 'Link do http://smsapi.pl');
	 * </code>
	 *
	 * @param string $url
	 * @param string $message
	 * @return string
	 */
	public static function make_WAPPush_message($url, $message)
	{
		$url = self::ascii_to_hex( $url );
		$message = self::ascii_to_hex( $message );

		return
			'860601ae02056a0045c60c03'.
			$url.
			'00070103'.
			$message.
			'000101';
	}

	/**
	 * Konwerter vCard
	 *
	 * nie obsługiwane przez wszystkie telefony
	 *
	 * Przyklad:
	 * <code>
	 * $msg->datacoding = smsAPI::DATACODING_BIN;
	 * $msg->udh		= smsAPI::UDH_VCARD;
	 * $msg->message	= smsAPI::make_vCard_message(
	 *				'smsAPI', 'smsAPI', '500123321', 'bok@smsapi.pl', 'http://www.smsapi.pl');
	 * </code>
	 *
	 * @param string $name
	 * @param string $surname
	 * @param string $phone
	 * @param string $email
	 * @param string $www
	 * @return string
	 */
	public static function make_vCard_message($name, $surname, $phone, $email, $www)
	{
		$msg  = "BEGIN:VCARD\r\nVERSION:2.1\r\n";

		if( $name OR $surname )
		{
			$msg .= 'FN:'. $name .' '. $surname ."\r\nN:". $surname .';'. $name .";;;\r\n";
		}
		else
		{
			if ( $name ) $msg .= 'FN:'. $name ."\r\nN:". $name .";;;;\r\n";
			else if ( $surname ) $msg .= "FN:$surname\r\nN:$surname;;;;\r\n";
		}

		if ( $phone )	$msg .= 'TEL;PREF;CELL:'. $phone ."\r\n";
		if ( $email )	$msg .= 'EMAIL;INTERNET:'. $email ."\r\n";
		if ( $www )		$msg .= 'URL:'. $www ."\r\n";

		$msg .= "END:VCARD";

		return self::ascii_to_hex( $msg );
	}

	/**
	 * string -> hex
	 *
	 * @param string $ascii
	 * @return string
	 */
	public static function ascii_to_hex ($ascii)
	{
		$hexadecimal = '';
		for ($i = 0; $i < strlen($ascii); $i++)
		{
			$byte = strtoupper(dechex(ord($ascii{$i})));
			$byte = str_repeat('0', 2 - strlen($byte)) . $byte;
			$hexadecimal .= $byte;
		}

		return $hexadecimal;
	}

	/**
	 * @ignore
	 * @var array
	 */
	protected static $listners = array();

	/**
	 * Dodaj nasłuch
	 *
	 * <code>
	 * smsAPI::add_listner('var_dump');
	 * smsAPI::add_listner(array('myClass','log'));
	 * </code>
	 *
	 * @param callback $listner
	 * @return null
	 */
	public static function add_listner($listner)
	{
		if( !isset ($listner) OR empty($listner) ) return;

		self::$listners[] = $listner;
	}

	/**
	 * @ignore
	 */
	public static function call_listners()
	{
		$args = func_get_args();
		foreach (self::$listners as $listner)
		{
			call_user_func_array($listner, $args);
		}
	}

	/**
	 * Base Dir
	 *
	 * @var string
	 */
	protected static $base_dir = null;

	/**
	 * Autoloader class
	 *
	 * Przyklad:
	 * <code>
	 * require_once 'smsapi.php';
	 * //Instrukcja odpowiedziala za automatyczne wczytywanie class
	 * spl_autoload_register(array('smsAPI','__autoload'));
	 * </code>
	 *
	 * @param string $class
	 * @return null
	 */
	public static function __autoload ($class)
	{
		if( self::$base_dir == null ) self::$base_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR;

		$class = strtolower($class);
		$pos = strpos($class, 'smsapi_');

		if( $pos === false OR $pos > 0 ) return;

		$class = str_replace('_', DIRECTORY_SEPARATOR, $class);
		require_once self::$base_dir . $class . '.php';
	}
}
