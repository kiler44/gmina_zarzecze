{{BEGIN index}}
<section class="gz-section gz-page-title wyszukiwanie-pt">
    <div class="container">
        <div class="row">
            <!-- Page title -->
            <div class="col-12 text-center">

                <!-- Okruszki End-->
                {{BEGIN naglowek}}
                <h5>{{$tag_wyniki_wyszukiwania}} </h5>
                <span>dla</span>
                <h2>{{$fraza}}</h2>
                {{END}}
            </div>
            <!-- Page title End-->
        </div>
    </div>
</section>
<section class="gz-section gz-page-title">
    <div class="container">
        <div class="row">
            {{BEGIN wynik}}
                <div class="col-lg-6 col-6">
                    <div class="gz-wyszukiwanie-bloczek">
                        <div class="info-tags">
                            <ul>
                                <li class="wydarzenia" >{{$kategoria}}</li>
                            </ul>
                        </div>
                        {{BEGIN zdjecie}}
                        <img src="{{$url_zdjecia}}" />
                        {{END}}
                        <div class="content">
                            <!--
                            <div class="tags">
                                <ul>
                                    <li >{{$kategoria}}</li>
                                </ul>
                            </div>
                            -->
                            <time datetime="{{$data}}">{{$data}}</time>
                            <h4>{{$tytul}}</h4>
                        </div>
                        <a href="{{$link}}" class="btn btn-outline-primary justify-content-lg-end">Czytaj więcej »</a>
                    </div>
                </div>

            {{END}}
            <!--
            <a class="list-group-item list-group-item-action flex-column align-items-start" href="{{$link}}">
                    <div class="d-flex w-100 justify-content-between" data-tags="{{$tytul}}">
                        <h4  >{{$tytul}} <span class="badge bg-info" style="font-size: 12px;">{{$kategoria}}</span></small></h4>
                        <small><time datetime="{{$data}}">{{$data}}</time></small>
                    </div>
                    <p class="mb-1">{{$tresc}}</p>
                </a>
            <div class="col-12 aktualnosci-item" data-tags="{{$tytul}}">
                <div class="aktualnosci-content">
                    <time datetime="{{$data}}">{{$data}}</time> <span class="badge bg-info ">{{$kategoria}}</span>
                    <h4><a href="{{$link}}" >{{$tytul}}</a></h4>
                    <p>{{$tresc}}</p>
                </div>
            </div>-->
        </div>
        {{BEGIN pagerSekcja}}
        <div class="col-12">
            {{$pager}}
        </div>
        {{END}}
    </div>
</section>

{{END}}