
/*
 * Tooltip script
 * powered by jQuery (http://www.jquery.com)
 *
 * written by Alen Grakalic (http://cssglobe.com)
 *
 * for more info visit http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
 *
 */
tooltip = function(){
	/* CONFIG */
		xOffset = 10;
		yOffset = 20;
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result
	/* END CONFIG */
	$("a.tooltip").hover(function(e){
		this.t = this.title;
		this.title = "";
		$("body").append("<p id='tooltip'>"+ this.t +"</p>");
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");
	},
	function(){
		this.title = this.t;
		$("#tooltip").remove();
	});
	$("a.tooltip").mousemove(function(e){
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});
};


function przeladowanie()
{
	$("body").prepend("<div class=przeladowanie><div><div id=komunikat>Loading...</div></div></div>");
	$("div.przeladowanie").height($(document).height());
}

function modalAjax(url, rozmiarModala, typWysylania, data)
{
	$('#oknoModalne').removeClass('modal-no-resize');
	rozmiarModala = rozmiarModala || false ;
	typWysylania = typWysylania || 'GET';
	data = data || {};
	$.ajax({
		url: url,
		type: typWysylania,
		dataType: 'json',
		data: data,
		async: true,
		success: function(dane) {
			if (dane.status == 1)
			{
				$('#oknoModalne .modal-body').html(dane.html);
				$('#oknoModalne .modal-header h3').html(dane.tytul);
				$('#oknoModalne').modal();
				$('.tip-top').tooltip({ placement: 'top' });
				if(rozmiarModala.width)
				{
					setTimeout(function(){ dopasujModalaDoRozmiaru(rozmiarModala.width, rozmiarModala.height, rozmiarModala.top );	}, 200);
				}
				else
				{
					setTimeout(function(){ dopasujModala(); }, 400);
				}
				
			}
			else
			{
				$('#oknoModalne .modal-body').html(dane.html);
				$('#oknoModalne .modal-header h3').html(dane.tytul);	
				$('#oknoModalne').modal();
			}
			$('#oknoModalne .modal-body, #oknoModalne .modal-body iframe html').css('background', 'none');
		},
		error: function (xhr, ajaxOptions, thrownError) {
			var error = 'Displaying content in AJAX modal failed:  '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
		}
	});
}

function modalWModaluIFrame(url)
{
	$('#oknoModalne2 .modal-body').html('<iframe src="' + url + '"></iframe>');
	$('#oknoModalne2 .modal-header h3').html('&nbsp;');
	
	$('#oknoModalne2').modal();
	$('#oknoModalne2 .modal-body iframe').find('body').css('margin', 0);
	
	$('#oknoModalne').hide(500);
	
	dopasujModala('#oknoModalne2');
}

function modalIFrame(url)
{
	$('#oknoModalne .modal-body').html('<iframe src="' + url + '"></iframe>');
	$('#oknoModalne .modal-header h3').html('&nbsp;');
	
	$('#oknoModalne').modal();
	$('#oknoModalne .modal-body iframe').find('body').css('margin', 0);
	dopasujModala();
}

$(window).on('resize', function(){
	setTimeout(function(){
		dopasujModala('#oknoModalne:not(.modal-no-resize)');
		dopasujModala('#oknoModalne2:not(.modal-no-resize)');
	}, 500);
});

function dopasujModalaDoRozmiaru(width, height, top, modal)
{
	modal = modal || '#oknoModalne' ;
	top = top || '50%';
	$(modal).css({top: top, left: '50%'});
	$(modal).animate({
		marginLeft: '-'+(width/2)+'px',
		marginTop: '-'+((height/2))+'px',
		width: width+'px',
		height: height+'px'
	}, 750);
}

function dopasujModala(modal)
{
	modal = modal || '#oknoModalne' ;
	//if (! $('#oknoModalne').is('visible')) return false;
	var w = $(window).width() - 40;
	var h = $(window).height() - 40;
	$(modal).css({top: '50%', left: '50%'});
	$(modal).animate({
		marginLeft: '-'+(w/2)+'px',
		marginTop: '-'+((h/2))+'px',
		width: w+'px',
		height: h
	}, 750);
	$(modal+' .modal-body, '+modal+' .modal-body iframe').css({
		height: (h-77),
		maxHeight: (h-77)
	});
	$(modal+' .modal-body iframe').css({
		height: (h-83),
		maxHeight: (h-83)
	});
}

