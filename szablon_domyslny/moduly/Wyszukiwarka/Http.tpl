{{BEGIN index}}
<section class="gz-section gz-page-title">
    <div class="container">
        <div class="row">
            <!-- Page title -->
            <div class="col-12 text-center">

                <!-- Okruszki End-->
                {{BEGIN naglowek}}
                <h1>{{$tag_wyniki_wyszukiwania}} {{$fraza}}</h1>
                {{END}}
                <h5>Lista wyników wyszukiwania</h5>
            </div>
            <!-- Page title End-->
        </div>
    </div>
</section>
<section class="gz-section gz-page-title">
    <div class="container">
        <div class="row">
            {{BEGIN wynik}}
            <div class="col-12 aktualnosci-item" data-tags="{{$tytul}}">
                <div class="aktualnosci-content">
                    <time datetime="{{$data}}">{{$data}}</time> <span class="badge bg-info ">{{$kategoria}}</span>
                    <h4><a href="{{$link}}" >{{$tytul}}</a></h4>
                    <p>{{$tresc}}</p>
                </div>
            </div>
            {{END}}
        </div>
        {{BEGIN pagerSekcja}}
        <div class="col-12">
            {{$pager}}
        </div>
        {{END}}
    </div>
</section>

{{END}}