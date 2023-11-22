{{BEGIN selectRok}}
	<div class="input input1"><select name="{{$nazwa}}_rok" id="{{$nazwa}}_rok" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$rok}}" {{ if($selected,'selected="selected"') }}>{{$rok}}</option>
	{{END}}
	</select></div><span> - </span>
{{END}}

{{BEGIN selectMiesiac}}
	<div class="input input2"><select name="{{$nazwa}}_miesiac" id="{{$nazwa}}_miesiac" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$miesiac}}" {{ if($selected,'selected="selected"') }}>{{$miesiac}}</option>
	{{END}}
	</select></div><span> - </span>
{{END}}

{{BEGIN selectDzien}}
	<div class="input input2"><select name="{{$nazwa}}_dzien" id="{{$nazwa}}_dzien" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$dzien}}" {{ if($selected,'selected="selected"') }}>{{$dzien}}</option>
	{{END}}
	</select></div>
{{END}}
<input type="hidden" id="{{$nazwa}}" name="{{$nazwa}}" value="{{$data}}" />

{{BEGIN noDatapicer}}
<script type="text/javascript">
<!--
$(document).ready(function(){

$("#{{$nazwa}}_dzien, #{{$nazwa}}_miesiac, #{{$nazwa}}_rok").change(function(){

	// sprawdzamy czy dzien miesiaca pasuje
	var ostatniMiesiaca = new Date($("#{{$nazwa}}_rok").val(), $("#{{$nazwa}}_miesiac").val(), 0);
	if ($("#{{$nazwa}}_dzien").val() > ostatniMiesiaca.getDate())
	{
		dzien = (ostatniMiesiaca.getDate() < 10) ? "0" + ostatniMiesiaca.getDate() : ostatniMiesiaca.getDate();
		$("#{{$nazwa}}_dzien option[value='" + dzien + "']").attr("selected", "selected");
	}

	$("#{{$nazwa}}").val($("#{{$nazwa}}_rok").val() + "-" + $("#{{$nazwa}}_miesiac").val() + "-" + $("#{{$nazwa}}_dzien").val());
});

});
-->
</script>
{{END}}

{{BEGIN datapicker}}
<script type="text/javascript">
<!--
$(function() {
$("#{{$nazwa}}").datepicker({
	onClose: function(dateText, inst) { {{$nazwa}}Odswierz(dateText); },
	onSelect: function(dateText, inst) { {{$nazwa}}Odswierz(dateText); {{$onchange_function}} },
	{{$datapicker_config}}
},
$.datepicker.regional['{{$kod_jezyka}}']);

var {{$nazwa}}Odswierz = function(wybranaData)
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


// kiedy select-y sa zmieniane updateujemy tez datePicker
$("#{{$nazwa}}_dzien, #{{$nazwa}}_miesiac, #{{$nazwa}}_rok").change(function(){

	// sprawdzamy czy dzien miesiaca pasuje
	var ostatniMiesiaca = new Date($("#{{$nazwa}}_rok").val(), $("#{{$nazwa}}_miesiac").val(), 0);

	if ($("#{{$nazwa}}_dzien").val() > ostatniMiesiaca.getDate())
	{
		dzien = (ostatniMiesiaca.getDate() < 10) ? "0" + ostatniMiesiaca.getDate() : ostatniMiesiaca.getDate();
		$("#{{$nazwa}}_dzien option[value='" + dzien + "']").attr("selected", "selected");
	}

	$("#{{$nazwa}}").val($("#{{$nazwa}}_rok").val() + "-" + $("#{{$nazwa}}_miesiac").val() + "-" + $("#{{$nazwa}}_dzien").val());
	{{$onchange_function}}
});

});
-->
</script>
{{END}}