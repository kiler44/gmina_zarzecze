{{BEGIN index}}
<div class="span6" style="margin-left:0px;"><h3>{{$etykieta_cache_widok}}</h3>
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-dashboard"></i>
			</span>
			<h5>{{$etykieta_cache_wizytowki}}</h5>
		</div>
		<div class="widget-content">
			<p>{{if($cache_wizytowki_wlaczony, $etykieta_cache_wlaczony, $etykieta_cache_wylaczony)}} {{$cache_wizytowki_ilosc}}</p>
			<a href="{{$link_cache_wizytowki}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_cache_wizytowki}}"><i class="icon-search"></i> {{$etykieta_link_cache_wizytowki}}</a>
			<a href="{{$link_czysc_cache_wizytowki}}" class="btn btn-danger" onclick="return potwierdzenieUsun('{{$etykieta_link_czysc_cache_wizytowki_pytanie}}', $(this));" title="{{$etykieta_link_czysc_cache_wizytowki}}"><i class="icon-remove"></i> {{$etykieta_link_czysc_cache_wizytowki}}</a>
		</div>
	</div>
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-dashboard"></i>
			</span>
			<h5>{{$etykieta_cache_strony}}</h5>
		</div>
		<div class="widget-content">
			<p>{{if($cache_strony_wlaczony, $etykieta_cache_wlaczony, $etykieta_cache_wylaczony)}} {{$cache_strony_ilosc}}</p>
			<a href="{{$link_cache_strony}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_cache_strony}}"><i class="icon-search"></i> {{$etykieta_link_cache_strony}}</a>
			<a href="{{$link_czysc_cache_strony}}" class="btn btn-danger" onclick="return potwierdzenieUsun('{{$etykieta_link_czysc_cache_strony_pytanie}}', $(this));" title="{{$etykieta_link_czysc_cache_strony}}"><i class="icon-remove"></i> {{$etykieta_link_czysc_cache_strony}}</a>
		</div>
	</div>
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-dashboard"></i>
			</span>
			<h5>{{$etykieta_cache_bloki}}</h5>
		</div>
		<div class="widget-content">
			<p>{{if($cache_bloki_wlaczony, $etykieta_cache_wlaczony, $etykieta_cache_wylaczony)}} {{$cache_bloki_ilosc}}</p>
			<a href="{{$link_cache_bloki}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_cache_bloki}}"><i class="icon-search"></i> {{$etykieta_link_cache_bloki}}</a>
			<a href="{{$link_czysc_cache_bloki}}" class="btn btn-danger" onclick="return potwierdzenieUsun('{{$etykieta_link_czysc_cache_bloki_pytanie}}', $(this));" title="{{$etykieta_link_czysc_cache_bloki}}"><i class="icon-remove"></i> {{$etykieta_link_czysc_cache_bloki}}</a>
		</div>
	</div>
</div>
<div class="span6"><h3>{{$etykieta_cache_system}}</h3>
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-dashboard"></i>
			</span>
			<h5>{{$etykieta_cache_baza}}</h5>
		</div>
		<div class="widget-content">
			<p>{{if($cache_baza_wlaczony, $etykieta_cache_wlaczony, $etykieta_cache_wylaczony)}} {{$cache_baza_ilosc}}</p>
			<a href="{{$link_cache_baza}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_cache_baza}}"><i class="icon-search"></i> {{$etykieta_link_cache_baza}}</a>
			<a href="{{$link_czysc_cache_baza}}" class="btn btn-danger" onclick="return potwierdzenieUsun('{{$etykieta_link_czysc_cache_baza_pytanie}}', $(this));" title="{{$etykieta_link_czysc_cache_baza}}"><i class="icon-remove"></i> {{$etykieta_link_czysc_cache_baza}}</a>
		</div>
	</div>
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-dashboard"></i>
			</span>
			<h5>{{$etykieta_cache_php}}</h5>
		</div>
		<div class="widget-content">
			<p>{{if($cache_php_wlaczony, $etykieta_cache_wlaczony, $etykieta_cache_wylaczony)}} {{$cache_php_ilosc}}</p>
			<a href="{{$link_czysc_cache_php}}" class="btn btn-danger" onclick="return potwierdzenieUsun('{{$etykieta_link_czysc_cache_php_pytanie}}', $(this));" title="{{$etykieta_link_czysc_cache_php}}"><i class="icon-remove"></i> {{$etykieta_link_czysc_cache_php}}</a>
		</div>
	</div>
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-dashboard"></i>
			</span>
			<h5>{{$etykieta_cache_tpl}}</h5>
		</div>
		<div class="widget-content">
			<p>{{if($cache_tpl_wlaczony, $etykieta_cache_wlaczony, $etykieta_cache_wylaczony)}} {{$cache_tpl_ilosc}}</p>
			<a href="{{$link_czysc_cache_tpl}}" class="btn btn-danger" onclick="return potwierdzenieUsun('{{$etykieta_link_czysc_cache_tpl_pytanie}}', $(this));" title="{{$etykieta_link_czysc_cache_tpl}}"><i class="icon-remove"></i> {{$etykieta_link_czysc_cache_tpl}}</a>
		</div>
	</div>
</div>

{{END}}
