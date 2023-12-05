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

	<!-- dodatkowe naglowki -->
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
		{{ $region_2 }}
	</div>
</nav>
<!-- Navbar END -->
<!-- Sekcja 1 -->

<!-- Sekcja 1 END-->


<!-- Sekcja 2 -->
{{ $region_0 }}
<!-- Sekcja 2 END-->

<!-- Sekcja 3 Icon box 01 -->
<section class="gz-section">
	<div class="container" id="tiles-container">
		<div class="row">
			<div class="col-12 gz-title gz-mt-60 text-lg-start text-center">
				<h2>Załatw sprawę w urzędzie</h2>
				<h5>Wybierz jedno najczęściej wybieranych zagadnień</h5>
			</div>
		</div>
		<div class="row gz-mt-20">
			<div class="col-md-3 col-6 tile">
				<a href="#">
					<div class="gz-icobox-1 gz-mt-10">
						<img src="/_szablon/images/ico/ico-06.svg" alt="Druki i formularze">
						<p>Druki i formularze</p>
					</div>
				</a>
			</div>
			<div class="col-md-3 col-6 tile">
				<a href="#">
					<div class="gz-icobox-1 gz-mt-10">
						<img src="/_szablon/images/ico/ico-07.svg" alt="Druki i formularze">
						<p>Tereny budowlane</p>
					</div>
				</a>
			</div>

			<div class="col-md-3 col-6 tile">
				<a href="#">
					<div class="gz-icobox-1 gz-mt-10">
						<img src="/_szablon/images/ico/ico-08.svg" alt="Druki i formularze">
						<p>Przetargi</p>
					</div>
				</a>
			</div>

			<div class="col-md-3 col-6 tile">
				<a href="#">
					<div class="gz-icobox-1 gz-mt-10">
						<img src="/_szablon/images/ico/ico-09.svg" alt="Druki i formularze">
						<p>Konsultacje społeczne</p>
					</div>
				</a>
			</div>

		</div>

		<div class="row">

			<div class="col-md-3 col-6 tile hidden">
				<a href="#">
					<div class="gz-icobox-1 gz-mt-10">
						<img src="/_szablon/images/ico/ico-06.svg" alt="Druki i formularze">
						<p>Druki i formularze</p>
					</div>
				</a>
			</div>

			<div class="col-md-3 col-6 tile hidden">
				<a href="#">
					<div class="gz-icobox-1 gz-mt-10">
						<img src="/_szablon/images/ico/ico-07.svg" alt="Druki i formularze">
						<p>Tereny budowlane</p>
					</div>
				</a>
			</div>

			<div class="col-md-3 col-6 tile hidden">
				<a href="#">
					<div class="gz-icobox-1 gz-mt-10">
						<img src="/_szablon/images/ico/ico-08.svg" alt="Druki i formularze">
						<p>Przetargi</p>
					</div>
				</a>
			</div>

			<div class="col-md-3 col-6 tile hidden">
				<a href="#">
					<div class="gz-icobox-1 gz-mt-10">
						<img src="/_szablon/images/ico/ico-09.svg" alt="Druki i formularze">
						<p>Konsultacje społeczne</p>
					</div>
				</a>
			</div>

		</div>

		<div class="row">

			<div class="col-md-3 col-6 tile hidden">
				<a href="#">
					<div class="gz-icobox-1 gz-mt-10">
						<img src="/_szablon/images/ico/ico-06.svg" alt="Druki i formularze">
						<p>Druki i formularze</p>
					</div>
				</a>
			</div>

			<div class="col-md-3 col-6 tile hidden">
				<a href="#">
					<div class="gz-icobox-1 gz-mt-10">
						<img src="/_szablon/images/ico/ico-07.svg" alt="Druki i formularze">
						<p>Tereny budowlane</p>
					</div>
				</a>
			</div>

			<div class="col-md-3 col-6 tile hidden">
				<a href="#">
					<div class="gz-icobox-1 gz-mt-10">
						<img src="/_szablon/images/ico/ico-08.svg" alt="Druki i formularze">
						<p>Przetargi</p>
					</div>
				</a>
			</div>

			<div class="col-md-3 col-6 tile hidden">
				<a href="#">
					<div class="gz-icobox-1 gz-mt-10">
						<img src="/_szablon/images/ico/ico-09.svg" alt="Druki i formularze">
						<p>Konsultacje społeczne</p>
					</div>
				</a>
			</div>

		</div>


		<div class="row">

			<div class="col-12 align-items-center d-flex justify-content-center">
				<button id="toggle-btn" class="btn btn-outline-primary gz-cta-more">Wczytaj więcej</button>
			</div>

		</div>

	</div>
