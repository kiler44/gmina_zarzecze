<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca pole opcji(radio).
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class Radio extends Input
{

	protected $katalogSzablonu = 'RadioNew';
	protected $parametry = array(
		'lista' => array(),
		'inline' => false,
		'label_class' => '',
	);


	protected $tpl = '
<div id="{{$nazwa}}">
{{BEGIN inline}}
	{{BEGIN radio}}
		<input type="radio" name="{{$nazwa}}" value="{{$klucz}}" id="{{$nazwa}}_{{$klucz}}" class="noinput" {{ if($selected,\'checked="checked"\') }} {{$atrybuty}} /><label for="{{$nazwa}}_{{$klucz}}">{{$wartosc}}</label><br />
	{{END}}
{{END}}

{{BEGIN block}}
	{{BEGIN radio}}
		<span><input type="radio" name="{{$nazwa}}" value="{{$klucz}}" id="{{$nazwa}}_{{$klucz}}" class="noinput" {{ if($selected,\'checked="checked"\') }} {{$atrybuty}} /><label for="{{$nazwa}}_{{$klucz}}">{{$wartosc}}</label></span>
	{{END}}
{{END}}
</div>

';



	function pobierzHtml()
	{
		if (!is_array($this->parametry['lista']) || count($this->parametry['lista']) == 0)
		{
			trigger_error('Nieprawidlowy parametr "lista" w parametrach '.get_class($this), E_USER_WARNING);
			return;
		}

		$blok = ((bool)$this->parametry['inline'] == true) ? 'inline' : 'block';
		foreach($this->parametry['lista'] as $klucz => $wartosc)
		{
			$dane[$blok]['radio'][] = array(
				'klucz' => $klucz,
				'wartosc' => $wartosc,
				'label_class' => $this->parametry['label_class'],
				'selected' => ($klucz == $this->pobierzWartosc()) ? 1 : 0,
			);
		}

		$this->szablon->ustawGlobalne(array(
			'nazwa' => $this->nazwa,
			'atrybuty' => $this->pobierzAtrybuty(),
		));

		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}

}
