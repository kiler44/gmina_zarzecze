<?php
namespace Generic\Konfiguracja\Modul\PrepareFaktura;

use Generic\Konfiguracja\Konfiguracja;

/**
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		'index.zakladki' => array(
			'typ' => 'array',
			'opis' => 'Kolejność wyświetlania bloków zamówień',
			'wartosc' => array(
				1 => array(
					'nazwa' => 'Villa installations',
					'bloki' => array(
						'blokRaportow' => array(
							'method' => 'zwrocWierszeRaportow', 
							'attr' => 'villa instalacje raport faktura',
							'prefix_bloku' => 'villa',
						),
					),
					'typy' => array('1'),
				),
				2 => array(
					'nazwa' => 'B2B',
					'bloki' => array(
						'blokRaportow' => array(
							'method' => 'zwrocWierszeRaportow', 
							'attr' => 'b2b instalacje raport faktura',
							'prefix_bloku' => 'b2b',
						),
					),
					'typy' => array('2'),
				),
				3 => array(
					'nazwa' => 'Digging',
					'bloki' => array(
						'blokRaportow' => array(
							'method' => 'zwrocWierszeRaportow', 
							'attr' => 'digging report',
							'prefix_bloku' => 'digging',
						),
					),
					'typy' => array('24'),
				),
				4 => array(
					'nazwa' => 'Private orders',
					'bloki' => array(
						'blokZamowienPrywatnych' => array('method' => 'zwrocWierszeZamowienPrywatnych'),
					),
					'typy' => array('26', '27', '28', '29'),
				),
				5 => array(
					'nazwa' => 'Projects',
					'bloki' => array(
						'blokProjektow' => array('method' => 'zwrocWierszeProjektow'),
					),
					'typy' => array('4, 34'),
				),
				6 => array(
					'nazwa' => 'Gravebefaring',
					'bloki' => array(
						'blokRaportow' => array(
							'method' => 'zwrocWierszeRaportow', 
							'attr' => 'gravebefaring raport faktura',
							'prefix_bloku' => 'gravebefaring',
						),
					),
					'typy' => array('36'),
				),
				7 => array(
					'nazwa' => 'B2B befaring',
					'bloki' => array(
						'blokRaportow' => array(
							'method' => 'zwrocWierszeRaportow', 
							'attr' => 'b2b befaring raport faktura',
							'prefix_bloku' => 'b2b_befaring',
						),
					),
					'typy' => array('36'),
				),
				8 => array(
					'nazwa' => 'Homenet Villa installations',
					'bloki' => array(
						'blokRaportow' => array(
							'method' => 'zwrocWierszeRaportow', 
							'attr' => 'homenet villa report',
							'prefix_bloku' => 'homenet',
						),
					),
					'typy' => array('37'),
				),
			),
		),
		'index.id_domyslnej_zakladki' => array(
			'typ' => 'int',
			'opis' => 'ID domyślnej zakładki',
			'wartosc' => 1,
		),
		'blokRaportow.format_daty' => array(
			'typ' => 'varchar',
			'opis' => 'Format daty w bloku raportów',
			'wartosc' => 'Y-m-d',
		),
		'blokRaportow.format_daty_dodania' => array(
			'typ' => 'varchar',
			'opis' => 'Format daty w bloku raportów',
			'wartosc' => 'H:i d-m-Y',
		),
		'grid_zdjecia_przedrostek' => array(
			'opis' => '',
			'typ' => 'varchar',
			'wartosc' => 'xs',
		),
		'blokZamowienPrywatnych.id_typow_zamowien' => array(
			'opis' => 'ID typów zamówień wyświetlanych w tym bloku',
			'typ' => 'list',
			'wartosc' => array(
				26, 27, 28, 29
			),
		),
		'blokProjektow.id_typow_zamowien' => array(
			'opis' => 'ID typów zamówień wyświetlanych w tym bloku',
			'typ' => 'list',
			'wartosc' => array(
				4, 5, 6, 7, 8, 3, 25, 34, 
			),
		),
		'blokProjektow.format_daty' => array(
			'typ' => 'varchar',
			'opis' => 'Format daty w bloku projektow',
			'wartosc' => "W / Y",
		),
		'blokProjektow.format_daty_faktury' => array(
			'typ' => 'varchar',
			'opis' => 'Format daty w bloku projektow',
			'wartosc' => "H:i d-m-Y",
		),
		'editPayout.format_daty_faktury' => array(
			'typ' => 'varchar',
			'opis' => 'Format daty w historii faktur',
			'wartosc' => "d-m-Y",
		),
		'undo.wyslijEmailInformacyjny' => array(
			'typ' => 'bool',
			'opis' => 'Czy wysyłać email informacyjny po wycofaniu faktury przez Pettera',
			'wartosc' => 1,
		),
		'wyslijEmailUndo.id_formatki_email' => array(
			'typ' => 'int',
			'opis' => 'ID formatki emaila informacyjnego.',
			'wartosc' => 20,
		),
		'deleteFromList.zamykaj_projekt_przy_usuwaniu' => array(
			'typ' => 'bool',
			'opis' => 'Czy zamykać projekt przy usuwaniu z listy',
			'wartosc' => 1,
		),
		'przywrocProjekt.otworz_projekt_przy_przywracaniu' => array(
			'typ' => 'bool',
			'opis' => 'Czy otwierać projekt przy przywracaniu do fakturowania',
			'wartosc' => 1,
		),
		'editPayout.ostatnioPrzegladanyProjekt' => array(
			'typ' => 'int',
			'opis' => 'id ostatnio przeglądanego projektu',
			'wartosc' => 0,
		)
	);
}
