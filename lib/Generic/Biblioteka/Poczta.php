<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka;
use Generic\Biblioteka\Poczta;
use Generic\Biblioteka\Plik;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Klasa odpowiedzialna za obsługę poczty korzystajaca z PHPMailer
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Poczta
{

	/**
	 * Wysyła email
	 *
	 * @param array|string $odbiorcy Odbiorcy wiadomości
	 * @param string $temat Temat wiadomości email
	 * @param string $tresc Treść tekstowa wiadomości email
	 * @param string $trescHtml Treść HTML wiadomości email
	 * @param array $ustawienia Dodatkowe ustawienia
	 *
	 * @return boolean
	 */
	public static function wyslijEmail($odbiorcy, $temat, $tresc, $trescHtml = null, Array $ustawienia = array())
	{
		$cfg = Cms::inst()->config['email'];
		if (count($ustawienia) > 0)
		{
			if (isset($ustawienia['from']))
			{
				if ($ustawienia['from'] != '') $cfg['from'] = $ustawienia['from'];
				unset($ustawienia['from']);
			}
			if (isset($ustawienia['from_name']))
			{
				if ($ustawienia['from_name'] != '') $cfg['from_name'] = $ustawienia['from_name'];
				unset($ustawienia['from_name']);
			}
			if (isset($ustawienia['reply_to']))
			{
				if ($ustawienia['reply_to'] != '') $cfg['reply_to'] = $ustawienia['reply_to'];
				unset($ustawienia['reply_to']);
			}
			if (isset($ustawienia['szablon']) && $ustawienia['szablon'] == true)
			{
				$tresc = str_replace('{TRESC}', $tresc, $cfg['szablon_txt']);
				$trescHtml = str_replace('{TRESC}', $trescHtml, $cfg['szablon_html']);
			}
			if(isset($ustawienia['potwierdzenie']))
			{
				$cfg['potwierdzenie'] = $ustawienia['potwierdzenie'];
				unset($ustawienia['potwierdzenie']);
			}
			$cfg = array_merge($cfg, $ustawienia);
		}

		ob_start();
		//$email = new Biblioteka\Poczta\PHPMailer();
		$email = new PHPMailer();
		
		$email->From = $cfg['from']; //adres email Od:
		$email->FromName = $cfg['from_name']; //etykieta email Od:
		$email->IsSMTP();
		$email->Host = $cfg['smtp_host']; //adres serwera SMTP
		$email->Port = $cfg['smtp_port']; //port serwera SMTP
		$email->SMTPDebug = (isset($cfg['smtp_debug'])) ? abs((int)$cfg['smtp_debug']) : false;
		if ($cfg['smtp_user'] != '' && $cfg['smtp_pass'] != '')
		{
			$email->SMTPAuth = true;
			$email->Username = $cfg['smtp_user']; //nazwa użytkownika
			$email->Password = $cfg['smtp_pass']; //nasze hasło do konta SMTP
		}
		if ($cfg['smtp_secur'] != '')
		{
			$email->SMTPSecure = $cfg['smtp_secur']; // protokol szyfrowania
		}

		if (isset($cfg['charset']) && $cfg['charset'] != '')
		{
			$email->CharSet = strtoupper($cfg['charset']);
			$trescHtml = iconv("UTF-8", $email->CharSet, $trescHtml);
			$tresc = iconv("UTF-8", $email->CharSet, $tresc);
			$temat = iconv("UTF-8", $email->CharSet, $temat);
		}
		else
		{
			$email->CharSet = 'UTF-8';
		}

		$email->Subject = $temat; //temat maila

		if (isset($cfg['potwierdzenie']))
		{
			$adresaci .= "\nPotwierdzenie do: ".$cfg['potwierdzenie'];
			$email->ConfirmReadingTo = $cfg['potwierdzenie'];
		}

		if (!empty($trescHtml))
		{
			if ($cfg['img_include'])
				$trescHtml = Poczta::obrazkiDoZalacznika($trescHtml, $email);
			$email->IsHTML(true);
			$email->Body = $trescHtml;
			$email->AltBody = $tresc;
		}
		else
		{
			$email->IsHTML(false);
			$email->Body = $tresc;
		}



		if (trim($cfg['email_dev']) != '' && strpos(DOMENA, 'supertraders.pl') === false)
		{
			$adresaci = "-------------- EMAIL TRYB TESTOWY --------------";

			$adresaci .= "\nOdbiorcy: ";
			if (is_string($odbiorcy)) $odbiorcy = array($odbiorcy);
			foreach ($odbiorcy as $adres => $nazwa)
			{
				$adresaci .= (is_int($adres)) ? $nazwa.", " : $nazwa." (".$adres."), ";
			}
			if (isset($cfg['cc']))
			{
				$adresaci .= "\nKopie: ";
				if (is_string($cfg['cc'])) $cfg['cc'] = array($cfg['cc']);
				foreach ($cfg['cc'] as $adres => $nazwa)
				{
					$adresaci .= (is_int($adres)) ? $nazwa.", " : $nazwa." (".$adres."), ";
				}
			}
			if (isset($cfg['bcc']))
			{
				$adresaci .= "\nKopie ukryte: ";
				if (is_string($cfg['bcc'])) $cfg['bcc'] = array($cfg['bcc']);
				foreach ($cfg['bcc'] as $adres => $nazwa)
				{
					$adresaci .= (is_int($adres)) ? $nazwa.", " : $nazwa." (".$adres."), ";
				}
			}
			if (isset($cfg['reply_to']))
			{
				$adresaci .= "\nOdpowiedz do: ";
				if (is_string($cfg['reply_to'])) $cfg['reply_to'] = array($cfg['reply_to']);
				foreach ($cfg['reply_to'] as $adres => $nazwa)
				{
					$adresaci .= (is_int($adres)) ? $nazwa.", " : $nazwa." (".$adres."), ";
				}
			}
			$adresaci .= "\n-------------- EMAIL TRYB TESTOWY --------------\n\n";
			if (!empty($trescHtml)) $adresaci = nl2br($adresaci);

			$email->Body = $adresaci.$email->Body.
			$email->AddAddress($cfg['email_dev']);
		}
		else
		{
			if (isset($cfg['bcc']))
			{
				if (is_string($cfg['bcc']))
				{
					$cfg['bcc'] = array($cfg['bcc']);
				}
				foreach ($cfg['bcc'] as $adres => $nazwa)
				{
					if (is_int($adres))
						$email->AddBcc($nazwa);
					else
						$email->AddBcc($adres, $nazwa);
				}
				$email->SMTPKeepAlive = true;
			}

			if (isset($cfg['cc']))
			{
				if (is_string($cfg['cc']))
				{
					$cfg['cc'] = array($cfg['cc']);
				}
				foreach ($cfg['cc'] as $adres => $nazwa)
				{
					if (is_int($adres))
						$email->AddCc($nazwa);
					else
						$email->AddCc($adres, $nazwa);
				}
				$email->SMTPKeepAlive = true;
			}

			if (isset($cfg['reply_to']))
			{
				if (is_string($cfg['reply_to']))
				{
					$cfg['reply_to'] = array($cfg['reply_to']);
				}
				foreach ($cfg['reply_to'] as $adres => $nazwa)
				{
					if (is_int($adres))
						$email->AddReplyTo($nazwa);
					else
						$email->AddReplyTo($adres, $nazwa);
				}
			}

			if (is_string($odbiorcy))
			{
				$odbiorcy = array($odbiorcy);
			}
			if (is_array($odbiorcy) && count($odbiorcy) > 0)
			{
				if (count($odbiorcy) > 1)
				{
					$email->SMTPKeepAlive = true;
				}
				foreach ($odbiorcy as $adres => $nazwa)
				{
					if (is_int($adres))
						$email->AddAddress($nazwa);
					else
						$email->AddAddress($adres, $nazwa);
				}
			}
		}

		$emailWyslany = $email->Send();
		$email->ClearAddresses();
		$email->ClearAttachments();

		if ($email->SMTPDebug > 0)
		{
			$debug = ob_get_contents();
			Cms::inst()->temp('smtp_debug', $debug);
		}
		ob_end_clean();

		if ($emailWyslany)
		{
			return true;
		}
		else
		{
			trigger_error($email->ErrorInfo, E_USER_WARNING);
			if ($email->SMTPDebug > 0) trigger_error($debug, E_USER_WARNING);
			return false;
		}
	}

	/**
	 * Analizuje Html w poszukiwaniu obrazkow i dodaje je jako zalaczniki
	 *
	 * @param string $Html tresc wiadomosci do wysylki, ktora moze zawierac obrazki
	 * @param Poczta_PHPMailer $MailerObj obiekt PHPMailer'a, abyśmy mogli zalaczyc pliki
	 *
	 * @return string przetworzony html
	 */

	public static function obrazkiDoZalacznika($Html, PHPMailer $MailerObj)
	{
		$dopasowania = array();
		preg_match_all('/<img.*?>/', $Html, $dopasowania);
		if (!count($dopasowania)) return $Html;

		$katalog = str_replace(Cms::inst()->config['katalogi']['public_temp'], '', Cms::inst()->katalog('public_temp'));
		$finfo = finfo_open(FILEINFO_MIME_TYPE);

		foreach ($dopasowania[0] as $klucz => $obrazek)
		{
			if (!isset($obrazek)) continue;
			$sciezka = array();
			$nazwaObrazka = array();
			preg_match('/src="(.*?)"/', $obrazek, $sciezka);
			preg_match('/alt="(.*?)"/', $obrazek, $nazwaObrazka);

			$nazwaPliku = 'obraz_';
			if (isset($nazwaObrazka[1]) && strlen($nazwaObrazka[1]) > 0)
			{
				$nazwaPliku = Plik::unifikujNazwe($nazwaObrazka[1]) .'_';
			}

			if (!isset($sciezka[1])) continue;
			$url = parse_url($sciezka[1]);
			if(!file_exists($katalog.$url['path']))
			{
				$url['path'] = str_replace('_public', 'public', $url['path']);
			}
			if ((!isset($url['host']) || !isset($url['path'])) || !file_exists($katalog.$url['path'])) continue;

			$MailerObj->AddEmbeddedImage($katalog.$url['path'], $klucz+1001, $nazwaPliku.($klucz+1), 'base64', finfo_file($finfo, $katalog.$url['path']));
			$Html = str_replace($sciezka[1], 'cid:'.($klucz+1001), $Html);
		}
		return $Html;
	}
}
