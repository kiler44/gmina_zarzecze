<div class="input-append">
	<input type="text" name="{{$nazwa}}" value="{{$wartosc}}" id="{{$nazwa}}" title="dd-mm-yyyy" data-date-format="{{$format_daty}}" {{$atrybuty}}/>
	<span class="add-on"><i class="icon-calendar"></i></span>
</div>
	{{BEGIN aktywacja}}
	<script type="text/javascript">

		$(document).ready(function(){
			$( "#{{$nazwa}}" ).datepicker({
				weekStart: 1,
				{{$datepicker_cfg}}
			}).on('changeDate', function(ev){
									$("#{{$nazwa}}").change();
							});
		});

	</script>
	{{END}}