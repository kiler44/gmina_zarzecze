<div class="section">
		<div class="info-gray clearfix">{{BEGIN jest_zdjecie}}<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$zdjecie_name}}" {{$atrybuty}} />{{IF $link_miniaturka}}<a href="{{$sciezka_plikow}}{{$zdjecie_name}}" rel="lightbox"><img class="inputZdjecieMiniatura" alt="" src="{{$sciezka_plikow}}{{$link_miniaturka}}"></a>{{END}}<div class="right-upload">{{IF $link_usun}}<a onclick="if({{$potwierdz_usun}}){return confirmLightbox(this, \'{{$etykieta_usun_tytul}}\', \'{{$etykieta_usun_pytanie}}\', \'eWarning\', \'confirm\');}" href="{{$link_usun}}" class="remove" title="{{$etykieta_usun}}">{{$etykieta_usun}} <span></span></a>{{END}}<div class="upload {{$nazwa}}">{{IF $zdjecie_opis}}{{$etykieta_opis}}<input type="text" name="{{$nazwa}}_title" id="{{$nazwa}}_title" value="{{$zdjecie_description}}" /><br />{{END}}<a href="{{$sciezka_plikow}}{{$zdjecie_name}}">{{$zdjecie_name}}</a>{{IF $popraw_miniaturke}}<a href="javascript:void(0);" onclick="pokazUkryj{{$nazwa}}(\'#{{$nazwa}}_kontener\');" class="popraw_miniature" ><img src="/_system/admin/ikony/edytuj.gif" alt="{{$etykieta_popraw}}"/></a>{{END}}{{IF $wyswietlac_dozwolone_typy}}<p>{{$etykieta_dozwolone_typy}} {{$dozwolone_typy}}</p>{{END}}</div></div>{{END}}
		{{BEGIN brak_zdjecia}}
			<div class="upload"><input type="file" name="{{$nazwa}}" id="{{$nazwa}}" value="" {{$atrybuty}} />
			{{IF $wyswietlac_dozwolone_typy}}<p>{{$etykieta_dozwolone_typy}} {{$dozwolone_typy}})</p>{{END}}
			</div>
		{{END}}
		</div>
	</div>
	{{BEGIN obsluga_poprawy_miniaturki}}
		<div class="clear"></div>
		<div id="{{$nazwa}}_kontener" style="display: none;">
		<div style="float: left; margin-right: 6px;">
		{{BEGIN jeden_rozmiar}}
			<input type="hidden" id="{{$nazwa}}_ratio" name="{{$nazwa}}_ratio" value="{{$kod}}">
		{{END}}
		{{BEGIN wiele_rozmiarow}}
			{{$etykieta_wybierz}} <select name="{{$nazwa}}_ratio" id="{{$nazwa}}_ratio">{{BEGIN wiersze}}<option value="{{$kod}}">{{$kod}}</option>{{END}}</select>
		{{END}}
		</div>
		<a href="{{$link_popraw_miniaturke}}" id="{{$nazwa}}_popraw" class="button"><span>{{$etykieta_zatwierdz}}</span></a>
		<div class="clear"></div>
		<div id="{{$nazwa}}_ramka" class="ramka">
			<img src="{{$sciezka_plikow}}{{$zdjecie_name}}" alt="obraz" id="{{$nazwa}}_obraz">
		</div>
		<div id="{{$nazwa}}_ramka_podglad" class="ramka_podglad">
			<img src="{{$sciezka_plikow}}{{$zdjecie_name}}" alt="miniatura" id="{{$nazwa}}_obraz_podglad">
		</div>
		<div class="clear"></div>
		</div>

		<script type="text/javascript">
		<!--

		var {{$nazwa}}_avc = undefined;
		var {{$nazwa}}_jcrop = undefined;
		var tabelaRatio = new Array();
		{{BEGIN lista_js}}
			tabelaRatio["{{$kod}}"] = {{$ratio}};
		{{END}}


		var {{$nazwa}}_generuj = function(coords) {
			var rx = {{$nazwa}}_avc.h_podglad.width() / coords.w;
			var ry = {{$nazwa}}_avc.h_podglad.height() / coords.h;

			{{$nazwa}}_avc.h_miniatura.css({
				width: Math.round(rx * {{$nazwa}}_avc.h_obraz.width()) + "px",
				height: Math.round(ry * {{$nazwa}}_avc.h_obraz.height()) + "px",
				marginLeft: "-" + Math.round(rx * coords.x) + "px",
				marginTop: "-" + Math.round(ry * coords.y) + "px"
			});

			var x1 = parseFloat((coords.x / {{$nazwa}}_avc.h_obraz.width()) * 100);
			var y1 = parseFloat((coords.y / {{$nazwa}}_avc.h_obraz.height()) * 100);
			var x2 = parseFloat((coords.x2 / {{$nazwa}}_avc.h_obraz.width()) * 100);
			var y2 = parseFloat((coords.y2 / {{$nazwa}}_avc.h_obraz.height()) * 100);

			var link = "{{$link_popraw_miniaturke}}";
			link = link.replace("{X1}",x1).replace("{Y1}",y1).replace("{X2}",x2).replace("{Y2}",y2).replace("{KOD}", $("#{{$nazwa}}_ratio").val());
			$("#{{$nazwa}}_popraw").attr("href",link);
		}


		function pokazUkryj{{$nazwa}}() {
			if(pokazUkryj(\'#{{$nazwa}}_kontener\'))
			{
				if({{$nazwa}}_avc == undefined || {{$nazwa}}_jcrop == undefined)
				{
					{{$nazwa}}_avc = new avcreator("{{$nazwa}}");
					{{$nazwa}}_avc.obraz = { w: {{$nazwa}}_avc.h_obraz.width(), h: {{$nazwa}}_avc.h_obraz.height() }
					{{$nazwa}}_avc.skalujRamke();
					{{$nazwa}}_avc.korekta();
					{{$nazwa}}_avc.ustawRatio(tabelaRatio[$("#{{$nazwa}}_ratio").val()]);
					{{$nazwa}}_jcrop = $.Jcrop("#{{$nazwa}}_obraz");
					{{$nazwa}}_jcrop.setOptions({
						onChange: {{$nazwa}}_generuj,
						onSelect: {{$nazwa}}_generuj,
						aspectRatio: {{$nazwa}}_avc.ratio,
					});

					$("#{{$nazwa}}_ratio").change(function(){
						{{$nazwa}}_avc.ustawRatio(tabelaRatio[$("#{{$nazwa}}_ratio").val()]);
						{{$nazwa}}_jcrop.setOptions({
							aspectRatio: {{$nazwa}}_avc.ratio
						});
						{{$nazwa}}_avc.korekta();
					});
				}
				{{$nazwa}}_jcrop.enable();
				{{$nazwa}}_jcrop.focus();
			}
			else
			{
				{{$nazwa}}_jcrop.disable();
			}
		}
		-->
		</script>
	{{END}}