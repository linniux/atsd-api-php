# Meters application. 

This application shows you how to use atsd-api-php client with a real use case.
Read more about this use case on [axibase.com]

To implement it, execute the following steps:

#### Install [atsd-api-php] client.

#### Enable digest authentication on your apache server:
```bash
sudo a2enmod auth_digest
sudo service apache2 restart
```
#### Install ```apache2-utils``` package to use ```htdigest``` utill (is required to generate authentication file)
```bash
sudo apt-get install apache2-utils
```
#### Generate password file:
```bash
touch atsd-api-php/meters/.htpasswd
htdigest atsd-api-php/meters/.htpasswd meters admin
htdigest atsd-api-php/meters/.htpasswd meters user-001
htdigest atsd-api-php/meters/.htpasswd meters user-002
htdigest atsd-api-php/meters/.htpasswd meters guest
```
#### Modify ```atsd-api-php/meters/.htaccess``` and set right full path to ```.htpasswd``` file:
```bash
AuthUserFile "/documentRoot/atsd-api-php/meters/.htpasswd"
```
#### Test it on your site: yourDomainName/atsd-api-php/meters/

Make sure you set the right ATSD user and password in atsd-api-php/atsdPHP/atsd.ini

#### Troubleshooting

If you get the following error, ensure that variable AuthUserFile in ```atsd-api-php/meters/.htaccess``` is pointing to your ```.htpasswd``` file.
```
Internal Server Error
The server encountered an internal error or misconfiguration and was unable to complete your request.
```

[atsd-api-php]:https://github.com/axibase/atsd-api-php
[axibase.com]:http://axibase.com/products/axibase-time-series-database/visualization/embedded-widgets/external-application/
