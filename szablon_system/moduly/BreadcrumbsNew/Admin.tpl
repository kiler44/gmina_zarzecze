{{BEGIN index}}
<div id="content-header">
	<h1>{{$tytul_modulu}}</h1>

	{{BEGIN opcje_standardowe}}
	<div class="btn-group admin">
		{{BEGIN tresc}}<a href="{{$link_tresc}}" class="btn btn-large tip-bottom" title="{{$etykieta_link_tresc}}"><i class="icon-file"></i></a>{{END}}
		{{BEGIN edycja}}<a href="{{$link_edycja}}" class="btn btn-large tip-bottom" title="{{$etykieta_link_edycja}}"><i class="icon-pencil"></i></a>{{END}}
		{{BEGIN konfiguracja}}<a href="{{$link_konfiguracja}}" class="btn btn-large tip-bottom" title="{{$etykieta_link_konfiguracja}}"><i class="icon-wrench"></i></a>{{END}}
		{{BEGIN tlumaczenia}}<a href="{{$link_tlumaczenia}}" class="btn btn-large tip-bottom" title="{{$etykieta_link_tlumaczenia}}"><i class="icon-flag"></i></a>{{END}}
	</div>
	{{END}}
	
	{{BEGIN opcje_kontekstowe}}
	<div class="btn-group">
		{{BEGIN opcja}}<a href="{{$url}}" class="btn btn-large tip-bottom" title="{{$etykieta}}"><i class="{{$ikona}}"></i></a>{{END}}
	</div>
	{{END}}
	<div class="clear"></div>
</div>
<div id="breadcrumb">
		{{BEGIN link}}<a href="{{$url}}" title="{{$nazwa}}" class="tip-bottom">{{$nazwa}}</a>{{END}}
		{{BEGIN tekst}}<a>{{$nazwa}}</a>{{END}}
</div>
	{{BEGIN jezyk}}
	<div id="lang">
		{{$etykieta_wybrany_jezyk}}
		<img src="/_system/admin/flagi/{{$wybrany_jezyk}}.gif" height="11" width="16" border="0" alt="{{$nazwa_wybrany_jezyk}}" class="flag-ico"/>
		{{$etykieta_zmien_jezyk}}
		{{BEGIN zmien}}&nbsp;<a href="{{$url}}" title="{{$etykieta}}"><img src="/_system/admin/flagi/{{$kod}}.gif" height="11" width="16" border="0" alt="{{$etykieta}}" class="flag-ico"/></a>{{END}}
	</div>
	{{END}}

{{IF $sprawdzajLokalizacje}}
<script type="text/javascript">
	function onPositionUpdate(position)
	{
		var lat = position.coords.latitude;
		var lng = position.coords.longitude;
		var accuracy = position.coords.accuracy;
		$.ajax({
			url: '{{$localizeUrl}}&lat=' + lat + '&lng=' + lng + '&accuracy='+ accuracy,
			type: 'POST',
			dataType: 'json',
			async: true,
			success: function(dane) {
				//$('#notesButtonContainer').html(dane);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//alert(xhr.status);
				//alert(thrownError);
			}
		});
		//console.log("Current position: " + lat + " " + lng + ' Accuracy: ' + position.coords.accuracy);
	}
	
	function handleError(error)
	{
		window.location.href = '{{$wylogujUrl}}';
	}
		
	if(navigator.geolocation)
	{
		navigator.geolocation.getCurrentPosition(onPositionUpdate, handleError);
	}
	else
	{
		handleError(null);
	}

	
	setInterval(function(){
		if(navigator.geolocation)
		{
			navigator.geolocation.getCurrentPosition(onPositionUpdate, handleError);
		}
	}, 120000);
</script>
{{END IF}}
{{END}}