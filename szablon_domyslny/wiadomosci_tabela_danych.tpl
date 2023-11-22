<script type="text/javascript">
<!--

$(document).ready(function(){
	//Podświetlanie wierszy po najechaniu kursorem
	$(".grid tr.wiersz").hover(
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
			$("#zaznacz_wszystkie img").attr({
				src: "/_system/admin/ikony/zaznacz.png",
				alt: "{{$etykieta_zaznacz_wszystkie}}",
				title: "{{$etykieta_zaznacz_wszystkie}}"
			});
			$("#zaznacz_btn img").attr({
				src: "/_system/admin/ikony/zaznacz.png",
				alt: "{{$etykieta_zaznacz_wszystkie}}",
				title: "{{$etykieta_zaznacz_wszystkie}}"
			});
			$(".grid tr.wiersz").unCheckCheckboxes();
			$(".grid tr.wiersz").removeClass("clicked");
		}
		else
		{
			zaznaczone = false;
			$("#zaznacz_wszystkie span").text("{{$etykieta_odznacz_wszystkie}}");
			$("#zaznacz_wszystkie img").attr({
				src: "/_system/admin/ikony/odznacz.png",
				alt: "{{$etykieta_odznacz_wszystkie}}",
				title: "{{$etykieta_odznacz_wszystkie}}"
			});
			$("#zaznacz_btn img").attr({
				src: "/_system/admin/ikony/odznacz.png",
				alt: "{{$etykieta_odznacz_wszystkie}}",
				title: "{{$etykieta_odznacz_wszystkie}}"
			});
			$(".grid .wiersz").checkCheckboxes();
			$(".grid tr.wiersz").addClass("clicked");
		}
	});

	//Obsługa przycisków grupowych
	$(".akcja_grupowa:not(#zaznacz_wszystkie, #zaznacz_btn, #odwroc_zaznaczenie) ").click(function(){
		if($(".grid .wiersz input[type='checkbox']:checked").length == 0)
		{
			alert("{{$blad_zaznaczenie_puste}}");
		}
		else
		{
			var akcja = $(this).attr("href");
			var inputs ='';
			$(".grid").append('<form id="grid_form" method="post" action="'+ akcja +'"></form>');
			$(".grid .wiersz input[type='checkbox']:checked").each(function(){
				inputs += '<input type="hidden" name="'+ $(this).attr("name") +'" value="'+ $(this).val() +'"/>'+"\n";
			});
			$("#grid_form").html(inputs);
			$("#grid_form").submit();
		}
		return false;
	});

	//Obsługa przycisku odwróć zaznaczenie
	$("#odwroc_zaznaczenie").click(function() {
		$(".grid tr.wiersz").toggleCheckboxes();
		zaznaczone = true;
		$(".grid tr.wiersz").each( function() {
			if ($(this).hasClass("clicked"))
			{
				$(this).removeClass("clicked");
			}
			else
			{
				$(this).addClass("clicked");
			}
		});
		return false;
	});

	//Po przeładowaniu strony resetuje stan checkboxów
		$(".grid tr.wiersz").unCheckCheckboxes();

	//Dodaje klase zaznacz do wszystkich wierszy danych tabeli
		$(".wiersz").addClass("zaznacz");

	//Zaznaczenie checkboxa i pokolorowanie wiersza po kliknięciu
		$("tr.zaznacz").click(function(){
			$(this).toggleCheckboxes();
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
<div class="wiadomosci_grid">
<table cellpadding="0" cellspacing="0" class="grid" border="0">
{{BEGIN naglowek}}
	<tr>
		<td colspan="{{$ilosc_kolumn}}">
			{{$naglowek_html}}
		</td>
	</tr>
{{END}}
	<tr class="naglowek">
		<th class="l"></th>
{{BEGIN naglowek_kolumna_zaznaczenie}}
		<th width="20" class="grupowe">
			<a href="javascript:void(0)" id="zaznacz_btn" class="akcja_grupowa"><img src="/_system/admin/ikony/zaznacz.png" alt="{{$etykieta_zaznacz_wszystkie}}"/></a>
		</th>{{END}}
{{BEGIN naglowek_kolumna_zwykla}}
		<th width="{{$szerokosc}}" class="{{$klasa}}">
			{{BEGIN sortowanie_start}}<a href="{{$url}}" title="{{$etykieta_sortuj_po}}" class="{{$klasa}}">{{END}}
			<span>{{$etykieta_kolumny}}</span>
			{{BEGIN sortowanie_stop}}</a>{{END}}
		</th>{{END}}
{{BEGIN naglowek_kolumna_przyciski}}
		<th width="{{$szerokosc}}">
			<span>&nbsp;</span>
		</th>
{{END}}
		<th class="r"></th>
	</tr>
{{BEGIN wiersz_brak_danych}}
	<tr class="wiersz pusty">
		<td colspan="{{$ilosc_kolumn}}" align="center">{{$etykieta_brak_wierszy}}</td>
	</tr>{{END}}
{{BEGIN wiersz}}
	<tr class="wiersz {{$klasa}}" id="wiersz_{{$wartosc_klucza}}">
		<td></td>
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
			{{BEGIN przycisk}}<a href="{{$url}}" {{$parametry}}>{{BEGIN ikona}}<img src="/_system/admin/ikony/{{$ikona}}" alt="{{$etykieta}}" title="{{$etykieta}}"/>{{END}}{{ if($etykieta,'<span>') }}{{$etykieta}}{{ if($etykieta,'</span>') }}</a> {{END}}
		</td>{{END}}
		<td></td>
	</tr>{{END}}
</table>
</div>
	<div class="bottom">
		<div class="round_container"><b></b></div>
	</div>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="w_pager">

{{BEGIN stopka_kolumna_zaznaczenie}}
	<tr>
		<td>
		{{BEGIN przycisk}}<a href="{{$url}}" class="akcja_grupowa" title="{{$etykieta}}" {{$parametry}}>
		{{BEGIN ikona}}<img src="/_system/admin/ikony/{{$ikona}}" alt="{{$etykieta}}"/>{{END}}{{ if($etykieta,'<span>') }}{{$etykieta}}{{ if($etykieta,'</span>') }}</a>{{END}}
		</td>
	</tr>
{{END}}
	<tr class="stopka">
		<td colspan="2" align="right">{{$pager_html}}</td>
	</tr>
</table>
{{BEGIN stopka}}
<div>
	{{$stopka_tresc}}
</div>
	{{END}}
