{{BEGIN formularz_start}}

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
		//$("input:not(input[type=hidden]):first").focus();
	});
-->
</script>
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
<form class="filters" enctype="{{$typ}}" id="{{$nazwa}}" name="{{$nazwa}}" method="{{$metoda}}" action="{{$akcja}}">
	<input type="hidden" name="__{{$nazwa}}" value="wypelniony" />
{{BEGIN token}}
	<input type="hidden" name="__token" value="{{$token}}" />{{END}}
<p>
{{END}}
{{BEGIN identyfikatorFormularza}}<input type="hidden" name="__identyfikator" value="{{$id}}" />{{END}}

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

		{{BEGIN etykieta}}
			<label for="{{$nazwa}}" class="{{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' *')}}</label>
		{{END}}
		{{$html}}
		{{BEGIN blad}}<span class="formularz_blad">{{$tresc}}</span>{{END}}
{{END}}

{{BEGIN pole_html}}
{{$tresc}}
{{END}}

{{BEGIN formularz_stop}}
</p>
	{{BEGIN stopka}}
		<div class="formularz_stopka">
			{{$input_html}}
		</div>
	{{END}}
</form>
{{END}}
