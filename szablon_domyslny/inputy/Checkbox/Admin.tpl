<input type="checkbox" name="{{$nazwa}}" {{IF $wymagany}} required="required" {{END IF}} value="1" id="{{$nazwa}}" {{IF $zaznaczony}}checked="checked"{{END}} {{$atrybuty}}/>
<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony" />
