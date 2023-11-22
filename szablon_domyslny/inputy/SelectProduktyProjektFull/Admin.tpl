<div class="select_wrap select2 products productsFull{{UNLESS $wyswietla_edytuj_procent}} bezProcentow{{END IF}}" {{IF $zabron_dodaj_produkt}} style="display: none;" {{END}}>
	<p class="niestandardowe_projekt">
		<span id="{{$nazwa}}_container" class="select">
			<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}} >
		</span>
	{{$etykieta_kategorie}}
	<span class="cena catKontener">
		<select name="{{$nazwa}}_kategoria" id="{{$nazwa}}_kategoria">
			{{BEGIN kategorie}}
				<option value="{{$wartosc}}"  >{{$etykieta}}</option>
			{{END}}
		</select>
	</span>
	{{$ilosc}} <span class="cena qty_full"> <input type="text" class="qty_add quantity" name="{{$nazwa}}_qty_add" value="1" id="{{$nazwa}}_qty_add"/></span>
	{{$waluta}} <span class="cena"> <input type="text" class="cena_add price" name="{{$nazwa}}_cena_add" value="0" id="{{$nazwa}}_cena_add" /></span>
	<label class="etykieta">{{$kwota}} <input type="text" class="sum_price cena_add" name="{{$nazwa}}_kwota_add" value="" id="{{$nazwa}}_kwota_add" readonly="readonly"/></label>
	<label class="etykieta" style="display: {{IF $wyswietlaj_vat}} inline {{ELSE}}none{{END}}"> {{$etykieta_vat}} <input type="text" class="vat_add" name="{{$nazwa}}_vat_add" value="{{$domyslna_wartosc_vat}}" id="{{$nazwa}}_vat_add" /></label>
	<a href="javascript:void(0);" id="add_niestandardowy" class="btn btn-success add_button"><i class="icon icon-plus"></i> {{$etykieta_dodaj}}</a>
	</p>
