{{BEGIN index}}
<script type="text/javascript">

    $(document).on('change', ".zmienStatus", function (e) {
        var status = $(this).val();
        var id = $(this).parents('tr').attr('id');
        var dane = {status: status, id: id};

        ajax('{{$urlZmienStatus}}', potwierdzZmienStatus, dane, 'POST', 'json');
    });
    $(document).ready(function () {


    });

    function potwierdzZmienStatus(dane) {

        if (dane.blad == 1) {
            alertModal('Uwaga', 'Nie udało się zmienić statusu zamówienia');
        } else if (dane.smsWyslany == 1) {
            alertModal('Uwaga', 'Powiadominie sms zostało wysłane');
        }

        if (dane.blad == 0) {
            $('#zmienStatus_' + dane.idZamowienia).replaceWith(dane.select);
        }
    }

    /**  Obsluga ajax notatek **/
    var linkGlobal;

    function otworzOkno(link) {
        linkGlobal = link;

        $.ajax({
            url: link,
            type: 'POST',
            dataType: 'html',
            async: true,
            success: function (dane) {
                $('#oknoModalne .modal-body').html(dane);
                $('#oknoModalne').modal('show');
                $('#oknoModalne .modal-body, #oknoModalne .modal-body iframe html').css('background', 'none');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        })
        return false;
    }

    function aktualizujNotatki(idObiektu) {

        var url = {{$linkAktualizujNotatki}} +"&id=" + idObiektu;

        $('#' + idObiektu).children(".zamowienie-opis").find(".opis > .notatki").html('<div class="spinner"></div>');
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            async: true,
            success: function (dane) {
                $('#' + idObiektu).children(".zamowienie-opis").find(".opis > .notatki").html(dane);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        })
        return false;
    }

    function usunNotatka(link) {
        var linkAjax = link;

        $.ajax({
            url: linkAjax,
            type: 'POST',
            dataType: 'json',
            async: true,
            success: function (dane) {
                $('#oknoModalne #tabela').html(dane.grid);
                aktualizujNotatki(dane.idObiekt);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        })
        return false;
    }

    $("#notes_form").live('submit', function () {
        $.ajax({
                url: linkGlobal,
                type: $('#notes_form').attr('method'),
                data: $('#notes_form').serialize(),
                dataType: 'json',
                async: true,
                success: function (dane) {

                    if (dane.kod == '1') {
                        $('#miejsceNaFormularz').html(dane.info);
                    }
                    if (dane.kod == '2') {
                        $('#oknoModalne #tabela').html(dane.notatka);
                        $('#miejsceNaFormularz').html(dane.formularz);
                        if (linkGlobal.indexOf("editNote") >= 0) {
                            $('#oknoModalne').attr('aria-hidden', 'true');
                            $('#oknoModalne').modal('hide');
                            window.location.reload();
                        } else {
                            aktualizujNotatki(dane.idObject);
                        }
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            }
        )
        return false;
    });
</script>
{{$grid}}
{{END}}

{{BEGIN dodaj}}
{{$formularz}}
{{END}}

{{BEGIN podglad}}
<div class="widget-box">
    <div class="widget-content">
        <div class="tabbable inline">
            <div class="tab-content no-overflow">
                <div id="panel_tab2" class="tab-pane active">
                    <div class="widget-box">
                        <div class="widget-title">
						<span class="icon">
							<i class="icon icon-th-list"></i>
						</span>
                            <h5>{{$etykietaNaglowek}}</h5>
                            <!--
                            <div class="buttons">
                                <a class="btn" href="javascript: modalIFrame('{{$linkDrukuj}}');"
                                   title="{{$etykietaDrukuj}}">
                                    <i class="icon icon-print"></i>
                                    <span class="text">{{$etykietaDrukuj}}</span>
                                </a>
                            </div>
                               -->
                        </div>

                        <div class="widget-content">
                            <div class="invoice-content">
                                <div class="invoice-head">
                                    <div class="invoice-meta">
                                        {{$zamowienieNoEtykieta}}
                                        <span class="invoice-number">#{{$zamowienieNo}} <strong>( {{$tytul}} )</strong></span>
                                        <span class="invoice-date">
                                            {{$dataEtykieta}} {{$data}} <br/>
                                            {{$termin_etykieta}} {{$termin}}
                                        </span>
                                    </div>
                                    <h4>{{$dane_etykieta}}</h4>
                                    <div class="invoice-from">
                                        <ul>
                                            <li>
											<span>
												<strong>{{$dane_klienta_etykieta}}</strong>
											</span>
                                                <span>{{$klient}}</span>
                                                <span>{{$klient_ulica}}</span>
                                                <span>{{$klient_miasto}}</span>
                                                <span>{{$tel_etykieta}} {{$klient_telefon}}</span>
                                                <span>{{$mail_etykieta}} {{$klient_email}}</span>

                                            </li>
                                        </ul>
                                    </div>
                                    <div class="invoice-to">
                                        <ul>
                                            <li>
											<span>
												<strong>{{$dane_przyjmujacego_etykieta}}</strong>
											</span>
                                                <span>{{$dane_przyjmujacego}}</span>
                                            </li>
                                            <li>
                                            <span>
												<strong>{{$dane_wykonawcy_etykieta}}</strong>
											</span>
                                                <span>{{$wykonawca}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <h5>{{$szczeguly_zamowienia_etykieta}}</h5>
                                    <table class="table table-bordered table-striped table-hover">

                                        <tr>
                                            <th style="width: 10%;"> {{$model_etykieta}} </th>
                                            <td> {{$wybrany_model}} </td>

                                        </tr>
                                        <tr>
                                            <td> {{$rozmiar_etykieta}} </td>
                                            <td> {{$rozmiar}} </td>

                                        </tr>
                                        <tr>
                                            <td> {{$wysokosc_etykieta}} </td>
                                            <td> {{$wysokosc}} </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                {{$termin_etykieta}}
                                            </td>
                                            <td>
                                                {{$termin}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 10%;"> {{$zloto_info_etykieta}} </td>
                                            <td>
                                                {{BEGIN zlotoInfo}}
                                                {{$nazwa}}<br/>
                                                {{END zlotoInfo}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{$zloto_etykieta}}</td>
                                            <td>{{$zloto}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{$srebro_etykieta}}</td>
                                            <td>{{$srebro}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{$platyna_etykieta}}</td>
                                            <td>{{$platyna}}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Materiał klienta
                                            </td>
                                            <td>
                                                {{$materialKlienta}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> {{$etykieta_kamienKlienta}} </td>
                                            <td> {{$kamienKlienta}} </td>

                                        </tr>
                                        <tr>
                                            <td style="width: 10%;"> {{$kamienie_etykieta}} </td>
                                            <td>
                                                {{BEGIN kamien}}
                                                {{$nazwa}}: {{$ilosc}}<br/>
                                                {{END kamien}}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> {{$etykieta_rodzajOprawy}} </td>
                                            <td> {{$rodzajOprawy}} </td>

                                        </tr>
                                        <tr>
                                            <td>Grawer</td>
                                            <td>
                                                {{$grawer}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{$opis_etykieta}}</td>
                                            <td>{{$opis}}</td>
                                        </tr>
                                        <tfoot>
                                        <tr>
                                            <th class="total-label"><span
                                                        style="font-size : 14pt;">{{$cena_etykieta}} </span></th>
                                            <th style="text-align:center;" class="total-amount" id="koszykIlosc"><span
                                                        style="font-size : 14pt;"> {{$cena}} PLN ({{$rabat_etykieta}} : {{$rabat}})</span><br/>
                                                Zaliczka : {{$zaliczka}}
                                            </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <h5>{{$etykieta_notatka}}</h5>
                                    <ul>
                                        {{BEGIN notatki}}
                                        <li>
											<span>
												<strong>{{$autor}}  <small> ( {{$data}} )</small> </strong>
											</span><br/>
                                            <span>{{$notatka}}</span>
                                        </li>
                                        {{END notatki}}
                                    </ul>
                                </div>

                                <br class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
{{END}}



