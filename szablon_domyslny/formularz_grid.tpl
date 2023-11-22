{{BEGIN formularz_start}}

{{BEGIN zakladki}}
<!-- {{BEGIN zakladka_label}} {{$zakladka_etykieta}} ({{$zakladka_nazwa}} {{$zakladka_klasa}}){{END}} -->
{{END}}

<div class="formularz_grid">
<form enctype="{{$typ}}" id="{{$nazwa}}" name="{{$nazwa}}" method="{{$metoda}}" action="{{$akcja}}">
	<input type="hidden" name="__{{$nazwa}}" value="wypelniony" />
{{BEGIN token}}
	<input type="hidden" name="__token" value="{{$token}}" />{{END}}
<ul>
{{END}}
{{BEGIN identyfikatorFormularza}}<input type="hidden" name="__identyfikator" value="{{$id}}" />{{END}}

{{BEGIN zakladka_start}}
<!-- poczatek zakladki "{{$zakladka_nazwa}}" ({{$zakladka_tresc_atrybuty}})-->
{{END}}

{{BEGIN zakladka_stop}}
<!-- koniec zakladki "{{$zakladka_nazwa}}" -->
{{END}}

{{BEGIN region_start}}<!-- poczatek regionu "{{$region_nazwa}}" {{$region_etykieta}} -->{{END}}

{{BEGIN region_stop}}<!-- koniec regionu "{{$region_nazwa}}" -->{{END}}

{{BEGIN input}}
<li class="{{$input_klasa}}">
<dl>
	<dt>
		{{BEGIN etykieta}}<label for="{{$nazwa}}" class="{{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' *')}}</label>
		<span class="formularz_opis">{{$opis}}</span>{{END}}
	</dt>
	<dd>
		{{$html}}
		{{BEGIN blad}}<div class="formularz_blad">{{$tresc}}</div>{{END}}
	</dd>
</dl>
</li>
{{END}}

{{BEGIN pole_html}}
{{$tresc}}
{{END}}

{{BEGIN formularz_stop}}
</ul>
	{{BEGIN stopka}}
		<div class="formularz_stopka">
			{{$input_html}}
		</div>
	{{END}}
</form>
</div>
{{END}}
