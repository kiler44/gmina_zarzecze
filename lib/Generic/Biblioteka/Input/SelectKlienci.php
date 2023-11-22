<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca listę rozwijaną(select)
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */
class SelectKlienci extends Input
{
	protected $katalogSzablonu = 'SelectCustomersNew';
	protected $tpl = '
	<span class="select_wrap"><select name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}}>
	{{IF $wybierz}}<option value="">{{$wybierz}}</option>{{END}}
	{{BEGIN wiele_poziomow}}
		<optgroup label="{{$etykieta_grupy}}">
		{{BEGIN wiersz}}
			<option value="{{$wartosc}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>
		{{END}}
		</optgroup>
	{{END}}

	{{BEGIN wiersz}}
		<option value="{{$wartosc}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>
	{{END}}
	</select></span>
	';

	protected $parametry = array(
		'lista' => array(),
		'wybierz' => '',
		'dodaj_modal' => true,
		'podglad' => false,
	);



	function pobierzHtml()
	{
		$kategorieMapper = utworzObiektRaz('\Generic\Model\Kategoria\Mapper');
		$kategoriaKlientow = $kategorieMapper->pobierzPoKodModulu('Klienci');
		
		$zablokowany = false;
		
		if (isset($this->parametry['atrybuty']['disabled']))
		{
			$zablokowany = true;
		}
		
		$url_parametry = array();
		if (isset($this->parametry['url_parametry']) && $this->parametry['url_parametry'] != '')
		{
			$url_parametry = $this->parametry['url_parametry'];
		}
		$mid = sha1(microtime());
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'wybierz' => $this->parametry['wybierz'],
			'urlKlientDodajAjax' => \Generic\Biblioteka\Router::urlAjax('admin', $kategoriaKlientow, 'addCustomer', $url_parametry),
			'zablokowany' => $zablokowany,
			'dodaj_modal' => $this->parametry['dodaj_modal'],
			'podglad' => $this->parametry['podglad'],
			'etykieta_dodaj_klienta' => $this->tlumaczenia['select_klienci_etykieta_dodaj'],
			'etykieta_edytuj' => $this->tlumaczenia['select_klienci_etykieta_edytuj'],
			'etykieta_zamien' => $this->tlumaczenia['select_klienci_etykieta_zamien'],
			'etykieta_powrot_podglad' => $this->tlumaczenia['select_klienci_etykieta_powrot_podglad'],
			'mid' => $mid,
		);

		$this->szablon->ustawGlobalne($dane);
		$wybrane = $this->pobierzWartosc();
		
		$selection = '';
		if ($wybrane > 0)
		{
			$klienciMapper = new \Generic\Model\Klient\Mapper();
			$klient = $klienciMapper->zwracaTablice()->pobierzPoId($wybrane);
			$selection = json_encode($klient);
			$id = $klient['id'];
		}
		else
		{
			$id = '';
		}

		if (isset($this->parametry['selectAjax']) && is_array($this->parametry['selectAjax']))
		{
			$dane['selectAjax'] = array(
				'urlAjax' => \Generic\Biblioteka\Router::urlAjax('admin', $kategoriaKlientow, 'wyszukajKlientowAjax'),
				'typKlienta' => $this->parametry['selectAjax']['typKlienta'],
				'naStronie' => $this->parametry['selectAjax']['naStronie'],
				'selection' => $selection,
				'id' => $id,
				'mid' => $mid,
			);
		}
		else
		{
			$lista = array();
			if (is_array($this->parametry['lista']) && count($this->parametry['lista']) > 0)
			{
				$lista = $this->parametry['lista'];
			}
			else
			{
				trigger_error('Brak listy danych dla pola select '.$this->nazwa, E_USER_WARNING);
			}

			

			if (count($lista) > 0)
			{
				$i = 0;
				foreach($lista as $klucz => $wartosc)
				{
					if (is_array($wartosc))
					{
						$dane['zwykly']['wiele_poziomow'][$i] = array(
							'etykieta_grupy' => $klucz,
						);

						foreach($wartosc as $element => $etykieta)
						{
							$dane['zwykly']['wiele_poziomow'][$i]['wiersz'][] = array(
								'selected' => ($wybrane !== null && in_array($element, (array)$wybrane)) ? true : false,
								'wartosc' => htmlspecialchars($element),
								'etykieta' => $etykieta,
							);
						}
						$i++;
					}
					else
					{
						$selected = ($wybrane !== null && in_array($klucz, (array)$wybrane)) ? true : false;

						$dane['zwykly']['wiersz'][] = array(
							'selected' => $selected,
							'wartosc' => htmlspecialchars($klucz),
							'etykieta' => $wartosc,
						);
					}
				}
			}
		}
		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}
}