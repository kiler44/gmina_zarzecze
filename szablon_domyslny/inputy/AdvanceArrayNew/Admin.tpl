<div class="section inputs-inline input-tablica-zaawansowana" id="{{$nazwa}}">
{{BEGIN elementy}}
	<fieldset class="para para_{{$licznikWierszy}}_{{$nazwa}}">
	<div class="wiersz-tablicy-zaawansowanej">
		<label{{IF($ukryj_pola_klucza, ' style="display:none;"')}}>{{IF $napis_przed}}{{$napis_przed}}{{END}}</label><input type="text" name="{{$nazwa}}_klucz[]" value="{{$klucz}}" class="input_tablica_klucz" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}{{IF($ukryj_pola_klucza, ' style="display:none;"')}}/>
		<label{{IF($ukryj_pola_klucza, ' style="display:none;"')}}>{{$podzial}}</label>
		<div class="pola-tablicy-zaawansowanej{{IF($ukryj_pola_klucza, ' klucze-ukryte')}}">
			{{$htmlInputa}}
		</div>
		{{IF $dodawanie_wierszy}}<a class="usun_pole1 remove removeTablica btn btn-danger" href="javascript:void(0)"><i class="icon-remove"></i></a>{{END}}
	</div>
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

		var input = '<fieldset class="para para_IDWIERSZA_{{$nazwa}}"><div class="wiersz-tablicy-zaawansowanej"><label{{IF($ukryj_pola_klucza, ' style="display:none;"')}}>{{$napis_przed}}</label><input type="text" name="{{$nazwa}}_klucz[]" value="" class="input_tablica_klucz" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}{{IF($ukryj_pola_klucza, ' style="display:none;"')}}/> \
					<label{{IF($ukryj_pola_klucza, ' style="display:none;"')}}>{{$podzial}}</label>\
					<div class="pola-tablicy-zaawansowanej{{IF($ukryj_pola_klucza, ' klucze-ukryte')}}">\
					{{$htmlSzablonWiersza}}\
					</div>\
					{{IF $dodawanie_wierszy}}<a class="usun_pole1 remove removeTablica btn btn-danger" href="javascript:void(0)"><i class="icon-remove"></i></a>{{END}}\
					</div></fieldset>';
		var {{$nazwa}}_licznikPol = {{$licznikPol}};

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

			//tutaj następuje przenumerowanie pól
			var numerRodzica = parseInt($(this).parent().parent().attr('class').replace(/para para_/g, '').replace(/_{{$nazwa}}/g, ''));
			for (i = numerRodzica + 1; i < {{$nazwa}}_licznikPol; ++i)
			{
				$('.para_' + i + '_{{$nazwa}}').each(function() {
					var numerRodzica = parseInt($(this).attr('class').replace(/para para_/g, '').replace(/_{{$nazwa}}/g, ''));
					$(this).attr('class', 'para para_' + (numerRodzica - 1) + '_{{$nazwa}}');

					$(this).find('[name^="{{$nazwa}}_subpole_' + numerRodzica + '_"]').each(function() {
						var numerRodzica = parseInt($(this).attr('name').replace(/{{$nazwa}}_subpole_/g, ''));
						$(this).attr('name', $(this).attr('name').replace('_' + numerRodzica + '_', '_' + (numerRodzica - 1) + '_'));
					})

					$(this).find('[name^="{{$nazwa}}_subpole_"]').each(function() {
						var numerRodzica = parseInt($(this).attr('name').replace(/{{$nazwa}}_subpole_/g, ''));

						$(this).attr('id', $(this).attr('id').replace('_' + (numerRodzica + 1) + '_', '_' + (numerRodzica) + '_'));
					})
				})
			}

			{{$nazwa}}_licznikPol--;
		});

		$("#{{$nazwa}}_control .dodaj_pole").click(function()
		{
			if ($("#{{$nazwa}} fieldset:last").length == 0)
			{
				$("#{{$nazwa}}").prepend(input.replace(/_IDWIERSZA_/g, '_' + {{$nazwa}}_licznikPol + '_').replace(/&lt;/g, '<').replace(/&gt;/g, '>'));
			}
			else
			{
				$("#{{$nazwa}} fieldset:last").after(input.replace(/_IDWIERSZA_/g, '_' + {{$nazwa}}_licznikPol + '_').replace(/&lt;/g, '<').replace(/&gt;/g, '>'));
			}

			{{$nazwa}}_licznikPol++;

			{{IF $ukryj_pola_klucza}}
			$('.para_' + ({{$nazwa}}_licznikPol - 1) + '_{{$nazwa}} .input_tablica_klucz:last').attr('value', {{$nazwa}}_licznikPol);
			{{END}}

			uruchomSelect2('.pola-tablicy-zaawansowanej:last select');
			$('.pola-tablicy-zaawansowanej:last input[type=radio]').uniform();
			$('.pola-tablicy-zaawansowanej:last input[type=checkbox]').uniform();

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

			{{$nazwa}}_licznikPol--;
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

{{BEGIN inputInline}}
{{$htmlInputa}}
{{END}}

{{BEGIN inputPionowy}}
<div class="input-tablica-zaawansowana-pionowy">{{$htmlInputa}}</div>
{{END}}