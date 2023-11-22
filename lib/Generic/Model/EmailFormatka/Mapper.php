<?php
namespace Generic\Model\EmailFormatka;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących formatki emaili.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	// nazwa klasy tworzonego obiektu
	protected $zwracanyObiekt = 'Generic\Model\EmailFormatka\Obiekt';



	// przetrzymuje nazwe tabeli w bazie do ktorej beda zapisywane dane
	protected $tabela = 'cms_email_formatki';



	// przetrzymuje tablice tlumaczaca kolumny tabeli na nazwy pol obiektu
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'data_dodania' => 'dataDodania',
		'typ_wysylania' => 'typWysylania',
		'kategoria' => 'kategoria',
		'tytul' => 'tytul',
		'opis' => 'opis',
		'email_nadawca_email' => 'emailNadawcaEmail',
		'email_nadawca_nazwa' => 'emailNadawcaNazwa',
		'email_potwierdzenie_email' => 'emailPotwierdzenieEmail',
		'email_odbiorcy' => 'emailOdbiorcy',
		'email_kopie' => 'emailKopie',
		'email_kopie_ukryte' => 'emailKopieUkryte',
		'email_odpowiedzi' => 'emailOdpowiedzi',
		'email_tytul' => 'emailTytul',
		'email_tresc_html' => 'emailTrescHtml',
		'email_tresc_txt' => 'emailTrescTxt',
		'email_zalaczniki' => 'emailZalaczniki',
		'email_szablon' => 'emailSzablon',
	);



	// pola tabeli tworzace klucz glowny
	protected $polaTabeliKlucz = array('id', 'id_projektu');


	public function pobierzPoId($id)
	{
		$kryteria = array(
			'id_rowne_' => $id,
			'id_projektu_rowne_' => ID_PROJEKTU,
		);

		return $this->pobierzJeden(array('kryteria' => $this->piszKryteria($kryteria)));
	}



	public function szukaj(Array $kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$zapytanie = $this->zapytanieWyszukiwanie((array)$kryteria);

		return $this->pobierzWiele($zapytanie, $pager, $sorter);
	}



	public function iloscSzukaj(Array $kryteria)
	{
		$zapytanie = $this->zapytanieWyszukiwanie((array)$kryteria);

		return $this->pobierzWartosc($zapytanie);
	}



	protected function zapytanieWyszukiwanie($kryteria)
	{
		$zapytanie = $this->przygotujZapytanieWyszukujace();

		$warunki = $this->piszKryteria($kryteria);

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = $this->q('%'.$kryteria['fraza'].'%');
			$warunki[] = '(tytul ILIKE '.$fraza
						.' OR opis ILIKE '.$fraza.')';
		}
		if (isset($kryteria['email']) && $kryteria['email'] != '')
		{
			$fraza = $this->q('%'.$kryteria['email'].'%');
			$warunki[] = '(email_nadawca_email ILIKE '.$fraza
						.' OR email_odpowiedzi ILIKE '.$fraza
						.' OR email_potwierdzenie_email ILIKE '.$fraza
						.' OR email_odbiorcy ILIKE '.$fraza
						.' OR email_kopie ILIKE '.$fraza
						.' OR email_kopie_ukryte ILIKE '.$fraza.')';
		}
		if (isset($kryteria['data_dodania']) && intval($kryteria['data_dodania']) > 0)
		{
			$warunki[] = 'data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}

		$zapytanie['kryteria'] = array_merge($zapytanie['kryteria'], $warunki);
		return $zapytanie;
	}

}
