<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca strukturę drzewa.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class SelectDrzewo extends Input
{
	protected $katalogSzablonu = 'SelectTreeNew';
	protected $tpl = '
	<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}}/>
	<script type="text/javascript">
	<!--
		var drzewo = { {{$drzewo}} };
		$("input[name=\'{{$nazwa}}\']").optionTree(drzewo, {{$parametry_cfg}});
	-->
	</script>
	';

	protected $parametry = array(
		'wybierz' => '',
		'cfg' => array(),
		'lista' => array(), //lista w postaci array( 0 => array('id' => 1, 'poziom' => 1, 'nazwa' => 'przykladowanazwa') )
	);



	function pobierzHtml()
	{
		if (is_array($this->parametry['cfg']) && count($this->parametry['cfg']) > 0)
		{
			$parametry['cfg'] = $this->parametry['cfg'];
		}
		else
		{
			trigger_error('Nieprawidlowy parametr "cfg" w konfiguracji '.get_class($this), E_USER_WARNING);
		}

		if ($this->parametry['wybierz'] !='')
		{
			$parametry['cfg']['choose'] = $this->parametry['wybierz'];
		}

		$lista = array();
		if (is_array($this->parametry['lista'])
			&& count($this->parametry['lista']) > 0
			&& isset($this->parametry['lista'][0]['id'])
			&& isset($this->parametry['lista'][0]['poziom'])
			&& isset($this->parametry['lista'][0]['nazwa']))
		{
			$lista = $this->parametry['lista'];
		}
		else
		{
			trigger_error('Brak lub nieprawidlowa lista danych dla pola select', E_USER_WARNING);
		}

		$drzewo = '';
		$poprzedni = $pierwszy = $this->parametry['lista'][0];

		$szukana = $this->pobierzWartosc();
		$sciezka = array();
		$wyszukiwanie = ($szukana != '') ? true : false;

		foreach ($this->parametry['lista'] as $bierzacy)
		{
			$poprzedni['nazwa'] = str_replace('"', '', $poprzedni['nazwa']);
			if ($poprzedni['poziom'] < $bierzacy['poziom'])
			{
				$drzewo .= '"'.$poprzedni['nazwa'].'":{';
				if ($wyszukiwanie)
				{
					$sciezka[] = $poprzedni['nazwa'];
				}
			}
			elseif ($poprzedni['poziom'] == $bierzacy['poziom'])
			{
				$drzewo .= '"'.$poprzedni['nazwa'].'":'.$poprzedni['id'].',';
			}
			elseif ($poprzedni['poziom'] > $bierzacy['poziom'])
			{
				$i = (int)($poprzedni['poziom'] - $bierzacy['poziom']);
				$drzewo .= '"'.$poprzedni['nazwa'].'":'.$poprzedni['id']."\n";
				$drzewo .= str_repeat('}', $i).',';
				if ($wyszukiwanie)
				{
					while ($i > 0)
					{
						array_pop($sciezka);
						--$i;
					}
				}
			}
			if ($wyszukiwanie && $bierzacy['id'] == $szukana)
			{
				$sciezka[] = $bierzacy['nazwa'];
				$wyszukiwanie = false;
			}
			$poprzedni = $bierzacy;
		}
		$drzewo .= '"'.$bierzacy['nazwa'].'":'.$bierzacy['id']."\n";
		$drzewo .= str_repeat('}', (int)($bierzacy['poziom'] - $pierwszy['poziom']));

		if ($szukana != '')
		{
			$sciezka[] = $szukana;
			$parametry['cfg']['preselect'] = '{\''.$this->nazwa.'\': [\''.implode("','", $sciezka).'\']}';
		}
		
		$parametry_cfg = str_replace(array('"{', '}"'), array('{', '}') , stripslashes(json_encode($parametry['cfg'])));

		$this->szablon->ustaw(array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'wartosc' => $this->pobierzWartosc(),
			'drzewo' => $drzewo,
			'parametry_cfg' => $parametry_cfg,
		));
		return $this->szablon->parsuj();
	}

}