</section>
<!-- Sekcja 3 Icon box 01 -->

<!-- Sekcja 4 Counter dni do wydarzenia -->
<section class="gz-section ">
	<div class="container gz-mt-40">
		<div class="row">
			<div class="col-12">
				<!-- Karuzela -->
				<div id="gz-slider-homepage-2" class="carousel slide carousel-dark" data-bs-ride="carousel">
					<!-- Karuzela nawigacja-->
					<button class="carousel-control-prev" type="button" data-bs-target="#gz-slider-homepage-2" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#gz-slider-homepage-2" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
					<!-- Karuzela nawigacja END-->
					<div class="carousel-inner ">
						<!-- bloczek karuzeli 1 -->
						<div class="carousel-item active gz-counter" data-bs-interval="3000">
							<div class="gz-event-label zolty">Najbliższe wydarzenia</div>
							<div class="row align-items-center gz-counter-container">
								<div class="col-xxl-5 col-lg-5 col-12 text-lg-start text-center">
									<h3>Dożynki w gminie zarzecze</h3>
									<p>Pellentesque habitant morbi tristique...</p>
								</div>
								<!-- Ustawienie początkowej daty jest w pliku gz-js.js nagłówek: Odliczanie/counter Homepage zaczyna się od 29 lini-->
								<div class="col-xxl-4 col-lg-4  col-12 d-flex justify-content-center ">
									<div class="counter-box d-flex flex-column justify-content-center">
										<span id="dni1-val" class="counter-value">10</span>
										<span id="dni1-label" class="counter-label">dni</span>
									</div>
									<div class="counter-box d-flex flex-column justify-content-center">
										<span id="godziny1-val" class="counter-value">4</span><br>
										<span id="godziny1-label" class="counter-label">godziny</span>
									</div>
									<div class="counter-box d-flex flex-column justify-content-center">
										<span id="minuty1-val" class="counter-value">25</span><br>
										<span id="minuty1-label" class="counter-label">minut</span>
									</div>
									<div class="counter-box d-flex flex-column justify-content-center">
										<span id="sekundy1-val" class="counter-value">0</span><br>
										<span id="sekundy1-label" class="counter-label">sekund</span>
									</div>
								</div>
								<div class="col-xxl-3 col-lg-3 col-12 text-center ">
									<button class="btn btn-outline-primary text-end">Wszystkie Informacje</button>
								</div>
							</div>
						</div>
						<!-- bloczek karuzeli 1 END -->
						<!-- bloczek karuzeli 2 -->
						<div class="carousel-item gz-counter" data-bs-interval="3000">
							<div class="gz-event-label czerwony">Ostatnie bilety</div>
							<div class="row align-items-center gz-counter-container">
								<div class="col-xxl-5 col-lg-5 col-12 text-lg-start text-center">
									<h3>"Filcharmonia w twojej gminie"</h3>
									<p>Malesuada fames ac turpis egestas...</p>
								</div>
								<!-- Ustawienie początkowej daty jest w pliku gz-js.js nagłówek: Odliczanie/counter Homepage zaczyna się od 29 lini-->
								<div class="col-xxl-4 col-lg-4  col-12 d-flex justify-content-center ">
									<div class="counter-box d-flex flex-column justify-content-center">
										<span id="dni2-val" class="counter-value">10</span><br>
										<span id="dni2-label" class="counter-label">dni</span>
									</div>
									<div class="counter-box d-flex flex-column justify-content-center">
										<span id="godziny2-val" class="counter-value">4</span><br>
										<span id="godziny2-label" class="counter-label">godziny</span>
									</div>
									<div class="counter-box d-flex flex-column justify-content-center">
										<span id="minuty2-val" class="counter-value">25</span><br>
										<span id="minuty2-label" class="counter-label">minut</span>
									</div>
									<div class="counter-box d-flex flex-column justify-content-center">
										<span id="sekundy2-val" class="counter-value">0</span><br>
										<span id="sekundy2-label" class="counter-label">sekund</span>
									</div>
								</div>
								<div class="col-xxl-3 col-lg-3 col-12 text-center ">
									<button class="btn btn-outline-primary text-end">Wszystkie Informacje</button>
								</div>
							</div>
						</div>
						<!-- bloczek karuzeli 2 END -->
						<!-- bloczek karuzeli 3 -->
						<div class="carousel-item gz-counter" data-bs-interval="3000">
							<div class="gz-event-label niebieski">Sport</div>
							<div class="row align-items-center gz-counter-container">
								<div class="col-xxl-5 col-lg-5 col-12 text-lg-start text-center">
									<h3>Mecz piłki nożnej</h3>
									<p>Sed at ipsum sapien. Sed non nunc libero...</p>
								</div>
								<!-- Ustawienie początkowej daty jest w pliku gz-js.js nagłówek: Odliczanie/counter Homepage zaczyna się od 29 lini-->
								<div class="col-xxl-4 col-lg-4 col-12 d-flex justify-content-center ">
									<div class="counter-box d-flex flex-column justify-content-center">
										<span id="dni3-val" class="counter-value">10</span><br>
										<span id="dni3-label" class="counter-label">dni</span>
									</div>
									<div class="counter-box d-flex flex-column justify-content-center">
										<span id="godziny3-val" class="counter-value">4</span><br>
										<span id="godziny3-label" class="counter-label">godziny</span>
									</div>
									<div class="counter-box d-flex flex-column justify-content-center">
										<span id="minuty3-val" class="counter-value">25</span><br>
										<span id="minuty3-label" class="counter-label">minut</span>
									</div>
									<div class="counter-box d-flex flex-column justify-content-center">
										<span id="sekundy3-val" class="counter-value">0</span><br>
										<span id="sekundy3-label" class="counter-label">sekund</span>
									</div>
								</div>
								<div class="col-xxl-3 col-lg-3 col-12 text-center ">
									<button class="btn btn-outline-primary text-end">Wszystkie Informacje</button>
								</div>
							</div>
						</div>
						<!-- bloczek karuzeli 3 END -->
					</div>
					<!-- Karuzela END-->
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Sekcja 4 Counter dni do wydarzenia -->

