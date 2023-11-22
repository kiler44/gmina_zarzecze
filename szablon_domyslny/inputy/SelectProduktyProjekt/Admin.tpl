{{IF $wiersz}} 
<div class="select_wrap select2 products" {{IF $zabron_dodaj_produkt}} style="display: none;" {{END}} >
	<p class="niestandardowe_projekt">
		<span id="{{$nazwa}}_container" class="select">
		<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}} >
	</span>
	{{$etykieta_kategorie}}
	<span class="cena">
		<select name="{{$nazwa}}_kategoria" id="{{$nazwa}}_kategoria">
			{{BEGIN kategorie}}
				<option value="{{$wartosc}}"  >{{$etykieta}}</option>
			{{END}}
		</select>
	</span>
	 {{$waluta}} <span class="cena"> <input type="text" class="cena_add" name="{{$nazwa}}_cena_add" value="0" id="{{$nazwa}}_cena_add" /></span>
	<a href="javascript:void(0);" id="add_niestandardowy" class="btn btn-success add_button"><i class="icon icon-plus"></i> {{$etykieta_dodaj}}</a>
	</p>
</div>
{{ELSE}}
<div class="select_wrap select2 products" {{IF $zabron_dodaj_produkt}} style="display: none;" {{END}} >
	<p class="niestandardowe_projekt">
	<span id="{{$nazwa}}_container" class="select">
	<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}}>
	</span>
	{{$etykieta_kategorie}}
	<span class="cena">
	<select name="{{$nazwa}}_kategoria" id="{{$nazwa}}_kategoria">
		{{BEGIN kategorie}}
			<option value="{{$wartosc}}"  >{{$etykieta}}</option>
		{{END}}
	</select>
	</span>
	
	{{$waluta}} <span class="cena"> <input type="text" class="cena_add" name="{{$nazwa}}_cena_add" value="0" id="{{$nazwa}}_cena_add" /></span>
	<a href="javascript:void(0);" id="add_niestandardowy" class="btn btn-success add_button"><i class="icon icon-plus"></i> {{$etykieta_dodaj}}</a>
	</p>
</div>
{{END}}

<div class="prd_dodane {{IF $zabron_dodaj_produkt}}dodane_projekt{{END}}">
<ul class="nst">
{{BEGIN produkt_dodany}}
	<li class="item item_szeroki"  >
		<span class="prd_projekt" >{{$wartosc_nazwa}} </span>
		{{$etykieta_kategorie}}
		<span class="cena">
			{{IF $zabron_edycji_kategorii == 'true'}}
				<input type="text" class="readonly" name="{{$nazwa}}_category[]" readonly="readonly" id="{{$nazwa}}_kategoria" value="{{$wartosc_kategoria}}" />
			{{ELSE}}
				<select name="{{$nazwa}}_category[]" id="{{$nazwa}}_category_{{$i}}" >
				</select>
			{{END}}
		</span>
		{{$waluta}} <span class="cena procent" style="width:80px;"><input type="text" {{IF $zabron_edycji_ceny == 'true'}} readonly="readonly" {{END}} name="{{$nazwa}}_cena[]" class="{{$nazwa}}_ceny" value="{{$wartosc_cena}}" /></span>
		
		{{$etykieta_procent}}
		<span class="qty qty_projekt">
		<input type="text" id="spinId_{{$i}}" readonly="readonly" class="procent_wykonania" name="{{$nazwa}}_procent_wykonania[]" value="{{$wartosc_procent_wykonania}}" />
		</span>
		
		{{IF $zabron_usun == 'false' }}
			<button class="btn btn-danger remove_n"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button>
		{{END}}
		<input type="hidden" class="hiddenId" name="{{$nazwa}}_id[]" value="{{$wartosc_id}}"/>
		<input type="hidden" class="hiddenNazwa" name="{{$nazwa}}_nazwa[]" value="{{$wartosc_nazwa}}"/>
		<input type="hidden" class="hiddenQty" name="{{$nazwa}}_qty[]" value="{{$wartosc_ilosc}}"/>
	</li>
{{END}}
</ul>
</div>
<ul class="podsumowanie_produkty" >
	<li class="podsumowanie_produkty_projekt" >
		<span class="podsumowanie_tekst">{{$etykieta_kwota}} {{$etykieta_waluta}}  {{IF $wyswietla_edytuj_procent}}<span id="dodatkowo" style="display: none"><i class="icon icon-arrow-up"></i> <var id="dodatkowoWartosc"></var></span> <var id="poczatkowo" class="hidden"></var><span id="wyslano">0</span> (<var id="procent">0</var>%) / {{END IF}}<span id="suma">0</span>{{$etykieta_kwota_znaczek}}</span>
	</li>
