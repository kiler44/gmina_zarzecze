{{BEGIN formularz_start}}

{{BEGIN zakladki}}
<!-- {{BEGIN zakladka_label}} {{$zakladka_etykieta}} ({{$zakladka_nazwa}} {{$zakladka_klasa}}){{END}} -->
{{END}}

<div class="formularz_logowanie">
<form enctype="{{$typ}}" id="{{$nazwa}}" name="{{$nazwa}}" method="{{$metoda}}" action="{{$akcja}}">
	<input type="hidden" name="__{{$nazwa}}" value="wypelniony" />
{{BEGIN token}}
	<input type="hidden" name="__token" value="{{$token}}" />{{END}}
{{END}}

{{BEGIN zakladka_start}}
<!-- poczatek zakladki "{{$zakladka_nazwa}}" ({{$zakladka_tresc_atrybuty}})-->
{{END}}

{{BEGIN zakladka_stop}}
<!-- koniec zakladki "{{$zakladka_nazwa}}" -->
{{END}}

{{BEGIN pole_html}}
	{{$tresc}}
{{END}}

{{BEGIN region_start}}<!-- poczatek regionu "{{$region_nazwa}}" {{$region_etykieta}} -->{{END}}

{{BEGIN region_stop}}<!-- koniec regionu "{{$region_nazwa}}" -->{{END}}

{{BEGIN input}}
	<div class="input">
		{{BEGIN etykieta}}<label class="{{$klasa}} {{if($wymagany,'wymagany')}}"><span class="label">{{$etykieta}}{{if($wymagany,' *')}}</span>{{END}}
		{{$html}}
		{{ if(etykieta,'</label>') }}
		{{BEGIN blad}}<div class="formularz_blad">{{$tresc}}</div>{{END}}
	</div>
{{END}}

{{BEGIN formularz_stop}}
	{{BEGIN stopka}}
		<div class="formularz_stopka">
			{{$input_html}}
		</div>
	{{END}}
</form>
</div>
{{END}}
