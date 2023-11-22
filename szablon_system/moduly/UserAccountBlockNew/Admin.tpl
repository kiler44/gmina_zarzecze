{{BEGIN index}}
<div id="user-nav" class="navbar navbar-inverse">
	<ul class="nav btn-group">
		{{BEGIN blokEvent}}
		<script>
			$(document).ready(function(){
				$( "li.message-item" ).hover(
					function() {
					  $( this ).css('opacity', '1');
					}, function() {
					  $( this ).css('opacity', '0.5');
					}
				);
			})
			
		</script>
		<li class="btn btn-inverse btn dropdown" id='menu-messages' style="min-height: 32px;">
			<a title="{{$etykieta_wyloguj}}" href="#" class="dropdown-toggle"  data-target="#menu-messages" data-toggle="dropdown">
				<i class="icon icon-calendar" style="margin-top:-4px; color: #FFF;"></i> <span class="text" style="color: #FFF;"> {{$events_etykieta}}</span>
				<span class="label label-danger" style="margin-top: 0px; padding: 1px 4px;">{{$iloscEventow}}</span>
				<b class="caret"></b>
			</a>
				<ul class="dropdown-menu messages-menu" style="">
					<li class="title">
						<a class="title-btn" title="Write new message" href="#" style="text-align: center; ">
							<i class="icon icon-calendar"></i> ( {{$iloscEventow}} ) {{$events_etykieta}}
						</a>
					</li>
					{{BEGIN event}}
					<li class="message-item" style="background-color: {{$bgkolor}}; opacity: 0.5;">
						<a href="{{$url}}" style="color:{{$kolor}}">
							<div class="message-content">
								<span class="event-time"> {{$data}} </span><br/>
								<span class='event-name'> {{$tytul}} </span><br/>
								<div>{{$opis}}</div>
							</div>
						</a>
					</li>
					{{END}}
				</ul>
		</li>
		{{END}}
		<li class="btn btn-inverse" ><a title="{{$etykieta_zalogowany}}" href="{{$url_glowna}}"><img width="16" height="11" border="0" alt="{{$etykieta_jezyk}}" title="{{$etykieta_jezyk}}" src="/_system/admin/flagi/{{$kod_jezyk}}.gif" class="flag-ico"/> <i class="icon icon-user"></i> <span class="text">{{$nazwa_uzytkownika}}</span></a></li>
		<li class="btn btn-inverse"><a title="{{$etykieta_wyloguj}}" href="{{$url_wyloguj}}"><i class="icon icon-off"></i> <span class="text">{{$etykieta_wyloguj}}</span></a></li>
	</ul>
</div>
{{END}}