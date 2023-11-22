<?php
namespace Generic\Modul\BlokCzytnikRss;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Cms;


/**
 * Blok odpowiedzialny za zarządzanie wyświetlaniem zewnętrznych kanałów rss.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokCzytnikRss\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokCzytnikRss\Admin
	 */
	protected $j;

	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajCzysc',
	);



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$this->tresc .= $this->szablon->parsujBlok('/index', array(
			'link_czysc' => Router::urlAdmin($this->blok, 'czysc'),
		));
	}



	public function wykonajCzysc()
	{
		$katalog = new Katalog(Cms::inst()->katalog('czytnik_rss', $this->blok->id));
		if ( ! $katalog->istnieje() || $katalog->usun())
		{
			$this->komunikat($this->j->t['czysc.info_wyczyszczono_cache'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czysc.blad_nie_mozna_wyczyscic_cache'],'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin($this->blok));
	}

}

