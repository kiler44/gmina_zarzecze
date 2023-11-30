{{BEGIN komunikat}}
	<div class="komunikatBlok {{$klasa}} ">
		<div class="box {{$typ}}">
			<span class="komunikat_tresc">{{$tresc}}</span>
		</div>
	</div>
{{END}}


{{BEGIN index}}
<section class="gz-newscenter">
	<div class="container">
		<div class="row">
			<div class="col-12" id="czytaj-wiecej">
				<!-- Karuzela -->
				<div id="carouselExampleInterval" class="carousel slide carousel-dark" data-bs-ride="carousel">
					<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
					<div class="carousel-inner ">


{{BEGIN wiersz}}
	<div class="carousel-item {{IF $lp == 0}}active{{END}}" data-bs-interval="3000">
		<div class="row">
			<div class="col-md-6 col-12 gz-newscenter-left order-md-1 order-2">
				<!--<span class="badge bg-danger">Pilne</span>-->
				<h3>{{$tytul}}</h3>
				<p class="blog-post-meta">{{BEGIN autor}}<span class="autor">{{$autor}}</span>{{END}} {{$data_dodania}}</p>
				{{BEGIN zajawka}}<p>{{$zajawka_tresc}}</p>

				{{BEGIN link_wiecej}}<a href="{{$url}}" title="{{escape($tytul_alt)}}" class="more"><button class="btn btn-primary btn-lg ">{{$etykieta_link_wiecej}}</button></a>{{END}}
				{{END}}
			</div>
			<div class="col-md-6 col-12 gz-newscenter-right order-md-2 order-1">
				{{BEGIN zdjecie_glowne}}<img src="{{$zdjecie}}" alt="{{escape($tytul_alt)}}"/>
				{{END}}
			</div>
		</div>
	</div>
{{END}}
</div>
						<div class="row g-0">
							<div class="col-lg-8 col-12 gz-newscenter-sorter text-lg-start text-center g-0">
								<button type="button" class="btn btn-outline-primary btn-sm gz-sorter">Sport</button>
								<button type="button" class="btn btn-outline-primary btn-sm gz-sorter-przetarg">Przetargi</button>
								<button type="button" class="btn btn-outline-primary btn-sm">Aktualności</button>
								<button type="button" class="btn btn-outline-primary btn-sm">Ogłosznia</button>
								<button type="button" class="btn btn-outline-primary btn-sm">Wydarzenia</button>
								<button type="button" class="btn btn-outline-primary btn-sm">Kultura</button>
								<button type="button" class="btn btn-outline-primary btn-sm">Nauka</button>
								<button type="button" class="btn btn-outline-primary btn-sm">Inwestycje</button>
								<button type="button" class="btn btn-outline-primary btn-sm gz-sorter-allert">Ostatnia chwila</button>
							</div>
							{{BEGIN link_wiecej}}
							<div class="col-lg-4 col 12 d-flex justify-content-lg-end justify-content-center g-0">
								<a title="{{escape($etykieta_link_wiecej_aktualnosci)}}" href="{{$url_wiecej}}"><button class="btn btn-outline-primary sorter-more">{{$etykieta_link_wiecej_aktualnosci}}</button></a>
							</div>
							{{END}}
						</div>
					</div>




					</div>
				</div>
			</div>
		</div>
	</div>
</section>
{{END}}