$(document).ready(function(){
	$(document).on('click', "[rel^='lightDiv']", function () {
		var konfiguracja = {
			mode : 1
		};
		oknoModalne(this, konfiguracja);
		return false;
	});
	$(document).on('click', "[rel^='lightbox']", function () {
		var iOS = /(iPad|iPhone|iPod)/g.test( navigator.userAgent );
		if (iOS)
		{
			$('.mobile-loader').hide();
			return true;
		}
		var conf = {};
		if ($(this).attr('rel').indexOf("fullPage") > -1)
		{
			conf = {fullPage: true};
		}
		oknoModalne(this, conf);
		return false;
	});
	
	$("#kategorie_toggler").toggle(function(){
			$("#kategorie .hide").show("fast");
			$("#kategorie .tr").addClass("rozwiniety");
		},
		function(){
			$("#kategorie .hide").hide("fast");
			$("#kategorie .tr").removeClass("rozwiniety");
	});
});


function in_array(needle, haystack, argStrict) {
	var key = '', strict = !!argStrict;

	if (strict) {
		for (key in haystack) {
			if (haystack[key] === needle) {
				return true;
			}
		}
	} else {
		for (key in haystack) {
			if (haystack[key] == needle) {
				return true;
			}
		}
	}
	return false;
}


// Ustawia focus na wyznaczonym kolejnym polu
function nastepnyInput(bierzacyInput, zdarzenie, nastepnyInputZapytanie)
{
	pomijane = [0,8,9,16,17,18,37,38,39,40,46];

	for (i = 0; i < pomijane.length; i++)
	{
		if (pomijane[i] == zdarzenie.keyCode) return;
	}
	if (bierzacyInput.value.length == bierzacyInput.maxLength)
	{
		$(nastepnyInputZapytanie).each(function () {
			this.focus();
			this.select();
		});
	}
}


// Ustawia focus na wyznaczonym poprzednim polu
function poprzedniInput(bierzacyInput, zdarzenie, nastepnyInputZapytanie)
{
	// jezeli naciskamy klawisz backspace i skasowalismy juz wszystko w inpucie
	if (zdarzenie.keyCode == 8 && bierzacyInput.value.length == 0) {
		$(nastepnyInputZapytanie).each(function () {
			this.focus();
			this.select();
		});
	}
}


function zapytanieUrl(trescZapytania, url)
{
	if (window.confirm(trescZapytania)) {
		window.location = url;
	}
}


function pokazUkryj(zapytanie)
{
	var element = $(zapytanie);
	if (element.is(":visible")) { element.slideUp("fast"); return false; } else { element.slideDown("fast"); return true; }
}


function avcreator(nazwa)
{
	// Atrybuty
	var h_obraz = undefined;
	var obraz = { w: 0, h: 0 }
	var h_ramka = undefined;
	var ramka = { w: 0, h: 0 }
	var h_podglad = undefined;
	var podglad = { w: 0, h: 0 }
	var h_miniatura = undefined;
	var ratio = 1;

	this.h_obraz = $('#'+nazwa+'_obraz');

	this.h_ramka = $('#'+nazwa+'_ramka');
	this.ramka = { w: this.h_ramka.width(), h: this.h_ramka.height() }

	this.h_podglad = $('#'+nazwa+'_ramka_podglad');
	this.podglad = { w: this.h_podglad.width(), h: this.h_podglad.height() }

	this.h_miniatura = $('#'+nazwa+'_obraz_podglad');

	this.ustawRatio = function(ratio)
	{
		this.ratio = ratio;
		this.h_podglad.height(this.podglad.w / ratio);
		this.podglad.h = this.h_podglad.height();
	}

	this.skalujRamke = function()
	{
		var wys = Math.round((this.ramka.h / this.obraz.h) * 100) / 100;
		var szer = Math.round((this.ramka.w / this.obraz.w) * 100) / 100;
		if (wys < szer)
		{
			var x = this.h_obraz.width()*wys;
			var y = this.h_obraz.height()*wys;
			this.h_obraz.width(x);
			this.h_obraz.height(y);
		}
		else
		{
			var x = this.h_obraz.width()*szer;
			var y = this.h_obraz.height()*szer;
			this.h_obraz.width(x);
			this.h_obraz.height(y);
		}
	}

	this.korekta = function()
	{
		if (this.podglad.h > this.h_miniatura.height()) {
			var h_ratio = 1;
			h_ratio = this.podglad.h / this.h_miniatura.height();
			this.h_miniatura.height(this.h_miniatura.height() * h_ratio);
			this.h_miniatura.width(this.h_miniatura.width() * h_ratio);
		}
		if (this.podglad.w > this.h_miniatura.width()) {
			var w_ratio = 1;
			w_ratio = this.podglad.w / this.h_miniatura.width();
			this.h_miniatura.width(this.h_miniatura.width() * w_ratio);
			this.h_miniatura.height(this.h_miniatura.height() * w_ratio);
		}
	}
}

function maximizeWindow()
{
	window.moveTo(0, 0);
	if (document.all) {
		top.window.resizeTo(screen.availWidth,screen.availHeight);
	} else if (document.layers||document.getElementById) {
		if (top.window.outerHeight < screen.availHeight || top.window.outerWidth < screen.availWidth) {
			top.window.outerHeight = screen.availHeight;
			top.window.outerWidth = screen.availWidth;
		}
	}
}

