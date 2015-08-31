# Meters application. 

This application shows you how to use atsd-api-php client with a real user case.

To implement it, execute the following steps:

1. Install [atsd-api-php] client.

2. Enable digest authentication on your apache server:
```bash
sudo a2enmod auth_digest
sudo service apache2 restart```
3. Install ```apache2-utils``` package to use ```htdigest``` utill (is required to generate authentication file)
```bash
sudo apt-get install apache2-utils```
4. Generate password file:
```bash
touch atsd-api-php/meters/.htpasswd
htdigest atsd-api-php/meters/.htpasswd meters admin
htdigest atsd-api-php/meters/.htpasswd meters user-001
htdigest atsd-api-php/meters/.htpasswd meters user-002
htdigest atsd-api-php/meters/.htpasswd meters guest```
5. Modify ```atsd-api-php/meters/.htaccess``` and set right full path to ```.htpasswd``` file:
```bash
AuthUserFile "/documentRoot/atsd-api-php/meters/.htpasswd"```
6. Test it on your site: yourDomainName/atsd-api-php/meters/

Make sure you set the right ATSD user and password in atsd-api-php/atsdPHP/atsd.ini

### Troubleshooting

If you get the following error, ensure that variable AuthUserFile in ```atsd-api-php/meters/.htaccess``` is pointing to your ```.htpasswd``` file.
```
Internal Server Error
The server encountered an internal error or misconfiguration and was unable to complete your request.
```

[atsd-api-php]:https://github.com/axibase/atsd-api-php
