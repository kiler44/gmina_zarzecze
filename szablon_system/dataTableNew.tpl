<script type="text/javascript">
<!--

$(document).ready(function(){
	//Podświetlanie wierszy po najechaniu kursorem
	$(".table tr.wiersz").hover(
		function() {$(this).addClass("highlight");},
		function() {$(this).removeClass("highlight");}
	);
});
-->
</script>

{{ BEGIN skrypt_zaznaczenie}}
<script type="text/javascript">
<!--
	$(document).ready(function(){

	// Tooltip
	var zaznaczone = true;

	// Obsługa przycisku zaznacz odznacz wszystkie
	$("#zaznacz_wszystkie, #zaznacz_btn").click(function()
	{
		if(!zaznaczone)
		{
			zaznaczone = true;
			$("#zaznacz_wszystkie span").text("{{$etykieta_zaznacz_wszystkie}}");
			$("#zaznacz_wszystkie i").attr({
				'class': 'icon-check-empty',
				alt: "{{$etykieta_zaznacz_wszystkie}}",
				title: "{{$etykieta_zaznacz_wszystkie}}"
			});
			$("#zaznacz_btn i").attr({
				'class': 'icon-check-empty',
				alt: "{{$etykieta_zaznacz_wszystkie}}",
				title: "{{$etykieta_zaznacz_wszystkie}}"
			});
			$(".table input[type=checkbox]").attr('checked', false);
			$(".table tr.wiersz").removeClass("clicked");

		}
		else
		{
			zaznaczone = false;
			$("#zaznacz_wszystkie span").text("{{$etykieta_odznacz_wszystkie}}");
			$("#zaznacz_wszystkie i").attr({
				'class': 'icon-check',
				alt: "{{$etykieta_odznacz_wszystkie}}",
				title: "{{$etykieta_odznacz_wszystkie}}"
			});
			$("#zaznacz_btn i").attr({
				'class': 'icon-check',
				alt: "{{$etykieta_odznacz_wszystkie}}",
				title: "{{$etykieta_odznacz_wszystkie}}"
			});
			$(".table input[type=checkbox]").attr('checked', true);
			$(".table tr.wiersz").addClass("clicked");
		}

		$.uniform.update();
	});

	//Obsługa przycisków grupowych
	$(".table .akcja_grupowa:not(#zaznacz_wszystkie, #zaznacz_btn, #odwroc_zaznaczenie) ").click(function(){
		if ($(".table input[type='checkbox']:checked").length == 0)
		{
			alert("{{$blad_zaznaczenie_puste}}");
		}
		else
		{
			$(".table").append('<form id="grid_actions_form" method="post" action="' + $(this).attr("href") + '"></form>');
			$(".table input[type='checkbox']:checked").each(function(){
				$("#grid_actions_form").append('<input style="dispaly: none;" type="text" name="' + this.name + '" value="' + this.value + '"/>'+"\n");
			});
			$("#grid_actions_form").submit();
		}
		return false;
	});

	//Obsługa przycisku usun zaznaczone
	$(".akcje_grupowe").click(function(){
		if($(".table input[type='checkbox']:checked").length == 0) return false;

		$(".table").append('<form id="grid_actions_form" method="post" action="' + $(this).attr("href") + '"></form>');
		$(".table input[type='checkbox']:checked").each(function(){
			$("#grid_actions_form").append('<input style="dispaly: none;" type="text" name="' + this.name + '" value="' + this.value + '"/>'+"\n");
		});
		$("#grid_actions_form").submit();
		return false;
	});

	//Obsługa przycisku odwróć zaznaczenie
	$(".table #odwroc_zaznaczenie").click(function() {
		$('table input[type=checkbox]').each(function () {
			$(this).attr('checked', ! $(this).attr('checked'));

			if ($(this).attr('checked'))
			{
				$(this).parents('tr').addClass("clicked");
			}
			else
			{
				$(this).parents('tr').removeClass('clicked');
			}
		});
		$.uniform.update();

		return false;
	});

	//Po przeładowaniu strony resetuje stan checkboxów
		$(".table input[type=checkbox]").attr('checked', false);
		$.uniform.update();

	//Dodaje klase zaznacz do wszystkich wierszy danych tabeli
		$(".wiersz").addClass("zaznacz");

	//Zaznaczenie checkboxa i pokolorowanie wiersza po kliknięciu
		$("tr.zaznacz").click(function(){
			if ($(this).find('input').attr('checked') != undefined)
			{
				$(this).find('input').attr('checked', false);
			}
			else
			{
				$(this).find('input').attr('checked', true);
			}
			$.uniform.update();
			$(this).toggleClass("clicked");
		});
		$("tr.zaznacz input").click(function(){
			if($(this).attr("checked"))
				$(this).attr("checked", false);
			else
				$(this).attr("checked", true);
				
		});
	});

