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
<div class="round_container"><b class="r"></b></div>
{{END}}
{{BEGIN brak_zakladek}}<div class="round_container brak_zakladek"><b class="l"></b><b class="r"></b></div>{{END}}
<div>

<form enctype="{{$typ}}" id="{{$nazwa}}" name="{{$nazwa}}" method="{{$metoda}}" action="{{$akcja}}" class="row g-3 needs-validation {{$klasa_css_formularza}}">
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
<div class="boxPureShell">
	{{if $region_etykieta}}
	<h3 class="region_tytul {{if($region_zamkniety, 'closed')}}">{{$region_etykieta}}<a class="ico-icoQ" href="#"></a></h3>
	{{end}}
	<div class="region_tresc {{if($region_zamkniety, 'region_zamkniety')}}" id="{{$region_nazwa}}">
{{END}}

{{BEGIN region_stop}}
	</div>
</div>
<!-- koniec regionu "{{$region_nazwa}}" -->
{{END}}

{{BEGIN input}}
<div class="{{$klasa}}">
	{{IF $klasa_wew}}<div class="{{$klasa_wew}}">{{END}}
		{{BEGIN etykieta}}
		<label for="{{$nazwa}}" class="form-label {{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' <strong>*</strong>')}}</label>
		{{END}}
		{{$html}}
		{{BEGIN blad}}<div class="invalid-feedback">{{$tresc}}</div>{{END}}
	{{IF $klasa_wew}}</div>{{END}}
</div>
{{END}}


{{BEGIN etykieta}}{{$etykieta}}{{END}}

{{BEGIN input_zbiorowy}}
	{{BEGIN pionowy}}
	<fieldset {{if $klasa}}class="{{$klasa}}"{{end}}>
		{{BEGIN etykieta}}
			<h3 class="{{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' *')}}</h3>
			<span class="formularz_opis">{{$opis}}</span>
		{{END}}
		{{BEGIN pole}}
			<div class="hR mbDimA {{$klasa}}">
				{{BEGIN etykieta}}
				<label for="{{$nazwa}}" class="textLabel {{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' <strong>*</strong>')}}</label>
				{{END}}
				{{$html}}
				{{BEGIN opis}}
				<span class="descLabel">{{$opis}}</span>
				{{END}}
				{{BEGIN blad}}<div class="errorLabel">{{$tresc}}</div>{{END}}</div>
		{{END}}
	</fieldset>
	{{END}}
	{{BEGIN poziomy}}
		<div class="hR mbDimB {{$klasa}}">
			{{BEGIN etykieta}}
			<label for="{{$nazwa}}" class="textLabel {{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' <strong>*</strong>')}}</label>
			{{END}}
			{{BEGIN opis}}
			<span class="descLabel">{{$opis}}</span>
			{{END}}
		{{BEGIN pole}} {{$html}} {{BEGIN blad}}<div class="errorLabel">{{$tresc}}</div>{{END}} {{END}}
		</div>
	{{END}}
{{END}}

{{BEGIN pole_html}}
{{$tresc}}
{{END}}

{{BEGIN formularz_stop}}
{{BEGIN stopka}}
<div class="col-12 text-lg-end text-center">
	{{$input_html}}
</div>
{{END}}
</form>

</div>
{{END}}
