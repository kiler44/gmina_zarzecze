<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" value="1" >
<div class="prd_dodane ">
<ul class="kreditnota">
{{BEGIN produkt_dodany}}
	<li class="item"  >
		<span class="prd_projekt" >{{$wartosc_nazwa}} </span>
		
		{{$waluta}} <span class="cena procent" style="width:80px;"><input disabled="disabled" type="text" name="{{$nazwa}}_cena[]" class="{{$nazwa}}_ceny" id="cenaFaktura_{{$wartosc_id}}" value="{{$wartosc_cena}}" /></span>
		{{IF $wyswietlaj_ilosc == true}}
		{{$etykieta_ilosc}}
			<span class="qty_kreditnota">
				<input type="text" id="spinId_{{$wartosc_id}}" class="ilosc" name="{{$nazwa}}_ilosc[]" max="{{$ilosc}}" value="{{$ilosc}}" />
			</span>
			<input type="hidden" name="{{$nazwa}}_procent[]" value="{{$wartosc_procent}}" />
		{{ELSE}}
		{{$etykieta_procent}}
			<span class="qty_kreditnota">
			<input type="text" id="spinId_{{$wartosc_id}}" readonly="readonly" class="procent" name="{{$nazwa}}_procent[]" value="{{$wartosc_procent}}" />
			</span>
			<input type="hidden" name="{{$nazwa}}_ilosc[]" value="{{$ilosc}}" />
		{{END}}
		
		<span class="cena procent" style="width:180px; float: right;">
			{{IF $wyswietlaj_zmniejszkwote}}
			<div class="control-label input_ok" style="width: 110px; padding: 0px; line-height: 18px; text-align: right;" > {{$etykieta_zmniesz_kwote}} </div>
			<input type="checkbox" class="zmnieszkwote" value="1" name="{{$nazwa}}_zmniejszkwote_{{$wartosc_id}}"  />
			{{END}}
		</span>
		
		{{IF $wyswietlaj_ilosc == true}}
		<span class="cena procent" style="width:100px;">
		{{$etykieta_razy}} <input type="text" id="sztuka_{{$wartosc_id}}" readonly="readonly" name="{{$nazwa}}_wartosc_sztuka[]" value="{{$wartosc_sztuka}}">
		</span>
		{{ELSE}}
			<input type="hidden" name="{{$nazwa}}_wartosc_sztuka[]" value="{{$wartosc_sztuka}}">
		{{END}}
		<span class="cena procent" style="position: absolute; right: 185px; width: 110px;">
			{{$waluta}} {{$etykieta_minus}} <input type="text" {{IF $ilosc > 1}}readonly="readonly"{{END}} name="{{$nazwa}}_wartosc_kreditnota[]" id="cenaKreditnota_{{$wartosc_id}}" class="{{$nazwa}}_ceny_kreditnota" value="{{$wartosc_kreditnota}}" />
		</span>
		<input type="hidden" class="hiddenId" name="{{$nazwa}}_id[]" value="{{$wartosc_id}}"/>
		<input type="hidden" class="hiddenNazwa" name="{{$nazwa}}_nazwa[]" value="{{$wartosc_nazwa}}"/>
		<!-- <input type="hidden" class="hiddenQty" name="{{$nazwa}}_qty[]" value="{{$ilosc}}"/> -->
		<input type="hidden" class="hiddenQty" name="{{$nazwa}}_kategoria[]" value="{{$kategoria}}"/>
		<input type="hidden" class="hiddenQty" name="{{$nazwa}}_wyswietlaj_ilosc[]" value="{{$wyswietlaj_ilosc}}"/>
		
	</li>
{{END}}
</ul>
</div>
<ul class="podsumowanie_produkty" >
	<li class="podsumowanie_produkty_projekt" >
		<span class="podsumowanie_tekst">{{$etykieta_kwota}} {{$etykieta_waluta}}  {{$etykieta_minus}}<span id="suma">0</span>{{$etykieta_kwota_znaczek}}</span>
	</li>
