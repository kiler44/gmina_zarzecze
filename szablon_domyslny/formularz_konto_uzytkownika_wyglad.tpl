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
	{{BEGIN etykieta}}
		<h2>{{$etykieta}}{{if($wymagany,' <strong>*</strong>')}}</h2>
	{{END}}
	{{BEGIN opisBuble}}
		<p class="bubble top">{{$opis}}</p>
	{{END}}
	<p>{{$html}}</p>
	{{BEGIN blad}}<div class="formularz_blad">{{$tresc}}</div>{{END}}
{{END}}

{{BEGIN input_zbiorowy}}
	{{BEGIN etykieta}}
		<h2>{{$etykieta}}{{if($wymagany,' <strong>*</strong>')}}</h2>
	{{END}}
	{{BEGIN opis}}
		<p class="bubble top">{{$opis}}</p>
	{{END}}
	{{BEGIN pionowy}}<div class="section">
		{{BEGIN pole}}
		<div class="info-gray">
			{{BEGIN etykieta}}
				<label for="{{$nazwa}}" class="{{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' <strong>*</strong>')}}</label>
				<span class="formularz_opis">{{$opis}}</span>
			{{END}}
			{{$html}}{{BEGIN blad}}<div class="formularz_blad">{{$tresc}}</div>{{END}}
		</div>
		{{END}}
	</div>
	{{END}}
	{{BEGIN poziomy}}
		{{BEGIN pole}}<div class="multiInput">{{$html}}{{BEGIN blad}}<div class="formularz_blad">{{$tresc}}</div>{{END}}</div>{{END}}
	{{END}}
{{END}}

{{BEGIN pole_html}}
{{$tresc}}
{{END}}

{{BEGIN formularz_stop}}
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
