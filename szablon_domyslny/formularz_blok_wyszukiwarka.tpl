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
<div>
<form enctype="{{$typ}}" id="{{$nazwa}}" name="{{$nazwa}}" method="{{$metoda}}" action="{{$akcja}}">
	<input type="hidden" name="__{{$nazwa}}" value="wypelniony" />
	{{BEGIN token}}<input type="hidden" name="__token" value="{{$token}}" />{{END}}
	{{BEGIN identyfikatorFormularza}}<input type="hidden" name="__identyfikator" value="{{$id}}" />{{END}}
{{END}}

{{BEGIN zakladka_start}}
<!-- poczatek zakladki "{{$zakladka_nazwa}}" -->
{{END}}

{{BEGIN zakladka_stop}}
<!-- koniec zakladki "{{$zakladka_nazwa}}" -->
{{END}}

{{BEGIN region_start}}
<!-- poczatek regionu "{{$region_nazwa}}" -->
<div class="region_tresc {{if($region_zamkniety, 'region_zamkniety')}}" id="{{$region_nazwa}}">
{{END}}

{{BEGIN region_stop}}
</div>
<div class="clear_r"></div>
<!-- koniec regionu "{{$region_nazwa}}" -->
{{END}}

{{BEGIN input}}{{BEGIN etykieta}}<div class="search_label"><label for="{{$nazwa}}">{{ $etykieta }}</label></div>{{END}}
<div class="input_bg bg {{$klasa}}"><div class="input_bg left"><div class="input_bg right">{{$html}}</div></div></div>{{BEGIN blad}}<!--{{$tresc}}-->{{END}}
{{END}}

{{BEGIN pole_html}}
{{$tresc}}
{{END}}

{{BEGIN formularz_stop}}
{{BEGIN stopka}}
<div class="form_stopka">{{$input_html}}</div>
{{END}}
</form>
</div>
{{END}}