</ul>

<script type="text/javascript">
	$(document).ready(function(){
		liczBudget();
		{{BEGIN produkt_dodany}}
				{{IF $wyswietlaj_ilosc == true}}
				$("#spinId_{{$wartosc_id}}").spinner({
					min: 0,
					max: {{$ilosc}},
					step: 1, 
				});
				{{ELSE}}
				$("#spinId_{{$wartosc_id}}").spinner({
					min: 0,
					max: {{$wartosc_procent}},
					step: {{$procent_skok}} 
				});
				{{END}}
		{{END}}
		
		
		setTimeout(function(){
			$("#{{$nazwa}}_container").children('div').animate({width: "92%"}, 500);
		}, 100);
	});
	
	$('.ilosc').live('keyup', function(){
		
		if($(this).val() == "") $(this).val(0);
		
		var id = $(this).attr('id').replace('spinId_', '');	
		$(this).val(parseInt($(this).val()));

		liczKwota( $(this).val(), id, $(this).siblings('.procent') );
		
		if( parseInt($(this).val()) > parseInt($(this).attr('max')) )
		{
			$(this).val($(this).attr('max'));
			liczKwota( $(this).val(), id, $(this).siblings('.procent') );
		}
	});
	
	$(".qty_kreditnota .ui-spinner-button").live('click', function(){
		var ilosc = $(this).siblings('.ilosc').val();
		if(ilosc >= 0)
		{
			var id = $(this).siblings('.ilosc').attr('id').replace('spinId_', '');
			var cena_sztuka = $('#sztuka_'+id).val();
			var wartosc_kreditnota = ilosc * cena_sztuka;
			$('#cenaKreditnota_'+id).val(wartosc_kreditnota);
		}
		else
		{
			var procent = $(this).siblings('.procent');
			var procent_wartosc = procent.val();
			var id = procent.attr('id').replace('spinId_', '');
			var cena_faktura = $('#cenaFaktura_'+id).val();
			var kreditnota = $('#cenaKreditnota_'+id);

			var wartosc_kreditnota = cena_faktura * (procent_wartosc/100);
			kreditnota.val(wartosc_kreditnota);
		}
		
		liczBudget();
	});
	
	$('.{{$nazwa}}_ceny_kreditnota').live('keyup', function(){

		var wartosc_kreditnota = $(this).val().replace(',', '.').replace(' ', '');
		var id = $(this).attr('id').replace('cenaKreditnota_', '');
		var cena_faktura = $('#cenaFaktura_'+id).val();
		
		var wartosc_procent = (wartosc_kreditnota/cena_faktura) * 100;
		$('#spinId_'+id).val(wartosc_procent.toFixed(2));
		liczBudget();
	});
	
	 
	function liczKwota(ilosc, id, procent)
	{
		
		if(ilosc >= 0)
		{
			//var id = $(this).siblings('.ilosc').attr('id').replace('spinId_', '');
			var cena_sztuka = $('#sztuka_'+id).val();
			var wartosc_kreditnota = ilosc * cena_sztuka;
			$('#cenaKreditnota_'+id).val(wartosc_kreditnota);
		}
		else
		{
			//var procent = $(this).siblings('.procent');
			var procent_wartosc = procent.val();
			var id = procent.attr('id').replace('spinId_', '');
			var cena_faktura = $('#cenaFaktura_'+id).val();
			var kreditnota = $('#cenaKreditnota_'+id);

			var wartosc_kreditnota = cena_faktura * (procent_wartosc/100);
			kreditnota.val(wartosc_kreditnota);
		}
		
		liczBudget();
	}
	function liczBudget()
	{
		var budget = 0;
		
		$('.{{$nazwa}}_ceny_kreditnota').each(function(){
						budget += parseFloat($(this).val());
					}
			);
		
		$('#budget').val(budget);
		$('#suma').text(number_format(budget, 0, ',', ' '));
	}
</script>