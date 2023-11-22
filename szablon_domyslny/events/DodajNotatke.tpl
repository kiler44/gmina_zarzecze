{{BEGIN index}}
<script>
	$('#trescNotatki_{{$kod}}').on('keyup', function(){
		var w = $(this).val();
		if(w.length > 2)
			rozwinNastepnyRegion($(this))
		
		
	});
	function validOrderNumber()
	{
		var wartosc = $('#orderNumber_{{$kod}}').val();
		if(wartosc.length > 5)
		{
			$('.orderNumber_{{$kod}}').hide();
			return true;
		}
		else
		{
			$('.orderNumber_{{$kod}}').show();
			return false;
		}
	}
	function validTrescNotatki()
	{
		var wartosc = $('#trescNotatki_{{$kod}}').val();
		if(wartosc.length > 5)
		{
			$('.trescNotatki_{{$kod}}').hide();
			return true;
		}
		else
		{
			$('.trescNotatki_{{$kod}}').show();
			return false;
		}
	}
</script>
<div class="formularz_region ">
	<div class="widget-title region_tytul {{$wyswietlajRegion}}">
		<span class="icon">
		<i class="{{IF $wyswietlajRegion == 'closed'}} icon-circle-arrow-down {{ELSE}} icon-circle-arrow-up {{END}}"></i>
		</span>
		<h5>{{$tytul}}</h5>
	</div>
	<div id="{{$kod}}" class="region_tresc" {{IF $wyswietlajRegion == 'closed'}}style="display:none;"{{END}} >
	{{BEGIN dodajNotatke}}
	{{$trescNotatki}}
	<div class="control-group input_ok" style="width:100%;">
		<label class="control-label input_ok " for="address">Add note : </label>
			<div class="controls">
				<textarea class="js-data-example-ajax" style="width: 90%;" name="trescNotatki" data-valid="validTrescNotatki" id="trescNotatki_{{$kod}}" ></textarea>
				<span class="help-inline trescNotatki_{{$kod}}"></span>
		</div>
	</div>
	{{END dodajNotatke}}
	{{BEGIN dodajDoBefaring}}
	<div class="control-group input_ok" style="width:100%;">
		<label class="control-label input_ok " for="address">Order number : </label>
			<div class="controls">
				<input type="text" class="js-data-example-ajax" data-valid="validOrderNumber" style="width: 90%;" name="orderNumber" id="orderNumber_{{$kod}}" ></textarea>
				<span class="help-inline orderNumber_{{$kod}}">This field is required and cannot be empty</span>
		</div>
	</div>
	{{END}}
	</div>
</div>
{{END index}}