{{BEGIN komunikat}}
<div class="komunikat_{{typ}}">
	<span class="komunikat_tresc">{{$tresc}}</span>
</div>
{{END}}

{{BEGIN index}}
<script>
function zalogujObecnosc()
{
	$.ajax({
		type: "POST",
		url: "{{$urlLogowanie}}",
		data: {}
	});
}

$(document).ready(function() {
	zalogujObecnosc();

	setInterval(function() {
		zalogujObecnosc();
	}, {{$interwal}});
});
</script>
{{END}}