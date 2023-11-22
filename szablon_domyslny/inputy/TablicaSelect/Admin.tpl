	<div id="{{$nazwa}}" class="input_array">
	{{BEGIN wiersze}}
		<fieldset class="para">
		<p>
			<label></label>
			{{$pobierz_select_1}}
			<label>{{$etykieta_podzial}}</label>
			<span class="input-append">
				{{$pobierz_select_2}}
		{{IF $dodawanie_wierszy}}
			<a class="usun_pole1 btn btn-danger" href="javascript:void(0)" title="{{$etykieta_usun_pole_wybrane}}"><i class="icon-remove"></i></a>
		{{END}}
			</span>
		</p>
		</fieldset>
	{{END}}
	<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony" />
	{{BEGIN obsluga_dodawania_wierszy}}
		<div class="input_array btn-group" id="{{$nazwa}}_control">
			<input type="button" value="{{$etykieta_dodaj_pole}}" class="dodaj_pole btn btn-success" />
			<input type="button" value="{{$etykieta_usun_pole}}" class="usun_pole btn btn-danger" />
		</div>
	<script type="text/javascript">
	<!--
	$(document).ready(function(){
		var input = '<fieldset class="para"><p><label></label>{{$pobierz_select_3}}<label>{{$etykieta_podzial}}</label><span class="input-append">{{$pobierz_select_4}}<a class="usun_pole1 btn btn-danger" href="javascript:void(0)" title="{{$etykieta_usun_pole_wybrane}}"><i class="icon-remove"></i></a></span></p></</fieldset>';

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
			if ($("#{{$nazwa}} .para:last").length == 0)
			{
				$("#{{$nazwa}}").prepend(input);
			}
			else
			{
				$("#{{$nazwa}} .para:last").after(input);
			}
			uruchomSelect2("#{{$nazwa}} .para:last select");
			$("#{{$nazwa}} .usun_pole").fadeIn("normal");
			$("#{{$nazwa}} .para:last").show("fast");

			if ($("#{{$nazwa}} .para").length >= {{$liczba_wierszy}})
			{
				$(this).hide();
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
	});
	-->
	</script>
	{{END}}

	</div>
		{{BEGIN select_html}}{{BEGIN lista}}<select name="{{$nazwa}}_{{$typ}}[]" class="input_tablica_{{$typ}}">{{IF $etykieta_wybierz}}<option value="">{{$etykieta_wybierz}}</option>{{END}}{{BEGIN wiele_poziomow}}<optgroup label="{{$klucz}}">{{BEGIN opcje}}<option value="{{$element}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>{{END}}</optgroup>{{END}}{{BEGIN opcje}}<option value="{{$klucz}}" {{IF $selected}}selected="selected"{{END}}>{{$wartosc}}</option>{{END}}</select>{{END}}{{BEGIN tekst}}<input type="text" name="{{$nazwa}}_{{$typ}}[]" value="{{$wartosc_poczatkowna}}" class="input_tablica_{{$typ}}" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/>{{END}}{{END}}
