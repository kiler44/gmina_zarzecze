{{BEGIN index}}

{{END BLOCK}}


{{BEGIN importApartamenty}}
<h3>{{$nazwa_projektu}}</h3>
<div id="komunikatyBlok"></div>
<div class="excelForm">
	{{$form}}
</div>

<div id="excelPreview" class="">
	
</div>
<script type="text/javascript">
	$('#excel').submit(function(e) {
		$('.mobile-loader').fadeIn();
		if ($('#excelFile').val() != '')
		{
			$('#komunikatyBlok').html('');
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '{{$url_wyslij_plik}}',
				type: 'POST',
				dataType: 'json',
				data: formData,
				processData: false,
				contentType: false,
				success: function(dane){
					if (dane.success)
					{
						location.href = '{{$url_przydzielanie}}';
					}
					else
					{
						$('.mobile-loader').fadeOut();
						$('#komunikatyBlok').html(dane.komunikaty);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('.mobile-loader').fadeOut("normal");
					var error = 'Upload failed:  '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
					
				}
			});
		}
		else
		{
			$('.mobile-loader').fadeOut();
			$('#komunikatyBlok').html('<div class="alert alert-warning ">{{$komunikat_brak_pliku}} <a class="close" data-dismiss="alert" href="#">×</a></div>');
		}
		e.preventDefault();
	});
</script>
{{END BLOCK}}