<!-- Sekcja 5 Kalendarz wydarzenia -->
<section class="gz-section">
	<div class="container gz-kalendarz-container">
		<div class="row gz-kalendarz">
			<div class="col-md-6 gz-kalendarz-left">
				<!-- sterowanie kalendarz -->
				<div class="d-flex justify-content-center align-items-center">
					<button id="prev" class="btn-nav"><img src="/_szablon/images/ico/ico-04.svg" alt="Poprzedni miesiąc" width="25"></button>
					<span id="currentMonth" class="gz-miesiac"></span>
					<button id="next" class="btn-nav"><img src="/_szablon/images/ico/ico-05.svg" alt="Następny miesiąc" width="25"></button>
				</div>
				<!-- kalendarz -->
				<table>
					<thead>
					<tr>
						<th>Pn</th>
						<th>Wt</th>
						<th>Śr</th>
						<th>Cz</th>
						<th>Pt</th>
						<th>So</th>
						<th>Nd</th>
					</tr>
					</thead>
					<tbody id="days"></tbody>
				</table>
				<!-- wiecej informacji cta -->
				<div class="d-flex justify-content-end">
					<a href="#" class="gz-cta-text">Pełna lista wydarzeń »</a>
				</div>
			</div>
			<div class="col-md-6 gz-kalendarz-right" id="eventDetails"></div>
		</div>
	</div>
</section>
<!-- Sekcja 5 END-->

