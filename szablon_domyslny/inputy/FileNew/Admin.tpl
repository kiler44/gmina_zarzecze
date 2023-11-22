{{BEGIN jest_plik}}
	{{IF $plik_opis}}{{$etykieta_opis}}<input type="text" name="{{$nazwa}}_title" id="{{$nazwa}}_title" value="{{$plik_opis}}" /><br />{{END}}
	<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$plik_nazwa}}" {{$atrybuty}} />
	{{IF $sciezka}}<a href="{{$sciezka_do_plikow}}{{$plik_nazwa}}">{{$plik_nazwa}}</a>{{ELSE}}{{$plik_nazwa}}{{END}}
	{{IF $usun}}<a href="{{$link_usun}}" class="usun_zdjecie" title="{{$etykieta_usun}}"><img src="/_system/admin/ikony/usun.gif" alt="{{$etykieta_usun}}"/></a>{{END}}
	<br/>
{{END}}
{{BEGIN upload}}
	<div class="upload"><input type="file" name="{{$nazwa}}" id="{{$nazwa}}" value="" {{$atrybuty}} /></div>
	<script>
		$(document).ready( function () {
			$('#{{$nazwa}}').uniform({"fileDefaultText":"{{$input_plik_etykieta_nie_wybrano}}", " fileBtnText":"{{$input_plik_etykieta_wybierz}}"});
		});
	</script>
{{END}}