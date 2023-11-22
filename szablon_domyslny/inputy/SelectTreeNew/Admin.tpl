<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}}/>
<script type="text/javascript">
<!--
	var drzewo = { {{$drzewo}} };
	$("input[name='{{$nazwa}}']").optionTree(drzewo, {{$parametry_cfg}});
	
	
	$(document).live('ready', function(){
		$("select[name^='{{$nazwa}}']").select2();
	});
	$('select').live('change', function(){
		$(".select2-container").remove();
		$('select').select2();
	});
	
-->
</script>