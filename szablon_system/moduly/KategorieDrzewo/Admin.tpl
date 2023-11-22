{{BEGIN index}}
{{drzewo}}
<div id="search">
	<div class="search-bg"></div>
	<input type="text" placeholder="{{$wyszukaj}}"/><button type="submit" class="tip-right" title="{{$szukaj}}"><i class="icon-search"></i></button>
</div>


<script>
	/*
	var drzewoKategorii = [{{$drzewo}}];
	var menuKategorii = '<div id="kategorieMenuUkryj"><i class="icon-circle-arrow-left"></i></div><ul>';

	var listaKategorii = Array();
	for (i = 0;i < drzewoKategorii.length;++i)
	{
		if (drzewoKategorii[i].url != undefined)
		{
			listaKategorii.push(drzewoKategorii[i].nazwaPelna);
			menuKategorii += '<li class="poziom_' + drzewoKategorii[i].poziom + ' ' + drzewoKategorii[i].klasa + '"><i class="icon-arrow-right"></i><a href="' + drzewoKategorii[i].url + '" title="' + drzewoKategorii[i].nazwa + '">' + drzewoKategorii[i].nazwa + '</a></li>';
		}
		else
		{
			menuKategorii += '<li class="poziom_' + drzewoKategorii[i].poziom + ' ' + drzewoKategorii[i].klasa + '"><i class="icon-arrow-right"></i>' + drzewoKategorii[i].nazwa + '</li>';
		}

	}

	menuKategorii += '</ul>';
	*/
	
	/* Tutaj wyszukiwarka, zamienić źródło danych do wyszukiwania i powinien być git, sprawdzic co to typehead
	$(document).ready(function () {
		$('#search input[type=text]').typeahead({
			source: listaKategorii,
			items: 3,
			updater: function (item) {przekierujNaModul(item);}
		});

		//inicjalizujMenuKategorii();
	});
	*/


	function przekierujNaModul(nazwa)
	{
		for (i = 0;i < drzewoKategorii.length;++i)
		{
			if (drzewoKategorii[i].nazwaPelna == nazwa && drzewoKategorii[i].url != undefined)
			{
				window.location.href = drzewoKategorii[i].url;
			}
		}
	}

	function inicjalizujMenuKategorii()
	{
		$('#sidebar').first().prepend('<div id="kategorieMenuToggle" title="{{$kategorie}}"><i class="icon icon-circle-arrow-right"></i></div>');

		$('#sidebar').prepend('<div id="kategorieMenu">' + menuKategorii + '</div>');

		$('#kategorieMenuUkryj').click(function () {
			$('#kategorieMenu').hide(300);
		});
		$('#kategorieMenuToggle').click(function () {
			$('#kategorieMenu').show(300);
		});
	}

</script>

{{END}}

{{BEGIN drzewo}}

{{BEGIN listaStart}}
	<div class="sidebarHeader"><h5><i class="icon icon-suitcase"></i> {{$etykieta_menu}} <a href="javascript:void(0);" id="adminToggle"><i class="icon icon-plus {{IF $jestAdminem}}hide{{END}}"></i></a></h5></div>
	<ul id="leftMenu" class="{{UNLESS $jestAdminem}}hidden{{END}}">
{{END}}

{{BEGIN elementStart}}
	<li{{IF $aktywny}} class="active"{{END}}>
{{END}}
{{BEGIN elementTrescLink}}
		<a href="{{$link_url}}" title="{{$link_etykieta}}"><i class="icon {{$ikona}}"></i> <span>{{$link_etykieta}}</span></a>
{{END}}
{{BEGIN elementTresc}}
	
{{END}}
{{BEGIN elementStop}}
	</li>
{{END}}
{{BEGIN listaStop}}
	</ul>
{{END}}

{{END}}