</div>
<div class="prd_dodane productsFull{{IF $zabron_dodaj_produkt}} dodane_projekt{{END}}{{UNLESS $wyswietla_edytuj_procent}} bezProcentow{{END IF}}">
<ul class="nst">
{{BEGIN produkt_dodany}}
	<li class="item item_szeroki"  >
		<span class="prd_projekt" >{{$wartosc_nazwa}}</span>
		{{$etykieta_kategorie}}
		<span class="cena catKontener">
		{{IF $zabron_edycji_kategorii}}
			<!-- <input type="text" class="readonly" name="{{$nazwa}}_category[]" readonly="readonly" id="{{$nazwa}}_kategoria" value="{{$wartosc_kategoria}}" /> -->
			<select name="{{$nazwa}}_kategoria[]" id="{{$nazwa}}_category_{{$i}}" readonly="readonly" class="produkt_kategoria">
			</select>
		{{ELSE}}
			<select name="{{$nazwa}}_kategoria[]" id="{{$nazwa}}_category_{{$i}}" class="produkt_kategoria">
			</select>
		{{END IF}}
		</span>
		{{$ilosc}} <span class="cena qty_full{{IF $zabron_edycji_ilosci}} noEdit{{END IF}}"> <input type="text" class="qty_add quantity" name="{{$nazwa}}_ilosc[]" value="{{$wartosc_ilosc}}" readonly="readonly"/></span>
		{{$waluta}} <span class="cena"><input type="text" {{IF $zabron_edycji_ceny}} readonly="readonly" {{END}} name="{{$nazwa}}_cena[]" class="produkty_ceny ceny price" value="{{$wartosc_cena}}" /></span>
		<p class="kwota_kontener">
			{{UNLESS $zabron_edycji_ilosci}}<label class="etykieta">{{$kwota}} <input type="text" class="sum_price cena_add" readonly="readonly" value="{{$wartosc_kwota}}"/></label>{{END IF}}
			{{IF $wyswietla_edytuj_procent}}<label class="etykieta procent"><span class="etykieta_procent"> {{$etykieta_procent}}</span> <input type="text" class="procent_wykonania" name="{{$nazwa}}_procent_wykonania[]" value="{{$wartosc_procent}}" /> <var class="info"></var></label>
			<label class="etykieta total">{{$kwota_total}} <input type="text" readonly="readonly" class="sum_total_price" value="{{$wartosc_kwota_total}}" /></label>{{END IF}}
			<label class="etykieta" style="display: {{IF $wyswietlaj_vat}} inline {{ELSE}}none{{END}}"> {{$etykieta_vat}} <input type="text" class="vat" name="{{$nazwa}}_vat[]" value="{{$wartosc_vat}}" readonly="readonly" /></label>
		</p>
		
		{{IF $zabron_usun == 'false' }}
			<button class="btn btn-danger remove_n"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button>
		{{END}}
		<input type="hidden" class="hiddenId" name="{{$nazwa}}_id[]" value="{{$wartosc_id}}"/>
		<input type="hidden" class="hiddenNazwa" name="{{$nazwa}}_nazwa[]" value="{{$wartosc_nazwa}}"/>
		<input type="hidden" name="{{$nazwa}}_procent_wykonania[]" value="{{$wartosc_procent}}"/>
		<input type="hidden" class="hiddenProcentPoczatkowy" name="{{$nazwa}}_procent_poczatkowy[]" value="{{$wartosc_procent}}"/>
		<input type="hidden" class="hiddenCenaTmp" name="{{$nazwa}}_cena_tmp[]" value="{{$wartosc_kwota_total}}" />
	</li>
{{END}}
</ul>
</div>
<ul class="podsumowanie_produkty" >
	<li class="podsumowanie_produkty_projekt" >
		<span class="podsumowanie_tekst">{{$etykieta_kwota}} {{$etykieta_waluta}} {{IF $wyswietla_edytuj_procent}}{{IF $zabron_dodaj_produkt}}<span id="dodatkowo" style="display: none"><i class="icon icon-arrow-up"></i> <var id="dodatkowoWartosc"></var></span> {{END IF}}<span id="wyslano">0,00</span> (<var id="procent">0,0</var>%) / {{END IF}}<span id="suma_total">{{$suma_total}}</span>{{$etykieta_kwota_znaczek}}</span>
	</li>
</ul>

