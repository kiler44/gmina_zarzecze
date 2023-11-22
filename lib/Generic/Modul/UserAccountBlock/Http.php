<?php
namespace Generic\Modul\UserAccountBlock;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;

/**
 * Wyświetlanie zalogowanego użytkownika i przycisku wyloguj
 *
 * @author Łukasz Wrucha
 * @package moduly
 */

class Http extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\UserAccountBlock\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\UserAccountBlock\Admin
	 */
	protected $j;


	public function wykonajIndex()
	{
		$cms = Cms::inst();
		$uzytkownik = $cms->profil();
		
		$projektObiekt = new \Generic\Model\Projekt\Obiekt();
		
		$jezykiProjektu = [];
		foreach ($projektObiekt->jezyki as $jezyk)
		{
			$jezykiProjektu[$jezyk->kod] = $jezyk->nazwa;
		}
		
		$kategorieMapper = $this->dane()->Kategoria();
		$kategoria = $kategorieMapper->pobierzDlaModulu('Kalendarz');
		
		$this->szablon->ustawBlok('/index', array(
			'nazwa_uzytkownika' => trim($uzytkownik->pelnaNazwa.' ('.$uzytkownik->login.')'),
			'etykieta_jezyk' => $jezykiProjektu[$uzytkownik->jezyk],
			'kod_jezyk' => $uzytkownik->jezyk,
			//'czas_sesji' => ($cms->config['sesja']['czasZyciaSesji'] > 0) ? $cms->config['sesja']['czasZyciaSesji'] : -1,
			'url_wyloguj' => Router::urlAdmin('UserAccount', 'signOut'),
			'url_glowna' => Router::urlAdmin('UserAccount', 'index'),
			'etykieta_styl' => $this->j->t['index.etykieta_styl'],
		));
		
		if(isset($kategoria[0]) && $uzytkownik->maUprawnieniaDo('Admin_'.$kategoria[0]->id.'_wykonajIndex'))
		{
			$data = new \DateTime(date('Y-m-d', strtotime(date('Y-m-d').' +7 day')));
			//$sorter = new \Generic\Model\EventMetody\Sorter('data_wykonania');
			$listaEventow = $cms->dane()->EventMetody()->zwracaTablice()->szukajPolaczZKalendarzem(array('data_wykonania_do' => $data->format('Y-m-d'), 'wykonane' => false),null, null);
			
			$this->szablon->ustawBlok('/index/blokEvent', array(
					'iloscEventow' => count($listaEventow),
					'events_etykieta' => $this->j->t['index.events_etykieta']
				));
			foreach($listaEventow as $eventMetoda)
			{
				$url = Router::urlAdmin($kategoria[0], 'index', array('idEvent' => $eventMetoda['id_event']));
				$this->szablon->ustawBlok('/index/blokEvent/event/', array(
					'data' => $eventMetoda['data_wykonania'],
					'opis' => $eventMetoda['opis'],
					'tytul' => $eventMetoda['tytul'],
					'bgkolor' => unserialize($eventMetoda['opcje_dodatkowe'])['kolor'],
					'kolor' => unserialize($eventMetoda['opcje_dodatkowe'])['kolorCzcionki'],
					'url' => $url,
				));
				
			}
			
		}
		
		$this->tresc .= $this->szablon->parsujBlok('index');
	}

}

