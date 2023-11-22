<div style="margin: 5px;">
	<div>{{$etykieta_podpowiedz}}</div>
	<input type="text" id="{{$nazwa}}_fraza" autocomplete="off" />
	<div id="{{$nazwa}}_wyniki"></div>
	<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}}/>
	</div>
	<script type="text/javascript">
	<!--
	var {{$nazwa}}_drzewo = { {{$drzewo}} };
	var sciezka = [];
	var lista = [];
	
	function przeszukajDrzewo(szukana, {{$nazwa}}_drzewo, sciezka)
	{
		if (typeof {{$nazwa}}_drzewo == "object")
		{
			var zapytanie = new RegExp(szukana,"i");
			
			for (var klucz in {{$nazwa}}_drzewo)
			{
				if (klucz.match(zapytanie))
				{
					sciezka.push(klucz);
					lista.push(clone(sciezka));
					sciezka.pop();
				}
				if (typeof {{$nazwa}}_drzewo[klucz] == "object")
				{
					sciezka.push(klucz);
					przeszukajDrzewo(szukana, {{$nazwa}}_drzewo[klucz], sciezka);
					sciezka.pop();
				}
			}
		}
	}

	function clone(obj)
	{
		if (obj == null || typeof(obj) != "object") return obj;
		var temp = obj.constructor(); // changed
		for (var key in obj) temp[key] = clone(obj[key]);
		return temp;
	}

	function wybierz(tresc, nazwa)
	{
		var tresc = tresc.split(" / ");

		var opcje = {
			empty_value: 0,
			select_class: "selectDrzewo_" + nazwa,
			rozmiar: 8,
			choose: '{{$wybierz}}',
			preselect: {nazwa: tresc}
		};
		opcje.preselect[nazwa] = tresc;

		$("input[name='"+nazwa+"']").optionTree(window[nazwa+"_drzewo"], opcje);
		$(".selectDrzewo_" + nazwa).each(function() {
			if (this.selectedIndex > 0) {
				$(this).attr("size", 1);
				$(this).attr("style", "width:81%");
			}
		});

		if ($("input[name={{$nazwa}}]").val() == "")
		{
			$("#{{$nazwa}}_komunikat").show();
		}
	}

	$(document).ready(function(){

		$("input[name={{$nazwa}}]").optionTree({{$nazwa}}_drzewo, {{$parametry_cfg}});

		$("#{{$nazwa}}_fraza").keyup(function() {
			var zapytanie = jQuery.trim($("#{{$nazwa}}_fraza").val());

			if (zapytanie.length > 2)
			{
				$("input[name={{$nazwa}}]").unbind("optionTree");
				$("input[name={{$nazwa}}]").optionTree({{$nazwa}}_drzewo, {{$parametry_cfg}});
				przeszukajDrzewo(zapytanie, {{$nazwa}}_drzewo, sciezka);
				var tresc = "<select size=8 style=\"width:100%;overflow: scroll;\" onchange=\"wybierz(this.options[selectedIndex].value, \'{{$nazwa}}\');\">";
				for (var i=0;i < lista.length; i++)
				{
					wartosc = lista[i].join(" / ");
					//opis = wartosc.replace(new RegExp(zapytanie,"i"), "<strong>" + zapytanie + "</strong>");
					tresc = tresc + "<option value=\"" + wartosc + "\">" + wartosc + "</option>";
				}
				tresc = tresc + "</select>";
				$("#{{$nazwa}}_wyniki").html(tresc);
				lista = [];
			}
			else
			{
				$("#{{$nazwa}}_wyniki").html("");
				$("#{{$nazwa}}_komunikat").hide();
				lista = [];
			}
		});
	});

	-->
	</script>