<script type="text/javascript">
	
	var tags = Array();
	{{BEGIN wiersz}}
		tags['{{$wartosc}}'] = {id: {{$wartosc}}, text: '{{$etykieta}}', multiplied: '{{$multiple}}', cena: '{{$cena}}', zabron_edycji_ceny : {{$zabron_edycji_ceny}}};
	{{END}}
	
	$(window).resize(function(){
		//przeskalujInput();
	});
	$(document).ready(function(){
		//przeskalujInput();
		$('.qty_add').spinner({
			min: 1,
			{{IF $zabron_edycji_ilosci}}
			disabled: true
			{{END IF}}
		});
		
		$('.productsFull .item').each(function(){
			var ilosc = $(this).find('.quantity').val();
			if (ilosc > 1) // Ilosciowo
			{
				//console.log($(this).find('.procent_wykonania').val());
				$(this).find('.procent_wykonania').spinner({
					min: $(this).find('.procent_wykonania').val(),
					max: $(this).find('.quantity').val(),
					step: 1
				});
			}
			else // Procentowo
			{
				$(this).find('.procent_wykonania').spinner({
					min: $(this).find('.procent_wykonania').val(),
					max: 100,
					step: {{$procent_skok}}
				});
			}
		});
		
		var opcjeSelect = $("#{{$nazwa}}_kategoria").html();
		
		{{BEGIN produkt_dodany}}
			{{IF $wyswietla_edytuj_procent}}
				$("#spinId_{{$i}}").spinner({
					min: {{$wartosc_procent}},
					max: 100,
					step: {{$procent_skok}} 
				});
			{{END}}
				$("#{{$nazwa}}_category_{{$i}}").append(opcjeSelect);
				$("#{{$nazwa}}_category_{{$i}} option[value={{$wartosc_kategoria}}]").attr('selected', 'selected');
		{{END}}
		
		
		$("#{{$nazwa}}").select2({
			multiple: false,
			data: tags,
			placeholder : '{{$wybierz}}',
			createSearchChoice: function(term) {
				return {
					 id: term,
					 text: term + ' (new)'
				};
		  },
		  //createSearchChoice: function(term, data) { if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {return {id:term, text:term};} },
		});
		
		setTimeout(function(){
			$("#{{$nazwa}}_container").children('div').animate({width: "92%"}, 500);
		}, 100);
		setTimeout(function(){
			$('.catKontener select').select2({width: '120px'});
		}, 200);
		
		$("#{{$nazwa}}").click(function(){
			var id = $(this).val();
			if (id in tags)
			{
				$('#{{$nazwa}}_cena_add').val(tags[id]['cena']);
				if (tags[id]['text'].match(/grav/i) !== null)
					$('#{{$nazwa}}_kategoria').select2('val', 'Graving');
				else
					$('#{{$nazwa}}_kategoria').select2('val', 'Installation');
			}
			else
			{
				if (id.match(/grav/i) !== null)
					$('#{{$nazwa}}_kategoria').select2('val', 'Graving');
				else
					$('#{{$nazwa}}_kategoria').select2('val', 'Installation');
			}
			przeliczWiersz($(this), false, false);
		});
		$('.nst .item .ui-spinner-button').live('click', function(){
			setTimeout(function(){ liczKwoteWyslania(false); }, 500);
		});
		
		{{IF $produkt_dodany}}
		$('.productsFull .item .quantity').each(function(){
			przeliczWiersz($(this), true, true);
		})
		{{END IF}}
		liczKwoteWyslania(true);
	});
	  
	var wierszNiestandardowy = '<li class="item item_szeroki notUsed" id="{KONTENER}" >\n\
		<span class="prd_projekt" >{NAZWA_PRODUKTU}</span>\n\
		{{$etykieta_kategorie}}<span class="cena catKontener"><select name="{{$nazwa}}_kategoria[]" id="category_{ID_SELECT}" class="produkt_kategoria">{SELECT_OPCJE}</select></span>\
		{{$ilosc}} <span class="cena qty_full"> <input type="text" class="qty_add quantity" name="{{$nazwa}}_ilosc[]" value="{ILOSC}"/></span>\
		{{$waluta}} <span class="cena"><input type="text" {READONLY} name="{{$nazwa}}_cena[]" value="{CENA}" class="produkty_ceny ceny price" /></span>\
		<p class="kwota_kontener">\
		<label class="etykieta">{{$kwota}} <input type="text" class="sum_price cena_add" readonly="readonly"/></label>\
		{{IF $wyswietla_edytuj_procent}}<label class="etykieta procent"><span class="etykieta_procent"> %</span> <input type="text" class="procent_wykonania" name="{{$nazwa}}_procent_wykonania[]" value="0" /></label>\
		<label class="etykieta total">{{$kwota_total}} <input type="text" readonly="readonly" class="sum_total_price" value="0" /></label>\{{ELSE}}\{{END IF}}
		<label class="etykieta" style="display: {{IF $wyswietlaj_vat}} inline {{ELSE}}none{{END}}" > {{$etykieta_vat}} <input type="text" class="vat" name="{{$nazwa}}_vat[]" value="{VAT}" id="{{$nazwa}}_vat" /></label>\n\
		</p>\
		<a class="btn btn-danger remove_n"><i class="icon icon-remove"></i> {{$etykieta_usun}}</a>\n\
		<input type="hidden" class="hiddenId" name="{{$nazwa}}_id[]" value="{ID}"/>\n\
		<input type="hidden" class="hiddenNazwa" name="{{$nazwa}}_nazwa[]" value="{NAZWA_PRODUKTU}"/>\
		<input type="hidden" class="hiddenCenaTmp" name="{{$nazwa}}_cena_tmp[]" value="{CENA}" />\
	</li>';
	
	$("#add_niestandardowy").click(function(){
		var id = $("#{{$nazwa}}").val();
		
		// jezeli nie wprowadzono produktu lub próba dodania produktu juz dodanego
		if(id === '' || $('ul.nst .hiddenId[value="'+id+'"]').val() === id)
		{
			return false;
		}
		
		$controlGroupProducts = $('#{{$nazwa}}_container').parents('.control-group');
		$controlGroupProducts.removeClass('input_blad error').addClass('input-ok');
		$controlGroupProducts.find('.help-block').html('');
		
		if (id in tags && tags.length != $('li.item').length)
			var result = tags[id];
		else
			var result = [];
		
		var readonlyCena = ''
		if(result.length == 0)
		{
			var nazwa = id;
		}
		else
		{
			if ($(result).attr('zabron_edycji_ceny'))
			{
				readonlyCena = 'readonly = "readonly"';
			}
			 
			var nazwa = $(result).attr('text');
		}
		
		var cena = $("#{{$nazwa}}_cena_add").val().replace(',', '.').replace(' ', '');
		var ilosc = $("#{{$nazwa}}_qty_add").val();
		var vat = $("#{{$nazwa}}_vat_add").val();
		
		var kategoria = $("#{{$nazwa}}_kategoria").val();
		var procent_wykonania = 100;
		
		var opcjeSelect = $("#{{$nazwa}}_kategoria").html();
		var opcjeSelectWybrana = $("#{{$nazwa}}_kategoria").val();
		
		var ostatniProdukt = $('.nst').children('li').last();
		var ostatniProduktId = ostatniProdukt.attr('id');
		if(ostatniProduktId === undefined)
		{
			ostatniProdukt = 'kontener_1';
		}
		else
		{
			ostatniProdukt = 'kontener_'+(parseInt(ostatniProduktId.replace('kontener_', '')) + 1);
		}
		
		
		var znajdz = ['{KONTENER}', '{ID}', '{NAZWA_PRODUKTU}', '{SELECT_OPCJE}' , '{ID_SELECT}', '{CENA}', '{READONLY}', '{ILOSC}', '{KATEGORIA}', '{PROCENT}', '{VAT}'];
		var zamien = [ostatniProdukt, id, nazwa, opcjeSelect, ostatniProduktId, cena, readonlyCena, ilosc, kategoria, procent_wykonania, vat];
		var zamienionyWiersz = wierszNiestandardowy.replaceArray(znajdz, zamien);
		$(".prd_dodane ul.nst").append(zamienionyWiersz);
		$('#category_'+ostatniProduktId+' option[value='+opcjeSelectWybrana+']').attr('selected', 'selected');
		
		if (ilosc > 1)
		{
			$('.notUsed .procent_wykonania').val(ilosc).attr('aria-valuenow', ilosc);
			$('.notUsed .etykieta_procent').html(' /');
			var procent_config = {
				min: 1,
				max: ilosc,
				step: 1
			};
		}
		else
		{
			$('.notUsed .procent_wykonania').val(100).attr('aria-valuenow', 100);
			var procent_config = {
				min: 0,
				max: 100,
				step: 5
			};
		}
		
		$(".notUsed .procent_wykonania").spinner(procent_config);
		
		
		$(".notUsed .quantity").spinner({
			min: 1,
			step: 1
		});
		
		$('.cena select').select2();
		
		setTimeout(function(){
			przeliczWiersz($('.notUsed .quantity'), true, false);
			$('.notUsed').removeClass('notUsed');
		},1);
		liczKwoteWyslania(false);
		$('.catKontener select').select2({width: '120px'});
		return false;
	});
	
	function liczKwoteWyslania(zapiszWartoscPoczatkowa, pobierz_z_wartosci)
	{
		var suma = 0;
		var kwota = 0;
		var cena = 0;
		var ilosc = 0;
		var p = 0;
		
		
		$('.nst .item').each(function(){
			cena = $(this).find('.price.ceny').val();
			ilosc = $(this).find('.qty_add').val();
			if (pobierz_z_wartosci === true)
				p = $(this).find('.procent_wykonania').val();
			else
				p = $(this).find('.procent_wykonania').attr('aria-valuenow');
		
			suma += parseFloat(cena*ilosc);
			if (ilosc > 1)
			{
				kwota += (cena*p);
			}
			else
			{
				kwota += (cena*ilosc) * (p/100);
			}
		});
		
		$('#wyslano').html(number_format(kwota, 2, ',', ' '));
		$('#suma_total').html(number_format(suma, 2, ',', ' '));
		
		var procent = number_format((kwota/suma)*100, 1, ',', '');
		$('#procent').html(procent);
		$('#budget').val(suma);
		
		document.kwota = kwota;
		if (zapiszWartoscPoczatkowa) document.kwotaPoczatkowa = kwota;
		
		if (document.kwotaPoczatkowa != 'undefined' && (kwota - document.kwotaPoczatkowa) > 0)
		{
			var dodatkowo = kwota - document.kwotaPoczatkowa;
			$('#dodatkowoWartosc').html(number_format(dodatkowo, 2, ',', ' '));
			$('#dodatkowo').fadeIn();
		}
		else
		{
			$('#dodatkowo').hide();
			$('#dodatkowoWartosc').html('');
		}
	}
	
	function pobierzIdKontener()
	{
		var ostatniProdukt = $('.nst').children('li').last();
		var ostatniProduktId = ostatniProdukt.attr('id');
		if(ostatniProduktId === undefined)
		{
			ostatniProduktId = 1;
			ostatniProdukt.attr('id', 'kontener_'+ostatniProduktId);
		}
		else
		{
			ostatniProduktId = intval(ostatniProduktId.substr('kontener_'))+1;
			ostatniProdukt.attr('id', 'kontener_'+ostatniProduktId);
		}
		return ostatniProduktId;
	}
	
	$('.{{$nazwa}}_ceny').live('keyup', function(){
		$(this).val($(this).val().replace(',', '.').replace(' ', ''));
	});
	$('.{{$nazwa}}_ceny').live('change', function(){
		$(this).val($(this).val().replace(',', '.').replace(' ', ''));
	});
	
	$(".remove_n").live('click' ,function(){
		$(this).parents('li.item').remove();
		liczKwoteWyslania(false);
		return false;
	});
	
	$('.qty_full .ui-spinner-button').live('click', function(){
		przeliczWiersz($(this), true, false, false);
	});
	$('.procent .ui-spinner-button').live('click', function(){
		
		przeliczWiersz($(this), false, false, false);
	});
	$('.price, .quantity, .qty_add').live('keyup', function(){
		przeliczWiersz($(this), false, false, false);
		liczKwoteWyslania(false);
	});
	$('.quantity, .qty_add').live('keyup', function(){
		przeliczWiersz($(this), false, false, true);
		liczKwoteWyslania(false);
	});
	// (element, zmiana_procent, minimalne_wartosci, pobierz_z_atrybutu_wartosc)
	$('.procent_wykonania').live('keyup', function(){
		var el = $(this);
		aktualizujKwoty(el);		
	});
	
	function aktualizujKwoty(element)
	{
		var wartosc = parseInt(element.val());
		var min = parseInt(element.attr('aria-valuemin'));
		if (wartosc >= min || wartosc == '')
		{
			element.siblings('.ui-spinner-up').click();
			element.siblings('.ui-spinner-down').click();
		}
		sprawdzKwoty();
	}
	
	function sprawdzKwoty()
	{
		var bledy = 0;
		$('.nst .item .procent_wykonania').each(function(){
			var min = parseInt($(this).attr('aria-valuemin'));
			var max = parseInt($(this).attr('aria-valuemax'));
			var w = parseInt($(this).val());
			
			if (w > max || w < min)
			{
				$(this).css({borderColor: "red"});
				$(this).parents('label').find('.info').html('Minimum: '+number_format(min, '2', ',', ' ')+', maximum: '+number_format(max, '2', ',', ' '));
			}
			else
			{
				$(this).css({borderColor: "#ccc"});
				$(this).parents('label').find('.info').html('');
			}
		});
	}
	
	function przeskalujInput()
	{
		var szerokosc = $('textarea.full-width').width()+10;
		$('.niestandardowe_projekt').width(szerokosc);
	}
	
	function przeliczWiersz(element, zmiana_procent, minimalne_wartosci, pobierz_z_atrybutu_wartosc, popraw_wartosc)
	{
		if (popraw_wartosc !== false)
			popraw_wartosc = true;
		
		var $rodzic = $(element).parents('.niestandardowe_projekt, .item');
		var cena = $rodzic.find('.price').val();
		
		$procent = $rodzic.find('.procent_wykonania');
		var procent = "100";
		if ($procent.length > 0)
			procent = $procent.attr('aria-valuenow');
		
		if (pobierz_z_atrybutu_wartosc)
		{
			var ilosc = $rodzic.find('.qty_add').val();
			if (zmiana_procent && !minimalne_wartosci){ $(element).parents('.item').find('.procent_wykonania').val(ilosc).attr('aria-valuenow', ilosc); }
			var procent = $procent.val();
		}
		else
		{
			var ilosc = $rodzic.find('.qty_add').attr('aria-valuenow');
			if (zmiana_procent && !minimalne_wartosci){ $(element).parents('.item').find('.procent_wykonania').val(ilosc).attr('aria-valuenow', ilosc); }
			var procent = $procent.attr('aria-valuenow');
		}
		
		var kwota = parseFloat(cena) * parseInt(ilosc);
		$rodzic.find('.sum_price').attr('real-value', kwota).val(number_format(kwota, '2', ',', ' '));
		
		var min = {{IF $produkt_dodany}}$rodzic.find('.hiddenProcentPoczatkowy').val(){{ELSE}}0{{END IF}};
		if (typeof min == 'undefined') min = 0;
		if (ilosc > 1)
		{
			var procent_conf = {
				min: min,
				max: ilosc,
				step: 1
			};
			
			$rodzic.find('.etykieta_procent').html(' /');
			var kwota_total = cena * procent;
		}
		else
		{
			var procent_conf = {
				min: min,
				max: 100,
				step: 1
			};
			
			if (zmiana_procent && !minimalne_wartosci) $(element).parents('.item').find('.procent_wykonania').val(100).attr('aria-valuenow', 100);
			$rodzic.find('.etykieta_procent').html(' %');
			if($procent.val() % 1 !=0 && $procent.val() > 99 && $procent.val() < 100 ){ $(element).parents('.item').find('.procent_wykonania').val(100).attr('aria-valuenow', 100); }
			var procent = $procent.val();
			var kwota_total = kwota * (procent/100);
		}
		if (popraw_wartosc)
		{
			$(element).parents('.item').find('.procent_wykonania').spinner(procent_conf);
		}
		else
		{
			$(element).parents('.item').find('.procent_wykonania').unbind();
		}
		$rodzic.find('.sum_total_price').attr('real-value', kwota_total).val(number_format(kwota_total, '2', ',', ' '));
	}
</script>