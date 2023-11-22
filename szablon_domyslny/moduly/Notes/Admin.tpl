{{BEGIN index}}
<div class="widget-box">
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
	
	function usunNotatka(link)
	{
		$.ajax({
				url: link,
				type: 'POST',
				dataType: 'json',
				async: true,
				success: function(dane) {
					$('#oknoModalne #tabela').html(dane.grid);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
	}
	
	$(document).ready(function () {
		$('#wstecz').live('click', function(e){
			$('#oknoModalne').modal('hide');
		});
		$("#notes_form").live('submit', function() {
		$.ajax({
			url: linkGlobal,
			type: $('#notes_form').attr('method'),
			data: $('#notes_form').serialize(),
			dataType: 'json',
			async: true,
			success: function(dane) {
				if(dane.kod == '1' )
				{
					$('#miejsceNaFormularz').html(dane.info);
				}
				if(dane.kod == '2' )
				{
					$('#oknoModalne #tabela').html(dane.notatka);
					$('#miejsceNaFormularz').html(dane.formularz);
					if (linkGlobal.indexOf("editNote") >= 0)
					{
						$('#oknoModalne').attr('aria-hidden', 'true');
						$('#oknoModalne').modal('hide');
						window.location.reload();
					}
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
			}
		)
		return false;
	})
});
</script>
{{$tabela_danych}}
 
<a class="btn tip-top" onclick="return otworzOkno(this.href);" href="{{$linkAjax}}" > dodaj </a>
 
</div>
{{END}}

{{BEGIN dodaj}}
<script src="/_system/js/jquery.jeditable.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		$('.edit_textarea').editable('{{$url_ajax_edycja}}', { 
         type      : 'textarea',
         cancel    : '{{$przycisk_cancel}}',
         submit    : '{{$przycisk_ok}}',
         indicator : '<img src="/_system/img/spinner.gif">',
         tooltip   : '{{$jeditable_tooltip}}',
			width     : 650,
			height    : 70,
		
     });
	  
	  $('#pokazDodaj').live('click', function(){
		  $(this).fadeOut("fast");
		  $('#toggler').slideDown("fast");
	  });
	  $('#hideDodaj').live('click', function(){
		  $('#toggler').slideUp("fast");
		  $('#pokazDodaj').fadeIn("fast");
	  });

	});
</script>

{{IF $nieWyswietlajLista}}<a class="btn margin" id="pokazDodaj"><i class="incon icon-plus-sign"></i> {{$etykieta_dodaj}}</a>{{END}}
<div id="toggler" {{IF $nieWyswietlajLista}} class="hide clear closing" {{END}}>
	{{IF $nieWyswietlajLista}}<button id="hideDodaj" aria-hidden="true" class="close" type="button">×</button>{{END}}
	<div id="miejsceNaFormularz" >
		{{$form}}
	</div>
</div>

<div id="tabela" class="clear">

{{$tabela_danych}}
</div>
{{END}}