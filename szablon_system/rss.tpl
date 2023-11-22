<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
<channel>
<title>{{$tytul_kanalu}}</title>
<link>{{$url_kanalu}}</link>
<description>{{$opis_kanalu}}</description>
{{if($jezyk_kanalu,'<language>')}}{{if($jezyk_kanalu, $jezyk_kanalu)}}{{if($jezyk_kanalu,'</language>')}}
{{if($czas_odswierzania,'<ttl>')}}{{if($czas_odswierzania, $czas_odswierzania)}}{{if($czas_odswierzania,'</ttl>')}}
{{BEGIN wiersz}}
<item>
<title>{{$tytul}}</title>
<link>{{$url}}</link>
<description>{{$opis}}</description>
{{if($data_dodania,'<pubDate>')}}{{if($data_dodania,$data_dodania)}}{{if($data_dodania,'</pubDate>')}}
{{if($autor,'<author>')}}{{if($autor,$autor)}}{{if($autor,'</author>')}}
</item>
{{END}}
</channel>
</rss>

