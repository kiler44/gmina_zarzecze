<?php
namespace Generic\Modul\BlokKomunikator;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;

/**
 * Wysyłanie maili SMSów i może kiedyś komunikator online.
 *
 * @author Łukasz Wrucha
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokKomunikator\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokKomunikator\Admin
	 */
	protected $j;
	
	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$uzytkownik = $cms->profil();
		if (! $uzytkownik->maRole(array('use_communicator')))
		{
			$this->tresc .= $this->szablon->parsujBlok('zaslepka');
			return false;
		}
		
		
		if (! isset($cms->sesja->kontakty) || empty($cms->sesja->kontakty))
		{
			$kontakty = $this->dane()->Uzytkownik()->zwracaTablice()->szukaj(array(
				'status' => 'aktywny',
				'czy_admin' => true,
				'kody_rol' => array(
					'admin', 'user', 'worker', 'boss', 'coordinator'
				),
			), null, new \Generic\Model\Uzytkownik\Sorter('nazwisko', 'ASC'));
			$cms->sesja->kontakty = $kontakty;
		}
		else
		{
			$kontakty = $cms->sesja->kontakty;
		}
		
		$prefix = ($this->k->k['index.zdjecia_pracownikow_przedrostek'] != '') ? $this->k->k['index.zdjecia_pracownikow_przedrostek'].'-' : '';
		$kategoriaSms = $this->dane()->Kategoria()->pobierzPoKodModulu('Sms');
		
		foreach ($kontakty as $kontakt)
		{
			if ($kontakt['tel_komorka_firmowa'] == '' && strpos($kontakt['email'], 'mail_nieznany') !== false) continue;
			
			$kontakt_nazwa = $kontakt['imie'].' '.$kontakt['nazwisko'];
			
			$slowa = explode(' ', $kontakt_nazwa);
			$inicjaly = '';
			foreach ($slowa as $slowo)
			{
				$inicjaly .= mb_strtoupper($slowo[0]);
			}
			
			$email = ($kontakt['email'] != '' && strpos($kontakt['email'], 'mail_nieznany') === false) ? $kontakt['email'] : '';
			
			if ($kontakt['tel_komorka_firmowa'] != '') $telefon = $kontakt['tel_komorka_firmowa'];
			else if ($kontakt['tel_komorka_prywatna'] != '') $telefon = $kontakt['tel_komorka_prywatna'];
			else $telefon = '';
			
			$zdjecie = ($kontakt['zdjecie'] != '') ? $cms->url('zdjecia_pracownikow' , $prefix.$kontakt['zdjecie']) : '';
			$this->szablon->ustawBlok('index/kontakt', array(
				'zdjecie' => $zdjecie,
				'kontakt_nazwa' => $kontakt_nazwa,
				'inicjaly' => $inicjaly,
				'telefon' => $telefon,
				'email' => $email,
				'id' => $kontakt['id'],
				'url_historia_podglad' => Router::urlAdmin($kategoriaSms, 'historiaWiadomosci', array('uid' => $kontakt['id'])),
				'etykieta_historia_podglad' => $this->j->t['index.etykieta_historia_podglad'],
			));
		}
		
		$textarea = new \Generic\Biblioteka\Input\TextArea('wiadomosc-tresc', array(
			'atrybuty' => array(
				'maxlength' => 609,
				'placeholder' => $this->j->t['index.wiadomosc_placeholder'],
				'rows' => 4,
			),
			'chowaj_licznik' => false,
		), '', '');
		
		$znajdz = array('Ą','Ć','Ę','Ł','Ń','Ó','Ś','Ż','Ź','ą','ć','ę','ł','ń','ó','ś','ż','ź');
		$zamien = array('A','C','E','L','N','O','S','Z','Z','a','c','e','l','n','o','s','z','z');
		$podpis = str_replace($znajdz, $zamien, $uzytkownik->imie.' '.$uzytkownik->nazwisko[0]).'{WO}';
		
		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'etykieta_naglowek' => $this->j->t['index.etykieta_naglowek'],
			'etykieta_brak_kontaktow' => $this->j->t['index.etykieta_brak_kontaktow'],
			'etykieta_zaznacz' => $this->j->t['index.etykieta_zaznacz_wszystkie'],
			'etykieta_odznacz' => $this->j->t['index.etykieta_odznacz_wszystkie'],
			'etykieta_lista_kontaktow' => $this->j->t['index.etykieta_lista_kontaktow'],
			'etykieta_sms' => $this->j->t['index.etykieta_rodzaj_sms'],
			'etykieta_email' => $this->j->t['index.etykieta_rodzaj_email'],
			'komunikat_brak_numeru_tytul' => $this->j->t['index.komunikat_brak_numeru_tytul'],
			'komunikat_brak_numeru_tresc' => $this->j->t['index.komunikat_brak_numeru_tresc'],
			'komunikat_brak_maila_tytul' => $this->j->t['index.komunikat_brak_maila_tytul'],
			'komunikat_brak_maila_tresc' => $this->j->t['index.komunikat_brak_maila_tresc'],
			'filtruj_placeholder' => $this->j->t['index.filtruj_placeholder'],
			'wiadomosc_placeholder' => $this->j->t['index.wiadomosc_placeholder'],
			'textarea' => $textarea->pobierzHtml(),
			'url_ajax_wyslij' => Router::urlAjax('admin', $kategoriaSms, 'wyslijWiadomosci'),
			'sms_podpis' => $podpis,
			'get_wo' => $this->j->t['index.get_wo'],
			'bkt_wo' => $this->j->t['index.bkt_wo'],
			'powiazane_zamowienie' => $this->j->t['index.powiazane_zamowienie'],
			'url_laduj_starsze' => Router::urlAjax('admin', $kategoriaSms, 'ladujStarsze'),
		));
	}
}

