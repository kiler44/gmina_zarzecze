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
                <h5>{{$info}}</h5>
            </div>
            <!-- Page title End-->
        </div>
    </div>
</section>
<section class="gz-section gz-page-title">
    <div class="container">
        <div class="row">
            <div class="list-group">
            {{BEGIN wynik}}
                <a class="list-group-item list-group-item-action flex-column align-items-start" href="{{$link}}">
                    <div class="d-flex w-100 justify-content-between" data-tags="{{$tytul}}">
                        <h4  >{{$tytul}} <span class="badge bg-info" style="font-size: 12px;">{{$kategoria}}</span></small></h4>
                        <small><time datetime="{{$data}}">{{$data}}</time></small>
                    </div>
                    <p class="mb-1">{{$tresc}}</p>

                </a>

            {{END}}
            </div>
            <!--
            div class="col-12 aktualnosci-item" data-tags="{{$tytul}}">
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