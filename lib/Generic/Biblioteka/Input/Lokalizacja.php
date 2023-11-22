<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca pole lokalizacja - dedykowane do formularza edycji produktu.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class Lokalizacja extends Input
{
	protected $katalogSzablonu = 'LocalizationNew';
	// TODO: ŁW@21-11-2012: Nie przerabiam tego inputa na szablony bo nie jest aktualnie nigdzie używany
	protected $tpl = '
	';

	protected $parametry = array(
		'lista' => array(),
		'listaLokalizacji' => array(),
		'inline' => false,
	);


	function pobierzHtml()
	{
		if (!is_array($this->parametry['lista']) || count($this->parametry['lista']) == 0 || !is_array($this->parametry['listaLokalizacji']) || count($this->parametry['listaLokalizacji']) == 0)
		{
			trigger_error('Nieprawidlowy parametr "lista" lub "listaLokalizacji" w parametrach '.get_class($this), E_USER_WARNING);
			return;
		}

		$listaSelect = '';
		foreach($this->parametry['listaLokalizacji'] as $idLokalizacji => $nazwa)
		{
			$selected = '';
			if ($idLokalizacji == $this->pobierzWartosc() || ($idLokalizacji == 2 && $this->pobierzWartosc() > 2))
			{
				$selected = ' selected="selected"';
			}

			$listaSelect .='<option value="' . $idLokalizacji . '"' . $selected . '>'.$nazwa.'</option>';
		}

		$html = '<div id="'.$this->nazwa.'">';

		foreach($this->parametry['lista'] as $klucz => $wartosc)
		{
			$html .= ((bool)$this->parametry['inline'] == true) ? '<span>' : '';
			$selected = '';
			if ($klucz == $this->pobierzWartosc() || ($klucz == 2 && $this->pobierzWartosc() > 2) || ($klucz == 1 && $this->pobierzWartosc() != '' && $this->pobierzWartosc() == 0 && $this->pobierzWartosc() !== '0'))
			{
				$selected = 'checked="checked"';
			}

			$wartosc = str_replace('{{POLE1}}', '<select name="'.$this->nazwa.'_wybrana" id="'.$this->nazwa.'_wybrana" '.$this->pobierzAtrybuty().'>' . $listaSelect . '</select>', $wartosc);
			$wartosc = str_replace('{{POLE2}}', '<input style="width:300px;" type="text" name="'.$this->nazwa.'_inna" value="'.($selected != '' ? $this->pobierzWartosc(): '').'" id="'.$this->nazwa.'_inna" '.$this->pobierzAtrybuty().' />', $wartosc);

			$html .= '<input type="radio" name="'.$this->nazwa.'" value="'.$klucz.'" id="'.$this->nazwa.'_'.$klucz.'" class="noinput" '.$selected.' '.$this->pobierzAtrybuty().'/><label for="'.$this->nazwa.'_'.$klucz.'">'.$wartosc.'</label>';

			//$html .= '';

			$html .= ((bool)$this->parametry['inline'] == true) ? '</span>' : '<br/>';
		}
		$html .= '</div>';
		return $html;
	}

	public function pobierzWartosc()
	{
		$this->wartosc = parent::pobierzWartosc();
		$inna = Zadanie::pobierzPost($this->nazwa.'_inna', 'stripslashes', 'trim', 'filtr_xss');
		$wybrana = Zadanie::pobierzPost($this->nazwa.'_wybrana', 'stripslashes', 'trim', 'filtr_xss', 'intval');

		if ($this->wartosc == '0')
		{
			return '0';
		}
		elseif ($this->wartosc == 1 && $inna != '')
		{
			return $inna;
		}
		elseif($wybrana > 0)
		{
			return $wybrana;
		}
		else
		{
			return $this->wartosc;
		}
	}

}
