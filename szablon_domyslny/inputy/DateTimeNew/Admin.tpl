
{{BEGIN selectRok}}
<span class="select_wrap select2">
	<select name="{{$nazwa}}_rok" id="{{$nazwa}}_rok" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$rok}}" {{ if($selected,'selected="selected"') }}>{{$rok}}</option>
	{{END}}
	</select> -
</span>
{{END}}

{{BEGIN selectMiesiac}}
<span class="select_wrap select2">
	<select name="{{$nazwa}}_miesiac" id="{{$nazwa}}_miesiac" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$miesiac}}" {{ if($selected,'selected="selected"') }}>{{$label}}</option>
	{{END}}
	</select>
</span>
{{END}}

{{BEGIN selectDzien}}
<span class="select_wrap select2">
	 - <select name="{{$nazwa}}_dzien" id="{{$nazwa}}_dzien" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$dzien}}" {{ if($selected,'selected="selected"') }}>{{$dzien}}</option>
	{{END}}
	</select>
</span>
{{END}}

<input type="hidden" id="{{$nazwa}}" name="{{$nazwa}}" value="{{$data}}" />
<script type="text/javascript">
<!--
$(function() {
{{BEGIN datepicker}}
$("#{{$nazwa}}").datepicker({
		onClose: function(dateText, inst) { {{$nazwa}}Odswiez(dateText); },
		onSelect: function(dateText, inst) { {{$nazwa}}Odswiez(dateText); odswiez(); },
		{{$datapicker_config}}
	},
	$.datepicker.regional['{{$kod_jezyka}}']);

	var {{$nazwa}}Odswiez = function(wybranaData)
	{
		var dzien, miesiac, rok;

		if (wybranaData instanceof Date)
		{
			dzien = (wybranaData.getDate() < 10) ? "0" + wybranaData.getDate() : wybranaData.getDate();
			miesiac = (wybranaData.getMonth()+1 < 10) ? "0" + (wybranaData.getMonth() +1 ) : (wybranaData.getMonth() + 1);
			rok = wybranaData.getFullYear();
		}
		else
		{
			wybranaData = wybranaData.split("-");
			dzien = wybranaData[2];
			miesiac = wybranaData[1];
			rok = wybranaData[0];
		}

		$("#{{$nazwa}}_dzien option[value='" + dzien + "']").attr("selected", "selected");
		$("#{{$nazwa}}_miesiac option[value='" + miesiac + "']").attr("selected", "selected");
		$("#{{$nazwa}}_rok option[value='" + rok + "']").attr("selected", "selected");
	}
{{END}}


	function odswiez()
	{
		// sprawdzamy czy dzien miesiaca pasuje
		var ostatniMiesiaca = new Date($("#{{$nazwa}}_rok").val(), $("#{{$nazwa}}_miesiac").val(), 0);

		if ($("#{{$nazwa}}_dzien").val() > ostatniMiesiaca.getDate())
		{
			dzien = (ostatniMiesiaca.getDate() < 10) ? "0" + ostatniMiesiaca.getDate() : ostatniMiesiaca.getDate();
			$("#{{$nazwa}}_dzien option[value='" + dzien + "']").attr("selected", "selected");
		}

		var godzina;
		var czas;

		if($("#{{$nazwa}}_rok").val() != ""
		&& $("#{{$nazwa}}_miesiac").val() != ""
		&& $("#{{$nazwa}}_dzien").val() != "")
		{
			
			if($("#{{$nazwa}}_godzina").val() != ""
			   && $("#{{$nazwa}}_minuta").val() != "")
			{
				godzina = $("#{{$nazwa}}_godzina").val() + ":" + $("#{{$nazwa}}_minuta").val() + ":00";
			}
			else
			{
				godzina = "00:00:00";
			}
			
			czas = $("#{{$nazwa}}_rok").val() + "-" +
					$("#{{$nazwa}}_miesiac").val();
		 
			{{IF wyswietlaj_dzien}}
				czas += "-" + $("#{{$nazwa}}_dzien").val()
			{{END}}
			{{IF wyswietlaj_czas}}
				czas += " " + godzina;
			{{END}}
			
		}
		else
		{
			czas = "";
		}

		$("#{{$nazwa}}").val(czas);
	}

	// kiedy select-y sa zmieniane updateujemy tez datePicker
	$("#{{$nazwa}}_dzien, #{{$nazwa}}_miesiac, #{{$nazwa}}_rok, #{{$nazwa}}_godzina, #{{$nazwa}}_minuta").change(function(){
		odswiez();
	});
});
-->
</script>
{{BEGIN selectGodzina}}
<span class="select_wrap select2">
	<select name="{{$nazwa}}_godzina" id="{{$nazwa}}_godzina" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$godzina}}" {{ if($selected,'selected="selected"') }}>{{$godzina}}</option>
	{{END}}
	</select> :
</span>
{{END}}

{{BEGIN selectMinuta}}
<span class="select_wrap select2">
	<select name="{{$nazwa}}_minuta" id="{{$nazwa}}_minuta" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$minuta}}" {{ if($selected,'selected="selected"') }}>{{$minuta}}</option>
	{{END}}
	</select>
</span>
{{END}}