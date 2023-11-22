<?php
namespace Generic\Biblioteka;

use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Grafika;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Szablon;
use Generic\Tlumaczenia;


/**
 * Webowy interfejs do zarządzania plikami
 *
 * @author Dariusz Półtorak
 *
 * TODO: większość z tego kodu trzeba przepisać
 * @package biblioteki
 */

class MenedzerPlikow
{

	//halt decyduje czy zatrzymac dzialanie programu
	protected $halt = false;

	//Korzen drzewa z wybranego trybu
	protected $korzen = null;


	//Link download dla trybow
	protected $download = null;


	//Obiekt szablonu blitz
	protected $szablon = null;


	// Ilosc wyswietlen - limi 1
	protected static $wyswietlen = 0;


	//CKeditor
	protected $ckeditor = false;
	
	/**
	 * @var \Generic\Tlumaczenie\Pl\Biblioteka\MenedzerPlikow
	 */
	protected $j;

	protected $konfiguracja = array(
		'CKEditorFuncNum' => null,
		'link_katalog' => '?sciezka={SCIEZKA}',
		'link_usun' => '?sciezka={SCIEZKA}&usun={USUN}',
		'link_zmienNazwe' => '?sciezka={SCIEZKA}&plik={PLIK}&zmienNazwe={NAZWA}',
		'link_przenies' => '?sciezka={SCIEZKA}&przenies={ZRODLO}&do={CEL}',
		'link_nowy' => '?sciezka={SCIEZKA}',
		'link_upload' => '?sciezka={SCIEZKA}',
		'przenoszenie' => true,
		'usuwanie' => true,
		'zmianaNazwy' => true,
		'upload' => true,
		'tworzenie_katalogow' => true,
		'akceptowane_rozszerzenia' => false,
		'pliki_do_wyswietlenia' => false,			// URL do wyswietlenia - false by wyswietlic wszystko - array() by nie wyswietlac niczego, array('jakis/url') by wyswietlic jakis/url
		'max_rozmiar_plikow' => 6400000,		// Maksymalny rozmiar plikow
		'podglad_miniatur' => false,				// Podgląd obrazków w menedżerze - nie włączać dopóki nie napiszemy generowania miniatur
		'rozszerzenia_dla_miniatur' => array('bmp', 'gif', 'jpg', 'jpeg', 'png', 'svg'),
		'wielkosc_miniatury' => array(
			'szerokosc' => 90,
			'wysokosc' => 90,
		),
		'katalog_miniaturek' => '',
		'url_miniaturek' => '',
	);


	protected $komunikat = null;


	protected $tpl = '
		{{BEGIN html}}
		DIP
			<div class="menedzer_plikow">
				<h3>{{$menedzer_plikow_nazwa}}</h3>
				<div class="menu">
					<b class="gl"></b>
					<b class="gr"></b>
					<b class="dl"></b>
					<b class="dr"></b>
					<h3>{{$menedzer_plikow_menu}}</h3>
					<div class="listaMenu">
					<ul>
						<li>
							<span class="toggle"><a href="{{$link}}" id="root" alt="" class="droppable katalog">{{$menedzer_plikow_glowna}}</a></span>
							{{$menu}}
						</li>
					</ul>
					</div>
				</div>
				<div class="pliki">
					<b class="gl"></b>
					<b class="gr"></b>
					<b class="dl"></b>
					<b class="dr"></b>
					{{$pliki}}
				</div>
				<div class="menedzer_plikow_img""></div>
			</div>
		{{END}}


		{{BEGIN lista}}<ul class="{{$class}}">{{$lista}}</ul>{{END}}

		{{BEGIN menu}}
			{{BEGIN katalog}}<li><span class="toggle"><a id="{{$id}}" class="droppable katalog" alt="{{$title}}/" href="{{$link}}">{{$plik}}</a></span>{{$lista}}</li>{{END}}
			{{BEGIN plik}}<li><a id="{{$id}}" class="droppable plik" title="{{$title}}/" href="{{$link}}">{{$plik}}</a></li>{{END}}
		{{END}}

