	{{BEGIN index}}
	<div class="formularz_region ">
	<div class="widget-title region_tytul {{$wyswietlajRegion}}">
		<span class="icon">
		<i class="{{IF $wyswietlajRegion == 'closed'}} icon-circle-arrow-down {{ELSE}} icon-circle-arrow-up {{END}}"></i>
		</span>
		<h5>{{$tytul}}</h5>
	</div>
	<div id="{{$kod}}" class="region_tresc" {{IF $wyswietlajRegion == 'closed'}}style="display:none;"{{END}} >
	{{BEGIN nazwaWyswietlana}}
	<script>
		{{IF $aktulizujPo == 'now'}}
			$('input[name^=nazwaWyswietlana]').val({{$tekst}});
		{{ELSE}}
		$('{{$aktualizujTytul}}').on('{{$aktulizujPo}}', function(){
			$('input[name^=nazwaWyswietlana]').val({{$tekst}});
		});
		{{END}}
	</script>
	<div class="control-group input_ok">
		<label class="control-label input_ok " for="address">Name displayed : </label>
		<div class="controls">
			<input type="text" style="width: 90%;" name="nazwaWyswietlana" id="nazwaWyswietlana_{{$kod}}" data-valid="validNazwaWyswietlana_{{$kod}}" value="{{IF $typ == 'script'}}{{ELSE}}{{$tekst}}{{END}}" />
			<span class="help-inline nazwaWyswietlana_{{$kod}}" style="display:none;" >This field is required and cannot be empty</span>
		</div>
	</div>
	{{END nazwaWyswietlana}}
	{{BEGIN kolor}}
	<script type="text/javascript">
		$( ".dataStop" ).datepicker({
			});
		$( ".dataStart" ).datepicker({
			});
		function validNazwaWyswietlana_{{$kod}}()
		{
			var wartosc = $('#nazwaWyswietlana_{{$kod}}').val();
			
			if(wartosc.length > 1)
			{
				$('.nazwaWyswietlana_{{$kod}}').hide();
				return true;
			}
			else
			{
				$('.nazwaWyswietlana_{{$kod}}').show();
				return false;
			}
		}
		
		kolorPrzycisk{{$kod}}($('#kolor_{{$kod}}'), '{{$kolorDomyslny}}');
		
		$('#kolor_{{$kod}}').on('change', function(){ rozwinNastepnyRegion($(this)); } );
		
		function kolorPrzycisk{{$kod}}(obiekt, kolorDomyslny)
		{
			obiekt.val(kolorDomyslny);
			obiekt.spectrum({
				color: kolorDomyslny,
				showInput: true,
				className: "full-spectrum",
				showInitial: true,
				showPalette: true,
				showSelectionPalette: true,
				maxSelectionSize: 10,
				preferredFormat: "hex",
				localStorageKey: "spectrum.demo",

				palette: [
					 ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
					 "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
					 ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
					 "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
					 ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
					 "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
					 "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
					 "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
					 "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
					 "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
					 "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
					 "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
					 "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
					 "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
				]
		  });
		  obiekt.val(kolorDomyslny);
		}
	</script>
	
	<div class="control-group input_ok">
		<label class="control-label input_ok " for="address">Select color : </label>
			<div class="controls">
				<div class="demo2">
					<input type="text" style="width:70px;" value="" name="kolor" id="kolor_{{$kod}}" class="form-control kolor" />
					<span class="input-group-addon"><i></i></span>
				</div>
			<span class="help-block" style="display:none;" >{{$bladKolor}}</span>
		</div>
	</div>
	{{END kolor}}
	{{BEGIN komentarz}}
	<div class="control-group input_ok">
		<label class="control-label input_ok " for="address">Comment : </label>
			<div class="controls">
					<input type="text" style="width: 90%;" value="" name="komentarz" id="komentarz_{{$kod}}" />
					<span class="input-group-addon"><i></i></span>
			<span class="help-block"></span>
		</div>
	</div>
	{{END komentarz}}
	{{BEGIN dataStartStopTeam}}
	<div class="control-group input_ok">
		{{BEGIN team}}
		<label class="control-label input_ok " for="address"><span class="label label-info" style="font-size:16px;">{{$teamS}}</span></label>
			<div class="controls">
				from <input type="text" class="dataStart" name="dataStart" style="width: 20%;" data-date-format="dd-mm-yyyy" value="{{$dataStart}}" >  to <input data-date-format="dd-mm-yyyy" class="dataStart" name="dataStart" type="text" style="width: 20%;" value="{{$dataStop}}" >
			</div>
		{{END team}}
	</div>
	{{END dataStartStopTeam}}
	</div>
	</div>
	{{END index}}
	