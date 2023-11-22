{{BEGIN index}}
<script type="text/javascript">
   var linkGlobal;
	function otworzOkno(link)
	{
		linkGlobal = link;
		$.ajax({
				url: link,
				type: 'POST',
				dataType: 'html',
				async: true,
				success: function(dane) {
					$('#oknoModalne .modal-header h3').html("{{$okno_dodaj_produkt_naglowek}}");
					$('#oknoModalne .modal-body').html(dane);
					$('#oknoModalne').modal('show');
					$('#oknoModalne .modal-body, #oknoModalne .modal-body iframe html').css('background', 'none');
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
	}
	
	
	
	$("#produkty_zakupione_form").live('submit', function() {
			$.ajax({
			url: linkGlobal,
			type: $('#produkty_zakupione_form').attr('method'),
			data: $('#produkty_zakupione_form').serialize(),
			dataType: 'json',
			async: true,
			success: function(dane) {
				if(dane.kod == '1' )
				{
					$('#miejsceNaFormularz').html(dane.info);
					$('.alert').css('display', 'block').addClass('alert-error').html(dane.komunikat);
				}
				if(dane.kod == '2' )
				{
					$('#miejsceNaFormularz').html(dane.info);
					$('.alert').css('display', 'block').addClass('alert-info').html(dane.komunikat);

				}
				$('#vat').parent().parent('.control-group').css('display', 'none');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
			}
		)
		return false;
		});

	$('#wstecz').live('click', function(e){
			$('#oknoModalne').modal('hide');
		});
	
</script>
<div class="widget-box">
{{$tabela_danych}}
<!--
<a class="btn tip-top" onclick="return otworzOkno(this.href);" href="{{$linkAjax}}" > dodaj </a>
<a class="btn tip-top" onclick="return otworzOkno(this.href);" href="{{$linkAjaxEdytuj}}" > edytuj </a>
-->
</div>
{{END}}

{{BEGIN dodaj}}
<script type="text/javascript">
	
	function przeladujFormularz()
	{
		$('.modal-backdrop').fadeIn("fast");
		setTimeout(function(){
			$('#products_form').append($('<input type="hidden" name="tylkoOdswierz" value="1"/>')).submit();
		}, 1);
	}
	
   $(document).ready(function () {
		
		$('#visibleInOrder_wybrane, #visibleInOrder_lista').dblclick(function(){
			przeladujFormularz();
		});
		$('#visibleInOrder_dodaj, #visibleInOrder_usun').click(function(){
			przeladujFormularz();
		});
		
		$('#nettoPrice').change(function() {
				var vat = $('#vat').val();
				var netto = $(this).val().replace(',','.');
				var brutto = 0;
				if(netto > 0)
				{
					brutto = liczBrutto(parseFloat(netto), vat);
				}
								
				$('#bruttoPrice').val(brutto);
				
			}
		)
		$('#bruttoPrice').change(function() {
				var vat = $('#vat').val();
				var brutto = $(this).val().replace(',','.');
				
				var netto = 0;
				if(brutto > 0)
				{
					netto = liczNetto(parseFloat(brutto), vat);
				}
				
				$('#nettoPrice').val(netto);
				
			}
		)
		
		
		
		$('#vat').change(function() {
				var vat = $(this).val();
				var netto = $('#nettoPrice').val().replace(',','.');
				var brutto = $('#bruttoPrice').val().replace(',','.')
				if(netto > 0)
				{
					var brutto = liczBrutto(parseFloat(netto), vat);
					$('#bruttoPrice').val(brutto);
				}
				else if(brutto > 0)
				{
					var netto = liczNetto(parseFloat(brutto), vat);
					$('#nettoPrice').val(netto);
				}
				
			}
		)
		function liczBrutto(netto, vat)
		{
			var brutto = (netto * (1 + (vat/100)));
			return brutto.toFixed(0);
		}
		function liczNetto(brutto, vat)
		{
			var netto = brutto/(1+(vat/100));
			return netto.toFixed(0);
		}
	});
</script>
{{$form}}
{{END}}

{{BEGIN dodajAjax}}
<script type="text/javascript">
	
   $(document).ready(function () {
		
		$('#nettoPrice').keyup(function() {
				var vat = $('#vat').val();
				var netto = $(this).val().replace(',','.');
				
				var brutto = 0;
				if(netto > 0)
				{
					brutto = liczBrutto(parseFloat(netto), vat);
				}
				
				$('#bruttoPrice').val(brutto);
			}
		)
		$('#bruttoPrice').keyup(function() {
				var vat = $('#vat').val();
				var brutto = $(this).val().replace(',','.');
				
				var netto = 0;
				if(brutto > 0)
				{
					var netto = liczNetto(parseFloat(brutto), vat);
				}
				
				$('#nettoPrice').val(netto);
				
			}
		)
		
		$('#vat').parent().parent('.control-group').css('display', 'none');
		
		$('#vat').keyup(function() {
				var vat = $(this).val();
				var netto = $('#nettoPrice').val().replace(',','.');
				var brutto = $('#bruttoPrice').val().replace(',','.')
				if(netto > 0)
				{
					var brutto = liczBrutto(parseFloat(netto), vat);
					$('#bruttoPrice').val(brutto);
				}
				else if(brutto > 0)
				{
					var netto = liczNetto(parseFloat(brutto), vat);
					$('#nettoPrice').val(netto);
				}
				
			}
		)
		function liczBrutto(netto, vat)
		{
			var brutto = (netto * (1 + (vat/100)));
			return brutto.toFixed(0);
		}
		function liczNetto(brutto, vat)
		{
			var netto = brutto/(1+(vat/100));
			return netto.toFixed(0);
		}
	});
</script>
<div class="alert" style="display:none">
	
</div>
<div id="miejsceNaFormularz" >
{{$form}}
</div>
	
{{END}}

{{BEGIN sortowanie}}
	<a href="javascript:void(0)" class="zapisz btn btn-success margin-right"><i class="icon icon-save"></i> {{$etykieta_zapisz_kolejnosc}}</a>
	<a href="{{$urlWstecz}}" class="btn">{{$etykieta_wstecz}}</a>
	<div class="widget-box" id="elementy">
		<div class="widget-title">
			<span class="icon"><i class="icon icon-reorder"></i></span>
			<h5>{{$produkty_etykieta}}</h5>
	  </div>
	<ul id="sortowanie" class="ui-sortable">
		{{BEGIN produkt}}
			<li id="id-{{$id}}">
				<span><strong>{{$nazwa}}</strong></span>
				<div class="right">
					<span>{{$cena}}</span>
					<span>{{$produkt_glowny}}</span>
					<span>{{$visible_in}}</span>
				</div>
				<div class="clear"></div>
			</li>
		{{END}}
	</ul>
	</div>
	<a href="javascript:void(0)" class="zapisz btn btn-success margin-right"><i class="icon icon-save"></i> {{$etykieta_zapisz_kolejnosc}}</a>
	<a href="{{$urlWstecz}}" class="btn">{{$etykieta_wstecz}}</a>
	<form action="" method="post" id="kolejnoscForm">
		<input type="hidden" name="kolejnosc" id="kolejnosc"/>
	</form>
	<script type="text/javascript">
	$(".zapisz").hide();
	$(document).ready(function(){
		$(".zapisz").live('click', function(){
			$("#kolejnosc").val($("#sortowanie").sortable("toArray"));
			$("#kolejnoscForm").submit();
		});
		
		$( ".ui-sortable" ).sortable({
			placeholder: 'placeholder',
			helper: "box",
			opacity: 0.8,
			update: function(){
				if (! $(".row-fluid").find("#zapiszKolejnosc").length)
				{
					$(".zapisz").slideDown("fast");
				}
			}
		});
		$( ".ui-sortable" ).disableSelection();
	});
	</script>
{{END}}