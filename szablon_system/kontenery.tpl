{{BEGIN kontener_pusty}}
<div class="pizda">
	{{$tresc}}
</div>
{{END}}
{{BEGIN kontener_podstawowy}}
<div class="modul">
<h2>{{$tytul_strony}}</h2>
<div class="tresc">{{$tresc}}</div>
</div>
{{END}}

{{BEGIN kontener_podstawowy_unicorn}}
<div class="container-fluid">
	<div class="row-fluid">{{$tresc}}</div>
</div>
{{END}}

{{BEGIN kontener_bez_linkow}}
<div class="modul">
<h2>{{$tytul_strony}}</h2>
<div class="linki"></div>
<div class="tresc">{{$tresc}}</div>
</div>
{{END}}

{{BEGIN kontener_tresc}}
<div class="modul">
	<div class="tresc">{{$tresc}}</div>
</div>
{{END}}

{{ BEGIN kontener_kategorie }}
<div class="kategorie_kontener">
<table cellspacing="0" cellpadding="0" id="kategorie">
	<tr>
		<td class="logo">
			<div class="hide">{{$tytul_modulu}}</div>
		</td>
		<td class="tr" id="kategorie_toggler">

		</td>
	</tr>
	<tr>
		<td class="tresc">
			<div class="hide">
				{{$tresc}}
			</div>
		</td>
		<td class="border_right">

		</td>
	</tr>
	<tr>
		<td class="stopka_bg"></td>
		<td class="stopka_r"></td>
	</tr>
</table>
</div>
{{END}}
