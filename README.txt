=== Firebase Auth Wordpress ===
### sorry this is an old project no support is given only pull requests

link: http://ash2osh.com
Tags: login, firebase, authentication , auth
Requires at least: 3.5
Tested up to: 4.8.1


== Description ==

#auth for rest api
RewriteCond %{HTTP:Authorization} ^(.*)
RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]

#allow cors
<IfModule mod_headers.c>    
    Header set Access-Control-Allow-Origin *
</IfModule>

