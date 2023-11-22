{{BEGIN komunikat}}
<div class="r_clear"></div>
	<div class="komunikat {{$klasa}}">
		<div class="box {{$typ}}">
			<div class="top_left">
				<div class="top_right">
					<div class="bottom_right">
						<div class="bottom_left">
							<span class="komunikat_tresc">{{$tresc}}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="r_clear"></div>
{{END}}

{{BEGIN index}}
<div class="mapaStrony kategorie">
	{{$drzewo}}
</div>
{{END}}

{{BEGIN drzewo}}
{{BEGIN listaStart}}<ul>{{END}}
{{BEGIN elementStart}}<li class="poziom{{$poziom}} {{$klasa}}">{{END}}
{{BEGIN elementTrescLink}}<a href="{{$url}}" class="poziom{{$poziom}} {{$klasa}}" title="{{escape($nazwa)}}"><span>{{$nazwa}}</span></a>{{END}}
{{BEGIN elementTresc}}<span class="poziom{{$poziom}} {{$klasa}}">{{$nazwa}}</span>{{END}}
{{BEGIN elementStop}}</li>{{END}}
{{BEGIN listaStop}}</ul>{{END}}
{{END}}
