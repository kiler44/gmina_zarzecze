<span id="{{$nazwa}}"></span><input type="checkbox" class="{{$klasa}}" name="{{$nazwa}}" value="1" id="checkbox_{{$nazwa}}" {{IF $zaznaczony}}checked="checked"{{END}} {{$atrybuty}}/>
<label for="checkbox_{{$nazwa}}">{{$opis}}</label>
<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony" />