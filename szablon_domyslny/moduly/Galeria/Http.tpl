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

{{BEGIN listaGalerii}}
<div class="col-12 text-center">
<h1>{{$tytul_strony}}</h1>
</div>
<div class="gz-section gz-aktualnosci gz-mt-20">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center">
				<div class="gz-sorter">
					{{BEGIN kategoriaGalerii}}
					<a href="{{$link}}" type="button" class="btn {{IF aktywna}}btn-primary{{ELSE}}btn-outline-primary{{END}} btn-sm" onclick="filterGallery('')">{{$nazwa}}</a>
					{{END}}
				</div>
				<div class="row gz-gallery-section">
					{{ BEGIN galeria_wylistowanie }}
					<div class="col-lg-4 col-6 gallery-item" data-tags="sport">
						<img src="{{$zdjecie}}" alt="{{escape($zdjecie_alt)}}" >
						<div class="gallery-overlay"></div>
						<div class="gallery-content">
							<div class="gallery-tags">
								<ul>
									<li>{{$kategoria}}</li>
								</ul>
							</div>
							<h4 class="gallery-title">{{ $nazwa }}</h4>
						</div>
						<a href="{{ $link }}"  title="{{escape($zdjecie_alt)}}" class="gallery-button">Cała galeria »</a>
					</div>
					{{ END }}
				</div>
			</div>
		</div>
	</div>
</div>
	<div class="r_clear s20"></div>
	{{BEGIN podsumowanie}}
	{{$pager}}
	{{END}}
{{END}}


{{BEGIN galeria}}
<div class="col-12 text-center">
	<h1>{{$tytul_strony}}</h1>
	<h5>{{$opis}}</h5>
</div>
<div class="gz-section gz-aktualnosci gz-mt-20">
	<div class="container">
		<div class="row">
			<div class="row gz-gallery-section">
				{{ BEGIN miniaturka }}
				<div class="col-lg-4 col-6 gallery-item" data-tags="{{escape($tytul)}}" >
					<img src="{{ $miniaturka }}"  alt="{{escape($tytul)}}" >
					<a class="example-image-link" href="{{ $zdjecie_link }}" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
					<div class="gallery-overlay" ></div>
					</a>

				</div>
				<!--
					<div class="caption"><a href="{{ $zdjecie_link }}" title="{{ $tytul }}" {{ $lightbox }}>{{ $tytul }}</a></div>
					-->
				{{ END }}
				<div class="r_clear"></div>
				<div class="text-center">
					<p>
					<small>{{$autor}} {{$data_dodania}}</small>
					</p>
				</div>
				<div class="r_clear"></div>
				{{$pager}}
			</div>
			<div class="back">
			<a href="{{ $wstecz_link }}" class="btn">{{ $wstecz_etykieta }}</a>
			</div>
		</div>
	</div>
</div>

{{END}}


{{ BEGIN zdjecie }}
<div class="image_show">
<div class="image" id="image">
	{{ BEGIN zdjecie_lightbox_link }}
	<a href="{{ $zdjecie_lightbox_link }}" id="lightbox_{{ $zdjecie_lightbox_id }}" title="{{ $zdjecie_lightbox_tytul }}" {{ $uzyj_lightbox }} style="display: none;"></a>
	{{ END }}

	{{ BEGIN zdjecie }}
		<a href="{{ $zdjecie_link }}" title="{{ $zdjecie_tytul }}" id="lightbox_{{ $zdjecie_lightbox_id }}" {{ $uzyj_lightbox }} class="loader active">
			<img src="{{ $zdjecie }}" alt="{{escape($zdjecie_tytul)}}"/>
		</a>
	{{ END }}

	{{ BEGIN zdjecie_bez_linka }}
		<a href="" class="loader" style="cursor: default" onclick="return false">
			<img src="{{ $zdjecie }}" alt="{{escape($zdjecie_tytul)}}"/>
		</a>
	{{ END }}
	{{ BEGIN zdjecia_html }}
		{{ $zdjecia_html }}
	{{ END }}
</div>
	{{ BEGIN zdjecie_opis}}
		<div class="caption">
		<strong>{{ $zdjecie_tytul }}</strong> <span>{{ $zdjecie_autor }}</span>
		<p>{{ $zdjecie_opis }}</p>
		</div>
	{{ END }}

<div id="scrollable">
	<strong>{{ $etykieta_pozostale_zdjecia }}</strong>
	<a class="prev"></a>

	<div style="text-align: left;">
		<div class="items">
		{{ BEGIN miniaturki }}
		<a href="{{ $miniaturka_link }}" rel="image_show" id="thumbnail_{{ $miniaturka_id }}" title="{{ $miniaturka_tytul }}" class="{{ $miniaturka_klasa }}">
			<span title="zdjecie_autor_{{ $miniaturka_id }}" style="display: none">{{ $miniaturka_autor }}</span>
			<span title="zdjecie_opis_{{ $miniaturka_id }}"style="display: none">{{ $miniaturka_opis }}</span>
			<img src="{{ $miniaturka }}" alt="{{escape($miniaturka_tytul)}}"/>
		</a>
		{{ END }}
		</div>
	</div>

	<a class="next"></a>
	<div class="navi"></div>
</div>
{{ BEGIN java_script }}
<script type="text/javascript">
<!--
// Tutaj preloader
$(document).ready(function(){
	$(".navi [page='{{ $slider_strona }}']").click();
	//$("#thumbnail_{{ $active_id }}").click();
});

$("#scrollable").scrollable({
	size: {{$ilosc_miniaturek}}
});

$("[rel^='image_show']").click(function(){
	var id = $(this).attr("id").substr(10);
	$(".image_show .image .active").removeClass("active").hide();

	var image_link = $(this).attr("href");
	var image_alt = $(this).attr("title");
	var image_autor = $("[title^='zdjecie_autor_"+id+"']").html();
	var image_opis = $("[title^='zdjecie_opis_"+id+"']").html();


	var obrazek = new Image();
		obrazek.src = image_link;
		obrazek.alt = image_alt;

	var lightbox_link = $("#lightbox_"+id).attr("href");
	$(".image_show .image .active a").attr({href: ""+ lightbox_link +""});

	if({{$uzywa_linki}})
	{
		if($("#lightbox_"+id).html() == '')
		{
			$("#lightbox_"+id).html(obrazek);
		}
		$("#lightbox_"+id).addClass("active").show("fast");

	}
	else
	{
		$(".image_show .image .loader").html(obrazek).addClass("active").show("fast");
	}
	$(".image_show .caption strong, .modul h1").text(image_alt);
	$(".image_show .caption span").text(image_autor);
	$(".image_show .caption p").text(image_opis);

	return false;
});
-->
</script>
{{ END }}
</div>
<div class="back"><a href="{{ $wstecz_link }}">{{ $wstecz_etykieta }}</a></div>
{{ END }}