{{BEGIN html}}
	<div class="menedzer_plikow widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-file"></i>
			</span>
			<h5>{{$menedzer_plikow_nazwa}}</h5>
		</div>
		<div class="widget-content nopadding">
			<div class="menu">
				<div class="header"><h5>{{$menedzer_plikow_menu}}</h5></div>
				<div class="listaMenu">
				<ul>
					<li>
						<span class="toggle"><a href="{{$link}}" id="root" alt="" class="droppable katalog"><i class="icon-folder-open"></i> {{$menedzer_plikow_glowna}}</a></span>
						{{$menu}}
					</li>
				</ul>
				</div>
			</div>
			<div class="pliki">
				{{$pliki}}
			</div>
			<div style="clear:both;"></div>
			<div class="menedzer_plikow_img"></div>
		</div>
	</div>
{{END}}


{{BEGIN lista}}<ul class="{{$class}}">{{$lista}}</ul>{{END}}

{{BEGIN menu}}
	{{BEGIN katalog}}<li><span class="toggle"><a style="padding-left:{{$poziom}}0px;" id="{{$id}}" class="droppable katalog" alt="{{$title}}" href="{{$link}}"><i class="icon-folder-open"></i> {{$plik}}</a></span>{{$lista}}</li>{{END}}
	{{BEGIN plik}}<li><a id="{{$id}}" class="droppable plik" title="{{$title}}/" href="{{$link}}">{{$plik}}</a></li>{{END}}
{{END}}

