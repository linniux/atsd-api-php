# Meters application. 

This application show you how to use atsd-api-php client in useful case.

To try it, you should to do the following actions:

1. install [atsd-api-php] client

2. enable digest authentication on your apache server:
```bash
sudo a2enmod auth_digest
sudo service apache2 restart
```
3. generate password file to authentication:
```bash
touch atsd-api-php/meters/.htpasswd
htdigest atsd-api-php/meters/.htpasswd meters admin
htdigest atsd-api-php/meters/.htpasswd meters user-001
htdigest atsd-api-php/meters/.htpasswd meters user-002
htdigest atsd-api-php/meters/.htpasswd meters guest
```
4. modify ```atsd-api-php/meters/.htaccess``` and set right full path to ```.htpasswd``` file:
```bash
AuthUserFile "/documentRoot/atsd-api-php/meters/.htpasswd"
```
5. test it on your site: yourDomainName/atsd-api-php/meters/

### Troubleshooting

If you get an error like the following, ensure that the variable AuthUserFile in ```atsd-api-php/meters/.htaccess``` is pointing to your ```.htpasswd``` file.
```
Internal Server Error
The server encountered an internal error or misconfiguration and was unable to complete your request.
```

[atsd-api-php]:https://github.com/axibase/atsd-api-php
