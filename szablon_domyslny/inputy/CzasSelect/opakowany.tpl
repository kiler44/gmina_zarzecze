{{BEGIN selectGodzina}}
	<div class="input input2"><select name="{{$nazwa}}_godzina" id="{{$nazwa}}_godzina" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$godzina}}" {{ if($selected,'selected="selected"') }}>{{$godzina}}</option>
	{{END}}
	</select></div><span> : </span>
{{END}}

{{BEGIN selectMinuta}}
	<div class="input input2"><select name="{{$nazwa}}_minuta" id="{{$nazwa}}_minuta" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$minuta}}" {{ if($selected,'selected="selected"') }}>{{$minuta}}</option>
	{{END}}
	</select></div>
{{END}}

<input type="hidden" id="{{$nazwa}}" name="{{$nazwa}}" value="{{$data}}" />

<script type="text/javascript">
<!--
$(function() {
	function odswiez()
	{
		var czas;

		if($("#{{$nazwa}}_godzina").val() != ""
		   && $("#{{$nazwa}}_minuta").val() != "")
		{
			czas = $("#{{$nazwa}}_godzina").val() + ":" + $("#{{$nazwa}}_minuta").val() + ":00";
		}
		else
		{
			czas = "";
		}
		
		$("#{{$nazwa}}").val(czas);
	}

	// kiedy select-y sa zmieniane updateujemy tez datePicker
	$("#{{$nazwa}}_godzina, #{{$nazwa}}_minuta").change(function(){
		odswiez();
	});
});
-->
</script>