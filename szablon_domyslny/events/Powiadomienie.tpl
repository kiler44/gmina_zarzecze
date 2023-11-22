{{BEGIN index}}
<div class="formularz_region ">
	<div class="widget-title region_tytul {{$wyswietlajRegion}}">
		<span class="icon">
		<i class="{{IF $wyswietlajRegion == 'closed'}} icon-circle-arrow-down {{ELSE}} icon-circle-arrow-up {{END}}"></i>
		</span>
		<h5>{{$tytul}}</h5>
	</div>
<div id="{{$kod}}" class="region_tresc" {{IF $wyswietlajRegion == 'closed'}}style="display:none;"{{END}} >
{{BEGIN uzytkownicySelect}}

	<script type="text/javascript">
	
	$(document).on('change', 'input[name=powiadomUzytkownikSms]' , function(e){ sprawdzEmailSmsCheck($(this), 'sms');	});
	$(document).on('change', 'input[name=powiadomUzytkownikEmail]' , function(e){ sprawdzEmailSmsCheck($(this), 'email');});
	$(document).on('click', '.uzytkownikUsun' , function(e){ $(this).parents('li').remove(); return false; } );
	
	$(document).on('keyup', '.dni_sms_val' , function(){ $(this).parents('.sms-container').find('.powiadomSmsDni').val($(this).val()); });
	$(document).on('keyup', '.dni_email_val' , function(){ $(this).parents('.email-container').find('.powiadomEmailDni').val($(this).val()); });
	
	$(document).on('change', '.kiedy_sms' , function(e){ wyswietlajDni( $(this) , 'sms' ); });
	$(document).on('change', '.kiedy_email' , function(e){ wyswietlajDni( $(this) , 'email' ); });
	
	$(document).ready(function(){
		
		$('.kiedy_sms').on( 'change', function(){ wyswietlajDni( $(this) , 'sms' ); } );
		
		$('.kiedy_email').on( 'change', function(){ wyswietlajDni( $(this), 'email' ); } );
		
		$('input[name=powiadomUzytkownikSms]').each(function()
			{ 
				sprawdzEmailSmsCheck($(this), 'sms');
			}	
		)
		$('input[name=powiadomUzytkownikEmail]').each(function()
			{ 
				sprawdzEmailSmsCheck($(this), 'email');
			}	
		)
	});
	
	function wyswietlajDni(obiekt, typ)
	{
		var uid = obiekt.attr('data-id');
		var val = obiekt.val();
		
		var wstaw = typ.charAt(0).toUpperCase() + typ.substring(1,typ.length);
		var rodzic = obiekt.parents('.'+typ+'-container');
		rodzic.find('.powiadom'+wstaw+'Kiedy').val(val);
		
		if(val == 'in_start' || val == 'in_end')
			obiekt.siblings('.dni_'+typ+'[data-id='+uid+']').hide();
		else
			obiekt.siblings('.dni_'+typ+'[data-id='+uid+']').show();
	}
	
	function sprawdzEmailSmsCheck(obiekt, typ)
	{
		var val = obiekt.val();
		if(val == '{UID}') return false;
		var rodzic = obiekt.parents('.'+typ+'-container');
		if(obiekt.is(':checked'))
		{
			rodzic.find('.kiedy_'+typ).val();
			var wstaw = typ.charAt(0).toUpperCase() + typ.substring(1,typ.length);
			rodzic.find('.powiadom'+wstaw+'IdUzytkownika').val(val);
			rodzic.find('.powiadom'+wstaw+'Kiedy').val(rodzic.find('.kiedy_'+typ).val());
			rodzic.find('.powiadom'+wstaw+'Dni').val(rodzic.find('.dni_'+typ+'_val').val());
			
			$('.'+typ+'_'+val).show();
		}
		else
		{
			var wstaw = typ.charAt(0).toUpperCase() + typ.substring(1,typ.length);
			rodzic.find('.powiadom'+wstaw+'IdUzytkownika').val('');
			rodzic.find('.powiadom'+wstaw+'Kiedy').val('');
			rodzic.find('.powiadom'+wstaw+'Dni').val('');
			$('.'+typ+'_'+val).hide();
		}

	}
	
	$('#userSelect_{{$kod}}').select2({
			placeholder: "Enter min. 3 characters",
			minimumInputLength: 3,
			ajax: {
				url: "{{$urlSearchUser}}",
				dataType: 'json',
				quietMillis: 100,
				data: function (term, page) { 
					return {
						fraza: term, 
						nrStrony: page,
						naStronie: 20,
					};
				},
				results: function (data, page) {
					var more = (page * 20) < data.total; 
					
					return {results: data.uzytkownicy, more: more};
				}
			},
			formatResult: userFormatResult_{{$kod}}, // omitted for brevity, see the source of this page
			formatSelection: userFormatSelection_{{$kod}}, // omitted for brevity, see the source of this page
			dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
			escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
		});

	function userFormatResult_{{$kod}}(uzytkownik) {
		
			var markup = "<table style='width:100%;' ><tr>";
			if(uzytkownik.zdjecie != ' ' && uzytkownik.zdjecie != null)
			{
				markup += "<td style='width:80px;'><img style=\"width:50px;\" src='"+uzytkownik.zdjecie+"' /></td>"
			}
			markup += "<td style='text-align:left;'><div >" + uzytkownik.imie +" "+uzytkownik.nazwisko+" </div></td>";
			markup += "</tr></table>";
			return markup;
		}
	function userFormatSelection_{{$kod}}(uzytkownik) {
			
				var uzytkownikElement = $('#tmpUzytkownik_{{$kod}}').html();
				var znajdz = ['{UID}', '{ZDJECIE}', '{IMIE}'];
				var zamien = [ uzytkownik.id, uzytkownik.zdjecie, uzytkownik.imie+' '+uzytkownik.nazwisko ];
				var wstaw = uzytkownikElement.replaceArray(znajdz, zamien);
				$('#userList_{{$kod}}').append(wstaw);
				$('input[name=powiadomUzytkownikEmail][value='+uzytkownik.id+']').parent('span').unwrap();
				$('input[name=powiadomUzytkownikEmail][value='+uzytkownik.id+']').uniform();
				
				$('input[name=powiadomUzytkownikSms][value='+uzytkownik.id+']').parent('span').unwrap();
				$('input[name=powiadomUzytkownikSms][value='+uzytkownik.id+']').uniform();
				
				return uzytkownik.imie+' '+' '+uzytkownik.nazwisko+' ';
			}
	</script>

	<div class="control-group input_ok" style="width:100%;">
		<label class="control-label input_ok " for="address">Send to : </label>
			<div class="controls">
				<input class="js-data-example-ajax" style="width: 50%;" name="userSelect" id="userSelect_{{$kod}}" />
				<span class="input-group-addon"><i></i></span>
				<span class="help-block"></span>
		</div>
	</div>
	<div class="control-group input_ok" style="width:100%;">
		<label class="control-label input_ok " for="address">User list : </label>
		<div class="controls">
			<ul id="userList_{{$kod}}" class="userList" >
				<div id='tmpUzytkownik_{{$kod}}' style="display:none;">
					<li  style=" width: 55%;" >
						<div>
							<div>
								<img src="{ZDJECIE}" style="width:30px;"> <strong class="nazwa">{IMIE} </strong> <button class="btn btn-danger fR uzytkownikUsun"><i class="icon icon-remove"></i></button>
							</div>
							<div style="margin-left:50px;" >
								<div class="sms-container">
									<input type="checkbox" class="no-js powiadmSms" name="powiadomUzytkownikSms"  {{IF $zaznaczPowiadomienieSms == true}} checked {{END}}  value="{UID}"  /> <label for="powiadomUzytkownikSms" style="display:inline;" >SMS</label>
									<div class="sms_{UID}" style="margin-bottom: 15px; margin-left: 50px; display: none;" >
										When :
										<select name="kiedy_sms_{UID}" class="kiedy_sms" data-id="{UID}" >
											<option {{IF $domyslnyStartSms == 'before_start'}} selected {{END}} value="before_start" >Before start</option>
											<option {{IF $domyslnyStartSms == 'in_start'}} selected {{END}} value="in_start" >Start</option>
											<option {{IF $domyslnyStartSms == 'after_start'}} selected {{END}} value="after_start" >After start</option>
											<option {{IF $domyslnyStartSms == 'before_end'}} selected {{END}} value="before_end" >Before end</option>
											<option {{IF $domyslnyStartSms == 'in_end'}} selected {{END}} value="in_end" >End</option>
											<option {{IF $domyslnyStartSms == 'after_end'}} selected {{END}} value="after_end" >After end</option>
										</select>
										<span data-id="{UID}" class="dni_sms">
											day : 
											<input type="text" class="dni_sms_val" data-id="{UID}" name="dni_sms_{UID}" style="width: 20%;" />
										</span>
									</div>
									<input type="hidden" class="powiadomSmsIdUzytkownika" name="powiadomSmsIdUzytkownika" value="" />
									<input type="hidden" class="powiadomSmsKiedy" name="powiadomSmsKiedy" value="" />
									<input type="hidden" class="powiadomSmsDni" name="powiadomSmsDni" value="" />
								</div>
								<div class="email-container">
									<div>
										<input type="checkbox" class="no-js powiadmEmail" name="powiadomUzytkownikEmail" {{IF $zaznaczPowiadomienieEmail == true}} checked {{END}} value="{UID}"  /> <label  style="display:inline;" >E-mail</label>
										<div class="email_{UID}" style="margin-bottom: 15px; margin-left: 50px; display: none;" >
											When : 
											<select name="kiedy_email_{UID}" class="kiedy_email" data-id="{UID}">
												<option {{IF $domyslnyStartSms == 'before_start'}} selected {{END}} value="before_start" >Before start</option>
												<option {{IF $domyslnyStartSms == 'in_start'}} selected {{END}} value="in_start" >Start</option>
												<option {{IF $domyslnyStartSms == 'after_start'}} selected {{END}} value="after_start" >After start</option>
												<option {{IF $domyslnyStartSms == 'before_end'}} selected {{END}} value="before_end" >Before end</option>
												<option {{IF $domyslnyStartSms == 'in_end'}} selected {{END}} value="in_end" >End</option>
												<option {{IF $domyslnyStartSms == 'after_end'}} selected {{END}} value="after_end" >After end</option>
											</select>
											<span data-id="{UID}" class="dni_email">
												day : 
												<input type="text" class="dni_email_val" name="dni_email_{UID}" data-id="{UID}" style="width: 50px;" />
											</span>
										</div>
									</div>
									<input type="hidden" class="powiadomEmailIdUzytkownika" name="powiadomEmailIdUzytkownika" value="" />
									<input type="hidden" class="powiadomEmailKiedy" name="powiadomEmailKiedy" value="" />
									<input type="hidden" class="powiadomEmailDni" name="powiadomEmailDni" value="" />
								</div>
							</div>
						</div>
					</li>
				</div>
				
				{{BEGIN uzytkownikPowiadom}}
				<li style="width:55%;">
					<div>
						<div>
							<img src="{{$zdjecie}}" style="width:30px;"> <strong class="nazwa">{{$imie}} </strong> <button class="btn btn-danger fR uzytkownikUsun"><i class="icon icon-remove"></i></button>
						</div>
						<div style="margin-left:50px;" >
							<div class="sms-container">
								<input type="checkbox" name="powiadomUzytkownikSms"  {{IF $zaznaczPowiadomienieSms == true}} checked {{END}}  value="{{$uId}}"  /> <label for="powiadomUzytkownikSms" style="display:inline;" >SMS</label>
								<div class="sms_{{$uId}}" style="margin-bottom: 15px; margin-left: 50px; display: none;" >
									When : {{$domyslnyStartSms}}
									<select name="kiedy_sms_{{$uId}}" class="kiedy_sms" data-id="{{$uId}}" >
										<option {{IF $domyslnyStartSms == 'before_start'}} selected {{END}} value="before_start" >Before start</option>
										<option {{IF $domyslnyStartSms == 'in_start'}} selected {{END}} value="in_start" >Start</option>
										<option {{IF $domyslnyStartSms == 'after_start'}} selected {{END}} value="after_start" >After start</option>
										<option {{IF $domyslnyStartSms == 'before_end'}} selected {{END}} value="before_end" >Before end</option>
										<option {{IF $domyslnyStartSms == 'in_end'}} selected {{END}} value="in_end" >End</option>
										<option {{IF $domyslnyStartSms == 'after_end'}} selected {{END}} value="after_end" >After end</option>
									</select>
									<span data-id="{{$uId}}" class="dni_sms">
										day : 
										<input type="text" data-id="{{$uId}}" class="dni_sms_val" name="dni_sms_{{$uId}}" value='{{$dniSms}}' style="width: 50px;" />
									</span>
								</div>
								<input type="hidden" class="powiadomSmsIdUzytkownika" name="powiadomSmsIdUzytkownika" value="{{$uId}}" />
								<input type="hidden" class="powiadomSmsKiedy" name="powiadomSmsKiedy" value="{{$domyslnyStartSms}}" />
								<input type="hidden" class="powiadomSmsDni" name="powiadomSmsDni" value="{{$dniSms}}" />
							</div>
							<div class="email-container">
								<div>
									<input type="checkbox" name="powiadomUzytkownikEmail" {{IF $zaznaczPowiadomienieEmail == true}} checked {{END}} value="{{$uId}}"  /> <label for="powiadomUzytkownikEmail" style="display:inline;" >E-mail</label>
									<div class="email_{{$uId}}" style="margin-bottom: 15px; margin-left: 50px; display: none;" >
										When : {{$domyslnyStartEmail}}
										<select name="kiedy_email_{{$uId}}" class="kiedy_email" data-id="{{$uId}}">
											<option {{IF $domyslnyStartEmail == 'before_start'}} selected {{END}} value="before_start" >Before start</option>
											<option {{IF $domyslnyStartEmail == 'in_start'}} selected {{END}} value="in_start" >Start</option>
											<option {{IF $domyslnyStartEmail == 'after_start'}} selected {{END}} value="after_start" >After start</option>
											<option {{IF $domyslnyStartEmail == 'before_end'}} selected {{END}} value="before_end" >Before end</option>
											<option {{IF $domyslnyStartEmail == 'in_end'}} selected {{END}} value="in_end" >End</option>
											<option {{IF $domyslnyStartEmail == 'after_end'}} selected {{END}} value="after_end" >After end</option>
										</select>
										<span data-id="{{$uId}}" class="dni_email">
											day : 
											<input type="text" class="dni_email_val" name="dni_email_{{$uId}}" data-id="{{$uid}}" value='{{$dniEmail}}' style="width: 50px;" />
										</span>
									</div>
									<input type="hidden" class="powiadomEmailIdUzytkownika" name="powiadomEmailIdUzytkownika" value="{{$uId}}" />
									<input type="hidden" class="powiadomEmailKiedy" name="powiadomEmailKiedy" value="{{$domyslnyStartEmail}}" />
									<input type="hidden" class="powiadomEmailDni" name="powiadomEmailDni" value="{{$dniEmail}}" />
								</div>
							</div>
						</div>
					</div>
				</li>
				{{END uzytkownikPowiadom}}
			</ul>
		</div>
	</div>
{{END}}
</div>
</div>
{{END index}}