<div id="{{$nazwa}}" {{$atrybuty}}>
<div class="control-group input_ok" >
	<label class="control-label input_ok " for="kategoria">{{$etykieta_rabat_rodzaj}} </label>
	<div class="controls" style="margin-left:200px;" >
		<label for="{{$nazwa}}_rabat_rodzaj" style="display: inline; margin-right: 30px">
			<input type="radio" name="{{$nazwa}}_rabat_rodzaj"  value="procentowy" class="noinput" checked="checked"  /> {{$etykieta_rabat_rodzaj_procentowy}}
		</label>
		<label for="{{$nazwa}}_rabat_rodzaj" style="display: inline; margin-right: 30px">
			<input type="radio" name="{{$nazwa}}_rabat_rodzaj" value="kwotowy" class="noinput"  /> {{$etykieta_rabat_rodzaj_kwotowy}}
		</label>
	</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="kategoria">{{$etykieta_rabat_na_calosc}}</label>
	<div class="controls" style="margin-left:200px;" >
		<input type="text" name="{{$nazwa}}_rabat_na_calosc"  style="width:80px;" /> <span class="rabat_znaczek">{{$etykieta_procent}}</span>
	</div>
</div>

<div class="control-group input_ok">
	<div class="controls">
		<ul id="produkty_rabat" style="list-style: decimal;">
			{{BEGIN produkt_dodany}}
				<li class="item item_szeroki" id="id_{{$wartosc_id}}"  >
					<span class="prd_projekt" >{{$wartosc_nazwa}} </span>
					<input type="hidden" name="nazwa[]" value="{{$wartosc_nazwa}}" />
					<input type="hidden" name="id[]" value="{{$wartosc_id}}" />
					{{$waluta}}<span style="width:80px;"><input type="text" style="width:80px;" readonly="readonly" name="{{$nazwa}}_cena[]" class="{{$nazwa}}_cena" value="{{$wartosc_cena}}" /></span>
					{{$etykieta_discount}}
					<span class="qty qty_projekt" style="margin-right:0px;">
						 <input type="text" class="{{$nazwa}}_rabat" name="{{$nazwa}}_rabat[]" value="0" />
					</span> <span class="rabat_znaczek">{{$etykieta_procent}}</span>
					{{$etykieta_total}}
					<span class="qty qty_projekt">
						 <input type="text" readonly="readonly" class="{{$nazwa}}_kwota_po_rabacie" name="{{$nazwa}}_kwota_po_rabacie[]" value="{{$wartosc_cena}}" />
					</span>
				</li>
			{{END}}
		</ul>
	</div>
</div>
<ul class="podsumowanie_rabat">
	<li class="podsumowanie_rabat_projekt" >
		{{$etykieta_total_sum}} 
		<span class="suma">
		<i class="icon icon-arrow-up"></i>
		<var id="suma_po_rabacie" ></var>
		</span>	
		{{$waluta}}	
	</li>
</ul>
</div>
<script>
	var wierszPatern = '<li class="item item_szeroki" id="id_{ID}"  >\n\
								<span class="prd_projekt" >{NAZWA} </span>\n\
								<input type="hidden" name="nazwa[]" value="{NAZWA}" />\n\
					<input type="hidden" name="id[]" value="{ID}" />\n\
					{{$waluta}}<span style="width:80px;"><input type="text" style="width:80px;" readonly="readonly" name="{{$nazwa}}_cena[]" class="{{$nazwa}}_cena" value="{CENA}" /></span>\n\
					{{$etykieta_discount}}\n\
					<span class="qty qty_projekt" style="margin-right:0px;">\n\
						 <input type="text" class="{{$nazwa}}_rabat" name="{{$nazwa}}_rabat[]" value="0" />\n\
					</span> <span class="rabat_znaczek">{{$etykieta_procent}}</span>\n\
					{{$etykieta_total}}\n\
					<span class="qty qty_projekt">\n\
						 <input type="text" readonly="readonly" class="{{$nazwa}}_kwota_po_rabacie" name="{{$nazwa}}_kwota_po_rabacie[]" value="{CENA}" />\n\
					</span>\n\
				</li>';
	var rodzaj_rabatu = 'procentowy'
	$(document).ready(function(){
		
		liczSumaPoRabacie();
		
		$(document).on('click',"input[name={{$nazwa}}_rabat_rodzaj]", function (e) { sprawdzRodzajRabatu(); });
		$(document).on('keyup',"input[name={{$nazwa}}_rabat_na_calosc]", function (e) { aktualizujRabatNaCalosc(); });
		$(document).on('keyup',".{{$nazwa}}_rabat", function (e) { aktualizujKwotaPoRabacie($(this)); });
		
	});
	
	function liczSumaPoRabacie()
	{
		var suma_kwota = 0;
		$('.{{$nazwa}}_kwota_po_rabacie').each(function(){
			suma_kwota = suma_kwota + parseFloat($(this).val());
		});
		$('#suma_po_rabacie').html(number_format(suma_kwota, 2, ',', ' '));
	}
	
	function sprawdzRodzajRabatu()
	{
		rodzaj_rabatu = $('input[name={{$nazwa}}_rabat_rodzaj]:checked').val();
		if(rodzaj_rabatu == 'procentowy')
		{
			$('.rabat_znaczek').text("{{$etykieta_procent}}");
		}
		else
		{
			$('.rabat_znaczek').text("{{$waluta}}");
		}
		$('.{{$nazwa}}_rabat').each(function(){
			$(this).keyup();
		})
	}
	
	function aktualizujRabatNaCalosc()
	{
		var obiekt = $('input[name={{$nazwa}}_rabat_na_calosc]');
		obiekt.val(obiekt.val().replace(/[^\d\.\-]/g,''));
		var rabat = obiekt.val();
		$('.{{$nazwa}}_rabat').val(rabat);
		$('.{{$nazwa}}_rabat').keyup();
	}
	
	function aktualizujKwotaPoRabacie(obiekt)
	{
		obiekt.val(obiekt.val().replace(/[^\d\.\-]/g,''));
		
		var rabat = obiekt.val();
		var kwota = parseFloat(obiekt.parents('li').find('.{{$nazwa}}_cena').val().replace(' ', ''));
		
		if(rodzaj_rabatu == 'procentowy' && rabat > 100)
		{
			rabat = 100;
			obiekt.val(100);
		}
		else if(rodzaj_rabatu == 'kwotowy' && rabat > kwota)
		{
			rabat = kwota;
			obiekt.val(kwota);
		}
		
		obiekt.parents('li').find('.{{$nazwa}}_kwota_po_rabacie').val(liczKwotaPoRabacie(rabat, kwota));
		liczSumaPoRabacie();
	}
	
	function liczKwotaPoRabacie(rabat, kwota)
	{
		if(rodzaj_rabatu == 'procentowy')
		{
			return (kwota - (kwota * rabat/100));
		}
		else
		{
			return (kwota - rabat);
		}
	}
	
</script>