		{{BEGIN pliki}}
			{{BEGIN tabela}}
			<div class="alert">{{$komunikat}}</div>
			{{$form}}
			<div class="fullurl" title="/{{$fullurl}}"><strong>Url:&nbsp;</strong>/{{$fullurl}}</div>
			<div class="tabela">
			<table class="pliki">
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
								var nazwa1 = ui.draggable.html();
								var sciezka1 = ui.draggable.attr("alt");
								var nazwa2 = $(this).html();
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
								var nazwa1 = ui.draggable.html();
								var sciezka1 = ui.draggable.attr("alt");
								var nazwa2 = $(this).html();
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
							var mouseX = e.pageX;
							var mouseY = e.pageY;
							$(img).load(function(e) {
								$("div.menedzer_plikow_img").css("top", (mouseY+20)+"px").css("left", (mouseX+20)+"px").append(this).show();
								$(document).mousemove(function(e) {
									$("div.menedzer_plikow_img").css("top", (e.pageY+20)+"px").css("left", (e.pageX+20)+"px");
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
							return confirm("{{$menedzer_plikow_usun}}");
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
						var kom = "{{$menedzer_plikow_zmienNazwe}}";
						var popraw = "{{$menedzer_plikow_poprawNazwe}}";
						var lastPos = plik.lastIndexOf(".");
						if(lastPos >= 0)
						{
							plik = plik.slice(0, lastPos);
						}
						do
						{
							var nazwa = prompt(kom, plik);
							if(nazwa == null || nazwa == "") { return false; }
							test = mp_poprawNazwe(nazwa);
							if(test != nazwa) { plik = test; kom = popraw; }
						}
						while(test != nazwa);
						nazwa = nazwa.replace("&", "%26");
						link = link.replace("{NAZWA}",nazwa);
						if(nazwa != "" && nazwa != null)
						{
							window.location = link;
						}
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

				<table class="form">
					<tr>
						{{BEGIN upload}}<td><h4 style="margin-bottom: 3px;">{{$menedzer_etykieta_upload}}</h4><form action="{{$link_upload}}" method="post" name="plik" enctype="multipart/form-data"><input type="submit" name="upload" value="{{$menedzer_plikow_wyslij}}" /><input type="hidden" name ="MAX_FILE_SIZE" value="{{$max_rozmiar}}" /><input type="file" name="plik" /></form></td>{{END}}
						<td class="separator"></td>
						{{BEGIN tworzenieKatalogow}}<td><h4 style="margin-bottom: 3px;">{{$menedzer_etykieta_katalogi}}</h4><form action="{{$link_nowy}}" method="post" name="plik"><input type="text" name="nazwa" /><input type="submit" name="nowy_folder" value="{{$menedzer_plikow_stworz}}" onclick="if(!mp_popraw(this.form.nazwa)) { return false; };" /></form></td>{{END}}
					</tr>
				</table>
			{{END}}

			{{BEGIN wiersz}}
				{{BEGIN gora}}<tr class="gora"><td class="type">1</td><td class="nazwa"><a href="{{$link}}" class="gora droppable" alt="{{$title}}">{{$plik}}</a></td><td class="typ"></td><td class="rozmiar"></td><td class="data"></td><td class="opcje"></td></tr>{{END}}
				{{BEGIN katalog}}<tr class="katalog"><td class="type">2</td><td class="nazwa"><a href="{{$link}}" id="{{$id}}" class="draggable droppable katalog nazwa" alt="{{$title}}">{{$plik}}</a></td><td class="typ"></td><td class="rozmiar"></td><td class="data"></td><td class="opcje">{{BEGIN zmienNazwe}}<a href="{{$link_zmienNazwe}}" title="{{$plik}}" class="edytuj"></a>{{END}}{{BEGIN usun}} <a href="{{$link_usun}}" class="usun"></a>{{END}}</td></tr>{{END}}
				{{BEGIN plik}}<tr class="plik"><td class="type">3</td><td class="nazwa"><a {{BEGIN ckeditor}}onclick=" if(!SetUrl(\'{{$title}}\')) { return false; }"{{END}} href="{{$link}}" id="{{$id}}" class="draggable plik {{$typ}} nazwa {{$class}}" alt="{{$title}}" min="{{$link_min}}">{{$plik}}</a></td><td class="typ">{{$typ}}</td><td class="rozmiar">{{$rozmiar}}</td><td class="data">{{$data}}</td><td class="opcje">{{BEGIN zmienNazwe}}<a href="{{$link_zmienNazwe}}" title="{{$plik}}" class="edytuj"></a>{{END}}{{BEGIN usun}} <a href="{{$link_usun}}" class="usun"></a>{{END}}</td></tr>{{END}}
			{{END}}
		{{END}}
	';


	/*
	 * Drukowanie na ekran menedzera plikow
	 * @param string $sciezka - Sciezka do wybranego katalogu
	 * @param int $poziom - ilosc przejsc rekurencji
	 */
	public function html($sciezka ='', $poziom = 99)
	{
		//echo $this->tpl
		if($this->halt == true) {
			return $this->komunikat;
		}
		$global_config = array(
			'cfg_przenoszenie' => $this->konfiguracja['przenoszenie'],
			'cfg_usuwanie' => $this->konfiguracja['usuwanie'],
			'cfg_zmianaNazwy' => $this->konfiguracja['zmianaNazwy'],
			'cfg_upload' => $this->konfiguracja['upload'],
			'cfg_tworzenieKatalogow' => $this->konfiguracja['tworzenie_katalogow'],
		);
		$this->j->t['CKEditorFuncNum'] = $this->konfiguracja['CKEditorFuncNum'];
		if(self::$wyswietlen < 0)
		{
			trigger_error("Menedżer nie może zostać wyświetlony ze względu na błędną konfigurację", E_USER_WARNING);
			return false;
		}
		self::$wyswietlen++;
		if(self::$wyswietlen > 1)
		{
			trigger_error("Nie można wyświetlić menedżera plików więcej jak raz z jednego obiektu", E_USER_WARNING);
			return false;
		}
		$poziom = (int)$poziom;
		$this->inicjujSzablon();
		$this->szablon->ustawGlobalne($this->j->t);
		$this->szablon->ustawGlobalne($global_config);
		$test = $this->sprSciezke($sciezka);
		if ($test === false) { $sciezka = ""; }
		return $this->szablon->parsujBlok('/html', array(
			'menu' => $this->wypiszDrzewo('',$poziom),
			'pliki' => $this->wypiszPliki($sciezka),
			'link' => str_replace('{SCIEZKA}', '', $this->konfiguracja['link_katalog'])
		));
	}



	public function przenies($przenies,$do, $nadpisz = true)
	{
		$przenies = str_replace('\\', '/', $przenies);
		$do = str_replace('\\', '/', $do);
		$do = str_replace('//', '/', $do);
		$przeniesMin = $przenies;
		$doMin = $do;
		if($this->konfiguracja['przenoszenie'] == false) {
			$this->komunikat = $this->j->t['menedzer_plikow_kom_przenoszenieOff'];
			return false;
		}
		$wynik = $this->sprSciezke($przenies);
		if(!$wynik) { return false; }
		$przenies = $wynik['sciezka'].$wynik['plik'];
		$plik = $wynik['plik'];
		$wynik = $this->sprSciezke(dirname($do));
		if(!$wynik) { return false; }
		$do = $wynik['sciezka'];
		if(is_file($przenies))
		{
			if($przenies == $do.$plik)
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_przenoszenieBlad'];
				return false;
			}
			if($nadpisz != false)
			{
				$rozszerzenie = $this->rozszerzenie($plik);
				$nazwa = substr($plik,0,'-'.(strlen($rozszerzenie)+1));
				if(strlen($rozszerzenie)+1 >= strlen($plik))
				{
					$nazwa = $plik;
					$rozszerzenie = '';
				}
				else
				{
					if(trim($rozszerzenie) != '') { $rozszerzenie = '.'.$rozszerzenie; }
				}
				$i = 0;
				while(file_exists($do.$plik))
				{
					$plik = sprintf('%s(%d)%s',$nazwa, ++$i, $rozszerzenie);
				}
			}
			$x = rename($przenies,$do.$plik);
			if($x)
			{

				if($this->konfiguracja['katalog_miniaturek'] != '')
				{
					$wynik2 = $this->sprSciezkeMiniatur($przeniesMin);
					$wynik3 = $this->sprSciezkeMiniatur(dirname($doMin));
					if($wynik2 && $wynik3)
					{
						$przeniesMin = $wynik2['sciezka'];
						$doMin = $wynik3['sciezka'];
						rename($przeniesMin.$wynik2['plik'], $doMin.$plik);
					}
				}

				$this->komunikat = $this->j->t['menedzer_plikow_kom_przenoszenie'];
				return array(
					'stara' => $przenies,
					'nowa' => $do.$plik
				);
			}
			else
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_przenoszenieBlad'];
				return false;
			}
		}
		elseif(is_dir($przenies))
		{
			$k = new Katalog($przenies);
			if($przenies[strlen($przenies)-1] == '/') $przenies = substr($przenies,0,-1);
			$katalog = basename($przenies);
			if($przenies == $do.$katalog)
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_przenoszenieBlad'];
				return false;
			}
			$x = $k->przeniesDo($do.$katalog,false);
			if($x)
			{
				if($this->konfiguracja['katalog_miniaturek'] != '')
				{
					$wynik2 = $this->sprSciezkeMiniatur($przeniesMin);
					$wynik3 = $this->sprSciezkeMiniatur(dirname($doMin));
					if($wynik2 && $wynik3)
					{
						$przeniesMin = $wynik2['sciezka'];
						if($przeniesMin[strlen($przeniesMin)-1] == '/') $przeniesMin = substr($przeniesMin,0,-1);
						$doMin = $wynik3['sciezka'];
						$kmin = new Katalog($przeniesMin);
						$katalogMin = end(explode('/', $przeniesMin));
						$kmin->przeniesDo($doMin.$katalogMin);
					}
				}
				$this->komunikat = $this->j->t['menedzer_plikow_kom_przenoszenie'];
			}
			else
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_przenoszenieBlad'];
			}
			return $x;
		}
		else
		{
			$this->komunikat = $this->j->t['menedzer_plikow_kom_przenoszenieBlad'];
			return false;
		}
	}



