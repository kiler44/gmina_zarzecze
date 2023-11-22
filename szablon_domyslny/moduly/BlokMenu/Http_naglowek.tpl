{{BEGIN index}}
<!-- Navbar START -->
<nav class="navbar navbar-dark navbar-expand-lg gz-navbar" aria-label="Ninth navbar example">
<!--<span>{{$tytul_modulu}}</span>-->
    <div class="container-xl justify-content-end">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#gz-Nav-Dropdown" aria-controls="gz-Nav-Dropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="gz-Nav-Dropdown">
            {{$drzewo}}
</div>
{{END}}

{{BEGIN drzewo}}
    <div class="collapse navbar-collapse" id="gz-Nav-Dropdown">
{{BEGIN listaStart}}<ul class="navbar-nav gz-ul-navbar">{{END}}
{{BEGIN elementStart}}<li class="nav-item dropdown">{{END}}
{{BEGIN elementTrescLink}}<a class="nav-link dropdown-toggle" href="{{$url}}" data-bs-toggle="dropdown" aria-expanded="false" title="{{escape($nazwa)}}">{{$nazwa}}</a>{{END}}
{{BEGIN elementTrescLinkSeo}}<span id="hsl{{$url}}" class="hsl">{{$nazwa}}</span>{{END}}
{{BEGIN elementTresc}}<span>{{$nazwa}}</span>{{END}}
{{BEGIN elementStop}}</li>{{END}}
{{BEGIN listaStop}}</ul>{{END}}
    </div>
{{END}}

<!--
            <ul class="navbar-nav gz-ul-navbar">
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Na bieżąco</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Ogłoszenia</a></li>
                        <li><a class="dropdown-item" href="#">Przetargi</a></li>
                        <li><a class="dropdown-item" href="#">OZE - Odnawialne Źródła Energii</a></li>
                        <li><a class="dropdown-item" href="#">Kurier Zarzecki</a></li>
                        <li><a class="dropdown-item" href="#">Ostrzeżenia meteorologiczne</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Sołtysów</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Parlamentarne 2019</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Prezydent RP 2020</a></li>
                        <li><a class="dropdown-item" href="#">Wybory uzupełniające do Rady Gminy</a></li>
                        <li><a class="dropdown-item" href="#">Wybory do Podkarpackiej Izby Rolniczej</a></li>
                        <li><a class="dropdown-item" href="#">Konsultacje społeczne</a></li>
                        <li><a class="dropdown-item" href="#">Petycje i wnioski</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Dla mieszkańców</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Ogłoszenia</a></li>
                        <li><a class="dropdown-item" href="#">Przetargi</a></li>
                        <li><a class="dropdown-item" href="#">OZE - Odnawialne Źródła Energii</a></li>
                        <li><a class="dropdown-item" href="#">Kurier Zarzecki</a></li>
                        <li><a class="dropdown-item" href="#">Ostrzeżenia meteorologiczne</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Sołtysów</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Parlamentarne 2019</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Prezydent RP 2020</a></li>
                        <li><a class="dropdown-item" href="#">Wybory uzupełniające do Rady Gminy</a></li>
                        <li><a class="dropdown-item" href="#">Wybory do Podkarpackiej Izby Rolniczej</a></li>
                        <li><a class="dropdown-item" href="#">Konsultacje społeczne</a></li>
                        <li><a class="dropdown-item" href="#">Petycje i wnioski</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Gmina Zarzecze</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Ogłoszenia</a></li>
                        <li><a class="dropdown-item" href="#">Przetargi</a></li>
                        <li><a class="dropdown-item" href="#">OZE - Odnawialne Źródła Energii</a></li>
                        <li><a class="dropdown-item" href="#">Kurier Zarzecki</a></li>
                        <li><a class="dropdown-item" href="#">Ostrzeżenia meteorologiczne</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Sołtysów</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Parlamentarne 2019</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Prezydent RP 2020</a></li>
                        <li><a class="dropdown-item" href="#">Wybory uzupełniające do Rady Gminy</a></li>
                        <li><a class="dropdown-item" href="#">Wybory do Podkarpackiej Izby Rolniczej</a></li>
                        <li><a class="dropdown-item" href="#">Konsultacje społeczne</a></li>
                        <li><a class="dropdown-item" href="#">Petycje i wnioski</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Urząd gminy</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Ogłoszenia</a></li>
                        <li><a class="dropdown-item" href="#">Przetargi</a></li>
                        <li><a class="dropdown-item" href="#">OZE - Odnawialne Źródła Energii</a></li>
                        <li><a class="dropdown-item" href="#">Kurier Zarzecki</a></li>
                        <li><a class="dropdown-item" href="#">Ostrzeżenia meteorologiczne</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Sołtysów</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Parlamentarne 2019</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Prezydent RP 2020</a></li>
                        <li><a class="dropdown-item" href="#">Wybory uzupełniające do Rady Gminy</a></li>
                        <li><a class="dropdown-item" href="#">Wybory do Podkarpackiej Izby Rolniczej</a></li>
                        <li><a class="dropdown-item" href="#">Konsultacje społeczne</a></li>
                        <li><a class="dropdown-item" href="#">Petycje i wnioski</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Kultura i oświata</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Ogłoszenia</a></li>
                        <li><a class="dropdown-item" href="#">Przetargi</a></li>
                        <li><a class="dropdown-item" href="#">OZE - Odnawialne Źródła Energii</a></li>
                        <li><a class="dropdown-item" href="#">Kurier Zarzecki</a></li>
                        <li><a class="dropdown-item" href="#">Ostrzeżenia meteorologiczne</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Sołtysów</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Parlamentarne 2019</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Prezydent RP 2020</a></li>
                        <li><a class="dropdown-item" href="#">Wybory uzupełniające do Rady Gminy</a></li>
                        <li><a class="dropdown-item" href="#">Wybory do Podkarpackiej Izby Rolniczej</a></li>
                        <li><a class="dropdown-item" href="#">Konsultacje społeczne</a></li>
                        <li><a class="dropdown-item" href="#">Petycje i wnioski</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Gospodarka</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Ogłoszenia</a></li>
                        <li><a class="dropdown-item" href="#">Przetargi</a></li>
                        <li><a class="dropdown-item" href="#">OZE - Odnawialne Źródła Energii</a></li>
                        <li><a class="dropdown-item" href="#">Kurier Zarzecki</a></li>
                        <li><a class="dropdown-item" href="#">Ostrzeżenia meteorologiczne</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Sołtysów</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Parlamentarne 2019</a></li>
                        <li><a class="dropdown-item" href="#">Wybory Prezydent RP 2020</a></li>
                        <li><a class="dropdown-item" href="#">Wybory uzupełniające do Rady Gminy</a></li>
                        <li><a class="dropdown-item" href="#">Wybory do Podkarpackiej Izby Rolniczej</a></li>
                        <li><a class="dropdown-item" href="#">Konsultacje społeczne</a></li>
                        <li><a class="dropdown-item" href="#">Petycje i wnioski</a></li>
                    </ul>
                </li>

            </ul>

            <a class="gz-nav-kontakt-cta ms-auto" href="#">Kontakt</a>
        </div>
    </div>
</nav>
<!-- Navbar END -->
