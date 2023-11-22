<div class="option-list"><ul id="{{$nazwa}}_ul" class="input_array_ul">
	{{BEGIN element}}
		{{IF $numerowanie}}
		<li class="numerowane"><label>{{$_num}}</label>{{ELSE}}<li>{{END}}
			<span class="input-append">
				<input type="text" title="" name="{{$nazwa}}[{{$licznik}}]" value="{{$wartosc}}" {{$atrybuty}} class="listaPoleZPrzyciskiem" />
				{{IF $dodawanie_wierszy}}<a href="javascript:void(0)" title="{{$etykieta_usun_pole_wybrane}}" class="usuniecie remove btn btn-danger"><i class="icon-remove"></i></a>{{END}}
			</span>
		</li>
	{{END}}
	</ul></div>
	<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony" {{$atrybuty}} />

	{{BEGIN dodawanie_wierszy}}
	<div class="input_array_control btn-group" id="{{$nazwa}}_control">
		<a class="dodaj_pole buttonSet btn btn-success" {{IF $niemozliwe_dodawanie}}style="display: none;"{{END}}>{{$etykieta_dodaj_pole}}</a>
		<a class="usun_pole buttonSet btn btn-danger">{{$etykieta_usun_pole}}</a>
	</div>

	<script type="text/javascript">
	<!--
	var liczba_pol = $('#{{$nazwa}}_ul li').length;
	$(document).ready(function(){
		$(".usuniecie").live("click", function() {
			$(this).parent().remove();
			if ($("#{{$nazwa}}_ul li").length < {{$liczba_wierszy}})
			{
				$("#{{$nazwa}}_control .dodaj_pole").fadeIn("fast");
			}
			if ($("#{{$nazwa}}_ul li").length < 1)
			{
				$("#{{$nazwa}}_control .usun_pole").fadeOut("normal");
			}

			liczba_pol = 0;

			$("li.numerowane label").each(function () {
				++liczba_pol;
				$(this).html(liczba_pol + ".");
			})
		});

		$("#{{$nazwa}}_control .dodaj_pole").click(function()
		{
			var ilosc_pol = $("#{{$nazwa}}_ul li").length;
			var input = '{{IF $numerowanie}}<li class="numerowane"><label>' + (++liczba_pol) + '.</label>{{ELSE}}<li>{{END}}<span class="input-append"><input type="text" title="" name="{{$nazwa}}['+ilosc_pol+']" value="" {{$atrybuty}}> <a href="javascript:void(0)" title="{{$etykieta_usun_pole_wybrane}}" class="usuniecie remove btn btn-danger"><i class="icon-remove"></i></a></span></li>';

			if ($("#{{$nazwa}}_ul li:last").length == 0)
			{
				$("#{{$nazwa}}_ul").prepend(input);
					$("#{{$nazwa}}_control .usun_pole").fadeIn("normal");
			}
			else
			{
				$("#{{$nazwa}}_ul li:last").after(input);
			}
			$("#{{$nazwa}}_ul li:last").show("fast");
			if ($("#{{$nazwa}}_ul li").length >= {{$liczba_wierszy}})
			{
				$(this).hide();
				return;
			}
		});

		$("#{{$nazwa}}_control .usun_pole").click(function(){
			if ($("#{{$nazwa}}_ul li").length > 0)
			{
				$("#{{$nazwa}}_ul li:last").fadeOut("normal").remove();
				--liczba_pol;
			}
			if ($("#{{$nazwa}}_ul li").length < 1)
			{
				$("#{{$nazwa}}_control .usun_pole").fadeOut("normal");
				liczba_pol = 0;
			}
			if ($("#{{$nazwa}}_ul li").length < {{$liczba_wierszy}})
			{
				$("#{{$nazwa}}_control .dodaj_pole").fadeIn("fast");
			}
		});

		{{IF $sortowanie}}
		$("#{{$nazwa}}_ul").sortable({
			placeholder: "sortable-placeholder",
			opacity: 0.6,
			helper: "original"
		});
		{{END}}
	});
	-->
	</script>
	{{END}}