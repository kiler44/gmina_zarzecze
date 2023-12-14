{{BEGIN index}}
<section class="gz-section gz-gallery-section gz-mt-60">
    <div class="container">
        <div class="row">
            <div class="col-12 gz-title text-lg-start text-center">
                <h2>{{$galeria_naglowek}}</h2>
                <h5>{{$galeria_naglowek_dwa}}</h5>
                <div class="gz-newscenter-sorter" role="group" aria-label="Tagi">
                    {{BEGIN kategorieGalerii}}
                    <button type="button" class="btn btn-outline-primary {{IF $aktywna}} btn-primary {{END IF}} btn-sm" onclick="filterGallery('{{$kategoria}}')">{{$nazwa}}</button>
                    {{END kategorieGalerii}}
                </div>
            </div>
            <div class="row ">
                {{BEGIN galeriaKategoria}}
                <div class="col-lg-4 col-6 gallery-item {{IF $nie_wyswietlaj}} hidden-box {{END IF}}" data-tags="{{$kategoria}}">
                    <img src="{{$zdjecie}}" alt="{{$zdjecie_alt}}">
                    <div class="gallery-overlay"></div>
                    <div class="gallery-content">
                        <div class="gallery-tags">
                            <ul>
                                <li>{{$kategoria}}</li>
                            </ul>
                        </div>
                        <h4 class="gallery-title">{{$nazwa}}</h4>
                    </div>
                    <a class="gallery-button" href="{{$link}}">{{$etykieta_link_wiecej}}</a>
                </div>
                {{END galeriaKategoria}}

                <div class="col-12 text-center">
                    <button onclick="loadMoreBoxes()" class="btn btn-outline-primary gz-cta-more"> {{$czytaj_wiecej}} </button>
                </div>
            </div>
        </div>
    </div>
</section>
{{END}}