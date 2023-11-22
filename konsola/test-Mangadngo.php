<?php

//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';

//Inicjowanie cms-a dla konsoli
require_once 'cli-cms.inc.php';

use Mandango\Cache\FilesystemCache;
use Mandango\Connection;
use Mandango\Mandango;
use Generic\ModelNosql\Mapping\MetadataFactory;
use Mandango\Mondator\Mondator;


$metadataFactory = new MetadataFactory();
$cache = new FilesystemCache('/var/www/supetraders2/cache/bazaNosql');

$logger = function(array $log)
{
	//var_dump($log);
	$tresc = "\n[".date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
	$tresc .= (PHP_SAPI != 'cli') ? ', '.Zadanie::wywolanyUrl().', '.Zadanie::adresIp() : ', '.$_SERVER['SCRIPT_NAME'].', User: '.$_SERVER['USER'];
	$tresc .= serialize($log);

	//echo $tresc;
};

$mandango = new Mandango($metadataFactory, $cache, $logger);


$connection = new Connection('mongodb://localhost:27017', 'crm');
$mandango->setConnection('my_connection', $connection);
$mandango->setDefaultConnectionName('my_connection');



$log = $mandango->create('Generic\ModelNosql\LogZdarzen');
$log['nazwa'] = 'test' . time();

//$log->save();

$repository = $mandango->getRepository('Generic\ModelNosql\LogZdarzen');

$query = $repository->createQuery();

$query
	->criteria(array('name' => array('$ne' => 'ddd')))
    ->limit(3)
;

foreach ($query as $result)
{
	//var_dump($result['nazwa']);
	//var_dump($result->getId()->{'$id'});

	//dump($result->daneDoZapisu());
}

//$query->all();

//var_dump($query->count());

var_dump($repository->iloscSzukaj(array('name' => array('nierowne' => 'ddd'))));

//$query->one()->zapisz();

//var_dump($repository->iloscWszystko());



/*
$mondator = new Mondator();

$mondator->setConfigClasses(array(
    'Generic\ModelNosql\LogZdarzen' => array(
        'fields' => array(
            'timestamp' => 'date',
            'idPracownika' => 'integer',
            'idObiektuGlownego' => 'integer',
            'typObiektuGlownego' => 'string',
            'danePomocnicze' => 'serialized',
            'nazwa' => 'string',
            'tokenProcesu' => 'string',
        ),
    ),
));

$mondator->setExtensions(array(
    new \Mandango\Extension\Core(array(
		'metadata_factory_class' => '\Mandango\MetadataFactory',
        'metadata_factory_output' => CMS_KATALOG . '/lib/Generic/ModelNosql/Mapping',
        'default_output'         => CMS_KATALOG . '/lib/Generic/ModelNosql',
    )),
	new \Mandango\Extension\DocumentPropertyOverloading(),
	new \Mandango\Extension\DocumentArrayAccess(),
));

$mondator->process();

*/