{{BEGIN index}}
<div class="przyciskiFunkcyjne">
	<a href="{{$link_konfiguruj}}" class="btn" title="{{$etykieta_link_konfiguruj}}"><span><img src="/_system/admin/ikony/konfiguruj.gif" alt="{{$etykieta_konfiguruj}}"/> {{$etykieta_link_konfiguruj}}</span></a>
	<a href="{{$link_tresc_przed}}" class="btn" title="{{$etykieta_link_tresc_przed}}"><span><img src="/_system/admin/ikony/page_edit.png" alt="{{$etykieta_tresc_przed}}"/> {{$etykieta_link_tresc_przed}}</span></a>
	<a href="{{$link_tresc_po}}" class="btn" title="{{$etykieta_link_tresc_po}}"><span><img src="/_system/admin/ikony/page_edit.png" alt="{{$etykieta_tresc_po}}"/> {{$etykieta_link_tresc_po}}</span></a>
</div>
{{$tabela_danych}}
{{END}}

{{BEGIN konfiguruj}}
<div class="przyciskiFunkcyjne">
	<a href="{{$link_dodaj}}" class="btn" title="{{$etykieta_dodaj}}"><span><img src="/_system/admin/ikony/dodaj.gif" alt="{{$etykieta_dodaj}}"/> {{$etykieta_dodaj}}</span></a>
</div>
<div class="tresc">
	{{$tabela_danych}}
</div>
<div class="przyciskiFunkcyjne">
	<a href="{{$link_wstecz}}" class="btn" title="{{$etykieta_wstecz}}"><span><img src="/_system/admin/ikony/wstecz.gif" alt="{{$etykieta_wstecz}}"/> {{$etykieta_wstecz}}</span></a>
</div>
{{END}}

{{BEGIN dodaj}}
	{{$formularz}}
{{END}}

{{BEGIN edytuj}}
	{{$formularz}}
{{END}}

{{BEGIN edytujTrescPrzed}}
	{{$formularz}}
{{END}}

{{BEGIN edytujTrescPo}}
	{{$formularz}}
{{END}}