{{BEGIN pliki}}
	{{BEGIN tabela}}
	<div class="alertKontener">
		<div class="alert">{{$komunikat}}</div>
	</div>
	{{$form}}
	<div class="fullurl header" title="/{{$fullurl}}"><h5>Url:&nbsp;/{{$fullurl}}</h5></div>
	<div class="tabela">
	<table class="pliki table table-condensed table-hover">
		<thead>
			<tr class="info"><th class="type"></th><th class="nazwa cssHeader"><strong>{{$menadzer_etykieta_kolumna_nazwa}}</strong></th><th class="cssHeader"><strong>{{$menadzer_etykieta_kolumna_typ}}</strong></th><th class="cssHeader"><strong>{{$menadzer_etykieta_kolumna_rozmiar}}</strong></th><th class="cssHeader"><strong>{{$menadzer_etykieta_kolumna_data}}</strong></th><th class="cssHeader"><strong></strong></th></tr>
		</thead>
		<tbody>{{$pliki}}<tbody>
	</table>
	</div>
	{{END}}

	{{BEGIN form}}
		<script type="text/javascript"><!--
			$("document").ready(function()
			{
				{{BEGIN przenoszenie}}
				$("div.menedzer_plikow").find(".pliki").find("a.draggable").draggable({ revert: "true", helper: "clone" });
				$("div.menedzer_plikow").find(".menu").find("a.droppable").draggable({ revert: "true", helper: "clone" });
				$("div.menedzer_plikow").find(".menu").find("a.droppable").droppable({
					hoverClass: "ui-state-active",
					tolerance: "pointer",
					drop: function(event, ui) {
						var nazwa1 = ui.draggable.attr("item");
						var sciezka1 = ui.draggable.attr("alt");
						var nazwa2 = $(this).attr("item");
						var sciezka2 = $(this).attr("alt");
						var test = sciezka2.substr(0,sciezka1.length);
						if(sciezka1 != test)
						{
							mp_przenies(sciezka1,sciezka2+nazwa1);
						}
						else
						{
							$("div.menedzer_plikow").find(".pliki").find(".alert").html("Nie można tutaj przenieś tego elementu");
						}
					}
				});
				$("div.menedzer_plikow").find(".pliki").find("a.droppable").droppable({
					hoverClass: "ui-state-active",
					tolerance: "pointer",
					drop: function(event, ui) {
						var nazwa1 = ui.draggable.attr("item");
						var sciezka1 = ui.draggable.attr("alt");
						var nazwa2 = $(this).attr("item");
						var sciezka2 = $(this).attr("alt");
						var test = sciezka2.substr(0,sciezka1.length);
						if(sciezka1 != test)
						{
							mp_przenies(sciezka1,sciezka2+"/"+nazwa1);
						}
						else
						{
							$("div.menedzer_plikow").find(".pliki").find(".alert").html("Nie można tutaj przenieś tego elementu");
						}
					}
				});
				{{END}}

				{{BEGIN podglad}}
				<!-- GENEROWANIE PODGLADU Z LINKU DO DOWNLOADU! -->
				$("div.menedzer_plikow").find(".pliki").find("a.obrazek").mouseover(function(e) {
					var img = new Image();
					var mouseX = e.pageX - this.offsetLeft;
					var mouseY = e.pageY - this.offsetTop;
					$(img).load(function(e) {
						$("div.menedzer_plikow_img").css("top", (mouseY+20)+"px").css("left", (mouseX+20)+"px").append(this).show();
						$(document).mousemove(function(e) {
							$("div.menedzer_plikow_img").css("top", (e.pageY - 200)+"px").css("left", (e.pageX+20)+"px");
						});
					});
					$(img).attr("src",$(this).attr("min"));
				});
				$("div.menedzer_plikow").find(".pliki").find("a.obrazek").mouseout(function(e) {
					$("div.menedzer_plikow_img").hide();
					$("div.menedzer_plikow_img").find("img").remove();
				});
				$("div.menedzer_plikow").mouseover(function(e) {
					$("div.menedzer_plikow_img").find("img").remove();
					$("div.menedzer_plikow_img").hide();
				});
				{{END}}

				$("div.menedzer_plikow").find("td").find("a.edytuj").click(function(){
					mp_zmienNazwe(this.href, $(this).attr("title")); return false;
				});

				$("div.menedzer_plikow").find("td").find("a.usun").click(function(){
					return potwierdzenieUsun("{{$menedzer_plikow_usun}}", $(this));
				});

				$.tablesorter.addParser({
					id: "iqfilesize",
					is: function(s) {
						return false;
					},
					format: function(s) {
						if(s == "") { return 0; }
						var suf = s.match( new RegExp( /(kB|GB|MB|TB|B)$/ ) )[0];
						var num = parseFloat( s.match( new RegExp( /^[0-9]+(\.[0-9]+)?/ ) )[0] );
						switch( suf ) {
							case "kB":
								return num * 102400;
							case "MB":
								return num * 104857600;
							case "GB":
								return num * 107374182400;
							case "TB":
								return num * 109951162777600;
							case "B":
								return num * 100;
						}
					},
					type: "numeric"
				});

				$("div.menedzer_plikow").find("table.pliki").tablesorter({
					cssHeader: "table_naglowek",
					cssAsc: "table_asc",
					cssDesc: "table_desc",
					headers: {
						3: { sorter : "iqfilesize" },
						5: { sorter : false },
					},
					sortForce: [[0,0]]
				});
			});

			function mp_zmienNazwe(link, plik)
			{
				var komunikat = "{{$menedzer_plikow_zmienNazwe}}";
				var lastPos = plik.lastIndexOf(".");
				if(lastPos >= 0)
				{
					plik = plik.slice(0, lastPos);
				}

				oknoEdytujWartosc(komunikat, plik, function () {
					var popraw = "{{$menedzer_plikow_poprawNazwe}}";
					var nazwa = $('#edytujWartoscOknoPole').val();
					var test = mp_poprawNazwe(nazwa);

					if (nazwa == null || nazwa == "")
					{
						oknoEdytujWartoscZamknij();
						return false;
					}

					if (test != nazwa)
					{

						if (test != nazwa)
						{
							$('#edytujWartoscOknoOpis').html(popraw)
							$('#edytujWartoscOknoPole').val(test);
						}
					}
					else
					{
						nazwa = nazwa.replace("&", "%26");
						link = link.replace("{NAZWA}",nazwa);
						if(nazwa != "" && nazwa != null)
						{
							window.location = link;
						}
					}

				});




			}

			function mp_przenies(zrodlo,cel)
			{
				var link = "{{$link_przenies}}";
				link = link.replace("{ZRODLO}",zrodlo).replace("{CEL}",cel);
				window.location = link;
			}

			function mp_poprawNazwe(test)
			{
				test = test.replace(/ę/i,"e");
				test = test.replace(/ż/i,"z");
				test = test.replace(/ó/i,"o");
				test = test.replace(/ł/i,"l");
				test = test.replace(/ć/i,"c");
				test = test.replace(/ś/i,"s");
				test = test.replace(/ź/i,"z");
				test = test.replace(/ń/i,"n");
				test = test.replace(/ą/i,"a");
				test = test.replace(/Ą/i,"A");
				test = test.replace(/[^-_A-Z0-9\s\.]/gi, "");
				test = test.replace(/^\s+|\s+$/g, "");
				test = test.replace(/\s+/g, "_");
				return test;
			}

			function mp_popraw(e)
			{
				if(e.value.length == 0) { alert("{{$menedzer_plikow_kom_zlaNazwa}}"); return false; }
				var kom = "{{$menedzer_plikow_poprawNazwe}}";
				var nazwa = e.value;
				e.value = test = mp_poprawNazwe(nazwa);
				if(test != nazwa) { alert("{{$menedzer_plikow_poprawNazwe}}"); return false; }
				return true;
			}

			function SetUrl(fileUrl){
				window.top.opener.CKEDITOR.tools.callFunction("{{$CKEditorFuncNum}}", "{{$download}}"+fileUrl);
				window.top.close();
				window.top.opener.focus();
				return false;
			}
		--></script>

				{{BEGIN upload}}
				<div class="uploadPlikow">
					<div class="header">
						<h5 style="margin-bottom: 3px;">{{$menedzer_etykieta_upload}}</h5>
					</div>
					<form action="{{$link_upload}}" method="post" name="plik" enctype="multipart/form-data">
						<input type="hidden" name ="MAX_FILE_SIZE" value="{{$max_rozmiar}}" />
						<input type="file" id="plik" name="plik" />
						<input class="btn" type="submit" name="upload" value="{{$menedzer_plikow_wyslij}}" />
						<script>
							$(document).ready( function () {
								$('#plik').uniform();
							});
						</script>
					</form>
				</div>
				{{END}}
				{{BEGIN tworzenieKatalogow}}
				<div class="tworzenieKatalogow">
					<div class="header">
						<h5 style="margin-bottom: 3px;">{{$menedzer_etykieta_katalogi}}</h5>
					</div>
					<form action="{{$link_nowy}}" method="post" name="plik">
						<div class="input-append">
							<input type="text" name="nazwa" />
							<input class="btn" type="submit" name="nowy_folder" value="{{$menedzer_plikow_stworz}}" onclick="if(!mp_popraw(this.form.nazwa)) { return false; };" />
						</div>
					</form>
				</div>
				{{END}}
	{{END}}

	{{BEGIN wiersz}}
		{{BEGIN gora}}
		<tr class="gora">
			<td class="type">1</td>
			<td class="nazwa">
				<a href="{{$link}}" class="gora droppable" alt="{{$title}}" item="{{$plik}}">
					<i class="icon-reply"></i> {{$plik}}
				</a>
			</td>
			<td class="typ"></td>
			<td class="rozmiar"></td>
			<td class="data"></td>
			<td class="opcje"></td>
		</tr>
		{{END}}
		{{BEGIN katalog}}
		<tr class="katalog">
			<td class="type">2</td>
			<td class="nazwa">
				<a href="{{$link}}" id="{{$id}}" class="draggable droppable katalog nazwa" alt="{{$title}}" item="{{$plik}}">
					<i class="icon-folder-close"></i> {{$plik}}
				</a>
			</td>
			<td class="typ"></td>
			<td class="rozmiar"></td>
			<td class="data"></td>
			<td class="opcje">
				<div class="btn-group">
					{{BEGIN zmienNazwe}}<a href="{{$link_zmienNazwe}}" title="{{$plik}}" class="btn btn-mini btn-primary edytuj"><i class="icon-pencil"></i></a>{{END}}
					{{BEGIN usun}} <a href="{{$link_usun}}" class="btn btn-mini btn-danger usun"><i class="icon-remove"></i></a>{{END}}
				</div>
			</td>
		</tr>
		{{END}}
		{{BEGIN plik}}
		<tr class="plik">
			<td class="type">3</td>
			<td class="nazwa">
				<a {{BEGIN ckeditor}}onclick=" if(!SetUrl('{{$title}}')) { return false; }"{{END}} href="{{$link}}" id="{{$id}}" class="draggable plik {{$typ}} nazwa {{$class}}" alt="{{$title}}" min="{{$link_min}}" item="{{$plik}}">
					<i class="icon-file"></i> {{$plik}}
				</a>
			</td>
			<td class="typ">{{$typ}}</td>
			<td class="rozmiar">{{$rozmiar}}</td>
			<td class="data">{{$data}}</td>
			<td class="opcje">
				<div class="btn-group">
					{{BEGIN zmienNazwe}}<a href="{{$link_zmienNazwe}}" title="{{$plik}}" class="btn btn-mini btn-primary edytuj"><i class="icon-pencil"></i></a>{{END}}
					{{BEGIN usun}} <a href="{{$link_usun}}" class="btn btn-mini btn-danger usun"><i class="icon-remove"></i></a>{{END}}
				</div>
			</td>
		</tr>
		{{END}}
	{{END}}
{{END}}