<!-- Sekcja 6 Galeria -->
<section class="gz-section gz-gallery-section gz-mt-60">
	<div class="container">
		<div class="row">
			<div class="col-12 gz-title text-lg-start text-center">
				<h2>Galeria</h2>
				<h5>Wybierz jedno najczęściej wybieranych zagadnień</h5>
				<div class="gz-newscenter-sorter" role="group" aria-label="Tagi">
					<button type="button" class="btn btn-primary btn-sm" onclick="filterGallery('')">Wszystko</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterGallery('sport')">Sport</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterGallery('wydarzenia')">Wydarzenia</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterGallery('kultura')">Kultura</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterGallery('nauka')">Nauka</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterGallery('obiekty_sakralne')">Obiekty sakralne</button>
					<button type="button" class="btn btn-outline-primary btn-sm" onclick="filterGallery('zabytki')">Zabytki</button>
					<!-- ... Dodaj więcej przycisków filtrów według potrzeb -->
				</div>
			</div>
			<div class="row ">
				<div class="col-lg-4 col-6 gallery-item" data-tags="nauka sport">
					<img src="/_szablon/images/jpg/img-jpg-09.jpg" alt="opis zdjęcia">
					<div class="gallery-overlay"></div>
					<div class="gallery-content">
						<div class="gallery-tags">
							<ul>
								<li>Nauka</li>
								<li>Sport</li>
							</ul>
						</div>
						<h4 class="gallery-title">Szkoła w naszej w naszej gminie</h4>
					</div>
					<button class="gallery-button">Cała galeria »</button>
				</div>
				<div class="col-lg-4 col-6 gallery-item" data-tags="wydarzenia sport">
					<img src="/_szablon/images/jpg/img-jpg-13.jpg" alt="opis zdjęcia">
					<div class="gallery-overlay"></div>
					<div class="gallery-content">
						<div class="gallery-tags">
							<ul>
								<li>Sport</li>
							</ul>
						</div>
						<h4 class="gallery-title">Zawody szkolne o puchar Gminy Zarzecze</h4>
					</div>
					<button class="gallery-button">Cała galeria »</button>
				</div>
				<div class="col-lg-4 col-6 gallery-item" data-tags="sport obiekty_sakralne zabytki">
					<img src="/_szablon/images/jpg/img-jpg-10.jpg" alt="opis zdjęcia">
					<div class="gallery-overlay"></div>
					<div class="gallery-content">
						<div class="gallery-tags">
							<ul>
								<li>Sport</li>
								<li>Obiekty sakralne</li>
								<li>Zabytki</li>
							</ul>
						</div>
						<h4 class="gallery-title">Rajd rowerowy 2023</h4>
					</div>
					<button class="gallery-button">Cała galeria »</button>
				</div>
				<div class="col-lg-4 col-6 gallery-item" data-tags="sport wydarzenia">
					<img src="/_szablon/images/jpg/img-jpg-12.jpg" alt="opis zdjęcia">
					<div class="gallery-overlay"></div>
					<div class="gallery-content">
						<div class="gallery-tags">
							<ul>
								<li>Sport</li>
								<li>Wydarzenia</li>
							</ul>
						</div>
						<h4 class="gallery-title">Mecz  piłki nożnej</h4>
					</div>
					<button class="gallery-button">Cała galeria »</button>
				</div>
				<div class="col-lg-4 col-6 gallery-item" data-tags="kultura">
					<img src="/_szablon/images/jpg/img-jpg-14.jpg" alt="opis zdjęcia">
					<div class="gallery-overlay"></div>
					<div class="gallery-content">
						<div class="gallery-tags">
							<ul>
								<li>Kultura</li>
							</ul>
						</div>
						<h4 class="gallery-title">Nasza gmina zlotu ptaka</h4>
					</div>
					<button class="gallery-button">Cała galeria »</button>
				</div>
				<div class="col-lg-4 col-6 gallery-item" data-tags="zabytki">
					<img src="/_szablon/images/jpg/img-jpg-11.jpg" alt="opis zdjęcia">
					<div class="gallery-overlay"></div>
					<div class="gallery-content">
						<div class="gallery-tags">
							<ul>
								<li>Zabytki</li>
							</ul>
						</div>
						<h4 class="gallery-title">Stary dworek</h4>
					</div>
					<button class="gallery-button">Cała galeria »</button>
				</div>

				<!-- Ukryte -->

				<div class="col-lg-4 col-6 gallery-item hidden-box" data-tags="nauka sport">
					<img src="/_szablon/images/jpg/img-jpg-09.jpg" alt="opis zdjęcia">
					<div class="gallery-overlay"></div>
					<div class="gallery-content">
						<div class="gallery-tags">
							<ul>
								<li>Nauka</li>
								<li>Sport</li>
							</ul>
						</div>
						<h4 class="gallery-title">Szkoła w naszej w naszej gminie</h4>
					</div>
					<button class="gallery-button">Cała galeria »</button>
				</div>
				<div class="col-lg-4 col-6 gallery-item hidden-box" data-tags="wydarzenia sport">
					<img src="/_szablon/images/jpg/img-jpg-13.jpg" alt="opis zdjęcia">
					<div class="gallery-overlay"></div>
					<div class="gallery-content">
						<div class="gallery-tags">
							<ul>
								<li>Sport</li>
							</ul>
						</div>
						<h4 class="gallery-title">Zawody szkolne o puchar Gminy Zarzecze</h4>
					</div>
					<button class="gallery-button">Cała galeria »</button>
				</div>
				<div class="col-lg-4 col-6 gallery-item hidden-box" data-tags="sport obiekty_sakralne zabytki">
					<img src="/_szablon/images/jpg/img-jpg-10.jpg" alt="opis zdjęcia">
					<div class="gallery-overlay"></div>
					<div class="gallery-content">
						<div class="gallery-tags">
							<ul>
								<li>Sport</li>
								<li>Obiekty sakralne</li>
								<li>Zabytki</li>
							</ul>
						</div>
						<h4 class="gallery-title">Rajd rowerowy 2023</h4>
					</div>
					<button class="gallery-button">Cała galeria »</button>
				</div>
				<div class="col-lg-4 col-6 gallery-item hidden-box" data-tags="sport wydarzenia">
					<img src="/_szablon/images/jpg/img-jpg-12.jpg" alt="opis zdjęcia">
					<div class="gallery-overlay"></div>
					<div class="gallery-content">
						<div class="gallery-tags">
							<ul>
								<li>Sport</li>
								<li>Wydarzenia</li>
							</ul>
						</div>
						<h4 class="gallery-title">Mecz  piłki nożnej</h4>
					</div>
					<button class="gallery-button">Cała galeria »</button>
				</div>
				<div class="col-lg-4 col-6 gallery-item hidden-box" data-tags="kultura">
					<img /_szablon/images/jpg/img-jpg-14.jpg" alt="opis zdjęcia">
					<div class="gallery-overlay"></div>
					<div class="gallery-content">
						<div class="gallery-tags">
							<ul>
								<li>Kultura</li>
							</ul>
						</div>
						<h4 class="gallery-title">Nasza gmina zlotu ptaka</h4>
					</div>
					<button class="gallery-button">Cała galeria »</button>
				</div>
				<div class="col-lg-4 col-6 gallery-item hidden-box" data-tags="zabytki">
					<img /_szablon/images/jpg/img-jpg-11.jpg" alt="opis zdjęcia">
					<div class="gallery-overlay"></div>
					<div class="gallery-content">
						<div class="gallery-tags">
							<ul>
								<li>Zabytki</li>
							</ul>
						</div>
						<h4 class="gallery-title">Stary dworek</h4>
					</div>
					<button class="gallery-button">Cała galeria »</button>
				</div>
				<div class="col-12 text-center">
					<button onclick="loadMoreBoxes()" class="btn btn-outline-primary gz-cta-more" >Wczytaj więcej</button>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Sekcja 6 Galeria END-->

