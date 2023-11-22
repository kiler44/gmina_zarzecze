{{BEGIN formularz_start}}
{{BEGIN zakladki}}
<div class="zakladki">
	<ul>
	{{BEGIN zakladka_label}}
		<li class="zakladka_tytul {{$zakladka_klasa}}">
			<a href="#{{$zakladka_nazwa}}" id="{{$zakladka_nazwa}}_tab" name="name_{{$zakladka_nazwa}}">
				<span>{{$zakladka_etykieta}}</span>
			</a>
		</li>
	{{END}}
	</ul>
</div>
{{END}}
{{BEGIN brak_zakladek}}{{END}}
<div class="round_container"><b class="r"></b></div>
<div>
<form enctype="{{$typ}}" id="{{$nazwa}}" name="{{$nazwa}}" method="{{$metoda}}" action="{{$akcja}}">
	<div style="float:right;">{{$etykieta_wymagane_pola}}</div>
	<input type="hidden" name="__{{$nazwa}}" value="wypelniony" />
{{BEGIN token}}
	<input type="hidden" name="__token" value="{{$token}}" />
{{END}}
{{BEGIN identyfikatorFormularza}}<input type="hidden" name="__identyfikator" value="{{$id}}" />{{END}}

{{END}}

{{BEGIN zakladka_start}}
<!-- poczatek zakladki "{{$zakladka_nazwa}}" -->
<div class="formularz_zakladka">
	<div class="zakladka_tresc" id="{{$zakladka_nazwa}}_tresc" {{$zakladka_tresc_atrybuty}}>
{{END}}

{{BEGIN zakladka_stop}}
	</div>
</div>

<!-- koniec zakladki "{{$zakladka_nazwa}}" -->
{{END}}

{{BEGIN region_start}}
<!-- poczatek regionu "{{$region_nazwa}}" -->
<div class="formularz_region">
	<h3 class="region_tytul {{if($region_zamkniety, 'closed')}}">
		<a>
		<span class="left"><span class="right"><span class="label">
			{{$region_etykieta}}
		</span></span></span>
		</a><span class="zwin">{{ $etykieta_region_zwin_rozwin }}</span>
	</h3>
	<div class="region_tresc {{if($region_zamkniety, 'region_zamkniety')}}" id="{{$region_nazwa}}">
{{END}}

{{BEGIN region_stop}}
	</div>
</div>
<!-- koniec regionu "{{$region_nazwa}}" -->
{{END}}

{{BEGIN input}}
<div class="input_container">
	<table cellpadding="0" cellspacing="0" width="100%" class="input">
	<tbody>
	<tr class="{{$klasa}}">
		{{BEGIN etykieta}}<td class="etykieta" width="140">
			&nbsp;<label for="{{$nazwa}}" class="{{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' <strong>*</strong>')}}</label>
			<span class="formularz_opis">{{$opis}}</span>
		</td>{{END}}
		<td class="pole">
		{{$html}}
			{{BEGIN blad}}<div class="formularz_blad">{{$tresc}}</div>{{END}}
		</td>
	</tr>
	</tbody>
	</table>
</div>
{{END}}

{{BEGIN input_zbiorowy}}
<div class="input_container">
	<table cellpadding="0" cellspacing="0" width="100%" class="input">
	<tbody>
	<tr class="{{$klasa}}">
		{{BEGIN etykieta}}<td class="etykieta">
			&nbsp;<label for="{{$nazwa}}" class="{{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' *')}}</label>
			<span class="formularz_opis">{{$opis}}</span>
		</td>{{END}}
		<td class="pole">
{{BEGIN pionowy}}<table border="0" cellpadding="0" cellspacing="0" width="99%" class="multiInput">
{{BEGIN pole}}<tr>
		{{BEGIN etykieta}}<td class="etykieta">
			&nbsp;<label for="{{$nazwa}}" class="{{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' <strong>*</strong>')}}</label>
			<span class="formularz_opis">{{$opis}}</span>
		</td>{{END}}
		<td>{{$html}}{{BEGIN blad}}<div class="formularz_blad">{{$tresc}}</div>{{END}}</td></tr>{{END}}
</table>{{END}}
{{BEGIN poziomy}}
{{BEGIN pole}}<div class="multiInput">{{$html}}{{BEGIN blad}}<div class="formularz_blad">{{$tresc}}</div>{{END}}</div>{{END}}
{{END}}
		</td>
	</tr>
	</tbody>
	</table>
</div>
{{END}}

{{BEGIN pole_html}}
{{$tresc}}
{{END}}

{{BEGIN formularz_stop}}
{{BEGIN stopka}}
<div class="formularz_stopka">
	<div class="input" style=" text-align: center; ">
	{{$input_html}}
	</div>
</div>
<div class="bottom">
	<div class="round_container"><b></b></div>
</div>
{{END}}
</form>

</div>
<script type="text/javascript">
<!--

$(document).ready(function(){

	/*  Obsługa regionow  */
	function regionToggle(elem)
	{
		$(elem).toggleClass("closed");
		if($("+ .region_tresc", elem).is(":visible"))
		{
			$("+ .region_tresc", elem).slideUp("fast");
		}
		else
		{
			$("+ .region_tresc", elem).slideDown("fast");
		}
	}
	$(".region_tytul").click(function(){
		regionToggle($(this));
	});
});
-->
</script>
{{END}}
