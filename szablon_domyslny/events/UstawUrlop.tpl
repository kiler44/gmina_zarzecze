	{{BEGIN index}}
	<script>
		$(document).ready(function(){
			$('input[name=rodzajDniWolnych]').uniform();
			$('input[name=rodzajDniWolnych]').on('change', function(){ 
				
				if($(this).val() == 'sickDay')
				{
					$('#hourPerDay').show();
				}
				else
				{
					$('#hourPerDay').hide();
				}
				$('#nazwaWyswietlana_Dayoff_1').val($(this).attr('data-tekst'));
			})
		});
	</script>
	<div class="formularz_region ">
		<div class="widget-title region_tytul {{$wyswietlajRegion}}">
			<span class="icon">
			<i class="{{IF $wyswietlajRegion == 'closed'}} icon-circle-arrow-down {{ELSE}} icon-circle-arrow-up {{END}}"></i>
			</span>
			<h5>{{$tytul}}</h5>
		</div>
		<div id="{{$kod}}" class="region_tresc" {{IF $wyswietlajRegion == 'closed'}}style="display:none;"{{END}} >
			<div class="control-group input_ok">
				<table class="userDayOff" >
					<tr>
						{{BEGIN uzytkownik}}
						<td valign="top">
							<div class="dayOff">
								<div style="min-height:170px;">
									<img class="tip top imgDayOff" data-original-title="{{$imie}} {{$nazwisko}}" alt="{{$imie}} {{$nazwisko}}" src="{{$zdjecie}}"/>
								</div>
								{{BEGIN dataStartStop}}
								<i class="icon icon-calendar"></i> Date start : <strong>{{$dataStart}}</strong> <br/>
								<i class="icon icon-calendar"></i> Date stop : <strong>{{$dataStop}}</strong> <br/>
								<hr/>
								{{END}}
								{{BEGIN sumaDni}}
								<div style="border-top:1px solid #FFA44A;">
									Amount day :  <strong>{{$sumaDni}}</strong>
								</div>
								{{END}}
							</div>
						</td>
						{{END}}
					</tr>
				</table>
			</div>
			<div style="margin:0 auto; width: 100px;">
				<div class="control-group input_ok">
						<label>
							<input type="radio" name="rodzajDniWolnych" value="dayOff" checked data-tekst="Day Off: {USER_NAME}" > Day Off
						</label>
						<label>
							<input type="radio" name="rodzajDniWolnych" value="sickDay" data-tekst="Sick Day: {USER_NAME}"> Sick day
						</label>
				</div>
				<div class="control-group input_ok" style="display: none;" id="hourPerDay" >
					<label>Hour per day : </label> 
					<input  type="number" required = "required" name="hourPerDay" value="7.5"  />
				</div>
			</div>
		</div>
	</div>
	{{END index}}
	