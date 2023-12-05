<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Google font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,900&display=swap" rel="stylesheet">

	<!-- Bootstrap css -->
	<link href="/_szablon/css/bootstrap.min.css" rel="stylesheet">
	<link href="/_szablon/css/style.css " rel="stylesheet">
	<script src="/_szablon/lightbox/css/lightbox.css"></script>
	<title>{{$tytul_strony}}</title>

	<meta name="description" content="{{$opis_strony}}" />
	<link rel="canonical" href="https://gminazarzecze.pl/" />
	<meta property="og:locale" content="pl_PL" />

	<meta property="og:type" content="website" />
	<meta property="og:title" content="{{$tytul_strony}}" />
	<meta property="og:description" content="{{$opis_strony}}" />
	<meta property="og:url" content="https://gminazarzecze.pl/" />
	<meta property="og:site_name" content="{{$tytul_strony}}" />



	<script src="/_szablon/js/jquery-3.6.0.min.js"></script>
	<script src="/_szablon/js/moment.min.js"></script>
	<script src="/_szablon/js/pl.min.js"></script>
	<script src="/_szablon/lightbox/js/lightbox.js"></script>
	<script>
		lightbox.option({
			'resizeDuration': 200,
			'wrapAround': true
		})
	</script>
	{{$naglowek_html}}
	{{BEGIN rss}}<link rel="alternate" type="application/rss+xml" title="{{$tytul}}" href="{{$url}}" />
	{{END}}
</head>
<body>
<!-- Header START -->
<header class="gz-header">
	<div class="container">
		<div><a class="herb" href="{$URL}"><img alt="{$alt_herb}" src="/_szablon/images/svg/img-svg-01.svg" /></a></div>
		<div class="row gz-navbar-top align-items-center">
			<div class="col-md-8 col-sm-6 col-8 gz-navbar-title">
				<h2>{$TOP_TYTUL}</h2>
				<span id="gz-span-text-change" data-md-text="{$TOP_HASLO}" data-xs-text="{$TOP_HASLO}"></span>
			</div>
			<div class="col-md-4 col-sm-6 col-4 d-flex justify-content-end flex-column flex-sm-row align-items-end align-items-sm-start">
				{{ $region_1 }}
			</div>
		</div>
	</div>
</header>
<!-- Header END -->

<!-- Navbar START -->
<nav class="navbar navbar-dark navbar-expand-lg gz-navbar" aria-label="Ninth navbar example">
	<div class="container-xl justify-content-end">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#gz-Nav-Dropdown" aria-controls="gz-Nav-Dropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		{{$region_2 }}
	</div>
</nav>
<!-- Navbar END -->



<!-- Sekcja 1 -->

<section class="gz-section">
	<div class="container">
		<div class="row">
			{{ $region_0 }}
		</div>
</section>
<!-- Sekcja 9 Banery-01 -->
<section class="gz-section gz-banery-01">
	<div class="container gz-mt-40 ">
		<div class="row">
			<div class="col-12">
				<!-- Karuzela -->
				<div id="gz-slider-homepage-5" class="carousel slide carousel-dark" data-bs-ride="carousel">
					<!-- Karuzela nawigacja-->
					<button class="carousel-control-prev" type="button" data-bs-target="#gz-slider-homepage-5" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#gz-slider-homepage-5" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
					<!-- Karuzela nawigacja END-->
					<div class="carousel-inner gz-margin-karuzela">
						<!-- bloczek karuzeli 1 -->
						<div class="carousel-item active" data-bs-interval="3000">
							<div class="row align-items-center gz-counter-container">

								<div class="col-md-3 col-6">
									<div class="gz-banery-item">
										<img src="/_szablon/images/jpg/img-jpg-23.jpg" alt="">
										<h4>Raport ostanie Gminy Zarzecz</h4>
									</div>
								</div>
								<div class="col-md-3 col-6">
									<div class="gz-banery-item">
										<img src="/_szablon/images/jpg/img-jpg-24.jpg" alt="">
										<h4>ZS Zarzecz</h4>
									</div>
								</div>
								<div class="col-md-3 col-6">
									<div class="gz-banery-item">
										<img src="/_szablon/images/jpg/img-jpg-25.jpg" alt="">
										<h4>OZE</h4>
									</div>
								</div>
								<div class="col-md-3 col-6">
									<div class="gz-banery-item">
										<img src="/_szablon/images/jpg/img-jpg-26.jpg" alt="">
										<h4>Czyste pwietrze</h4>
									</div>
								</div>
							</div>
						</div>
						<!-- bloczek karuzeli 1 END -->
						<!-- bloczek karuzeli 2 -->
						<div class="carousel-item" data-bs-interval="3000">
							<div class="row align-items-center gz-counter-container">
								<div class="col-md-3 col-6">
									<div class="gz-banery-item">
										<img src="/_szablon/images/jpg/img-jpg-23.jpg" alt="">
										<h4>Raport ostanie Gminy Zarzecz</h4>
									</div>
								</div>
								<div class="col-md-3 col-6">
									<div class="gz-banery-item">
										<img src="/_szablon/images/jpg/img-jpg-24.jpg" alt="">
										<h4>ZS Zarzecz</h4>
									</div>
								</div>
								<div class="col-md-3 col-6">
									<div class="gz-banery-item">
										<img src="/_szablon/images/jpg/img-jpg-25.jpg" alt="">
										<h4>OZE</h4>
									</div>
								</div>
								<div class="col-md-3 col-6">
									<div class="gz-banery-item">
										<img src="/_szablon/images/jpg/img-jpg-26.jpg" alt="">
										<h4>Czyste pwietrze</h4>
									</div>
								</div>
							</div>
						</div>
						<!-- bloczek karuzeli 2 END -->
					</div>
					<!-- Karuzela END-->
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Sekcja 9 Banery-01 END -->
<!-- Footer -->
<section class="gz-footer">
	<div class="container">
		<footer class="row">
			{{ $region_3 }}
		</footer>
	</div>
</section>
<section class="gz-footer-copyright">
	<div class="container">
		<footer class="row">
			<div class="col-12 text-center">
				{$podpis_stopka}
			</div>
		</footer>
	</div>
</section>
<!-- Footer End -->
<script src="/_szablon/js/bootstrap.bundle.min.js"></script>
<script src="/_szablon/js/gz-js.js"></script>
</body>
</html>
