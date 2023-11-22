<?php
namespace Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Cms;
use Generic\Model\Projekt;


/**
 * Usluga Server JsonRPC.
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class Api extends Usluga
{
	private $dostepneProcedury = array();

	public function start()
	{
		$cms = Cms::inst();
		$cms->ladujBazeDanych();
		//$cms->rozpocznijSesje();

		$projekty = Cms::inst()->dane()->Projekt();
		$cms->projekt = $projekty->pobierzPoKodzie(KOD_PROJEKTU);

		if ($cms->projekt instanceof Projekt\Obiekt)
		{
			define('ID_PROJEKTU', $cms->projekt->id);
			if ( ! defined('DOMENA')) define('DOMENA', $cms->projekt->domena);
		}
		else
		{
			cms_blad($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_projektu'], 503);
		}
		
		
		define('KOD_JEZYKA_ITERFEJSU', $cms->projekt->domyslnyJezyk);
		define('KOD_JEZYKA', $cms->projekt->domyslnyJezyk);

		// znamy juz ID_PROJEKTU i KOD_JEZYKA wiec mozemy uzupelnic konfiguracje
		$cms->konfiguracjaBaza();
		$cms->tlumaczeniaBaza();
		
		$modulyApi = array_filter(explode(',', $cms->projekt->modulyApi));
		asort($modulyApi);
		$nieDozwoloneMetody = array(
			'inicjuj', 
		);
		
		$server = new \JsonRPC\Server();
		
		
		$dostepneProcedury = array();
		
		foreach ($modulyApi as $modul)
		{
			$nazwaKlasy = 'Generic\\Modul\\'.$modul.'\\'.'Api';
			$klasa = new \ReflectionClass($nazwaKlasy);
			foreach ($klasa->getMethods(\ReflectionMethod::IS_PUBLIC) as $metoda)
			{
				if ($metoda->class == $nazwaKlasy && strpos($metoda->name, '__') === false && substr($metoda->name, 0, 3) == 'api' && !in_array($metoda->name, $nieDozwoloneMetody))
				{
					$nazwaProcedury = str_replace(['Generic\Modul\\', '\Api'], ['', 'API'], $metoda->class).'_'.lcfirst(str_replace('api', '', $metoda->name));
					
					$refleksjaMetody = new \ReflectionMethod($metoda->class, $metoda->name);
					$dostepneProcedury[$nazwaProcedury] = array(
						'procedureName' => $nazwaProcedury,
						'description' => $refleksjaMetody->getDocComment(),
						'numberOfArgs' => $refleksjaMetody->getNumberOfParameters(),
					);
					
					$server->bind($nazwaProcedury, new $metoda->class, $metoda->name);
				}
			}
		}
		
		$this->dostepneProcedury = $dostepneProcedury;
		
		$server->register('getApiInfo', function() use ($dostepneProcedury, $server) {
			if (empty($dostepneProcedury))
			{
				return json_encode(array('info' => 'This API doesn\'t provide any registered procedures at the moment. Please contact our admin for more information.'));
			}
			return json_encode($dostepneProcedury);
		});
		
		$haslo = $cms->config['api']['haslo_dostepu'];
		if ($haslo == '')
		{
			if ($server->getRequest() == null)
			{
				$server->setApiInfoRequest();
			}
		}
		$wynik = $server->execute($haslo);
		
		echo $wynik;
	}
}

