<script type="text/javascript">
<!--

$(document).ready(function(){
	//Podświetlanie wierszy po najechaniu kursorem
	$(".gridTab tr.wiersz").hover(
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
			$(".gridTab").unCheckCheckboxes();
			$(".gridTab tr.wiersz").removeClass("clicked");
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
			$(".gridTab").checkCheckboxes();
			$(".gridTab tr.wiersz").addClass("clicked");
		}
	});

	//Obsługa przycisków grupowych
	$(".gridTab .akcja_grupowa:not(#zaznacz_wszystkie, #zaznacz_btn, #odwroc_zaznaczenie) ").click(function(){
		if ($(".gridTab input[type='checkbox']:checked").length == 0)
		{
			alert("{{$blad_zaznaczenie_puste}}");
		}
		else
		{
			$(".gridTab").append('<form id="grid_actions_form" method="post" action="' + $(this).attr("href") + '"></form>');
			$(".gridTab input[type='checkbox']:checked").each(function(){
				$("#grid_actions_form").append('<input style="dispaly: none;" type="hidden" name="' + this.name + '" value="' + this.value + '"/>'+"\n");
			});
			$("#grid_actions_form").submit();
		}
		return false;
	});

	function wyslijAkcjeGrupowa(obj)
	{
		if($(".gridTab input[type='checkbox']:checked").length == 0) return false;

		$(".gridTab").append('<form id="grid_actions_form" method="post" action="' + $(obj).attr("href") + '"></form>');
		$(".gridTab input[type='checkbox']:checked").each(function(){
			$("#grid_actions_form").append('<input style="dispaly: none;" type="hidden" name="' + this.name + '" value="' + this.value + '"/>'+"\n");
		});
		$("#grid_actions_form").submit();
		return false;
	}

	function wyslijAkcjeGrupowa2(href)
	{
		if($(".gridTab input[type='checkbox']:checked").length == 0) return false;

		$(".gridTab").append('<form id="grid_actions_form" method="post" action="' + href + '"></form>');
		$(".gridTab input[type='checkbox']:checked").each(function(){
			$("#grid_actions_form").append('<input style="dispaly: none;" type="hidden" name="' + this.name + '" value="' + this.value + '"/>'+"\n");
		});
		$("#grid_actions_form").submit();
		return false;
	}

	//Obsługa przycisku usun zaznaczone
	$(".akcje_grupowe").click(function(){
		return wyslijAkcjeGrupowa($(this));
	});

	//Obsługa przycisku odwróć zaznaczenie
	$(".gridTab #odwroc_zaznaczenie").click(function() {
		$(".gridTab").toggleCheckboxes();
		zaznaczone = true;
		$(".gridTab tr.wiersz").each( function() {
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
		$(".gridTab .wiersz").unCheckCheckboxes();

	//Dodaje klase zaznacz do wszystkich wierszy danych tabeli
		$(".wiersz").addClass("zaznacz");

	//Zaznaczenie checkboxa i pokolorowanie wiersza po kliknięciu
		$("tr.zaznacz td").click(function(){
			$(this).parent().toggleCheckboxes();
			$(this).parent().toggleClass("clicked");
		});
		$("tr.zaznacz td.przyciski").unbind('click');
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
{{BEGIN stopka_kolumna_zaznaczenie}}
<div class="pager-contener" style="margin-left:5px; float:left;">
	<div class="actions" style="margin-bottom: 5px;">

{{BEGIN przycisk}}
<a style="float:left;" class="akcje_grupowe2 buttonSet buttonLight" rel="{{$url}}" title="{{$etykieta}}" {{$parametry}}>{{$etykieta}}
	{{BEGIN ikona}}{{END}}<!-- {{ if($etykieta,'<span>') }}{{$etykieta}}{{ if($etykieta,'</span>') }} -->
</a>
{{END}}
</div></div><div class="clearfix"></div>{{END}}
<table class="gridTab type1 tabelaBe">
<thead>
{{BEGIN naglowek}}
	<tr>
		<th colspan="{{$ilosc_kolumn}}">
			{{$naglowek_html}}
		</th>
	</tr>
{{END}}
	<tr class="naglowek">
{{BEGIN naglowek_kolumna_zaznaczenie}}
		<th scope="col" class="check">
			<a href="javascript:void(0)" id="zaznacz_btn" class="akcja_grupowa" title="{{$etykieta_zaznacz_wszystkie}}"><img src="/_system/admin/ikony/zaznacz.png" alt="{{$etykieta_zaznacz_wszystkie}}"/></a>
		</th>{{END}}
{{BEGIN naglowek_kolumna_zwykla}}
		<th scope="col" width="{{$szerokosc}}" class="{{$klasa}}">
			{{BEGIN sortowanie_start}}<a href="{{$url}}" title="{{$etykieta_sortuj_po}}">{{END}}
			{{$etykieta_kolumny}}<span></span>
			{{BEGIN sortowanie_stop}}</a>{{END}}
		</th>{{END}}
{{BEGIN naglowek_kolumna_przyciski}}
		<th scope="col" width="{{$szerokosc}}">
			<span>&nbsp;</span>
		</th>{{END}}
	</tr>
</thead>
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
		<td class="{{$klasa}}" valign="middle" {{$atrybuty}}>
			{{BEGIN akcja}}<a href="{{$url}}" class="{{$klasa}}"><span>{{$tresc_kolumny}}</span></a>  {{END}}{{ if($tresc_kolumny,'<span>') }}{{$tresc_kolumny}}{{ if($tresc_kolumny,'</span>') }}
		</td>{{END}}
	{{BEGIN kolumna_przyciski}}
		<td class="{{$klasa}} przyciski" valign="middle">
			{{BEGIN przycisk}}<a href="{{$url}}" {{$parametry}}>{{BEGIN ikona}}<img src="/_system/admin/ikony/{{$ikona}}" alt="{{$etykieta}}" title="{{$etykieta}}"/>{{END}}{{ if($etykieta,'<span>') }}{{$etykieta}}{{ if($etykieta,'</span>') }}</a> {{END}}
			{{BEGIN przyciskNowy}}<a href="{{$url}}" {{$parametry}} title="{{$etykieta}}"></a> {{END}}
			{{BEGIN przycisk_pusty}}<span><img src="/_system/admin/ikony/bullet_white.png" alt=""/></span>{{END}}
		</td>{{END}}
	</tr>{{END}}
	<tr class="stopka">
		<td colspan="{{$ilosc_kolumn}}">
			<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td width="50%" align="left">
{{BEGIN stopka_kolumna_zaznaczenie}}
<div class="pager-contener" style="margin-left: -17px;">
	<div class="actions bottom_actions">

{{BEGIN przycisk}}<a style="float:left;" class="akcje_grupowe2 btn-style2"rel="{{$url}}" title="{{$etykieta}}" {{$parametry}}>{{$etykieta}}
	{{BEGIN ikona}}{{END}}<!-- {{ if($etykieta,'<span>') }}{{$etykieta}}{{ if($etykieta,'</span>') }} -->
</a>
{{END}}
</div></div>{{END}}
					</td>
					<td width="50%" align="right">{{$pager_html}}</td>
				</tr>
			</table>
		</td>
	</tr>
{{BEGIN stopka}}
	<tr class="stopka">
		<td colspan="{{$ilosc_kolumn}}">
			{{$stopka_tresc}}
		</td>
	</tr>
	{{END}}
</table>

