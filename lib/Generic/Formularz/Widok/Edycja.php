<?php
namespace Generic\Formularz\Widok;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Szablon;
use Generic\Model\UkladStrony;
use Generic\Model\Blok;
use Generic\Model\Widok;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var \Generic\Biblioteka\Szablon
	 */
	protected $szablon;


	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'kategoriaEdycja');

		$this->formularz->input(new Input\Text('nazwa'));
		$this->formularz->nazwa->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$lista = array();
		$sorter = new UkladStrony\Sorter('nazwa', 'asc');
		$sorterBloki = new Blok\Sorter('nazwa', 'asc');
		$ukladyMapper = UkladStrony\Mapper::wywolaj();
		if ($this->obiekt->id > 0)
		{
			$this->formularz->input(new Input\Html('ukladStrony'));

			$kategorie =Cms::inst()->dane()->Kategoria();
			$kategorie = $kategorie->pobierzDlaWidoku($this->obiekt->id);
			if (count($kategorie) > 0)
			{
				$lista = array();
				foreach ($kategorie as $kategoria)
				{
					$url = rtrim(Router::urlHttp($kategoria),'/')."/?podgladEdytowanegoUkladu=true";
					$lista[$url] = $kategoria->nazwa;
				}
				$this->formularz->input(new Input\Select('podglad', array(
					'lista' => $lista,
					'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
					'atrybuty' => array('onchange' => 'podgladWidoku(this.options[selectedIndex].value); this.selectedIndex = 0;')
				)));
			}

			//pobieramy wszystkie dostepne bloki
			$blokiMapper = Cms::inst()->dane()->Blok();
			$dostepneBloki = array();

			// umieszczamy kategorie w strukturze blokow
			$blok = new Blok\Obiekt;
			$blok->nazwa = $this->tlumaczenia['etykieta_kategoria'];
			$dostepneBloki[0] = $blok;

			foreach ($blokiMapper->pobierzWszystko(null, $sorterBloki) as $blok)
			{
				$dostepneBloki[$blok->id] = $blok;
			}

			//tworzymy uklad strony na podstawie danych o blokach i szablonie strony
			$uklad = $ukladyMapper->pobierzPoKodzie($this->obiekt->ukladStrony);

			$u = new UkladStrony\Obiekt();
			$u->ustawTrescSzablonu($uklad->struktura);
			$u->regiony = $uklad->regiony;
			// wypelniamy uklad danymi blokow
			$ukladBlokow = $this->obiekt->ukladBlokow;
			if (count($ukladBlokow) > 0)
			{
				foreach ($ukladBlokow as $kodRegionu => $idBlokow)
				{
					$trescRegionu = '';
					foreach ($idBlokow as $id)
					{
						if (isset($dostepneBloki[$id]))
						{
							$blok = $dostepneBloki[$id];
							if ($blok->id > 0)
							{
								$this->szablon->ustawBlok('/struktura_blok/przyciski', array(
									'link_tresc' => Router::urlAdmin($blok),
									'etykieta_link_tresc' => $this->tlumaczenia['etykieta_link_tresc'],
									'link_edytuj' => Router::urlAdmin('WidokiZarzadzanie', 'edytujBlok', array('id' => $blok->id)),
									'etykieta_link_edytuj' => $this->tlumaczenia['etykieta_link_edytuj'],
									'link_usun' => Router::urlAdmin('WidokiZarzadzanie', 'usunBlok', array('id' => $blok->id)),
									'etykieta_link_usun' => $this->tlumaczenia['etykieta_link_usun'],
								));
							}

							$u->dodajTrescRegionu(
								$kodRegionu,
								$this->szablon->parsujBlok('/struktura_blok', array(
									'id_bloku' => ($blok->id > 0) ? $blok->id : 0,
									'nazwa_bloku' => $blok->nazwa,
									'kod_modulu' => ($blok->modul instanceof DostepnyModul\Obiekt) ? $blok->modul->kod : 'kategoria',
									'nazwa_modulu' => ($blok->modul instanceof DostepnyModul\Obiekt) ? $blok->modul->nazwa : '',
								))
							);
							unset($dostepneBloki[$id]);
						}
					}
				}
			}
			// bloki ktore nie zostaly umieszczone w widoku a sa dostepne wyswietlamy w oddzielnej liscie
			$nieprzypisaneBloki = '';
			foreach ($dostepneBloki as $blok)
			{
				if ($blok->id > 0)
				{
					$this->szablon->ustawBlok('/struktura_blok/przyciski', array(
						'link_tresc' => Router::urlAdmin($blok),
						'etykieta_link_tresc' => $this->tlumaczenia['etykieta_link_tresc'],
						'link_edytuj' => Router::urlAdmin('WidokiZarzadzanie', 'edytujBlok', array('id' => $blok->id)),
						'etykieta_link_edytuj' => $this->tlumaczenia['etykieta_link_edytuj'],
						'link_usun' => Router::urlAdmin('WidokiZarzadzanie', 'usunBlok', array('id' => $blok->id)),
						'etykieta_link_usun' => $this->tlumaczenia['etykieta_link_usun'],
					));
				}

				$nieprzypisaneBloki .= $this->szablon->parsujBlok('/struktura_blok', array(
					'id_bloku' => ($blok->id > 0) ? $blok->id : 0,
					'nazwa_bloku' => $blok->nazwa,
					'kod_modulu' => ($blok->modul instanceof DostepnyModul\Obiekt) ? $blok->modul->kod : 'kategoria',
					'nazwa_modulu' => ($blok->modul instanceof DostepnyModul\Obiekt) ? $blok->modul->nazwa : '',
				));
			}

			$nie = '';
			$mozliwe_bloki_js = '';
			foreach($uklad->regiony as $region => $mozliwe_bloki)
			{
				if (in_array('!wszystko', (array)$mozliwe_bloki))
				{
					$bloki = '\'!wszystko\',';
					foreach($mozliwe_bloki as $mozliwy_blok)
					{
						$bloki .= (strpos($mozliwy_blok, '!') === false) ? '\''.$mozliwy_blok.'\',' : '';
					}
				}
				else
				{
					$bloki = '\'wszystko\',';
					foreach((array)$mozliwe_bloki as $mozliwy_blok)
					{
						$bloki .= (strpos($mozliwy_blok, '!') !== false) ? '\''.substr($mozliwy_blok, 1).'\',' : '';
					}
					$nie = '!';
				}
				$mozliwe_bloki_js .= 'regiony[\''.$region.'\'] = new Array('.substr($bloki, 0, -1).");\n";
			}

			$this->formularz->poleHtml('ukladBlokow', $this->szablon->parsujBlok('/struktura_kontener', array(
				'przypisane_bloki' => $u->pobierzHtml(),
				'nieprzypisane_bloki' => $nieprzypisaneBloki,
				'link_dodaj' => Router::urlAdmin('WidokiZarzadzanie', 'dodajBlok'),
				'link_aktualizuj' => Router::urlAjax('admin', 'WidokiZarzadzanie', 'aktualizuj', array('widok' => $this->obiekt->id, 'struktura' => '{STRUKTURA}')),
				'mozliwe_bloki' => $mozliwe_bloki_js,
				'nie' => $nie,
			)));

			$this->formularz->input(new Input\Hidden('struktura', ''));
			$this->formularz->struktura->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		}
		else
		{
			foreach ($ukladyMapper->pobierzWszystko(null, $sorter) as $uklad)
			{
				$lista[$uklad->kod] = $uklad->nazwa;
			}
			$this->formularz->input(new Input\Select('ukladStrony', array(
				'lista' => $lista,
				'wybierz' => $this->tlumaczenia['etykieta_select_wybierz']
			)));
			$this->formularz->ukladStrony->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$widoki = Cms::inst()->dane()->Widok();
			$widoki = $widoki->zwracaTablice()->pobierzWszystko(null, new Widok\Sorter('nazwa', 'asc'));
			$lista = listaZTablicy($widoki, 'id', 'nazwa');

			if (count($lista) > 0)
			{
				$this->formularz->input(new Input\Select('kopiowanyWidok', array(
					'lista' => $lista,
					'wybierz' => $this->tlumaczenia['etykieta_select_wybierz']
				)));
				$this->formularz->kopiowanyWidok->dodajFiltr('intval');
			}
		}

		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('czysc'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin('WidokiZarzadzanie','index').'\'')
		)));

		foreach ($this->formularz as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->konfiguracja['formularz.wymagane_pola']))
			{
				$this->formularz->$nazwaInputa->wymagany = true;
				$this->formularz->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}

			$wartosc = $input->pobierzWartoscPoczatkowa();
			if (!empty($wartosc) || $nazwaInputa == 'podglad' || $nazwaInputa == 'kopiowanyWidok') continue;
			$this->formularz->$nazwaInputa->ustawWartosc($this->obiekt->$nazwaInputa);
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Widok\Edycja
	 */
	public function ustawSzablon(Szablon $szablon)
	{
		$this->szablon = $szablon;

		return $this;
	}
}