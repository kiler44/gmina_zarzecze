<input type="button" id="__{{$nazwa}}" name="__{{$nazwa}}" onclick="{{$nazwa}}_czysc(this)" value="{{$wartosc_poczatkowa}}" class="btn" {{$atrybuty}} />
<script type="text/javascript">
<!--
function {{$nazwa}}_czysc(element) {
	if ($('input[name="{{$nazwa}}"]').size() < 1)
		$(element).after('<input type="hidden" name="{{$nazwa}}" value="{{$nazwa}}"/>');
	element.form.submit();
}
-->
</script>