<!-- Sekcja 7 Video Galeria -->
<section class="gz-section gz-video-gallery-section gz-mt-60">
	<div class="container">
		<div class="row">
			<div class="col-12 gz-title text-lg-start text-center">
				<h2>Załatw sprawę w urzędzie</h2>
				<h5>Wybierz jedno najczęściej wybieranych zagadnień</h5>
			</div>
			<!-- Karuzela -->
			<div id="gz-slider-homepage-3" class="carousel slide carousel-dark gz-mt-20" data-bs-ride="carousel">
				<!-- Karuzela nawigacja-->
				<button class="carousel-control-prev" type="button" data-bs-target="#gz-slider-homepage-3" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#gz-slider-homepage-3" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
				<!-- Karuzela nawigacja END-->
				<div class="carousel-inner ">
					<!-- bloczek karuzeli 1 -->
					<div class="carousel-item active " data-bs-interval="3000">
						<div class="row">
							<div class="col-6">
								<div class="video-thumbnail" onclick="openVideoModal('images/video/gz-video-01.mp4')">
									<div class="gallery-overlay"></div>
									<img src="/_szablon/images/jpg/img-jpg-15.jpg" class="img-fluid" alt="Video 1">
									<div class="video-gallery-content">
										<h4>GOSIR Zarzecze - Film  promocyjny</h4>
										<time datetime="2023-10-27">2023-10-27</time>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="video-thumbnail" onclick="openVideoModal('images/video/gz-video-01.mp4')">
									<div class="gallery-overlay"></div>
									<img src="/_szablon/images/jpg/img-jpg-16.jpg" class="img-fluid" alt="Video 1">
									<div class="video-gallery-content">
										<h4>Gmina Zarzecze - Wiosna</h4>
										<time datetime="2023-10-27">2023-10-27</time>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- bloczek karuzeli 1 END -->
					<!-- bloczek karuzeli 2 -->
					<div class="carousel-item" data-bs-interval="3000">
						<div class="row">
							<div class="col-6">
								<div class="video-thumbnail" onclick="openVideoModal('images/video/gz-video-01.mp4')">
									<div class="gallery-overlay"></div>
									<img src="/_szablon/images/jpg/img-jpg-15.jpg" class="img-fluid" alt="Video 1">
									<div class="video-gallery-content">
										<h4>GOSIR Zarzecze - Film  promocyjny</h4>
										<time datetime="2023-10-27">2023-10-27</time>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="video-thumbnail" onclick="openVideoModal('images/video/gz-video-01.mp4')">
									<div class="gallery-overlay"></div>
									<img src="/_szablon/images/jpg/img-jpg-16.jpg" class="img-fluid" alt="Video 1">
									<div class="video-gallery-content">
										<h4>Gmina Zarzecze - Wiosna</h4>
										<time datetime="2023-10-27">2023-10-27</time>
									</div>
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
	<!-- Video Modal -->
	<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered gz-modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<video controls id="videoPlayer"></video>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Sekcja 7 Video Galeria END-->

