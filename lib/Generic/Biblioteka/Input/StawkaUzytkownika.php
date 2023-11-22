<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Router;


/**
 * Klasa obsługująca pole daty w postaci tekstowej.
 *
 * @author Marcin Mucha
 * @package biblioteki
 */

class StawkaUzytkownika extends Input
{
	protected $katalogSzablonu = 'UserRateNew';
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
		'datepicker_cfg' => array(),
		'urlDodajStawke' => '' ,
		'urlAktualizujStawke' => '',
		'urlUsunStawke' => '',
		'listaStawek' => '',
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
		if(count($this->parametry['listaStawek']))
		{
			foreach($this->parametry['listaStawek'] as $idStawki => $daneStawka)
			{
				$this->szablon->ustawBlok('stawkaLista',  
					array_merge(array('idStawki'=> $idStawki, 'nazwa' => $this->pobierzNazwe()), $daneStawka)
				);
			}
		}
		
		$dane = array(
			'idUzytkownika' => $this->parametry['idUzytkownika'],
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => $this->pobierzWartosc(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'urlDodajStawke' => $this->parametry['urlDodajStawke'] ,
			'urlAktualizujStawke' => $this->parametry['urlAktualizujStawke'],
			'urlUsunStawke' => $this->parametry['urlUsunStawke'],
			'format_daty' => (isset($this->parametry['format_daty'])) ? $this->parametry['format_daty'] : "yyyy-mm-dd",
		);

		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}

}


