<?php
namespace Generic\Model\EmailWpisKolejki;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


class Mapper extends Biblioteka\Mapper\Baza
{

	// nazwa klasy tworzonego obiektu
	protected $zwracanyObiekt = 'Generic\Model\EmailWpisKolejki\Obiekt';



	// przetrzymuje nazwe tabeli w bazie do ktorej beda zapisywane dane
	protected $tabela = 'cms_email_kolejka';



	// przetrzymuje tablice tlumaczaca kolumny tabeli na nazwy pol obiektu
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_jezyka' => 'kodJezyka',
		'data_dodania' => 'dataDodania',
		'id_formatki' => 'idFormatki',
		'typ_wysylania' => 'typWysylania',
		'bledy_licznik' => 'bledyLicznik',
		'bledy_opis' => 'bledyOpis',
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
		'email_zalaczniki_katalog' => 'emailZalacznikiKatalog',
		'nie_wysylaj' => 'nieWysylaj',
		'id_nadawcy' => 'idNadawcy',
		'id_odbiorcy' => 'idOdbiorcy',
		'object' => 'object',
		'id_object' => 'idObject',
	);



	// pola tabeli tworzace klucz glowny
	protected $polaTabeliKlucz = array('id','id_projektu','kod_jezyka');


	public function pobierzPoId($id)
	{
		$kryteria = Array(
			'id_rowne_' => $id,
			'id_projektu_rowne_' => ID_PROJEKTU,
			'kod_jezyka_rowne_' => KOD_JEZYKA,
		);

		return $this->pobierzJeden(array('kryteria' => $this->piszKryteria($kryteria)));
	}



	public function szukaj(Array $kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);

		return $this->pobierzWiele($zapytanie, $pager, $sorter);
	}



	public function iloscSzukaj(Array $kryteria)
	{
		$zapytanie = $this->zapytanieWyszukiwanie($kryteria);

		return $this->pobierzWartosc($zapytanie);
	}



	protected function zapytanieWyszukiwanie($kryteria)
	{
		$zapytanie = $this->przygotujZapytanieWyszukujace();

		$kryteria['id_projektu_rowne_'] = ID_PROJEKTU;
		$kryteria['kod_jezyka_rowne_'] = KOD_JEZYKA;
		$warunki = $this->piszKryteria($kryteria);

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = $this->q('%'.$kryteria['fraza'].'%');
			$warunki[] = '(email_tytul LIKE '.$fraza
						.' OR email_tresc_html LIKE '.$fraza
						.' OR email_tresc_txt LIKE '.$fraza.')';
		}
		if (isset($kryteria['email']) && $kryteria['email'] != '')
		{
			$fraza = $this->q('%'.$kryteria['email'].'%');
			$warunki[] = '(email_nadawca_email LIKE '.$fraza
						.' OR email_odpowiedzi LIKE '.$fraza
						.' OR email_potwierdzenie_email LIKE '.$fraza
						.' OR email_odbiorcy LIKE '.$fraza
						.' OR email_kopie LIKE '.$fraza
						.' OR email_kopie_ukryte LIKE '.$fraza.')';
		}
		if (isset($kryteria['data_dodania']) && intval($kryteria['data_dodania']) > 0)
		{
			$warunki[] = 'data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}
		
		if (isset($kryteria['nie_wysylaj']))
		{
			if ($kryteria['nie_wysylaj'])
				$warunki[] = 'nie_wysylaj = TRUE';
			else
				$warunki[] = 'nie_wysylaj = FALSE';
		}
		if (isset($kryteria['object']) && $kryteria['object'] != '')
		{
			$warunki[] = 'object = \''.$kryteria['object'].'\'';
		}
		
		if (isset($kryteria['idObject']) && $kryteria['idObject'] > 0)
		{
			if (is_array($kryteria['idObject']) && count($kryteria['idObject']) > 0)
			{
				$warunki[] = 'idObject IN ('.implode(',', $kryteria['idObject']).')';
			}
			else
			{
				$warunki[] = 'id_object = '.$kryteria['idObject'];
			}
		}
		if (isset($kryteria['idNadawcy']) && $kryteria['idNadawcy'] > 0)
		 {
			 if (is_array($kryteria['idNadawcy']))
			 {
				$warunki[] = 'id_nadawcy IN('.implode(',', $kryteria['idNadawcy']).')';
			 }
			 else
			 {
				$warunki[] = 'id_nadawcy = '.intval($kryteria['idNadawcy']);
			 }
		 }
		 if (isset($kryteria['idOdbiorcy']) && $kryteria['idOdbiorcy'] > 0)
		 {
			 if (is_array($kryteria['idOdbiorcy']))
			 {
				$warunki[] = 'id_odbiorcy IN('.implode(',', $kryteria['idOdbiorcy']).')';
			 }
			 else
			 {
				$warunki[] = 'id_odbiorcy = '.intval($kryteria['idOdbiorcy']);
			 }
		 }
		 if(isset($kryteria['data_dodania_od']) && $kryteria['data_dodania_od'] != '')
		 {
			 $fraza = addslashes($kryteria['data_dodania_od']);
			 $warunki[] = 'data_dodania >= \''.$fraza.'\' ';
		 }
		 if(isset($kryteria['data_dodania_do']) && $kryteria['data_dodania_do'] != '')
		 {
			 $fraza = addslashes($kryteria['data_dodania_do']);
			 $warunki[] = 'data_dodania <= \''.$fraza.'\' ';
		 }

		$zapytanie['kryteria'] = array_merge($zapytanie['kryteria'], $warunki);

		return $zapytanie;
	}

}
