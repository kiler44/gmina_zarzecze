{{IF $wiersz}}
<div class="select_wrap select2 products nstProductsInput" id="{{$nazwa}}_input">
	<p class="niestandardowe">
	<span id="{{$nazwa}}_container" class="select">
	<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}}>
	</span>
	<span class="cena"><var>{{$waluta}}</var> <input type="text" class="cena_add" name="{{$nazwa}}_cena_add" value="0,0" id="{{$nazwa}}_cena_add" /></span>
		{{UNLESS $no-alert}}{{$alert}} <input type="checkbox" name="{{$nazwa}}_dodaj_alert" id="{{$nazwa}}_dodaj_alert" value="1" />{{END}}
		<span class="qty"><input type="text" class="spn" name="{{$nazwa}}_qty_add" value="1" id="{{$nazwa}}_qty_add" readonly="readonly" /></span>
		<a href="javascript:void(0);" id="add_niestandardowy" class="btn btn-success add_button_n"><i class="icon icon-plus"></i> {{$etykieta_dodaj}}</a>
		
	</p>
	<div class="prd_dodane">
	<ul class="nst">
	{{BEGIN produkt_dodany}}
		<li class="item">
			<span class="prd">{{$wartosc_nazwa}} </span>
			<span class="cena"><var>{{$waluta}}</var> <input type="text" class="{{$nazwa}}_ceny" {{IF $zabron_edycji_ceny == 'true'}} readonly="readonly" {{END}} name="{{$nazwa}}_cena[]" value="{{$wartosc_cena}}" /></span>
			{{UNLESS $no-alert}}<span > {{$alert}} <input type="checkbox" {{IF wartosc_alert}} checked="checked" {{END}} name="{{$nazwa}}_alert[]" id="{{$nazwa}}_alert[]" class="alert" value="{{$wartosc_id}}" /></span>{{END}}
			{{IF $wartosc_multiple == "true"}}
				<span class="qty"><input type="text" class="spn" name="{{$nazwa}}_qty[]" value="{{$wartosc_ilosc}}" readonly="readonly"/></span>
			{{ELSE}}
				<input type="hidden" name="{{$nazwa}}_qty[]" value="1"/>
			{{END}}
			<button class="btn btn-danger remove_n"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button>
			<input type="hidden" name="{{$nazwa}}_id[]" class="hiddenId" value="{{$wartosc_id}}"/>
			<input type="hidden" name="{{$nazwa}}_nazwa[]" class="hiddenNazwa" value="{{$wartosc_nazwa}}"/>
			<span class="clear block"></span>
		</li>
	{{END}}
	</ul>
	</div>
</div>

{{ELSE}}
<div class="select_wrap select2 products nstProductsInput" id="{{$nazwa}}_input">
	<p class="niestandardowe">
	<span id="{{$nazwa}}_container" class="select">
	<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}}>
	</span>
		<span class="cena"><var>{{$waluta}}</var> <input type="text" class="cena_add" class="{{$nazwa}}_ceny" name="{{$nazwa}}_cena_add" value="0,0" id="{{$nazwa}}_cena_add" /></span>
		{{UNLESS $no-alert}}{{$alert}} <input type="checkbox" name="{{$nazwa}}_dodaj_alert" id="{{$nazwa}}_dodaj_alert" value="1" />{{END}}
		<span class="qty"><input type="text" class="spn" name="{{$nazwa}}_qty_add" value="1" id="{{$nazwa}}_qty_add" readonly="readonly" /></span>
		<a href="javascript:void(0);" id="add_niestandardowy" class="btn btn-success add_button_n"><i class="icon icon-plus"></i> {{$etykieta_dodaj}}</a>
	</p>
	<div class="prd_dodane">
	<ul class="nst">
	{{BEGIN produkt_dodany}}
		<li class="item">
			<span class="prd">{{$wartosc_nazwa}} </span>
			<span class="cena"><var>{{$waluta}}</var> <input type="text" class="{{$nazwa}}_ceny" {{IF $zabron_edycji_ceny == 'true'}} readonly="readonly" {{END}} name="{{$nazwa}}_cena[]" value="{{$wartosc_cena}}" /></span>
			{{UNLESS $no-alert}}<span > {{$alert}} <input type="checkbox" {{IF wartosc_alert}} checked="checked" {{END}} name="{{$nazwa}}_alert[]" id="{{$nazwa}}_alert[]" class="alert" value="{{$wartosc_id}}" /></span>{{END}}
			{{IF $wartosc_multiple == "true"}}
				<span class="qty"><input type="text" class="spn" name="{{$nazwa}}_qty[]" value="{{$wartosc_ilosc}}" readonly="readonly"/></span>
			{{ELSE}}
				<input type="hidden" name="{{$nazwa}}_qty[]" value="1"/>
			{{END}}
			<button class="btn btn-danger remove_n"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button>
			<input type="hidden" name="{{$nazwa}}_id[]" class="hiddenId" value="{{$wartosc_id}}"/>
			<input type="hidden" name="{{$nazwa}}_nazwa[]" class="hiddenNazwa" value="{{$wartosc_nazwa}}"/>
			<span class="clear block"></span>
		</li>
	{{END}}
	</ul>
	</div>
