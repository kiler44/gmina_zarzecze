<?php
//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';

$_SERVER['ST_URL'] = 'cron';
$cms = \Generic\Biblioteka\Cms::start();

