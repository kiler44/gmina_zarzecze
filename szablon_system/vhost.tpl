{{BEGIN vhost}}

# Konfiguracja VirtualHost-a Apache dla {{$domena}}

<VirtualHost ADRES_IP:80>
	ServerAdmin admin@{{$domena}}
	ServerSignature Off
	HostnameLookups Off

	# Mozliwe wartosci: debug, info, notice, warn, error, crit, alert, emerg.
	LogLevel warn
	ErrorLog /var/log/httpd/www.{{$domena}}-http.error
	TransferLog /var/log/httpd/www.{{$domena}}-http.log 
	CustomLog /var/log/httpd/www.{{$domena}}-http.combined combined env=!dontlogpic

	# Podstwowe opcje dotyczace katalogu
	DocumentRoot {{$katalog}}
	DirectoryIndex index.php
	ErrorDocument 404 /index.php

	#Opcje dotyczace przegladania
	<Directory "{{$katalog}}">
		Options -Indexes -ExecCGI +FollowSymLinks
		Order allow,deny
		Allow from All
		AllowOverride None
	</Directory>

	# Ochrona plikow
	<Files "\.(php|tpl|log|sql|tmp)$">
		Order deny,allow
		Deny from all
	</Files>

	Alias /_szablon {{$katalog}}{{$s}}szablony{{$s}}{{$kod}}{{$s}}{{$szablon}}
	Alias /_public {{$katalog}}{{$s}}temp{{$s}}{{$kod}}{{$s}}public
	Alias /_system {{$katalog}}{{$s}}szablony{{$s}}_system

	# Ustawienia PHP
	php_value session.cookie_domain ".{{$domena}}"

	SetEnv IQCMS_PROJEKT {{$kod}}

	#Mod Rewrite
	<IfModule mod_rewrite.c>
		RewriteEngine On
		# dozwolone katalogi
		RewriteCond %{REQUEST_FILENAME} !^(/_szablon|/_public|/_system|/crm)
		# dozwolone pliki
		RewriteCond %{REQUEST_FILENAME} !-f
		# wszystko inne idzie na index.php
		RewriteRule ^/(.*)$ /index.php?_p_={{$kod}}&_q_=$1 [L,QSA]
	</IfModule>

</VirtualHost>

<VirtualHost {{$domena}}:80>
	Redirect permanent / http://www.{{$domena}}/
	ErrorLog /var/log/httpd/redirects-{{$domena}}-http.error
	TransferLog /var/log/httpd/redirects-{{$domena}}-http.access
</VirtualHost>

{{END}}
