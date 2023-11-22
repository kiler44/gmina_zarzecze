<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca pole daty w postaci tekstowej.
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class Data extends Input
{
	protected $katalogSzablonu = 'DateNew';
	protected $tpl = '
	<div class="input-append">
		<input type="text" name="{{$nazwa}}" value="{{$wartosc}}" id="{{$nazwa}}" {{$atrybuty}}/>
		<span class="add-on"><i class="icon-calendar"></i></span>
	</div>
	{{BEGIN aktywacja}}
		<script type="text/javascript">

			$(document).ready(function(){
				$( "#{{$nazwa}}" ).datepicker({
					weekStart: 1,
					{{$datepicker_cfg}}
					}).on(\'changeDate\', function(ev){
						$("#{{$nazwa}}").change();
				});
			});

		</script>
	{{END}}
	';

	protected $parametry = array(
		'datepicker_cfg' => array(), //konfiguracja Date Pickera
	);


	function pobierzHtml()
	{
		$datepicker_cfg = '';

		if (is_array($this->parametry['datepicker_cfg']) && !empty($this->parametry['datepicker_cfg']))
		{
			foreach($this->parametry['datepicker_cfg'] as $nazwa => $wartosc)
			{
				$datepicker_cfg .= $nazwa.': '.$wartosc.', ';
			}
			$datepicker_cfg = substr($datepicker_cfg, 0, -2);
		}

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => $this->pobierzWartosc(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'format_daty' => (isset($this->parametry['format_daty'])) ? $this->parametry['format_daty'] : "yyyy-mm-dd",
		);

		if ((!(isset($this->parametry['atrybuty']['disabled']) && $this->parametry['atrybuty']['disabled'] == 'disabled')) 
				  && !(isset($this->parametry['atrybuty']['no-js']) && $this->parametry['atrybuty']['no-js'] == true)
		)
		{
			$dane_aktywacja = array(
				'aktywacja' => array(
					'nazwa' => $this->pobierzNazwe(),
					'miesiace' => '\''.implode('\', \'', $this->tlumaczenia['input_data_miesiace']).'\'',
					'miesiace_skrocone' => '\''.implode('\', \'', $this->tlumaczenia['input_data_miesiace_skrocone']).'\'',
					'dni' => '\''.implode('\', \'', $this->tlumaczenia['input_data_dni']).'\'',
					'dni_skrocone' => '\''.implode('\', \'', $this->tlumaczenia['input_data_dni_skrocone']).'\'',
					'dni_minimum' => '\''.implode('\', \'', $this->tlumaczenia['input_data_dni_minimum']).'\'',
					'datepicker_cfg' => $datepicker_cfg,
				),
			);

			$dane = array_merge($dane, $dane_aktywacja);
		}

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}

}