<!-- Sekcja 8 Kurier -->
<section class="gz-section gz-kurier gz-mt-60">
	<div class="container">
		<div class="row">
			<div class="col-12 gz-title text-lg-start text-center">
				<h2>Załatw sprawę w urzędzie</h2>
				<h5>Wybierz jedno najczęściej wybieranych zagadnień</h5>
			</div>
			<!-- Karuzela -->
			<div class="col-12 carousel slide carousel-dark" id="gz-slider-homepage-4" class="carousel slide carousel-dark" data-bs-ride="carousel">
				<!-- Karuzela nawigacja-->
				<button class="carousel-control-prev" type="button" data-bs-target="#gz-slider-homepage-4" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#gz-slider-homepage-4" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
				<!-- Karuzela nawigacja END-->
				<div class="carousel-inner ">
					<!-- bloczek karuzeli 1 -->
					<div class="carousel-item active" data-bs-interval="3000">
						<div class="row">
							<div class="col-xl-2 col-md-4 col-6 ">
								<div class="gz-kurier-item">
									<img src="/_szablon/images/jpg/img-jpg-17.jpg"  alt="">
									<h4>Marzec 2023 </h4>
									<span>numer 1 (51)</span>
								</div>
							</div>
							<div class="col-xl-2 col-md-4 col-6 ">
								<div class="gz-kurier-item">
									<img src="/_szablon/images/jpg/img-jpg-18.jpg"  alt="">
									<h4>Grudzień 2022</h4>
									<span>numer 4 (50)</span>
								</div>
							</div>
							<div class="col-xl-2 col-md-4 col-6">
								<div class="gz-kurier-item">
									<img src="/_szablon/images/jpg/img-jpg-19.jpg"  alt="">
									<h4>Wrzesień 2022</h4>
									<span>numer 3(49)</span>
								</div>
							</div>
							<div class="col-xl-2 col-md-4 col-6">
								<div class="gz-kurier-item">
									<img src="/_szablon/images/jpg/img-jpg-20.jpg"  alt="">
									<h4>Marzec 2023 </h4>
									<span>numer 1 (51)</span>
								</div>
							</div>

							<div class="col-xl-2 col-md-4 col-6">
								<div class="gz-kurier-item">
									<img src="/_szablon/images/jpg/img-jpg-21.jpg"  alt="">
									<h4>Grudzień 2022</h4>
									<span>numer 4 (50)</span>
								</div>
							</div>

							<div class="col-xl-2 col-md-4 col-6">
								<div class="gz-kurier-item">
									<img src="/_szablon/images/jpg/img-jpg-22.jpg"  alt="">
									<h4>Wrzesień 2022</h4>
									<span>numer 3(49)</span>
								</div>
							</div>
						</div>
					</div>
					<!-- bloczek karuzeli 1 END -->
				</div>
				<!-- Karuzela END-->
			</div>
		</div>
	</div>
</section>
<!-- Sekcja 8 Kurier END-->

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