</ul>

<script type="text/javascript">
	var tags = [
	{{BEGIN wiersz}}
		{id: {{$wartosc}}, text: '{{$etykieta}}', multiplied: '{{$multiple}}', cena: '{{$cena}}', zabron_edycji_ceny :'{{$zabron_edycji_ceny}}' },
	{{END}}
	];
	$(document).ready(function(){
		$('#budget').attr('readonly', 'readonly');
		liczBudget();
		
		
		{{IF $wyswietla_edytuj_procent}}
		$(".procent_wykonania").spinner({
			min: 0,
			max: 100,
			step: {{$procent_skok}} 
		});
		liczKwoteWyslania();
		$('.ui-spinner-button').click(function(){liczKwoteWyslania()});
		{{END}}
		
		var opcjeSelect = $("#{{$nazwa}}_kategoria").html();
		
		{{BEGIN produkt_dodany}}
			{{IF $wyswietla_edytuj_procent}}
				$("#spinId_{{$i}}").spinner({
					min: {{$wartosc_procent_wykonania}},
					max: 100,
					step: {{$procent_skok}} 
				});
			{{END}}
				$("#{{$nazwa}}_category_{{$i}}").append(opcjeSelect);
				$("#{{$nazwa}}_category_{{$i}} option[value={{$wartosc_kategoria}}]").attr('selected', 'selected');
		{{END}}
		
		
		$("#{{$nazwa}}").select2({
			createSearchChoice:function(term, data) { if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {return {id:term, text:term};} },
			multiple: false,
			data: tags,
			placeholder : '{{$wybierz}}',
			createSearchChoice: function(term) {
				return {
					 id: term,
					 text: term + ' (new)'
				};
		  },
		});
		
		setTimeout(function(){
			$("#{{$nazwa}}_container").children('div').animate({width: "92%"}, 500);
		}, 100);
	});
	  
	var wierszNiestandardowy = '<li class="item item_szeroki" id="{KONTENER}" >\n\
		<span class="prd_projekt" >{NAZWA_PRODUKTU}</span>\n\
		{{$etykieta_kategorie}}<span class="cena"><select name="{{$nazwa}}_category[]" id="category_{ID_SELECT}" >{SELECT_OPCJE}</select></span>\n\
		{{$waluta}} <span style="width:80px;" class="cena"><input type="text" {READONLY} name="{{$nazwa}}_cena[]" value="{CENA}" class="{{$nazwa}}_ceny" /></span>\n\
		{{$etykieta_procent}}\n\
		<span class="qty qty_projekt">\n\
		<input type="text"  readonly="readonly" class="procent_wykonania" name="{{$nazwa}}_procent_wykonania[]" value="0" />\n\
		</span>\n\
		<a class="btn btn-danger remove_n"><i class="icon icon-remove"></i> {{$etykieta_usun}}</a>\n\
		<input type="hidden" class="hiddenId" name="{{$nazwa}}_id[]" value="{ID}"/>\n\
		<input type="hidden" name="{{$nazwa}}_qty[]" value="1"/>\n\
		<input type="hidden" name="{{$nazwa}}_nazwa[]" value="{NAZWA_PRODUKTU}"/>\n\
	</li>';
	
	$("#add_niestandardowy").click(function(){
		
		var id = $("#{{$nazwa}}").val();
		
		// jezeli nie wprowadzono produktu lub pruba dodania produktu juz dodanego
		if(id === '' || $('ul.nst .hiddenId[value="'+id+'"]').val() === id)
		{
			return false;
		}
		
		var result = $.grep(tags, function(e){ return e.id == id; });
		
		var readonlyCena = ''
		if(result.length == 0)
		{
			var nazwa = id;
		}
		else
		{
			if ($(result).attr('zabron_edycji_ceny') === 'true')
			{
				readonlyCena = 'readonly = "readonly"';
			}
			 
			var nazwa = $(result).attr('text');
		}
		
		var cena = $("#{{$nazwa}}_cena_add").val().replace(',', '.').replace(' ', '');
		
		var opcjeSelect = $("#{{$nazwa}}_kategoria").html();
		var opcjeSelectWybrana = $("#{{$nazwa}}_kategoria").val();
		
		var ostatniProdukt = $('.nst').children('li').last();
		var ostatniProduktId = ostatniProdukt.attr('id');
		if(ostatniProduktId === undefined)
		{
			ostatniProduktId = 'kontener_1';
		}
		else
		{
			ostatniProduktId = 'kontener_'+(parseInt(ostatniProduktId.replace('kontener_', '')) + 1);
		}
		
		
		var znajdz = ['{KONTENER}', '{ID}', '{NAZWA_PRODUKTU}', '{SELECT_OPCJE}' , '{ID_SELECT}', '{CENA}', '{READONLY}'];
		var zamien = [ostatniProduktId, id, nazwa, opcjeSelect, ostatniProduktId, cena, readonlyCena];
		var zamienionyWiersz = wierszNiestandardowy.replaceArray(znajdz, zamien);
		$(".prd_dodane ul.nst").append(zamienionyWiersz);
		
		$('#category_'+ostatniProduktId+' option[value='+opcjeSelectWybrana+']').attr('selected', 'selected');
		liczBudget();
		return false;
	});
	
	function liczKwoteWyslania()
	{
		var suma = 0;
		var kwota = 0;
		$('.nst .item').each(function(){
			var cena = $(this).find('.produktyProjekt_ceny').val();
			var p = $(this).find('.procent_wykonania').attr('aria-valuenow');
			suma += parseInt(cena);
			kwota += cena * (p/100);
		});
		$('#wyslano').html(number_format(kwota, 0, ',', ' '));
		
		if ($('#poczatkowo').html() == '')
		{
			$('#poczatkowo').html(kwota);
			var poczatkowo = kwota;
		}
		else
		{
			var poczatkowo = $('#poczatkowo').html();
		}
		
		var dodatkowo = kwota - poczatkowo;
		if (dodatkowo > 0)
		{
			$('#dodatkowo').fadeIn("normal");
			$('#dodatkowoWartosc').html(number_format(dodatkowo, 0, ',', ' '));
		}
		else
		{
			$('#dodatkowo').fadeOut("fast");
			$('#dodatkowoWartosc').html('');
		}
		
		var procent = number_format((kwota/suma)*100, 1, ',', '');
		$('#procent').html(procent);
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
	
	function liczBudget()
	{
		var budget = 0;
		
		$('.{{$nazwa}}_ceny').each(function(){
						budget += parseFloat($(this).val());
					}
			);
		
		$('#budget').val(budget);
		$('#suma').text(number_format(budget, 0, ',', ' '));
	}
	
	$('.{{$nazwa}}_ceny').live('keyup', function(){
		$(this).val($(this).val().replace(',', '.').replace(' ', ''));
		liczBudget();
	});
	$('.{{$nazwa}}_ceny').live('change', function(){
		$(this).val($(this).val().replace(',', '.').replace(' ', ''));
		liczBudget();
	});
	
	$(".remove_n").live('click' ,function(){
		$(this).parents('li.item').remove();
		liczBudget();
		return false;
	});
	
</script>