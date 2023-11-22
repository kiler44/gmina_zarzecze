<input type="checkbox" name="{{$nazwa}}" value="1" id="{{$nazwa}}" {{IF $zaznaczony}}checked="checked"{{END}} {{$atrybuty}}/>
<label for="{{$nazwa}}" class="btn"><i class="icon-check-sign"></i></label>
<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony" />