	public function zapiszPlik($sciezka, $plik, $nadpisz = false)
	{
		if ($this->konfiguracja['upload'] == false)
		{
			$this->komunikat = $this->j->t['menedzer_plikow_kom_uploadOff'];
			return false;
		}
		if ($plik['error'] == 2 || $plik['size'] > $this->konfiguracja['max_rozmiar_plikow'])
		{
			$this->komunikat = sprintf($this->j->t['menedzer_plikow_kom_zlyRozmiar'], $this->bajtyNa($this->konfiguracja['max_rozmiar_plikow']));
			return false;
		}
		if ($plik['error'] != 0)
		{
			$this->komunikat = $this->j->t['menedzer_plikow_kom_uploadBlad'];
			return false;
		}
		$plik['name'] = $this->poprawNazwe($plik['name']);
		if ($plik['name'] == '') {
			$this->komunikat = $this->j->t['menedzer_plikow_kom_zlaNazwa'];
			return false;
		}
		$rozszerzenie = $this->rozszerzenie($plik['name']);

		if(is_array($this->konfiguracja['akceptowane_rozszerzenia']) && count($this->konfiguracja['akceptowane_rozszerzenia']) > 0 && !in_array(strtolower($rozszerzenie), $this->konfiguracja['akceptowane_rozszerzenia']))
		{
			$this->komunikat = $this->j->t['menedzer_plikow_kom_zleRozszerzenie'];
			return false;
		}
		if(strlen($rozszerzenie)+1 >= strlen($plik['name']))
		{
			$this->komunikat = $this->j->t['menedzer_plikow_kom_zleRozszerzenie'];
			return false;
		}

		$sciezkaMin = $sciezka;
		$mojasciezka = $this->sprSciezke($sciezka);
		if (!$mojasciezka) { return false; }
		$sciezka = $mojasciezka['sciezka'];
		$url = $mojasciezka['url'];
		if ($nadpisz == false)
		{
			$nazwa = substr($plik['name'],0,'-'.(strlen($rozszerzenie)+1));
			if (strlen($rozszerzenie)+1 >= strlen($plik['name']))
			{
				$nazwa = $plik['name'];
				$rozszerzenie = '';
			}
			else
			{
				if(trim($rozszerzenie) != '') { $rozszerzenie = '.'.$rozszerzenie; }
			}
			if(trim($nazwa) == '') { return false; }
			$i = 0;
			while(file_exists($sciezka.$plik['name']))
			{
				$plik['name'] = sprintf('%s(%d)%s',$nazwa, ++$i, $rozszerzenie);
			}
		}
		if (is_uploaded_file($plik['tmp_name']))
		{
			if(move_uploaded_file($plik['tmp_name'], $sciezka.$plik['name']))
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_upload'];
				$rozszerzenie = $this->rozszerzenie($plik['name']);
				if($this->konfiguracja['katalog_miniaturek'] != '' && in_array(strtolower($rozszerzenie), $this->konfiguracja['rozszerzenia_dla_miniatur']))
				{
					$wynik2 = $this->sprSciezkeMiniatur($sciezkaMin);
					if($wynik2 != false)
					{
						$sciezkaMin = $wynik2['sciezka'];
						$grafika = new Grafika(new Grafika\IMagic);
						$grafika->wczytaj($sciezka.$plik['name']);
						$grafika->skaluj($this->konfiguracja['wielkosc_miniatury']['szerokosc'], $this->konfiguracja['wielkosc_miniatury']['wysokosc']);
						$grafika->zapisz($sciezkaMin.$plik['name']);
					}
				}
				return $url.$plik['name'];
			}
			else
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_uploadBlad'];
				return false;
			}
		}
	}



	public function zmienNazwe($sciezka,$nazwa)
	{
		$sciezka = str_replace('\\', '/', $sciezka);
		$sciezkaMin = $sciezka;
		if($this->konfiguracja['zmianaNazwy'] == false) {
			$this->komunikat = $this->j->t['menedzer_plikow_kom_zmianaNazwyOff'];
			return false;
		}
		if(!$this->sprNazwe($nazwa)) {
			$this->komunikat = $this->j->t['menedzer_plikow_kom_zlaNazwa'];
			return false;
		}
		$nazwa = trim($nazwa);
		if(strpos($nazwa,'/') !== false || strpos($nazwa,'\\') !== false )
		{
			$this->komunikat = $this->j->t['menedzer_plikow_kom_zlaNazwa'];
			return false;
		}
		$nazwa = $this->poprawNazwe($nazwa);
		$wynik = $this->sprSciezke($sciezka);
		$wynik2 = $this->sprSciezkeMiniatur($sciezkaMin);
		if(!$wynik)
		{
			$this->komunikat = $this->j->t['menedzer_plikow_kom_zlaSciezka'];
			return false;
		}
		$sciezka = $wynik['sciezka'];
		$return = $wynik['url'];
		$plik = $wynik['plik'];

		if(is_file($sciezka.$plik))
		{
			if($nazwa != basename($nazwa)) { return false; }
			$ext = $this->rozszerzenie($plik);
			$nazwa .= '.'.$ext;

			if(!file_exists($sciezka.$nazwa))
			{
				$x = rename($sciezka.$plik, $sciezka.$nazwa);
				if($x)
				{

					if($this->konfiguracja['katalog_miniaturek'] != '')
					{
						$sciezkaMin = $wynik2['sciezka'];
						if(is_file($sciezkaMin.$plik))
						{
							if($nazwa != basename($nazwa)) { return false; }
							rename($sciezkaMin.$plik, $sciezkaMin.$nazwa);
						}
					}

					$this->komunikat = sprintf($this->j->t['menedzer_plikow_kom_zmianaNazwy'],htmlspecialchars($nazwa));
					return array(
						'stara' => $return.$plik,
						'nowa' => $return.$nazwa
					);
				}
				else
				{
					$this->komunikat = $this->j->t['menedzer_plikow_kom_zmianaNazwyBlad'];
					return false;
				}
			}
			else
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_zmianaNazwyBlad'];
				return false;
			}
		}
		elseif(is_dir($sciezka.$plik))
		{
			$tab = explode('/',$sciezka);
			$count = count($tab);
			$url = '/';
			for($i=0; $i < $count-2; $i++)
			{
				if($tab[$i] == '') { continue; }
				$url .= $tab[$i].'/';
			}
			if(!file_exists($url.$nazwa))
			{

				if($this->konfiguracja['katalog_miniaturek'] != '')
				{
					$sciezkaMin = $wynik2['sciezka'];
					$tabMin = explode('/',$sciezkaMin);
					$countMin = count($tabMin);
					$urlMin = '/';
					for($i=0; $i < $countMin-2; $i++)
					{
						if($tabMin[$i] == '') { continue; }
						$urlMin .= $tabMin[$i].'/';
					}
					rename($sciezkaMin, $urlMin.$nazwa);
				}

				$x = rename($sciezka, $url.$nazwa);
				if($x)
				{
					$this->komunikat = sprintf($this->j->t['menedzer_plikow_kom_zmianaNazwy'],htmlspecialchars($nazwa));
				}
				else
				{
					$this->komunikat = $this->j->t['menedzer_plikow_kom_zmianaNazwyBlad'];
				}
				return $x;
			}
			else
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_zmianaNazwyBlad'];
				return false;
			}
		}
	}



	public function nowyKatalog($sciezka,$nazwa)
	{
		if($this->konfiguracja['tworzenie_katalogow'] == false) {
			$this->komunikat = $this->j->t['menedzer_plikow_kom_tworzenieKatalogowOff'];
			return false;
		}
		$test = $nazwa;
		$nazwa = $this->poprawNazwe($nazwa);
		$zmiana = false;
		if($test != $nazwa) { $zmiana = true; }
		if($nazwa == '') {
			$this->komunikat = $this->j->t['menedzer_plikow_kom_zlaNazwa'];
			return false;
		}
		$sciezkaMin = $sciezka;
		$nazwa = trim($nazwa);
		$wynik = $this->sprSciezke($sciezka);
		if(!$wynik)
		{
			$this->komunikat = $this->j->t['menedzer_plikow_kom_zlaSciezka'];
			return false;
		}
		$sciezka = $wynik['sciezka'];
		$katalog = new Katalog($sciezka.$nazwa,true);

		if($this->konfiguracja['katalog_miniaturek'] != '')
		{
			$wynikMin = $this->sprSciezkeMiniatur($sciezkaMin);
			if(!$wynikMin)
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_zlaSciezkaMin'];
				return false;
			}
			$sciezkaMin = $wynikMin['sciezka'];
			$katalog = new Katalog($sciezkaMin.$nazwa, true);
		}

		if ($katalog->istnieje())
		{
			if ($zmiana)
			{
				$this->komunikat = sprintf($this->j->t['menedzer_plikow_kom_zmianaNazwy'], '<strong>'.htmlspecialchars($nazwa).'</strong>');
			}
			else
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_nowyKatalog'];
			}
			return true;
		}
		else
		{
			$this->komunikat = $this->j->t['menedzer_plikow_kom_nowyKatalogBlad'];
			return false;
		}
	}



	public function usun($sciezka)
	{
		if($this->konfiguracja['usuwanie'] == false) {
			$this->komunikat = $this->j->t['menedzer_plikow_kom_usuwanieOff'];
			return false;
		}
		$sciezkaMin = $sciezka;
		$wynik = $this->sprSciezke($sciezka);
		if(!$wynik) { return false; }
		$sciezka = $wynik['sciezka'];
		$plik = $wynik['plik'];
		$return = $wynik['url'];
		$url = $sciezka.$plik;
		$rozszerzenie = $this->rozszerzenie($plik);
		if(is_dir($url) && $url == $this->korzen)
		{
			return false;
		}

		if($this->konfiguracja['katalog_miniaturek'] != '')
		{
			$wynikMin = $this->sprSciezkeMiniatur($sciezkaMin);
			if($wynikMin)
			{
				$sciezkaMin = $wynikMin['sciezka'];
				$plikMin = $wynikMin['plik'];
				$urlMin = $sciezkaMin.$plikMin;
				if(is_dir($urlMin) && $plikMin != '..')
				{
					$k = new Katalog($urlMin);
					$x = $k->usun();
				}
				elseif(is_file($urlMin) && $plik != '..')
				{
					$p = new Plik($urlMin);
					$x = $p->usun($urlMin);
				}
			}
		}

		if(is_dir($url) && $plik != '..')
		{
			$k = new Katalog($url);
			$x = $k->usun();
			if($x)
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_usun'];
				return true;
			}
			else
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_usunBlad'];
				return false;
			}
		}
		elseif(is_file($url) && $plik != '..')
		{
			$p = new Plik($url);
			$x = $p->usun($url);
			if($x)
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_usun'];
				return $return.$plik;
			}
			else
			{
				$this->komunikat = $this->j->t['menedzer_plikow_kom_usunBlad'];
				return false;
			}
		}
	}



	public function pobierzKonfiguracje()
	{
		return $this->konfiguracja;
	}



	public function pobierzTlumaczenia()
	{
		return $this->j->t;
	}



	public function ustawTlumaczenia($tlumaczenia = array())
	{
		if (is_array($tlumaczenia) && $this->j->t = array_merge($this->j->t, $tlumaczenia))
		{
			$this->komunikat = $this->j->t['menedzer_plikow_kom_domyslny'];
			return true;
		}
		return false;
	}



	public function ustawSzablon($trescSzablonu, $plik = true)
	{
		$nowySzablon = new Szablon();
		$this->inicjujSzablon();

		if ($plik)
		{
			$nowySzablon->ladujTresc(Plik::pobierzTrescPliku($trescSzablonu));
		}
		else
		{
			$nowySzablon->ladujTresc($trescSzablonu);
		}

		if (count(array_diff($this->szablon->struktura(), $nowySzablon->struktura())) == 0)
		{
			$this->szablon = $nowySzablon;
			return true;
		}
		else
		{
			trigger_error('Nieprawidlowa struktura zaladowanego szablonu dla pagera', E_USER_WARNING);
			return false;
		}
	}


	/*
	 * Konfiguracja parametrow
	 *		- link
	 *		- link_nowy
	 *		- link_upload
	 *		- link_usun
	 *		- link_zmienNazwe
	 *		- link_przenies
	 *		- max_rozmiar
	 *		- przenoszenie
	 *		- usuwanie
	 *		- zmianaNazwy
	 *		- upload
	 *		- tworzenieKatalogow
	 *		- podglad
	 *		- akceptowane
	 */
	public function ustawKonfiguracje($config)
	{
		if(self::$wyswietlen > 0)
		{
			trigger_error("Zmiana konfiguracji po wyświetleniu menedżera jest niemożliwa", E_USER_WARNING);
			return false;
		}
		if(!is_array($config) || (is_array($config) && count($config) == 0)) { return false; }
		if(isset($config['link_katalog']))
		{
			if(strpos($config['link_katalog'],'{SCIEZKA}') !== false)
			{
				$this->konfiguracja['link_katalog'] = $config['link_katalog'];
			}
		}
		if(isset($config['link_download']))
		{
			if(strpos($config['link_download'],'{SCIEZKA}') !== false)
			{
				$this->konfiguracja['link_download'] = $config['link_download'];
			}
		}
		if(isset($config['link_nowy']))
		{
			if(strpos($config['link_nowy'],'{SCIEZKA}') !== false)
			{
				$this->konfiguracja['link_nowy'] = $config['link_nowy'];
			}
		}
		if(isset($config['link_upload']))
		{
			if(strpos($config['link_upload'],'{SCIEZKA}') !== false)
			{
				$this->konfiguracja['link_upload'] = $config['link_upload'];
			}
		}
		if(isset($config['link_usun']))
		{
			if(strpos($config['link_usun'],'{SCIEZKA}') !== false && strpos($config['link_usun'],'{USUN}') !== false)
			{
				$this->konfiguracja['link_usun'] = $config['link_usun'];
			}
			else
			{
				trigger_error("link_usun powinien zawierać parametr {SCIEZKA} oraz {USUN}", E_USER_WARNING);
			}
		}
		if(isset($config['link_zmienNazwe']))
		{
			if(strpos($config['link_zmienNazwe'],'{SCIEZKA}') !== false && strpos($config['link_zmienNazwe'],'{NAZWA}') !== false && strpos($config['link_zmienNazwe'],'{PLIK}') !== false)
			{
				$this->konfiguracja['link_zmienNazwe'] = $config['link_zmienNazwe'];
			}
			else
			{
				trigger_error("link_zmienNazwe powinien zawierać parametr {SCIEZKA}, {PLIK} oraz {NAZWA}", E_USER_WARNING);
			}
		}
		if (isset($config['link_przenies']))
		{
			if (strpos($config['link_przenies'],'{SCIEZKA}') !== false && strpos($config['link_przenies'],'{ZRODLO}') !== false && strpos($config['link_przenies'],'{CEL}') !== false)
			{
				$this->konfiguracja['link_przenies'] = $config['link_przenies'];
			}
			else
			{
				trigger_error("link_zmienNazwe powinien zawierać parametr {SCIEZKA}, {ZRODLO} oraz {CEL}", E_USER_WARNING);
			}
		}
		if (isset($config['max_rozmiar_plikow']))
		{
			if (abs((int)$config['max_rozmiar_plikow']) > 0)
			{
				$this->konfiguracja['max_rozmiar_plikow'] = abs((int)$config['max_rozmiar_plikow']);
			}
			else
			{
				trigger_error("Maksymalny rozmiar pliku powinien być większy od 0", E_USER_WARNING);
			}
		}
		if (isset($config['CKEditorFuncNum'])) {
			$this->konfiguracja['CKEditorFuncNum'] = (int)$config['CKEditorFuncNum'];
			if($this->ckeditor == false) { $this->ckeditor(); }
		}
		if(isset($config['przenoszenie']))
		{
			$this->konfiguracja['przenoszenie'] = (bool)$config['przenoszenie'];
		}
		if(isset($config['usuwanie']))
		{
			$this->konfiguracja['usuwanie'] = (bool)$config['usuwanie'];
		}
		if(isset($config['zmianaNazwy']))
		{
			$this->konfiguracja['zmianaNazwy'] = (bool)$config['zmianaNazwy'];
		}
		if(isset($config['upload']))
		{
			$this->konfiguracja['upload'] = (bool)$config['upload'];
		}
		if(isset($config['tworzenie_katalogow']))
		{
			$this->konfiguracja['tworzenie_katalogow'] = (bool)$config['tworzenie_katalogow'];
		}
		if(isset($config['podglad_miniatur']))
		{
			$this->konfiguracja['podglad_miniatur'] = (bool)$config['podglad_miniatur'];
		}
		if(isset($config['pliki_do_wyswietlenia']))
		{
			if(is_array($config['pliki_do_wyswietlenia']))
			{
				$this->konfiguracja['pliki_do_wyswietlenia'] = $config['pliki_do_wyswietlenia'];
			}
			else
			{
				$this->konfiguracja = array();
				trigger_error("parametr pliki_do_wyswietlenia powinien zawierac tablice dozwolonych adresow url", E_USER_WARNING);
			}
		}
		if(isset($config['akceptowane_rozszerzenia']) && !empty($config['akceptowane_rozszerzenia']))
		{
			if(is_array($config['akceptowane_rozszerzenia']))
			{
				$this->konfiguracja['akceptowane_rozszerzenia'] = array_map('strtolower', $config['akceptowane_rozszerzenia']);
			}
			else
			{
				$this->konfiguracja['akceptowane_rozszerzenia'] = false;
				trigger_error("parametr akceptowane_rozszerzenia powinien zawierac tablice dozwolonych rozszerzen plikow", E_USER_WARNING);
			}
		}
		if(isset($config['katalog_miniaturek']) && !empty($config['katalog_miniaturek'])) {
			if($config['katalog_miniaturek'][strlen($config['katalog_miniaturek'])-1] != '/') {
				$config['katalog_miniaturek'] .= '/';
			}
			$this->konfiguracja['katalog_miniaturek'] = str_replace('\\','/',rtrim(realpath(trim($config['katalog_miniaturek'])), '/').'/');
		}
		if(isset($config['url_miniaturek']))
		{
			$this->konfiguracja['url_miniaturek'] = $config['url_miniaturek'];
		}
	}



	protected function inicjujSzablon()
	{
		if(!($this->szablon instanceof Szablon))
		{
			$this->szablon = new Szablon();
			$this->szablon->ladujTresc($this->tpl);
			$this->szablon->ustaw($this->j->t);
		}
	}



	protected function bajtyNa($bytes)
	{
		$rozmiary = array('B', 'kB', 'MB', 'GB', 'TB');
		$break = count($rozmiary)-1;
		$wynik = floatval( $bytes );
		$rozmiar = $wynik;
		$i = -1;
		do
		{
			$wynik /= 1024;
			if($wynik > 1) { $rozmiar = $wynik; }
			$i++;
			if($i == $break) { break; }
		}
		while($wynik > 1);
		$oznaczenie = $rozmiary[$i];
		$rozmiar = number_format($rozmiar, 2, '.', '');
		return $rozmiar.$oznaczenie;
	}



	protected function wypiszDrzewo($sciezka = '', $poziom = 99)
	{
		$this->inicjujSzablon();
		$wynik = $this->sprSciezke($sciezka);
		if(!$wynik) { return false; }
		$sciezka = $wynik['sciezka'];
		$url = $wynik['url'];
		$html = '';
		$poziomPoczatkowy = $poziom = (int) $poziom;
		$elementy = array();
		if($poziom > 0)
		{
			if($uchwyt = opendir($sciezka))
			{
				$pliki = array();
				while(false !== ($plik = readdir($uchwyt)))
				{
					$nowaSciezka = $sciezka.$plik;
					$nowyUrl = $url.$plik;
					if ($plik != '.' && $plik != '..' && !is_link($nowaSciezka))
					{
						if(is_dir($nowaSciezka))
						{
							$nowyUrl = str_replace('&','%26',$nowyUrl);
							$html .= $this->szablon->parsujBlok('/menu/katalog', array(
								'plik' => htmlspecialchars($plik),
								'lista' =>$this->wypiszDrzewo($nowyUrl,$poziom-1),
								'link' => str_replace('{SCIEZKA}', $nowyUrl, $this->konfiguracja['link_katalog']),
								'title' => $nowyUrl,
								'id' => 'm'.abs(crc32($nowyUrl)),
								'poziom' => abs (99 - $poziomPoczatkowy + 2)
							));
						}
					}
				}
				closedir($uchwyt);
			}
		}
		return $this->szablon->parsujBlok('/lista', array(
			'lista' => $html,
			'class' => 'menu'
		));
	}



	protected function wypiszPliki($sciezka)
	{
		$html = '';
		$this->inicjujSzablon();
		$wynik = $this->sprSciezke($sciezka);
		if(!$wynik) { return false; }
		$sciezka = $wynik['sciezka'];
		$url = $wynik['url'];
		$fullurl = '';
		if($url != '')
		{
			$fullurl = htmlspecialchars($url);
		}
		if(is_file($sciezka))
		{
			$sciezka = dirname($sciezka).'/';
		}
		if ($uchwyt = opendir($sciezka))
		{
			$url = str_replace('&','%26',$url);
			$form = '';
			$formparam = array(
				'link' => str_replace('{SCIEZKA}',$url,$this->konfiguracja['link_katalog']),
				'link_nowy' => str_replace('{SCIEZKA}',$url,$this->konfiguracja['link_nowy']),
				'link_upload' => str_replace('{SCIEZKA}',$url,$this->konfiguracja['link_upload']),
				'link_przenies' => str_replace('{SCIEZKA}',$url,$this->konfiguracja['link_przenies']),
				'max_rozmiar' => $this->konfiguracja['max_rozmiar_plikow'],
				'download' => $this->download
			);
			if ($this->konfiguracja['przenoszenie']) {
				$this->szablon->ustawBlok('/pliki/form/przenoszenie', $formparam);
			}
			if ($this->konfiguracja['upload']) {
				$this->szablon->ustawBlok('/pliki/form/upload', $formparam);
			}
			if ($this->konfiguracja['tworzenie_katalogow']) {
				$this->szablon->ustawBlok('/pliki/form/tworzenieKatalogow', $formparam);
			}
			if ($this->konfiguracja['podglad_miniatur']) {
				$this->szablon->ustawBlok('/pliki/form/podglad', $formparam);
			}
			$form .= $this->szablon->parsujBlok('/pliki/form', $formparam);
			$katalogi = array();
			$pliki = array();
			while (false !== ($plik = readdir($uchwyt)))
			{
				$nowaSciezka = $sciezka.$plik;
				$nowyUrl = $url.$plik;
				if (is_dir($nowaSciezka) && $plik != '.')
				{
					$nowyUrl .= '/';
					if($plik == '..' && $url == '') { continue; }
					if($plik == '..')
					{
						$pathinfo = dirname($url);
						if($pathinfo == '.') { $pathinfo = ''; }
						$nowyUrl = $pathinfo;
					}
					$url = str_replace('&','%26',$url);
					$nowyUrl = str_replace('&','%26',$nowyUrl);
					$katalogi[$plik]['link'] = $nowyUrl;
					$katalogi[$plik]['sciezka'] = $url;
					$katalogi[$plik]['usun'] = $nowyUrl;
					$katalogi[$plik]['data'] = date("d.m.Y G:i:s", filemtime($nowaSciezka));
					$katalogi[$plik]['typ'] = '';
				}
				elseif (is_file($nowaSciezka) && $plik != '..' && $plik != '.')
				{
					$typ = $this->rozszerzenie($plik);
					if ($typ == $plik || $typ == '') { $typ = 'default'; }
					$url = str_replace('&','%26',$url);
					$nowyUrl = str_replace('&','%26',$nowyUrl);
					$pliki[$plik]['link'] = $nowyUrl;
					$pliki[$plik]['sciezka'] = $url;
					$pliki[$plik]['usun'] = $nowyUrl;
					$pliki[$plik]['data'] = date("d.m.Y G:i:s", filemtime($nowaSciezka));
					$pliki[$plik]['rozmiar'] = $this->bajtyNa(filesize($nowaSciezka));
					$pliki[$plik]['typ'] = $typ;
				}
			}
			closedir($uchwyt);
			if(count($katalogi) > 0)
			{
				ksort($katalogi);
				foreach($katalogi as $plik => $info)
				{
					$link = str_replace('{SCIEZKA}',$info['link'],$this->konfiguracja['link_katalog']);
					$link_zmienNazwe = str_replace('{SCIEZKA}',$info['sciezka'],$this->konfiguracja['link_zmienNazwe']);
					$link_zmienNazwe = str_replace('{PLIK}',$info['link'],$link_zmienNazwe);
					$link_usun = str_replace('{SCIEZKA}',$info['sciezka'],$this->konfiguracja['link_usun']);
					$link_usun = str_replace('{USUN}',$info['usun'],$link_usun);

					if($plik == '..')
					{
						$kontekst = '/pliki/wiersz/gora';
					}
					else
					{
						$kontekst = '/pliki/wiersz/katalog';
						if ($this->konfiguracja['zmianaNazwy'] !== false)
						{
							$this->szablon->ustawBlok('/pliki/wiersz/katalog/zmienNazwe', array(
								'link_usun' => $link_usun,
								'link_zmienNazwe' => $link_zmienNazwe,
								'plik' => htmlspecialchars($plik)
							));
						}
						if ($this->konfiguracja['usuwanie'] !== false)
						{
							$this->szablon->ustawBlok('/pliki/wiersz/katalog/usun', array(
								'link_usun' => $link_usun,
								'link_zmienNazwe' => $link_zmienNazwe,
								'plik' => htmlspecialchars($plik)
							));
						}
					}
					$html .= $this->szablon->parsujBlok($kontekst, array(
						'link' => $link,
						'title' => $info['link'],
						'id' => 'p'.abs(crc32($info['link'])),
						'plik' => htmlspecialchars($plik),
						'typ' => htmlspecialchars($info['typ'])
					));
				}
			}
			if (count($pliki) > 0)
			{
				ksort($pliki);
				foreach($pliki as $plik => $info)
				{
					if(is_array($this->konfiguracja['pliki_do_wyswietlenia']) && !in_array($info['link'],$this->konfiguracja['pliki_do_wyswietlenia']))
					{
						continue;
					}
					$link_zmienNazwe = str_replace('{SCIEZKA}',$info['sciezka'],$this->konfiguracja['link_zmienNazwe']);
					$link_zmienNazwe = str_replace('{PLIK}',$info['link'],$link_zmienNazwe);
					$link_usun = str_replace('{SCIEZKA}',$info['sciezka'],$this->konfiguracja['link_usun']);
					$link_usun = str_replace('{USUN}',$info['usun'],$link_usun);

					if ($this->konfiguracja['zmianaNazwy'] !== false)
					{
						$this->szablon->ustawBlok('/pliki/wiersz/plik/zmienNazwe', array(
							'link_zmienNazwe' => $link_zmienNazwe,
							'plik' => htmlspecialchars($plik)
						));
					}
					if ($this->konfiguracja['usuwanie'] !== false)
					{
						$this->szablon->ustawBlok('/pliki/wiersz/plik/usun', array(
							'link_usun' => $link_usun,
							'plik' => htmlspecialchars($plik)
						));
					}

					if ($this->ckeditor) {
						$this->szablon->ustawBlok('/pliki/wiersz/plik/ckeditor', array('title' => $info['link']));
					}

					$typy_obrazkow = array('bmp', 'gif', 'jpg', 'png', 'tif', 'svg');
					$info['typ'] = strtolower($info['typ']);
					$jestObrazem = (in_array($info['typ'], $typy_obrazkow)) ? 'obrazek' : '';

					$html .= $this->szablon->parsujBlok('/pliki/wiersz/plik', array(
						'link' => $this->download.$info['sciezka'].$plik,
						'link_min' => $this->konfiguracja['url_miniaturek'].$info['sciezka'].$plik,
						'title' => $info['link'],
						'id' => 'p'.abs(crc32($info['link'])),
						'plik' => htmlspecialchars($plik),
						'rozmiar' => $info['rozmiar'],
						'data' => $info['data'],
						'typ' => $info['typ'],
						'class' => $jestObrazem ,
					));
				}
			}
		}
		return $this->szablon->parsujBlok('/pliki/tabela/', array(
			'pliki' => $html,
			'form' => $form,
			'komunikat' => $this->komunikat,
			'fullurl' => $fullurl
		));
	}



	protected function sprSciezke($sciezka)
	{
		if($sciezka != '' && $sciezka['0'] == '/')
		{
			$sciezka = trim(substr($sciezka,1,strlen($sciezka)));
		}
		$sciezka = $this->korzen.$sciezka;
		$sciezka = realpath($sciezka);
		$sciezka = str_replace('\\','/',trim($sciezka));
		$plik = '';
		if(is_file($sciezka))
		{
			$plik = basename($sciezka);
			$sciezka = dirname($sciezka);
		}
		if(is_dir($sciezka) && $sciezka[strlen($sciezka)-1] != '/')
		{
			$sciezka .= '/';
		}
		$testKorzen = $this->korzen;
		$testSciezka = substr($sciezka,0,strlen($testKorzen));
		$testKorzen = str_replace('\\', '/', $testKorzen);
		$testSciezka = str_replace('\\', '/', $testSciezka);

		if($testKorzen == $testSciezka)
		{
			$url = substr($sciezka,strlen($this->korzen),strlen($sciezka));
			return array(
				'url' => $url,
				'sciezka' => $sciezka,
				'plik' => $plik
			);
		}
		else
		{
			return false;
		}
	}



	protected function sprSciezkeMiniatur($sciezka)
	{
		$sciezka = trim($sciezka);
		if($sciezka != '' && $sciezka['0'] == '/')
		{
			$sciezka = trim(substr($sciezka,1,strlen($sciezka)));
		}
		$sciezka = $this->konfiguracja['katalog_miniaturek'].$sciezka;
		$sciezka = realpath($sciezka);
		$sciezka = str_replace('\\','/',trim($sciezka));
		$plik = '';
		if(is_file($sciezka))
		{
			$plik = basename($sciezka);
			$sciezka = dirname($sciezka);
		}
		if(is_dir($sciezka) && $sciezka[strlen($sciezka)-1] != '/')
		{
			$sciezka .= '/';
		}
		$testKorzen = $this->konfiguracja['katalog_miniaturek'];
		$testSciezka = substr($sciezka,0,strlen($testKorzen));
		$testKorzen = str_replace('\\', '/', $testKorzen);
		$testSciezka = str_replace('\\', '/', $testSciezka);
		if($testKorzen == $testSciezka)
		{
			$url = substr($sciezka,strlen($this->konfiguracja['katalog_miniaturek']),strlen($sciezka));
			return array(
				'url' => $url,
				'sciezka' => $sciezka,
				'plik' => $plik
			);
		}
		else
		{
			return false;
		}
	}



	protected function sprNazwe($nazwa)
	{
		$znaki = array(';','=','+','<','>','|','"','\'','[',']','\\','/','*','?','%');
		$strlen = strlen($nazwa);
		if($strlen == 0 || $strlen > 255) { return false; }
		for($i = 0; $i < $strlen; $i++)
		{
			if(in_array($nazwa[$i],$znaki)) { return false; }
		}
		return $nazwa;
	}



	protected function poprawNazwe($nazwa)
	{
		$nazwa = trim($nazwa);
		$nazwa = preg_replace("#ę#i","e",$nazwa);
		$nazwa = preg_replace("#ż#i","z",$nazwa);
		$nazwa = preg_replace("#ó#i","o",$nazwa);
		$nazwa = preg_replace("#ł#i","l",$nazwa);
		$nazwa = preg_replace("#ć#i","c",$nazwa);
		$nazwa = preg_replace("#ś#i","s",$nazwa);
		$nazwa = preg_replace("#ź#i","z",$nazwa);
		$nazwa = preg_replace("#ń#i","n",$nazwa);
		$nazwa = preg_replace("#ą#i","a",$nazwa);
		$nazwa = preg_replace("#Ą#i","A",$nazwa);
		$nazwa = preg_replace("#[^-_A-Z\.0-9\s\.]#i","",$nazwa);
		$nazwa = preg_replace("#^\s+|\s+$#i","",$nazwa);
		$nazwa = preg_replace("#\s+#i","",$nazwa);
		return $nazwa;
	}



	protected function rozszerzenie($plik)
	{
		$test = explode('.',$plik);
		if(count($test) == 1) { return ''; }
		return end($test);
	}



	protected function ckeditor()
	{
		$this->ckeditor = true;
		$ck = '&CKEditorFuncNum='.$this->konfiguracja['CKEditorFuncNum'];
		if($this->konfiguracja['CKEditorFuncNum'] != null) {
			$this->konfiguracja['link_katalog'] .= $ck;
			$this->konfiguracja['link_nowy'] .= $ck;
			$this->konfiguracja['link_upload'] .= $ck;
			$this->konfiguracja['link_usun'] .= $ck;
			$this->konfiguracja['link_przenies'] .= $ck;
			$this->konfiguracja['link_zmienNazwe'] .= $ck;
		}
	}



	public function __construct($korzen,$download)
	{
		$nazwaKlasy = explode('\\', get_class($this));
		$namespaceJezyka = '\\Generic\\Tlumaczenie\\'.ucfirst(KOD_JEZYKA_ITERFEJSU).'\\Biblioteka\\'.end($nazwaKlasy);
		$this->j = new $namespaceJezyka;
		
		if ($download[strlen($download)-1] != '/')
		{
			$download .= '/';
		}
		$this->download = str_replace('\\','/',trim($download));
		$this->korzen = str_replace('\\','/',trim($korzen));
		if($this->korzen != '' && $this->korzen[strlen($this->korzen)-1] != '/')
		{
			$this->korzen .= '/';
		}
		if ( ! is_dir($this->korzen) || !is_writable($this->korzen))
		{
			if(!file_exists($this->korzen))
			{
				$katalog = new Katalog($this->korzen, true);
				if ( ! $katalog->istnieje())
				{
					$this->halt = true;
					trigger_error('Katalog dla menedzera plikow nie ma mozliwosci zapisu danych lub nie istnieje', E_USER_WARNING);
				}
			}
			else
			{
				$this->halt = true;
				trigger_error('Katalog dla menedzera plikow nie ma mozliwosci zapisu danych lub nie istnieje', E_USER_WARNING);
			}
		}
		if (strpos($this->download, '{SCIEZKA}' === false)) {
			$this->komunikat = sprintf($this->j->t['menedzer_plikow_brak_sciezka'], $this->trybAktywny['nazwa']);
			$this->halt = true;
			trigger_error('Drugi parametr konstruktora musi zawierać w sobie {SCIEZKA}', E_USER_WARNING);
		}
		$this->komunikat = $this->j->t['menedzer_plikow_kom_domyslny'];
	}

}
