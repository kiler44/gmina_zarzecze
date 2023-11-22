<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca blok tekstowy z edytorem WYMEditor.
 *
 * @author Łukasz Wrcha
 * @package biblioteki
 */

class WYMEditor extends Input
{
	protected $katalogSzablonu = 'WymEditorNew';
	protected $parametry = array(
		'cfg' => array(), // konfiguracja WYMEditor
	);



	function pobierzHtml()
	{
		$cfg = '';
		if (is_array($this->parametry['cfg']) && count($this->parametry['cfg']) > 0)
		{
			foreach($this->parametry['cfg'] as $nazwa => $wartosc)
			{
				if(is_array($wartosc))
				{
					$wartosci_wew = '';
					foreach($wartosc as $nazwa_ => $wartosc_)
					{
						$wartosci_wew .= $nazwa_.': '.$wartosc_.','."\n";
					}
					$cfg .= $nazwa.': {'.substr($wartosci_wew, 0, -2).'},'."\n";
				}
				else
				{
					$cfg .= $nazwa.': '.$wartosc.','."\n";
				}
			}
		}

		if (!isset($this->parametry['atrybuty']['rows']) || $this->parametry['atrybuty']['rows'] < 1) $this->parametry['atrybuty']['rows'] = 6;
		if (!isset($this->parametry['atrybuty']['cols']) || $this->parametry['atrybuty']['cols'] < 1) $this->parametry['atrybuty']['cols'] = 30;

		$html = '<textarea name="'.$this->nazwa.'" id="'.$this->nazwa.'" '.$this->pobierzAtrybuty().'>'.$this->pobierzWartosc().'</textarea>';
		$html .= '
<script type="text/javascript">
<!--
$(document).ready(function(){
	$("#'.$this->nazwa.'").wymeditor({
		'.$cfg.'
		updateSelector: "[type^=\'submit\']",
		logoHtml: "",
		toolsItems:
		[
			{"name": "Bold", "title": "Strong", "css": "wym_tools_strong"},
			{"name": "Italic", "title": "Emphasis", "css": "wym_tools_emphasis"},
			{"name": "Superscript", "title": "Superscript", "css": "wym_tools_superscript"},
			{"name": "Subscript", "title": "Subscript", "css": "wym_tools_subscript"},
			{"name": "InsertOrderedList", "title": "Ordered_List", "css": "wym_tools_ordered_list"},
			{"name": "InsertUnorderedList", "title": "Unordered_List", "css": "wym_tools_unordered_list"},
			{"name": "ToggleHtml", "title": "HTML", "css": "wym_tools_html"},
			{"name": "Preview", "title": "Preview", "css": "wym_tools_preview"}
		],
		containersItems: [],
		postInit: function(){
			$(".wym_area_right").remove();
		}
	});
});
-->
</script>';

		return $html;
	}

}


