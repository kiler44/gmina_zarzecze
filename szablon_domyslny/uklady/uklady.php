<?php

return array(
	array(
		'kod' => 'strona_glowna',
		'nazwa' => 'Strona główna',
		'plik' => 'strona_glowna.tpl',
		'regiony' => array(

			'region_0' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokRegulaminWprowadzaniaTresci', 'BlokRegulaminWprowadzaniaMaterialow', 'BlokFiltrowWyszukiwania'),
			'region_1' => array('!wszystko', 'kategoria', 'BlokOpisowy'),
			'region_2' => array('!wszystko', 'kategoria', 'BlokOpisowy'),
			'region_3' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokMenu'),
		),
		'struktura' => '
<table border="0" frame="void" cellpadding="0" cellspacing="3" width="100%">
	<tr width="100%">
		<td class="region locked" width="30%"><ul class="locked" style="min-height:100px;">Nagłówek stały - logo, tytuł i szlagier strony</ul></td>
		<td class="region" width="70%" id="r_1"><ul id="region_1" style="min-height:100px;">{{$region_1}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_2"><ul id="region_2" style="min-height:100px;">{{$region_2}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_0"><ul id="region_0" style="min-height:380px;">{{$region_0}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_3"><ul id="region_3" style="min-height:140px;">{{$region_3}}</ul><div class="clear"></div></td>
	</tr>
</table>
'),

array(
	'kod' => 'uklad_podstawowy',
	'nazwa' => 'Zwykła Strona',
	'plik' => 'uklad_podstawowy.tpl',
	'regiony' => array(

		'region_0' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokRegulaminWprowadzaniaTresci', 'BlokRegulaminWprowadzaniaMaterialow', 'BlokFiltrowWyszukiwania'),
		'region_1' => array('!wszystko', 'kategoria', 'BlokOpisowy'),
		'region_2' => array('!wszystko', 'kategoria', 'BlokOpisowy'),
		'region_3' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokMenu'),
	),
	'struktura' => '
<table border="0" frame="void" cellpadding="0" cellspacing="3" width="100%">
	<tr width="100%">
		<td class="region locked" width="30%"><ul class="locked" style="min-height:100px;">Nagłówek stały - logo, tytuł i szlagier strony</ul></td>
		<td class="region" width="70%" id="r_1"><ul id="region_1" style="min-height:100px;">{{$region_1}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_2"><ul id="region_2" style="min-height:100px;">{{$region_2}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_0"><ul id="region_0" style="min-height:380px;">{{$region_0}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_3"><ul id="region_3" style="min-height:140px;">{{$region_3}}</ul><div class="clear"></div></td>
	</tr>
</table>
'),

array(
	'kod' => 'uklad_aktualnosci',
	'nazwa' => 'Strona z aktualnościami',
	'plik' => 'uklad_aktualnosci.tpl',
	'regiony' => array(

		'region_0' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokRegulaminWprowadzaniaTresci', 'BlokRegulaminWprowadzaniaMaterialow', 'BlokFiltrowWyszukiwania'),
		'region_1' => array('!wszystko', 'kategoria', 'BlokOpisowy'),
		'region_2' => array('!wszystko', 'kategoria', 'BlokOpisowy'),
		'region_3' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokRegulaminWprowadzaniaTresci', 'BlokRegulaminWprowadzaniaMaterialow', 'BlokFiltrowWyszukiwania'),
		'region_4' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokMenu'),
	),
		'struktura' => '
<table border="0" frame="void" cellpadding="0" cellspacing="3" width="100%">
	<tr width="100%">
		<td class="region locked" width="30%"><ul class="locked" style="min-height:100px;">Nagłówek stały - logo, tytuł i szlagier strony</ul></td>
		<td class="region" width="70%" id="r_1"><ul id="region_1" style="min-height:100px;">{{$region_1}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_2"><ul id="region_2" style="min-height:100px;">{{$region_2}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_3"><ul id="region_3" style="min-height:60px;">{{$region_3}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_0"><ul id="region_0" style="min-height:380px;">{{$region_0}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_4"><ul id="region_4" style="min-height:140px;">{{$region_4}}</ul><div class="clear"></div></td>
	</tr>
</table>
'),

array(
	'kod' => 'uklad_formularz_kontaktowy',
	'nazwa' => 'Strona z formularzem kontaktowym',
	'plik' => 'uklad_formularz_kontaktowy.tpl',
	'regiony' => array(

		'region_0' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokRegulaminWprowadzaniaTresci', 'BlokRegulaminWprowadzaniaMaterialow', 'BlokFiltrowWyszukiwania'),
		'region_1' => array('!wszystko', 'kategoria', 'BlokOpisowy'),
		'region_2' => array('!wszystko', 'kategoria', 'BlokOpisowy'),
		'region_3' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokRegulaminWprowadzaniaTresci', 'BlokRegulaminWprowadzaniaMaterialow', 'BlokFiltrowWyszukiwania'),
		'region_4' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokMenu'),
		'region_5' => array('!wszystko', 'kategoria', 'BlokOpisowy'),
		'region_6' => array('!wszystko', 'kategoria', 'BlokOpisowy'),
	),
		'struktura' => '
<table border="0" frame="void" cellpadding="0" cellspacing="3" width="100%">
	<tr width="100%">
		<td class="region locked" width="30%"><ul class="locked" style="min-height:100px;">Nagłówek stały - logo, tytuł i szlagier strony</ul></td>
		<td class="region" width="70%" id="r_1"><ul id="region_1" style="min-height:100px;">{{$region_1}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_2"><ul id="region_2" style="min-height:100px;">{{$region_2}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_3"><ul id="region_3" style="min-height:60px;">{{$region_3}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td class="region" width="75%" id="r_0"><ul id="region_0" style="min-height:380px">{{$region_0}}</ul><div class="clear"></div></td>
		<td class="region" width="25%" id="r_4"><ul id="region_4" style="min-height:380px">{{$region_4}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_5"><ul id="region_5" style="min-height:140px;">{{$region_5}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_6"><ul id="region_6" style="min-height:140px;">{{$region_6}}</ul><div class="clear"></div></td>
	</tr>
</table>
'),

array(
		'kod' => 'uklad_dwie_kolumny',
		'nazwa' => 'Dwie kolumny',
		'plik' => 'uklad_dwie_kolumny.tpl',
		'regiony' => array(
			'region_0' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokRegulaminWprowadzaniaTresci', 'BlokRegulaminWprowadzaniaMaterialow', 'BlokFiltrowWyszukiwania'),
			'region_1' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokRegulaminWprowadzaniaTresci', 'BlokRegulaminWprowadzaniaMaterialow', 'BlokFiltrowWyszukiwania'),
			'region_2' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokRegulaminWprowadzaniaTresci', 'BlokRegulaminWprowadzaniaMaterialow', 'BlokFiltrowWyszukiwania'),
			'region_3' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokRegulaminWprowadzaniaTresci', 'BlokRegulaminWprowadzaniaMaterialow', 'BlokFiltrowWyszukiwania'),
			'region_4' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokRegulaminWprowadzaniaTresci', 'BlokRegulaminWprowadzaniaMaterialow', 'BlokFiltrowWyszukiwania'),
		),
		'struktura' => '
<table border="0" frame="void" cellpadding="0" cellspacing="3" width="100%">
	<tr width="100%">
		<td width="20%" class="region" id="r_2"><ul id="region_2" style="min-height:180px;">{{$region_2}}</ul><div class="clear"></div></td>
		<td width="80%" class="region" id="r_3"><ul id="region_3" style="min-height:180px;">{{$region_3}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td width="20%" class="region" id="r_0"><ul id="region_0" style="min-height:180px;">{{$region_0}}</ul><div class="clear"></div></td>
		<td width="80%" class="region" id="r_1"><ul id="region_1" style="min-height:180px;">{{$region_1}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td width="100%" colspan="2" class="region" id="r_4"><ul id="region_4" style="min-height:180px;">{{$region_4}}</ul><div class="clear"></div></td>
	</tr>
</table>
'),
	array(
		'kod' => 'uklad_jedna_kolumna',
		'nazwa' => 'Jedna kolumna',
		'plik' => 'uklad_jedna_kolumna.tpl',
		'regiony' => array(
			'region_0' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokRegulaminWprowadzaniaTresci', 'BlokRegulaminWprowadzaniaMaterialow', 'BlokFiltrowWyszukiwania'),
			'region_1' => array('!wszystko', 'kategoria', 'BlokOpisowy'),
			'region_2' => array('!wszystko', 'kategoria', 'BlokOpisowy'),
			'region_3' => array('!wszystko', 'kategoria', 'BlokSciezka', 'BlokOpisowy','BlokMenu'),
		),
		'struktura' => '
<table border="0" frame="void" cellpadding="0" cellspacing="3" width="100%">
	<tr width="100%">
		<td class="region locked" width="30%"><ul class="locked" style="min-height:100px;">Nagłówek stały - logo, tytuł i szlagier strony</ul></td>
		<td class="region" width="70%" id="r_1"><ul id="region_1" style="min-height:100px;">{{$region_1}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_2"><ul id="region_2" style="min-height:100px;">{{$region_2}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_0"><ul id="region_0" style="min-height:380px;">{{$region_0}}</ul><div class="clear"></div></td>
	</tr>
	<tr width="100%">
		<td colspan="2" class="region" id="r_3"><ul id="region_3" style="min-height:140px;">{{$region_3}}</ul><div class="clear"></div></td>
	</tr>
</table>
'),


)
?>