function getFromUrl( name )
{
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null )
		return "";
	else
		return results[1];
}

function limitZnakow(id, limit, info_id, komunikat)
{
	var text = $('#'+id).val();
	var textlength = text.length;
	if(textlength > limit)
	{
		$('#' + info_id).html(komunikat.replace('{LICZBA}', 0).replace('{LIMIT}', limit));
		$('#'+id).val(text.substr(0,limit));
		return false;
	}
	else
	{
		$('#' + info_id).html(komunikat.replace('{LICZBA}', (limit - textlength)).replace('{LIMIT}', limit));
		return true;
	}
}

/*
 * Usuwa polskie litery i niedozwolone znaki z tekstu
 * tekst - tekst do przekonwertowania
 * rozdzielacz - znak rozdzielajacy zastepujacy biale znaki (domyslnie: "-")
 * maleLitery - czy konwertowac do malych liter (domyslnie: true)
 */
function tworzKodBezPl(tekst, rozdzielacz, maleLitery)
{
	rozdzielacz = (typeof rozdzielacz == 'undefined') ? '-' : rozdzielacz;
	maleLitery = (typeof maleLitery == 'undefined') ? true : Boolean(maleLitery);

	// usuniecie polskich znakow
	tekst = tekst.replace(/ą/g,"a");
	tekst = tekst.replace(/ć/g,"c");
	tekst = tekst.replace(/ę/g,"e");
	tekst = tekst.replace(/ł/g,"l");
	tekst = tekst.replace(/ń/g,"n");
	tekst = tekst.replace(/ó/g,"o");
	tekst = tekst.replace(/ś/g,"s");
	tekst = tekst.replace(/ź/g,"z");
	tekst = tekst.replace(/ż/g,"z");
	tekst = tekst.replace(/Ą/g,"A");
	tekst = tekst.replace(/Ć/g,"C");
	tekst = tekst.replace(/Ę/g,"E");
	tekst = tekst.replace(/Ł/g,"L");
	tekst = tekst.replace(/Ń/g,"N");
	tekst = tekst.replace(/Ó/g,"O");
	tekst = tekst.replace(/Ś/g,"S");
	tekst = tekst.replace(/Ź/g,"Z");
	tekst = tekst.replace(/Ż/g,"Z");
	tekst = tekst.replace(/[^-_A-Z0-9\s]/gi, '');	// nieuzywane znaki
	tekst = tekst.replace(/^\s+|\s+$/g, '');		// usuniecie poczatkowych/koncowych spacji
	tekst = tekst.replace(/\s+/g, rozdzielacz);		// zamiana bialych znakow na rozdzielacz
	if (maleLitery) {
		tekst = tekst.toLowerCase();				// konwertowanie do malych liter
	}
	return tekst;
}


function hexAscii(x, d) {
	h = "0123456789ABCDEF";
	a = ' !"#$%&' + "'" + '()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[' + '\\' + ']^_`abcdefghijklmnopqrstuvwxyz{|}';
	r = "";
	if (d == "H2A") {
		for (i = 0; i < x.length; i++) {
			l1 = x.charAt(2 * i);
			l2 = x.charAt(2 * i + 1);
			v = h.indexOf(l1) * 16 + h.indexOf(l2);
			r += a.charAt(v - 32);
		};
	};
	if (d == "A2H") {
		for (i = 0; i < x.length; i++) {
			l = x.charAt(i);
			p = a.indexOf(l) + 32;
			h16 = Math.floor(p / 16);
			h1 = p % 16;
			r += h.charAt(h16) + h.charAt(h1);
		};
	};
	return r;
};

function isInt(n)
{
	 return parseInt(n) === n;
}

function getRowName(link)
{
	var rowName = link.parent().parent().find('td').first().find('span').text();

	if ( rowName != '')
	{
		return ' (' + rowName + ')';
	}
	else
	{
		return '';
	}
}

function number_format(number, decimals, dec_point, thousands_sep)
{
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number, prec = !isFinite(+decimals) ? 0 : Math.abs(decimals), sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep, dec = (typeof dec_point === 'undefined') ? '.' : dec_point, s = '',
   toFixedFix = function(n, prec) {
		var k = Math.pow(10, prec);
		return '' + (Math.round(n * k) / k).toFixed(prec);
	};
	// Fix for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
}

function secondsToTime(s){
    var h  = Math.floor( s / ( 60 * 60 ) );
        s -= h * ( 60 * 60 );
    var m  = Math.floor( s / 60 );
        s -= m * 60;
   
    return {
        "h": h,
        "m": m,
        "s": s
    };
}
