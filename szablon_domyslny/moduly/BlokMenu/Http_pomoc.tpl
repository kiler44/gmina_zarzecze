{{BEGIN index}}
	{{$drzewo}}
	<script type="text/javascript">
		<!--
		$('#tabsShell > li.active > ul').show();
		$('#tabsShell > li > ul > li > ul').show();
		$('li.active').parents('ul').show();
		$('li.active').parents('ul').parents('li').addClass('active');

		$('#tabsShell li.active > a').each(function(){
			$(this).replaceWith($(this.innerHTML).addClass($(this).attr('class')));
		});
		-->
	</script>
{{END}}

{{BEGIN drzewo}}
{{BEGIN listaStart}}<ul{{if $poziom_glowny}} id="tabsShell"{{else}} class="dNone" {{end}}>{{END}}
{{BEGIN elementStart}}<li class="poziom{{$poziom}} {{$klasa}}">{{END}}
{{BEGIN elementTrescLink}}<a href="{{$url}}" class="poziom{{$poziom}} {{$klasa}}" title="{{escape($nazwa)}}"><span>{{$nazwa}}</span></a>{{END}}
{{BEGIN elementTrescLinkSeo}}<span id="hsl{{$url}}" class="hsl poziom{{$poziom}} {{$klasa}}" title="{{escape($nazwa)}}"><span>{{$nazwa}}</span></span>{{END}}
{{BEGIN elementTresc}}<span class="poziom{{$poziom}} {{$klasa}}">{{$nazwa}}</span>{{END}}
{{BEGIN elementStop}}</li>{{END}}
{{BEGIN listaStop}}</ul>{{END}}
{{END}}