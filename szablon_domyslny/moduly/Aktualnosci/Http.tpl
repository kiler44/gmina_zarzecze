
{{BEGIN listaAktualnosci}}
<!-- Aktualności Content -->
<section class="gz-section gz-page-title">
	<div class="container" >
		<div class="row">
			<!-- Page title -->
			<div class="col-12 text-center">
				<h1>{{$tytul_strony}}</h1>
				<h5>{{$tytul_modulu}}</h5>
			</div>
			<!-- Page title End-->
		</div>
	</div>
</section>
<section class="gz-section gz-aktualnosci gz-mt-20">
	<div class="container">
		<div class="row">
			<!-- Sorter -->
			<!--
			<div class="col-12 text-center">
				<div class="gz-sorter" role="group" aria-label="Tagi">
					<button type="button" class="btn btn-primary btn-sm" onclick="filterAktualnosci('')">Wszystko</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterAktualnosci('nowe')">Nowe</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterAktualnosci('zdrowie')">Zdrowie</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterAktualnosci('sport')">Sport</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterAktualnosci('przetargi')">Przetargi</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterAktualnosci('aktualnosci')">Aktualności</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterAktualnosci('ogloszenia')">Ogłoszenia</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterAktualnosci('wydarzenia')">Wydarzenia</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterAktualnosci('kultura')">Kultura</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterAktualnosci('nauka')">Nauka</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterAktualnosci('inwestycje')">Inwestycje</button>
				</div>
			</div>
			-->
			<!-- Sorter END-->
				<div class="row">
{{ BEGIN lista }}
					<div class="col-lg-3 col-6 aktualnosci-item {{ if($priorytetowa, 'priority') }}" data-tags="nowe sport wydarzenia kultura">
						<div class="aktualnosci-image-content ">
							<!--
							<div class="aktualnosci-tags-info">
								<ul>
									<li class="pilne">Pilne</li>
									<li class="nowe">Nowe</li>
								</ul>
							</div>
							<div class="aktualnosci-tags">
								<ul>
									<li>Aktualności</li>
									<li>Zdrowie</li>
								</ul>
							</div>
							-->
							<button class="aktualnosci-button"><a href="{{ $link }}">{{ $etykieta_wiecej }}</a></button>
							<div class="aktualnosci-overlay"></div>
							{{BEGIN zdjecie_glowne}}
							<img src="{{ $zdjecie }}" alt="{{escape($tytul)}}"/>
							{{END}}
							{{BEGIN brak_zdjecia}}
							<div style="min-height: 290px; background: center / 50% no-repeat url(/_szablon/images/svg/img-svg-02.svg); text-align: center; padding-top: 235px">{{$etykieta_brak_zdjecia}}</div>
							{{END}}
						</div>
						<div class="aktualnosci-content">
							<time datetime="{{ $datetime }}">{{ $data }}</time>
							<a href="{{ $link }}"><h4>{{ $tytul }}</h4></a>
						</div>
					</div>
{{ END }}
				</div>
		</div>
	</div>
</section>
{{$pager}}

{{END}}


{{ BEGIN aktualnosc }}
<section class="gz-section gz-aktualnosc-wpis gz-opisowa">
	<div class="container" >
		<div class="row">
			<div class="col-lg-2 col-12 gz-top">
				<a href="{{ $link_wstecz }}" class="btn">{{ $etykieta_wstecz }}</a>
			</div>
			<!-- Content Strony -->
			<div class="col-lg-10 col-12 gz-content">
				<div class="page-title text-center">
					<h1>{{ $tytul }}</h1>
					<time datetime="{{ $datetime }}">{{ $data }}</time>
				</div>
				<figure class="figure">
					<!--
					<div class="tag">
						<div class="aktualnosc-wpis-tags-info">
							<ul>
								<li class="pilne">Pilne</li>
								<li class="nowe">Nowe</li>
								<li class="wydarzenie">Wydarzania</li>
								<li class="inwestycje">Inwestycje</li>
							</ul>
						</div>
						<div class="aktualnosc-wpis-tags ">
							<ul>
								<li>Aktualności</li>
								<li>Zdrowie</li>
							</ul>
						</div>
					</div>
					-->
					{{BEGIN zdjecie_glowne}}
					<img src="{{$zdjecie}}" class="figure-img img-fluid rounded" alt="{{escape($tytul)}}"/>
					<figcaption class="">{{ $etykieta_autor_zdjec }} {{ $autor_zdjec }}</figcaption>
					{{END}}

				</figure>
				{{$tresc_pelna}}
				{{$galeria}}
				{{$zalaczniki}}
			</div>
			<!-- Content End-->
		</div>
	</div>
</section>
{{ END }}



{{BEGIN galeria}}
<div class="row gz-gallery-section">
	{{ BEGIN miniaturka }}
	<div class="col-lg-4 col-6 gallery-item">
		<a class="not-text-link" title="{{ $tytul }}" href="{{ $zdjecie_link }}" {{ if($lightbox, 'data-toggle="lightbox" data-gallery="galeria"') }}><img alt="{{escape($tytul)}}" src="{{ $miniaturka }}"/></a>
		<div class="caption">{{ $opis }}</div>
	</div>
	{{END}}
	<div class="r_clear"></div>
</div>
{{END}}