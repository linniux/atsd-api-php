# Meters application. 

This application shows you how to use atsd-api-php client with a real use case.
Read more about this use case on [axibase.com]

To implement it, execute the following steps:

#### Install [atsd-api-php] client.

Make sure you set the right ATSD user and password in atsd-api-php/atsdPHP/atsd.ini

#### Enable digest authentication on your apache server:
```bash
$ sudo a2enmod auth_digest
$ sudo service apache2 restart
```

#### Test your connection ???????????

#### Install ```apache2-utils``` package to use ```htdigest``` utill (is required to generate authentication file)
```bash
$ sudo apt-get install apache2-utils
```
#### Generate password file:
```bash
$ touch atsd-api-php/meters/.htpasswd
$ htdigest atsd-api-php/meters/.htpasswd meters admin
$ htdigest atsd-api-php/meters/.htpasswd meters user-001
$ htdigest atsd-api-php/meters/.htpasswd meters user-002
$ htdigest atsd-api-php/meters/.htpasswd meters guest
```
#### Modify ```atsd-api-php/meters/.htaccess``` and specify the correct path to the ```.htpasswd``` file:
```
AuthUserFile "/documentRoot/atsd-api-php/meters/.htpasswd"
```
#### Access the application.
You can access the applicattion on the following URL:
yourDomainName/atsd-api-php/meters/
If you wish to make your URL more clear, you are able to create ```.htaccess``` file in your ```documentRoot``` with the following content:
```
RewriteEngine On
RewriteBase /
RewriteRule ^(meters/.*)$ /atsd-api-php/$1 
```
Make sure that rewrite mode is enable on your server, or enable it and restart the server:
```
$ sudo a2enmod rewrite
$ sudo service apache2 restart
```
Then you can access the application on the following URL:
yourDomainName/meters/

### Users-Group.
To define users group your are able to modify ```atsd-api-php/meters/users-group.ini``` file. 
users-group.ini example:
```bash
user-to-group]
admin = org-all-entities
user-001 = org-001-entities
user-002 = org-002-entities
user-guest = org-none-entities
```
Entities group are configuring with ATSD web interface.

#### Troubleshooting

If you get the following error, ensure that variable AuthUserFile in ```atsd-api-php/meters/.htaccess``` is pointing to your ```.htpasswd``` file.
```
Internal Server Error
The server encountered an internal error or misconfiguration and was unable to complete your request.
```

[atsd-api-php]:https://github.com/axibase/atsd-api-php
[axibase.com]:http://axibase.com/products/axibase-time-series-database/visualization/embedded-widgets/external-application/
