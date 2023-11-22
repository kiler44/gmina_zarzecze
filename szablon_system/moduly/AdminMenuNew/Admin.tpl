{{BEGIN index}}
<script type="text/javascript">
$(document).ready(function(){
	var rot = 0; 
	
	var duration = 300;
	$('#adminToggle').click(function(){
		var menu = $("#leftMenu");
		
		if (rot===0)
			rot = 135;
		else
			rot = 0;
		
		$('#adminToggle i').stop().animate({rotation: rot}, {
			duration: duration,
			step: function(now, fx) {
				$(this).css({"transform": "rotate("+ now +"deg)"});
			}
		});
		menu.slideToggle();
	});
	
	if ($('#leftMenu').hasClass('admin'))
	{
		setTimeout(function(){
			$('#leftMenu').hide().removeClass('hidden');
			$('#adminToggle').click();
		}, 1);
	}		
	else
		$('#leftMenu').hide().removeClass('hidden');
});
</script>


{{$menu_zwykle}}


{{BEGIN menu_nowe}}
<div class="sidebarHeader"><h5><i class="icon icon-suitcase"></i> <span>{{$etykieta_menu_administracyjne}}</span> <a href="javascript:void(0);" id="adminToggle"><i class="icon icon-plus {{IF $jestAdminem}}admin{{END}}"></i></a></h5></div>
<ul id="leftMenu" class="leftMenu {{IF $jestAdminem}}admin{{END}}">
	<!-- <li class =""><a href="{{$link_glowna}}" title="{{$etykieta_strona_glowna}}"><i class="icon icon-home"></i> <span>{{$etykieta_strona_glowna}}</span></a></li> -->
{{BEGIN element}}<li class="submenu{{IF $aktywny}} active{{END}}">
	<a href="{{$link_url}}" title="{{$link_etykieta}}"><i class="icon {{$ikona}}"></i> <span>{{$link_etykieta}}</span></a>
	<ul>
		{{BEGIN subElement}}<li{{IF $aktywny}} class="active"{{END}}><a href="{{$link_url}}"><i class="icon {{$ikona}}"></i> {{$link_etykieta}}</a></li>{{END}}
	</ul>
</li>
{{END}}
{{BEGIN elementPojedynczy}}<li{{IF $aktywny}} class="active"{{END}}><a href="{{$link_url}}" title="{{$link_etykieta}}"><i class="icon {{$ikona}}"></i> <span>{{$link_etykieta}}</span></a></li>{{END}}
</ul>
{{END}}

{{END}}




{{BEGIN drzewo}}
<div class="sidebarHeader"><h5><a href="{{$link_glowna}}" title="{{$etykieta_strona_glowna}}" class="link"><i class="icon icon-home"></i> <span>{{$etykieta_menu}}</span></a></h5></div>
	{{BEGIN listaStart}}
		<ul class="leftMenu">
	{{END}}

		{{BEGIN element}}
			<li class="{{IF $aktywny}}active{{END}} {{$klasa_wiersza}}">
				<a href="{{$url}}" title="{{$nazwaPelna}}" class="{{$klasa}}">{{IF $ikona}}<i class="icon {{$ikona}}"></i>{{END}} <span>{{$nazwaPelna}}</span></a>
			</li>
		{{END}}
			
	{{BEGIN listaStop}}
		</ul>
	{{END}}
{{END}}