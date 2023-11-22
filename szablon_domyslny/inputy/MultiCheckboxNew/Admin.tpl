{{BEGIN lista}}<label for="{{$nazwa}}_{{$klucz}}"><input type="checkbox" id="{{$nazwa}}_{{$klucz}}" name="{{$nazwa}}[]" value="{{$klucz}}" {{$atrybuty}} {{IF $selected}}checked="checked"{{END}} /> {{$etykieta}}</label><br />{{END}}
<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony"/>