-->
</script>
{{END}}
<div class="tabelaDanych">
	{{BEGIN naglowek}}
		<div class="widget-title">
			{{$naglowek_html}}
		</div>
	{{END}}

<div class="widget-content nopadding">
	<table class="table table-striped table-bordered">

	<tr class="naglowek">
{{BEGIN naglowek_kolumna_zaznaczenie}}
		<th>
			<a href="javascript:void(0)" id="zaznacz_btn" class="akcja_grupowa" title="{{$etykieta_zaznacz_wszystkie}}"><i class="icon-check-empty"></i></a>
		</th>{{END}}
{{BEGIN naglowek_kolumna_zwykla}}
		<th width="{{$szerokosc}}" class="{{$klasa}}">
			{{BEGIN sortowanie_start}}<a href="{{$url}}" title="{{$etykieta_sortuj_po}}" class="{{$klasa}}"><i class="{{$ikona}}"></i> {{END}}
				<span>{{$etykieta_kolumny}}</span>
			{{BEGIN sortowanie_stop}}</a>{{END}}
		</th>{{END}}
{{BEGIN naglowek_kolumna_przyciski}}
		<th>
			<span>&nbsp;</span>
		</th>{{END}}
	</tr>
{{BEGIN wiersz_brak_danych}}
	<tr class="wiersz pusty">
		<td colspan="{{$ilosc_kolumn}}" align="center">{{$etykieta_brak_wierszy}}</td>
	</tr>{{END}}
{{BEGIN wiersz}}
	<tr class="wiersz {{$klasa}}" id="wiersz_{{$wartosc_klucza}}" {{$atrybuty}}>
	{{BEGIN kolumna_zaznaczenie}}
		<td class="{{$klasa}} grupowe">
			<input type="checkbox" name="{{$nazwa_klucza}}[]" value="{{$wartosc_klucza}}"/>
		</td>{{END}}
	{{BEGIN kolumna}}
		<td class="{{$klasa}}" valign="middle">
			{{BEGIN akcja}}<a href="{{$url}}" class="{{$klasa}}"><span>{{$tresc_kolumny}}</span></a>  {{END}}{{ if($tresc_kolumny,'<span>') }}{{$tresc_kolumny}}{{ if($tresc_kolumny,'</span>') }}
		</td>{{END}}
	{{BEGIN kolumna_przyciski}}
		<td class="{{$klasa}} przyciski" valign="middle">
			<div class="btn-group">
			{{BEGIN przycisk}}<a class="btn tip-top {{$klasa_przycisku}}" href="{{$url}}" title="{{$etykieta}}" {{$parametry}}>{{BEGIN ikona}}<i class="{{$ikona}}"></i>{{END}}</a> {{END}}
			{{BEGIN przycisk_pusty}}<a class="btn"><i class="icon-sign-blank"></i></a>{{END}}
			</div>
		</td>{{END}}
	</tr>{{END}}
{{BEGIN stopka_kolumna_zaznaczenie}}
	<tr class="stopka">
		<td colspan="{{$ilosc_kolumn}}">
			<div class="btn-group pull-left">
				{{BEGIN przycisk}}<a href="{{$url}}" class="btn btn-small akcja_grupowa" title="{{$etykieta}}" {{$parametry}}>
					{{BEGIN ikona}}<i class="{{$ikona}}"></i>{{END}}
				</a>
				{{END}}
			</div>
			<div class="pull-right">
				{{$pager_html}}
			</div>
		</td>
	</tr>
{{END}}
{{BEGIN stopka}}
	<tr class="stopka">
		<td colspan="{{$ilosc_kolumn}}">
			{{$stopka_tresc}}
		</td>
	</tr>
	{{END}}
</table>
</div>
</div>