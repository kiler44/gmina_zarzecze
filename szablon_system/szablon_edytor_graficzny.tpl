<div class="edytor_grafiki">
	<link rel="stylesheet" href="/_system/css/jquery.Jcrop.min.css" />
	<link rel="stylesheet" type="text/css" href="/_system/jquery-ui-1.7.2.custom.css" />
	<link rel="stylesheet" href="/_system/css/colorpicker.css" />
	<link rel="stylesheet" href="/_system/css/st-fonts.css" />

	<script type="text/javascript" src="/_system/_biblioteki/jquery.Jcrop.min.js"></script>
	<script src="/_system/js/bootstrap-colorpicker.js"></script>
	<script type="text/javascript">
		var api = null;
		var img_w = null;
		var img_h = null;
		var total_h = 70;
		$("document").ready(function(){
			maximizeWindow();
			if(window.opener && getFromUrl("odswiez") != "")
			{
				var windowOpener = window.opener;
				windowOpener.location.reload();
			}
			var window_w = window.innerWidth;
			var window_h = window.innerHeight;
			$(".edytor_grafiki > .edytor").height(window_h-total_h);
			$(".edytor_grafiki > .edytor > .obszar_roboczy").width(window_w-237).height(window_h-total_h);
			$(".edytor_grafiki > .edytor > .historia").height(window_h-total_h).find("ul");
			var dumpImg = new Image();
			dumpImg.src = $("#img").attr("src");
			img_w = 0;
			img_h = 0;
			$(dumpImg).load(function(){
				img_w = $("#img").width();
				img_h = $("#img").height();
				inicjalizujResize();
			});
			$(".edytor_grafiki > .menu a").click(function() {
				$(".edytor_grafiki > .opcje > form").hide();
				var title = $(this).attr("rel");
				$(".edytor_grafiki > .opcje > form[name='"+title+"']").show();
				if(title == "skaluj") {
					$('#skalujWysokosc').focus();
					inicjalizujResize();
				}
				else {
					$("#img").resizable("destroy");
					$("#img").width(img_w);
					$("#img").height(img_h);
				}
				if(title == "tnij") {
					if (api != null) {
						api.destroy();
					}
					$('#tnijPozx').focus();
					api = $.Jcrop("#img",{ bgColor: "black", onChange: kordynaty, onSelect: kordynaty });
				}
				else {
					if (api != null) {
						api.destroy();
					}
				}

				if (title != 'odbij')
				{
					$('#odbijKierunekY, #odbijKierunekX').attr('checked', false);
					$('#odbijKierunekY, #odbijKierunekX').uniform();
				}
				if (title == 'obroc')
				{
					$('#obrocKat').focus();
				}
				else
				{
					$('.obraz img').css({
						'-webkit-transform': '',
						'-moz-transform': '',
						'-o-transform': '',
						'-ms-transform': ''
					});
				}

				ustawOdbicie();

				if(title == "tekst") {
					$(".edytor_grafiki > .opcje").animate({height: "100px"}, 1);
					total_h = 142;
					$('#znakWodnyPodglad').css('display', 'block');
				}
				else {
					$(".edytor_grafiki > .opcje").animate({height: "60px"}, 1);
					total_h = 102;
					$('#znakWodnyPodglad').css('display', 'none');
				}
				var window_w = window.innerWidth;
				var window_h = window.innerHeight;
				$(".edytor_grafiki > .edytor").height(window_h-total_h);
				$(".edytor_grafiki > .edytor > .obszar_roboczy").width(window_w-237).height(window_h-total_h);
				$(".edytor_grafiki > .edytor > .historia").height(window_h-total_h);

				uruchomSelect2('select:not([multiple])');
			});

			if ($('select[name=\"zachowanie\"]').change(function () {
				inicjalizujResize();
				ustawRozmiarResize('s');
			}));

			$('#skalujSzerokosc').change(function () {
				ustawRozmiarResize('s');
			});

			$('#skalujWysokosc').change(function () {
				ustawRozmiarResize('w');
			});

			$('#tnijPozx, #tnijPozy, #tnijSzerokosc, #tnijWysokosc').change(function () {
				ustawPrzycinanie();
			});

			$('#odbijKierunekY, #odbijKierunekX').change(function() {
				ustawOdbicie();
			});

			$('#obrocKat').change(function() {
				ustawKat();
			});

			$('#tekstPozycja, #tekstCzcionka, #tekstRozmiar, #tekstKolor, #tekstPrzezroczystosc, #tekstKat, #tekstTekst').change(function() {
				ustawZnakWodny()
			});

			$('input[type=\"text\"]').each(
				function() {
					$(this).keydown(function (e) {
						var zmiana = 1;
						if(e.shiftKey)
						{
							zmiana = 10;
						}
						if (e.keyCode == 39 || e.keyCode == 38)
						{
							if ( ! isNaN(parseInt($(this).val())))
							{
								$(this).val(parseInt($(this).val()) + zmiana);
								$(this).change();
							}
						}
						if (e.keyCode == 37 || e.keyCode == 40)
						{
							if ( ! isNaN(parseInt($(this).val())))
							{
								$(this).val(parseInt($(this).val()) - zmiana);
								$(this).change();
							}
						}
					});
				});

			$('.colorpicker').colorpicker().on('changeColor', function(ev){
				$('#tekstKolor').val(ev.color.toHex());
				$('#znakWodnyPodglad').css('color', ev.color.toHex());
			});

		$('form[name="skaluj"]').submit(function () {
			if (parseInt($('#skalujWysokosc').val()) >= 1 && parseInt($('#skalujSzerokosc').val()) >= 1)
			{
				return true;
			}
			else
			{
				alertModal('{{$menedzer_plikow_skalujRozmiar0}}');
				return false;
			}
		});

		$('form[name="tnij"]').submit(function () {
			if (parseInt($('#tnijPozx').val()) < img_w && parseInt($('#tnijPozy').val()) < img_h && parseInt($('#tnijSzerokosc').val()) > 0 &&  parseInt($('#tnijWysokosc').val()) > 0)
			{
				return true;
			}
			else
			{
				alertModal('{{$menedzer_plikow_utnijRozmiarNiepoprawny}}');
				return false;
			}
		});

		$('form[name="obroc"]').submit(function () {
			if (parseInt($('#obrocKat').val()) != 0)
			{
				return true;
			}
			else
			{
				alertModal('{{$menedzer_plikow_obrocKat0}}');
				return false;
			}
		});

		$('form[name="odbij"]').submit(function () {
			if ($('#odbijKierunekY').attr('checked') || $('#odbijKierunekX').attr('checked'))
			{
				return true;
			}
			else
			{
				alertModal('{{$menedzer_plikow_odbijNieWybrano}}');
				return false;
			}
		});

		$('form[name="tekst"]').submit(function () {
			if ($('#tekstTekst').val().length > 0)
			{
				return true;
			}
			else
			{
				alertModal('{{$menedzer_plikow_tekstBrakTekstu}}');
				return false;
			}
		});

			setTimeout(function () {$(".edytor_grafiki > .menu a[rel=\"skaluj\"]").click();}, 100);
		});

		$(window).resize(function(){
			window_w = window.innerWidth;
			window_h = window.innerHeight;
			$(".edytor_grafiki > .edytor").height(window_h-total_h);
			$(".edytor_grafiki > .edytor > .obszar_roboczy").width(window_w-237).height(window_h-total_h);
			$(".edytor_grafiki > .edytor > .historia").height(window_h-total_h);
		});

		function inicjalizujResize()
		{
			$('#skalujWysokosc').val(img_h);
			$('#skalujSzerokosc').val(img_w);

			$("#img").resizable("destroy");

			if ($('select[name=\"zachowanie\"]').val() == 'skaluj')
			{
				var ratio = img_w / img_h;
				$("#img").resizable({
					resize: function(event, ui) {
						var form = $(".edytor_grafiki > .opcje > form[name=\"skaluj\"]");
						form.find("input[name=\"wysokosc\"]").val(parseInt(ui.size.height));
						form.find("input[name=\"szerokosc\"]").val(parseInt(ui.size.width));
					},
					aspectRatio: ratio,
					maxHeight: img_h,
					maxWidth: img_w,
				});
			}
			else
			{
				$("#img").resizable({
					resize: function(event, ui) {
						var form = $(".edytor_grafiki > .opcje > form[name=\"skaluj\"]");
						form.find("input[name=\"wysokosc\"]").val(ui.size.height);
						form.find("input[name=\"szerokosc\"]").val(ui.size.width);
					},
					maxHeight: img_h,
					maxWidth: img_w,
				});
			}
		}

		function ustawRozmiarResize(zmienionaWartosc)
		{
			var wysokosc = parseInt($('#skalujWysokosc').val());
			var szerokosc = parseInt($('#skalujSzerokosc').val());

			if (wysokosc > img_h)
			{
				wysokosc = img_h;
				$('#skalujWysokosc').val(img_h);
			}
			if (szerokosc > img_w)
			{
				szerokosc = img_w;
				$('#skalujSzerokosc').val(img_w);
			}
			if (wysokosc < 1 || isNaN(wysokosc))
			{
				wysokosc = 1;
				$('#skalujWysokosc').val(1);
			}
			if (szerokosc < 1 || isNaN(szerokosc))
			{
				szerokosc = 1;
				$('#skalujSzerokosc').val(1);
			}

			if ($('select[name=\"zachowanie\"]').val() == 'skaluj')
			{
				var form = $(".edytor_grafiki > .opcje > form[name=\"skaluj\"]");

				if (zmienionaWartosc == 's')
				{
					wysokosc = parseInt(szerokosc * (img_h / img_w));
					form.find("#skalujWysokosc").val(wysokosc);
				}
				else
				{
					szerokosc = parseInt(wysokosc * (img_w / img_h));
					form.find("#skalujSzerokosc").val(szerokosc);
				}
			}

			$('.obraz .ui-wrapper').css('width', szerokosc + 'px');
			$('.obraz .ui-wrapper').css('height', wysokosc + 'px');
			$('.obraz .ui-wrapper img').css('width', szerokosc + 'px');
			$('.obraz .ui-wrapper img').css('height', wysokosc + 'px');
		}

		function ustawPrzycinanie()
		{
			var x1 = parseInt($('#tnijPozx').val());
			var y1 = parseInt($('#tnijPozy').val());

			if (x1 < 1 || isNaN(x1))
			{
				x1 = 0;
			}
			if (y1 < 1 || isNaN(y1))
			{
				y1 = 0;
			}

			var x2 = parseInt(x1) + parseInt($('#tnijSzerokosc').val());
			var y2 = parseInt(y1) + parseInt($('#tnijWysokosc').val());


			if (x2 < x1 || isNaN(x2))
			{
				x2 = x1 + 50;
			}
			if (y2 <= y1 || isNaN(y2))
			{
				y2 = y1 + 50;
			}

			var wyciecie = new Array(
				x1,
				y1,
				x2,
				y2
				);
			api.setSelect(wyciecie);
		}

		function ustawOdbicie()
		{
			if ($('#odbijKierunekY').attr('checked') == 'checked')
			{
				$('.obraz img').removeClass('obrotPoziom');
				$('.obraz img').addClass('obrotPion');
			}
			else if ($('#odbijKierunekX').attr('checked') == 'checked')
			{
				$('.obraz img').removeClass('obrotPion');
				$('.obraz img').addClass('obrotPoziom');
			}
			else
			{
				$('.obraz img').removeClass('obrotPion');
				$('.obraz img').removeClass('obrotPoziom');
			}
		}

		function ustawKat()
		{
			var kat = parseInt($('#obrocKat').val());

			if (isNaN(kat))
			{
				kat = 0;
				$('#obrocKat').val('0');
			}
			$('.obraz img').css({
				'-webkit-transform': 'rotate(' + kat + 'deg)',
				'-moz-transform': 'rotate(' + kat + 'deg)',
				'-o-transform': 'rotate(' + kat + 'deg)',
				'-ms-transform': 'rotate(' + kat + 'deg)'
			});
		}

		function ustawZnakWodny()
		{
			$('#znakWodnyPodglad').css('width', img_w + 'px');
			$('#znakWodnyPodglad').css('height', img_h + 'px');
			$('#znakWodnyPodglad').css('display', 'block');

			$('#znakWodnyPodglad span').text($('#tekstTekst').val());
			$('#znakWodnyPodglad').css('font-size', $('#tekstRozmiar').val() + 'px');
			$('#znakWodnyPodglad').css('color', $('#tekstKolor').val());
			$('#znakWodnyPodglad').css('opacity', parseInt($('#tekstPrzezroczystosc').val()) / 100.0);
			$('#znakWodnyPodglad').css('font-family', $('#tekstCzcionka').val());

			var kat = parseInt($('#tekstKat').val());

			if (isNaN(kat))
			{
				kat = 0;
				$('#tekstKat').val('0');
			}

			$('#znakWodnyPodglad span').css({
				'-webkit-transform': 'rotate(' + kat + 'deg)',
				'-moz-transform': 'rotate(' + kat + 'deg)',
				'-o-transform': 'rotate(' + kat + 'deg)',
				'-ms-transform': 'rotate(' + kat + 'deg)'
			});

			var wysokoscCzcionki = 0;
			var odstepGora = 0;
			switch ($('#tekstRozmiar').val())
			{
				case'10' : wysokoscCzcionki = 20; odstepGora = -3; break;
				case'12' : wysokoscCzcionki = 22; odstepGora = -1; break;
				case'14' : wysokoscCzcionki = 21; odstepGora = 0; break;
				case'16' : wysokoscCzcionki = 20; odstepGora = 1; break;
				case'18' : wysokoscCzcionki = 24; odstepGora = 2; break;
				case'24' : wysokoscCzcionki = 26; odstepGora = 6; break;
				case'30' : wysokoscCzcionki = 32; odstepGora = 10; break;
				case'36' : wysokoscCzcionki = 36; odstepGora = 14; break;
				case'44' : wysokoscCzcionki = 40; odstepGora = 19; break;
				case'54' : wysokoscCzcionki = 48; odstepGora = 26; break;
				case'66' : wysokoscCzcionki = 56; odstepGora = 34; break;
				case'72' : wysokoscCzcionki = 60; odstepGora = 38; break;
				case'80' : wysokoscCzcionki = 65; odstepGora = 42; break;
				case'94' : wysokoscCzcionki = 75; odstepGora = 52; break;
				case'100' : wysokoscCzcionki = 78; odstepGora = 56; break;
			}

			var polowaWysokosci = (img_h / 2) - 10;
			var pelnaWysokosc = img_h - wysokoscCzcionki;

			switch($('#tekstPozycja').val())
			{
				case'default' :		{
						$('#znakWodnyPodglad').css('text-align', 'center');
						$('#znakWodnyPodglad span').css('margin-top', polowaWysokosci + 'px');
						$('#znakWodnyPodglad span').css({
							'-webkit-transform-origin': '50% 50%',
							'-moz-transform-origin': '50% 50%',
							'-o-transform-origin': '50% 50%',
							'-ms-transform-origin': '50% 50%'
						});

					} break;
				case'lewy_gorny' :	{
						$('#znakWodnyPodglad').css('text-align', 'left');
						$('#znakWodnyPodglad span').css('margin-top',odstepGora + 'px');
						$('#znakWodnyPodglad span').css({
							'-webkit-transform-origin': '0% 50%',
							'-moz-transform-origin': '0% 50%',
							'-o-transform-origin': '0% 50%',
							'-ms-transform-origin': '0% 50%'
						});
					} break;
				case'gora' :		{
						$('#znakWodnyPodglad').css('text-align', 'center');
						$('#znakWodnyPodglad span').css('margin-top',odstepGora + 'px');
						$('#znakWodnyPodglad span').css({
							'-webkit-transform-origin': '50% 50%',
							'-moz-transform-origin': '50% 50%',
							'-o-transform-origin': '50% 50%',
							'-ms-transform-origin': '50% 50%'
						});
					} break;
				case'prawy_gorny' : {
						$('#znakWodnyPodglad').css('text-align', 'right');
						$('#znakWodnyPodglad span').css('margin-top',odstepGora + 'px');
						$('#znakWodnyPodglad span').css({
							'-webkit-transform-origin': '100% 50%',
							'-moz-transform-origin': '100% 50%',
							'-o-transform-origin': '100% 50%',
							'-ms-transform-origin': '100% 50%'
						});
					} break;
				case'lewa' :		{
						$('#znakWodnyPodglad').css('text-align', 'left');
						$('#znakWodnyPodglad span').css('margin-top', polowaWysokosci + 'px');
						$('#znakWodnyPodglad span').css({
							'-webkit-transform-origin': '0% 50%',
							'-moz-transform-origin': '0% 50%',
							'-o-transform-origin': '0% 50%',
							'-ms-transform-origin': '0% 50%'
						});
					} break;
				case'prawa' :		{
						$('#znakWodnyPodglad').css('text-align', 'right');
						$('#znakWodnyPodglad span').css('margin-top', polowaWysokosci + 'px');
						$('#znakWodnyPodglad span').css({
							'-webkit-transform-origin': '100% 50%',
							'-moz-transform-origin': '100% 50%',
							'-o-transform-origin': '100% 50%',
							'-ms-transform-origin': '100% 50%'
						});
					} break;
				case'lewy_dolny' :	{
						$('#znakWodnyPodglad').css('text-align', 'left');
						$('#znakWodnyPodglad span').css('margin-top', pelnaWysokosc + 'px');
						$('#znakWodnyPodglad span').css({
							'-webkit-transform-origin': '0% 50%',
							'-moz-transform-origin': '0% 50%',
							'-o-transform-origin': '0% 50%',
							'-ms-transform-origin': '0% 50%'
						});
					} break;
				case'dol' :			{
						$('#znakWodnyPodglad').css('text-align', 'center');
						$('#znakWodnyPodglad span').css('margin-top', pelnaWysokosc + 'px');
						$('#znakWodnyPodglad span').css({
							'-webkit-transform-origin': '50% 50%',
							'-moz-transform-origin': '50% 50%',
							'-o-transform-origin': '50% 50%',
							'-ms-transform-origin': '50% 50%'
						});
					} break;
				case'prawy_dolny' : {
						$('#znakWodnyPodglad').css('text-align', 'right');
						$('#znakWodnyPodglad span').css('margin-top', pelnaWysokosc + 'px');
						$('#znakWodnyPodglad span').css({
							'-webkit-transform-origin': '100% 50%',
							'-moz-transform-origin': '100% 50%',
							'-o-transform-origin': '100% 50%',
							'-ms-transform-origin': '100% 50%'
						});
					} break;
			}
		}

		function kordynaty(c) {
			var form = $(".edytor_grafiki > .opcje > form[name=\"tnij\"]")
			form.find("input[name=\"pozx\"]").val(c.x);
			form.find("input[name=\"pozy\"]").val(c.y);
			form.find("input[name=\"wysokosc\"]").val(c.h);
			form.find("input[name=\"szerokosc\"]").val(c.w);
		}

		function eg_poprawNazwe(test)
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

		function eg_popraw(e)
		{
			if(e.value.length == 0) { alertModal("{{$menedzer_plikow_kom_zlaNazwa}}"); return false; }
			var nazwa = e.value;
			e.value = test = eg_poprawNazwe(nazwa);
			if(test != nazwa) { alertModal("{{$etykieta_poprawNazwe}}"); return false; }
			return true;
		}
	</script>
	<div class="menu navbar">
		<div class="navbar-inner">
			<ul class="nav">
				<li><a href="javascript:void(0);" rel="skaluj"><i class="icon-resize-full"></i> {{$etykieta_zmienRozmiar}}</a></li>
				<li><a href="javascript:void(0);" rel="tnij"><i class="icon-cut"></i> {{$etykieta_utnij}}</a></li>
				<li><a href="javascript:void(0);" rel="obroc"><i class="icon-refresh"></i> {{$etykieta_obroc}}</a></li>
				<li><a href="javascript:void(0);" rel="odbij"><i class="icon-resize-horizontal"></i> {{$etykieta_odbij}}</a></li>
				<li><a href="javascript:void(0);" rel="tekst"><i class="icon-font"></i> {{$etykieta_znakWodny}}</a></li>
				{{BEGIN zapisz}}<li><a href="#" rel="zapisz"><i class="icon-save"></i> {{$etykieta_zapisz}}</a></li>{{END}}
			</ul>
		</div>
	</div>
	<div class="opcje">
		<form action="" method="post" name="skaluj" class="form-inline">
			<label>{{$etykieta_wysokosc}} </label> <input type="text" id="skalujWysokosc" name="wysokosc" class="text" autocomplete="off">
			<label>{{$etykieta_szerokosc}} </label> <input type="text" id="skalujSzerokosc" name="szerokosc" class="text" autocomplete="off">
			<label>{{$etykieta_zachowanie}} </label>
			<select name="zachowanie">
				<option value="skaluj">{{$etykieta_zachowanieSkaluj}}</option>
				<option value="default">{{$etykieta_zachowanieZmienRozmiar}}</option>
				<!--<option value="przytnij">{{$etykieta_zachowanieSkalujUtnij}}</option>-->
			</select>
			<input class="btn" type="submit" name="wykonaj" value="{{$etykieta_skaluj}}">
			<input type="hidden" name="akcjaEdytora" value="skaluj">
		</form>
		<form action="" method="post" name="tnij" class="form-inline">
			<label>{{$etykieta_pozycjaX}} </label> <input type="text" id="tnijPozx" name="pozx" value="0" class="text" autocomplete="off">
			<label>{{$etykieta_pozycjaY}} </label> <input type="text" id="tnijPozy" name="pozy" value="0" class="text" autocomplete="off">
			<label>{{$etykieta_szerokosc}} </label> <input type="text" id="tnijSzerokosc" name="szerokosc" value="50" class="text" autocomplete="off">
			<label>{{$etykieta_wysokosc}} </label> <input type="text" id="tnijWysokosc" name="wysokosc" value="50" class="text" autocomplete="off">
			<input class="btn" type="submit" name="wykonaj" value="{{$etykieta_utnij}}">
			<input type="hidden" name="akcjaEdytora" value="tnij">
		</form>
		<form action="" method="post" name="obroc" class="form-inline">
			<label>{{$etykieta_kat}} </label> <input type="text" name="kat" id="obrocKat" class="text" autocomplete="off" value="0">
			<input class="btn" type="submit" name="wykonaj" value="{{$etykieta_obroc}}">
			<input type="hidden" name="akcjaEdytora" value="obroc">
		</form>
		<form action="" method="post" name="odbij" class="form-inline">
			<label for="odbijKierunekY">{{$etykieta_pionowo}} </label> <input id="odbijKierunekY" type="radio" name="kierunek" value="y">
			<label for="odbijKierunekX">{{$etykieta_poziomo}} </label> <input id="odbijKierunekX" type="radio" name="kierunek" value="x">
			<input class="btn" type="submit" name="wykonaj" value="{{$etykieta_odbij}}">
			<input type="hidden" name="akcjaEdytora" value="odbij">
		</form>
		<form action="" method="post" name="tekst" class="form-inline">
			<label>{{$etykieta_pozycja}} </label>
			<select name="pozycja" id="tekstPozycja">
				<option value="default">{{$etykieta_srodek}}</option>
				<option value="lewy_gorny">{{$etykietak_lewyGorny}}</option>
				<option value="gora">{{$etykietak_gora}}</option>
				<option value="prawy_gorny">{{$etykietak_prawyGorny}}</option>
				<option value="lewa">{{$etykietak_lewa}}</option>
				<option value="prawa">{{$etykietak_prawa}}</option>
				<option value="lewy_dolny">{{$etykietak_lewyDol}}</option>
				<option value="dol">{{$etykietak_Dol}}</option>
				<option value="prawy_dolny">{{$etykietak_prawyDol}}</option>
			</select>
			<label>{{$etykieta_czcionka}} </label>
			<select name="czcionka" id="tekstCzcionka">
				<option value="agapes">Agapes</option>
				<option value="antpr">Antykwa</option>
				<option value="frankgon">Frankfurt Gothic</option>
				<option value="znakwodny">Frankfurt Gothic Bold</option>
				<option value="gentiumplus">Gentium Plus</option>
				<option value="efnmacmt">Mac Menu</option>
				<option value="efnzepsm">Maszyna</option>
				<option value="qzcmi">Quasi Chancery</option>
				<option value="robin1">Robin</option>
				<option value="scribeb">Scribe</option>
			</select>
			<label>{{$etykieta_rozmiar}}</label>
			<select name="rozmiar" id="tekstRozmiar">
				<option value="10">10pt</option>
				<option value="12">12pt</option>
				<option value="14">14pt</option>
				<option value="16">16pt</option>
				<option value="18">18pt</option>
				<option value="24">24pt</option>
				<option value="30">30pt</option>
				<option value="36">36pt</option>
				<option value="44">44pt</option>
				<option value="54">54pt</option>
				<option value="66">66pt</option>
				<option value="72">72pt</option>
				<option value="80">80pt</option>
				<option value="94">94pt</option>
				<option value="100">100pt</option>
			</select>
			<label>{{$etykieta_kolor}}</label>
			<input type="text" name="kolor" id="tekstKolor" value="#000000" class="colorpicker input-mini" />
			</select><br />
			<div class="odstepPionowy"></div>
			<label>{{$etykieta_przezroczystosc}}</label>
			<select name="przezroczystosc" id="tekstPrzezroczystosc">
				<option value="100">0%</option>
				<option value="90">10%</option>
				<option value="80">20%</option>
				<option value="70">30%</option>
				<option value="60">40%</option>
				<option value="50">50%</option>
				<option value="40">60%</option>
				<option value="30">70%</option>
				<option value="20">80%</option>
				<option value="10">90%</option>
			</select>
			<label>Kąt: </label>
			<input type="text" name="kat" class="text" id="tekstKat" autocomplete="off" value="0">
			<label>{{$etykieta_tekst}} </label>
			<input type="text" name="tekst" id="tekstTekst" value="">
			<input class="btn" type="submit" name="wykonaj" value="{{$etykieta_wstawTekst}}">
			<input type="hidden" name="akcjaEdytora" value="tekst">
		</form>
		<form action="" method="post" name="zapisz" class="form-inline">
			<input type="hidden" name="wykonaj" value="1">
			<input class="btn" type="submit" name="zapiszOryginal" value="{{$etykieta_zapisznaoryginal}}">
			<input type="hidden" name="akcjaEdytora" value="zapisz">
			<label>{{$etykieta_zapisz_jako}} </label><input type="text" name="nazwa" value="">
			<input class="btn" type="submit" name="zapiszJako" value="{{$etykieta_zapisz}}" onclick="if(!eg_popraw(this.form.nazwa)) { return false; }">
		</form>
	</div>
	<div class="edytor">
		<div class="obszar_roboczy">
			<div class="obraz">
				<div id="znakWodnyPodglad"><span></span></div>
				<img id="img" src="{{$link}}{{$plik}}" alt="{{$plik}}">
			</div>
		</div>
		<div class="historia widget-box">
			<div class="widget-title">
				<span class="icon"><i class="icon-time"></i></span>
				<h5>{{$etykieta_nazwa}}</h5>
			</div>
			<div class="widget-content nopadding">
				<table class="table table-striped table-bordered">
						<tbody>
							{{BEGIN akcja}}<tr><td class="taskOptions{{if($wybrany,' wybrany');}}"><a href="{{$link}}" rel="{{$plik}}" class="{{if($wybrany,'', 'show-popover');}} pull-left" data-original-title="{{$etykieta_przywrocWersje}}"><i class="icon-reply"></i> {{$akcja}}</a></td></tr>{{END}}
						</tbody>
					</table>
			</div>
		</div>
	</div>
</div>