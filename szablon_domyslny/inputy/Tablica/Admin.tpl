<div class="section inputs-inline" id="{{$nazwa}}">
{{BEGIN elementy}}
	<fieldset class="para">
	<p>
		<label>{{IF $napis_przed}}{{$napis_przed}}{{END}}</label><input type="text" name="{{$nazwa}}_klucz[]" value="{{$klucz}}" class="input_tablica_klucz input-xlarge" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/>
		<label>{{$podzial}}</label>
		<span class="input-append">
			<input type="text" name="{{$nazwa}}_wartosc[]" value="{{$wartosc}}" class="input_tablica_wartosc listaPoleZPrzyciskiem input-xlarge" {{$atrybuty}}/>
			   {{IF $dodawanie_wierszy}}<a class="usun_pole1 remove removeTablica btn btn-danger" href="javascript:void(0)"><i class="icon-remove"></i></a>{{END}}
		</span>
	</p>
	</fieldset>
{{END}}
<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony" />
{{BEGIN obsluga_dodawania_wierszy}}
	<div class="input_array input_array_dodawanie_wierszy btn-group" id="{{$nazwa}}_control">
		<input type="button" value="{{$etykieta_dodaj_pole}}" {{IF $start_limit}}style="display: none;"{{END}} class="dodaj_pole buttonSet btn btn-success" /><input type="button" value="{{$etykieta_usun_pole}}" class="usun_pole buttonSet  btn btn-danger" />
	</div>
	<script type="text/javascript">
	<!--
	$(document).ready(function(){

		var input = '<fieldset class="para"><p><label>{{$napis_przed}}</label><input type="text" name="{{$nazwa}}_klucz[]" value="" class="input_tablica_klucz" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/> <label>{{$podzial}}</label> <span class="input-append"><input type="text" name="{{$nazwa}}_wartosc[]" value="" class="input_tablica_wartosc listaPoleZPrzyciskiem" {{$strybuty}}/>{{IF $dodawanie_wierszy}}<a class="usun_pole1 remove removeTablica btn btn-danger" href="javascript:void(0)"><i class="icon-remove"></i></a>{{END}}</span></p></fieldset>';

		$(".usun_pole1").live("click", function() {
			$(this).parent().parent().remove();
			if ($("#{{$nazwa}} fieldset").length < {{$liczba_wierszy}})
			{
				$("#{{$nazwa}}_control .dodaj_pole").fadeIn("fast");
			}

			if ($("#{{$nazwa}} .para").length < 1)
			{
				$("#{{$nazwa}} .usun_pole").fadeOut("fast")
			}
		});

		$("#{{$nazwa}}_control .dodaj_pole").click(function()
		{
			if ($("#{{$nazwa}} fieldset:last").length == 0)
			{
				$("#{{$nazwa}}").prepend(input);
			}
			else
			{
				$("#{{$nazwa}} fieldset:last").after(input);
			}
			$("#{{$nazwa}} .usun_pole").fadeIn("normal");
			$("#{{$nazwa}} .para:last").show("fast");
			if ($("#{{$nazwa}} .para").length >= {{$liczba_wierszy}})
			{
				$(this).fadeOut("fast")
				return;
			}
		});

		$("#{{$nazwa}}_control .usun_pole").click(function(){
			if ($("#{{$nazwa}} .para").length > 0)
			{
				$("#{{$nazwa}} .para:last").fadeOut("normal").remove();
			}
			if ($("#{{$nazwa}} .para").length < 1)
			{
				$("#{{$nazwa}} .usun_pole").fadeOut("fast");
			}
			if ($("#{{$nazwa}} .para").length < {{$liczba_wierszy}})
			{
				$("#{{$nazwa}}_control .dodaj_pole").fadeIn("fast");
			}
		});

		{{IF $sortowanie}}
		$("#{{$nazwa}}").sortable({
			items: "fieldset",
			placeholder: "sortable-placeholder",
			opacity: 0.6,
			helper: "original"
		});
		{{END}}
	});
	-->
	</script>
{{END}}
</div>