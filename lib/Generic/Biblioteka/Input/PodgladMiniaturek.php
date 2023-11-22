<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;


/**
 * Klasa obsługująca podgląd miniaturek i edycję zdjęć do galerii.
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class PodgladMiniaturek extends Input
{

	protected $katalogSzablonu = 'ThumbnailsPreviewNew';
	protected $parametry = array(
		'sciezka' => '',
		'link_usun' => '',
		'prefix_zdjec' => '',
	);


	/**
	 * Pobiera obecna wartosc inputa.
	 *
	 * @return array
	 */
	function pobierzWartosc()
	{
		if ($this->wymusPoczatkowa)
		{
			return $this->pobierzWartoscPoczatkowa();
		}
		if ($this->filtrowany)
		{
			return $this->wartosc;
		}

		$zdjecia_id = Zadanie::pobierz('zdjecia_id', 'intval', 'abs');
		$zdjecia_nazwa = Zadanie::pobierz('zdjecia_nazwa');
		$zdjecia_tytul = Zadanie::pobierz('zdjecia_tytul');
		$zdjecia_opis = Zadanie::pobierz('zdjecia_opis');
		$zdjecia_autor = Zadanie::pobierz('zdjecia_autor');
		$zdjecie_glowne = Zadanie::pobierz('zdjecie_glowne');

		$temp = null;
		if (is_array($zdjecia_id))
		{
			$temp = array();
			foreach ($zdjecia_id as $id)
			{
				$temp[$zdjecia_nazwa[$id]] = array(
					'id' => $id,
					'tytul' => $zdjecia_tytul[$id],
					'opis' => $zdjecia_opis[$id],
					'autor' => $zdjecia_autor[$id],
				);
			}
			$temp['zdjecie_glowne'] = $zdjecie_glowne;
		}

		if ($temp !== null)
		{
			$this->wartosc = $this->filtrujWartosc($temp);
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		return $this->wartosc;
	}



	/**
	 * Filtruje wartosc podana w argumencie
	 *
	 * @param array $tablica Wartosc do filtrowania.
	 *
	 * @return array
	 */
	protected function filtrujWartosc($tablica)
	{
		$glowne = $tablica['zdjecie_glowne'];
		unset($tablica['zdjecie_glowne']);

		foreach($this->filtry as $filtr)
		{
			foreach ($tablica as $zdjecie => $opis)
			{
				foreach ($opis as $klucz => $wartosc)
				{
					$tablica[$zdjecie][$klucz] = $filtr($wartosc);
				}
			}
		}
		$tablica['zdjecie_glowne'] = $glowne;
		$this->filtrowany = true;
		return $tablica;
	}



	/**
	 * Sprawdza czy input zostal zmodyfikowany.
	 *
	 * @return boolean
	 */
	function zmieniony()
	{
		$tab1 = $this->pobierzWartosc();
		$tab2 = $this->pobierzWartoscPoczatkowa();
		return (count(array_intersect($tab1, $tab2)) == count(array_unique(array_merge($tab1, $tab2)))) ? FALSE : TRUE;
	}



	function pobierzHtml()
	{
		/*
		 * ŁW: ten Input nie wiadomo czy jest potrzebny w związku z tym nie przerabiam go by działa w oparciu o szablon
		 */
		trigger_error('Ten Input jest przestarzały, użyj w zamian MultiUploadZdjec (podgląd jest tam wbudowany). This input is deprecated use MultiUploadZdjec instead (preview is built in there).', E_USER_DEPRECATED);

		$this->ustawTlumaczenia(Cms::inst()->lang['inputy']);

		if ($this->parametry['sciezka'] == '')
		{
			trigger_error('Nieprawidlowy parametr "sciezka" w parametrach '.get_class($this), E_USER_WARNING);
			return;
		}

		$link_usun = null;
		if ($this->parametry['link_usun'] != '')
		{
			if (strpos($this->parametry['link_usun'], '{ID_ZDJECIA}') === false)
			{
				trigger_error('Brak parametru "{ID_ZDJECIA}" w linku usuwania zdjec dla '.get_class($this), E_USER_WARNING);
			}
			else
			{
				$link_usun = $this->parametry['link_usun'];
			}
		}

		$prefix = ($this->parametry['prefix_zdjec'] != '') ? $this->parametry['prefix_zdjec'].'-' : '';

		$zdjecia = $this->pobierzWartosc();

		if (isset($zdjecia['zdjecie_glowne']))
		{
			$zdjecie_glowne = $zdjecia['zdjecie_glowne'];
			unset($zdjecia['zdjecie_glowne']);
		}
		else
		{
			$zdjecie_glowne = null;
		}

		if (is_array($zdjecia) && count($zdjecia) > 0)
		{
			$html = '<div id="thumbnails" class="miniaturki">';

			foreach ($zdjecia as $nazwa => $miniaturka)
			{
				$glowne_checked = (($zdjecie_glowne == $nazwa) ? 'checked' : null);

				$html .= '
<div class="miniaturka_box '.$glowne_checked.'">
	<div class="podglad_miniaturka" style="background: url('.$this->parametry['sciezka'].'/'.$prefix.$nazwa.') no-repeat center center">
		<div style="margin-top: 104px">
			<input type="radio" name="zdjecie_glowne_" value="'.$nazwa.'" id="zdjecia_zdjecie_glowne['.$miniaturka['id'].']" '.$glowne_checked.' class="zdjecie_glowne"/><label for="zdjecia_zdjecie_glowne['.$miniaturka['id'].']"><span style="display: inline">'.$this->tlumaczenia['input_podglad_miniaturek_etykieta_zdjecie_glowne'].'</span></label>
		</div>
	</div>
	<div style="float: right">
		<div class="nazwa_pliku">
			<div>'.$nazwa.'</div>
			<div class="ikonki">';

			if (!empty($link_usun))
			{
				$html .= '<a href="'.str_replace('{ID_ZDJECIA}', $miniaturka['id'], $link_usun).'" class="usun"></a>';
			}

			$html .= '</div>
			<div class="clear"></div>
		</div>
		<label for="tytul_'.$miniaturka['id'].'"><span>'.$this->tlumaczenia['input_podglad_miniaturek_etykieta_tytul'].'</span><input type="text" id="tytul_'.$miniaturka['id'].'" name="zdjecia_tytul['.$miniaturka['id'].']" value="'.$miniaturka['tytul'].'"/></label>
		<label for="opis_'.$miniaturka['id'].'"><span>'.$this->tlumaczenia['input_podglad_miniaturek_etykieta_opis'].'</span><textarea id="opis_'.$miniaturka['id'].'" cols="10" rows="3" name="zdjecia_opis['.$miniaturka['id'].']">'.$miniaturka['opis'].'</textarea></label>
		<label for="autor_'.$miniaturka['id'].'"><span>'.$this->tlumaczenia['input_podglad_miniaturek_etykieta_autor'].'</span><input type="text" id="autor_'.$miniaturka['id'].'" name="zdjecia_autor['.$miniaturka['id'].']" value="'.$miniaturka['autor'].'"/></label>

		<input type="hidden" name="zdjecia_id['.$miniaturka['id'].']" value="'.$miniaturka['id'].'"/>
		<input type="hidden" name="zdjecia_nazwa['.$miniaturka['id'].']" value="'.$nazwa.'"/>
	</div>
</div>
';
			}
			$html .= '<input type="hidden" name="zdjecie_glowne" value="'.$zdjecie_glowne.'" id="zdjecie_glowne"/>';
		}

		$html .= '
<script type="text/javascript">
<!--
$(document).ready(function(){
	$(".zdjecie_glowne").click(function(){
		$("#zdjecie_glowne").val($(this).val());
	});
});
-->
</script>
</div>
';
		return $html;
	}

}
