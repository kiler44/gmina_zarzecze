{{BEGIN formularz_start}}
	{{BEGIN zakladki}}
	<div class="tabs">
		<ul>
		{{BEGIN zakladka_label}}
			<li class="{{$zakladka_klasa}}" style="border: 1px solid #D9DFE6 !important;border-radius: 6px; padding-bottom:0px;">
				<a href="#{{$zakladka_nazwa}}" id="{{$zakladka_nazwa}}_tab" name="name_{{$zakladka_nazwa}}">
					{{$zakladka_etykieta}}
				</a>
			</li>
		{{END}}
		</ul>

	{{END}}
	{{BEGIN brak_zakladek}}{{END}}
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
<div id="{{$zakladka_nazwa}}" {{$zakladka_tresc_atrybuty}} style="border:0px;">

{{END}}

{{BEGIN zakladka_stop}}
	</div>

<!-- koniec zakladki "{{$zakladka_nazwa}}" -->
{{END}}

{{BEGIN region_start}}
<!-- poczatek regionu "{{$region_nazwa}}" -->
<h3 class="dropdown-header region_tytul"><a class="btn-style2 small padding4"><span></span></a>{{$region_etykieta}}</h3>
	<div class="opened-content {{if($region_zamkniety, 'closed')}} region_tresc" id="{{$region_nazwa}}">
{{END}}

{{BEGIN region_stop}}
</div>
<!-- koniec regionu "{{$region_nazwa}}" -->
{{END}}

{{BEGIN input}}
	{{BEGIN etykieta}}
		<h2>{{$etykieta}}{{if($wymagany,' <strong>*</strong>')}}</h2>
	{{END}}
	{{BEGIN opisBuble}}
		<p class="bubble top">{{$opis}}</p>
	{{END}}
	<div class="elementKontener {{$klasa}}">{{$html}}
	{{BEGIN blad}}<div class="formularz_blad">{{$tresc}}</div>{{END}}
	</div>
{{END}}

{{BEGIN input_zbiorowy}}
	{{BEGIN etykieta}}
		<h2 class="inputZbiorowyTytul">{{$etykieta}}{{if($wymagany,' <strong>*</strong>')}}</h2>
	{{END}}
	{{BEGIN opis}}
		<p class="bubble top">{{$opis}}</p>
	{{END}}
	{{BEGIN pionowy}}<table class="zbiorowyInput">
		<thead>
			<tr>
				<th width="160"></th>
				<th></th>
			</tr>
		</thead>
		{{BEGIN pole}}
		<tr><td{{if($brakEtykiety, ' colspan="2"', ' style="width:160px;"')}}>
			{{BEGIN etykieta}}
				<label for="{{$nazwa}}" class="{{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' <strong>*</strong>')}}</label>
				<span class="formularz_opis">{{$opis}}</span></td><td>
			{{END}}
			{{$html}}{{BEGIN blad}}<div class="formularz_blad">{{$tresc}}</div>{{END}}
		</td></tr>
		{{END}}
	</table>
	{{END}}
	{{BEGIN poziomy}}
		{{BEGIN pole}}<div class="multiInput">{{$html}}{{BEGIN blad}}<div class="formularz_blad">{{$tresc}}</div>{{END}}</div>{{END}}
		<div class="clearfix"></div>
	{{END}}
{{END}}

{{BEGIN pole_html}}
{{$tresc}}
{{END}}

{{BEGIN formularz_stop}}
	{{BEGIN zakladki_stop}}
	</div>
	{{END}}
	{{BEGIN stopka}}
	<p class="links-2">
		{{$input_html}}
	</p>
	{{END}}
</form>

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
