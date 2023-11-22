<?php
namespace Generic\Konfiguracja\Modul\Imports;

use Generic\Konfiguracja\Konfiguracja;


class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		'zapiszImport.kolumny_ustalone_nowe_instalacje_walidatory' => array(
			'typ' => 'array',
			'opis' => 'Możliwe kolumny w pliku excel - format ustalony przez nas i Get jako "standard" :-p',
			'wartosc' => array( 
				'h-nummer' => '', 
				'postnummer' => 'NiePuste,KodPocztowyZeStringu', 
				'sted' => 'NiePuste',
				'knr' => 'LiczbaCalkowita', 
				'inst.dato' => '', 
				'inst.tid' => '', 
				'montør' => 'LiczbaCalkowita',
			),
		),
		
		'zapiszImport.apartamenty_nowe_polaczenia_z_obiektami' => array(
			'typ' => 'array',
			'opis' => 'Mapping pomiedzy kolumnami excela a propercjami obiektów',
			'wartosc' => array(
				'name' => 'Klient=>name',
				'second_name' => 'Klient=>secondName',
				'surname' => 'Klient=>surname',
				'address' => 'Klient=>address,Zamowienie=>address',
				'attributes' => 'Zamowienie=>attributes',
				'inst.dato' => 'Zamowienie=>dateStart',
				'inst.tid' => 'Zamowienie=>hoursInterval',
				'montør' => 'Zamowienie=>idTeam',
				'h-nummer' => 'Zamowienie=>apartment',
				'postnummer' => 'Zamowienie=>postcode,Klient=>postcode',
				'sted' => 'Zamowienie=>city,Klient=>city',
				'telefon' => 'wyjatek', 
				'epost' => 'Klient=>email', 
				'knr' => 'Klient=>idCustomer,Zamowienie=>numberPrivatCustomer',
			),
		),
		'zapiszImport.apartamenty_nowe_transformacje_danych'=> array(
			'typ' => 'array',
			'opis' => 'Transformacje na kolumnach',
			'wartosc' => array( 
				'inst.dato' => 'dateFromExcel', 
				'montør' => 'this->zwrocIdTeamu',
				'inst.tid' => 'this->zwrocGodziny',
			),
		),
		'zapiszImport.apartamenty_istniejace_walidatory' => array(
			'typ' => 'array',
			'opis' => 'Walidatory przypisane kolejnym numerom kolumn',
			'wartosc' => array(
				'0' => 'NiePuste',
				'1' => 'NiePuste,KodPocztowyZeStringu',
			),
		),
		'importApartamenty.id_projektow' => array(
			'typ' => 'list',
			'opis' => 'ID typow orderow bedacych projektami',
			'wartosc' => array(4),
		),
		'zapiszZamowienieNoweApartamenty.id_typu_zamowienia' => array(
			'typ' => 'int',
			'opis' => 'ID typu pod-zamowienia - apartamentu na projekcie',
			'wartosc' => 32,
		),
		'zapiszZamowienieIstniejaceApartamenty.id_typu_zamowienia' => array(
			'typ' => 'int',
			'opis' => 'ID typu pod-zamowienia - apartamentu na projekcie',
			'wartosc' => 33,
		),
	);
}
