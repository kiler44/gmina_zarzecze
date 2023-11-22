$("[rel^='comm-']").css('cursor', 'pointer');
function potwierdzenieUsun(tresc, przycisk, tytul)
{
	if (typeof tytul == 'undefined' || tytul == '') tytul = '&nbsp;';
	
	$('#usunPotwierdzeniePotwierdz').attr('href', przycisk.attr('href'));
	$('#usunPotwierdzenieTytul').html(tytul);
	$('#usunPotwierdzenieOpis').html(tresc + pobierzNazweWTabeli(przycisk));
	$('#usunPotwierdzenie').modal('show');

	return false;
}

function potwierdzenieUsun1(tresc, przycisk, url)
{
	if (typeof tytul == 'undefined' || tytul == '') tytul = '&nbsp;';
	$('#usunPotwierdzeniePotwierdz').attr('onclick', url);
	$('#usunPotwierdzenieTytul').html(tytul);
	$('#usunPotwierdzenieOpis').html(tresc + pobierzNazweWTabeli(przycisk));
	$('#usunPotwierdzenie').modal('show');
                         
	return false;
}

function potwierdzenieModal(tresc, tytul)
{
	if (typeof tytul == 'undefined' || tytul == '') tytul = '&nbsp;';
	
	$('#usunPotwierdzenieTytul').html(tytul);
	$('#usunPotwierdzenieOpis').html(tresc);
	$('#usunPotwierdzenie').modal('show');

	return false;
}

function timeString(secs)
{
	var tekst = '';
	var czas = secondsToTime(secs)

	if (czas.h > 0) tekst = tekst + czas.h.toLocaleString()+'h ';
	if (czas.m > 0) tekst = tekst + czas.m.toLocaleString()+'m ';

	tekst = tekst + czas.s.toString()+'s';
	return tekst;
}

function potwierdzenieModal1(tresc, tytul, funkcja)
{
	if (typeof tytul == 'undefined' || tytul == '') tytul = '&nbsp;';
	$('#usunPotwierdzeniePotwierdz').attr('onclick', funkcja);
	$('#usunPotwierdzenieTytul').html(tytul);
	$('#usunPotwierdzenieOpis').html(tresc);
	$('#usunPotwierdzenie').modal('show');

	return false;
}

function potwierdzenieModal2(tresc, tytul, funkcjaZatwierdz, funkcjaAnuluj)
{
	if (typeof tytul == 'undefined' || tytul == '') tytul = '&nbsp;';
	$('#usunPotwierdzeniePotwierdz').attr('onclick', funkcjaZatwierdz);
	$('#usunPotwierdzeniePotwierdz').siblings('.btn[data-dismiss=modal]').attr('onclick', funkcjaAnuluj);
	$('#usunPotwierdzenieTytul').html(tytul);
	$('#usunPotwierdzenieOpis').html(tresc);
	$('#usunPotwierdzenie').modal('show');

	return false;
}

function oknoEdytujWartosc(tresc, wartosc, callback)
{
	$('#edytujWartoscOknoTytul').html('&nbsp;');
	$('#edytujWartoscOknoOpis').html(tresc)
	$('#edytujWartoscOknoPole').val(wartosc);
	$('#edytujWartoscOkno').modal('show');
	$('#edytujWartoscOknoPotwierdz').on('click',  function () {callback();});
}

function oknoEdytujWartoscZamknij()
{
	$('#edytujWartoscOkno').modal('hide');
}

function alertModal(tytul, tresc)
{
	if (typeof tytul == 'undefined' || tytul == '') tytul = '&nbsp;';
	$('#alertModalTytul').html(tytul);
	$('#alertModalOpis').html(tresc);
	$('#alertModal').modal('show');

	return false;
}

function pobierzNazweWTabeli(link)
{
	var rowName = link.parent().parent().parent().find('td').first().find('span').text();

	if ( rowName != '')
	{
		return ' (' + rowName + ')';
	}
	else
	{
		return '';
	}
}

function inArray(needle, haystack) 
{
	return in_array(needle, haystack);
}

String.prototype.replaceArray = function(find, replace) {
  var replaceString = this;
  var regex; 
  for (var i = 0; i < find.length; i++) {
    regex = new RegExp(find[i], "g");
    replaceString = replaceString.replace(regex, replace[i]);
  }
  return replaceString;
};


function oknoModalne(obj, konfiguracja)
{
	if (typeof konfiguracja == 'undefined')
	{
		konfiguracja = {};
	}

	var width = 1024;
	var height = 768;
	var mode = 'iframe';
	var url = '';


	if (konfiguracja.width > 0)
	{
		width = konfiguracja.width;
	}

	if (konfiguracja.height > 0)
	{
		height = konfiguracja.height;
	}

	if (konfiguracja.mode > 0)
	{
		mode = konfiguracja.mode;
	}

	if (konfiguracja.url != '' && konfiguracja.url != undefined)
	{
		url = konfiguracja.url;
	}

	if (url == '')
	{
		url = $(obj).attr('href');
	}
	
	$('#oknoModalne').css('width', width + 'px');
	$('#oknoModalne .modal-body').css('max-height', height + 'px');
	$('#oknoModalne').css('margin', 'auto');
	$('#oknoModalne').css('margin-left', (($(document).width() - width) / 2) + 'px');
	$('#oknoModalne').css('left', 'auto');
	$('#oknoModalne').css('top', ((screen.height - height) / 2)-120 + 'px');

	if (mode == 'iframe')
	{
		$('#oknoModalne .modal-body').html('<iframe src="' + url + '"></iframe>');
		$('#oknoModalne .modal-body iframe').css('height', (height+42) + 'px');
		$('#oknoModalne').modal();
		$('#oknoModalne .modal-body iframe').find('body').css('margin', 0);
	}
	else
	{
		$('#oknoModalne').modal({"remote":url});
	}
	$('#oknoModalne .modal-body, #oknoModalne .modal-body iframe html').css('background', 'none');
	if (konfiguracja.fullPage)
	{
		dopasujModala();
	}
}

