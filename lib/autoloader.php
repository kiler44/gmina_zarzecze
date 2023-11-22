<?php

// automatyczne wczytywanie klas
spl_autoload_register(function ($className)
{
	$className = ltrim($className, '\\');
	$fileName  = '';
	$namespace = '';
	if ($lastNsPos = strripos($className, '\\')) {
	
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
	
	listaPlikow($className, CMS_KATALOG . '/lib/' . $fileName);
	
	$plikKlasy = CMS_KATALOG . '/lib/' . $fileName;

	require_once $plikKlasy;
	/*
	if (file_exists($plikKlasy))
	{
		require_once $plikKlasy;
	}
	else
	{
		trigger_error('Brak pliku '.$plikKlasy.' dla klasy: '.$className, E_USER_ERROR);
	}
	 */
	//require_once CMS_KATALOG . '/lib/' . str_replace('\\', '/', $nazwaKlasy) . '.php';
});