</div>
{{END}}
<script type="text/javascript">
	if (jestNst == 0)
	{
		var tags = Array();
	}
	tags['{{$nazwa}}'] = [
	{{BEGIN wiersz}}
		{id: {{$wartosc}}, text: '{{$etykieta}}', multiplied: '{{$multiple}}', cena: '{{$cena}}', zabron_edycji_ceny :'{{$zabron_edycji_ceny}}' },
	{{END}}
	];
	$(document).ready(function(){
		$('#budget').attr('readonly', 'readonly');
		liczBudget();
		sprawdzMultipleDodawanie('{{$nazwa}}');
		
		if ($("#{{$nazwa}}_container").find('a.select2-choice').length == 0)
		{
			$("#{{$nazwa}}").select2({
				createSearchChoice:function(term, data) { if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {return {id:term, text:term};} },
				multiple: false,
				data: tags['{{$nazwa}}'],
				placeholder : '{{$wybierz}}',
				createSearchChoice: function(term) {
					return {
						 id: term,
						 text: term + ' (new)'
					};
			  },
			});
			$(".spn").spinner({min: 1, step: {{$skok}} });
			setTimeout(function(){
				$('#{{$nazwa}}_container .select2-container').css({width: "92%"});
			}, 1);
		}
	});
	
	var wierszNiestandardowy = '<li class="item">\n\
		<span class="prd">{NAZWA_PRODUKTU}</span>\n\
		<span class="cena"><var>{{$waluta}}</var> <input type="text" class="{{$nazwa}}_ceny" {READONLY} name="{NAZWA_INPUTA}_cena[]" value="{CENA}" /></span>\n';
		{{UNLESS $no-alert}}wierszNiestandardowy += '<span> {{$alert}} <input type="checkbox" name="{NAZWA_INPUTA}_alert[]" class="alert" {ALERT_ZNAK} id="{NAZWA_INPUTA}_alert_{ID_ALERT}" value="{ID}" /></span>\n';{{END}}
		wierszNiestandardowy += '<span class="qty {CLASS}"><input type="text" readonly="readonly" class="spn" name="{NAZWA_INPUTA}_qty[]" value="{ILOSC}"/></span>\n\
		<a class="btn btn-danger remove_n"><i class="icon icon-remove"></i> {{$etykieta_usun}}</a>\n\
		<input type="hidden" class="hiddenId" name="{NAZWA_INPUTA}_id[]" value="{ID}"/>\n\
		<input type="hidden" class="hiddenNazwa" name="{NAZWA_INPUTA}_nazwa[]" value="{NAZWA_PRODUKTU}"/><span class="clear block"></span>\n\
	</li>';
	
	if (jestNst == 0)
	{
		$(".add_button_n").live('click', function(){
			var idProdNiest = $(this).parents('.nstProductsInput').attr('id');
			var nazwa_inputa = $(this).parents('.nstProductsInput').attr('id').replace('_input', '');
			var id = $('#'+nazwa_inputa).val();
			
			var result = $.grep(tags[nazwa_inputa], function(e){ return e.id == id; });
			
			if(id === '' || $('#'+idProdNiest+' ul.nst .hiddenNazwa[value="'+$(result).attr('text')+'"]').length)
			{
				return false;
			}
			//console.log($(result).attr('text'));

			var klasa = '';
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
				if($(result).attr('multiplied') == 'false')
				{
					klasa = 'hidden';
				}
				var nazwa = $(result).attr('text');
			}

			var cena = $("#"+nazwa_inputa+"_cena_add").val().replace(',', '.').replace(' ', '');
			var alert = $("#"+nazwa_inputa+"_dodaj_alert").is(':checked');
			var ilosc = $("#"+nazwa_inputa+"_qty_add").val();

			var alert_znak = '';
			if(alert) { alert_znak = 'checked="checked"' }

			var id_alert =  id;
			var id_alert_uniform = id_alert.replace(/ /g, "");

			var znajdz = [ '{ID}', '{NAZWA_PRODUKTU}', '{CENA}', '{ALERT}', '{ALERT_ZNAK}', '{ILOSC}', '{CLASS}', '{ID_ALERT}', '{READONLY}', '{NAZWA_INPUTA}'];
			var zamien = [id, nazwa, cena, alert, alert_znak, ilosc, klasa, id_alert_uniform, readonlyCena, nazwa_inputa];

			var zamienionyWiersz = wierszNiestandardowy.replaceArray(znajdz, zamien);

			$("#"+nazwa_inputa+"_input .prd_dodane ul.nst").append(zamienionyWiersz);


			$(".spn").spinner({min: 1});

			$("#"+nazwa_inputa+"_qty_add").val(1);

			$("#"+nazwa_inputa+"_alert_"+id_alert_uniform+"").uniform();
			// updateZamknijZamowienie(false);
			liczBudget();
			return false;
		});
		jestNst++;
	}
	
	function liczBudget()
	{
		var budget = 0;
		
		$('.{{$nazwa}}_ceny').each(function(){
						var ilosc = $(this).parent().siblings('.qty').find('.spn').val();
						budget += parseFloat($(this).val()) * ilosc;
					}
			);
		
		$('#budget').val(budget);
		
	}
	$('.{{$nazwa}}_ceny').live('change', function(){
		$(this).val($(this).val().replace(',', '.').replace(' ', ''));
		liczBudget();
	});
	$('.{{$nazwa}}_ceny').live('keyup', function(){
		$(this).val($(this).val().replace(',', '.').replace(' ', ''));
		liczBudget();
	});
	$("#{{$nazwa}}_cena_add").live('keypress', function(e) {
		if(e.which === 13) {
			 e.preventDefault();
			 $(this).parents('.niestandardowe').find('.add_button_n').click();
		}
	});
	
	 
	function sprawdzMultipleDodawanie(nazwaInputa)
	{
		var m = $('#'+nazwaInputa).val();
		var result = $.grep(tags[nazwaInputa], function(e){ return e.id == m; });
		
		if(result.length !== 0)
		{
			if ($(result).attr('zabron_edycji_ceny') === 'true')
			{
				$('#'+nazwaInputa+'_container').parent('p').find('.cena_add').attr('readonly', 'readonly');
			}
			else
			{
				$('#'+nazwaInputa+'_container').parent('p').find('.cena_add').removeAttr('readonly');
			}
			if ($(result).attr('multiplied') === 'true')
			{
				$('#'+nazwaInputa+'_container').parent('p').find('.qty').show();
			}
			else
			{
				$('#'+nazwaInputa+'_container').parent('p').find('.qty').hide();
			}
			
			$('#'+nazwaInputa+'_container').parent('p').find('.cena_add').val($(result).attr('cena'));
			
		}
		else
		{
			$('#'+nazwaInputa+'_container').parent('p').find('.qty').show();
			$('#'+nazwaInputa+'_container').parent('p').find('.cena_add').val(0);
			$('#'+nazwaInputa+'_container').parent('p').find('.cena_add').removeAttr('readonly');
		}
		
	}
	
	
	$('#{{$nazwa}}').live('change', function(){
			sprawdzMultipleDodawanie($(this).attr('id'));
	});
	
	$(".remove_n").live('click' ,function(){
		
		$(this).parents('li.item').remove();
		liczBudget();
		return false;
	});
	$(".prd_dodane .ui-spinner-button").live('click', function(){
		liczBudget();
	});
	
</script>