function nalozUniform()
{
	$('input[type=radio]').uniform();
	$('input[type=checkbox]:not(".no-js")').uniform();
}

function nalozSelect2()
{
	if (! $('.select2 select').hasClass('no-select2') && ! $('body').hasClass('tablet'))
	{
		$('.select2 select').select2();
	}
}

nalozUniform();

$('#search .search-bg').dblclick(function () {
	$('#search').css('position', 'absolute');
});


$('#leftMenu li a.show-tooltip').tooltip({'placement':'right'});

$('#leftMenu li a.show-tooltip').click(function () {$(this).tooltip('hide');});

$('.edytor_grafiki a.show-popover').each(function () {
	var content = '<img src="' + $(this).attr('rel') + '" alt="" />';
	$(this).popover({'placement':'left', 'trigger':'hover', 'content':content, 'html':true});
});

$(document).ready(function(){
	nalozSelect2();
	$('.js-hide').parents('.control-group').hide();
	//$(window).unbind('resize.' + $('.select2-container').data('select2').containerId);
	$('.closeModal2').on('click', function(){
		$('#oknoModalne2').hide();
		$('#oknoModalne').show();
	});
	$('.modal-backdrop').on('click', function(){
		if($('#oknoModalne2').is(':visible'))
			$('#oknoModalne').show();
	});
});
$.urlParam = function(name){
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	results = regex.exec(location.search);
	return results === null ? 0 : decodeURIComponent(results[1].replace(/\+/g, " "));
	 
		//var results = new RegExp('[\?&amp;]' + name + '=([^&amp;#]*)').exec(window.location.href);
		var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		//return results[1] || 0;
		if ( typeof results !== "undefined" && results) {
			return decodeURIComponent(results[1]);
		}
		else
		{
			return 0;
		}
	}
function liczDni(dataStart, dataStop){
	
	var mDate_od = dataStart.getTime();
	var mDate_do = dataStop.getTime();
	var dzien_milisekundy = 86400000;
	return Math.ceil(((mDate_do - mDate_od) / dzien_milisekundy));
	
}
Date.prototype.addDays = function(days)
{
	 var dat = new Date(this.valueOf());
	 dat.setDate(dat.getDate() + days);
	 return dat;
}
Date.prototype.getWeek = function() {
  var year = new Date(this.getFullYear(),0,1);
  return Math.ceil((((this - year) / 86400000) + year.getDay()+1)/7);
}


function zamknijModla()
{
	$('#oknoModalne').find('.modal-body').html('');
	$('#oknoModalne').find('.close').click();
	
}

/**
 * 
 * @param {type} url - adres stron
 * @param {type} succesFunction - funkcja wywoływana jak jest sukces
 * @param {type} data - dodatkowe parametry wysylane 
 * @param {type} type - POST / GET
 * @param {type} dataType - json, html etc.
 * @returns $.ajax
 */
var ajax = function (url, succesFunction, data, type, dataType, preloader, errorHandlerOn )
{
	var preloader = preloader|false;
	var errorHandlerOn = errorHandlerOn|true;
	console.log(errorHandlerOn);
	$.ajax({
			url: url,
			type: type, 
			data: data, 
			dataType: dataType,
			beforeSend: function() { if(preloader) ladujPreloader(); },
			success:  function(dane){ succesFunction(dane); },
			error: function(xhr, ajaxOptions, thrownError){ if(errorHandlerOn) { errorHandler(xhr, ajaxOptions, thrownError) } },
			complete: function(){ if(preloader) usunPreloader() },
		});
		
		return $.ajax;
};
	
function ladujPreloader(){	$('.mobile-loader').fadeIn("normal"); }
function usunPreloader() {	$('.mobile-loader').fadeOut("normal");	}
function errorHandler(xhr, ajaxOptions, thrownError){
		
	var statusErrorMap = {
	  '400' : "Server understood the request, but request content was invalid.",
	  '401' : "Unauthorized access.",
	  '403' : "Forbidden resource can't be accessed.",
	  '500' : "Internal server error.",
	  '503' : "Service unavailable."
	};

	if  (xhr.status in statusErrorMap) 
	{
		alertModal('ERROR', "("+ xhr.status +") error occurred: " + statusErrorMap[xhr.status.toString()] + " <br/><br/>Server said: <br/><br/>" + xhr.responseText);
	}
	else 
	{
		alertModal('ERROR', "An error occurred: " + xhr.status + "nError: " + thrownError + " <br/><br/>Server said: <br/><br/>" + xhr.responseText);
	}
}
$.fn.serializeObject = function() {
    var o = Object.create(null),
        elementMapper = function(element) {
            element.name = $.camelCase(element.name);
            return element;
        },
        appendToResult = function(i, element) {
			  
            var node = o[element.name];
				
            if ( ('undefined' != typeof node && node !== null)) {
					if($.isArray(o[element.name])){ o[element.name].push(element.value); }else{ var tempVal = o[element.name]; o[element.name] = [tempVal, element.value]; }
            } else {
                o[element.name] = element.value;
            }
        };

    $.each($.map(this.serializeArray(), elementMapper), appendToResult);
    return o;
};

function klientMobilny()
{
	return ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) );
}
