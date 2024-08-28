{{BEGIN kontener_podstawowy}}
<div class="modul">
<h1>{{$tytul_modulu}}</h1>
	{{BEGIN linki}}
	<div class="linki">
		{{BEGIN link}}
			{{$tresc_linka}}
		{{END}}
	</div>
	{{END}}
<div class="tresc">{{$tresc}}</div>
</div>
{{END}}

{{BEGIN kontener_podstawowy_tresci}}
<div class="modul podstawowy">
<h1>{{$tytul_modulu}}</h1>
	{{BEGIN linki}}
	<div class="linki">
		{{BEGIN link}}
			{{$tresc_linka}}
		{{END}}
	</div>
	{{END}}
<div class="tresc">{{$tresc}}</div>
</div>
{{END}}

{{BEGIN kontener_galeria}}
<div class="modul">
<h1>{{$tytul_galerii}}</h1>
<div class="tresc">{{$tresc}}</div>
</div>
{{END}}

{{BEGIN kontener_pusty}}
{{$tresc}}
{{END}}


{{BEGIN kontener_tresc}}
<div class="modul">
	<div class="tresc">{{$tresc}}</div>
</div>
{{END}}

{{BEGIN kontener_sekcja}}
<section class="gz-section icobox-1-section">
	<div class="container" id="tiles-container">
		{{$tresc}}
	</div>
</section>
{{END}}

{{BEGIN kontener_sekcja_wideo}}
<section class="gz-video-gallery-section gz-section karuzela-2">
	<div class="container">

		<div class="row">
			<div class="col-12 gz-title text-lg-start text-center">
				<h2>{{$tytul_modulu}}</h2>
			</div>
			<div class="col-12">
				<div id="carousel-gz-1" class="carousel">

					<div class="carousel-inner">
						{{$tresc}}
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carousel-gz-1" data-bs-slide="prev">
						<span class="carousel-control-slider-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carousel-gz-1" data-bs-slide="next">
						<span class="carousel-control-slider-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered gz-modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<iframe id="videoPlayerIframe" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="display: none;"></iframe>
					<video controls id="videoPlayer" style="width: 100%; display: none;"></video>
				</div>
			</div>
		</div>
	</div>
</section>
{{END}}

{{BEGIN kontener_sekcja_kurier}}
<section class="gz-kurier gz-section karuzela-6">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div id="carousel-gz-2" class="carousel">
					<div class="carousel-inner">
						{{$tresc}}
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carousel-gz-2" data-bs-slide="prev">
						<span class="carousel-control-slider-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden"></span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carousel-gz-2" data-bs-slide="next">
						<span class="carousel-control-slider-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
{{END}}

{{BEGIN kontener_sekcja_banery}}
<section class="gz-banery-01 karuzela-4">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div id="carousel-gz-3" class="carousel">
					<div class="carousel-inner">
						{{$tresc}}
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carousel-gz-3" data-bs-slide="prev">
						<span class="carousel-control-slider-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden"></span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carousel-gz-3" data-bs-slide="next">
						<span class="carousel-control-slider-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
{{END}}