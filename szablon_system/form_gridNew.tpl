{{BEGIN formularz_js}}
<script type="text/javascript">
<!--
	$(document).ready(function(){

	/*  Obsługa zakładek  */
		$("input[type='text'], input[type='password']").keypress(function(event){
			if(event.keyCode == '13')
			{
				event.preventDefault();
				$("#{{$nazwa}}").submit();
			}
		});
		$("input:not(input[type=hidden]):first").focus();
	});
-->
</script>
{{END}}
{{BEGIN formularz_start}}

{{BEGIN zakladki}}
<div class="zakladki">
	<ul>
		{{BEGIN zakladka_label}}
		<li class="zakladka_tytul">
			<a href="javascript: void(0)" name="{{$zakladka_nazwa}}" class="{{$zakladka_klasa}}">
				<span class="label">{{$zakladka_etykieta}}</span>
			</a>
		</li>{{END}}
	</ul>
</div>
{{END}}
<div class="formularz_grid">
<form enctype="{{$typ}}" id="{{$nazwa}}" name="{{$nazwa}}" method="{{$metoda}}" action="{{$akcja}}" class="form-inline">
	<input type="hidden" name="__{{$nazwa}}" value="wypelniony" />
{{BEGIN token}}
	<input type="hidden" name="__token" value="{{$token}}" />{{END}}
<ul>
{{END}}

{{BEGIN zakladka_start}}
	<!-- poczatek zakladki "{{$zakladka_nazwa}}" -->
	<div class="formularz_zakladka">
		<div class="zakladka_tresc" id="{{$zakladka_nazwa}}" {{$zakladka_tresc_atrybuty}}>
{{END}}

{{BEGIN zakladka_stop}}
		</div>
	</div>
<!-- koniec zakladki "{{$zakladka_nazwa}}" -->
{{END}}

{{BEGIN region_start}}<!-- poczatek regionu "{{$region_nazwa}}" {{$region_etykieta}} -->{{END}}

{{BEGIN region_stop}}<!-- koniec regionu "{{$region_nazwa}}" -->{{END}}

{{BEGIN input}}
<li class="{{$input_klasa}}">
		{{BEGIN etykieta}}<label for="{{$nazwa}}" class="{{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' *')}}</label>
		<span class="formularz_opis">{{$opis}}</span>{{END}}
		{{$html}}
		{{BEGIN blad}}<div class="formularz_blad">{{$tresc}}</div>{{END}}
</li>
{{END}}

{{BEGIN pole_html}}
{{$tresc}}
{{END}}

{{BEGIN formularz_stop}}
</ul>
<div style="clear:both;"></div>
	{{BEGIN stopka}}
		<div class="formularz_stopka">
			{{$input_html}}
		</div>
	{{END}}
</form>
</div>
{{END}}

{{BEGIN input_zbiorowy}}
<span class="control-group {{$klasa}}">
	<span class="controls">
{{BEGIN pionowy}}<table class="{{$klasa}}">
	{{BEGIN pole}}<tr><td>
			{{$html}}
			{{BEGIN blad}}<span for="{{$nazwa}}" class="help-inline">{{$tresc}}</span>{{END}}
			{{BEGIN etykieta}}{{$opis}}{{END}}
	</td></tr>{{END}}
</table>{{END}}
{{BEGIN poziomy}}
	{{BEGIN pole}}
		<div class="polePoziome">
			{{BEGIN etykieta}}<label for="{{$nazwa}}">{{$etykieta}}</label>{{END}}
			{{$html}}
			{{BEGIN blad}}<span for="{{$nazwa}}" class="help-inline">{{$tresc}}</span>{{END}}
			{{BEGIN etykieta}}{{$opis}}{{END}}
		</div>
	{{END}}
{{END}}
</span>
</span>
{{END}}