<div class="section">
        <div class="info-gray clearfix">
        {{BEGIN jest_zdjecie}}
        	<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$zdjecie_name}}" {{$atrybuty}} />
        	{{IF $pokaz_nazwe}}<a href="{{$sciezka_plikow}}{{$zdjecie_name}}" class="nazwaZdjecia">{{$zdjecie_name}}</a>{{END}}
        	{{IF $miniaturka}}
        		<a href="{{$sciezka_plikow}}{{$zdjecie_name}}" rel="lightbox" class="podgladZdjecia"><img class="inputZdjecieMiniatura" alt="" src="{{$sciezka_plikow}}{{$link_miniaturka}}{{$cacheDumper}}"></a>
        	{{END}}
			<div class="btn-group control">
        		{{BEGIN usun}}<a href="{{$link_usun}}" class="remove btn btn-mini btn-danger" title="{{$etykieta_usun}}" {{IF $potwierdz_usun}} onclick="return potwierdzenieUsun('{{$etykieta_usun_pytanie}}', $(this), '{{$etykieta_usun_tytul}}')"{{END}}><i class="icon-remove"></i> {{$etykieta_usun}}</a>{{END}}
        		{{IF $popraw_miniature}}<a href="javascript:void(0);" class="btn btn-mini btn-primary" id="{{$nazwa}}_link_popraw" title="{{$etykieta_popraw}}"><i class="icon-edit"></i> {{$etykieta_popraw}}</a>{{END}}
       		</div>
        	<div class="upload {{$nazwa}}">
        	{{IF $opis}}{{$etykieta_opis}} <input type="text" name="{{$nazwa}}_title" id="{{$nazwa}}_title" value="{{$zdjecie_description}}" /><br />{{END}}
			{{IF $pokaz_dozwolone_typy}}<p>{{$etykieta_dozwolone_typy}} {{$dozwolone_typy}}</p>{{END}}
			</div>
        {{END}}
        {{BEGIN brak_zdjecia}}
        	<div class="upload"><input type="file" name="{{$nazwa}}" id="{{$nazwa}}" value="" {{$atrybuty}} /></div>
        	{{IF $pokaz_dozwolone_typy}}<p>{{$etykieta_dozwolone_typy}} {{$dozwolone_typy}}</p>{{END}}
			<script>
				$(document).ready( function () {
					$('#{{$nazwa}}').uniform({"fileDefaultText":"{{$input_plik_etykieta_nie_wybrano}}", " fileBtnText":"{{$input_plik_etykieta_wybierz}}"});
				});
			</script>
        {{END}}
		</div>
	</div>
	{{BEGIN obsluga_poprawy_miniaturek}}
		<script>
			$(document).ready(function () {
				$('#{{$nazwa}}_link_popraw').live('click', function () {
					$('#oknoModalne .modal-body').html('<iframe src="{{$link_popraw_miniaturke}}" frameborder="0" width="100%"></iframe>');
					$('#oknoModalne').modal('show');
				});
			});
		</script>
	{{END}}